@forelse($chunk as $i => $type)
    <div class="col-xs-12">
        <div class="card-box border-top-success">
            <div class="card-body">
                @foreach($settings->where('type', $type)->sortBy('input') as $setting)
                    @include('Back.includes.settingsInput', compact('setting'))
                    @if($setting->input == 4)
                        <script>
                            CKEDITOR.replace('{{ $setting->key }}', { height: '400px', extraPlugins: 'forms' });
                            CKEDITOR.instances.{{$setting->key}}.setData(`{!! isset($setting) ? $setting->value : '' !!}`);
                        </script>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-info">{{ trans('back.no-var', ['var' => trans('back.settings')]) }}</div>
@endforelse
