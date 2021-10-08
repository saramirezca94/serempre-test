<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    public function query()
    {
        return Client::query();
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'City id',
            'Created At'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->id,
            $transaction->name,
            $transaction->city_id,
            $transaction->created_at
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'name',
            'city_id',
            'created_at'
        ];
    }
}
