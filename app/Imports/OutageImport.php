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
        // Check if a record already exists, return true or false
        $outageExists = Outage::where(function ($query) use ($row) {
            $query->where('start', '=', Date::excelToDateTimeObject($row[0]));
            $query->where('end', '=', Date::excelToDateTimeObject($row[1]));
            $query->where('cec_number', '=', trim(preg_replace('/\D/', '', $row[3])));
            $query->where('location', '=', trim(preg_replace('/\d+/', '', $row[3])));
            $query->where('address', '=', $row[4]);
        })->exists();

        // If it doesn't exist, save the record
        if ($outageExists === false) {
            return new Outage([
                'start' => Date::excelToDateTimeObject($row[0]),
                'end' => Date::excelToDateTimeObject($row[1]),
                'cec_number' => trim(preg_replace('/\D/', '', $row[3])),
                'location' => trim(preg_replace('/\d+/', '', $row[3])),
                'address' => $row[4]
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
