<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Contract;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customers.index')->withCustomers(Customer::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.create')->withCustomer(new Customer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = Customer::create($request->all());

        return redirect()->route('customers.edit', $customer)->withMessage('Customer created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());

        return view('customers.edit', compact('customer'))->withMessage('Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        $orders= Order::select('id')->where('customer_id',$customer->id)->get();
        Order::where('customer_id', $customer->id)->delete();
        foreach($orders as $order){
            Contract::where('order_id', $order->id)->delete();
        }


        return redirect()->route('customers.index')->withMessage('Customer deleted successfully');
    }

    public function archived()
    {
        return view('customers.archived')->withCustomers(Customer::onlyTrashed()->paginate(10));
    }

    public function restore($id)
    {
        Customer::where('id', $id)->restore();
        $orders= Order::onlyTrashed()->where('customer_id',$id)->get();
        Order::where('customer_id', $id)->restore();
        foreach($orders as $order)
        {
            Contract::where('order_id', $order->id)->restore();
        }
        return view('customers.archived')->withCustomers(Customer::onlyTrashed()->paginate(10));
    }
}
