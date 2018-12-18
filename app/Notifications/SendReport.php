<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendReport extends Notification
{
    use Queueable;
    private $user;
    private $file;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @param $file
     */
    public function __construct($user, $file)
    {
        //
        $this->user = $user;
        $this->file = $file;
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
        return (new MailMessage)
            ->subject('PERFORMANCE APPRAISAL REPORT (SHRAWAN 2075)')
            ->view(
                'report-mail', ['name' => $this->user->name]
            )
            ->attach($this->file);
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
