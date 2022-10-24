<x-layout>
    <div class="flex flex-col items-center space-y-3 justify-center mb-3">
        <h1 class="md:text-2xl text-lg text-center text-blue-500 font-semibold rounded-lg shadow-lg py-2 px-4 hover:bg-blue-300">
            <a href="{{route('outage.index')}}">Планирани прекини на струја за <span
                        class="text-amber-500">{{date('Y-m-d', strtotime($date))}}</span>
            </a>
        </h1>

        <div class="md:flex flex-row md:w-auto w-full text-sm md:space-x-3 md:space-y-0 space-y-4 shadow-lg p-2 rounded-lg items-center border-2 border-blue-50">
            <form action="{{route('outage.index')}}" method="GET">
                @csrf
                <label for="date" class="bg-amber-300 py-1 px-3 rounded-lg border-2 border-amber-400">Дата:</label>
                <input value="{{$date}}" id="date" name="date" class="border-2 border-amber-400 rounded-lg p-1 text-sm"
                       onchange="this.form.submit()" type="date">
                <label for="area" class="bg-amber-300 py-1 px-3 rounded-lg border-2 border-amber-400">Локација:</label>
                <select id="area" name="location" onchange="this.form.submit()"
                        class="border-2 border-amber-400 bg-white rounded-lg p-1 text-sm">
                    <option value="">сите локации</option>
                    @foreach($locations as $location)
                        <option {{(request()->get('location') === $location['name']) ? 'selected' : ''}} value="{{$location['name']}}">{{$location['name']}}</option>
                    @endforeach
                </select>
            </form>

            <div class="flex space-x-1 place-content-around md:text-sm text-xs">
                <div class="bg-white py-1 px-1 rounded-lg border-2 border-green-400 text-center">
                    <a href="{{route('notification.choose-locations')}}">Нотификации</a>
                </div>

                @auth()
                    <div class="bg-white py-1 px-3 rounded-lg border-2 border-blue-400 text-center">
                        <a href="{{route('outage.index', ['user_id' => Auth::id()])}}">За мене</a>
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
    <x-table :outages="$plannedOutages"/>

    <x-mobile-table :outages="$plannedOutages"/>

</x-layout>