<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Artisan;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard(Request $request)
    {
        $_start = Carbon::parse(\request('start_d'));
        $start = $_start->format('Y-m-d');
        $_end = Carbon::parse(\request('end_d'));
        $end = $_end->format('Y-m-d');

        $orderQ = Order::query()
            // ->whereBetween('created_at', [$_start->startOfDay()->toDateTimeString(), $_end->endOfDay()->toDateTimeString()])
        ;
        $orders = ['Total' => (clone $orderQ)->count()];
        foreach (config('order.statuses', []) as $status) {
            // if ($status == 'Shipping') {
            //     $orders[$status] = Order::query()
            //         ->whereBetween('shipped_at', [$_start->startOfDay()->toDateTimeString(), $_end->endOfDay()->toDateTimeString()])
            //         ->where('status', $status)
            //         ->count();
            //     continue;
            // }
            $orders[$status] = (clone $orderQ)->where('delivery_status', $status)->count();
        }

        return view('backend.dashboard', compact('orders', 'start', 'end'));
    }

    function clearCache(Request $request)
    {
        Artisan::call('optimize:clear');
        flash(translate('Cache cleared successfully'))->success();
        return back();
    }
}
