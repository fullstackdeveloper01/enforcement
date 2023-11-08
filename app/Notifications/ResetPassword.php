<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Arr;

class ResetPassword extends Notification
{
    use Queueable;
    
    /**
    * The password reset token.
    *
    * @var string
    */
   public $token;
   public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
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
        $url = url("{$this->token}?").Arr::query([
            'email' => $notifiable->getEmailForPasswordReset()
        ]);
      
        return (new MailMessage)
            ->subject(Lang::get('Password Reset Request for '.config('app.name')))
            ->line(Lang::get('Dear '.$this->user->name.","))
            ->line(Lang::get('We received a request to reset your password for your account. If you made this request, please click the link below to reset your password:'))
            ->action(Lang::get('Reset my password'), $url)
            ->line(Lang::get('If you did not make this request, please ignore this email. For security reasons, this link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('If you have any questions or concerns, please contact our customer service team at support@enforcementpro.co.uk.'))
            ->line(Lang::get('Thank you for choosing Enforecement Pro for your enforcement solution needs.'));
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
