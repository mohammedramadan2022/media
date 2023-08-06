@foreach($specs as $i => $spec)
    @if($spec['spec']['type'] == 'select')
        <div class="form-group">
            <x-form.select-input
                :arr="$spec['options']"
                name="options[]"
                :slug="$spec['spec']['name']"
                :selected="isset($currentModel) ? $currentModel->options->whereIn('optionable_id', array_keys($spec['options']))->first()->optionable_id : null"
            ></x-form.select-input>
        </div>
    @elseif($spec['spec']['type'] == 'text')
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input
                    type="checkbox"
                    onchange="$(this).val($(this).val() === '0' ? '1' : '0');"
                    name="specs[{{ $spec['spec']['id'] }}]"
                    {{ isset($currentModel) ? ($currentModel->specs->where('optionable_id', $spec['spec']['id'])->first()->optionable_id ? 'checked' : '') : '' }}
                    value="{{ isset($currentModel) ? ($currentModel->specs->where('optionable_id', $spec['spec']['id'])->first()->optionable_id ? '1' : '0') : '0' }}"
                    class="custom-control-input form-data"
                    id="customSwitch-{{ $spec['spec']['id'] }}">
                <label class="custom-control-label" for="customSwitch-{{ $spec['spec']['id'] }}">{{ $spec['spec']['name'] }}</label>
            </div>
        </div>
    @elseif($spec['spec']['type'] == 'boolean')
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input
                    type="checkbox"
                    onchange="$(this).val($(this).val() === '0' ? '1' : '0');"
                    name="specs[{{ $spec['spec']['id'] }}]"
                    {{ isset($currentModel) ? (optional($currentModel->specs->where('optionable_id', $spec['spec']['id'])->first())->optionable_id ? 'checked' : '') : '' }}
                    value="{{ isset($currentModel) ? (optional($currentModel->specs->where('optionable_id', $spec['spec']['id'])->first())->optionable_id ? '1' : '0') : '0' }}"
                    class="custom-control-input form-data"
                    id="customSwitch{{ $spec['spec']['id'] }}">
                <label class="custom-control-label" for="customSwitch{{ $spec['spec']['id'] }}">{{ $spec['spec']['name'] }}</label>
            </div>
        </div>
    @endif
@endforeach
