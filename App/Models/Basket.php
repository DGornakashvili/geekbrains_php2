<?php

namespace App\Models;

/**
 * Class Basket
 * @package App\Models
 * @property int $id
 * @property int $userId
 * @property int $productId
 * @property int $amount
 */
class Basket extends Model
{
    protected static $table = 'baskets';
    protected static $schema = [
        [
            'name' => 'id',
            'type' => 'int'
        ],
        [
            'name' => 'userId',
            'type' => 'int',
            'nullable' => true,
        ],
        [
            'name' => 'productId',
            'type' => 'int'
        ],
        [
            'name' => 'amount',
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
        //Получаем корзину как обычно
        $basket = static::get($filters, $orders, $limitCount, $limitOffset);
        if(empty($basket)) {
            return $basket;
        }
        //Получаем ID товаров которые есть в корзине
        $ids = array_column($basket, 'productId');
        //Получаем сами товары
        $products = Product::get([[
            'col' => 'id',
            'oper' => 'IN',
            'value' => '(' . implode(', ', $ids) . ')',
        ]]);
        //INDEX BY KEY
        //Превращаем нашу коллекцию в индексированную, то есть вида
        //[productId => Product]
        $indexedProducts = [];
        foreach ($products as $product) {
            $indexedProducts[$product->id] = $product;
        }
        //Добавляем каждому элементу корзины сам товар
        foreach ($basket as &$item) {
            $item->product = $indexedProducts[$item->productId] ?? null;
        }
        return $basket;
    }
}