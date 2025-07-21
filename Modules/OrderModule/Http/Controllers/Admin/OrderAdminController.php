<?php

namespace Modules\OrderModule\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\OrderModule\Services\OrderService;
use Modules\OrderModule\Repository\OrderProductRepository;
use Modules\OrderModule\Repository\OrderStatusRepository;

class OrderAdminController extends Controller
{
    protected $orderService;
    protected $orderProductRepository;
    protected $orderStatusRepository;

    public function __construct(
        OrderService $orderService,
        OrderStatusRepository $orderStatusRepository,
        OrderProductRepository $orderProductRepository
    ) {
        $this->orderService = $orderService;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->orderProductRepository = $orderProductRepository;
    }

    // List all orders
    public function index()
    {
        $orders = $this->orderService->findAll();
        return view('ordermodule::admin.index', compact('orders'));
    }

    // Show order details
    public function show($order_id)
    {
        $order = $this->orderService->findOne($order_id);

        if (!$order) {
            return redirect()->route('ordermodule::admin.index')->with('error', 'Order not found');
        }

        return view('ordermodule::admin.show', compact('order'));
    }

    // Show update form
    public function edit($order_id)
    {
        $order = $this->orderService->findOne($order_id);
        $statuses = $this->orderStatusRepository->get();
        $orderItems = $order->orderProducts ?? [];
        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }

        return view('ordermodule::admin.edit', compact('order', 'statuses', 'orderItems'));
    }

    // Update order status
    public function update(Request $request, $order_id)
    {
        $order = $this->orderService->findOne($order_id);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }

        $validator = Validator::make($request->all(), [
            'status_id' => 'required|exists:order_statuses,id',
            'notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.quantity' => 'nullable|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update order status
        $this->orderService->updateStatus([
            'order_id' => $order_id,
            'status_id' => $request->status_id,
        ]);

        // Update notes and quantities
        $this->orderService->updateNotesAndQuantities([
            'order_id' => $order_id,
            'notes' => $request->notes,
            'items' => $request->input('items', []),
        ]);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }


    // Optional: Cancel order
    public function cancel($order_id)
    {
        $order = $this->orderService->findOne($order_id);

        if (!$order) {
            return redirect()->route('orders.index')->with('error', 'Order not found');
        }

        $this->orderService->cancelOrder(['order_id' => $order_id]);

        return redirect()->route('orders.index')->with('success', 'Order cancelled successfully');
    }
}
