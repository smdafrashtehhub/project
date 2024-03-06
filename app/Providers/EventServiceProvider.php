<?php

namespace App\Providers;

use App\Events\CreateOrder;
use App\Events\SendSmsEvent;
use App\Events\SendSmsRegisterEvent;
use App\Listeners\CreateOrderEmail;
use App\Listeners\SendSmsListener;
use App\Listeners\SendSmsRegisterListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CreateOrder::class=>[
            CreateOrderEmail::class,
        ],
        SendSmsEvent::class=>[
            SendSmsListener::class,
        ],
        SendSmsRegisterEvent::class=>[
            SendSmsRegisterListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
