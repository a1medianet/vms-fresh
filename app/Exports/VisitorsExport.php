<?php

namespace App\Exports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class VisitorsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Visitor::with('preArrival')->get();
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
            __('Pre-Arrival ID'),
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
            $visitor->pre_arrival_id,
        ];
    }
}
