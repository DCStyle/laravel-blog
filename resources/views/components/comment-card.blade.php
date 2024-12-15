<div class="comment">
    <div class="head">
        <div class="basic_info">
            <i class="fa-solid fa-caret-right"></i>
            <p>{{ $comment->name }}</p>
            <p>{{ $comment->created_at->format('d.m.Y H:i') }}</p>
        </div>
        <div class="comment_actions">
            @can('comment-edit')
                <i class="fa-solid fa-circle"></i>
                <a href="{{ route('comments.edit', $comment->id) }}" class="edit">Sửa</a>
            @endcan
            @if(Auth::Check() && ($post->user_id == Auth::id()))
                <x-button action="{{ route('comments.destroy', $comment->id) }}" type="delete" />
            @endif
        </div>
    </div>
    <div class="body">
        {{ $comment->body }}
    </div>
</div>
