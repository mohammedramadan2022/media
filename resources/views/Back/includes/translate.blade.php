<x-translation-input-tabs>
    <x-slot name="nav">
        @foreach(config('sitelangs.langs') as $lang)
            <li class="nav-item">
                <a href="#fields-{{ $lang['locale'] }}" data-toggle="tab" aria-expanded="false" class="nav-link {{ $loop->first ? 'active' : '' }}">
                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                    <span class="d-none d-sm-block nav-tab-title-js">
                        <img style="width: 18px;" src="{{ asset_url('admin/images/'.$lang['locale'].'.png') }}" alt="@lang('back.'.$lang['locale'])"/>
                    </span>
                </a>
            </li>
        @endforeach
    </x-slot>
    @foreach(config('sitelangs.langs') as $lang)
        <div role="tabpanel" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="fields-{{ $lang['locale'] }}">
            @foreach (app($model)->fields as $key => $field)
                @include('Back.components.langInput', [
                    'name'  => $field['name'],
                    'type'  => $field['type'],
                    'trans' => $field['trans'],
                    'lang'  => $lang,
                    'other' => $others ?? '',
                    'class' => 'col-xs-12'
                ])
            @endforeach
        </div>
    @endforeach
</x-translation-input-tabs>
