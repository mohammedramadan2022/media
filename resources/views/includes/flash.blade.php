@if(session()->has('danger'))
    <div class="alert alert-danger text-center">{{ session('danger') }}</div>
@endif
@if(session()->has('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
@endif
@if(session()->has('warning'))
    <div class="alert alert-warning text-center">{{ session('warning') }}</div>
@endif

<div id="ajax-messages"></div>
