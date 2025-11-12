<?php

namespace App\Filament\Opd\Resources;

use App\Filament\Opd\Resources\NonTenderResource\Pages;
use App\Filament\Opd\Resources\NonTenderResource\RelationManagers;
use App\Models\nontender;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NonTenderResource extends Resource
{
    protected static ?string $model = NonTender::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                ->default(auth()->id())
                ->required(),
                Forms\Components\Section::make('Informasi Dasar')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_dibuat')
                            ->label('Tanggal dibuat')
                            ->required()
                            ->default(now())
                            ->disabled(fn (string $operation): bool => $operation === 'edit')
                            ->dehydrated()
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        Forms\Components\TextInput::make('nama_pekerjaan')
                            ->label('Nama Pekerjaan')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('kode_rup')
                            ->label('Kode RUP')
                            ->required()
                            ->numeric()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('pagu_rup')
                            ->label('Pagu RUP')
                            ->numeric()
                            ->prefix('Rp')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('kode_paket')
                            ->label('Kode Paket')
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Forms\Components\Select::make('jenis_pengadaan')
                            ->label('Jenis Pengadaan')
                            ->options([
                                'Barang' => 'Barang',
                                'Pekerjaan Konstruksi' => 'Pekerjaan Konstruksi',
                                'Jasa Konsultansi' => 'Jasa Konsultansi',
                                'Jasa Lainnya' => 'Jasa Lainnya',
                                'Terintegrasi' => 'Terintegrasi',
                            ])
                            ->native(false),
                // Forms\Components\TextInput::make('surat_pesanan')
                //     ->maxLength(255)
                //     ->default(null),
                // BARIS 2: PDN/TKDN/IMPOR dan Nilainya
                // BARIS 1: Nilai Kontrak
                        Forms\Components\TextInput::make('nilai_kontrak')
                            ->label('Nilai Kontrak')
                            ->numeric()
                            ->required()
                            ->live(onBlur: true)
                            ->prefix('Rp')
                            ->placeholder('0')
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                $pdnTkdnImpor = $get('pdn_tkdn_impor');
                                $umkNonUmk = $get('umk_non_umk');
                                
                                if ($pdnTkdnImpor === 'IMPOR') {
                                    $set('nilai_pdn_tkdn_impor', 0);
                                } elseif ($pdnTkdnImpor) {
                                    $set('nilai_pdn_tkdn_impor', $state);
                                }
                                
                                if ($umkNonUmk === 'Non UMK') {
                                    $set('nilai_umk', 0);
                                } elseif ($umkNonUmk) {
                                    $set('nilai_umk', $state);
                                }
                            })
                            ->columnSpanFull(),

                        Forms\Components\Grid::make()
                            ->schema([
                                // Kolom 1: Radio Button
                                Forms\Components\Fieldset::make('PDN/TKDN/IMPOR')
                                    ->schema([
                                        Forms\Components\Radio::make('pdn_tkdn_impor')
                                            ->options([
                                                'PDN' => 'PDN',
                                                'TKDN' => 'TKDN', 
                                                'IMPOR' => 'IMPOR',
                                            ])
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $nilaiKontrak = $get('nilai_kontrak');
                                                if ($state === 'IMPOR') {
                                                    $set('nilai_pdn_tkdn_impor', 0);
                                                    $set('persentase_tkdn', null);
                                                } elseif ($state === 'PDN') {
                                                    $set('nilai_pdn_tkdn_impor', $nilaiKontrak);
                                                    $set('persentase_tkdn', null);
                                                } else {
                                                    $set('nilai_pdn_tkdn_impor', 0);
                                                    $set('persentase_tkdn', 0);
                                                }
                                            })
                                            ->inline()
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpan(1),

                                // Kolom 2: Conditional Fields
                                Forms\Components\Group::make()
                                    ->schema([
                                        // Untuk PDN & IMPOR
                                        Forms\Components\TextInput::make('nilai_pdn_tkdn_impor')
                                            ->label('Nilai PDN/TKDN/IMPOR')
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->prefix('Rp')
                                            ->visible(fn (Forms\Get $get): bool => 
                                                in_array($get('pdn_tkdn_impor'), ['PDN', 'IMPOR'])
                                            )
                                            ->helperText(fn (Forms\Get $get): string => 
                                                $get('pdn_tkdn_impor') === 'IMPOR' 
                                                    ? 'Otomatis 0 untuk IMPOR' 
                                                    : 'Otomatis terisi sesuai nilai kontrak'
                                            ),

                                        // Untuk TKDN
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('persentase_tkdn')
                                                    ->label('Persentase TKDN')
                                                    ->numeric()
                                                    ->suffix('%')
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                        $nilaiKontrak = $get('nilai_kontrak');
                                                        $persentase = $state ?: 0;
                                                        $hasil = $nilaiKontrak * ($persentase / 100);
                                                        $set('nilai_pdn_tkdn_impor', $hasil);
                                                    }),

                                                Forms\Components\TextInput::make('nilai_pdn_tkdn_impor')
                                                    ->label('Hasil TKDN')
                                                    ->numeric()
                                                    ->disabled()
                                                    ->dehydrated()
                                                    ->prefix('Rp')
                                                    ->helperText('Hasil: Nilai Kontrak × Persentase TKDN'),
                                            ])
                                            ->columns(2)
                                            ->visible(fn (Forms\Get $get): bool => 
                                                $get('pdn_tkdn_impor') === 'TKDN'
                                            ),
                                    ])
                                    ->columnSpan(1),
                            ])
                            ->columns(2),

                        // BARIS 3: UMK/Non UMK dan Nilainya
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Fieldset::make('UMK / Non UMK')
                                    ->schema([
                                        Forms\Components\Radio::make('umk_non_umk')
                                            ->options([
                                                'UMK' => 'UMK',
                                                'Non UMK' => 'Non UMK',
                                            ])
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $nilaiKontrak = $get('nilai_kontrak');
                                                if ($state === 'Non UMK') {
                                                    $set('nilai_umk', 0);
                                                } elseif ($state) {
                                                    $set('nilai_umk', $nilaiKontrak);
                                                }
                                            })
                                            ->inline()
                                            ->columnSpanFull(),
                                    ])
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('nilai_umk')
                                    ->label('Nilai UMK')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->prefix('Rp')
                                    ->helperText(fn (Forms\Get $get): string =>
                                        $get('umk_non_umk') === 'Non UMK'
                                            ? 'Otomatis 0 untuk Non UMK'
                                            : 'Otomatis terisi sesuai nilai kontrak'
                                    )
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                Forms\Components\FileUpload::make('realisasi')
                            ->label('Realisasi')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/jpg'])
                            ->maxSize(5120)
                            ->directory('realisasi')
                            ->downloadable()
                            ->openable()
                            ->helperText('Upload file JPG/PDF (Max: 5MB)'),
                // Forms\Components\TextInput::make('serah_terima'),
                // Forms\Components\Textarea::make('penilaian_kinerja')
                //     ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal_dibuat')
                    ->label('Tanggal dibuat')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_pekerjaan')
                    ->label('Nama Pekerjaan')
                    ->searchable()
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\TextColumn::make('kode_rup')
                    ->label('Kode RUP')
                    ->searchable(),

                Tables\Columns\TextColumn::make('pagu_rup')
                    ->label('Pagu RUP')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nilai_kontrak')
                    ->label('Nilai Kontrak')
                    ->formatStateUsing(fn ($state) => $state ? 'Rp ' . number_format($state, 0, ',', '.') : '-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_pengadaan')
                    ->label('Jenis Pengadaan')
                    ->options([
                        'Barang' => 'Barang',
                        'Pekerjaan Konstruksi' => 'Pekerjaan Konstruksi',
                        'Jasa Konsultansi' => 'Jasa Konsultansi',
                        'Jasa Lainnya' => 'Jasa Lainnya',
                        'Terintegrasi' => 'Terintegrasi',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNonTenders::route('/'),
            'create' => Pages\CreateNonTender::route('/create'),
            'edit' => Pages\EditNonTender::route('/{record}/edit'),
        ];
    }
}
