<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $id_event
 * @property string $event_name
 * @property string $day_event
 * @property string $description
 * @property string $ubication
 * @property string $place
 * @property string $hour
 * @property string $logo
 * @property int $max_register
 * @property string $register_begin
 * @property string $register_end
 * @property string $event_begin
 * @property string $event_end
 * @property string $updated_at
 * @property string $created_at
 */
class Event extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'event';

    /**
     * @var array
     */
    protected $fillable = ['id_event', 'event_name', 'day_event', 'description', 'ubication', 'place', 'logo', 'hour', 'max_register', 'register_begin', 'register_end', 'event_begin', 'event_end', 'updated_at', 'created_at'];
}
