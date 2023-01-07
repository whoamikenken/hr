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

        if ($this->data['emailtype'] == "applicant_document") {
            $this->data['fullname'] = $this->data['attachment'][0]->fullname;
            unset($this->data['attachment'][0]->fullname);
            $this->from($from, $this->data['from_title'])->subject($this->data['subject'])->view("email.status_email", $this->data);
            foreach ($this->data['attachment'][0] as $file => $val) {
                if ($val) {

                    $fileDesc = Extras::showDesc($file);

                    $getMime = explode(".", $val);

                    $getMime = $getMime[1];
                    // dd();
                    $this->attach(Attachment::fromPath(Storage::disk('s3')->url($val))->as($fileDesc . "." . $getMime));
                }
            }

            return $this;
        } elseif ($this->data['emailtype'] == "claim_notification") {
            // dd($this->data);
            return $this->from($from, $this->data['from_title'])->subject($this->data['subject'])->view("email.claim_email")->with('data', $this->data);
        }
    }
}
