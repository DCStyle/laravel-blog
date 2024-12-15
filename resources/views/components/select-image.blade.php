<div class="select-image" style="display: none;">
    <div class="option" onclick="selectLocalImage();">
        <i class="fa-solid fa-upload"></i>
        <p>Tải lên<br>từ máy</p>
    </div>
    <div class="option" onclick="selectFromStorage();">
        <i class="fa-solid fa-server"></i>
        <p>Chọn từ<br>thư viện</p>
    </div>
    <div class="browse-images" style="display: none;">
        <div class="back" onclick="hideBrowseImages();"><i class="fa-solid fa-left-long" aria-hidden="true"></i> Quay lại</div>
        <div class="image-list">
            <div class="loading hidden">
                <div class="loader"></div>
            </div>
            <div class="load-images"></div>
        </div>
    </div>
</div>
