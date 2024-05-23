<?php

namespace App\Listeners;

use App\Models\AuthLog;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;

class AuthLogListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handleUserLogin(Login $event): void
    {
        AuthLog::create([
            "user_id" => $event->user->id,
            "ip_address" => request()->ip(),
            "user_agent" => request()->userAgent(),
            "email" => $event->user->email,
            "username" => $event->user->username,
            "mobile_number" => $event->user->mobile_number,
            "action" => "User Login",
        ]);
    }

    public function handleUserLogout(Logout $event): void
    {
        AuthLog::create([
            "user_id" => $event->user->id,
            "ip_address" => request()->ip(),
            "user_agent" => request()->userAgent(),
            "email" => $event->user->email,
            "username" => $event->user->username,
            "mobile_number" => $event->user->mobile_number,
            "action" => "User Logout",
        ]);
    }

    public function handleUserLoginFailed(Failed $event): void
    {
        AuthLog::create([
            "user_id" => $event->user->id ?? null,
            "ip_address" => request()->ip(),
            "user_agent" => request()->userAgent(),
            "email" => $event->user->email ?? null,
            "username" => $event->user->username ?? null,
            "mobile_number" => $event->user->mobile_number ?? null,
            "action" => "Login Failed",
        ]);
    }

    public function handleUserPasswordReset(PasswordReset $event): void
    {
        AuthLog::create([
            "user_id" => $event->user->id ?? null,
            "ip_address" => request()->ip(),
            "user_agent" => request()->userAgent(),
            "email" => $event->user->email ?? null,
            "username" => $event->user->username ?? null,
            "mobile_number" => $event->user->mobile_number ?? null,
            "action" => "Password Reset",
        ]);
    }

    public function subscribe(Dispatcher $events): void
    {
        $events->listen(Login::class, [AuthLogListener::class, 'handleUserLogin']);
        $events->listen(Logout::class, [AuthLogListener::class, 'handleUserLogout']);
        $events->listen(Failed::class, [AuthLogListener::class, 'handleUserLoginFailed']);
        $events->listen(PasswordReset::class, [AuthLogListener::class, 'handleUserPasswordReset']);
    }
}
