@component('mail::message')
# Планирани прекини на струја за {{$user->name}}

Добар ден. Ја добивате оваа порака бидејќи има планирани прекини на струја за:

@foreach($outages as $outage)
    - {{$outage->location}}
    - {{$outage->start}}
    - {{$outage->end}}
    - {{$outage->address}}

@endforeach

@component('mail::button', ['url' => ''])
Види ги сите
@endcomponent

Наполнете ги телефоните,<br>
{{ config('app.name') }}
@endcomponent
