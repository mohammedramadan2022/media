@props(['justified' => false])

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-flat">
            <div class="panel-body">
                <ul class="nav nav-tabs {{ $justified ? 'nav-justified' : '' }}">
                    {{ $nav }}
                </ul>
                <div class="tabbable">
                    <div class="tab-content">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
