<?php

namespace Modules\UserModule\Http\Controllers\Api;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


use App\Helpers\ApiResponseHelper;
use Modules\UserModule\Entities\ShippingAddress;
use Modules\UserModule\Repository\ShippingAddressRepository;
use Modules\UserModule\Transformers\ShippingAddressResource;

class ShippingAddressApiController extends Controller
{

    private $shippingAddressRepository;
    use ApiResponseHelper;
    public function __construct(ShippingAddressRepository $shippingAddressRepository)
    {

        $this->shippingAddressRepository = $shippingAddressRepository;
    }




    public function listShippingAddresses(Request $request)
    {
        $user = Auth::guard('api')->user();
        $userShippingAddresses = $user->shippingAddresses;

        if (count($userShippingAddresses) == 0) {
            return $this->json(200, false, null, 'No shipping addresses found');
        }

        // Transform the collection of shipping addresses into a resource collection
        $transformedAddresses = ShippingAddressResource::collection($userShippingAddresses);

        return $this->json(200, true, $transformedAddresses, 'Success');
    }

    public function viewShippingAddress($id)
    {
        $user = Auth::guard('api')->user();

        $shipping_address = $this->shippingAddressRepository->findWhere(['id' => $id])->first();

        if (!$shipping_address) {
            return $this->json(404, false, trans('messages.Error'), "Shipping Address not found");
        }

        if ($shipping_address->user_id !== $user->id) {
            return $this->json(403, false, trans('messages.Error'), "You are not authorized to delete this Shipping Address");
        }


        $transformedAddresse = ShippingAddressResource::make($shipping_address);


        return $this->json(200, true, $transformedAddresse, "view Shipping Adress");
    }
    
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        $requestData = $request->all();
        $requestData['user_id'] = $user->id;

        // Create the shipping address
        $shipping_address = $this->shippingAddressRepository->create($requestData);

        if ($shipping_address) {
            // Transform the shipping address resource
            $transformedAddress = ShippingAddressResource::make($shipping_address);
            return $this->json(200, true, $transformedAddress, "Shipping Address Created");
        } else {
            return $this->json(500, false, trans('messages.Error'), "Failed to create Shipping Address");
        }
    }


    public function update(Request $request, $id)
    {
        $user = Auth::guard('api')->user();
        $shipping_address = $this->shippingAddressRepository->findWhere(['id' => $id])->first();

        if (!$shipping_address) {
            return $this->json(404, false, trans('messages.Error'), "Shipping Address not found");
        }

        if ($shipping_address->user_id !== $user->id) {
            return $this->json(403, false, trans('messages.Error'), "You are not authorized to update this Shipping Address");
        }

        $validator = Validator::make($request->all(), [
            'address' => 'required|string',
            'city_id' => 'required',
            'area_id' => 'required',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->json(400, false, trans('messages.Error'), $validator->errors());
        }

        $data = [
            'additional_phone' => $request->input('additional_phone'),
            'address' => $request->input('address'),
            'city_id' => $request->input('city_id'),
            'area_id' => $request->input('area_id'),
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'distinct_mark' => $request->input('distinct_mark'),
        ];

        if ($this->shippingAddressRepository->update($data, $id)) {
            $transformedAddress = ShippingAddressResource::make($shipping_address);
            return $this->json(200, true, $transformedAddress, "Shipping Address Updated");
        } else {
            return $this->json(500, false, trans('messages.Error'), "Failed to update Shipping Address");
        }
    }

    public function delete($id)
    {
        $user = Auth::guard('api')->user();
        $shipping_address = $this->shippingAddressRepository->findWhere(['id' => $id])->first();

        if (!$shipping_address) {
            return $this->json(404, false, trans('messages.Error'), "Shipping Address not found");
        }

        if ($shipping_address->user_id !== $user->id) {
            return $this->json(403, false, trans('messages.Error'), "You are not authorized to delete this Shipping Address");
        }

        if ($this->shippingAddressRepository->delete($id)) {
            return $this->json(200, true, trans('messages.Success'), "Shipping Address Deleted");
        } else {
            return $this->json(500, false, trans('messages.Error'), "Failed to delete Shipping Address");
        }
    }
}
