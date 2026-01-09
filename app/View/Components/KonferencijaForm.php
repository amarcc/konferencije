<?php

namespace App\View\Components;

use App\Models\Konferencija;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class KonferencijaForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?Konferencija $konferencija = null,
        public string $formType = 'create',
        public $locs = null
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.konferencija-form');
    }
}
