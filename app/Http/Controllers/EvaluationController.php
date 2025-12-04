<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\EvaluationDetail;
use App\Models\Instansi;
use App\Models\Variabel;
use App\Models\Tingkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $query = Evaluation::with(['instansi', 'user']);

        // Filter by user if not admin
        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by year
        if ($request->filled('tahun')) {
            $query->byYear($request->tahun);
        }

        // Search by instansi
        if ($request->filled('search')) {
            $query->whereHas('instansi', function ($q) use ($request) {
                $q->where('nama_instansi', 'like', '%' . $request->search . '%');
            });
        }

        $evaluations = $query->orderBy('tahun', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Filter years based on user role
        $yearsQuery = Evaluation::select('tahun')->distinct();
        if (!Auth::user()->is_admin) {
            $yearsQuery->where('user_id', Auth::id());
        }
        $years = $yearsQuery->orderBy('tahun', 'desc')->pluck('tahun');

        return view('evaluations.index', compact('evaluations', 'years'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            $instansis = Instansi::orderBy('nama_instansi')->get();
            $userInstansiId = null;
        } else {
            $instansis = Instansi::orderBy('nama_instansi')->get();
            $userInstansiId = $user->instansi_id;
        }

        $currentYear = date('Y');

        return view('evaluations.create', compact('instansis', 'currentYear', 'userInstansiId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'instansi_id' => 'required|exists:instansi,id',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        $exists = Evaluation::where('instansi_id', $request->instansi_id)
            ->where('tahun', $request->tahun)
            ->where('status', '!=', 'rejected')
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'tahun' => 'Lembar kerja untuk instansi ini pada tahun tersebut sudah ada dan masih aktif!'
            ])->withInput();
        }

        DB::beginTransaction();
        try {
            // Create evaluation
            $evaluation = Evaluation::create([
                'instansi_id' => $request->instansi_id,
                'tahun' => $request->tahun,
                'user_id' => Auth::id(),
                'status' => 'draft',
            ]);

            // Create evaluation details for all variabel
            $variabels = Variabel::ordered()->get();
            foreach ($variabels as $variabel) {
                EvaluationDetail::create([
                    'evaluation_id' => $evaluation->id,
                    'variabel_id' => $variabel->id,
                    'tingkat_id' => null,
                    'bukti_dokumen' => null,
                    'keterangan' => null,
                ]);
            }

            DB::commit();

            return redirect()->route('evaluations.edit', $evaluation->id)
                ->with('success', 'Lembar kerja berhasil dibuat! Silakan isi data lembar kerja.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat lembar kerja: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(Evaluation $evaluation)
    {
        if (!Auth::user()->is_admin && $evaluation->user_id !== Auth::id()) {
            //            abort(403, 'Anda tidak memiliki akses ke lembar kerja ini.');
        }

        $evaluation->load(['instansi', 'user', 'details.variabel.tingkat', 'details.tingkat']);

        return view('evaluations.show', compact('evaluation'));
    }

    public function edit(Evaluation $evaluation)
    {
        if (!Auth::user()->is_admin && $evaluation->user_id !== Auth::id()) {
            //            abort(403, 'Anda tidak memiliki akses ke lembar kerja ini.');
        }

        $evaluation->load(['instansi', 'details.variabel.tingkat', 'details.tingkat']);

        return view('evaluations.edit', compact('evaluation'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        if (!Auth::user()->is_admin && $evaluation->user_id !== Auth::id()) {
            //            abort(403, 'Anda tidak memiliki akses ke lembar kerja ini.');
        }

        if (!$evaluation->canBeEdited()) {
            return back()->with('error', 'Lembar kerja ini tidak dapat diedit karena sudah disubmit!');
        }

        $request->validate([
            'details' => 'required|array',
            'details.*.tingkat_id' => 'nullable|exists:tingkat,id',
            'details.*.bukti_dokumen' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:5120',
            'details.*.keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->details as $detailId => $data) {
                $detail = EvaluationDetail::find($detailId);
                if ($detail && $detail->evaluation_id == $evaluation->id) {
                    $updateData = [
                        'tingkat_id' => $data['tingkat_id'] ?? null,
                        'keterangan' => $data['keterangan'] ?? null,
                    ];

                    // Handle file upload
                    if ($request->hasFile("details.{$detailId}.bukti_dokumen")) {
                        // Delete old file if exists
                        if ($detail->bukti_dokumen && Storage::disk('public')->exists($detail->bukti_dokumen)) {
                            Storage::disk('public')->delete($detail->bukti_dokumen);
                        }

                        // Store new file
                        $file = $request->file("details.{$detailId}.bukti_dokumen");
                        $fileName = time() . '_' . $detailId . '_' . $file->getClientOriginalName();
                        $filePath = $file->storeAs('evaluations', $fileName, 'public');
                        $updateData['bukti_dokumen'] = $filePath;
                    }

                    $detail->update($updateData);
                }
            }

            DB::commit();

            return redirect()->route('evaluations.edit', $evaluation->id)
                ->with('success', 'Lembar kerja berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengupdate lembar kerja: ' . $e->getMessage());
        }
    }

    public function destroy(Evaluation $evaluation)
    {
        if (!Auth::user()->is_admin && $evaluation->user_id !== Auth::id()) {
            //            abort(403, 'Anda tidak memiliki akses ke lembar kerja ini.');
        }

        if (!$evaluation->isDraft()) {
            return back()->with('error', 'Hanya lembar kerja dengan status draft yang dapat dihapus!');
        }

        foreach ($evaluation->details as $detail) {
            if ($detail->bukti_dokumen && Storage::disk('public')->exists($detail->bukti_dokumen)) {
                Storage::disk('public')->delete($detail->bukti_dokumen);
            }
        }

        $evaluation->delete();

        return redirect()->route('evaluations.index')
            ->with('success', 'Lembar kerja berhasil dihapus!');
    }

    public function submit(Evaluation $evaluation)
    {
        // Check authorization: admin can submit all, users can only submit their own
        if (!Auth::user()->is_admin && $evaluation->user_id !== Auth::id()) {
            //            abort(403, 'Anda tidak memiliki akses ke lembar kerja ini.');
        }

        if (!$evaluation->canBeEdited()) {
            return back()->with('error', 'Lembar kerja ini tidak dapat disubmit!');
        }

        // Check if all details are filled
        $unfilledCount = $evaluation->details()->whereNull('tingkat_id')->count();
        if ($unfilledCount > 0) {
            return back()->with('error', "Masih ada {$unfilledCount} variabel yang belum diisi tingkatnya!");
        }

        $evaluation->submit();

        return redirect()->route('evaluations.index')
            ->with('success', 'Lembar kerja berhasil disubmit!');
    }

    public function approve(Evaluation $evaluation)
    {
        if (!Auth::user()->is_admin) {
            return back()->with('error', 'Hanya admin yang dapat menyetujui lembar kerja!');
        }

        if (!$evaluation->isSubmitted()) {
            return back()->with('error', 'Hanya lembar kerja yang sudah disubmit yang dapat disetujui!');
        }

        $evaluation->approve();

        return redirect()->route('evaluations.index')
            ->with('success', 'Lembar kerja berhasil disetujui!');
    }

    public function reject(Evaluation $evaluation)
    {
        if (!Auth::user()->is_admin) {
            return back()->with('error', 'Hanya admin yang dapat menolak lembar kerja!');
        }

        if (!$evaluation->isSubmitted()) {
            return back()->with('error', 'Hanya lembar kerja yang sudah disubmit yang dapat ditolak!');
        }

        $evaluation->reject();

        return redirect()->route('evaluations.index')
            ->with('success', 'Lembar kerja berhasil ditolak!');
    }

    public function downloadFile($id)
    {
        $evaluationDetail = EvaluationDetail::findOrFail($id);

        if (!Auth::user()->is_admin && $evaluationDetail->evaluation->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        if (!$evaluationDetail->bukti_dokumen || !Storage::disk('public')->exists($evaluationDetail->bukti_dokumen)) {
            return back()->with('error', 'File tidak ditemukan!');
        }

        return Storage::disk('public')->download($evaluationDetail->bukti_dokumen);
    }

    public function deleteFile($id)
    {
        try {
            $evaluationDetail = EvaluationDetail::findOrFail($id);

            if (!Auth::user()->is_admin && $evaluationDetail->evaluation->user_id !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke file ini!'
                ], 403);
            }

            if (!$evaluationDetail->evaluation->canBeEdited()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Lembar kerja ini tidak dapat diedit!'
                ], 403);
            }

            if ($evaluationDetail->bukti_dokumen && Storage::disk('public')->exists($evaluationDetail->bukti_dokumen)) {
                Storage::disk('public')->delete($evaluationDetail->bukti_dokumen);
                $evaluationDetail->update(['bukti_dokumen' => null]);

                return response()->json([
                    'success' => true,
                    'message' => 'File berhasil dihapus!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan!'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
