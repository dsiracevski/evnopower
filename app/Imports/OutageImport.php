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
        $outageExists = Outage::where(function ($query) use ($row) {
            $query->where('start', '=', Date::excelToDateTimeObject($row[0]));
            $query->where('end', '=', Date::excelToDateTimeObject($row[1]));
            $query->where('location', '=', $row[2]);
            $query->where('address', '=', $row[3]);
        })->exists();


        if ($outageExists === false) {
            return new Outage([
                'start' => Date::excelToDateTimeObject($row[0]),
                'end' => Date::excelToDateTimeObject($row[1]),
                'location' => trim(preg_replace('/\d+/', '', $row[2])),
                'address' => $row[3]
            ]);
        }
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
