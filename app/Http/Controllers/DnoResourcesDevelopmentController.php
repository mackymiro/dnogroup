<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;
use Auth; 
use Session;
use App\User;
use App\DnoResourcesDevelopmentCorpPaymentVoucher;
use App\DnoResourcesDevelopmentCorpPurchaseOrder;
use App\DnoResourcesDevelopmentCorpDeliveryTransactionForm; 
use App\DnoResourcesDevelopmentCode;
use App\DnoResourcesDevelopmentCorpSupplier;
use App\DnoResourcesDevelopmentCorpPettyCash;
use App\DnoResourcesDevelopmentCorpBillingStatement;
use App\DnoResourcesDevelopmentCorpStatementOfAccount;

class DnoResourcesDevelopmentController extends Controller
{

    public function printSOALists(){
        $printSOAStatements = DnoResourcesDevelopmentCorpStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                ->where('billing_statement_id', NULL)
                                                                ->where('deleted_at', NULL)
                                                                ->orderBy('id', 'desc')
                                                                ->get();
        $status = "PAID";
        $moduleName = "Statement Of Account";
        $totalAmount = DB::table(
                        'dno_resources_development_corp_statement_of_accounts')
                        ->select(
                            'dno_resources_development_corp_statement_of_accounts.id',
                            'dno_resources_development_corp_statement_of_accounts.user_id',
                            'dno_resources_development_corp_statement_of_accounts.billing_statement_id',
                            'dno_resources_development_corp_statement_of_accounts.bill_to',
                            'dno_resources_development_corp_statement_of_accounts.address',
                            'dno_resources_development_corp_statement_of_accounts.date',
                            'dno_resources_development_corp_statement_of_accounts.period_cover',
                            'dno_resources_development_corp_statement_of_accounts.terms',
                            'dno_resources_development_corp_statement_of_accounts.date_of_transaction',
                            'dno_resources_development_corp_statement_of_accounts.description',
                            'dno_resources_development_corp_statement_of_accounts.amount',
                            'dno_resources_development_corp_statement_of_accounts.total_amount',
                            'dno_resources_development_corp_statement_of_accounts.paid_amount',
                            'dno_resources_development_corp_statement_of_accounts.payment_method',
                            'dno_resources_development_corp_statement_of_accounts.collection_date',
                            'dno_resources_development_corp_statement_of_accounts.check_number',
                            'dno_resources_development_corp_statement_of_accounts.check_amount',
                            'dno_resources_development_corp_statement_of_accounts.or_number',
                            'dno_resources_development_corp_statement_of_accounts.status',
                            'dno_resources_development_corp_statement_of_accounts.created_by',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                        ->join('dno_resources_development_codes', 'dno_resources_development_corp_statement_of_accounts.id', '=', 'dno_resources_development_codes.module_id')
                        ->where('dno_resources_development_corp_statement_of_accounts.billing_statement_id', NULL)
                        ->where('dno_resources_development_codes.module_name', $moduleName)
                        ->where('dno_resources_development_corp_statement_of_accounts.status', '=', $status)
                        ->sum('dno_resources_development_corp_statement_of_accounts.total_amount');


    $totalRemainingBalance = DB::table(
                            'dno_resources_development_corp_statement_of_accounts')
                            ->select(
                                'dno_resources_development_corp_statement_of_accounts.id',
                                'dno_resources_development_corp_statement_of_accounts.user_id',
                                'dno_resources_development_corp_statement_of_accounts.billing_statement_id',
                                'dno_resources_development_corp_statement_of_accounts.bill_to',
                                'dno_resources_development_corp_statement_of_accounts.address',
                                'dno_resources_development_corp_statement_of_accounts.date',
                                'dno_resources_development_corp_statement_of_accounts.period_cover',
                                'dno_resources_development_corp_statement_of_accounts.terms',
                                'dno_resources_development_corp_statement_of_accounts.date_of_transaction',
                                'dno_resources_development_corp_statement_of_accounts.description',
                                'dno_resources_development_corp_statement_of_accounts.amount',
                                'dno_resources_development_corp_statement_of_accounts.total_amount',
                                'dno_resources_development_corp_statement_of_accounts.total_remaining_balance',
                                'dno_resources_development_corp_statement_of_accounts.paid_amount',
                                'dno_resources_development_corp_statement_of_accounts.payment_method',
                                'dno_resources_development_corp_statement_of_accounts.collection_date',
                                'dno_resources_development_corp_statement_of_accounts.check_number',
                                'dno_resources_development_corp_statement_of_accounts.check_amount',
                                'dno_resources_development_corp_statement_of_accounts.or_number',
                                'dno_resources_development_corp_statement_of_accounts.status',
                                'dno_resources_development_corp_statement_of_accounts.created_by',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                            ->join('dno_resources_development_codes', 'dno_resources_development_corp_statement_of_accounts.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_statement_of_accounts.billing_statement_id', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->where('dno_resources_development_corp_statement_of_accounts.status', NULL)
                            ->sum('dno_resources_development_corp_statement_of_accounts.total_remaining_balance');

        $pdf = PDF::loadView('printSOAListsDnoResources', compact('printSOAStatements', 
        'totalAmount', 'totalRemainingBalance'));

        return $pdf->download('dno-resources-development-corp-statement-of-account-list.pdf');

    }

    public function printSOA($id){  
        
        $soa = DnoResourcesDevelopmentCorpStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                ->where('billing_statement_id', NULL)
                                                                ->orderBy('id', 'desc')
                                                                ->get();                                                   
                                                                
        $statementAccounts = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->get()->toArray();
        
        $moduleName = "Statement Of Account";
        $countTotalAmount =  DB::table(
                            'dno_resources_development_corp_statement_of_accounts')
                            ->select(
                                'dno_resources_development_corp_statement_of_accounts.id',
                                'dno_resources_development_corp_statement_of_accounts.user_id',
                                'dno_resources_development_corp_statement_of_accounts.billing_statement_id',
                                'dno_resources_development_corp_statement_of_accounts.bill_to',
                                'dno_resources_development_corp_statement_of_accounts.address',
                                'dno_resources_development_corp_statement_of_accounts.date',
                                'dno_resources_development_corp_statement_of_accounts.period_cover',
                                'dno_resources_development_corp_statement_of_accounts.terms',
                                'dno_resources_development_corp_statement_of_accounts.date_of_transaction',
                                'dno_resources_development_corp_statement_of_accounts.description',
                                'dno_resources_development_corp_statement_of_accounts.amount',
                                'dno_resources_development_corp_statement_of_accounts.paid_amount',
                                'dno_resources_development_corp_statement_of_accounts.payment_method',
                                'dno_resources_development_corp_statement_of_accounts.collection_date',
                                'dno_resources_development_corp_statement_of_accounts.check_number',
                                'dno_resources_development_corp_statement_of_accounts.check_amount',
                                'dno_resources_development_corp_statement_of_accounts.or_number',
                                'dno_resources_development_corp_statement_of_accounts.status',
                                'dno_resources_development_corp_statement_of_accounts.created_by',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                            ->join('dno_resources_development_codes', 'dno_resources_development_corp_statement_of_accounts.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_statement_of_accounts.id', $id)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->sum('dno_resources_development_corp_statement_of_accounts.amount');
                
        $countAmount = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        //
         $countAmount = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');


         $sum  = $countTotalAmount + $countAmount;

         $pdf = PDF::loadView('printSOADnoResourcesDevelopment', compact('soa', 'statementAccounts', 'sum'));

         return $pdf->download('dno-resources-development-corp-statement-of-account.pdf');
    }

    public function viewStatementAccount($id){
        $viewStatementAccount = DnoResourcesDevelopmentCorpStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                ->where('id', $id)
                                                                ->get();

        $statementAccounts = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->get();

        //count the total amount 
        $countTotalAmount = DnoResourcesDevelopmentCorpStatementOfAccount::where('id', $id)->sum('amount');

        //
        $countAmount = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        //count the total balance if there are paid amount
        $paidAmountCount = DnoResourcesDevelopmentCorpStatementOfAccount::where('id', $id)->sum('paid_amount');

        //
        $countAmountOthersPaid = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');

        $compute  = $paidAmountCount + $countAmountOthersPaid;


        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('view-dno-resources-development-corp-statement-account', compact('viewStatementAccount', 'statementAccounts', 'sum', 'computeAll'));

    }

    public function sAccountUpdate(Request $request, $id){  
          //get the main Id 
          $mainIdSoa = DnoResourcesDevelopmentCorpStatementOfAccount::find($request->mainId);

          $compute = $mainIdSoa->total_remaining_balance - $request->paidAmount;
          
          $mainIdSoa->total_remaining_balance = $compute; 
          $mainIdSoa->save();
  
          $statementAccountPaid = DnoResourcesDevelopmentCorpStatementOfAccount::find($request->id);
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
        $getStatementOfAccount = DnoResourcesDevelopmentCorpStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('id', $id)
                                                                    ->get();
        //AllAcounts not yet paid
        $allAccounts = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->where('status', NULL)->get()->toArray();

        $stat = "PAID";
        $allAccountsPaids = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->where('status', $stat)->get()->toArray();  

        //count the total amount 
        $countTotalAmount = DnoResourcesDevelopmentCorpStatementOfAccount::where('id', $id)->sum('amount');

        //
        $countAmount = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        //count the total balance if there are paid amount
        $paidAmountCount = DnoResourcesDevelopmentCorpStatementOfAccount::where('id', $id)->sum('paid_amount');

        //
        $countAmountOthersPaid = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');

        $compute  = $paidAmountCount + $countAmountOthersPaid;

        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('edit-dno-resources-development-corp-statement-of-account', compact('id', 'getStatementOfAccount', 'computeAll', 'allAccounts', 'allAccountsPaids', 'sum'));

    }

    public function statementOfAccountLists(){
        $statementOfAccounts = DnoResourcesDevelopmentCorpStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                ->where('billing_statement_id', NULL)
                                                                ->where('deleted_at', NULL)
                                                                ->orderBy('id', 'desc')
                                                                ->get();

        $status = "PAID";
        $moduleName = "Statement Of Account";
        $totalAmount = DB::table(
                        'dno_resources_development_corp_statement_of_accounts')
                        ->select(
                            'dno_resources_development_corp_statement_of_accounts.id',
                            'dno_resources_development_corp_statement_of_accounts.user_id',
                            'dno_resources_development_corp_statement_of_accounts.billing_statement_id',
                            'dno_resources_development_corp_statement_of_accounts.bill_to',
                            'dno_resources_development_corp_statement_of_accounts.address',
                            'dno_resources_development_corp_statement_of_accounts.date',
                            'dno_resources_development_corp_statement_of_accounts.period_cover',
                            'dno_resources_development_corp_statement_of_accounts.terms',
                            'dno_resources_development_corp_statement_of_accounts.date_of_transaction',
                            'dno_resources_development_corp_statement_of_accounts.description',
                            'dno_resources_development_corp_statement_of_accounts.amount',
                            'dno_resources_development_corp_statement_of_accounts.total_amount',
                            'dno_resources_development_corp_statement_of_accounts.paid_amount',
                            'dno_resources_development_corp_statement_of_accounts.payment_method',
                            'dno_resources_development_corp_statement_of_accounts.collection_date',
                            'dno_resources_development_corp_statement_of_accounts.check_number',
                            'dno_resources_development_corp_statement_of_accounts.check_amount',
                            'dno_resources_development_corp_statement_of_accounts.or_number',
                            'dno_resources_development_corp_statement_of_accounts.status',
                            'dno_resources_development_corp_statement_of_accounts.created_by',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                        ->join('dno_resources_development_codes', 'dno_resources_development_corp_statement_of_accounts.id', '=', 'dno_resources_development_codes.module_id')
                        ->where('dno_resources_development_corp_statement_of_accounts.billing_statement_id', NULL)
                        ->where('dno_resources_development_codes.module_name', $moduleName)
                        ->where('dno_resources_development_corp_statement_of_accounts.status', '=', $status)
                        ->sum('dno_resources_development_corp_statement_of_accounts.total_amount');

                                                        
            $totalRemainingBalance = DB::table(
                                    'dno_resources_development_corp_statement_of_accounts')
                                    ->select(
                                        'dno_resources_development_corp_statement_of_accounts.id',
                                        'dno_resources_development_corp_statement_of_accounts.user_id',
                                        'dno_resources_development_corp_statement_of_accounts.billing_statement_id',
                                        'dno_resources_development_corp_statement_of_accounts.bill_to',
                                        'dno_resources_development_corp_statement_of_accounts.address',
                                        'dno_resources_development_corp_statement_of_accounts.date',
                                        'dno_resources_development_corp_statement_of_accounts.period_cover',
                                        'dno_resources_development_corp_statement_of_accounts.terms',
                                        'dno_resources_development_corp_statement_of_accounts.date_of_transaction',
                                        'dno_resources_development_corp_statement_of_accounts.description',
                                        'dno_resources_development_corp_statement_of_accounts.amount',
                                        'dno_resources_development_corp_statement_of_accounts.total_amount',
                                        'dno_resources_development_corp_statement_of_accounts.total_remaining_balance',
                                        'dno_resources_development_corp_statement_of_accounts.paid_amount',
                                        'dno_resources_development_corp_statement_of_accounts.payment_method',
                                        'dno_resources_development_corp_statement_of_accounts.collection_date',
                                        'dno_resources_development_corp_statement_of_accounts.check_number',
                                        'dno_resources_development_corp_statement_of_accounts.check_amount',
                                        'dno_resources_development_corp_statement_of_accounts.or_number',
                                        'dno_resources_development_corp_statement_of_accounts.status',
                                        'dno_resources_development_corp_statement_of_accounts.created_by',
                                        'dno_resources_development_codes.dno_resources_code',
                                        'dno_resources_development_codes.module_id',
                                        'dno_resources_development_codes.module_code',
                                        'dno_resources_development_codes.module_name')
                                    ->join('dno_resources_development_codes', 'dno_resources_development_corp_statement_of_accounts.id', '=', 'dno_resources_development_codes.module_id')
                                    ->where('dno_resources_development_corp_statement_of_accounts.billing_statement_id', NULL)
                                    ->where('dno_resources_development_codes.module_name', $moduleName)
                                    ->where('dno_resources_development_corp_statement_of_accounts.status', NULL)
                                    ->sum('dno_resources_development_corp_statement_of_accounts.total_remaining_balance');
                                                        

        
        return view('dno-resources-development-corp-statement-of-account-lists', compact('statementOfAccounts', 
        'totalAmount', 'totalRemainingBalance'));
    }

    public function printBillingStatement($id){
        $printBillingStatement = DnoResourcesDevelopmentCorpBillingStatement::with(['user', 'billing_statements'])
                                                                    ->where('id', $id)
                                                                    ->get();

        $billingStatements = DnoResourcesDevelopmentCorpBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoResourcesDevelopmentCorpBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = DnoResourcesDevelopmentCorpBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printBillingStatementDnoResourcesDevelopment', compact('printBillingStatement', 'billingStatements', 'sum'));

        return $pdf->download('dno-resources-development-corp-billing-statement.pdf'); 
    }

    public function viewBillingStatement($id){
        $viewBillingStatement = DnoResourcesDevelopmentCorpBillingStatement::with(['user', 'billing_statements'])
                                                                ->where('id', $id)
                                                                ->get();


        $billingStatements = DnoResourcesDevelopmentCorpBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoResourcesDevelopmentCorpBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = DnoResourcesDevelopmentCorpBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-dno-resources-development-corp-billing-statement', compact('viewBillingStatement', 'billingStatements', 'sum'));

    }

    public function billingStatementList(){

        $billingStatements = DnoResourcesDevelopmentCorpBillingStatement::with(['user', 'billing_statements'])
                                                                ->where('billing_statement_id', NULL)
                                                                ->where('deleted_at', NULL)
                                                                ->orderBy('id', 'desc')
                                                                ->get();
        return view('dno-resources-development-corp-billing-statement-lists', compact('billingStatements'));
    }

    public function addNewBilling(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = DnoResourcesDevelopmentCorpBillingStatement::find($id);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $amount = $request->get('amount');

        $tot = $billingOrder->total_amount + $amount; 

        $addBillingStatement = new DnoResourcesDevelopmentCorpBillingStatement([
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

        $addStatementAccount = new DnoResourcesDevelopmentCorpStatementOfAccount([
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
        $statementOrder = DnoResourcesDevelopmentCorpStatementOfAccount::find($id);  

        $billingOrder->total_amount = $tot;
        $billingOrder->save();

       //update soa table
       $statementOrder->total_amount  = $tot;
       $statementOrder->total_remaining_balance = $tot;
       $statementOrder->save();

       Session::flash('SuccessAdd', 'Successfully added.');

       return redirect()->route('editBillingStatementDnoResourcesDevelopment', ['id'=>$id]);

    }

    public function updateBillingInfo(Request $request, $id){
        $updateBillingOrder = DnoResourcesDevelopmentCorpBillingStatement::find($id);

        $getOtherBilling = DnoResourcesDevelopmentCorpBillingStatement::where('billing_statement_id', $id)->get();
       
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
        $getMainStatement = DnoResourcesDevelopmentCorpStatementOfAccount::find($id);

        $getStatement = DnoResourcesDevelopmentCorpStatementOfAccount::where('billing_statement_id', $id)->get();

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

        return redirect()->route('editBillingStatementDnoResourcesDevelopment', ['id'=>$id]);
    }

    public function editBillingStatement($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $billingStatement = DnoResourcesDevelopmentCorpBillingStatement::find($id);
       
        $bStatements = DnoResourcesDevelopmentCorpBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        return view('edit-dno-resources-development-corp-billing-statement-form', compact('billingStatement', 'bStatements'));
    }

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
            'periodCovered'=>'required',
            'date'=>'required',
            'terms'=>'required',
            'transactionDate'=>'required',
        ]);

         //get the latest insert id query in table billing statements ref number
         $dataReferenceNum = DB::select('SELECT id, dno_resources_code FROM dno_resources_development_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 reference number
         if(isset($dataReferenceNum[0]->dno_resources_code) != 0){
             //if code is not 0
             $newRefNum = $dataReferenceNum[0]->dno_resources_code +1;
             $uRef = sprintf("%06d",$newRefNum);   
 
         }else{
             //if code is 0 
             $newRefNum = 1;
             $uRef = sprintf("%06d",$newRefNum);
         } 

         $target = DB::table(
            'dno_resources_development_corp_billing_statements')
            ->where('dr_no', $request->get('dr_no'))
            ->get()->first();

        if($target === NULL){
            $billingStatement = new DnoResourcesDevelopmentCorpBillingStatement([
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

            $dnoResources = new DnoResourcesDevelopmentCode([
                'user_id'=>$user->id,
                'dno_resources_code'=>$uRef,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
    
            ]);
    
            $dnoResources->save();
            $bsNo = $dnoResources->id;

            $bsNoId = DnoResourcesDevelopmentCode::find($bsNo);

            $statementAccount = new DnoResourcesDevelopmentCorpStatementOfAccount([
                'user_id'=>$user->id,
                'bs_no'=>$bsNoId->dno_resources_code,
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
            
            $statement = new DnoResourcesDevelopmentCode([
                'user_id'=>$user->id,
                'dno_resources_code'=>$uRefState,
                'module_id'=>$insertedIdStatement,
                'module_code'=>$moduleCodeSOA,
                'module_name'=>$moduleNameSOA,
    
            ]);
            $statement->save();

            return redirect()->route('editBillingStatementDnoResourcesDevelopment', ['id'=>$insertedId]);


        }else{
            return redirect()->route('billingStatementFormDnoResourcesDevelopment')->with('error', 'DR Number Already Exists. Please See Transaction List For Your Reference');
        }    
        


    }

    public function billingStatementForm(){
        return view('dno-resources-development-corp-billing-statement-form');
    }

    public function printPettyCash($id){
        $getPettyCash =  DnoResourcesDevelopmentCorpPettyCash::with(['user', 'petty_cashes'])
                                                    ->where('id', $id)
                                                    ->get();

        $getPettyCashSummaries = DnoResourcesDevelopmentCorpPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = DnoResourcesDevelopmentCorpPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = DnoResourcesDevelopmentCorpPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashDnoResourcesDevelopment', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));

        return $pdf->download('dno-resources-development-corp-petty-cash.pdf');
    }

    public function viewPettyCash($id){
        $getPettyCash =  DnoResourcesDevelopmentCorpPettyCash::with(['user', 'petty_cashes'])
                                                        ->where('id', $id)
                                                        ->get();

        $getPettyCashSummaries = DnoResourcesDevelopmentCorpPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = DnoResourcesDevelopmentCorpPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = DnoResourcesDevelopmentCorpPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;


        return view('dno-resources-development-corp-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
    }

    public function updatePC(Request $request, $id){
        $updatePC = DnoResourcesDevelopmentCorpPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashDnoResourcesDevelopment', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        
        $addNew = new DnoResourcesDevelopmentCorpPettyCash([
            'user_id'=>$user->id,
            'pc_id'=>$id,
            'date'=>$request->get('date'),
            'petty_cash_summary'=>$request->get('pettyCashSummary'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNew->save();

        Session::flash('addNewSuccess', 'Successfully added.');

        return redirect()->route('editPettyCashDnoResourcesDevelopment', ['id'=>$id]);
    }

    public function updatePettyCash(Request $request, $id){
        $update = DnoResourcesDevelopmentCorpPettyCash::find($id);
        $update->date = $request->get('date');
        $update->petty_cash_name = $request->get('pettyCashName');
        $update->petty_cash_summary = $request->get('pettyCashSummary');
        $update->amount = $request->get('amount');

        $update->save();
        Session::flash('editSuccess', 'Successfully updated.'); 

        return redirect()->route('editPettyCashDnoResourcesDevelopment', ['id'=>$id]);
    }

    public function editPettyCash($id){
        $pettyCash =  DnoResourcesDevelopmentCorpPettyCash::with(['user', 'petty_cashes'])
                                                ->where('id', $id)
                                                ->get();

        $pettyCashSummaries = DnoResourcesDevelopmentCorpPettyCash::where('pc_id', $id)->get()->toArray();

        return view('edit-dno-resources-development-corp-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }

    public function addPettyCash(Request $request){     
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table dno personal codes
         $dataCashNo = DB::select('SELECT id, dno_resources_code FROM dno_resources_development_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
         if(isset($dataCashNo[0]->dno_resources_code) != 0){
             //if code is not 0
             $newProd = $dataCashNo[0]->dno_resources_code +1;
             $uPetty = sprintf("%06d",$newProd);   
 
         }else{
             //if code is 0 
             $newProd = 1;
             $uPetty = sprintf("%06d",$newProd);
         } 

         $addPettyCash = new DnoResourcesDevelopmentCorpPettyCash([
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

        $dnoResources = new DnoResourcesDevelopmentCode([
            'user_id'=>$user->id,
            'dno_resources_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $dnoResources->save();
      
        return response()->json($insertId);


    }

    public function pettyCashList(){
        $pettyCashLists =  DnoResourcesDevelopmentCorpPettyCash::with(['user', 'petty_cashes'])
                                                        ->where('pc_id', NULL)
                                                        ->where('deleted_at', NULL)
                                                        ->orderBy('id', 'desc')
                                                        ->get();
        return view('dno-resources-development-corp-petty-cash-list', compact('pettyCashLists'));
    }

    public function printPO($id){
        $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                            'dno_resources_development_corp_purchase_orders')
                            ->select( 
                            'dno_resources_development_corp_purchase_orders.id',
                            'dno_resources_development_corp_purchase_orders.user_id',
                            'dno_resources_development_corp_purchase_orders.po_id',
                            'dno_resources_development_corp_purchase_orders.paid_to',
                            'dno_resources_development_corp_purchase_orders.address',
                            'dno_resources_development_corp_purchase_orders.date',
                            'dno_resources_development_corp_purchase_orders.quantity',
                            'dno_resources_development_corp_purchase_orders.description',
                            'dno_resources_development_corp_purchase_orders.unit',
                            'dno_resources_development_corp_purchase_orders.unit_price',
                            'dno_resources_development_corp_purchase_orders.amount',
                            'dno_resources_development_corp_purchase_orders.total_price',
                            'dno_resources_development_corp_purchase_orders.prepared_by',
                            'dno_resources_development_corp_purchase_orders.checked_by',
                            'dno_resources_development_corp_purchase_orders.ordered_by',
                            'dno_resources_development_corp_purchase_orders.particulars',
                            'dno_resources_development_corp_purchase_orders.qty',
                            'dno_resources_development_corp_purchase_orders.created_by',
                            'dno_resources_development_corp_purchase_orders.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_purchase_orders.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_purchase_orders.id', $id)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->get()->toArray();
        
        $pOrders = DnoResourcesDevelopmentCorpPurchaseOrder::where('po_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoResourcesDevelopmentCorpPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = DnoResourcesDevelopmentCorpPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printDnoResourcesPO', compact('purchaseOrder', 'pOrders', 'sum'));

        return $pdf->download('dno-resources-development-corp-purchase-order.pdf');

    }

    public function printSupplier($id){
        $viewSupplier = DnoResourcesDevelopmentCorpSupplier::where('id', $id)->get();
        
        $printSuppliers = DB::table(
            'dno_resources_development_corp_payment_vouchers')
            ->select( 
            'dno_resources_development_corp_payment_vouchers.id',
            'dno_resources_development_corp_payment_vouchers.user_id',
            'dno_resources_development_corp_payment_vouchers.pv_id',
            'dno_resources_development_corp_payment_vouchers.date',
            'dno_resources_development_corp_payment_vouchers.paid_to',
            'dno_resources_development_corp_payment_vouchers.account_no',
            'dno_resources_development_corp_payment_vouchers.account_name',
            'dno_resources_development_corp_payment_vouchers.particulars',
            'dno_resources_development_corp_payment_vouchers.amount',
            'dno_resources_development_corp_payment_vouchers.method_of_payment',
            'dno_resources_development_corp_payment_vouchers.prepared_by',
            'dno_resources_development_corp_payment_vouchers.approved_by',
            'dno_resources_development_corp_payment_vouchers.date_apprroved',
            'dno_resources_development_corp_payment_vouchers.received_by_date',
            'dno_resources_development_corp_payment_vouchers.created_by',
            'dno_resources_development_corp_payment_vouchers.created_at',
            'dno_resources_development_corp_payment_vouchers.invoice_number',
            'dno_resources_development_corp_payment_vouchers.issued_date',
            'dno_resources_development_corp_payment_vouchers.category',
            'dno_resources_development_corp_payment_vouchers.amount_due',
            'dno_resources_development_corp_payment_vouchers.delivered_date',
            'dno_resources_development_corp_payment_vouchers.status',
            'dno_resources_development_corp_payment_vouchers.cheque_number',
            'dno_resources_development_corp_payment_vouchers.cheque_amount',
            'dno_resources_development_corp_payment_vouchers.sub_category',
            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
            'dno_resources_development_corp_payment_vouchers.supplier_name',
            'dno_resources_development_corp_payment_vouchers.deleted_at',
            'dno_resources_development_corp_suppliers.id',
            'dno_resources_development_corp_suppliers.date',
            'dno_resources_development_corp_suppliers.supplier_name')
            ->leftJoin('dno_resources_development_corp_suppliers', 'dno_resources_development_corp_payment_vouchers.supplier_id', '=', 'dno_resources_development_corp_suppliers.id')
            ->where('dno_resources_development_corp_suppliers.id', $id)
            ->get();

    $status = "FULLY PAID AND RELEASED";    
    $totalAmountDue = DB::table(
                'dno_resources_development_corp_payment_vouchers')
                ->select( 
                'dno_resources_development_corp_payment_vouchers.id',
                'dno_resources_development_corp_payment_vouchers.user_id',
                'dno_resources_development_corp_payment_vouchers.pv_id',
                'dno_resources_development_corp_payment_vouchers.date',
                'dno_resources_development_corp_payment_vouchers.paid_to',
                'dno_resources_development_corp_payment_vouchers.account_no',
                'dno_resources_development_corp_payment_vouchers.account_name',
                'dno_resources_development_corp_payment_vouchers.particulars',
                'dno_resources_development_corp_payment_vouchers.amount',
                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                'dno_resources_development_corp_payment_vouchers.prepared_by',
                'dno_resources_development_corp_payment_vouchers.approved_by',
                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                'dno_resources_development_corp_payment_vouchers.received_by_date',
                'dno_resources_development_corp_payment_vouchers.created_by',
                'dno_resources_development_corp_payment_vouchers.created_at',
                'dno_resources_development_corp_payment_vouchers.invoice_number',
                'dno_resources_development_corp_payment_vouchers.issued_date',
                'dno_resources_development_corp_payment_vouchers.category',
                'dno_resources_development_corp_payment_vouchers.amount_due',
                'dno_resources_development_corp_payment_vouchers.delivered_date',
                'dno_resources_development_corp_payment_vouchers.status',
                'dno_resources_development_corp_payment_vouchers.cheque_number',
                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                'dno_resources_development_corp_payment_vouchers.sub_category',
                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                'dno_resources_development_corp_payment_vouchers.supplier_name',
                'dno_resources_development_corp_payment_vouchers.deleted_at',
                'dno_resources_development_corp_suppliers.id',
                'dno_resources_development_corp_suppliers.date',
                'dno_resources_development_corp_suppliers.supplier_name')
                ->leftJoin('dno_resources_development_corp_suppliers', 'dno_resources_development_corp_payment_vouchers.supplier_id', '=', 'dno_resources_development_corp_suppliers.id')
                ->where('dno_resources_development_corp_suppliers.id', $id)
                ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSupplierDnoResources', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('dno-resources-development-supplier.pdf');

    }

    public function viewSupplier($id){
        $viewSupplier = DnoResourcesDevelopmentCorpSupplier::where('id', $id)->get();

        $supplierLists = DB::table(
                        'dno_resources_development_corp_payment_vouchers')
                        ->select( 
                        'dno_resources_development_corp_payment_vouchers.id',
                        'dno_resources_development_corp_payment_vouchers.user_id',
                        'dno_resources_development_corp_payment_vouchers.pv_id',
                        'dno_resources_development_corp_payment_vouchers.date',
                        'dno_resources_development_corp_payment_vouchers.paid_to',
                        'dno_resources_development_corp_payment_vouchers.account_no',
                        'dno_resources_development_corp_payment_vouchers.account_name',
                        'dno_resources_development_corp_payment_vouchers.particulars',
                        'dno_resources_development_corp_payment_vouchers.amount',
                        'dno_resources_development_corp_payment_vouchers.method_of_payment',
                        'dno_resources_development_corp_payment_vouchers.prepared_by',
                        'dno_resources_development_corp_payment_vouchers.approved_by',
                        'dno_resources_development_corp_payment_vouchers.date_apprroved',
                        'dno_resources_development_corp_payment_vouchers.received_by_date',
                        'dno_resources_development_corp_payment_vouchers.created_by',
                        'dno_resources_development_corp_payment_vouchers.created_at',
                        'dno_resources_development_corp_payment_vouchers.invoice_number',
                        'dno_resources_development_corp_payment_vouchers.issued_date',
                        'dno_resources_development_corp_payment_vouchers.category',
                        'dno_resources_development_corp_payment_vouchers.amount_due',
                        'dno_resources_development_corp_payment_vouchers.delivered_date',
                        'dno_resources_development_corp_payment_vouchers.status',
                        'dno_resources_development_corp_payment_vouchers.cheque_number',
                        'dno_resources_development_corp_payment_vouchers.cheque_amount',
                        'dno_resources_development_corp_payment_vouchers.sub_category',
                        'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                        'dno_resources_development_corp_payment_vouchers.supplier_name',
                        'dno_resources_development_corp_payment_vouchers.deleted_at',
                        'dno_resources_development_corp_suppliers.date',
                        'dno_resources_development_corp_suppliers.supplier_name')
                        ->leftJoin('dno_resources_development_corp_suppliers', 'dno_resources_development_corp_payment_vouchers.supplier_id', '=', 'dno_resources_development_corp_suppliers.id')
                        ->where('dno_resources_development_corp_suppliers.id', $id)
                        ->get();

    $status = "FULLY PAID AND RELEASED";    
    $totalAmountDue = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.supplier_name',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_corp_suppliers.id',
                            'dno_resources_development_corp_suppliers.date',
                            'dno_resources_development_corp_suppliers.supplier_name')
                            ->leftJoin('dno_resources_development_corp_suppliers', 'dno_resources_development_corp_payment_vouchers.supplier_id', '=', 'dno_resources_development_corp_suppliers.id')
                            ->where('dno_resources_development_corp_suppliers.id', $id)
                            ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                            ->sum('dno_resources_development_corp_payment_vouchers.amount_due');

        return view('view-dno-resources-development-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue')); 


    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //check if supplier name exits
          $target = DB::table(
                'dno_resources_development_corp_suppliers')
                ->where('supplier_name', $request->supplierName)
                ->get()->first();
        
        if($target === NULL){
            $supplier = new DnoResourcesDevelopmentCorpSupplier([
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
        $suppliers = DnoResourcesDevelopmentCorpSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('dno-resources-development-supplier',  compact('suppliers'));
    }

    public function updateDetails(Request $request){
        $updateDetail = DnoResourcesDevelopmentCorpPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = DnoResourcesDevelopmentCorpPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = DnoResourcesDevelopmentCorpPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
          //main id 
          $updateParticular = DnoResourcesDevelopmentCorpPaymentVoucher::find($request->transId);

          //particular id
          $uIdParticular = DnoResourcesDevelopmentCorpPaymentVoucher::find($request->id);
 
          $amount = $request->amount; 
 
          $updateAmount =  $updateParticular->amount; 
         
          $uParticular = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
          
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
        $updateParticular =  DnoResourcesDevelopmentCorpPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
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
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                            ->get();
        
        $totalAmountCashes = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.currency',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                            ->get();
        
        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";    
        $totalAmountCheck = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.currency',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                ->where('dno_resources_development_corp_payment_vouchers.currency', '!=', $currency)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
                            
        $totalPaidAmountCheck = DB::table(
                                    'dno_resources_development_corp_payment_vouchers')
                                    ->select( 
                                    'dno_resources_development_corp_payment_vouchers.id',
                                    'dno_resources_development_corp_payment_vouchers.user_id',
                                    'dno_resources_development_corp_payment_vouchers.pv_id',
                                    'dno_resources_development_corp_payment_vouchers.date',
                                    'dno_resources_development_corp_payment_vouchers.paid_to',
                                    'dno_resources_development_corp_payment_vouchers.account_no',
                                    'dno_resources_development_corp_payment_vouchers.account_name',
                                    'dno_resources_development_corp_payment_vouchers.particulars',
                                    'dno_resources_development_corp_payment_vouchers.amount',
                                    'dno_resources_development_corp_payment_vouchers.currency',
                                    'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                    'dno_resources_development_corp_payment_vouchers.prepared_by',
                                    'dno_resources_development_corp_payment_vouchers.approved_by',
                                    'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                    'dno_resources_development_corp_payment_vouchers.received_by_date',
                                    'dno_resources_development_corp_payment_vouchers.created_by',
                                    'dno_resources_development_corp_payment_vouchers.created_at',
                                    'dno_resources_development_corp_payment_vouchers.invoice_number',
                                    'dno_resources_development_corp_payment_vouchers.issued_date',
                                    'dno_resources_development_corp_payment_vouchers.category',
                                    'dno_resources_development_corp_payment_vouchers.amount_due',
                                    'dno_resources_development_corp_payment_vouchers.delivered_date',
                                    'dno_resources_development_corp_payment_vouchers.status',
                                    'dno_resources_development_corp_payment_vouchers.cheque_number',
                                    'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                    'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                                    'dno_resources_development_corp_payment_vouchers.sub_category',
                                    'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                    'dno_resources_development_corp_payment_vouchers.deleted_at',
                                    'dno_resources_development_codes.dno_resources_code',
                                    'dno_resources_development_codes.module_id',
                                    'dno_resources_development_codes.module_code',
                                    'dno_resources_development_codes.module_name')
                                    ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                    ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                    ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_resources_development_codes.module_name', $moduleName)
                                    ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$uri0, $uri1])
                                    ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_resources_development_corp_payment_vouchers.status', $status)
                                    ->where('dno_resources_development_corp_payment_vouchers.currency', '!=', $currency)
                                    ->sum('dno_resources_development_corp_payment_vouchers.cheque_total_amount');

        $totalAmountCheckInUSD = DB::table(
                                        'dno_resources_development_corp_payment_vouchers')
                                        ->select( 
                                        'dno_resources_development_corp_payment_vouchers.id',
                                        'dno_resources_development_corp_payment_vouchers.user_id',
                                        'dno_resources_development_corp_payment_vouchers.pv_id',
                                        'dno_resources_development_corp_payment_vouchers.date',
                                        'dno_resources_development_corp_payment_vouchers.paid_to',
                                        'dno_resources_development_corp_payment_vouchers.account_no',
                                        'dno_resources_development_corp_payment_vouchers.account_name',
                                        'dno_resources_development_corp_payment_vouchers.particulars',
                                        'dno_resources_development_corp_payment_vouchers.amount',
                                        'dno_resources_development_corp_payment_vouchers.currency',
                                        'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                        'dno_resources_development_corp_payment_vouchers.prepared_by',
                                        'dno_resources_development_corp_payment_vouchers.approved_by',
                                        'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                        'dno_resources_development_corp_payment_vouchers.received_by_date',
                                        'dno_resources_development_corp_payment_vouchers.created_by',
                                        'dno_resources_development_corp_payment_vouchers.created_at',
                                        'dno_resources_development_corp_payment_vouchers.invoice_number',
                                        'dno_resources_development_corp_payment_vouchers.issued_date',
                                        'dno_resources_development_corp_payment_vouchers.category',
                                        'dno_resources_development_corp_payment_vouchers.amount_due',
                                        'dno_resources_development_corp_payment_vouchers.delivered_date',
                                        'dno_resources_development_corp_payment_vouchers.status',
                                        'dno_resources_development_corp_payment_vouchers.cheque_number',
                                        'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                        'dno_resources_development_corp_payment_vouchers.sub_category',
                                        'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                        'dno_resources_development_corp_payment_vouchers.deleted_at',
                                        'dno_resources_development_codes.dno_resources_code',
                                        'dno_resources_development_codes.module_id',
                                        'dno_resources_development_codes.module_code',
                                        'dno_resources_development_codes.module_name')
                                        ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                        ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                        ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                        ->where('dno_resources_development_codes.module_name', $moduleName)
                                        ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$uri0, $uri1])
                                        ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                        ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                        ->where('dno_resources_development_corp_payment_vouchers.currency', $currency)
                                        ->sum('dno_resources_development_corp_payment_vouchers.amount_due');

        $totalPaidAmountCheckInUSD = DB::table(
                                            'dno_resources_development_corp_payment_vouchers')
                                            ->select( 
                                            'dno_resources_development_corp_payment_vouchers.id',
                                            'dno_resources_development_corp_payment_vouchers.user_id',
                                            'dno_resources_development_corp_payment_vouchers.pv_id',
                                            'dno_resources_development_corp_payment_vouchers.date',
                                            'dno_resources_development_corp_payment_vouchers.paid_to',
                                            'dno_resources_development_corp_payment_vouchers.account_no',
                                            'dno_resources_development_corp_payment_vouchers.account_name',
                                            'dno_resources_development_corp_payment_vouchers.particulars',
                                            'dno_resources_development_corp_payment_vouchers.amount',
                                            'dno_resources_development_corp_payment_vouchers.currency',
                                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                                            'dno_resources_development_corp_payment_vouchers.approved_by',
                                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                                            'dno_resources_development_corp_payment_vouchers.created_by',
                                            'dno_resources_development_corp_payment_vouchers.created_at',
                                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                                            'dno_resources_development_corp_payment_vouchers.issued_date',
                                            'dno_resources_development_corp_payment_vouchers.category',
                                            'dno_resources_development_corp_payment_vouchers.amount_due',
                                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                                            'dno_resources_development_corp_payment_vouchers.status',
                                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                            'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                                            'dno_resources_development_corp_payment_vouchers.sub_category',
                                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                                            'dno_resources_development_codes.dno_resources_code',
                                            'dno_resources_development_codes.module_id',
                                            'dno_resources_development_codes.module_code',
                                            'dno_resources_development_codes.module_name')
                                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                            ->where('dno_resources_development_codes.module_name', $moduleName)
                                            ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$uri0, $uri1])
                                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                            ->where('dno_resources_development_corp_payment_vouchers.status', $status)
                                            ->where('dno_resources_development_corp_payment_vouchers.currency', $currency)
                                            ->sum('dno_resources_development_corp_payment_vouchers.cheque_total_amount');
                                    

        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryDnoResoures',  compact('date', 'getDateToday', 'uri0', 'uri1',
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck', 'totalAmountCheckInUSD', 'totalPaidAmountCheckInUSD'));
        
        return $pdf->download('dno-resources-summary-report.pdf');

    }

    public function getSummaryReportMultiple(Request $request){ 
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$startDate, $endDate])
                            ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                            ->get()->toArray();
        
        $totalAmountCashes = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$startDate, $endDate])
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.currency',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                            ->get();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.currency',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$startDate, $endDate])
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                ->where('dno_resources_development_corp_payment_vouchers.currency', '!=', $currency)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');


        $totalAmountCheckInUSD = DB::table(
                                    'dno_resources_development_corp_payment_vouchers')
                                    ->select( 
                                    'dno_resources_development_corp_payment_vouchers.id',
                                    'dno_resources_development_corp_payment_vouchers.user_id',
                                    'dno_resources_development_corp_payment_vouchers.pv_id',
                                    'dno_resources_development_corp_payment_vouchers.date',
                                    'dno_resources_development_corp_payment_vouchers.paid_to',
                                    'dno_resources_development_corp_payment_vouchers.account_no',
                                    'dno_resources_development_corp_payment_vouchers.account_name',
                                    'dno_resources_development_corp_payment_vouchers.particulars',
                                    'dno_resources_development_corp_payment_vouchers.amount',
                                    'dno_resources_development_corp_payment_vouchers.currency',
                                    'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                    'dno_resources_development_corp_payment_vouchers.prepared_by',
                                    'dno_resources_development_corp_payment_vouchers.approved_by',
                                    'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                    'dno_resources_development_corp_payment_vouchers.received_by_date',
                                    'dno_resources_development_corp_payment_vouchers.created_by',
                                    'dno_resources_development_corp_payment_vouchers.created_at',
                                    'dno_resources_development_corp_payment_vouchers.invoice_number',
                                    'dno_resources_development_corp_payment_vouchers.issued_date',
                                    'dno_resources_development_corp_payment_vouchers.category',
                                    'dno_resources_development_corp_payment_vouchers.amount_due',
                                    'dno_resources_development_corp_payment_vouchers.delivered_date',
                                    'dno_resources_development_corp_payment_vouchers.status',
                                    'dno_resources_development_corp_payment_vouchers.cheque_number',
                                    'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                    'dno_resources_development_corp_payment_vouchers.sub_category',
                                    'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                    'dno_resources_development_corp_payment_vouchers.deleted_at',
                                    'dno_resources_development_codes.dno_resources_code',
                                    'dno_resources_development_codes.module_id',
                                    'dno_resources_development_codes.module_code',
                                    'dno_resources_development_codes.module_name')
                                    ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                    ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                    ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_resources_development_codes.module_name', $moduleName)
                                    ->whereBetween('dno_resources_development_corp_payment_vouchers.created_at', [$startDate, $endDate])
                                    ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                    ->where('dno_resources_development_corp_payment_vouchers.currency', $currency)
                                    ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
    
        return view('dno-resources-multiple-summary-report', compact('getTransactionLists', 'startDate', 'endDate', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 
        'totalAmountCheck', 'totalAmountCheckInUSD'));
    
    }

    public function search(Request $request){
        $getSearchResults =DnoResourcesDevelopmentCode::where('dno_resources_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Purchase Order"){ 
            $getSearchPurchaseOrders = DB::table(
                            'dno_resources_development_corp_purchase_orders')
                            ->select( 
                            'dno_resources_development_corp_purchase_orders.id',
                            'dno_resources_development_corp_purchase_orders.user_id',
                            'dno_resources_development_corp_purchase_orders.po_id',
                            'dno_resources_development_corp_purchase_orders.paid_to',
                            'dno_resources_development_corp_purchase_orders.address',
                            'dno_resources_development_corp_purchase_orders.date',
                            'dno_resources_development_corp_purchase_orders.quantity',
                            'dno_resources_development_corp_purchase_orders.description',
                            'dno_resources_development_corp_purchase_orders.unit',
                            'dno_resources_development_corp_purchase_orders.unit_price',
                            'dno_resources_development_corp_purchase_orders.amount',
                            'dno_resources_development_corp_purchase_orders.total_price',
                            'dno_resources_development_corp_purchase_orders.prepared_by',
                            'dno_resources_development_corp_purchase_orders.checked_by',
                            'dno_resources_development_corp_purchase_orders.ordered_by',
                            'dno_resources_development_corp_purchase_orders.particulars',
                            'dno_resources_development_corp_purchase_orders.qty',
                            'dno_resources_development_corp_purchase_orders.created_by',
                            'dno_resources_development_corp_purchase_orders.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_purchase_orders.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_purchase_orders.id', $getSearchResults[0]->module_id)
                            ->where('dno_resources_development_codes.module_name', $getSearchResults[0]->module_name)
                            ->get();

            $getAllCodes = DnoResourcesDevelopmentCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;
           
            return view('dno-resources-search-results',  compact('module', 'getAllCodes', 'getSearchPurchaseOrders'));
                          
        }else if($getSearchResults[0]->module_name === "Payment Voucher"){
           $getSearchPaymentVouchers = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.id', $getSearchResults[0]->module_id)
                                ->where('dno_resources_development_codes.module_name', $getSearchResults[0]->module_name)
                                ->get();

            $getAllCodes = DnoResourcesDevelopmentCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('dno-resources-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
                        

    
        }
    }

    public function searchNumberCode(){
        $getAllCodes = DnoResourcesDevelopmentCode::get()->toArray();
        return view('dno-resources-search-number-code', compact('getAllCodes'));
    }

    public function printGetSummary($date){ 
        $moduleName = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($date))
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                            ->get();
        
        $totalAmountCashes = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($date))
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.currency',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($date))
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                            ->get();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.currency',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($date))
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                ->where('dno_resources_development_corp_payment_vouchers.currency', '!=', $currency)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');

                            
        $totalPaidAmountCheck = DB::table(
                                    'dno_resources_development_corp_payment_vouchers')
                                    ->select( 
                                    'dno_resources_development_corp_payment_vouchers.id',
                                    'dno_resources_development_corp_payment_vouchers.user_id',
                                    'dno_resources_development_corp_payment_vouchers.pv_id',
                                    'dno_resources_development_corp_payment_vouchers.date',
                                    'dno_resources_development_corp_payment_vouchers.paid_to',
                                    'dno_resources_development_corp_payment_vouchers.account_no',
                                    'dno_resources_development_corp_payment_vouchers.account_name',
                                    'dno_resources_development_corp_payment_vouchers.particulars',
                                    'dno_resources_development_corp_payment_vouchers.amount',
                                    'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                    'dno_resources_development_corp_payment_vouchers.prepared_by',
                                    'dno_resources_development_corp_payment_vouchers.approved_by',
                                    'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                    'dno_resources_development_corp_payment_vouchers.received_by_date',
                                    'dno_resources_development_corp_payment_vouchers.created_by',
                                    'dno_resources_development_corp_payment_vouchers.created_at',
                                    'dno_resources_development_corp_payment_vouchers.invoice_number',
                                    'dno_resources_development_corp_payment_vouchers.issued_date',
                                    'dno_resources_development_corp_payment_vouchers.category',
                                    'dno_resources_development_corp_payment_vouchers.amount_due',
                                    'dno_resources_development_corp_payment_vouchers.delivered_date',
                                    'dno_resources_development_corp_payment_vouchers.status',
                                    'dno_resources_development_corp_payment_vouchers.cheque_number',
                                    'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                    'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                                    'dno_resources_development_corp_payment_vouchers.sub_category',
                                    'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                    'dno_resources_development_corp_payment_vouchers.deleted_at',
                                    'dno_resources_development_codes.dno_resources_code',
                                    'dno_resources_development_codes.module_id',
                                    'dno_resources_development_codes.module_code',
                                    'dno_resources_development_codes.module_name')
                                    ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                    ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                    ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_resources_development_codes.module_name', $moduleName)
                                    ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($date))
                                    ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_resources_development_corp_payment_vouchers.status', $status)
                                    ->where('dno_resources_development_corp_payment_vouchers.currency', '!=', $currency)
                                    ->sum('dno_resources_development_corp_payment_vouchers.cheque_total_amount');
    
        $totalAmountCheckInUSD = DB::table(
                                        'dno_resources_development_corp_payment_vouchers')
                                        ->select( 
                                        'dno_resources_development_corp_payment_vouchers.id',
                                        'dno_resources_development_corp_payment_vouchers.user_id',
                                        'dno_resources_development_corp_payment_vouchers.pv_id',
                                        'dno_resources_development_corp_payment_vouchers.date',
                                        'dno_resources_development_corp_payment_vouchers.paid_to',
                                        'dno_resources_development_corp_payment_vouchers.account_no',
                                        'dno_resources_development_corp_payment_vouchers.account_name',
                                        'dno_resources_development_corp_payment_vouchers.particulars',
                                        'dno_resources_development_corp_payment_vouchers.amount',
                                        'dno_resources_development_corp_payment_vouchers.currency',
                                        'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                        'dno_resources_development_corp_payment_vouchers.prepared_by',
                                        'dno_resources_development_corp_payment_vouchers.approved_by',
                                        'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                        'dno_resources_development_corp_payment_vouchers.received_by_date',
                                        'dno_resources_development_corp_payment_vouchers.created_by',
                                        'dno_resources_development_corp_payment_vouchers.created_at',
                                        'dno_resources_development_corp_payment_vouchers.invoice_number',
                                        'dno_resources_development_corp_payment_vouchers.issued_date',
                                        'dno_resources_development_corp_payment_vouchers.category',
                                        'dno_resources_development_corp_payment_vouchers.amount_due',
                                        'dno_resources_development_corp_payment_vouchers.delivered_date',
                                        'dno_resources_development_corp_payment_vouchers.status',
                                        'dno_resources_development_corp_payment_vouchers.cheque_number',
                                        'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                        'dno_resources_development_corp_payment_vouchers.sub_category',
                                        'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                        'dno_resources_development_corp_payment_vouchers.deleted_at',
                                        'dno_resources_development_codes.dno_resources_code',
                                        'dno_resources_development_codes.module_id',
                                        'dno_resources_development_codes.module_code',
                                        'dno_resources_development_codes.module_name')
                                        ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                        ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                        ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                        ->where('dno_resources_development_codes.module_name', $moduleName)
                                        ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($date))
                                        ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                        ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                        ->where('dno_resources_development_corp_payment_vouchers.currency', $currency)
                                        ->sum('dno_resources_development_corp_payment_vouchers.amount_due');

        $totalPaidAmountCheckInUSD = DB::table(
                                            'dno_resources_development_corp_payment_vouchers')
                                            ->select( 
                                            'dno_resources_development_corp_payment_vouchers.id',
                                            'dno_resources_development_corp_payment_vouchers.user_id',
                                            'dno_resources_development_corp_payment_vouchers.pv_id',
                                            'dno_resources_development_corp_payment_vouchers.date',
                                            'dno_resources_development_corp_payment_vouchers.paid_to',
                                            'dno_resources_development_corp_payment_vouchers.account_no',
                                            'dno_resources_development_corp_payment_vouchers.account_name',
                                            'dno_resources_development_corp_payment_vouchers.particulars',
                                            'dno_resources_development_corp_payment_vouchers.amount',
                                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                                            'dno_resources_development_corp_payment_vouchers.approved_by',
                                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                                            'dno_resources_development_corp_payment_vouchers.created_by',
                                            'dno_resources_development_corp_payment_vouchers.created_at',
                                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                                            'dno_resources_development_corp_payment_vouchers.issued_date',
                                            'dno_resources_development_corp_payment_vouchers.category',
                                            'dno_resources_development_corp_payment_vouchers.amount_due',
                                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                                            'dno_resources_development_corp_payment_vouchers.status',
                                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                            'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                                            'dno_resources_development_corp_payment_vouchers.sub_category',
                                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                                            'dno_resources_development_codes.dno_resources_code',
                                            'dno_resources_development_codes.module_id',
                                            'dno_resources_development_codes.module_code',
                                            'dno_resources_development_codes.module_name')
                                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                            ->where('dno_resources_development_codes.module_name', $moduleName)
                                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($date))
                                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                            ->where('dno_resources_development_corp_payment_vouchers.status', $status)
                                            ->where('dno_resources_development_corp_payment_vouchers.currency', $currency)
                                            ->sum('dno_resources_development_corp_payment_vouchers.cheque_total_amount');
                                
        $getDateToday = "";
        $uri0  = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryDnoResoures',  compact('date', 'getDateToday', 'uri0', 'uri1',
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck', 'totalAmountCheck', 'totalPaidAmountCheckInUSD'));
        
        return $pdf->download('dno-resources-summary-report.pdf');
    
    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');

        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDate))
                            ->get();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDate))
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                            ->get();
        
        $totalAmountCashes = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDate))
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.currency',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDate))
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                            ->get();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.currency',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDate))
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                ->where('dno_resources_development_corp_payment_vouchers.currency', '!=', $currency)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
    
        $totalAmountCheckInUSD = DB::table(
                                    'dno_resources_development_corp_payment_vouchers')
                                    ->select( 
                                    'dno_resources_development_corp_payment_vouchers.id',
                                    'dno_resources_development_corp_payment_vouchers.user_id',
                                    'dno_resources_development_corp_payment_vouchers.pv_id',
                                    'dno_resources_development_corp_payment_vouchers.date',
                                    'dno_resources_development_corp_payment_vouchers.paid_to',
                                    'dno_resources_development_corp_payment_vouchers.account_no',
                                    'dno_resources_development_corp_payment_vouchers.account_name',
                                    'dno_resources_development_corp_payment_vouchers.particulars',
                                    'dno_resources_development_corp_payment_vouchers.amount',
                                    'dno_resources_development_corp_payment_vouchers.currency',
                                    'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                    'dno_resources_development_corp_payment_vouchers.prepared_by',
                                    'dno_resources_development_corp_payment_vouchers.approved_by',
                                    'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                    'dno_resources_development_corp_payment_vouchers.received_by_date',
                                    'dno_resources_development_corp_payment_vouchers.created_by',
                                    'dno_resources_development_corp_payment_vouchers.created_at',
                                    'dno_resources_development_corp_payment_vouchers.invoice_number',
                                    'dno_resources_development_corp_payment_vouchers.issued_date',
                                    'dno_resources_development_corp_payment_vouchers.category',
                                    'dno_resources_development_corp_payment_vouchers.amount_due',
                                    'dno_resources_development_corp_payment_vouchers.delivered_date',
                                    'dno_resources_development_corp_payment_vouchers.status',
                                    'dno_resources_development_corp_payment_vouchers.cheque_number',
                                    'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                    'dno_resources_development_corp_payment_vouchers.sub_category',
                                    'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                    'dno_resources_development_corp_payment_vouchers.deleted_at',
                                    'dno_resources_development_codes.dno_resources_code',
                                    'dno_resources_development_codes.module_id',
                                    'dno_resources_development_codes.module_code',
                                    'dno_resources_development_codes.module_name')
                                    ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                    ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                    ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_resources_development_codes.module_name', $moduleName)
                                    ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDate))
                                    ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                    ->where('dno_resources_development_corp_payment_vouchers.currency',  $currency)
                                    ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
        
        return view('dno-resources-get-summary-report', compact('getDate', 'getTransactionLists', 
        'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 
        'totalAmountCheck', 'totalAmountCheckInUSD'));
        
                
    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");
        $moduleName = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                            ->get();
        
        $totalAmountCashes = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.currency',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                            ->get();
        
        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";    
        $totalAmountCheck = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.currency',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                ->where('dno_resources_development_corp_payment_vouchers.currency', '!=', $currency)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
                            
        $totalPaidAmountCheck = DB::table(
                                    'dno_resources_development_corp_payment_vouchers')
                                    ->select( 
                                    'dno_resources_development_corp_payment_vouchers.id',
                                    'dno_resources_development_corp_payment_vouchers.user_id',
                                    'dno_resources_development_corp_payment_vouchers.pv_id',
                                    'dno_resources_development_corp_payment_vouchers.date',
                                    'dno_resources_development_corp_payment_vouchers.paid_to',
                                    'dno_resources_development_corp_payment_vouchers.account_no',
                                    'dno_resources_development_corp_payment_vouchers.account_name',
                                    'dno_resources_development_corp_payment_vouchers.particulars',
                                    'dno_resources_development_corp_payment_vouchers.amount',
                                    'dno_resources_development_corp_payment_vouchers.currency',
                                    'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                    'dno_resources_development_corp_payment_vouchers.prepared_by',
                                    'dno_resources_development_corp_payment_vouchers.approved_by',
                                    'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                    'dno_resources_development_corp_payment_vouchers.received_by_date',
                                    'dno_resources_development_corp_payment_vouchers.created_by',
                                    'dno_resources_development_corp_payment_vouchers.created_at',
                                    'dno_resources_development_corp_payment_vouchers.invoice_number',
                                    'dno_resources_development_corp_payment_vouchers.issued_date',
                                    'dno_resources_development_corp_payment_vouchers.category',
                                    'dno_resources_development_corp_payment_vouchers.amount_due',
                                    'dno_resources_development_corp_payment_vouchers.delivered_date',
                                    'dno_resources_development_corp_payment_vouchers.status',
                                    'dno_resources_development_corp_payment_vouchers.cheque_number',
                                    'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                    'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                                    'dno_resources_development_corp_payment_vouchers.sub_category',
                                    'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                    'dno_resources_development_corp_payment_vouchers.deleted_at',
                                    'dno_resources_development_codes.dno_resources_code',
                                    'dno_resources_development_codes.module_id',
                                    'dno_resources_development_codes.module_code',
                                    'dno_resources_development_codes.module_name')
                                    ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                    ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                    ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_resources_development_codes.module_name', $moduleName)
                                    ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_resources_development_corp_payment_vouchers.status', $status)
                                    ->where('dno_resources_development_corp_payment_vouchers.currency', '!=', $currency)
                                    ->sum('dno_resources_development_corp_payment_vouchers.cheque_total_amount');

        $totalAmountCheckInUSD = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.currency',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                ->where('dno_resources_development_corp_payment_vouchers.currency', $currency)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');

        $totalPaidAmountCheckInUSD = DB::table(
                                    'dno_resources_development_corp_payment_vouchers')
                                    ->select( 
                                    'dno_resources_development_corp_payment_vouchers.id',
                                    'dno_resources_development_corp_payment_vouchers.user_id',
                                    'dno_resources_development_corp_payment_vouchers.pv_id',
                                    'dno_resources_development_corp_payment_vouchers.date',
                                    'dno_resources_development_corp_payment_vouchers.paid_to',
                                    'dno_resources_development_corp_payment_vouchers.account_no',
                                    'dno_resources_development_corp_payment_vouchers.account_name',
                                    'dno_resources_development_corp_payment_vouchers.particulars',
                                    'dno_resources_development_corp_payment_vouchers.amount',
                                    'dno_resources_development_corp_payment_vouchers.currency',
                                    'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                    'dno_resources_development_corp_payment_vouchers.prepared_by',
                                    'dno_resources_development_corp_payment_vouchers.approved_by',
                                    'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                    'dno_resources_development_corp_payment_vouchers.received_by_date',
                                    'dno_resources_development_corp_payment_vouchers.created_by',
                                    'dno_resources_development_corp_payment_vouchers.created_at',
                                    'dno_resources_development_corp_payment_vouchers.invoice_number',
                                    'dno_resources_development_corp_payment_vouchers.issued_date',
                                    'dno_resources_development_corp_payment_vouchers.category',
                                    'dno_resources_development_corp_payment_vouchers.amount_due',
                                    'dno_resources_development_corp_payment_vouchers.delivered_date',
                                    'dno_resources_development_corp_payment_vouchers.status',
                                    'dno_resources_development_corp_payment_vouchers.cheque_number',
                                    'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                    'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                                    'dno_resources_development_corp_payment_vouchers.sub_category',
                                    'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                    'dno_resources_development_corp_payment_vouchers.deleted_at',
                                    'dno_resources_development_codes.dno_resources_code',
                                    'dno_resources_development_codes.module_id',
                                    'dno_resources_development_codes.module_code',
                                    'dno_resources_development_codes.module_name')
                                    ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                    ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                    ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_resources_development_codes.module_name', $moduleName)
                                    ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_resources_development_corp_payment_vouchers.status', $status)
                                    ->where('dno_resources_development_corp_payment_vouchers.currency', $currency)
                                    ->sum('dno_resources_development_corp_payment_vouchers.cheque_total_amount');
                            
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryDnoResoures',  compact('uri0', 'uri1', 'date', 'getDateToday', 
        'getTransactionListCashes', 'getTransactionListChecks',  
        'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck', 'totalAmountCheckInUSD', 'totalPaidAmountCheckInUSD'));
        
        return $pdf->download('dno-resources-summary-report.pdf');
    }

    public function summaryReport(){
        $getDateToday = date("Y-m-d");

        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                            ->get();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                            ->get();
        
        $totalAmountCashes = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $cash)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.currency',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.created_at',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.cheque_total_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                            ->get();

        $currency = "USD";
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                                'dno_resources_development_corp_payment_vouchers')
                                ->select( 
                                'dno_resources_development_corp_payment_vouchers.id',
                                'dno_resources_development_corp_payment_vouchers.user_id',
                                'dno_resources_development_corp_payment_vouchers.pv_id',
                                'dno_resources_development_corp_payment_vouchers.date',
                                'dno_resources_development_corp_payment_vouchers.paid_to',
                                'dno_resources_development_corp_payment_vouchers.account_no',
                                'dno_resources_development_corp_payment_vouchers.account_name',
                                'dno_resources_development_corp_payment_vouchers.particulars',
                                'dno_resources_development_corp_payment_vouchers.amount',
                                'dno_resources_development_corp_payment_vouchers.currency',
                                'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                'dno_resources_development_corp_payment_vouchers.prepared_by',
                                'dno_resources_development_corp_payment_vouchers.approved_by',
                                'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                'dno_resources_development_corp_payment_vouchers.received_by_date',
                                'dno_resources_development_corp_payment_vouchers.created_by',
                                'dno_resources_development_corp_payment_vouchers.created_at',
                                'dno_resources_development_corp_payment_vouchers.invoice_number',
                                'dno_resources_development_corp_payment_vouchers.issued_date',
                                'dno_resources_development_corp_payment_vouchers.category',
                                'dno_resources_development_corp_payment_vouchers.amount_due',
                                'dno_resources_development_corp_payment_vouchers.delivered_date',
                                'dno_resources_development_corp_payment_vouchers.status',
                                'dno_resources_development_corp_payment_vouchers.cheque_number',
                                'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                'dno_resources_development_corp_payment_vouchers.sub_category',
                                'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                'dno_resources_development_corp_payment_vouchers.deleted_at',
                                'dno_resources_development_codes.dno_resources_code',
                                'dno_resources_development_codes.module_id',
                                'dno_resources_development_codes.module_code',
                                'dno_resources_development_codes.module_name')
                                ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                ->where('dno_resources_development_codes.module_name', $moduleName)
                                ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                ->where('dno_resources_development_corp_payment_vouchers.currency', '!=', $currency)
                                ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
            
        $totalAmountCheckInUSD = DB::table(
                                    'dno_resources_development_corp_payment_vouchers')
                                    ->select( 
                                    'dno_resources_development_corp_payment_vouchers.id',
                                    'dno_resources_development_corp_payment_vouchers.user_id',
                                    'dno_resources_development_corp_payment_vouchers.pv_id',
                                    'dno_resources_development_corp_payment_vouchers.date',
                                    'dno_resources_development_corp_payment_vouchers.paid_to',
                                    'dno_resources_development_corp_payment_vouchers.account_no',
                                    'dno_resources_development_corp_payment_vouchers.account_name',
                                    'dno_resources_development_corp_payment_vouchers.particulars',
                                    'dno_resources_development_corp_payment_vouchers.amount',
                                    'dno_resources_development_corp_payment_vouchers.currency',
                                    'dno_resources_development_corp_payment_vouchers.method_of_payment',
                                    'dno_resources_development_corp_payment_vouchers.prepared_by',
                                    'dno_resources_development_corp_payment_vouchers.approved_by',
                                    'dno_resources_development_corp_payment_vouchers.date_apprroved',
                                    'dno_resources_development_corp_payment_vouchers.received_by_date',
                                    'dno_resources_development_corp_payment_vouchers.created_by',
                                    'dno_resources_development_corp_payment_vouchers.created_at',
                                    'dno_resources_development_corp_payment_vouchers.invoice_number',
                                    'dno_resources_development_corp_payment_vouchers.issued_date',
                                    'dno_resources_development_corp_payment_vouchers.category',
                                    'dno_resources_development_corp_payment_vouchers.amount_due',
                                    'dno_resources_development_corp_payment_vouchers.delivered_date',
                                    'dno_resources_development_corp_payment_vouchers.status',
                                    'dno_resources_development_corp_payment_vouchers.cheque_number',
                                    'dno_resources_development_corp_payment_vouchers.cheque_amount',
                                    'dno_resources_development_corp_payment_vouchers.sub_category',
                                    'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                                    'dno_resources_development_corp_payment_vouchers.deleted_at',
                                    'dno_resources_development_codes.dno_resources_code',
                                    'dno_resources_development_codes.module_id',
                                    'dno_resources_development_codes.module_code',
                                    'dno_resources_development_codes.module_name')
                                    ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                                    ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                                    ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL)
                                    ->where('dno_resources_development_codes.module_name', $moduleName)
                                    ->whereDate('dno_resources_development_corp_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('dno_resources_development_corp_payment_vouchers.method_of_payment', $check)
                                    ->where('dno_resources_development_corp_payment_vouchers.status', '!=', $status)
                                    ->where('dno_resources_development_corp_payment_vouchers.currency', $currency)
                                    ->sum('dno_resources_development_corp_payment_vouchers.amount_due');
                            
    
                
        return view('dno-resources-summary-report', compact('getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 
        'totalAmountCheck', 'totalAmountCheckInUSD'));
    }
   
   
    public function viewDeliveryTransaction($id){
        $deliveryTransaction = DnoResourcesDevelopmentCorpDeliveryTransactionForm::find($id);

        $getTotal = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('id', $id)->sum('total');

        $getSum = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('dt_id', $id)->sum('total');

        $sum = $getTotal + $getSum;

        $dTransactions = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('dt_id', $id)->get()->toArray();
        return view('view-dno-resources-delivery-transaction', compact('deliveryTransaction', 'dTransactions', 'sum'));
    }

    public function deliveryRecords(){
        $deliveryTransactions = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('dt_id', NULL)->get()->toArray();

        return view('dno-resources-delivery-records', compact('deliveryTransactions'));
    }

    public function updateDT(Request $request, $id){
        $updateDt = DnoResourcesDevelopmentCorpDeliveryTransactionForm::find($id);
        $updateDt->delivery_description = $request->get('deliveryDescription');
        $updateDt->qty = $request->get('qty');
        $updateDt->total = $request->get('total');

        $updateDt->save();
        Session::flash('SuccessEdit', 'Successfully edited.');
        return redirect()->route('editDeliveryTransaction', ['id'=>$request->get('dtId')]);
    }

    public function addDelivery(Request $request, $id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $addTransaction = new DnoResourcesDevelopmentCorpDeliveryTransactionForm([
            'user_id'=>$user->id,
            'dt_id'=>$id,
            'delivery_description'=>$request->get('deliveryDescription'),
            'qty'=>$request->get('qty'),
            'total'=>$request->get('total'),
            'created_by'=>$name,
        ]);
        $addTransaction->save();

        Session::flash('addNewSuccess', 'Successfully added.');
        return redirect()->route('editDeliveryTransaction', ['id'=>$id]);

    }

    public function editDeliveryTransaction($id){
        $deliveryT = DnoResourcesDevelopmentCorpDeliveryTransactionForm::find($id);

        $deliveryTransactions = DnoResourcesDevelopmentCorpDeliveryTransactionForm::where('dt_id', $id)->get()->toArray();

        return view('dno-resources-edit-delivery-transaction', compact('deliveryT', 'deliveryTransactions'));
    }

    public function addDeliveryTransaction(Request $request){
         //
         $this->validate($request, [
            'supplierName'=>'required',
            'deliveryDescription'=>'required',
        ]);

        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $addDeliveryTransaction = new DnoResourcesDevelopmentCorpDeliveryTransactionForm([
            'user_id'=>$user->id,
            'supplier_name'=>$request->get('supplierName'),
            'delivery_date'=>$request->get('deliveryDate'),
            'delivered_to'=>$request->get('deliveredTo'),
            'dr_no'=>$request->get('drNo'),
            'delivery_description'=>$request->get('deliveryDescription'),
            'qty'=>$request->get('qty'),
            'total'=>$request->get('total'),
            'created_by'=>$name,
        ]);

        $addDeliveryTransaction->save();
        $insertedId = $addDeliveryTransaction->id;

        return redirect()->route('editDeliveryTransaction', ['id'=>$insertedId]);
    

    }

    public function deliveryForm(){
        return view('dno-resources-delivery-form');
    }

    public function purchaseOrderList(){
        $moduleName = "Purchase Order";
        $purchaseOrders = DB::table(
                            'dno_resources_development_corp_purchase_orders')
                            ->select( 
                            'dno_resources_development_corp_purchase_orders.id',
                            'dno_resources_development_corp_purchase_orders.user_id',
                            'dno_resources_development_corp_purchase_orders.po_id',
                            'dno_resources_development_corp_purchase_orders.paid_to',
                            'dno_resources_development_corp_purchase_orders.address',
                            'dno_resources_development_corp_purchase_orders.date',
                            'dno_resources_development_corp_purchase_orders.quantity',
                            'dno_resources_development_corp_purchase_orders.description',
                            'dno_resources_development_corp_purchase_orders.unit',
                            'dno_resources_development_corp_purchase_orders.unit_price',
                            'dno_resources_development_corp_purchase_orders.amount',
                            'dno_resources_development_corp_purchase_orders.total_price',
                            'dno_resources_development_corp_purchase_orders.prepared_by',
                            'dno_resources_development_corp_purchase_orders.checked_by',
                            'dno_resources_development_corp_purchase_orders.ordered_by',
                            'dno_resources_development_corp_purchase_orders.particulars',
                            'dno_resources_development_corp_purchase_orders.qty',
                            'dno_resources_development_corp_purchase_orders.created_by',
                            'dno_resources_development_corp_purchase_orders.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_purchase_orders.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_purchase_orders.po_id', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->where('dno_resources_development_corp_purchase_orders.deleted_at', NULL)
                            ->orderBy('dno_resources_development_corp_purchase_orders.id', 'desc')
                            ->get()->toArray();

        return view('dno-resources-purchase-order-lists', compact('purchaseOrders'));
    }

    public function updatePo(Request $request, $id){
        $order = DnoResourcesDevelopmentCorpPurchaseOrder::find($id);
        
        $order->quantity = $request->get('quantity');
        $order->description = $request->get('description');
        $order->unit = $request->get('unit');
        $order->unit_price  = $request->get('unitPrice');
        $order->amount = $request->get('amount');
    
        $order->save();
        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('dno-resources/edit-dno-resources-purchase-order/'.$request->get('poId'));
    }


    public function addNew(Request $request, $id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        //
          $this->validate($request, [
            'amount'=>'required',
        ]);

        $pO = DnoResourcesDevelopmentCorpPurchaseOrder::find($id);

        $addNewParticulars = new DnoResourcesDevelopmentCorpPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit'=>$request->get('unit'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewParticulars->save();

        Session::flash('addNewSuccess', 'Successfully added');

        return redirect()->route('edit', ['id'=>$id]);
    }

    public function purchaseOrder(){
        return view('dno-resources-purchase-order');
    }

    public function printPayables($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.id', $id)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->get();

        //getParticular details
        $getParticulars = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
    

         $getChequeNumbers = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
         $amount1 = DnoResourcesDevelopmentCorpPaymentVoucher::where('id', $id)->sum('amount');
         $amount2 = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->sum('amount');
           
         $sum = $amount1 + $amount2;
         
         //
         $chequeAmount1 = DnoResourcesDevelopmentCorpPaymentVoucher::where('id', $id)->sum('cheque_amount');
         $chequeAmount2 = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
         
         $sumCheque = $chequeAmount1 + $chequeAmount2;
       

        $pdf = PDF::loadView('printPayablesDnoResources', compact('payableId', 
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

        return $pdf->download('dno-resources-payment-voucher.pdf');
    }


    public function viewPayableDetails($id){
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.currency',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.id', $id)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->get();

        //
        $getViewPaymentDetails = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //getParticular details
          $getParticulars = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
       

        return view('view-dno-resources-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
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

                    $payables = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
                    $payables->save();


                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

        //add current amount
         $add = $particulars['amount_due'] + $request->get('amount');


        $addParticulars = new DnoResourcesDevelopmentCorpPaymentVoucher([
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

        return redirect('/dno-resources-development/edit-dno-resources-payables-detail/'.$id);
    }

    //
    public function addPayment(Request $request, $id){  
           $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');


        //save payment cheque num and cheque amount
        $addPayment = new DnoResourcesDevelopmentCorpPaymentVoucher([
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

         return redirect('dno-resources-development/edit-dno-resources-payables-detail/'.$id);
    }

    //
    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.currency',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.id', $id)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->get();

          //
        $getChequeNumbers = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
      
         //getParticular details
         $getParticulars = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        //amount
        $amount1 = DnoResourcesDevelopmentCorpPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;

         //
         $chequeAmount1 = DnoResourcesDevelopmentCorpPaymentVoucher::where('id', $id)->sum('cheque_amount');
         $chequeAmount2 = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
         
         $sumCheque = $chequeAmount1 + $chequeAmount2;

         return view('dno-resources-payables-detail', compact('transactionList', 'getChequeNumbers','sum', 
            'getParticulars', 'sumCheque', 'getCashAmounts'));
    }

    //
    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'dno_resources_development_corp_payment_vouchers')
                            ->select( 
                            'dno_resources_development_corp_payment_vouchers.id',
                            'dno_resources_development_corp_payment_vouchers.user_id',
                            'dno_resources_development_corp_payment_vouchers.pv_id',
                            'dno_resources_development_corp_payment_vouchers.date',
                            'dno_resources_development_corp_payment_vouchers.paid_to',
                            'dno_resources_development_corp_payment_vouchers.account_no',
                            'dno_resources_development_corp_payment_vouchers.account_name',
                            'dno_resources_development_corp_payment_vouchers.particulars',
                            'dno_resources_development_corp_payment_vouchers.amount',
                            'dno_resources_development_corp_payment_vouchers.method_of_payment',
                            'dno_resources_development_corp_payment_vouchers.prepared_by',
                            'dno_resources_development_corp_payment_vouchers.approved_by',
                            'dno_resources_development_corp_payment_vouchers.date_apprroved',
                            'dno_resources_development_corp_payment_vouchers.received_by_date',
                            'dno_resources_development_corp_payment_vouchers.created_by',
                            'dno_resources_development_corp_payment_vouchers.invoice_number',
                            'dno_resources_development_corp_payment_vouchers.issued_date',
                            'dno_resources_development_corp_payment_vouchers.category',
                            'dno_resources_development_corp_payment_vouchers.amount_due',
                            'dno_resources_development_corp_payment_vouchers.delivered_date',
                            'dno_resources_development_corp_payment_vouchers.status',
                            'dno_resources_development_corp_payment_vouchers.cheque_number',
                            'dno_resources_development_corp_payment_vouchers.cheque_amount',
                            'dno_resources_development_corp_payment_vouchers.sub_category',
                            'dno_resources_development_corp_payment_vouchers.sub_category_account_id',
                            'dno_resources_development_corp_payment_vouchers.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_payment_vouchers.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_payment_vouchers.pv_id', NULL)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->where('dno_resources_development_corp_payment_vouchers.deleted_at', NULL  )
                            ->orderBy('dno_resources_development_corp_payment_vouchers.id', 'desc')
                            ->get();



           //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = DnoResourcesDevelopmentCorpPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('dno-resources-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));
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
        $dataVoucherRef = DB::select('SELECT id, dno_resources_code FROM dno_resources_development_codes ORDER BY id DESC LIMIT 1');


          //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->dno_resources_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->dno_resources_code +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
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
                        'dno_resources_development_corp_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first(); 
        if ($target === NULL) {
            # code...
              $addPaymentVoucher = new DnoResourcesDevelopmentCorpPaymentVoucher([
                    'user_id'=>$user->id,
                    'paid_to'=>$request->get('paidTo'),
                    'method_of_payment'=>$request->get('paymentMethod'),
                    'invoice_number'=>$request->get('invoiceNumber'),
                    'account_name'=>$request->get('accountName'),
                    'issued_date'=>$request->get('issuedDate'),
                    'delivered_date'=>$request->get('deliveredDate'),
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

            $dnoResources = new DnoResourcesDevelopmentCode([
                'user_id'=>$user->id,
                'dno_resources_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);

            $dnoResources->save();

            return redirect()->route('editPayablesDetailDnoResources', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormDnoResources')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
            
        }
    }

    //
    public function paymentVoucherForm(){
        //get suppliers
        $suppliers = DnoResourcesDevelopmentCorpSupplier::get()->toArray();

        $pettyCashes = DnoResourcesDevelopmentCorpPettyCash::with(['user', 'petty_cashes'])
                                                        ->where('pc_id', NULL)
                                                        ->where('deleted_at', NULL)
                                                        ->get();

        return view('payment-voucher-form-dno-resources', compact('suppliers', 'pettyCashes'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dno-resources');

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

        $this->validate($request, [
            'paidTo' => 'required',
            'description'=>'required',
        ]);

          //get the latest insert id query in table dno resources development codes
          $data = DB::select('SELECT id, dno_resources_code FROM dno_resources_development_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1
           if(isset($data[0]->dno_resources_code) != 0){
              //if code is not 0
              $newNum = $data[0]->dno_resources_code +1;
              $uNum = sprintf("%06d",$newNum);    
          }else{
              //if code is 0 
              $newNum = 1;
              $uNum = sprintf("%06d",$newNum);
          }

          $purchaseOrder = new DnoResourcesDevelopmentCorpPurchaseOrder([
                'user_id' =>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'date'=>$request->get('date'),
                'address'=>$request->get('address'),
                'quantity'=>$request->get('quantity'),
                'description'=>$request->get('description'),
                'unit'=>$request->get('unit'),
                'unit_price'=>$request->get('unitPrice'),
                'amount'=>$request->get('amount'),
                'prepared_by'=>$name,
                'created_by'=>$name
          ]);

          $purchaseOrder->save();

          $insertedId = $purchaseOrder->id;

          $moduleCode = "PO-";
          $moduleName = "Purchase Order";

          $dnoResources = new DnoResourcesDevelopmentCode([
                'user_id'=>$user->id,
                'dno_resources_code'=>$uNum,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
          ]);

          $dnoResources->save();


          return redirect()->route('edit', ['id'=>$insertedId]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                            'dno_resources_development_corp_purchase_orders')
                            ->select( 
                            'dno_resources_development_corp_purchase_orders.id',
                            'dno_resources_development_corp_purchase_orders.user_id',
                            'dno_resources_development_corp_purchase_orders.po_id',
                            'dno_resources_development_corp_purchase_orders.paid_to',
                            'dno_resources_development_corp_purchase_orders.address',
                            'dno_resources_development_corp_purchase_orders.date',
                            'dno_resources_development_corp_purchase_orders.quantity',
                            'dno_resources_development_corp_purchase_orders.description',
                            'dno_resources_development_corp_purchase_orders.unit',
                            'dno_resources_development_corp_purchase_orders.unit_price',
                            'dno_resources_development_corp_purchase_orders.amount',
                            'dno_resources_development_corp_purchase_orders.total_price',
                            'dno_resources_development_corp_purchase_orders.prepared_by',
                            'dno_resources_development_corp_purchase_orders.checked_by',
                            'dno_resources_development_corp_purchase_orders.ordered_by',
                            'dno_resources_development_corp_purchase_orders.particulars',
                            'dno_resources_development_corp_purchase_orders.qty',
                            'dno_resources_development_corp_purchase_orders.created_by',
                            'dno_resources_development_corp_purchase_orders.deleted_at',
                            'dno_resources_development_codes.dno_resources_code',
                            'dno_resources_development_codes.module_id',
                            'dno_resources_development_codes.module_code',
                            'dno_resources_development_codes.module_name')
                            ->leftJoin('dno_resources_development_codes', 'dno_resources_development_corp_purchase_orders.id', '=', 'dno_resources_development_codes.module_id')
                            ->where('dno_resources_development_corp_purchase_orders.id', $id)
                            ->where('dno_resources_development_codes.module_name', $moduleName)
                            ->get();

        //
        $pOrders = DnoResourcesDevelopmentCorpPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = DnoResourcesDevelopmentCorpPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = DnoResourcesDevelopmentCorpPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-dno-resources-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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
        $purchaseOrder = DnoResourcesDevelopmentCorpPurchaseOrder::find($id);

        $pOrders = DnoResourcesDevelopmentCorpPurchaseOrder::where('po_id', $id)->get()->toArray();

        return view('edit-dno-resources-purchase-order', compact('purchaseOrder', 'pOrders'));
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

    public function destroyBillingStatement($id){
        $billingStatement = DnoResourcesDevelopmentCorpBillingStatement::find($id);
        $billingStatement->delete();

        //delete SOA
        $statementAccount = DnoResourcesDevelopmentCorpStatementOfAccount::find($id);
        $statementAccount->delete();
    }

    public function destroyBillingDataStatement(Request $request, $id){
        $billStatement = DnoResourcesDevelopmentCorpBillingStatement::find($request->billingStatementId);

        $billingStatement = DnoResourcesDevelopmentCorpBillingStatement::find($id);
    
        $getAmount = $billStatement->total_amount - $billingStatement->amount;
        $billStatement->total_amount = $getAmount;
        $billStatement->save();

        $billingStatement->delete();

         //update statement of account table
         $statementAccount = DnoResourcesDevelopmentCorpStatementOfAccount::find($request->billingStatementId);

         $stateAccount = DnoResourcesDevelopmentCorpStatementOfAccount::find($id);
 
         $getStateAmount = $statementAccount->total_amount - $stateAccount->amount; 
         $statementAccount->total_amount = $getStateAmount;
         $statementAccount->total_remaining_balance = $getStateAmount;
         $statementAccount->save();
 
         $stateAccount->delete();
    }


    public function destroyPettyCash($id){
        $pettyCash = DnoResourcesDevelopmentCorpPettyCash::find($id);
        $pettyCash->delete();
    }

    public function destroyDeliveryTransaction($id){
        $deliveryTransaction = DnoResourcesDevelopmentCorpDeliveryTransactionForm::find($id);
        $deliveryTransaction->delete();
    }
    
    public function destroyTransactionList($id){
         $transactionList = DnoResourcesDevelopmentCorpPaymentVoucher::find($id);
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
        $purchaseOrder = DnoResourcesDevelopmentCorpPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }
}
