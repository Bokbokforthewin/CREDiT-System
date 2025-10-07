<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RedirectUser extends Component
{
    public function mount()
    {
        $user = Auth::user();

        return match ($user->usertype) {
            'admin' => redirect()->route('admin.dashboard'),
            'business_office' => match ($user->business_role) {
                'reports'    => redirect()->route('business.reportsdashboard'), // New reports staff
                'limits'    => redirect()->route('business.dashboard'),  // Existing limits staff
                null  => redirect()->route('business.dashboard'),  // Legacy users (backward compatibility)
                default => redirect('/dashboard'),                        // Fallback
            },
            'frontdesk' => redirect()->route('frontdesk.dashboard', $user->department_id),
            // 'frontdesk' => match ($user->department_id) {
            //     1 => redirect()->route('store.dashboard'),
            //     2 => redirect()->route('fastfood.dashboard'),
            //     3 => redirect()->route('cafeteria.dashboard'),
            //     4 => redirect()->route('laundry.dashboard'),
            //     5 => redirect()->route('water.dashboard'),
            //     6 => redirect()->route('garden.dashboard'),
            //     default => redirect('/dashboard'),
            // },
            default => redirect('/dashboard'),
        };
    }

    public function render()
    {
        return view('livewire.redirect-user');
    }
}
