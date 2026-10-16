<?php

namespace App\Imports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class VisitorsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Visitor([
            'full_name' => $row['full_name'] ?? $row['full name'] ?? '',
            'email' => $row['email'] ?? '',
            'nationality' => $row['nationality'] ?? '',
            'passport_number' => $row['passport_number'] ?? $row['passport number'] ?? '',
            'arrival_date' => $row['arrival_date'] ?? $row['arrival date'] ?? now(),
            'departure_date' => $row['departure_date'] ?? $row['departure date'] ?? now()->addDays(7),
            'status' => $row['status'] ?? 'pending',
        ]);
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required',
            'email' => 'required|email',
            'nationality' => 'required',
            'passport_number' => 'required',
            'arrival_date' => 'required|date',
            'departure_date' => 'required|date|after:arrival_date',
        ];
    }
}
