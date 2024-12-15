<x-admin-layout>
    <x-dashboard-navbar route="{{ route('categories.index') }}"/>

    <div class="dashboard">
        <form action="{{ isset($category)
                        ? route('categories.update', $category->id)
                        : route('categories.store')
                    }}"
              method="POST"
              id="edit_category"
              class="w-full"
        >
            @csrf
            @isset($category)
                @method('PUT')
            @endisset

            <div class="welcome-2">{{ isset($category) ? 'Chỉnh sửa danh mục' : 'Thêm danh mục' }}</div>

            <div class="body_form">
                @if(count($errors) > 0)
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <label>Tên danh mục</label>
                <input
                    type="text"
                    name="name"
                    autocomplete="off"
                    value="{{ old('name', $category->name ?? '') }}"
                    class="mb-4"
                >

                <div class="mb-4 flex items-center justify-stretch space-x-4">
                    <div>
                        <label>Màu nền</label>
                        <input
                            type="text"
                            name="backgroundColor"
                            autocomplete="off"
                            value="{{ old('backgroundColor', $category->backgroundColor ?? '') }}"
                            data-coloris
                            class="!m-0 cursor-pointer"
                        >
                    </div>

                    <div>
                        <label>Màu chữ</label>
                        <input
                            type="text"
                            name="textColor"
                            autocomplete="off"
                            value="{{ old('textColor', $category->textColor ?? '') }}"
                            data-coloris
                            class="!m-0 cursor-pointer"
                        >
                    </div>
                </div>

                <input type="submit" value="{{ isset($category) ? 'Cập nhật' : 'Thêm' }}">
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css"/>
    <script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>
</x-admin-layout>
