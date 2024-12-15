<header>
    <a href="{{ $route }}">
        <i class="fa-solid fa-left-long"></i>
        @switch($route)
            @case(route('dashboard'))
                Trang quản lý
                @break
            @case(route('home'))
                Trang chủ
                @break
            @default
                Quay lại
                @break
        @endswitch
    </a>

    <div class="profile">
        <img src="{{ asset(Auth::user()->image_path) }}" alt="profile" class="profile_img">
        <i class="fa-solid fa-angles-down"></i>
    </div>
</header>
