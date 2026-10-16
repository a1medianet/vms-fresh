<?php

namespace App\Exports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function __construct(
        private $visitors,
        private $reportType,
        private $period1,
        private $period2 = null
    ) {
    }

    public function collection()
    {
        return $this->visitors;
    }

    public function headings(): array
    {
        return [
            __('ID'),
            __('Full Name'),
            __('Email'),
            __('Nationality'),
            __('Passport Number'),
            __('Arrival Date'),
            __('Departure Date'),
            __('Status'),
        ];
    }

    public function map($visitor): array
    {
        return [
            $visitor->id,
            $visitor->full_name,
            $visitor->email,
            $visitor->nationality,
            $visitor->passport_number,
            $visitor->arrival_date->format('Y-m-d'),
            $visitor->departure_date->format('Y-m-d'),
            $visitor->status,
        ];
    }

    public function title(): string
    {
        $title = ucfirst($this->reportType) . ' Report';
        if ($this->period2) {
            $title .= " ({$this->period1} - {$this->period2})";
        } else {
            $title .= " ({$this->period1})";
        }
        return $title;
    }
}
