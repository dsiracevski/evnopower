<?php

namespace App\Imports;

use App\Models\Outage;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OutageImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function model(array $row): ?Model
    {
        $row = $this->formatted($row);

        return $this->import($row);
    }

    public function formatted(array $row): array
    {
        if (!isset($row[4])) {
            $row[4] = $row[3];
            $row[3] = $row[2];
            $row[2] = 69;
        }

        return $row;
    }

    public function import(array $row): Outage
    {
        return new Outage([
            'start' => Date::excelToDateTimeObject($row[0]),
            'end' => Date::excelToDateTimeObject($row[1]),
            'cec_number' => $row[2],
            'location' => $row[3],
            'address' => $row[4]
        ]);
    }

    /**
     * Set starting row
     * @return int
     */
    public function startRow(): int
    {
        return 3;
    }
}
