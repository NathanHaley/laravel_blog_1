<div class="row mb-2">
    @forelse($cards as $card)
        <div class="col-md-6 featured-card">
            <avatar classes="featured-card-avatar" username="{{ $card->user->name }}"
                    avatar_path="{{ $card->user->avatar_path }}" width="3"></avatar>
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2"
                            style="color: {{ $card->channel->color }}">{{ $card->channel->name }}</strong>
                    <h3 class="mb-0">
                        <a class="text-dark"
                           href="{{ route('post.show', $card) }}">{{ str_limit($card->title, 17, '...')}}</a>
                    </h3>
                    <div class="mb-1 text-muted">{{ $card->created_at->format('M d') }}</div>
                    <p class="card-text mb-auto">{{ str_limit($card->lede, 65, '...')}}</p>
                    <a href="{{ route('post.show', $card) }}">Continue reading</a>
                </div>
                <img class="card-img-right flex-auto d-none d-lg-block"
                     width="200"
                     height="250"
                     src="{{ $card->card_path }}"
                     alt="{{ $card->slug }}">
            </div>
        </div>
    @empty
        @for($cnt = 0; $cnt <2; ++$cnt)
            <div class="col-md-6 featured-card">
                <avatar classes="featured-card-avatar" username="default_name"
                        avatar_path="images/avatars/default.png" width="3"></avatar>
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2"
                                style="color: #000">Velit</strong>
                        <h3 class="mb-0">
                            <a class="text-dark"
                               href="#">{{ str_limit("Doloremque rem distinctio", 12, '...')}}</a>
                        </h3>
                        <div class="mb-1 text-muted">{{ now()->format('M d') }}</div>
                        <p class="card-text mb-auto">{{ str_limit("Fugiat nostrum doloribus non et ipsum odio accusamus. Molestias consequatur recusandae eum. ", 65, '...')}}</p>
                        <a href="#">Continue reading</a>
                    </div>
                    <img class="card-img-right flex-auto d-none d-lg-block"
                         width="200"
                         height="250"
                         src=""
                         alt="">
                </div>
            </div>
        @endfor
    @endforelse
</div>