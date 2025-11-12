<?php

namespace App\Filament\Opd\Resources\Pls\Pages;

use App\Filament\Opd\Resources\Pls\PlResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPl extends EditRecord
{
    protected static string $resource = PlResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
