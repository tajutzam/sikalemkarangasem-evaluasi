<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Evaluation;
use App\Models\Variabel;
use App\Models\Instansi;
use App\Models\EvaluationDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvaluationForm extends Component
{
    use WithFileUploads;

    public $evaluationId;
    public $instansi_id;
    public $tahun;
    public $variabels;
    public $details = [];
    public $status = 'draft';

    // For file uploads
    public $uploadedFiles = [];

    protected $rules = [
        'instansi_id' => 'required|exists:instansi,id',
        'tahun' => 'required|integer|min:2000|max:2100',
        'details.*.tingkat_id' => 'nullable|exists:tingkat,id',
        'details.*.keterangan' => 'nullable|string',
    ];

    public function mount($evaluationId = null)
    {
        $this->evaluationId = $evaluationId;
        $this->variabels = Variabel::with('tingkat')->ordered()->get();

        if ($evaluationId) {
            $this->loadEvaluation();
        } else {
            $this->initializeDetails();
        }
    }

    public function loadEvaluation()
    {
        $evaluation = Evaluation::with('details')->findOrFail($this->evaluationId);

        $this->instansi_id = $evaluation->instansi_id;
        $this->tahun = $evaluation->tahun;
        $this->status = $evaluation->status;

        // Initialize details array
        foreach ($this->variabels as $variabel) {
            $detail = $evaluation->details->where('variabel_id', $variabel->id)->first();

            $this->details[$variabel->id] = [
                'id' => $detail->id ?? null,
                'tingkat_id' => $detail->tingkat_id ?? null,
                'bukti_dokumen' => $detail->bukti_dokumen ?? null,
                'keterangan' => $detail->keterangan ?? null,
            ];
        }
    }

    public function initializeDetails()
    {
        foreach ($this->variabels as $variabel) {
            $this->details[$variabel->id] = [
                'id' => null,
                'tingkat_id' => null,
                'bukti_dokumen' => null,
                'keterangan' => null,
            ];
        }
    }

    public function saveDraft()
    {
        $this->validate();

        DB::transaction(function () {
            if ($this->evaluationId) {
                $evaluation = Evaluation::findOrFail($this->evaluationId);
                $evaluation->update([
                    'instansi_id' => $this->instansi_id,
                    'tahun' => $this->tahun,
                ]);
            } else {
                $evaluation = Evaluation::create([
                    'instansi_id' => $this->instansi_id,
                    'tahun' => $this->tahun,
                    'user_id' => Auth::id(),
                    'status' => 'draft',
                ]);
                $this->evaluationId = $evaluation->id;
            }

            $this->saveDetails($evaluation);
        });

        session()->flash('message', 'Draft berhasil disimpan!');
    }

    public function submit()
    {
        $this->validate();

        // Validasi: semua variabel harus terisi
        foreach ($this->details as $variabelId => $detail) {
            if (empty($detail['tingkat_id'])) {
                session()->flash('error', 'Semua variabel harus diisi sebelum submit!');
                return;
            }
        }

        DB::transaction(function () {
            if ($this->evaluationId) {
                $evaluation = Evaluation::findOrFail($this->evaluationId);
            } else {
                $evaluation = Evaluation::create([
                    'instansi_id' => $this->instansi_id,
                    'tahun' => $this->tahun,
                    'user_id' => Auth::id(),
                    'status' => 'draft',
                ]);
                $this->evaluationId = $evaluation->id;
            }

            $this->saveDetails($evaluation);
            $evaluation->submit();
        });

        session()->flash('message', 'Evaluasi berhasil disubmit!');
        return redirect()->route('evaluations.index');
    }

    protected function saveDetails($evaluation)
    {
        foreach ($this->details as $variabelId => $detail) {
            // Handle file upload
            $buktiDokumen = $detail['bukti_dokumen'];
            if (isset($this->uploadedFiles[$variabelId])) {
                $file = $this->uploadedFiles[$variabelId];
                $path = $file->store('bukti-dokumen', 'public');
                $buktiDokumen = $path;
            }

            if ($detail['id']) {
                // Update existing detail
                EvaluationDetail::where('id', $detail['id'])->update([
                    'tingkat_id' => $detail['tingkat_id'],
                    'bukti_dokumen' => $buktiDokumen,
                    'keterangan' => $detail['keterangan'],
                ]);
            } else {
                // Create new detail
                EvaluationDetail::create([
                    'evaluation_id' => $evaluation->id,
                    'variabel_id' => $variabelId,
                    'tingkat_id' => $detail['tingkat_id'],
                    'bukti_dokumen' => $buktiDokumen,
                    'keterangan' => $detail['keterangan'],
                ]);
            }
        }
    }

    public function render()
    {
        return view('livewire.evaluation-form', [
            'instansiList' => Instansi::orderBy('nama_instansi')->get(),
        ]);
    }
}