@props([
    'value' => null,
    'title' => 'Vimeo',
])

@php
    $embedUrl = \App\Support\VimeoVideo::embedUrl($value);
@endphp

@if ($embedUrl)
    <div class="vimeo-embed">
        <iframe
            src="{{ $embedUrl }}"
            title="{{ $title }}"
            allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
            referrerpolicy="strict-origin-when-cross-origin"
        ></iframe>
    </div>
@endif
