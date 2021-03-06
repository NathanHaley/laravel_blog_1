<div class="p-3">
    <h4 class="font-italic">{{ $heading }} </h4>
    <ol class="list-unstyled mb-0 mt-2">
        @forelse($archives as $year => $months)
            <li><h4 class="text-muted">{{ $year }}</h4></li>
                <ol class="list-unstyled mb-2">
                @foreach($months as $monthName => $posts)
                        <li><a href="/posts/archive/year/{{ $year }}/month/{{ $monthName }}/{{ $archiveUser ?? '' }}">{{ $monthName }}</a></li>
                @endforeach
                </ol>
        @empty
            <li>No articles at this time</li>
        @endforelse

        {{--@forelse($archives as $year => $month )--}}
            {{--<li><a href="/posts/archive/year/{{ $archive->year }}/month/{{ $archive->monthName }}">{{ $archive->monthName }} {{ $archive->year }}</a></li>--}}
        {{--@empty--}}
            {{--<li>No articles at this time</li>--}}
        {{--@endforelse--}}
    </ol>
</div>