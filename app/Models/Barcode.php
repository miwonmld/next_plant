<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Barcode extends Model
{
    use HasRoles;
    protected $connection = 'dbbarcode'; // Gunakan database BCD
    protected $table = 't_barcode'; // Nama tabel di database
    protected $primaryKey = 'barcode'; // Primary Key

    public $incrementing = false; // Karena primary key bukan angka auto-increment
    protected $keyType = 'string'; // Karena primary key adalah CHAR(12)

    public $timestamps = false; // Disable created_at dan updated_at

    protected $fillable = ['barcode', 'c_date', 'c_time', 'nprint']; // Kolom yang bisa diubah

}
