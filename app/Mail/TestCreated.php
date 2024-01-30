<?php

namespace App\Mail;

use App\Models\Test;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $test;

    public function __construct(Test $test)
    {
        $this->test = $test;
    }

    public function build()
    {
        return $this->view('emails.test.created');
    }
}
