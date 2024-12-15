<x-admin-layout :edit="true">
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
        @vite(['resources/js/page.js'])
    @endsection

    <x-dashboard-navbar route="{{ route('pages.index') }}"/>

    <div class="dashboard !block">
        <form action="{{ isset($page) ? route('pages.update', $page->id) : route('pages.store') }}" method="POST" id="edit_page">
            @csrf
            @isset($page)
                @method('PUT')
            @endisset

            <div class="welcome-2">
                {{ isset($page) ? 'Chỉnh sửa trang' : 'Thêm trang mới' }}
            </div>

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
                    <label>Tên trang</label>
                    <input type="text" name="title" autocomplete="off" value="{{ old('title', $page->title ?? '') }}">
                </div>

                <!-- Slug -->
                @isset($page)
                    <div class="mb-4">
                        <label>Đường dẫn</label>
                        <input type="text" name="slug" autocomplete="off" placeholder="Đường dẫn" value="{{ old('slug', $page->slug) }}">
                    </div>
                @endisset

                <!-- Order -->
                <div class="mb-4">
                    <label>Nội dung</label>

                    <div id="editor"></div>
                    <textarea name="content" style="display: none" id="hiddenArea">{!! old('content', $page->content ?? '') !!}</textarea>
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label>Trạng thái</label>
                    <select name="is_published">
                        <option value="1" {{ old('is_published', $page->is_published ?? 1) == 1 ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ old('is_published', $page->is_published ?? 0) == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>

                <!-- Submit -->
                <input type="submit" value="{{ isset($page) ? 'Cập nhật' : 'Thêm' }}">
            </div>
        </form>

        <x-select-image />
    </div>
</x-admin-layout>
