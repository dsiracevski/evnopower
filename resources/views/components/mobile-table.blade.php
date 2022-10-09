<div {{ $attributes->class(['grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden']) }}>
    @foreach($outages as $outage)
        <div class="col-span-1 shadow-xl border-2 border-blue-50 bg-white space-y-3 rounded-lg p-4">
            <div class="flex items-center space-x-1">
                <div class="text-sm text-blue-700">{{$outage->location}} -</div>
                <div class="text-sm font-semibold text-black">{{date('Y-m-d', strtotime($outage->start))}}</div>
            </div>
            <div class="flex items-center space-x-1">
                <div class="text-sm text-gray-700">Прекинот ќе трае oд <span
                            class="font-semibold text-black">{{date('H:i:s', strtotime($outage->start))}}</span>
                </div>
                <div class="text-sm text-gray-700">до <span
                            class="font-semibold text-black">{{date('H:i:s', strtotime($outage->end))}}</span>
                </div>
            </div>

            <div>
                <div class="text-sm font-medium text-black">{{$outage->address}}</div>
            </div>
        </div>
    @endforeach
</div>