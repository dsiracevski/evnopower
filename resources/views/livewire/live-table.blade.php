<div class="hidden md:block space-y-2 bg-slate-300 rounded-lg p-5">
    <div class="grid grid-cols-12">
        <div wire:model.debounce.300ms="location" class="col-span-2 mr-1">
            <div class="relative">
                <x-input icon="location-marker" placeholder="{{__('Search by location')}}"
                         type="search"
                         class="border-5 border-amber-400 rounded-xl font-semibold tracking-wide"/>
            </div>
            <div class="absolute mt-2 z-50">
                @if(strlen($location) > 2)
                    <ul class="flex flex-row border-4 border-white bg-amber-300 rounded-lg border-blue-100 divide-y">
                        @forelse($searchLocations as $searchLocation)
                            <li class="flex-1 items-center px-2 py-2 transition ease-in-out duration-150">{{$searchLocation}}</li>
                        @empty
                            <li class="font-semibold tracking-wide px-2 py-2">{{__('No results found for')}} "{{$location}}"</li>
                        @endforelse
                    </ul>
                @endif
            </div>
        </div>

        <div wire:model="date" class="col-span-3">
            <label for="date" class="font-semibold tracking-wide">{{__('Search by date')}}:
                <input value="{{$date}}" id="date" name="date" class="border-5 border-amber-500 rounded-xl" type="date">
            </label>
        </div>

        <div class="flex col-span-6 place-content-end space-x-3 md:text-sm text-xs">
            <x-button teal label="{{__('Notifications')}}" href="{{route('notification.choose-locations')}}"/>
            @guest()
                <x-button teal label="{{__('Log In')}}" href="{{route('login')}}"/>
            @endguest

            @auth()

                <x-button negative label="{{__('Log Out')}}" href="{{route('logout')}}"/>
            @endauth
        </div>
    </div>
    <div class="grid grid-cols-12 gap-4 border-4 border-white bg-amber-300 rounded-lg border-blue-100">
        <div class="font-bold col-span-1 col-span-1 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
            <div sortable wire:click="sortBy('start')">
                <button type="submit">{{__('From')}}:</button>
            </div>
        </div>

        <div class="text-base col-span-1 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
            <div sortable wire:click="sortBy('end')">
                <button type="submit">
                    {{__('To')}}:
                </button>
            </div>
        </div>

        <div class="text-base col-span-1 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
            <div sortable wire:click="sortBy('cec_number')">
                <button type="submit">
                    {{__('CEC')}}:
                </button>
            </div>
        </div>

        <div class="text-base col-span-1 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
            <div sortable wire:click="sortBy('location')">
                <button type="submit">
                    {{__('Location')}}:
                </button>
            </div>
        </div>

        <div class="text-base col-span-8 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
            {{__('Address')}}:
        </div>
    </div>

    @foreach($outages as $outage)
        <div class="grid grid-cols-12 rounded-lg shadow-xl text-lg hover:font-bold hover:text-gray-900 bg-amber-300 hover:text-xl border-4 border-white">
            <div class="p-2 col-span-1 my-2 text-sm text-gray-600 text-left">{{date('H:i:s', strtotime($outage->start))}}</div>
            <div class="p-2 col-span-1 my-2 text-sm text-gray-600 text-left">{{date('H:i:s', strtotime($outage->end))}}</div>
            <div class="p-2 col-span-1 my-2 text-sm text-gray-600 text-left">{{$outage->cec_number}}</div>
            <div class="p-2 col-span-1 my-2 text-sm text-gray-600 text-left">{{$outage->location}}</div>
            <div class="p-2 col-span-8 my-2 text-sm text-gray-600 text-left  md:whitespace-normal">{{$outage->address}}</div>
        </div>
    @endforeach

    {{$outages->links()}}
</div>