<?php

namespace App\Mail;

use App\Models\Keluhan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TanggapanEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $keluhan;
    public $tanggapan;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Keluhan $keluhan, $tanggapan)
    {
        $this->keluhan = $keluhan;
        $this->tanggapan = $tanggapan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('muchammad.faisal@unisba.ac.id', 'Feedback')
            ->view('pages.emails.tanggapanMail');
    }
}
