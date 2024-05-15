<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataParkir extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_parkir',
        'jenis_kendaraan',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'lama_parkir',
        'total_tagihan',
        'keterangan',
    ];
}
