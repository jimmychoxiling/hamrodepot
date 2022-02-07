<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PlaceOrderStatus extends Notification
{
    use Queueable;
    private $order;
    private $orderDetail;
    private $status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $orderDetail, $status)
    {
        $this->order = $order;
        $this->orderDetail = $orderDetail;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $orderDetail = $this->orderDetail;
        $status = $this->status;
        return (new MailMessage)
            ->bcc(config('mail.bcc_address'), config('mail.bcc_name'))
            ->line($orderDetail->name . ' from your order has been ' . $status->name)
            ->action('View Order Detail', route('order-detail', ['id' => $this->orderDetail->order_id]))
            ->line('Thanks!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
