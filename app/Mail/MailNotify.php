<?php

namespace App\Mail;

use App\Models\Extras;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    private $data = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = env('MAIL_FROM_ADDRESS');

        if ($this->data['emailtype'] == "notify") {
            return $this->from($from, $this->data['from_title'])->subject($this->data['subject'])->view("email.schedule_email")->with('data', $this->data);
        }elseif($this->data['emailtype'] == "wfh_notification"){
            return $this->from($from, $this->data['from_title'])->subject($this->data['subject'])->view("email.wfh_email")->with('data', $this->data['data'])->attach(Attachment::fromPath(Storage::disk("s3")->url($this->data['data']['accomplishment_file'])));
        } elseif ($this->data['emailtype'] == "wfh_notification_update") {
            return $this->from($from, $this->data['from_title'])->subject($this->data['subject'])->view("email.wfh_email")->with('data', $this->data['data']);
        }
    }
}
