<x-admin-layout>
    <x-dashboard-navbar route="{{ route('menu.index') }}"/>

    <div class="dashboard">
        <form action="{{ route('menu.store') }}" method="POST" id="create_menu_item">
            @csrf
            <div class="welcome-2">Thêm mục menu</div>
            @if(count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="body_form">
                <!-- Title -->
                <label>Tên mục menu</label>
                <input type="text" name="title" autocomplete="off" value="{{ old('title') }}">

                <!-- URL -->
                <label>Liên kết</label>
                <input type="text" name="url" autocomplete="off" placeholder="https://example.com" value="{{ old('url') }}">

                <!-- Parent Menu -->
                <label>Mục cha</label>
                <select name="parent_id">
                    <option value="">Không có</option>
                    @foreach ($menuItems as $menuItem)
                        <option value="{{ $menuItem->id }}" {{ old('parent_id') == $menuItem->id ? 'selected' : '' }}>
                            {{ $menuItem->title }}
                        </option>
                    @endforeach
                </select>

                <!-- Order -->
                <label>Thứ tự hiển thị</label>
                <input type="number" name="order" autocomplete="off" value="{{ old('order', 0) }}">

                <!-- Status -->
                <label>Trạng thái</label>
                <select name="status">
                    <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ old('status', 1) == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>

                <!-- Submit -->
                <input type="submit" value="Tạo mới">
            </div>
        </form>
    </div>
</x-admin-layout>
