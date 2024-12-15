<div class="post-card">
    @isset($hasThumbnail)
        <a href="{{ route('post.show', $post->slug) }}" class="block">
            <img src="{{ $post->image_path }}" alt="{{ $post->title }}"
                 class="rounded-lg shadow-lg w-full h-fit object-cover max-md:aspect-[2/1]"
            >
        </a>
    @endisset

    <div class="mt-4">
        @if(!isset($hideCategory))
            <a href="{{ route('category.show', $post->category->slug) }}" class="text-sm text-gray-500 hover:text-blue-600 transition">
                {{ $post->category->name }}
            </a>
        @endif

        <h2 class="mt-2 font-bold text-gray-800 hover:text-blue-600 transition
                {{ isset($size) && $size == 'large' ? 'md:text-2xl' : '' }}
                {{ isset($size) && $size == 'medium' ? 'md:text-xl' : '' }}
                ">
            <a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a>
        </h2>

        @isset($showDate)
            <div class="mt-2 flex items-center space-x-4 text-sm">
                <div class="text-gray-500">
                    <i class="fa fa-history"></i>

                    <time datetime="{{ $post->created_at->toISOString() }}">
                        {{ $post->created_at->diffForHumans() }}
                    </time>
                </div>
                <div>
                    <i class="fa fa-eye"></i>

                    <span>
                        {{ $post->read_time }} phút đọc
                    </span>
                </div>
            </div>
        @endisset

        @isset($showExcerpt)
            <p class="mt-2 text-gray-600 max-md:line-clamp-2">{{ $post->excerpt }}</p>
        @endisset

        @isset($showReadMore)
            <a href="{{ route('post.show', $post->slug) }}" class="text-blue-600 hover:underline mt-2 inline-block">Đọc tiếp</a>
        @endisset
    </div>

</div>
