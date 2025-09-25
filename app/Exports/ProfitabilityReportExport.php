<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfitabilityReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $data;
    protected $type;

    public function __construct($data, $type = 'books')
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
        if ($this->type === 'books') {
            return [
                'Book Title',
                'Author',
                'Selling Price (RM)',
                'Cost Price (RM)',
                'Total Revenue (RM)',
                'Total Cost (RM)',
                'Total Profit (RM)',
                'Profit Margin (%)'
            ];
        } elseif ($this->type === 'genres') {
            return [
                'Genre',
                'Total Revenue (RM)',
                'Total Cost (RM)',
                'Total Profit (RM)',
                'Profit Margin (%)'
            ];
        } else {
            return [
                'Month',
                'Revenue (RM)',
                'Cost (RM)',
                'Profit (RM)',
                'Profit Margin (%)'
            ];
        }
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        if ($this->type === 'books') {
            return [
                $row->title,
                $row->author,
                number_format($row->price, 2),
                number_format($row->cost_price, 2),
                number_format($row->total_revenue, 2),
                number_format($row->total_cost, 2),
                number_format($row->total_profit, 2),
                $row->profit_margin . '%'
            ];
        } elseif ($this->type === 'genres') {
            return [
                $row->name,
                number_format($row->total_revenue, 2),
                number_format($row->total_cost, 2),
                number_format($row->total_profit, 2),
                $row->profit_margin . '%'
            ];
        } else {
            return [
                $row->month,
                number_format($row->revenue, 2),
                number_format($row->cost, 2),
                number_format($row->profit, 2),
                $row->profit_margin . '%'
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
        if ($this->type === 'books') {
            return [
                'A' => 30,
                'B' => 25,
                'C' => 15,
                'D' => 15,
                'E' => 18,
                'F' => 15,
                'G' => 15,
                'H' => 15,
            ];
        } elseif ($this->type === 'genres') {
            return [
                'A' => 25,
                'B' => 18,
                'C' => 15,
                'D' => 15,
                'E' => 15,
            ];
        } else {
            return [
                'A' => 15,
                'B' => 18,
                'C' => 15,
                'D' => 15,
                'E' => 15,
            ];
        }
    }
}
