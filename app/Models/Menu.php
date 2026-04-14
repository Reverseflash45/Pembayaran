<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'idmenu';

    // Kasih tahu Laravel kalau Menu ini punya Vendor
    public function vendor()
    {
        // 'idvendor' adalah kolom di tabel menus
        // 'idvendor' (parameter kedua) adalah kolom di tabel vendors
        return $this->belongsTo(Vendor::class, 'idvendor', 'idvendor');
    }
}