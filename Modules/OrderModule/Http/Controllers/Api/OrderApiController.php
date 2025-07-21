<?php

namespace Modules\OrderModule\Http\Controllers\Api;

use App\Events\OrderCreated;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\OrderModule\Services\OrderService;
use Modules\OrderModule\Transformers\OrderResource;
use App\Helpers\ApiResponseHelper;
use App\Helpers\FcmHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\OrderModule\Repository\OrderProductRepository;
use Modules\OrderModule\Repository\OrderStatusRepository;
use Modules\OrderModule\Transformers\OrderStatusesResource;


class OrderApiController extends Controller
{
    public $orderProductRepository;
    public $orderService;
    public $orderStatusRepository;
    use ApiResponseHelper;

    public function __construct(OrderService $orderService, OrderStatusRepository $orderStatusRepository, OrderProductRepository $orderProductRepository)
    {
        $this->orderService = $orderService;
        $this->orderProductRepository = $orderProductRepository;
        $this->orderStatusRepository = $orderStatusRepository;
    }

    public function index()
    {
        return view('ordermodule::index');
    }

    public function listOrderStatuses(Request $request)
    {
        $user = Auth::guard('api')->user();
        $orderStatuses = $this->orderStatusRepository->get();

        $transformedOrderStatuses = OrderStatusesResource::collection($orderStatuses);

        return $this->json(200, true, $transformedOrderStatuses, 'Success');
    }

    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'products' => 'required',
            'status_id' => 'required|exists:order_statuses,id',
            'shipping_address_id' => 'required|exists:shipping_addresses,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation Error',
            ], 400);
        }

        $orderData = $request->all();

        // Create the order
        $order = $this->orderService->create($orderData);

        // Check if order creation failed
        if (is_array($order) && isset($order['failed']) && $order['failed']) {
            return response()->json([
                'success' => false,
                'error' => $order['message'],
            ], 401);
        }

        // Mark order as unpaid for now (or paid if needed)
        $order->is_paid = 0;
        $order->save();

        return response()->json([
            'success' => true,
            'data' => OrderResource::make($order),
            'message' => 'Order Created Successfully',
        ], 200);
    }


    public function showOrders()
    {
        $orders = $this->orderService->orderBy('created_at', 'desc')->get();
        $transformedOrders = OrderResource::collection($orders);
        return $this->json(200, true, $transformedOrders, "Orders Retrieved");
    }

    public function listOfOrders()
    {
        $user = Auth::guard('api')->user();
        $orderContents = $user->orders()->orderBy('created_at', 'desc')->paginate(3);

        $transformedOrders = OrderResource::collection($orderContents);

        return $this->json(200, true, $transformedOrders, 'Success', $transformedOrders->currentPage(), $transformedOrders->lastPage());
    }

    public function orderDetails($order_id)
    {
        // Check if order_id is valid (e.g., is a positive integer)
        if (!is_numeric($order_id) || $order_id <= 0) {
            return $this->json(400, false, null, 'Invalid order ID');
        }

        $user = Auth::guard('api')->user();
        $orderContents = $this->orderService->findOne($order_id);

        if ($orderContents) {
            $transformedOrder = OrderResource::make($orderContents);
            return $this->json(200, true, $transformedOrder, 'Success');
        } else {
            return $this->json(404, false, null, 'Order not found');
        }
    }


    public function updateOrderStatus(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user)
            return $this->error(400, false, 'invalid_token', 'Invalid Token');
        $orderContents = $this->orderService->findOne($request['order_id']);

        if ($orderContents) {
            $orderStatus = $this->orderService->updateStatus($request->all());
            // // Order Status Updated successfully
            // $target_tokens = [$order->user->push_token];
            // $notification_title = "Our Project";
            // $notification_body = " Order Status Updated Successfully";
            // $data = ['order_id' => $order->id];
            // $notification_res = FcmHelper::sendNotification($target_tokens, 'all', $notification_title, $notification_body, $data);
            $transformedOrder = OrderResource::make($orderStatus);

            return $this->json(200, true, $transformedOrder, 'Order status has been updated successfully');
        } else {
            return $this->json(404, false, null, 'Order not found');
        }
    }
    public function cancelOrder(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user)
            return $this->error(400, false, 'invalid_token', 'Invalid Token');
        $orderContents = $this->orderService->findOne($request['order_id']);

        if ($orderContents) {
            $orderStatus = $this->orderService->cancelOrder($request->all());
            $transformedOrder = OrderResource::make($orderStatus);

            return $this->json(200, true, $transformedOrder, 'Order status has been updated successfully');
        } else {
            return $this->json(404, false, null, 'Order not found');
        }
    }

    //  tracking order status
    public function trackOrder($order_id)
    {
        $order = $this->orderService->findOne($order_id);
        if ($order) {
            $transformedOrder = OrderResource::make($order);
            return $this->json(200, true, $transformedOrder, 'Order status retrieved successfully');
        } else {
            return $this->json(404, false, null, 'Order not found');
        }
    }
}
