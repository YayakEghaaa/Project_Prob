<?php

namespace App\Filament\Opd\Resources\SwakelolaResource\Pages;

use App\Filament\Opd\Resources\SwakelolaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSwakelola extends EditRecord
{
    protected static string $resource = SwakelolaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
