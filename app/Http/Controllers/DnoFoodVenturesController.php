<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF; 
use Session;
use Auth; 
use App\User;
use App\DnoFoodVenturesPaymentVoucher;
use App\DnoFoodVenturesCode;


class DnoFoodVenturesController extends Controller
{
    public function updateDetails(Request $request){
        $updateDetail = DnoFoodVenturesPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){       
        $updateCash = DnoFoodVenturesPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }   

    public function updateCheck(Request $request){
        $updateCheck = DnoFoodVenturesPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){      
         //main id 
         $updateParticular = DnoFoodVenturesPaymentVoucher::find($request->transId);

         //particular id
         $uIdParticular = DnoFoodVenturesPaymentVoucher::find($request->id);

         $amount = $request->amount; 

         $updateAmount =  $updateParticular->amount; 
        
         $uParticular = DnoFoodVenturesPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
         
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
        $updateParticular =  DnoFoodVenturesPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = DnoFoodVenturesPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
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
                        'dno_food_ventures_payment_vouchers')
                        ->select( 
                        'dno_food_ventures_payment_vouchers.id',
                        'dno_food_ventures_payment_vouchers.user_id',
                        'dno_food_ventures_payment_vouchers.pv_id',
                        'dno_food_ventures_payment_vouchers.date',
                        'dno_food_ventures_payment_vouchers.paid_to',
                        'dno_food_ventures_payment_vouchers.account_no',
                        'dno_food_ventures_payment_vouchers.account_name',
                        'dno_food_ventures_payment_vouchers.particulars',
                        'dno_food_ventures_payment_vouchers.amount',
                        'dno_food_ventures_payment_vouchers.method_of_payment',
                        'dno_food_ventures_payment_vouchers.prepared_by',
                        'dno_food_ventures_payment_vouchers.approved_by',
                        'dno_food_ventures_payment_vouchers.date_approved',
                        'dno_food_ventures_payment_vouchers.received_by_date',
                        'dno_food_ventures_payment_vouchers.created_by',
                        'dno_food_ventures_payment_vouchers.created_at',
                        'dno_food_ventures_payment_vouchers.invoice_number',
                        'dno_food_ventures_payment_vouchers.voucher_ref_number',
                        'dno_food_ventures_payment_vouchers.issued_date',
                        'dno_food_ventures_payment_vouchers.category',
                        'dno_food_ventures_payment_vouchers.amount_due',
                        'dno_food_ventures_payment_vouchers.delivered_date',
                        'dno_food_ventures_payment_vouchers.status',
                        'dno_food_ventures_payment_vouchers.cheque_number',
                        'dno_food_ventures_payment_vouchers.cheque_amount',
                        'dno_food_ventures_payment_vouchers.sub_category',
                        'dno_food_ventures_payment_vouchers.sub_category_account_id',
                        'dno_food_ventures_payment_vouchers.deleted_at',
                        'dno_food_ventures_codes.dno_food_venture_code',
                        'dno_food_ventures_codes.module_id',
                        'dno_food_ventures_codes.module_code',
                        'dno_food_ventures_codes.module_name')
                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                        ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                        ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                        ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$uri0, $uri1])
                        ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                        ->get();

        $totalAmountCashes = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.created_at',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                            ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                                'dno_food_ventures_payment_vouchers')
                                ->select( 
                                'dno_food_ventures_payment_vouchers.id',
                                'dno_food_ventures_payment_vouchers.user_id',
                                'dno_food_ventures_payment_vouchers.pv_id',
                                'dno_food_ventures_payment_vouchers.date',
                                'dno_food_ventures_payment_vouchers.paid_to',
                                'dno_food_ventures_payment_vouchers.account_no',
                                'dno_food_ventures_payment_vouchers.account_name',
                                'dno_food_ventures_payment_vouchers.particulars',
                                'dno_food_ventures_payment_vouchers.amount',
                                'dno_food_ventures_payment_vouchers.method_of_payment',
                                'dno_food_ventures_payment_vouchers.prepared_by',
                                'dno_food_ventures_payment_vouchers.approved_by',
                                'dno_food_ventures_payment_vouchers.date_approved',
                                'dno_food_ventures_payment_vouchers.received_by_date',
                                'dno_food_ventures_payment_vouchers.created_by',
                                'dno_food_ventures_payment_vouchers.created_at',
                                'dno_food_ventures_payment_vouchers.invoice_number',
                                'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                'dno_food_ventures_payment_vouchers.issued_date',
                                'dno_food_ventures_payment_vouchers.category',
                                'dno_food_ventures_payment_vouchers.amount_due',
                                'dno_food_ventures_payment_vouchers.delivered_date',
                                'dno_food_ventures_payment_vouchers.status',
                                'dno_food_ventures_payment_vouchers.cheque_number',
                                'dno_food_ventures_payment_vouchers.cheque_amount',
                                'dno_food_ventures_payment_vouchers.cheque_total_amount',
                                'dno_food_ventures_payment_vouchers.sub_category',
                                'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                'dno_food_ventures_payment_vouchers.deleted_at',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                                ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                ->where('dno_food_ventures_codes.module_name', $moduleName)
                                ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                ->get();
        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                    'dno_food_ventures_payment_vouchers')
                                    ->select( 
                                    'dno_food_ventures_payment_vouchers.id',
                                    'dno_food_ventures_payment_vouchers.user_id',
                                    'dno_food_ventures_payment_vouchers.pv_id',
                                    'dno_food_ventures_payment_vouchers.date',
                                    'dno_food_ventures_payment_vouchers.paid_to',
                                    'dno_food_ventures_payment_vouchers.account_no',
                                    'dno_food_ventures_payment_vouchers.account_name',
                                    'dno_food_ventures_payment_vouchers.particulars',
                                    'dno_food_ventures_payment_vouchers.amount',
                                    'dno_food_ventures_payment_vouchers.method_of_payment',
                                    'dno_food_ventures_payment_vouchers.prepared_by',
                                    'dno_food_ventures_payment_vouchers.approved_by',
                                    'dno_food_ventures_payment_vouchers.date_approved',
                                    'dno_food_ventures_payment_vouchers.received_by_date',
                                    'dno_food_ventures_payment_vouchers.created_by',
                                    'dno_food_ventures_payment_vouchers.created_at',
                                    'dno_food_ventures_payment_vouchers.invoice_number',
                                    'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                    'dno_food_ventures_payment_vouchers.issued_date',
                                    'dno_food_ventures_payment_vouchers.category',
                                    'dno_food_ventures_payment_vouchers.amount_due',
                                    'dno_food_ventures_payment_vouchers.delivered_date',
                                    'dno_food_ventures_payment_vouchers.status',
                                    'dno_food_ventures_payment_vouchers.cheque_number',
                                    'dno_food_ventures_payment_vouchers.cheque_amount',
                                    'dno_food_ventures_payment_vouchers.sub_category',
                                    'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                    'dno_food_ventures_payment_vouchers.deleted_at',
                                    'dno_food_ventures_codes.dno_food_venture_code',
                                    'dno_food_ventures_codes.module_id',
                                    'dno_food_ventures_codes.module_code',
                                    'dno_food_ventures_codes.module_name')
                                    ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                    ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$uri0, $uri1])                                    ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $status)
                                    ->sum('dno_food_ventures_payment_vouchers.amount_due');

            $totalPaidAmountCheck = DB::table(
                                        'dno_food_ventures_payment_vouchers')
                                        ->select( 
                                        'dno_food_ventures_payment_vouchers.id',
                                        'dno_food_ventures_payment_vouchers.user_id',
                                        'dno_food_ventures_payment_vouchers.pv_id',
                                        'dno_food_ventures_payment_vouchers.date',
                                        'dno_food_ventures_payment_vouchers.paid_to',
                                        'dno_food_ventures_payment_vouchers.account_no',
                                        'dno_food_ventures_payment_vouchers.account_name',
                                        'dno_food_ventures_payment_vouchers.particulars',
                                        'dno_food_ventures_payment_vouchers.amount',
                                        'dno_food_ventures_payment_vouchers.method_of_payment',
                                        'dno_food_ventures_payment_vouchers.prepared_by',
                                        'dno_food_ventures_payment_vouchers.approved_by',
                                        'dno_food_ventures_payment_vouchers.date_approved',
                                        'dno_food_ventures_payment_vouchers.received_by_date',
                                        'dno_food_ventures_payment_vouchers.created_by',
                                        'dno_food_ventures_payment_vouchers.created_at',
                                        'dno_food_ventures_payment_vouchers.invoice_number',
                                        'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                        'dno_food_ventures_payment_vouchers.issued_date',
                                        'dno_food_ventures_payment_vouchers.category',
                                        'dno_food_ventures_payment_vouchers.amount_due',
                                        'dno_food_ventures_payment_vouchers.delivered_date',
                                        'dno_food_ventures_payment_vouchers.status',
                                        'dno_food_ventures_payment_vouchers.cheque_number',
                                        'dno_food_ventures_payment_vouchers.cheque_amount',
                                        'dno_food_ventures_payment_vouchers.sub_category',
                                        'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                        'dno_food_ventures_payment_vouchers.deleted_at',
                                        'dno_food_ventures_codes.dno_food_venture_code',
                                        'dno_food_ventures_codes.module_id',
                                        'dno_food_ventures_codes.module_code',
                                        'dno_food_ventures_codes.module_name')
                                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                        ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                        ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                                        ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$uri0, $uri1])
                                        ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                        ->where('dno_food_ventures_payment_vouchers.status', $status)
                                        ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryDnoFoodVentures',  compact('date', 'getDateToday', 'uri0', 'uri1',
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck'));
                                        
        return $pdf->download('dno-food-ventures-summary-report.pdf');


    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.created_at',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$startDate, $endDate])
                            ->orderBy('dno_food_ventures_payment_vouchers.id', 'desc')
                            ->get();

        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dno_food_ventures_payment_vouchers')
                        ->select( 
                        'dno_food_ventures_payment_vouchers.id',
                        'dno_food_ventures_payment_vouchers.user_id',
                        'dno_food_ventures_payment_vouchers.pv_id',
                        'dno_food_ventures_payment_vouchers.date',
                        'dno_food_ventures_payment_vouchers.paid_to',
                        'dno_food_ventures_payment_vouchers.account_no',
                        'dno_food_ventures_payment_vouchers.account_name',
                        'dno_food_ventures_payment_vouchers.particulars',
                        'dno_food_ventures_payment_vouchers.amount',
                        'dno_food_ventures_payment_vouchers.method_of_payment',
                        'dno_food_ventures_payment_vouchers.prepared_by',
                        'dno_food_ventures_payment_vouchers.approved_by',
                        'dno_food_ventures_payment_vouchers.date_approved',
                        'dno_food_ventures_payment_vouchers.received_by_date',
                        'dno_food_ventures_payment_vouchers.created_by',
                        'dno_food_ventures_payment_vouchers.created_at',
                        'dno_food_ventures_payment_vouchers.invoice_number',
                        'dno_food_ventures_payment_vouchers.voucher_ref_number',
                        'dno_food_ventures_payment_vouchers.issued_date',
                        'dno_food_ventures_payment_vouchers.category',
                        'dno_food_ventures_payment_vouchers.amount_due',
                        'dno_food_ventures_payment_vouchers.delivered_date',
                        'dno_food_ventures_payment_vouchers.status',
                        'dno_food_ventures_payment_vouchers.cheque_number',
                        'dno_food_ventures_payment_vouchers.cheque_amount',
                        'dno_food_ventures_payment_vouchers.sub_category',
                        'dno_food_ventures_payment_vouchers.sub_category_account_id',
                        'dno_food_ventures_payment_vouchers.deleted_at',
                        'dno_food_ventures_codes.dno_food_venture_code',
                        'dno_food_ventures_codes.module_id',
                        'dno_food_ventures_codes.module_code',
                        'dno_food_ventures_codes.module_name')
                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                        ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                        ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                        ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                        ->get();

        $totalAmountCashes = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.created_at',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                            ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                                'dno_food_ventures_payment_vouchers')
                                ->select( 
                                'dno_food_ventures_payment_vouchers.id',
                                'dno_food_ventures_payment_vouchers.user_id',
                                'dno_food_ventures_payment_vouchers.pv_id',
                                'dno_food_ventures_payment_vouchers.date',
                                'dno_food_ventures_payment_vouchers.paid_to',
                                'dno_food_ventures_payment_vouchers.account_no',
                                'dno_food_ventures_payment_vouchers.account_name',
                                'dno_food_ventures_payment_vouchers.particulars',
                                'dno_food_ventures_payment_vouchers.amount',
                                'dno_food_ventures_payment_vouchers.method_of_payment',
                                'dno_food_ventures_payment_vouchers.prepared_by',
                                'dno_food_ventures_payment_vouchers.approved_by',
                                'dno_food_ventures_payment_vouchers.date_approved',
                                'dno_food_ventures_payment_vouchers.received_by_date',
                                'dno_food_ventures_payment_vouchers.created_by',
                                'dno_food_ventures_payment_vouchers.created_at',
                                'dno_food_ventures_payment_vouchers.invoice_number',
                                'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                'dno_food_ventures_payment_vouchers.issued_date',
                                'dno_food_ventures_payment_vouchers.category',
                                'dno_food_ventures_payment_vouchers.amount_due',
                                'dno_food_ventures_payment_vouchers.delivered_date',
                                'dno_food_ventures_payment_vouchers.status',
                                'dno_food_ventures_payment_vouchers.cheque_number',
                                'dno_food_ventures_payment_vouchers.cheque_amount',
                                'dno_food_ventures_payment_vouchers.cheque_total_amount',
                                'dno_food_ventures_payment_vouchers.sub_category',
                                'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                'dno_food_ventures_payment_vouchers.deleted_at',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                                ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                ->where('dno_food_ventures_codes.module_name', $moduleName)
                                ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$startDate, $endDate])
                                ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                    'dno_food_ventures_payment_vouchers')
                                    ->select( 
                                    'dno_food_ventures_payment_vouchers.id',
                                    'dno_food_ventures_payment_vouchers.user_id',
                                    'dno_food_ventures_payment_vouchers.pv_id',
                                    'dno_food_ventures_payment_vouchers.date',
                                    'dno_food_ventures_payment_vouchers.paid_to',
                                    'dno_food_ventures_payment_vouchers.account_no',
                                    'dno_food_ventures_payment_vouchers.account_name',
                                    'dno_food_ventures_payment_vouchers.particulars',
                                    'dno_food_ventures_payment_vouchers.amount',
                                    'dno_food_ventures_payment_vouchers.method_of_payment',
                                    'dno_food_ventures_payment_vouchers.prepared_by',
                                    'dno_food_ventures_payment_vouchers.approved_by',
                                    'dno_food_ventures_payment_vouchers.date_approved',
                                    'dno_food_ventures_payment_vouchers.received_by_date',
                                    'dno_food_ventures_payment_vouchers.created_by',
                                    'dno_food_ventures_payment_vouchers.created_at',
                                    'dno_food_ventures_payment_vouchers.invoice_number',
                                    'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                    'dno_food_ventures_payment_vouchers.issued_date',
                                    'dno_food_ventures_payment_vouchers.category',
                                    'dno_food_ventures_payment_vouchers.amount_due',
                                    'dno_food_ventures_payment_vouchers.delivered_date',
                                    'dno_food_ventures_payment_vouchers.status',
                                    'dno_food_ventures_payment_vouchers.cheque_number',
                                    'dno_food_ventures_payment_vouchers.cheque_amount',
                                    'dno_food_ventures_payment_vouchers.sub_category',
                                    'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                    'dno_food_ventures_payment_vouchers.deleted_at',
                                    'dno_food_ventures_codes.dno_food_venture_code',
                                    'dno_food_ventures_codes.module_id',
                                    'dno_food_ventures_codes.module_code',
                                    'dno_food_ventures_codes.module_name')
                                    ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                    ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->whereBetween('dno_food_ventures_payment_vouchers.created_at', [$startDate, $endDate]) 
                                    ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $status)
                                    ->sum('dno_food_ventures_payment_vouchers.amount_due');
        
        return view('dno-food-ventures-multiple-summary-report', compact('getTransactionLists', 'startDate', 'endDate', 'getTransactionListCashes', 'totalAmountCashes', 
        'getTransactionListChecks', 'totalAmountCheck'));


    }

    public function search(Request $request){
        $getSearchResults =DnoFoodVenturesCode::where('dno_food_venture_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                                'dno_food_ventures_payment_vouchers')
                                ->select( 
                                'dno_food_ventures_payment_vouchers.id',
                                'dno_food_ventures_payment_vouchers.user_id',
                                'dno_food_ventures_payment_vouchers.pv_id',
                                'dno_food_ventures_payment_vouchers.date',
                                'dno_food_ventures_payment_vouchers.paid_to',
                                'dno_food_ventures_payment_vouchers.account_no',
                                'dno_food_ventures_payment_vouchers.account_name',
                                'dno_food_ventures_payment_vouchers.particulars',
                                'dno_food_ventures_payment_vouchers.amount',
                                'dno_food_ventures_payment_vouchers.method_of_payment',
                                'dno_food_ventures_payment_vouchers.prepared_by',
                                'dno_food_ventures_payment_vouchers.approved_by',
                                'dno_food_ventures_payment_vouchers.date_approved',
                                'dno_food_ventures_payment_vouchers.received_by_date',
                                'dno_food_ventures_payment_vouchers.created_by',
                                'dno_food_ventures_payment_vouchers.invoice_number',
                                'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                'dno_food_ventures_payment_vouchers.issued_date',
                                'dno_food_ventures_payment_vouchers.category',
                                'dno_food_ventures_payment_vouchers.amount_due',
                                'dno_food_ventures_payment_vouchers.delivered_date',
                                'dno_food_ventures_payment_vouchers.status',
                                'dno_food_ventures_payment_vouchers.cheque_number',
                                'dno_food_ventures_payment_vouchers.cheque_amount',
                                'dno_food_ventures_payment_vouchers.sub_category',
                                'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                'dno_food_ventures_payment_vouchers.deleted_at',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                                ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                ->where('dno_food_ventures_payment_vouchers.id', $getSearchResults[0]->module_id)
                                ->where('dno_food_ventures_codes.module_name', $getSearchResults[0]->module_name)
                                ->get()->toArray();

            $getAllCodes = DnoFoodVenturesCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('dno-food-ventures-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
    
        }
    }

    public function searchNumberCode(){
        $getAllCodes = DnoFoodVenturesCode::get()->toArray();
        return view('dno-food-ventures-search-number-code', compact('getAllCodes'));
    }

    public function printGetSummary($date){
        $moduleName = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dno_food_ventures_payment_vouchers')
                        ->select( 
                        'dno_food_ventures_payment_vouchers.id',
                        'dno_food_ventures_payment_vouchers.user_id',
                        'dno_food_ventures_payment_vouchers.pv_id',
                        'dno_food_ventures_payment_vouchers.date',
                        'dno_food_ventures_payment_vouchers.paid_to',
                        'dno_food_ventures_payment_vouchers.account_no',
                        'dno_food_ventures_payment_vouchers.account_name',
                        'dno_food_ventures_payment_vouchers.particulars',
                        'dno_food_ventures_payment_vouchers.amount',
                        'dno_food_ventures_payment_vouchers.method_of_payment',
                        'dno_food_ventures_payment_vouchers.prepared_by',
                        'dno_food_ventures_payment_vouchers.approved_by',
                        'dno_food_ventures_payment_vouchers.date_approved',
                        'dno_food_ventures_payment_vouchers.received_by_date',
                        'dno_food_ventures_payment_vouchers.created_by',
                        'dno_food_ventures_payment_vouchers.created_at',
                        'dno_food_ventures_payment_vouchers.invoice_number',
                        'dno_food_ventures_payment_vouchers.voucher_ref_number',
                        'dno_food_ventures_payment_vouchers.issued_date',
                        'dno_food_ventures_payment_vouchers.category',
                        'dno_food_ventures_payment_vouchers.amount_due',
                        'dno_food_ventures_payment_vouchers.delivered_date',
                        'dno_food_ventures_payment_vouchers.status',
                        'dno_food_ventures_payment_vouchers.cheque_number',
                        'dno_food_ventures_payment_vouchers.cheque_amount',
                        'dno_food_ventures_payment_vouchers.sub_category',
                        'dno_food_ventures_payment_vouchers.sub_category_account_id',
                        'dno_food_ventures_payment_vouchers.deleted_at',
                        'dno_food_ventures_codes.dno_food_venture_code',
                        'dno_food_ventures_codes.module_id',
                        'dno_food_ventures_codes.module_code',
                        'dno_food_ventures_codes.module_name')
                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                        ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                        ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                        ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($date))
                        ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                        ->get();

        $totalAmountCashes = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.created_at',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($date))
                            ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                            ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                                'dno_food_ventures_payment_vouchers')
                                ->select( 
                                'dno_food_ventures_payment_vouchers.id',
                                'dno_food_ventures_payment_vouchers.user_id',
                                'dno_food_ventures_payment_vouchers.pv_id',
                                'dno_food_ventures_payment_vouchers.date',
                                'dno_food_ventures_payment_vouchers.paid_to',
                                'dno_food_ventures_payment_vouchers.account_no',
                                'dno_food_ventures_payment_vouchers.account_name',
                                'dno_food_ventures_payment_vouchers.particulars',
                                'dno_food_ventures_payment_vouchers.amount',
                                'dno_food_ventures_payment_vouchers.method_of_payment',
                                'dno_food_ventures_payment_vouchers.prepared_by',
                                'dno_food_ventures_payment_vouchers.approved_by',
                                'dno_food_ventures_payment_vouchers.date_approved',
                                'dno_food_ventures_payment_vouchers.received_by_date',
                                'dno_food_ventures_payment_vouchers.created_by',
                                'dno_food_ventures_payment_vouchers.created_at',
                                'dno_food_ventures_payment_vouchers.invoice_number',
                                'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                'dno_food_ventures_payment_vouchers.issued_date',
                                'dno_food_ventures_payment_vouchers.category',
                                'dno_food_ventures_payment_vouchers.amount_due',
                                'dno_food_ventures_payment_vouchers.delivered_date',
                                'dno_food_ventures_payment_vouchers.status',
                                'dno_food_ventures_payment_vouchers.cheque_number',
                                'dno_food_ventures_payment_vouchers.cheque_amount',
                                'dno_food_ventures_payment_vouchers.cheque_total_amount',
                                'dno_food_ventures_payment_vouchers.sub_category',
                                'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                'dno_food_ventures_payment_vouchers.deleted_at',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                                ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                ->where('dno_food_ventures_codes.module_name', $moduleName)
                                ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($date))
                                ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                ->get();
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                    'dno_food_ventures_payment_vouchers')
                                    ->select( 
                                    'dno_food_ventures_payment_vouchers.id',
                                    'dno_food_ventures_payment_vouchers.user_id',
                                    'dno_food_ventures_payment_vouchers.pv_id',
                                    'dno_food_ventures_payment_vouchers.date',
                                    'dno_food_ventures_payment_vouchers.paid_to',
                                    'dno_food_ventures_payment_vouchers.account_no',
                                    'dno_food_ventures_payment_vouchers.account_name',
                                    'dno_food_ventures_payment_vouchers.particulars',
                                    'dno_food_ventures_payment_vouchers.amount',
                                    'dno_food_ventures_payment_vouchers.method_of_payment',
                                    'dno_food_ventures_payment_vouchers.prepared_by',
                                    'dno_food_ventures_payment_vouchers.approved_by',
                                    'dno_food_ventures_payment_vouchers.date_approved',
                                    'dno_food_ventures_payment_vouchers.received_by_date',
                                    'dno_food_ventures_payment_vouchers.created_by',
                                    'dno_food_ventures_payment_vouchers.created_at',
                                    'dno_food_ventures_payment_vouchers.invoice_number',
                                    'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                    'dno_food_ventures_payment_vouchers.issued_date',
                                    'dno_food_ventures_payment_vouchers.category',
                                    'dno_food_ventures_payment_vouchers.amount_due',
                                    'dno_food_ventures_payment_vouchers.delivered_date',
                                    'dno_food_ventures_payment_vouchers.status',
                                    'dno_food_ventures_payment_vouchers.cheque_number',
                                    'dno_food_ventures_payment_vouchers.cheque_amount',
                                    'dno_food_ventures_payment_vouchers.sub_category',
                                    'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                    'dno_food_ventures_payment_vouchers.deleted_at',
                                    'dno_food_ventures_codes.dno_food_venture_code',
                                    'dno_food_ventures_codes.module_id',
                                    'dno_food_ventures_codes.module_code',
                                    'dno_food_ventures_codes.module_name')
                                    ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                    ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($date))
                                    ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $status)
                                    ->sum('dno_food_ventures_payment_vouchers.amount_due');

            $totalPaidAmountCheck  = DB::table(
                                        'dno_food_ventures_payment_vouchers')
                                        ->select( 
                                        'dno_food_ventures_payment_vouchers.id',
                                        'dno_food_ventures_payment_vouchers.user_id',
                                        'dno_food_ventures_payment_vouchers.pv_id',
                                        'dno_food_ventures_payment_vouchers.date',
                                        'dno_food_ventures_payment_vouchers.paid_to',
                                        'dno_food_ventures_payment_vouchers.account_no',
                                        'dno_food_ventures_payment_vouchers.account_name',
                                        'dno_food_ventures_payment_vouchers.particulars',
                                        'dno_food_ventures_payment_vouchers.amount',
                                        'dno_food_ventures_payment_vouchers.method_of_payment',
                                        'dno_food_ventures_payment_vouchers.prepared_by',
                                        'dno_food_ventures_payment_vouchers.approved_by',
                                        'dno_food_ventures_payment_vouchers.date_approved',
                                        'dno_food_ventures_payment_vouchers.received_by_date',
                                        'dno_food_ventures_payment_vouchers.created_by',
                                        'dno_food_ventures_payment_vouchers.created_at',
                                        'dno_food_ventures_payment_vouchers.invoice_number',
                                        'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                        'dno_food_ventures_payment_vouchers.issued_date',
                                        'dno_food_ventures_payment_vouchers.category',
                                        'dno_food_ventures_payment_vouchers.amount_due',
                                        'dno_food_ventures_payment_vouchers.delivered_date',
                                        'dno_food_ventures_payment_vouchers.status',
                                        'dno_food_ventures_payment_vouchers.cheque_number',
                                        'dno_food_ventures_payment_vouchers.cheque_amount',
                                        'dno_food_ventures_payment_vouchers.cheque_total_amount',
                                        'dno_food_ventures_payment_vouchers.sub_category',
                                        'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                        'dno_food_ventures_payment_vouchers.deleted_at',
                                        'dno_food_ventures_codes.dno_food_venture_code',
                                        'dno_food_ventures_codes.module_id',
                                        'dno_food_ventures_codes.module_code',
                                        'dno_food_ventures_codes.module_name')
                                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                        ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                        ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                                        ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($date))
                                        ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                        ->where('dno_food_ventures_payment_vouchers.status',  $status)
                                        ->sum('dno_food_ventures_payment_vouchers.cheque_total_amount');
        $getDateToday = "";
        $uri0  = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryDnoFoodVentures',  compact('date', 'getDateToday', 'uri0', 'uri1',
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('dno-food-ventures-summary-report.pdf');
        
    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");
        $moduleName = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dno_food_ventures_payment_vouchers')
                        ->select( 
                        'dno_food_ventures_payment_vouchers.id',
                        'dno_food_ventures_payment_vouchers.user_id',
                        'dno_food_ventures_payment_vouchers.pv_id',
                        'dno_food_ventures_payment_vouchers.date',
                        'dno_food_ventures_payment_vouchers.paid_to',
                        'dno_food_ventures_payment_vouchers.account_no',
                        'dno_food_ventures_payment_vouchers.account_name',
                        'dno_food_ventures_payment_vouchers.particulars',
                        'dno_food_ventures_payment_vouchers.amount',
                        'dno_food_ventures_payment_vouchers.method_of_payment',
                        'dno_food_ventures_payment_vouchers.prepared_by',
                        'dno_food_ventures_payment_vouchers.approved_by',
                        'dno_food_ventures_payment_vouchers.date_approved',
                        'dno_food_ventures_payment_vouchers.received_by_date',
                        'dno_food_ventures_payment_vouchers.created_by',
                        'dno_food_ventures_payment_vouchers.created_at',
                        'dno_food_ventures_payment_vouchers.invoice_number',
                        'dno_food_ventures_payment_vouchers.voucher_ref_number',
                        'dno_food_ventures_payment_vouchers.issued_date',
                        'dno_food_ventures_payment_vouchers.category',
                        'dno_food_ventures_payment_vouchers.amount_due',
                        'dno_food_ventures_payment_vouchers.delivered_date',
                        'dno_food_ventures_payment_vouchers.status',
                        'dno_food_ventures_payment_vouchers.cheque_number',
                        'dno_food_ventures_payment_vouchers.cheque_amount',
                        'dno_food_ventures_payment_vouchers.sub_category',
                        'dno_food_ventures_payment_vouchers.sub_category_account_id',
                        'dno_food_ventures_payment_vouchers.deleted_at',
                        'dno_food_ventures_codes.dno_food_venture_code',
                        'dno_food_ventures_codes.module_id',
                        'dno_food_ventures_codes.module_code',
                        'dno_food_ventures_codes.module_name')
                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                        ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                        ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                        ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                        ->get();

        $totalAmountCashes = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.created_at',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                            ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                                'dno_food_ventures_payment_vouchers')
                                ->select( 
                                'dno_food_ventures_payment_vouchers.id',
                                'dno_food_ventures_payment_vouchers.user_id',
                                'dno_food_ventures_payment_vouchers.pv_id',
                                'dno_food_ventures_payment_vouchers.date',
                                'dno_food_ventures_payment_vouchers.paid_to',
                                'dno_food_ventures_payment_vouchers.account_no',
                                'dno_food_ventures_payment_vouchers.account_name',
                                'dno_food_ventures_payment_vouchers.particulars',
                                'dno_food_ventures_payment_vouchers.amount',
                                'dno_food_ventures_payment_vouchers.method_of_payment',
                                'dno_food_ventures_payment_vouchers.prepared_by',
                                'dno_food_ventures_payment_vouchers.approved_by',
                                'dno_food_ventures_payment_vouchers.date_approved',
                                'dno_food_ventures_payment_vouchers.received_by_date',
                                'dno_food_ventures_payment_vouchers.created_by',
                                'dno_food_ventures_payment_vouchers.created_at',
                                'dno_food_ventures_payment_vouchers.invoice_number',
                                'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                'dno_food_ventures_payment_vouchers.issued_date',
                                'dno_food_ventures_payment_vouchers.category',
                                'dno_food_ventures_payment_vouchers.amount_due',
                                'dno_food_ventures_payment_vouchers.delivered_date',
                                'dno_food_ventures_payment_vouchers.status',
                                'dno_food_ventures_payment_vouchers.cheque_number',
                                'dno_food_ventures_payment_vouchers.cheque_amount',
                                'dno_food_ventures_payment_vouchers.cheque_total_amount',
                                'dno_food_ventures_payment_vouchers.sub_category',
                                'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                'dno_food_ventures_payment_vouchers.deleted_at',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                                ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                ->where('dno_food_ventures_codes.module_name', $moduleName)
                                ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                ->get();
        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                    'dno_food_ventures_payment_vouchers')
                                    ->select( 
                                    'dno_food_ventures_payment_vouchers.id',
                                    'dno_food_ventures_payment_vouchers.user_id',
                                    'dno_food_ventures_payment_vouchers.pv_id',
                                    'dno_food_ventures_payment_vouchers.date',
                                    'dno_food_ventures_payment_vouchers.paid_to',
                                    'dno_food_ventures_payment_vouchers.account_no',
                                    'dno_food_ventures_payment_vouchers.account_name',
                                    'dno_food_ventures_payment_vouchers.particulars',
                                    'dno_food_ventures_payment_vouchers.amount',
                                    'dno_food_ventures_payment_vouchers.method_of_payment',
                                    'dno_food_ventures_payment_vouchers.prepared_by',
                                    'dno_food_ventures_payment_vouchers.approved_by',
                                    'dno_food_ventures_payment_vouchers.date_approved',
                                    'dno_food_ventures_payment_vouchers.received_by_date',
                                    'dno_food_ventures_payment_vouchers.created_by',
                                    'dno_food_ventures_payment_vouchers.created_at',
                                    'dno_food_ventures_payment_vouchers.invoice_number',
                                    'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                    'dno_food_ventures_payment_vouchers.issued_date',
                                    'dno_food_ventures_payment_vouchers.category',
                                    'dno_food_ventures_payment_vouchers.amount_due',
                                    'dno_food_ventures_payment_vouchers.delivered_date',
                                    'dno_food_ventures_payment_vouchers.status',
                                    'dno_food_ventures_payment_vouchers.cheque_number',
                                    'dno_food_ventures_payment_vouchers.cheque_amount',
                                    'dno_food_ventures_payment_vouchers.sub_category',
                                    'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                    'dno_food_ventures_payment_vouchers.deleted_at',
                                    'dno_food_ventures_codes.dno_food_venture_code',
                                    'dno_food_ventures_codes.module_id',
                                    'dno_food_ventures_codes.module_code',
                                    'dno_food_ventures_codes.module_name')
                                    ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                    ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $status)
                                    ->sum('dno_food_ventures_payment_vouchers.amount_due');

            $totalPaidAmountCheck = DB::table(
                                        'dno_food_ventures_payment_vouchers')
                                        ->select( 
                                        'dno_food_ventures_payment_vouchers.id',
                                        'dno_food_ventures_payment_vouchers.user_id',
                                        'dno_food_ventures_payment_vouchers.pv_id',
                                        'dno_food_ventures_payment_vouchers.date',
                                        'dno_food_ventures_payment_vouchers.paid_to',
                                        'dno_food_ventures_payment_vouchers.account_no',
                                        'dno_food_ventures_payment_vouchers.account_name',
                                        'dno_food_ventures_payment_vouchers.particulars',
                                        'dno_food_ventures_payment_vouchers.amount',
                                        'dno_food_ventures_payment_vouchers.method_of_payment',
                                        'dno_food_ventures_payment_vouchers.prepared_by',
                                        'dno_food_ventures_payment_vouchers.approved_by',
                                        'dno_food_ventures_payment_vouchers.date_approved',
                                        'dno_food_ventures_payment_vouchers.received_by_date',
                                        'dno_food_ventures_payment_vouchers.created_by',
                                        'dno_food_ventures_payment_vouchers.created_at',
                                        'dno_food_ventures_payment_vouchers.invoice_number',
                                        'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                        'dno_food_ventures_payment_vouchers.issued_date',
                                        'dno_food_ventures_payment_vouchers.category',
                                        'dno_food_ventures_payment_vouchers.amount_due',
                                        'dno_food_ventures_payment_vouchers.delivered_date',
                                        'dno_food_ventures_payment_vouchers.status',
                                        'dno_food_ventures_payment_vouchers.cheque_number',
                                        'dno_food_ventures_payment_vouchers.cheque_amount',
                                        'dno_food_ventures_payment_vouchers.sub_category',
                                        'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                        'dno_food_ventures_payment_vouchers.deleted_at',
                                        'dno_food_ventures_codes.dno_food_venture_code',
                                        'dno_food_ventures_codes.module_id',
                                        'dno_food_ventures_codes.module_code',
                                        'dno_food_ventures_codes.module_name')
                                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                        ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                        ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                                        ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                                        ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                        ->where('dno_food_ventures_payment_vouchers.status', $status)
                                        ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSummaryDnoFoodVentures',  compact('date', 'getDateToday', 
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('dno-food-ventures-summary-report.pdf');
        
    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');

        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.created_at',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDate))
                            ->orderBy('dno_food_ventures_payment_vouchers.id', 'desc')
                            ->get();

        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dno_food_ventures_payment_vouchers')
                        ->select( 
                        'dno_food_ventures_payment_vouchers.id',
                        'dno_food_ventures_payment_vouchers.user_id',
                        'dno_food_ventures_payment_vouchers.pv_id',
                        'dno_food_ventures_payment_vouchers.date',
                        'dno_food_ventures_payment_vouchers.paid_to',
                        'dno_food_ventures_payment_vouchers.account_no',
                        'dno_food_ventures_payment_vouchers.account_name',
                        'dno_food_ventures_payment_vouchers.particulars',
                        'dno_food_ventures_payment_vouchers.amount',
                        'dno_food_ventures_payment_vouchers.method_of_payment',
                        'dno_food_ventures_payment_vouchers.prepared_by',
                        'dno_food_ventures_payment_vouchers.approved_by',
                        'dno_food_ventures_payment_vouchers.date_approved',
                        'dno_food_ventures_payment_vouchers.received_by_date',
                        'dno_food_ventures_payment_vouchers.created_by',
                        'dno_food_ventures_payment_vouchers.created_at',
                        'dno_food_ventures_payment_vouchers.invoice_number',
                        'dno_food_ventures_payment_vouchers.voucher_ref_number',
                        'dno_food_ventures_payment_vouchers.issued_date',
                        'dno_food_ventures_payment_vouchers.category',
                        'dno_food_ventures_payment_vouchers.amount_due',
                        'dno_food_ventures_payment_vouchers.delivered_date',
                        'dno_food_ventures_payment_vouchers.status',
                        'dno_food_ventures_payment_vouchers.cheque_number',
                        'dno_food_ventures_payment_vouchers.cheque_amount',
                        'dno_food_ventures_payment_vouchers.sub_category',
                        'dno_food_ventures_payment_vouchers.sub_category_account_id',
                        'dno_food_ventures_payment_vouchers.deleted_at',
                        'dno_food_ventures_codes.dno_food_venture_code',
                        'dno_food_ventures_codes.module_id',
                        'dno_food_ventures_codes.module_code',
                        'dno_food_ventures_codes.module_name')
                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                        ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                        ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                        ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDate))
                        ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                        ->get();

        $totalAmountCashes = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.created_at',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDate))
                            ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                            ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                                'dno_food_ventures_payment_vouchers')
                                ->select( 
                                'dno_food_ventures_payment_vouchers.id',
                                'dno_food_ventures_payment_vouchers.user_id',
                                'dno_food_ventures_payment_vouchers.pv_id',
                                'dno_food_ventures_payment_vouchers.date',
                                'dno_food_ventures_payment_vouchers.paid_to',
                                'dno_food_ventures_payment_vouchers.account_no',
                                'dno_food_ventures_payment_vouchers.account_name',
                                'dno_food_ventures_payment_vouchers.particulars',
                                'dno_food_ventures_payment_vouchers.amount',
                                'dno_food_ventures_payment_vouchers.method_of_payment',
                                'dno_food_ventures_payment_vouchers.prepared_by',
                                'dno_food_ventures_payment_vouchers.approved_by',
                                'dno_food_ventures_payment_vouchers.date_approved',
                                'dno_food_ventures_payment_vouchers.received_by_date',
                                'dno_food_ventures_payment_vouchers.created_by',
                                'dno_food_ventures_payment_vouchers.created_at',
                                'dno_food_ventures_payment_vouchers.invoice_number',
                                'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                'dno_food_ventures_payment_vouchers.issued_date',
                                'dno_food_ventures_payment_vouchers.category',
                                'dno_food_ventures_payment_vouchers.amount_due',
                                'dno_food_ventures_payment_vouchers.delivered_date',
                                'dno_food_ventures_payment_vouchers.status',
                                'dno_food_ventures_payment_vouchers.cheque_number',
                                'dno_food_ventures_payment_vouchers.cheque_amount',
                                'dno_food_ventures_payment_vouchers.cheque_total_amount',
                                'dno_food_ventures_payment_vouchers.sub_category',
                                'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                'dno_food_ventures_payment_vouchers.deleted_at',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                                ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                ->where('dno_food_ventures_codes.module_name', $moduleName)
                                ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDate))
                                ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                    'dno_food_ventures_payment_vouchers')
                                    ->select( 
                                    'dno_food_ventures_payment_vouchers.id',
                                    'dno_food_ventures_payment_vouchers.user_id',
                                    'dno_food_ventures_payment_vouchers.pv_id',
                                    'dno_food_ventures_payment_vouchers.date',
                                    'dno_food_ventures_payment_vouchers.paid_to',
                                    'dno_food_ventures_payment_vouchers.account_no',
                                    'dno_food_ventures_payment_vouchers.account_name',
                                    'dno_food_ventures_payment_vouchers.particulars',
                                    'dno_food_ventures_payment_vouchers.amount',
                                    'dno_food_ventures_payment_vouchers.method_of_payment',
                                    'dno_food_ventures_payment_vouchers.prepared_by',
                                    'dno_food_ventures_payment_vouchers.approved_by',
                                    'dno_food_ventures_payment_vouchers.date_approved',
                                    'dno_food_ventures_payment_vouchers.received_by_date',
                                    'dno_food_ventures_payment_vouchers.created_by',
                                    'dno_food_ventures_payment_vouchers.created_at',
                                    'dno_food_ventures_payment_vouchers.invoice_number',
                                    'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                    'dno_food_ventures_payment_vouchers.issued_date',
                                    'dno_food_ventures_payment_vouchers.category',
                                    'dno_food_ventures_payment_vouchers.amount_due',
                                    'dno_food_ventures_payment_vouchers.delivered_date',
                                    'dno_food_ventures_payment_vouchers.status',
                                    'dno_food_ventures_payment_vouchers.cheque_number',
                                    'dno_food_ventures_payment_vouchers.cheque_amount',
                                    'dno_food_ventures_payment_vouchers.sub_category',
                                    'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                    'dno_food_ventures_payment_vouchers.deleted_at',
                                    'dno_food_ventures_codes.dno_food_venture_code',
                                    'dno_food_ventures_codes.module_id',
                                    'dno_food_ventures_codes.module_code',
                                    'dno_food_ventures_codes.module_name')
                                    ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                    ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDate))
                                    ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $status)
                                    ->sum('dno_food_ventures_payment_vouchers.amount_due');
        
        return view('dno-food-ventures-get-summary-report', compact('getDate','getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 
        'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function summaryReport(){
        $getDateToday = date("Y-m-d");

        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.created_at',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                            ->orderBy('dno_food_ventures_payment_vouchers.id', 'desc')
                            ->get();

        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'dno_food_ventures_payment_vouchers')
                        ->select( 
                        'dno_food_ventures_payment_vouchers.id',
                        'dno_food_ventures_payment_vouchers.user_id',
                        'dno_food_ventures_payment_vouchers.pv_id',
                        'dno_food_ventures_payment_vouchers.date',
                        'dno_food_ventures_payment_vouchers.paid_to',
                        'dno_food_ventures_payment_vouchers.account_no',
                        'dno_food_ventures_payment_vouchers.account_name',
                        'dno_food_ventures_payment_vouchers.particulars',
                        'dno_food_ventures_payment_vouchers.amount',
                        'dno_food_ventures_payment_vouchers.method_of_payment',
                        'dno_food_ventures_payment_vouchers.prepared_by',
                        'dno_food_ventures_payment_vouchers.approved_by',
                        'dno_food_ventures_payment_vouchers.date_approved',
                        'dno_food_ventures_payment_vouchers.received_by_date',
                        'dno_food_ventures_payment_vouchers.created_by',
                        'dno_food_ventures_payment_vouchers.created_at',
                        'dno_food_ventures_payment_vouchers.invoice_number',
                        'dno_food_ventures_payment_vouchers.voucher_ref_number',
                        'dno_food_ventures_payment_vouchers.issued_date',
                        'dno_food_ventures_payment_vouchers.category',
                        'dno_food_ventures_payment_vouchers.amount_due',
                        'dno_food_ventures_payment_vouchers.delivered_date',
                        'dno_food_ventures_payment_vouchers.status',
                        'dno_food_ventures_payment_vouchers.cheque_number',
                        'dno_food_ventures_payment_vouchers.cheque_amount',
                        'dno_food_ventures_payment_vouchers.sub_category',
                        'dno_food_ventures_payment_vouchers.sub_category_account_id',
                        'dno_food_ventures_payment_vouchers.deleted_at',
                        'dno_food_ventures_codes.dno_food_venture_code',
                        'dno_food_ventures_codes.module_id',
                        'dno_food_ventures_codes.module_code',
                        'dno_food_ventures_codes.module_name')
                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                        ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                        ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                        ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                        ->get();

        $totalAmountCashes = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.created_at',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dno_food_ventures_payment_vouchers.method_of_payment', $cash)
                            ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                                'dno_food_ventures_payment_vouchers')
                                ->select( 
                                'dno_food_ventures_payment_vouchers.id',
                                'dno_food_ventures_payment_vouchers.user_id',
                                'dno_food_ventures_payment_vouchers.pv_id',
                                'dno_food_ventures_payment_vouchers.date',
                                'dno_food_ventures_payment_vouchers.paid_to',
                                'dno_food_ventures_payment_vouchers.account_no',
                                'dno_food_ventures_payment_vouchers.account_name',
                                'dno_food_ventures_payment_vouchers.particulars',
                                'dno_food_ventures_payment_vouchers.amount',
                                'dno_food_ventures_payment_vouchers.method_of_payment',
                                'dno_food_ventures_payment_vouchers.prepared_by',
                                'dno_food_ventures_payment_vouchers.approved_by',
                                'dno_food_ventures_payment_vouchers.date_approved',
                                'dno_food_ventures_payment_vouchers.received_by_date',
                                'dno_food_ventures_payment_vouchers.created_by',
                                'dno_food_ventures_payment_vouchers.created_at',
                                'dno_food_ventures_payment_vouchers.invoice_number',
                                'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                'dno_food_ventures_payment_vouchers.issued_date',
                                'dno_food_ventures_payment_vouchers.category',
                                'dno_food_ventures_payment_vouchers.amount_due',
                                'dno_food_ventures_payment_vouchers.delivered_date',
                                'dno_food_ventures_payment_vouchers.status',
                                'dno_food_ventures_payment_vouchers.cheque_number',
                                'dno_food_ventures_payment_vouchers.cheque_amount',
                                'dno_food_ventures_payment_vouchers.cheque_total_amount',
                                'dno_food_ventures_payment_vouchers.sub_category',
                                'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                'dno_food_ventures_payment_vouchers.deleted_at',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                                ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                ->where('dno_food_ventures_codes.module_name', $moduleName)
                                ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                    'dno_food_ventures_payment_vouchers')
                                    ->select( 
                                    'dno_food_ventures_payment_vouchers.id',
                                    'dno_food_ventures_payment_vouchers.user_id',
                                    'dno_food_ventures_payment_vouchers.pv_id',
                                    'dno_food_ventures_payment_vouchers.date',
                                    'dno_food_ventures_payment_vouchers.paid_to',
                                    'dno_food_ventures_payment_vouchers.account_no',
                                    'dno_food_ventures_payment_vouchers.account_name',
                                    'dno_food_ventures_payment_vouchers.particulars',
                                    'dno_food_ventures_payment_vouchers.amount',
                                    'dno_food_ventures_payment_vouchers.method_of_payment',
                                    'dno_food_ventures_payment_vouchers.prepared_by',
                                    'dno_food_ventures_payment_vouchers.approved_by',
                                    'dno_food_ventures_payment_vouchers.date_approved',
                                    'dno_food_ventures_payment_vouchers.received_by_date',
                                    'dno_food_ventures_payment_vouchers.created_by',
                                    'dno_food_ventures_payment_vouchers.created_at',
                                    'dno_food_ventures_payment_vouchers.invoice_number',
                                    'dno_food_ventures_payment_vouchers.voucher_ref_number',
                                    'dno_food_ventures_payment_vouchers.issued_date',
                                    'dno_food_ventures_payment_vouchers.category',
                                    'dno_food_ventures_payment_vouchers.amount_due',
                                    'dno_food_ventures_payment_vouchers.delivered_date',
                                    'dno_food_ventures_payment_vouchers.status',
                                    'dno_food_ventures_payment_vouchers.cheque_number',
                                    'dno_food_ventures_payment_vouchers.cheque_amount',
                                    'dno_food_ventures_payment_vouchers.sub_category',
                                    'dno_food_ventures_payment_vouchers.sub_category_account_id',
                                    'dno_food_ventures_payment_vouchers.deleted_at',
                                    'dno_food_ventures_codes.dno_food_venture_code',
                                    'dno_food_ventures_codes.module_id',
                                    'dno_food_ventures_codes.module_code',
                                    'dno_food_ventures_codes.module_name')
                                    ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                                    ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->whereDate('dno_food_ventures_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('dno_food_ventures_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $status)
                                    ->sum('dno_food_ventures_payment_vouchers.amount_due');
        
        return view('dno-food-ventures-summary-report', compact('getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 
        'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function printPayables($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.id', $id)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->get();

          //getParticular details
          $getParticulars = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      

          $payablesVouchers = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->get()->toArray();
  
            //count the total amount 
          $countTotalAmount = DnoFoodVenturesPaymentVoucher::where('id', $id)->sum('amount_due');
  
  
            //
          $countAmount = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->sum('amount_due');
  
          $sum  = $countTotalAmount + $countAmount;
         
  
          $pdf = PDF::loadView('printPayablesDNOFoodVentures', compact('payableId',  'payablesVouchers', 'sum', 'getParticulars'));
  
          return $pdf->download('dno-food-ventures-payment-voucher.pdf');
  
        
    }

    public function viewPayableDetails($id){
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.id', $id)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->get();
        
        $getViewPaymentDetails = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //getParticular details
        $getParticulars = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
                        
       

        return view('view-dno-food-ventures-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
   

    }

    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_payment_vouchers.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.pv_id', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->where('dno_food_ventures_payment_vouchers.deleted_at', NULL)
                            ->orderBy('dno_food_ventures_payment_vouchers.id', 'desc')
                            ->get()->toArray();

         //get total amount due
         $status = "FULLY PAID AND RELEASED";
         $totalAmountDue = DnoFoodVenturesPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');
                                
        return view('dno-food-ventures-transaction-list', compact('getTransactionLists', 'totalAmountDue'));
         
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
    
                        $payables = DnoFoodVenturesPaymentVoucher::find($id);
    
                        $payables->status = $status;
                        $payables->delivered_date = $getDate;
                        $payables->created_by = $name; 
                        $payables->save();
    
                        Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');
                        
                        return redirect()->route('editPayablesDetailDNOFoodVentures', ['id'=>$id]);
                       
                        break;
                    
                    default:
                        # code...
                        return redirect()->route('editPayablesDetailDNOFoodVentures', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                       
                        break;
                }
    
            }else if($status == "FOR APPROVAL"){
                switch ($request->get('action')) {
                    case 'PAID & HOLD':
                        # code...
                        $payables = DnoFoodVenturesPaymentVoucher::find($id);
    
                        $payables->status = $status;
                        $payables->save();
    
                         Session::flash('payablesSuccess', 'Status set for approval.');
    
                         return redirect()->route('editPayablesDetailDNOFoodVentures', ['id'=>$id]);
    
                        break;
                    
                    default:
                        # code...
                        return redirect()->route('editPayablesDetailDNOFoodVentures', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                        break;
                }
            }else{
    
                switch ($request->get('action')) {
                    case 'PAID & HOLD':
                        # code...
                        $payables = DnoFoodVenturesPaymentVoucher::find($id);
    
                        $payables->status = $status;
                        $payables->save();
    
                        Session::flash('payablesSuccess', 'Status set for confirmation.');
    
                        return redirect()->route('editPayablesDetailDNOFoodVentures', ['id'=>$id]);
                        
                        break;
                    
                    default:
                        # code...
                        return redirect()->route('editPayablesDetailDNOFoodVentures', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = DnoFoodVenturesPaymentVoucher::find($id);

         //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');


        $addParticulars = new DnoFoodVenturesPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'date'=>$request->get('date'),
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addParticulars->save();

        //update 
        $particulars->amount_due = $add;
        $particulars->save();
        
        Session::flash('particularsAdded', 'Particulars added.');

        return redirect()->route('editPayablesDetailDNOFoodVentures', ['id'=>$id]);
    }

    public function addPayment(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = DnoFoodVenturesPaymentVoucher::find($id);
        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');

        $addPayment = new DnoFoodVenturesPaymentVoucher([
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

        return redirect()->route('editPayablesDetailDNOFoodVentures', ['id'=>$id]);
    }   
    

    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'dno_food_ventures_payment_vouchers')
                            ->select( 
                            'dno_food_ventures_payment_vouchers.id',
                            'dno_food_ventures_payment_vouchers.user_id',
                            'dno_food_ventures_payment_vouchers.pv_id',
                            'dno_food_ventures_payment_vouchers.date',
                            'dno_food_ventures_payment_vouchers.paid_to',
                            'dno_food_ventures_payment_vouchers.account_no',
                            'dno_food_ventures_payment_vouchers.account_name',
                            'dno_food_ventures_payment_vouchers.particulars',
                            'dno_food_ventures_payment_vouchers.amount',
                            'dno_food_ventures_payment_vouchers.method_of_payment',
                            'dno_food_ventures_payment_vouchers.prepared_by',
                            'dno_food_ventures_payment_vouchers.approved_by',
                            'dno_food_ventures_payment_vouchers.date_approved',
                            'dno_food_ventures_payment_vouchers.received_by_date',
                            'dno_food_ventures_payment_vouchers.created_by',
                            'dno_food_ventures_payment_vouchers.invoice_number',
                            'dno_food_ventures_payment_vouchers.voucher_ref_number',
                            'dno_food_ventures_payment_vouchers.issued_date',
                            'dno_food_ventures_payment_vouchers.category',
                            'dno_food_ventures_payment_vouchers.amount_due',
                            'dno_food_ventures_payment_vouchers.delivered_date',
                            'dno_food_ventures_payment_vouchers.status',
                            'dno_food_ventures_payment_vouchers.cheque_number',
                            'dno_food_ventures_payment_vouchers.cheque_amount',
                            'dno_food_ventures_payment_vouchers.sub_category',
                            'dno_food_ventures_payment_vouchers.sub_category_account_id',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_payment_vouchers.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_payment_vouchers.id', $id)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->get();

        $getChequeNumbers = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        
        $getCashAmounts = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
      
        //getParticular details
        $getParticulars = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      
        
        //amount
        $amount1 = DnoFoodVenturesPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;

        $chequeAmount1 = DnoFoodVenturesPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
        
        return view('dno-food-ventures-payables-detail', compact('transactionList', 
        'getChequeNumbers', 'getParticulars', 'sum', 'sumCheque', 'getCashAmounts'));
                
        
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

          //get the latest insert id query in table lechon de cebu
          $dataCode = DB::select('SELECT id, dno_food_venture_code FROM dno_food_ventures_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 reference number
          if(isset($dataCode[0]->dno_food_venture_code) != 0){
              //if code is not 0
              $newCode= $dataCode[0]->dno_food_venture_code +1;
              $uCode = sprintf("%06d",$newCode);   
  
          }else{
              //if code is 0 
              $newCode = 1;
              $uCode = sprintf("%06d",$newCode);
          } 

           //if user selects category
        if($request->get('category') === "None"){

            $subCat = NULL;
            $subCatAccountId = NULL;

        }elseif($request->get('category') === "Petty Cash"){

            $subCat = $request->get('pettyCashNo');
            $subCatAccountId = NULL;

        }else if($request->get('category') === "Utility"){
            $subCat = $request->get('utility');
            $subCatAccountId = $request->get('accountId');

        }else if($request->get('category') === "Payroll"){  
            $subCat = NULL;
            $subCatAccountId = NULL;
        }

         //check if invoice number already exists
        $target = DB::table(
                        'dno_food_ventures_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if($target === NULL){
            #code .... 
            $addPaymentVoucher = new DnoFoodVenturesPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'method_of_payment'=>$request->get('paymentMethod'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'account_name'=>$request->get('accountName'),
                'issued_date'=>$request->get('issuedDate'),
                'amount'=>$request->get('amount'),
                'amount_due'=>$request->get('amount'),
                'particulars'=>$request->get('particulars'),
                'category'=>$request->get('category'),
                'sub_category'=>$subCat,
                'sub_category_account_id'=>$subCatAccountId,
                'prepared_by'=>$name,
                'created_by'=>$name,

            ]);

            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;
            
            $moduleCode = "PV-";
            $moduleName = "Payment Voucher";

            $dnoFoodVenture = new DnoFoodVenturesCode([
                'user_id'=>$user->id,
                'dno_food_venture_code'=>$uCode,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);

            $dnoFoodVenture->save();

            return redirect()->route('editPayablesDetailDNOFoodVentures', ['id'=>$insertedId]);
        }else{

        }



    }

    public function paymentVoucherForm(){
        
        return view('payment-voucher-form-dno-food-ventures');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         return view('dno-food-ventures');
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
        $transactionList = DnoFoodVenturesPaymentVoucher::find($id);
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
