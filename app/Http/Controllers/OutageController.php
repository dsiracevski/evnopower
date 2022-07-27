<?php

namespace App\Http\Controllers;

use App\Imports\OutageImport;
use App\Models\Outage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class OutageController extends Controller
{

    public function index()
    {
        $locations = Outage::locations()->get();

        $currentDate = (request()->date) ? Carbon::parse(request()->date)->endOfDay() : Carbon::today()->endOfDay();

        return view('outages.index', [
            'outages' => Outage::filter()->orderBy((request()->filter) ?: "location")->get(),
            'date' => date_format($currentDate, 'Y-m-d'),
            'locations' => $locations,
            ''
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

        Storage::disk('public')->exists($fileName) ? abort('404') : Storage::put("public/{$fileName}",
            file_get_contents($fileUrl));

        Excel::import(new OutageImport, $fileName, 'public',
            \Maatwebsite\Excel\Excel::XLSX);

    }
}
