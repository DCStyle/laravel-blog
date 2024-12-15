<x-main-layout>
    @seo(['title' => $post->title, 'description' => $post->getSnippet(), 'image' => asset($post->image_path)])

    <div class="min-h-screen">
        <div class="relative h-96 w-full overflow-hidden">
            <!-- Background Image or Gradient -->
            <div class="absolute inset-0">
                @if($post->image_path)
                    <img src="{{ $post->image_path }}"
                         alt="{{ $post->title }}"
                         class="h-full w-full object-cover">
                @else
                    <div class="h-full w-full bg-gradient-to-br from-purple-600 via-red-500 to-yellow-500"></div>
                @endif
            </div>

            <div class="absolute inset-0 {{ $post->image_path ? 'bg-gradient-to-r from-black/50 to-black/25' : 'bg-black/10' }}"></div>

            <!-- Content -->
            <div class="relative flex h-full items-center justify-center px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <span class="mb-4 inline-block rounded-full bg-white px-3 py-1 text-xs font-semibold uppercase tracking-wide text-gray-900" style="background: {{ $post->category->backgroundColor }}CC; color: {{ $post->category->textColor }};">{{ $post->category->name }} </span>

                    <!-- Title -->
                    <h1 class="mb-4 text-4xl font-bold text-white sm:text-5xl md:text-6xl">
                        {{ $post->title }}
                    </h1>

                    <div class="flex flex-wrap items-center justify-center gap-2 text-sm text-white sm:gap-4">
                    <span>
                        <i class="fa fa-history"></i>

                        <time datetime="{{ $post->created_at->toISOString() }}">
                            {{ $post->created_at->diffForHumans() }}
                        </time>
                    </span>
                        <span class="hidden sm:inline">&bull;</span>

                        <span>
                        <i class="fa fa-eye"></i>
                        {{ $post->read_time }} phút đọc
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-2 xl:px-0 flex flex-wrap justify-between mt-8 lg:mt-10 xl:mt-12 mb-4">
            <div class="w-full mb-4 lg:w-3/4 lg:mb-0 lg:pr-8 xl:pr-12">
                <div class="post-content px-4 lg:px-8 text-justify md:text-lg leading-loose mb-4">
                    {!! $post->body !!}
                </div>

                @if(count($relatedPosts))
                    <div class="flex items-center justify-center gap-4 py-8">
                        <div class="h-px flex-1 bg-gray-200"></div>
                        <h2 class="text-2xl font-bold text-gray-900">Bài viết liên quan</h2>
                        <div class="h-px flex-1 bg-gray-200"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($relatedPosts as $relatedPost)
                            @include('components.post-card', [
                                'post' => $relatedPost,
                                'size' => 'medium',
                                'hideCategory' => true,
                                'hasThumbnail' => true,
                                'showDate' => true,
                            ])
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="w-full lg:w-1/4">
                <div class="sticky top-10">
                    <h2 class="text-xl font-medium border-b pb-2 mb-4">Bài mới</h2>
                    <ul class="space-y-4">
                        @foreach($latestPosts as $post)
                            <li>
                                <x-post-card :post="$post" :hasThumbnail="true" />
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('img:not(.profile_img)').forEach(function (img) {
            img.classList.add('img-enlargable');
            img.addEventListener('click', function () {
                let src = img.getAttribute('src');

                let overlay = document.createElement('div');
                overlay.style.cssText = 'background: RGBA(0,0,0,.5) url(' + src + ') no-repeat center; background-size: contain; width: 100%; height: 100%; position: fixed; z-index: 10000; top: 0; left: 0; cursor: zoom-out;';

                overlay.addEventListener('click', function () {
                    overlay.remove();
                });

                document.body.appendChild(overlay);
            });
        });
    </script>
</x-main-layout>
