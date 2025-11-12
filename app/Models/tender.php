<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tender extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tenders';

    protected $fillable = [
        'tanggal_dibuat',
        'nama_pekerjaan',
        'kode_rup',
        'pagu_rup',
        'kode_paket',
        'jenis_pengadaan',
        'summary_report',
        'nilai_kontrak',
        'pdn_tkdn_impor',
        'nilai_pdn_tkdn_impor',
        'umk_non_umk',
        'nilai_umk',
        'serah_terima_pekerjaan',
        'penilaian_kinerja',
    ];
    protected $casts = [
        'pagu_rup' => 'integer',
    ];
}
