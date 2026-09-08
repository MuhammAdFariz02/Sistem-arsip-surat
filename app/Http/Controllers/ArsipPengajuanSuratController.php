<?php

namespace App\Http\Controllers;

use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArsipPengajuanSuratController extends Controller
{
    public function index(Request $request)
    {
        abort_unless(Auth::user()->role === 'admin', 403, 'Arsip pengajuan surat hanya dapat diakses Admin.');

        $baseQuery = PengajuanSurat::query();
        $query = PengajuanSurat::with(['jenisSurat', 'pemohon', 'posisi', 'digitalSignature.signer']);

        if ($request->filled('search')) {
            $search = trim((string) $request->search);

            $query->where(function ($subQuery) use ($search): void {
                $subQuery->where('nomor_pengajuan', 'like', '%'.$search.'%')
                    ->orWhere('perihal', 'like', '%'.$search.'%')
                    ->orWhereHas('pemohon', function ($pemohonQuery) use ($search): void {
                        $pemohonQuery->where('name', 'like', '%'.$search.'%')
                            ->orWhere('nip', 'like', '%'.$search.'%');
                    })
                    ->orWhereHas('digitalSignature', function ($signatureQuery) use ($search): void {
                        $signatureQuery->where('verification_code', 'like', '%'.$search.'%');
                    });
            });
        }

        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_pengajuan', $request->tahun);
        }

        if ($request->filled('ttd')) {
            $request->ttd === 'sudah'
                ? $query->whereHas('digitalSignature')
                : $query->doesntHave('digitalSignature');
        }

        $pengajuanSurats = $query
            ->withCount('riwayat')
            ->latest('tanggal_pengajuan')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $jenisSurats = JenisSurat::orderBy('nama')->get();
        $statusOptions = PengajuanSurat::STATUS;
        $years = $baseQuery
            ->orderByDesc('tanggal_pengajuan')
            ->pluck('tanggal_pengajuan')
            ->map(fn ($date) => $date ? date('Y', strtotime((string) $date)) : null)
            ->filter()
            ->unique()
            ->values();

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'selesai' => (clone $baseQuery)->where('status', 'selesai')->count(),
            'proses' => (clone $baseQuery)->whereNotIn('status', ['draft', 'ditolak', 'selesai'])->count(),
            'revisi_ditolak' => (clone $baseQuery)->whereIn('status', ['draft', 'ditolak'])->count(),
            'ditandatangani' => (clone $baseQuery)->whereHas('digitalSignature')->count(),
        ];

        return view('arsip-pengajuan-surat.index', compact(
            'pengajuanSurats',
            'jenisSurats',
            'statusOptions',
            'years',
            'stats'
        ));
    }
}
