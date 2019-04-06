<?php

namespace App\Models;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $login
 * @property string $password
 * @property int $role
 */
class User extends Model
{
    protected static $table = 'users';
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
            'name' => 'login',
            'type' => 'string'
        ],
        [
            'name' => 'password',
            'type' => 'string'
        ],
        [
            'name' => 'role',
            'type' => 'int'
        ],
    ];

    public function getBasket()
    {
        return Basket::getWithProducts([
            [
                'col' => 'userId',
                'oper' => '=',
                'value' => $this->id
            ],
        ]);
    }

    public function getOrders()
    {
        return Order::getWithProducts([
            [
                'col' => 'userId',
                'oper' => '=',
                'value' => $this->id
            ]
        ]);
    }
}