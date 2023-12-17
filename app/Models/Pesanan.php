<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = "pesanan";
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = ['nomor_pesanan', 'total_harga', 'metode_pembayaran',
        'tanggal', 'status'
    ];
    public $timestamps = false;
}
