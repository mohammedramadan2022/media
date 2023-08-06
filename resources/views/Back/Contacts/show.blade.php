<x-model-show-element :title="$contact->name" model="contact" nameSpace="back">
    <div class="col-md-12">
        <div class="card border main-border-color">
            <div class="card-header main-background-color text-white">@lang('back.contacts.t-contact')</div>
            <div class="card-body">
                @include('includes.flash')
                <div class="row">
                    <div class="col-md-12">
                        <div class="well">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-name')</h4>
                                    <h5>{{ $contact->name ?? trans('back.no-value') }}</h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-email')</h4>
                                    <h5>{{ $contact->email ?? trans('back.no-value') }}</h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-phone')</h4>
                                    <h5>{{ $contact->phone ?? trans('back.no-value') }}</h5>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.form-message')</h4>
                                    <p>{{ $contact->message ?? trans('back.no-value') }}</p>
                                </li>

                                <li class="list-group-item">
                                    <h4 class="text-muted">@lang('back.since')</h4>
                                    <h5>{{ $contact->since }}</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-model-show-element>
