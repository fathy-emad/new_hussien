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
            width="640"
            height="360"
            frameborder="0"
            allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
            allowfullscreen
            webkitallowfullscreen
            mozallowfullscreen
            referrerpolicy="strict-origin-when-cross-origin"
        ></iframe>
    </div>
@endif
