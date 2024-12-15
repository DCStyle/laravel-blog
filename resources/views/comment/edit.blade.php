<x-admin-layout>

    <x-dashboard-navbar route="{{ route('comments.index') }}"/>

    <div class="dashboard">
        <form action="{{ route('comments.update', $comment->id) }}" id="edit_comment" method="POST">
            @csrf
            @method('PATCH')
            <div class="welcome-2">Chỉnh sửa bình luận</div>
            <div class="body_form">
                <label>Họ và tên</label>
                <input type="text" name="name" autocomplete="off" value="{{ $comment->name }}">
                <label>Nội dung</label>
                <textarea name="body">{{ $comment->body }}</textarea>
                <input type="submit" value="Cập nhật">
            </div>
        </form>
    </div>
</x-admin-layout>
