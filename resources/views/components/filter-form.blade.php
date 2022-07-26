<form action="{{route('outage.index')}}" method="GET">
    @csrf

    {{$slot}}

</form>