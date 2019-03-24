<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GameNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $group, $participant, $friend, $exchangeDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($group, $participant, $friend, $exchangeDate)
    {
        $this->group = $group;
        $this->participant = $participant;
        $this->friend = $friend;
        $this->exchangeDate = $exchangeDate;
    }

    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {             
               return $this->markdown('emails.game_notification')
                    ->subject('Novo sorteio iniciado - Amigo X')
                    ->with([
                        'participantName' => $this->participant->name,
                        'groupName' => $this->group->name,
                        'exchangeDate' => $this->exchangeDate,
                        'friendName' => $this->friend->name,
                        'gifts' => $this->friend->gifts()->exists() ? $this->friend->gifts()->get() : false,
                    ]);
    }
}
