<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Jobs\SendEmailNewOrderJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCreatedListener
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
     * @param  OrderCreatedEvent  $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event)
    {
        $details = [
            'email' => 'jebauza1989@gmail.com'
        ];
        SendEmailNewOrderJob::dispatch($details);
    }
}
