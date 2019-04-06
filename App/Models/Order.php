<?php

namespace App\Models;

/**
 * Class Order
 * @package App\Models
 * @property int $id
 * @property int $userId
 * @property string $address
 * @property string $dateCreate
 * @property string $dateChange
 * @property int $status
 */
class Order extends Model
{
    protected static $table = 'orders';
    protected static $schema = [
        [
            'name' => 'id',
            'type' => 'int'
        ],
        [
            'name' => 'userId',
            'type' => 'int',
        ],
        [
            'name' => 'address',
            'type' => 'string',
        ],
        [
            'name' => 'dateCreate',
            'type' => 'string',
        ],
        [
            'name' => 'dateChange',
            'type' => 'string',
            'nullable' => true,
        ],
        [
            'name' => 'status',
            'type' => 'int'
        ]
    ];

    /**
     * Надостройка над get, что бы получить сразу с товарами
     * @param array|null $filters
     * @param array|null $orders
     * @param int|null $limitCount
     * @param int|null $limitOffset
     * @return self[]
     */
    public static function getWithProducts(
        ?array $filters = [],
        ?array $orders = [],
        ?int $limitCount = null,
        ?int $limitOffset = null
    ): array
    {
        $orders = static::get($filters, $orders, $limitCount, $limitOffset);
        if (empty($orders)) {
            return $orders;
        }

        $orderIds = array_column($orders, 'id');

        $orderProducts = OrderProduct::get([[
            'col' => 'orderId',
            'oper' => 'IN',
            'value' => '(' . implode(', ', $orderIds) . ')',
        ]]);

        $productIds = array_column($orderProducts, 'productId');

        $products = Product::get([[
            'col' => 'id',
            'oper' => 'IN',
            'value' => '(' . implode(', ', $productIds) . ')',
        ]]);

        $indexedProducts = [];
        foreach ($products as $product) {
            $indexedProducts[$product->id] = $product;
        }

        foreach ($orderProducts as &$item) {
            $item->product = $indexedProducts[$item->productId] ?? null;
        }

        $indexedOrders = [];
        foreach ($orderProducts as $orderItem) {
            $indexedOrders[$orderItem->orderId][] = $orderItem;
        }

        foreach ($orders as &$order) {
            $order->order = $indexedOrders[$order->id] ?? null;
        }
        return $orders;
    }
}