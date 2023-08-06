<script>
    var el_{{$counter}} = '{{ $el }}';
    // Initialize chart
    google.load("visualization", "1", {packages:["corechart"]});

    google.setOnLoadCallback(function() {
        // Data
        var data = google.visualization.arrayToDataTable([
            ['Language', 'Speakers (in millions)'],
            ['@lang('back.active')', {{ $active }}],
            ['@lang('back.disactive')', {{ $disactive }}],
        ]);

        // Instantiate and draw our chart, passing in some options.
        var donut_exploded = new google.visualization.PieChart($('#'+el_{{$counter}})[0]);

        donut_exploded.draw(data, {
            fontName: 'Roboto',
            height: 300,
            width: 420,
            chartArea: {
                left: 50,
                width: '90%',
                height: '90%'
            },
            pieHole: 0.5,
            pieSliceText: 'label',
            slices: {
                2: {offset: 0.15},
                8: {offset: 0.1},
                10: {offset: 0.15},
                11: {offset: 0.1}
            }
        });
    });
</script>
