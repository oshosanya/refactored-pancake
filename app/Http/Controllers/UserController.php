<?php

namespace App\Http\Controllers;

use App\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private function send_sms($phone_number, $message) {
        $phone='234'.$phone_number;
        $url ="http://thinkfirstsms.com/index.php/reseller/"; //this is the url of the gateway's interface
        $request = ""; //initialize the request variable
        $param["username"] = "dajayi";//this is the username of our TM4B account
        $param["password"] = "9395";//this is your password on thinkfirstsms.com
        $param["message"] = $message; //this is the message that we want to send
        $param["mobile"] = $phone;//these are the recipients of the message seperated by comma
        $param["sender"] ="Primera MFB"; //this is our sender//"Primera MFB";
        $param["type"] = "0"; //we are only simulating a broadcast
        foreach($param as $key=>$val)
        {
            $request.= $key."=".urlencode($val); //we have to urlencode the values
            $request.= "&"; //append the ampersand (&) sign after each paramter/value pair
        }
        $request = substr($request, 0, strlen($request)-1); //remove the final ampersand sign from the request
        $ch = curl_init(); //initialize curl handle
        curl_setopt($ch, CURLOPT_URL, $url); //set the url www.thinkfirstsms.com

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //return as a variable
        curl_setopt($ch, CURLOPT_POST, 1); //set POST method
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request); //set the POST variables
        $response = curl_exec($ch); //run the whole process and return the response
        curl_close($ch); //close the curl handle

        if($response == "1002") {
            return true;
        } else {
            return false;
        }
    }

    public function store(Request $request) {
        // $this->validate($request, [
        //     'phone_number' => 'required|numeric',
        //     'password' => 'required|same:repeat_password',
        //     'repeat_password' => 'required'
        // ]);

        $user = new User;
        $user->phone_number = $request->input('phone_number');
        $user->password = app('hash')->make($request->input('password'));//Crypt::encrypt($request->input('password'));
        $user->save();

        $pattern = "/0[0-9]{10}/";
        $activation = $this->get_activation_message();
        if(preg_match($pattern, $request->input('phone_number')) == 1) {
            //$sms_sent = $this->send_sms(substr($request->input('phone_number'), 1), $activation[1]);
            $sms_sent = true;
        }
        $sms_sent = true;
        if($sms_sent) {
            $response = [
                'status' => 'success'
            ];
        } else {
            $response = [
                'status' => 'failure'
            ];
        }

        $user->activation_code = $activation[0];
        $user->save();

        return response()->json($response);
    }

    public function activate(Request $request, $id) {
        $user = User::find($id);
        $activation_code = $user->activation_code;

        if($activation_code == $request->input('activation_code')) {
            $user->activated = true;
            $user->activation_code = NULL;
            $user->save();

            $response = [
                'status' => 'success'
            ];
        } else {
            $response = [
                'status' => 'failure'
            ];
        }
        return response()->json($response);
    }

    private function get_activation_message() {
        $random_number = mt_rand(10000, 99999);
        $message = "You have successfully registered on primeracredit.com. Use this six-digit code $random_number to activate your account.";
        return [$random_number, $message];
    }
}
