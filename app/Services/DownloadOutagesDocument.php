<?php

namespace App\Services;

use App\Imports\OutageImport;
use Illuminate\Support\Facades\Log;
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

        //Check if file has been downloaded yet
        if (Storage::exists("public/$fileName")) {
            Log::info("The file has not been updated yet!");
        }

        Storage::put("public/$fileName", file_get_contents($this->fileUrl));

        $import = new OutageImport;
        $import = Excel::import($import, $fileName, 'public', \Maatwebsite\Excel\Excel::XLSX)
            ->toArray($import, $fileName, 'public');

        return array_unique(array_column($import[0], 2));
    }

    /**
     * The document name is the md5 hash of the file contents, in case of an unscheduled update
     * @return string
     */
    private function getFileName(): string
    {
        $url = "https://www.elektrodistribucija.mk/Grid/Planned-disconnections.aspx";
        preg_match('/Planirani-isklucuvanja-Samo-aktuelno(.*?).aspx/', file_get_contents($url), $match);
        $name = trim($match[1], '/');
        $this->fileUrl = "https://www.elektrodistribucija.mk/Files/Planirani-isklucuvanja-Samo-aktuelno/$name.aspx";

        return basename(md5_file($this->fileUrl));
    }
}
