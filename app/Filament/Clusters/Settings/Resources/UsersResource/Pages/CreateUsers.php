<?php

namespace App\Filament\Clusters\Settings\Resources\UsersResource\Pages;

use App\Filament\Clusters\Settings\Resources\UsersResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;
}
