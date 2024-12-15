<div class="floating-button">
    <a href="{{ $url }}" class="button" title="{{ $tooltip }}">
        <i class="fa {{ $icon }}"></i>
    </a>
</div>

<style>
    .floating-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }
    .floating-button .button {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 60px;
        height: 60px;
        background-color: #007bff;
        border-radius: 50%;
        color: white;
        font-size: 24px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        transition: transform 0.2s, background-color 0.2s;
    }
    .floating-button .button:hover {
        transform: scale(1.1);
        background-color: #0056b3;
    }
</style>
