<x-layout>
    <h1>Chart should be under me</h1>
    <canvas id="outageChart" height="100px"></canvas>

</x-layout>
@pushOnce('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.js"></script>

<script>
    {{--let labels = {{ Js::from($labels) }};--}}
    {{--let outages = {{ Js::from($data) }};--}}
console.log('1212')
    let data = {
        labels: ['one', 'two', 'three'],
        datasets: [{
            label: 'Ehhhhhhh',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [1, 2, 3],
        }]
    };

    let config = {
        type: 'line',
        data: data,
        options: {}
    };

    let myChart = new Chart(
        document.getElementById('outageChart'),
        config
    );
</script>
@endPushOnce

