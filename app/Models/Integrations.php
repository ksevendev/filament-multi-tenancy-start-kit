<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Integrations extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'settings'  => 'json',
        'is_active' => 'boolean',
    ];

    public $timestamps = false;

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
