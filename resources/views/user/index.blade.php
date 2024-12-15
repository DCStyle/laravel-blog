<x-admin-layout>
    @section('scripts')
        @vite(['resources/js/filtr.js'])
    @endsection

    <x-dashboard-navbar route="{{ route('dashboard') }}"/>

    <div class="users">
        <div class="filter">
            <div class="filtr_collapse">
                <p class="head">Người dùng</p>
                <i class="fa-solid fa-caret-up button_collapse"></i>
            </div>
            <div class="filtr_body">
                <div class="sort">
                    <p class="name">Sắp xếp</p>
                    <div class="buttons sort_buttons">
                        <div class="filter-button active" onclick="filterCheck(1);" data-order="desc">
                            <div class="dot"><i class="fa-solid fa-circle-check"></i></div>
                            <p>Mới nhất</p>
                        </div>
                        <div class="filter-button" onclick="filterCheck(2);" data-order="asc">
                            <div class="dot"><i class="fa-solid fa-circle-dot"></i></div>
                            <p>Cũ nhất</p>
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
        <div class="users_list">
            <table>
                <thead>
                <tr>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Họ</th>
                    <th scope="col">Email</th>
                    <th scope="col" style="width:125px;">Thao tác</th>
                </tr>
                </thead>
                <tbody class="body_user_list">
                @foreach ($users as $key => $user)
                    <tr>
                        <td data-label="Ảnh"><img src="{{ asset($user->image_path) }}" alt="{{ $user->firstname }}"></td>
                        <td data-label="Tên">{{ $user->firstname }}</td>
                        <td data-label="Họ">{{ $user->lastname }}</td>
                        <td data-label="Email">{{ $user->email }}</td>
                        <td data-label="Thao tác">
                            <a href="{{ route('users.edit', $user->id) }}" class="edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            @if(Auth::id() == $user->id)
                                <button class="delete" onClick="cannot('Không thể xóa tài khoản của bạn!')"><i class="fa-solid fa-trash"></i></a>
                                    @else
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="user_{{ $user->id }}">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                        <button class="delete" onClick="confirmDelete({{ $user->id }}, 'user')"><i class="fa-solid fa-trash"></i></a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $users->appends([
                 'q' => $terms ?? '',
                 'order' => $order ?? 'desc',
                 'limit' => $limit ?? 20,
                 'users' => [],
            ])->links('pagination.default') }}
        </div>
    </div>
    <script>

    </script>
</x-admin-layout>

<x-floating-button icon="fa-plus" url="{{ route('users.create') }}" />
