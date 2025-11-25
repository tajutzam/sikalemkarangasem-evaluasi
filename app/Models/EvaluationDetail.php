<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationDetail extends Model
{
    protected $table = 'evaliation_details'; // Note: typo in migration

    protected $fillable = [
        'evaluation_id',
        'variabel_id',
        'tingkat_id',
        'bukti_dokumen',
        'keterangan',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function variabel()
    {
        return $this->belongsTo(Variabel::class);
    }

    public function tingkat()
    {
        return $this->belongsTo(Tingkat::class);
    }
}