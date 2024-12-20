<?php

namespace App\Models;

use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $photoable_type
 * @property int $photoable_id
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\PhotosFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Photos newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photos newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Photos query()
 * @method static \Illuminate\Database\Eloquent\Builder|Photos whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photos wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photos wherePhotoableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photos wherePhotoableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Photos whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Photos extends Model
{
    use HasFactory;

    public static function getForm(): array
    {
        return [
            FileUpload::make('path')
                ->label('Fotos')
                ->preserveFilenames()
                ->image()
                ->imageEditor()
                ->panelLayout('grid')
                ->reorderable()
                ->maxSize(512)
                ->appendFiles(),
        ];
    }
}
