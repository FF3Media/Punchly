<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $templateName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$templateName)
    {
        $this->data = $data;
        $this->templateName = $templateName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@upchat.io')->subject($this->data['subject'])->view('mail.'.$this->templateName)->with('data', $this->data);
    }
}
