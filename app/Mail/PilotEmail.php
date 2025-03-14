<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PilotEmail extends Mailable
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
        ->subject('Lead desde sitio web - Honda Motos')
        ->view('mail.pilot_plain')
        ->text('mail.pilot_plain');
  }
}
