<?php

namespace App\Http\Controllers;

use App\Account;
use App\Customer;
use App\Message;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $from = $request->from;
        $to = $request->to;

        $customer_id = $request->customer_id;
        if (!$customer_id && !$month && !$year && !$from && !$to) {
            $messagesDb = Message::select('account_id', 'date', \DB::raw('sum(quantity) as sum'))
                ->groupBy('account_id', \DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                ->with('account')
                ->get();
        } elseif (!$customer_id) {
            if ($month && $year) {
                $messagesDb = Message::select('account_id', 'date', \DB::raw('sum(quantity) as sum'))
                    ->groupBy('account_id', \DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->with('account')
                    ->get();
            } else {
                $from = Carbon::parse($request->from)->startOfDay();
                $to = Carbon::parse($request->to)->endOfDay();
                $messagesDb = Message::select('account_id', 'date', \DB::raw('sum(quantity) as sum'))
                    ->groupBy('account_id', \DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                    ->whereBetween('date', [$from, $to])
                    ->with('account')
                    ->get();
            }
        } elseif (!$year && !$month && $customer_id && !$from && !$to) {
            $customer = Customer::find($customer_id);
            $account_ids = $customer->accounts->pluck('id');
            $messagesDb = Message::select('account_id', \DB::raw('sum(quantity) as sum'))
                ->whereIn('account_id', $account_ids)
                ->groupBy('account_id', \DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                ->with('account')
                ->get();
        } else {
            $customer = Customer::find($customer_id);
            $account_ids = $customer->accounts->withTrashed()->pluck('id');

            if ($month && $year) {
                $messagesDb = Message::select('account_id', 'date', \DB::raw('sum(quantity) as sum'))
                    ->whereIn('account_id', $account_ids)
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->groupBy('account_id', \DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                    ->with('account')
                    ->get();
            } else {
                $from = Carbon::parse($request->from)->startOfDay();
                $to = Carbon::parse($request->to)->endOfDay();
                $messagesDb = Message::select('account_id', 'date', \DB::raw('sum(quantity) as sum'))
                    ->whereIn('account_id', $account_ids)
                    ->whereBetween('date', [$from, $to])
                    ->groupBy('account_id', \DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                    ->with('account')
                    ->get();
            }
        }
        $accounts = Account::withTrashed()->get();
        $customers = Customer::pluck('name', 'id');

        // $customersID = Customer::where('deleted_at', null)->pluck('id');
        // dd($customersID);
        $messages = [];
        $messages_sums = [];
        foreach ($messagesDb as $key => $message) {
            $messages[$message->account->customer_id][] = $message;
            if (!isset($messages_sums[$message->account->customer_id])) {
                $messages_sums[$message->account->customer_id] = 0;
            }
            $messages_sums[$message->account->customer_id] += $message->sum;
        }

        return view('charts', compact('messages', 'customers', 'accounts', 'year', 'messages_sums', 'amount', 'limit'));
    }

    public function changePasswordView()
    {
        return view('auth.passwords.change-password');
    }
    public function changePassword(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Podane aktualne hasło jest nie prawidłowe. Proszę spróbuj jeszcze raz!");
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "Nowe hasło nie może być takie same jak poprzednie. Proszę wpisz inne hasło.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success", "Hasło zostało zmienione!");
    }
}
