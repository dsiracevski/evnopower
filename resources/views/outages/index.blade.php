<x-layout>
    <div class="flex flex-col items-center space-y-3 justify-center mb-3">
        <h1 class="md:text-2xl text-lg text-center text-blue-500 font-semibold rounded-lg shadow-lg py-2 px-4 hover:bg-blue-300">
            <a href="{{route('outage.index')}}">{{__('Planned outages for')}} <span
                        class="text-amber-500">{{date('Y-m-d', strtotime($date))}}</span>
            </a>
        </h1>
    </div>

    <livewire:live-table/>

{{--    <x-mobile-table :outages="$plannedOutages"/>--}}

</x-layout>