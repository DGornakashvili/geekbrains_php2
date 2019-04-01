<?php

namespace App\Models;

/**
 * Class OrderProduct
 * @package App\Models
 *
 * @property int $id
 * @property int $orderId
 * @property int $productId
 * @property string $dateCreate
 * @property string $dateChange
 * @property float $isActive
 * @property int $status
 */
class OrderProduct extends Model
{
    protected static $table = 'orderProducts';
    protected static $schema = [
        [
            'name' => 'id',
            'type' => 'int'
        ],
        [
            'name' => 'orderId',
            'type' => 'int',
            'nullable' => true,
        ],
        [
            'name' => 'productId',
            'type' => 'int'
        ],
        [
            'name' => 'price',
            'type' => 'float'
        ],
        [
            'name' => 'dateCreate',
            'type' => 'string',
            'nullable' => true,
        ],
        [
            'name' => 'dateChange',
            'type' => 'string',
            'nullable' => true,
        ],
        [
            'name' => 'amount',
            'type' => 'int'
        ],
        [
            'name' => 'status',
            'type' => 'int'
        ]
    ];
}