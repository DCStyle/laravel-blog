<x-admin-layout>
    <x-dashboard-navbar route="{{ route('menu.index') }}"/>

    <div class="dashboard">
        <form action="{{ route('menu.update', $menuItem->id) }}" method="POST" id="edit_menu_item">
            @csrf
            @method('PUT')
            <div class="welcome-2">Chỉnh sửa mục menu</div>
            @if(count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="body_form">
                <!-- Title -->
                <div class="mb-4">
                    <label>Tên mục menu</label>
                    <input type="text" name="title" autocomplete="off" value="{{ old('title', $menuItem->title) }}">
                </div>

                <!-- URL -->
                <div class="mb-4">
                    <label>Liên kết</label>
                    <input type="text" name="url" autocomplete="off" placeholder="https://example.com" value="{{ old('url', $menuItem->url) }}">
                </div>

                <!-- Parent Menu -->
                <div class="mb-4">
                    <label>Mục cha</label>
                    <select name="parent_id">
                        <option value="">Không có</option>
                        @foreach ($menuItems as $item)
                            <option value="{{ $item->id }}" {{ old('parent_id', $menuItem->parent_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Order -->
                <div class="mb-4">
                    <label>Thứ tự hiển thị</label>
                    <input type="number" name="order" autocomplete="off" value="{{ old('order', $menuItem->order) }}">
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label>Trạng thái</label>
                    <select name="status">
                        <option value="1" {{ old('status', $menuItem->status) == 1 ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('status', $menuItem->status) == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>

                <!-- Submit -->
                <input type="submit" value="Cập nhật">
            </div>
        </form>
    </div>
</x-admin-layout>
