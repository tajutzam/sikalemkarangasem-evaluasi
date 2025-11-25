<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tingkat extends Model
{
    protected $table = 'tingkat';

    protected $fillable = [
        'variabel_id',
        'tingkat',
        'deskripsi_indikator',
    ];

    protected $casts = [
        'tingkat' => 'integer',
    ];

    public function variabel()
    {
        return $this->belongsTo(Variabel::class);
    }

    public function evaluationDetails()
    {
        return $this->hasMany(EvaluationDetail::class);
    }

    public function getFormattedTingkatAttribute(): string
    {
        $romans = ['', 'I', 'II', 'III', 'IV', 'V'];
        return 'Tingkat ' . ($romans[$this->tingkat] ?? $this->tingkat);
    }
}
