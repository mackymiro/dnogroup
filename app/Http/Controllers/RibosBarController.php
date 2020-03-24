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
use App\RibosBarSalesInvoice;
use App\RibosBarBillingStatement;
use App\RibosBarStatementOfAccount;

class RibosBarController extends Controller
{

    //
    public function printPayablesRibosBar($id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $payableId = RibosBarPaymentVoucher::find($id);

        $payablesVouchers = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = RibosBarPaymentVoucher::where('id', $id)->sum('amount_due');


          //
        $countAmount = RibosBarPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesRibosBar', compact('payableId', 'user', 'payablesVouchers', 'sum'));

        return $pdf->download('ribos-bar-payment-voucher.pdf');
    }
    
    //
    public function viewPayableDetails($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewPaymentDetail = RibosBarPaymentVoucher::find($id);

        //
        $getViewPaymentDetails = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('view-ribos-bar-payable-details', compact('user', 'viewPaymentDetail', 'getViewPaymentDetails'));

    }

    //
    public function accept(Request $request, $id){
         //get the status 
        $status = $request->get('status');
        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                    $payables = RibosBarPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('ribos-bar/edit-ribos-bar-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('ribos-bar/edit-ribos-bar-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = RibosBarPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('ribos-bar/edit-ribos-bar-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('ribos-bar/edit-ribos-bar-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = RibosBarPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('ribos-bar/edit-ribos-bar-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('ribos-bar/edit-ribos-bar-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }  
    }

    //
    public function addPayment(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         $paymentData = RibosBarPaymentVoucher::find($id);

        //save payment cheque num and cheque amount
        $addPayment = new RibosBarPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

         $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

         return redirect('ribos-bar/edit-ribos-bar-payables-detail/'.$id);
    }

    //
    public function editPayablesDetail(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $transactionList = RibosBarPaymentVoucher::find($id);

          //
        $getChequeNumbers = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //total the cheque amount
        $tot = RibosBarPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');

         return view('ribos-bar-payables-detail', compact('user', 'transactionList', 'getChequeNumbers','tot'));
    }

    //
    public function transactionList(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         //
        $getTransactionLists = RibosBarPaymentVoucher::where('pv_id', NULL)->get()->toArray();

           //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = RibosBarPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('ribos-bar-transaction-list', compact('user', 'getTransactionLists', 'totalAmoutDue'));

    }

    //
    public function viewStatementAccount($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        //getStatementAccounts
        $getStatementAccounts = RibosBarStatementOfAccount::where('id', $id)->get()->toArray();

        return view('view-ribos-bar-statement-account', compact('user','getStatementAccounts'));
    }

    //
    public function statementOfAccountList(){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $status = "Unpaid";
        $paid = "Paid";

        //get statement of account 
        $statementOfAccounts = RibosBarStatementOfAccount::where('soa_id', NULL)->where('status', $status)->get()->toArray();

        $statementOfAccountPaids = RibosBarStatementOfAccount::where('soa_id', NULL)->where('status', $paid)->get()->toArray();


        return view('ribos-bar-statement-of-account-lists', compact('user', 'statementOfAccounts', 'statementOfAccountPaids'));
    }

    //
    public function updateStatementInfo(Request $request, $id){
         $updateStatmentInfo = RibosBarStatementOfAccount::find($id);

        $updateStatmentInfo->date = $request->get('date');
        $updateStatmentInfo->branch = $request->get('branch');
        $updateStatmentInfo->kilos = $request->get('kilos');
        $updateStatmentInfo->unit_price = $request->get('unitPrice');
        $updateStatmentInfo->payment_method = $request->get('paymentMethod');
        $updateStatmentInfo->amount = $request->get('amount');
        $updateStatmentInfo->status = $request->get('status');
        $updateStatmentInfo->paid_amount = $request->get('paidAmount');
        $updateStatmentInfo->collection_date = $request->get('collectionDate');
        $updateStatmentInfo->check_number = $request->get('checkNumber');
        $updateStatmentInfo->check_amount = $request->get('checkAmount');
        $updateStatmentInfo->or_number = $request->get('orNumber');

        $updateStatmentInfo->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect('ribos-bar/edit-ribos-bar-statement-of-account/'.$id);
    }

    //
    public function editStatementOfAccount($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);


         //getStatementOfAccount
        $getStatementOfAccount = RibosBarStatementOfAccount::find($id);

        $sAccounts = RibosBarStatementOfAccount::where('soa_id', $id)->get()->toArray();
        
        return view('edit-ribos-bar-statement-of-account', compact('user', 'getStatementOfAccount', 'sAccounts'));
    }

    //
    public function storeStatementAccount(Request $request){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName." ".$lastName;

         //validate
        $this->validate($request, [
            'date' =>'required',
            'kilos'=>'required',
            'amount'=>'required',

        ]);

          //get the latest insert id query in table statement of account invoice number
        $invoiceNumber = DB::select('SELECT id, invoice_number FROM ribos_bar_statement_of_accounts ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 reference number
        if(isset($invoiceNumber[0]->invoice_number) != 0){
            //if code is not 0
            $newInvoice = $invoiceNumber[0]->invoice_number +1;
            $uInvoice = sprintf("%06d",$newInvoice);   

        }else{
            //if code is 0 
            $newInvoice = 1;
            $uInvoice = sprintf("%06d",$newInvoice);
        } 


         $addStatementAccount = new RibosBarStatementOfAccount([
            'user_id'=>$user->id,
            'date'=>$request->get('date'),
            'branch'=>$request->get('branch'),
            'invoice_number'=>$uInvoice,
            'kilos'=>$request->get('kilos'),
            'unit_price'=>$request->get('unitPrice'),
            'payment_method'=>$request->get('paymentMethod'),
            'amount'=>$request->get('amount'),
            'status'=>$request->get('status'),
            'paid_amount'=>$request->get('paidAmount'),
            'collection_date'=>$request->get('collectionDate'),
            'check_number'=>$request->get('checkNumber'),
            'check_amount'=>$request->get('checkAmount'),
            'or_number'=>$request->get('orNumber'),
            'created_by'=>$name,
        ]);

        $addStatementAccount->save();

        $insertedId = $addStatementAccount->id;

        return redirect('ribos-bar/edit-ribos-bar-statement-of-account/'.$insertedId);


    }

    //
    public function statementOfAccountForm(){
         $ids = Auth::user()->id;
        $user = User::find($ids);


        return view('ribos-bar-statement-of-account', compact('user'));
    }

    //
    public function viewBillingStatement($id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewBillingStatement = RibosBarBillingStatement::find($id);
        

        $billingStatements = RibosBarBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = RibosBarBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = RibosBarBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-ribos-bar-billing-statement', compact('user', 'viewBillingStatement', 'billingStatements', 'sum'));
    }

    //
    public function billingStatementLists(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingStatements = RibosBarBillingStatement::where('billing_statement_id', NULL)->get()->toArray();


        return view('ribos-bar-billing-statement-lists', compact('user', 'billingStatements'));
    }

    //
    public function updateBillingStatement(Request $request, $id){
        $updateBilling = RibosBarBillingStatement::find($id);

        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $updateBilling->date_of_transaction = $request->get('transactionDate');
        $updateBilling->whole_lechon = $wholeLechon;
        $updateBilling->description = $request->get('description');
        $updateBilling->invoice_number = $request->get('invoiceNumber');
        $updateBilling->amount = $add;

        $updateBilling->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('ribos-bar/edit-ribos-bar-billing-statement/'.$request->get('billingStatementId'));
    }

    //
    public function addNewBillingData(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = RibosBarBillingStatement::find($id);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //get the whole lechon then multiply by 500
        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $addBillingStatement = new RibosBarBillingStatement([
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

        return redirect('ribos-bar/add-new-ribos-bar-billing/'.$id);

    }

    //
    public function addNewBilling($id){
         $ids =  Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-ribos-bar-billing-statement', compact('user', 'id'));
    }

    //
    public function updateBillingInfo(Request $request, $id){
        $updateBillingOrder = RibosBarBillingStatement::find($id);

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

        return redirect('ribos-bar/edit-ribos-bar-billing-statement/'.$id);
    }

    //
    public function editBillingStatement($id){
         $ids =  Auth::user()->id;
        $user = User::find($ids);

        $billingStatement = RibosBarBillingStatement::find($id);
       
        $bStatements = RibosBarBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //get the purchase order lists
        $getPurchaseOrders = RibosBarPurchaseOrder::where('po_id', NULL)->get()->toArray();
        
        return view('edit-ribos-bar-billing-statement-form', compact('user', 'billingStatement', 'bStatements', 'getPurchaseOrders'));
    }

    //
    public function storeBillingStatement(Request $request){
         $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName." ".$lastName;

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
        $dataReferenceNum = DB::select('SELECT id, reference_number FROM ribos_bar_billing_statements ORDER BY id DESC LIMIT 1');

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

          $billingStatement = new RibosBarBillingStatement([
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

         return redirect('ribos-bar/edit-ribos-bar-billing-statement/'.$insertedId);

    }

    //
    public function billingStatementForm(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        //get the purchase order lists
        $getPurchaseOrders = RibosBarPurchaseOrder::where('po_id', NULL)->get()->toArray();
       

        return view('ribos-bar-billing-statement-form', compact('user', 'getPurchaseOrders'));
    }

    //
    public function viewSalesInvoice($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewSalesInvoice = RibosBarSalesInvoice::find($id);

        $salesInvoices = RibosBarSalesInvoice::where('si_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = RibosBarSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = RibosBarSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-ribos-bar-sales-invoice', compact('user', 'viewSalesInvoice', 'salesInvoices', 'sum'));
    }

    //
    public function updateSi(Request $request, $id){
        
        $updateSi = RibosBarSalesInvoice::find($id);

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

        return redirect('ribos-bar/edit-ribos-bar-sales-invoice/'.$request->get('siId'));
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

        $addNewSalesInvoice = new RibosBarSalesInvoice([
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


        return redirect('ribos-bar/add-new-ribos-bar-sales-invoice/'. $id);

    }

    //
    public function addNewSalesInvoice($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);
       

        return view('add-new-ribos-bar-sales-invoice', compact('user', 'id'));
    }

    //
    public function updateSalesInvoice(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $updateSalesInvoice = RibosBarSalesInvoice::find($id);

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

        return redirect('ribos-bar/edit-ribos-bar-sales-invoice/'.$id);
    }

    //
    public function editSalesInvoice($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getSalesInvoice
        $getSalesInvoice = RibosBarSalesInvoice::find($id);

        $sInvoices  = RibosBarSalesInvoice::where('si_id', $id)->get()->toArray();

        return view('edit-ribos-bar-sales-invoice', compact('user', 'getSalesInvoice', 'sInvoices'));
    }

    //
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

        $addSalesInvoice = new RibosBarSalesInvoice([
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

        return redirect('ribos-bar/edit-ribos-bar-sales-invoice/'.$insertedId);
    }

    //
    public function salesInvoiceForm(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('ribos-bar-sales-invoice-form', compact('user'));
    }

    //
    public function viewPaymentVoucher($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //paymentVoucher
        $paymentVoucher = RibosBarPaymentVoucher::find($id);

        $pVouchers = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();


         //count the total amount 
        $countTotalAmount = RibosBarPaymentVoucher::where('id', $id)->sum('amount');

        //
        $countAmount = RibosBarPaymentVoucher::where('pv_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-payment-voucher-ribos-bar', compact('user', 'paymentVoucher', 'pVouchers', 'sum'));
    }

    //
    public function chequeVoucher(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        //getAllChequeVouchers
        $method = "Cheque";

        $getAllChequeVouchers = RibosBarPaymentVoucher::where('method_of_payment', $method)->get()->toArray(); 

        return view('cheque-vouchers-lists-ribos-bar', compact('user', 'getAllChequeVouchers'));
    }

    //
    public function cashVoucher(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getAllCashVouchers
        $method = "Cash";

        $getAllCashVouchers = RibosBarPaymentVoucher::where('method_of_payment', $method)->get()->toArray();

        return view('cash-vouchers-list-ribos-bar', compact('user', 'getAllCashVouchers'));
    }

    //
    public function updatePV(Request $request, $id){
         $updatePV = RibosBarPaymentVoucher::find($id);
      

        $updatePV->particulars = $request->get('particulars');
        $updatePV->amount = $request->get('amount');

        $updatePV->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('ribos-bar/edit-ribos-bar-payment-voucher/'.$request->get('pvId'));
    }

    //
    public function addNewPaymentVoucherData(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentVoucher = RibosBarPaymentVoucher::find($id);

         $addNewPaymentVoucherData = new RibosBarPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'reference_number'=>$paymentVoucher['reference_number'],
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewPaymentVoucherData->save();

        Session::flash('addPaymentVoucherSuccess', 'Successfully added.');

        return redirect('ribos-bar/add-new-ribos-bar-payment-voucher/'.$id);

    }

    //
    public function addNewPaymentVoucher($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-ribos-bar-payment-voucher', compact('user', 'id'));
    }

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
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM ribos_bar_payment_vouchers ORDER BY id DESC LIMIT 1');

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
                        'ribos_bar_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...
             $addPaymentVoucher = new RibosBarPaymentVoucher([
                    'user_id'=>$user->id,
                    'paid_to'=>$request->get('paidTo'),
                    'invoice_number'=>$request->get('invoiceNumber'),
                    'voucher_ref_number'=>$uVoucher,
                    'issued_date'=>$request->get('issuedDate'),
                    'delivered_date'=>$request->get('deliveredDate'),
                    'amount_due'=>$request->get('amountDue'),
                    'prepared_by'=>$name,
                    'created_by'=>$name,
            ]);

            $addPaymentVoucher->save();
            Session::flash('addSuccess', 'Successfully created.');

             return redirect('ribos-bar/payment-voucher-form');
        }else{
             return redirect('ribos-bar/payment-voucher-form/')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    
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

         $getAllSalesInvoices = RibosBarSalesInvoice::where('si_id', NULL)->get()->toArray();

        return view('ribos-bar', compact('user', 'getAllSalesInvoices')); 
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

    //
    public function destroyTransactionList($id){    
         $transactionList = RibosBarPaymentVoucher::find($id);
        $transactionList->delete();
    }

     //
    public function destroyBillingStatement($id){
        $billingStatement = RibosBarBillingStatement::find($id);
        $billingStatement->delete();
    }

    //
    public function destroySalesInvoice($id){
        $salesInvoice = RibosBarSalesInvoice::find($id);
        $salesInvoice->delete();
    }

    //
    public function destroyPaymentVoucher($id){
        $paymentVoucher = RibosBarPaymentVoucher::find($id);
        $paymentVoucher->delete();
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
