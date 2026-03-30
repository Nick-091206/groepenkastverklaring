<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Verklaring extends Model
{
    protected $table = 'verklaringen';

    protected $fillable = [
        'user_id',
        'naam',
        'adres',
        'postcode',
        'stad',
        'aantal_groepen',
        'groepen',
        'installateur',
        'installateur_telefoon',
    ];

    protected $casts = [
        'groepen' => 'array',
        'aantal_groepen' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
