<?php

namespace App\Http\Controllers;

use App\User;
use Nikolag\Square\Facades\Square;
use Nikolag\Square\Models\Customer;

class ChargeController extends Controller
{

    /**
     * Create customer.
     */
    public function createCustomer()
    {
        $customerArr = [
            'first_name' => 'Nikola',
            'last_name' => 'Gavric',
            'company_name' => 'The Testing Company - TTC',
            'nickname' => 'gavra',
            'email' => 'nikoxxxxxxxx@xxxx.com',
            'phone' => '+38112341251',
            'note' => 'Some small note up to 50 characters.',
        ];

        $customer = new Customer($customerArr);
        $customer->save();

        return response()->json(compact('customer'));
    }

    /**
     * Basic charge.
     */
    public function charge()
    {
        $transaction = Square::charge([
            'amount' => 500,
            'card_nonce' => 'fake-card-nonce-ok',
            'location_id' => 'CBASEP2UlDG1Zy4RJBW46Q_S1AcgAQ',
            'currency' => 'USD'
        ]);

        return response()->json(compact('transaction'));
    }

    /**
     * Charge the customer.
     */
    public function chargeWithMerchant(User $merchant)
    {
        $transaction = Square::setMerchant($merchant)
            ->charge([
                'amount' => 500,
                'card_nonce' => 'fake-card-nonce-ok',
                'location_id' => 'CBASEP2UlDG1Zy4RJBW46Q_S1AcgAQ',
                'currency' => 'USD'
            ]);
        return response()->json(compact('transaction'));
    }

    /**
     * Charge with specifying who is the merchant.
     */
    public function chargeWithCustomer(Customer $customer)
    {
        $transaction = Square::setCustomer($customer)
            ->charge([
                'amount' => 500,
                'card_nonce' => 'fake-card-nonce-ok',
                'location_id' => 'CBASEP2UlDG1Zy4RJBW46Q_S1AcgAQ',
                'currency' => 'USD'
            ]);
        return response()->json(compact('transaction'));
    }

    /**
     * Charge the customer with specifying
     * who is the merchant.
     */
    public function chargeWithMerchantAndCustomer(User $merchant, Customer $customer)
    {
        $transaction = Square::setMerchant($merchant)
            ->setCustomer($customer)
            ->charge([
                'amount' => 500,
                'card_nonce' => 'fake-card-nonce-ok',
                'location_id' => 'CBASEP2UlDG1Zy4RJBW46Q_S1AcgAQ',
                'currency' => 'USD'
            ]);

        return response()->json(compact('transaction'));
    }

}
