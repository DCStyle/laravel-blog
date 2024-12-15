<x-main-layout>
    @seo(['title' => $page->title, 'description' => $page->getSnippet()])

    <div class="min-h-screen">
        <div class="bg-gray-50 bg-opacity-50 border-t-2 border-b-2 border-gray-100 px-4 py-16 text-center mb-6">
            <h1 class="text-4xl font-bold">
                {{ $page->title }}
            </h1>
        </div>

        <div class="container mx-auto px-2 xl:px-0 flex flex-wrap justify-between mb-4">
            <div class="prose max-w-none">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</x-main-layout>
