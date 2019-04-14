<?php

namespace App\Http\Controllers;

use App\Account;
use App\Customer;
use App\Mail\Response;
use App\Message;
use App\Services\SmsApi;
use DateTime;
use File;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Storage;

class ApiController extends Controller
{
    public function sendSms(Request $request)
    {
        $service = $request->service;
        $adviser = $request->adviser;
        $recipient = $request->recipient;
        $message = $request->message;
        $pl = $request->pl;
        $test = $request->test;
        $eco = $request->eco;
        $encoding = $request->encoding;
        if ($eco) {
            $adviser = 'eco';
        }
        $account = Account::where('service', $service)->first();
        $sender = new SmsApi($service, $adviser, $recipient, $message, $pl, $encoding, $test);
        $date = new DateTime();
        $date = $date->format('Y-m-d');
        $response = $sender->send();
        $response = json_decode($response);
        $ip = $request->ip();

        if (!isset($response->error)) {

            $messagesend = new Message;
            $messagesend->account_id = $account->id;
            $messagesend->date = new DateTime();
            $messagesend->adviser = $account->signature;
            $messagesend->quantity = $response->parts;
            $messagesend->recipient = $recipient;
            $messagesend->messages_id = $response->list[0]->id;
            $messagesend->points = $response->list[0]->points;
            $messagesend->save();
            $customer = Customer::where('id', $account->customer_id)->first();
            $place = DIRECTORY_SEPARATOR . $service . DIRECTORY_SEPARATOR . $date . DIRECTORY_SEPARATOR;
            if (!file_exists($place)) {
                File::makeDirectory($place, 0777, true);
            }

            // file_put_contents('messages-' . $date . '.txt', $date . '~Odbiorca: ' . $recipient . '~Klient: ' . $customer->name . '~Ilosc sms: ' . $response->parts . '~id-sms: ' . $response->list[0]->id . '~pobrane-punkty: ' . $response->list[0]->points . '~' . $response->message . '');
            // File::put(storage_path() .$place.'messages-'.$date.'.txt', $date . '~Odbiorca: ' . $recipient . '~Klient: ' . $customer->name . '~Ilosc sms: ' . $response->parts . '~id-sms: ' . $response->list[0]->id . '~pobrane-punkty: ' . $response->list[0]->points . '~' . $response->message . '');
            Storage::append($place . 'messages-' . $date . '.txt', $date . '~Odbiorca: ' . $recipient . '~Klient: ' . $customer->name . '~Ilosc sms: ' . $response->parts . '~id-sms: ' . $response->list[0]->id . '~pobrane-punkty: ' . $response->list[0]->points . '~' . $response->message . '');
            return response()->json([
                'status' => '0',
                'msg' => 'Wiadomosc(' . $response->list[0]->id . ') zostala wyslana.',
                'sms_id' => $response->list[0]->id,
                "outpout" => $response,

            ], 200);
        } elseif ($response->error === 13) {
            return response()->json([

                'status' => '3',
                'msg' => 'Brak poprawnych odbiorcow.',

            ], 400);

        } else {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->SMTPDebug = 0;
                $mail->Host = env('MAIL_HOST');
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = true;
                $mail->Username = env('MAIL_USERNAME');
                $mail->Password = env('MAIL_PASSWORD');
                $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                $mail->Port = env('MAIL_PORT');
                $mail->SetFrom(env('MAIL_FROM'), env('MAIL_NAME'));
                $mail->CharSet = 'UTF-8';
                $mail->addAddress("k.krol@webwizards.pl", "SMSApi");
                //Content
                $mail->isHTML(true);
                $mail->Subject = 'SMS API System Error';
                $mail->Body = '<i>Nieudana wysyłka SMS ' . $ip . ', ' . $account->signature . ', ' . $service . '<br/>BLAD: ' . $response->error . ', ' . $response->message . ', NUMER: ' . $recipient . ' USER: ' . $account->customer->name . '</i>';
                $mail->send();
            } catch (phpmailerException $e) {
                dd($e);
            } catch (Exception $e) {
                dd($e);
            }
        }
        return response()->json([

            'status' => '4',
            'msg' => 'Wystapil blad podczas wysylki.',
            "outpout" => $response,

        ], 400);
    }
}
