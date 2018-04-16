<?php

namespace App\Services;

use Exception;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Container\Container;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Video thumbnail class for implementing FFMpeg Features
 */
class VideoThumbnail
{
    /**
     * @var string
     */
    protected $videoUrl;

    /**
     * @var File
     */
    protected $thumb;

    /**
     * Delete template file before destruct
     */
    public function __destruct()
    {
        if ($this->thumb instanceof File) {
            @unlink($this->thumb->getRealPath());
        }
    }

    /**
     * Make a video thumbnail
     *
     * @param string $videoUrl
     * @param int $second
     * @param int $width
     * @param int $height
     * @return self
     * @throws Exception
     */
    public function makeThumbnail(string $videoUrl, $second = 2, $width = 640, $height = 480)
    {
        $options = array_merge(config('video-thumbnail.defaults', []), compact('second', 'width', 'height'));
        $thumbnail = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid('thumb_') . '.jpg';

        try {
            $maker = FFMpeg::create([
                'ffmpeg.binaries' => config('video-thumbnail.binaries.ffmpeg'),
                'ffprobe.binaries' => config('video-thumbnail.binaries.ffprobe'),
            ]);

            $videoObject = $maker->open($videoUrl);
            $videoObject
                ->frame(TimeCode::fromSeconds($options['second']))
                ->save($thumbnail);

            //static::resizeImage($thumbnail, $thumbnail, $options['width'], $options['height']);
        } catch (Exception $e) {
            Log::error($e->getMessage() . PHP_EOL . $e->getTraceAsString());
            throw $e;
        }

        $this->thumb = new File($thumbnail);

        return $this;
    }

    /**
     * Store the uploaded file on a filesystem disk.
     *
     * @param  string  $path
     * @param  array  $options
     * @return string|false
     */
    public function store($path, $options = [])
    {
        return $this->storeAs($path, $this->thumb->hashName(), $this->parseOptions($options));
    }

    /**
     * Store the uploaded file on a filesystem disk with public visibility.
     *
     * @param  string  $path
     * @param  array  $options
     * @return string|false
     */
    public function storePublicly($path, $options = [])
    {
        $options = $this->parseOptions($options);

        $options['visibility'] = 'public';

        return $this->storeAs($path, $this->thumb->hashName(), $options);
    }

    /**
     * Store the uploaded file on a filesystem disk with public visibility.
     *
     * @param  string  $path
     * @param  string  $name
     * @param  array  $options
     * @return string|false
     */
    public function storePubliclyAs($path, $name, $options = [])
    {
        $options = $this->parseOptions($options);

        $options['visibility'] = 'public';

        return $this->storeAs($path, $name, $options);
    }

    /**
     * Store the uploaded file on a filesystem disk.
     *
     * @param  string  $path
     * @param  string  $name
     * @param  array  $options
     * @return string|false
     */
    public function storeAs($path, $name, $options = [])
    {
        $options = $this->parseOptions($options);

        $disk = Arr::pull($options, 'disk');

        return Container::getInstance()->make(FilesystemFactory::class)->disk($disk)->putFileAs(
            $path, $this->thumb, $name, $options
        );

        $this->thumb->delete();
    }

    /**
     * Parse and format the given options.
     *
     * @param  array|string  $options
     * @return array
     */
    protected function parseOptions($options)
    {
        if (is_string($options)) {
            $options = ['disk' => $options];
        }

        return $options;
    }

    /**
     * Resize thumbnail image
     *
     * @param string $source
     * @param string $destination
     * @param int $width
     * @param int $height
     * @param int $quality
     * @return bool
     * @throws Exception when errors
     */
    public static function resizeImage(string $source, string $destination, $width, $height, $quality = 80)
    {
        if ($width <= 0 || $height <= 0) {
            throw new Exception('Width and height of destination image MUST be greater than zero');
        }

        list(0 => $srcW, 1 => $srcH, 'mime' => $mime) = getimagesize($source);

        switch ($mime) {
            case 'image/gif':
                $imageCreateFn = "imagecreatefromgif";
                $imageFn = "imagegif";
                break;
            case 'image/png':
                $imageCreateFn = "imagecreatefrompng";
                $imageFn = "imagepng";
                $quality = $quality / 10;
                break;
            case 'image/jpeg':
                $imageCreateFn = "imagecreatefromjpeg";
                $imageFn = "imagejpeg";
                break;
            default:
                throw new RuntimeException('Image type is not supported');
                break;
        }
        $dstImg = imagecreatetruecolor($width, $height);
        $srcImg = $imageCreateFn($source);

        if ($dstImg === false || $srcImg === false) {
            throw new RuntimeException('Can not create temporary image');
        }

        $cropW = min($srcW, $srcH * $width / $height);
        $cropH = min($srcH, $srcW * $height / $width);
        $cropX = ($width - $cropW) / 2;
        $cropY = ($height - $cropH) / 2;

        if (!imagecopyresampled($dstImg, $srcImg, 0, 0, $cropX, $cropY, $width, $height, $cropW, $cropH)
            || $imageFn($dstImg, $destination, $quality)
        ) {
            throw new RuntimeException('Can not resize temporary image');
        }

        // free memory
        if (!imagedestroy($dstImg) || !imagedestroy($srcImg)) {
            throw new RuntimeException('Can not remove temporary image');
        }
        unset($cropH, $cropW, $cropX, $cropY);
    }
}
