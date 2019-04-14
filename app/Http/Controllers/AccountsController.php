<?php

namespace App\Http\Controllers;

use App\Account;
use App\Customer;
use App\Http\Requests\AccounteditRequest;
use App\Http\Requests\AccountRequest;
use App\Message;
use App\Server;
use Illuminate\Http\Request;

class AccountsController extends Controller
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
    public function index(Customer $customer)
    {

        $accounts = Account::with('servers')->with('messages')->where('customer_id', $customer->id)->paginate(10);
        return view('accounts.accounts', compact('customer', 'accounts'));
    }
    public function create(Customer $customer)
    {

        return view('accounts.create', compact('customer'));
    }
    public function store(AccountRequest $request, Customer $customer)
    {
        $validated = $request->validated();
        Account::create($request->all());

        return redirect('/customers/' . $customer->id . '/accounts');
    }
    public function edit(Customer $customer, Account $account)
    {

        return view('accounts.edit', compact('account', 'customer'));
    }
    public function update(AccounteditRequest $request, Customer $customer, Account $account)
    {
        $validated = $request->validated();
        $account->update($request->all());

        return redirect('/customers/' . $customer->id . '/accounts');
    }
    public function destroy(Customer $customer, Account $account)
    {

        $account->delete();

        return redirect('/customers/' . $customer->id . '/accounts');
    }
    public function serverslist(Customer $customer, Account $account)
    {

        return view('accounts.serverslist', compact('account', 'customer'));
    }
    public function manageServers(Account $account)
    {
        $servers = Server::all();
        return view('accounts.manage-servers', compact('account', 'servers'));
    }
    public function updateServers(Request $request, Account $account)
    {

        $account->servers()->sync($request->get('servers', []));

        return redirect(action('AccountsController@serverslist', [$account->customer_id, $account->id]));
    }
    public function messages(Account $account)
    {
        $messages = Message::where('account_id', $account->id)->paginate(10);

        return view('accounts.messages', compact('messages', 'account'));
    }
}
