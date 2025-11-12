<?php

namespace App\Filament\Opd\Resources\PengadaanDaruratResource\Pages;

use App\Filament\Opd\Resources\PengadaanDaruratResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengadaanDarurat extends EditRecord
{
    protected static string $resource = PengadaanDaruratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
