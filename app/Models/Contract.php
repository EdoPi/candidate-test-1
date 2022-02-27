<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;

    protected $fillable = ['order_id', 'title'];

    public function orders(){
        return $this->belongsTo('App\Models\Order');
    }
}
