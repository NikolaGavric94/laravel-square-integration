<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Nikolag\Square\Facades\Square;
use Nikolag\Square\Models\Customer;

class OrderController extends Controller
{
    /**
     * Place an order.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function order(Request $request)
    {
        $order = new Order;
        $order->total = 500;

        $square = Square::setOrder($order, env('SQUARE_LOCATION'));

        foreach ($request->get('products') as $product) {
            $square->addProduct($product, 1);
        }

        $square->charge([
            'amount' => $order->total,
            'card_nonce' => 'fake-card-nonce-ok',
            'location_id' => env('SQUARE_LOCATION')
        ]);

        $order = $square->getOrder();


        return response()->json(compact('order'));
    }

    /**
     * Place an order against a customer (buyer).
     *
     * @param Request $request
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderWithCustomer(Request $request, Customer $customer)
    {
        $order = new Order;
        $order->total = 500;

        $square = Square::setOrder($order, env('SQUARE_LOCATION'))
            ->setCustomer($customer);

        foreach ($request->get('products') as $product) {
            $square->addProduct($product, 1);
        }

        $square->charge([
            'amount' => $order->total,
            'card_nonce' => 'fake-card-nonce-ok',
            'location_id' => env('SQUARE_LOCATION')
        ]);

        $order = $square->getOrder();


        return response()->json(compact('order'));
    }

    /**
     * Place an order and include only a merchant
     * maybe because you don't store buyers, but only
     * sellers.
     *
     * @param Request $request
     * @param User $merchant
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderWithMerchant(Request $request, User $merchant)
    {
        $order = new Order;
        $order->total = 500;

        $square = Square::setOrder($order, env('SQUARE_LOCATION'))
            ->setMerchant($merchant);

        foreach ($request->get('products') as $product) {
            $square->addProduct($product, 1);
        }

        $square->charge([
            'amount' => $order->total,
            'card_nonce' => 'fake-card-nonce-ok',
            'location_id' => env('SQUARE_LOCATION')
        ]);

        $order = $square->getOrder();


        return response()->json(compact('order'));
    }

    /**
     * Place an order against a customer (buyer) for some
     * merchant (seller)
     *
     * @param Request $request
     * @param User $merchant
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderWithCustomerAndMerchant(Request $request, User $merchant, Customer $customer)
    {
        $order = new Order;
        $order->total = 500;

        $square = Square::setOrder($order, env('SQUARE_LOCATION'))
            ->setMerchant($merchant)
            ->setCustomer($customer);

        foreach ($request->get('products') as $product) {
            $square->addProduct($product, 1);
        }

        $square->charge([
            'amount' => $order->total,
            'card_nonce' => 'fake-card-nonce-ok',
            'location_id' => env('SQUARE_LOCATION')
        ]);

        $order = $square->getOrder();


        return response()->json(compact('order'));
    }
}
