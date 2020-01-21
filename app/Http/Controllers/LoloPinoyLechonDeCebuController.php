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
    //viewBillingStatement
    public function viewBillingStatement($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewBillingStatement = LechonDeCebuBillingStatement::find($id);
        

        $billingStatements = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        return view('view-lechon-de-cebu-billing-statement', compact('user', 'viewBillingStatement', 'billingStatements'));
    }


    //updateBilling info
    public function updateBillingInfo(Request $request, $id){

        $updateBillingOrder = LechonDeCebuBillingStatement::find($id);

        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $updateBillingOrder->bill_to = $request->get('billTo');
        $updateBillingOrder->address = $request->get('address');
        $updateBillingOrder->period_cover = $request->get('periodCovered');
        $updateBillingOrder->date = $request->get('date');
        $updateBillingOrder->terms = $request->get('terms');
        $updateBillingOrder->p_o_number = $request->get('poNumber');
        $updateBillingOrder->invoice_number = $request->get('invoiceNumber');
        $updateBillingOrder->date_of_transaction = $request->get('transactionDate');
        $updateBillingOrder->whole_lechon = $wholeLechon;
        $updateBillingOrder->description = $request->get('description');
        $updateBillingOrder->amount = $add;

        $updateBillingOrder->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-billing-statement/'.$id);
    }

    //updateBillingStatement
    public function updateBillingStatement(Request $request, $id){

        $updateBilling = LechonDeCebuBillingStatement::find($id);

        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $updateBilling->date_of_transaction = $request->get('transactionDate');
        $updateBilling->whole_lechon = $wholeLechon;
        $updateBilling->description = $request->get('description');
        $updateBilling->invoice_number = $request->get('invoiceNumber');
        $updateBilling->amount = $add;

        $updateBilling->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-lechon-de-cebu/edit-billing-statement/'.$request->get('billingStatementId'));
    }


    //billing statement lists
    public function billingStatementLists(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingStatements = LechonDeCebuBillingStatement::where('billing_statement_id', NULL)->get()->toArray();


        return view('lechon-de-cebu-billing-statement-lists', compact('user', 'billingStatements'));
    }


    //add new billing statement form 
    public function addNewBillingData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = LechonDeCebuBillingStatement::find($id);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        //get the whole lechon then multiply by 500
        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 


        $addBillingStatement = new LechonDeCebuBillingStatement([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'reference_number'=>$billingOrder['reference_number'],
            'p_o_number'=>$billingOrder['p_o_number'],
            'date_of_transaction'=>$request->get('transactionDate'),
            'invoice_number'=>$request->get('invoiceNumber'),
            'whole_lechon'=>$wholeLechon,
            'description'=>$request->get('description'),
            'amount'=>$add,
            'created_by'=>$name,
        ]);

        $addBillingStatement->save();

        Session::flash('addBillingSuccess', 'Successfully added.');

        return redirect('lolo-pinoy-lechon-de-cebu/add-new-billing/'.$id);
        
    }

    //add new billing statement
    public function addNewBilling($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-lechon-de-cebu-billing-statement', compact('user', 'id'));
    }


    //edit billing statement 
    public function editBillingStatement($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $billingStatement = LechonDeCebuBillingStatement::find($id);
       
        $bStatements = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //get the purchase order lists
        $getPurchaseOrders = LechonDeCebuPurchaseOrder::where('po_id', NULL)->get()->toArray();
        
        return view('edit-billing-statement-form', compact('user', 'billingStatement', 'bStatements', 'getPurchaseOrders'));
    }

    //storeBillingStatement
    public function storeBillingStatement(Request $request){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName.$lastName;

        //validate
        $this->validate($request, [
            'billTo' =>'required',
            'address'=>'required',
            'invoiceNumber'=>'required',
            'periodCovered'=>'required',
            'date'=>'required',
            'terms'=>'required',
            'transactionDate'=>'required',
            'wholeLechon'=>'required',
            'description'=>'required',
        ]);

        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 
       
       
        //get the latest insert id query in table billing statements ref number
        $dataReferenceNum = DB::select('SELECT id, reference_number FROM lechon_de_cebu_billing_statements ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataReferenceNum[0]->reference_number) != 0){
            //if code is not 0
            $newRefNum = $dataReferenceNum[0]->reference_number +1;
            $uRef = sprintf("%06d",$newRefNum);   

        }else{
            //if code is 0 
            $newRefNum = 1;
            $uRef = sprintf("%06d",$newRefNum);
        } 

       
        $billingStatement = new LechonDeCebuBillingStatement([
            'user_id'=>$user->id,
            'bill_to'=>$request->get('billTo'),
            'address'=>$request->get('address'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'invoice_number'=>$request->get('invoiceNumber'),
            'reference_number'=>$uRef,
            'p_o_number'=>$request->get('poNumber'),
            'terms'=>$request->get('terms'),
            'date_of_transaction'=>$request->get('transactionDate'),
            'whole_lechon'=>$wholeLechon,
            'description'=>$request->get('description'),
            'amount'=>$add,
            'created_by'=>$name,
            'prepared_by'=>$name,
        ]);

        $billingStatement->save();

        $insertedId = $billingStatement->id;

        //Session::flash('billingStatementSuccess', 'Successfully added');
         
        return redirect('lolo-pinoy-lechon-de-cebu/edit-billing-statement/'.$insertedId);

    }

    //billing statement form
    public function billingStatementForm(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        //get the purchase order lists
        $getPurchaseOrders = LechonDeCebuPurchaseOrder::where('po_id', NULL)->get()->toArray();
       

        return view('lechon-de-cebu-billing-statement-form', compact('user', 'getPurchaseOrders'));
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

    //delete billing statement
    public function destroyBillingStatement($id){
        //
        $billingStatement = LechonDeCebuBillingStatement::find($id);
        $billingStatement->delete();
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
