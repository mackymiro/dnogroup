<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;
use Session; 
use Auth; 
use App\User;
use App\LoloPinoyGrillBranchesPaymentVoucher;
use App\LoloPinoyGrillBranchesRequisitionSlip;
use App\LoloPinoyGrillBranchesUtility;
use App\LoloPinoyGrillCommissaryRawMaterial;
use App\LoloPinoyGrillBranchesSalesForm;
use App\LoloPinoyGrillBranchesPettyCash;
use Hash;
use App\LoloPinoyGrillBranchesCode;

class LoloPinoyGrillBranchesController extends Controller
{   
    public function updateDetails(Request $request){
        $updateDetail = LoloPinoyGrillBranchesPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = LoloPinoyGrillBranchesPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = LoloPinoyGrillBranchesPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
          //main id 
          $updateParticular = LoloPinoyGrillBranchesPaymentVoucher::find($request->transId);

          //particular id
          $uIdParticular = LoloPinoyGrillBranchesPaymentVoucher::find($request->id);
 
          $amount = $request->amount; 
 
          $updateAmount =  $updateParticular->amount; 
         
          $uParticular = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
          
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
        $updateParticular =  LoloPinoyGrillBranchesPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
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

        $moduleNameVoucher = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $totalPaidAmountCheck  = DB::table(
                                    'lolo_pinoy_grill_branches_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_branches_payment_vouchers.id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.status',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                    'lolo_pinoy_grill_branches_codes.module_id',
                                    'lolo_pinoy_grill_branches_codes.module_code',
                                    'lolo_pinoy_grill_branches_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                    ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.status', $status)
                                    ->sum('lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount');

        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillBranches',  compact('date', 'getDateToday', 'uri0', 'uri1', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lolo-pinoy-grill-branches-summary-report.pdf');

    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        
        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_at',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->whereBetween('lolo_pinoy_grill_branches_requisition_slips.created_at', [$startDate, $endDate])        
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        $transactionLists = DB::table(
                            'lolo_pinoy_grill_branches_requisition_slips')
                            ->select(
                                'lolo_pinoy_grill_branches_requisition_slips.id',
                                'lolo_pinoy_grill_branches_requisition_slips.user_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                                'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                                'lolo_pinoy_grill_branches_requisition_slips.request_date',
                                'lolo_pinoy_grill_branches_requisition_slips.date_released',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                                'lolo_pinoy_grill_branches_requisition_slips.unit',
                                'lolo_pinoy_grill_branches_requisition_slips.item',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                                'lolo_pinoy_grill_branches_requisition_slips.released_by',
                                'lolo_pinoy_grill_branches_requisition_slips.received_by',
                                'lolo_pinoy_grill_branches_requisition_slips.created_by',
                                'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                            ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->whereBetween('lolo_pinoy_grill_branches_requisition_slips.created_at', [$startDate, $endDate])
                     
                            ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                            ->get()->toArray();

        $moduleNamePetty = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.created_at',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_branches_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNamePetty)
                                ->whereBetween('lolo_pinoy_grill_branches_petty_cashes.created_at', [$startDate, $endDate])
                     
                                ->orderBy('lolo_pinoy_grill_branches_petty_cashes.id', 'desc')
                                ->get()->toArray();
                    
            $moduleNameVoucher = "Payment Voucher";
            $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                     
                                ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                                ->get()->toArray();
        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                     
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                     
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        return view('lolo-pinoy-grill-branches-multiple-summary-report', compact('requisitionLists', 'startDate', 'endDate',
        'transactionLists', 'pettyCashLists', 'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function search(Request $request){
        $getSearchResults =LoloPinoyGrillBranchesCode::where('lolo_pinoy_branches_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Requisition Slip"){
            $getSearchReqSlips = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_requisition_slips.created_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.id', $getSearchResults[0]->module_id)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $getSearchResults[0]->module_name)
                        ->get()->toArray();
            
            $getAllCodes = LoloPinoyGrillBranchesCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-branches-search-results',  compact('module', 'getAllCodes', 'getSearchReqSlips'));
                   

        }else if($getSearchResults[0]->module_name === "Petty Cash"){
            $getSearchPettyCashes = DB::table(
                            'lolo_pinoy_grill_branches_petty_cashes')
                            ->select( 
                            'lolo_pinoy_grill_branches_petty_cashes.id',
                            'lolo_pinoy_grill_branches_petty_cashes.user_id',
                            'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                            'lolo_pinoy_grill_branches_petty_cashes.date',
                            'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                            'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                            'lolo_pinoy_grill_branches_petty_cashes.amount',
                            'lolo_pinoy_grill_branches_petty_cashes.created_by',
                            'lolo_pinoy_grill_branches_petty_cashes.created_at',
                            'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_petty_cashes.id', $getSearchResults[0]->module_id)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $getSearchResults[0]->module_name)       
                            ->get()->toArray();
                    
            $getAllCodes = LoloPinoyGrillBranchesCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-branches-search-results',  compact('module', 'getAllCodes', 'getSearchPettyCashes'));
                      
        }else if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.id', $getSearchResults[0]->module_id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $getSearchResults[0]->module_name)
                                ->get()->toArray(); 
            
            $getAllCodes = LoloPinoyGrillBranchesCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-branches-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
                          

        }
    
    }

    public function searchNumberCode(){
        $getAllCodes = LoloPinoyGrillBranchesCode::get()->toArray();
        return view('lolo-pinoy-grill-branches-search-number-code', compact('getAllCodes'));
    }

    public function printGetSummary($date){
        $moduleNameVoucher = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');
            
            $totalPaidAmountCheck = DB::table(
                                    'lolo_pinoy_grill_branches_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_branches_payment_vouchers.id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.status',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                    'lolo_pinoy_grill_branches_codes.module_id',
                                    'lolo_pinoy_grill_branches_codes.module_code',
                                    'lolo_pinoy_grill_branches_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                    ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.status', $status)
                                    ->sum('lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount');
        
        $getDateToday = "";
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillBranches',  compact('date', 'uri0', 'uri1', 'getDateToday', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lolo-pinoy-grill-branches-summary-report.pdf');
    }

    public function getSummaryReport(Request $request){ 
        $getDate = $request->get('selectDate');
        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_at',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_branches_requisition_slips.created_at', '=', date($getDate))
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        $transactionLists = DB::table(
                            'lolo_pinoy_grill_branches_requisition_slips')
                            ->select(
                                'lolo_pinoy_grill_branches_requisition_slips.id',
                                'lolo_pinoy_grill_branches_requisition_slips.user_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                                'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                                'lolo_pinoy_grill_branches_requisition_slips.request_date',
                                'lolo_pinoy_grill_branches_requisition_slips.date_released',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                                'lolo_pinoy_grill_branches_requisition_slips.unit',
                                'lolo_pinoy_grill_branches_requisition_slips.item',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                                'lolo_pinoy_grill_branches_requisition_slips.released_by',
                                'lolo_pinoy_grill_branches_requisition_slips.received_by',
                                'lolo_pinoy_grill_branches_requisition_slips.created_by',
                                'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                            ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->whereDate('lolo_pinoy_grill_branches_requisition_slips.created_at', '=', date($getDate))
                            ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                            ->get()->toArray();

        $moduleNamePetty = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.created_at',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_branches_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNamePetty)
                                ->whereDate('lolo_pinoy_grill_branches_petty_cashes.created_at', '=', date($getDate))
                                ->orderBy('lolo_pinoy_grill_branches_petty_cashes.id', 'desc')
                                ->get()->toArray();
                    


        $moduleNameVoucher = "Payment Voucher";

        $getTransactionLists = DB::table(
                    'lolo_pinoy_grill_branches_payment_vouchers')
                    ->select( 
                    'lolo_pinoy_grill_branches_payment_vouchers.id',
                    'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                    'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                    'lolo_pinoy_grill_branches_payment_vouchers.date',
                    'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                    'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                    'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                    'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                    'lolo_pinoy_grill_branches_payment_vouchers.amount',
                    'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                    'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                    'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                    'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                    'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                    'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                    'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                    'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                    'lolo_pinoy_grill_branches_payment_vouchers.category',
                    'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                    'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                    'lolo_pinoy_grill_branches_payment_vouchers.status',
                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                    'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                    'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                    'lolo_pinoy_grill_branches_codes.module_id',
                    'lolo_pinoy_grill_branches_codes.module_code',
                    'lolo_pinoy_grill_branches_codes.module_name')
                    ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                    ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                    ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                    ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                    ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                    ->get()->toArray();



        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDate))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDate))
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDate))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDate))
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');
        
        return view('lolo-pinoy-grill-branches-get-summary-report', compact('getDate', 
        'requisitionLists', 'transactionLists', 'getTransactionListCashes', 'pettyCashLists', 'getTransactionLists',
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck'));


    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");

        $moduleNameVoucher = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $totalPaidAmountCheck  = DB::table(
                                    'lolo_pinoy_grill_branches_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_branches_payment_vouchers.id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.status',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                    'lolo_pinoy_grill_branches_codes.module_id',
                                    'lolo_pinoy_grill_branches_codes.module_code',
                                    'lolo_pinoy_grill_branches_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                    ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.status', $status)
                                    ->sum('lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount');

        $pdf = PDF::loadView('printSummaryLoloPinoyGrillBranches',  compact('getDateToday', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lolo-pinoy-grill-branches-summary-report.pdf');

    }

    public function summaryReport(){
         
        $getDateToday = date("Y-m-d");

        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_at',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_branches_requisition_slips.created_at', '=', date($getDateToday))
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        $transactionLists = DB::table(
                            'lolo_pinoy_grill_branches_requisition_slips')
                            ->select(
                                'lolo_pinoy_grill_branches_requisition_slips.id',
                                'lolo_pinoy_grill_branches_requisition_slips.user_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                                'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                                'lolo_pinoy_grill_branches_requisition_slips.request_date',
                                'lolo_pinoy_grill_branches_requisition_slips.date_released',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                                'lolo_pinoy_grill_branches_requisition_slips.unit',
                                'lolo_pinoy_grill_branches_requisition_slips.item',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                                'lolo_pinoy_grill_branches_requisition_slips.released_by',
                                'lolo_pinoy_grill_branches_requisition_slips.received_by',
                                'lolo_pinoy_grill_branches_requisition_slips.created_by',
                                'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                            ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->whereDate('lolo_pinoy_grill_branches_requisition_slips.created_at', '=', date($getDateToday))
                            ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                            ->get()->toArray();

        $moduleNamePetty = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.created_at',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_branches_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNamePetty)
                                ->whereDate('lolo_pinoy_grill_branches_petty_cashes.created_at', '=', date($getDateToday))
                                ->orderBy('lolo_pinoy_grill_branches_petty_cashes.id', 'desc')
                                ->get()->toArray();
                    
            $moduleNameVoucher = "Payment Voucher";
            $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                               
                                ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                                ->get()->toArray();
        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

                
        return view('lolo-pinoy-grill-branches-summary-report', compact('requisitionLists', 
        'transactionLists', 'pettyCashLists', 'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck'));
    }

    public function printPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.id', $id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->get();
        

        $getPettyCashSummaries = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = LoloPinoyGrillBranchesPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashLoloPinoyGrillBranches', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
        return $pdf->download('lolo-pinoy-grill-branches-petty-cash.pdf');

    }

    public function updatePC(Request $request, $id){
        $updatePC = LoloPinoyGrillBranchesPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashLoloPinoyGrillBranches', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


        $addNew = new LoloPinoyGrillBranchesPettyCash([
            'user_id'=>$user->id,
            'pc_id'=>$id,
            'date'=>$request->get('date'),
            'petty_cash_summary'=>$request->get('pettyCashSummary'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNew->save();
        Session::flash('addNewSuccess', 'Successfully added.');

        return redirect()->route('editPettyCashLoloPinoyGrillBranches', ['id'=>$id]);
    }

    public function updatePettyCash(Request $request, $id){
        $updatePettyCash = LoloPinoyGrillBranchesPettyCash::find($id);
        $updatePettyCash->date = $request->get('date');
        $updatePettyCash->petty_cash_name = $request->get('pettyCashName');
        $updatePettyCash->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePettyCash->save();

        Session::flash('editSuccess', 'Successfully updated.');

        return redirect()->route('editPettyCashLoloPinoyGrillBranches', ['id'=>$id]);
    }

    public function editPettyCash($id){
        $moduleName = "Petty Cash";
        $pettyCash = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.id', $id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->get();

        $pettyCashSummaries = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->get()->toArray();
        return view('edit-lolo-pinoy-grill-branches-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }

    public function  addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table lolo_pinoy_grill_branches_codes
        $dataCashNo = DB::select('SELECT id, lolo_pinoy_branches_code  FROM lolo_pinoy_grill_branches_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
        if(isset($dataCashNo[0]->lolo_pinoy_branches_code ) != 0){
            //if code is not 0
            $newProd = $dataCashNo[0]->lolo_pinoy_branches_code  +1;
            $uPetty = sprintf("%06d",$newProd);   

        }else{
            //if code is 0 
            $newProd = 1;
            $uPetty = sprintf("%06d",$newProd);
        } 

        $addPettyCash = new LoloPinoyGrillBranchesPettyCash([
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

        $lpBranches = new LoloPinoyGrillBranchesCode([
            'user_id'=>$user->id,
            'lolo_pinoy_branches_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $lpBranches->save();
      
        return response()->json($insertId);


    }


    //logout session in branches
    public function logOutBranch(Request $request){
        $request->session()->forget('sessionBranch');
        return redirect()->route('salesInvoiceForm');

    }

    //redirect to branch
    public function salesInvoiceFormBranch(Request $request, $type){
        $data = $request->session()->get('sessionBranch');
        if(empty($data)){
            return redirect()->route('salesInvoiceForm');
        }else{
            return view('lolo-pinoy-grill-branches-sales-invoice-form');
        }
        
    }

    //login branch 
    public function loginSales(Request $request){

        //get the data from the users table
        $getBranch = User::where('select_branch', $request->get('selectBranch'))->get()->toArray();
       
        if($getBranch == NULL){
            $findAccess = User::find(isset($getBranch[0]['id']));
            return redirect()->route('salesInvoiceForm')->with('noAccess', 'No Access'); 
        }else{
            $findAccess = User::find($getBranch[0]['id']);

            $password = $request->get('password');
            //check if  password is the same 
            if(Hash::check($password, $findAccess['password'])){
                $stat = "1";
                $updateStatus = User::find($findAccess['id']);
                $updateStatus->status = $stat;
                $updateStatus->save();
                
                $value = $findAccess['select_branch'];
                Session::put('sessionBranch', $value);

                //redirect to what branch selected in login
                return redirect()->route('salesInvoiceFormBranch', ['branch'=>$findAccess['select_branch']]);

            }else{
                $request->session()->flash('error', 'Password does not match.');
                return redirect()->route('salesInvoiceForm');
            }
        
        }

    }   

    //pay cash
    public function payCash(Request $request, $id){
         //validate
         $this->validate($request, [
            'cash' =>'required|integer|min:0',
           
        ]);

        $payCash = LoloPinoyGrillBranchesSalesForm::find($id);
        
        $payTotal = $request->get('cash') - $payCash->total_amount_of_sales;
        
        $payCash->cash_amount = $request->get('cash');
        $payCash->change = $payTotal; 
        $payCash->save();

        Session::flash('successPay', 'Paid Successfully. Kindly click the OK button below.');
        return redirect()->route('detailTransactions', ['id'=>$id]);
        
    }

    //detail transaction
    public function detailTransactions(Request $request, $id){
        $data = $request->session()->get('sessionBranch');

        $transaction = LoloPinoyGrillBranchesSalesForm::find($id); 
         //getTransactions
        $getTransactions = LoloPinoyGrillBranchesSalesForm::where('sf_id', $id)->get()->toArray();
        return view('lolo-pinoy-grill-branches-detail-transactions', compact('transaction', 'getTransactions', 'data'));
    }

    //settle transactions
    public function settleTransactions(Request $request, $id){
        

        $settleTransactions = LoloPinoyGrillBranchesSalesForm::find($id);
        $settleTransactions->invoice_number = $request->get('invoiceNum');
        $settleTransactions->ordered_by = $request->get('orderedBy');
        $settleTransactions->table_no = $request->get('tableNo');
        $settleTransactions->save();

        return redirect()->route('detailTransactions', ['id'=>$id]);

    }

    //save additional transactions
    public function addSalesAdditional(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
        $getDate =  date("Y-m-d");

        //get transaction id
        $getTransId = LoloPinoyGrillBranchesSalesForm::find($request->transactionId);

        //compute 
        $amt = $request->amount + $getTransId->total_amount_of_sales;

        //update
        $getTransId->total_amount_of_sales = $amt;
        $getTransId->save();

        $addAdditional = new LoloPinoyGrillBranchesSalesForm([
            'user_id'=>$user->id,
            'sf_id'=>$request->transactionId,
            'date'=>$getDate,
            'qty'=>$request->quantity,
            'item_description'=>$request->itemDescription,
            'amount'=>$request->amount,
            'branch'=>$request->branch,
            'created_by'=>$name,
        ]);
        $addAdditional->save();
    
        return response()->json($addAdditional);

    }

    public function salesTransaction($type, $id){
        $transaction = LoloPinoyGrillBranchesSalesForm::find($id);

        //getTransactions
        $getTransactions = LoloPinoyGrillBranchesSalesForm::where('sf_id', $id)->get()->toArray();


        return view('lolo-pinoy-grill-branches-transactions', compact('id', 'transaction', 'getTransactions'));
    }

    //save first transactions
    public function addSalesTransaction(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
        $getDate =  date("Y-m-d");

        $addNewSales = new LoloPinoyGrillBranchesSalesForm([
            'user_id'=>$user->id,
            'date'=>$getDate,
            'qty'=>$request->quantity,
            'item_description'=>$request->itemDescription,
            'amount'=>$request->amount,
            'total_amount_of_sales'=>$request->amount,
            'branch'=>$request->branch,
            'created_by'=>$name,
        ]);
        $addNewSales->save();
        $insertId = $addNewSales->id; 

        return response()->json($insertId);

    }

    public function viewStockInventory($id){
        $viewStockInventory = LoloPinoyGrillCommissaryRawMaterial::find($id);
        $getStoreStockDetails = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', $id)->get()->toArray();
        return view('view-lolo-pinoy-grill-branches-store-stock', compact('viewStockInventory', 'getStoreStockDetails'));
    }

    public function stockInventory(){
        $getCommissaryRawMaterials = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

        return view('lolo-pinoy-grill-branches-stock-inventory', compact('getCommissaryRawMaterials'));
    }

    public function stockStatus(){

    }
    
    public function viewBills($id){
        
        $viewBill = LoloPinoyGrillBranchesUtility::find($id);
        //view particulars
        $viewParticulars = LoloPinoyGrillBranchesPaymentVoucher::where('sub_category_account_id', $id)->get()->toArray();

        return view('lolo-pinoy-grill-branches-view-utility', compact('viewBill', 'viewParticulars'));
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
                'lolo_pinoy_grill_branches_utilities')
                ->where('account_id', $request->accountId)
                ->get()->first();

        if($target ==  NULL){
    
            $addInternet = new LoloPinoyGrillBranchesUtility([
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
                'lolo_pinoy_grill_branches_utilities')
                ->where('account_id', $request->accountId)
                ->get()->first();

        if($target == NULL){
            $addBills = new LoloPinoyGrillBranchesUtility([
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

        $vecoDocuments = LoloPinoyGrillBranchesUtility::where('flag', $flag)->get()->toArray();

        $mcwdDocuments = LoloPinoyGrillBranchesUtility::where('flag', $flagMCWD)->get()->toArray();

        $internetDocuments = LoloPinoyGrillBranchesUtility::where('flag', $flagInternet)->get()->toArray();

        return view('lolo-pinoy-grill-branches-utilities', compact('vecoDocuments', 'mcwdDocuments', 'internetDocuments'));
    }

    //
    public function viewPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.id', $id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->get();

        $getPettyCashSummaries = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = LoloPinoyGrillBranchesPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        return view('lolo-pinoy-grill-branches-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
    }

    //
    public function pettyCashList(){
        $moduleName = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->where('lolo_pinoy_grill_branches_petty_cashes.deleted_at', NULL)
                                ->orderBy('lolo_pinoy_grill_branches_petty_cashes.id', 'desc')
                                ->get()->toArray();

        return view('lolo-pinoy-grill-branches-petty-cash-list', compact('pettyCashLists'));
    }

    //
    public function salesInvoiceForm(Request $request){
        $data = $request->session()->get('sessionBranch');
       if(empty($data)){
            return view('lolo-pinoy-grill-branches-login-form', compact('data'));      
       }else{
            return redirect()->route('salesInvoiceFormBranch', ['type'=>$data]);
        
       }
        
        
    }

    //
    public function reqTransactionList(){
        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        return view('lolo-pinoy-grill-branches-requisition-slip-transaction-list', compact('requisitionLists'));
    }

    //  
    public function printRS($id){
    
        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);

          //
        $rSlips = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', $id)->get()->toArray();


        $pdf = PDF::loadView('printRS', compact('requisitionSlip', 'rSlips'));

        return $pdf->download('lolo-pinoy-grill-branches-requisition-slip.pdf');

    }

    //
    public function requisitionSlipList(){
        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        return view('lolo-pinoy-grill-branches-all-lists', compact('requisitionLists'));
    }

    //
    public function updateRs(Request $request, $id){
        $slip = LoloPinoyGrillBranchesRequisitionSlip::find($id);
        

        $slip->quantity_requested = $request->get('quantityRequested');
        $slip->unit = $request->get('unit');
        $slip->item = $request->get('item');
        $slip->quantity_given = $request->get('quantityGiven');

        $slip->save();

         Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-grill-branches/edit/'.$request->get('rsId'));
    }

    //
    public function addNewRequisitionSlip(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $rs = LoloPinoyGrillBranchesRequisitionSlip::find($id);

         $addRequisitionslip = new LoloPinoyGrillBranchesRequisitionSlip([
            'user_id' =>$user->id,
            'rs_id'=>$id,
            'rs_number'=>$rs['rs_number'],
            'quantity_requested'=>$request->get('quantityRequested'),
            'unit'=>$request->get('unit'),
            'item'=>$request->get('item'),
            'quantity_given'=>$request->get('quantityGiven'),
            'released_by'=>$name,
            'created_by'=>$name,
        ]);

        $addRequisitionslip->save();

        Session::flash('purchaseOrderSuccess', 'Successfully added requisition order');

        return redirect('lolo-pinoy-grill-branches/add-new/'.$id);

    }

    //
    public function addNew($id){
        return view('add-new-lolo-pinoy-grill-branches-requisition-slip', compact('id'));
    }

    //
    public function requisitionSlip(){
    
        return view('lolo-pinoy-grill-branches-requisition-slip');
    }

    //
    public function printPayables($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.id', $id)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->get();

       //

        //getParticular details
        $getParticulars = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      

        $payablesVouchers = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->sum('amount_due');


          //
        $countAmount = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesLoloPinoyGrillBranches', compact('payableId', 'payablesVouchers', 'getParticulars', 'sum'));

        return $pdf->download('lolo-pinoy-grill-branches-payment-voucher.pdf');
    }   

    //
    public function viewPayableDetails($id){
         $moduleName = "Payment Voucher";
         $viewPaymentDetail = DB::table(
                             'lolo_pinoy_grill_branches_payment_vouchers')
                             ->select( 
                             'lolo_pinoy_grill_branches_payment_vouchers.id',
                             'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                             'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                             'lolo_pinoy_grill_branches_payment_vouchers.date',
                             'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                             'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                             'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                             'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                             'lolo_pinoy_grill_branches_payment_vouchers.amount',
                             'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                             'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                             'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                             'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                             'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                             'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                             'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                             'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                             'lolo_pinoy_grill_branches_payment_vouchers.category',
                             'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                             'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                             'lolo_pinoy_grill_branches_payment_vouchers.status',
                             'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                             'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                             'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                             'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                             'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                             'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                             'lolo_pinoy_grill_branches_codes.module_id',
                             'lolo_pinoy_grill_branches_codes.module_code',
                             'lolo_pinoy_grill_branches_codes.module_name')
                             ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                             ->where('lolo_pinoy_grill_branches_payment_vouchers.id', $id)
                             ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                             ->get();

        //
        $getViewPaymentDetails = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->get()->toArray();

           //getParticular details
           $getParticulars = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
       

        return view('view-lolo-pinoy-grill-branches-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
    }

    //
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

                    $payables = LoloPinoyGrillBranchesPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = LoloPinoyGrillBranchesPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = LoloPinoyGrillBranchesPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = LoloPinoyGrillBranchesPaymentVoucher::find($id);

        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

        //get Category
        $cat = $particulars['category'];

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $subAccountId = $particulars['sub_category_account_id'];
        
        $addParticulars = new LoloPinoyGrillBranchesPaymentVoucher([
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

        return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$id);
    }

    //
    public function addPayment(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = LoloPinoyGrillBranchesPaymentVoucher::find($id);

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');


        //save payment cheque num and cheque amount
        $addPayment = new LoloPinoyGrillBranchesPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
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

        return redirect()->route('editPayablesDetailLpBranches', ['id'=>$id]);

    }

    //
    public function editPayablesDetail(Request $request, $id){
            $moduleName = "Payment Voucher";
            $transactionList = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftjoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.id', $id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->get();


          //
        $getChequeNumbers = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();
        
        $getCashAmounts = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
      
        
        //getParticular details
        $getParticulars = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
         //amount
        $amount1 = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('amount');
         
         $sum = $amount1 + $amount2;

        $chequeAmount1 = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
      

         return view('lolo-pinoy-grill-branches-payables-detail', compact('transactionList', 
            'getChequeNumbers','sum', 'getParticulars', 'sumCheque', 'getCashAmounts'));
    }

    //
    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        
        
        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('lolo-pinoy-grill-branches-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));
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

        //get the latest insert id query in table lolo_pinoy_grill_branches_codes
        $dataVoucherRef = DB::select('SELECT id, lolo_pinoy_branches_code  FROM lolo_pinoy_grill_branches_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->lolo_pinoy_branches_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->lolo_pinoy_branches_code +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
        } 

        //get the category
       if($request->get('category') == "Petty Cash"){

            $subCat = "NULL";
            $subCatAcctId = "NULL";

       }else if($request->get('category') == "Utilities"){

            $subCat = $request->get('bills');
            $subCatAcctId = $request->get('selectAccountID');

       }else if($request->get('category') == "None"){
            $subCat = "NULL";
            $subCatAcctId = "NULL";
       }else if($request->get('category') == "Payroll"){
            $subCat = "NULL";
            $subCatAcctId = "NULL";
        }


        //check if invoice number already exists
        $target = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...   
            $addPaymentVoucher = new LoloPinoyGrillBranchesPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'method_of_payment'=>$request->get('paymentMethod'),
                'account_name'=>$request->get('accountName'),
                'invoice_number'=>$request->get('invoiceNumber'),
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

             $moduleCode = "PV-";
             $moduleName = "Payment Voucher";
             
             $lpBranches = new LoloPinoyGrillBranchesCode([
                'user_id'=>$user->id,
                'lolo_pinoy_branches_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
             ]);
             $lpBranches->save();

            return redirect()->route('editPayablesDetailLpBranches', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormLpBranches')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    }


    //
    public function paymentVoucherForm(){
        $getAllFlags = LoloPinoyGrillBranchesUtility::where('u_id', NULL)->get()->toArray();

        return view('payment-voucher-form-lolo-pinoy-grill-branches', compact('getAllFlags'));
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data =  $request->session()->get('sessionBranch');

        $getTransactionBranches = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $data)->get()->toArray();

        $sum = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $data)->sum('total_amount_of_sales');
        return view('lolo-pinoy-grill-branches', compact('getTransactionBranches', 'data', 'sum'));


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
            'requestingDept' => 'required',
            'quantityRequested'=> 'required',
            'unit'=>'required',
            'item'=>'required',
            'quantityGiven'=>'required',
        ]);

          //get the latest insert id query in table lolo_pinoy_grill_branches_codes
          $data = DB::select('SELECT id, lolo_pinoy_branches_code FROM lolo_pinoy_grill_branches_codes ORDER BY id DESC LIMIT 1');
        
          //if code is not zero add plus 1
           if(isset($data[0]->lolo_pinoy_branches_code) != 0){
              //if code is not 0
              $newNum = $data[0]->lolo_pinoy_branches_code +1;
              $uNum = sprintf("%06d",$newNum);    
          }else{
              //if code is 0 
              $newNum = 1;
              $uNum = sprintf("%06d",$newNum);
          }
       
        $requisitionSlip = new LoloPinoyGrillBranchesRequisitionSlip([
            'user_id' =>$user->id,
            'requesting_department'=>$request->get('requestingDept'),
            'request_date'=>$request->get('requestDate'),
            'date_released'=>$request->get('dateReleased'),
            'quantity_requested'=>$request->get('quantityRequested'),
            'unit'=>$request->get('unit'),
            'item'=>$request->get('item'),
            'quantity_given'=>$request->get('quantityGiven'),
            'released_by'=>$name,
            'created_by'=>$name,
        ]);

        $requisitionSlip->save();

        $insertedId = $requisitionSlip->id;

        $moduleCode = "RS-";
        $moduleName = "Requisition Slip";

        $lpBranches = new LoloPinoyGrillBranchesCode([
            'user_id'=>$user->id,
            'lolo_pinoy_branches_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $lpBranches->save();

        return redirect()->route('editLpBranches', ['id'=>$insertedId]);
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        $moduleName = "Requisition Slip";
        $requisitionSlip = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.id', $id)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->get();

        $rSlips = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', $id)->get()->toArray();
    

        return view('view-lolo-pinoy-grill-branches-requisition-slip', compact('requisitionSlip', 'rSlips'));

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
    
        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);

        $rSlips = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', $id)->get()->toArray();

        //get users
        $getUsers = User::get()->toArray();
       

        return view('edit-lolo-pinoy-grill-branches-requisition-slip', compact('requisitionSlip', 'rSlips', 'getUsers'));

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

          $requestingDept = $request->get('requestingDept');
          $requestDate = $request->get('requestDate');
          $dateReleased = $request->get('dateReleased');
          $quantityRequested = $request->get('quantityRequested');
          $unit = $request->get('unit');
          $item = $request->get('item');
          $quantityGiven = $request->get('quantityGiven');

          $requisitonSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);
        
          $requisitonSlip->requesting_department = $requestingDept;
          $requisitonSlip->request_date = $requestDate;
          $requisitonSlip->date_released = $dateReleased;
          $requisitonSlip->quantity_requested = $quantityRequested;
          $requisitonSlip->unit = $unit;
          $requisitonSlip->item = $item;
          $requisitonSlip->quantity_given = $quantityGiven;

          $requisitonSlip->save();

           Session::flash('SuccessE', 'Successfully updated');

           return redirect('lolo-pinoy-grill-branches/edit/'.$id);


    }

    public function destroyUtility($id){
        $utility = LoloPinoyGrillBranchesUtility::find($id);
        $utility->delete();
    }

    public function destroyPettyCash($id){
        $pettyCash = LoloPinoyGrillBranchesPettyCash::find($id);
        $pettyCash->delete();
    }

    public function destroyTransactionList($id){
        $transactionList = LoloPinoyGrillBranchesPaymentVoucher::find($id);
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
        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);
        $requisitionSlip->delete();
    }
}
