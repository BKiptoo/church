<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Propaganistas\LaravelPhone\PhoneNumber;
use YoHang88\LetterAvatar\LetterAvatar;

class SystemController extends Controller
{

    /**
     * returns the elapsed time
     * @param $time
     * @return string
     */
    public static function elapsedTime($time): string
    {
        return Carbon::parse($time)->diffForHumans();
    }

    /**
     * Write the system log files
     * @param array $data
     * @param string $channel
     * @param string $fileName
     */
    public static function log(array $data, string $channel, string $fileName)
    {
        $file = storage_path('logs/' . $fileName . '.log');

        // finally, create a formatter
        $jsonFormatter = new JsonFormatter();

        // Create the log data
        $log = [
            'ip' => request()->getClientIp(),
            'data' => $data,
        ];
        // Create a handler
        $stream = new StreamHandler($file, Logger::INFO);
        $stream->setFormatter($jsonFormatter);

        // bind it to a logger object
        $securityLogger = new Logger($channel);
        $securityLogger->pushHandler($stream);
        $securityLogger->log('info', $channel, $log);
    }

    /**
     * get greetings here
     * @return string
     */
    public static function passGreetings(): string
    {
        $message = '';

        if (date("H") < 12) {
            $message = "Good Morning";
        } elseif (date("H") >= 12 && date("H") < 16) {
            $message = "Good Afternoon";
        } elseif (date("H") >= 16) {
            $message = "Good Evening";
        }

        return $message;
    }

    /**
     * store image here
     * @param string $mediaBase64
     * @param string|null $fileName
     * @param string|null $path
     * @return array
     */
    public static function storeMediaBase64(
        string      $mediaBase64,
        string|null $fileName = null,
        string|null $path = null
    ): array
    {
        $path ??= 'mayministries.org';

        // The environment is either local OR staging...
        if (App::environment(['local', 'staging'])) {
            $path = $path . '_' . App::environment();
        }

        // remove the file if it exists
        if (isset($fileName)) {
            self::unLinkMedia($fileName, $path);
        }

        // Get the base 64 file contents
        $mediaBase64 = str_replace(';base64,', '', $mediaBase64);
        $mediaBase64 = str_replace(' ', '+', $mediaBase64);

        $newFileName = Str::lower(Str::random()) . '.pdf';
        Storage::disk('do_space')->put($path . '/' . $newFileName, base64_decode($mediaBase64), 'public');
        $url = Storage::disk('do_space_cdn')->url($path . '/' . $newFileName);
        $size = Storage::disk('do_space')->size($path . '/' . $newFileName);
        $mimeType = Storage::disk('do_space')->mimeType($path . '/' . $newFileName);

        return [
            $newFileName, // this will be the new file name i.e shiftechafrica.png
            $url, // set the path for loading the image i.e http:IP/storage/shiftechafrica.png
            $size, // get file size in bytes
            $mimeType // get file mime Type
        ];
    }

    /**
     * store image here
     * @param $fileRequest
     * @param string|null $fileName
     * @param string|null $path
     * @return array
     */
    public static function storeMedia(
        $fileRequest,
        string|null $fileName = null,
        string|null $path = null
    ): array
    {
        // check if feature_image exists
        $path ??= 'mayministries.org';

        // The environment is either local OR staging...
        if (App::environment(['local', 'staging'])) {
            $path = $path . '_' . App::environment();
        }

        // validate
        if (isset($fileRequest)) {
            // unlink media here
            self::unLinkMedia($fileName);

            // generate new name for image
            $newFileName = Str::slug(Str::random()) . '.' . $fileRequest->extension();

            // store the new image
            $fileRequest->storePubliclyAs($path, $newFileName, 'do_space');

            // assign variables
            $url = Storage::disk('do_space_cdn')->url($path . '/' . $newFileName);
            $size = Storage::disk('do_space')->size($path . '/' . $newFileName);
            $mimeType = Storage::disk('do_space')->mimeType($path . '/' . $newFileName);

            return [
                $newFileName, // this will be the new file name i.e shiftechafrica.png
                $url, // set the path for loading the image i.e http:IP/storage/shiftechafrica.png
                $size, // get file size in bytes
                $mimeType // get file mime Type
            ];
        }
        return [null, '#', 0];
    }

    /**
     * store image here
     * @param $fileRequest
     * @param string|null $fileName
     * @param string|null $path
     * @return array
     */
    public static function storeMediaKML(
        $fileRequest,
        string|null $fileName = null,
        string|null $path = null
    ): array
    {
        // check if feature_image exists
        $path ??= 'mayministries.org';

        // The environment is either local OR staging...
        if (App::environment(['local', 'staging'])) {
            $path = $path . '_' . App::environment();
        }

        // validate
        if (isset($fileRequest)) {
            // unlink media here
            self::unLinkMedia($fileName);

            // generate new name for image
            $newFileName = Str::slug(Str::random()) . '.' . 'kml';

            // store the new image
            $fileRequest->storePubliclyAs($path, $newFileName, 'do_space');

            // assign variables
            $url = Storage::disk('do_space_cdn')->url($path . '/' . $newFileName);
            $size = Storage::disk('do_space')->size($path . '/' . $newFileName);
            $mimeType = Storage::disk('do_space')->mimeType($path . '/' . $newFileName);

            return [
                $newFileName, // this will be the new file name i.e shiftechafrica.png
                $url, // set the path for loading the image i.e http:IP/storage/shiftechafrica.png
                $size, // get file size in bytes
                $mimeType // get file mime Type
            ];
        }
        return [null, '#', 0];
    }

    /**
     * unlink media here
     * @param string|null $fileName
     * @param string|null $path
     */
    public static function unLinkMedia(string|null $fileName = null, string|null $path = null)
    {
        $path ??= 'mayministries.org';

        // The environment is either local OR staging...
        if (App::environment(['local', 'staging'])) {
            $path = $path . '_' . App::environment();
        }

        // check if image exists
        if (Storage::disk('do_space')->exists($path . '/' . $fileName)) {
            // unlink the media here after upload
            Storage::disk('do_space')->delete($path . '/' . $fileName);
        }
    }

    /**
     * unlink media here
     * @param string|null $fileName
     * @param string|null $path
     * @return string|null
     */
    public static function getMedia(string|null $fileName, string|null $path = null): ?string
    {
        // check if feature_image exists
        $path ??= 'mayministries.org';

        // The environment is either local OR staging...
        if (App::environment(['local', 'staging'])) {
            $path = $path . '_' . App::environment();
        }

        return Storage::disk('do_space_cdn')->get($path . '/' . $fileName);
    }

    /**
     * unlink media here
     * @param string|null $fileName
     * @param string|null $path
     * @return string|null
     */
    public static function downloadMedia(string|null $fileName, string|null $path = null): ?string
    {
        // check if feature_image exists
        $path ??= 'mayministries.org';

        // The environment is either local OR staging...
        if (App::environment(['local', 'staging'])) {
            $path = $path . '_' . App::environment();
        }

        return Storage::disk('do_space_cdn')->download($path . '/' . $fileName);
    }

    /**
     * format phone number
     * @param string $phoneNumber
     * @param string $short2Code
     * @return string
     */
    public static function formatPhoneNumber(string $phoneNumber, string $short2Code): string
    {
        return PhoneNumber::make($phoneNumber)->ofCountry($short2Code);
    }

    /**
     * validate the phone number with country
     * @param string $phoneNumber
     * @param string $short2Code
     * @return bool
     */
    public static function validatePhoneNumber(string $phoneNumber, string $short2Code): bool
    {
        try {
            return PhoneNumber::make($phoneNumber, $short2Code)->isOfCountry($short2Code);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return false;
        }
    }

    /**
     * generate avatars here
     * @param string $name
     * @param int $size
     * @return LetterAvatar
     */
    public static function generateAvatars(string $name, int $size): LetterAvatar
    {
        return new LetterAvatar($name, 'circle', $size);
    }

    /**
     * remove existing files
     */
    public static function removeExistingFiles(string $mediaableId, bool|null $deleteMedia = null)
    {
        $deleteMedia ??= false;
        $model = Media::query()->firstWhere('mediaable_id', $mediaableId);
        if ($model) {
            foreach ($model->pathNames as $pathName) {
                self::unLinkMedia($pathName);
            }

            // forceDelete
            if ($deleteMedia) {
                $model->forceDelete();
            }
        }
    }

    /**
     * process single storage images
     * @param string $mediaableId
     * @param string $mediaableType
     * @param
     * @param bool $isKML
     */
    public static function singleMediaUploadsJob(string $mediaableId, string $mediaableType, $fileRequest, bool $isKML = false)
    {
        // start process of storage here
        if ($isKML) {
            $media = self::storeMediaKML(
                $fileRequest
            );
        } else {
            $media = self::storeMedia(
                $fileRequest
            );
        }

        // remove existing files first
        self::removeExistingFiles($mediaableId);

        // store in the database here
        Media::query()->updateOrCreate([
            'mediaable_id' => $mediaableId,
            'mediaable_type' => $mediaableType,
        ], [
            'pathNames' => [
                $media[0]
            ],
            'pathUrls' => [
                $media[1]
            ],
            'sizes' => [
                $media[2]
            ],
            'mimeTypes' => [
                $media[3]
            ],
        ]);
    }

    /**
     * process single storage images
     * @param string $mediaableId
     * @param string $mediaableType
     * @param string $base64
     */
    public static function singleMediaUploadsBase64(string $mediaableId, string $mediaableType, string $base64)
    {
        // start process of storage here
        $media = self::storeMediaBase64(
            $base64
        );

        // remove existing files first
        self::removeExistingFiles($mediaableId);

        // store in the database here
        Media::query()->updateOrCreate([
            'mediaable_id' => $mediaableId,
            'mediaable_type' => $mediaableType,
        ], [
            'pathNames' => [
                $media[0]
            ],
            'pathUrls' => [
                $media[1]
            ],
            'sizes' => [
                $media[2]
            ],
            'mimeTypes' => [
                $media[3]
            ],
        ]);
    }

    /**
     * store images in multiple ways
     */
    public static function multipleMediaUploadsJob(string $mediaableId, string $mediaableType, $fileRequests)
    {
        // define empty array here for pathNames and pathUrls
        $pathUrls = $pathNames = $sizes = $mimeTypes = [];

        // start process of storage here
        foreach ($fileRequests as $fileRequest) {
            $media = self::storeMedia(
                $fileRequest
            );

            // add the items to the array
            $pathNames[] = $media[0];
            $pathUrls[] = $media[1];
            $sizes[] = $media[2];
            $mimeTypes[] = $media[3];
        }

        // remove existing files first
        self::removeExistingFiles($mediaableId);

        // store in the database here
        Media::query()->updateOrCreate([
            'mediaable_id' => $mediaableId,
            'mediaable_type' => $mediaableType,
        ], compact('pathNames', 'pathUrls', 'sizes', 'mimeTypes'));
    }

    /**
     * @param $bytes
     * @return string
     */
    public static function bytesToHuman($bytes): string
    {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
