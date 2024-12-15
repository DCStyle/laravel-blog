<x-admin-layout :edit="true">
    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
        @vite(['resources/js/post.js'])
        @vite(['resources/js/editPost.js'])
    @endsection

    <header class="header_post_edit">
        <a href="{{ route('posts.index') }}"><i class="fa-solid fa-left-long"></i> Quay lại</a>
        <div class="edit_post_actions">
            <x-button action="{{ route('posts.destroy', $post->id) }}" type="delete" />

            <a href="{{ route('history.index', $post->id) }}" class="history">
                <span class="text">Lịch sử</span>
                <span class="icon">
                    <i class="fa fa-history"></i>
                </span>
            </a>

            <div class="submit" onClick="submitForm();">
                <span class="text">Đăng bài</span>
                <span class="icon">
                    <i class="fa fa-upload"></i>
                </span>
            </div>
        </div>
    </header>

    <div class="post__create post__edit">
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            @method('PATCH')
            <div id="content" data-image-url="{{route('images.store')}}">
                <div class="post_container">
                    @if(count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="top">
                        <div class="image">
                            <img src="{{ asset($post->image_path) }}" id="output" alt="image">
                            <input id="image" type="hidden" name="image">
                            <div class="change_image"><i class="fa-solid fa-image"></i> Thay đổi</div>
                        </div>
                        <div class="info">
                            <p class="info_title_length">Tối đa 255 ký tự. <span class='current_title_length'>{{ Str::length($post->title) }}/255</span></p>
                            <input type="text" name="title" class="title" autocomplete="off" value="{{ $post->title }}">
                            <div class="reading-info">
                                <p class="reading-text">Thời gian đọc: </p>
                                <i class="fa-solid fa-clock"></i>
                                <p class="reading-time">{{ $post->read_time ? $post->read_time : 0 }} phút</p>
                                <button type="button" class="calculate" onclick="calculateReadTime();">Tính toán</button>
                            </div>
                            <p class="date">{{ $post->updated_at->format('d.m.Y') }} bởi {{ $post->user->firstname . ' ' . $post->user->lastname }}</p>
                        </div>
                    </div>
                </div>
                <div class="post_body">
                    <div id="editor"></div>
                    <textarea name="body" style="display: none" id="hiddenArea">{!! $post->body !!}</textarea>

                    <div class="actions">
                        <a><i class="fa-solid fa-arrow-left"></i> Trở về trang chủ</a>
                        <a>Bài viết tiếp theo <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="post_options">
                    <div class="header">Tùy chọn bổ sung:</div>
                    <label>Mô tả ngắn</label>
                    <p class="info excerpt_length">Tối đa 510 ký tự. <span class='current_excerpt_length'>{{ Str::length($post->excerpt) }}/510</span></p>
                    <textarea name="excerpt">{{ $post->excerpt }}</textarea>
                    <label>Hiển thị</label>
                    <div class="published">
                        <p>Đặt trạng thái công khai</p>
                        <label class="switch">
                            <input type="checkbox" name="is_published" {{ $post->is_published == true ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <label>Danh mục</label>
                    @isset($post)
                        @isset($post->category)
                            <div class="category-selected" style="border: none; background: {{ $post->category->backgroundColor }}CC; color: {{ $post->category->textColor }}">{{ $post->category->name }}</div>
                        @else
                            <div class="category-selected">Chưa chọn</div>
                        @endisset
                    @else
                        <div class="category-selected">Chưa chọn</div>
                    @endisset
                    <p class="categories_extend" onclick="categoriesToggle();">Ẩn <i class="fa-solid fa-chevron-up"></i></p>
                    <div class="categories_list">
                        @foreach($categories as $category)
                            <div class="category" style="background: {{ $category->backgroundColor }}CC; color: {{ $category->textColor }}" onclick="changeToCategory(event, {{ $category->id }})" data-id="{{ $category->id }}">{{ $category->name }}</div>
                        @endforeach
                    </div>
                    <input type="hidden" name="category_id" value="{{ isset($post) ? ($post->category ? $post->category->id : 0) : 0 }}"/>
                    <div class="auto-save-info">

                    </div>
                </div>
        </form>
        <x-select-image />
    </div>
    @if ($hasAutoSave)
        <script type="module">
            detectedAutoSave();
        </script>
    @endif
</x-admin-layout>
