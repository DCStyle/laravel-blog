<x-admin-layout>
    <x-dashboard-navbar route="{{ route('footer-links.index') }}"/>

    <div class="dashboard">
        <form action="{{ route('footer-links.update', $footerLink->id) }}" method="POST" id="edit_footer_link">
            @csrf
            @method('PUT')

            <div class="welcome-2">Chỉnh sửa liên kết footer</div>

            @if(count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="body_form">
                <!-- Title -->
                <label>Tên liên kết</label>
                <input type="text" name="title" autocomplete="off" value="{{ old('title', $footerLink->title) }}" placeholder="Nhập tên liên kết">

                <!-- URL -->
                <label>Liên kết</label>
                <input type="text" name="url" autocomplete="off" placeholder="https://example.com" value="{{ old('url', $footerLink->url) }}">

                <!-- Order -->
                <label>Thứ tự hiển thị</label>
                <input type="number" name="order" autocomplete="off" value="{{ old('order', $footerLink->order) }}">

                <!-- Status -->
                <label>Trạng thái</label>
                <select name="status">
                    <option value="1" {{ old('status', $footerLink->status) == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ old('status', $footerLink->status) == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>

                <!-- Submit -->
                <input type="submit" value="Cập nhật">
            </div>
        </form>
    </div>
</x-admin-layout>
