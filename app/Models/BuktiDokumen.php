<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiDokumen extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'evaliation_detail_id',
        'file_path',
    ];

    protected $table = 'bukti_dokumen_evaluasi';

    public function evaluationDetail()
    {
        return $this->belongsTo(EvaluationDetail::class, 'evaliation_detail_id');
    }


}
