<x-admin-layout>
    <x-dashboard-navbar route="{{ route('dashboard') }}" />

    <div class="dashboard !block">
        <form id="settingsForm" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="text-2xl font-bold mb-6">Cấu hình chung</div>

            <div id="alertMessage" class="hidden mb-4 p-4 rounded"></div>

            <!-- Tabs -->
            <div class="mb-6 border-b border-gray-200">
                <nav class="flex space-x-4" aria-label="Tabs">
                    <button type="button" class="tab-button px-4 py-2 text-sm font-medium rounded-t-lg active" data-tab="general">
                        Thông tin chung
                    </button>
                    <button type="button" class="tab-button px-4 py-2 text-sm font-medium rounded-t-lg" data-tab="media">
                        Logo & Favicon
                    </button>
                    <button type="button" class="tab-button px-4 py-2 text-sm font-medium rounded-t-lg" data-tab="social">
                        Mạng xã hội
                    </button>
                </nav>
            </div>

            <!-- General Tab -->
            <div class="tab-content active" id="general">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Tên trang web</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Mô tả trang web</label>
                        <textarea name="site_description" rows="3"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $settings['site_description'] ?? '' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Từ khóa Meta</label>
                        <textarea name="site_meta_keywords" rows="2"
                                  class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $settings['site_meta_keywords'] ?? '' }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Email liên hệ</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Copyright</label>
                        <input type="text" name="copyright_text" value="{{ $settings['copyright_text'] ?? '' }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>

            <!-- Media Tab -->
            <div class="tab-content hidden" id="media">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Logo</label>
                        <div class="flex items-center space-x-4">
                            <div class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden">
                                <img id="logoPreview" src="{{ $settings['logo'] ?? 'https://placehold.co/400' }}"
                                     class="w-full h-full object-contain">
                            </div>
                            <input type="file" name="logo" id="logoInput" class="hidden" accept="image/*">
                            <button type="button" onclick="document.getElementById('logoInput').click()"
                                    class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                                Chọn logo
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Favicon</label>
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden">
                                <img id="faviconPreview" src="{{ $settings['favicon'] ?? 'https://placehold.co/10' }}"
                                     class="w-full h-full object-contain">
                            </div>
                            <input type="file" name="favicon" id="faviconInput" class="hidden" accept="image/*">
                            <button type="button" onclick="document.getElementById('faviconInput').click()"
                                    class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">
                                Chọn favicon
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Tab -->
            <div class="tab-content hidden" id="social">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Facebook</label>
                        <input type="text" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Instagram</label>
                        <input type="text" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Twitter</label>
                        <input type="text" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Youtube</label>
                        <input type="text" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Lưu cấu hình
                </button>
            </div>
        </form>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tab switching
                const tabs = document.querySelectorAll('.tab-button');
                const contents = document.querySelectorAll('.tab-content');

                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        // Remove active class from all tabs and contents
                        tabs.forEach(t => t.classList.remove('active', 'bg-gray-100'));
                        contents.forEach(c => c.classList.add('hidden'));

                        // Add active class to clicked tab and show content
                        tab.classList.add('active', 'bg-gray-100');
                        document.getElementById(tab.dataset.tab).classList.remove('hidden');
                    });
                });

                // Image preview
                function handleImagePreview(input, previewId) {
                    input.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById(previewId).src = e.target.result;
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                }

                handleImagePreview(document.getElementById('logoInput'), 'logoPreview');
                handleImagePreview(document.getElementById('faviconInput'), 'faviconPreview');
            });
        </script>
    @endsection

    <style>
        .tab-button.active {
            border-bottom: 2px solid #4f46e5;
            color: #4f46e5;
        }
    </style>
</x-admin-layout>
