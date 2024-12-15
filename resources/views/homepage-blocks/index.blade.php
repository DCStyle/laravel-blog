<x-admin-layout>
    <x-dashboard-navbar route="{{ route('dashboard') }}"/>

    <div class="dashboard !block w-full">
        <h2 class="welcome-2 mb-4">Quản lý trang chủ</h2>

        <div>
            <div id="blocks-container" class="space-y-4">
                @foreach ($blocks as $block)
                    <div class="block-item p-4 bg-white rounded shadow flex items-center space-y-4" data-id="{{ $block->id }}">
                        <i class="fa fa-bars flex-grow-0 flex-shrink-0 w-12 text-xl cursor-pointer"></i>

                        <div class="space-y-2 flex-1">
                            <a href="{{ route('homepage-blocks.edit', $block) }}" class="text-lg font-bold">
                                {{ $block->title }}

                                <i class="fa fa-pencil" data-tooltip-target="tooltip-edit-block-{{ $block->id }}"></i>
                                <div id="tooltip-edit-block-{{ $block->id }}"
                                     role="tooltip"
                                     class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
                                >
                                    Chỉnh sửa
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </a>
                            <p class="text-sm text-gray-500">Type: {{ ucfirst($block->type) }}</p>
                        </div>

                        <div class="inline-flex space-x-4">
                            <x-button action="{{ route('homepage-blocks.destroy', $block) }}" type="delete" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <x-floating-button icon="fa-plus" url="{{ route('homepage-blocks.create') }}" />

    <script src="http://SortableJS.github.io/Sortable/Sortable.js"></script>
    <script>
        const container = document.getElementById('blocks-container');
        new Sortable(container, {
            animation: 150,
            onEnd: function () {
                const order = Array.from(container.children).map(item => item.dataset.id);
                fetch("{{ route('homepage-blocks.update-order') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ order })
                });
            }
        });
    </script>
</x-admin-layout>
