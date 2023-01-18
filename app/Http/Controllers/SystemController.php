<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Propaganistas\LaravelPhone\PhoneNumber;

class SystemController extends Controller
{
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
    public static function pass_greetings_to_user(): string
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
        $path ??= 'csquared';

        // The environment is either local OR staging...
        if (App::environment(['local', 'staging'])) {
            $path = $path . '_' . App::environment();
        }

        // remove the file if it exists
        if (isset($fileName)) {
            self::unLinkMedia($fileName, $path);
        }

        // Get the base 64 file contents
        $mediaBase64 = str_replace('data:image/png;base64,', '', $mediaBase64);
        $mediaBase64 = str_replace(' ', '+', $mediaBase64);

        $newFileName = Str::lower(Str::random()) . '.png';
        Storage::disk('do_space')->put($path . '/' . $newFileName, base64_decode($mediaBase64), 'public');

        return [
            $newFileName, // this will be the new file name i.e. shiftechafrica.png
            Storage::disk('do_space_cdn')->url($path . '/' . $newFileName) // set the path for
            // loading the image i.e. http:IP/storage/shiftechafrica.png
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
        $path ??= 'csquared';
        if (isset($fileRequest)) {
            // unlink media here
            self::unLinkMedia($fileName);

            // generate new name for image
            $newFileName = Str::slug(Str::random(16)) . '.' . $fileRequest->extension();

            // store the new image
            $fileRequest->storePubliclyAs($path, $newFileName, 'do_space');

            // assign variables
            $url = Storage::disk('do_space_cdn')->url($path . '/' . $newFileName);
            $size = Storage::disk('do_space')->size($path . '/' . $newFileName);

            return [
                $newFileName, // this will be the new file name i.e shiftechafrica.png
                $url, // set the path for loading the image i.e http:IP/storage/shiftechafrica.png
                $size // get file size in bytes
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
        $path ??= 'csquared';

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
}
