@props([
    'value' => null,
    'title' => 'Vimeo',
])

@php
    $embedUrl = \App\Support\VimeoVideo::embedUrl($value);
@endphp

@if ($embedUrl)
    <div
        class="vimeo-embed"
        style="padding:56.25% 0 0 0;position:relative;width:100%;max-width:100%;height:auto;background:#000;overflow:hidden;border-radius:8px;"
    >
        <iframe
            src="{{ $embedUrl }}"
            title="{{ $title }}"
            frameborder="0"
            allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share"
            allowfullscreen
            webkitallowfullscreen
            mozallowfullscreen
            referrerpolicy="strict-origin-when-cross-origin"
            style="position:absolute;top:0;left:0;width:100%;height:100%;border:0;"
        ></iframe>
    </div>
@endif
