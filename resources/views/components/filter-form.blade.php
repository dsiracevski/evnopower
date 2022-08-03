<form action="{{route('outages.index')}}" method="GET">
    @csrf

    {{$slot}}

</form>