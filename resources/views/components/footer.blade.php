<footer class="bg-gray-50 py-10">
    <div class="container mx-auto text-center space-y-6">
        <!-- Social Media Icons -->
        <div class="flex justify-center space-x-4">
            <a href="{{ \App\Models\Setting::get('social_facebook') }}" class="flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition">
                <i class="fa-brands fa-facebook-f"></i>
            </a>
            <a href="{{ \App\Models\Setting::get('social_instagram') }}" class="flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <a href="{{ \App\Models\Setting::get('social_twitter') }}" class="flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition">
                <i class="fa-brands fa-twitter"></i>
            </a>
            <a href="{{ \App\Models\Setting::get('social_youtube') }}" class="flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition">
                <i class="fa-brands fa-youtube"></i>
            </a>
        </div>

        <!-- Footer Links -->
        <nav class="space-x-4 text-gray-700">
            @foreach($footerLinks as $link)
                <a href="{{ $link->url }}" class="hover:text-blue-600">{{ $link->title }}</a>
            @endforeach
        </nav>

        <!-- Copyright -->
        <p class="text-sm text-gray-500">{{ \App\Models\Setting::get('copyright_text') }}</p>
    </div>
</footer>
