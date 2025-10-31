<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FamilyRegister extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public string $family_name = '';
    public string $account_code = '';

    protected array $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',

        'family_name' => 'required|string|max:255',
        'account_code' => 'required|string|max:255|unique:families,account_code',
    ];

    public function register(){
        $this->validate();

        DB::transaction(function () {
            // 2. Create the User (The Head of the Family)
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'usertype' => 'faculty', // Assuming this is the appropriate user type for the head
            ]);

            // 3. Create the Family
            $family = Family::create([
                'family_name' => $this->family_name,
                'account_code' => $this->account_code,
            ]);

            // 4. Create the FamilyMember Linkage (The Crucial Step)
            // This connects the new User ($user->id) to the new Family ($family->id)
            // and explicitly sets their ROLE as 'head'.
            FamilyMember::create([
                'user_id' => $user->id,
                'family_id' => $family->id,
                'name' => $this->name,
                'email' => $this->email,
                'role' => 'head', // This links the user as the primary contact/head
                'rfid_code' => Str::uuid()->toString(), 
            ]);

            // 5. Log the new user in immediately
            auth()->login($user);

            // 6. Flash success and redirect to the dashboard
            session()->flash('success', 'Registration and Family setup successful! Welcome to the dashboard.');
            // You should update the route below to wherever your main dashboard is located
            return redirect()->to('/dashboard'); 

        });
    }
    public function render()
    {
        return view('livewire.auth.family-register')->layout('layouts.guest');
    }
}
