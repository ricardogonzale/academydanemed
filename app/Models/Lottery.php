<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JamesDordoy\LaravelVueDatatable\Traits\LaravelVueDatatableTrait;

/**
 * @property int $id
 * @property string $name_lottery
 * @property string $name
 * @property string $city
 * @property string $email
 * @property float $whatsapp
 * @property string $cedula_p
 * @property string $practice
 * @property string $agent
 * @property string $created_at
 * @property string $updated_at
 */
class Lottery extends Model
{
    use LaravelVueDatatableTrait;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'lottery';

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],

        'name_lottery' => [
            'searchable' => true,
        ],
        'name' => [
            'searchable' => true,
        ],
        'city' => [
            'searchable' => true,
        ],
        'whatsapp' => [
            'searchable' => true,
        ],
        'email' => [
            'searchable' => true,
        ],
        'cedula_p' => [
            'searchable' => true,
        ],
        'agent' => [
            'searchable' => true,
        ]
    ];
    /**
     * @var array
     */
    protected $fillable = ['name_lottery', 'name', 'city', 'email', 'whatsapp', 'cedula_p', 'agent', 'created_at', 'updated_at'];
}
