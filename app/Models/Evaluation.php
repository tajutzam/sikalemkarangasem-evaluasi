<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'instansi_id',
        'tahun',
        'user_id',
        'status',
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(EvaluationDetail::class);
    }


    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'submitted';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function canBeEdited(): bool
    {
        return $this->isDraft();
    }

    public function submit()
    {
        $this->update(['status' => 'submitted']);
    }

    public function approve()
    {
        $this->update(['status' => 'approved']);
    }

    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }

    public function getCompletionPercentage(): float
    {
        $total = $this->details()->count();
        if ($total === 0) return 0;

        $filled = $this->details()->whereNotNull('tingkat_id')->count();
        return round(($filled / $total) * 100, 2);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('tahun', $year);
    }
}
