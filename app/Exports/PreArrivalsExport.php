<?php

namespace App\Exports;

use App\Models\PreArrival;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PreArrivalsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return PreArrival::all();
    }

    public function headings(): array
    {
        return [
            __('ID'),
            __('Token'),
            __('Full Name'),
            __('Email'),
            __('Nationality'),
            __('Passport Number'),
            __('Arrival Date'),
            __('Departure Date'),
            __('Used At'),
            __('Created At'),
        ];
    }

    public function map($preArrival): array
    {
        return [
            $preArrival->id,
            $preArrival->token,
            $preArrival->full_name,
            $preArrival->email,
            $preArrival->nationality,
            $preArrival->passport_number,
            $preArrival->arrival_date->format('Y-m-d'),
            $preArrival->departure_date->format('Y-m-d'),
            $preArrival->used_at ? $preArrival->used_at->format('Y-m-d H:i:s') : '',
            $preArrival->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
