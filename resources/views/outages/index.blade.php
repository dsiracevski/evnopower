<x-layout>

    <div class="lg:px-24 px-6 md:py-8 p-4 mx-auto min-h-screen bg-white">
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
        <div class="hidden md:block space-y-4">
            <div class="grid grid-cols-12 gap-4 border-2 bg-amber-300 rounded-lg border-blue-50">
                <div class="text-base col-span-1 col-span-1 p-4 rounded-lg font-semibold tracking-wide text-left">

                    <x-filter-form>
                        <input type="hidden" value="start" name="filter">
                        <button type="submit">Од:</button>
                    </x-filter-form>
                </div>

                <div class="text-base col-span-1 p-4 rounded-lg font-semibold tracking-wide text-left">
                    <x-filter-form>
                        <input type="hidden" value="end" name="filter">
                        <button type="submit">
                            До:
                        </button>
                    </x-filter-form>
                </div>

                <div class="text-base col-span-2 p-4 rounded-lg font-semibold tracking-wide text-left">
                    <x-filter-form>
                        <input type="hidden" value="area" name="filter">
                        <button type="submit">
                            Област:
                        </button>
                    </x-filter-form>
                </div>

                    <div class="text-base col-span-8 p-4 rounded-lg font-semibold tracking-wide text-left">Адреса:</div>
            </div>

            @foreach($outages as $outage)
                <div class="grid grid-cols-12  rounded-lg shadow-lg hover:bg-amber-300 odd:bg-gray-100 even:bg-white border-2 border-blue-50">
                    <div class="p-2 col-span-1 my-2 text-sm text-gray-700 text-left">{{date('H:i:s', strtotime($outage->start))}}</div>
                    <div class="p-2 col-span-1 my-2 text-sm text-gray-700 text-left">{{date('H:i:s', strtotime($outage->end))}}</div>
                    <div class="p-2 col-span-2 my-2 text-sm text-gray-700 text-left">{{$outage->area}}</div>
                    <div class="p-2 col-span-8 my-2 text-sm text-gray-700 text-left  md:whitespace-normal">{{$outage->address}}</div>
                </div>

            @endforeach
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
            @foreach($outages as $outage)
                <div class="col-span-1 shadow-xl border-2 border-blue-50 bg-white space-y-3 rounded-lg p-4">
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
    </div>

</x-layout>