<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;
use Auth; 
use Session;
use App\User;
use App\DnoResourcesDevelopmentCorpPaymentVoucher;
use App\DnoResourcesDevelopmentCorpPurchaseOrder;
use App\DnoResourcesDevelopmentCorpDeliveryTransactionForm; 
use App\DnoResourcesDevelopmentCode;

class DnoResourcesDevelopmentController extends Controller
{
   
   
    public function viewDeliveryTransaction($id){
        $deliveryTransaction = DnoResourcesDevelopmentCorpDeliveryTransactionForm::find($id);

        $getTotal = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('id', $id)->sum('total');

        $getSum = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('dt_id', $id)->sum('total');

        $sum = $getTotal + $getSum;

        $dTransactions = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('dt_id', $id)->get()->toArray();
        return view('view-dno-resources-delivery-transaction', compact('deliveryTransaction', 'dTransactions', 'sum'));
    }

    public function deliveryRecords(){
        $deliveryTransactions = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('dt_id', NULL)->get()->toArray();

        return view('dno-resources-delivery-records', compact('deliveryTransactions'));
    }

    public function updateDT(Request $request, $id){
        $updateDt = DnoResourcesDevelopmentCorpDeliveryTransactionForm::find($id);
        $updateDt->delivery_description = $request->get('deliveryDescription');
        $updateDt->qty = $request->get('qty');
        $updateDt->total = $request->get('total');

        $updateDt->save();
        Session::flash('SuccessEdit', 'Successfully edited.');
        return redirect()->route('editDeliveryTransaction', ['id'=>$request->get('dtId')]);
    }

    public function addDelivery(Request $request, $id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $addTransaction = new DnoResourcesDevelopmentCorpDeliveryTransactionForm([
            'user_id'=>$user->id,
            'dt_id'=>$id,
            'delivery_description'=>$request->get('deliveryDescription'),
            'qty'=>$request->get('qty'),
            'total'=>$request->get('total'),
            'created_by'=>$name,
        ]);
        $addTransaction->save();

        Session::flash('addNewSuccess', 'Successfully added.');
        return redirect()->route('editDeliveryTransaction', ['id'=>$id]);

    }

    public function editDeliveryTransaction($id){
        $deliveryT = DnoResourcesDevelopmentCorpDeliveryTransactionForm::find($id);

        $deliveryTransactions = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('dt_id', $id)->get()->toArray();

        return view('dno-resources-edit-delivery-transaction', compact('deliveryT', 'deliveryTransactions'));
    }

    public function addDeliveryTransaction(Request $request){
         //
         $this->validate($request, [
            'supplierName'=>'required',
            'deliveryDescription'=>'required',
        ]);

        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $addDeliveryTransaction = new DnoResourcesDevelopmentCorpDeliveryTransactionForm([
            'user_id'=>$user->id,
            'supplier_name'=>$request->get('supplierName'),
            'delivery_date'=>$request->get('deliveryDate'),
            'delivered_to'=>$request->get('deliveredTo'),
            'dr_no'=>$request->get('drNo'),
            'delivery_description'=>$request->get('deliveryDescription'),
            'qty'=>$request->get('qty'),
            'total'=>$request->get('total'),
            'created_by'=>$name,
        ]);

        $addDeliveryTransaction->save();
        $insertedId = $addDeliveryTransaction->id;

        return redirect()->route('editDeliveryTransaction', ['id'=>$insertedId]);
    

    }

    public function deliveryForm(){
        return view('dno-resources-delivery-form');
    }

    public function purchaseOrderList(){
        $purchaseOrders = DnoResourcesDevelopmentCorpPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('dno-resources-purchase-order-lists', compact('purchaseOrders'));
    }

    public function updatePo(Request $request, $id){
        $order = DnoResourcesDevelopmentCorpPurchaseOrder::find($id);
        
        $order->quantity = $request->get('quantity');
        $order->description = $request->get('description');
        $order->unit = $request->get('unit');
        $order->unit_price  = $request->get('unitPrice');
        $order->amount = $request->get('amount');
    
        $order->save();
        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('dno-resources/edit-dno-resources-purchase-order/'.$request->get('poId'));
    }


    public function addNew(Request $request, $id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        //
          $this->validate($request, [
            'amount'=>'required',
        ]);

        $pO = DnoResourcesDevelopmentCorpPurchaseOrder::find($id);

        $addNewParticulars = new DnoResourcesDevelopmentCorpPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit'=>$request->get('unit'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewParticulars->save();

        Session::flash('addNewSuccess', 'Successfully added');

        return redirect()->route('edit', ['id'=>$id]);
    }

    public function purchaseOrder(){
        return view('dno-resources-purchase-order');
    }

    public function printPayables($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.id', $id)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->get();

        $payablesVouchers = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //getParticular details
        $getParticulars = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
    

          //count the total amount 
        $countTotalAmount = DnoResourcesDevelopmentCorpPaymentVoucher::where('id', $id)->sum('amount_due');


          //
        $countAmount = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesDnoResources', compact('payableId', 'payablesVouchers', 'sum', 'getParticulars'));

        return $pdf->download('dno-resources-payment-voucher.pdf');
    }


    public function viewPayableDetails($id){
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.id', $id)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->get();



        //
        $getViewPaymentDetails = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //getParticular details
          $getParticulars = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
       

        return view('view-dno-resources-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
    }

    //
    public function accept(Request $request, $id){  
         //get the status 
        $status = $request->get('status');
        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                    $payables = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }  
    }

    //
    public function addParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

        //add current amount
         $add = $particulars['amount_due'] + $request->get('amount');


        $addParticulars = new DnoResourcesDevelopmentCorpPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,

        ]);

        $addParticulars->save();

        //update 
        $particulars->amount_due = $add;
        $particulars->save();
        
        Session::flash('particularsAdded', 'Particulars added.');

        return redirect('/dno-resources-development/edit-dno-resources-payables-detail/'.$id);
    }

    //
    public function addPayment(Request $request, $id){  
           $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

        //save payment cheque num and cheque amount
        $addPayment = new DnoResourcesDevelopmentCorpPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

         $addPayment->save();
        Session::flash('paymentAdded', 'Payment added.');

         return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id);
    }

    //
    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.id', $id)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->get();

          //
        $getChequeNumbers = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

         //getParticular details
         $getParticulars = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        //amount
        $amount1 = DnoResourcesDevelopmentCorpPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;

         //
         $chequeAmount1 = DnoResourcesDevelopmentCorpPaymentVoucher::where('id', $id)->sum('cheque_amount');
         $chequeAmount2 = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
         
         $sumCheque = $chequeAmount1 + $chequeAmount2;

         return view('dno-resources-payables-detail', compact('user', 'transactionList', 'getChequeNumbers','sum', 
            'getParticulars', 'sumCheque'));
    }

    //
    public function transactionList(){
       $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->get();



           //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('dno-resources-transaction-list', compact('user', 'getTransactionLists', 'totalAmoutDue'));
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
        $dataVoucherRef = DB::select('SELECT id, dno_resources_code FROM dno_resources_development_codes ORDER BY id DESC LIMIT 1');


          //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->dno_resources_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->dno_resources_code +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
        }

             //check if invoice number already exists
        $target = DB::table(
                        'dno_resources_development_corp_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first(); 
        if ($target === NULL) {
            # code...
              $addPaymentVoucher = new DnoResourcesDevelopmentCorpPaymentVoucher([
                    'user_id'=>$user->id,
                    'paid_to'=>$request->get('paidTo'),
                    'method_of_payment'=>$request->get('paymentMethod'),
                    'invoice_number'=>$request->get('invoiceNumber'),
                    'account_name'=>$request->get('accountName'),
                    'issued_date'=>$request->get('issuedDate'),
                    'delivered_date'=>$request->get('deliveredDate'),
                    'amount'=>$request->get('amount'),
                    'amount_due'=>$request->get('amount'),
                    'particulars'=>$request->get('particulars'),
                    'category'=>$request->get('category'),
                    'prepared_by'=>$name,
                    'created_by'=>$name,
            ]);

            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;

            $moduleCode = "PV-";
            $moduleName = "Payment Voucher";

            $dnoResources = new DnoResourcesDevelopmentCode([
                'user_id'=>$user->id,
                'dno_resources_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);

            $dnoResources->save();

            return redirect()->route('editPayablesDetailDnoResources', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormDnoResources')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
            
        }
    }

    //
    public function paymentVoucherForm(){
        

        return view('payment-voucher-form-dno-resources');
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


        return view('dno-resources', compact('user'));

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

        $this->validate($request, [
            'paidTo' => 'required',
            'description'=>'required',
        ]);

          //get the latest insert id query in table purchase order
          $data = DB::select('SELECT id, p_o_number FROM dno_resources_development_corp_purchase_orders ORDER BY id DESC LIMIT 1');

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

          $purchaseOrder = new DnoResourcesDevelopmentCorpPurchaseOrder([
                'user_id' =>$user->id,
                'p_o_number'=>$uNum,
                'paid_to'=>$request->get('paidTo'),
                'date'=>$request->get('date'),
                'address'=>$request->get('address'),
                'quantity'=>$request->get('quantity'),
                'description'=>$request->get('description'),
                'unit'=>$request->get('unit'),
                'unit_price'=>$request->get('unitPrice'),
                'amount'=>$request->get('amount'),
                'prepared_by'=>$name,
                'created_by'=>$name
          ]);

          $purchaseOrder->save();

          $insertedId = $purchaseOrder->id;

          return redirect()->route('edit', ['id'=>$insertedId]);

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
        $purchaseOrder = DnoResourcesDevelopmentCorpPurchaseOrder::find($id);


        //
        $pOrders = DnoResourcesDevelopmentCorpPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = DnoResourcesDevelopmentCorpPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = DnoResourcesDevelopmentCorpPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-dno-resources-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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
        $purchaseOrder = DnoResourcesDevelopmentCorpPurchaseOrder::find($id);

        $pOrders = DnoResourcesDevelopmentCorpPurchaseOrder::where('po_id', $id)->get()->toArray();

        return view('edit-dno-resources-purchase-order', compact('purchaseOrder', 'pOrders'));
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


    public function destroyDeliveryTransaction($id){
        $deliveryTransaction = DnoResourcesDevelopmentCorpDeliveryTransactionForm::find($id);
        $deliveryTransaction->delete();
    }
    
    public function destroyTransactionList($id){
         $transactionList = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);
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
        //
        $purchaseOrder = DnoResourcesDevelopmentCorpPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }
}
