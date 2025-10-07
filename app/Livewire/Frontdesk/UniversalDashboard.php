<?php

namespace App\Livewire\Frontdesk;

use Livewire\Component;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Charge;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChargeNotification;
use App\Traits\Auditable; // <-- ADDED: Import the Auditable trait

class UniversalDashboard extends Component
{
    use Auditable; // <-- ADDED: Use the Auditable trait
    
    public $showRfidModal = false;
    public $showManualEntry = false;
    public $rfid_code = '';
    public $family_search = '';
    public $selected_family_id = '';
    public $selected_member_id = '';
    public $member = null;
    public $description = '';
    public $price = '';
    public $charges = [];
    public $rfidNotFound = false;
    public $showFamilyDropdown = false;

    // NEW PROPERTIES FOR CONFIRMATION
    public $showConfirmationModal = false;
    public $confirmationType = ''; // 'rfid' or 'manual'
    public $tempChargeData = [];
    public $confirmationRfidCode = '';
    public $confirmationError = '';
    public $originalRfidCode = ''; // Store the original RFID for comparison

    public Department $department;

    public function getChargesQuery()
    {
        return Charge::where('department_id', $this->department->id);
    }

    public function mount(Department $department)
    {
        $this->department = $department;
    }

    public function openManualEntry()
    {
        $this->showRfidModal = false;
        $this->showManualEntry = true;
        $this->reset([
            'rfid_code',
            'family_search',
            'selected_family_id',
            'selected_member_id',
            'member',
            'description',
            'price',
            'charges',
            'rfidNotFound'
        ]);
    }

    public function updatedFamilySearch()
    {
        $this->showFamilyDropdown = !empty($this->family_search);
        $this->selected_family_id = '';
        $this->selected_member_id = '';
        $this->member = null;
        $this->charges = [];
    }

    public function selectFamily($familyId, $familyName)
    {
        $this->selected_family_id = $familyId;
        $this->family_search = $familyName;
        $this->showFamilyDropdown = false;
        $this->selected_member_id = '';
        $this->member = null;
        $this->charges = [];
    }

    public function updatedRfidCode()
    {
        if (empty($this->rfid_code)) {
            return;
        }

        $this->member = FamilyMember::where('rfid_code', $this->rfid_code)->first();

        if (!$this->member) {
            $this->rfidNotFound = true;
            $this->charges = [];
            return;
        }

        $this->rfidNotFound = false;
        $this->showRfidModal = false;
        
        // Store the original RFID code for later confirmation
        $this->originalRfidCode = $this->rfid_code;
        
        $this->loadCharges();
    }

    public function closeRfidNotFoundModal()
    {
        $this->rfidNotFound = false;
        $this->rfid_code = '';
    }

    public function resetToRfidScan()
    {
        $this->reset([
            'rfid_code',
            'family_search',
            'selected_family_id',
            'selected_member_id',
            'member',
            'description',
            'price',
            'charges',
            'rfidNotFound'
        ]);
        $this->showRfidModal = true;
        $this->showManualEntry = false;
    }

    public function updatedSelectedMemberId()
    {
        $this->member = FamilyMember::find($this->selected_member_id);
        $this->loadCharges();
    }

    // MODIFIED SUBMIT CHARGE METHOD
    public function submitCharge()
    {
        if (!$this->member) return;

        // Validate required fields
        $this->validate([
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
        ]);

        $rule = $this->member->rules()->where('department_id', $this->department->id)->first();

        if ($rule && $rule->is_restricted) {
            session()->flash('error', 'This member is restricted from charging in this department.');
            return;
        }

        if ($rule && $rule->spending_limit !== null && $this->price > $rule->spending_limit) {
            session()->flash('error', 'Amount exceeds spending limit.');
            return;
        }

        // Store temporary charge data for confirmation
        $this->tempChargeData = [
            'charge_datetime' => now(),
            'description' => $this->description,
            'price' => $this->price,
            'member' => $this->member,
            'rule' => $rule
        ];

        // Determine confirmation type based on how charge was initiated
        $this->confirmationType = $this->showManualEntry ? 'manual' : 'rfid';
        
        // Show confirmation modal instead of directly saving
        $this->showConfirmationModal = true;
        $this->confirmationRfidCode = '';
        $this->confirmationError = '';
    }

    // MODIFIED METHOD: CONFIRM RFID CHARGE
    public function confirmRfidCharge()
    {
        if (empty($this->confirmationRfidCode)) {
            $this->confirmationError = 'Please scan your RFID to confirm the charge.';
            return;
        }

        // Check if confirmation RFID matches the original RFID
        if ($this->confirmationRfidCode !== $this->originalRfidCode) {
            $this->confirmationError = 'RFID does not match. Please scan the same RFID card that was used initially.';
            $this->confirmationRfidCode = '';
            return;
        }

        $this->processConfirmedCharge();
    }

    // NEW METHOD: CONFIRM MANUAL CHARGE
    public function confirmManualCharge()
    {
        $this->processConfirmedCharge();
        // Reset form and go back to RFID scan mode
        $this->resetAfterCharge();
    }

    // NEW METHOD: PROCESS CONFIRMED CHARGE
    private function processConfirmedCharge()
    {
        $charge = Charge::create([
            'charge_datetime' => $this->tempChargeData['charge_datetime'],
            'description' => $this->tempChargeData['description'],
            'price' => $this->tempChargeData['price'],
            'user_id' => Auth::id(),
            'family_id' => $this->tempChargeData['member']->family_id,
            'family_member_id' => $this->tempChargeData['member']->id,
            'department_id' => $this->department->id
        ]);
        
        // AUDIT LOGGING: Log the creation of the Charge record
        $this->logCreation($charge); 

        // Update spending limit if applicable
        if ($this->tempChargeData['rule'] && $this->tempChargeData['rule']->spending_limit !== null) {
            $this->tempChargeData['rule']->spending_limit -= $this->tempChargeData['price'];
            $this->tempChargeData['rule']->save();
        }

        // Send email notification
        $head = $this->tempChargeData['member']->family->members()->where('role', 'head')->first();
        if ($head && $head->email) {
            Mail::to($head->email)->queue(new ChargeNotification($charge));
        }

        // Close modal and show success
        $this->showConfirmationModal = false;
        session()->flash('success', 'Charge recorded successfully.');
        
        // Reset form and go back to RFID scan mode
        $this->resetAfterCharge();
    }

    // NEW METHOD: CANCEL CONFIRMATION AND RETRY RFID
    public function retryRfidScan()
    {
        $this->showConfirmationModal = false;
        $this->tempChargeData = [];
        $this->confirmationRfidCode = '';
        $this->confirmationError = '';
        $this->originalRfidCode = '';
        
        // Reset everything and go back to RFID modal
        $this->reset([
            'rfid_code',
            'family_search',
            'selected_family_id',
            'selected_member_id',
            'member',
            'description',
            'price',
            'charges',
            'rfidNotFound'
        ]);
        $this->showRfidModal = true;
        $this->showManualEntry = false;
    }

    // NEW METHOD: CANCEL CONFIRMATION
    public function cancelConfirmation()
    {
        $this->showConfirmationModal = false;
        $this->tempChargeData = [];
        $this->confirmationRfidCode = '';
        $this->confirmationError = '';
    }

    // NEW METHOD: RESET AFTER SUCCESSFUL CHARGE
    private function resetAfterCharge()
    {
        $this->reset([
            'description', 
            'price', 
            'tempChargeData', 
            'confirmationRfidCode', 
            'confirmationError',
            'rfid_code',
            'family_search',
            'selected_family_id',
            'selected_member_id',
            'member',
            'charges',
            'rfidNotFound',
            'originalRfidCode'
        ]);
        $this->showRfidModal = false;
        $this->showManualEntry = false;
    }

    public function loadCharges()
    {
        if ($this->member) {
            $this->charges = Charge::where('family_id', $this->member->family_id)
                ->where('department_id', $this->department->id)
                ->orderBy('charge_datetime', 'desc')
                ->take(10)
                ->get();
        } else {
            $this->charges = [];
        }
    }

    public function getFilteredFamiliesProperty()
    {
        if (empty($this->family_search)) {
            return collect();
        }

        return Family::where('family_name', 'like', '%' . $this->family_search . '%')
            ->limit(10)
            ->get();
    }

    public function getFamilyMembersProperty()
    {
        return $this->selected_family_id
            ? FamilyMember::where('family_id', $this->selected_family_id)->get()
            : collect();
    }

    public function render()
    {
        return view('livewire.frontdesk.universal-dashboard', [
            'filteredFamilies' => $this->filteredFamilies,
            'familyMembers' => $this->familyMembers
        ])->layout('layouts.app');
    }
}
