<?php

namespace Modules\OrderModule\Services;

use App\Events\OrderCreated;
use App\Helpers\UploaderHelper;
use App\Helpers\FcmHelper;
use Modules\OrderModule\Repository\OrderRepository;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\productModule\Repository\productRepository;
use Modules\OrderModule\Repository\OrderproductRepository;
use Modules\UserModule\Repository\ShippingAddressRepository;

class OrderService
{

    use UploaderHelper;

    public $orderRepository;
    public $productRepository;
    public $orderproductRepository;
    public $shippingAddressRepository;


    public function __construct(
        OrderRepository $orderRepository,
        productRepository $productRepository,
        OrderproductRepository $orderproductRepository,
        ShippingAddressRepository $shippingAddressRepository,
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderproductRepository = $orderproductRepository;
        $this->shippingAddressRepository = $shippingAddressRepository;
    }

    /**
     * ------------------------------
     * Filter
     * ------------------------------
     *
     * Filter category according to sended array
     *
     * @key parent_id
     * @key name
     *
     * @param array $request
     *
     * @return query
     */

    public function filter(array $request)
    {
        return $this->orderRepository->filter($request);
    }

    /**
     * ------------------------------
     * find category
     * ------------------------------
     *
     * Get category
     *
     *  param $id
     *
     * @return object
     */

    public function findOne($id)
    {
        return $this->orderRepository->find($id);
    }




    /**
     * Return All Categories
     * @return object
     */

    public function findAll()
    {
        return $this->orderRepository->get();
    }

    public function create($data)
    {
        $user = Auth::guard('api')->user();

        // Check if the shipping address exists and belongs to the authenticated user
        $shippingAddress = $this->shippingAddressRepository->findWhere([
            'id' => $data['shipping_address_id'],
            'user_id' => $user->id
        ])->first();

        if (!$shippingAddress) {
            // Handle the case where the shipping address is invalid
            return ['failed' => true, 'message' => 'shipping address not found'];
        }



        $products = [];
        $products_qty = [];
        $arrayOfproducts = json_decode($data['products'], true);
        $order_nu = $this->orderRepository->genOrderNu();

        // Iterate through $arrayOfproducts and calculate the total amount
        $total_amount = 0;
        foreach ($arrayOfproducts as $product_item) {
            $product = $this->productRepository->findWhere(['id' => $product_item['id']])->first();

            if (!$product) {
                return ['failed' => true, 'message' => 'product Id not Found'];
            }

            if ($product->stock_quantity < $product_item['q']) {
                return ['failed' => true, 'message' => "Insufficient stock for product ID {$product_item['id']}"];
            }

            $products[] = $product;
            $products_qty[$product_item['id']] = $product_item['q'];
            $total_amount += ($product['price'] * $product_item['q']);
        }

        $delivery_fees = $data['delivery_fees'];




        // Add VAT (15%)
        $vat_amount = $total_amount * 0.15;
        $order_amount_after_vat = $total_amount + $vat_amount;

        // Calculate net amount
        $net_amount = $order_amount_after_vat + $delivery_fees;

        $order_data = [
            'user_id' => $user->id,
            'order_nu' => $order_nu,
            'status_id' => 1,
            'payment_method_id' => $data['payment_method_id'],  // must be updated after payment method
            'is_paid' => 0,
            'transaction_id' => $data['transaction_id'],
            'total_amount' => $total_amount, // price * qty
            'delivery_fees' => $delivery_fees,  // after pharmacy fees
            'net_amount' => $net_amount,  // total after discount, VAT, and delivery fees
            'shipping_address_id' => $data['shipping_address_id'], // customer address
            'notes' => $data['notes'],
        ];

        $order = $this->orderRepository->create($order_data);

        if (!empty($products)) {
            foreach ($products as $product_item) {
                $quantity = $products_qty[$product_item['id']];
                $product_item->stock_quantity -= $quantity;
                $product_item->save();

                $product_data = [];
                $product_data['order_id'] = $order->id;
                $product_data['product_id'] = $product_item['id'];
                $product_data['product_name'] = $product_item->name;
                $product_data['item_price'] = $this->productRepository->getProductPrice($product_item['id']);
                $product_data['quantity'] = $quantity;
                $product_data['total_price'] = $product_data['quantity'] * $product_data['item_price'];
                $this->orderproductRepository->create($product_data);
            }
        }

        return $order;
    }

    public function orderBy()
    {
        // Fetch orders from the database sorted by creation date in descending order
        return $this->orderRepository->orderBy('created_at', 'desc')->get();
    }

    public function findWhere($arr)
    {
        return $this->orderRepository->findWhere($arr);
    }


    public function updateStatus($data)
    {
        $order = $this->orderRepository->findWhere(['id' => $data['order_id']])->first();
        $order =  $this->orderRepository->update(['status_id' => $data['status_id']], $order->id);
        return $order;
    }

    public function cancelOrder($data)
    {
        $order = $this->orderRepository->findWhere(['id' => $data['order_id']])->first();
        $order =  $this->orderRepository->update(['status_id' => 6], $order->id);
        return $order;
    }


    public function updateNotesAndQuantities($data)
    {
        $order = $this->orderRepository->find($data['order_id']);

        if (!$order) {
            return ['failed' => true, 'message' => 'Order not found'];
        }

        // Update notes
        $order->notes = $data['notes'] ?? $order->notes;
        $order->save();

        // Update quantities
        if (!empty($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $itemId => $itemData) {
                $orderProduct = $this->orderproductRepository->find($itemId);
                if ($orderProduct && isset($itemData['quantity'])) {
                    $newQty = (int)$itemData['quantity'];
                    if ($newQty > 0) {
                        //Restock the original quantity before subtracting the new one
                        $product = $this->productRepository->find($orderProduct->product_id);
                        if ($product) {
                            // Adjust stock
                            $product->stock_quantity += $orderProduct->quantity - $newQty;
                            $product->save();
                        }

                        // Update the order product quantity and total
                        $orderProduct->quantity = $newQty;
                        $orderProduct->total_price = $newQty * $orderProduct->item_price;
                        $orderProduct->save();
                    }
                }
            }
        }

        // Recalculate order total_amount after quantity updates
        $updatedTotal = $order->orderProducts()->sum('total_price');
        $order->total_amount = $updatedTotal;
        $order->save();

        return $order;
    }
}
