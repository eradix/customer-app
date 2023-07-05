<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request)
    {
        //validate the customer data
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'active' => 'sometimes'
        ]);

        //create customer
        $customer = Customer::create($data);

        //get the id of newly created customer
        $customer_id = $customer->id;

        //get the address from request
        $customerAddress = $request->json('address');

        //if address is in the request
        if (is_array($customerAddress)) {
            //loop thru address
            foreach ($customerAddress as $addressData) {
                //build the address array
                $address = [
                    'street'        => $addressData['street'] ?? null,
                    'city'          => $addressData['city'] ?? null,
                    'barangay'      => $addressData['barangay'] ?? null,
                    'primary'       => $addressData['primary'] ?? null,
                    'customer_id'   => $customer_id
                ];
                //create the address
                Address::create($address);
            }
        }
        //return the json response
        return response()->json(['message' => 'Customer created successfully'], 201);
    }

    public function show()
    {
        //get all customer info
        //get only the primary address of each customer
        $customerInfos = Customer::with(['addresses' => function ($query) {
            $query->where('primary', 1);
        }, 'capabilities'])
            ->get()
            ->map(function ($customerInfo) {
                return [
                    'id' => $customerInfo->id,
                    'first_name' => $customerInfo->first_name,
                    'last_name' => $customerInfo->last_name,
                    'active' => $customerInfo->active,
                    'created_at' => $customerInfo->created_at->format('m-d-Y'),
                    'address' => $customerInfo->addresses[0] ?? null,
                    'capabilities' => $customerInfo->capabilities ?? null,
                ];
            });

        // return json response
        return response()->json($customerInfos);
    }
}
