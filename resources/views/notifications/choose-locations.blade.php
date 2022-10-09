<x-layout>

    <div class="mx-auto md:w-1/2 w-full">

        <form action="{{route('notification.set-locations')}}" method="POST">
            @csrf
            @method('POST')

            @guest()
                <div class="py-3 px-4 my-4 shadow-xl rounded-lg border-2 border-blue-50 md:space-y-0 space-y-2">
                    <label for="email">Внесете e-mail за нотификации: </label>

                    <input id="email" type="email" value="" name="email"
                           class="px-2 border-2 border-blue-300 rounded-lg"
                           required>

                    @error('email')
                    <div class="text-red-500 text-sm">{{$message}}</div>
                    @enderror
                </div>
            @endguest

            @auth()
                <input type="email" value="{{auth()->user()->email}}" name="email" hidden>
            @endauth

            <div class="space-y-3 py-3 px-4 my-4 shadow-xl rounded-lg border-2 border-blue-50">
                <div class="my-3 ">
                    <span>Изберете една или повеќе локации:</span>
                </div>

                <div class="py-2 px-4">

                    @foreach($locations as $location)

                        <div class="inline-flex mx-1 my-1">
                            @if(in_array($location->id, $userLocations, true))
                                <div class="py-2 px-5 rounded-full text-sm bg-white w-max cursor-pointer border-2 bg-amber-500">
                                    @else
                                        <div class="py-2 px-5 rounded-full text-sm bg-white w-max cursor-pointer border-2 border-amber-500">
                                            @endif
                                            <label class="cursor-pointer"
                                                   for="{{$location->id}}">{{$location->name}}</label>
                                            <input class="cursor-pointer"
                                                   @checked(in_array($location->id, $userLocations, true))
                                                   id="{{$location->id}}" type="checkbox" name="location[]"
                                                   value="{{$location->id}}">
                                        </div>
                                </div>
                                @endforeach
                        </div>

                        <div class="flex space-x-3">

                            <div class="py-1 px-4 w-max my-4 shadow-xl rounded-xl bg-blue-500">
                                <button type="submit" class="text-white">Прати</button>
                            </div>

                            <div class="py-1 px-4 w-max my-4 shadow-xl rounded-xl bg-red-500">
                                <a href="{{url()->previous()}}" class="text-white">Назад</a>
                            </div>
                        </div>
                </div>
            </div>
        </form>
    </div>
</x-layout>