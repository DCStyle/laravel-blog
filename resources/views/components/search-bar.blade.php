@props(['isAdmin' => false])

@vite(['resources/js/searchBar.js'])

<style>
    /* Dropdown transitions */
    .search-results-dropdown,
    .no-results {
        transition: opacity 0.2s ease-out;
    }

    .search-results-dropdown.hidden,
    .no-results.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .search-results-dropdown:not(.hidden),
    .no-results:not(.hidden) {
        opacity: 1;
        pointer-events: auto;
    }

    /* Loading indicator transition */
    .loading-indicator {
        transition: opacity 0.2s ease-out;
    }

    .loading-indicator.hidden {
        opacity: 0;
    }
</style>

<div class="search-bar-container relative">
    <!-- Search input with icon -->
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input
            type="text"
            class="search-input w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Tìm kiếm..."
        >
        <!-- Loading spinner -->
        <div class="loading-indicator hidden absolute inset-y-0 right-0 items-center pr-3">
            <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-500"></div>
        </div>
    </div>

    <!-- Search results dropdown -->
    <div class="search-results-dropdown hidden absolute z-50 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-96 overflow-y-auto">
        <!-- Results will be inserted here -->
    </div>

    <!-- No results message -->
    <div class="no-results hidden absolute z-50 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 p-4 text-center text-gray-500">
        Không tìm thấy kết quả nào.
    </div>
</div>

<script>
    window.isAdmin = {{ $isAdmin ? 'true' : 'false' }};
</script>
