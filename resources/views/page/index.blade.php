<x-admin-layout>
    @section('scripts')
        @vite(['resources/js/filtr.js'])
    @endsection

    <x-dashboard-navbar route="{{ route('dashboard') }}"/>

    <div class="layout-container">
        <div class="filter">
            <div class="filtr_collapse">
                <p class="head">Mục trang</p>
                <i class="fa-solid fa-caret-up button_collapse"></i>
            </div>
            <div class="filtr_body">
                <div class="sort">
                    <p class="name">Sắp xếp</p>
                    <div class="buttons sort_buttons">
                        <div class="filter-button" onclick="filterCheck(1);" data-order="desc">
                            <div class="dot"><i class="fa-solid fa-circle-dot"></i></div>
                            <p>ID giảm dần</p>
                        </div>
                        <div class="filter-button active" onclick="filterCheck(2);" data-order="asc">
                            <div class="dot"><i class="fa-solid fa-circle-check"></i></div>
                            <p>ID tăng dần</p>
                        </div>
                        <div class="filter-button" onclick="filterCheck(3);" data-order="ascAlphabetical">
                            <div class="dot"><i class="fa-solid fa-circle-dot"></i></div>
                            <p>A-Z tăng dần</p>
                        </div>
                        <div class="filter-button" onclick="filterCheck(4);" data-order="descAlphabetical">
                            <div class="dot"><i class="fa-solid fa-circle-dot"></i></div>
                            <p>A-Z giảm dần</p>
                        </div>
                    </div>
                </div>
                <div class="term">
                    <p class="name">Tìm kiếm</p>
                    <div class="inputs">
                        <input type="text" name="term" value="{{ $terms ?? '' }}">
                    </div>
                </div>
                <div class="records">
                    <p class="name">Số lượng</p>
                    <div class="buttons">
                        <div class="filter-button rec_1" onclick="radioCheck(1);">
                            <span class="dot"><i class="fa-solid fa-square-xmark"></i></span>
                            <p>20 mục</p>
                        </div>
                        <div class="filter-button rec_2" onclick="radioCheck(2);">
                            <span class="dot"><i class="fa-regular fa-square"></i></span>
                            <p>50 mục</p>
                        </div>
                        <div class="filter-button rec_3" onclick="radioCheck(3);">
                            <span class="dot"><i class="fa-regular fa-square"></i></span>
                            <p>100 mục</p>
                        </div>
                        <div class="filter-button rec_4" onclick="radioCheck(4);">
                            <span class="dot"><i class="fa-regular fa-square"></i></span>
                            <p>Tất cả</p>
                        </div>
                    </div>
                </div>
                <div class="filter-button show_results">
                    <p>Áp dụng bộ lọc</p>
                </div>
                <form style="display: none" id="filter_form">
                    <input type="text" id="term" name="q" value="{{ $terms ?? '' }}">
                    <input type="text" id="order" name="order" value="{{ $order ?? 'desc' }}">
                    <input type="text" id="limit" name="limit" value="{{ $limit ?? 20 }}">
                </form>
            </div>
        </div>
        <div class="layout-inner">
            <table class="min-w-full">
                <thead>
                <tr>
                    <th class="px-6 py-3 border-b">Tiêu đề</th>
                    <th class="px-6 py-3 border-b">Đường dẫn</th>
                    <th class="px-6 py-3 border-b">Trạng thái</th>
                    <th class="px-6 py-3 border-b">Hành động</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pages as $page)
                    <tr>
                        <td class="px-6 py-4 border-b">{{ $page->title }}</td>
                        <td class="px-6 py-4 border-b">{{ $page->slug }}</td>
                        <td class="px-6 py-4 border-b">
                            {{ $page->is_published ? 'Hiển thị' : 'Đang ẩn' }}
                        </td>
                        <td class="px-6 py-4 border-b">
                            <x-button href="{{ route('pages.edit', $page->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Sửa</span>
                            </x-button>

                            <x-button action="{{ route('pages.destroy', $page->id) }}" type="delete" />
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

<x-floating-button icon="fa-plus" url="{{ route('pages.create') }}" />
