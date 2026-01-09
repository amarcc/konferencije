<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?User $user = null,
        public string $formType = "create",
        public bool $admin = False
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-form');
    }
}
