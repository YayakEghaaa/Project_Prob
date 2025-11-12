<?php

namespace App\Filament\Opd\Resources\EpurcasingResource\Pages;

use App\Filament\Opd\Resources\EpurcasingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEpurcasing extends EditRecord
{
    protected static string $resource = EpurcasingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
