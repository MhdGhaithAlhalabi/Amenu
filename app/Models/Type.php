<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table= 'types';
    protected $fillable =['name'];
    use HasFactory;
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
