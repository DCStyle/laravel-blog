<x-admin-layout>
    <x-dashboard-navbar route="{{ route('homepage-blocks.index') }}"/>

    <div class="dashboard">
        <form class="w-full" action="{{ isset($homepageBlock) ? route('homepage-blocks.update', $homepageBlock) : route('homepage-blocks.store') }}" method="POST">
            @csrf
            @isset($homepageBlock)
                @method('PUT')
            @endisset

            <div class="welcome-2">{{ isset($homepageBlock) ? 'Sửa' : 'Thêm' }} Block trang chủ</div>
            @if(count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="body_form">
                <label for="title" class="block font-bold">Tiêu đề</label>
                <input type="text" name="title" id="title" value="{{ old('title', $homepageBlock->title ?? '') }}" class="form-input">

                <label for="type" class="block font-bold">Loại</label>
                <select name="type" id="type" class="form-select">
                    <option value="highlight_posts" {{ old('type', $homepageBlock->type ?? '') === 'highlight_posts' ? 'selected' : '' }}>Bài viết nổi bật</option>
                    <option value="category" {{ old('type', $homepageBlock->type ?? '') === 'category' ? 'selected' : '' }}>Danh mục</option>
                    <option value="html" {{ old('type', $homepageBlock->type ?? '') === 'html' ? 'selected' : '' }}>HTML</option>
                </select>

                <!-- Cài đặt động -->
                <div id="settings-container">
                    <!-- Cài đặt bài viết nổi bật -->
                    <div id="highlight-posts-settings" class="settings-group hidden">
                        <div class="mb-4">
                            <label for="highlight_posts_number" class="block font-bold">Số lượng bài viết</label>
                            <input type="number" name="settings[number_of_posts]" id="highlight_posts_number" value="{{ old('settings.number_of_posts', $homepageBlock->settings->number_of_posts ?? 5) }}" class="form-input">
                        </div>
                    </div>

                    <!-- Cài đặt danh mục -->
                    <div id="category-settings" class="settings-group hidden">
                        <div class="mb-4">
                            <label for="category_ids" class="block font-bold">Danh mục</label>
                            <select name="settings[category_ids][]" id="category_ids" class="form-multiselect" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, old('settings.category_ids', $homepageBlock->settings->category_ids ?? [])) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="category_display_style" class="block font-bold">Kiểu hiển thị</label>
                            <select name="settings[display_style]" id="category_display_style" class="form-select">
                                <option value="list" {{ old('settings.display_style', $homepageBlock->settings->display_style ?? '') === 'list' ? 'selected' : '' }}>Dạng danh sách</option>
                                <option value="2_columns" {{ old('settings.display_style', $homepageBlock->settings->display_style ?? '') === '2_columns' ? 'selected' : '' }}>2 cột</option>
                                <option value="3_columns" {{ old('settings.display_style', $homepageBlock->settings->display_style ?? '') === '3_columns' ? 'selected' : '' }}>3 cột</option>
                                <option value="grid" {{ old('settings.display_style', $homepageBlock->settings->display_style ?? '') === 'grid' ? 'selected' : '' }}>Dạng lưới</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="category_number_of_posts" class="block font-bold">Số lượng bài viết</label>
                            <input type="number" name="settings[number_of_posts]" id="category_number_of_posts" value="{{ old('settings.number_of_posts', $homepageBlock->settings->number_of_posts ?? 5) }}" class="form-input">
                        </div>

                        <div class="mb-4">
                            <label for="category_order" class="block font-bold">Xếp theo</label>
                            <select name="settings[post_order]" id="category_order" class="form-select">
                                <option value="latest" {{ old('settings.post_order', $homepageBlock->settings->post_order ?? '') === 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="oldest" {{ old('settings.post_order', $homepageBlock->settings->post_order ?? '') === 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                                <option value="random" {{ old('settings.post_order', $homepageBlock->settings->post_order ?? '') === 'random' ? 'selected' : '' }}>Ngẫu nhiên</option>
                            </select>
                        </div>
                    </div>

                    <!-- Cài đặt HTML -->
                    <div id="html-settings" class="settings-group hidden">
                        <div class="mb-4">
                            <label for="html_content" class="block font-bold">HTML</label>
                            <textarea name="settings[html]" id="html_content" rows="6" class="hidden">{{ old('settings.html', $homepageBlock->settings->html ?? '') }}</textarea>
                            <div id="code-editor"></div>
                        </div>
                    </div>
                </div>

                <!-- Trạng thái hiển thị -->
                <div class="flex items-center mb-4">
                    <input id="is_visible" type="checkbox" name="is_visible" {{ old('is_visible', $homepageBlock->is_visible ?? true) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_visible" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Hiển thị</label>
                </div>
            </div>

            <input type="submit" class="btn btn-primary" value="{{ isset($homepageBlock) ? 'Cập nhật' : 'Thêm mới' }}" />
        </form>
    </div>

    <!-- CodeMirror CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.css">

    <!-- Optional Theme -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/theme/material.min.css">

    <!-- CodeMirror JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/codemirror.min.js"></script>

    <!-- Optional Modes -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.5/mode/javascript/javascript.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const settingsGroups = document.querySelectorAll('.settings-group');
            const htmlTextarea = document.getElementById('html_content');
            let codeEditor;

            const toggleSettings = () => {
                settingsGroups.forEach(group => group.classList.add('hidden'));
                const selectedType = typeSelect.value;

                if (selectedType === 'highlight_posts') {
                    document.getElementById('highlight-posts-settings').classList.remove('hidden');
                } else if (selectedType === 'category') {
                    document.getElementById('category-settings').classList.remove('hidden');
                } else if (selectedType === 'html') {
                    document.getElementById('html-settings').classList.remove('hidden');
                    if (!codeEditor) {
                        codeEditor = CodeMirror(document.getElementById('code-editor'), {
                            value: htmlTextarea.value,
                            mode: 'htmlmixed',
                            lineNumbers: true,
                            theme: 'material',
                            lineWrapping: true,
                        });

                        // Sync CodeMirror content with the hidden textarea
                        codeEditor.on('change', function () {
                            htmlTextarea.value = codeEditor.getValue();
                        });
                    }
                }
            };

            const detectLanguage = () => {
                const content = htmlTextarea.value;
                const detectedMode = CodeMirror.findModeByMIME('text/html'); // Default mode

                // Set the detected mode
                if (detectedMode) {
                    codeEditor.setOption('mode', detectedMode.mode);
                    CodeMirror.autoLoadMode(codeEditor, detectedMode.mode);
                }
            };

            // Initial setup
            toggleSettings();

            // Add event listeners
            typeSelect.addEventListener('change', toggleSettings);
            htmlTextarea.addEventListener('input', detectLanguage);
        });
    </script>
</x-admin-layout>
