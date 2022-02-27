<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Tag;
use App\Models\Contract;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $orders =Order::with('contracts')->paginate(10);
        dd($orders); */
        return view('orders.index')->withOrders(Order::with('contracts')->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $customers = Customer::all();
        $tags = Tag::all();
        $order = new Order;

        return view('orders.create', compact('customers','tags','order'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $order = Order::create($request->all());
        $order->tags()->attach($request['tag_id']);

        $customerName = Customer::select('first_name', 'last_name')->where('id',$request->customer_id)->first();
        $customerName = $customerName ->first_name . " " . $customerName->last_name;

        $contractData= array(
            "title" => "Contratto di " . $customerName,
            "order_id"    => $order->id

        );

        $contract = Contract::create($contractData);

        return redirect()->route('orders.edit', $order)->withMessage('Order created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {

        $customers = Customer::all();
        $tags = Tag::all();

        $tagsChecked = [];
        foreach($order->tags as $tag){
            array_push($tagsChecked,$tag->id);
        }

        $customerChosen = Customer::select('id')->where('id', $order->customer_id)->first();

        return view('orders.edit', compact('customers','tags','order','customerChosen','tagsChecked'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {

        if($order->customer_id != intval($request->customer_id)){
            $customerName = Customer::select('first_name', 'last_name')->where('id',$request->customer_id)->first();
            $customerName = $customerName ->first_name . " " . $customerName->last_name;

            $contractData= array(
                "title" => "Contratto di " . $customerName,
            );

            $contract = Contract::where('order_id', $order->id)->update($contractData);
        }


        $order->update($request->all());
        $order->tags()->sync($request['tag_id']);

        $tags = Tag::all();
        $customers = Customer::all();

        $tagsChecked = [];
        foreach($order->tags as $tag){
            array_push($tagsChecked,$tag->id);
        }

        $customerChosen = Customer::select('id')->where('id', $order->customer_id)->first();

        return view('orders.edit', compact('customers','tags','order','customerChosen','tagsChecked'))->withMessage('Order updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        Contract::where('order_id', $order->id)->delete();

        return redirect()->route('orders.index')->withMessage('Customer deleted successfully');
    }

    public function archived()
    {
        return view('orders.archived')->withOrders(Order::onlyTrashed()->with('contracts')->paginate(10));
    }

    public function restore($id)
    {
        Order::where('id', $id)->restore();
        Contract::where('order_id', $id)->restore();
        $customerId = Order::select('customer_id')->where('id',$id)->first();
        $customer = Customer::withTrashed()->where('id',$customerId->customer_id)->first();
        if(!empty($customer->deleted_at)){
            Customer::where('id',$customer->id)->restore();
        }

        return view('orders.archived')->withOrders(Order::onlyTrashed()->paginate(10));
    }
}
