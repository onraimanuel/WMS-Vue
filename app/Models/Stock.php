<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stocks_id',
        'product_id',
        'category_id',
        'jumlah_stok',
        'tanggal_masuk',
        'tanggal_keluar',
        'tanggal_expired',
   ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    
    public function category()
    {
        return $this->product->belongsTo(Category::class, 'category_id', 'category_id');
    }
    
}
