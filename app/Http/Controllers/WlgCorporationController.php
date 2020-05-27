<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth; 
use Session; 
use PDF;
use App\User;
use App\WlgCorporationPaymentVoucher;
use App\WlgCorporationPurchaseOrder;
use App\WlgCorporationInvoice;


class WlgCorporationController extends Controller
{

    public function editInvoice($id){   
        
        return view('edit-wlg-corportaion-invoice');
    }

    public function addInvoice(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


        $this->validate($request, [
            'date' => 'required',
            'deliveryTerms'=> 'required',
            'shipper'=>'required',
            'descGoods'=>'required',
        ]);

         //check if invoice number already exists
         $target = DB::table(
            'wlg_corporation_invoices')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        $status = "Invoice Form";
        if($target === NULL){
            $addInvoice = new WlgCorporationInvoice([
                'user_id'=>$user->id,
                'date'=>$request->get('date'),
                'delivery_terms'=>$request->get('deliveryTerms'),
                'tranport_by'=>$request->get('transportBy'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'shipper'=>$request->get('shipper'),
                'consignee'=>$request->get('consignee'),
                'notify_party'=>$request->get('notifyParty'),
                'attention'=>$request->get('attention'),
                'number_of_goods'=>$request->get('no'),
                'description_of_goods'=>$request->get('descGoods'),
                'qty'=>$request->get('qty'),
                'unit_price'=>$request->get('unitPrice'),
                'total_amount'=>$request->get('totalAmount'),
                'status'=>$status,
                'created_by'=>$name,
            ]);
    
            $addInvoice->save();
            $insertedId = $addInvoice->id;
    
            return redirect()->route('editInvoiceWlg', ['id'=>$insertedId]);
        }else{
            return redirect()->route('invoiceFormWlg')->with('error', 'Invoice Number Already Exists.');
        }

      
        
    }

    public function invoiceForm(){
        
        return view('wlg-corporation-invoice-form');
    }

    public function printPO($id){
        $purchaseOrder = WlgCorporationPurchaseOrder::find($id);

        $pOrders = WlgCorporationPurchaseOrder::where('po_id', $id)->get()->toArray();

            //count the total amount 
        $countTotalAmount = WlgCorporationPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = WlgCorporationPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printPOWlg', compact('purchaseOrder', 'pOrders', 'sum'));

        return $pdf->download('wlg-corporation-purchase-order.pdf');
    }

    public function purchaseOrderAllLists(){
        $purchaseOrders = WlgCorporationPurchaseOrder::where('po_id', NULL)->get()->toArray();
        return view('wlg-corporation-purchase-order-lists', compact('purchaseOrders'));
    }

    public function updatePo(Request $request, $id){
        
        $order = WlgCorporationPurchaseOrder::find($id);

        $order->model = $request->get('model');
        $order->particulars = $request->get('particulars');
        $order->quantity = $request->get('quantity');
        $order->unit_price = $request->get('unitPrice');
        $order->amount = $request->get('amount');
        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect()->route('editWlg', ['id'=>$request->get('poId')]);
    }

    public function addNewParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pO = WlgCorporationPurchaseOrder::find($id);

        $addNewParticulars = new WlgCorporationPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'model'=>$request->get('model'),
            'particulars'=>$request->get('particulars'),
            'quantity'=>$request->get('quantity'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNewParticulars->save();
        Session::flash('particularsAdded', 'Particulars added.');

        return redirect()->route('editWlg', ['id'=>$id]);

    }

    public function purchaseOrderForm(){
        
        return view('wlg-corporation-purchase-order');
    }

    public function transactionList(){
        $getTransactionLists = WlgCorporationPaymentVoucher::where('pv_id', NULL)->get()->toArray();

        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmountDue = WlgCorporationPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('wlg-corporation-transaction-list', compact('getTransactionLists', 'totalAmountDue'));

    }

    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        $paymentData = WlgCorporationPaymentVoucher::find($id);
         
        //save payment cheque num and cheque amount
         $addPayment = new WlgCorporationPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,
        ]);

        $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

        return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);
    }

    public function accept(Request $request, $id){
         //get the status 
         $status = $request->get('status');
         if($status == "FULLY PAID AND RELEASED"){
             switch ($request->get('action')) {
                 case 'PAID AND RELEASE':
                     # code...
                     $payables = WlgCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                     Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');
 
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
 
         }else if($status == "FOR APPROVAL"){
             switch ($request->get('action')) {
                 case 'PAID & HOLD':
                     # code...
                     $payables = WlgCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                      Session::flash('payablesSuccess', 'Status set for approval.');
 
                      return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);
 
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
         }else{
 
             switch ($request->get('action')) {
                 case 'PAID & HOLD':
                     # code...
                     $payables = WlgCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                     Session::flash('payablesSuccess', 'Status set for confirmation.');
 
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);
                     
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
         }  
    }

    public function addParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = WlgCorporationPaymentVoucher::find($id);

        //add current amount
         $add = $particulars['amount_due'] + $request->get('amount');

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $addParticulars = new WlgCorporationPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'voucher_ref_number'=>$voucherRef,
            'date'=>$request->get('date'),
            'created_by'=>$name,
        ]);

        $addParticulars->save();

         //update 
         $particulars->amount_due = $add;
         $particulars->save();

         Session::flash('particularsAdded', 'Particulars added.');

         return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);

    }

    public function editPayablesDetail(Request $request, $id){
        $transactionList = WlgCorporationPaymentVoucher::find($id);

        $getChequeNumbers = WlgCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //getParticular details
        $getParticulars = WlgCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
          //amount
        $amount1 = WlgCorporationPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = WlgCorporationPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;

        $chequeAmount1 = WlgCorporationPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = WlgCorporationPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('wlg-corporation-payables-detail', compact('transactionList', 'getParticulars', 'sum' , 
        'getChequeNumbers', 'sumCheque'));
    }

    public function paymentVoucherStore(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the latest insert id query in table payment voucher ref number
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM wlg_corporation_payment_vouchers ORDER BY id DESC LIMIT 1');
        
        //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->voucher_ref_number) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->voucher_ref_number +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
        } 

         //check if invoice number already exists
         $target = DB::table(
            'wlg_corporation_payment_vouchers')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        if($target === NULL){
            $addPaymentVoucher = new WlgCorporationPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'voucher_ref_number'=>$uVoucher,
                'issued_date'=>$request->get('issuedDate'),
                'delivered_date'=>$request->get('deliveredDate'),
                'amount'=>$request->get('amount'),
                'amount_due'=>$request->get('amount'),
                'particulars'=>$request->get('particulars'),
                'prepared_by'=>$name,
                'created_by'=>$name,
            ]);
            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;

            return redirect()->route('editPayablesDetailWlg', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormWlg')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');

        }

    }

    public function paymentVoucherForm(){

        return view('payment-voucher-form-wlg-corp');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('wlg-corporation');
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

        $this->validate($request, [
            'paidTo' => 'required',
            'address'=> 'required',
        ]);

        //get the latest insert id query in table purchase order
        $data = DB::select('SELECT id, p_o_number FROM wlg_corporation_purchase_orders ORDER BY id DESC LIMIT 1');

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

        $purchaseOrder = new WlgCorporationPurchaseOrder([
            'user_id' =>$user->id,
            'paid_to'=>$request->get('paidTo'),
            'address'=>$request->get('address'),
            'p_o_number'=>$uNum,
            'date'=>$request->get('date'),
            'model'=>$request->get('model'),
            'particulars'=>$request->get('particulars'),
            'quantity'=>$request->get('quantity'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $purchaseOrder->save();

        $insertedId = $purchaseOrder->id;

        return redirect()->route('editWlg', ['id'=>$insertedId]);
      
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
        $purchaseOrder = WlgCorporationPurchaseOrder::find($id);
        $pOrders = WlgCorporationPurchaseOrder::where('po_id', $id)->get()->toArray();
        //count the total amount 
        $countTotalAmount = WlgCorporationPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = WlgCorporationPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-wlg-corporation-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseOrder = WlgCorporationPurchaseOrder::find($id);

        $pOrders = WlgCorporationPurchaseOrder::where('po_id', $id)->get()->toArray();

        return view('edit-wlg-corporation-purchase-order', compact('purchaseOrder', 'pOrders'));
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
    }

    public function destroyTransaction($id){
        $transactionList = WlgCorporationPaymentVoucher::find($id);
        $transactionList->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchaseOrder = WlgCorporationPaymentVoucher::find($id);
        $purchaseOrder->delete();
    }
}
