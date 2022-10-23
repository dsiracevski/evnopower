<div class="hidden md:block space-y-4">
    <div class="grid grid-cols-12">
        <div wire:model="search" class="col-span-3">
            <label class="font-semibold tracking-wide">{{__('Search by city')}}:
                <input type="text" class="border-5 border-amber-400 rounded-xl">
            </label>
        </div>
        <div wire:model="date" class="col-span-3">
            <label for="date" class="font-semibold tracking-wide">{{__('Search by date')}}:
                <input value="{{$date}}" id="date" name="date" class="border-5 border-amber-400 rounded-xl" type="date">
            </label>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-4 border-2 bg-amber-300 rounded-lg border-blue-50">
        <div class="text-base col-span-1 col-span-1 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
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
        <div wire:key="{{$outage->id}}"
             class="grid grid-cols-12 rounded-lg shadow-lg hover:bg-amber-300 hover:text-lg odd:bg-gray-100 even:bg-white border-2 border-blue-50">
            <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{date('H:i:s', strtotime($outage->start))}}</div>
            <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{date('H:i:s', strtotime($outage->end))}}</div>
            <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{$outage->cec_number}}</div>
            <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{$outage->location}}</div>
            <div class="p-2 col-span-8 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left  md:whitespace-normal">{{$outage->address}}</div>
        </div>
    @endforeach

    {{$outages->links()}}

</div>