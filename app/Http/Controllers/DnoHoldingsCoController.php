<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session; 
use Auth; 
use PDF;
use App\User;
use App\DnoHoldingsCoPaymentVoucher;
use App\DnoHoldingsCoCode;
use App\DnoHoldingsCoSupplier;

class DnoHoldingsCoController extends Controller
{

    public function printSupplier($id){
        $viewSupplier = DnoHoldingsCoSupplier::where('id', $id)->get();

        $printSuppliers  = DB::table(
                        'dno_holdings_co_payment_vouchers')
                        ->select( 
                        'dno_holdings_co_payment_vouchers.id',
                        'dno_holdings_co_payment_vouchers.user_id',
                        'dno_holdings_co_payment_vouchers.pv_id',
                        'dno_holdings_co_payment_vouchers.date',
                        'dno_holdings_co_payment_vouchers.paid_to',
                        'dno_holdings_co_payment_vouchers.account_no',
                        'dno_holdings_co_payment_vouchers.account_name',
                        'dno_holdings_co_payment_vouchers.particulars',
                        'dno_holdings_co_payment_vouchers.amount',
                        'dno_holdings_co_payment_vouchers.method_of_payment',
                        'dno_holdings_co_payment_vouchers.prepared_by',
                        'dno_holdings_co_payment_vouchers.approved_by',
                        'dno_holdings_co_payment_vouchers.date_approved',
                        'dno_holdings_co_payment_vouchers.received_by_date',
                        'dno_holdings_co_payment_vouchers.created_by',
                        'dno_holdings_co_payment_vouchers.invoice_number',
                        'dno_holdings_co_payment_vouchers.issued_date',
                        'dno_holdings_co_payment_vouchers.category',
                        'dno_holdings_co_payment_vouchers.amount_due',
                        'dno_holdings_co_payment_vouchers.delivered_date',
                        'dno_holdings_co_payment_vouchers.status',
                        'dno_holdings_co_payment_vouchers.cheque_number',
                        'dno_holdings_co_payment_vouchers.cheque_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_suppliers.id',
                        'dno_holdings_co_suppliers.date',
                        'dno_holdings_co_suppliers.supplier_name')
                        ->leftJoin('dno_holdings_co_suppliers', 'dno_holdings_co_payment_vouchers.supplier_id', '=', 'dno_holdings_co_suppliers.id')
                        ->where('dno_holdings_co_suppliers.id', $id)
                        ->get();

        $status = "FULLY PAID AND RELEASED";  
        
        $totalAmountDue  = DB::table(
                        'dno_holdings_co_payment_vouchers')
                        ->select( 
                        'dno_holdings_co_payment_vouchers.id',
                        'dno_holdings_co_payment_vouchers.user_id',
                        'dno_holdings_co_payment_vouchers.pv_id',
                        'dno_holdings_co_payment_vouchers.date',
                        'dno_holdings_co_payment_vouchers.paid_to',
                        'dno_holdings_co_payment_vouchers.account_no',
                        'dno_holdings_co_payment_vouchers.account_name',
                        'dno_holdings_co_payment_vouchers.particulars',
                        'dno_holdings_co_payment_vouchers.amount',
                        'dno_holdings_co_payment_vouchers.method_of_payment',
                        'dno_holdings_co_payment_vouchers.prepared_by',
                        'dno_holdings_co_payment_vouchers.approved_by',
                        'dno_holdings_co_payment_vouchers.date_approved',
                        'dno_holdings_co_payment_vouchers.received_by_date',
                        'dno_holdings_co_payment_vouchers.created_by',
                        'dno_holdings_co_payment_vouchers.invoice_number',
                        'dno_holdings_co_payment_vouchers.issued_date',
                        'dno_holdings_co_payment_vouchers.category',
                        'dno_holdings_co_payment_vouchers.amount_due',
                        'dno_holdings_co_payment_vouchers.delivered_date',
                        'dno_holdings_co_payment_vouchers.status',
                        'dno_holdings_co_payment_vouchers.cheque_number',
                        'dno_holdings_co_payment_vouchers.cheque_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_suppliers.id',
                        'dno_holdings_co_suppliers.date',
                        'dno_holdings_co_suppliers.supplier_name')
                        ->leftJoin('dno_holdings_co_suppliers', 'dno_holdings_co_payment_vouchers.supplier_id', '=', 'dno_holdings_co_suppliers.id')
                        ->where('dno_holdings_co_suppliers.id', $id)
                        ->where('dno_holdings_co_payment_vouchers.status', '!=', $status)
                        ->sum('dno_holdings_co_payment_vouchers.amount_due');
         
        $pdf = PDF::loadView('printSupplierDnoHoldingsCo', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('dno-holdings-co-supplier.pdf');
    

    }

    public function viewSupplier($id){
        $viewSupplier = DnoHoldingsCoSupplier::where('id', $id)->get();

        $supplierLists  = DB::table(
                    'dno_holdings_co_payment_vouchers')
                    ->select( 
                    'dno_holdings_co_payment_vouchers.id',
                    'dno_holdings_co_payment_vouchers.user_id',
                    'dno_holdings_co_payment_vouchers.pv_id',
                    'dno_holdings_co_payment_vouchers.date',
                    'dno_holdings_co_payment_vouchers.paid_to',
                    'dno_holdings_co_payment_vouchers.account_no',
                    'dno_holdings_co_payment_vouchers.account_name',
                    'dno_holdings_co_payment_vouchers.particulars',
                    'dno_holdings_co_payment_vouchers.amount',
                    'dno_holdings_co_payment_vouchers.method_of_payment',
                    'dno_holdings_co_payment_vouchers.prepared_by',
                    'dno_holdings_co_payment_vouchers.approved_by',
                    'dno_holdings_co_payment_vouchers.date_approved',
                    'dno_holdings_co_payment_vouchers.received_by_date',
                    'dno_holdings_co_payment_vouchers.created_by',
                    'dno_holdings_co_payment_vouchers.invoice_number',
                    'dno_holdings_co_payment_vouchers.issued_date',
                    'dno_holdings_co_payment_vouchers.category',
                    'dno_holdings_co_payment_vouchers.amount_due',
                    'dno_holdings_co_payment_vouchers.delivered_date',
                    'dno_holdings_co_payment_vouchers.status',
                    'dno_holdings_co_payment_vouchers.cheque_number',
                    'dno_holdings_co_payment_vouchers.cheque_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_suppliers.id',
                    'dno_holdings_co_suppliers.date',
                    'dno_holdings_co_suppliers.supplier_name')
                    ->leftJoin('dno_holdings_co_suppliers', 'dno_holdings_co_payment_vouchers.supplier_id', '=', 'dno_holdings_co_suppliers.id')
                    ->where('dno_holdings_co_suppliers.id', $id)
                    ->get();
                        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue  = DB::table(
                    'dno_holdings_co_payment_vouchers')
                    ->select( 
                    'dno_holdings_co_payment_vouchers.id',
                    'dno_holdings_co_payment_vouchers.user_id',
                    'dno_holdings_co_payment_vouchers.pv_id',
                    'dno_holdings_co_payment_vouchers.date',
                    'dno_holdings_co_payment_vouchers.paid_to',
                    'dno_holdings_co_payment_vouchers.account_no',
                    'dno_holdings_co_payment_vouchers.account_name',
                    'dno_holdings_co_payment_vouchers.particulars',
                    'dno_holdings_co_payment_vouchers.amount',
                    'dno_holdings_co_payment_vouchers.method_of_payment',
                    'dno_holdings_co_payment_vouchers.prepared_by',
                    'dno_holdings_co_payment_vouchers.approved_by',
                    'dno_holdings_co_payment_vouchers.date_approved',
                    'dno_holdings_co_payment_vouchers.received_by_date',
                    'dno_holdings_co_payment_vouchers.created_by',
                    'dno_holdings_co_payment_vouchers.invoice_number',
                    'dno_holdings_co_payment_vouchers.issued_date',
                    'dno_holdings_co_payment_vouchers.category',
                    'dno_holdings_co_payment_vouchers.amount_due',
                    'dno_holdings_co_payment_vouchers.delivered_date',
                    'dno_holdings_co_payment_vouchers.status',
                    'dno_holdings_co_payment_vouchers.cheque_number',
                    'dno_holdings_co_payment_vouchers.cheque_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_suppliers.id',
                    'dno_holdings_co_suppliers.date',
                    'dno_holdings_co_suppliers.supplier_name')
                    ->leftJoin('dno_holdings_co_suppliers', 'dno_holdings_co_payment_vouchers.supplier_id', '=', 'dno_holdings_co_suppliers.id')
                    ->where('dno_holdings_co_suppliers.id', $id)
                    ->where('dno_holdings_co_payment_vouchers.status', '!=', $status)
                    ->sum('dno_holdings_co_payment_vouchers.amount_due');



        return view('view-dno-holdings-co-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue')); 
    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

           //check if supplier name exits
        $target = DB::table(
            'dno_holdings_co_suppliers')
            ->where('supplier_name', $request->supplierName)
            ->get()->first();

        if($target === NULL){
            $supplier = new DnoHoldingsCoSupplier([
                'user_id'=>$user->id,
                'date'=>$request->date,
                'supplier_name'=>$request->supplierName, 
                'created_by'=>$name,
            ]);

            $supplier->save();
            return response()->json('Success: successfully added.');        
        }else{
            return response()->json('Failed: Already exist.');
        }

    }

    public function supplier(){
        $suppliers = DnoHoldingsCoSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('dno-holdings-co-supplier', compact('suppliers'));
    }

    public function printPayablesDnoHoldingsCo($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                        'dno_holdings_co_payment_vouchers')
                        ->select( 
                        'dno_holdings_co_payment_vouchers.id',
                        'dno_holdings_co_payment_vouchers.user_id',
                        'dno_holdings_co_payment_vouchers.pv_id',
                        'dno_holdings_co_payment_vouchers.date',
                        'dno_holdings_co_payment_vouchers.paid_to',
                        'dno_holdings_co_payment_vouchers.account_no',
                        'dno_holdings_co_payment_vouchers.account_name',
                        'dno_holdings_co_payment_vouchers.particulars',
                        'dno_holdings_co_payment_vouchers.amount',
                        'dno_holdings_co_payment_vouchers.method_of_payment',
                        'dno_holdings_co_payment_vouchers.prepared_by',
                        'dno_holdings_co_payment_vouchers.approved_by',
                        'dno_holdings_co_payment_vouchers.date_approved',
                        'dno_holdings_co_payment_vouchers.received_by_date',
                        'dno_holdings_co_payment_vouchers.created_by',
                        'dno_holdings_co_payment_vouchers.invoice_number',
                        'dno_holdings_co_payment_vouchers.issued_date',
                        'dno_holdings_co_payment_vouchers.category',
                        'dno_holdings_co_payment_vouchers.amount_due',
                        'dno_holdings_co_payment_vouchers.delivered_date',
                        'dno_holdings_co_payment_vouchers.status',
                        'dno_holdings_co_payment_vouchers.cheque_number',
                        'dno_holdings_co_payment_vouchers.cheque_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.id', $id)
                        ->where('dno_holdings_co_codes.module_name', $moduleName)
                        ->get();

        
        //getParticular details
        $getParticulars = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      
        $getChequeNumbers = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
         $amount1 = DnoHoldingsCoPaymentVoucher::where('id', $id)->sum('amount');
         $amount2 = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->sum('amount');
           
         $sum = $amount1 + $amount2;

        //
        $chequeAmount1 = DnoHoldingsCoPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        $pdf = PDF::loadView('printPayablesDnoHoldingsCo', compact('payableId',  
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

        return $pdf->download('dno-holdings-co-payment-voucher.pdf');

    }

    public function viewPayableDetails($id){
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                        'dno_holdings_co_payment_vouchers')
                        ->select( 
                        'dno_holdings_co_payment_vouchers.id',
                        'dno_holdings_co_payment_vouchers.user_id',
                        'dno_holdings_co_payment_vouchers.pv_id',
                        'dno_holdings_co_payment_vouchers.date',
                        'dno_holdings_co_payment_vouchers.paid_to',
                        'dno_holdings_co_payment_vouchers.account_no',
                        'dno_holdings_co_payment_vouchers.account_name',
                        'dno_holdings_co_payment_vouchers.particulars',
                        'dno_holdings_co_payment_vouchers.amount',
                        'dno_holdings_co_payment_vouchers.method_of_payment',
                        'dno_holdings_co_payment_vouchers.prepared_by',
                        'dno_holdings_co_payment_vouchers.approved_by',
                        'dno_holdings_co_payment_vouchers.date_approved',
                        'dno_holdings_co_payment_vouchers.received_by_date',
                        'dno_holdings_co_payment_vouchers.created_by',
                        'dno_holdings_co_payment_vouchers.invoice_number',
                        'dno_holdings_co_payment_vouchers.issued_date',
                        'dno_holdings_co_payment_vouchers.category',
                        'dno_holdings_co_payment_vouchers.amount_due',
                        'dno_holdings_co_payment_vouchers.delivered_date',
                        'dno_holdings_co_payment_vouchers.status',
                        'dno_holdings_co_payment_vouchers.cheque_number',
                        'dno_holdings_co_payment_vouchers.cheque_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.id', $id)
                        ->where('dno_holdings_co_codes.module_name', $moduleName)
                        ->get();

        $getViewPaymentDetails = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //getParticular details
        $getParticulars = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        return view('view-dno-holdings-co-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
                

    }

    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                    'dno_holdings_co_payment_vouchers')
                    ->select( 
                    'dno_holdings_co_payment_vouchers.id',
                    'dno_holdings_co_payment_vouchers.user_id',
                    'dno_holdings_co_payment_vouchers.pv_id',
                    'dno_holdings_co_payment_vouchers.date',
                    'dno_holdings_co_payment_vouchers.paid_to',
                    'dno_holdings_co_payment_vouchers.account_no',
                    'dno_holdings_co_payment_vouchers.account_name',
                    'dno_holdings_co_payment_vouchers.particulars',
                    'dno_holdings_co_payment_vouchers.amount',
                    'dno_holdings_co_payment_vouchers.method_of_payment',
                    'dno_holdings_co_payment_vouchers.prepared_by',
                    'dno_holdings_co_payment_vouchers.approved_by',
                    'dno_holdings_co_payment_vouchers.date_approved',
                    'dno_holdings_co_payment_vouchers.received_by_date',
                    'dno_holdings_co_payment_vouchers.created_by',
                    'dno_holdings_co_payment_vouchers.invoice_number',
                    'dno_holdings_co_payment_vouchers.issued_date',
                    'dno_holdings_co_payment_vouchers.category',
                    'dno_holdings_co_payment_vouchers.amount_due',
                    'dno_holdings_co_payment_vouchers.delivered_date',
                    'dno_holdings_co_payment_vouchers.status',
                    'dno_holdings_co_payment_vouchers.cheque_number',
                    'dno_holdings_co_payment_vouchers.cheque_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleName)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->get()->toArray();

         //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = DnoHoldingsCoPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('dno-holdings-co-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));

    }

    public function accept(Request $request, $id){
          //get the status 
        $status = $request->get('status');

        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                     $ids = Auth::user()->id;
                    $user = User::find($ids);
            
                    $firstName = $user->first_name;
                    $lastName = $user->last_name;
            
                    $name  = $firstName." ".$lastName;

                     //get the date today
                     $getDate =  date("Y-m-d");

                    $payables = DnoHoldingsCoPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
                    $payables->save();


                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect()->route('editPayablesDetailDnoHoldingsCo', ['id'=>$id]);
                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailDnoHoldingsCo', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoHoldingsCoPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect()->route('editPayablesDetailDnoHoldingsCo', ['id'=>$id]);

                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailDnoHoldingsCo', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoHoldingsCoPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect()->route('editPayablesDetailDnoHoldingsCo', ['id'=>$id]);
                    
                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailDnoHoldingsCo', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }  

    }

    public function updateDetails(Request $request){    
        $updateDetail = DnoHoldingsCoPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = DnoHoldingsCoPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }
    
    public function updateCheck(Request $request){  
        $updateCheck = DnoHoldingsCoPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request, $id){
        //main id 
        $updateParticular = DnoHoldingsCoPaymentVoucher::find($request->transId);

        //particular id
        $uIdParticular = DnoHoldingsCoPaymentVoucher::find($request->id);

        $amount = $request->amount; 

        $updateAmount =  $updateParticular->amount; 

        $uParticular = DnoHoldingsCoPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
         
        $tot = $updateAmount + $uParticular; 

        $uIdParticular->date  = $request->date;
        $uIdParticular->particulars = $request->particulars;
        $uIdParticular->amount = $amount; 
        $uIdParticular->save();

        $updateParticular->amount_due = $tot;
        $updateParticular->save();
        
        return response()->json('Success: successfully updated.');
    }

    public function updateParticulars(Request $request){
        $updateParticular =  DnoHoldingsCoPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = DnoHoldingsCoPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 

        $updateParticular->date = $request->date;
        $updateParticular->particulars = $request->particulars;
        $updateParticular->amount = $amount;
        $updateParticular->amount_due = $sum;
        $updateParticular->save();
 
        return response()->json('Success: successfully updated.');

    }

    public function addParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = DnoHoldingsCoPaymentVoucher::find($id);

         //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

           //get Category
        $cat = $particulars['category'];
  
        $subAccountId = $particulars['sub_category_account_id'];

        $addParticulars = new DnoHoldingsCoPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'particulars'=>$request->get('particulars'),
            'date'=>$request->get('date'),
            'amount'=>$request->get('amount'),
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

        return redirect()->route('editPayablesDetailDnoHoldingsCo', ['id'=>$id]);
    }


    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = DnoHoldingsCoPaymentVoucher::find($id);

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');

          //save payment cheque num and cheque amount
        $addPayment = new DnoHoldingsCoPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'account_name_no'=>$request->get('accountNameNo'),
            'date'=>$request->get('date'),
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

        $addPayment->save();

        //update the total cheque amount
        $paymentData->cheque_total_amount = $totalChequeAmount;
        $paymentData->save();
            
        Session::flash('paymentAdded', 'Payment added.');

        return redirect()->route('editPayablesDetailDnoHoldingsCo', ['id'=>$id]);

    }

    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                        'dno_holdings_co_payment_vouchers')
                        ->select( 
                        'dno_holdings_co_payment_vouchers.id',
                        'dno_holdings_co_payment_vouchers.user_id',
                        'dno_holdings_co_payment_vouchers.pv_id',
                        'dno_holdings_co_payment_vouchers.date',
                        'dno_holdings_co_payment_vouchers.paid_to',
                        'dno_holdings_co_payment_vouchers.account_no',
                        'dno_holdings_co_payment_vouchers.account_name',
                        'dno_holdings_co_payment_vouchers.particulars',
                        'dno_holdings_co_payment_vouchers.amount',
                        'dno_holdings_co_payment_vouchers.method_of_payment',
                        'dno_holdings_co_payment_vouchers.prepared_by',
                        'dno_holdings_co_payment_vouchers.approved_by',
                        'dno_holdings_co_payment_vouchers.date_approved',
                        'dno_holdings_co_payment_vouchers.received_by_date',
                        'dno_holdings_co_payment_vouchers.created_by',
                        'dno_holdings_co_payment_vouchers.invoice_number',
                        'dno_holdings_co_payment_vouchers.issued_date',
                        'dno_holdings_co_payment_vouchers.category',
                        'dno_holdings_co_payment_vouchers.amount_due',
                        'dno_holdings_co_payment_vouchers.delivered_date',
                        'dno_holdings_co_payment_vouchers.status',
                        'dno_holdings_co_payment_vouchers.cheque_number',
                        'dno_holdings_co_payment_vouchers.cheque_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.id', $id)
                        ->where('dno_holdings_co_codes.module_name', $moduleName)
                        ->get();

        $getChequeNumbers = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        $getCashAmounts = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        

        //getParticular details
        $getParticulars = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        //amount
        $amount1 = DnoHoldingsCoPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;

        $chequeAmount1 = DnoHoldingsCoPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoHoldingsCoPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('dno-holdings-co-payables-detail', compact('transactionList', 'getChequeNumbers','sum'
        , 'getParticulars', 'sumCheque', 'getCashAmounts'));
                


    }
    
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
         $dataVoucherRef = DB::select('SELECT id, dno_holdings_code FROM dno_holdings_co_codes ORDER BY id DESC LIMIT 1');
        
              //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->dno_holdings_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->dno_holdings_code +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
        } 

           //get the category
        if($request->get('category') == "None"){
            $subCat = NULL;
            $subCatAcctId = NULL;
            $supplierExp = NULL;
       
        }else if($request->get('category') == "Supplier"){
            $supplier = $request->get('supplierName');
            $supplierExp = explode("-", $supplier);

            $subCat = "NULL";
            $subCatAcctId = "NULL";
        }

        //check if invoice number already exists
          $target = DB::table(
                    'dno_holdings_co_payment_vouchers')
                    ->where('invoice_number', $request->get('invoiceNumber'))
                    ->get()->first();
        
        if ($target === NULL) {
             # code...
             $addPaymentVoucher = new DnoHoldingsCoPaymentVoucher([
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
                    'sub_category'=>$subCat,
                    'sub_category_account_id'=>$subCatAcctId,
                    'supplier_id'=>$supplierExp[0],
                    'supplier_name'=>$supplierExp[1],  
                    'prepared_by'=>$name,
                    'created_by'=>$name,
             ]);

             $addPaymentVoucher->save();
             $insertedId = $addPaymentVoucher->id;

             $moduleCode = "PV-";
             $moduleName = "Payment Voucher";

            $dnoHoldings = new DnoHoldingsCoCode([
                'user_id'=>$user->id,
                'dno_holdings_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);

            $dnoHoldings->save();

            return redirect()->route('editPayablesDetailDnoHoldingsCo', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormDnoHoldingsCo')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }


    }

    public function paymentVoucherForm(){
         //get suppliers
         $suppliers = DnoHoldingsCoSupplier::get()->toArray();

        return view('payment-voucher-form-dno-holdings-co', compact('suppliers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dno-holdings-co');
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


    public function destroyTransactionList($id){
        $transactionList = DnoHoldingsCoPaymentVoucher::find($id);
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
    }
}
