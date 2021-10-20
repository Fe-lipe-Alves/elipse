<?php

namespace App\Mail;

use App\Models\Work;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewWork extends Mailable
{
    use Queueable, SerializesModels;

    private $work;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, Work $work)
    {
        $this->work = $work;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Novo trabalho de '. $this->work->lesson->subject->description);
        $this->to($this->user->email, $this->user->name);
        return $this->markdown('mails.new-work', [
            'work' => $this->work
        ]);
    }
}
