<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pl extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pls';

    protected $fillable = [
        'user_id',
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
        'persentase_tkdn',
        'umk_non_umk',
        'nilai_umk',
        'serah_terima_pekerjaan',
        'bast_document',
        'penilaian_kinerja',
    ];

    protected $casts = [
        'tanggal_pls' => 'date',
        'kode_rup' => 'integer',
        'pagu_rup' => 'decimal:2',
        'nilai_kontrak' => 'decimal:2',
        'nilai_pdn_tkdn_impor' => 'decimal:2',
        'nilai_umk' => 'decimal:2',
    ];
}