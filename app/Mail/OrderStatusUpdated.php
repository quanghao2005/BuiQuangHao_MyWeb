<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $customer;
    public $statusText;
    public $statusColor;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $customer)
    {
        $this->order = $order;
        $this->customer = $customer;

        // Determine status text and color
        if ($order->status == 1) {
            $this->statusText = 'Đang giao hàng';
            $this->statusColor = '#0dcaf0'; // info
        } elseif ($order->status == 2) {
            $this->statusText = 'Đã giao xong';
            $this->statusColor = '#198754'; // success
        } elseif ($order->status == 3) {
            $this->statusText = 'Đã hủy';
            $this->statusColor = '#dc3545'; // danger
        } else {
            $this->statusText = 'Chờ xử lý';
            $this->statusColor = '#ffc107'; // warning
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Cập nhật trạng thái đơn hàng #' . $this->order->id . ' - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.status_updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
