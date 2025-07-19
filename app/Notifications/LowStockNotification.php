<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    protected $data;
    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['slack', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable) : MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
  
    public function toSlack(object $notifiable): SlackMessage
    {
      $data=$this->data;
      return (new SlackMessage)
        ->success()
        ->content(now()->format('Y-m-d')." : *Low Stock Items*")
        ->attachment(function ($attachment) use($data) {
          $attachment->content($this->formatReport($data));
        });
    }
  
    private function formatReport($items): string
    {
      if (empty($items)) {
        return "_No low stock items today._ ✅";
      }
      
      $message = "";
      foreach ($items as $item) {
        $message .= "- • *Product ID*: `{$item->product_id}` | ";
        $message .= "  • *Product Name*: `{$item->product->name}` | ";
        $message .= "  • *SKU*: `{$item->product->sku}` | ";
        $message .= "  • *Current Qty*: `{$item->quantity}` | ";
        $message .= "  • *Minimum Qty*: `{$item->minimum_quantity}` | ";
        $message .= "  • *Warehouse*: `{$item->warehouse->location}` | ";
        $message .= "  • *Country*: `{$item->warehouse->country->name}`\n\n";
      }
      
      return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
