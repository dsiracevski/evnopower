<?php

namespace App\Imports;

use App\Models\Outage;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OutageImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
     * @param  array  $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Outage([
            'start' => Date::excelToDateTimeObject($row[0]),
            'end' => Date::excelToDateTimeObject($row[1]),
            'location' => trim(preg_replace('/\d+/', '', $row[2])),
            'address' => $row[3]
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
