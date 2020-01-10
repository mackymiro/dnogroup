<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use App\User; 
use App\LechonDeCebuPurchaseOrder; 
use App\LechonDeCebuBillingStatement; 

use Session;

class LoloPinoyLechonDeCebuController extends Controller
{

    //storeBillingStatement
    public function storeBillingStatement(Request $request){
         $this->validate($request, [
            'billTo' =>'required',
            'address'=>'required',
            'periodCovered'=>'required',
            'date'=>'required',
            'terms'=>'required',
            'transactionDate'=>'required',
            'wholeLechon'=>'required',
            'description'=>'required',
            'amount'=>'required',
        
        ]);

        $billingStatement = new LechonDeCebuBillingStatement([
            
        ]);


    }

    //billing statement form
    public function billingStatementForm(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        return view('lechon-de-cebu-billing-statement-form', compact('user'));
    }

    //update-po
    public function updatePo(Request $request, $id){
        
        $order = LechonDeCebuPurchaseOrder::find($id);
        

        $order->quantity = $request->get('quant');
        $order->description = $request->get('desc');
        $order->unit_price = $request->get('unitP');
        $order->amount = $request->get('amt');

        $order->save();


        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-lechon-de-cebu/edit/'.$request->get('poId'));
    }

    //save new purchase order
    public function addNewPurchaseOrder(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $pO = LechonDeCebuPurchaseOrder::find($id);


        $addPurchaseOrder = new LechonDeCebuPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addPurchaseOrder->save();

        Session::flash('purchaseOrderSuccess', 'Successfully added purchase order');

        return redirect('lolo-pinoy-lechon-de-cebu/add-new/'.$id);
    }

    //add new purchase order
    public function addNew($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        
        return view('add-new-lechon-de-cebu-purchase-order', compact('user', 'id'));

    }


    //all lists
    public function purchaseOrderAllLists(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        $purchaseOrders = LechonDeCebuPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('lechon-de-cebu-all-lists', compact('user', 'purchaseOrders'));
    }

    //purchase order
    public function purchaseOrder(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        return view('lechon-de-cebu-purchase-order', compact('user'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $id =  Auth::user()->id;
        $user = User::find($id);

        return view('lolo-pinoy-lechon-de-cebu', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        //
         $this->validate($request, [
            'paidTo' => 'required',
            'address'=> 'required',
            'quantity'=>'required',
            'description'=>'required',
            'unitPrice'=>'required',
            'amount'=>'required',
        ]);

        //get the latest insert id query in table purchase order
        $data = DB::select('SELECT id, p_o_number FROM lechon_de_cebu_purchase_orders ORDER BY id DESC LIMIT 1');
        //if code is not zero add plus 1

        if(isset($data[0]->p_o_number) != 0){
            //if code is not 0
            $newNum = $data[0]->p_o_number +1;
            $uNum = sprintf("%06d",$newNum);    
        }else{
            //if code is 0 
            $newNum = 1;
            $uNum = sprintf("%06d",$newNum);
        }
       
        $purchaseOrder = new LechonDeCebuPurchaseOrder([
            'user_id' =>$user->id,
            'paid_to'=>$request->get('paidTo'),
            'address'=>$request->get('address'),
            'p_o_number'=>$uNum,
            'date'=>$request->get('date'),
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'total_price'=>$request->get('amount'),
            'created_by'=>$name,
        ]);


        $purchaseOrder->save();

        $insertedId = $purchaseOrder->id;

        Session::flash('purchaseOrderSuccess', 'Successfully added');
         
        return redirect('lolo-pinoy-lechon-de-cebu/edit/'.$insertedId);
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
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);


        //
        $pOrders = LechonDeCebuPurchaseOrder::where('po_id', $id)->get()->toArray();
        

        return view('view-lechon-de-cebu-purchase-order', compact('user', 'purchaseOrder', 'pOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);

        $pOrders = LechonDeCebuPurchaseOrder::where('po_id', $id)->get()->toArray();

        //get users
        $getUsers = User::get()->toArray();
       

        return view('edit-lechon-de-cebu-purchase-order', compact('user', 'purchaseOrder', 'pOrders', 'getUsers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $paidTo = $request->get('paidTo');
        $address = $request->get('address');
        $quantity = $request->get('quantity');
        $description = $request->get('description');
        $date = $request->get('date');
        $unitPrice = $request->get('unitPrice');
        $amount = $request->get('amount');

        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);
        
        $purchaseOrder->paid_to = $paidTo;
        $purchaseOrder->address = $address;
        $purchaseOrder->date = $date;
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();


        Session::flash('SuccessE', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit/'.$id);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }
}
