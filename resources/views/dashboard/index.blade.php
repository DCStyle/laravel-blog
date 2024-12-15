<x-admin-layout>
    <x-dashboard-navbar route="{{ route('home') }}"/>

    <div class="dashboard main">
        <p class="welcome">Bảng điều khiển</p>

        <div class="actions_home">
            <a href="{{ route('settings.edit') }}" class="button">
                <i class="fa-solid fa-cog"></i>
                <p>Cài đặt chung</p>
            </a>

            <a href="{{ route('homepage-blocks.index') }}" class="button">
                <i class="fa-solid fa-cog"></i>
                <p>Quản lý trang chủ</p>
            </a>

            <a href="{{ route('pages.index') }}" class="button">
                <i class="fa-solid fa-pager"></i>
                <p>Quản lý các trang</p>
            </a>

            <div class="connected">
                <a href="{{ route('menu.index') }}" class="button">
                    <i class="fa-solid fa-bars"></i>
                    <p>Quản lý menu</p>
                </a>

                <a href="{{ route('footer-links.index') }}" class="button">
                    <i class="fa-solid fa-bars"></i>
                    <p>Quản lý links footer</p>
                </a>
            </div>

            <div class="connected">
                <a href="{{ route('posts.create') }}" class="button">
                    <i class="fa-solid fa-plus"></i>
                    <p>Thêm bài viết</p>
                </a>

                <a href="{{ route('posts.index') }}" class="button">
                    <i class="fa-solid fa-newspaper"></i>
                    <p>Xem bài viết</p>
                </a>
            </div>

            <div class="connected">
                <a href="{{ route('categories.create') }}" class="button">
                    <i class="fa-solid fa-square-plus"></i>
                    <p>Thêm danh mục</p>
                </a>

                <a href="{{ route('categories.index') }}" class="button">
                    <i class="fa-solid fa-layer-group"></i>
                    <p>Xem danh mục</p>
                </a>
            </div>

            <div class="connected">
                <a href="{{ route('users.create') }}" class="button">
                    <i class="fa-solid fa-user-plus"></i>
                    <p>Thêm người dùng</p>
                </a>

                <a href="{{ route('users.index') }}" class="button">
                    <i class="fa-solid fa-user-gear"></i>
                    <p>Quản lý người dùng</p>
                </a>
            </div>

            <div class="connected">
                <a href="{{ route('comments.index') }}" class="button">
                    <i class="fa-solid fa-comments"></i>
                    <p>Xem bình luận</p>
                </a>
                <a href="{{ route('images.index') }}" class="button">
                    <i class="fa-solid fa-image"></i>
                    <p>Xem hình ảnh</p>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>
