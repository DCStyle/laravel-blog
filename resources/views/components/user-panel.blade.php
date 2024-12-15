<div class="modal">
    <div class="modal-profile">
        <span>Xin chào!</span>

        <i class="fa-solid fa-circle-xmark close close-modal"></i>

        <p class="name">{{ Auth::User() ? Auth::User()->firstname . ' ' . Auth::User()->lastname : '' }}</p>

        <p class="info">Các tác vụ có sẵn</p>
        <a href="{{ route('dashboard') }}" class="button"><i class="fa-solid fa-wrench"></i><p>Bảng điều khiển</p></a>
        <a href="{{ route('profile') }}" class="button"><i class="fa-solid fa-id-card"></i><p>Hồ sơ</p></a>
{{--        <div class="button toggle-mode" onClick="toggleMode();"><i class="fa-solid fa-moon"></i><p>Giao diện tối</p></div>--}}
        <a href="{{ route('logout') }}" class="button"><i class="fa-solid fa-right-from-bracket"></i><p>Đăng xuất</p></a>

        <p class="info">Tác vụ nhanh</p>
        <a href="{{ route('settings.edit') }}" class="button">
            <i class="fa-solid fa-cog"></i>
            <p>Cài đặt chung</p>
        </a>

        <a href="{{ route('homepage-blocks.index') }}" class="button">
            <i class="fa-solid fa-cog"></i>
            <p>Quản lý trang chủ</p>
        </a>

        <a href="{{ route('menu.index') }}" class="button">
            <i class="fa-solid fa-bars"></i>
            <p>Quản lý menu</p>
        </a>

        <a href="{{ route('footer-links.index') }}" class="button">
            <i class="fa-solid fa-bars"></i>
            <p>Quản lý links footer</p>
        </a>

        <a href="{{ route('posts.index') }}" class="button">
            <i class="fa-solid fa-plus"></i>
            <p>Quản lý bài viết</p>
        </a>

        <a href="{{ route('categories.index') }}" class="button">
            <i class="fa-solid fa-square-plus"></i>
            <p>Quản lý danh mục</p>
        </a>

        <a href="{{ route('users.index') }}" class="button">
            <i class="fa-solid fa-user-plus"></i>
            <p>Quản lý người dùng</p>
        </a>
    </div>
    @vite(['resources/js/profile.js'])
</div>
