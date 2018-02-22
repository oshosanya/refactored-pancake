<?php
/**
 * Created by IntelliJ IDEA.
 * User: oshosanya
 * Date: 2/20/18
 * Time: 7:59 AM
 */

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcknowledgeContactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var $first_name
     * @var $last_name
     * @var $email_address
     * @var $phone_number
     * @var $mail_message
     */
    public $first_name;
    public $last_name;
    public $email_address;
    public $phone_number;
    public $mail_message;

    /**
     * Create a new message instance.
     * @param $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->first_name = $request->input('first_name');
        $this->last_name = $request->input('last_name');
        $this->email_address = $request->input('email_address');
        $this->phone_number = $request->input('phone_number');
        $this->mail_message = $request->input('message');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('noreply@primeracredit.com')
            ->subject('Thank you for contacting us')
            ->view('emails.acknowledge_contact_form')
            ->with([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email_address' => $this->email_address,
                'phone_number' => $this->phone_number,
                'message' => $this->mail_message
            ]);
    }
}