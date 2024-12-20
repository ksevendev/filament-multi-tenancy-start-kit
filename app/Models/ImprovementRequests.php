<?php

namespace App\Models;

use App\Enum\ImprovementRequests\{StatusImprovementsEnum, TypeImprovementsEnum};
use App\Observers\ImprovementRequestsObserver;
use Filament\Forms\Components\{FileUpload, MarkdownEditor, TextInput, ToggleButtons};
use Illuminate\Database\Eloquent\{Attributes\ObservedBy, Model, Relations\BelongsTo, Relations\HasOne, SoftDeletes};

#[ObservedBy(ImprovementRequestsObserver::class)]
class ImprovementRequests extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'attachments' => 'array',
        'status'      => StatusImprovementsEnum::class,
        'type'        => TypeImprovementsEnum::class,
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function getForm(): array
    {
        return [
            ToggleButtons::make('type')
                ->label('Tipo')
                ->options(TypeImprovementsEnum::class)
                ->default(TypeImprovementsEnum::IMPROVEMENT)
                ->inline(),
            TextInput::make('title')
                ->label('Título')
                ->columnSpan(2)
                ->required(),
            MarkdownEditor::make('description')
                ->label('Descrição')
                ->columnSpan(2),
            FileUpload::make('attachments')
                ->label('Fotos')
                ->preserveFilenames()
                ->image()
                ->multiple()
                ->imageEditor()
                ->reorderable()
                ->panelLayout('grid')
                ->maxSize(5000)
                ->appendFiles()
                ->columnSpan(2),
        ];
    }
}
