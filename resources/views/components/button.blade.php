@php
    $baseClasses = 'inline-flex space-x-2 items-center justify-center font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 rounded';
    $colorClasses = match($color) {
        'blue' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'red' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'gray' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
        default => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
    };
    $sizeClasses = match($size) {
        'sm' => 'px-3 py-2 text-sm',
        'lg' => 'px-6 py-3 text-lg',
        default => 'px-4 py-2 text-md',
    };
    $classes = "$baseClasses $colorClasses $sizeClasses";
@endphp

@if ($href)
    <!-- Render as a link -->
    <a href="{{ $href }}" class="{{ $classes }}" {{ $onClick ? "onclick=$onClick" : '' }}>
        {{ $slot }}
    </a>
@elseif ($type === 'submit')
    <!-- Render as a submit button -->
    <button type="submit" class="{{ $classes }}" {{ $onClick ? "onclick=$onClick" : '' }}>
        {{ $slot }}
    </button>
@elseif ($type === 'delete')
    <!-- Render as a delete button -->
    <form action="{{ $action }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="{{ $classes }}" onclick="return confirm('Bạn có chắc muốn xoá?')">
            {!! strlen($slot)
                ? $slot
                : '<i class="fa fa-trash"></i> <span>Xoá</span>'
            !!}
        </button>
    </form>
@else
    <!-- Render as a regular button -->
    <button type="button" class="{{ $classes }}" {{ $onClick ? "onclick=$onClick" : '' }}>
        {{ $slot }}
    </button>
@endif
