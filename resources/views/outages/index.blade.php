<!doctype html>
<html lang="mk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVNoPower</title>
    @vite('resources/css/app.css')
</head>
<body>

    <div class="md:px-52 md:py-8 p-4 mx-auto min-h-screen bg-gray-200">
        <div class="flex flex-col items-center space-x-3 justify-center mb-3">
            <h1 class="md:text-xl text-lg text-blue-500 font-semibold">Планирани прекини на струја</h1>
            <div class="lowercase text-sm">
                <form action="{{route('outage.index')}}" method="GET">
                    @csrf
                    <label for="filter">Подреди по:</label>
                    <select onchange="this.form.submit()" name="filter" class="text-amber-500" id="">
                        <option value="" class="bg-white">избери опција</option>
                        <option value="start" class="bg-white">почеток</option>
                        <option value="end" class="bg-white">крај</option>
                        <option value="area" class="bg-white">област</option>
                        <option value="address" class="bg-white">адреса</option>
                    </select>
                </form>
            </div>
        </div>
        <div class="overflow-auto rounded-lg hidden md:block">
            <table class="w-full">
                <thead class="border-b-2 bg-gray-50 border-blue-200">
                <tr>
                    <th class="p-3 text-base font-semibold tracking-wide text-left">Дата:</th>
                    <th class="p-3 text-base font-semibold tracking-wide text-left">Од:</th>
                    <th class="p-3 text-base font-semibold tracking-wide text-left">До:</th>
                    <th class="p-3 text-base font-semibold tracking-wide text-left">Област:</th>
                    <th class="p-3 text-base font-semibold tracking-wide text-left">Адреса:</th>
                </tr>
                </thead>
                <tbody class="divide-y-4 divide-gray-200 bg-white">
                @foreach($outages as $outage)
                    <tr>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{date('Y-m-d', strtotime($outage->start))}}</td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{date('H:i:s', strtotime($outage->start))}}</td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{date('H:i:s', strtotime($outage->end))}}</td>
                        <td class="p-3 text-sm text-gray-700 whitespace-nowrap">{{$outage->area}}</td>
                        <td class="p-3 text-sm text-gray-700 md:whitespace-normal whitespace-nowrap w-max">{{$outage->address}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
            @foreach($outages as $outage)
                <div class="bg-white space-y-3 rounded-lg p-4">
                    <div class="flex items-center space-x-1">
                        <div class="text-sm text-blue-700">{{$outage->area}} -</div>
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
    </div>

</body>
</html>