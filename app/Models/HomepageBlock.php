<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageBlock extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'is_visible', 'settings', 'order'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function getSettingsAttribute($value)
    {
        return json_decode($value);
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = json_encode($value);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeHighlightPosts($query)
    {
        return $query->type('highlight_posts');
    }

    public function scopeCategory($query)
    {
        return $query->type('category');
    }

    public function scopeHtml($query)
    {
        return $query->type('html');
    }

    public function getComponentAttribute()
    {
        return 'homepage-blocks.' . $this->type;
    }
}
