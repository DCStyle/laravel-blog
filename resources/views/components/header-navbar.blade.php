<div class="navbar z-50">
    <nav class="bg-white">
        <div class="container mx-auto px-4 md:px-0">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold">
                        @if(\App\Models\Setting::get('logo') !== null)
                            <img src="{{ asset(\App\Models\Setting::get('logo')) }}" alt="{{ \App\Models\Setting::get('site_name') }}" class="h-8">
                        @else
                            {{ \App\Models\Setting::get('site_name') }}
                        @endif
                    </a>
                </div>

                <!-- Main Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    @foreach($globalMenuItems as $menuItem)
                        @if($menuItem->children->isEmpty())
                            <!-- Single Menu Item -->
                            <a href="{{ $menuItem->url }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                                {{ $menuItem->title }}
                            </a>
                        @else
                            <!-- Dropdown Menu Item -->
                            <div class="relative">
                                <button
                                    id="menu-{{ $menuItem->id }}"
                                    data-dropdown-toggle="dropdown-menu-{{ $menuItem->id }}"
                                    class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"
                                >
                                    {{ $menuItem->title }}

                                    <i class="fa fa-chevron-down ml-1 text-xs"></i>
                                </button>

                                <!-- Dropdown Items -->
                                <div id="dropdown-menu-{{ $menuItem->id }}" class="hidden bg-white shadow-lg rounded-md mt-1 z-1 min-w-32">
                                    <ul class="py-1">
                                        @foreach($menuItem->children as $child)
                                            <li class="text-nowrap">
                                                <a href="{{ $child->url }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                    {{ $child->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Right Side Icons and Auth -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">
                    @auth
                        <!-- User Dropdown -->
                        <div class="relative">
                            <button id="user-menu" data-dropdown-toggle="dropdown-user-menu" class="flex items-center space-x-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                                <img src="{{ asset(Auth::user()->image_path) }}" alt="{{ Auth::user()->firstname }}" class="w-6 h-6 rounded-full">
                                <span>{{ Auth::user()->firstname }}</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>

                            <!-- Dropdown menu -->
                            <div id="dropdown-user-menu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none">
                                <div class="py-1">
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Trang cá nhân</a>
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Trang admin</a>
                                </div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Thoát
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex space-x-4">
                            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Đăng nhập
                            </a>
                        </div>
                    @endauth

                    <x-search-modal />
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</div>
