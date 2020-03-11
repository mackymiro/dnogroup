<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;
use Auth; 
use Session; 
use App\User;
use App\LoloPinoyGrillCommissaryDeliveryReceipt;
use App\LoloPinoyGrillCommissaryPurchaseOrder;

class LoloPinoyGrillCommissaryController extends Controller
{

    //billing statement form
    public function billingStatementForm(){
         $id =  Auth::user()->id;
        $user = User::find($id);

        return view('lolo-pinoy-grill-commissary-billing-statement-form', compact('user'));
    }

    
    //purchase order lists
    public function purchaseOrderAllLists(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        $purchaseOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('lolo-pinoy-grill-commissary-purchase-order-lists', compact('user', 'purchaseOrders'));
    }

    //updatePO 
    public function updatePo(Request $request, $id){
        $order = LoloPinoyGrillCommissaryPurchaseOrder::find($id);

        $order->quantity = $request->get('quantity');
        $order->description = $request->get('description');
        $order->unit_price = $request->get('unitPrice');
        $order->amount = $request->get('amount');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/'.$request->get('poId'));
    }

    //store add new purchase order
    public function addNewPurchaseOrder(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $pO = LoloPinoyGrillCommissaryPurchaseOrder::find($id);

        $addNewPurchaseOrder = new LoloPinoyGrillCommissaryPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'total_price'=>$request->get('amount'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $addNewPurchaseOrder->save();

        Session::flash('purchaseOrderSuccess', 'Successfully added purchase order');


        return redirect('lolo-pinoy-grill-commissary/add-new/'.$id);
    }

    //add new purchase order
    public function addNew(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        return view('add-new-lolo-pinoy-grill-purchase-order', compact('user', 'id'));

    }

    //purchase order
    public function purchaseOrder(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('lolo-pinoy-grill-commissary-purchase-order', compact('user'));
    }


    //printDelivery
    public function printDelivery($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $deliveryId = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

        $deliveryReceipts = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->get()->toArray();

          //count the total unit price
        $countTotalUnitPrice = LoloPinoyGrillCommissaryDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = LoloPinoyGrillCommissaryDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printDeliveryLoloPinoyGrill', compact('deliveryId', 'user', 'deliveryReceipts', 'sum', 'sum2'));

        return $pdf->download('lolo-pinoy-grill-commissary-delivery-receipt.pdf');
    }

    //view delivery receipt
    public function viewDeliveryReceipt($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewDeliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

         $deliveryReceipts = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->get()->toArray();

         //count the total unit price
        $countTotalUnitPrice = LoloPinoyGrillCommissaryDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = LoloPinoyGrillCommissaryDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        return view('view-lolo-pinoy-grill-commissary-delivery-receipt', compact('user', 'viewDeliveryReceipt', 'deliveryReceipts', 'countUnit', 'sum', 'sum2'));
    }

    //delivery lists
    public function deliveryReceiptList(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         //getAllDeliveryReceipt
        $getAllDeliveryReceipts = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', NULL)->get()->toArray();


        return view('lolo-pinoy-grill-commissary-delivery-receipt-list', compact('user', 'getAllDeliveryReceipts'));
    }

    //updateDr
    public function updateDr(Request $request, $id){
        $delivery = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $delivery->product_id = $request->get('productId');
        $delivery->qty = $qty;
        $delivery->unit = $request->get('unit');
        $delivery->item_description = $request->get('itemDescription');
        $delivery->unit_price = $unitPrice;
        $delivery->amount = $sum;

        $delivery->save();

         Session::flash('SuccessEdit', 'Successfully updated');
          return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$request->get('drId'));

    }

    //store add new 
    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $deliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

         //get date today
        $getDateToday =  date('Y-m-d');

        $addNewDeliveryReceipt = new LoloPinoyGrillCommissaryDeliveryReceipt([
            'user_id'=>$user->id,
            'dr_id'=>$id,
            'dr_no'=>$deliveryReceipt['dr_no'],
            'date'=>$getDateToday,
            'delivered_to'=>$request->get('deliveredTo'),
            'product_id'=>$request->get('productId'),
            'qty'=>$qty,
            'unit'=>$request->get('unit'),
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $addNewDeliveryReceipt->save();

        Session::flash('addDeliveryReceiptSuccess', 'Successfully added.');

         return redirect('lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-delivery-receipt/'.$id);


    }

    //add new delivery receipt
    public function addNewDelivery($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-lolo-pinoy-grill-delivery-receipt', compact('user', 'id'));
    }

    //update delivery receipt
    public function updateDeliveryReceipt(Request $request, $id){
        $updateDeliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $updateDeliveryReceipt->delivered_to = $request->get('deliveredTo');
        $updateDeliveryReceipt->qty = $request->get('qty');
        $updateDeliveryReceipt->unit = $request->get('unit');
        $updateDeliveryReceipt->item_description = $request->get('itemDescription');
        $updateDeliveryReceipt->unit_price = $unitPrice;
        $updateDeliveryReceipt->amount = $sum;

        $updateDeliveryReceipt->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$id);
    }

    //edit delivery receipt
    public function editDeliveryReceipt($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         //getDeliveryReceipt
        $getDeliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

         //dReceipts
        $dReceipts = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-lolo-pinoy-grill-commissary-delivery-receipt', compact('user','getDeliveryReceipt', 'dReceipts'));
    }

    //storeDeliveryReceipt
    public function storeDeliveryReceipt(Request $request){
          //validate
        $this->validate($request, [
            'deliveredTo' =>'required',
           
        ]);

         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

         //get the latest insert id query in table delivery receipt dr_no
        $dataDrNo = DB::select('SELECT id, dr_no FROM lolo_pinoy_grill_commissary_delivery_receipts ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 dr_no
        if(isset($dataDrNo[0]->dr_no) != 0){
            //if code is not 0
            $newDr = $dataDrNo[0]->dr_no +1;
            $uDr = sprintf("%06d",$newDr);   

        }else{
            //if code is 0 
            $newDr = 1;
            $uDr = sprintf("%06d",$newDr);
        } 

        //get date today
        $getDateToday =  date('Y-m-d');

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $storeDeliveryReceipt = new LoloPinoyGrillCommissaryDeliveryReceipt([
            'user_id'=>$user->id,            
            'dr_no'=>$uDr,
            'date'=>$getDateToday,
            'delivered_to'=>$request->get('deliveredTo'),
            'product_id'=>$request->get('productId'),
            'qty'=>$qty,
            'unit'=>$request->get('unit'),
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $storeDeliveryReceipt->save();
        $insertedId  = $storeDeliveryReceipt->id;

         return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$insertedId);


    }

    //delivery receipt
    public function deliveryReceiptForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('lolo-pinoy-grill-commissary-delivery-receipt-form', compact('user'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ids = Auth::user()->id;
        $user = User::find($ids);


        return view('lolo-pinoy-grill', compact('user'));
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
        //
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
        $data = DB::select('SELECT id, p_o_number FROM lolo_pinoy_grill_commissary_purchase_orders ORDER BY id DESC LIMIT 1');
        
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

        $purchaseOrder = new LoloPinoyGrillCommissaryPurchaseOrder([
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
            'requesting_branch'=>$request->get('requestingBranch'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $purchaseOrder->save();

         $insertedId = $purchaseOrder->id;
         
        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/'.$insertedId);

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
    public function edit($id)
    {
        //
        $ids = Auth::user()->id;
        $user = User::find($ids);

         $purchaseOrder = LoloPinoyGrillCommissaryPurchaseOrder::find($id);

         $pOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', $id)->get()->toArray();


        return view('edit-lolo-pinoy-grill-commissary-purchase-order', compact('user', 'purchaseOrder', 'pOrders'));

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

        $purchaseOrder = LoloPinoyGrillCommissaryPurchaseOrder::find($id);
        
        $purchaseOrder->paid_to = $paidTo;
        $purchaseOrder->address = $address;
        $purchaseOrder->date = $date;
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->description = $description;
        $purchaseOrder->requesting_branch = $request->get('requestingBranch');
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/'.$id);

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
        $purchaseOrder = LoloPinoyGrillCommissaryPurchaseOrder::find($id);
        $purchaseOrder->delete();

    }

    //destroy delivery receipt
    public function destroyDeliveryReceipt($id){
        $deliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);
        $deliveryReceipt->delete();
    }
}
