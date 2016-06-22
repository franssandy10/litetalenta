<?php

namespace App\Listeners;

use App\Events\PayrollDataEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayrollDataListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PayrollDataEvent  $event
     * @return void
     */
    public function handle(PayrollDataEvent $event)
    {
        //
    }
}
