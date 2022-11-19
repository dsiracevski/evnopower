<div class="mx-auto md:w-1/2 w-full">

    <form action="{{route('notification.set-locations')}}" method="POST">
        @csrf
        @method('POST')

        @guest()
            <div class="py-3 px-4 my-4 shadow-xl rounded-lg border-2 border-blue-50 md:space-y-0 space-y-2">
                <label for="email">{{__('Enter e-mail for notifications:')}}</label>

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

        <div class="md:block space-y-2 bg-slate-300 rounded-lg p-5">
            <div class="my-3 font-semibold tracking-wide">
                <span>{{__('Choose one or more locations')}}</span>
            </div>

            <div class="py-2 px-4">
                @foreach($nonSubscribedLocations as $nonsubscribedLocation)

                    <div class="inline-flex mx-1 my-1">
                        <x-button rounded info id="{{$nonsubscribedLocation->id}}"
                                  label="{{$nonsubscribedLocation->name}}"
                                  value="{{$nonsubscribedLocation->name}}"
                        />
                    </div>
                @endforeach
            </div>

            <div class="py-2 px-4">
                @foreach($subscribedLocations as $subscribedLocation)

                    <div class="inline-flex mx-1 my-1">
                        <x-button rounded info id="{{$subscribedLocation->id}}"
                                  label="{{$subscribedLocation->name}}"
                                  value="{{$subscribedLocation->name}}"
                        />
                    </div>
                @endforeach
            </div>

            <div class="flex space-x-3">

                <div class="py-1 px-4 w-max my-4 shadow-xl rounded-xl bg-blue-500">
                    <button type="submit" class="text-white">{{__('Submit')}}</button>
                </div>

                <div class="py-1 px-4 w-max my-4 shadow-xl rounded-xl bg-red-500">
                    <a href="{{route('outage.index')}}" class="text-white">{{__('Back')}}</a>
                </div>
            </div>
        </div>
        {{--</div>--}}
    </form>
</div>
