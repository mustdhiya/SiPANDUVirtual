<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">

    <title>
        Laporan Triwulan {{ $periode->nomor }} - {{ $periode->tahunAjaran->label ?? '-' }}
    </title>

    <style>
        @page {
            margin: 22px 24px;
        }

        body {
            color: #1f2419;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            line-height: 1.45;
        }

        .header {
            border-bottom: 3px solid #3d4a2f;
            margin-bottom: 18px;
            padding-bottom: 12px;
        }

        .brand {
            color: #3d4a2f;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        h1 {
            color: #1f2419;
            font-size: 18px;
            margin: 6px 0 4px;
        }

        .subtitle {
            color: #4f5546;
            font-size: 10px;
            margin: 0;
        }

        .report-meta {
            margin-top: 10px;
        }

        .report-meta td {
            border: none;
            padding: 2px 12px 2px 0;
        }

        .summary-grid {
            margin: 16px 0 20px;
            width: 100%;
        }

        .summary-grid td {
            background: #eef0e3;
            border: 1px solid #d9decf;
            padding: 10px;
            vertical-align: top;
            width: 25%;
        }

        .summary-label {
            color: #4f5546;
            display: block;
            font-size: 8px;
            font-weight: bold;
            letter-spacing: .4px;
            text-transform: uppercase;
        }

        .summary-value {
            color: #3d4a2f;
            display: block;
            font-size: 18px;
            font-weight: bold;
            margin-top: 4px;
        }

        h2 {
            color: #3d4a2f;
            font-size: 13px;
            margin: 20px 0 8px;
        }

        table.data-table {
            border-collapse: collapse;
            width: 100%;
        }

        table.data-table th {
            background: #3d4a2f;
            border: 1px solid #3d4a2f;
            color: #ffffff;
            font-size: 8px;
            padding: 8px 6px;
            text-align: left;
        }

        table.data-table td {
            border: 1px solid #d8ddd1;
            font-size: 8px;
            padding: 7px 6px;
            vertical-align: top;
        }

        table.data-table tr:nth-child(even) td {
            background: #faf7f0;
        }

        .center {
            text-align: center;
        }

        .muted {
            color: #66705c;
        }

        .status {
            border-radius: 3px;
            display: inline-block;
            font-size: 7px;
            font-weight: bold;
            padding: 3px 5px;
        }

        .status-success {
            background: #dcfce7;
            color: #166534;
        }

        .status-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .status-info {
            background: #e0f2fe;
            color: #075985;
        }

        .status-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .footer {
            border-top: 1px solid #d8ddd1;
            color: #66705c;
            font-size: 8px;
            margin-top: 22px;
            padding-top: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    @php
        $totalGuru = (int) ($stats['total_guru'] ?? 0);
        $sudahSubmit = (int) ($stats['sudah_submit'] ?? 0);
        $lengkap = (int) ($stats['lengkap'] ?? 0);
        $belumSubmit = max(0, $totalGuru - $sudahSubmit);

        $periodeLabel = match($periode->nomor) {
            1 => 'Januari – Maret',
            2 => 'April – Juni',
            3 => 'Juli – September',
            4 => 'Oktober – Desember',
            default => 'Periode Pendampingan',
        };
    @endphp

    <div class="header">
        <div class="brand">
            SiPANDU VIRTUAL — Pengawas PAI SMA/SMK Kota Samarinda
        </div>

        <h1>
            Laporan Pendampingan Triwulan {{ $periode->nomor }}
        </h1>

        <p class="subtitle">
            Tahun Ajaran {{ $periode->tahunAjaran->label ?? '-' }}
            — {{ $periodeLabel }}
            — {{ $periode->tema }}
        </p>

        <table class="report-meta">
            <tr>
                <td><strong>Deadline</strong></td>
                <td>: {{ $periode->deadline?->translatedFormat('d F Y') ?? '-' }}</td>

                <td><strong>Tanggal Cetak</strong></td>
                <td>: {{ now()->translatedFormat('d F Y, H:i') }}</td>
            </tr>
        </table>
    </div>

    <table class="summary-grid">
        <tr>
            <td>
                <span class="summary-label">Total Guru</span>
                <span class="summary-value">{{ $totalGuru }}</span>
            </td>

            <td>
                <span class="summary-label">Sudah Submit</span>
                <span class="summary-value">{{ $sudahSubmit }}</span>
            </td>

            <td>
                <span class="summary-label">Belum Submit</span>
                <span class="summary-value">{{ $belumSubmit }}</span>
            </td>

            <td>
                <span class="summary-label">Lengkap</span>
                <span class="summary-value">{{ $lengkap }}</span>
            </td>
        </tr>
    </table>

    <h2>Rekap Submission Guru</h2>

    <table class="data-table">
        <thead>
            <tr>
                <th class="center" style="width: 4%;">No</th>
                <th style="width: 23%;">Nama Guru</th>
                <th style="width: 22%;">Sekolah</th>
                <th style="width: 16%;">Status Jabatan</th>
                <th style="width: 14%;">Status Submission</th>
                <th style="width: 12%;">Tanggal Submit</th>
                <th style="width: 18%;">Feedback Admin</th>
            </tr>
        </thead>

        <tbody>
            @forelse($gurus as $index => $guru)
                @php
                    $submission = $guru->submissions->firstWhere('periode_id', $periode->id);

                    $statusLabel = match($submission?->status_review) {
                        'lengkap' => 'Lengkap',
                        'revisi' => 'Perlu Revisi',
                        'submitted' => 'Menunggu Review',
                        'draft' => 'Draft',
                        default => 'Belum Submit',
                    };

                    $statusClass = match($submission?->status_review) {
                        'lengkap' => 'status-success',
                        'revisi' => 'status-warning',
                        'submitted' => 'status-info',
                        default => 'status-error',
                    };

                    $jabatan = $guru->status_jabatan === 'GURU_KEPSEK'
                        ? 'Guru PAI + Kepala Sekolah'
                        : 'Guru PAI';
                @endphp

                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $guru->nama_lengkap }}</td>
                    <td>{{ $guru->sekolah->nama_sekolah ?? '-' }}</td>
                    <td>{{ $jabatan }}</td>
                    <td>
                        <span class="status {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </td>
                    <td>
                        {{ $submission?->submitted_at?->translatedFormat('d M Y') ?? '-' }}
                    </td>
                    <td>
                        {{ $submission?->feedback_admin ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="center muted">
                        Belum ada data guru binaan pada laporan ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dokumen dibuat otomatis oleh SiPANDU VIRTUAL —
        Sistem Pendampingan Terpadu Virtual Pengawas PAI Kota Samarinda.
    </div>
</body>
</html>