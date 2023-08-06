@if($actives > 0 || $deductives > 0)
    <script>
        Morris.Donut({
            element: "{{$htmlID}}",
            data: [
                {
                    label: "{{ trans('back.active') }}",
                    value: {{$actives}}
                },
                {
                    label: "{{ trans('back.disactive') }}",
                    value: {{$deductives}}
                },
            ],
            barSize: 0.2,
            resize: !0,
            colors: ["#5f634a", "#8C9173"]
        });
    </script>

@endif
