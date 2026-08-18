<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanTriwulanExport implements FromArray, WithHeadings, WithMapping, WithStyles
{
    protected $data;
    protected $periode;

    public function __construct($data, $periode)
    {
        $this->data = $data;
        $this->periode = $periode;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Guru',
            'Sekolah',
            'Status Jabatan',
            'Status Submission',
            'Tanggal Submit',
            'Feedback Admin',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row['Nama Guru'],
            $row['Sekolah'],
            $row['Status Jabatan'],
            $row['Status Submission'],
            $row['Tanggal Submit'],
            $row['Feedback Admin'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function array(): array
    {
        return $this->data;
    }
}