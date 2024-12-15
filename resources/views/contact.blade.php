<x-main-layout>
    <div class="article">
        <div class="contact_form">
            <div class="leave_message">Gửi tin nhắn!</div>
            <div class="body_form">
                <img src="{{ asset('images/open.png') }}" alt="">
                <form method="POST">
                    <label>Tên</label>
                    <input type="text" name="name">
                    <label>Email</label>
                    <input type="email" name="email">
                    <label>Tin nhắn</label>
                    <textarea name="body"></textarea>
                    <input type="submit" value="Gửi">
                </form>
            </div>
        </div>
    </div>
</x-main-layout>
