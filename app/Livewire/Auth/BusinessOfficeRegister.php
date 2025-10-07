<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BusinessOfficeRegister extends Component
{
    public $name, $email, $password, $password_confirmation, $business_role = '';

    public function register()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'business_role' => 'required|in:limits,reports', // Validate exact values
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'usertype' => 'business_office',
            'department_id' => null,
            'business_role' => $validated['business_role'], // Directly use the selected value
        ]);

        session()->flash('success', 'Business Office account registered successfully.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.business-office-register')
            ->layout('layouts.guest');
    }
}