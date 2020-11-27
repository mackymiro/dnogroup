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
use App\DnoFoodVenturesSupplier;
use App\DnoFoodVenturesPurchaseOrder;
use App\DnoFoodVenturesDeliveryReceipt;
use App\DnoFoodVenturesRawMaterial;
use App\DnoFoodVenturesRawMaterialProduct;
use App\DnoFoodVenturesSalesInvoice;
use App\DnoFoodVenturesBillingStatement;
use App\DnoFoodVenturesPettyCash;
use App\DnoFoodVenturesStatementOfAccount; 


class DnoFoodVenturesController extends Controller
{

    public function printBillingStatement($id){
        $printBillingStatement = DnoFoodVenturesBillingStatement::with(['user', 'billing_statements'])
                                                                    ->where('id', $id)
                                                                    ->get();

        $billingStatements = DnoFoodVenturesBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoFoodVenturesBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = DnoFoodVenturesBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printBillingStatementDnoFoodVentures', compact('printBillingStatement', 'billingStatements', 'sum'));

        return $pdf->download('dno-food-ventures-billing-statement.pdf');  
    }

    public function printSOAListsDR(){
        $sDr = "Delivery Receipt";
        $printSOAStatementsDRs = DnoFoodVenturesStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('billing_statement_id', NULL)
                                                                    ->where('deleted_at', NULL)
                                                                    ->where('order', $sDr)
                                                                    ->orderBy('id', 'desc')
                                                                    ->get();
                                                    
        $moduleName = "Statement Of Account";
        $status = "PAID";
        $totalAmountDR = DB::table(
                                    'dno_food_ventures_statement_of_accounts')
                                    ->select(
                                        'dno_food_ventures_statement_of_accounts.id',
                                        'dno_food_ventures_statement_of_accounts.user_id',
                                        'dno_food_ventures_statement_of_accounts.billing_statement_id',
                                        'dno_food_ventures_statement_of_accounts.bill_to',
                                        'dno_food_ventures_statement_of_accounts.address',
                                        'dno_food_ventures_statement_of_accounts.date',
                                        'dno_food_ventures_statement_of_accounts.period_cover',
                                        'dno_food_ventures_statement_of_accounts.terms',
                                        'dno_food_ventures_statement_of_accounts.date_of_transaction',
                                        'dno_food_ventures_statement_of_accounts.order',
                                        'dno_food_ventures_statement_of_accounts.description',
                                        'dno_food_ventures_statement_of_accounts.amount',
                                        'dno_food_ventures_statement_of_accounts.total_amount',
                                        'dno_food_ventures_statement_of_accounts.total_remaining_balance',
                                        'dno_food_ventures_statement_of_accounts.paid_amount',
                                        'dno_food_ventures_statement_of_accounts.payment_method',
                                        'dno_food_ventures_statement_of_accounts.collection_date',
                                        'dno_food_ventures_statement_of_accounts.check_number',
                                        'dno_food_ventures_statement_of_accounts.check_amount',
                                        'dno_food_ventures_statement_of_accounts.or_number',
                                        'dno_food_ventures_statement_of_accounts.status',
                                        'dno_food_ventures_statement_of_accounts.created_by',
                                        'dno_food_ventures_codes.dno_food_venture_code',
                                        'dno_food_ventures_codes.module_id',
                                        'dno_food_ventures_codes.module_code',
                                        'dno_food_ventures_codes.module_name')
                                    ->join('dno_food_ventures_codes', 'dno_food_ventures_statement_of_accounts.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_statement_of_accounts.billing_statement_id', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->where('dno_food_ventures_statement_of_accounts.status', '=', $status)
                                    ->where('dno_food_ventures_statement_of_accounts.order', $sDr)
                                    ->sum('dno_food_ventures_statement_of_accounts.total_amount');
        
        $totalRemainingBalanceDR = DB::table(
                                    'dno_food_ventures_statement_of_accounts')
                                    ->select(
                                        'dno_food_ventures_statement_of_accounts.id',
                                        'dno_food_ventures_statement_of_accounts.user_id',
                                        'dno_food_ventures_statement_of_accounts.billing_statement_id',
                                        'dno_food_ventures_statement_of_accounts.bill_to',
                                        'dno_food_ventures_statement_of_accounts.address',
                                        'dno_food_ventures_statement_of_accounts.date',
                                        'dno_food_ventures_statement_of_accounts.period_cover',
                                        'dno_food_ventures_statement_of_accounts.terms',
                                        'dno_food_ventures_statement_of_accounts.date_of_transaction',
                                        'dno_food_ventures_statement_of_accounts.order',
                                        'dno_food_ventures_statement_of_accounts.description',
                                        'dno_food_ventures_statement_of_accounts.amount',
                                        'dno_food_ventures_statement_of_accounts.total_amount',
                                        'dno_food_ventures_statement_of_accounts.total_remaining_balance',
                                        'dno_food_ventures_statement_of_accounts.paid_amount',
                                        'dno_food_ventures_statement_of_accounts.payment_method',
                                        'dno_food_ventures_statement_of_accounts.collection_date',
                                        'dno_food_ventures_statement_of_accounts.check_number',
                                        'dno_food_ventures_statement_of_accounts.check_amount',
                                        'dno_food_ventures_statement_of_accounts.or_number',
                                        'dno_food_ventures_statement_of_accounts.status',
                                        'dno_food_ventures_statement_of_accounts.created_by',
                                        'dno_food_ventures_codes.dno_food_venture_code',
                                        'dno_food_ventures_codes.module_id',
                                        'dno_food_ventures_codes.module_code',
                                        'dno_food_ventures_codes.module_name')
                                    ->join('dno_food_ventures_codes', 'dno_food_ventures_statement_of_accounts.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_statement_of_accounts.billing_statement_id', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->where('dno_food_ventures_statement_of_accounts.status', NULL)
                                    ->where('dno_food_ventures_statement_of_accounts.order', $sDr)
                                    ->sum('dno_food_ventures_statement_of_accounts.total_remaining_balance');

            $pdf = PDF::loadView('printSOAListsDRDnoFoodVentures', compact('printSOAStatementsDRs', 
            'totalAmountDR', 'totalRemainingBalanceDR'));

            return $pdf->download('dno-food-ventures-statement-of-account-list-delivery-receipt.pdf');
                                
    }


    public function printSOAListSO(){
        $sO = "Sales Invoice";
        $printSOAStatements = DnoFoodVenturesStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('billing_statement_id', NULL)
                                                                    ->where('deleted_at', NULL)
                                                                    ->where('order', $sO)
                                                                    ->orderBy('id', 'desc')
                                                                    ->get();
        $status = "PAID";
        $moduleName = "Statement Of Account";
        $totalAmount = DB::table(
                            'dno_food_ventures_statement_of_accounts')
                            ->select(
                                'dno_food_ventures_statement_of_accounts.id',
                                'dno_food_ventures_statement_of_accounts.user_id',
                                'dno_food_ventures_statement_of_accounts.billing_statement_id',
                                'dno_food_ventures_statement_of_accounts.bill_to',
                                'dno_food_ventures_statement_of_accounts.address',
                                'dno_food_ventures_statement_of_accounts.date',
                                'dno_food_ventures_statement_of_accounts.period_cover',
                                'dno_food_ventures_statement_of_accounts.terms',
                                'dno_food_ventures_statement_of_accounts.date_of_transaction',
                                'dno_food_ventures_statement_of_accounts.order',
                                'dno_food_ventures_statement_of_accounts.description',
                                'dno_food_ventures_statement_of_accounts.amount',
                                'dno_food_ventures_statement_of_accounts.total_amount',
                                'dno_food_ventures_statement_of_accounts.total_remaining_balance',
                                'dno_food_ventures_statement_of_accounts.paid_amount',
                                'dno_food_ventures_statement_of_accounts.payment_method',
                                'dno_food_ventures_statement_of_accounts.collection_date',
                                'dno_food_ventures_statement_of_accounts.check_number',
                                'dno_food_ventures_statement_of_accounts.check_amount',
                                'dno_food_ventures_statement_of_accounts.or_number',
                                'dno_food_ventures_statement_of_accounts.status',
                                'dno_food_ventures_statement_of_accounts.created_by',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                            ->join('dno_food_ventures_codes', 'dno_food_ventures_statement_of_accounts.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_statement_of_accounts.billing_statement_id', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->where('dno_food_ventures_statement_of_accounts.status', '=', $status)
                            ->where('dno_food_ventures_statement_of_accounts.order', $sO)
                            ->sum('dno_food_ventures_statement_of_accounts.total_amount');

       $totalRemainingBalance = DB::table(
                            'dno_food_ventures_statement_of_accounts')
                            ->select(
                                'dno_food_ventures_statement_of_accounts.id',
                                'dno_food_ventures_statement_of_accounts.user_id',
                                'dno_food_ventures_statement_of_accounts.billing_statement_id',
                                'dno_food_ventures_statement_of_accounts.bill_to',
                                'dno_food_ventures_statement_of_accounts.address',
                                'dno_food_ventures_statement_of_accounts.date',
                                'dno_food_ventures_statement_of_accounts.period_cover',
                                'dno_food_ventures_statement_of_accounts.terms',
                                'dno_food_ventures_statement_of_accounts.date_of_transaction',
                                'dno_food_ventures_statement_of_accounts.order',
                                'dno_food_ventures_statement_of_accounts.description',
                                'dno_food_ventures_statement_of_accounts.amount',
                                'dno_food_ventures_statement_of_accounts.total_amount',
                                'dno_food_ventures_statement_of_accounts.total_remaining_balance',
                                'dno_food_ventures_statement_of_accounts.paid_amount',
                                'dno_food_ventures_statement_of_accounts.payment_method',
                                'dno_food_ventures_statement_of_accounts.collection_date',
                                'dno_food_ventures_statement_of_accounts.check_number',
                                'dno_food_ventures_statement_of_accounts.check_amount',
                                'dno_food_ventures_statement_of_accounts.or_number',
                                'dno_food_ventures_statement_of_accounts.status',
                                'dno_food_ventures_statement_of_accounts.created_by',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                            ->join('dno_food_ventures_codes', 'dno_food_ventures_statement_of_accounts.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_statement_of_accounts.billing_statement_id', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->where('dno_food_ventures_statement_of_accounts.status', NULL)
                            ->where('dno_food_ventures_statement_of_accounts.order', $sO)
                            ->sum('dno_food_ventures_statement_of_accounts.total_remaining_balance');

        $pdf = PDF::loadView('printSOAListsSODnoFoodVentures', compact('printSOAStatements', 
        'totalAmount', 'totalRemainingBalance'));

        return $pdf->download('dno-food-ventures-statement-of-account-list-sales-order.pdf');

    }


    public function printSOA($id){
        $soa = DnoFoodVenturesStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                ->where('billing_statement_id', NULL)
                                                                ->orderBy('id', 'desc')
                                                                ->get();                                                   
                                                                
        $statementAccounts = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->get()->toArray();

        $moduleName = "Statement Of Account";
        $countTotalAmount =  DB::table(
                            'dno_food_ventures_statement_of_accounts')
                            ->select(
                                'dno_food_ventures_statement_of_accounts.id',
                                'dno_food_ventures_statement_of_accounts.user_id',
                                'dno_food_ventures_statement_of_accounts.billing_statement_id',
                                'dno_food_ventures_statement_of_accounts.bill_to',
                                'dno_food_ventures_statement_of_accounts.address',
                                'dno_food_ventures_statement_of_accounts.date',
                                'dno_food_ventures_statement_of_accounts.period_cover',
                                'dno_food_ventures_statement_of_accounts.terms',
                                'dno_food_ventures_statement_of_accounts.date_of_transaction',
                                'dno_food_ventures_statement_of_accounts.description',
                                'dno_food_ventures_statement_of_accounts.amount',
                                'dno_food_ventures_statement_of_accounts.paid_amount',
                                'dno_food_ventures_statement_of_accounts.payment_method',
                                'dno_food_ventures_statement_of_accounts.collection_date',
                                'dno_food_ventures_statement_of_accounts.check_number',
                                'dno_food_ventures_statement_of_accounts.check_amount',
                                'dno_food_ventures_statement_of_accounts.or_number',
                                'dno_food_ventures_statement_of_accounts.status',
                                'dno_food_ventures_statement_of_accounts.created_by',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                            ->join('dno_food_ventures_codes', 'dno_food_ventures_statement_of_accounts.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_statement_of_accounts.id', $id)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->sum('dno_food_ventures_statement_of_accounts.amount');

         $countAmount = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

    //
        $countAmount = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');


        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printSOADnoFoodVentures', compact('soa', 'statementAccounts', 'sum'));

        return $pdf->download('dno-food-ventures-statement-of-account.pdf');
    }   

    public function viewStatementAccount($id){
        $viewStatementAccount = DnoFoodVenturesStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                        ->where('id', $id)
                                                                        ->get();

        $statementAccounts = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->get();

        //count the total amount 
        $countTotalAmount = DnoFoodVenturesStatementOfAccount::where('id', $id)->sum('amount');

        //
        $countAmount = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        //count the total balance if there are paid amount
        $paidAmountCount = DnoFoodVenturesStatementOfAccount::where('id', $id)->sum('paid_amount');

        //
        $countAmountOthersPaid = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');

        $compute  = $paidAmountCount + $countAmountOthersPaid;


        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('view-dno-food-ventures-statement-account', compact('viewStatementAccount', 'statementAccounts', 'sum', 'computeAll'));

    }

    public function sAccountUpdate(Request $request, $id){
         //get the main Id 
         $mainIdSoa = DnoFoodVenturesStatementOfAccount::find($request->mainId);

         $compute = $mainIdSoa->total_remaining_balance - $request->paidAmount;
         
         $mainIdSoa->total_remaining_balance = $compute; 
         $mainIdSoa->save();
 
         $statementAccountPaid = DnoFoodVenturesStatementOfAccount::find($request->id);
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
        $getStatementOfAccount = DnoFoodVenturesStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('id', $id)
                                                                    ->get();
        //AllAcounts not yet paid
        $allAccounts = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->where('status', NULL)->get()->toArray();

        $stat = "PAID";
        $allAccountsPaids = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->where('status', $stat)->get()->toArray();  

        //count the total amount 
        $countTotalAmount = DnoFoodVenturesStatementOfAccount::where('id', $id)->sum('amount');

        //
        $countAmount = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        //count the total balance if there are paid amount
        $paidAmountCount = DnoFoodVenturesStatementOfAccount::where('id', $id)->sum('paid_amount');

        //
        $countAmountOthersPaid = DnoFoodVenturesStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');

        $compute  = $paidAmountCount + $countAmountOthersPaid;

        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('edit-dno-food-ventures-statement-of-account', compact('id', 'getStatementOfAccount', 'computeAll', 'allAccounts', 'allAccountsPaids', 'sum'));

    }

    public function statementOfAccountLists(){
        $sO = "Sales Invoice";
        $statementOfAccounts = DnoFoodVenturesStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('billing_statement_id', NULL)
                                                                    ->where('deleted_at', NULL)
                                                                    ->where('order', $sO)
                                                                    ->orderBy('id', 'desc')
                                                                    ->get();
        $status = "PAID";
        $moduleName = "Statement Of Account";
        $totalAmount = DB::table(
                            'dno_food_ventures_statement_of_accounts')
                            ->select(
                                'dno_food_ventures_statement_of_accounts.id',
                                'dno_food_ventures_statement_of_accounts.user_id',
                                'dno_food_ventures_statement_of_accounts.billing_statement_id',
                                'dno_food_ventures_statement_of_accounts.bill_to',
                                'dno_food_ventures_statement_of_accounts.address',
                                'dno_food_ventures_statement_of_accounts.date',
                                'dno_food_ventures_statement_of_accounts.period_cover',
                                'dno_food_ventures_statement_of_accounts.terms',
                                'dno_food_ventures_statement_of_accounts.date_of_transaction',
                                'dno_food_ventures_statement_of_accounts.order',
                                'dno_food_ventures_statement_of_accounts.description',
                                'dno_food_ventures_statement_of_accounts.amount',
                                'dno_food_ventures_statement_of_accounts.total_amount',
                                'dno_food_ventures_statement_of_accounts.total_remaining_balance',
                                'dno_food_ventures_statement_of_accounts.paid_amount',
                                'dno_food_ventures_statement_of_accounts.payment_method',
                                'dno_food_ventures_statement_of_accounts.collection_date',
                                'dno_food_ventures_statement_of_accounts.check_number',
                                'dno_food_ventures_statement_of_accounts.check_amount',
                                'dno_food_ventures_statement_of_accounts.or_number',
                                'dno_food_ventures_statement_of_accounts.status',
                                'dno_food_ventures_statement_of_accounts.created_by',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                            ->join('dno_food_ventures_codes', 'dno_food_ventures_statement_of_accounts.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_statement_of_accounts.billing_statement_id', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->where('dno_food_ventures_statement_of_accounts.status', '=', $status)
                            ->where('dno_food_ventures_statement_of_accounts.order', $sO)
                            ->sum('dno_food_ventures_statement_of_accounts.total_amount');

       $totalRemainingBalance = DB::table(
                            'dno_food_ventures_statement_of_accounts')
                            ->select(
                                'dno_food_ventures_statement_of_accounts.id',
                                'dno_food_ventures_statement_of_accounts.user_id',
                                'dno_food_ventures_statement_of_accounts.billing_statement_id',
                                'dno_food_ventures_statement_of_accounts.bill_to',
                                'dno_food_ventures_statement_of_accounts.address',
                                'dno_food_ventures_statement_of_accounts.date',
                                'dno_food_ventures_statement_of_accounts.period_cover',
                                'dno_food_ventures_statement_of_accounts.terms',
                                'dno_food_ventures_statement_of_accounts.date_of_transaction',
                                'dno_food_ventures_statement_of_accounts.order',
                                'dno_food_ventures_statement_of_accounts.description',
                                'dno_food_ventures_statement_of_accounts.amount',
                                'dno_food_ventures_statement_of_accounts.total_amount',
                                'dno_food_ventures_statement_of_accounts.total_remaining_balance',
                                'dno_food_ventures_statement_of_accounts.paid_amount',
                                'dno_food_ventures_statement_of_accounts.payment_method',
                                'dno_food_ventures_statement_of_accounts.collection_date',
                                'dno_food_ventures_statement_of_accounts.check_number',
                                'dno_food_ventures_statement_of_accounts.check_amount',
                                'dno_food_ventures_statement_of_accounts.or_number',
                                'dno_food_ventures_statement_of_accounts.status',
                                'dno_food_ventures_statement_of_accounts.created_by',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                            ->join('dno_food_ventures_codes', 'dno_food_ventures_statement_of_accounts.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_statement_of_accounts.billing_statement_id', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleName)
                            ->where('dno_food_ventures_statement_of_accounts.status', NULL)
                            ->where('dno_food_ventures_statement_of_accounts.order', $sO)
                            ->sum('dno_food_ventures_statement_of_accounts.total_remaining_balance');

        $sDr = "Delivery Receipt";
        $statementOfAccountsDRs = DnoFoodVenturesStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('billing_statement_id', NULL)
                                                                    ->where('deleted_at', NULL)
                                                                    ->where('order', $sDr)
                                                                    ->orderBy('id', 'desc')
                                                                    ->get();

        $totalAmountDR = DB::table(
                                    'dno_food_ventures_statement_of_accounts')
                                    ->select(
                                        'dno_food_ventures_statement_of_accounts.id',
                                        'dno_food_ventures_statement_of_accounts.user_id',
                                        'dno_food_ventures_statement_of_accounts.billing_statement_id',
                                        'dno_food_ventures_statement_of_accounts.bill_to',
                                        'dno_food_ventures_statement_of_accounts.address',
                                        'dno_food_ventures_statement_of_accounts.date',
                                        'dno_food_ventures_statement_of_accounts.period_cover',
                                        'dno_food_ventures_statement_of_accounts.terms',
                                        'dno_food_ventures_statement_of_accounts.date_of_transaction',
                                        'dno_food_ventures_statement_of_accounts.order',
                                        'dno_food_ventures_statement_of_accounts.description',
                                        'dno_food_ventures_statement_of_accounts.amount',
                                        'dno_food_ventures_statement_of_accounts.total_amount',
                                        'dno_food_ventures_statement_of_accounts.total_remaining_balance',
                                        'dno_food_ventures_statement_of_accounts.paid_amount',
                                        'dno_food_ventures_statement_of_accounts.payment_method',
                                        'dno_food_ventures_statement_of_accounts.collection_date',
                                        'dno_food_ventures_statement_of_accounts.check_number',
                                        'dno_food_ventures_statement_of_accounts.check_amount',
                                        'dno_food_ventures_statement_of_accounts.or_number',
                                        'dno_food_ventures_statement_of_accounts.status',
                                        'dno_food_ventures_statement_of_accounts.created_by',
                                        'dno_food_ventures_codes.dno_food_venture_code',
                                        'dno_food_ventures_codes.module_id',
                                        'dno_food_ventures_codes.module_code',
                                        'dno_food_ventures_codes.module_name')
                                    ->join('dno_food_ventures_codes', 'dno_food_ventures_statement_of_accounts.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_statement_of_accounts.billing_statement_id', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->where('dno_food_ventures_statement_of_accounts.status', '=', $status)
                                    ->where('dno_food_ventures_statement_of_accounts.order', $sDr)
                                    ->sum('dno_food_ventures_statement_of_accounts.total_amount');
        
        $totalRemainingBalanceDR = DB::table(
                                    'dno_food_ventures_statement_of_accounts')
                                    ->select(
                                        'dno_food_ventures_statement_of_accounts.id',
                                        'dno_food_ventures_statement_of_accounts.user_id',
                                        'dno_food_ventures_statement_of_accounts.billing_statement_id',
                                        'dno_food_ventures_statement_of_accounts.bill_to',
                                        'dno_food_ventures_statement_of_accounts.address',
                                        'dno_food_ventures_statement_of_accounts.date',
                                        'dno_food_ventures_statement_of_accounts.period_cover',
                                        'dno_food_ventures_statement_of_accounts.terms',
                                        'dno_food_ventures_statement_of_accounts.date_of_transaction',
                                        'dno_food_ventures_statement_of_accounts.order',
                                        'dno_food_ventures_statement_of_accounts.description',
                                        'dno_food_ventures_statement_of_accounts.amount',
                                        'dno_food_ventures_statement_of_accounts.total_amount',
                                        'dno_food_ventures_statement_of_accounts.total_remaining_balance',
                                        'dno_food_ventures_statement_of_accounts.paid_amount',
                                        'dno_food_ventures_statement_of_accounts.payment_method',
                                        'dno_food_ventures_statement_of_accounts.collection_date',
                                        'dno_food_ventures_statement_of_accounts.check_number',
                                        'dno_food_ventures_statement_of_accounts.check_amount',
                                        'dno_food_ventures_statement_of_accounts.or_number',
                                        'dno_food_ventures_statement_of_accounts.status',
                                        'dno_food_ventures_statement_of_accounts.created_by',
                                        'dno_food_ventures_codes.dno_food_venture_code',
                                        'dno_food_ventures_codes.module_id',
                                        'dno_food_ventures_codes.module_code',
                                        'dno_food_ventures_codes.module_name')
                                    ->join('dno_food_ventures_codes', 'dno_food_ventures_statement_of_accounts.id', '=', 'dno_food_ventures_codes.module_id')
                                    ->where('dno_food_ventures_statement_of_accounts.billing_statement_id', NULL)
                                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                                    ->where('dno_food_ventures_statement_of_accounts.status', NULL)
                                    ->where('dno_food_ventures_statement_of_accounts.order', $sDr)
                                    ->sum('dno_food_ventures_statement_of_accounts.total_remaining_balance');
                                            
    
        return view('dno-food-ventures-statement-of-account-lists', compact('statementOfAccounts', 
        'statementOfAccountsDRs', 'totalAmount', 'totalRemainingBalance', 'totalAmountDR', 'totalRemainingBalanceDR'));
    }

    public function printPettyCash($id){
        $getPettyCash =  DnoFoodVenturesPettyCash::with(['user', 'petty_cashes'])
                                                    ->where('id', $id)
                                                    ->get();

        $getPettyCashSummaries = DnoFoodVenturesPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = DnoFoodVenturesPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = DnoFoodVenturesPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashDnoFoodVentures', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));

        return $pdf->download('dno-food-ventures-petty-cash.pdf');
    }

    public function viewPettyCash($id){
        $getPettyCash =  DnoFoodVenturesPettyCash::with(['user', 'petty_cashes'])
                                                    ->where('id', $id)
                                                    ->get();

        $getPettyCashSummaries = DnoFoodVenturesPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = DnoFoodVenturesPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = DnoFoodVenturesPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;


        return view('dno-food-ventures-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
    }

    public function updatePC(Request $request, $id){
        $updatePC = DnoFoodVenturesPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashDnoFoodVentures', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addNew = new DnoFoodVenturesPettyCash([
            'user_id'=>$user->id,
            'pc_id'=>$id,
            'date'=>$request->get('date'),
            'petty_cash_summary'=>$request->get('pettyCashSummary'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNew->save();

        Session::flash('addNewSuccess', 'Successfully added.');

        return redirect()->route('editPettyCashDnoFoodVentures', ['id'=>$id]);
    }

    public function updatePettyCash(Request $request, $id){
        $update = DnoFoodVenturesPettyCash::find($id);
        $update->date = $request->get('date');
        $update->petty_cash_name = $request->get('pettyCashName');
        $update->petty_cash_summary = $request->get('pettyCashSummary');
        $update->amount = $request->get('amount');

        $update->save();
        Session::flash('editSuccess', 'Successfully updated.'); 

        return redirect()->route('editPettyCashDnoFoodVentures', ['id'=>$id]);
    }

    public function editPettyCash($id){
        $pettyCash =  DnoFoodVenturesPettyCash::with(['user', 'petty_cashes'])
                                                ->where('id', $id)
                                                ->get();

        $pettyCashSummaries = DnoFoodVenturesPettyCash::where('pc_id', $id)->get()->toArray();

        return view('edit-dno-food-ventures-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }
    
    public function addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table dno personal codes
         $dataCashNo = DB::select('SELECT id, dno_food_venture_code FROM dno_food_ventures_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
         if(isset($dataCashNo[0]->dno_food_venture_code) != 0){
             //if code is not 0
             $newProd = $dataCashNo[0]->dno_food_venture_code +1;
             $uPetty = sprintf("%06d",$newProd);   
 
         }else{
             //if code is 0 
             $newProd = 1;
             $uPetty = sprintf("%06d",$newProd);
         } 

         $addPettyCash = new DnoFoodVenturesPettyCash([
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

        $dnoFoundation = new DnoFoodVenturesCode([
            'user_id'=>$user->id,
            'dno_food_venture_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $dnoFoundation->save();
      
        return response()->json($insertId);


    }
    
    public function pettyCashList(){
        $pettyCashLists =  DnoFoodVenturesPettyCash::with(['user', 'petty_cashes'])
                                                        ->where('pc_id', NULL)
                                                        ->where('deleted_at', NULL)
                                                        ->orderBy('id', 'desc')
                                                        ->get();
        return view('dno-food-ventures-petty-cash-list', compact('pettyCashLists'));
    }   

    public function viewSalesInvoice($id){
        $viewSalesInvoice = DnoFoodVenturesSalesInvoice::with(['user', 'sales_invoices'])
                                ->where('id', $id)
                                ->get();

        $salesInvoices = DnoFoodVenturesSalesInvoice::where('si_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoFoodVenturesSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = DnoFoodVenturesSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-dno-food-ventures-sales-invoice', compact('viewSalesInvoice', 'salesInvoices', 'sum'));
    }

    public function updateSalesInvoice(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $updateSalesInvoice = DnoFoodVenturesSalesInvoice::find($id);

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

        return redirect()->route('editSalesInvoiceDnoFoodVentures', ['id'=>$id]);

    }

    public function updateSi(Request $request, $id){
        $updateSi = DnoFoodVenturesSalesInvoice::find($id);

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

        return redirect()->route('editSalesInvoiceDnoFoodVentures', ['id'=>$request->get('siId')]);

    }

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

         $addNewSalesInvoice = new DnoFoodVenturesSalesInvoice([
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

        return redirect()->route('editSalesInvoiceDnoFoodVentures', ['id'=>$id]);
   
    }

    public function editSalesInvoice($id){
        //getSalesInvoice
        $getSalesInvoice = DnoFoodVenturesSalesInvoice::find($id);

        $sInvoices  = DnoFoodVenturesSalesInvoice::where('si_id', $id)->get()->toArray();
  
        return view('edit-dno-food-ventures-sales-invoice' ,  compact('id', 'getSalesInvoice', 'sInvoices'));
    }

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

         //get the latest insert id query in table lolo_pinoy_grill_commissary
         $dataSalesNo = DB::select('SELECT id, dno_food_venture_code FROM dno_food_ventures_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 dr_no
         if(isset($dataSalesNo[0]->dno_food_venture_code) != 0){
             //if code is not 0
             $newSI = $dataSalesNo[0]->dno_food_venture_code +1;
             $uSI = sprintf("%06d",$newSI);   
 
         }else{
             //if code is 0 
             $newSI = 1;
             $uSI = sprintf("%06d",$newSI);
         } 
 
          //get date today
         $getDateToday =  date('Y-m-d');
 
         //total kls
         $kls = $request->get('totalKls');
 
         //compute kls * unit price
         $unitPrice = 500;
         $compute = $kls * $unitPrice;
         $sum = $compute;

         $addSalesInvoice = new DnoFoodVenturesSalesInvoice([
            'user_id'=>$user->id,
            'invoice_number'=>$request->get('invoiceNum'),
            'ordered_by'=>$request->get('orderedBy'),
            'address'=>$request->get('address'),
            'date'=>$request->get('date'),
            'qty'=>$request->get('qty'),
            'total_kls'=>$kls,
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'created_by'=>$name,
        ]);

        $addSalesInvoice->save();

        $insertedId = $addSalesInvoice->id;

        $moduleCode = "SI-";
        $moduleName = "Sales Invoice";

         //save to lolo_pinoy_grill_commissary_codes table
         $dnoCode = new DnoFoodVenturesCode([
            'user_id'=>$user->id,
            'dno_food_venture_code'=>$uSI,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);

        $dnoCode->save();

        return redirect()->route('editSalesInvoiceDnoFoodVentures', ['id'=>$insertedId]);
    }

    public function salesInvoiceForm(){
        return view('dno-food-ventures-sales-invoice-form');
    }

    public function viewBillingStatement($id){
        $viewBillingStatement =DnoFoodVenturesBillingStatement::with(['user', 'billing_statements'])
                            ->where('id', $id)    
                            ->get();

        
        $billingStatements = DnoFoodVenturesBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoFoodVenturesBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = DnoFoodVenturesBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-dno-food-ventures-billing-statement', compact('viewBillingStatement', 'billingStatements', 'sum'));

                  
    }

    public function addNewBillingData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = DnoFoodVenturesBillingStatement::find($id);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $amount = $request->get('amount');
        $tot = $billingOrder->total_amount + $amount;

        if($request->get('choose') === "Sales Invoice"){
            $order = $request->get('choose');
            $invoiceNo = $request->get('invoiceNumber');
            $invoiceListId = $request->get('invoiceListId');
            $qty = $request->get('qty');
            $totalKls = $request->get('totalKls');
            $unitPrice = $request->get('unitPrice');

            $drNo = NULL;
            $productId = NULL;
            $unit = NULL;
            $drList = NULL;
            $unit = NULL;
        }else{
            $order = $request->get('choose');
            $qty = $request->get('qty');
            $unitPrice = $request->get('unitPrice');
            $drNo = $request->get('drNo');
            $productId  = $request->get('productId');
            $unit = $request->get('unit'); 
            $drList = $request->get('drList');
            $unit = $request->get('unit');

            $invoiceNo = NULL;
            $invoiceListId = NULL;
            $totalKls = NULL; 
        }

        $addNewBillingStatement = new DnoFoodVenturesBillingStatement([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'date_of_transaction'=>$request->get('transactionDate'),
            'order'=>$order,
            'invoice_list_id'=>$invoiceListId,
            'qty'=>$qty,
            'dr_no'=>$drNo,
            'dr_list_id'=>$drList,
            'product_id'=>$productId,
            'total_kls'=>$totalKls,
            'invoice_number'=>$request->get('invoiceNumber'),
            'description'=>$request->get('description'),
            'unit_price'=>$unitPrice,
            'unit'=>$unit,
            'amount'=>$request->get('amount'),
            'total_amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewBillingStatement->save();

        $addStatementAccount = new DnoFoodVenturesStatementOfAccount([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'date_of_transaction'=>$request->get('transactionDate'),
            'order'=>$order,
            'invoice_list_id'=>$invoiceListId,
            'qty'=>$qty,
            'dr_no'=>$drNo,
            'dr_list_id'=>$drList,
            'product_id'=>$productId,
            'total_kls'=>$totalKls,
            'invoice_number'=>$request->get('invoiceNumber'),
            'description'=>$request->get('description'),
            'unit_price'=>$unitPrice,
            'unit'=>$unit,
            'amount'=>$request->get('amount'),
            'total_amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addStatementAccount->save();
        $statementOrder = DnoFoodVenturesStatementOfAccount::find($id);  


         //update
         $billingOrder->total_amount = $tot;
         $billingOrder->save();

           //update soa table
        $statementOrder->total_amount  = $tot;
        $statementOrder->total_remaining_balance = $tot;
        $statementOrder->save();

         Session::flash('addBillingSuccess', 'Successfully added.');
         return redirect()->route('editBillingStatementDnoFoodVentures', ['id'=>$id]);

    }

    public function billingStatementLists(){
        $billingStatements = DnoFoodVenturesBillingStatement::with(['user', 'billing_statements'])
                            ->where('billing_statement_id', NULL)
                            ->where('deleted_at', NULL)
                            ->orderBy('id', 'desc')
                            ->get();

        return view('dno-food-ventures-billing-statement-lists', compact('billingStatements'));
    }

    public function updateBillingInfo(Request $request, $id){
        $updateBillingOrder = DnoFoodVenturesBillingStatement::find($id);

        $updateBillingOrder->bill_to = $request->get('billTo');
        $updateBillingOrder->address = $request->get('address');
        $updateBillingOrder->period_cover = $request->get('periodCovered');
        $updateBillingOrder->date = $request->get('date');
        $updateBillingOrder->terms = $request->get('terms');
        $updateBillingOrder->invoice_number = $request->get('invoiceNumber');
        $updateBillingOrder->date_of_transaction = $request->get('transactionDate');
        $updateBillingOrder->description = $request->get('description');
        
        $updateBillingOrder->save();
        
        Session::flash('SuccessE', 'Successfully updated');

        return redirect()->route('editBillingStatementDnoFoodVentures', ['id'=>$id]);

    }

    public function editBillingStatement($id){
        $billingStatement =DnoFoodVenturesBillingStatement::with(['user', 'billing_statements'])
                            ->where('id', $id)    
                            ->get();

        $drNos = DnoFoodVenturesDeliveryReceipt::with(['user', 'delivery_receipts'])
                            ->where('dr_id', NULL)
                            ->where('deleted_at', NULL)
                            ->orderBy('id', 'desc')
                            ->get();

        $getAllSalesInvoices = DnoFoodVenturesSalesInvoice::with(['user', 'sales_invoices'])
                        ->where('si_id', NULL)
                        ->where('deleted_at', NULL)
                        ->orderBy('id', 'desc')
                        ->get();

        $bStatements = DnoFoodVenturesBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //
        $getPurchaseOrders = DnoFoodVenturesPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('edit-dno-food-ventures-billing-statement', compact('id', 'billingStatement', 
        'getPurchaseOrders', 'bStatements', 'drNos', 'getAllSalesInvoices'));
                    
    }

    public function storeBillingStatement(Request $request){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName.$lastName;

          //validate
        $this->validate($request, [
            'billTo' =>'required',
            'address'=>'required',
            'periodCovered'=>'required',
            'date'=>'required',
            'terms'=>'required',
            'transactionDate'=>'required',
            'description'=>'required',
        ]);

    
        $dataReferenceNum = DB::select('SELECT dno_food_venture_code FROM dno_food_ventures_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataReferenceNum[0]->dno_food_venture_code) != 0){
            //if code is not 0
            $newRefNum = $dataReferenceNum[0]->dno_food_venture_code +1;
            $uRef = sprintf("%06d",$newRefNum);   

        }else{
            //if code is 0 
            $newRefNum = 1;
            $uRef = sprintf("%06d",$newRefNum);
        } 

        if($request->get('choose') === "Sales Invoice"){
            $order = $request->get('choose');
            $invoiceNo = $request->get('invoiceNumber');
            $invoiceListId = $request->get('invoiceListId');
            $qty = $request->get('qty');
            $totalKls = $request->get('totalKls');
            $unitPrice = $request->get('unitPrice');

            $drNo = NULL;
            $productId = NULL;
            $unit = NULL;
            $drList = NULL;
            $unit = NULL;
        }else{
            $order = $request->get('choose');
            $qty = $request->get('qty');
            $unitPrice = $request->get('unitPrice');
            $drNo = $request->get('drNo');
            $productId  = $request->get('productId');
            $unit = $request->get('unit'); 
            $drList = $request->get('drList');
            $unit = $request->get('unit');

            $invoiceNo = NULL;
            $invoiceListId = NULL;
            $totalKls = NULL; 
        }

        $billingStatement = new DnoFoodVenturesBillingStatement([
            'user_id'=>$user->id,
            'bill_to'=>$request->get('billTo'),
            'address'=>$request->get('address'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'invoice_number'=>$invoiceNo,
            'terms'=>$request->get('terms'),
            'date_of_transaction'=>$request->get('transactionDate'),
            'order'=>$order,
            'invoice_list_id'=>$invoiceListId,
            'qty'=>$qty,
            'dr_no'=>$drNo,
            'dr_list_id'=>$drList,
            'product_id'=>$productId,
            'total_kls'=>$totalKls,
            'description'=>$request->get('description'),
            'unit_price'=>$unitPrice,
            'unit'=>$unit,
            'amount'=>$request->get('amount'),
            'total_amount'=>$request->get('amount'),
            'created_by'=>$name,
            'prepared_by'=>$name,

        ]);

        $billingStatement->save();

        $insertedId = $billingStatement->id;

        $moduleCode = "BS-";
        $moduleName = "Billing Statement";

        $dnoFoodVenturesCode = new DnoFoodVenturesCode([
            'user_id'=>$user->id,
            'dno_food_venture_code'=>$uRef,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);

        $dnoFoodVenturesCode->save();
        $bsNo = $dnoFoodVenturesCode->id;

        $bsNoId = DnoFoodVenturesCode::find($bsNo);

        $statementAccount = new DnoFoodVenturesStatementOfAccount([
            'user_id'=>$user->id,
            'bs_no'=>$bsNoId->dno_food_venture_code,
            'bill_to'=>$request->get('billTo'),
            'period_cover'=>$request->get('periodCovered'),
            'order'=>$order,
            'date'=>$request->get('date'),
            'terms'=>$request->get('terms'),
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

        $statement = new DnoFoodVenturesCode([
            'user_id'=>$user->id,
            'dno_food_venture_code'=>$uRefState,
            'module_id'=>$insertedIdStatement,
            'module_code'=>$moduleCodeSOA,
            'module_name'=>$moduleNameSOA,
        ]);
        $statement->save();

        return redirect()->route('editBillingStatementDnoFoodVentures', ['id'=>$insertedId]);
       
    }


    public function billingStatementForm(){
        $drNos = DnoFoodVenturesDeliveryReceipt::with(['user', 'delivery_receipts'])
                                    ->where('dr_id', NULL)
                                    ->where('deleted_at', NULL)
                                    ->orderBy('id', 'desc')
                                    ->get();

        $getAllSalesInvoices = DnoFoodVenturesSalesInvoice::with(['user', 'sales_invoices'])
                                ->where('si_id', NULL)
                                ->where('deleted_at', NULL)
                                ->orderBy('id', 'desc')
                                ->get();
 
        return view('dno-food-ventures-billing-statement-form', compact('drNos', 'getAllSalesInvoices'));
    }

    public function inventoryStockUpdate(Request $request){
        $updateInventoryStock = DnoFoodVenturesRawMaterial::find($request->id);
        $qty = $request->qty;

        $updateInventoryStock->date = $request->date;
        $updateInventoryStock->qty = $qty;
        $updateInventoryStock->unit = $request->unit;
        $updateInventoryStock->status = $request->status;
        $updateInventoryStock->requesting_branch = $request->requestingBranch;
        $updateInventoryStock->cheque_no_issued = $request->chequeNoIssued;
        $updateInventoryStock->remarks = $request->remarks;

        $updateInventoryStock->save();

        $updateRawMaterial = DnoFoodVenturesRawMaterial::find($request->mainId);
        $unitPrice = $updateRawMaterial->unit_price; 
      
        $add  = $qty + $updateRawMaterial->in; 

        $compute = $unitPrice * $add; 

        $updateRawMaterial->in = $add;
        $updateRawMaterial->amount = $compute;
        $updateRawMaterial->save();

        return response()->json('Success: Succesfully added a remarks.');
    }

    public function viewInventoryOfStocks($id){
        $viewStockDetail =DnoFoodVenturesRawMaterial::find($id)->with(['user', 'raw_material_product'])->get();

        $getViewStockDetails =DnoFoodVenturesRawMaterial::with(['user', 'raw_material_product'])
                            ->where('rm_id', $id)
                            ->get();

        return view('view-dno-food-ventures-inventory-stock', compact('viewStockDetail', 'getViewStockDetails'));        
    
    }

    public function inventoryOfStocks(){
        $getRawMaterials = DnoFoodVenturesRawMaterial::with(['user','raw_material_product',])
                    ->where('rm_id',  NULL)
                    ->get();
        
                    
        //count the total stock out amount value
        $countStockAmount = DnoFoodVenturesRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = DnoFoodVenturesRawMaterial::where('rm_id', NULL)->sum('amount');

        return view('commissary-inventory-of-stocks-dno-food-ventures', compact('getRawMaterials', 'countStockAmount' ,'countTotalAmount'));        
    
    }

    public function commissaryDeliveryOutlet(){
        $descriptionDIn = "DELIVERY IN";
        $descriptionDOut = "DELIVERY OUT";

        $getDeliveryOutlets = DnoFoodVenturesRawMaterial::with(['user','raw_material_product',])
                            ->where('rm_id', '!=', NULL)
                            ->where('description', $descriptionDIn)
                            ->get();
        $getDeliveryOutletsOuts = DnoFoodVenturesRawMaterial::with(['user','raw_material_product',])
                            ->where('rm_id', '!=', NULL)
                            ->where('description', $descriptionDOut)
                            ->get();

        return view('commissary-delivery-outlet-dno-food-ventures', compact('getDeliveryOutlets', 'getDeliveryOutletsOuts'));
    }

    public function stocksInventory(){
        $getRawMaterials = DnoFoodVenturesRawMaterial::with(['user','raw_material_product',])
                    ->where('rm_id', NULL)
                    ->orderBy('id', 'desc')
                    ->get();


        //count the total stock out amount value
        $countStockAmount = DnoFoodVenturesRawMaterial::all()->sum('stock_amount');

        //count the total amount 
        $countTotalAmount = DnoFoodVenturesRawMaterial::all()->sum('amount');

        return view('commissary-stocks-inventory-dno-food-ventures', compact('getRawMaterials'));
    }

    public function viewRawMaterialDetails($id){
        $viewRawDetail = DnoFoodVenturesRawMaterial::with(['user','raw_material_product',])
                    ->orderBy('id', 'desc')
                    ->where('id', $id)
                    ->get();

        $getViewRawDetails = DnoFoodVenturesRawMaterial::where('rm_id', $id)->get()->toArray();

        return view('view-dno-food-ventures-raw-material-details', compact('viewRawDetail', 'getViewRawDetails'));

    }

    public function updateRawMaterial(Request $request){
        $updateRawMaterial = DnoFoodVenturesRawMaterial::find($request->id);
        
         //unit price times number of IN products
         $unitPrice = $request->unitPrice1 * $request->stockIn1;

         $amount = $unitPrice;
         $updateRawMaterial->product_name = $request->productName1;
         $updateRawMaterial->unit_price = $request->unitPrice1;
         $updateRawMaterial->unit = $request->unit1;
         $updateRawMaterial->in = $request->stockIn1;
         $updateRawMaterial->remaining_stock = $request->stockIn1;
         $updateRawMaterial->amount = $amount;
         $updateRawMaterial->supplier = $request->supplier1;
 
         $updateRawMaterial->save();
 
         return response()->json('Success: successfully updated.');  
    }

    public function addRawMaterial(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //
        $dataProductId = DB::select('SELECT id, product_id_no FROM dno_food_ventures_raw_material_products ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 product id no
        if(isset($dataProductId[0]->product_id_no) != 0){
            //if code is not 0
            $newProd = $dataProductId[0]->product_id_no +1;
            $uProd = sprintf("%06d",$newProd);   

        }else{
            //if code is 0 
            $newProd = 1;
            $uProd = sprintf("%06d",$newProd);
        } 

          //unit price times number of IN products
          $unitPrice = $request->unitPrice * $request->stockIn;

          $amount = $unitPrice;
  
           //check if product name name exits
           $target = DB::table(
                  'dno_food_ventures_raw_materials')
                  ->where('product_name', $request->productName)
                  ->get()->first();

            if($target  === NULL){
                $addNewRawMaterial = new DnoFoodVenturesRawMaterial([
                    'user_id'=>$user->id,
                    'product_name'=>$request->productName,
                    'unit_price'=>$request->unitPrice,
                    'unit'=>$request->unit,
                    'in'=>$request->stockIn,
                    'remaining_stock'=>$request->stockIn,
                    'amount'=>$amount,
                    'supplier'=>$request->supplier,
                    'created_by'=>$name,
                ]);
        
                $addNewRawMaterial->save();
                $insertedId = $addNewRawMaterial->id;
        
                //save to table lolo_pinoy_grill_commissary_raw_material_products
                $addNewProd = new DnoFoodVenturesRawMaterialProduct([
                    'raw_materials_id'=>$insertedId,
                    'branch'=>$request->branch,
                    'product_id_no'=>$uProd,
                ]);
        
                $addNewProd->save();
        
                return response()->json('Success: successfully add RAW material.');    
    
            }else{
                return response()->json('Failed: Already exist.');

            }
        
  

    }

    public function rawMaterials(){  
        $getRawMaterials = DnoFoodVenturesRawMaterial::with(['user','raw_material_product',])
                        ->orderBy('id', 'desc')
                        ->get();
        
        return view('commissary-raw-materials-dno-food-ventures', compact('getRawMaterials'));
    }

    public function printDelivery($id){
      
        $deliveryId = DnoFoodVenturesDeliveryReceipt::with(['user', 'delivery_receipts'])
                        ->where('id', $id)
                        ->get();
      
        $deliveryReceipts = DnoFoodVenturesDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        //count the total unit price
        $countTotalUnitPrice = DnoFoodVenturesDeliveryReceipt::where('id', $id)->sum('unit_price');
        
        //
        $countUnitPrice = DnoFoodVenturesDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


        //count the total amount
        $countTotalAmount = DnoFoodVenturesDeliveryReceipt::where('id', $id)->sum('amount');
        
        //
        $countAmount = DnoFoodVenturesDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('DnoFoodVenturesPrintDelivery', compact('deliveryId', 'deliveryReceipts', 'sum2'));

        return $pdf->download('dno-food-ventures-delivery-receipt.pdf');

    }

    public function viewDeliveryReceipt($id){
        $viewDeliveryReceipt = DnoFoodVenturesDeliveryReceipt::with(['user', 'delivery_receipts'])
                            ->where('id', $id)
                            ->get();        


        $deliveryReceipts = DnoFoodVenturesDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        //count the total unit price
        $countTotalUnitPrice = DnoFoodVenturesDeliveryReceipt::where('id', $id)->sum('unit_price');
        
        //
        $countUnitPrice = DnoFoodVenturesDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


            //count the total amount
        $countTotalAmount = DnoFoodVenturesDeliveryReceipt::where('id', $id)->sum('amount');
        
        //
        $countAmount = DnoFoodVenturesDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        return view('view-dno-food-ventures-delivery-receipt', compact('viewDeliveryReceipt', 'deliveryReceipts', 'sum', 'sum2'));
 
    }



    public function deliveryReceiptList(){
        $getAllDeliveryReceipts = DnoFoodVenturesDeliveryReceipt::with(['user', 'delivery_receipts'])
                                ->where('dr_id', NULL)
                                ->where('deleted_at', NULL)
                                ->orderBy('id', 'desc')
                                ->get();  
        
        return view('dno-food-ventures-delivery-receipt-list', compact('getAllDeliveryReceipts'));
    }

    public function updateDeliveryReceipt(Request $request, $id){
        $updateDeliveryReceipt = DnoFoodVenturesDeliveryReceipt::find($id);
     
        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $updateDeliveryReceipt->delivered_to = $request->get('deliveredTo');
        $updateDeliveryReceipt->product_id  = $request->get('productId');
        $updateDeliveryReceipt->qty = $request->get('qty');
        $updateDeliveryReceipt->unit = $request->get('unit');
        $updateDeliveryReceipt->item_description = $request->get('itemDescription');
        $updateDeliveryReceipt->unit_price = $unitPrice;
        $updateDeliveryReceipt->address = $request->get('address');
        $updateDeliveryReceipt->charge_to = $request->get('chargeTo');
        $updateDeliveryReceipt->address_to = $request->get('addressTo');
        $updateDeliveryReceipt->amount = $sum;

        $updateDeliveryReceipt->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect()->route('DnoFoodVentures.editDeliveryReceipt', ['id'=>$id]);
    }


    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $deliveryReceipt = DnoFoodVenturesDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $getAmount = $deliveryReceipt->total_amount + $sum;

        $avail = $request->get('productId'); 
        $availExp = explode("-", $avail);

        $rawMaterial = DB::table(
                    'dno_food_ventures_raw_materials')
                    ->select(
                        'dno_food_ventures_raw_materials.id',
                        'dno_food_ventures_raw_materials.user_id',
                        'dno_food_ventures_raw_materials.rm_id',
                        'dno_food_ventures_raw_materials.product_name',
                        'dno_food_ventures_raw_materials.unit_price',
                        'dno_food_ventures_raw_materials.unit',
                        'dno_food_ventures_raw_materials.in',
                        'dno_food_ventures_raw_materials.out',
                        'dno_food_ventures_raw_materials.stock_amount',
                        'dno_food_ventures_raw_materials.remaining_stock',
                        'dno_food_ventures_raw_materials.amount',
                        'dno_food_ventures_raw_materials.supplier',
                        'dno_food_ventures_raw_materials.date',
                        'dno_food_ventures_raw_materials.item',
                        'dno_food_ventures_raw_materials.description',
                        'dno_food_ventures_raw_materials.reference_no',
                        'dno_food_ventures_raw_materials.qty',
                        'dno_food_ventures_raw_materials.requesting_branch',
                        'dno_food_ventures_raw_materials.cheque_no_issued',
                        'dno_food_ventures_raw_materials.status',
                        'dno_food_ventures_raw_materials.created_by',
                        'dno_food_ventures_raw_material_products.raw_materials_id',
                        'dno_food_ventures_raw_material_products.branch',
                        'dno_food_ventures_raw_material_products.product_id_no')
                    ->leftJoin('dno_food_ventures_raw_material_products', 'dno_food_ventures_raw_materials.id', '=', 'dno_food_ventures_raw_material_products.raw_materials_id')
                    ->where('dno_food_ventures_raw_material_products.raw_materials_id', $availExp[0])
                    ->orderBy('dno_food_ventures_raw_materials.id', 'desc')
                    ->get();

        //minus available pcs from the qty
        $aPcs = $rawMaterial[0]->remaining_stock - $qty;
    
        //add qty to out 
        $out = $rawMaterial[0]->out + $qty;
            
        //compute the stock out amount in unit price
        $stockAmount = $rawMaterial[0]->unit_price * $qty;

         //update raw material table
        $updateRawMaterial = DnoFoodVenturesRawMaterial::find($availExp[0]);
    
        $updateRawMaterial->out = $out;
        $updateRawMaterial->remaining_stock = $aPcs;
        $updateRawMaterial->stock_amount = $stockAmount;
        $updateRawMaterial->save();

        //get date today
        $getDateToday =  date('Y-m-d');

        $addNewDeliveryReceipt = new DnoFoodVenturesDeliveryReceipt([
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

        $deliveryReceipt->total_amount  = $getAmount; 
        $deliveryReceipt->save();


        Session::flash('addDeliveryReceiptSuccess', 'Successfully added.');

        return redirect()->route('DnoFoodVentures.editDeliveryReceipt', ['id'=>$id]);

    }

    public function editDeliveryReceipt($id){
        //getDeliveryReceipt
        $getDeliveryReceipt = DnoFoodVenturesDeliveryReceipt::find($id);
    
        $getRawMaterials = DnoFoodVenturesRawMaterial::with(['user','raw_material_product',])
                        ->where('rm_id', NULL)
                        ->orderBy('id', 'desc')
                        ->get();

        //dReceipts
        $dReceipts = DnoFoodVenturesDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-dno-food-ventures-delivery-receipt', compact('id',
        'getDeliveryReceipt', 'dReceipts', 'getRawMaterials'));
    }

    public function storeDeliveryReceipt(Request $request){
        //validate
           $this->validate($request, [
            'deliveredTo' =>'required',
           
        ]);

        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

          //get the latest insert id query in table lolo_pinoy_grill_code
          $dataDrNo = DB::select('SELECT id, dno_food_venture_code FROM dno_food_ventures_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 dr_no
          if(isset($dataDrNo[0]->dno_food_venture_code) != 0){
              //if code is not 0
              $newDr = $dataDrNo[0]->dno_food_venture_code +1;
              $uDr = sprintf("%06d",$newDr);   
  
          }else{
              //if code is 0 
              $newDr = 1;
              $uDr = sprintf("%06d",$newDr);
          } 

          $qty = $request->get('qty');
          $unitPrice = $request->get('unitPrice');
  
          $compute = $qty * $unitPrice;
          $sum = $compute;
  
          $avail = $request->get('productId'); 
          $availExp = explode("-", $avail);
          
          $rawMaterial = DB::table(
                    'dno_food_ventures_raw_materials')
                    ->select(
                        'dno_food_ventures_raw_materials.id',
                        'dno_food_ventures_raw_materials.user_id',
                        'dno_food_ventures_raw_materials.rm_id',
                        'dno_food_ventures_raw_materials.product_name',
                        'dno_food_ventures_raw_materials.unit_price',
                        'dno_food_ventures_raw_materials.unit',
                        'dno_food_ventures_raw_materials.in',
                        'dno_food_ventures_raw_materials.out',
                        'dno_food_ventures_raw_materials.stock_amount',
                        'dno_food_ventures_raw_materials.remaining_stock',
                        'dno_food_ventures_raw_materials.amount',
                        'dno_food_ventures_raw_materials.supplier',
                        'dno_food_ventures_raw_materials.date',
                        'dno_food_ventures_raw_materials.item',
                        'dno_food_ventures_raw_materials.description',
                        'dno_food_ventures_raw_materials.reference_no',
                        'dno_food_ventures_raw_materials.qty',
                        'dno_food_ventures_raw_materials.requesting_branch',
                        'dno_food_ventures_raw_materials.cheque_no_issued',
                        'dno_food_ventures_raw_materials.status',
                        'dno_food_ventures_raw_materials.created_by',
                        'dno_food_ventures_raw_material_products.raw_materials_id',
                        'dno_food_ventures_raw_material_products.branch',
                        'dno_food_ventures_raw_material_products.product_id_no')
                    ->leftJoin('dno_food_ventures_raw_material_products', 'dno_food_ventures_raw_materials.id', '=', 'dno_food_ventures_raw_material_products.raw_materials_id')
                    ->where('dno_food_ventures_raw_material_products.raw_materials_id', $availExp[0])
                    ->orderBy('dno_food_ventures_raw_materials.id', 'desc')
                    ->get();

        //minus available pcs from the qty
        $aPcs = $rawMaterial[0]->remaining_stock - $qty;

        //add qty to out 
        $out = $rawMaterial[0]->out + $qty;

        //compute the stock out amount in unit price
        $stockAmount = $rawMaterial[0]->unit_price * $qty;

         //update 
        $updateRawMaterial = DnoFoodVenturesRawMaterial::find($availExp[0]);
        
        $updateRawMaterial->out = $out;
        $updateRawMaterial->remaining_stock = $aPcs;
        $updateRawMaterial->stock_amount = $stockAmount;
        $updateRawMaterial->save();

        $storeDeliveryReceipt = new DnoFoodVenturesDeliveryReceipt([
            'user_id'=>$user->id,            
            'dr_no'=>$uDr,
            'date'=>$request->get('date'),
            'delivered_to'=>$request->get('deliveredTo'),
            'product_id'=>$request->get('productId'),
            'qty'=>$qty,
            'unit'=>$request->get('unit'),
            'item_description'=>$request->get('itemDescription'),
            'address'=>$request->get('address'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'total_amount'=>$sum,
            'charge_to'=>$request->get('chargeTo'),
            'address_to'=>$request->get('addressTo'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $storeDeliveryReceipt->save();
        $insertedId  = $storeDeliveryReceipt->id;

        $moduleCode = "DR-";
        $moduleName = "Delivery Receipt";

         //save to lolo_pinoy_grill_commissary_codes table
         $DnoFoodVentureCode = new DnoFoodVenturesCode([
                'user_id'=>$user->id,
                'dno_food_venture_code'=>$uDr,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,

        ]);

        $DnoFoodVentureCode->save();

        return redirect()->route('DnoFoodVentures.editDeliveryReceipt', ['id'=>$insertedId]);

    }
    
    public function deliveryReceiptForm(){
        $getRawMaterials = DnoFoodVenturesRawMaterial::with(['raw_material_product'])
                    ->orderBy('id', 'desc')
                    ->get();

        return view('dno-food-ventures-delivery-receipt-form', compact('getRawMaterials'));
    }

    public function printPO($id){
        $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                    'dno_food_ventures_purchase_orders')
                    ->select(
                        'dno_food_ventures_purchase_orders.id',
                        'dno_food_ventures_purchase_orders.user_id',
                        'dno_food_ventures_purchase_orders.po_id',
                        'dno_food_ventures_purchase_orders.paid_to',
                        'dno_food_ventures_purchase_orders.address',
                        'dno_food_ventures_purchase_orders.date',
                        'dno_food_ventures_purchase_orders.quantity',
                        'dno_food_ventures_purchase_orders.total_kls',
                        'dno_food_ventures_purchase_orders.description',
                        'dno_food_ventures_purchase_orders.unit_price',
                        'dno_food_ventures_purchase_orders.amount',
                        'dno_food_ventures_purchase_orders.total_price',
                        'dno_food_ventures_purchase_orders.requested_by',
                        'dno_food_ventures_purchase_orders.prepared_by',
                        'dno_food_ventures_purchase_orders.checked_by',
                        'dno_food_ventures_purchase_orders.created_by',
                        'dno_food_ventures_purchase_orders.deleted_at',
                        'dno_food_ventures_codes.dno_food_venture_code',
                        'dno_food_ventures_codes.module_id',
                        'dno_food_ventures_codes.module_code',
                        'dno_food_ventures_codes.module_name')
                    ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_purchase_orders.id', '=', 'dno_food_ventures_codes.module_id')
                    ->where('dno_food_ventures_purchase_orders.id',$id)
                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                    ->get();

        
        $pOrders = DnoFoodVenturesPurchaseOrder::where('po_id', $id)->get()->toArray();

            //count the total amount 
        $countTotalAmount = DnoFoodVenturesPurchaseOrder::where('id', $id)->sum('amount');
    
            //
        $countAmount = DnoFoodVenturesPurchaseOrder::where('po_id', $id)->sum('amount');
    
        $sum  = $countTotalAmount + $countAmount;
    
    
        $pdf = PDF::loadView('printPODnoFoodVentures', compact('purchaseOrder', 'pOrders', 'sum'));
    
        return $pdf->download('dno-food-ventures-purchase-order.pdf');
    }

    public function purchaseOrderList(){
        $moduleName = "Purchase Order";
        $purchaseOrders = DB::table(
                    'dno_food_ventures_purchase_orders')
                    ->select(
                        'dno_food_ventures_purchase_orders.id',
                        'dno_food_ventures_purchase_orders.user_id',
                        'dno_food_ventures_purchase_orders.po_id',
                        'dno_food_ventures_purchase_orders.paid_to',
                        'dno_food_ventures_purchase_orders.address',
                        'dno_food_ventures_purchase_orders.date',
                        'dno_food_ventures_purchase_orders.quantity',
                        'dno_food_ventures_purchase_orders.total_kls',
                        'dno_food_ventures_purchase_orders.description',
                        'dno_food_ventures_purchase_orders.unit_price',
                        'dno_food_ventures_purchase_orders.amount',
                        'dno_food_ventures_purchase_orders.total_price',
                        'dno_food_ventures_purchase_orders.requested_by',
                        'dno_food_ventures_purchase_orders.prepared_by',
                        'dno_food_ventures_purchase_orders.checked_by',
                        'dno_food_ventures_purchase_orders.created_by',
                        'dno_food_ventures_purchase_orders.deleted_at',
                        'dno_food_ventures_codes.dno_food_venture_code',
                        'dno_food_ventures_codes.module_id',
                        'dno_food_ventures_codes.module_code',
                        'dno_food_ventures_codes.module_name')
                    ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_purchase_orders.id', '=', 'dno_food_ventures_codes.module_id')
                    ->where('dno_food_ventures_purchase_orders.po_id', NULL)
                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                    ->where('dno_food_ventures_purchase_orders.deleted_at', NULL)
                    ->orderBy('dno_food_ventures_purchase_orders.id', 'desc')
                    ->get()->toArray();

        return view('dno-food-ventures-purchase-order-list', compact('purchaseOrders'));
    }

    public function updatePo(Request $request, $id){
        $order = DnoFoodVenturesPurchaseOrder::find($id);
        $order->quantity = $request->get('quant');
        $order->description = $request->get('desc');
        $order->unit_price = $request->get('unitP');
        $order->amount = $request->get('amt');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect()->route('editDnoFoodVentures', ['id'=>$request->get('poId')]);

    }

    public function addNewPurchaseOrder(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pO = DnoFoodVenturesPurchaseOrder::find($id);
    
        $tot = $pO->total_price + $request->get('amount');

        $addPurchaseOrder = new DnoFoodVenturesPurchaseOrder([
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

        return redirect()->route('editDnoFoodVentures', ['id'=>$id]);
    }


    public function purchaseOrder(){

        return view('dno-food-ventures-purchase-order');
    }

    public function printSupplier($id){
        $viewSupplier = DnoFoodVenturesSupplier::where('id', $id)->get();

        $printSuppliers = DB::table(
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
                    'dno_food_ventures_payment_vouchers.supplier_name',
                    'dno_food_ventures_payment_vouchers.deleted_at',
                    'dno_food_ventures_suppliers.id',
                    'dno_food_ventures_suppliers.date',
                    'dno_food_ventures_suppliers.supplier_name')
                    ->leftJoin('dno_food_ventures_suppliers', 'dno_food_ventures_payment_vouchers.supplier_id', '=', 'dno_food_ventures_suppliers.id')
                    ->where('dno_food_ventures_suppliers.id', $id)
                    ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
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
                    'dno_food_ventures_payment_vouchers.supplier_name',
                    'dno_food_ventures_payment_vouchers.deleted_at',
                    'dno_food_ventures_suppliers.id',
                    'dno_food_ventures_suppliers.date',
                    'dno_food_ventures_suppliers.supplier_name')
                    ->leftJoin('dno_food_ventures_suppliers', 'dno_food_ventures_payment_vouchers.supplier_id', '=', 'dno_food_ventures_suppliers.id')
                    ->where('dno_food_ventures_suppliers.id', $id)
                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $status)
                    ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSupplierDnoFoodVentures', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('dno-food-ventures-supplier.pdf');
    }

    public function viewSupplier($id){
        $viewSupplier = DnoFoodVenturesSupplier::where('id', $id)->get();

        $supplierLists = DB::table(
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
                    'dno_food_ventures_payment_vouchers.supplier_name',
                    'dno_food_ventures_payment_vouchers.deleted_at',
                    'dno_food_ventures_suppliers.date',
                    'dno_food_ventures_suppliers.supplier_name')
                    ->leftJoin('dno_food_ventures_suppliers', 'dno_food_ventures_payment_vouchers.supplier_id', '=', 'dno_food_ventures_suppliers.id')
                    ->where('dno_food_ventures_suppliers.id', $id)
                    ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
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
                    'dno_food_ventures_payment_vouchers.supplier_name',
                    'dno_food_ventures_payment_vouchers.deleted_at',
                    'dno_food_ventures_suppliers.id',
                    'dno_food_ventures_suppliers.date',
                    'dno_food_ventures_suppliers.supplier_name')
                    ->leftJoin('dno_food_ventures_suppliers', 'dno_food_ventures_payment_vouchers.supplier_id', '=', 'dno_food_ventures_suppliers.id')
                    ->where('dno_food_ventures_suppliers.id', $id)
                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $status)
                    ->sum('dno_food_ventures_payment_vouchers.amount_due');

        return view('view-dno-food-ventures-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue')); 


    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //check if supplier name exits
        $target = DB::table(
            'dno_food_ventures_suppliers')
            ->where('supplier_name', $request->supplierName)
            ->get()->first();
        
        if($target === NULL){
            $supplier = new DnoFoodVenturesSupplier([
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
        $suppliers = DnoFoodVenturesSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('dno-food-ventures-supplier', compact('suppliers'));
    }

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
         $uIdParticular->invoice_number = $request->invoiceN;
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
        $updateParticular->invoice_number = $request->invoiceNo;
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
                                'dno_food_ventures_payment_vouchers.currency',
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

        $currency = "USD";
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
                                    'dno_food_ventures_payment_vouchers.currency',
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
                                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $currency)
                                    ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $totalAmountCheckInUSD = DB::table(
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
                                        'dno_food_ventures_payment_vouchers.currency',
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
                                        ->where('dno_food_ventures_payment_vouchers.status',  $currency)
                                        ->sum('dno_food_ventures_payment_vouchers.amount_due');
        
        return view('dno-food-ventures-multiple-summary-report', compact('getTransactionLists', 'startDate', 'endDate', 'getTransactionListCashes', 'totalAmountCashes', 
        'getTransactionListChecks', 'totalAmountCheck', 'totalAmountCheckInUSD'));


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
                                'dno_food_ventures_payment_vouchers.currency',
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
            
        $currency = "USD";
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
                                    'dno_food_ventures_payment_vouchers.currency',
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
                                    ->where('dno_food_ventures_payment_vouchers.currency', '!=', $currency)
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
                                        'dno_food_ventures_payment_vouchers.currency',
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
                                        ->where('dno_food_ventures_payment_vouchers.status',  $currency)
                                        ->sum('dno_food_ventures_payment_vouchers.cheque_total_amount');

        $totalAmountCheckInUSD = DB::table(
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
                                            'dno_food_ventures_payment_vouchers.currency',
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
                                            ->where('dno_food_ventures_payment_vouchers.currency', $currency)
                                            ->sum('dno_food_ventures_payment_vouchers.amount_due');


        
        $totalPaidAmountCheckInUSD  = DB::table(
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
                                                'dno_food_ventures_payment_vouchers.currency',
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
                                                ->where('dno_food_ventures_payment_vouchers.status',  $currency)
                                                ->sum('dno_food_ventures_payment_vouchers.cheque_total_amount');
        $getDateToday = "";
        $uri0  = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryDnoFoodVentures',  compact('date', 'getDateToday', 'uri0', 'uri1',
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck', 'totalAmountCheckInUSD', 'totalPaidAmountCheckInUSD'));
        
        return $pdf->download('dno-food-ventures-summary-report.pdf');
        
    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");

         //purchase order
        $moduleNamePurchaseOrder = "Purchase Order";
        $purchaseOrders = DB::table(
            'dno_food_ventures_purchase_orders')
            ->select(
                'dno_food_ventures_purchase_orders.id',
                'dno_food_ventures_purchase_orders.user_id',
                'dno_food_ventures_purchase_orders.po_id',
                'dno_food_ventures_purchase_orders.paid_to',
                'dno_food_ventures_purchase_orders.address',
                'dno_food_ventures_purchase_orders.date',
                'dno_food_ventures_purchase_orders.quantity',
                'dno_food_ventures_purchase_orders.total_kls',
                'dno_food_ventures_purchase_orders.description',
                'dno_food_ventures_purchase_orders.unit_price',
                'dno_food_ventures_purchase_orders.amount',
                'dno_food_ventures_purchase_orders.total_price',
                'dno_food_ventures_purchase_orders.requested_by',
                'dno_food_ventures_purchase_orders.prepared_by',
                'dno_food_ventures_purchase_orders.checked_by',
                'dno_food_ventures_purchase_orders.created_by',
                'dno_food_ventures_purchase_orders.deleted_at',
                'dno_food_ventures_codes.dno_food_venture_code',
                'dno_food_ventures_codes.module_id',
                'dno_food_ventures_codes.module_code',
                'dno_food_ventures_codes.module_name')
            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_purchase_orders.id', '=', 'dno_food_ventures_codes.module_id')
            ->where('dno_food_ventures_purchase_orders.po_id', NULL)
            ->where('dno_food_ventures_codes.module_name', $moduleNamePurchaseOrder)
            ->where('dno_food_ventures_purchase_orders.deleted_at', NULL)
            ->whereDate('dno_food_ventures_purchase_orders.created_at', '=', date($getDateToday))
            ->orderBy('dno_food_ventures_purchase_orders.id', 'desc')
            ->get()->toArray();

        $totalPOrder = DB::table(
                        'dno_food_ventures_purchase_orders')
                        ->select(
                            'dno_food_ventures_purchase_orders.id',
                            'dno_food_ventures_purchase_orders.user_id',
                            'dno_food_ventures_purchase_orders.po_id',
                            'dno_food_ventures_purchase_orders.paid_to',
                            'dno_food_ventures_purchase_orders.address',
                            'dno_food_ventures_purchase_orders.date',
                            'dno_food_ventures_purchase_orders.quantity',
                            'dno_food_ventures_purchase_orders.total_kls',
                            'dno_food_ventures_purchase_orders.description',
                            'dno_food_ventures_purchase_orders.unit_price',
                            'dno_food_ventures_purchase_orders.amount',
                            'dno_food_ventures_purchase_orders.total_price',
                            'dno_food_ventures_purchase_orders.requested_by',
                            'dno_food_ventures_purchase_orders.prepared_by',
                            'dno_food_ventures_purchase_orders.checked_by',
                            'dno_food_ventures_purchase_orders.created_by',
                            'dno_food_ventures_purchase_orders.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_purchase_orders.id', '=', 'dno_food_ventures_codes.module_id')
                        ->where('dno_food_ventures_purchase_orders.po_id', NULL)
                        ->where('dno_food_ventures_codes.module_name', $moduleNamePurchaseOrder)
                        ->where('dno_food_ventures_purchase_orders.deleted_at', NULL)
                        ->whereDate('dno_food_ventures_purchase_orders.created_at', '=', date($getDateToday))
                        ->sum('dno_food_ventures_purchase_orders.total_price');


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
                                'dno_food_ventures_payment_vouchers.currency',
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
        
        $currency  = "USD";
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
                                    'dno_food_ventures_payment_vouchers.currency',
                                    'dno_food_ventures_payment_vouchers.currency',
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
                                    ->where('dno_food_ventures_payment_vouchers.currency', '!=', $currency)
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
                                        'dno_food_ventures_payment_vouchers.currency',
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
                                        ->where('dno_food_ventures_payment_vouchers.status', $status)
                                        ->where('dno_food_ventures_payment_vouchers.currency', '!=', $currency)
                                        ->sum('dno_food_ventures_payment_vouchers.cheque_total_amount');

        $totalAmountCheckInUSD = DB::table(
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
                                            'dno_food_ventures_payment_vouchers.currency',
                                            'dno_food_ventures_payment_vouchers.currency',
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
                                            ->where('dno_food_ventures_payment_vouchers.currency', $currency)
                                            ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $totalPaidAmountCheckInUSD = DB::table(
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
                                                'dno_food_ventures_payment_vouchers.currency',
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
                                                ->where('dno_food_ventures_payment_vouchers.status', $status)
                                                ->where('dno_food_ventures_payment_vouchers.currency', $currency)
                                                ->sum('dno_food_ventures_payment_vouchers.cheque_total_amount');

        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryDnoFoodVentures',  compact('uri0', 'uri1','date', 'getDateToday', 
        'purchaseOrders', 'getTransactionListCashes', 'getTransactionListChecks','totalPOrder', 
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck', 'totalAmountCheckInUSD', 'totalPaidAmountCheckInUSD'));
        
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
                                'dno_food_ventures_payment_vouchers.currency',
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
        
        $currency = "USD";
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
                                    'dno_food_ventures_payment_vouchers.currency',
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
                                    ->where('dno_food_ventures_payment_vouchers.status', '!=', $currency)
                                    ->sum('dno_food_ventures_payment_vouchers.amount_due');

        $totalAmountCheckInUSD = DB::table(
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
                                        'dno_food_ventures_payment_vouchers.currency',
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
                                        ->where('dno_food_ventures_payment_vouchers.status', $currency)
                                        ->sum('dno_food_ventures_payment_vouchers.amount_due');
        
        return view('dno-food-ventures-get-summary-report', compact('getDate','getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 
        'getTransactionListChecks', 'totalAmountCheck', 'totalAmountCheckInUSD'));

    }

    public function summaryReport(){
        $getDateToday = date("Y-m-d");

         //purchase order
        $moduleNamePurchaseOrder = "Purchase Order";
        $purchaseOrders = DB::table(
                        'dno_food_ventures_purchase_orders')
                        ->select(
                            'dno_food_ventures_purchase_orders.id',
                            'dno_food_ventures_purchase_orders.user_id',
                            'dno_food_ventures_purchase_orders.po_id',
                            'dno_food_ventures_purchase_orders.paid_to',
                            'dno_food_ventures_purchase_orders.address',
                            'dno_food_ventures_purchase_orders.date',
                            'dno_food_ventures_purchase_orders.quantity',
                            'dno_food_ventures_purchase_orders.total_kls',
                            'dno_food_ventures_purchase_orders.description',
                            'dno_food_ventures_purchase_orders.unit_price',
                            'dno_food_ventures_purchase_orders.amount',
                            'dno_food_ventures_purchase_orders.total_price',
                            'dno_food_ventures_purchase_orders.requested_by',
                            'dno_food_ventures_purchase_orders.prepared_by',
                            'dno_food_ventures_purchase_orders.checked_by',
                            'dno_food_ventures_purchase_orders.created_by',
                            'dno_food_ventures_purchase_orders.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_purchase_orders.id', '=', 'dno_food_ventures_codes.module_id')
                        ->where('dno_food_ventures_purchase_orders.po_id', NULL)
                        ->where('dno_food_ventures_codes.module_name', $moduleNamePurchaseOrder)
                        ->where('dno_food_ventures_purchase_orders.deleted_at', NULL)
                        ->whereDate('dno_food_ventures_purchase_orders.created_at', '=', date($getDateToday))
                        ->orderBy('dno_food_ventures_purchase_orders.id', 'desc')
                        ->get()->toArray();

            $totalPOrder = DB::table(
                            'dno_food_ventures_purchase_orders')
                            ->select(
                                'dno_food_ventures_purchase_orders.id',
                                'dno_food_ventures_purchase_orders.user_id',
                                'dno_food_ventures_purchase_orders.po_id',
                                'dno_food_ventures_purchase_orders.paid_to',
                                'dno_food_ventures_purchase_orders.address',
                                'dno_food_ventures_purchase_orders.date',
                                'dno_food_ventures_purchase_orders.quantity',
                                'dno_food_ventures_purchase_orders.total_kls',
                                'dno_food_ventures_purchase_orders.description',
                                'dno_food_ventures_purchase_orders.unit_price',
                                'dno_food_ventures_purchase_orders.amount',
                                'dno_food_ventures_purchase_orders.total_price',
                                'dno_food_ventures_purchase_orders.requested_by',
                                'dno_food_ventures_purchase_orders.prepared_by',
                                'dno_food_ventures_purchase_orders.checked_by',
                                'dno_food_ventures_purchase_orders.created_by',
                                'dno_food_ventures_purchase_orders.deleted_at',
                                'dno_food_ventures_codes.dno_food_venture_code',
                                'dno_food_ventures_codes.module_id',
                                'dno_food_ventures_codes.module_code',
                                'dno_food_ventures_codes.module_name')
                            ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_purchase_orders.id', '=', 'dno_food_ventures_codes.module_id')
                            ->where('dno_food_ventures_purchase_orders.po_id', NULL)
                            ->where('dno_food_ventures_codes.module_name', $moduleNamePurchaseOrder)
                            ->where('dno_food_ventures_purchase_orders.deleted_at', NULL)
                            ->whereDate('dno_food_ventures_purchase_orders.created_at', '=', date($getDateToday))
                            ->sum('dno_food_ventures_purchase_orders.total_price');


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
                                'dno_food_ventures_payment_vouchers.currency',
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

        $currency = "USD";
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
                                    'dno_food_ventures_payment_vouchers.currency',
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
                                        'dno_food_ventures_payment_vouchers.currency',
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
    
            $totalAmountCheckInUSD = DB::table(
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
                                            'dno_food_ventures_payment_vouchers.currency',
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
                                            ->where('dno_food_ventures_payment_vouchers.status',  $status)
                                            ->sum('dno_food_ventures_payment_vouchers.amount_due');
                                        
        return view('dno-food-ventures-summary-report', compact('purchaseOrders', 'getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 
        'getTransactionListChecks', 'totalAmountCheck', 'totalAmountCheckInUSD', 'totalPOrder'));

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

        $getParticulars = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();

        $getChequeNumbers = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
        $amount1 = DnoFoodVenturesPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = DnoFoodVenturesPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoFoodVenturesPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

  
          $pdf = PDF::loadView('printPayablesDNOFoodVentures',  compact('payableId',  
          'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));
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
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }elseif($request->get('category') === "Petty Cash"){

            $subCat = $request->get('pettyCashNo');
            $subCatAccountId = NULL;    

            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') === "Utility"){
            $subCat = $request->get('utility');
            $subCatAccountId = $request->get('accountId');

            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') === "Payroll"){  
            $subCat = NULL;
            $subCatAccountId = NULL;
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') == "Supplier"){
            $supplier = $request->get('supplierName');
            $supplierExps = explode("-", $supplier);

            $supplierExp =  $supplierExps[0];
            $supplierExp1 = $supplierExps[1];

            $subCat = "NULL";
            $subCatAccountId = "NULL";
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
                'currency'=>$request->get('currency'),
                'amount_due'=>$request->get('amount'),
                'particulars'=>$request->get('particulars'),
                'category'=>$request->get('category'),
                'sub_category'=>$subCat,
                'sub_category_account_id'=>$subCatAccountId,
                'supplier_id'=>$supplierExp,
                'supplier_name'=>$supplierExp1,  
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

         //get suppliers
         $suppliers = DnoFoodVenturesSupplier::get()->toArray();

         $pettyCashes = DnoFoodVenturesPettyCash::with(['user', 'petty_cashes'])
                                                        ->where('pc_id', NULL)
                                                        ->where('deleted_at', NULL)
                                                        ->get();
        
        return view('payment-voucher-form-dno-food-ventures', compact('suppliers', 'pettyCashes'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $getAllSalesInvoices = DnoFoodVenturesSalesInvoice::with(['user', 'sales_invoices'])
                                ->where('si_id', NULL)
                                ->where('deleted_at', NULL)
                                ->orderBy('id', 'desc')
                                ->get();

         return view('dno-food-ventures', compact('getAllSalesInvoices'));
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
          $data = DB::select('SELECT id, dno_food_venture_code FROM dno_food_ventures_codes ORDER BY id DESC LIMIT 1');
        
          //if code is not zero add plus 1
           if(isset($data[0]->dno_food_venture_code) != 0){
              //if code is not 0
              $newNum = $data[0]->dno_food_venture_code +1;
              $uNum = sprintf("%06d",$newNum);    
          }else{
              //if code is 0 
              $newNum = 1;
              $uNum = sprintf("%06d",$newNum);
          }

          $purchaseOrder = new DnoFoodVenturesPurchaseOrder([
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
        $dnoFoodVenture = new DnoFoodVenturesCode([
            'user_id'=>$user->id,
            'dno_food_venture_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $dnoFoodVenture->save();

        return redirect()->route('editDnoFoodVentures', ['id'=>$insertedId]);
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
        $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                        'dno_food_ventures_purchase_orders')
                        ->select(
                            'dno_food_ventures_purchase_orders.id',
                            'dno_food_ventures_purchase_orders.user_id',
                            'dno_food_ventures_purchase_orders.po_id',
                            'dno_food_ventures_purchase_orders.paid_to',
                            'dno_food_ventures_purchase_orders.address',
                            'dno_food_ventures_purchase_orders.date',
                            'dno_food_ventures_purchase_orders.quantity',
                            'dno_food_ventures_purchase_orders.total_kls',
                            'dno_food_ventures_purchase_orders.description',
                            'dno_food_ventures_purchase_orders.unit_price',
                            'dno_food_ventures_purchase_orders.amount',
                            'dno_food_ventures_purchase_orders.total_price',
                            'dno_food_ventures_purchase_orders.requested_by',
                            'dno_food_ventures_purchase_orders.prepared_by',
                            'dno_food_ventures_purchase_orders.checked_by',
                            'dno_food_ventures_purchase_orders.created_by',
                            'dno_food_ventures_purchase_orders.deleted_at',
                            'dno_food_ventures_codes.dno_food_venture_code',
                            'dno_food_ventures_codes.module_id',
                            'dno_food_ventures_codes.module_code',
                            'dno_food_ventures_codes.module_name')
                        ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_purchase_orders.id', '=', 'dno_food_ventures_codes.module_id')
                        ->where('dno_food_ventures_purchase_orders.id',$id)
                        ->where('dno_food_ventures_codes.module_name', $moduleName)
                        ->get();


        $pOrders = DnoFoodVenturesPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = DnoFoodVenturesPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = DnoFoodVenturesPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;
 

        return view('view-dno-food-ventures-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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
        $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                    'dno_food_ventures_purchase_orders')
                    ->select(
                        'dno_food_ventures_purchase_orders.id',
                        'dno_food_ventures_purchase_orders.user_id',
                        'dno_food_ventures_purchase_orders.po_id',
                        'dno_food_ventures_purchase_orders.paid_to',
                        'dno_food_ventures_purchase_orders.address',
                        'dno_food_ventures_purchase_orders.date',
                        'dno_food_ventures_purchase_orders.quantity',
                        'dno_food_ventures_purchase_orders.total_kls',
                        'dno_food_ventures_purchase_orders.description',
                        'dno_food_ventures_purchase_orders.unit_price',
                        'dno_food_ventures_purchase_orders.amount',
                        'dno_food_ventures_purchase_orders.total_price',
                        'dno_food_ventures_purchase_orders.requested_by',
                        'dno_food_ventures_purchase_orders.prepared_by',
                        'dno_food_ventures_purchase_orders.checked_by',
                        'dno_food_ventures_purchase_orders.created_by',
                        'dno_food_ventures_purchase_orders.deleted_at',
                        'dno_food_ventures_codes.dno_food_venture_code',
                        'dno_food_ventures_codes.module_id',
                        'dno_food_ventures_codes.module_code',
                        'dno_food_ventures_codes.module_name')
                    ->leftJoin('dno_food_ventures_codes', 'dno_food_ventures_purchase_orders.id', '=', 'dno_food_ventures_codes.module_id')
                    ->where('dno_food_ventures_purchase_orders.id',$id)
                    ->where('dno_food_ventures_codes.module_name', $moduleName)
                    ->get();

        $pOrders = DnoFoodVenturesPurchaseOrder::where('po_id', $id)->get()->toArray();

        return view('edit-dno-food-ventures-purchase-order', compact('id', 'purchaseOrder', 'pOrders'));
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
        $pettyCash = DnoFoodVenturesPettyCash::find($id);
        $pettyCash->delete();
    }

    public function destroyBillingStatement($id){
        $billingStatement = DnoFoodVenturesBillingStatement::find($id);
        $billingStatement->delete();
    }

    public function destroyBillingDataStatement(Request $request, $id){
        $billStatement = DnoFoodVenturesBillingStatement::find($request->billingStatementId);

        $billingStatement = DnoFoodVenturesBillingStatement::find($id);

        $getAmount = $billStatement->total_amount - $billingStatement->amount;
        $billStatement->total_amount = $getAmount;
        $billStatement->save();

        $billingStatement->delete();
    }

    public function destroySalesInvoice($id){
        $salesInvoice = DnoFoodVenturesSalesInvoice::find($id);
        $salesInvoice->delete();
    }

    public function destroyDR($id){
        $deliveryReceipt = DnoFoodVenturesDeliveryReceipt::find($id);
        $deliveryReceipt->delete();
    }

    public function destroyDeliveryReceipt(Request $request, $id){
        $drId = DnoFoodVenturesDeliveryReceipt::find($request->drId);
      
        $deliveryReceipt = DnoFoodVenturesDeliveryReceipt::find($id);
        $getAmount = $drId->total_amount - $deliveryReceipt->amount; 

        $drId->total_amount = $getAmount; 
        $drId->save();

        $deliveryReceipt->delete();
    }


    public function destroyTransactionList($id){
        $transactionList = DnoFoodVenturesPaymentVoucher::find($id);
        $transactionList->delete();
    }

    public function destroyPO($id){
        $purchaseOrder = DnoFoodVenturesPurchaseOrder::find($id);
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
        $poId = DnoFoodVenturesPurchaseOrder::find($request->poId);

        $purchaseOrder = DnoFoodVenturesPurchaseOrder::find($id);
        $getAmount = $poId->total_price - $purchaseOrder->amount;

        $poId->total_price = $getAmount;
        $poId->save();

        $purchaseOrder->delete();


    }
}
