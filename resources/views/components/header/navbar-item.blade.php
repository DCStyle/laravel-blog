@if($item->children->isEmpty())
    @if($mode === 'desktop')
        <a href="{{ $item->url }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
            {{ $item->title }}
        </a>
    @else
        <a href="{{ $item->url }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50">
            {{ $item->title }}
        </a>
    @endif
@else
    <div x-data="{ subOpen: false }" @class([
        'relative' => $mode === 'desktop'
    ])>
        <button
            @click="subOpen = !subOpen"
            @click.away="subOpen = false"
            @class([
                'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700' => $mode === 'desktop',
                'w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50' => $mode === 'mobile'
            ])
        >
            {{ $item->title }}
            <i class="fa fa-chevron-down ml-1 text-xs transition-transform duration-200" :class="{ 'transform rotate-180': subOpen }"></i>
        </button>

        <!-- Dropdown Items -->
        <div
            x-show="subOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @class([
                'absolute left-0 mt-1 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10' => $mode === 'desktop',
                'mt-1 pl-4' => $mode === 'mobile'
            ])
            style="display: none;"
        >
            <ul @class(['py-1' => $mode === 'desktop'])>
                @foreach($item->children as $child)
                    <li>
                        <a href="{{ $child->url }}" @class([
                            'block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100' => $mode === 'desktop',
                            'block px-3 py-2 rounded-md text-sm font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50' => $mode === 'mobile'
                        ])>
                            {{ $child->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
