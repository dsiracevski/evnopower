<?php

namespace App\Services;

use App\Imports\OutageImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DownloadOutagesDocument
{
    /**
     * @return array
     */
    public function handle(): array
    {
        $url = "https://www.elektrodistribucija.mk/Grid/Planned-disconnections.aspx";
        preg_match('/Planirani-isklucuvanja-Samo-aktuelno(.*?).aspx/', file_get_contents($url), $match);
        $name = trim($match[1], '/');
        $fileUrl = "https://www.elektrodistribucija.mk/Files/Planirani-isklucuvanja-Samo-aktuelno/$name.aspx";
        $fileName = basename("$name.xlsx");

        // update this if the document can be updated
        if (Storage::disk('public')->exists($fileName)) {
            // Log some stuff or delete the file so it's re-downloaded
        }

        Storage::put("public/{$fileName}", file_get_contents($fileUrl));

        $import = new OutageImport;
        $import = Excel::import($import, $fileName, 'public', \Maatwebsite\Excel\Excel::XLSX)
            ->toArray($import, $fileName, 'public');

        return array_unique(array_column($import[0], 2));
    }
}
