<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FlashSaleCountdown extends Component
{
    /**
     * The end time for the countdown.
     */
    public $endTime;
    
    /**
     * The title of the countdown.
     */
    public $title;
    
    /**
     * Create a new component instance.
     *
     * @param  string  $endTime
     * @param  string  $title
     */
    public function __construct($endTime, $title = 'Flash Sale Ends In')
    {
        $this->endTime = $endTime;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.flash-sale-countdown');
    }
}
