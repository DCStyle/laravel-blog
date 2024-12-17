<!-- Right Side Icons and Auth -->
<div class="sm:ml-6 flex items-center space-x-4">
    @auth
        <!-- User Dropdown -->
        <div class="relative">
            <button id="user-menu" data-dropdown-toggle="dropdown-user-menu" class="flex items-center space-x-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                <img src="{{ asset(Auth::user()->image_path) }}" alt="{{ Auth::user()->firstname }}" class="w-6 h-6 rounded-full">
                <span class="max-sm:hidden">{{ Auth::user()->firstname }}</span>
                <i class="fa-solid fa-chevron-down"></i>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdown-user-menu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50">
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
