<?php

namespace App\Listeners;

use App\Events\TestCreated;
use App\Mail\TestCreated as TestCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTestCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(TestCreated $event)
    {
        $test = $event->test;
        $mails = [];

        // Accede a los estudiantes del curso y obtén sus direcciones de correo electrónico
        $studentsEmails = $test->course->students;

        foreach ($studentsEmails as $mail) {
            $mails[] = $mail->user->email;
        }

        // Agrega un log para verificar que el listener se está ejecutando
        Log::info('Listener executed for TestCreated event');

        // Envía el correo electrónico a los estudiantes
        try {
            Mail::to($mails)->send(new TestCreatedMail($test));
            Log::info('Email sent successfully');
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
        }



    }
}
