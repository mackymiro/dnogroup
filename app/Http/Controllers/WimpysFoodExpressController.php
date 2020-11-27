<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use Session;
use PDF;
use App\User;
use App\WimpysFoodExpressPaymentVoucher;
use App\WimpysFoodExpressCode;
use App\WimpysFoodExpressSupplier;
use App\WimpysFoodExpressPurchaseOrder;
use App\WimpysFoodExpressBillingStatement; 
use App\WimpysFoodExpressStatementOfAccount;
use App\WimpysFoodExpressStockInventory; 
use App\WimpysFoodExpressOrderForm;

class WimpysFoodExpressController extends Controller
{

    public function search(Request $request){
        $getSearchResults = WimpysFoodExpressCode::where('wimpys_food_express_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table('wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.id', $getSearchResults[0]->module_id)
                    ->where('wimpys_food_express_codes.module_name',  $getSearchResults[0]->module_name)
                    ->get()->toArray();


            $getAllCodes = WimpysFoodExpressCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;  
            
            return view('wimpys-food-express-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
           
        }
    }

    public function searchNumberCode(){
        $getAllCodes = WimpysFoodExpressCode::get()->toArray();
        return view('wimpys-food-express-search-number-code', compact('getAllCodes'));

    }

    public function printGetSummary($date){
        $uri0 = "";
        $uri1 = "";

        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";

        $getTransactionListCashes = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->sum('wimpys_food_express_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $totalAmountCheck = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->sum('wimpys_food_express_payment_vouchers.amount_due');

    $totalPaidAmountCheck = DB::table(
                            'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.cheque_total_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                            ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                            ->where('wimpys_food_express_payment_vouchers.status', $status)
                            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                            ->sum('wimpys_food_express_payment_vouchers.amount_due');
        
        
        $getDateToday = "";     
        $pdf = PDF::loadView('printSummaryWimpysFoodExp',  compact('date', 'getDateToday', 'uri0', 'uri1', 
            'getTransactionListCashes', 'getTransactionListChecks', 
            'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('wimpys-food-express-summary-report.pdf');
                

    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");
        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $totalAmountCashes = DB::table(
                            'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.cheque_total_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                            ->sum('wimpys_food_express_payment_vouchers.amount_due');


        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->sum('wimpys_food_express_payment_vouchers.amount_due');
        
    $totalPaidAmountCheck = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->where('wimpys_food_express_payment_vouchers.status', $status)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->sum('wimpys_food_express_payment_vouchers.amount_due');

        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryWimpysFoodExp', compact('uri0', 'uri1', 'getDateToday', 
        'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));

        return $pdf->download('wimpys-food-express-inc-summary-report.pdf');

    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));
        $moduleNamePV = "Payment Voucher";

        $getTransactionLists = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $totalAmountCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->sum('wimpys_food_express_payment_vouchers.amount_due');


            $check = "CHECK";
            $getTransactionListChecks = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->get()->toArray();
    
            $status = "FULLY PAID AND RELEASED";
            $totalAmountCheck = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->sum('wimpys_food_express_payment_vouchers.amount_due');
            
        return view('wimpys-food-express-multiple-summary-report', compact('getTransactionLists', 'startDate', 'endDate', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));


    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');
        $moduleNamePV = "Payment Voucher";

        $getTransactionLists = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $totalAmountCashes = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->sum('wimpys_food_express_payment_vouchers.amount_due');
                    
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.cheque_total_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                            ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->sum('wimpys_food_express_payment_vouchers.amount_due');
        
        return view('wimpys-food-express-get-summary-report', compact('getDate', 'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
    
                    
    }

    public function summaryReport(){    
        $getDateToday = date("Y-m-d");
        $moduleNamePV = "Payment Voucher";

        $getTransactionLists = DB::table(
            'wimpys_food_express_payment_vouchers')
            ->select( 
            'wimpys_food_express_payment_vouchers.id',
            'wimpys_food_express_payment_vouchers.user_id',
            'wimpys_food_express_payment_vouchers.pv_id',
            'wimpys_food_express_payment_vouchers.date',
            'wimpys_food_express_payment_vouchers.paid_to',
            'wimpys_food_express_payment_vouchers.account_no',
            'wimpys_food_express_payment_vouchers.account_name',
            'wimpys_food_express_payment_vouchers.particulars',
            'wimpys_food_express_payment_vouchers.amount',
            'wimpys_food_express_payment_vouchers.method_of_payment',
            'wimpys_food_express_payment_vouchers.prepared_by',
            'wimpys_food_express_payment_vouchers.approved_by',
            'wimpys_food_express_payment_vouchers.date_approved',
            'wimpys_food_express_payment_vouchers.received_by_date',
            'wimpys_food_express_payment_vouchers.created_by',
            'wimpys_food_express_payment_vouchers.created_at',
            'wimpys_food_express_payment_vouchers.invoice_number',
            'wimpys_food_express_payment_vouchers.issued_date',
            'wimpys_food_express_payment_vouchers.category',
            'wimpys_food_express_payment_vouchers.amount_due',
            'wimpys_food_express_payment_vouchers.delivered_date',
            'wimpys_food_express_payment_vouchers.status',
            'wimpys_food_express_payment_vouchers.cheque_number',
            'wimpys_food_express_payment_vouchers.cheque_amount',
            'wimpys_food_express_payment_vouchers.cheque_total_amount',
            'wimpys_food_express_payment_vouchers.sub_category',
            'wimpys_food_express_payment_vouchers.sub_category_account_id',
            'wimpys_food_express_payment_vouchers.deleted_at',
            'wimpys_food_express_codes.wimpys_food_express_code',
            'wimpys_food_express_codes.module_id',
            'wimpys_food_express_codes.module_code',
            'wimpys_food_express_codes.module_name')
            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
            ->get()->toArray();

    $cash = "CASH";
    $getTransactionListCashes = DB::table(
            'wimpys_food_express_payment_vouchers')
            ->select( 
            'wimpys_food_express_payment_vouchers.id',
            'wimpys_food_express_payment_vouchers.user_id',
            'wimpys_food_express_payment_vouchers.pv_id',
            'wimpys_food_express_payment_vouchers.date',
            'wimpys_food_express_payment_vouchers.paid_to',
            'wimpys_food_express_payment_vouchers.account_no',
            'wimpys_food_express_payment_vouchers.account_name',
            'wimpys_food_express_payment_vouchers.particulars',
            'wimpys_food_express_payment_vouchers.amount',
            'wimpys_food_express_payment_vouchers.method_of_payment',
            'wimpys_food_express_payment_vouchers.prepared_by',
            'wimpys_food_express_payment_vouchers.approved_by',
            'wimpys_food_express_payment_vouchers.date_approved',
            'wimpys_food_express_payment_vouchers.received_by_date',
            'wimpys_food_express_payment_vouchers.created_by',
            'wimpys_food_express_payment_vouchers.created_at',
            'wimpys_food_express_payment_vouchers.invoice_number',
            'wimpys_food_express_payment_vouchers.issued_date',
            'wimpys_food_express_payment_vouchers.category',
            'wimpys_food_express_payment_vouchers.amount_due',
            'wimpys_food_express_payment_vouchers.delivered_date',
            'wimpys_food_express_payment_vouchers.status',
            'wimpys_food_express_payment_vouchers.cheque_number',
            'wimpys_food_express_payment_vouchers.cheque_amount',
            'wimpys_food_express_payment_vouchers.cheque_total_amount',
            'wimpys_food_express_payment_vouchers.sub_category',
            'wimpys_food_express_payment_vouchers.sub_category_account_id',
            'wimpys_food_express_payment_vouchers.deleted_at',
            'wimpys_food_express_codes.wimpys_food_express_code',
            'wimpys_food_express_codes.module_id',
            'wimpys_food_express_codes.module_code',
            'wimpys_food_express_codes.module_name')
            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
            ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
            ->get()->toArray();

    $totalAmountCashes = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->sum('wimpys_food_express_payment_vouchers.amount_due');

    $check = "CHECK";
    $getTransactionListChecks = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();
    
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->sum('wimpys_food_express_payment_vouchers.amount_due');


        return view('wimpys-food-express-summary-report', compact('getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function transactionOrder($id){
        
        $categoryKitchen = "Kitchen";
        $categoryDessert = "Dessert";
        $categoryDecor = "Decor";
        $categoryEqup  = "Equipment and Supplies";

        $getMaterials = WimpysFoodExpressStockInventory::where('category',$categoryKitchen)->get()->toArray();

        $getMaterials2 = WimpysFoodExpressStockInventory::where('category', $categoryDessert)->get()->toArray();

        $getMaterials3 = WimpysFoodExpressStockInventory::where('category', $categoryDecor)->get()->toArray();
        
        $getMaterials4 = WimpysFoodExpressStockInventory::where('category', $categoryEqup)->get()->toArray();

        $transaction = DB::table(
                        'wimpys_food_express_order_forms')
                        ->select(
                        'wimpys_food_express_order_forms.user_id',
                        'wimpys_food_express_order_forms.order_id',
                        'wimpys_food_express_order_forms.date',
                        'wimpys_food_express_order_forms.time',
                        'wimpys_food_express_order_forms.no_of_people',
                        'wimpys_food_express_order_forms.items',
                        'wimpys_food_express_order_forms.qty',
                        'wimpys_food_express_order_forms.unit',
                        'wimpys_food_express_order_forms.price',
                        'wimpys_food_express_order_forms.total',
                        'wimpys_food_express_order_forms.deleted_at')
                        ->where('wimpys_food_express_order_forms.id', $id)
                        ->get();
        

        return view('wimpys-food-express-order-form-transactions', compact('id','getMaterials', 
        'getMaterials2', 'getMaterials3', 'getMaterials4', 'transaction'));
    }

    public function addForm(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
        $getDate =  date("Y-m-d");

        if($request->quantity == 1){
            $priceT = $request->price;
             
        }else{
            $priceT = $request->total;
        }


        $addItem = new WimpysFoodExpressOrderForm([
            'user_id'=>$user->id,
            'date'=>$getDate,
            'items'=>$request->productName,
            'qty'=>$request->quantity,
            'unit'=>$request->unit,
            'price'=>$request->price,
            'total'=>$priceT,
            'created_by'=>$name,
        ]);

        $addItem->save();   
        $insertId = $addItem->id; 
        
        return response()->json($insertId);

        
    }

    public function orderForm(){
        $categoryKitchen = "Kitchen";
        $categoryDessert = "Dessert";
        $categoryDecor = "Decor";
        $categoryEqup  = "Equipment and Supplies";

        $getMaterials = WimpysFoodExpressStockInventory::where('category',$categoryKitchen)->get()->toArray();

        $getMaterials2 = WimpysFoodExpressStockInventory::where('category', $categoryDessert)->get()->toArray();

        $getMaterials3 = WimpysFoodExpressStockInventory::where('category', $categoryDecor)->get()->toArray();
        
        $getMaterials4 = WimpysFoodExpressStockInventory::where('category', $categoryEqup)->get()->toArray();
        
        return view('wimpys-food-express-order-form', compact('getMaterials', 'getMaterials2', 
        'getMaterials3', 'getMaterials4'));
    }

    public function updateRawMaterial(Request $request){
        $updateRawMaterial = WimpysFoodExpressStockInventory::find($request->id);

        $updateRawMaterial->product_name = $request->productName;
        $updateRawMaterial->price = $request->price;
        $updateRawMaterial->category = $request->category;
        $updateRawMaterial->save();
        
        return response()->json('Success: successfully updated.');  

    }

    public function addRawMaterial(Request $request){   
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //check if product name name exits
        $target = DB::table(
            'wimpys_food_express_stock_inventories')
            ->where('product_name', $request->productName)
            ->get()->first(); 

        if($target === NULL){
            $addNewMaterial = new WimpysFoodExpressStockInventory([
                'user_id'=>$user->id,
                'product_name'=>$request->productName,
                'unit'=>$request->unit,
                'price'=>$request->price,
                'category'=>$request->category,
                'created_by'=>$name,
            ]);

            $addNewMaterial->save();

            return response()->json('Success: successfully add material.'); 
        }else{
            return response()->json('Failed: Already exist.');
        }
    }

    public function rawMaterials(){
        $getMaterials = WimpysFoodExpressStockInventory::get()->toArray();

        return view('wimpys-food-express-raw-materials', ['getMaterials'=>$getMaterials]);
    }

    public function printSOAList(){
        $printSOAStatements = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('billing_statement_id', NULL)
                                                                    ->where('deleted_at', NULL)
                                                                    ->orderBy('id', 'desc')
                                                                    ->get();
            $status = "PAID";
            $moduleName = "Statement Of Account";
            $totalAmount  =   DB::table(
                            'wimpys_food_express_statement_of_accounts')
                            ->select(
                            'wimpys_food_express_statement_of_accounts.id',
                            'wimpys_food_express_statement_of_accounts.user_id',
                            'wimpys_food_express_statement_of_accounts.billing_statement_id',
                            'wimpys_food_express_statement_of_accounts.bill_to',
                            'wimpys_food_express_statement_of_accounts.address',
                            'wimpys_food_express_statement_of_accounts.date',
                            'wimpys_food_express_statement_of_accounts.period_cover',
                            'wimpys_food_express_statement_of_accounts.terms',
                            'wimpys_food_express_statement_of_accounts.date_of_transaction',
                            'wimpys_food_express_statement_of_accounts.description',
                            'wimpys_food_express_statement_of_accounts.amount',
                            'wimpys_food_express_statement_of_accounts.total_amount',
                            'wimpys_food_express_statement_of_accounts.paid_amount',
                            'wimpys_food_express_statement_of_accounts.payment_method',
                            'wimpys_food_express_statement_of_accounts.collection_date',
                            'wimpys_food_express_statement_of_accounts.check_number',
                            'wimpys_food_express_statement_of_accounts.check_amount',
                            'wimpys_food_express_statement_of_accounts.or_number',
                            'wimpys_food_express_statement_of_accounts.status',
                            'wimpys_food_express_statement_of_accounts.created_by',
                            'wimpys_food_express_statement_of_accounts.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_statement_of_accounts.billing_statement_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleName)
                            ->where('wimpys_food_express_statement_of_accounts.status', '=', $status)
                            ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                            ->sum('wimpys_food_express_statement_of_accounts.total_amount');
                                                
            $totalRemainingBalance  =   DB::table(
                                'wimpys_food_express_statement_of_accounts')
                                ->select(
                                'wimpys_food_express_statement_of_accounts.id',
                                'wimpys_food_express_statement_of_accounts.user_id',
                                'wimpys_food_express_statement_of_accounts.billing_statement_id',
                                'wimpys_food_express_statement_of_accounts.bill_to',
                                'wimpys_food_express_statement_of_accounts.address',
                                'wimpys_food_express_statement_of_accounts.date',
                                'wimpys_food_express_statement_of_accounts.period_cover',
                                'wimpys_food_express_statement_of_accounts.terms',
                                'wimpys_food_express_statement_of_accounts.date_of_transaction',
                                'wimpys_food_express_statement_of_accounts.description',
                                'wimpys_food_express_statement_of_accounts.amount',
                                'wimpys_food_express_statement_of_accounts.total_amount',
                                'wimpys_food_express_statement_of_accounts.total_remaining_balance',
                                'wimpys_food_express_statement_of_accounts.paid_amount',
                                'wimpys_food_express_statement_of_accounts.payment_method',
                                'wimpys_food_express_statement_of_accounts.collection_date',
                                'wimpys_food_express_statement_of_accounts.check_number',
                                'wimpys_food_express_statement_of_accounts.check_amount',
                                'wimpys_food_express_statement_of_accounts.or_number',
                                'wimpys_food_express_statement_of_accounts.status',
                                'wimpys_food_express_statement_of_accounts.created_by',
                                'wimpys_food_express_statement_of_accounts.deleted_at',
                                'wimpys_food_express_codes.wimpys_food_express_code',
                                'wimpys_food_express_codes.module_id',
                                'wimpys_food_express_codes.module_code',
                                'wimpys_food_express_codes.module_name')
                                ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                                ->where('wimpys_food_express_statement_of_accounts.billing_statement_id', NULL)
                                ->where('wimpys_food_express_codes.module_name', $moduleName)
                                ->where('wimpys_food_express_statement_of_accounts.status', NULL)
                                ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                                ->sum('wimpys_food_express_statement_of_accounts.total_remaining_balance');

            $pdf = PDF::loadView('printSOAListsWimpysFoodexp', compact('printSOAStatements', 
            'totalAmount', 'totalRemainingBalance'));

            return $pdf->download('wimpys-food-express-statement-of-account-list-all.pdf');
                                                            
    }

    public function printSOA($id){
        $soa = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                        ->where('billing_statement_id', NULL)
                                                        ->orderBy('id', 'desc')
                                                        ->get();                                                   
                                                        
        $statementAccounts = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->get()->toArray();

        $moduleName = "Statement Of Account";
        $countTotalAmount =  DB::table(
                            'wimpys_food_express_statement_of_accounts')
                            ->select(
                            'wimpys_food_express_statement_of_accounts.id',
                            'wimpys_food_express_statement_of_accounts.user_id',
                            'wimpys_food_express_statement_of_accounts.billing_statement_id',
                            'wimpys_food_express_statement_of_accounts.bill_to',
                            'wimpys_food_express_statement_of_accounts.address',
                            'wimpys_food_express_statement_of_accounts.date',
                            'wimpys_food_express_statement_of_accounts.period_cover',
                            'wimpys_food_express_statement_of_accounts.terms',
                            'wimpys_food_express_statement_of_accounts.date_of_transaction',
                            'wimpys_food_express_statement_of_accounts.description',
                            'wimpys_food_express_statement_of_accounts.amount',
                            'wimpys_food_express_statement_of_accounts.paid_amount',
                            'wimpys_food_express_statement_of_accounts.payment_method',
                            'wimpys_food_express_statement_of_accounts.collection_date',
                            'wimpys_food_express_statement_of_accounts.check_number',
                            'wimpys_food_express_statement_of_accounts.check_amount',
                            'wimpys_food_express_statement_of_accounts.or_number',
                            'wimpys_food_express_statement_of_accounts.status',
                            'wimpys_food_express_statement_of_accounts.created_by',
                            'wimpys_food_express_statement_of_accounts.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_statement_of_accounts.id', $id)
                            ->where('wimpys_food_express_codes.module_name', $moduleName)
                            ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                            ->sum('wimpys_food_express_statement_of_accounts.amount');

        $countAmount = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        //
        $countAmount = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');


        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printSOAWimpysFoodExp', compact('soa', 'statementAccounts', 'sum'));

        return $pdf->download('wimpys-food-express-statement-of-account.pdf');

    }

    public function viewStatementAccount($id){
        $viewStatementAccount = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('id', $id)
                                                                    ->get();

        $statementAccounts = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->get();

        //count the total amount 
        $countTotalAmount = WimpysFoodExpressStatementOfAccount::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        //count the total balance if there are paid amount
        $paidAmountCount = WimpysFoodExpressStatementOfAccount::where('id', $id)->sum('paid_amount');

        //
        $countAmountOthersPaid = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');

        $compute  = $paidAmountCount + $countAmountOthersPaid;


        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('view-wimpys-food-express-statement-account', compact('viewStatementAccount', 'statementAccounts', 'sum', 'computeAll'));

    }

    public function sAccountUpdate(Request $request, $id){
          //get the main Id 
          $mainIdSoa = WimpysFoodExpressStatementOfAccount::find($request->mainId);

          $compute = $mainIdSoa->total_remaining_balance - $request->paidAmount;
          
          $mainIdSoa->total_remaining_balance = $compute; 
          $mainIdSoa->save();
  
          $statementAccountPaid = WimpysFoodExpressStatementOfAccount::find($request->id);
          $statementAccountPaid->paid_amount = $request->paidAmount;
          $statementAccountPaid->status = $request->status;
          $statementAccountPaid->collection_date = $request->collectionDate;
          $statementAccountPaid->check_number = $request->checkNumber;
          $statementAccountPaid->check_amount = $request->checkAmount;
          $statementAccountPaid->or_number = $request->orNumber;
          $statementAccountPaid->payment_method = $request->payment;
  
          $statementAccountPaid->save();
  
          return response()->json('Success: paid successfully');
   
    }

    public function editStatementAccount($id){  
        $getStatementOfAccount = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                            ->where('id', $id)
                                                                            ->get();
        //AllAcounts not yet paid
        $allAccounts = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('status', NULL)->get()->toArray();

        $stat = "PAID";
        $allAccountsPaids = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('status', $stat)->get()->toArray();  

        //count the total amount 
        $countTotalAmount = WimpysFoodExpressStatementOfAccount::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        //count the total balance if there are paid amount
        $paidAmountCount = WimpysFoodExpressStatementOfAccount::where('id', $id)->sum('paid_amount');

        //
        $countAmountOthersPaid = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');

        $compute  = $paidAmountCount + $countAmountOthersPaid;

        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('edit-wimpys-food-express-statement-of-account', compact('id', 'getStatementOfAccount', 'computeAll', 'allAccounts', 'allAccountsPaids', 'sum'));

    }   

    public function statementOfAccountLists(){
        $statementOfAccounts = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('billing_statement_id', NULL)
                                                                    ->where('deleted_at', NULL)
                                                                    ->orderBy('id', 'desc')
                                                                    ->get();

        $status = "PAID";
        $moduleName = "Statement Of Account";
        $totalAmount  =   DB::table(
                        'wimpys_food_express_statement_of_accounts')
                        ->select(
                        'wimpys_food_express_statement_of_accounts.id',
                        'wimpys_food_express_statement_of_accounts.user_id',
                        'wimpys_food_express_statement_of_accounts.billing_statement_id',
                        'wimpys_food_express_statement_of_accounts.bill_to',
                        'wimpys_food_express_statement_of_accounts.address',
                        'wimpys_food_express_statement_of_accounts.date',
                        'wimpys_food_express_statement_of_accounts.period_cover',
                        'wimpys_food_express_statement_of_accounts.terms',
                        'wimpys_food_express_statement_of_accounts.date_of_transaction',
                        'wimpys_food_express_statement_of_accounts.description',
                        'wimpys_food_express_statement_of_accounts.amount',
                        'wimpys_food_express_statement_of_accounts.total_amount',
                        'wimpys_food_express_statement_of_accounts.paid_amount',
                        'wimpys_food_express_statement_of_accounts.payment_method',
                        'wimpys_food_express_statement_of_accounts.collection_date',
                        'wimpys_food_express_statement_of_accounts.check_number',
                        'wimpys_food_express_statement_of_accounts.check_amount',
                        'wimpys_food_express_statement_of_accounts.or_number',
                        'wimpys_food_express_statement_of_accounts.status',
                        'wimpys_food_express_statement_of_accounts.created_by',
                        'wimpys_food_express_statement_of_accounts.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_statement_of_accounts.billing_statement_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleName)
                        ->where('wimpys_food_express_statement_of_accounts.status', '=', $status)
                        ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                        ->sum('wimpys_food_express_statement_of_accounts.total_amount');
                                            
        $totalRemainingBalance  =   DB::table(
                            'wimpys_food_express_statement_of_accounts')
                            ->select(
                            'wimpys_food_express_statement_of_accounts.id',
                            'wimpys_food_express_statement_of_accounts.user_id',
                            'wimpys_food_express_statement_of_accounts.billing_statement_id',
                            'wimpys_food_express_statement_of_accounts.bill_to',
                            'wimpys_food_express_statement_of_accounts.address',
                            'wimpys_food_express_statement_of_accounts.date',
                            'wimpys_food_express_statement_of_accounts.period_cover',
                            'wimpys_food_express_statement_of_accounts.terms',
                            'wimpys_food_express_statement_of_accounts.date_of_transaction',
                            'wimpys_food_express_statement_of_accounts.description',
                            'wimpys_food_express_statement_of_accounts.amount',
                            'wimpys_food_express_statement_of_accounts.total_amount',
                            'wimpys_food_express_statement_of_accounts.total_remaining_balance',
                            'wimpys_food_express_statement_of_accounts.paid_amount',
                            'wimpys_food_express_statement_of_accounts.payment_method',
                            'wimpys_food_express_statement_of_accounts.collection_date',
                            'wimpys_food_express_statement_of_accounts.check_number',
                            'wimpys_food_express_statement_of_accounts.check_amount',
                            'wimpys_food_express_statement_of_accounts.or_number',
                            'wimpys_food_express_statement_of_accounts.status',
                            'wimpys_food_express_statement_of_accounts.created_by',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_statement_of_accounts.billing_statement_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleName)
                            ->where('wimpys_food_express_statement_of_accounts.status', NULL)
                            ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                            ->sum('wimpys_food_express_statement_of_accounts.total_remaining_balance');

        return view('wimpys-food-express-statement-of-account-lists', compact('statementOfAccounts',
        'totalAmount', 'totalRemainingBalance'));
    }

    public function printBillingStatement($id){
        $printBillingStatement = WimpysFoodExpressBillingStatement::with(['user', 'billing_statements'])
                                                                        ->where('id', $id)
                                                                        ->get();

        $billingStatements = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = WimpysFoodExpressBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printBillingStatementWimpysFoodExpress', compact('printBillingStatement', 'billingStatements', 'sum'));

        return $pdf->download('wimpys-food-express-billing-statement.pdf'); 
    }

    public function viewBillingStatement($id){
        $viewBillingStatement = WimpysFoodExpressBillingStatement::with(['user', 'billing_statements'])
                                                                ->where('id', $id)
                                                                ->get();


        $billingStatements = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = WimpysFoodExpressBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-wimpys-food-express-billing-statement', compact('viewBillingStatement', 'billingStatements', 'sum'));

    }

    public function billingStatementList(){
        $billingStatements = WimpysFoodExpressBillingStatement::with(['user', 'billing_statements'])
                                                                ->where('billing_statement_id', NULL)
                                                                ->where('deleted_at', NULL)
                                                                ->orderBy('id', 'desc')
                                                                ->get();

        return view('wimpys-food-express-billing-statement-lists', compact('billingStatements'));
    }

    public function updateBillingInfo(Request $request, $id){   
        $updateBillingOrder = WimpysFoodExpressBillingStatement::find($id);

        $getOtherBilling = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->get();
       
        if(isset($getOtherBilling[0]->amount) == ""){
            $amount = $request->get('amount');
            $getOtherAmount = 0 + $amount; 

        }else{
            $amount = $request->get('amount');
            $getOtherAmount = $getOtherBilling[0]->amount + $amount; 
        
        }
     

        $updateBillingOrder->bill_to = $request->get('billTo');
        $updateBillingOrder->address = $request->get('address');
        $updateBillingOrder->period_cover = $request->get('periodCovered');
      
        $updateBillingOrder->terms = $request->get('terms');
        $updateBillingOrder->date_of_transaction = $request->get('transactionDate');
        $updateBillingOrder->dr_no = $request->get('drNo');
        $updateBillingOrder->description = $request->get('description');
        $updateBillingOrder->unit_price = $request->get('unitPrice');
        $updateBillingOrder->amount = $request->get('amount');
        $updateBillingOrder->total_amount = $getOtherAmount;
        $updateBillingOrder->save();


             
        //statement of account
        $getMainStatement = WimpysFoodExpressStatementOfAccount::find($id);

        $getStatement = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->get();
      
        if(isset($getStatement[0]->amount) == ""){
            $amount = $request->get('amount');
            $getOtherAmountSOA = 0 + $amount; 

        }else{
            $amount = $request->get('amount');
            $getOtherAmountSOA = $getStatement[0]->amount + $amount; 
        
        }

        $getMainStatement->bill_to = $request->get('billTo');
        $getMainStatement->period_cover = $request->get('periodCovered');
      
        $getMainStatement->terms = $request->get('terms');
        $getMainStatement->date_of_transaction = $request->get('transactionDate');
        $getMainStatement->dr_no = $request->get('drNo');
        $getMainStatement->description = $request->get('description');
        $getMainStatement->unit_price = $request->get('unitPrice');
        $getMainStatement->amount =  $request->get('amount');
        $getMainStatement->total_amount = $getOtherAmountSOA;
        $getMainStatement->total_remaining_balance = $getOtherAmountSOA;
        $getMainStatement->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect()->route('editBillingStatementWimpysFoodExp', ['id'=>$id]);
    }

    public function addNewBilling(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = WimpysFoodExpressBillingStatement::find($id);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $amount = $request->get('amount');

        $tot = $billingOrder->total_amount + $amount; 

        $addBillingStatement = new WimpysFoodExpressBillingStatement([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'date_of_transaction'=>$request->get('transactionDate'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'dr_no'=>$request->get('drNo'),
            'amount'=>$amount,
            'created_by'=>$name,
        ]);

        $addBillingStatement->save();

        $addStatementAccount = new WimpysFoodExpressStatementOfAccount([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'date_of_transaction'=>$request->get('transactionDate'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'dr_no'=>$request->get('drNo'),
            'amount'=>$amount,
            'total_amount'=>$amount,
            'created_by'=>$name,
        ]);
        $addStatementAccount->save();
        $statementOrder = WimpysFoodExpressStatementOfAccount::find($id);
        
        //update
        $billingOrder->total_amount = $tot;
        $billingOrder->save();

        //update soa table
        $statementOrder->total_amount  = $tot;
        $statementOrder->total_remaining_balance = $tot;
        $statementOrder->save();
            
        Session::flash('SuccessAdd', 'Successfully added.');

        return redirect()->route('editBillingStatementWimpysFoodExp', ['id'=>$id]);

    }

    public function editBillingStatement($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $billingStatement = WimpysFoodExpressBillingStatement::find($id);

        $bStatements = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        return view('edit-wimpys-food-express-billing-statement-form', compact('billingStatement', 'bStatements'));
    
    }

    public function storeBillingStatement(Request $request){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName." ".$lastName;

        $this->validate($request,[
            'billTo' =>'required',
            'address'=>'required',
            'periodCovered'=>'required',
            'date'=>'required',
            'terms'=>'required',
            'transactionDate'=>'required',
        ]);

         //get the latest insert id query in table billing statements ref number
         $dataReferenceNum = DB::select('SELECT id, wimpys_food_express_code FROM wimpys_food_express_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 reference number
         if(isset($dataReferenceNum[0]->wimpys_food_express_code) != 0){
             //if code is not 0
             $newRefNum = $dataReferenceNum[0]->wimpys_food_express_code +1;
             $uRef = sprintf("%06d",$newRefNum);   
 
         }else{
             //if code is 0 
             $newRefNum = 1;
             $uRef = sprintf("%06d",$newRefNum);
         } 

         $target = DB::table(
                    'wimpys_food_express_billing_statements')
                    ->where('dr_no', $request->get('dr_no'))
                    ->get()->first();

        if($target === NULL){
            $billingStatement = new WimpysFoodExpressBillingStatement([
                'user_id'=>$user->id,
                'bill_to'=>$request->get('billTo'),
                'address'=>$request->get('address'),
                'period_cover'=>$request->get('periodCovered'),
                'date'=>$request->get('date'),
                'terms'=>$request->get('terms'),
                'dr_no'=>$request->get('drNo'),
                'date_of_transaction'=>$request->get('transactionDate'),
                'description'=>$request->get('description'),
                'unit_price'=>$request->get('unitPrice'),
                'amount'=>$request->get('amount'),
                'total_amount'=>$request->get('amount'),
                'created_by'=>$name,
                'prepared_by'=>$name,
            ]);

            $billingStatement->save();

            $insertedId = $billingStatement->id;
    
            $moduleCode = "BS-";
            $moduleName = "Billing Statement";

            $wimpysFoodExp = new WimpysFoodExpressCode([
                'user_id'=>$user->id,
                'wimpys_food_express_code'=>$uRef,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
    
            ]);
    
            $wimpysFoodExp->save();
            $bsNo = $wimpysFoodExp->id;

            $bsNoId = WimpysFoodExpressCode::find($bsNo);

            $statementAccount = new WimpysFoodExpressStatementOfAccount([
                'user_id'=>$user->id,
                'bs_no'=>$bsNoId->wimpys_food_express_code,
                'bill_to'=>$request->get('billTo'),
                'period_cover'=>$request->get('periodCovered'),
                'date'=>$request->get('date'),
                'terms'=>$request->get('terms'),
                'dr_no'=>$request->get('drNo'),
                'date_of_transaction'=>$request->get('transactionDate'),
                'description'=>$request->get('description'),
                'unit_price'=>$request->get('unitPrice'),
                'amount'=>$request->get('amount'),
                'total_amount'=>$request->get('amount'),
                'total_remaining_balance'=>$request->get('amount'),
                'created_by'=>$name,
                'prepared_by'=>$name,
            ]);
            $statementAccount->save();
            $insertedIdStatement = $statementAccount->id;

            $moduleCodeSOA = "SOA-";
            $moduleNameSOA = "Statement Of Account";
            
            $uRefStatement = $uRef + 1; 
            $uRefState = sprintf("%06d",$uRefStatement);

            $statement = new WimpysFoodExpressCode([
                'user_id'=>$user->id,
                'wimpys_food_express_code'=>$uRefState,
                'module_id'=>$insertedIdStatement,
                'module_code'=>$moduleCodeSOA,
                'module_name'=>$moduleNameSOA,
    
            ]);
            $statement->save();

            return redirect()->route('editBillingStatementWimpysFoodExp', ['id'=>$insertedId]);

        }else{
            return redirect()->route('billingStatementFormWimpysFoodExp')->with('error', 'DR Number Already Exists. Please See Transaction List For Your Reference');
      
        }




    }

    public function billingStatementForm(){
        return view('wimpys-food-exoress-billing-statement-form');
    }

    public function printPO($id){
        $purchaseOrder =  WimpysFoodExpressPurchaseOrder::with(['user', 'purchase_orders'])
                                            ->where('id', $id)                     
                                            ->get(); 

           
        $pOrders = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->get()->toArray();

            //count the total amount 
        $countTotalAmount = WimpysFoodExpressPurchaseOrder::where('id', $id)->sum('amount');
    
            //
        $countAmount = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->sum('amount');
    
        $sum  = $countTotalAmount + $countAmount;
    
    
        $pdf = PDF::loadView('printPOWimpysFoodExpress', compact('purchaseOrder', 'pOrders', 'sum'));
    
        return $pdf->download('wimpys-food-express-purchase-order.pdf');
    }

    public function purchaseOrderList(){
        $purchaseOrders =  WimpysFoodExpressPurchaseOrder::with(['user', 'purchase_orders'])
                                                ->where('po_id', NULL)
                                                ->where('deleted_at', NULL)
                                                ->orderBy('id', 'desc')
                                                ->get(); 
       
        return view('wimpys-food-express-purchase-order-list', compact('purchaseOrders'));
    }

    public function updatePo(Request $request, $id){
        $order = WimpysFoodExpressPurchaseOrder::find($id);
        $order->quantity = $request->get('quant');
        $order->description = $request->get('desc');
        $order->unit_price = $request->get('unitP');
        $order->amount = $request->get('amt');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect()->route('editWimpysFoodExpress', ['id'=>$request->get('poId')]);
    }

    public function addNewPurchaseOrder(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pO = WimpysFoodExpressPurchaseOrder::find($id);
    
        $tot = $pO->total_price + $request->get('amount');

        $addPurchaseOrder = new WimpysFoodExpressPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addPurchaseOrder->save();

        //update
        $pO->total_price = $tot;
        $pO->save();

        Session::flash('purchaseOrderSuccess', 'Successfully added purchase order');

        return redirect()->route('editWimpysFoodExpress', ['id'=>$id]);
    }

    public function purchaseOrder(){
        return view('wimpys-food-express-purchase-order');
    }

    public function printSupplier($id){
        $printSuppliers =  WimpysFoodExpressSupplier::with(['user', 'suppliers'])
                                                ->where('id', $id)
                                                ->get(); 

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue  = DB::table(
                            'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.supplier_id',
                            'wimpys_food_express_payment_vouchers.supplier_name',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_suppliers.id',
                            'wimpys_food_express_suppliers.date',
                            'wimpys_food_express_suppliers.supplier_name')
                            ->leftJoin('wimpys_food_express_suppliers', 'wimpys_food_express_payment_vouchers.supplier_id', '=', 'wimpys_food_express_suppliers.id')
                            ->where('wimpys_food_express_suppliers.id', $id)
                            ->where('wimpys_food_express_payment_vouchers.status', '!=', $status)
                            ->sum('amount_due');
                                        
        
        $pdf = PDF::loadView('printSupplierWimpys', compact('printSuppliers', 'totalAmountDue'));

        return $pdf->download('wimpys-food-express-supplier.pdf');
    }

    public function viewSupplier($id){
        $viewSuppliers =  WimpysFoodExpressSupplier::with(['user', 'suppliers'])
                                                ->where('id', $id)
                                                ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue  = DB::table(
                            'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.supplier_id',
                            'wimpys_food_express_payment_vouchers.supplier_name',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_suppliers.id',
                            'wimpys_food_express_suppliers.date',
                            'wimpys_food_express_suppliers.supplier_name')
                            ->leftJoin('wimpys_food_express_suppliers', 'wimpys_food_express_payment_vouchers.supplier_id', '=', 'wimpys_food_express_suppliers.id')
                            ->where('wimpys_food_express_suppliers.id', $id)
                            ->where('wimpys_food_express_payment_vouchers.status', '!=', $status)
                            ->sum('amount_due');
            
        return view('view-wimpys-food-express-supplier', compact('viewSuppliers', 'totalAmountDue'));
    }


    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

            //check if supplier name exits
        $target = DB::table(
                'wimpys_food_express_suppliers')
                ->where('supplier_name', $request->supplierName)
                ->get()->first();

        if($target === NULL){
            $supplier = new WimpysFoodExpressSupplier([
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
        $suppliers = WimpysFoodExpressSupplier::with(['user', 'suppliers'])
                                            ->orderBy('id', 'desc')
                                            ->get();
        return view('wimpys-food-express-supplier', compact('suppliers'));
    }

    public function printPayables($id){
        $payableId = WimpysFoodExpressPaymentVoucher::with(['user','payment_vouchers'])
                                ->where('id', $id)
                                ->get();   

        //getParticular details
        $getParticulars = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
    
        $getChequeNumbers = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
        $amount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
        

        $pdf = PDF::loadView('printPayablesWimpysFoodExpress', compact('payableId',  
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

        return $pdf->download('wimpys-food-express-payment-voucher.pdf');
    }

    public function viewPayableDetails($id){
        $viewPaymentDetail = WimpysFoodExpressPaymentVoucher::with(['user','payment_vouchers'])
                                                            ->where('id', $id)
                                                            ->withTrashed()
                                                            ->get(); 
                            
        $getChequeNumbers = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        $getCashAmounts = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        

        //getParticular details
        $getParticulars = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
    
        //amount
        $amount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('view-wimpys-food-express-payable-details', compact('viewPaymentDetail', 
        'getChequeNumbers', 'getCashAmounts', 'getParticulars', 'sum', 'sumCheque'));
    }

    public function transactionList(){
        $getTransactionLists = WimpysFoodExpressPaymentVoucher::with(['user','payment_vouchers'])
                                        ->where('pv_id', NULL)
                                        ->where('deleted_at', NULL)
                                        ->orderBy('id', 'desc')
                                        ->get();

        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = WimpysFoodExpressPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');
        

        return view('wimpys-food-transaction-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));
        
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
  
                      $payables = WimpysFoodExpressPaymentVoucher::find($id);
                      $payables->status = $status;
                      $payables->delivered_date = $getDate;
                      $payables->created_by = $name; 
                      $payables->save();
  
                      Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');
  
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
  
          }else if($status == "FOR APPROVAL"){
              switch ($request->get('action')) {
                  case 'PAID & HOLD':
                      # code...
                      $payables = WimpysFoodExpressPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                       Session::flash('payablesSuccess', 'Status set for approval.');
  
                       return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
  
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
          }else{
  
              switch ($request->get('action')) {
                  case 'PAID & HOLD':
                      # code...
                      $payables = WimpysFoodExpressPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                      Session::flash('payablesSuccess', 'Status set for confirmation.');
  
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
                      
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
          }  
    
    }

    public function updateDetails(Request $request){
        $updateDetails = WimpysFoodExpressPaymentVoucher::find($request->id);

        $updateDetails->paid_to =  $request->paidTo;
        $updateDetails->invoice_number = $request->invoiceNo;
        $updateDetails->account_name = $request->accountName;
 
        $updateDetails->save();
 
        return response()->json('Success: successfully updated.');
    }

    public function updateParticulars(Request $request){
        $updateParticular =  WimpysFoodExpressPaymentVoucher::find($request->id);

        $amount = $request->amount; 
     
        $tot = WimpysFoodExpressPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 
 
        $updateParticular->date = $request->date;
        $updateParticular->particulars = $request->particulars;
        $updateParticular->amount = $amount;
        $updateParticular->amount_due = $sum;
        $updateParticular->save();
 
        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
          //main id 
          $updateParticular = WimpysFoodExpressPaymentVoucher::find($request->transId);

          //particular id
          $uIdParticular = WimpysFoodExpressPaymentVoucher::find($request->id);
  
          $amount = $request->amount; 
  
          $updateAmount =  $updateParticular->amount; 
         
          $uParticular = WimpysFoodExpressPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
          
          $tot = $updateAmount + $uParticular; 
         
        
          $uIdParticular->date  = $request->date;
          $uIdParticular->particulars = $request->particulars;
          $uIdParticular->amount = $amount; 
          $uIdParticular->save();
  
          $updateParticular->amount_due = $tot;
          $updateParticular->save();
          
          return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = WimpysFoodExpressPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){   
        $updateCash = WimpysFoodExpressPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = WimpysFoodExpressPaymentVoucher::find($id);

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');

        //save payment cheque num and cheque amount
        $addPayment = new WimpysFoodExpressPaymentVoucher([
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

        return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
 
    }

    public function addParticulars(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = WimpysFoodExpressPaymentVoucher::find($id);

        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

        $addParticulars = new WimpysFoodExpressPaymentVoucher([
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


        return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
    }

    public function editPayablesDetail(Request $request, $id){
        $transactionList = WimpysFoodExpressPaymentVoucher::with(['user','payment_vouchers'])
                                ->where('id', $id)
                                ->get();

        $getChequeNumbers = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        $getCashAmounts = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
        //getParticular details
        $getParticulars = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        //amount
        $amount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('wimpys-food-express-payables-detail', compact('transactionList', 'getChequeNumbers','sum'
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

          //get the latest insert id query in table lechon de cebu
          $dataCode = DB::select('SELECT id, wimpys_food_express_code FROM wimpys_food_express_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 reference number
          if(isset($dataCode[0]->wimpys_food_express_code) != 0){
              //if code is not 0
              $newCode= $dataCode[0]->wimpys_food_express_code +1;
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

            $supplierExp = NULL;


        }else if($request->get('category') === "Supplier"){
            
            $supplier = $request->get('supplierName');
            $supplierExp = explode("-", $supplier);

            $subCat = NULL;
            $subCatAccountId = NULL;
        }

          //check if invoice number already exists
        $target = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->where('invoice_number', $request->get('invoiceNumber'))
                ->get()->first();

        if ($target === NULL) {
            # code...
                $addPaymentVoucher = new WimpysFoodExpressPaymentVoucher([
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
                'supplier_id'=>$supplierExp[0],
                'supplier_name'=>$supplierExp[1],
                'prepared_by'=>$name,
                'created_by'=>$name,

            ]);

            $addPaymentVoucher->save();

            $insertedId = $addPaymentVoucher->id;
        
            $moduleCode = "PV-";
            $moduleName = "Payment Voucher";
    
            //save to lechon_de_cebu_codes table
            $wimpysCode = new WimpysFoodExpressCode([
                'user_id'=>$user->id,
                'wimpys_food_express_code'=>$uCode,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
    
            ]);
            $wimpysCode->save();

            return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$insertedId]);

        }else{
            return redirect()->route('paymentVoucherFormWimpys')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }  
  
    }

    public function paymentVoucherForm(){   
        $suppliers =  WimpysFoodExpressSupplier::with(['user', 'suppliers'])
                                                 ->get();
        return view('payment-voucher-form-wimpys-food-express', compact('suppliers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('wimpys-food-express');
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

         //get the latest insert id query in table lechon_de_cebu_codes
         $data = DB::select('SELECT id, wimpys_food_express_code FROM wimpys_food_express_codes ORDER BY id DESC LIMIT 1');
        
         //if code is not zero add plus 1
        if(isset($data[0]->wimpys_food_express_code) != 0){
             //if code is not 0
             $newNum = $data[0]->wimpys_food_express_code +1;
             $uNum = sprintf("%06d",$newNum);    
         }else{
             //if code is 0 
             $newNum = 1;
             $uNum = sprintf("%06d",$newNum);
         }

         
         $purchaseOrder = new WimpysFoodExpressPurchaseOrder([
            'user_id' =>$user->id,
            'paid_to'=>$request->get('paidTo'),
            'address'=>$request->get('address'),
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

        $moduleCode = "PO-";
        $moduleName = "Purchase Order";

           //save to lechon_de_cebu_codes table
        $wimpysFoodExpress = new WimpysFoodExpressCode([
            'user_id'=>$user->id,
            'wimpys_food_express_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $wimpysFoodExpress->save();

        return redirect()->route('editWimpysFoodExpress', ['id'=>$insertedId]);
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
        $purchaseOrder =  WimpysFoodExpressPurchaseOrder::with(['user', 'purchase_orders'])
                                                    ->where('id', $id)
                                                    ->get(); 

        $pOrders = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->get()->toArray();

            //count the total amount 
        $countTotalAmount = WimpysFoodExpressPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-wimpys-food-express-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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
        $purchaseOrder = WimpysFoodExpressPurchaseOrder::with(['user', 'purchase_orders'])
                                                ->where('id', $id)
                                                ->get();

        $pOrders = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->get()->toArray();

        return view('edit-wimpys-food-express-purchase-order', compact('id', 'purchaseOrder', 'pOrders'));
    }

    /**
     * Update the specified resource in storage.
     *+
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

        $purchaseOrder = WimpysFoodExpressPurchaseOrder::find($id);
        
        $purchaseOrder->paid_to = $paidTo;
        $purchaseOrder->address = $address;
        $purchaseOrder->date = $date;
        $purchaseOrder->description = $description;
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();

        
        Session::flash('SuccessE', 'Successfully updated');

        return redirect()->route('editWimpysFoodExpress', ['id'=>$id]);
    }

    public function destroyBillingStatement($id){
        $billingStatement = WimpysFoodExpressBillingStatement::find($id);
        $billingStatement->delete();
        

        //delete SOA 
        $soa = WimpysFoodExpressStatementOfAccount::find($id);
        $soa->delete();

    }

    public function destroyBillingDataStatement(Request $request, $id){
        $billStatement = WimpysFoodExpressBillingStatement::find($request->billingStatementId);

        $billingStatement = WimpysFoodExpressBillingStatement::find($id);
    
        $getAmount = $billStatement->total_amount - $billingStatement->amount;
        $billStatement->total_amount = $getAmount;
        $billStatement->save();

        $billingStatement->delete();

        //update statement of account table
        $statementAccount = WimpysFoodExpressStatementOfAccount::find($request->billingStatementId);

        $stateAccount = WimpysFoodExpressStatementOfAccount::find($id);

        $getStateAmount = $statementAccount->total_amount - $stateAccount->amount; 
        $statementAccount->total_amount = $getStateAmount;
        $statementAccount->total_remaining_balance = $getStateAmount;
        $statementAccount->save();

        $stateAccount->delete();

    }

    public function destroyTransactionList($id){
        $transactionList = WimpysFoodExpressPaymentVoucher::find($id);
        $transactionList->delete();
    }

    public function destroyPO($id){
        $purchaseOrder = WimpysFoodExpressPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $poId = WimpysFoodExpressPurchaseOrder::find($request->poId);

        $purchaseOrder = WimpysFoodExpressPurchaseOrder::find($id);
        $getAmount = $poId->total_price - $purchaseOrder->amount;

        $poId->total_price = $getAmount;
        $poId->save();

        $purchaseOrder->delete();

    }
}
