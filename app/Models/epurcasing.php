<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class epurcasing extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'epurcasing';

    protected $fillable = [
        'user_id',
        'tanggal_dibuat',
        'nama_pekerjaan',
        'kode_rup',
        'pagu_rup',
        'kode_paket',
        'jenis_pengadaan',
        'surat_pesanan',
        'nilai_kontrak',
        'pdn_tkdn_impor',
        'nilai_pdn_tkdn_impor',
        'umk_non_umk',
        'nilai_umk',
        'serah_terima',
        'penilaian_kinerja',
    ];

    protected $casts = [
        'pagu_rup' => 'integer',
    ];
}
