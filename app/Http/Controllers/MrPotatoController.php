<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session;
use Auth; 
use PDF;
use App\User;
use App\MrPotatoPurchaseOrder;
use App\MrPotatoDeliveryReceipt;
use App\MrPotatoPaymentVoucher;
use App\MrPotatoSalesInvoice;
use App\MrPotatoUtility;

class MrPotatoController extends Controller
{     

    //
    public function viewBills($id){
         //
        $viewBill = MrPotatoUtility::find($id);
        
        //view particulars
         $viewParticulars = MrPotatoPaymentVoucher::where('sub_category_account_id', $id)->get()->toArray();
 
        return view('mr-potato-view-utility', compact('viewBill', 'viewParticulars'));
    }

    //
    public function addInternet(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
         $getDate =  date("Y-m-d");

        //check if internet account already exists
        $target = DB::table(
                'mr_potato_utilities')
                ->where('account_id', $request->accountIdInternet)
                ->get()->first();

        if($target ==  NULL){
    
            $addInternet = new MrPotatoUtility([
                'user_id'=>$user->id,
                'account_id'=>$request->accountIdInternet,
                'account_name'=>$request->accountNameInternet,
                'date'=>$getDate,
                'flag'=>$request->flagInternet,
                'created_by'=>$name,
            ]);

            $addInternet->save();
            return response()->json('Success: successfully added an account.');
        }else{
            return response()->json('Error: Account ID already exist.');
        }
    }

    //
    public function addBills(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the date today
        $getDate =  date("Y-m-d");

         //check if veco account and mcwd already exists
        $target = DB::table(
                'mr_potato_utilities')
                ->where('account_id', $request->accountId)
                ->get()->first();

        if($target == NULL){

            $addBills = new MrPotatoUtility([
                'user_id'=>$user->id,
                'account_id'=>$request->accountId,
                'account_name'=>$request->accountName,
                'meter_no'=>$request->meterNo,
                'date'=>$getDate,
                'flag'=>$request->flag,
                'created_by'=>$name,
            ]);

            $addBills->save();
            return response()->json('Success: successfully added an account.');
        }else{
            return response()->json('Error: Account ID already exist.');
        }
        
    }

    //
    public function utilities(){
        $flag = "Veco";
        $flagMCWD = "MCWD";
        $flagInternet = "Internet";

        $vecoDocuments = MrPotatoUtility::where('flag', $flag)->get()->toArray();

        $mcwdDocuments = MrPotatoUtility::where('flag', $flagMCWD)->get()->toArray();

        $internetDocuments = MrPotatoUtility::where('flag', $flagInternet)->get()->toArray();

        return view('mr-potato-utilities', compact('vecoDocuments', 'mcwdDocuments', 'internetDocuments'));
    }

    //
    public function pettyCashList(){
        return view('mr-potato-petty-cash-list');
    }

    //
    public function printPO($id){
       
        $purchaseOrder = MrPotatoPurchaseOrder::find($id);

          //
        $pOrders = MrPotatoPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = MrPotatoPurchaseOrder::where('id', $id)->sum('price');

        //
        $countAmount = MrPotatoPurchaseOrder::where('po_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;


        $pdf = PDF::loadView('printMrPotatoPO', compact('purchaseOrder', 'pOrders', 'sum'));

        return $pdf->download('mr-potato-purchase-order.pdf');
    }

    //
    public function printPayables($id){
     

        $payableId = MrPotatoPaymentVoucher::find($id);

        $payablesVouchers = MrPotatoPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //getParticular details
        $getParticulars = MrPotatoPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
     

          //count the total amount 
        $countTotalAmount = MrPotatoPaymentVoucher::where('id', $id)->sum('amount_due');

         //
        $countAmount = MrPotatoPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       
         $pdf = PDF::loadView('printPayablesMrPotato', compact('payableId',  'payablesVouchers', 'sum', 'getParticulars'));

        return $pdf->download('mr-potato-payment-voucher.pdf');
    }  

    //
    public function viewPayableDetails($id){
       
        //
        $viewPaymentDetail = MrPotatoPaymentVoucher::find($id);

        //
        $getViewPaymentDetails = MrPotatoPaymentVoucher::where('pv_id', $id)->get()->toArray();

         //getParticular details
         $getParticulars = MrPotatoPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
       

        return view('view-mr-potato-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
    }

    //
    public function accept(Request $request, $id){
         //get the status 
        $status = $request->get('status');
        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                    $payables = MrPotatoPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = MrPotatoPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = MrPotatoPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = MrPotatoPaymentVoucher::find($id);

        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

        //get Category
        $cat = $particulars['category'];

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $subAccountId = $particulars['sub_category_account_id'];

        $addParticulars = new MrPotatoPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'voucher_ref_number'=>$voucherRef,
            'category'=>$cat,
            'sub_category_account_id'=>$subAccountId,
            'date'=>$request->get('date'),
            'created_by'=>$name,
        ]);

        $addParticulars->save();

        //update 
        $particulars->amount_due = $add;
        $particulars->save();
        
        Session::flash('particularsAdded', 'Particulars added.');

        return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id);
    }

    //
    public function addPayment(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         $paymentData = MrPotatoPaymentVoucher::find($id);

        //save payment cheque num and cheque amount
        $addPayment = new MrPotatoPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

         $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

         return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id);
    }

    //
    public function editPayablesDetail(Request $request, $id){
     

        $transactionList = MrPotatoPaymentVoucher::find($id);

          //
        $getChequeNumbers = MrPotatoPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //getParticular details
        $getParticulars = MrPotatoPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        //amount
        $amount1 = MrPotatoPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = MrPotatoPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;

        $chequeAmount1 = MrPotatoPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = MrPotatoPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('mr-potato-payables-detail', compact('transactionList', 'getChequeNumbers',
            'getParticulars', 'sum', 'sumCheque'));
    }

    //
    public function transactionList(){
    
         //
        $getTransactionLists = MrPotatoPaymentVoucher::where('pv_id', NULL)->orderBy('id', 'desc')->get()->toArray();

           //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = MrPotatoPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('mr-potato-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));

    }


    //
    public function printDelivery($id){
       

        $deliveryId = MrPotatoDeliveryReceipt::find($id);

        $deliveryReceipts = MrPotatoDeliveryReceipt::where('dr_id', $id)->get()->toArray();

          //count the total unit price
        $countTotalUnitPrice = MrPotatoDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = MrPotatoDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = MrPotatoDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = MrPotatoDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('mr-potato-printDelivery', compact('deliveryId', 'deliveryReceipts', 'sum'));

        return $pdf->download('mr-potato-delivery-receipt.pdf');
    }

    //
    public function viewSalesInvoice($id){
      
        $viewSalesInvoice = MrPotatoSalesInvoice::find($id);

        $salesInvoices = MrPotatoSalesInvoice::where('si_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = MrPotatoSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = MrPotatoSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-mr-potato-sales-invoice', compact('viewSalesInvoice', 'salesInvoices', 'sum'));
    }

    //
    public function updateSi(Request $request, $id){
        $updateSi = MrPotatoSalesInvoice::find($id);

          //kls
        $kls  = $request->get('totalKls');

         //compute kls * unit price
        $unitPrice = $updateSi->unit_price;
        $compute = $kls * $unitPrice;
        $sum = $compute;

        $updateSi->qty = $request->get('qty');
        $updateSi->total_kls = $kls;
        $updateSi->item_description = $request->get('itemDescription');
        $updateSi->unit_price = $unitPrice;
        $updateSi->amount = $sum;

        $updateSi->save();

         Session::flash('SuccessEdit', 'Successfully updated');

        return redirect('mr-potato/edit-mr-potato-sales-invoice/'.$request->get('siId'));
    }


    //
    public function addNewSalesInvoiceData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


           //get date today
        $getDateToday =  date('Y-m-d');

        //kls
        $kls  = $request->get('totalKls');

         //compute kls * unit price
        $unitPrice = 500;
        $compute = $kls * $unitPrice;
        $sum = $compute;

        $addNewSalesInvoice = new MrPotatoSalesInvoice([
            'user_id'=>$user->id,
            'si_id'=>$id,
            'date'=>$getDateToday,
            'qty'=>$request->get('qty'),
            'total_kls'=>$kls,
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'created_by'=>$name,
        ]);

        $addNewSalesInvoice->save();
        Session::flash('addSalesInvoiceSuccess', 'Successfully added.');

        return redirect('mr-potato/add-new-mr-potato-sales-invoice/'.$id);
    }

    //
    public function addNewSalesInvoice($id){
    
        return view('add-new-mr-potato-sales-invoice', compact('id'));
    }

    //
    public function updateSalesInvoice(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $updateSalesInvoice = MrPotatoSalesInvoice::find($id);

          //kls
        $kls  = $request->get('totalKls');

        //compute kls * unit price
        $unitPrice = $updateSalesInvoice->unit_price;
        $compute = $kls * $unitPrice;
        $sum = $compute;

        $updateSalesInvoice->invoice_number = $request->get('invoiceNum');
        $updateSalesInvoice->ordered_by = $request->get('orderedBy');
        $updateSalesInvoice->address = $request->get('address');
        $updateSalesInvoice->qty = $request->get('qty');
        $updateSalesInvoice->total_kls = $kls;
        $updateSalesInvoice->item_description = $request->get('itemDescription');
        $updateSalesInvoice->amount = $sum;
        $updateSalesInvoice->created_by = $name; 

        $updateSalesInvoice->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

         return redirect('mr-potato/edit-mr-potato-sales-invoice/'.$id);
    } 

    //]
    public function editSalesInvoice($id){
    
         //getSalesInvoice
        $getSalesInvoice = MrPotatoSalesInvoice::find($id);

        $sInvoices  = MrPotatoSalesInvoice::where('si_id', $id)->get()->toArray();

        return view('edit-mr-potato-sales-invoice', compact('getSalesInvoice', 'sInvoices'));
    }

    //store sales invoice form
    public function storeSalesInvoice(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //validate
        $this->validate($request, [
            'invoiceNum' =>'required',
            'orderedBy'=>'required',
           
        ]);

         //get date today
        $getDateToday =  date('Y-m-d');

        //total kls
        $kls = $request->get('totalKls');

        //compute kls * unit price
        $unitPrice = 500;
        $compute = $kls * $unitPrice;
        $sum = $compute;

        $addSalesInvoice = new MrPotatoSalesInvoice([
            'user_id'=>$user->id,
            'invoice_number'=>$request->get('invoiceNum'),
            'ordered_by'=>$request->get('orderedBy'),
            'address'=>$request->get('address'),
            'date'=>$getDateToday,
            'qty'=>$request->get('qty'),
            'total_kls'=>$kls,
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'created_by'=>$name,
        ]);

        $addSalesInvoice->save();

        $insertedId = $addSalesInvoice->id;

        return redirect('mr-potato/edit-mr-potato-sales-invoice/'.$insertedId);

    }

    //sales invoice form
    public function salesInvoiceForm(){

        return view('mr-potato-sales-invoice-form');
    }                                                   

    //
    public function chequeVouchers(){

        //getAllChequeVouchers
        $method = "Cheque";

        $getAllChequeVouchers = MrPotatoPaymentVoucher::where('method_of_payment', $method)->get()->toArray(); 

        return view('cheque-vouchers-lists-mr-potato', compact('getAllChequeVouchers')); 
    }

    //
    public function cashVouchers(){
    
         //getAllCashVouchers
        $method = "Cash";

        $getAllCashVouchers = MrPotatoPaymentVoucher::where('method_of_payment', $method)->get()->toArray();

        return view('cash-vouchers-list-mr-potato', compact('getAllCashVouchers'));

    }

    //
    public function updatePV(Request $request, $id){
         $updatePV = MrPotatoPaymentVoucher::find($id);

        $updatePV->particulars = $request->get('particulars');
        $updatePV->amount = $request->get('amount');

        $updatePV->save();

        Session::flash('SuccessEdit', 'Successfully updated');

         return redirect('mr-potato/edit-mr-potato-payment-voucher/'.$request->get('pvId'));
    }

    //
    public function addNewPaymentVoucherData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentVoucher = MrPotatoPaymentVoucher::find($id);

         $addNewPaymentVoucherData = new MrPotatoPaymentVoucher([
             'user_id'=>$user->id,
            'pv_id'=>$id,
            'reference_number'=>$paymentVoucher['reference_number'],
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewPaymentVoucherData->save();

        Session::flash('addPaymentVoucherSuccess', 'Successfully added.');
        
        return redirect('mr-potato/add-new-mr-potato-payment-voucher/'.$id);
    }


    //
    public function addNewPaymentVoucher($id){
      
        return view('add-new-mr-potato-payment-voucher', compact('id'));
    }


    //updatePaymentVoucher
    public function updatePaymentVoucher(Request $request, $id){
        $updatePaymentVoucher = MrPotatoPaymentVoucher::find($id);

        $updatePaymentVoucher->paid_to = $request->get('paidTo');
        $updatePaymentVoucher->account_no = $request->get('accountNumber');
        $updatePaymentVoucher->date = $request->get('date');
        $updatePaymentVoucher->particulars = $request->get('particulars');
        $updatePaymentVoucher->amount = $request->get('amount');
        $updatePaymentVoucher->method_of_payment = $request->get('methodOfPayment');

        $updatePaymentVoucher->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('mr-potato/edit-mr-potato-payment-voucher/'.$id);

    }


    public function editPaymentVoucher($id){    
          //getPaymentVoucher 
        $getPaymentVoucher = MrPotatoPaymentVoucher::find($id);

        //pVoucher
        $pVouchers = MrPotatoPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('edit-payment-voucher-mr-potato', compact('getPaymentVoucher', 'pVouchers'));
    }

    //store voucher
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
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM mr_potato_payment_vouchers ORDER BY id DESC LIMIT 1');

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

          //get the category
       if($request->get('category') == "Petty Cash"){
             $subCat = NULL;
             $subCatAcctId = NULL;

        }else if($request->get('category') == "Utilities"){
            $subCat = $request->get('bills');
            $subCatAcctId = $request->get('selectAccountID');

        }else if($request->get('category') == "None"){
            $subCat = NULL;
            $subCatAcctId = NULL;
        }else if($request->get('category') == "Payroll"){
            $subCat = NULL;
            $subCatAcctId = NULL;
        }

         //check if invoice number already exists
        $target = DB::table(
                        'mr_potato_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...
              $addPaymentVoucher = new MrPotatoPaymentVoucher([
                    'user_id'=>$user->id,
                    'paid_to'=>$request->get('paidTo'),
                    'invoice_number'=>$request->get('invoiceNumber'),
                    'account_name'=>$request->get('accountName'),
                    'method_of_payment'=>$request->get('paymentMethod'),
                    'voucher_ref_number'=>$uVoucher,
                    'issued_date'=>$request->get('issuedDate'),
                    'delivered_date'=>$request->get('deliveredDate'),
                    'amount'=>$request->get('amount'),
                    'amount_due'=>$request->get('amount'),
                    'particulars'=>$request->get('particulars'),
                    'category'=>$request->get('category'),
                    'sub_category'=>$subCat,
                    'sub_category_account_id'=>$subCatAcctId,
                    'prepared_by'=>$name,
                    'created_by'=>$name,
                ]);

                $addPaymentVoucher->save();
               
                $insertedId = $addPaymentVoucher->id;

                 return redirect()->route('editPayablesDetailMrPotato', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormMrPotato')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    
    }

    //
    public function paymentVoucherForm(){
        $getAllFlags = MrPotatoUtility::where('u_id', NULL)->get()->toArray();
        return view('payment-voucher-form-mr-potato', compact('getAllFlags'));
    }

    //
    public function viewDeliveryReceipt($id){
    
        $viewDeliveryReceipt = MrPotatoDeliveryReceipt::find($id);

        $deliveryReceipts = MrPotatoDeliveryReceipt::where('dr_id', $id)->get()->toArray();

         //count the total unit price
        $countTotalUnitPrice = MrPotatoDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = MrPotatoDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = MrPotatoDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = MrPotatoDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        return view('view-mr-potato-delivery-receipt', compact('viewDeliveryReceipt', 'deliveryReceipts', 'countUnit', 'sum', 'sum2'));
    }

    //
    public function deliveryReceiptList(){
      
         //getAllDeliveryReceipt
        $getAllDeliveryReceipts = MrPotatoDeliveryReceipt::where('dr_id', NULL)->get()->toArray();

        return view('mr-potato-delivery-receipt-list', compact('getAllDeliveryReceipts'));
    }

    //
    public function updateDr(Request $request, $id){
        $delivery = MrPotatoDeliveryReceipt::find($id);

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

        return redirect('mr-potato/edit-mr-potato-delivery-receipt/'.$request->get('drId'));

    }

    //
    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $deliveryReceipt = MrPotatoDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

         //get date today
        $getDateToday =  date('Y-m-d');

          $addNewDeliveryReceipt = new MrPotatoDeliveryReceipt([
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

        return redirect('mr-potato/add-new-delivery-receipt/'.$id);

    }

    //add new
    public function addNewDelivery($id){
        return view('add-new-mr-potato-delivery-receipt', compact('id'));
    }

    //update 
    public function updateDeliveryReceipt(Request $request, $id){
        $updateDeliveryReceipt = MrPotatoDeliveryReceipt::find($id);

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

         return redirect('mr-potato/edit-mr-potato-delivery-receipt/'.$id);

    }

    public function editDeliveryReceipt($id){
        
        //getDeliveryReceipt
        $getDeliveryReceipt = MrPotatoDeliveryReceipt::find($id);

         //dReceipts
        $dReceipts = MrPotatoDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-mr-potato-delivery-receipt', compact('getDeliveryReceipt', 'dReceipts'));
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
        $dataDrNo = DB::select('SELECT id, dr_no FROM mr_potato_delivery_receipts ORDER BY id DESC LIMIT 1');
        
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

        $storeDeliveryReceipt = new MrPotatoDeliveryReceipt([
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

        return redirect('mr-potato/edit-mr-potato-delivery-receipt/'.$insertedId);


    }

    public function deliveryReceiptForm(){
        return view('mr-potato-delivery-receipt-form');
    }

    //purchase order all lists
    public function purchaseOrderAllLists(){

        $purchaseOrders = MrPotatoPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('mr-potato-purchase-order-lists', compact('purchaseOrders')); 
    }

    //update Po
    public function updatePo(Request $request, $id){
        $order = MrPotatoPurchaseOrder::find($id);
        
        $order->particulars = $request->get('particulars');
        $order->qty = $request->get('qty');
        $order->unit = $request->get('unit');
        $order->price = $request->get('price');
        $order->subtotal = $request->get('subtotal');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');

        return redirect('mr-potato/edit-mr-potato-purchase-order/'.$request->get('poId'));
    }

  
    //add new pO
    public function addNew(Request $request, $id){

        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

         //
         $this->validate($request, [
            'price'=>'required',
        ]);

        $pO = MrPotatoPurchaseOrder::find($id);

        $addNewParticulars = new MrPotatoPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'particulars'=>$request->get('particulars'),
            'qty'=>$request->get('qty'),
            'unit'=>$request->get('unit'),
            'price'=>$request->get('price'),
            'subtotal'=>$request->get('subtotal'),
            'created_by'=>$name,
        ]);

        $addNewParticulars->save();

        Session::flash('addNewSuccess', 'Successfully added');

        return redirect('mr-potato/edit-mr-potato-purchase-order/'.$id);

    }

    //purchase order
    public function purchaseOrder(){

        return view('mr-potato-purchase-order');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
     
        $getAllSalesInvoices = MrPotatoSalesInvoice::where('si_id', NULL)->get()->toArray();

        return view('mr-potato', compact('getAllSalesInvoices'));
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
            'branchLocation' => 'required',
            'orderedBy'=> 'required',
            'unit'=>'required',
            'price'=>'required',
        ]);

           //get the latest insert id query in table purchase order
        $data = DB::select('SELECT id, p_o_number FROM mr_potato_purchase_orders ORDER BY id DESC LIMIT 1');


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

        $purchaseOrder = new MrPotatoPurchaseOrder([
            'user_id' =>$user->id,
            'p_o_number'=>$uNum,
            'branch_location'=>$request->get('branchLocation'),
            'date'=>$request->get('date'),
            'ordered_by'=>$request->get('orderedBy'),
            'particulars'=>$request->get('particulars'),
            'qty'=>$request->get('qty'),
            'unit'=>$request->get('unit'),
            'price'=>$request->get('price'),
            'subtotal'=>$request->get('subtotal'),
            'prepared_by'=>$name,
            'created_by'=>$name,
        ]);

        $purchaseOrder->save();

        $insertedId = $purchaseOrder->id;

        return redirect('mr-potato/edit-mr-potato-purchase-order/'.$insertedId);
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
        
        $purchaseOrder = MrPotatoPurchaseOrder::find($id);


        //
        $pOrders = MrPotatoPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = MrPotatoPurchaseOrder::where('id', $id)->sum('price');

        //
        $countAmount = MrPotatoPurchaseOrder::where('po_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;

         return view('view-mr-potato-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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

        $purchaseOrder = MrPotatoPurchaseOrder::find($id);

        $pOrders = MrPotatoPurchaseOrder::where('po_id', $id)->get()->toArray();

         return view('edit-mr-potato-purchase-order', compact('purchaseOrder', 'pOrders'));
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

        $purchaseOrder = MrPotatoPurchaseOrder::find($id);

        $purchaseOrder->branch_location = $request->get('branchLocation');
        $purchaseOrder->date = $request->get('date');
        $purchaseOrder->ordered_by = $request->get('orderedBy');
        $purchaseOrder->particulars = $request->get('particulars');
        $purchaseOrder->qty = $request->get('qty');
        $purchaseOrder->unit = $request->get('unit');
        $purchaseOrder->price = $request->get('price');
        $purchaseOrder->subtotal = $request->get('subtotal');
 
        $purchaseOrder->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect('mr-potato/edit-mr-potato-purchase-order/'.$id);
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
        $purchaseOrder = MrPotatoPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }

    public function destroyDeliveryReceipt($id){
        $deliveryReceipt = MrPotatoDeliveryReceipt::find($id);
        $deliveryReceipt->delete();
    }

    public function destroyPaymentVoucher($id){
        $paymentVoucher = MrPotatoPaymentVoucher::find($id);
        $paymentVoucher->delete();
    }

    public function destroySalesInvoice($id){
         $salesInvoice = MrPotatoSalesInvoice::find($id);
        $salesInvoice->delete();
    }

    public function destroyTransactionList($id){
        $transactionList = MrPotatoPaymentVoucher::find($id);
        $transactionList->delete();
    }
}
