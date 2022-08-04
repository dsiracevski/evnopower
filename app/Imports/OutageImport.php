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
//        dd($row);
        // Check if a record already exists, return true or false
        $outageExists = Outage::where(function ($query) use ($row) {
            $query->where('start', '=', Date::excelToDateTimeObject($row[0]));
            $query->where('end', '=', Date::excelToDateTimeObject($row[1]));
//            $query->where('cec_number', '=', trim(preg_replace('/[^0-9]/', '', $row[3]))); // Uncomment if EVN decide to change the file format again
            $query->where('location', '=', trim(preg_replace('/\d+/', '', $row[2]))); // 3
            $query->where('address', '=', $row[3]); // 4
        })->exists();

        // If it doesn't exist, save the record
        if ($outageExists === false) {
            return new Outage([
                'start' => Date::excelToDateTimeObject($row[0]),
                'end' => Date::excelToDateTimeObject($row[1]),
//                'cec_number' => trim(preg_replace('/[^0-9]/', '', $row[3])), // Uncomment if EVN decide to change the file format again
                'location' => trim(preg_replace('/\d+/', '', $row[2])), // 3
                'address' => $row[3] // 4
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
