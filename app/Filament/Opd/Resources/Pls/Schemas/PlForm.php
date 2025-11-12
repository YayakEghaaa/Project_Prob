<?php

namespace App\Filament\Opd\Resources\Pls\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PlForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('tanggal_pls')
                    ->required(),
                TextInput::make('nama_pekerjaan')
                    ->required(),
                TextInput::make('kode_rup')
                    ->required(),
                TextInput::make('pagu_rup')
                    ->numeric()
                    ->default(null),
                TextInput::make('kode_paket')
                    ->default(null),
                Select::make('jenis_pengadaan')
                    ->options([
            'Barang' => 'Barang',
            'Pekerjaan Konstruksi' => 'Pekerjaan konstruksi',
            'Jasa Konsultansi' => 'Jasa konsultansi',
            'Jasa Lainnya' => 'Jasa lainnya',
            'Terintegrasi' => 'Terintegrasi',
        ])
                    ->default(null),
                TextInput::make('summary_report')
                    ->default(null),
                TextInput::make('nilai_kontrak')
                    ->numeric()
                    ->default(null),
                Select::make('pdn_tkdn_impor')
                    ->options(['PDN' => 'P d n', 'TKDN' => 'T k d n', 'IMPOR' => 'I m p o r'])
                    ->default(null),
                TextInput::make('nilai_pdn_tkdn_impor')
                    ->numeric()
                    ->default(null),
                Select::make('umk_non_umk')
                    ->options(['UMK' => 'U m k', 'Non UMK' => 'Non u m k'])
                    ->default(null),
                TextInput::make('nilai_umk')
                    ->numeric()
                    ->default(null),
                Select::make('serah_terima_pekerjaan')
                    ->options(['BAST' => 'B a s t', 'On Progres' => 'On progres'])
                    ->default(null),
                Select::make('penilaian_kinerja')
                    ->options([
            'Baik Sekali' => 'Baik sekali',
            'Baik' => 'Baik',
            'Cukup' => 'Cukup',
            'Buruk' => 'Buruk',
            'Belum Dinilai' => 'Belum dinilai',
        ])
                    ->default(null),
            ]);
    }
}
