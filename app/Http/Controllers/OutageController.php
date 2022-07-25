<?php

namespace App\Http\Controllers;

use App\Imports\OutageImport;
use App\Models\Outage;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\never;

class OutageController extends Controller
{

    public function index()
    {
        $filter = (request()->filter) ?: "area";

        return view('outages.index', [
            'outages' => Outage::all()->sortBy($filter)
        ]);

    }


    /**
     * Import file for planned outages
     * @return void
     */
    public function importFile()
    {
        $url = "https://www.elektrodistribucija.mk/Grid/Planned-disconnections.aspx";
        preg_match('/Planirani-isklucuvanja-Samo-aktuelno(.*?).aspx/', file_get_contents($url), $match);
        $name = trim($match[1], '/');
        $fileUrl = "https://www.elektrodistribucija.mk/Files/Planirani-isklucuvanja-Samo-aktuelno/$name.aspx";
        $fileName = basename("$name.xlsx");

        Storage::put("public/{$fileName}", file_get_contents($fileUrl));

        Excel::import(new OutageImport, $fileName, 'public',
            \Maatwebsite\Excel\Excel::XLSX);
    }
}
