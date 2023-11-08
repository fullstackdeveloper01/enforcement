<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class PaymentConfirmation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($payment)
    {
        $this->payment = $payment;
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
        return (new MailMessage)
            ->subject(Lang::get('Payment Confirmation'))
            ->line(Lang::get('Dear '.$this->payment['first_name'].","))
            ->line(Lang::get('Thank you for your payment to Harlow District Council. Please keep this e-mail as a record for your accounts.'))
            ->line(Lang::get('Please note your payment will show on your bank statement as National Enforcement Solutions working on behalf of Harlow District Council.'))
            ->line(new HtmlString('<table style="margin-bottom:14px;">
                    <tr style="padding:10px;">
                        <td style="font-size:16px;">FPN No:</td>
                        <td style="margin-left:14px;font-size:16px;">'.$this->payment['fpn_number'].'</td>
                    </tr>
                    <tr style="padding:10px;">
                        <td style="font-size:16px;">Transaction ID:</td>
                        <td style="margin-left:14px;font-size:16px;">'.$this->payment['transaction_id'].'</td>
                    </tr>
                    <tr style="padding:10px;">
                        <td style="font-size:16px;">Amount:</td>
                        <td style="margin-left:14px;font-size:16px;">GBP '.$this->payment['amount'].'</td>
                    </tr>
                </table>'))
            ->line(Lang::get('Please do not reply to this message. Replies to this message are routed to an unmonitored mailbox.'))
            ->line(Lang::get('Harlow District Council'));
    }

}

  