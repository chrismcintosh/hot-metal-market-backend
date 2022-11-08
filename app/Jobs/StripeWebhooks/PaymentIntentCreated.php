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
        $order = $this->updateOrder();
    }

    private function updateOrder() {
        $order = Order::findOrFail($this->webhookEvent->payload['data']['object']['metadata']['order_id']);
        
        if (!$order) {
            throw new \Exception('Error updating order');
        }
        
        $order->status = 'created';
        $order->save();
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
}
