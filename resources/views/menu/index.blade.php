<x-admin-layout>
    @section('scripts')
        @vite(['resources/js/filtr.js'])
    @endsection

    <x-dashboard-navbar route="{{ route('dashboard') }}"/>

    <div class="layout-container">
        <div class="filter">
            <div class="filtr_collapse">
                <p class="head">Mục menu</p>
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
            <table>
                <thead>
                <tr>
                    <th scope="col" class="text-left">Tên</th>
                    <th scope="col">Liên kết</th>
                    <th scope="col">Thứ tự</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Thao tác</th>
                </tr>
                </thead>
                <tbody class="body_user_list">
                @foreach ($menuItems as $menuItem)
                    <tr>
                        <td data-label="Tên" class="text-left">{{ $menuItem->title }}</td>
                        <td data-label="Liên kết">{{ $menuItem->url }}</td>
                        <td data-label="Thứ tự">{{ $menuItem->order }}</td>
                        <td data-label="Trạng thái">{{ $menuItem->status ? 'Hiển thị' : 'Ẩn' }}</td>
                        <td data-label="Thao tác">
                            <x-button href="{{ route('menu.edit', $menuItem->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                                <span>Sửa</span>
                            </x-button>

                            <x-button action="{{ route('menu.destroy', $menuItem->id) }}" type="delete" />
                        </td>
                    </tr>

                    @if(count($menuItem->children))
                        @foreach ($menuItem->children as $child)
                            <tr class="bg-gray-200">
                                <td data-label="Tên" class="text-left">-- {{ $child->title }}</td>
                                <td data-label="Liên kết">{{ $child->url }}</td>
                                <td data-label="Thứ tự">{{ $child->order }}</td>
                                <td data-label="Trạng thái">{{ $child->status ? 'Hiển thị' : 'Ẩn' }}</td>
                                <td data-label="Thao tác">
                                    <x-button href="{{ route('menu.edit', $child->id) }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Sửa</span>
                                    </x-button>

                                    <x-button action="{{ route('menu.destroy', $child->id) }}" type="delete" />
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>

<x-floating-button icon="fa-plus" url="{{ route('menu.create') }}" />
