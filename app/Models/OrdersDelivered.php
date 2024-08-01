<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDelivered extends Model
{
    use HasFactory;

    protected $table = 'orders_delivered';

    protected $fillable = [
        'user_id',
        'nameDrink',  // Añadir este campo
        'cantidad',   // Añadir este campo
    ];
    public function items()
{
    return $this->belongsTo(User::class);}
}
