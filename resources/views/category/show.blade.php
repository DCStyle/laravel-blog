<x-main-layout>
    @seo(['title' => $category->name])

    @vite(['resources/js/categoryLoadMore.js'])

    <div class="min-h-screen">
        <div class="bg-gray-50 bg-opacity-50 border-t-2 border-b-2 border-gray-100 px-4 py-16 text-center mb-6">
            <h1 class="text-4xl font-bold">
                <span class="preview p-2 rounded" style="background: {{ $category->backgroundColor }}CC; color: {{ $category->textColor }};">{{ $category->name }} </span>
            </h1>
        </div>

        <div class="container mx-auto px-2 xl:px-0 flex flex-wrap justify-between mb-4">
            <div class="w-full mb-4 lg:w-3/4 lg:mb-0">
                <div id="posts-container" class="space-y-6">
                    <x-posts-list :posts="$posts" />
                </div>

                <!-- Load more button -->
                @if($posts->hasMorePages())
                    <div class="flex justify-center mt-8">
                        <button
                            id="load-more"
                            data-next-page="{{ $posts->currentPage() + 1 }}"
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Load More
                        </button>
                    </div>
                @endif
            </div>

            <div class="w-full lg:w-1/4 lg:pl-4">
                <div class="sticky top-10">
                    <h2 class="text-xl font-medium border-b pb-2 mb-4">Bài mới</h2>
                    <ul class="space-y-4">
                        @foreach($otherPosts as $post)
                            <li>
                                <x-post-card :post="$post" :hasThumbnail="true" />
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
