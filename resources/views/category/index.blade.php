<x-admin-layout>
    @section('scripts')
        @vite(['resources/js/filtr.js'])
    @endsection

    <x-dashboard-navbar route="{{ route('dashboard') }}"/>

    <div class="categories">
        <div class="filter">
            <div class="filtr_collapse">
                <p class="head">Danh mục</p>
                <i class="fa-solid fa-caret-up button_collapse"></i>
            </div>
            <div class="filtr_body">
                <div class="sort">
                    <p class="name">Sắp xếp</p>
                    <div class="buttons sort_buttons">
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
        <div class="category_list">
            <table>
                <thead>
                <tr>
                    <th scope="col" class="text-left">Danh mục</th>
                    <th scope="col">Số bài viết</th>
                    <th scope="col">Thao tác</th>
                </tr>
                </thead>
                <tbody class="body_user_list">
                @foreach ($categories as $category)
                    <tr>
                        <td data-label="Danh mục" class="text-left">
                            <span class="preview" style="background: {{ $category->backgroundColor }}CC; color: {{ $category->textColor }};">{{ $category->name }} </span>
                        </td>

                        <td data-label="Số bài viết">{{ $category->posts_count }}</td>

                        <td data-label="Thao tác">
                            <x-button href="{{ route('categories.edit', $category->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Sửa
                            </x-button>

                            <x-button action="{{ route('categories.destroy', $category->id) }}" type="delete" />
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $categories->appends([
                 'q' => $terms ?? '',
                 'order' => $order ?? 'desc',
                 'limit' => $limit ?? 20,
            ])->links('pagination.default') }}
        </div>
    </div>
</x-admin-layout>

<x-floating-button icon="fa-plus" url="{{ route('categories.create') }}" />
