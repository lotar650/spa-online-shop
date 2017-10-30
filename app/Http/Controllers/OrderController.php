<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Mail;
use App\Mail\OrderConfirmed;

class OrderController extends Controller
{
    public function getUserOrders(Request $request)
    {
        return DB::table('orders')
            ->where(['user_id' => Auth::id(), 'isUserConfirmOrder' => false])
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->get();
    }

    public function store(Request $request)
    {
    	DB::table('orders')->insert(
		    $request->all() + ['user_id' => Auth::id()]
		);

    	return response('Success', 200);
    }

    public function confirmTransaction(Request $request)
    {
        $product_ids = collect($request->orders)->map(function ($product) {
            return $product['id'];
        });

        foreach ($request->orders as $order) {
            DB::table('orders')
                ->where(['user_id' => Auth::id(), 'product_id' => $order['product_id']])
                ->update(['isUserConfirmOrder' => true, 'quantity' => $order['quantity']]);
        }

        $orders = DB::table('orders')
            ->where([
            'user_id' => Auth::id(),
            'isUserConfirmOrder' => true,
            'isManagerNotificated' => false
            ])
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->get();

        Mail::to('admin@mail.com')
            ->send(new OrderConfirmed($orders));

        DB::table('orders')
            ->where('user_id', Auth::id())
            ->whereIn('product_id', $product_ids->all())
            ->update(['isManagerNotificated' => true]);

        return response('Success', 200);
    }

    public function destroy($id) 
    {
        DB::table('orders')
            ->where(['user_id' => Auth::id(), 'product_id' => $id])
            ->delete();

        return response('Success', 200);
    }
}
