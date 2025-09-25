<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $data;
    protected $type;

    public function __construct($data, $type = 'bestsellers')
    {
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        if ($this->type === 'bestsellers') {
            return [
                'Book Title',
                'Author',
                'Genre',
                'Selling Price (RM)',
                'Units Sold',
                'Total Revenue (RM)'
            ];
        } elseif ($this->type === 'authors') {
            return [
                'Author',
                'Total Revenue (RM)',
                'Total Units Sold'
            ];
        } else {
            return [
                'Genre',
                'Books Count',
                'Total Revenue (RM)'
            ];
        }
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        if ($this->type === 'bestsellers') {
            return [
                $row->title,
                $row->author,
                $row->genre->name ?? 'N/A',
                number_format($row->price, 2),
                $row->total_units ?? $row->total_sold,
                number_format($row->total_revenue ?? 0, 2)
            ];
        } elseif ($this->type === 'authors') {
            return [
                $row->author,
                number_format($row->total_revenue, 2),
                $row->total_units
            ];
        } else {
            return [
                $row->name,
                $row->books_count,
                number_format($row->total_revenue ?? 0, 2)
            ];
        }
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E5E7EB']
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        if ($this->type === 'bestsellers') {
            return [
                'A' => 30,
                'B' => 25,
                'C' => 20,
                'D' => 15,
                'E' => 12,
                'F' => 18,
            ];
        } elseif ($this->type === 'authors') {
            return [
                'A' => 25,
                'B' => 18,
                'C' => 15,
            ];
        } else {
            return [
                'A' => 25,
                'B' => 12,
                'C' => 18,
            ];
        }
    }
}
