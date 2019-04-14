<?php

namespace App\Http\Middleware;

use App\Account;
use Closure;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Request;

class Apisms
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $account = Account::where('service', $request->service)->first();

        if (!$account) {
            return response()->json(['status' => '2', 'msg' => 'Bledny kod serwisu.'], 400);
        }

        $server = $account->servers()->where('ip', $request->ip())->first();

        if (!$server) {
            if (Request::isMethod('post')) {
                require '../vendor/autoload.php';

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
                    $mail->Body = '<i>Próba włamania z serwera ' . Request::ip() . ' Odbiorca: ' . $request->recipient . ' Serwis: ' . $request->service . '</i>';
                    $mail->send();
                } catch (phpmailerException $e) {
                    dd($e);
                } catch (Exception $e) {
                    dd($e);
                }
                // die('success');

                return response()->json(['status' => '1', 'msg' => 'Blad dostepu.'], 400);

            }

        }
        return $next($request);
    }
}
