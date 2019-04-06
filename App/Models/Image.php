<?php

namespace App\Models;

/**
 * Class Image
 * @package App\Models
 * @property int $id
 * @property string $url
 * @property int $views
 * @property string $title
 * @property string|null $size
 */
class Image extends Model
{
    protected static $table = 'images';
    protected static $schema = [
        [
            'name' => 'id',
            'type' => 'int'
        ],
        [
            'name' => 'url',
            'type' => 'string'
        ],
        [
            'name' => 'views',
            'type' => 'int'
        ],
        [
            'name' => 'title',
            'type' => 'string'
        ],
        [
            'name' => 'size',
            'type' => 'string',
            'nullable' => true
        ]
    ];
}