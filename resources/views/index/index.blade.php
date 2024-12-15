<x-main-layout>
    <div class="container mx-auto py-4 px-2 xl:px-0">
        <div class="space-y-4 md:space-y-8 lg:space-y-12">
            @foreach ($blocks as $block)
                @if ($block->type === 'highlight_posts')
                    <x-home-highlight-posts :settings="$block->settings" />
                @elseif ($block->type === 'category')
                     <x-home-category :title="$block->title" :settings="$block->settings" />
                @elseif ($block->type === 'html')
                    {!! $block->settings->html ?? '' !!}
                @endif
            @endforeach
        </div>
    </div>
</x-main-layout>
