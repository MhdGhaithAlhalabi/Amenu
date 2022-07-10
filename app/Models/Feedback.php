<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table= 'feedback';
    protected $fillable =['customer_id','message','status'];
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
