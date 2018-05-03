<div class="row mb-2">
    @foreach($cards as $card)

        <div class="col-md-6">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2" style="color: {{ $card->channel->color }}">{{ $card->channel->name }}</strong>
                    <h3 class="mb-0">
                        <a class="text-dark" href="{{ route('post.show', $card) }}">Featured post</a>
                    </h3>
                    <div class="mb-1 text-muted">{{ $card->created_at->format('M Y') }}</div>
                    <p class="card-text mb-auto">{{ $card->lede }}</p>
                    <a href="{{ route('post.show', $card) }}">Continue reading</a>
                </div>
                <img class="card-img-right flex-auto d-none d-lg-block" width="200" height="250" src="{{ $card->card_path }}"
                     alt="{{ $card->slug }}">
            </div>
        </div>

    @endforeach
</div>