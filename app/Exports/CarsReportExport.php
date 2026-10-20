<?php
 
namespace App\Exports;
 
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
 
class CarsReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private Collection $cars)
    {
    }
 
    public function collection(): Collection
    {
        return $this->cars;
    }
 
    public function headings(): array
    {
        return ['Matrícula', 'Operador', 'Fecha de inicio'];
    }
 
    public function map($car): array
    {
        return [
            $car->matricula,
            $car->user->name,
            $car->fecha_inicio->format('d/m/Y'),
        ];
    }
}
