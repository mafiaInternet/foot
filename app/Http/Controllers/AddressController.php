<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    //
    public function getAddresses(){

        return response()->json(AddressResource::collection(Address::all()));
    }
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|string',
            'province' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validate();
        $address = Address::create($data);
        return response()->json([
            'message' => 'Create address by user success!!',
            'address' => new AddressResource($address)
        ]);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|string',
            'province' => 'required|string',
            'district' => 'required|string',
            'ward' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validate();
        $address = Address::find($id)->update($data);
        return response()->json([
            'message' => 'Update address by user success!!',
            'status' => $address
        ]);
    }

    public function delete($id){
        $address = Address::find($id);
        $address->delete();
        return response()->json([
            'message' => "Delete address by id success",
            'id' => $id
        ]);
    }
}
