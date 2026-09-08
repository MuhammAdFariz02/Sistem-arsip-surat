@extends('layouts.main')

@section('title', 'Arsip Pengajuan Surat')

@section('content')
<div class="archive-shell">
    <section class="archive-hero mb-4">
        <div>
            <div class="archive-kicker">Arsip Pengajuan</div>
            <h4 class="mb-1 fw-bold">Semua Pengajuan Surat</h4>
            <p class="mb-0 text-muted">Ruang admin untuk menelusuri, membuka, dan mengunduh seluruh dokumen dari alur pengajuan surat.</p>
        </div>
        <div class="archive-stamp">
            <i class="fas fa-box-archive"></i>
            <span>{{ $stats['total'] }} data</span>
        </div>
    </section>

    <div class="archive-metrics mb-4">
        <div class="metric-card metric-total">
            <span>Total arsip</span>
            <strong>{{ $stats['total'] }}</strong>
        </div>
        <div class="metric-card">
            <span>Selesai</span>
            <strong>{{ $stats['selesai'] }}</strong>
        </div>
        <div class="metric-card">
            <span>Dalam proses</span>
            <strong>{{ $stats['proses'] }}</strong>
        </div>
        <div class="metric-card">
            <span>Revisi / ditolak</span>
            <strong>{{ $stats['revisi_ditolak'] }}</strong>
        </div>
        <div class="metric-card">
            <span>Sudah TTD digital</span>
            <strong>{{ $stats['ditandatangani'] }}</strong>
        </div>
    </div>

    <section class="archive-filter mb-3">
        <form action="{{ route('arsip-pengajuan-surat.index') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-xl-3 col-lg-4">
                    <label class="form-label">Cari arsip</label>
                    <input type="text" name="search" class="form-control" placeholder="Nomor, perihal, nama, NIP, kode QR" value="{{ request('search') }}">
                </div>
                <div class="col-xl-2 col-lg-4">
                    <label class="form-label">Jenis</label>
                    <select name="jenis_surat_id" class="form-select">
                        <option value="">Semua jenis</option>
                        @foreach($jenisSurats as $jenisSurat)
                        <option value="{{ $jenisSurat->id }}" {{ request('jenis_surat_id') == $jenisSurat->id ? 'selected' : '' }}>
                            {{ $jenisSurat->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 col-lg-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua status</option>
                        @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 col-lg-4">
                    <label class="form-label">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="">Semua tahun</option>
                        @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-2 col-lg-4">
                    <label class="form-label">TTD digital</label>
                    <select name="ttd" class="form-select">
                        <option value="">Semua</option>
                        <option value="sudah" {{ request('ttd') === 'sudah' ? 'selected' : '' }}>Sudah TTD</option>
                        <option value="belum" {{ request('ttd') === 'belum' ? 'selected' : '' }}>Belum TTD</option>
                    </select>
                </div>
                <div class="col-xl-1 col-lg-4 d-flex gap-2">
                    @if(request()->hasAny(['search', 'jenis_surat_id', 'status', 'tahun', 'ttd']))
                    <a href="{{ route('arsip-pengajuan-surat.index') }}" class="btn btn-light border archive-icon-button" title="Reset filter">
                        <i class="fas fa-rotate-left"></i>
                    </a>
                    @endif
                    <button class="btn btn-primary archive-icon-button" title="Terapkan filter">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>
    </section>

    <section class="archive-table">
        <div class="archive-table-head">
            <div>
                <h6 class="mb-1 fw-bold">Daftar Arsip Pengajuan</h6>
                <small class="text-muted">Berisi semua pengajuan surat, bukan modul surat masuk atau surat keluar lama.</small>
            </div>
            <span class="archive-count">{{ $pengajuanSurats->total() }} hasil</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Dokumen</th>
                        <th>Pemohon</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>TTD / QR</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuanSurats as $pengajuan)
                    @php
                    $statusColor = match($pengajuan->status) {
                        'ditolak' => 'danger',
                        'selesai', 'disetujui_kabid' => 'success',
                        'draft' => 'secondary',
                        default => 'warning',
                    };
                    @endphp
                    <tr>
                        <td class="archive-document">
                            <div class="document-code">{{ $pengajuan->nomor_pengajuan }}</div>
                            <div class="document-title">{{ Str::limit($pengajuan->perihal, 62) }}</div>
                            <div class="document-type">{{ $pengajuan->jenisSurat->nama }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $pengajuan->pemohon->name }}</div>
                            <div class="text-muted small">{{ $pengajuan->pemohon->nip ?: '-' }}</div>
                            <div class="text-muted small">{{ $pengajuan->pemohon->jabatan ?: '-' }}</div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $pengajuan->tanggal_pengajuan->format('d/m/Y') }}</div>
                            <div class="text-muted small">{{ $pengajuan->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $statusColor }}">{{ $pengajuan->status_label }}</span>
                            <div class="stage-line mt-2">
                                <i class="fas fa-route"></i>
                                <span>{{ $pengajuan->tahap_label }}</span>
                            </div>
                            @if($pengajuan->posisi)
                            <div class="text-muted small mt-1">{{ $pengajuan->posisi->name }}</div>
                            @endif
                        </td>
                        <td>
                            @if($pengajuan->digitalSignature)
                            <div class="signature-chip signed">
                                <i class="fas fa-qrcode"></i>
                                <span>{{ $pengajuan->digitalSignature->verification_code }}</span>
                            </div>
                            <div class="text-muted small mt-1">{{ $pengajuan->digitalSignature->signer?->name ?: 'Kabid' }}</div>
                            @else
                            <div class="signature-chip unsigned">
                                <i class="fas fa-clock"></i>
                                <span>Belum TTD</span>
                            </div>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="archive-actions">
                                <a href="{{ route('pengajuan-surat.show', $pengajuan) }}" class="btn btn-sm btn-outline-primary" title="Lihat detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pengajuan-surat.preview', $pengajuan) }}" class="btn btn-sm btn-outline-dark" target="_blank" title="Preview dokumen">
                                    <i class="fas fa-file-lines"></i>
                                </a>
                                <a href="{{ route('pengajuan-surat.export', [$pengajuan, 'pdf']) }}" class="btn btn-sm btn-outline-danger" title="Download PDF">
                                    PDF
                                </a>
                                <a href="{{ route('pengajuan-surat.export', [$pengajuan, 'docx']) }}" class="btn btn-sm btn-outline-success" title="Download Word">
                                    DOCX
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="empty-archive">
                                <i class="fas fa-folder-open"></i>
                                <h5>Arsip pengajuan masih kosong</h5>
                                <p>Data akan muncul setelah staf membuat pengajuan surat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengajuanSurats->hasPages())
        <div class="p-3 border-top">
            {{ $pengajuanSurats->links() }}
        </div>
        @endif
    </section>
</div>

<style>
    .archive-shell {
        color: #172033;
    }

    .archive-hero,
    .archive-filter,
    .archive-table,
    .metric-card {
        background: #fff;
        border: 1px solid #dde6ee;
        border-radius: 8px;
        box-shadow: 0 14px 28px rgba(16, 24, 40, .06);
    }

    .archive-hero {
        align-items: center;
        border-left: 5px solid #0f766e;
        display: flex;
        justify-content: space-between;
        gap: 18px;
        padding: 22px 24px;
    }

    .archive-kicker {
        color: #0f766e;
        font-size: .72rem;
        font-weight: 900;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    .archive-stamp {
        align-items: center;
        background: #f5fbf9;
        border: 1px solid #bfe7db;
        border-radius: 8px;
        color: #0f766e;
        display: inline-flex;
        font-weight: 800;
        gap: 10px;
        padding: 12px 14px;
        white-space: nowrap;
    }

    .archive-metrics {
        display: grid;
        gap: 12px;
        grid-template-columns: repeat(5, minmax(0, 1fr));
    }

    .metric-card {
        min-height: 92px;
        padding: 16px;
        position: relative;
    }

    .metric-card::after {
        background: #d7a326;
        border-radius: 999px;
        content: "";
        height: 4px;
        left: 16px;
        position: absolute;
        right: 16px;
        top: 0;
    }

    .metric-total::after {
        background: #0f766e;
    }

    .metric-card span {
        color: #64748b;
        display: block;
        font-size: .78rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .metric-card strong {
        display: block;
        font-size: 2rem;
        line-height: 1;
        margin-top: 12px;
    }

    .archive-filter {
        padding: 18px;
    }

    .archive-filter .form-label {
        color: #475569;
        font-size: .78rem;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .archive-icon-button {
        align-items: center;
        border-radius: 7px;
        display: inline-flex;
        height: 38px;
        justify-content: center;
        min-width: 42px;
    }

    .archive-table-head {
        align-items: center;
        border-bottom: 1px solid #e6edf3;
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 17px 18px;
    }

    .archive-count {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        color: #334155;
        font-size: .8rem;
        font-weight: 800;
        padding: 7px 12px;
        white-space: nowrap;
    }

    .archive-table thead th {
        background: #f4f7fb;
        color: #334155;
        font-size: .73rem;
        font-weight: 900;
        letter-spacing: .05em;
        padding: 13px 14px;
        text-transform: uppercase;
    }

    .archive-table tbody td {
        border-color: #edf2f7;
        padding: 15px 14px;
        vertical-align: top;
    }

    .document-code {
        color: #0f766e;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-size: .78rem;
        font-weight: 900;
    }

    .document-title {
        font-weight: 800;
        margin-top: 4px;
        max-width: 360px;
    }

    .document-type {
        color: #64748b;
        font-size: .82rem;
        margin-top: 3px;
    }

    .stage-line,
    .signature-chip {
        align-items: center;
        display: inline-flex;
        gap: 7px;
    }

    .stage-line {
        color: #475569;
        font-size: .78rem;
        font-weight: 700;
    }

    .signature-chip {
        border-radius: 999px;
        font-size: .76rem;
        font-weight: 900;
        padding: 6px 10px;
        white-space: nowrap;
    }

    .signature-chip.signed {
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .signature-chip.unsigned {
        background: #fff7ed;
        border: 1px solid #fed7aa;
        color: #9a3412;
    }

    .archive-actions {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: flex-end;
    }

    .archive-actions .btn {
        border-radius: 7px;
        font-size: .72rem;
        font-weight: 900;
        min-width: 38px;
    }

    .empty-archive i {
        color: #94a3b8;
        font-size: 2.4rem;
        margin-bottom: 12px;
    }

    .empty-archive h5 {
        font-weight: 800;
    }

    .empty-archive p {
        color: #64748b;
        margin-bottom: 0;
    }

    @media (max-width: 1200px) {
        .archive-metrics {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .archive-hero,
        .archive-table-head {
            align-items: flex-start;
            flex-direction: column;
        }

        .archive-metrics {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 520px) {
        .archive-metrics {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
