<?php

namespace App\Jobs\StripeWebhooks;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;

class PaymentIntentCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $webhookEvent;
    private $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookEvent = $webhookCall;
        $this->user = $this->webhookEvent->payload['data']['object']['metadata']['user'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::debug("handling payment intent created");
        $order = $this->createOrder();
    }

    private function createOrder() {
        $order = Order::create([
            'stripe_payment_intent_id' => $this->webhookEvent->payload['data']['object']['id'],
            'user_id' => $this->user,
            'total' => $this->webhookEvent->payload['data']['object']['amount'],
            'status' => 'created'
        ]);

        if (!$order) {
            throw new \Exception('Error creating order');
        }

        $order->products()->attach($this->ingestCart());

        return $order;
    }

    private function ingestCart() {
        $cart_data = collect(json_decode($this->webhookEvent->payload['data']['object']['metadata']['cart']));

        $cart = $cart_data->mapWithKeys(function ($item, $key) {
            return [
                $item->product_id => [
                    'quantity' => $item->quantity, 
                    'product_cost' => $item->price
                ]
            ];
        })->toArray();

        return $cart;
    }

    // private function clearUserCart() {
    //     $cart = Cart::where('user_id', $this->user)->pluck('id')->toArray();
    //     User::find($this->user)->cart()->detach($cart);
    // }
}
