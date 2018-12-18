<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendNewPasswordNotification extends Notification
{
    use Queueable;
    private $newPassword;
    private $name;
    private $email;

    /**
     * SendNewPasswordNotification constructor.
     * @param $newPassword
     * @param $name
     * @param $email
     */
    public function __construct($newPassword, $name, $email)
    {
        $this->newPassword = $newPassword;
        $this->name        = $name;
        $this->email       = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $parameters = ['name' => $this->name, 'password' => $this->newPassword, 'email' => $this->email];

        return (new MailMessage)
            ->view(
                'mail', $parameters
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
