<?php

namespace App\Models;

/**
 * Class Product
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $image
 * @property string $dateCreate
 * @property string $dateChange
 * @property bool $isActive
 * @property int $categoryId
 */
class Product extends Model
{
    protected static $table = 'products';
    protected static $schema = [
        [
            'name' => 'id',
            'type' => 'int'
        ],
        [
            'name' => 'name',
            'type' => 'string'
        ],
        [
            'name' => 'description',
            'type' => 'string'
        ],
        [
            'name' => 'price',
            'type' => 'float'
        ],
        [
            'name' => 'image',
            'type' => 'string'
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
            'name' => 'isActive',
            'type' => 'bool'
        ],
        [
            'name' => 'categoryId',
            'type' => 'int'
        ]
    ];
}