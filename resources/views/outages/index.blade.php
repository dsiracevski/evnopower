<x-layout>

    <div class="flex flex-col items-center space-y-3 justify-center mb-3">
        <h1 class="md:text-2xl text-lg text-center text-blue-500 font-semibold rounded-lg shadow-lg py-2 px-4 hover:bg-blue-300">
            <a href="{{route('outages.index')}}">Планирани прекини на струја за <span class="text-amber-500">{{date('Y-m-d', strtotime($date))}}</span>
            </a>
        </h1>

        <div class="md:flex flex-row md:w-auto w-full text-sm md:space-x-3 md:space-y-0 space-y-4 shadow-lg p-2 rounded-lg items-center border-2 border-blue-50">

            <x-filter-form>

                <label for="date" class="bg-amber-300 py-1 px-3 rounded-lg border-2 border-amber-400">Дата:</label>
                <input value="{{$date}}" id="date" name="date" class="border-2 border-amber-400 rounded-lg p-1 text-sm"
                       onchange="this.form.submit()" type="date">
            </x-filter-form>

            <x-filter-form>

                <label for="area" class="bg-amber-300 py-1 px-3 rounded-lg border-2 border-amber-400">Локација:</label>
                <select id="area" name="location" onchange="this.form.submit()"
                        class="border-2 border-amber-400 bg-white rounded-lg p-1 text-sm">
                    <option value="">сите локации</option>

                    @foreach($locations as $location)

                        <option {{(request()->get('location') === $location->location) ? 'selected' : ''}} value="{{$location->location}}">{{$location->location}}</option>

                    @endforeach
                </select>
            </x-filter-form>
            <div class="flex space-x-1 place-content-around md:text-sm text-xs">
                <div class="bg-white py-1 px-1 rounded-lg border-2 border-green-400 text-center">
                    <a href="{{route('notification.choose-locations')}}">Нотификации</a>
                </div>

                @auth()
                    <div class="bg-white py-1 px-3 rounded-lg border-2 border-blue-400 text-center">
                        <a href="{{route('outages.index', ['user_id' => Auth::id()])}}">За мене</a>
                    </div>
                    <form action="{{route('logout')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div>
                            <button class="bg-white py-1 px-3 rounded-lg border-2 border-red-400 text-center">
                                Одлогирај се
                            </button>
                        </div>
                    </form>
                @endauth

                @guest()
                    <div class="bg-white py-1 px-3 rounded-lg border-2 border-blue-400 text-center">
                        <a href="{{route('login')}}">Логирај се</a>
                    </div>
                @endguest
            </div>
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
                    <input type="hidden" value="location" name="filter">
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
                <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{date('H:i:s', strtotime($outage->start))}}</div>
                <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{date('H:i:s', strtotime($outage->end))}}</div>
                <div class="p-2 col-span-2 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{$outage->location}}</div>
                <div class="p-2 col-span-8 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left  md:whitespace-normal">{{$outage->address}}</div>
            </div>

        @endforeach
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:hidden">
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

</x-layout>