class SearchModal {
    constructor(container, isAdmin) {
        this.container = container;
        this.isAdmin = isAdmin;
        this.modal = container.querySelector('.search-modal');
        this.trigger = container.querySelector('.search-trigger');
        this.closeBtn = container.querySelector('.close-modal');
        this.searchInput = container.querySelector('.search-input');
        this.resultsContainer = container.querySelector('.search-results');
        this.loadingIndicator = container.querySelector('.loading-indicator');
        this.noResultsMessage = container.querySelector('.no-results');

        this.debounceTimeout = null;
        this.bindEvents();
    }

    bindEvents() {
        // Open modal
        this.trigger.addEventListener('click', () => this.openModal());

        // Close modal
        this.closeBtn.addEventListener('click', () => this.closeModal());

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('hidden')) {
                this.closeModal();
            }
        });

        // Close on backdrop click
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.closeModal();
            }
        });

        // Search input handler
        this.searchInput.addEventListener('input', (e) => {
            clearTimeout(this.debounceTimeout);
            this.debounceTimeout = setTimeout(() => {
                this.performSearch(e.target.value);
            }, 300);
        });
    }

    openModal() {
        this.modal.classList.remove('hidden');
        this.searchInput.focus();
    }

    closeModal() {
        this.modal.classList.add('hidden');
        this.searchInput.value = '';
        this.clearResults();
    }

    clearResults() {
        this.resultsContainer.innerHTML = '';
        this.loadingIndicator.classList.add('hidden');
        this.noResultsMessage.classList.add('hidden');
    }

    async performSearch(query) {
        if (query.length < 2) {
            this.clearResults();
            return;
        }

        this.loadingIndicator.classList.remove('hidden');
        this.noResultsMessage.classList.add('hidden');
        this.resultsContainer.innerHTML = '';

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
            this.resultsContainer.innerHTML = '<div class="text-red-500">An error occurred while searching</div>';
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

        this.resultsContainer.innerHTML = results.map(result => `
            <a href="${result.url}" class="block p-4 hover:bg-gray-50 rounded-lg transition">
                <h3 class="text-lg font-semibold text-gray-900">${result.title}</h3>
                <p class="mt-1 text-sm text-gray-600">${result.excerpt}</p>
                <div class="flex justify-between items-center mt-2">
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-blue-600 bg-blue-100 rounded-full">
                        ${result.category}
                    </span>
                </div>
            </a>
        `).join('');
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

// Initialize all search modals on the page
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.search-modal-container').forEach(container => {
        new SearchModal(container, window.isAdmin);
    });
});
