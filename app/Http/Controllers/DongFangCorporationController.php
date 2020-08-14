<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use PDF;
use App\User; 
use App\DongFangCorporationPaymentVoucher;
use App\DongFangCorporationBillingStatement;
use App\DongFangCorporationPettyCash;
use App\DongFangCorporationCode;
use App\DongFangCorporationSupplier;

class DongFangCorporationController extends Controller
{
    public function printSupplier($id){
        $viewSupplier = DongFangCorporationSupplier::where('id', $id)->get();

        $printSuppliers = DB::table(
            'dong_fang_corporation_payment_vouchers')
            ->select( 
            'dong_fang_corporation_payment_vouchers.id',
            'dong_fang_corporation_payment_vouchers.user_id',
            'dong_fang_corporation_payment_vouchers.pv_id',
            'dong_fang_corporation_payment_vouchers.date',
            'dong_fang_corporation_payment_vouchers.paid_to',
            'dong_fang_corporation_payment_vouchers.account_no',
            'dong_fang_corporation_payment_vouchers.account_name',
            'dong_fang_corporation_payment_vouchers.particulars',
            'dong_fang_corporation_payment_vouchers.amount',
            'dong_fang_corporation_payment_vouchers.method_of_payment',
            'dong_fang_corporation_payment_vouchers.prepared_by',
            'dong_fang_corporation_payment_vouchers.approved_by',
            'dong_fang_corporation_payment_vouchers.date_approved',
            'dong_fang_corporation_payment_vouchers.received_by_date',
            'dong_fang_corporation_payment_vouchers.created_by',
            'dong_fang_corporation_payment_vouchers.created_at',
            'dong_fang_corporation_payment_vouchers.invoice_number',
            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
            'dong_fang_corporation_payment_vouchers.issued_date',
            'dong_fang_corporation_payment_vouchers.category',
            'dong_fang_corporation_payment_vouchers.amount_due',
            'dong_fang_corporation_payment_vouchers.delivered_date',
            'dong_fang_corporation_payment_vouchers.status',
            'dong_fang_corporation_payment_vouchers.cheque_number',
            'dong_fang_corporation_payment_vouchers.cheque_amount',
            'dong_fang_corporation_payment_vouchers.sub_category',
            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
            'dong_fang_corporation_payment_vouchers.supplier_name',
            'dong_fang_corporation_payment_vouchers.deleted_at',
            'dong_fang_corporation_suppliers.id',
            'dong_fang_corporation_suppliers.date',
            'dong_fang_corporation_suppliers.supplier_name')
            ->leftJoin('dong_fang_corporation_suppliers', 'dong_fang_corporation_payment_vouchers.supplier_id', '=', 'dong_fang_corporation_suppliers.id')
            ->where('dong_fang_corporation_suppliers.id', $id)
            ->get();

        $status = "FULLY PAID AND RELEASED"; 
        $totalAmountDue = DB::table(
                'dong_fang_corporation_payment_vouchers')
                ->select( 
                'dong_fang_corporation_payment_vouchers.id',
                'dong_fang_corporation_payment_vouchers.user_id',
                'dong_fang_corporation_payment_vouchers.pv_id',
                'dong_fang_corporation_payment_vouchers.date',
                'dong_fang_corporation_payment_vouchers.paid_to',
                'dong_fang_corporation_payment_vouchers.account_no',
                'dong_fang_corporation_payment_vouchers.account_name',
                'dong_fang_corporation_payment_vouchers.particulars',
                'dong_fang_corporation_payment_vouchers.amount',
                'dong_fang_corporation_payment_vouchers.method_of_payment',
                'dong_fang_corporation_payment_vouchers.prepared_by',
                'dong_fang_corporation_payment_vouchers.approved_by',
                'dong_fang_corporation_payment_vouchers.date_approved',
                'dong_fang_corporation_payment_vouchers.received_by_date',
                'dong_fang_corporation_payment_vouchers.created_by',
                'dong_fang_corporation_payment_vouchers.created_at',
                'dong_fang_corporation_payment_vouchers.invoice_number',
                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                'dong_fang_corporation_payment_vouchers.issued_date',
                'dong_fang_corporation_payment_vouchers.category',
                'dong_fang_corporation_payment_vouchers.amount_due',
                'dong_fang_corporation_payment_vouchers.delivered_date',
                'dong_fang_corporation_payment_vouchers.status',
                'dong_fang_corporation_payment_vouchers.cheque_number',
                'dong_fang_corporation_payment_vouchers.cheque_amount',
                'dong_fang_corporation_payment_vouchers.sub_category',
                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                'dong_fang_corporation_payment_vouchers.supplier_name',
                'dong_fang_corporation_payment_vouchers.deleted_at',
                'dong_fang_corporation_suppliers.id',
                'dong_fang_corporation_suppliers.date',
                'dong_fang_corporation_suppliers.supplier_name')
                ->leftJoin('dong_fang_corporation_suppliers', 'dong_fang_corporation_payment_vouchers.supplier_id', '=', 'dong_fang_corporation_suppliers.id')
                ->where('dong_fang_corporation_suppliers.id', $id)
                ->where('dong_fang_corporation_payment_vouchers.status', '!=', $status)
                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSupplierDongFang', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('dong-fang-corporation-supplier.pdf');

    }

    public function viewSupplier($id){
        $viewSupplier = DongFangCorporationSupplier::where('id', $id)->get();

        $supplierLists = DB::table(
                        'dong_fang_corporation_payment_vouchers')
                        ->select( 
                        'dong_fang_corporation_payment_vouchers.id',
                        'dong_fang_corporation_payment_vouchers.user_id',
                        'dong_fang_corporation_payment_vouchers.pv_id',
                        'dong_fang_corporation_payment_vouchers.date',
                        'dong_fang_corporation_payment_vouchers.paid_to',
                        'dong_fang_corporation_payment_vouchers.account_no',
                        'dong_fang_corporation_payment_vouchers.account_name',
                        'dong_fang_corporation_payment_vouchers.particulars',
                        'dong_fang_corporation_payment_vouchers.amount',
                        'dong_fang_corporation_payment_vouchers.method_of_payment',
                        'dong_fang_corporation_payment_vouchers.prepared_by',
                        'dong_fang_corporation_payment_vouchers.approved_by',
                        'dong_fang_corporation_payment_vouchers.date_approved',
                        'dong_fang_corporation_payment_vouchers.received_by_date',
                        'dong_fang_corporation_payment_vouchers.created_by',
                        'dong_fang_corporation_payment_vouchers.created_at',
                        'dong_fang_corporation_payment_vouchers.invoice_number',
                        'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                        'dong_fang_corporation_payment_vouchers.issued_date',
                        'dong_fang_corporation_payment_vouchers.category',
                        'dong_fang_corporation_payment_vouchers.amount_due',
                        'dong_fang_corporation_payment_vouchers.delivered_date',
                        'dong_fang_corporation_payment_vouchers.status',
                        'dong_fang_corporation_payment_vouchers.cheque_number',
                        'dong_fang_corporation_payment_vouchers.cheque_amount',
                        'dong_fang_corporation_payment_vouchers.sub_category',
                        'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                        'dong_fang_corporation_payment_vouchers.supplier_name',
                        'dong_fang_corporation_payment_vouchers.deleted_at',
                        'dong_fang_corporation_suppliers.id',
                        'dong_fang_corporation_suppliers.date',
                        'dong_fang_corporation_suppliers.supplier_name')
                        ->leftJoin('dong_fang_corporation_suppliers', 'dong_fang_corporation_payment_vouchers.supplier_id', '=', 'dong_fang_corporation_suppliers.id')
                        ->where('dong_fang_corporation_suppliers.id', $id)
                        ->get();
        
        $status = "FULLY PAID AND RELEASED"; 
        $totalAmountDue = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.supplier_name',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_suppliers.id',
                            'dong_fang_corporation_suppliers.date',
                            'dong_fang_corporation_suppliers.supplier_name')
                            ->leftJoin('dong_fang_corporation_suppliers', 'dong_fang_corporation_payment_vouchers.supplier_id', '=', 'dong_fang_corporation_suppliers.id')
                            ->where('dong_fang_corporation_suppliers.id', $id)
                            ->where('dong_fang_corporation_payment_vouchers.status', '!=', $status)
                            ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        return view('view-dong-fang-corporation-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue')); 

    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //check if supplier name exits
         $target = DB::table(
                    'dong_fang_corporation_suppliers')
                    ->where('supplier_name', $request->supplierName)
                    ->get()->first();
    
        if($target === NULL){
            $supplier = new DongFangCorporationSupplier([
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
        $suppliers = DongFangCorporationSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('dong-fang-corporation-supplier', compact('suppliers'));
    }

    public function updateDetails(Request $request){    
        $updateDetail = DongFangCorporationPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = DongFangCorporationPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = DongFangCorporationPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
          //main id 
          $updateParticular = DongFangCorporationPaymentVoucher::find($request->transId);

          //particular id
          $uIdParticular = DongFangCorporationPaymentVoucher::find($request->id);
 
          $amount = $request->amount; 
 
          $updateAmount =  $updateParticular->amount; 
         
          $uParticular = DongFangCorporationPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
          
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
        $updateParticular =  DongFangCorporationPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = DongFangCorporationPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 
 
        $updateParticular->date = $request->date;
        $updateParticular->particulars = $request->particulars;
        $updateParticular->amount = $amount;
        $updateParticular->amount_due = $sum;
        $updateParticular->save();
 
        return response()->json('Success: successfully updated.');
 
    }

    public function printMultipleSummary(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];

        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $totalAmountCashes = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$uri0, $uri1])                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.cheque_total_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                                ->where('dong_fang_corporation_payment_vouchers.status', '!=', $status)
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');
        
        $totalPaidAmountCheck = DB::table(
                                    'dong_fang_corporation_payment_vouchers')
                                    ->select( 
                                    'dong_fang_corporation_payment_vouchers.id',
                                    'dong_fang_corporation_payment_vouchers.user_id',
                                    'dong_fang_corporation_payment_vouchers.pv_id',
                                    'dong_fang_corporation_payment_vouchers.date',
                                    'dong_fang_corporation_payment_vouchers.paid_to',
                                    'dong_fang_corporation_payment_vouchers.account_no',
                                    'dong_fang_corporation_payment_vouchers.account_name',
                                    'dong_fang_corporation_payment_vouchers.particulars',
                                    'dong_fang_corporation_payment_vouchers.amount',
                                    'dong_fang_corporation_payment_vouchers.method_of_payment',
                                    'dong_fang_corporation_payment_vouchers.prepared_by',
                                    'dong_fang_corporation_payment_vouchers.approved_by',
                                    'dong_fang_corporation_payment_vouchers.date_approved',
                                    'dong_fang_corporation_payment_vouchers.received_by_date',
                                    'dong_fang_corporation_payment_vouchers.created_by',
                                    'dong_fang_corporation_payment_vouchers.created_at',
                                    'dong_fang_corporation_payment_vouchers.invoice_number',
                                    'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                    'dong_fang_corporation_payment_vouchers.issued_date',
                                    'dong_fang_corporation_payment_vouchers.category',
                                    'dong_fang_corporation_payment_vouchers.amount_due',
                                    'dong_fang_corporation_payment_vouchers.delivered_date',
                                    'dong_fang_corporation_payment_vouchers.status',
                                    'dong_fang_corporation_payment_vouchers.cheque_number',
                                    'dong_fang_corporation_payment_vouchers.cheque_amount',
                                    'dong_fang_corporation_payment_vouchers.cheque_total_amount',
                                    'dong_fang_corporation_payment_vouchers.sub_category',
                                    'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                    'dong_fang_corporation_payment_vouchers.deleted_at',
                                    'dong_fang_corporation_codes.dong_fang_code',
                                    'dong_fang_corporation_codes.module_id',
                                    'dong_fang_corporation_codes.module_code',
                                    'dong_fang_corporation_codes.module_name')
                                    ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                    ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                    ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                    ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                    ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$uri0, $uri1])
                                    ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                                    ->where('dong_fang_corporation_payment_vouchers.status', $status)
                                    ->sum('dong_fang_corporation_payment_vouchers.cheque_total_amount');

        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryDongFang', compact('date', 'getDateToday', 'uri0', 'uri1',
        'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
                                
        return $pdf->download('dong-fang-corporation-summary-report.pdf');

    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        $moduleName = "Petty Cash";
        $pettyCashLists = DB::table(
                        'dong_fang_corporation_petty_cashes')
                        ->select( 
                        'dong_fang_corporation_petty_cashes.id',
                        'dong_fang_corporation_petty_cashes.user_id',
                        'dong_fang_corporation_petty_cashes.pc_id',
                        'dong_fang_corporation_petty_cashes.date',
                        'dong_fang_corporation_petty_cashes.petty_cash_name',
                        'dong_fang_corporation_petty_cashes.petty_cash_summary',
                        'dong_fang_corporation_petty_cashes.amount',
                        'dong_fang_corporation_petty_cashes.created_by',
                        'dong_fang_corporation_petty_cashes.created_at',
                        'dong_fang_corporation_petty_cashes.deleted_at',
                        'dong_fang_corporation_codes.dong_fang_code',
                        'dong_fang_corporation_codes.module_id',
                        'dong_fang_corporation_codes.module_code',
                        'dong_fang_corporation_codes.module_name')
                        ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_petty_cashes.id', '=', 'dong_fang_corporation_codes.module_id')
                        ->where('dong_fang_corporation_petty_cashes.pc_id', NUll)
                        ->where('dong_fang_corporation_petty_cashes.deleted_at', NULL)
                        ->where('dong_fang_corporation_codes.module_name', $moduleName)
                        ->whereBetween('dong_fang_corporation_petty_cashes.created_at', [$startDate, $endDate])
                        ->orderBy('dong_fang_corporation_petty_cashes.id', 'desc')
                        ->get()->toArray();

        $moduleNamePV = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();
            
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $totalAmountCashes = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.cheque_total_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->whereBetween('dong_fang_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                                ->where('dong_fang_corporation_payment_vouchers.status', '!=', $status)
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        
        return view('dong-fang-corporation-multiple-summary-report', compact('pettyCashLists', 'startDate',  'endDate',
        'getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 
        'totalAmountCheck'));


    }

    public function search(Request $request){
        $getSearchResults =DongFangCorporationCode::where('dong_fang_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Petty Cash"){
            $getSearchPettyCashes = DB::table(
                    'dong_fang_corporation_petty_cashes')
                    ->select( 
                    'dong_fang_corporation_petty_cashes.id',
                    'dong_fang_corporation_petty_cashes.user_id',
                    'dong_fang_corporation_petty_cashes.pc_id',
                    'dong_fang_corporation_petty_cashes.date',
                    'dong_fang_corporation_petty_cashes.petty_cash_name',
                    'dong_fang_corporation_petty_cashes.petty_cash_summary',
                    'dong_fang_corporation_petty_cashes.amount',
                    'dong_fang_corporation_petty_cashes.created_by',
                    'dong_fang_corporation_petty_cashes.created_at',
                    'dong_fang_corporation_petty_cashes.deleted_at',
                    'dong_fang_corporation_codes.dong_fang_code',
                    'dong_fang_corporation_codes.module_id',
                    'dong_fang_corporation_codes.module_code',
                    'dong_fang_corporation_codes.module_name')
                    ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_petty_cashes.id', '=', 'dong_fang_corporation_codes.module_id')
                    ->where('dong_fang_corporation_petty_cashes.id', $getSearchResults[0]->module_id)
                    ->where('dong_fang_corporation_codes.module_name', $getSearchResults[0]->module_name)
                    ->get()->toArray();

            $getAllCodes = DongFangCorporationCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('dong-fang-search-results',  compact('module', 'getAllCodes', 'getSearchPettyCashes'));
                      
             
        }else if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                        'dong_fang_corporation_payment_vouchers')
                        ->select( 
                        'dong_fang_corporation_payment_vouchers.id',
                        'dong_fang_corporation_payment_vouchers.user_id',
                        'dong_fang_corporation_payment_vouchers.pv_id',
                        'dong_fang_corporation_payment_vouchers.date',
                        'dong_fang_corporation_payment_vouchers.paid_to',
                        'dong_fang_corporation_payment_vouchers.account_no',
                        'dong_fang_corporation_payment_vouchers.account_name',
                        'dong_fang_corporation_payment_vouchers.particulars',
                        'dong_fang_corporation_payment_vouchers.amount',
                        'dong_fang_corporation_payment_vouchers.method_of_payment',
                        'dong_fang_corporation_payment_vouchers.prepared_by',
                        'dong_fang_corporation_payment_vouchers.approved_by',
                        'dong_fang_corporation_payment_vouchers.date_approved',
                        'dong_fang_corporation_payment_vouchers.received_by_date',
                        'dong_fang_corporation_payment_vouchers.created_by',
                        'dong_fang_corporation_payment_vouchers.created_at',
                        'dong_fang_corporation_payment_vouchers.invoice_number',
                        'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                        'dong_fang_corporation_payment_vouchers.issued_date',
                        'dong_fang_corporation_payment_vouchers.category',
                        'dong_fang_corporation_payment_vouchers.amount_due',
                        'dong_fang_corporation_payment_vouchers.delivered_date',
                        'dong_fang_corporation_payment_vouchers.status',
                        'dong_fang_corporation_payment_vouchers.cheque_number',
                        'dong_fang_corporation_payment_vouchers.cheque_amount',
                        'dong_fang_corporation_payment_vouchers.sub_category',
                        'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                        'dong_fang_corporation_payment_vouchers.deleted_at',
                        'dong_fang_corporation_codes.dong_fang_code',
                        'dong_fang_corporation_codes.module_id',
                        'dong_fang_corporation_codes.module_code',
                        'dong_fang_corporation_codes.module_name')
                        ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                        ->where('dong_fang_corporation_payment_vouchers.id', $getSearchResults[0]->module_id)
                        ->where('dong_fang_corporation_codes.module_name', $getSearchResults[0]->module_name)
                        ->get()->toArray();

            $getAllCodes = DongFangCorporationCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('dong-fang-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
                   

        }
    }

    public function searchNumberCode(){
        $getAllCodes = DongFangCorporationCode::get()->toArray();
        return view('dong-fang-search-number-code', compact('getAllCodes'));
    }

    public function printGetSummary($date){
        
        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($date))
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $totalAmountCashes = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($date))
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.cheque_total_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($date))
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($date))
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                                ->where('dong_fang_corporation_payment_vouchers.status', '!=', $status)
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        
        $totalPaidAmountCheck = DB::table(
                                    'dong_fang_corporation_payment_vouchers')
                                    ->select( 
                                    'dong_fang_corporation_payment_vouchers.id',
                                    'dong_fang_corporation_payment_vouchers.user_id',
                                    'dong_fang_corporation_payment_vouchers.pv_id',
                                    'dong_fang_corporation_payment_vouchers.date',
                                    'dong_fang_corporation_payment_vouchers.paid_to',
                                    'dong_fang_corporation_payment_vouchers.account_no',
                                    'dong_fang_corporation_payment_vouchers.account_name',
                                    'dong_fang_corporation_payment_vouchers.particulars',
                                    'dong_fang_corporation_payment_vouchers.amount',
                                    'dong_fang_corporation_payment_vouchers.method_of_payment',
                                    'dong_fang_corporation_payment_vouchers.prepared_by',
                                    'dong_fang_corporation_payment_vouchers.approved_by',
                                    'dong_fang_corporation_payment_vouchers.date_approved',
                                    'dong_fang_corporation_payment_vouchers.received_by_date',
                                    'dong_fang_corporation_payment_vouchers.created_by',
                                    'dong_fang_corporation_payment_vouchers.created_at',
                                    'dong_fang_corporation_payment_vouchers.invoice_number',
                                    'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                    'dong_fang_corporation_payment_vouchers.issued_date',
                                    'dong_fang_corporation_payment_vouchers.category',
                                    'dong_fang_corporation_payment_vouchers.amount_due',
                                    'dong_fang_corporation_payment_vouchers.delivered_date',
                                    'dong_fang_corporation_payment_vouchers.status',
                                    'dong_fang_corporation_payment_vouchers.cheque_number',
                                    'dong_fang_corporation_payment_vouchers.cheque_amount',
                                    'dong_fang_corporation_payment_vouchers.cheque_total_amount',
                                    'dong_fang_corporation_payment_vouchers.sub_category',
                                    'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                    'dong_fang_corporation_payment_vouchers.deleted_at',
                                    'dong_fang_corporation_codes.dong_fang_code',
                                    'dong_fang_corporation_codes.module_id',
                                    'dong_fang_corporation_codes.module_code',
                                    'dong_fang_corporation_codes.module_name')
                                    ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                    ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                    ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                    ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                    ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($date))
                                    ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                                    ->where('dong_fang_corporation_payment_vouchers.status', $status)
                                    ->sum('dong_fang_corporation_payment_vouchers.cheque_total_amount');
    
            
        $getDateToday = "";  
        $uri0 = "";
        $uri1 = ""; 
        $pdf = PDF::loadView('printSummaryDongFang', compact('date', 'getDateToday', 'uri0', 'uri1', 'getTransactionListCashes', 
                'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
                                                        
        return $pdf->download('dong-fang-corporation-summary-report.pdf');
        
       
    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');

        $moduleName = "Petty Cash";
        $pettyCashLists = DB::table(
                        'dong_fang_corporation_petty_cashes')
                        ->select( 
                        'dong_fang_corporation_petty_cashes.id',
                        'dong_fang_corporation_petty_cashes.user_id',
                        'dong_fang_corporation_petty_cashes.pc_id',
                        'dong_fang_corporation_petty_cashes.date',
                        'dong_fang_corporation_petty_cashes.petty_cash_name',
                        'dong_fang_corporation_petty_cashes.petty_cash_summary',
                        'dong_fang_corporation_petty_cashes.amount',
                        'dong_fang_corporation_petty_cashes.created_by',
                        'dong_fang_corporation_petty_cashes.created_at',
                        'dong_fang_corporation_petty_cashes.deleted_at',
                        'dong_fang_corporation_codes.dong_fang_code',
                        'dong_fang_corporation_codes.module_id',
                        'dong_fang_corporation_codes.module_code',
                        'dong_fang_corporation_codes.module_name')
                        ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_petty_cashes.id', '=', 'dong_fang_corporation_codes.module_id')
                        ->where('dong_fang_corporation_petty_cashes.pc_id', NUll)
                        ->where('dong_fang_corporation_petty_cashes.deleted_at', NULL)
                        ->where('dong_fang_corporation_codes.module_name', $moduleName)
                        ->whereDate('dong_fang_corporation_petty_cashes.created_at', '=', date($getDate))
                        ->orderBy('dong_fang_corporation_petty_cashes.id', 'desc')
                        ->get()->toArray();

        $moduleNamePV = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDate))
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();
            
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDate))
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $totalAmountCashes = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDate))
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.cheque_total_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDate))
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $totalAmountCheck = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDate))
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                                ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        return view('dong-fang-corporation-get-summary-report', compact('getDate', 'pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 
        'totalAmountCheck'));
                  
    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");

        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $totalAmountCashes = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.cheque_total_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                                ->where('dong_fang_corporation_payment_vouchers.status', '!=', $status)
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');
        
        $totalPaidAmountCheck = DB::table(
                                    'dong_fang_corporation_payment_vouchers')
                                    ->select( 
                                    'dong_fang_corporation_payment_vouchers.id',
                                    'dong_fang_corporation_payment_vouchers.user_id',
                                    'dong_fang_corporation_payment_vouchers.pv_id',
                                    'dong_fang_corporation_payment_vouchers.date',
                                    'dong_fang_corporation_payment_vouchers.paid_to',
                                    'dong_fang_corporation_payment_vouchers.account_no',
                                    'dong_fang_corporation_payment_vouchers.account_name',
                                    'dong_fang_corporation_payment_vouchers.particulars',
                                    'dong_fang_corporation_payment_vouchers.amount',
                                    'dong_fang_corporation_payment_vouchers.method_of_payment',
                                    'dong_fang_corporation_payment_vouchers.prepared_by',
                                    'dong_fang_corporation_payment_vouchers.approved_by',
                                    'dong_fang_corporation_payment_vouchers.date_approved',
                                    'dong_fang_corporation_payment_vouchers.received_by_date',
                                    'dong_fang_corporation_payment_vouchers.created_by',
                                    'dong_fang_corporation_payment_vouchers.created_at',
                                    'dong_fang_corporation_payment_vouchers.invoice_number',
                                    'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                    'dong_fang_corporation_payment_vouchers.issued_date',
                                    'dong_fang_corporation_payment_vouchers.category',
                                    'dong_fang_corporation_payment_vouchers.amount_due',
                                    'dong_fang_corporation_payment_vouchers.delivered_date',
                                    'dong_fang_corporation_payment_vouchers.status',
                                    'dong_fang_corporation_payment_vouchers.cheque_number',
                                    'dong_fang_corporation_payment_vouchers.cheque_amount',
                                    'dong_fang_corporation_payment_vouchers.cheque_total_amount',
                                    'dong_fang_corporation_payment_vouchers.sub_category',
                                    'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                    'dong_fang_corporation_payment_vouchers.deleted_at',
                                    'dong_fang_corporation_codes.dong_fang_code',
                                    'dong_fang_corporation_codes.module_id',
                                    'dong_fang_corporation_codes.module_code',
                                    'dong_fang_corporation_codes.module_name')
                                    ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                    ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                    ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                    ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                    ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                                    ->where('dong_fang_corporation_payment_vouchers.status', $status)
                                    ->sum('dong_fang_corporation_payment_vouchers.cheque_total_amount');

        $pdf = PDF::loadView('printSummaryDongFang', compact('date', 'getDateToday', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
                                
        return $pdf->download('dong-fang-corporation-summary-report.pdf');
                    

    }

    public function summaryReport(){
        $getDateToday = date("Y-m-d");

        $moduleName = "Petty Cash";
        $pettyCashLists = DB::table(
                        'dong_fang_corporation_petty_cashes')
                        ->select( 
                        'dong_fang_corporation_petty_cashes.id',
                        'dong_fang_corporation_petty_cashes.user_id',
                        'dong_fang_corporation_petty_cashes.pc_id',
                        'dong_fang_corporation_petty_cashes.date',
                        'dong_fang_corporation_petty_cashes.petty_cash_name',
                        'dong_fang_corporation_petty_cashes.petty_cash_summary',
                        'dong_fang_corporation_petty_cashes.amount',
                        'dong_fang_corporation_petty_cashes.created_by',
                        'dong_fang_corporation_petty_cashes.created_at',
                        'dong_fang_corporation_petty_cashes.deleted_at',
                        'dong_fang_corporation_codes.dong_fang_code',
                        'dong_fang_corporation_codes.module_id',
                        'dong_fang_corporation_codes.module_code',
                        'dong_fang_corporation_codes.module_name')
                        ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_petty_cashes.id', '=', 'dong_fang_corporation_codes.module_id')
                        ->where('dong_fang_corporation_petty_cashes.pc_id', NUll)
                        ->where('dong_fang_corporation_petty_cashes.deleted_at', NULL)
                        ->where('dong_fang_corporation_codes.module_name', $moduleName)
                        ->whereDate('dong_fang_corporation_petty_cashes.created_at', '=', date($getDateToday))
                        ->orderBy('dong_fang_corporation_petty_cashes.id', 'desc')
                        ->get()->toArray();

        $moduleNamePV = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();
            
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $totalAmountCashes = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.created_at',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.cheque_total_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                            ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'dong_fang_corporation_payment_vouchers')
                                ->select( 
                                'dong_fang_corporation_payment_vouchers.id',
                                'dong_fang_corporation_payment_vouchers.user_id',
                                'dong_fang_corporation_payment_vouchers.pv_id',
                                'dong_fang_corporation_payment_vouchers.date',
                                'dong_fang_corporation_payment_vouchers.paid_to',
                                'dong_fang_corporation_payment_vouchers.account_no',
                                'dong_fang_corporation_payment_vouchers.account_name',
                                'dong_fang_corporation_payment_vouchers.particulars',
                                'dong_fang_corporation_payment_vouchers.amount',
                                'dong_fang_corporation_payment_vouchers.method_of_payment',
                                'dong_fang_corporation_payment_vouchers.prepared_by',
                                'dong_fang_corporation_payment_vouchers.approved_by',
                                'dong_fang_corporation_payment_vouchers.date_approved',
                                'dong_fang_corporation_payment_vouchers.received_by_date',
                                'dong_fang_corporation_payment_vouchers.created_by',
                                'dong_fang_corporation_payment_vouchers.created_at',
                                'dong_fang_corporation_payment_vouchers.invoice_number',
                                'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                                'dong_fang_corporation_payment_vouchers.issued_date',
                                'dong_fang_corporation_payment_vouchers.category',
                                'dong_fang_corporation_payment_vouchers.amount_due',
                                'dong_fang_corporation_payment_vouchers.delivered_date',
                                'dong_fang_corporation_payment_vouchers.status',
                                'dong_fang_corporation_payment_vouchers.cheque_number',
                                'dong_fang_corporation_payment_vouchers.cheque_amount',
                                'dong_fang_corporation_payment_vouchers.sub_category',
                                'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                                'dong_fang_corporation_payment_vouchers.deleted_at',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleNamePV)
                                ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                                ->whereDate('dong_fang_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dong_fang_corporation_payment_vouchers.method_of_payment', $check)
                                ->where('dong_fang_corporation_payment_vouchers.status', '!=', $status)
                                ->sum('dong_fang_corporation_payment_vouchers.amount_due');
                    
    
        return view('dong-fang-corporation-summary-report', compact('pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 
        'totalAmountCheck'));
    }

    public function viewPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                        'dong_fang_corporation_petty_cashes')
                        ->select( 
                        'dong_fang_corporation_petty_cashes.id',
                        'dong_fang_corporation_petty_cashes.user_id',
                        'dong_fang_corporation_petty_cashes.pc_id',
                        'dong_fang_corporation_petty_cashes.date',
                        'dong_fang_corporation_petty_cashes.petty_cash_name',
                        'dong_fang_corporation_petty_cashes.petty_cash_summary',
                        'dong_fang_corporation_petty_cashes.amount',
                        'dong_fang_corporation_petty_cashes.created_by',
                        'dong_fang_corporation_petty_cashes.deleted_at',
                        'dong_fang_corporation_codes.dong_fang_code',
                        'dong_fang_corporation_codes.module_id',
                        'dong_fang_corporation_codes.module_code',
                        'dong_fang_corporation_codes.module_name')
                        ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_petty_cashes.id', '=', 'dong_fang_corporation_codes.module_id')
                        ->where('dong_fang_corporation_petty_cashes.id', $id)
                        ->where('dong_fang_corporation_codes.module_name', $moduleName)
                        ->get();

            
            $getPettyCashSummaries = DongFangCorporationPettyCash::where('pc_id', $id)->get()->toArray();

            //total
            $totalPettyCash = DongFangCorporationPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');
    
            $pettyCashSummaryTotal = DongFangCorporationPettyCash::where('pc_id', $id)->sum('amount');
    
            $sum = $totalPettyCash + $pettyCashSummaryTotal;
    
                
            return view('dong-fang-corporation-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
        
    }

    public function updatePC(Request $request, $id){
        $updatePC = DongFangCorporationPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');

        return redirect()->route('editPettyCashDongFang', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


        $addNew = new DongFangCorporationPettyCash([
            'user_id'=>$user->id,
            'pc_id'=>$id,
            'date'=>$request->get('date'),
            'petty_cash_summary'=>$request->get('pettyCashSummary'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]); 
        $addNew->save();

        Session::flash('addNewSuccess', 'Successfully added.');

        return redirect()->route('editPettyCashDongFang', ['id'=>$id]);
    }

    public function updatePettyCash(Request $request, $id){
        $update = DongFangCorporationPettyCash::find($id);
        $update->date = $request->get('date');
        $update->petty_cash_name = $request->get('pettyCashName');
        $update->petty_cash_summary = $request->get('pettyCashSummary');
        $update->amount = $request->get('amount');

        $update->save();
        Session::flash('editSuccess', 'Successfully updated.'); 

        return redirect()->route('editPettyCashDongFang', ['id'=>$id]);
    }

    public function editPettyCash($id){
        $moduleName = "Petty Cash";
        $pettyCash = DB::table(
                        'dong_fang_corporation_petty_cashes')
                        ->select( 
                        'dong_fang_corporation_petty_cashes.id',
                        'dong_fang_corporation_petty_cashes.user_id',
                        'dong_fang_corporation_petty_cashes.pc_id',
                        'dong_fang_corporation_petty_cashes.date',
                        'dong_fang_corporation_petty_cashes.petty_cash_name',
                        'dong_fang_corporation_petty_cashes.petty_cash_summary',
                        'dong_fang_corporation_petty_cashes.amount',
                        'dong_fang_corporation_petty_cashes.created_by',
                        'dong_fang_corporation_codes.dong_fang_code',
                        'dong_fang_corporation_codes.module_id',
                        'dong_fang_corporation_codes.module_code',
                        'dong_fang_corporation_codes.module_name')
                        ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_petty_cashes.id', '=', 'dong_fang_corporation_codes.module_id')
                        ->where('dong_fang_corporation_petty_cashes.id', $id)
                        ->where('dong_fang_corporation_codes.module_name', $moduleName)
                        ->get();
        
        $pettyCashSummaries = DongFangCorporationPettyCash::where('pc_id', $id)->get()->toArray();

        return view('edit-dong-fang-corporation-petty-cash', compact('pettyCash', 'pettyCashSummaries'));

    }

    public function addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table dong fang corporation codes
         $dataCashNo = DB::select('SELECT id, dong_fang_code FROM dong_fang_corporation_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
         if(isset($dataCashNo[0]->dong_fang_code) != 0){
             //if code is not 0
             $newProd = $dataCashNo[0]->dong_fang_code +1;
             $uPetty = sprintf("%06d",$newProd);   
 
         }else{
             //if code is 0 
             $newProd = 1;
             $uPetty = sprintf("%06d",$newProd);
         } 


         $addPettyCash = new DongFangCorporationPettyCash([
            'user_id'=>$user->id,
            'date'=>$request->date,
            'petty_cash_name'=>$request->pettyCashName,
            'petty_cash_summary'=>$request->pettyCashSummary,
            'created_by'=>$name,          
         ]);

         $addPettyCash->save();
         $insertId = $addPettyCash->id;


         $moduleCode = "PC-";
         $moduleName = "Petty Cash";
        
         $dongFang = new DongFangCorporationCode([
            'user_id'=>$user->id,
            'dong_fang_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
         ]);

         $dongFang->save();

         return response()->json($insertId);

    }

    public function pettyCashList(){
        $moduleName = "Petty Cash";
        $pettyCashLists = DB::table(
                        'dong_fang_corporation_petty_cashes')
                        ->select( 
                        'dong_fang_corporation_petty_cashes.id',
                        'dong_fang_corporation_petty_cashes.user_id',
                        'dong_fang_corporation_petty_cashes.pc_id',
                        'dong_fang_corporation_petty_cashes.date',
                        'dong_fang_corporation_petty_cashes.petty_cash_name',
                        'dong_fang_corporation_petty_cashes.petty_cash_summary',
                        'dong_fang_corporation_petty_cashes.amount',
                        'dong_fang_corporation_petty_cashes.created_by',
                        'dong_fang_corporation_petty_cashes.deleted_at',
                        'dong_fang_corporation_codes.dong_fang_code',
                        'dong_fang_corporation_codes.module_id',
                        'dong_fang_corporation_codes.module_code',
                        'dong_fang_corporation_codes.module_name')
                        ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_petty_cashes.id', '=', 'dong_fang_corporation_codes.module_id')
                        ->where('dong_fang_corporation_petty_cashes.pc_id', NUll)
                        ->where('dong_fang_corporation_codes.module_name', $moduleName)
                        ->where('dong_fang_corporation_petty_cashes.deleted_at', NULL)
                        ->orderBy('dong_fang_corporation_petty_cashes.id',  'desc')
                        ->get()->toArray();
        
        return view('dong-fang-corporation-petty-cash-list', compact('pettyCashLists'));
    }

    public function printPayablesDongFang($id){
    
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->join('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.id', $id)
                            ->where('dong_fang_corporation_codes.module_name', $moduleName)
                            ->get();


        //getParticular details
         $getParticulars = DongFangCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

         $getChequeNumbers = DongFangCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

         $getCashAmounts = DongFangCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
         
          $amount1 = DongFangCorporationPaymentVoucher::where('id', $id)->sum('amount');
          $amount2 = DongFangCorporationPaymentVoucher::where('pv_id', $id)->sum('amount');
            
          $sum = $amount1 + $amount2;
          
          //
          $chequeAmount1 = DongFangCorporationPaymentVoucher::where('id', $id)->sum('cheque_amount');
          $chequeAmount2 = DongFangCorporationPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
          
          $sumCheque = $chequeAmount1 + $chequeAmount2;
       

        $pdf = PDF::loadView('printPayablesDongFang', compact('payableId', 
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

        return $pdf->download('dong-fang-payment-voucher.pdf');
    }

    public function viewPayableDetails($id){
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->join('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.id', $id)
                            ->where('dong_fang_corporation_codes.module_name', $moduleName)
                            ->get();
     

        $getViewPaymentDetails = DongFangCorporationPaymentVoucher::where('pv_id', $id)->get()->toArray();

         //getParticular details
         $getParticulars = DongFangCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        return view('view-dong-fang-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
   
    }

    public function viewBillingStatement($id){
        $viewBillingStatement = DongFangCorporationBillingStatement::find($id);

        $billingStatements = DongFangCorporationBillingStatement::where('bs_id', $id)->get()->toArray();

        $billTotal = DongFangCorporationBillingStatement::where('id', $id)->sum('amount');
        $billTotal2 = DongFangCorporationBillingStatement::where('bs_id', $id)->sum('amount');

        $sum = $billTotal + $billTotal2;

        return view('view-dong-fang-corporation-billing-statement', compact('viewBillingStatement', 'billingStatements', 'sum'));
    }

    public function billingStatementList(){
        $billingLists = DongFangCorporationBillingStatement::where('bs_id', NULL)->get()->toArray();
        return view('dong-fang-corporation-billing-list', compact('billingLists'));
    }

    public function updateBL(Request $request, $id){
        $updateBilling = DongFangCorporationBillingStatement::find($id);
        $updateBilling->date_detail = $request->get('dateDetails');
        $updateBilling->no_pax = $request->get('noPax');
        $updateBilling->particular = $request->get('particular');
        $updateBilling->price_per_pax = $request->get('pricePerPax');
        $updateBilling->amount = $request->get('amount');
        $updateBilling->save();

        Session::flash('updateBilling', 'Successfully updated.');
        return redirect()->route('editBillingStatementDongFang', ['id'=>$request->get('bsId')]); 
    }

    public function addNewBillingStatement(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addNewBilling = new DongFangCorporationBillingStatement([
            'user_id'=>$user->id,
            'bs_id'=>$id,
            'date'=>$request->get('dateDetails'),
            'no_pax'=>$request->get('noPax'),
            'particular'=>$request->get('particular'),
            'price_per_pax'=>$request->get('pricePerPax'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNewBilling->save();
        Session::flash('billingsAdded', 'Successfully added.');
        return redirect()->route('editBillingStatementDongFang', ['id'=>$id]);

    }

    public function editBillingStatement($id){
        $billingStatement = DongFangCorporationBillingStatement::find($id);

        $billingLists = DongFangCorporationBillingStatement::where('bs_id', $id)->get()->toArray();
        return view('edit-dong-fang-billing-statement', compact('billingStatement', 'billingLists'));
    }

    public function storeBillingStamtement(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //validate
        $this->validate($request, [
            'accountNo' =>'required',
            'companyName'=>'required',
            'particular'=>'required',          
        ]);

        
        //check if invoice number already exists
        $target = DB::table(
            'dong_fang_corporation_billing_statements')
            ->where('account_no', $request->get('accountNo'))
            ->get()->first();

        if($target === NULL){
            $storeBilling = new DongFangCorporationBillingStatement([
                'user_id'=>$user->id,
                'date'=>$request->get('date'),
                'account_no'=>$request->get('accountNo'),
                'company_name'=>$request->get('companyName'),
                'address'=>$request->get('address'),
                'billing_statement_no'=>$request->get('billingStatementNo'),
                'attention'=>$request->get('attention'),
                'ref_no'=>$request->get('refNumber'),
                'po_no'=>$request->get('poNumber'),
                'terms'=>$request->get('terms'),
                'due_date'=>$request->get('dueDate'),
                'date_detail'=>$request->get('dateDetails'),
                'no_pax'=>$request->get('noPax'),
                'particular'=>$request->get('particular'),
                'price_per_pax'=>$request->get('pricePerPax'),
                'amount'=>$request->get('amount'),
                'created_by'=>$name,
            ]);
    
            $storeBilling->save();
            $insertedId = $storeBilling->id;
    
            return redirect()->route('editBillingStatementDongFang', ['id'=>$insertedId]);
        }else{
            return redirect()->route('billingStatementFormDongFang')->with('error', 'Account Number Already Exists. Please See Transaction List For Your Reference');

        }
       
    }

    public function billingStatementForm(){

        return view('dong-fang-billing-statement-form');
    }

    public function transactionList(){

        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_payment_vouchers.deleted_at',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dong_fang_corporation_codes.module_name', $moduleName)
                            ->where('dong_fang_corporation_payment_vouchers.deleted_at', NULL)
                            ->orderBy('dong_fang_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();
        

         //get total amount due
         $status = "FULLY PAID AND RELEASED";

         $totalAmountDue = DongFangCorporationPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

         
        return view('dong-fang-corporation-transaction-list', compact('getTransactionLists', 'totalAmountDue'));
    }

    public function addParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = DongFangCorporationPaymentVoucher::find($id);

         //add current amount
         $add = $particulars['amount_due'] + $request->get('amount');

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $addParticulars = new DongFangCorporationPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'date'=>$request->get('date'),
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
         return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);
    }

    public function addPayment(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = DongFangCorporationPaymentVoucher::find($id);
        
        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');

        //save payment cheque num and cheque amount
         $addPayment = new DongFangCorporationPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'date'=>$request->get('date'),
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
        
        return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);

    }

    public function accept(Request $request, $id){
         //get the status 
         $status = $request->get('status');
         if($status == "FULLY PAID AND RELEASED"){
             switch ($request->get('action')) {
                 case 'PAID AND RELEASE':
                     # code...
                     $payables = DongFangCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                     Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');
 
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
 
         }else if($status == "FOR APPROVAL"){
             switch ($request->get('action')) {
                 case 'PAID & HOLD':
                     # code...
                     $payables = DongFangCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                      Session::flash('payablesSuccess', 'Status set for approval.');
 
                      return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);
 
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
         }else{
 
             switch ($request->get('action')) {
                 case 'PAID & HOLD':
                     # code...
                     $payables = DongFangCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                     Session::flash('payablesSuccess', 'Status set for confirmation.');
 
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);
                     
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
         }  
    }

    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'dong_fang_corporation_payment_vouchers')
                            ->select( 
                            'dong_fang_corporation_payment_vouchers.id',
                            'dong_fang_corporation_payment_vouchers.user_id',
                            'dong_fang_corporation_payment_vouchers.pv_id',
                            'dong_fang_corporation_payment_vouchers.date',
                            'dong_fang_corporation_payment_vouchers.paid_to',
                            'dong_fang_corporation_payment_vouchers.account_no',
                            'dong_fang_corporation_payment_vouchers.account_name',
                            'dong_fang_corporation_payment_vouchers.particulars',
                            'dong_fang_corporation_payment_vouchers.amount',
                            'dong_fang_corporation_payment_vouchers.method_of_payment',
                            'dong_fang_corporation_payment_vouchers.prepared_by',
                            'dong_fang_corporation_payment_vouchers.approved_by',
                            'dong_fang_corporation_payment_vouchers.date_approved',
                            'dong_fang_corporation_payment_vouchers.received_by_date',
                            'dong_fang_corporation_payment_vouchers.created_by',
                            'dong_fang_corporation_payment_vouchers.invoice_number',
                            'dong_fang_corporation_payment_vouchers.voucher_ref_number',
                            'dong_fang_corporation_payment_vouchers.issued_date',
                            'dong_fang_corporation_payment_vouchers.category',
                            'dong_fang_corporation_payment_vouchers.amount_due',
                            'dong_fang_corporation_payment_vouchers.delivered_date',
                            'dong_fang_corporation_payment_vouchers.status',
                            'dong_fang_corporation_payment_vouchers.cheque_number',
                            'dong_fang_corporation_payment_vouchers.cheque_amount',
                            'dong_fang_corporation_payment_vouchers.sub_category',
                            'dong_fang_corporation_payment_vouchers.sub_category_account_id',
                            'dong_fang_corporation_codes.dong_fang_code',
                            'dong_fang_corporation_codes.module_id',
                            'dong_fang_corporation_codes.module_code',
                            'dong_fang_corporation_codes.module_name')
                            ->leftJoin('dong_fang_corporation_codes', 'dong_fang_corporation_payment_vouchers.id', '=', 'dong_fang_corporation_codes.module_id')
                            ->where('dong_fang_corporation_payment_vouchers.id', $id)
                            ->where('dong_fang_corporation_codes.module_name', $moduleName)
                            ->get();
    

        $getChequeNumbers = DongFangCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = DongFangCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
      

        //getParticular details
        $getParticulars = DongFangCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        //amount
        $amount1 = DongFangCorporationPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DongFangCorporationPaymentVoucher::where('pv_id', $id)->sum('amount');
           
        $sum = $amount1 + $amount2;

        $chequeAmount1 = DongFangCorporationPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DongFangCorporationPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('dong-fang-corporation-payables-detail', compact('transactionList', 'getParticulars', 'sum', 
        'getChequeNumbers', 'sumCheque', 'getCashAmounts'));
    }

    public function paymentVoucherStore(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table payment voucher ref number
        $dataVoucherRef = DB::select('SELECT id, dong_fang_code FROM dong_fang_corporation_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->dong_fang_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->dong_fang_code +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
        }

        
        if($request->get('category') == "Petty Cash"){
            $subCat = $request->get('pettyCashNo');
            $supplierExp = NULL;
        }else if($request->get('category') == "Payroll"){
            $subCat = NULL;
            $supplierExp = NULL;
        }else if($request->get('category') == "None"){
            $subCat = NULL;
            $supplierExp = NULL;
        }else if($request->get('category') == "Supplier"){
            $supplier = $request->get('supplierName');
            $supplierExp = explode("-", $supplier);

            $subCat = "NULL";
       }


        //check if invoice number already exists
        $target = DB::table(
            'dong_fang_corporation_payment_vouchers')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();
        
        if($target === NULL){
            $addPaymentVoucher = new DongFangCorporationPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'account_name'=>$request->get('accountName'),
                'method_of_payment'=>$request->get('paymentMethod'),
                'issued_date'=>$request->get('issuedDate'),
                'delivered_date'=>$request->get('deliveredDate'),
                'amount'=>$request->get('amount'),
                'amount_due'=>$request->get('amount'),
                'particulars'=>$request->get('particulars'),
                'category'=>$request->get('category'),
                'sub_category'=>$subCat,
                'supplier_id'=>$supplierExp[0],
                'supplier_name'=>$supplierExp[1],  
                'prepared_by'=>$name,
                'created_by'=>$name,
            ]);
            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;

            $moduleCode = "PV-";
            $moduleName = "Payment Voucher";

            $dongFang = new DongFangCorporationCode([
                'user_id'=>$user->id,
                'dong_fang_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);
            $dongFang->save();
            
            return redirect()->route('editPayablesDetailDongFang', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormDongFang')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');

        }

    }

    public function paymentVoucherForm(){
        $moduleName = "Petty Cash";
        $pettyCashes = DB::table(
                                'dong_fang_corporation_petty_cashes')
                                ->select( 
                                'dong_fang_corporation_petty_cashes.id',
                                'dong_fang_corporation_petty_cashes.user_id',
                                'dong_fang_corporation_petty_cashes.pc_id',
                                'dong_fang_corporation_petty_cashes.date',
                                'dong_fang_corporation_petty_cashes.petty_cash_name',
                                'dong_fang_corporation_petty_cashes.petty_cash_summary',
                                'dong_fang_corporation_petty_cashes.amount',
                                'dong_fang_corporation_petty_cashes.created_by',
                                'dong_fang_corporation_codes.dong_fang_code',
                                'dong_fang_corporation_codes.module_id',
                                'dong_fang_corporation_codes.module_code',
                                'dong_fang_corporation_codes.module_name')
                                ->join('dong_fang_corporation_codes', 'dong_fang_corporation_petty_cashes.id', '=', 'dong_fang_corporation_codes.module_id')
                                ->where('dong_fang_corporation_petty_cashes.pc_id', NULL)
                                ->where('dong_fang_corporation_codes.module_name', $moduleName)
                                ->get()->toArray();
        
        //get suppliers
         $suppliers = DongFangCorporationSupplier::get()->toArray(); 
        
         return view('payment-voucher-form-dong-fang-corp', compact('pettyCashes', 'suppliers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('dong-fang-corporation');
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

    public function destroyPettyCash($id){
        $pettyCash  = DongFangCorporationPettyCash::find($id);
        $pettyCash->delete();
    }

    public function destroyBillingStatment($id){
        $billingStatement = DongFangCorporationBillingStatement::find($id);
        $billingStatement->delete();
    }

    public function destroyTransaction($id){
        $transactionList = DongFangCorporationPaymentVoucher::find($id);
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
