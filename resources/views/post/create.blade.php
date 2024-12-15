<x-admin-layout>
    @section('scripts')
        <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
        <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        @vite(['resources/js/post.js', 'resources/js/createPost.js'])
    @endsection

    <x-dashboard-navbar route="{{ route('dashboard') }}"/>

    <div class="post__create">
        <form action="{{ route('posts.store') }}" method="POST" id="form" enctype="multipart/form-data">
            @csrf
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
                            <img src="{{ isset($post) ? ($post->image_path ? asset($post->image_path) : asset('images/picture3.jpg')) : asset('images/picture3.jpg') }}" id="output" alt="image">
                            <input id="image" type="hidden" name="image">
                            <div class="change_image"><i class="fa-solid fa-image"></i> Thay đổi</div>
                        </div>
                        <div class="info">
                            <p class="info_title_length">Tối đa 255 ký tự. <span class='current_title_length'>{{ isset($post) ? Str::length($post->title) : 5 }}/255</span></p>
                            <input type="text" name="title" class="title" autocomplete="off" value="{{ isset($post) ? ($post->title ?? 'Tiêu đề') : 'Tiêu đề' }}">
                            <div class="reading-info">
                                <p class="reading-text">Thời gian đọc: </p>
                                <i class="fa-solid fa-clock"></i>
                                <p class="reading-time">{{ isset($post) ? ($post->read_time ??  0) : 0 }} phút</p>
                                <button type="button" class="calculate" onclick="calculateReadTime();">Tính toán</button>
                            </div>
                            <p class="date">{{ date('d.m.Y') }} bởi {{ Auth::User()->firstname . ' ' . Auth::User()->lastname }}</p>
                        </div>
                    </div>
                </div>
                <div class="post_body">
                    <div id="editor">

                    </div>

                    <textarea name="body" style="display: none" id="hiddenArea">{!! isset($post) ? $post->body : '' !!}</textarea>

                    <div class="actions">
                        <a><i class="fa-solid fa-arrow-left"></i> Trở về trang chủ</a>
                        <a>Bài viết tiếp theo <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="post_options">
                    <div class="header">Tùy chọn bổ sung:</div>
                    <label>Mô tả ngắn</label>
                    <p class="info excerpt_length">Tối đa 510 ký tự. <span class='current_excerpt_length'>{{ isset($post) ? Str::length($post->excerpt) : 0 }}/510</span></p>
                    <textarea name="excerpt">{{ isset($post) ? $post->excerpt  : '' }}</textarea>
                    <label>Hiển thị</label>
                    <div class="published">
                        <p>Đặt trạng thái công khai</p>
                        <label class="switch">
                            <input type="checkbox" name="is_published" {{ isset($post) ? ($post->is_published ? 'checked' : '') : 'checked' }}>
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
                    <input type="hidden" name="id_saved_post" value="{{ isset($post) ? ($post->id ? $post->id : 0) : 0 }}">
                    <div class="create_post_actions">
                        <input type="button" onClick="submitForm();" value="Đăng bài">
                        <div class="save" onClick="savePost();">Lưu</div>
                    </div>
                </div>
            </div>
        </form>
        <x-select-image />
    </div>
</x-admin-layout>
