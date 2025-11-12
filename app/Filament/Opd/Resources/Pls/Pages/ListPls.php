<?php

namespace App\Filament\Opd\Resources\Pls\Pages;

use App\Filament\Opd\Resources\Pls\PlResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPls extends ListRecords
{
    protected static string $resource = PlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
