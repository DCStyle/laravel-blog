@foreach($posts as $post)
    <article class="bg-white rounded-lg border hover:shadow-md transition-shadow duration-200">
        <div class="p-4 md:p-6">
            <div class="flex flex-wrap md:flex-nowrap justify-between items-start">
                @if($post->image_path)
                    <a href="{{ route('posts.show', $post) }}" class="block w-full aspect-[2/1] md:w-24 md:h-24 md:aspect-auto flex-shrink-0 flex-grow-0 md:mr-4">
                        <img
                            src="{{ $post->image_path }}"
                            alt="{{ $post->title }}"
                            class="w-full h-full object-cover rounded-lg md:mr-4"
                        >
                    </a>
                @endif

                <div class="mt-2 md:mt-0">
                    <h2 class="md:text-xl font-semibold text-gray-900 hover:text-blue-600">
                        <a href="{{ route('posts.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <div class="mt-2 text-sm text-gray-600 line-clamp-2 md:line-clamp-none">
                        {{ $post->excerpt }}
                    </div>
                </div>
            </div>

            <div class="mt-4 flex items-center space-x-4 text-sm">
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
        </div>
    </article>
@endforeach
