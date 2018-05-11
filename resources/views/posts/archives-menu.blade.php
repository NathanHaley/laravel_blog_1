<div class="p-3">
    <h4 class="font-italic">Archives</h4>
    <ol class="list-unstyled mb-0">
        @forelse($archives as $archive)
            <li><a href="/posts/archive/year/{{ $archive->year }}/month/{{ $archive->monthName }}">{{ $archive->monthName }} {{ $archive->year }}</a></li>
        @empty
            <li>No archives at this time</li>
        @endforelse
    </ol>
</div>