<div class="card border main-border-color" >
    <div class="card-header main-background-color text-white">{{ $title }}</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                {{ $slot }}
            </table>
        </div>
    </div>
</div>
