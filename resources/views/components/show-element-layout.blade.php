@props(['title', 'model', 'nameSpace'])

<x-model-show-element :title="$title" :model="$model" :nameSpace="$nameSpace">
    <div class="col-md-12">
        <div class="card border main-border-color">
            <div class="card-header main-background-color text-white">@lang('back.'.plural($model).'.t-'.$model)</div>
            <div class="card-body">
                @include('Back.includes.flash')
                {{ $slot }}
            </div>
        </div>
    </div>

    {{ $other ?? '' }}

    <x-slot name="scripts">
        {{ $scripts ?? '' }}
    </x-slot>
</x-model-show-element>
