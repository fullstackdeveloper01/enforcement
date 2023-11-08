<?php

namespace app\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

class TwoFactorCode extends Notification
{
    use Queueable;

    public function __construct($authUser) {
        $this->authUser = $authUser;
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
            ->subject(Lang::get('Login OTP for Enforcement Pro'))
            ->line(Lang::get('Dear '.$this->authUser->name.","))
            ->line(Lang::get('Please use the following 6-digit OTP code to complete your login process within the next 5 minutes:'))
            ->line(new HtmlString("<h1><center style='background:lightgrey;'>{$this->authUser->two_factor_code}</center></h1>"))
            ->line(Lang::get('Please keep this OTP code secure and not share it with anyone, including the Enforcement Pro support team. The Enforcement Pro support team will never ask you for your OTP code.'))
            ->line(Lang::get('If you did not request this OTP, please contact our support team immediately at support@enforcementpro.co.uk.'))
            ->line(Lang::get('Thank you for choosing Enforecement Pro for your enforcement solution needs.'));
        }
}
