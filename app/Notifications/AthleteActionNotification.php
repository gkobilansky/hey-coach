<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;
use Lang;
use App\Models\Athlete;

class AthleteActionNotification extends Notification
{
    use Queueable;

    private $athlete;
    private $action;

    /**
     * Create a new notification instance.
     * AthleteActionNotification constructor.
     * @param $athlete
     * @param $action
     */
    public function __construct($athlete, $action)
    {
        $this->athlete = $athlete;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /*return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', 'https://laravel.com')
                    ->line('Thank you for using our application!'); */
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        switch ($this->action) {
            case 'created':
                $text = __('Athlete :company was assigned to you', [
                    'company' => $this->athlete->company_name,
                ]);
                break;
            case 'updated_assign':
                $text = __(':username assigned :company to you', [
                    'company' => $this->athlete->company_name,
                    'username' => Auth()->user()->name
                ]);
                break;
            default:
                break;
        }

        return [
            'assigned_user' => $notifiable->id, //Assigned user ID
            'created_user' => auth()->user()->id,
            'message' => $text,
            'type' => Athlete::class,
            'type_id' =>  $this->athlete->id,
            'url' =>  url('athletes/' . $this->athlete->id),
            'action' => $this->action
        ];
    }
}
