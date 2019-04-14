<?php

namespace App\Http\Controllers;

use App\Account;
use App\Customer;
use App\Http\Requests\ServerseditRequest;
use App\Http\Requests\ServersRequest;
use App\Server;
use Illuminate\Http\Request;

class ServersController extends Controller
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

    public function index()
    {

        $servers = Server::with('accounts')->paginate(10);

        return view('servers.servers', compact('servers'));
    }
    public function create()
    {

        return view('servers.create');
    }
    public function store(ServersRequest $request)
    {
        $validated = $request->validated();
        $servers = Server::create($request->all());

        return redirect('/servers');
    }
    public function edit(Server $server)
    {

        return view('servers.edit', compact('server'));
    }
    public function update(ServerseditRequest $request, Server $server)
    {
        $validated = $request->validated();
        $server->update($request->all());

        return redirect('/servers');
    }
    public function destroy(Server $server)
    {

        $server->accounts()->detach();

        $server->delete();

        return redirect('/servers');
    }
    public function accounts(Server $server)
    {

        $accounts = $server->accounts;
        return view('servers.accounts', compact('server', 'accounts'));
    }
    public function manageAccounts(Account $account, Server $server)
    {

        $customers = Customer::all();
        $accounts = Account::all();
        return view('servers.manage-accounts', compact('customers', 'account', 'server'));
    }
    public function fetch(Request $request, Server $server)
    {
        $value = $request->get('value');
        $accounts = Account::where('customer_id', $value)->get();

        return view('servers.filtered-accounts', compact('accounts', 'server'));
    }
    public function updateAccounts(Request $request, Server $server)
    {
        $accounts = Account::where('customer_id', $request->get('customer_id'))->pluck('id');
        $server->accounts()->detach($accounts);
        $server->accounts()->attach($request->get('accounts', []));

        return redirect(action('ServersController@accounts', [$server->id]));
    }
}
