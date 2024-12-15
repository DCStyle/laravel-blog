<x-admin-layout>
    <header class="header_post_edit">
        <a href="{{ route('posts.edit', $id) }}"><i class="fa-solid fa-left-long"></i> Quay lại</a>
        <span class="info">Lịch sử bài viết</span>
    </header>
    <div class="history-list">
        @php($autoSave = $posts->where('additional_info', 2)->first())
        @php($lastDate = $autoSave ? $autoSave->updated_at->format('Y-m-d') : null)
        @if ($autoSave)
            <div class="date">
                Thay đổi ngày {{ \Carbon\Carbon::parse($lastDate)->translatedFormat('d F, Y') }}
                <div class="line-v"></div>
            </div>
            <a href="{{ route('history.show', [$id, $autoSave->id]) }}">
                <div class="history_card">
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
                        <span class="excerpt">{{ $autoSave->excerpt }}</span>
                        <div class="bottom-info">
                            <span class="created"><i class="fa-regular fa-clock"></i> {{ $autoSave->updated_at->diffForHumans() }}, <span class="time">{{ $autoSave->updated_at->format('H:i') }}</span></span>
                            <span class="additional_info"><i class="fa-solid fa-floppy-disk"></i> Tự động lưu</span>
                        </div>
                        @if ($autoSave->changelog)
                            <div class="changelog-info">
                                <span class="user"><i class="fa-solid fa-user"></i> {{ $autoSave->changeUser->firstname . ' ' . $autoSave->changeUser->lastname }}</span>
                                <span class="changelog"><i class="fa-solid fa-square-pen"></i> <span class="text">{{ $autoSave->changelog }}</span></span>
                            </div>
                        @endif
                    </div>
                </div>
            </a>
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
        <a href="{{ route('history.show', [$id, 'current']) }}">
            <div class="history_card">
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
                    <span class="excerpt">{{ $currentPost->excerpt }}</span>
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
                </div>
            </div>
        </a>

        @if (count($posts) > 0)
            @foreach ($posts as $post)
                @php($postDate = $post->updated_at->format('Y-m-d'))
                @if($lastDate != $postDate && $post->additional_info != 2)
                    @php($lastDate = $postDate)
                    <div class="date">
                        <div class="line-v"></div>
                        Thay đổi ngày {{ \Carbon\Carbon::parse($postDate)->translatedFormat('d F, Y') }}
                        <div class="line-v"></div>
                    </div>
                @elseif($post->additional_info == 2)
                    @continue
                @else
                    <div class="margin-10"> </div>
                @endif
                <a href="{{ route('history.show', [$id, $post->id]) }}">
                    <div class="history_card">
                        <img src="{{ asset($post->image_path) }}" alt="">
                        <div class="body">
                            <div class="top-info">
                                @if ($post->category)
                                    <div class="category" style="background: {{ $post->category->backgroundColor }}CC; color: {{ $post->category->textColor }}">{{ $post->category->name }}</div>
                                @endif
                                @if ($post->read_time)
                                    <i class="fa-solid fa-clock"></i>
                                    <p class="reading-time">{{ $post->read_time }} phút</p>
                                @endif
                            </div>
                            <span class="title">{{ $post->title }}</span>
                            <span class="excerpt">{{ $post->excerpt }}</span>
                            <div class="bottom-info">
                                <span class="created"><i class="fa-regular fa-clock"></i> {{ $post->updated_at->diffForHumans() }}, <span class="time">{{ $post->updated_at->format('H:i') }}</span></span>
                                @if($post->additional_info)
                                    <span class="additional_info">{!! $post->additional_info == 1 ? '<i class="fa-solid fa-clock-rotate-left"></i> Đã khôi phục' : '' !!}</span>
                                @endif
                            </div>
                            @if ($post->changelog)
                                <div class="changelog-info">
                                    <span class="user"><i class="fa-solid fa-user"></i> {{ $post->changeUser->firstname . ' ' . $post->changeUser->lastname }}</span>
                                    <span class="changelog"><i class="fa-solid fa-square-pen"></i> <span class="text">{{ $post->changelog }}</span></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</x-admin-layout>
