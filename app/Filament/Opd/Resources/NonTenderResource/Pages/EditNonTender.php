<?php

namespace App\Filament\Opd\Resources\NonTenderResource\Pages;

use App\Filament\Opd\Resources\NonTenderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNonTender extends EditRecord
{
    protected static string $resource = NonTenderResource::class;

    // ✅ TAMBAHKAN INI - Redirect setelah edit
    protected function getRedirectUrl(): string
    {
        return PlResource::getUrl('index');
    }

    // ✅ OPSIONAL: Notifikasi sukses edit
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Data PL berhasil diperbarui';
    }
}
