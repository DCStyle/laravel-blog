@props(['isAdmin' => false])

@vite(['resources/js/searchModal.js'])

<style>
    /* Modal transitions */
    .search-modal {
        transition: opacity 0.3s ease-out;
    }

    .search-modal.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .search-modal:not(.hidden) {
        opacity: 1;
        pointer-events: auto;
    }

    /* Results transitions */
    .search-results > * {
        transition: opacity 0.2s ease-out;
    }
</style>

<div class="search-modal-container">
    <!-- Search trigger button -->
    <button class="search-trigger text-gray-500 hover:text-gray-600" type="button">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </button>

    <!-- Modal -->
    <div class="search-modal fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="min-h-screen px-4 text-center">
            <div class="close-modal fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <!-- Search input -->
                <div class="p-6 relative">
                    <div class="relative">
                        <i class="fa fa-search absolute top-1/2 -translate-y-1/2 left-2 text-gray-500"></i>

                        <input
                            type="text"
                            class="search-input w-full px-4 py-2 pl-8 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Tìm kiếm..."
                        >
                    </div>
                </div>

                <!-- Loading state -->
                <div class="loading-indicator hidden text-center py-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div>
                </div>

                <!-- Results list -->
                <div class="search-results space-y-4"></div>

                <!-- No results -->
                <div class="no-results hidden text-center py-4 text-gray-500">
                    Không tìm thấy kết quả nào.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.isAdmin = {{ $isAdmin ? 'true' : 'false' }};
</script>
