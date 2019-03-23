<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Group;

class GroupConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($participant, $group)
    {
        $this->participant = $participant;
        $this->group = $group;
    }

    protected $group, $participant;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.confirm_participation')
                    ->subject('Confirmar participação em grupo - Amigo X')
                    ->with([
                        'groupName' => $this->group->name,
                        'groupCreatorName' => $this->group->creator->name,
                        'participantName' => $this->participant['name'],
                        'confirmUrl' => url('confirm-participation/'.$this->participant->pivot->token),
                    ]);
    }
}
