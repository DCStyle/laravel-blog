<div class="category-block">
    @php
        // Get posts from selected categories
        $posts = \App\Models\Post::whereIn('category_id', $settings->category_ids ?? [])
            ->take($settings->number_of_posts ?? 5)
            ->when(isset($settings->post_order) && $settings->post_order === 'oldest', function ($query) {
                return $query->oldest();
            })
            ->when(isset($settings->post_order) && $settings->post_order === 'random', function ($query) {
                return $query->inRandomOrder();
            })
            ->latest()
            ->get();
    @endphp

    <h2 class="text-2xl font-bold mb-4">{{ $title }}</h2>

    <div class="grid {{ $settings->display_style === '3_columns' ? 'grid-cols-1 md:grid-cols-3' : 'grid-cols-1 md:grid-cols-2' }} gap-6">
        @foreach ($posts as $post)
            @include('components.post-card', [
                'post' => $post,
                'size' => 'large',
                'hasThumbnail' => true,
                'showDate' => true,
                'showExcerpt' => true,
                'showReadMore' => true
            ])
        @endforeach
    </div>
</div>
