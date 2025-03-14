<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BudgetEmail extends Mailable
{
  use Queueable, SerializesModels;

  public $data;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($data)
  {
    $this->data = $data;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    if ($this->data->contact_method == 'email')  $this->replyTo($this->data->contact_value);
    else $this->replyTo('no-reply@diesa.com.py');

    return $this
        ->subject('Presupuesto desde el sitio web de Honda Motos')
        ->view('mail.budget')
        ->text('mail.budget_plain');
  }
}
