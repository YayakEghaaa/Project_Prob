<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class swakelola extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'swakelolas';

    protected $fillable = [
        'tanggal_dibuat',
        'nama_pekerjaan',
        'kode_rup',
        'pagu_rup',
        'kode_paket',
        'jenis_pengadaan',
        'nilai_kontrak',
        'realisasi',
    ];
}
