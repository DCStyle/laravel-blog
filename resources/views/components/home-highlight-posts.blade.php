@php
    $highlightedPosts = \App\Models\HighlightPost::latest()->take($settings->number_of_posts ?? 5)->get();
@endphp

<section class="container mx-auto py-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        <!-- Main Featured Post -->
        @if($highlightedPosts->first())
            @php
                $mainPost = $highlightedPosts->first();
                $otherPosts = $highlightedPosts->slice(1);
            @endphp
            <div class="col-span-2">
                @include('components.post-card', [
                    'post' => $mainPost->post,
                    'size' => 'large',
                    'hasThumbnail' => true,
                    'showDate' => true,
                    'showExcerpt' => true,
                    'showReadMore' => true
                ])
            </div>
        @endif

        <!-- More Featured Posts -->
        <div>
            <h3 class="text-lg font-bold text-gray-800 mb-4">Bài viết nổi bật khác</h3>
            <div class="space-y-4 md:space-y-8">
                @foreach($otherPosts as $post)
                    @include('components.post-card', [
                        'post' => $post->post,
                        'size' => 'small',
                        'showDate' => true,
                    ])
                @endforeach
            </div>
        </div>
    </div>
</section>
