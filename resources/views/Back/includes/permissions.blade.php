<div class="row">
    @foreach($getAllRoutes as $key => $value)
        @continue($value == 'admin-panel' || $value == 'search')
        @if(is_array($value))
            @php $chunks = array_chunk($value, 7); @endphp
            @php $uuid = uuid(); @endphp
            <div class="col-md-4 col-xs-12">
                <div class="card border main-border-color">
                    <div class="card-body" style="min-height: 626px;">
                        <h4 class="card-title text-secondary"><b>@lang('crud.' . $key . '.' . $key)</b></h4>
                        @if(count($chunks) > 1)
                            <ul class="nav nav-tabs">
                                @foreach($chunks as $ck => $xx)
                                    <li class="nav-item">
                                        <a href="#fields-{{$ck.$uuid}}" data-toggle="tab" aria-expanded="false" class="nav-link {{ $loop->first ? 'active' : '' }}">
                                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                            <span class="d-none d-sm-block">{{ trans('back.page-number', ['var' => $ck + 1]) }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="tab-content">
                            @foreach($chunks as $ii => $chunk)
                                <div role="tabpanel" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="fields-{{$ii.$uuid}}">
                                    @foreach ($chunk as $keys => $field)
                                        <x-permission-list-item :role="$role" :val="$field" :k="$ii.$uuid.$keys"></x-permission-list-item>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-4 col-xs-12">
                <div class="card border main-border-color" >
                    <div class="card-body" style="min-height: 626px;">
                        <h3 class="card-title text-secondary"><b>@lang('crud.' . $value)</b></h3>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a href="#fields-name-{{$key}}" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">{{ trans('back.page-number', ['var' => 1]) }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="fields-name-{{$key}}">
                                <x-permission-item :role="$role" :value="$value" :key="$key"></x-permission-item>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
