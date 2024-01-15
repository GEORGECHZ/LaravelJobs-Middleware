@props(['type'])

@php
    switch ($type) {
        case 'info':
            $clases = 'bg-blue-500 text-white';
            break;

        case 'danger':
            $clases = 'bg-red-500 text-white';
            break;

        default:
            $clases = 'bg-blue-500 text-white';
            break;
    }
@endphp

<article role="alert">
    <h1 class="font-bold rounded-t px-4 py-2 {{$clases}}">
        {{ $title }}
    </h1>
    <div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
        {{ $slot }}
    </div>
</article>
