<?php

namespace Pvtl\VoyagerForms\Traits;

use Pvtl\VoyagerForms\Form;
use Illuminate\Support\Facades\View;

trait Email
{
    public function sendEmail(Form $form, array $formData)
    {
        $recipients = explode(',', str_replace(' ', '', $form->mailto));

        $subject = "New Form Enquiry - $form->title";

        $headers = "From: " . setting('forms.default_from_email') . "\r\n";
        $headers .= "Reply-To: ". setting('forms.default_from_email') . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $emailLayout = view('voyager-forms::email-templates.default', $formData);

        if (View::exists('email-templates.' . $form->layout)) {
            $emailLayout = view('email-templates.' . $form->layout, $formData);
        }

        foreach ($recipients as $to) {
            mail($to, $subject, $emailLayout->render(), $headers);
        }
    }
}
