<div class="card" style="margin-top:20px;">
    <div class="card-header">
        <div class="level">
            <span class="flex">
                {{ $heading }}
            </span>
        </div>
    </div>
    @isset($body)
        <div class="card-body trix-content">
            {!! $body !!}
        </div>
    @endisset
</div>