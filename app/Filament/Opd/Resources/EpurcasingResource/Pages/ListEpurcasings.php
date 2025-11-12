<?php

namespace App\Filament\Opd\Resources\EpurcasingResource\Pages;

use App\Filament\Opd\Resources\EpurcasingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEpurcasings extends ListRecords
{
    protected static string $resource = EpurcasingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
