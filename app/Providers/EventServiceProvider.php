<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Example:
        // 'App\Events\EventName' => [
        //     'App\Listeners\ListenerName',
        // ],
    ];

    /**
     * The subscriber classes to be registered.
     *
     * @var array
     */
    protected $subscribe = [
        // Add your subscriber classes here if needed.
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // You can register event listeners or other logic here.
    }
}
