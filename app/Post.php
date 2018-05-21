<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Events\UserPublishedNewPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 * @package App
 */
class Post extends Model
{
    use RecordsActivity;
    use LikableTrait;

    /**
     * @var array
     */
    protected $recordableActivities = ['created', 'updated'];

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'channel_id',
        'title',
        'lede',
        'body',
        'locked',
        'featured_banner',
        'featured_card',
        'banner_path',
        'card_path'
    ];

    /**
     * @var array
     */
    protected $appends = ['likedCount'];

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            event(new UserPublishedNewPost($post));
        });

        static::deleting(function ($post) {
            $post->removeBannerImage();
            $post->removeCardImage();
        });
    }

    /**
     *
     */
    public function removeBannerImage()
    {
        if ($this->banner_path != null) {
            Storage::disk('public')->delete($this->banner_path);
            $this->banner_path = null;
        }
    }

    /**
     *
     */
    public function removeCardImage()
    {
        if ($this->card_path != null) {
            Storage::disk('public')->delete($this->card_path);
            $this->card_path = null;
        }
    }


    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Set the name of the channel.
     *
     * @param string $name
     */
    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = str_slug($title);
    }

    /**
     * @param int $monthsBack
     * @param int|null $userId
     * @return mixed
     */
    static function archives2(int $monthsBack = 1, int $userId = null)
    {
        $breakPoint = static::breakPoint($monthsBack);

        $posts = Post::where([
                            ['user_id', (isset($userId))?'=':'<>', $userId],
                            ['locked', '=', false],
                            ['created_at', '<', $breakPoint],
                        ])
                        ->get([
                        'created_at as year',
                        'created_at as month',
                        'created_at as monthName'
                    ]);

        $posts = $posts->map(function ($post) {

            $c = new Carbon($post['year']);
            $post['year'] = $c->year;
            $post['month'] = $c->month;
            $post['monthName'] = $c->format('F');

            return $post;
        });

        $posts = $posts->groupby(['year', 'monthName'])
                        ->sortByDesc('year')
                        ->sortByDesc('month');

        return $posts;
    }

    /**
     * @param Carbon|null $breakPoint
     * @return mixed
     */
    static function archives(Carbon $breakPoint = null)
    {
        $breakPoint = $breakPoint ?? Carbon::now()->subMonth();

        // SQLite for testing.
        if (config('database.default') == 'sqlite') {
            return static::select(
                DB::raw('strftime("Y", created_at) as year, strftime("M", created_at) as monthName, strftime("M", created_at) as month')
            )
                ->where([
                    ['locked', '=', false],
                    ['created_at', '<', $breakPoint]
                ])
                ->groupby(['year', 'monthName', 'month'])
                ->orderby('year', 'desc')
                ->orderby('month', 'desc')
                ->get();
        }

        return static::select(
            DB::raw('year(created_at) as year, monthname(created_at) as monthName, month(created_at) as month')
        )
            ->where([
                ['locked', '=', false],
                ['created_at', '<', $breakPoint]
            ])
            ->groupby(['year', 'monthName', 'month'])
            ->orderby('year', 'desc')
            ->orderby('month', 'desc')
            ->get();

    }

    /**
     * @param int $limit
     * @return mixed
     */
    static function latestActive($limit = 3)
    {
        return static::latest()->limit($limit)->get();
    }

    /**
     *
     */
    public function visitsIncrement()
    {
        static::increment('visits');
    }

    /**
     *
     */
    public function commentsCountIncrement()
    {
        static::increment('comments_count');
    }

    /**
     *
     */
    public function commentsCountDecrement()
    {
        static::decrement('comments_count');
    }

    /**
     * @param null $id
     * @return array
     */
    static function validations($id = null)
    {
        return [
            'title' => [
                'required',
                $id === null ? '' : Rule::unique('posts')->ignore($id),
                'max:100',
            ],
            'banner_path' => 'image|max:5000',
            'card_path' => 'image|max:1000',
            'lede' => 'required|max:250',
            'body' => 'required|max:65000',
            'channel_id' => 'required|exists:channels,id'
        ];
    }


    /**
     * @param int $monthsBack
     * @return mixed
     */
    static function breakPoint(int $monthsBack = 1)
    {
        return Post::orderby('created_at', 'desc')->pluck('created_at')->first()->subMonths($monthsBack);
    }

    /**
     * @return string
     */
    public function path()
    {
        return "/post/{$this->slug}";
    }

    /**
     * @param $banner_path
     * @return null|string
     */
    public function getBannerPathAttribute($banner_path)
    {
        if (isset($banner_path) && starts_with($banner_path, 'https://')) {
            return $banner_path;
        }

        return ($banner_path) ? '/storage/' . $banner_path : null;
    }

    /**
     * @param $cardPath
     * @return null|string
     */
    public function getCardPathAttribute($cardPath)
    {
        return ($cardPath) ? '/storage/' . $cardPath : null;
    }

    /**
     * @param $body
     * @return array|string
     */
    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }

    /**
     * @param array $commentArray
     * @return Comment
     */
    public function addComment(array $commentArray)
    {
        $comment = new Comment();

        $comment->post_id = $this->id;
        $comment->user_id = auth()->id();
        $comment->body = $commentArray['body'];

        $comment->save();

        $this->commentsCountIncrement();

        return $comment;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return $this
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderByDesc('created_at');
    }
}
