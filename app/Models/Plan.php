<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['name', 'price', 'duration', 'description', 'subscription_api_id', 'sales_commission', 'state'];
}
