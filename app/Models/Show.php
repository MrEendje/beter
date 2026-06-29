<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'category',
        'image_url',
        'available_tickets',
        'price',
        'is_active',
    ];

    protected $casts = [
        'date' => 'datetime',
        'available_tickets' => 'integer',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'show_id');
    }
}