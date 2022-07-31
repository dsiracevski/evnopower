<?php

namespace App\Services;

use App\Imports\OutageImport;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DownloadOutagesDocument
{
    protected $fileUrl;

    /**
     * @return array
     */
    public function handle(): mixed
    {
        $fileName = $this->getFileName();
        $fileName .= ".xlsx";

//        dd($fileName);
        if (Storage::exists("public/{$fileName}")) {
            return "It's here already!";
        }
        Storage::put("public/{$fileName}", file_get_contents($this->fileUrl));

        $import = new OutageImport;
        $import = Excel::import($import, $fileName, 'public', \Maatwebsite\Excel\Excel::XLSX)
            ->toArray($import, $fileName, 'public');

        return array_unique(array_column($import[0], 2));
    }

    private function getFileName()
    {
        $url = "https://www.elektrodistribucija.mk/Grid/Planned-disconnections.aspx";
        preg_match('/Planirani-isklucuvanja-Samo-aktuelno(.*?).aspx/', file_get_contents($url), $match);
        $name = trim($match[1], '/');
        $this->fileUrl = "https://www.elektrodistribucija.mk/Files/Planirani-isklucuvanja-Samo-aktuelno/$name.aspx";

        return basename(md5_file($this->fileUrl));
    }
}
