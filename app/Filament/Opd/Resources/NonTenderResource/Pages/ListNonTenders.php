<?php

namespace App\Filament\Opd\Resources\NonTenderResource\Pages;

use App\Filament\Opd\Resources\NonTenderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNonTenders extends ListRecords
{
    protected static string $resource = NonTenderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
