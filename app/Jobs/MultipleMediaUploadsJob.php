<?php

namespace App\Jobs;

use App\Http\Controllers\SystemController;
use App\Models\Media;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MultipleMediaUploadsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private readonly string $mediaableId,
        private readonly string $mediaableType,
        private readonly array  $fileRequests
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        // define empty array here for pathNames and pathUrls
        $pathUrls = $pathNames = $sizes = [];

        // start process of storage here
        foreach ($this->fileRequests as $fileRequest) {
            $media = SystemController::storeMedia(
                $fileRequest
            );

            // add the items to the array
            $pathNames[] = $media[0];
            $pathUrls[] = $media[1];
            $sizes[] = $media[2];
        }

        // remove existing files first
        $model = Media::query()->firstWhere('mediaable_id', $this->mediaableId);
        if ($model)
            foreach ($model->pathNames as $pathName) {
                SystemController::unLinkMedia($pathName);
            }

        // store in the database here
        Media::query()->updateOrCreate([
            'mediaable_id' => $this->mediaableId,
            'mediaable_type' => $this->mediaableType,
        ], [
            'pathNames' => $pathNames,
            'pathUrls' => $pathUrls,
            'sizes' => $sizes
        ]);
    }
}
