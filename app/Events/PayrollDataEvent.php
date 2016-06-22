<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PayrollDataEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
     public function __construct($result)
     {
         $this->data = $result;
     }

     public function broadcastOn()
     {
         return ['payroll'];
     }
}
