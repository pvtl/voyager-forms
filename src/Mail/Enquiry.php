<?php

namespace Pvtl\VoyagerForms\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\View;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Enquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $form;
    public $enquiry;

    public function __construct($form, $enquiry)
    {
        $this->form = $form;
        $this->enquiry = $enquiry;
    }

    public function build()
    {
        if (!View::exists('voyager-forms::email-templates.' . $this->form->email_template)) {
            $this->form->email_template = 'default';
        }

        return $this->from($this->form->mailfrom, $this->form->mailfromname)
            ->subject($this->form->mailfromname . ' - ' . $this->form->title . ' [New Enquiry]')
            ->view('voyager-forms::email-templates.' . $this->form->email_template);
    }
}
