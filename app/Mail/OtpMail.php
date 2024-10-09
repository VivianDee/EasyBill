<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;



    public $greeting;
    public $name;
    public $intro;
    public $outro;
    public $text;
    public $message;
    public $companyName;
    public $title;


    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {

        $this->greeting = $data['greeting'];
        $this->name = $data['name'];
        $this->intro = $data['intro'];
        $this->outro = $data['outro'];
        $this->text = $data['text'];
        $this->title = $data['title'];
        $this->companyName = $data['companyName'];
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Otp Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'welcome',
            with: [
               'greeting' => $this->greeting,
                'name' => $this->name,
                'intro' => $this->intro,
                'outro' => $this->outro,
                'text' => $this->text,
                'message' => $this->message,
                'title' => $this->title,
                'companyName' => $this->companyName,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
