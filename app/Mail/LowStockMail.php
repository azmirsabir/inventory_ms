<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class LowStockMail extends Mailable
{
    use Queueable, SerializesModels;
  
    public $data;
    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
      $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
          from: new Address('azmirsabir@gmail.com', 'Azmir Sabir'),
          subject: 'Low Stock Alert',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(view: 'low_stock_report_mail');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
      $headers = ['Product ID', 'Product Name', 'SKU', 'Current Quantity', 'Minimum Quantity', 'Location', 'Country'];
      $csv = $this->generateCsv($this->data, $headers, function ($item) {
        return [
          $item->product_id,
          $item->product->name ?? '',
          $item->product->sku ?? '',
          $item->quantity ?? 0,
          $item->minimum_quantity ?? 0,
          $item->warehouse->location ?? '',
          $item->warehouse->country->name ?? '',
        ];
      });
      
      return [
        Attachment::fromData(fn () =>$csv, 'low_stock_report.csv')
          ->withMime('text/csv')
      ];
    }
  
  private function generateCsv(Collection $data, array $headers, callable $rowMapper): string
  {
    $handle = fopen('php://temp', 'r+');
    
    // Add headers
    fputcsv($handle, $headers);
    
    // Add data rows
    foreach ($data as $item) {
      $row = $rowMapper($item);
      fputcsv($handle, $row);
    }
    
    rewind($handle);
    $csv = stream_get_contents($handle);
    fclose($handle);
    
    return $csv;
  }
}
