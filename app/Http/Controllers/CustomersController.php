<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Account;
use App\Server;
use App\Http\Requests\CustomersRequest;

class CustomersController extends Controller
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
        $customer = Customer::with('accounts')->paginate(10);

        return view('customers.customers')->with('customers', $customer);
    }
    public function create()
    {
        return view('customers.create');
    }
    public function store(CustomersRequest $request)
    {
        $validated = $request->validated();
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->description = $request->description;
        $customer->amount = str_replace(",", ".", $request->amount);
        $customer->count = $request->count;
        $customer->save();

        return redirect('customers');
    }
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }
    public function update(CustomersRequest $request, Customer $customer)
    {
        $validated = $request->validated();
        $customer->name = $request->name;
        $customer->description = $request->description;
        $customer->amount = str_replace(",", ".", $request->amount);
        $customer->count = $request->count;
        $customer->save();


        return redirect('customers');
    }
    public function destroy(Customer $customer)
    {
        foreach ($customer->accounts as $account) {
            $account->servers()->detach();
        }
        $customer->accounts()->delete();

        // $accountslist = Account::where('customer_id', $customer->id)->pluck('id');
        // $servers = Server::all();
        // $servers->account()->detach($accountslist);
        // $accounts = Account::where('customer_id', $customer->id)->delete();
        $customer->delete();
        return redirect('/customers');
    }
}
