@extends('Back.layouts.master')

@section('title', trans('back.reports'))

@section('style')
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/plugins/notifications/jgrowl.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/plugins/ui/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/plugins/pickers/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/plugins/pickers/anytime.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/plugins/pickers/pickadate/picker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/plugins/pickers/pickadate/picker.date.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/plugins/pickers/pickadate/picker.time.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/plugins/pickers/pickadate/legacy.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/admin/assets/js/pages/picker_date.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".btnPrint").printPage();
        });
    </script>
@stop

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4>
                    <i onClick="window.history.go(-1);" style="cursor: pointer;" class="icon-arrow-right6 position-left"></i>
                    <span class="text-semibold">@lang('back.home')</span> - @lang('back.reports')
                </h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb" style="float: {{ floating('right','left') }};">
                <li><a href="{{ route('admin-panel') }}"><i class="icon-home2 position-left"></i> @lang('back.home')</a></li>
                <li class="active">@lang('back.reports')</li>
            </ul>

            @include('Back.includes.quick-links')
        </div>
    </div>
    <!-- /page header -->
    <div class="content">
    	<div class="row">
    		<div class="col-md-12">

                <!-- Basic table -->
{{--                 <div class="panel panel-flat">
                    <div class="panel-heading">@lang('back.reports')</div>
                    <div class="panel-body">
                        <div class="well">
                            <form action="#">
                                <div class="form-group">
                                    <label class="display-block text-semibold">@lang('back.select-a-value')</label>
                                    <label class="radio-inline">
                                        <input type="radio" value="markets" name="radio-inline-left" class="styled" checked="checked">
                                        @lang('back.markets')
                                    </label>

                                    <label class="radio-inline">
                                        <input type="radio" value="delegates" name="radio-inline-left" class="styled">
                                        @lang('back.delegates')
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <!-- /basic table -->

                <!-- Basic table -->
                <div class="panel panel-flat" id="markets-report">
                    <div class="panel-heading">@lang('back.var-report',['var'=>trans('back.markets')])</div>
                    <div class="panel-body">
						<div class="well">
                            <form method="POST" action="{{ route('reports.get-markets-report') }}" id="form-markets-reports">
                                @csrf
                                <div class="row" dir="{{ direction() }}">
                                    <div class="col-sm-6" style="float: {{ floating('right', 'left') }};">
                                        <div class="form-group">
                                            <label>@lang('back.form-date-from')</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input type="text" name="date-from" value="" class="form-control daterange-single">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" style="float: {{ floating('left', 'right') }};">
                                        <div class="form-group">
                                            <label>@lang('back.form-date-to')</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input type="text" name="date-to" value="" class="form-control daterange-single">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="submit" name="submit" class="btn btn-primary" value="@lang('back.submit')">
                                    </div>
                                </div>
                            </form>
						</div>
                        <br>
                        <br>
                    </div>
                </div>
                <!-- /basic table -->

                <!-- Basic table -->
{{--                 <div class="panel panel-flat" id="delegates-report" style="display: none;">
                    <div class="panel-heading">@lang('back.var-report',['var'=>trans('back.delegates')])</div>
                    <div class="panel-body">
                        <div class="well">
                            <form id="form-delegates-reports">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('back.form-date-from')</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input type="text" name="date-from" class="form-control form-data daterange-single" value="{{ date('m/d/Y') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>@lang('back.form-date-to')</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="icon-calendar22"></i></span>
                                                <input type="text" name="date-to" class="form-control form-data daterange-single" value="{{ date('m/d/Y') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="submit" name="submit" class="btn btn-primary" value="@lang('back.submit')">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
                <!-- /basic table -->
    		</div>
    	</div>
    </div>
@stop

@section('scripts')
<script>
    // $('#form-markets-reports').on('submit', function(e)
    // {
        // e.preventDefault();

        // var data = {
        //     date_from: $('input[name=date-from]').val(),
        //     date_to: $('input[name=date-to]').val(),
        //     _token: $('input[name=_token]').val()
        // };

        // $('#markets-table-report').html('');

        // $.ajax({
        //     type: 'POST',
        //     url: '{{-- route('get-markets-report') --}}',
        //     data: data,
        //     success: function(response)
        //     {
        //         if(response.status)
        //         {
        //             $('#markets-report-res').show();
        //             var markets = response.markets;

        //             if(markets.length > 0)
        //             {
        //                 $.each(markets, function(index, el){
        //                     $('#markets-table-report').append(`
        //                         <tr>
        //                             <td>${el.id}</td>
        //                             <td>${el.name}</td>
        //                             <td>${el.phone}</td>
        //                             <td>${el.subscribe_no}</td>
        //                             <td>${el.start_time}</td>
        //                             <td>${el.end_time}</td>
        //                             <td>${el.delegate_identity}</td>
        //                             <td>${el.created_at}</td>
        //                             <td>${el.payed_at}</td>
        //                             <td>${el.expired_at}</td>
        //                         </tr>
        //                     `);
        //                 });
        //             }
        //             else
        //             {
        //                 $('#markets-table-report').append(`
        //                     <tr><td colspan="10"><div class="alert alert-info text-center">@lang('back.no-value')</div></td></tr>
        //                 `);
        //             }
        //         }
        //     },
        //     error: (e) => crud_handle_server_errors(e),
        // });
    // });

    // $('#form-delegates-reports').on('submit', function(e)
    // {
    //     e.preventDefault();

    //     var date_from = $('input[name=date-from]').val();
    //     var date_to   = $('input[name=date-to]').val();
    //     var _token    = $('input[name=_token]').val();

        // $.ajax({
        //     type: 'POST',
        //     url: '{{-- route('get-markets-report') --}}',
        //     data: { id: id, value: value },
        //     success: function(response) {
        //         var dialog = bootbox.dialog({
        //             message: '<p class="text-center">'+response.message+'</p>',
        //             closeButton: false
        //         });
        //         setTimeout(function(){ dialog.modal('hide'); }, 1000);
        //     },
        //     error: function(e) {
        //         console.error(e);
        //     }
        // });
    // });

    // $('input[name=radio-inline-left]').change(function()
    // {
    //     if($(this).is(":checked"))
    //     {
    //         if($(this).val() == "markets")
    //         {
    //             $('#markets-report').show();
    //             $('#delegates-report').hide();
    //         }
    //         else
    //         {
    //             $('#markets-report').hide();
    //             $('#delegates-report').show();
    //         }
    //     }
    // });
</script>
@stop
