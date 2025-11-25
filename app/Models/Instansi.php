<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansi';

    protected $fillable = [
        'nama_instansi',
        'alamat',
        'telepon',
    ];

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function getEvaluationByYear($year)
    {
        return $this->evaluations()->where('tahun', $year)->first();
    }

    public function hasEvaluationForYear($year): bool
    {
        return $this->evaluations()->where('tahun', $year)->exists();
    }
}
