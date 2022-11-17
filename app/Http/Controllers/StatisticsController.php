<?php

namespace App\Http\Controllers;

use App\Services\OutageService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function __construct(private OutageService $outageService)
    {
    }

    public function index()
    {
        $graphData = $this->outageService->outagesGraphData();
        $labels = $graphData->keys();
        $data = $graphData->values();


        return view('outages.statistics')->with(compact('graphData', 'labels', 'data'));
    }
}
