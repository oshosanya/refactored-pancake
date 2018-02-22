<?php
/**
 * Created by IntelliJ IDEA.
 * User: oshosanya
 * Date: 2/19/18
 * Time: 5:21 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactForm;
use App\Mail\AcknowledgeContactForm;

use App\Mail as MailStore;

class MailController extends Controller
{
    public function mail(Request $request) {
        $this->validate($request, [
            'first_name' => 'string|nullable',
            'last_name' => 'string|nullable',
            'email_address' => 'email',
            'message' => 'string'
        ]);
        
        $mail_store = new MailStore;
        $mail_store->first_name = $request->input('first_name');
        $mail_store->last_name = $request->input('last_name');
        $mail_store->phone_number = $request->input('phone_number');
        $mail_store->email_address = $request->input('email_address');
        $mail_store->message = $request->input('message');
        $mail_store->save();

        Mail::to('michaeloshosanya@yahoo.com')->send(new ContactForm($request));

        Mail::to($request->input('email_address'))->send(new AcknowledgeContactForm($request));
        
        $response = [
        	'status' => 'success'
        ];
        
        return response()->json($response);
    }
}