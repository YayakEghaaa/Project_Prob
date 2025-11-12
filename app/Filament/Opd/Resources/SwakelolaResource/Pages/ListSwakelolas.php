<?php

namespace App\Filament\Opd\Resources\SwakelolaResource\Pages;

use App\Filament\Opd\Resources\SwakelolaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSwakelolas extends ListRecords
{
    protected static string $resource = SwakelolaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
