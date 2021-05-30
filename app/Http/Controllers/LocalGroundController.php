<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;
use Auth; 
use Session; 
use App\User;
use App\LocalGroundPaymentVoucher;
use App\LocalGroundCode;
use App\LocalGroundSupplier;


class LocalGroundController extends Controller
{

    public function printSupplier($id){
        $viewSupplier = LocalGroundSupplier::where('id', $id)->get();

        $printSuppliers = DB::table(
            'local_ground_payment_vouchers')
            ->select( 
            'local_ground_payment_vouchers.id',
            'local_ground_payment_vouchers.user_id',
            'local_ground_payment_vouchers.pv_id',
            'local_ground_payment_vouchers.date',
            'local_ground_payment_vouchers.paid_to',
            'local_ground_payment_vouchers.account_no',
            'local_ground_payment_vouchers.account_name',
            'local_ground_payment_vouchers.particulars',
            'local_ground_payment_vouchers.amount',
            'local_ground_payment_vouchers.method_of_payment',
            'local_ground_payment_vouchers.prepared_by',
            'local_ground_payment_vouchers.approved_by',
            'local_ground_payment_vouchers.date_approved',
            'local_ground_payment_vouchers.received_by_date',
            'local_ground_payment_vouchers.created_by',
            'local_ground_payment_vouchers.invoice_number',
            'local_ground_payment_vouchers.issued_date',
            'local_ground_payment_vouchers.category',
            'local_ground_payment_vouchers.amount_due',
            'local_ground_payment_vouchers.delivered_date',
            'local_ground_payment_vouchers.status',
            'local_ground_payment_vouchers.cheque_number',
            'local_ground_payment_vouchers.cheque_amount',
            'local_ground_payment_vouchers.sub_category',
            'local_ground_payment_vouchers.sub_category_account_id',
            'local_ground_payment_vouchers.supplier_name',
            'local_ground_payment_vouchers.created_at',
            'local_ground_payment_vouchers.deleted_at',
            'local_ground_suppliers.id',
            'local_ground_suppliers.date',
            'local_ground_suppliers.supplier_name')
            ->leftJoin('local_ground_suppliers', 'local_ground_payment_vouchers.supplier_id', '=', 'local_ground_suppliers.id')
            ->where('local_ground_suppliers.id', $id)
            ->get();

    $status = "FULLY PAID AND RELEASED"; 
    $totalAmountDue = DB::table(
                'local_ground_payment_vouchers')
                ->select( 
                'local_ground_payment_vouchers.id',
                'local_ground_payment_vouchers.user_id',
                'local_ground_payment_vouchers.pv_id',
                'local_ground_payment_vouchers.date',
                'local_ground_payment_vouchers.paid_to',
                'local_ground_payment_vouchers.account_no',
                'local_ground_payment_vouchers.account_name',
                'local_ground_payment_vouchers.particulars',
                'local_ground_payment_vouchers.amount',
                'local_ground_payment_vouchers.method_of_payment',
                'local_ground_payment_vouchers.prepared_by',
                'local_ground_payment_vouchers.approved_by',
                'local_ground_payment_vouchers.date_approved',
                'local_ground_payment_vouchers.received_by_date',
                'local_ground_payment_vouchers.created_by',
                'local_ground_payment_vouchers.invoice_number',
                'local_ground_payment_vouchers.issued_date',
                'local_ground_payment_vouchers.category',
                'local_ground_payment_vouchers.amount_due',
                'local_ground_payment_vouchers.delivered_date',
                'local_ground_payment_vouchers.status',
                'local_ground_payment_vouchers.cheque_number',
                'local_ground_payment_vouchers.cheque_amount',
                'local_ground_payment_vouchers.sub_category',
                'local_ground_payment_vouchers.sub_category_account_id',
                'local_ground_payment_vouchers.supplier_name',
                'local_ground_payment_vouchers.created_at',
                'local_ground_payment_vouchers.deleted_at',
                'local_ground_suppliers.id',
                'local_ground_suppliers.date',
                'local_ground_suppliers.supplier_name')
                ->leftJoin('local_ground_suppliers', 'local_ground_payment_vouchers.supplier_id', '=', 'local_ground_suppliers.id')
                ->where('local_ground_suppliers.id', $id)
                ->where('local_ground_payment_vouchers.status', '!=', $status)
                ->sum('local_ground_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSupplierLocalGround', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('dino-industrial-corporation-supplier.pdf');

    }

    public function viewSupplier($id){
        $viewSupplier = LocalGroundSupplier::where('id', $id)->get();

        $supplierLists = DB::table(
                    'local_ground_payment_vouchers')
                    ->select( 
                    'local_ground_payment_vouchers.id',
                    'local_ground_payment_vouchers.user_id',
                    'local_ground_payment_vouchers.pv_id',
                    'local_ground_payment_vouchers.date',
                    'local_ground_payment_vouchers.paid_to',
                    'local_ground_payment_vouchers.account_no',
                    'local_ground_payment_vouchers.account_name',
                    'local_ground_payment_vouchers.particulars',
                    'local_ground_payment_vouchers.amount',
                    'local_ground_payment_vouchers.method_of_payment',
                    'local_ground_payment_vouchers.prepared_by',
                    'local_ground_payment_vouchers.approved_by',
                    'local_ground_payment_vouchers.date_approved',
                    'local_ground_payment_vouchers.received_by_date',
                    'local_ground_payment_vouchers.created_by',
                    'local_ground_payment_vouchers.invoice_number',
                    'local_ground_payment_vouchers.issued_date',
                    'local_ground_payment_vouchers.category',
                    'local_ground_payment_vouchers.amount_due',
                    'local_ground_payment_vouchers.delivered_date',
                    'local_ground_payment_vouchers.status',
                    'local_ground_payment_vouchers.cheque_number',
                    'local_ground_payment_vouchers.cheque_amount',
                    'local_ground_payment_vouchers.sub_category',
                    'local_ground_payment_vouchers.sub_category_account_id',
                    'local_ground_payment_vouchers.supplier_name',
                    'local_ground_payment_vouchers.created_at',
                    'local_ground_payment_vouchers.deleted_at',
                    'local_ground_suppliers.date',
                    'local_ground_suppliers.supplier_name')
                    ->leftJoin('local_ground_suppliers', 'local_ground_payment_vouchers.supplier_id', '=', 'local_ground_suppliers.id')
                    ->where('local_ground_suppliers.id', $id)
                    ->get();

    $status = "FULLY PAID AND RELEASED"; 
    $totalAmountDue = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.supplier_name',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_suppliers.id',
                        'local_ground_suppliers.date',
                        'local_ground_suppliers.supplier_name')
                        ->leftJoin('local_ground_suppliers', 'local_ground_payment_vouchers.supplier_id', '=', 'local_ground_suppliers.id')
                        ->where('local_ground_suppliers.id', $id)
                        ->where('local_ground_payment_vouchers.status', '!=', $status)
                        ->sum('local_ground_payment_vouchers.amount_due');

        return view('view-local-ground-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue')); 


    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //check if supplier name exits
        $target = DB::table(
            'local_ground_suppliers')
            ->where('supplier_name', $request->supplierName)
            ->get()->first();

        if($target === NULL){
            $supplier = new LocalGroundSupplier([
                'user_id'=>$user->id,
                'date'=>$request->date,
                'supplier_name'=>$request->supplierName, 
                'created_by'=>$name,
            ]);

            $supplier->save();
            return response()->json('Success: successfully updated.');        
        }else{
            return response()->json('Failed: Already exist.');
        }

    }

    public function supplier(){
        $suppliers = LocalGroundSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('local-ground-supplier', compact('suppliers'));
    }

    public function updateDetails(Request $request){    
        $updateDetail = LocalGroundPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = LocalGroundPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }
    
    public function updateCheck(Request $request){
        $updateCheck = LocalGroundPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
         //main id 
         $updateParticular = LocalGroundPaymentVoucher::find($request->transId);

         //particular id
         $uIdParticular = LocalGroundPaymentVoucher::find($request->id);

         $amount = $request->amount; 

         $updateAmount =  $updateParticular->amount; 
        
         $uParticular = LocalGroundPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
         
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
        $updateParticular =  LocalGroundPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = LocalGroundPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 
 
        $updateParticular->date = $request->date;
        $updateParticular->particulars = $request->particulars;
        $updateParticular->amount = $amount;
        $updateParticular->amount_due = $sum;
        $updateParticular->save();
 
        return response()->json('Success: successfully updated.');
 
    }

    public function printGetSummary($date){
        $moduleNameVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($date))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $cash = "CASH"; 
        $getTransactionListCashes = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($date))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();
        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($date))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->sum('local_ground_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.currency',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.cheque_total_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($date))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $check)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($date))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', '!=', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');

        
        $totalPaidAmountCheck = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.cheque_total_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($date))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', $status)
                            ->where('local_ground_payment_vouchers.currency', '!=', $currency)
                            ->sum('local_ground_payment_vouchers.cheque_total_amount');

    $totalAmountCheckInUSD = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($date))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency',  $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');

        $totalPaidAmountCheckInUSD = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.cheque_total_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($date))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', $status)
                            ->where('local_ground_payment_vouchers.currency', $currency)
                            ->sum('local_ground_payment_vouchers.cheque_total_amount');

        $getDateToday = "";
        $uri0 ="";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLocalGround',  compact('date', 'uri0', 'uri1', 'getDateToday', 
        'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks',         
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck' , 'totalAmountCheck', 'totalPaidAmountCheckInUSD'));
                            
        return $pdf->download('local-ground-summary-report.pdf');

    }

    public function printMultipleSummary(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];

        
        $moduleNameVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereBetween('local_ground_payment_vouchers.created_at', [$uri0, $uri1])
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $cash = "CASH"; 
        $getTransactionListCashes = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereBetween('local_ground_payment_vouchers.created_at', [$uri0, $uri1])
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();
        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereBetween('local_ground_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->sum('local_ground_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.currency',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.cheque_total_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereBetween('local_ground_payment_vouchers.created_at', [$uri0, $uri1])
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $check)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereBetween('local_ground_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', '!=', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');

        
        $totalPaidAmountCheck = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.cheque_total_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereBetween('local_ground_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', $status)
                            ->where('local_ground_payment_vouchers.currency', '!=',$currency)
                            ->sum('local_ground_payment_vouchers.cheque_total_amount');


        $totalAmountCheckInUSD = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereBetween('local_ground_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');

        $totalPaidAmountCheckInUSD = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.cheque_total_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereBetween('local_ground_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', $status)
                            ->where('local_ground_payment_vouchers.currency', $currency)
                            ->sum('local_ground_payment_vouchers.cheque_total_amount');


        $pdf = PDF::loadView('printSummaryLocalGround',  compact('date', 'uri0', 'uri1', 
        'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks',         
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck', 'totalAmountCheckInUSD', 'totalPaidAmountCheckInUSD'));
                            
        return $pdf->download('local-ground-summary-report.pdf');
                   


    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        $moduleNameVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereBetween('local_ground_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $cash = "CASH"; 
        $getTransactionListCashes = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereBetween('local_ground_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();
        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereBetween('local_ground_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->sum('local_ground_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.currency',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.cheque_total_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereBetween('local_ground_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $check)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereBetween('local_ground_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', '!=', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');

        
    $totalAmountCheckInUSD = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereBetween('local_ground_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');
        return view('local-ground-multiple-summary-report', compact('getTransactionLists', 
        'startDate', 'endDate', 'getTransactionListCashes', 
        'getTransactionListChecks', 'totalAmountCashes', 'totalAmountCheck', 'totalAmountCheckInUSD'));



    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");

        $moduleNameVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $cash = "CASH"; 
        $getTransactionListCashes = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();
        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->sum('local_ground_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.currency',
                        'local_ground_payment_vouchers.currency',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.cheque_total_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $check)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', '!=', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');

        
        $totalPaidAmountCheck = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.cheque_total_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', $status)
                            ->where('local_ground_payment_vouchers.currency', '!=', $currency)
                            ->sum('local_ground_payment_vouchers.cheque_total_amount');

    $totalAmountCheckInUSD = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');

        
    $totalPaidAmountCheckInUSD = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.cheque_total_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', $status)
                            ->where('local_ground_payment_vouchers.currency', $currency)
                            ->sum('local_ground_payment_vouchers.cheque_total_amount');

        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLocalGround',  compact('date', 'getDateToday', 'uri0', 'uri1',
         'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks',         
         'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck', 'totalAmountCheckInUSD', 'totalPaidAmountCheckInUSD'));
                            
        return $pdf->download('local-ground-summary-report.pdf');

    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');

        $moduleNameVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDate))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $cash = "CASH"; 
        $getTransactionListCashes = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDate))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();
        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDate))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->sum('local_ground_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.currency',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.cheque_total_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDate))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $check)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDate))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', '!=', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');


        $totalAmountCheckInUSD = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDate))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');
        
        return view('local-ground-get-summary-report', compact('getDate','getTransactionLists', 'getTransactionListCashes', 
        'getTransactionListChecks', 'totalAmountCashes', 'totalAmountCheck', 'totalAmountCheckInUSD'));
                    

    }

    public function summaryReport(){
        $getDateToday = date("Y-m-d");

        $moduleNameVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $cash = "CASH"; 
        $getTransactionListCashes = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();
        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $cash)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->sum('local_ground_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.currency',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.cheque_total_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.created_at',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.pv_id', NULL)
                        ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('local_ground_codes.module_name', $moduleNameVoucher)
                        ->where('local_ground_payment_vouchers.deleted_at', NULL)
                        ->where('local_ground_payment_vouchers.method_of_payment', $check)
                        ->orderBy('local_ground_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.status', '!=', $status)
                            ->where('local_ground_payment_vouchers.currency', '!=', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');

        
        $totalAmountCheckInUSD = DB::table(
                                'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_payment_vouchers.created_at',
                            'local_ground_payment_vouchers.deleted_at',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->whereDate('local_ground_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('local_ground_codes.module_name', $moduleNameVoucher)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->where('local_ground_payment_vouchers.method_of_payment', $check)
                            ->where('local_ground_payment_vouchers.currency', $currency)
                            ->sum('local_ground_payment_vouchers.amount_due');

        return view('local-ground-summary-report', compact('getTransactionLists', 'getTransactionListCashes', 
        'getTransactionListChecks', 'totalAmountCashes', 'totalAmountCheck', 'totalAmountCheckInUSD'));

    }

    public function printPayables($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.id', $id)
                        ->where('local_ground_codes.module_name', $moduleName)
                        ->get();

        //getParticular details
        $getParticulars = LocalGroundPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
    

        $getChequeNumbers = LocalGroundPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = LocalGroundPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
         $amount1 = LocalGroundPaymentVoucher::where('id', $id)->sum('amount');
         $amount2 = LocalGroundPaymentVoucher::where('pv_id', $id)->sum('amount');
           
         $sum = $amount1 + $amount2;
         
         //
         $chequeAmount1 = LocalGroundPaymentVoucher::where('id', $id)->sum('cheque_amount');
         $chequeAmount2 = LocalGroundPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
         
         $sumCheque = $chequeAmount1 + $chequeAmount2;
      

        $pdf = PDF::loadView('printPayablesLocalGround', compact('payableId',  
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

        return $pdf->download('local-ground-payment-voucher.pdf');

    }

    public function viewPayableDetails($id){
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                        'local_ground_payment_vouchers')
                        ->select( 
                        'local_ground_payment_vouchers.id',
                        'local_ground_payment_vouchers.user_id',
                        'local_ground_payment_vouchers.pv_id',
                        'local_ground_payment_vouchers.date',
                        'local_ground_payment_vouchers.paid_to',
                        'local_ground_payment_vouchers.account_no',
                        'local_ground_payment_vouchers.account_name',
                        'local_ground_payment_vouchers.particulars',
                        'local_ground_payment_vouchers.amount',
                        'local_ground_payment_vouchers.method_of_payment',
                        'local_ground_payment_vouchers.prepared_by',
                        'local_ground_payment_vouchers.approved_by',
                        'local_ground_payment_vouchers.date_approved',
                        'local_ground_payment_vouchers.received_by_date',
                        'local_ground_payment_vouchers.created_by',
                        'local_ground_payment_vouchers.invoice_number',
                        'local_ground_payment_vouchers.issued_date',
                        'local_ground_payment_vouchers.category',
                        'local_ground_payment_vouchers.amount_due',
                        'local_ground_payment_vouchers.delivered_date',
                        'local_ground_payment_vouchers.status',
                        'local_ground_payment_vouchers.cheque_number',
                        'local_ground_payment_vouchers.cheque_amount',
                        'local_ground_payment_vouchers.sub_category',
                        'local_ground_payment_vouchers.sub_category_account_id',
                        'local_ground_payment_vouchers.deleted_at',
                        'local_ground_codes.local_ground_code',
                        'local_ground_codes.module_id',
                        'local_ground_codes.module_code',
                        'local_ground_codes.module_name')
                        ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                        ->where('local_ground_payment_vouchers.id', $id)
                        ->where('local_ground_codes.module_name', $moduleName)
                        ->get();

        $getViewPaymentDetails = LocalGroundPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //getParticular details
        $getParticulars = LocalGroundPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        return view('view-local-ground-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
 
    }

    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.pv_id', NULL)
                            ->where('local_ground_codes.module_name', $moduleName)
                            ->where('local_ground_payment_vouchers.deleted_at', NULL)
                            ->orderBy('local_ground_payment_vouchers.id', 'desc')
                            ->get()->toArray();

             //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmountDue = LocalGroundPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('local-ground-transaction-list',compact('getTransactionLists', 'totalAmountDue'));
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

                    $payables = LocalGroundPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect()->route('editPayablesDetailLocalGround', ['id'=>$id]);
                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailLocalGround', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = LocalGroundPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect()->route('editPayablesDetailLocalGround', ['id'=>$id]);

                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailLocalGround', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = LocalGroundPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect()->route('editPayablesDetailLocalGround', ['id'=>$id]);
                    
                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailLocalGround', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = LocalGroundPaymentVoucher::find($id);

        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

        $addParticulars = new LocalGroundPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'date'=>$request->get('date'),
            'invoice_number'=>$request->get('invoiceNo'),
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addParticulars->save();

        //update 
        $particulars->amount_due = $add;
        $particulars->save();
        
        Session::flash('particularsAdded', 'Particulars added.');

        return redirect()->route('editPayablesDetailLocalGround', ['id'=>$id]);

    }

    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = LocalGroundPaymentVoucher::find($id);
        
        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');
        
        //save payment cheque num and cheque amount
        $addPayment = new LocalGroundPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'date'=>$request->get('date'),
            'invoice_number'=>$request->get('invoiceNo'),
            'account_name_no'=>$request->get('accountNameNo'),
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,
        ]);

        $addPayment->save();

        //update the total cheque amount
        $paymentData->cheque_total_amount = $totalChequeAmount;
        $paymentData->save();

        Session::flash('paymentAdded', 'Payment added.');

        return redirect()->route('editPayablesDetailLocalGround', ['id'=>$id]);

    }

    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'local_ground_payment_vouchers')
                            ->select( 
                            'local_ground_payment_vouchers.id',
                            'local_ground_payment_vouchers.user_id',
                            'local_ground_payment_vouchers.pv_id',
                            'local_ground_payment_vouchers.date',
                            'local_ground_payment_vouchers.paid_to',
                            'local_ground_payment_vouchers.account_no',
                            'local_ground_payment_vouchers.account_name',
                            'local_ground_payment_vouchers.particulars',
                            'local_ground_payment_vouchers.amount',
                            'local_ground_payment_vouchers.currency',
                            'local_ground_payment_vouchers.method_of_payment',
                            'local_ground_payment_vouchers.prepared_by',
                            'local_ground_payment_vouchers.approved_by',
                            'local_ground_payment_vouchers.date_approved',
                            'local_ground_payment_vouchers.received_by_date',
                            'local_ground_payment_vouchers.created_by',
                            'local_ground_payment_vouchers.invoice_number',
                            'local_ground_payment_vouchers.issued_date',
                            'local_ground_payment_vouchers.category',
                            'local_ground_payment_vouchers.amount_due',
                            'local_ground_payment_vouchers.delivered_date',
                            'local_ground_payment_vouchers.status',
                            'local_ground_payment_vouchers.cheque_number',
                            'local_ground_payment_vouchers.cheque_amount',
                            'local_ground_payment_vouchers.sub_category',
                            'local_ground_payment_vouchers.sub_category_account_id',
                            'local_ground_codes.local_ground_code',
                            'local_ground_codes.module_id',
                            'local_ground_codes.module_code',
                            'local_ground_codes.module_name')
                            ->leftJoin('local_ground_codes', 'local_ground_payment_vouchers.id', '=', 'local_ground_codes.module_id')
                            ->where('local_ground_payment_vouchers.id', $id)
                            ->where('local_ground_codes.module_name', $moduleName)
                            ->get();

        $getChequeNumbers = LocalGroundPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        
        $getCashAmounts = LocalGroundPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
      
        //getParticular details
        $getParticulars = LocalGroundPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
            //amount
        $amount1 = LocalGroundPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = LocalGroundPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;

        $chequeAmount1 = LocalGroundPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = LocalGroundPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('local-ground-payables-detail', compact('transactionList', 'getParticulars', 'sum' , 
        'getChequeNumbers', 'sumCheque', 'getCashAmounts'));
                

    }

    public function paymentVoucherStore(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //get the latest insert id query in table local ground
          $dataVoucherRef = DB::select('SELECT id, local_ground_code FROM local_ground_codes ORDER BY id DESC LIMIT 1');
        
          //if code is not zero add plus 1 reference number
          if(isset($dataVoucherRef[0]->local_ground_code) != 0){
              //if code is not 0
              $newVoucherRef = $dataVoucherRef[0]->local_ground_code +1;
              $uVoucher = sprintf("%06d",$newVoucherRef);   
  
          }else{
              //if code is 0 
              $newVoucherRef = 1;
              $uVoucher = sprintf("%06d",$newVoucherRef);
          } 


        if($request->get('category') == "Payroll"){
            $subCat = NULL;
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') == "None"){
            $subCat = NULL;
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') == "Supplier"){
            $supplier = $request->get('supplierName');
            $supplierExps = explode("-", $supplier);

            $supplierExp =  $supplierExps[0];
            $supplierExp1 = $supplierExps[1];


            $subCat = "NULL";
       }

           //check if invoice number already exists
           $target = DB::table(
            'local_ground_payment_vouchers')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        if($target  === NULL){
            $addPaymentVoucher = new LocalGroundPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'method_of_payment'=>$request->get('paymentMethod'),
                'account_name'=>$request->get('accountName'),
                'issued_date'=>$request->get('issuedDate'),
                'delivered_date'=>$request->get('deliveredDate'),
                'amount'=>$request->get('amount'),
                'currency'=>$request->get('currency'),
                'amount_due'=>$request->get('amount'),
                'particulars'=>$request->get('particulars'),
                'category'=>$request->get('category'),
                'sub_category'=>$subCat,
                'supplier_id'=>$supplierExp,
                'supplier_name'=>$supplierExp1,  
                'prepared_by'=>$name,
                'created_by'=>$name,
            ]);

            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;

            $moduleCode = "PV-";
            $moduleName = "Payment Voucher";

            $localGround = new LocalGroundCode([
                'user_id'=>$user->id,
                'local_ground_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);
            $localGround->save();

            return redirect()->route('editPayablesDetailLocalGround', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherStoreLocalGround')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');

        }
  

    }

    public function paymentVoucherForm(){
        //get suppliers
        $suppliers = LocalGroundSupplier::get()->toArray(); 

        return view('payment-voucher-form-local-ground', compact('suppliers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('local-ground');
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

    public function destroyTransaction($id){
        $transactionList = LocalGroundPaymentVoucher::find($id);
        $transactionList->delete();
    }
}
