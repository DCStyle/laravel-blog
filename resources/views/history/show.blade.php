<x-admin-layout>
    @section('scripts')
        @vite('resources/js/history.js')
    @endsection

    <header class="header_post_edit">
        <a href="{{ route('history.index', $id) }}"><i class="fa-solid fa-left-long"></i> Quay lại</a>
        <span class="leave-compare" onclick="leaveCompare();">Thoát so sánh</span>
        <span class="info">Lịch sử bài viết</span>
    </header>

    <div class="post__history">
        <div class="compact-history-list">
            <div class="extend-history" onclick="extend_history();">Hiện lịch sử thu gọn</div>
            <div id="history_list" style="height: 0px; visibility: hidden;">
                @php($autoSave = $historyPosts->where('additional_info', 2)->first())
                @php($lastDate = $autoSave ? $autoSave->updated_at->format('Y-m-d') : null)
                @if ($autoSave)
                    <div class="date">
                        Thay đổi ngày {{ \Carbon\Carbon::parse($lastDate)->translatedFormat('d F, Y') }}
                        <div class="line-v"></div>
                    </div>
                    <div class="history_card h_{{$autoSave->id}} {{(int)$history_id === $autoSave->id ? 'active' : ''}}" onclick="show({{$currentPost->id}}, {{$autoSave->id}});">
                        <img src="{{ asset($autoSave->image_path) }}" alt="">
                        <div class="body">
                            <div class="top-info">
                                @if ($autoSave->category)
                                    <div class="category" style="background: {{ $autoSave->category->backgroundColor }}CC; color: {{ $autoSave->category->textColor }}">{{ $autoSave->category->name }}</div>
                                @endif
                                @if ($autoSave->read_time)
                                    <i class="fa-solid fa-clock"></i>
                                    <p class="reading-time">{{ $autoSave->read_time }} phút</p>
                                @endif
                            </div>
                            <span class="title">{{ $autoSave->title }}</span>
                            <div class="bottom-info">
                                <span class="created"><i class="fa-regular fa-clock"></i> {{ $autoSave->updated_at->diffForHumans() }}, <span class="time">{{ $autoSave->updated_at->format('H:i') }}</span></span>
                                <span class="additional_info"><i class="fa-solid fa-floppy-disk"></i> Tự động lưu</span>
                            </div>
                            <span onclick="compare(event, {{ $autoSave->id }});" class="compare{{(int)$history_id === $autoSave->id ? ' hidden' : '' }}">So sánh <i class="fa-solid fa-right-left"></i></span>
                        </div>
                    </div>
                @endif
                @if($lastDate != $currentPost->updated_at->format('Y-m-d'))
                    @php($lastDate = $currentPost->updated_at->format('Y-m-d'))
                    @if ($autoSave)
                        <div class="date">
                            <div class="line-v"></div>
                            Thay đổi ngày {{ \Carbon\Carbon::parse($lastDate)->translatedFormat('d F, Y') }}
                            <div class="line-v"></div>
                        </div>
                    @else
                        <div class="date">
                            Thay đổi ngày {{ \Carbon\Carbon::parse($currentPost->updated_at)->translatedFormat('d F, Y') }}
                            <div class="line-v"></div>
                        </div>
                    @endif
                @else
                    <div class="margin-10"> </div>
                @endif
                <div onclick="show({{$currentPost->id}}, 'current');" class="history_card{{ $history_id === 'current' ? ' active' : '' }} h_0">
                    <img src="{{ asset($currentPost->image_path) }}" alt="">
                    <div class="body">
                        <div class="top-info">
                            @if ($currentPost->category)
                                <div class="category" style="background: {{ $currentPost->category->backgroundColor }}CC; color: {{ $currentPost->category->textColor }}">{{ $currentPost->category->name }}</div>
                            @endif
                            @if ($currentPost->read_time)
                                <i class="fa-solid fa-clock"></i>
                                <p class="reading-time">{{ $currentPost->read_time }} phút</p>
                            @endif
                        </div>
                        <span class="title">{{ $currentPost->title }}</span>
                        <div class="bottom-info">
                            <span class="created"><i class="fa-regular fa-clock"></i> {{ $currentPost->updated_at->diffForHumans() }}, <span class="time">{{ $currentPost->updated_at->format('H:i') }}</span></span>
                            <span class="additional_info"><i class="fa-solid fa-bolt"></i> Hiện tại</span>
                            <span class="additional_info">{!! $currentPost->additional_info == 1 ? '<i class="fa-solid fa-clock-rotate-left"></i> Đã khôi phục' : '' !!}</span>
                        </div>
                        @if ($currentPost->changelog)
                            <div class="changelog-info">
                                <span class="user"><i class="fa-solid fa-user"></i> {{ $currentPost->changeUser->firstname . ' ' . $currentPost->changeUser->lastname }}</span>
                                <span class="changelog"><i class="fa-solid fa-square-pen"></i> <span class="text">{{ $currentPost->changelog }}</span></span>
                            </div>
                        @endif
                        <span onclick="compare(event, 'current');" class="compare{{ $history_id === 'current' ? ' hidden' : '' }}">So sánh <i class="fa-solid fa-right-left"></i></span>
                    </div>
                </div>
                @foreach($historyPosts as $historyPost)
                    @php($postDate = $historyPost->updated_at->format('Y-m-d'))
                    @if($lastDate != $postDate && $historyPost->additional_info != 2)
                        @php($lastDate = $postDate)
                        <div class="date">
                            <div class="line-v"></div>
                            Thay đổi ngày {{ \Carbon\Carbon::parse($postDate)->translatedFormat('d F, Y') }}
                            <div class="line-v"></div>
                        </div>
                    @elseif($historyPost->additional_info == 2)
                        @continue
                    @else
                        <div class="margin-10"> </div>
                    @endif

                    <div class="history_card h_{{$historyPost->id}} {{(int)$history_id === $historyPost->id ? 'active' : ''}}" onclick="show({{$currentPost->id}}, {{$historyPost->id}});">
                        <img src="{{ asset($historyPost->image_path) }}" alt="">
                        <div class="body">
                            <div class="top-info">
                                @if ($historyPost->category)
                                    <div class="category" style="background: {{ $historyPost->category->backgroundColor }}CC; color: {{ $historyPost->category->textColor }}">{{ $historyPost->category->name }}</div>
                                @endif
                                @if ($historyPost->read_time)
                                    <i class="fa-solid fa-clock"></i>
                                    <p class="reading-time">{{ $historyPost->read_time }} phút</p>
                                @endif
                            </div>
                            <span class="title">{{ $historyPost->title }}</span>
                            <div class="bottom-info">
                                <span class="created"><i class="fa-regular fa-clock"></i> {{ $historyPost->updated_at->diffForHumans() }}, <span class="time">{{ $historyPost->updated_at->format('H:i') }}</span></span>
                                <span class="additional_info">{!! $historyPost->additional_info == 1 ? '<i class="fa-solid fa-clock-rotate-left"></i> Đã khôi phục' : '' !!}{!! $historyPost->additional_info == 2 ? '<i class="fa-solid fa-floppy-disk"></i> Tự động lưu' : '' !!}</span>
                            </div>
                            @if ($historyPost->changelog)
                                <div class="changelog-info">
                                    <span class="user"><i class="fa-solid fa-user"></i> {{ $historyPost->changeUser->firstname . ' ' . $historyPost->changeUser->lastname }}</span>
                                    <span class="changelog"><i class="fa-solid fa-square-pen"></i> <span class="text">{{ $historyPost->changelog }}</span></span>
                                </div>
                            @endif
                            @if ($historyPost->additional_info !== 2)
                                <span class="actions{{(int)$history_id === $historyPost->id ? '' : ' hidden' }}">
                                    <span onClick="revert({{ $id }}, {{ $historyPost->id }});">Khôi phục <i class="fa-solid fa-clock-rotate-left"></i></span>
                                </span>
                            @endif
                            <span onclick="compare(event, {{ $historyPost->id }});" class="compare{{(int)$history_id === $historyPost->id ? ' hidden' : '' }}">So sánh <i class="fa-solid fa-right-left"></i></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <aside class="post__preview" id="first_post">
            <div class="post_container">
                <div class="top">
                    <img src="{{ asset($post->image_path) }}" class="output" alt="image">
                    <div class="info">
                        <p class="preview_title">{{ $post->title }}</p>
                        @isset($post->category)
                            <div class="category" style="background: {{ $post->category->backgroundColor }}CC; color: {{ $post->category->textColor }}">{{ $post->category->name }}</div>
                        @else
                            <div class="category"></div>
                        @endisset
                        @isset($post->read_time)
                            <div class="reading-info">
                                <p class="reading-text">Thời gian đọc: </p>
                                <i class="fa-solid fa-clock"></i>
                                <p class="reading-time">{{ $post->read_time }} phút</p>
                            </div>
                        @else
                            <div class="reading-info"></div>
                        @endisset
                        <p class="date">{{ $post->updated_at->format('d.m.Y') }} bởi {{ $post->user->firstname . ' ' . $post->user->lastname }}</p>
                    </div>
                </div>
            </div>
            <div class="post_body">
                {!! $post->body !!}

                <div class="actions">
                    <a><i class="fa-solid fa-arrow-left"></i> Trở về trang chủ</a>
                    <a>Bài viết tiếp theo <i class="fa-solid fa-arrow-right"></i></a>
                </div>

            </div>
            <div class="post_options">
                <div class="header">Tùy chọn bổ sung:</div>
                <label>Mô tả ngắn</label>
                <div class="excerpt">{{ isset($post) ? $post->excerpt  : '' }}</div>
                <label>Hiển thị</label>
                <div class="published">
                    <p>Đặt trạng thái công khai</p>
                    <label class="switch">
                        <input type="checkbox" name="is_published" {{ isset($post) ? ($post->is_published ? 'checked' : '') : 'checked' }} disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </aside>
        <aside class="post__preview" id="second_post" style="display: none;">
            <div class="post_container">
                <div class="top">
                    <img src="{{ asset('images/posts/picture.jpg') }}" class="output" alt="image">
                    <div class="info">
                        <p class="preview_title"></p>
                        <div class="category"></div>
                        <div class="reading-info">
                            <p class="reading-text">Thời gian đọc: </p>
                            <i class="fa-solid fa-clock"></i>
                            <p class="reading-time">0 phút</p>
                        </div>
                        <p class="date">01.01.2024 bởi {{ $post->user->firstname . ' ' . $post->user->lastname }}</p>
                    </div>
                </div>
            </div>
            <div class="post_body">

            </div>
            <div class="post_options">
                <div class="header">Tùy chọn bổ sung:</div>
                <label>Mô tả ngắn</label>
                <div class="excerpt"></div>
                <label>Hiển thị</label>
                <div class="published">
                    <p>Đặt trạng thái công khai</p>
                    <label class="switch">
                        <input type="checkbox" name="is_published" disabled>
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </aside>
        <div class="loading hidden">
            <div class="loader"></div>
        </div>
        <div onclick="switchShowCompare();" class="switch-compare">Chuyển đổi</div>
    </div>
</x-admin-layout>
