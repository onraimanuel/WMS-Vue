<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products'; // sesuaikan dengan nama tabel yang sesuai

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_id',
        'category_id',
        'product_name',
        'on_warehouse',
        'is_deleted',
        // tambahkan kolom lain yang ingin Anda isi secara massal di sini
    ];
}
