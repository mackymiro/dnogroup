<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use PDF;
use App\User;
use App\DinoIndustrialCorporationPaymentVoucher; 
use App\DinoIndustrialCorporationCode;
use App\DinoIndustrialCorporationSupplier;


class DinoIndustrialCorporationController extends Controller
{

    public function printSupplier($id){
        $viewSupplier = DinoIndustrialCorporationSupplier::where('id', $id)->get();

        $printSuppliers = DB::table(
            'dino_industrial_corporation_payment_vouchers')
            ->select( 
            'dino_industrial_corporation_payment_vouchers.id',
            'dino_industrial_corporation_payment_vouchers.user_id',
            'dino_industrial_corporation_payment_vouchers.pv_id',
            'dino_industrial_corporation_payment_vouchers.date',
            'dino_industrial_corporation_payment_vouchers.paid_to',
            'dino_industrial_corporation_payment_vouchers.account_no',
            'dino_industrial_corporation_payment_vouchers.account_name',
            'dino_industrial_corporation_payment_vouchers.particulars',
            'dino_industrial_corporation_payment_vouchers.amount',
            'dino_industrial_corporation_payment_vouchers.method_of_payment',
            'dino_industrial_corporation_payment_vouchers.prepared_by',
            'dino_industrial_corporation_payment_vouchers.approved_by',
            'dino_industrial_corporation_payment_vouchers.date_approved',
            'dino_industrial_corporation_payment_vouchers.received_by_date',
            'dino_industrial_corporation_payment_vouchers.created_by',
            'dino_industrial_corporation_payment_vouchers.created_at',
            'dino_industrial_corporation_payment_vouchers.invoice_number',
            'dino_industrial_corporation_payment_vouchers.issued_date',
            'dino_industrial_corporation_payment_vouchers.category',
            'dino_industrial_corporation_payment_vouchers.amount_due',
            'dino_industrial_corporation_payment_vouchers.delivered_date',
            'dino_industrial_corporation_payment_vouchers.status',
            'dino_industrial_corporation_payment_vouchers.cheque_number',
            'dino_industrial_corporation_payment_vouchers.cheque_amount',
            'dino_industrial_corporation_payment_vouchers.sub_category',
            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
            'dino_industrial_corporation_payment_vouchers.supplier_name',
            'dino_industrial_corporation_payment_vouchers.deleted_at', 
            'dino_industrial_corporation_suppliers.id',
            'dino_industrial_corporation_suppliers.date',
            'dino_industrial_corporation_suppliers.supplier_name')
            ->leftJoin('dino_industrial_corporation_suppliers', 'dino_industrial_corporation_payment_vouchers.supplier_id', '=', 'dino_industrial_corporation_suppliers.id')
            ->where('dino_industrial_corporation_suppliers.id', $id)     
            ->get();

    $status = "FULLY PAID AND RELEASED"; 
    $totalAmountDue = DB::table(
                'dino_industrial_corporation_payment_vouchers')
                ->select( 
                'dino_industrial_corporation_payment_vouchers.id',
                'dino_industrial_corporation_payment_vouchers.user_id',
                'dino_industrial_corporation_payment_vouchers.pv_id',
                'dino_industrial_corporation_payment_vouchers.date',
                'dino_industrial_corporation_payment_vouchers.paid_to',
                'dino_industrial_corporation_payment_vouchers.account_no',
                'dino_industrial_corporation_payment_vouchers.account_name',
                'dino_industrial_corporation_payment_vouchers.particulars',
                'dino_industrial_corporation_payment_vouchers.amount',
                'dino_industrial_corporation_payment_vouchers.method_of_payment',
                'dino_industrial_corporation_payment_vouchers.prepared_by',
                'dino_industrial_corporation_payment_vouchers.approved_by',
                'dino_industrial_corporation_payment_vouchers.date_approved',
                'dino_industrial_corporation_payment_vouchers.received_by_date',
                'dino_industrial_corporation_payment_vouchers.created_by',
                'dino_industrial_corporation_payment_vouchers.created_at',
                'dino_industrial_corporation_payment_vouchers.invoice_number',
                'dino_industrial_corporation_payment_vouchers.issued_date',
                'dino_industrial_corporation_payment_vouchers.category',
                'dino_industrial_corporation_payment_vouchers.amount_due',
                'dino_industrial_corporation_payment_vouchers.delivered_date',
                'dino_industrial_corporation_payment_vouchers.status',
                'dino_industrial_corporation_payment_vouchers.cheque_number',
                'dino_industrial_corporation_payment_vouchers.cheque_amount',
                'dino_industrial_corporation_payment_vouchers.sub_category',
                'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                'dino_industrial_corporation_payment_vouchers.supplier_name',
                'dino_industrial_corporation_payment_vouchers.deleted_at', 
                'dino_industrial_corporation_suppliers.id',
                'dino_industrial_corporation_suppliers.date',
                'dino_industrial_corporation_suppliers.supplier_name')
                ->leftJoin('dino_industrial_corporation_suppliers', 'dino_industrial_corporation_payment_vouchers.supplier_id', '=', 'dino_industrial_corporation_suppliers.id')
                ->where('dino_industrial_corporation_suppliers.id', $id)     
                ->where('dino_industrial_corporation_payment_vouchers.status', '!=', $status)
                ->sum('dino_industrial_corporation_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSupplierDIC', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('dino-industrial-corporation-supplier.pdf');

    }

    public function viewSupplier($id){
        $viewSupplier = DinoIndustrialCorporationSupplier::where('id', $id)->get();

        $supplierLists = DB::table(
                    'dino_industrial_corporation_payment_vouchers')
                    ->select( 
                    'dino_industrial_corporation_payment_vouchers.id',
                    'dino_industrial_corporation_payment_vouchers.user_id',
                    'dino_industrial_corporation_payment_vouchers.pv_id',
                    'dino_industrial_corporation_payment_vouchers.date',
                    'dino_industrial_corporation_payment_vouchers.paid_to',
                    'dino_industrial_corporation_payment_vouchers.account_no',
                    'dino_industrial_corporation_payment_vouchers.account_name',
                    'dino_industrial_corporation_payment_vouchers.particulars',
                    'dino_industrial_corporation_payment_vouchers.amount',
                    'dino_industrial_corporation_payment_vouchers.method_of_payment',
                    'dino_industrial_corporation_payment_vouchers.prepared_by',
                    'dino_industrial_corporation_payment_vouchers.approved_by',
                    'dino_industrial_corporation_payment_vouchers.date_approved',
                    'dino_industrial_corporation_payment_vouchers.received_by_date',
                    'dino_industrial_corporation_payment_vouchers.created_by',
                    'dino_industrial_corporation_payment_vouchers.created_at',
                    'dino_industrial_corporation_payment_vouchers.invoice_number',
                    'dino_industrial_corporation_payment_vouchers.issued_date',
                    'dino_industrial_corporation_payment_vouchers.category',
                    'dino_industrial_corporation_payment_vouchers.amount_due',
                    'dino_industrial_corporation_payment_vouchers.delivered_date',
                    'dino_industrial_corporation_payment_vouchers.status',
                    'dino_industrial_corporation_payment_vouchers.cheque_number',
                    'dino_industrial_corporation_payment_vouchers.cheque_amount',
                    'dino_industrial_corporation_payment_vouchers.sub_category',
                    'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                    'dino_industrial_corporation_payment_vouchers.supplier_name',
                    'dino_industrial_corporation_payment_vouchers.deleted_at', 
                    'dino_industrial_corporation_suppliers.date',
                    'dino_industrial_corporation_suppliers.supplier_name')
                    ->leftJoin('dino_industrial_corporation_suppliers', 'dino_industrial_corporation_payment_vouchers.supplier_id', '=', 'dino_industrial_corporation_suppliers.id')
                    ->where('dino_industrial_corporation_suppliers.id', $id)     
                    ->get();

        $status = "FULLY PAID AND RELEASED"; 
        $totalAmountDue = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.supplier_name',
                        'dino_industrial_corporation_payment_vouchers.deleted_at', 
                        'dino_industrial_corporation_suppliers.id',
                        'dino_industrial_corporation_suppliers.date',
                        'dino_industrial_corporation_suppliers.supplier_name')
                        ->leftJoin('dino_industrial_corporation_suppliers', 'dino_industrial_corporation_payment_vouchers.supplier_id', '=', 'dino_industrial_corporation_suppliers.id')
                        ->where('dino_industrial_corporation_suppliers.id', $id)     
                        ->where('dino_industrial_corporation_payment_vouchers.status', '!=', $status)
                        ->sum('dino_industrial_corporation_payment_vouchers.amount_due');

        return view('view-dino-industrial-corporation-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue')); 

    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //check if supplier name exits
        $target = DB::table(
            'dino_industrial_corporation_suppliers')
            ->where('supplier_name', $request->supplierName)
            ->get()->first();

        if($target === NULL){
            $supplier = new DinoIndustrialCorporationSupplier([
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
        $suppliers = DinoIndustrialCorporationSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('dino-industrial-corporation-supplier', compact('suppliers'));
    }

    public function updateDetails(Request $request){
        $updateDetail = DinoIndustrialCorporationPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = DinoIndustrialCorporationPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = DinoIndustrialCorporationPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
         //main id 
         $updateParticular = DinoIndustrialCorporationPaymentVoucher::find($request->transId);

         //particular id
         $uIdParticular = DinoIndustrialCorporationPaymentVoucher::find($request->id);

         $amount = $request->amount; 

         $updateAmount =  $updateParticular->amount; 
        
         $uParticular = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
         
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
        $updateParticular =  DinoIndustrialCorporationPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
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

        $moduleName = "Payment Voucher";

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at', 
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                        ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$uri0, $uri1])      
                        ->get();
            
        $totalAmountCashes = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                            ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$uri0, $uri1]) 
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');
        
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.cheque_total_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$uri0, $uri1]) 
                        ->get();
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                            ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$uri0, $uri1]) 
                            ->where('dino_industrial_corporation_payment_vouchers.status', '!=', $status)
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');
            
        $totalPaidAmountCheck = DB::table(
                                'dino_industrial_corporation_payment_vouchers')
                                ->select( 
                                'dino_industrial_corporation_payment_vouchers.id',
                                'dino_industrial_corporation_payment_vouchers.user_id',
                                'dino_industrial_corporation_payment_vouchers.pv_id',
                                'dino_industrial_corporation_payment_vouchers.date',
                                'dino_industrial_corporation_payment_vouchers.paid_to',
                                'dino_industrial_corporation_payment_vouchers.account_no',
                                'dino_industrial_corporation_payment_vouchers.account_name',
                                'dino_industrial_corporation_payment_vouchers.particulars',
                                'dino_industrial_corporation_payment_vouchers.amount',
                                'dino_industrial_corporation_payment_vouchers.method_of_payment',
                                'dino_industrial_corporation_payment_vouchers.prepared_by',
                                'dino_industrial_corporation_payment_vouchers.approved_by',
                                'dino_industrial_corporation_payment_vouchers.date_approved',
                                'dino_industrial_corporation_payment_vouchers.received_by_date',
                                'dino_industrial_corporation_payment_vouchers.created_by',
                                'dino_industrial_corporation_payment_vouchers.created_at',
                                'dino_industrial_corporation_payment_vouchers.invoice_number',
                                'dino_industrial_corporation_payment_vouchers.issued_date',
                                'dino_industrial_corporation_payment_vouchers.category',
                                'dino_industrial_corporation_payment_vouchers.amount_due',
                                'dino_industrial_corporation_payment_vouchers.delivered_date',
                                'dino_industrial_corporation_payment_vouchers.status',
                                'dino_industrial_corporation_payment_vouchers.cheque_number',
                                'dino_industrial_corporation_payment_vouchers.cheque_amount',
                                'dino_industrial_corporation_payment_vouchers.cheque_total_amount',
                                'dino_industrial_corporation_payment_vouchers.sub_category',
                                'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                                'dino_industrial_corporation_payment_vouchers.deleted_at',
                                'dino_industrial_corporation_codes.dic_code',
                                'dino_industrial_corporation_codes.module_id',
                                'dino_industrial_corporation_codes.module_code',
                                'dino_industrial_corporation_codes.module_name')
                                ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                                ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                                ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                                ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$uri0, $uri1]) 
                                ->where('dino_industrial_corporation_payment_vouchers.status', $status)
                                ->sum('dino_industrial_corporation_payment_vouchers.cheque_total_amount');

        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryDIC',  compact('date', 'getDateToday', 'uri0', 'uri1',
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('dic-summary-report.pdf');   

    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                            ->orderBy('dino_industrial_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                        ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                        ->get();
            
        $totalAmountCashes = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                            ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');
        
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.cheque_total_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                        ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                            ->where('dino_industrial_corporation_payment_vouchers.status', '!=', $status)
                            ->whereBetween('dino_industrial_corporation_payment_vouchers.created_at', [$startDate, $endDate])
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');

        return view('dino-industrial-multiple-summary-report', compact('getTransactionLists', 'startDate', 'endDate',
        'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 
        'totalAmountCheck'));


    }   

    public function search(Request $request){
        $getSearchResults =DinoIndustrialCorporationCode::where('dic_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.id', $getSearchResults[0]->module_id)
                        ->where('dino_industrial_corporation_codes.module_name', $getSearchResults[0]->module_name)
                        
                        ->get()->toArray();
            
                              
            $getAllCodes = DinoIndustrialCorporationCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('dino-industrial-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
                

        }
    }

    public function searchNumberCode(){
        $getAllCodes = DinoIndustrialCorporationCode::get()->toArray();
        return view('dino-industrial-search-number-code', compact('getAllCodes'));
    }

    public function printGetSummary($date){
        $moduleName = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($date))
                            
                        ->get();
            
        $totalAmountCashes = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($date))
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');
        
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.cheque_total_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($date))
                        ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($date))
                            ->where('dino_industrial_corporation_payment_vouchers.status', '!=', $status)
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');
        
    $totalPaidAmountCheck = DB::table(
                                'dino_industrial_corporation_payment_vouchers')
                                ->select( 
                                'dino_industrial_corporation_payment_vouchers.id',
                                'dino_industrial_corporation_payment_vouchers.user_id',
                                'dino_industrial_corporation_payment_vouchers.pv_id',
                                'dino_industrial_corporation_payment_vouchers.date',
                                'dino_industrial_corporation_payment_vouchers.paid_to',
                                'dino_industrial_corporation_payment_vouchers.account_no',
                                'dino_industrial_corporation_payment_vouchers.account_name',
                                'dino_industrial_corporation_payment_vouchers.particulars',
                                'dino_industrial_corporation_payment_vouchers.amount',
                                'dino_industrial_corporation_payment_vouchers.method_of_payment',
                                'dino_industrial_corporation_payment_vouchers.prepared_by',
                                'dino_industrial_corporation_payment_vouchers.approved_by',
                                'dino_industrial_corporation_payment_vouchers.date_approved',
                                'dino_industrial_corporation_payment_vouchers.received_by_date',
                                'dino_industrial_corporation_payment_vouchers.created_by',
                                'dino_industrial_corporation_payment_vouchers.created_at',
                                'dino_industrial_corporation_payment_vouchers.invoice_number',
                                'dino_industrial_corporation_payment_vouchers.issued_date',
                                'dino_industrial_corporation_payment_vouchers.category',
                                'dino_industrial_corporation_payment_vouchers.amount_due',
                                'dino_industrial_corporation_payment_vouchers.delivered_date',
                                'dino_industrial_corporation_payment_vouchers.status',
                                'dino_industrial_corporation_payment_vouchers.cheque_number',
                                'dino_industrial_corporation_payment_vouchers.cheque_amount',
                                'dino_industrial_corporation_payment_vouchers.cheque_total_amount',
                                'dino_industrial_corporation_payment_vouchers.sub_category',
                                'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                                'dino_industrial_corporation_payment_vouchers.deleted_at',
                                'dino_industrial_corporation_codes.dic_code',
                                'dino_industrial_corporation_codes.module_id',
                                'dino_industrial_corporation_codes.module_code',
                                'dino_industrial_corporation_codes.module_name')
                                ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                                ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                                ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                                ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($date))
                                ->where('dino_industrial_corporation_payment_vouchers.status',  $status)
                                ->sum('dino_industrial_corporation_payment_vouchers.cheque_total_amount');
        $getDateToday = "";
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryDIC',  compact('date', 'getDateToday', 'uri0', 'uri1',
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('dic-summary-report.pdf');      

    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');

        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDate))
                            ->orderBy('dino_industrial_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDate))
                           
                        ->get();
            
        $totalAmountCashes = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDate))
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');
        
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.cheque_total_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDate))
                           
                        ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDate))
                            ->where('dino_industrial_corporation_payment_vouchers.status', '!=', $status)
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');

        return view('dino-industrial-get-summary-report', compact('getDate', 'getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 
        'totalAmountCheck'));

    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");
        $moduleName = "Payment Voucher";

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at', 
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            
                        ->get();
            
        $totalAmountCashes = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');
        
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.cheque_total_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                        ->get();
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dino_industrial_corporation_payment_vouchers.status', '!=', $status)
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');
            
        $totalPaidAmountCheck = DB::table(
                                'dino_industrial_corporation_payment_vouchers')
                                ->select( 
                                'dino_industrial_corporation_payment_vouchers.id',
                                'dino_industrial_corporation_payment_vouchers.user_id',
                                'dino_industrial_corporation_payment_vouchers.pv_id',
                                'dino_industrial_corporation_payment_vouchers.date',
                                'dino_industrial_corporation_payment_vouchers.paid_to',
                                'dino_industrial_corporation_payment_vouchers.account_no',
                                'dino_industrial_corporation_payment_vouchers.account_name',
                                'dino_industrial_corporation_payment_vouchers.particulars',
                                'dino_industrial_corporation_payment_vouchers.amount',
                                'dino_industrial_corporation_payment_vouchers.method_of_payment',
                                'dino_industrial_corporation_payment_vouchers.prepared_by',
                                'dino_industrial_corporation_payment_vouchers.approved_by',
                                'dino_industrial_corporation_payment_vouchers.date_approved',
                                'dino_industrial_corporation_payment_vouchers.received_by_date',
                                'dino_industrial_corporation_payment_vouchers.created_by',
                                'dino_industrial_corporation_payment_vouchers.created_at',
                                'dino_industrial_corporation_payment_vouchers.invoice_number',
                                'dino_industrial_corporation_payment_vouchers.issued_date',
                                'dino_industrial_corporation_payment_vouchers.category',
                                'dino_industrial_corporation_payment_vouchers.amount_due',
                                'dino_industrial_corporation_payment_vouchers.delivered_date',
                                'dino_industrial_corporation_payment_vouchers.status',
                                'dino_industrial_corporation_payment_vouchers.cheque_number',
                                'dino_industrial_corporation_payment_vouchers.cheque_amount',
                                'dino_industrial_corporation_payment_vouchers.cheque_total_amount',
                                'dino_industrial_corporation_payment_vouchers.sub_category',
                                'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                                'dino_industrial_corporation_payment_vouchers.deleted_at',
                                'dino_industrial_corporation_codes.dic_code',
                                'dino_industrial_corporation_codes.module_id',
                                'dino_industrial_corporation_codes.module_code',
                                'dino_industrial_corporation_codes.module_name')
                                ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                                ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                                ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                                ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                                ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                                ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dino_industrial_corporation_payment_vouchers.status', $status)
                                ->sum('dino_industrial_corporation_payment_vouchers.cheque_total_amount');
        
        $uri0 = "";
        $uri1 = "";

        $pdf = PDF::loadView('printSummaryDIC',  compact('uri0', 'uri1', 'date', 'getDateToday', 
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('dic-summary-report.pdf');      

    }

    public function summaryReport(){
        $getDateToday = date("Y-m-d");

        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->orderBy('dino_industrial_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                        ->get();
            
        $totalAmountCashes = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');
        
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'dino_industrial_corporation_payment_vouchers')
                        ->select( 
                        'dino_industrial_corporation_payment_vouchers.id',
                        'dino_industrial_corporation_payment_vouchers.user_id',
                        'dino_industrial_corporation_payment_vouchers.pv_id',
                        'dino_industrial_corporation_payment_vouchers.date',
                        'dino_industrial_corporation_payment_vouchers.paid_to',
                        'dino_industrial_corporation_payment_vouchers.account_no',
                        'dino_industrial_corporation_payment_vouchers.account_name',
                        'dino_industrial_corporation_payment_vouchers.particulars',
                        'dino_industrial_corporation_payment_vouchers.amount',
                        'dino_industrial_corporation_payment_vouchers.method_of_payment',
                        'dino_industrial_corporation_payment_vouchers.prepared_by',
                        'dino_industrial_corporation_payment_vouchers.approved_by',
                        'dino_industrial_corporation_payment_vouchers.date_approved',
                        'dino_industrial_corporation_payment_vouchers.received_by_date',
                        'dino_industrial_corporation_payment_vouchers.created_by',
                        'dino_industrial_corporation_payment_vouchers.created_at',
                        'dino_industrial_corporation_payment_vouchers.invoice_number',
                        'dino_industrial_corporation_payment_vouchers.issued_date',
                        'dino_industrial_corporation_payment_vouchers.category',
                        'dino_industrial_corporation_payment_vouchers.amount_due',
                        'dino_industrial_corporation_payment_vouchers.delivered_date',
                        'dino_industrial_corporation_payment_vouchers.status',
                        'dino_industrial_corporation_payment_vouchers.cheque_number',
                        'dino_industrial_corporation_payment_vouchers.cheque_amount',
                        'dino_industrial_corporation_payment_vouchers.cheque_total_amount',
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_payment_vouchers.deleted_at',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                        ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.created_at',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                            ->where('dino_industrial_corporation_payment_vouchers.status', '!=', $status)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');

        return view('dino-industrial-summary-report', compact('getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 
                'totalAmountCheck'));
      
    }

    public function printPayables($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.id', $id)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->get();


            //getParticular details
            $getParticulars = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

            $getChequeNumbers = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

            $getCashAmounts = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
            
             $amount1 = DinoIndustrialCorporationPaymentVoucher::where('id', $id)->sum('amount');
             $amount2 = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->sum('amount');
               
             $sum = $amount1 + $amount2;
             
             //
             $chequeAmount1 = DinoIndustrialCorporationPaymentVoucher::where('id', $id)->sum('cheque_amount');
             $chequeAmount2 = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
             
             $sumCheque = $chequeAmount1 + $chequeAmount2;
          
            
            $pdf = PDF::loadView('printPayablesDINOIndustrial', compact('payableId', 
            'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

            return $pdf->download('dino-industrial-corporation-payment-voucher.pdf');
    }

    public function viewPayableDetails($id){
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.id', $id)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->get();
              //
        $getViewPaymentDetails = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //getParticular details
        $getParticulars = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
                                
        return view('view-dino-industrial-payable-details',compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));

    }

    public function accept(Request $request, $id){
          //get the status 
          $status = $request->get('status');
          if($status == "FULLY PAID AND RELEASED"){
              switch ($request->get('action')) {
                  case 'PAID AND RELEASE':
                      # code...
                      $payables = DinoIndustrialCorporationPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                      Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');
  
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
  
          }else if($status == "FOR APPROVAL"){
              switch ($request->get('action')) {
                  case 'PAID & HOLD':
                      # code...
                      $payables = DinoIndustrialCorporationPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                       Session::flash('payablesSuccess', 'Status set for approval.');
  
                       return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);
  
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
          }else{
  
              switch ($request->get('action')) {
                  case 'PAID & HOLD':
                      # code...
                      $payables = DinoIndustrialCorporationPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                      Session::flash('payablesSuccess', 'Status set for confirmation.');
  
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);
                      
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
          }  
    }

    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        $paymentData = DinoIndustrialCorporationPaymentVoucher::find($id);
        
        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');
         
        //save payment cheque num and cheque amount
         $addPayment = new DinoIndustrialCorporationPaymentVoucher([
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

        return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);
    }

    public function addParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = DinoIndustrialCorporationPaymentVoucher::find($id);

        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');


        $addParticulars = new DinoIndustrialCorporationPaymentVoucher([
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

         return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);

    }

    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_payment_vouchers.deleted_at',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.deleted_at', NULL)
                            ->orderBy('dino_industrial_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();
      

        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmountDue = DinoIndustrialCorporationPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('dino-industrial-transaction-list', compact('getTransactionLists', 'totalAmountDue'));

    }

    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'dino_industrial_corporation_payment_vouchers')
                            ->select( 
                            'dino_industrial_corporation_payment_vouchers.id',
                            'dino_industrial_corporation_payment_vouchers.user_id',
                            'dino_industrial_corporation_payment_vouchers.pv_id',
                            'dino_industrial_corporation_payment_vouchers.date',
                            'dino_industrial_corporation_payment_vouchers.paid_to',
                            'dino_industrial_corporation_payment_vouchers.account_no',
                            'dino_industrial_corporation_payment_vouchers.account_name',
                            'dino_industrial_corporation_payment_vouchers.particulars',
                            'dino_industrial_corporation_payment_vouchers.amount',
                            'dino_industrial_corporation_payment_vouchers.method_of_payment',
                            'dino_industrial_corporation_payment_vouchers.prepared_by',
                            'dino_industrial_corporation_payment_vouchers.approved_by',
                            'dino_industrial_corporation_payment_vouchers.date_approved',
                            'dino_industrial_corporation_payment_vouchers.received_by_date',
                            'dino_industrial_corporation_payment_vouchers.created_by',
                            'dino_industrial_corporation_payment_vouchers.invoice_number',
                            'dino_industrial_corporation_payment_vouchers.issued_date',
                            'dino_industrial_corporation_payment_vouchers.category',
                            'dino_industrial_corporation_payment_vouchers.amount_due',
                            'dino_industrial_corporation_payment_vouchers.delivered_date',
                            'dino_industrial_corporation_payment_vouchers.status',
                            'dino_industrial_corporation_payment_vouchers.cheque_number',
                            'dino_industrial_corporation_payment_vouchers.cheque_amount',
                            'dino_industrial_corporation_payment_vouchers.sub_category',
                            'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.id', $id)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->get();


        $getChequeNumbers = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
      
        //getParticular details
        $getParticulars = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
          //amount
        $amount1 = DinoIndustrialCorporationPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;

        $chequeAmount1 = DinoIndustrialCorporationPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('dino-industrial-payables-detail', compact('transactionList', 'getParticulars', 'sum' , 
        'getChequeNumbers', 'sumCheque', 'getCashAmounts'));
    }

    public function paymentVoucherStore(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the latest insert id query in table dino industrial code
        $dataVoucherRef = DB::select('SELECT id, dic_code FROM dino_industrial_corporation_codes ORDER BY id DESC LIMIT 1');
        
        //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->dic_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->dic_code +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
        } 

        if($request->get('category') == "Petty Cash"){
            $subCat = $request->get('pettyCashNo');
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') == "Payroll"){
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
       }else if($request->get('category') == "Utility"){
            $subCat = NULL;
            $supplierExp = NULL;
            $supplierExp1 = NULL;
       }

           //check if invoice number already exists
           $target = DB::table(
            'dino_industrial_corporation_payment_vouchers')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        if($target === NULL){
            $addPaymentVoucher = new DinoIndustrialCorporationPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'method_of_payment'=>$request->get('paymentMethod'),
                'account_name'=>$request->get('accountName'),
                'issued_date'=>$request->get('issuedDate'),
                'delivered_date'=>$request->get('deliveredDate'),
                'amount'=>$request->get('amount'),
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

            $dic = new DinoIndustrialCorporationCode([
                'user_id'=>$user->id,
                'dic_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);

            $dic->save();

            return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormDinoIndustrial')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');

        }

    }

    public function paymentVoucherForm(){
          //get suppliers
        $suppliers = DinoIndustrialCorporationSupplier::get()->toArray(); 

        return view('payment-voucher-form-dino-industrial-corp', compact('suppliers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dino-industrial-corporation');
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
        $transactionList = DinoIndustrialCorporationPaymentVoucher::find($id);
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
