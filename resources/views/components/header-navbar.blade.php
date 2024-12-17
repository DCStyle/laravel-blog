<!-- resources/views/components/header.blade.php -->
<div x-data="{
    isOpen: false,
    startX: 0,
    currentX: 0,
    touchStartHandler(e) {
        this.startX = e.touches[0].pageX;
    },
    touchMoveHandler(e) {
        if (!this.isOpen && this.startX < 50) { // Only trigger when starting from left edge
            this.currentX = e.touches[0].pageX - this.startX;
            if (this.currentX > 50) { // Minimum distance to trigger open
                this.isOpen = true;
            }
        } else if (this.isOpen) {
            this.currentX = e.touches[0].pageX - this.startX;
            if (this.currentX < -50) { // Minimum distance to trigger close
                this.isOpen = false;
            }
        }
    }
}"
     class="relative"
     @touchstart="touchStartHandler"
     @touchmove="touchMoveHandler"
>
    <!-- Main Navigation Bar -->
    <nav class="bg-white border-b">
        <div class="container mx-auto px-4 md:px-0">
            <div class="flex justify-between items-center h-16">
                <!-- Left side with menu button and logo -->
                <div class="flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button
                        @click="isOpen = !isOpen"
                        type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                    >
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center mx-auto sm:mx-0">
                    <a href="{{ route('home') }}" class="text-xl font-bold">
                        @if(\App\Models\Setting::get('logo') !== null)
                            <img src="{{ asset(\App\Models\Setting::get('logo')) }}" alt="{{ \App\Models\Setting::get('site_name') }}" class="h-8">
                        @else
                            {{ \App\Models\Setting::get('site_name') }}
                        @endif
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    @foreach($globalMenuItems as $menuItem)
                        <x-header.navbar-item :item="$menuItem" mode="desktop" />
                    @endforeach
                </div>

                <!-- Right Side Icons and Auth -->
                <div class="flex items-center space-x-4 sm:ml-6">
                    <x-header.auth-menu />
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar Overlay -->
    <div
        x-show="isOpen"
        class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 transition-opacity sm:hidden"
        @click="isOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    ></div>

    <!-- Mobile Sidebar -->
    <aside
        x-show="isOpen"
        class="fixed inset-y-0 left-0 max-w-xs w-full bg-white shadow-xl z-50 transform sm:hidden"
        x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        @click.away="isOpen = false"
        style="display: none;"
    >
        <!-- Mobile Sidebar Header -->
        <div class="flex items-center justify-between px-4 h-16 border-b border-gray-200">
            <div class="text-lg font-medium text-gray-900">Menu</div>
            <button
                @click="isOpen = false"
                class="rounded-md p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
            >
                <span class="sr-only">Close menu</span>
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Mobile Sidebar Content -->
        <div class="h-full overflow-y-auto">
            <div class="px-2 pt-2 pb-3 space-y-1">
                @foreach($globalMenuItems as $menuItem)
                    <x-header.navbar-item :item="$menuItem" mode="mobile" />
                @endforeach
            </div>
        </div>
    </aside>
</div>
