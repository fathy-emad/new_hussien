<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chunked video upload (Dropzone)
    |--------------------------------------------------------------------------
    */

    /** 2MB per chunk — 500MB video ≈ 250 requests */
    'chunk_size' => (int) env('UPLOAD_CHUNK_SIZE', 2 * 1024 * 1024),

    /** Seconds per chunk request (merge on last chunk can take minutes) */
    'chunk_time_limit' => (int) env('UPLOAD_CHUNK_TIME_LIMIT', 1800),

    'chunks_path' => 'chunks',

    /** Delete abandoned chunk folders older than this (hours) */
    'chunks_max_age_hours' => (int) env('UPLOAD_CHUNKS_MAX_AGE_HOURS', 24),

    /** Dropzone maxFilesize in MB (0 = unlimited in UI validation) */
    'video_max_filesize_mb' => (int) env('UPLOAD_VIDEO_MAX_MB', 2048),

    /** Per-chunk XHR timeout in ms (last chunk includes server merge) */
    'video_upload_timeout_ms' => (int) env('UPLOAD_VIDEO_TIMEOUT_MS', 3600000),

    /*
    |--------------------------------------------------------------------------
    | Accepted MIME types
    |--------------------------------------------------------------------------
    */

    'video_mimes' => [
        'video/mp4',
        'video/webm',
        'video/quicktime',
        'application/octet-stream',
    ],

    'video_extensions' => ['mp4', 'webm', 'mov'],

    /*
    |--------------------------------------------------------------------------
    | STORE-PATH header → disk mapping
    |--------------------------------------------------------------------------
    |
    | Used by Dropzone (header STORE-PATH). Video paths use chunked upload
    | into storage/app/videos. Public paths go to public/uploads/.
    |
    */

    'paths' => [
        'videos/lessons' => [
            'type' => 'video',
            'disk' => 'videos',
            'folder' => 'lessons',
        ],
        'videos/capacitors' => [
            'type' => 'video',
            'disk' => 'videos',
            'folder' => 'capacitors',
        ],
        'videos/website' => [
            'type' => 'video',
            'disk' => 'videos',
            'folder' => 'website',
        ],
        'lessons/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'lessons/images',
        ],
        'lessons/files' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'lessons/files',
        ],
        'website/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'website/images',
        ],
        'capacitors/lessons/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'capacitors/lessons/images',
        ],
        'capacitors/lessons/files' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'capacitors/lessons/files',
        ],
        'students/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'students/images',
        ],
        'admins/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'admins/images',
        ],
        'exams/questions/images' => [
            'type' => 'public',
            'disk' => 'uploads',
            'folder' => 'exams/questions/images',
        ],
    ],

];
