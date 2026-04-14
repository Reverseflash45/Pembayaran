<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';
    protected $primaryKey = 'idpesanan';
    public $timestamps = false;

    protected $fillable = [
        'nama_customer',
        'total',
        'metode_bayar',
        'status_bayar',
        'snap_token'
    ];
}