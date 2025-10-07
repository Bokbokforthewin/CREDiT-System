<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';
    public $remember = false;

    public function login()
    {
        $credentials = $this->only(['email', 'password']);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            $route = match ($user->usertype) {
                'admin' => route('admin.dashboard'), // ✅ Central admin dashboard
                'business_office' => route('business.dashboard'),
                'frontdesk' => match ($user->department_id) {
                    1 => route('store.dashboard'),
                    2 => route('fastfood.dashboard'),
                    3 => route('cafeteria.dashboard'),
                    4 => route('laundry.dashboard'),
                    5 => route('water.dashboard'),
                    6 => route('garden.dashboard'),
                    default => '/dashboard',
                },
                default => '/dashboard',
            };
    
            return $this->redirect($route);
        }
    
        session()->flash('error', 'Invalid credentials.');
    }    


    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.guest'); // Optional: depends on your layout
    }
}
