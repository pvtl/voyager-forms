<?php

namespace Pvtl\VoyagerForms\Traits;

use Pvtl\VoyagerForms\Form;

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

        $emailData = [];

        array_unshift($emailData, "<html><body>");

        foreach ($formData as $key => $value) {
            $realKey = str_replace('_', ' ', $key);
            $emailData[] = "$realKey: $value<br>";
        }

        $emailData = implode("\r\r", $emailData);
        $emailData .= "</body></html>";

        foreach ($recipients as $to) {
            mail($to, $subject, $emailData, $headers);
        }
    }
}
