<?php

namespace App\Filament\Opd\Resources\PengadaanDaruratResource\Pages;

use App\Filament\Opd\Resources\PengadaanDaruratResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengadaanDarurats extends ListRecords
{
    protected static string $resource = PengadaanDaruratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
