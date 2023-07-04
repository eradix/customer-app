<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Capability;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request){

        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'active' => 'sometimes'
        ]);
        //create customer
        $customer = Customer::create($data);

        //last id
        $lastId = $customer->value('id');

        $customerAddress = $request->validate([
            'street' => 'sometimes',
            'barangay' => 'sometimes',
            'city' => 'sometimes',
            'primary' => 'sometimes'
        ]);

        $customerAddress['user_id'] = $lastId;

        //create address for customer
        Address::create($customerAddress);

        
        $customerCapability = $request->validate([
            'code' => 'sometimes',
            'description' => 'sometimes',
        ]);

        $customerCapability['user_id']= $lastId;

        //create customer capability
        Capability::create($customerCapability);

        return response()->json(['message' => "{$data['first_name']} has been successfully added"]);

    }

    public function show(){
        //get all customer info
        $customerInfos = Customer::with('addresses', 'capabilities')
            ->get()
            ->filter(function($customerInfo){
                return $customerInfo->address->primary;
            })
            ->map(function($customerInfo){
                return [
                    'id' => $customerInfo->id,
                    'first_name' => $customerInfo->first_name,
                    'last_name' => $customerInfo->last_name,
                    'active' => $customerInfo->active,
                    'street' => $customerInfo->address->street,
                    'barangay' => $customerInfo->address->barangay,
                    'city' => $customerInfo->address->city,
                    'primary' => $customerInfo->address->primary,
                    'code' => $customerInfo->capability->code,
                    'description' => $customerInfo->capability->description,
                ];
            });

            //return json response
            return response()->json($customerInfos);
    }
}
