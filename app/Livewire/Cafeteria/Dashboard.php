<?php

namespace App\Livewire\Cafeteria;

use Livewire\Component;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Charge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChargeNotification;

class Dashboard extends Component
{
    public $mode = null;
    public $rfid_code = '';
    public $selected_family_id = '';
    public $selected_member_id = '';
    public $member = null;
    public $description = '';
    public $price = '';
    public $charges = [];
    public $rfidNotFound = false;

    public function selectMode($mode)
    {
        $this->reset([
            'rfid_code',
            'selected_family_id',
            'selected_member_id',
            'member',
            'description',
            'price',
            'charges'
        ]);
        $this->mode = $mode;
    }

    public function updatedRfidCode()
    {
        $this->member = FamilyMember::where('rfid_code', $this->rfid_code)->first();

        if (!$this->member) {
            $this->rfidNotFound = true;
            $this->charges = [];
            return;
        }

        $this->rfidNotFound = false;
        $this->loadCharges();
    }

    public function updatedSelectedFamilyId()
    {
        // Clear selected member when family is changed
        $this->selected_member_id = '';
        $this->member = null;
        $this->charges = [];
    }

    public function updatedSelectedMemberId()
    {
        $this->member = FamilyMember::find($this->selected_member_id);
        $this->loadCharges();
    }

    public function submitCharge()
    {
        if (!$this->member) return;

        $rule = $this->member->rules()->where('department_id', Auth::user()->department_id)->first();

        if ($rule && $rule->is_restricted) {
            session()->flash('error', 'This member is restricted from charging in this department.');
            return;
        }

        if ($rule && $rule->spending_limit !== null && $this->price > $rule->spending_limit) {
            session()->flash('error', 'Amount exceeds spending limit.');
            return;
        }

        $charge = Charge::create([
            'charge_datetime' => now(),
            'description' => $this->description,
            'price' => $this->price,
            'user_id' => Auth::id(),
            'family_id' => $this->member->family_id,
            'family_member_id' => $this->member->id,
            'department_id' => Auth::user()->department_id,
        ]);

        if ($rule && $rule->spending_limit !== null) {
            $rule->spending_limit -= $this->price;
            $rule->save();
        }

        $head = $this->member->family->members()->where('role', 'head')->first();
        if ($head && $head->email) {
            Mail::to($head->email)->queue(new ChargeNotification($charge));
        }

        session()->flash('success', 'Charge recorded successfully.');
        $this->reset(['description', 'price']);
        $this->loadCharges();
    }

    public function loadCharges()
    {
        if ($this->member) {
            $this->charges = Charge::where('family_id', $this->member->family_id)
                ->where('department_id', Auth::user()->department_id)
                ->orderBy('charge_datetime', 'desc')
                ->take(10)
                ->get();
        } else {
            $this->charges = [];
        }
    }

    public function getFamiliesProperty()
    {
        return Family::all();
    }

    public function getFamilyMembersProperty()
    {
        return $this->selected_family_id
            ? FamilyMember::where('family_id', $this->selected_family_id)->get()
            : collect();
    }

    public function render()
    {
        return view('livewire.cafeteria.dashboard', [
            'families' => $this->families,
            'familyMembers' => $this->familyMembers
        ])->layout('layouts.app');
    }
}
