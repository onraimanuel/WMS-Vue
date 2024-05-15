<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $primaryKey = 'transaksi_id';
    
    protected $fillable = [
        'stocks_id',
        'jumlah_barang_keluar',
        'tanggal_keluar',
    ];

    public function stocks()
    {
        return $this->belongsTo(Stocks::class, 'stocks_id');
    }
}
