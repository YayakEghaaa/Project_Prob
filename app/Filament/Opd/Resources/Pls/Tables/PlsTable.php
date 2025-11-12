<?php

namespace App\Filament\Opd\Resources\Pls\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PlsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tanggal_pls')
                    ->date()
                    ->sortable(),
                TextColumn::make('nama_pekerjaan')
                    ->searchable(),
                TextColumn::make('kode_rup')
                    ->searchable(),
                TextColumn::make('pagu_rup')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kode_paket')
                    ->searchable(),
                TextColumn::make('jenis_pengadaan')
                    ->badge(),
                TextColumn::make('summary_report')
                    ->searchable(),
                TextColumn::make('nilai_kontrak')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('pdn_tkdn_impor')
                    ->badge(),
                TextColumn::make('nilai_pdn_tkdn_impor')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('umk_non_umk')
                    ->badge(),
                TextColumn::make('nilai_umk')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('serah_terima_pekerjaan')
                    ->badge(),
                TextColumn::make('penilaian_kinerja')
                    ->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
