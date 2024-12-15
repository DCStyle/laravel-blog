class SearchBar {
    constructor(container, isAdmin) {
        this.container = container;
        this.isAdmin = isAdmin;
        this.searchInput = container.querySelector('.search-input');
        this.resultsDropdown = container.querySelector('.search-results-dropdown');
        this.loadingIndicator = container.querySelector('.loading-indicator');
        this.noResultsMessage = container.querySelector('.no-results');

        this.debounceTimeout = null;
        this.bindEvents();
    }

    bindEvents() {
        // Search input handler
        this.searchInput.addEventListener('input', (e) => {
            clearTimeout(this.debounceTimeout);
            this.debounceTimeout = setTimeout(() => {
                this.performSearch(e.target.value);
            }, 300);
        });

        // Close dropdown on click outside
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target)) {
                this.closeDropdown();
            }
        });

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeDropdown();
            }
        });
    }

    closeDropdown() {
        this.resultsDropdown.classList.add('hidden');
        this.noResultsMessage.classList.add('hidden');
    }

    clearResults() {
        this.resultsDropdown.innerHTML = '';
        this.loadingIndicator.classList.add('hidden');
        this.noResultsMessage.classList.add('hidden');
        this.resultsDropdown.classList.add('hidden');
    }

    async performSearch(query) {
        if (query.length < 2) {
            this.clearResults();
            return;
        }

        this.loadingIndicator.classList.remove('hidden');
        this.resultsDropdown.classList.add('hidden');
        this.noResultsMessage.classList.add('hidden');

        try {
            const response = await fetch('/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    query: query,
                    is_admin: this.isAdmin
                })
            });

            if (!response.ok) {
                throw new Error('Search request failed');
            }

            const results = await response.json();
            this.displayResults(results);
        } catch (error) {
            console.error('Search failed:', error);
            this.resultsDropdown.innerHTML = '<div class="p-4 text-red-500">An error occurred while searching</div>';
            this.resultsDropdown.classList.remove('hidden');
        } finally {
            this.loadingIndicator.classList.add('hidden');
        }
    }

    displayResults(results) {
        this.clearResults();

        if (results.length === 0) {
            this.noResultsMessage.classList.remove('hidden');
            return;
        }

        this.resultsDropdown.innerHTML = results.map(result => `
            <a href="${result.url}" class="block p-3 hover:bg-gray-50 border-b last:border-b-0">
                <div class="font-medium text-gray-900">${result.title}</div>
                <div class="text-sm text-gray-600 truncate">${result.excerpt}</div>
                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">
                    ${result.category}
                </span>
            </a>
        `).join('');
        this.resultsDropdown.classList.remove('hidden');
    }

    escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
}

// Initialize all search bars on the page
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.search-bar-container').forEach(container => {
        new SearchBar(container, window.isAdmin);
    });
});
