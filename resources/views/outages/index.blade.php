<x-layout>

    <div class="lg:px-24 px-6 md:py-8 p-4 mx-auto min-h-screen bg-white">
        <div class="flex flex-col items-center space-y-3 justify-center mb-3">

            <h1 class="md:text-2xl text-lg text-center text-blue-500 font-semibold rounded-lg shadow-lg py-2 px-4">
                Планирани прекини на струја за <span class="text-amber-500">{{date('Y-m-d', strtotime($date))}}</span>
            </h1>

            <div class="md:flex flex-row md:w-auto w-full text-sm md:space-x-3 md:space-y-0 space-y-4 shadow-lg p-2 rounded-lg items-center border-2 border-blue-50">

                <x-filter-form>

                    <label for="date" class="bg-amber-300 py-1 px-3 rounded-lg">Дата:</label>
                    <input value="{{$date}}" id="date" name="date" class="border-2 border-amber-300 rounded-lg p-1" onchange="this.form.submit()" type="date">
                </x-filter-form>

                <x-filter-form>

                    <label for="area" class="bg-amber-300 py-1 px-3 rounded-lg">Локација:</label>
                    <select id="area" name="area" onchange="this.form.submit()" class="border-2 border-amber-300 bg-white rounded-lg p-1">
                        <option value="">сите локации</option>

                        @foreach($areas as $area)

                            <option {{(request()->get('area') === $area->area) ? 'selected' : ''}} value="{{$area->area}}">{{$area->area}}</option>

                        @endforeach
                    </select>
                </x-filter-form>
            </div>
        </div>
        <div class="hidden md:block space-y-4">
            <div class="grid grid-cols-12 gap-4 border-2 bg-amber-300 rounded-lg border-blue-50">
                <div class="text-base col-span-1 col-span-1 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">

                    <x-filter-form>
                        <input type="hidden" value="start" name="filter">
                        <button type="submit">Од:</button>
                    </x-filter-form>
                </div>

                <div class="text-base col-span-1 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
                    <x-filter-form>
                        <input type="hidden" value="end" name="filter">
                        <button type="submit">
                            До:
                        </button>
                    </x-filter-form>
                </div>

                <div class="text-base col-span-2 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
                    <x-filter-form>
                        <input type="hidden" value="area" name="filter">
                        <button type="submit">
                            Локација:
                        </button>
                    </x-filter-form>
                </div>

                <div class="text-base col-span-8 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">Адреса:
                </div>
            </div>

            @foreach($outages as $outage)
                <div class="grid grid-cols-12 rounded-lg shadow-lg hover:bg-amber-300 hover:text-lg odd:bg-gray-100 even:bg-white border-2 border-blue-50">
                    <div class="p-2 col-span-1 my-2 text-sm hover:text-lg hover:text-gray-900 text-gray-600 text-left">{{date('H:i:s', strtotime($outage->start))}}</div>
                    <div class="p-2 col-span-1 my-2 text-sm hover:text-lg hover:text-gray-900 text-gray-600 text-left">{{date('H:i:s', strtotime($outage->end))}}</div>
                    <div class="p-2 col-span-2 my-2 text-sm hover:text-lg hover:text-gray-900 text-gray-600 text-left">{{$outage->area}}</div>
                    <div class="p-2 col-span-8 my-2 text-sm hover:text-lg hover:text-gray-900 text-gray-600 text-left  md:whitespace-normal">{{$outage->address}}</div>
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


</x-layout>