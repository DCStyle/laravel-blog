<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'excerpt', 'body', 'image_path', 'slug', 'is_published', 'additional_info', 'category_id', 'read_time', 'change_user_id', 'changelog'
    ];

    protected function normalizeSearchTerm($term)
    {
        // Remove diacritics (accents)
        $term = preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|caron);~i', '$1', htmlentities($term, ENT_QUOTES, 'UTF-8'));
        return mb_strtolower($term);
    }

    protected function prepareSearchTerm($searchTerm)
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            $normalized = $this->normalizeSearchTerm($searchTerm);
            // Add wildcards for partial matching
            return '+' . implode('* +', explode(' ', $normalized)) . '*';
        }
        else if (DB::connection()->getDriverName() === 'pgsql') {
            $term = str_replace(' ', ' & ', $searchTerm);
            return Str::ascii($term);
        }

        return $searchTerm;
    }

    public function scopeSearch($query, $searchTerm)
    {
        $driver = DB::connection()->getDriverName();
        $preparedTerm = $this->prepareSearchTerm($searchTerm);

        if ($driver === 'mysql') {
            return $query->join('categories', 'posts.category_id', '=', 'categories.id')
                ->where(function($q) use ($preparedTerm, $searchTerm) {
                    // Search in original columns (for exact matches)
                    $q->whereRaw(
                        "MATCH(posts.title, posts.excerpt, posts.body) AGAINST(? IN BOOLEAN MODE)",
                        [$searchTerm]
                    )
                        ->orWhereRaw(
                            "MATCH(categories.name) AGAINST(? IN BOOLEAN MODE)",
                            [$searchTerm]
                        )
                        // Search in normalized columns (for accent-insensitive matches)
                        ->orWhereRaw(
                            "MATCH(posts.normalized_title, posts.normalized_excerpt, posts.normalized_body) AGAINST(? IN BOOLEAN MODE)",
                            [$preparedTerm]
                        )
                        ->orWhereRaw(
                            "MATCH(categories.normalized_name) AGAINST(? IN BOOLEAN MODE)",
                            [$preparedTerm]
                        );
                });
        }
        else if ($driver === 'pgsql') {
            return $query->whereRaw(
                "search_vector @@ to_tsquery('simple', unaccent(?))",
                [$preparedTerm]
            );
        }

        // Fallback for other databases
        return $query->where(function($q) use ($searchTerm) {
            $searchLike = '%' . $searchTerm . '%';
            $q->whereRaw('LOWER(posts.title) LIKE LOWER(?)', [$searchLike])
                ->orWhereRaw('LOWER(posts.excerpt) LIKE LOWER(?)', [$searchLike])
                ->orWhereRaw('LOWER(posts.body) LIKE LOWER(?)', [$searchLike])
                ->orWhereHas('category', function($q) use ($searchLike) {
                    $q->whereRaw('LOWER(name) LIKE LOWER(?)', [$searchLike]);
                });
        });
    }

    public function scopeWithSearchRank($query, $searchTerm)
    {
        $driver = DB::connection()->getDriverName();
        $preparedTerm = $this->prepareSearchTerm($searchTerm);

        if ($driver === 'mysql') {
            return $query->selectRaw('
                posts.*,
                (
                    MATCH(posts.title, posts.excerpt, posts.body) AGAINST(? IN BOOLEAN MODE) * 2 +
                    MATCH(categories.name) AGAINST(? IN BOOLEAN MODE) * 2 +
                    MATCH(posts.normalized_title, posts.normalized_excerpt, posts.normalized_body) AGAINST(? IN BOOLEAN MODE) +
                    MATCH(categories.normalized_name) AGAINST(? IN BOOLEAN MODE)
                ) as search_rank',
                [$searchTerm, $searchTerm, $preparedTerm, $preparedTerm]
            );
        }
        else if ($driver === 'pgsql') {
            return $query->selectRaw(
                "*, ts_rank(search_vector, to_tsquery('simple', unaccent(?))) as search_rank",
                [$preparedTerm]
            );
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function changeUser()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('id', 'DESC');
    }

    public function historypost()
    {
        return $this->hasMany(HistoryPost::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function highlightPosts()
    {
        return $this->hasMany(HighlightPost::class);
    }

    public function getSnippet($length = 200)
    {
        return Str::limit(strip_tags(html_entity_decode($this->body)), $length);
    }
}
