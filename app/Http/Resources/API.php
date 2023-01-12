<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class API extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return parent::toArray($request);
    }

    /**
     * show return with something
     * @param $request
     * @return array
     */
    public function with($request): array
    {
        return [
            'api-version' => '1.0.0',
            'author' => 'SHIFTECH AFRICA',
            'author-url' => url('https://shiftechafrica.com/'),
        ];
    }
}
