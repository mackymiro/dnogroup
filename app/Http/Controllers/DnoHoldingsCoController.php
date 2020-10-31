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
use App\DnoHoldingsCoPurchaseOrder;
use App\DnoHoldingsCoPettyCash;
use App\DnoHoldingsCoBillingStatement; 


class DnoHoldingsCoController extends Controller
{

    public function printBillingStatement($id){ 
        $printBillingStatement = DnoHoldingsCoBillingStatement::with(['user', 'billing_statements'])
                                                                ->where('id', $id)
                                                                ->get();

        $billingStatements = DnoHoldingsCoBillingStatement::where('billing_statement_id', $id)->get()->toArray();

            //count the total amount 
        $countTotalAmount = DnoHoldingsCoBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = DnoHoldingsCoBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printBillingStatementDnoHoldingsCo', compact('printBillingStatement', 'billingStatements', 'sum'));

        return $pdf->download('dno-holdings-co-billing-statement.pdf');   
    }

    public function viewBillingStatement($id){
        $viewBillingStatement = DnoHoldingsCoBillingStatement::with(['user', 'billing_statements'])
                                                    ->where('id', $id)
                                                    ->get();
        

        $billingStatements = DnoHoldingsCoBillingStatement::where('billing_statement_id', $id)->get()->toArray();

            //count the total amount 
        $countTotalAmount = DnoHoldingsCoBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = DnoHoldingsCoBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-dno-holdings-co-billing-statement', compact('viewBillingStatement', 'billingStatements', 'sum'));
 
    }

    public function billingStatementList(){
        $billingStatements = DnoHoldingsCoBillingStatement::with(['user', 'billing_statements'])
                                                ->where('billing_statement_id', NULL)
                                                ->where('deleted_at', NULL)
                                                ->orderBy('id', 'desc')
                                                ->get();

        return view('dno-holdings-co-billing-statement-lists', compact('billingStatements'));
    }

    public function addNewBilling(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = DnoHoldingsCoBillingStatement::find($id);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $amount = $request->get('amount');

        $tot = $billingOrder->total_amount + $amount; 

        $addBillingStatement = new DnoHoldingsCoBillingStatement([
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


         //update
         $billingOrder->total_amount = $tot;
         $billingOrder->save();

         Session::flash('SuccessAdd', 'Successfully added.');

         return redirect()->route('editBillingStatementDnoHoldingsCo', ['id'=>$id]);
    }



    public function updateBillingInfo(Request $request, $id){
        $updateBillingOrder = DnoHoldingsCoBillingStatement::find($id);


        $updateBillingOrder->bill_to = $request->get('billTo');
        $updateBillingOrder->address = $request->get('address');
        $updateBillingOrder->period_cover = $request->get('periodCovered');
      
        $updateBillingOrder->terms = $request->get('terms');
        $updateBillingOrder->date_of_transaction = $request->get('transactionDate');
        $updateBillingOrder->dr_no = $request->get('drNo');
        $updateBillingOrder->description = $request->get('description');
        $updateBillingOrder->unit_price = $request->get('unitPrice');
        $updateBillingOrder->amount = $request->get('amount');
        $updateBillingOrder->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect()->route('editBillingStatementDnoHoldingsCo', ['id'=>$id]);
    }

    public function editBillingStatement($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $billingStatement = DnoHoldingsCoBillingStatement::find($id);
       
        $bStatements = DnoHoldingsCoBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        return view('edit-dno-holdings-co-billing-statement-form', compact('billingStatement', 'bStatements'));
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
        $dataReferenceNum = DB::select('SELECT id, dno_holdings_code FROM dno_holdings_co_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 reference number
        if(isset($dataReferenceNum[0]->dno_holdings_code) != 0){
              //if code is not 0
              $newRefNum = $dataReferenceNum[0]->dno_holdings_code +1;
              $uRef = sprintf("%06d",$newRefNum);   
  
          }else{
              //if code is 0 
              $newRefNum = 1;
              $uRef = sprintf("%06d",$newRefNum);
          } 

          $billingStatement = new DnoHoldingsCoBillingStatement([
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

        $dnoHoldingsCo = new DnoHoldingsCoCode([
            'user_id'=>$user->id,
            'dno_holdings_code'=>$uRef,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);

        $dnoHoldingsCo->save();

        return redirect()->route('editBillingStatementDnoHoldingsCo', ['id'=>$insertedId]);

    }

    public function billingStatementForm(){
        return view('dno-holdings-co-billing-statement-form');
    }

    public function printPettyCash($id){    
        $getPettyCash =  DnoHoldingsCoPettyCash::with(['user', 'petty_cashes'])
                                                ->where('id', $id)
                                                ->get();

        $getPettyCashSummaries = DnoPersonalPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = DnoPersonalPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = DnoPersonalPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashDnoHoldingsCo', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));

        return $pdf->download('dno-personal-petty-cash.pdf');
    }

    public function viewPettyCash($id){
        $getPettyCash =  DnoHoldingsCoPettyCash::with(['user', 'petty_cashes'])
                                                        ->where('id', $id)
                                                        ->get();

        $getPettyCashSummaries = DnoHoldingsCoPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = DnoHoldingsCoPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = DnoHoldingsCoPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;


        return view('dno-holdings-co-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
    }

    public function updatePC(Request $request, $id){
        $updatePC = DnoHoldingsCoPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashDnoHoldingsCo', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
    
        $addNew = new DnoHoldingsCoPettyCash([
            'user_id'=>$user->id,
            'pc_id'=>$id,
            'date'=>$request->get('date'),
            'petty_cash_summary'=>$request->get('pettyCashSummary'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNew->save();

        Session::flash('addNewSuccess', 'Successfully added.');

        return redirect()->route('editPettyCashDnoHoldingsCo', ['id'=>$id]);
    }

    public function updatePettyCash(Request $request, $id){
        $update = DnoHoldingsCoPettyCash::find($id);
        $update->date = $request->get('date');
        $update->petty_cash_name = $request->get('pettyCashName');
        $update->petty_cash_summary = $request->get('pettyCashSummary');
        $update->amount = $request->get('amount');

        $update->save();
        Session::flash('editSuccess', 'Successfully updated.'); 

        return redirect()->route('editPettyCashDnoHoldingsCo', ['id'=>$id]);
    }

    public function editPettyCash($id){
        $pettyCash =  DnoHoldingsCoPettyCash::with(['user', 'petty_cashes'])
                                                        ->where('id', $id)
                                                        ->get();

        $pettyCashSummaries = DnoHoldingsCoPettyCash::where('pc_id', $id)->get()->toArray();

        return view('edit-dno-holdings-co-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }

    public function addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table dno personal codes
         $dataCashNo = DB::select('SELECT id, dno_holdings_code FROM dno_holdings_co_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
         if(isset($dataCashNo[0]->dno_holdings_code) != 0){
             //if code is not 0
             $newProd = $dataCashNo[0]->dno_holdings_code +1;
             $uPetty = sprintf("%06d",$newProd);   
 
         }else{
             //if code is 0 
             $newProd = 1;
             $uPetty = sprintf("%06d",$newProd);
         } 

         $addPettyCash = new DnoHoldingsCoPettyCash([
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

        $dnoHoldings = new DnoHoldingsCoCode([
            'user_id'=>$user->id,
            'dno_holdings_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $dnoHoldings->save();
      
        return response()->json($insertId);


    }

    public function pettyCashList(){
        $pettyCashLists =  DnoHoldingsCoPettyCash::with(['user', 'petty_cashes'])
                                                        ->where('pc_id', NULL)
                                                        ->where('deleted_at', NULL)
                                                        ->get();

        return view('dno-holdings-co-petty-cash-list', compact('pettyCashLists'));
    }

    public function printPO($id){
        $purchaseOrder =  DnoHoldingsCoPurchaseOrder::with(['user', 'purchase_orders'])
                                                    ->where('id', $id)                     
                                                    ->get(); 

        $pOrders = DnoHoldingsCoPurchaseOrder::where('po_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoHoldingsCoPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = DnoHoldingsCoPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        $pdf = PDF::loadView('printPODnoHoldingsCo', compact('purchaseOrder', 'pOrders', 'sum'));

        return $pdf->download('dno-holdings-co-purchase-order.pdf');

    }

    public function purchaseOrderList(){
        $purchaseOrders =  DnoHoldingsCoPurchaseOrder::with(['user', 'purchase_orders'])
                                                ->where('po_id', NULL)
                                                ->where('deleted_at', NULL)
                                                ->orderBy('id', 'desc')
                                                ->get(); 

        return view('dno-holdings-co-purchase-order-list', compact('purchaseOrders'));
    }

    public function updatePo(Request $request, $id){
        $order = DnoHoldingsCoPurchaseOrder::find($id);
        $order->quantity = $request->get('quant');
        $order->description = $request->get('desc');
        $order->unit_price = $request->get('unitP');
        $order->amount = $request->get('amt');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect()->route('editDnoHoldingsCo', ['id'=>$request->get('poId')]);
    }

    public function addNewPurchaseOrder(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pO = DnoHoldingsCoPurchaseOrder::find($id);
    
        $tot = $pO->total_price + $request->get('amount');

        $addPurchaseOrder = new DnoHoldingsCoPurchaseOrder([
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

        return redirect()->route('editDnoHoldingsCo', ['id'=>$id]);
    }

    public function purchaseOrder(){
        return view('dno-holdings-co-purchase-order');
    }


    public function printMultipleSummary(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];

        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
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
                    'dno_holdings_co_payment_vouchers.cheque_total_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_payment_vouchers.created_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                    ->whereBetween('dno_holdings_co_payment_vouchers.created_at', [$uri0, $uri1])
                    ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $totalAmountCashes = DB::table(
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereBetween('dno_holdings_co_payment_vouchers.created_at',  [$uri0, $uri1])
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->sum('dno_holdings_co_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
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
                    'dno_holdings_co_payment_vouchers.cheque_total_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_payment_vouchers.created_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                    ->whereBetween('dno_holdings_co_payment_vouchers.created_at',  [$uri0, $uri1])
                    ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->get()->toArray();
        
        $status = "FULLY PAID AND RELEASED";     
        $totalAmountCheck = DB::table(
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
                    'dno_holdings_co_payment_vouchers.cheque_total_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_payment_vouchers.created_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                    ->whereBetween('dno_holdings_co_payment_vouchers.created_at', [$uri0, $uri1])
                    ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                    ->where('dno_holdings_co_payment_vouchers.status','!=', $status)
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->sum('dno_holdings_co_payment_vouchers.amount_due');

    $totalPaidAmountCheck = DB::table(
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereBetween('dno_holdings_co_payment_vouchers.created_at',  [$uri0, $uri1])
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                        ->where('dno_holdings_co_payment_vouchers.status', $status)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->sum('dno_holdings_co_payment_vouchers.amount_due');
    
        
        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryDnoHoldingsCo', compact('date', 'uri0', 'uri1', 'getDateToday', 
        'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('dno-holdings-co-summary-report.pdf');


    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");
        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
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
                    'dno_holdings_co_payment_vouchers.cheque_total_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_payment_vouchers.created_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                    ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $totalAmountCashes = DB::table(
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->sum('dno_holdings_co_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
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
                    'dno_holdings_co_payment_vouchers.cheque_total_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_payment_vouchers.created_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                    ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->get()->toArray();
        
        $status = "FULLY PAID AND RELEASED";     
        $totalAmountCheck = DB::table(
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
                    'dno_holdings_co_payment_vouchers.cheque_total_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_payment_vouchers.created_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                    ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                    ->where('dno_holdings_co_payment_vouchers.status','!=', $status)
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->sum('dno_holdings_co_payment_vouchers.amount_due');

    $totalPaidAmountCheck = DB::table(
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                        ->where('dno_holdings_co_payment_vouchers.status', $status)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->sum('dno_holdings_co_payment_vouchers.amount_due');
    
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryDnoHoldingsCo', compact('date', 'uri0', 'uri1', 'getDateToday', 'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));

        return $pdf->download('dno-holdings-co-summary-report.pdf');

    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));
    
        $moduleNamePV = "Payment Voucher";
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
                    'dno_holdings_co_payment_vouchers.cheque_total_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_payment_vouchers.created_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->leftJoin('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                    ->whereBetween('dno_holdings_co_payment_vouchers.created_at', [$startDate, $endDate])
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->get()->toArray();


        $cash = "CASH";
        $getTransactionListCashes = DB::table(
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->leftJoin('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereBetween('dno_holdings_co_payment_vouchers.created_at',  [$startDate, $endDate])
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->get()->toArray();
            
        $totalAmountCashes = DB::table(
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->leftJoin('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereBetween('dno_holdings_co_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->sum('dno_holdings_co_payment_vouchers.amount_due');


        $check = "CHECK";
        $getTransactionListChecks = DB::table(
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
                            'dno_holdings_co_payment_vouchers.cheque_total_amount',
                            'dno_holdings_co_payment_vouchers.sub_category',
                            'dno_holdings_co_payment_vouchers.sub_category_account_id',
                            'dno_holdings_co_payment_vouchers.deleted_at',
                            'dno_holdings_co_payment_vouchers.created_at',
                            'dno_holdings_co_codes.dno_holdings_code',
                            'dno_holdings_co_codes.module_id',
                            'dno_holdings_co_codes.module_code',
                            'dno_holdings_co_codes.module_name')
                            ->leftJoin('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                            ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                            ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                            ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                            ->whereBetween('dno_holdings_co_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                            ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                            ->get()->toArray();

    
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
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
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->leftJoin('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereBetween('dno_holdings_co_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                        ->where('dno_holdings_co_payment_vouchers.status', '!=', $status)
                        ->sum('dno_holdings_co_payment_vouchers.amount_due');
            
        return view('dno-holdings-co-multiple-summary-report', compact('getTransactionLists', 'startDate', 'endDate', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');
        $moduleNamePV = "Payment Voucher";
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
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDate))
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
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
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDate))
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $totalAmountCashes = DB::table(
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
                            'dno_holdings_co_payment_vouchers.created_at',
                            'dno_holdings_co_codes.dno_holdings_code',
                            'dno_holdings_co_codes.module_id',
                            'dno_holdings_co_codes.module_code',
                            'dno_holdings_co_codes.module_name')
                            ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                            ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                            ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                            ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                            ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDate))
                            ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                            ->sum('dno_holdings_co_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDate))
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
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
                    'dno_holdings_co_payment_vouchers.cheque_total_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_payment_vouchers.created_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                    ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDate))
                    ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->sum('dno_holdings_co_payment_vouchers.amount_due');
            
        return view('dno-holdings-co-get-summary-report', compact('getDate', 'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function summaryReport(){
        $getDateToday = date("Y-m-d");

        $moduleNamePV = "Payment Voucher";
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->get()->toArray();


        $totalAmountCashes = DB::table(
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
                            'dno_holdings_co_payment_vouchers.cheque_total_amount',
                            'dno_holdings_co_payment_vouchers.sub_category',
                            'dno_holdings_co_payment_vouchers.sub_category_account_id',
                            'dno_holdings_co_payment_vouchers.deleted_at',
                            'dno_holdings_co_payment_vouchers.created_at',
                            'dno_holdings_co_codes.dno_holdings_code',
                            'dno_holdings_co_codes.module_id',
                            'dno_holdings_co_codes.module_code',
                            'dno_holdings_co_codes.module_name')
                            ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                            ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                            ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                            ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                            ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dno_holdings_co_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                            ->sum('dno_holdings_co_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
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
                        'dno_holdings_co_payment_vouchers.cheque_total_amount',
                        'dno_holdings_co_payment_vouchers.sub_category',
                        'dno_holdings_co_payment_vouchers.sub_category_account_id',
                        'dno_holdings_co_payment_vouchers.deleted_at',
                        'dno_holdings_co_payment_vouchers.created_at',
                        'dno_holdings_co_codes.dno_holdings_code',
                        'dno_holdings_co_codes.module_id',
                        'dno_holdings_co_codes.module_code',
                        'dno_holdings_co_codes.module_name')
                        ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                        ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                        ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                        ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                        ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                        ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                        ->get()->toArray();
       
       
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
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
                    'dno_holdings_co_payment_vouchers.cheque_total_amount',
                    'dno_holdings_co_payment_vouchers.sub_category',
                    'dno_holdings_co_payment_vouchers.sub_category_account_id',
                    'dno_holdings_co_payment_vouchers.deleted_at',
                    'dno_holdings_co_payment_vouchers.created_at',
                    'dno_holdings_co_codes.dno_holdings_code',
                    'dno_holdings_co_codes.module_id',
                    'dno_holdings_co_codes.module_code',
                    'dno_holdings_co_codes.module_name')
                    ->join('dno_holdings_co_codes', 'dno_holdings_co_payment_vouchers.id', '=', 'dno_holdings_co_codes.module_id')
                    ->where('dno_holdings_co_payment_vouchers.pv_id', NULL)
                    ->where('dno_holdings_co_payment_vouchers.deleted_at', NULL)
                    ->where('dno_holdings_co_codes.module_name', $moduleNamePV)
                    ->whereDate('dno_holdings_co_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('dno_holdings_co_payment_vouchers.method_of_payment', $check)
                    ->orderBy('dno_holdings_co_payment_vouchers.id', 'desc')
                    ->sum('dno_holdings_co_payment_vouchers.amount_due');


        return view('dno-holdings-co-summary-report', compact('getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
    }

    public function search(Request $request){
        $getSearchResults =DnoHoldingsCoCode::where('dno_holdings_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
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
                        ->where('dno_holdings_co_payment_vouchers.id', $getSearchResults[0]->module_id)
                        ->where('dno_holdings_co_codes.module_name', $getSearchResults[0]->module_name)
                        ->get()->toArray();
                        
                $getAllCodes = DnoHoldingsCoCode::get()->toArray();  
                $module = $getSearchResults[0]->module_name;            

                return view('dno-holdings-co-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
        }
    }

    public function searchNumberCode(){
        $getAllCodes = DnoHoldingsCoCode::get()->toArray();
        return view('dno-holdings-co-search-number-code', compact('getAllCodes'));
    }

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
         $data = DB::select('SELECT id, dno_holdings_code FROM dno_holdings_co_codes ORDER BY id DESC LIMIT 1');
        
         //if code is not zero add plus 1
        if(isset($data[0]->dno_holdings_code) != 0){
             //if code is not 0
             $newNum = $data[0]->dno_holdings_code +1;
             $uNum = sprintf("%06d",$newNum);    
         }else{
             //if code is 0 
             $newNum = 1;
             $uNum = sprintf("%06d",$newNum);
         }

         $purchaseOrder = new DnoHoldingsCoPurchaseOrder([
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
        $dnoHoldings = new DnoHoldingsCoCode([
            'user_id'=>$user->id,
            'dno_holdings_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $dnoHoldings->save();

        return redirect()->route('editDnoHoldingsCo', ['id'=>$insertedId]);
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
        $purchaseOrder =  DnoHoldingsCoPurchaseOrder::with(['user', 'purchase_orders'])
                                                    ->where('id', $id)
                                                    ->get(); 

        $pOrders = DnoHoldingsCoPurchaseOrder::where('po_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoHoldingsCoPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = DnoHoldingsCoPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-dno-holdings-co-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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
        $purchaseOrder = DnoHoldingsCoPurchaseOrder::with(['user', 'purchase_orders'])
                                                    ->where('id', $id)
                                                    ->get();

        $pOrders = DnoHoldingsCoPurchaseOrder::where('po_id', $id)->get()->toArray();

        return view('edit-dno-holdings-co-purchase-order', compact('id', 'purchaseOrder', 'pOrders'));
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
        $billingStatement = DnoHoldingsCoBillingStatement::find($id);
        $billingStatement->delete();
    }

    public function destroyBillingDataStatement(Request $request, $id){
        $billStatement = DnoHoldingsCoBillingStatement::find($request->billingStatementId);

        $billingStatement = DnoHoldingsCoBillingStatement::find($id);
    
        $getAmount = $billStatement->total_amount - $billingStatement->amount;
        $billStatement->total_amount = $getAmount;
        $billStatement->save();

        $billingStatement->delete();
    }


    public function destroyPettyCash($id){
        $pettyCash = DnoHoldingsCoPettyCash::find($id);
        $pettyCash->delete();
    }

    public function destroyTransactionList($id){
        $transactionList = DnoHoldingsCoPaymentVoucher::find($id);
        $transactionList->delete();
    }

    public function destroyPO($id){
        $purchaseOrder = DnoHoldingsCoPurchaseOrder::find($id);
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
        $poId = DnoHoldingsCoPurchaseOrder::find($request->poId);

        $purchaseOrder = DnoHoldingsCoPurchaseOrder::find($id);
        $getAmount = $poId->total_price - $purchaseOrder->amount;

        $poId->total_price = $getAmount;
        $poId->save();

        $purchaseOrder->delete();
    }
}
