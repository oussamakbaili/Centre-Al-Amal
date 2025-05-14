@props(['href', 'icon', 'active' => false])

<a href="{{ $href }}" class="flex items-center px-4 py-3 text-sm {{ $active ? 'bg-blue-700' : 'hover:bg-blue-700' }} transition-colors duration-200">
    <i class="{{ $icon }} mr-3"></i>
    <span>{{ $slot }}</span>
</a>