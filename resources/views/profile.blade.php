<x-main-layout>
    <div class="article">
        <div class="profile_form">
            <div class="edit_profile">Chỉnh sửa hồ sơ</div>
            <div class="body_form">
                <form action="{{ route('users.update', Auth::User()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    @if(count($errors) > 0)
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="profile_file">
                        <img src="{{ asset(Auth::User()->image_path) }}" id="output" alt="profile">
                        <span class="change" onClick="document.getElementById('profile_update_form_profile_image').click()"><i class="fa-solid fa-image"></i></span>
                    </div>
                    <input type="file" name="image" id="profile_update_form_profile_image"  accept="image/*" onchange="loadFile(event)" style="display: none;">
                    <label>Tên</label>
                    <input type="text" name="firstname" value="{{ Auth::User()->firstname }}">
                    <label>Họ</label>
                    <input type="text" name="lastname" value="{{ Auth::User()->lastname }}">
                    <label>Email</label>
                    <p>Vui lòng liên hệ Quản trị viên để thay đổi email</p>
                    <input type="email" value="{{ Auth::User()->email }}" disabled>
                    <label>Mật khẩu</label>
                    <input type="password" name="password">
                    <label>Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation">
                    <input type="hidden" name="profile_update" value="True">
                    <input type="submit" value="Cập nhật">
                </form>
            </div>
        </div>
    </div>
    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>
</x-main-layout>
