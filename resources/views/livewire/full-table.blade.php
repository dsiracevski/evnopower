<div {{ $attributes->class(['hidden md:block space-y-4']) }}>
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

        <div class="text-base col-span-1 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
            <x-filter-form>
                <input type="hidden" value="cec_number" name="filter">
                <button type="submit">
                    КЕЦ:
                </button>
            </x-filter-form>
        </div>

        <div class="text-base col-span-1 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
            <x-filter-form>
                <input type="hidden" value="location" name="filter">
                <button type="submit">
                    Локација:
                </button>
            </x-filter-form>
        </div>

        <div class="text-base col-span-8 py-4 px-2 rounded-lg font-semibold tracking-wide text-left">
            Адреса:
        </div>
    </div>

    @foreach($outages as $outage)
        <div class="grid grid-cols-12 rounded-lg shadow-lg hover:bg-amber-300 hover:text-lg odd:bg-gray-100 even:bg-white border-2 border-blue-50">
            <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{date('H:i:s', strtotime($outage->start))}}</div>
            <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{date('H:i:s', strtotime($outage->end))}}</div>
            <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{$outage->cec_number}}</div>
            <div class="p-2 col-span-1 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left">{{$outage->location}}</div>
            <div class="p-2 col-span-8 my-2 text-sm hover:font-bold hover:text-gray-900 text-gray-600 text-left  md:whitespace-normal">{{$outage->address}}</div>
        </div>
    @endforeach

    <div>
        {{$outages->links()}}
    </div>
</div>