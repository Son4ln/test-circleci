<?php

return [
    'binaries' => [
        'ffmpeg' => env('BIN_FFMPEG', 'ffmpeg'),
        'ffprobe' => env('BIN_FFPROBE', 'ffprobe'),
    ],
    'defaults' => [
        'second' => 2,
        'width' => 640,
        'height' => 480,
    ],
];
