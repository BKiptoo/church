<?php

namespace Database\Factories;

use App\Models\Analytic;
use App\Models\Media;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends Factory<Analytic>
 */
class AnalyticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'data' => [
                'users' => count(User::query()->get()),
                'orders' => count(Order::query()->get()),
                'pendingOrders' => count(Order::query()->where('isClosed', true)->get()),
                'tenders' => count(Tender::query()->get()),
                'pendingTenders' => count(Tender::query()->where('isClosed', true)->get()),
                'leads' => count(Subscriber::query()->where('isLead', true)->get()),
                'contacts' => count(Subscriber::query()->where('isContact', true)->get()),
                'customers' => count(Subscriber::query()->where('isCustomer', true)->get()),
                'failed' => count(Subscriber::query()->where('isClosed', true)->get()),
                'products' => count(Product::query()->get()),
                'blogViews' => Post::query()->sum('views'),
                'blogLikes' => Post::query()->sum('likes'),
                'blogs' => count(Post::query()->get()),
                'media' => count(Arr::flatten(Media::query()->select('pathNames')->get()->toArray())),
                'mediaSize' => array_sum(Arr::flatten(Media::query()->select('sizes')->get()->toArray())),
                'orderSummary' => [
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                    0
                ]
            ]
        ];
    }
}
