<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variabel extends Model
{
    use HasFactory;

    protected $table = 'variabel';

    protected $fillable = [
        'kode_variabel',
        'nama_variabel',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    public function tingkat()
    {
        return $this->hasMany(Tingkat::class)->orderBy('tingkat');
    }

    public function evaluationDetails()
    {
        return $this->hasMany(EvaluationDetail::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }
}