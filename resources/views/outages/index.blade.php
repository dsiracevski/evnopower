<x-layout>
    <div class="flex flex-col items-center space-y-3 justify-center mb-3">
        <button class="md:text-3xl text-lg text-center text-blue-500 font-bold rounded-lg shadow-lg py-2 px-4">
            EV<span class="text-red-500 font-bolder tracking-wide ">No</span>Power
        </button>
    </div>

    <livewire:live-table/>

    {{--    <x-mobile-table :outages="$plannedOutages"/>--}}

</x-layout>