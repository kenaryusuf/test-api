<?php

namespace App\Mail;

use App\Models\Todo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class TodoCreateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function build()
    {
        return $this->view('email.new-task')
            ->subject("Size Yeni Bir Görev Atandı!")
            ->with(['email' => $this->todo->email, "title" => $this->todo->title]);
    }
}
