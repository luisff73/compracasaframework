<?php

$resend = Resend::client('re_kt8KKNEG_JQd5Qfx2HejwfHKWDFNMvjQn');

$resend->emails->send([
  'from' => 'onboarding@resend.dev',
  'to' => 'jvrluis@hotmail.com',
  'subject' => 'Hello World',
  'html' => '<p>Congrats on sending your <strong>first email</strong>!</p>'
]);