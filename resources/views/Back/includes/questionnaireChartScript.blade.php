<script>
    Morris.Donut({
        element: "{{ $name }}",
        data: [
            {
                label: "{{ trans('back.satisfied') }}",
                value: {{ $satisfied }}
            },
            {
                label: "{{ trans('back.not_satisfied') }}",
                value: {{ $not_satisfied }}
            },
            {
                label: "{{ trans('back.very-satisfied') }}",
                value: {{ $very_satisfied }}
            },
        ],
        barSize: 0.2,
        resize: !0,
        colors: ["#ffae00", "#e6224f", "#4aba00"]
    });
</script>
