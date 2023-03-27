<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Order;
use App\Models\User;
use http\Env\Request;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * RegisterRequest any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('shift-active', function (User $user, Order $order) {
            if (!$order->shift->active) {
                response(['error' => ['code' => 403, 'message' => 'You cannot change the order status of a closed shift!']], 403)->throwResponse();
            }

            return true;
        });

        Gate::define('waiter-order-owner', function (User $user, Order $order) {
            if ($order->user->id !== $user->id) {
                response(['error' => ['code' => 403, 'message' => 'Forbidden! You did not accept this order!']], 403)->throwResponse();
            }

            return true;
        });

        Gate::define('waiter-can-change-status', function (User $user, Order $order, $request) {
            return ($order->status === Order::ACCEPTED && $request->status === Order::DECLINED) || ($order->status === Order::READY && $request->status === Order::PAID);
        });

        Gate::define('cook-can-change-status', function (User $user, Order $order, $request) {
            return (($order->status === Order::ACCEPTED && $request->status === Order::PREPARING) || ($order->status === Order::PREPARING && $request->status === Order::READY));
        });
    }
}
