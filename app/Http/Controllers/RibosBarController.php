<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session;
use Auth;
use PDF; 
use App\User;
use App\RibosBarDeliveryReceipt;
use App\RibosBarPurchaseOrder;
use App\RibosBarPaymentVoucher;

class RibosBarController extends Controller
{

    //
    public function updatePaymentVoucher(Request $request, $id){
        $updatePaymentVoucher = RibosBarPaymentVoucher::find($id);

        $updatePaymentVoucher->paid_to = $request->get('paidTo');
        $updatePaymentVoucher->account_no = $request->get('accountNumber');
        $updatePaymentVoucher->date = $request->get('date');
        $updatePaymentVoucher->particulars = $request->get('particulars');
        $updatePaymentVoucher->amount = $request->get('amount');
        $updatePaymentVoucher->method_of_payment = $request->get('methodOfPayment');

        $updatePaymentVoucher->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('ribos-bar/edit-ribos-bar-payment-voucher/'.$id);
    }


    //
    public function editPaymentVoucher($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

          //getPaymentVoucher 
        $getPaymentVoucher = RibosBarPaymentVoucher::find($id);

        //pVoucher
        $pVouchers = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('edit-payment-voucher-ribos-bar', compact('user', 'getPaymentVoucher', 'pVouchers'));
    }

    //
    public function paymentVoucherStore(Request $request){
          //validate
        $this->validate($request, [
            'paidTo' =>'required',
           
        ]);

         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

            //get the latest insert id query in table payment voucher ref number
        $dataReferenceNum = DB::select('SELECT id, reference_number FROM ribos_bar_payment_vouchers ORDER BY id DESC LIMIT 1');

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

        $addPaymentVoucher = new RibosBarPaymentVoucher([
             'user_id'=>$user->id,
            'reference_number'=>$uRef,
            'paid_to'=>$request->get('paidTo'),
            'account_no'=>$request->get('accountNumber'),
            'date'=>$request->get('date'),
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'method_of_payment'=>$request->get('paymentMethod'),
            'prepared_by'=>$name,
            'created_by'=>$name,
        ]);

        $addPaymentVoucher->save();

        $insertedId = $addPaymentVoucher->id;

        return redirect('ribos-bar/edit-ribos-bar-payment-voucher/'.$insertedId);
    }

    //payment voucher form
    public function paymentVoucherForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('payment-voucher-form-ribos-bar', compact('user'));
    }

    //
    public function purchaseOrderList(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        $purchaseOrders = RibosBarPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('ribos-bar-purchase-order-lists', compact('user', 'purchaseOrders'));
    }

    //
    public function updatePo(Request $request, $id){
        $order = RibosBarPurchaseOrder::find($id);
        
        $order->quantity = $request->get('quant');
        $order->description = $request->get('desc');
        $order->unit_price = $request->get('unitP');
        $order->amount = $request->get('amt');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('ribos-bar/edit-ribos-bar-purchase-order/'.$request->get('poId'));
    }

    //
    public function addNewPurchaseOrder(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pO = RibosBarPurchaseOrder::find($id);

         $addPurchaseOrder = new RibosBarPurchaseOrder([
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

        return redirect('ribos-bar/add-new/'.$id);
    }

    //add new
    public function addNew($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        
        return view('add-new-ribos-bar-purchase-order', compact('user', 'id'));
    }

    //
    public function purchaseOrder(){
         $id =  Auth::user()->id;
        $user = User::find($id);

        return view('ribos-bar-purchase-order', compact('user'));
    }

    //print delivery
    public function printDelivery($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $deliveryId = RibosBarDeliveryReceipt::find($id);

        $deliveryReceipts = RibosBarDeliveryReceipt::where('dr_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = RibosBarDeliveryReceipt::where('id', $id)->sum('amount');


          //
        $countAmount = RibosBarDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

         $pdf = PDF::loadView('ribos-bar-printDelivery', compact('deliveryId', 'user', 'deliveryReceipts', 'sum'));

        return $pdf->download('ribos-bar-delivery-receipt.pdf');

    }

    //
    public function viewDeliveryReceipt($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);


        $viewDeliveryReceipt = RibosBarDeliveryReceipt::find($id);

        $deliveryReceipts = RibosBarDeliveryReceipt::where('dr_id', $id)->get()->toArray();

         //count the total unit price
        $countTotalUnitPrice = RibosBarDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = RibosBarDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = RibosBarDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = RibosBarDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        return view('view-ribos-bar-delivery-receipt', compact('user', 'viewDeliveryReceipt', 'deliveryReceipts', 'countUnit', 'sum', 'sum2'));
    }

    //
    public function deliveryReceiptList(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         //getAllDeliveryReceipt
        $getAllDeliveryReceipts = RibosBarDeliveryReceipt::where('dr_id', NULL)->get()->toArray();

        return view('ribos-bar-delivery-receipt-list', compact('user', 'getAllDeliveryReceipts'));
    }

    //
    public function updateDr(Request $request, $id){
        $delivery = RibosBarDeliveryReceipt::find($id);

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

        return redirect('ribos-bar/edit-ribos-bar-delivery-receipt/'.$request->get('drId'));
    }

    //
    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $deliveryReceipt = RibosBarDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

          //get date today
        $getDateToday =  date('Y-m-d');

        $addNewDeliveryReceipt = new RibosBarDeliveryReceipt([
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

        return redirect('ribos-bar/add-new-delivery-receipt/'.$id);

    }

    //
    public function addNewDelivery($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-ribos-bar-delivery-receipt', compact('user', 'id'));
    }

    //
    public function updateDeliveryReceipt(Request $request, $id){
        $updateDeliveryReceipt = RibosBarDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $updateDeliveryReceipt->delivered_to = $request->get('deliveredTo');
        $updateDeliveryReceipt->qty = $request->get('qty');
        $updateDeliveryReceipt->unit = $request->get('unit');
        $updateDeliveryReceipt->product_id = $request->get('productId');
        $updateDeliveryReceipt->item_description = $request->get('itemDescription');
        $updateDeliveryReceipt->unit_price = $unitPrice;
        $updateDeliveryReceipt->address = $request->get('address');
        $updateDeliveryReceipt->amount = $sum;

        $updateDeliveryReceipt->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

         return redirect('ribos-bar/edit-ribos-bar-delivery-receipt/'.$id);
    }

    //
    public function editDeliveryReceipt($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);
        
        //getDeliveryReceipt
        $getDeliveryReceipt = RibosBarDeliveryReceipt::find($id);

         //dReceipts
        $dReceipts = RibosBarDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-ribos-bar-delivery-receipt', compact('user','getDeliveryReceipt', 'dReceipts'));
    }   

    //store delivery receipt
    public function storeDeliveryReceipt(Request $request){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        
        //validate
        $this->validate($request, [
            'deliveredTo' =>'required',
            'productId' =>'required',
            'qty'=>'required',
            'unit'=>'required',
            'itemDescription'=>'required',
            'unitPrice'=>'required',
           
        ]);


         //get the latest insert id query in table delivery receipt dr_no
        $dataDrNo = DB::select('SELECT id, dr_no FROM ribos_bar_delivery_receipts ORDER BY id DESC LIMIT 1');
        
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

         $storeDeliveryReceipt = new RibosBarDeliveryReceipt([
            'user_id'=>$user->id,            
            'dr_no'=>$uDr,
            'date'=>$getDateToday,
            'delivered_to'=>$request->get('deliveredTo'),
            'product_id'=>$request->get('productId'),
            'qty'=>$qty,
            'unit'=>$request->get('unit'),
            'item_description'=>$request->get('itemDescription'),
            'address'=>$request->get('address'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $storeDeliveryReceipt->save();

        $insertedId  = $storeDeliveryReceipt->id;

        return redirect('ribos-bar/edit-ribos-bar-delivery-receipt/'.$insertedId);
    }

    //
    public function deliveryReceiptForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('ribos-bar-delivery-receipt-form', compact('user'));
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

        return view('ribos-bar', compact('user')); 
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

        $name  = $firstName." ".$lastName;

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
        $data = DB::select('SELECT id, p_o_number FROM ribos_bar_purchase_orders ORDER BY id DESC LIMIT 1');

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

         $purchaseOrder = new RibosBarPurchaseOrder([
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

        return redirect('ribos-bar/edit-ribos-bar-purchase-order/'.$insertedId);
        
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

        $purchaseOrder = RibosBarPurchaseOrder::find($id);


        //
        $pOrders = RibosBarPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = RibosBarPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = RibosBarPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;
    

        return view('view-ribos-bar-purchase-order', compact('user', 'purchaseOrder', 'pOrders', 'sum'));
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

        $purchaseOrder = RibosBarPurchaseOrder::find($id);

        $pOrders = RibosBarPurchaseOrder::where('po_id', $id)->get()->toArray();

        //get users
        $getUsers = User::get()->toArray();
       

        return view('edit-ribos-bar-purchase-order', compact('user', 'purchaseOrder', 'pOrders', 'getUsers'));
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

        $name  = $firstName." ".$lastName;

        $paidTo = $request->get('paidTo');
        $address = $request->get('address');
        $quantity = $request->get('quantity');
        $description = $request->get('description');
        $date = $request->get('date');
        $unitPrice = $request->get('unitPrice');
        $amount = $request->get('amount');

         $purchaseOrder = RibosBarPurchaseOrder::find($id);
        
        $purchaseOrder->paid_to = $paidTo;
        $purchaseOrder->address = $address;
        $purchaseOrder->date = $date;
        $purchaseOrder->description = $description;
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();


        Session::flash('SuccessE', 'Successfully updated');

        return redirect('ribos-bar/edit-ribos-bar-purchase-order/'.$id);
    }


    public function destroyDeliveryReceipt($id){
        $deliveryReceipt = RibosBarDeliveryReceipt::find($id);
        $deliveryReceipt->delete();
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
        $purchaseOrder = RibosBarPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }

    
}
