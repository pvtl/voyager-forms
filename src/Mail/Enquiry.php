<?php

namespace Pvtl\VoyagerForms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\View;
use Illuminate\Queue\SerializesModels;

class Enquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $form;
    public $enquiries;
    public $filesKeys;

    public function __construct($form, $enquiries, $filesKeys)
    {
        $this->form = $form;
        $this->enquiries = $enquiries;
        $this->filesKeys = $filesKeys;
    }

    public function build()
    {
        if (!View::exists('voyager-forms::email-templates.' . $this->form->email_template)) {
            $this->form->email_template = 'default';
        }

        //create the email
        $email = $this->from($this->form->mailfrom, $this->form->mailfromname)
            ->subject($this->form->mailfromname . ' - ' . $this->form->title . ' [New Enquiry]')
            ->view('voyager-forms::email-templates.' . $this->form->email_template);

        //Attach files and unset in enquiry array
        foreach ($this->enquiries as $key => $enquiry){
            if(in_array($key, $this->filesKeys)){
                $email->attach(storage_path('app/' . $enquiry));
                unset($this->enquiries[$key]);
            }
        }

        return $email;
    }
}
