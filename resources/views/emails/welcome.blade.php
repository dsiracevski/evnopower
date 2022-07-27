@component('mail::message')
# Добредојдовте!

Добредојдовте на EVNoPower. Вашиот профил е автоматски генериран (лозинката е првиот дел од Вашиот email).

Ќе примате нотификации за:

@foreach($locations as $location)
    - {{$location->name}}
@endforeach

@component('mail::button', ['url' => ''])
Промени
@endcomponent

Поздрав,<br>
{{ config('app.name') }}
@endcomponent
