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


class DinoIndustrialCorporationController extends Controller
{

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
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
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
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
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
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($date))
                        ->get();

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
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($date))
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');

        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryDIC',  compact('date', 'getDateToday', 
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck'));
        
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
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
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
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
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
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
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
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDate))
                           
                        ->get();

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
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDate))
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
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
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
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
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
                        'dino_industrial_corporation_payment_vouchers.sub_category',
                        'dino_industrial_corporation_payment_vouchers.sub_category_account_id',
                        'dino_industrial_corporation_codes.dic_code',
                        'dino_industrial_corporation_codes.module_id',
                        'dino_industrial_corporation_codes.module_code',
                        'dino_industrial_corporation_codes.module_name')
                        ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                        ->get();

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
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                            ->whereDate('dino_industrial_corporation_payment_vouchers.created_at', '=', date($getDateToday))
                            ->sum('dino_industrial_corporation_payment_vouchers.amount_due');

            $pdf = PDF::loadView('printSummaryDIC',  compact('date', 'getDateToday', 
            'getTransactionListCashes', 'getTransactionListChecks',  
            'totalAmountCashes','totalAmountCheck'));
            
             return $pdf->download('dic-summary-report.pdf');      

    }

    public function summaryReport(){
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
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
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
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
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
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $cash)
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
                        ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                        ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                        ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
                        ->get();

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
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
                            ->where('dino_industrial_corporation_payment_vouchers.method_of_payment', $check)
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

            $payablesVouchers = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->get()->toArray();

            //getParticular details
            $getParticulars = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

                //count the total amount 
            $countTotalAmount = DinoIndustrialCorporationPaymentVoucher::where('id', $id)->sum('amount_due');

            //
            $countAmount = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->sum('amount_due');

            $sum  = $countTotalAmount + $countAmount;

            
            $pdf = PDF::loadView('printPayablesDINOIndustrial', compact('payableId', 'payablesVouchers', 'sum', 'getParticulars'));

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
         
        //save payment cheque num and cheque amount
         $addPayment = new DinoIndustrialCorporationPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,
        ]);

        $addPayment->save();

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

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $addParticulars = new DinoIndustrialCorporationPaymentVoucher([
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
                            'dino_industrial_corporation_codes.dic_code',
                            'dino_industrial_corporation_codes.module_id',
                            'dino_industrial_corporation_codes.module_code',
                            'dino_industrial_corporation_codes.module_name')
                            ->leftJoin('dino_industrial_corporation_codes', 'dino_industrial_corporation_payment_vouchers.id', '=', 'dino_industrial_corporation_codes.module_id')
                            ->where('dino_industrial_corporation_payment_vouchers.pv_id', NULL)
                            ->where('dino_industrial_corporation_codes.module_name', $moduleName)
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
        'getChequeNumbers', 'sumCheque'));
    }

    public function paymentVoucherStore(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the latest insert id query in table payment voucher ref number
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
        
        return view('payment-voucher-form-dino-industrial-corp');
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
