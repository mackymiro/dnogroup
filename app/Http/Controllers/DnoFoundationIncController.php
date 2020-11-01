<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session; 
use Auth; 
use PDF;
use App\User;
use App\DnoFoundationIncPaymentVoucher;
use App\DnoFoundationIncCode;
use App\DnoFoundationIncSupplier;
use App\DnoFoundationIncPurchaseOrder;
use App\DnoFoundationIncPettyCash;

class DnoFoundationIncController extends Controller
{

    public function printPettyCash($id){
        $getPettyCash =  DnoFoundationIncPettyCash::with(['user', 'petty_cashes'])
                                                    ->where('id', $id)
                                                    ->get();

        $getPettyCashSummaries = DnoFoundationIncPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = DnoFoundationIncPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = DnoFoundationIncPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashDnoFoundationInc', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));

        return $pdf->download('dno-personal-petty-cash.pdf');
    }

    public function viewPettyCash($id){
        $getPettyCash =  DnoFoundationIncPettyCash::with(['user', 'petty_cashes'])
                                                ->where('id', $id)
                                                ->get();

        $getPettyCashSummaries = DnoFoundationIncPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = DnoFoundationIncPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = DnoFoundationIncPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;


        return view('dno-foundation-inc-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
    }

    public function updatePC(Request $request, $id){
        $updatePC = DnoFoundationIncPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashDnoFoundationInc', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addNew = new DnoFoundationIncPettyCash([
            'user_id'=>$user->id,
            'pc_id'=>$id,
            'date'=>$request->get('date'),
            'petty_cash_summary'=>$request->get('pettyCashSummary'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNew->save();

        Session::flash('addNewSuccess', 'Successfully added.');

        return redirect()->route('editPettyCashDnoFoundationInc', ['id'=>$id]);
        
    }

    public function updatePettyCash(Request $request, $id){
        $update = DnoFoundationIncPettyCash::find($id);
        $update->date = $request->get('date');
        $update->petty_cash_name = $request->get('pettyCashName');
        $update->petty_cash_summary = $request->get('pettyCashSummary');
        $update->amount = $request->get('amount');

        $update->save();
        Session::flash('editSuccess', 'Successfully updated.'); 

        return redirect()->route('editPettyCashDnoFoundationInc', ['id'=>$id]);
    }

    public function editPettyCash($id){
        $pettyCash =  DnoFoundationIncPettyCash::with(['user', 'petty_cashes'])
                                                ->where('id', $id)
                                                ->get();

        $pettyCashSummaries = DnoFoundationIncPettyCash::where('pc_id', $id)->get()->toArray();

        return view('edit-dno-foundation-inc-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }

    public function addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //get the latest insert id query in table dno personal codes
          $dataCashNo = DB::select('SELECT id, dno_foundation_code FROM dno_foundation_inc_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 petty cash no
          if(isset($dataCashNo[0]->dno_foundation_code) != 0){
              //if code is not 0
              $newProd = $dataCashNo[0]->dno_foundation_code +1;
              $uPetty = sprintf("%06d",$newProd);   
  
          }else{
              //if code is 0 
              $newProd = 1;
              $uPetty = sprintf("%06d",$newProd);
          } 

          $addPettyCash = new DnoFoundationIncPettyCash([
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

        $dnoFoundation = new DnoFoundationIncCode([
            'user_id'=>$user->id,
            'dno_foundation_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $dnoFoundation->save();
      
        return response()->json($insertId);

    }

    public function pettyCashList(){
        $pettyCashLists =  DnoFoundationIncPettyCash::with(['user', 'petty_cashes'])
                                                    ->where('pc_id', NULL)
                                                    ->where('deleted_at', NULL)
                                                    ->orderBy('id', 'desc')
                                                    ->get();

        return view('dno-foundation-inc-petty-cash-list', compact('pettyCashLists'));
    }

    public function printPO($id){
        $purchaseOrder =  DnoFoundationIncPurchaseOrder::with(['user', 'purchase_orders'])
                                                    ->where('id', $id)                     
                                                    ->get(); 

        $pOrders = DnoFoundationIncPurchaseOrder::where('po_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoFoundationIncPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = DnoFoundationIncPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        $pdf = PDF::loadView('printPODnoFoundationInc', compact('purchaseOrder', 'pOrders', 'sum'));

        return $pdf->download('dno-foundation-inc-purchase-order.pdf');

    }

    public function purchaseOrderList(){
        $purchaseOrders =  DnoFoundationIncPurchaseOrder::with(['user', 'purchase_orders'])
                                                        ->where('po_id', NULL)
                                                        ->where('deleted_at', NULL)
                                                        ->orderBy('id', 'desc')
                                                        ->get(); 

        return view('dno-foundation-inc-purchase-order-list', compact('purchaseOrders'));
    }

    public function updatePo(Request $request, $id){
        $order = DnoFoundationIncPurchaseOrder::find($id);
        $order->quantity = $request->get('quant');
        $order->description = $request->get('desc');
        $order->unit_price = $request->get('unitP');
        $order->amount = $request->get('amt');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect()->route('editDnoFoundationInc', ['id'=>$request->get('poId')]);
    }

    public function addNewPurchaseOrder(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        
        $pO = DnoFoundationIncPurchaseOrder::find($id);
    
        $tot = $pO->total_price + $request->get('amount');

        $addPurchaseOrder = new DnoFoundationIncPurchaseOrder([
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
        return redirect()->route('editDnoFoundationInc', ['id'=>$id]);
    }

    public function purchaseOrder(){
        return view('dno-foundation-inc-purchase-order');
    }

    public function printMultipleSummary(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];

        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereBetween('dno_foundation_inc_payment_vouchers.created_at', [$uri0, $uri1])
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $totalAmountCashes = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereBetween('dno_foundation_inc_payment_vouchers.created_at',  [$uri0, $uri1])
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                    ->sum('dno_foundation_inc_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereBetween('dno_foundation_inc_payment_vouchers.created_at', [$uri0, $uri1])
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";     
        $totalAmountCheck = DB::table(
            'dno_foundation_inc_payment_vouchers')
            ->select( 
            'dno_foundation_inc_payment_vouchers.id',
            'dno_foundation_inc_payment_vouchers.user_id',
            'dno_foundation_inc_payment_vouchers.pv_id',
            'dno_foundation_inc_payment_vouchers.date',
            'dno_foundation_inc_payment_vouchers.paid_to',
            'dno_foundation_inc_payment_vouchers.account_no',
            'dno_foundation_inc_payment_vouchers.account_name',
            'dno_foundation_inc_payment_vouchers.particulars',
            'dno_foundation_inc_payment_vouchers.amount',
            'dno_foundation_inc_payment_vouchers.method_of_payment',
            'dno_foundation_inc_payment_vouchers.prepared_by',
            'dno_foundation_inc_payment_vouchers.approved_by',
            'dno_foundation_inc_payment_vouchers.date_approved',
            'dno_foundation_inc_payment_vouchers.received_by_date',
            'dno_foundation_inc_payment_vouchers.created_by',
            'dno_foundation_inc_payment_vouchers.created_at',
            'dno_foundation_inc_payment_vouchers.invoice_number',
            'dno_foundation_inc_payment_vouchers.issued_date',
            'dno_foundation_inc_payment_vouchers.category',
            'dno_foundation_inc_payment_vouchers.amount_due',
            'dno_foundation_inc_payment_vouchers.delivered_date',
            'dno_foundation_inc_payment_vouchers.status',
            'dno_foundation_inc_payment_vouchers.cheque_number',
            'dno_foundation_inc_payment_vouchers.cheque_amount',
            'dno_foundation_inc_payment_vouchers.cheque_total_amount',
            'dno_foundation_inc_payment_vouchers.sub_category',
            'dno_foundation_inc_payment_vouchers.sub_category_account_id',
            'dno_foundation_inc_payment_vouchers.deleted_at',
            'dno_foundation_inc_codes.dno_foundation_code',
            'dno_foundation_inc_codes.module_id',
            'dno_foundation_inc_codes.module_code',
            'dno_foundation_inc_codes.module_name')
            ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
            ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
            ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
            ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
            ->whereBetween('dno_foundation_inc_payment_vouchers.created_at', [$uri0, $uri1])
            ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
            ->where('dno_foundation_inc_payment_vouchers.status', '!=', $status)
            ->sum('dno_foundation_inc_payment_vouchers.amount_due');
 

        //total paid amount check
        $totalPaidAmountCheck = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereBetween('dno_foundation_inc_payment_vouchers.created_at', [$uri0, $uri1])
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                    ->where('dno_foundation_inc_payment_vouchers.status', $status)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->sum('dno_foundation_inc_payment_vouchers.amount_due');

        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryDnoFoundationInc', compact('date', 'uri0', 'uri1', 'getDateToday', 
        'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('dno-foundation-inc-summary-report.pdf');
            

    }

    public function printGetSummary($date){
        $uri0 = "";
        $uri1 = "";

        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($date))
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($date))
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                    ->where('dno_foundation_inc_payment_vouchers.status', '!=', $status)
                    ->sum('dno_foundation_inc_payment_vouchers.amount_due');
        
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($date))
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->get()->toArray();

    $totalAmountCheck = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($date))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                        ->where('dno_foundation_inc_payment_vouchers.status', '!=', $status)
                        ->sum('dno_foundation_inc_payment_vouchers.amount_due');
             
            
         //total paid amount check
         $totalPaidAmountCheck = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($date))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                        ->where('dno_foundation_inc_payment_vouchers.status', $status)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->sum('dno_foundation_inc_payment_vouchers.amount_due');
                
        
            $getDateToday = "";     
            $pdf = PDF::loadView('printSummaryDnoFoundationInc',  compact('date', 'getDateToday', 'uri0', 'uri1', 
                'getTransactionListCashes', 'getTransactionListChecks', 
                'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck'));
            
            return $pdf->download('dno-foundation-inc-summary-report.pdf');

    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");
        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->get()->toArray();
        
    $totalAmountCashes = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->sum('dno_foundation_inc_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->sum('dno_foundation_inc_payment_vouchers.amount_due');
                
    $totalPaidAmountCheck = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                        ->where('dno_foundation_inc_payment_vouchers.status', $status)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->sum('dno_foundation_inc_payment_vouchers.amount_due');
                
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryDnoFoundationInc', compact('date', 'uri0', 'uri1', 'getDateToday', 
        'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));

        return $pdf->download('dno-foundation-inc-summary-report.pdf');
        
        
    }

    public function search(Request $request){
        $getSearchResults =DnoFoundationIncCode::where('dno_foundation_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.id', $getSearchResults[0]->module_id)
                        ->where('dno_foundation_inc_codes.module_name', $getSearchResults[0]->module_name)
                        ->get()->toArray();
            
            $getAllCodes = DnoFoundationIncCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;            

            return view('dno-foundation-inc-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
            

        }
    }

    public function searchNumberCode(){
        $getAllCodes = DnoFoundationIncCode::get()->toArray();
        return view('dno-foundation-code-search-number-code', compact('getAllCodes'));        
    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));
        $moduleNamePV = "Payment Voucher";

        $getTransactionLists = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereBetween('dno_foundation_inc_payment_vouchers.created_at', [$startDate, $endDate])
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'dno_foundation_inc_payment_vouchers')
                            ->select( 
                            'dno_foundation_inc_payment_vouchers.id',
                            'dno_foundation_inc_payment_vouchers.user_id',
                            'dno_foundation_inc_payment_vouchers.pv_id',
                            'dno_foundation_inc_payment_vouchers.date',
                            'dno_foundation_inc_payment_vouchers.paid_to',
                            'dno_foundation_inc_payment_vouchers.account_no',
                            'dno_foundation_inc_payment_vouchers.account_name',
                            'dno_foundation_inc_payment_vouchers.particulars',
                            'dno_foundation_inc_payment_vouchers.amount',
                            'dno_foundation_inc_payment_vouchers.method_of_payment',
                            'dno_foundation_inc_payment_vouchers.prepared_by',
                            'dno_foundation_inc_payment_vouchers.approved_by',
                            'dno_foundation_inc_payment_vouchers.date_approved',
                            'dno_foundation_inc_payment_vouchers.received_by_date',
                            'dno_foundation_inc_payment_vouchers.created_by',
                            'dno_foundation_inc_payment_vouchers.created_at',
                            'dno_foundation_inc_payment_vouchers.invoice_number',
                            'dno_foundation_inc_payment_vouchers.issued_date',
                            'dno_foundation_inc_payment_vouchers.category',
                            'dno_foundation_inc_payment_vouchers.amount_due',
                            'dno_foundation_inc_payment_vouchers.delivered_date',
                            'dno_foundation_inc_payment_vouchers.status',
                            'dno_foundation_inc_payment_vouchers.cheque_number',
                            'dno_foundation_inc_payment_vouchers.cheque_amount',
                            'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                            'dno_foundation_inc_payment_vouchers.sub_category',
                            'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                            'dno_foundation_inc_payment_vouchers.deleted_at',
                            'dno_foundation_inc_codes.dno_foundation_code',
                            'dno_foundation_inc_codes.module_id',
                            'dno_foundation_inc_codes.module_code',
                            'dno_foundation_inc_codes.module_name')
                            ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                            ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                            ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                            ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                            ->whereBetween('dno_foundation_inc_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                            ->get()->toArray();

    $totalAmountCashes = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereBetween('dno_foundation_inc_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->sum('dno_foundation_inc_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereBetween('dno_foundation_inc_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereBetween('dno_foundation_inc_payment_vouchers.created_at', [$startDate, $endDate])
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->sum('dno_foundation_inc_payment_vouchers.amount_due');


         return view('dno-foundation-inc-multiple-summary-report', compact('getTransactionLists', 'startDate', 'endDate', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
            
    }   

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');
        $moduleNamePV = "Payment Voucher";
        $getTransactionLists = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDate))
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->get()->toArray();
        
    $cash = "CASH";
    $getTransactionListCashes = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDate))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->get()->toArray();
            
    $totalAmountCashes = DB::table(
                            'dno_foundation_inc_payment_vouchers')
                            ->select( 
                            'dno_foundation_inc_payment_vouchers.id',
                            'dno_foundation_inc_payment_vouchers.user_id',
                            'dno_foundation_inc_payment_vouchers.pv_id',
                            'dno_foundation_inc_payment_vouchers.date',
                            'dno_foundation_inc_payment_vouchers.paid_to',
                            'dno_foundation_inc_payment_vouchers.account_no',
                            'dno_foundation_inc_payment_vouchers.account_name',
                            'dno_foundation_inc_payment_vouchers.particulars',
                            'dno_foundation_inc_payment_vouchers.amount',
                            'dno_foundation_inc_payment_vouchers.method_of_payment',
                            'dno_foundation_inc_payment_vouchers.prepared_by',
                            'dno_foundation_inc_payment_vouchers.approved_by',
                            'dno_foundation_inc_payment_vouchers.date_approved',
                            'dno_foundation_inc_payment_vouchers.received_by_date',
                            'dno_foundation_inc_payment_vouchers.created_by',
                            'dno_foundation_inc_payment_vouchers.created_at',
                            'dno_foundation_inc_payment_vouchers.invoice_number',
                            'dno_foundation_inc_payment_vouchers.issued_date',
                            'dno_foundation_inc_payment_vouchers.category',
                            'dno_foundation_inc_payment_vouchers.amount_due',
                            'dno_foundation_inc_payment_vouchers.delivered_date',
                            'dno_foundation_inc_payment_vouchers.status',
                            'dno_foundation_inc_payment_vouchers.cheque_number',
                            'dno_foundation_inc_payment_vouchers.cheque_amount',
                            'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                            'dno_foundation_inc_payment_vouchers.sub_category',
                            'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                            'dno_foundation_inc_payment_vouchers.deleted_at',
                            'dno_foundation_inc_codes.dno_foundation_code',
                            'dno_foundation_inc_codes.module_id',
                            'dno_foundation_inc_codes.module_code',
                            'dno_foundation_inc_codes.module_name')
                            ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                            ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                            ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                            ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                            ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDate))
                            ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                            ->sum('dno_foundation_inc_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDate))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDate))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->sum('dno_foundation_inc_payment_vouchers.amount_due');

            return view('dno-foundation-inc-get-summary-report', compact('getDate', 'getTransactionLists', 'getTransactionListCashes', 
            'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function summaryReport(){
        $getDateToday = date("Y-m-d");
        $moduleNamePV = "Payment Voucher";

        $getTransactionLists = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->get()->toArray();
        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.created_at',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->get()->toArray();

    $totalAmountCashes = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->sum('dno_foundation_inc_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'dno_foundation_inc_payment_vouchers')
                            ->select( 
                            'dno_foundation_inc_payment_vouchers.id',
                            'dno_foundation_inc_payment_vouchers.user_id',
                            'dno_foundation_inc_payment_vouchers.pv_id',
                            'dno_foundation_inc_payment_vouchers.date',
                            'dno_foundation_inc_payment_vouchers.paid_to',
                            'dno_foundation_inc_payment_vouchers.account_no',
                            'dno_foundation_inc_payment_vouchers.account_name',
                            'dno_foundation_inc_payment_vouchers.particulars',
                            'dno_foundation_inc_payment_vouchers.amount',
                            'dno_foundation_inc_payment_vouchers.method_of_payment',
                            'dno_foundation_inc_payment_vouchers.prepared_by',
                            'dno_foundation_inc_payment_vouchers.approved_by',
                            'dno_foundation_inc_payment_vouchers.date_approved',
                            'dno_foundation_inc_payment_vouchers.received_by_date',
                            'dno_foundation_inc_payment_vouchers.created_by',
                            'dno_foundation_inc_payment_vouchers.created_at',
                            'dno_foundation_inc_payment_vouchers.invoice_number',
                            'dno_foundation_inc_payment_vouchers.issued_date',
                            'dno_foundation_inc_payment_vouchers.category',
                            'dno_foundation_inc_payment_vouchers.amount_due',
                            'dno_foundation_inc_payment_vouchers.delivered_date',
                            'dno_foundation_inc_payment_vouchers.status',
                            'dno_foundation_inc_payment_vouchers.cheque_number',
                            'dno_foundation_inc_payment_vouchers.cheque_amount',
                            'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                            'dno_foundation_inc_payment_vouchers.sub_category',
                            'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                            'dno_foundation_inc_payment_vouchers.deleted_at',
                            'dno_foundation_inc_codes.dno_foundation_code',
                            'dno_foundation_inc_codes.module_id',
                            'dno_foundation_inc_codes.module_code',
                            'dno_foundation_inc_codes.module_name')
                            ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                            ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                            ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                            ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                            ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $check)
                            ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                            ->get()->toArray();
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.created_at',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.cheque_total_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_codes.dno_foundation_code',
                        'dno_foundation_inc_codes.module_id',
                        'dno_foundation_inc_codes.module_code',
                        'dno_foundation_inc_codes.module_name')
                        ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                        ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                        ->where('dno_foundation_inc_codes.module_name', $moduleNamePV)
                        ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                        ->whereDate('dno_foundation_inc_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('dno_foundation_inc_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                        ->sum('dno_foundation_inc_payment_vouchers.amount_due');


        return view('dno-foundation-inc-summary-report', compact('getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
    }

    public function viewSupplier($id){
        $viewSupplier = DnoFoundationIncSupplier::where('id', $id)->get();
        
        $supplierLists  = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_suppliers.id',
                    'dno_foundation_inc_suppliers.date',
                    'dno_foundation_inc_suppliers.supplier_name')
                    ->leftJoin('dno_foundation_inc_suppliers', 'dno_foundation_inc_payment_vouchers.supplier_id', '=', 'dno_foundation_inc_suppliers.id')
                    ->where('dno_foundation_inc_suppliers.id', $id)
                    ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue  = DB::table(
                        'dno_foundation_inc_payment_vouchers')
                        ->select( 
                        'dno_foundation_inc_payment_vouchers.id',
                        'dno_foundation_inc_payment_vouchers.user_id',
                        'dno_foundation_inc_payment_vouchers.pv_id',
                        'dno_foundation_inc_payment_vouchers.date',
                        'dno_foundation_inc_payment_vouchers.paid_to',
                        'dno_foundation_inc_payment_vouchers.account_no',
                        'dno_foundation_inc_payment_vouchers.account_name',
                        'dno_foundation_inc_payment_vouchers.particulars',
                        'dno_foundation_inc_payment_vouchers.amount',
                        'dno_foundation_inc_payment_vouchers.method_of_payment',
                        'dno_foundation_inc_payment_vouchers.prepared_by',
                        'dno_foundation_inc_payment_vouchers.approved_by',
                        'dno_foundation_inc_payment_vouchers.date_approved',
                        'dno_foundation_inc_payment_vouchers.received_by_date',
                        'dno_foundation_inc_payment_vouchers.created_by',
                        'dno_foundation_inc_payment_vouchers.invoice_number',
                        'dno_foundation_inc_payment_vouchers.issued_date',
                        'dno_foundation_inc_payment_vouchers.category',
                        'dno_foundation_inc_payment_vouchers.amount_due',
                        'dno_foundation_inc_payment_vouchers.delivered_date',
                        'dno_foundation_inc_payment_vouchers.status',
                        'dno_foundation_inc_payment_vouchers.cheque_number',
                        'dno_foundation_inc_payment_vouchers.cheque_amount',
                        'dno_foundation_inc_payment_vouchers.sub_category',
                        'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                        'dno_foundation_inc_payment_vouchers.deleted_at',
                        'dno_foundation_inc_suppliers.id',
                        'dno_foundation_inc_suppliers.date',
                        'dno_foundation_inc_suppliers.supplier_name')
                        ->leftJoin('dno_foundation_inc_suppliers', 'dno_foundation_inc_payment_vouchers.supplier_id', '=', 'dno_foundation_inc_suppliers.id')
                        ->where('dno_foundation_inc_suppliers.id', $id)
                        ->where('dno_foundation_inc_payment_vouchers.status', '!=', $status)
                        ->sum('dno_foundation_inc_payment_vouchers.amount_due');


        return view('view-dno-foundation-inc-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue')); 
           
    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //check if supplier name exits
        $target = DB::table(
                'dno_foundation_inc_suppliers')
                ->where('supplier_name', $request->supplierName)
                ->get()->first();

        if($target === NULL){
            $supplier = new DnoFoundationIncSupplier([
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
        $suppliers = DnoFoundationIncSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('dno-foundation-inc-supplier', compact('suppliers'));
    }

    public function printPayablesDnoFoundationInc($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_payment_vouchers.deleted_at',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.id', $id)
                    ->where('dno_foundation_inc_codes.module_name', $moduleName)
                    ->get();
          
        //getParticular details
        $getParticulars = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      
        $getChequeNumbers = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();
  
        $getCashAmounts = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
          
        $amount1 = DnoFoundationIncPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->sum('amount');
             
        $sum = $amount1 + $amount2;
  
          //
        $chequeAmount1 = DnoFoundationIncPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        $pdf = PDF::loadView('printPayablesDnoFoundationInc', compact('payableId',  
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

        return $pdf->download('dno-foundation-inc-payment-voucher.pdf');

    }

    public function viewPayableDetails($id){
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                'dno_foundation_inc_payment_vouchers')
                ->select( 
                'dno_foundation_inc_payment_vouchers.id',
                'dno_foundation_inc_payment_vouchers.user_id',
                'dno_foundation_inc_payment_vouchers.pv_id',
                'dno_foundation_inc_payment_vouchers.date',
                'dno_foundation_inc_payment_vouchers.paid_to',
                'dno_foundation_inc_payment_vouchers.account_no',
                'dno_foundation_inc_payment_vouchers.account_name',
                'dno_foundation_inc_payment_vouchers.particulars',
                'dno_foundation_inc_payment_vouchers.amount',
                'dno_foundation_inc_payment_vouchers.method_of_payment',
                'dno_foundation_inc_payment_vouchers.prepared_by',
                'dno_foundation_inc_payment_vouchers.approved_by',
                'dno_foundation_inc_payment_vouchers.date_approved',
                'dno_foundation_inc_payment_vouchers.received_by_date',
                'dno_foundation_inc_payment_vouchers.created_by',
                'dno_foundation_inc_payment_vouchers.invoice_number',
                'dno_foundation_inc_payment_vouchers.issued_date',
                'dno_foundation_inc_payment_vouchers.category',
                'dno_foundation_inc_payment_vouchers.amount_due',
                'dno_foundation_inc_payment_vouchers.delivered_date',
                'dno_foundation_inc_payment_vouchers.status',
                'dno_foundation_inc_payment_vouchers.cheque_number',
                'dno_foundation_inc_payment_vouchers.cheque_amount',
                'dno_foundation_inc_payment_vouchers.sub_category',
                'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                'dno_foundation_inc_payment_vouchers.deleted_at',
                'dno_foundation_inc_codes.dno_foundation_code',
                'dno_foundation_inc_codes.module_id',
                'dno_foundation_inc_codes.module_code',
                'dno_foundation_inc_codes.module_name')
                ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                ->where('dno_foundation_inc_payment_vouchers.id', $id)
                ->where('dno_foundation_inc_codes.module_name', $moduleName)
                ->get();

        $getViewPaymentDetails = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //getParticular details
        $getParticulars = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        
        return view('view-dno-foundation-inc-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
     
    }

    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.pv_id', NULL)
                    ->where('dno_foundation_inc_codes.module_name', $moduleName)
                    ->where('dno_foundation_inc_payment_vouchers.deleted_at', NULL)
                    ->orderBy('dno_foundation_inc_payment_vouchers.id', 'desc')
                    ->get()->toArray();
           //get total amount due
           $status = "FULLY PAID AND RELEASED";

           $totalAmoutDue = DnoFoundationIncPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');
   
        return view('dno-foundation-inc-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));
    }

    public function updateDetails(Request $request){
        $updateDetail = DnoFoundationIncPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = DnoFoundationIncPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = DnoFoundationIncPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request, $id){
        //main id 
        $updateParticular = DnoFoundationIncPaymentVoucher::find($request->transId);

        //particular id
        $uIdParticular = DnoFoundationIncPaymentVoucher::find($request->id);

        $amount = $request->amount; 

        $updateAmount =  $updateParticular->amount; 

        $uParticular = DnoFoundationIncPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
         
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
        $updateParticular =  DnoFoundationIncPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = DnoFoundationIncPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 

        
        $updateParticular->date = $request->date;
        $updateParticular->particulars = $request->particulars;
        $updateParticular->amount = $amount;
        $updateParticular->amount_due = $sum;
        $updateParticular->save();
 
        return response()->json('Success: successfully updated.');
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

                    $payables = DnoFoundationIncPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
                    $payables->save();


                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect()->route('editPayablesDetailDnoFoundation', ['id'=>$id]);
                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailDnoFoundation', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoFoundationIncPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect()->route('editPayablesDetailDnoFoundation', ['id'=>$id]);

                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailDnoFoundation', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoFoundationIncPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect()->route('editPayablesDetailDnoFoundation', ['id'=>$id]);
                    
                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailDnoFoundation', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = DnoFoundationIncPaymentVoucher::find($id);

           //add current amount
           $add = $particulars['amount_due'] + $request->get('amount');

           //get Category
        $cat = $particulars['category'];
  
        $subAccountId = $particulars['sub_category_account_id'];


        $addParticulars = new DnoFoundationIncPaymentVoucher([
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

        return redirect()->route('editPayablesDetailDnoFoundation', ['id'=>$id]);
    }

    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = DnoFoundationIncPaymentVoucher::find($id);

        
        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');

           //save payment cheque num and cheque amount
           $addPayment = new DnoFoundationIncPaymentVoucher([
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

        return redirect()->route('editPayablesDetailDnoFoundation', ['id'=>$id]);

    }


    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                    'dno_foundation_inc_payment_vouchers')
                    ->select( 
                    'dno_foundation_inc_payment_vouchers.id',
                    'dno_foundation_inc_payment_vouchers.user_id',
                    'dno_foundation_inc_payment_vouchers.pv_id',
                    'dno_foundation_inc_payment_vouchers.date',
                    'dno_foundation_inc_payment_vouchers.paid_to',
                    'dno_foundation_inc_payment_vouchers.account_no',
                    'dno_foundation_inc_payment_vouchers.account_name',
                    'dno_foundation_inc_payment_vouchers.particulars',
                    'dno_foundation_inc_payment_vouchers.amount',
                    'dno_foundation_inc_payment_vouchers.method_of_payment',
                    'dno_foundation_inc_payment_vouchers.prepared_by',
                    'dno_foundation_inc_payment_vouchers.approved_by',
                    'dno_foundation_inc_payment_vouchers.date_approved',
                    'dno_foundation_inc_payment_vouchers.received_by_date',
                    'dno_foundation_inc_payment_vouchers.created_by',
                    'dno_foundation_inc_payment_vouchers.invoice_number',
                    'dno_foundation_inc_payment_vouchers.issued_date',
                    'dno_foundation_inc_payment_vouchers.category',
                    'dno_foundation_inc_payment_vouchers.amount_due',
                    'dno_foundation_inc_payment_vouchers.delivered_date',
                    'dno_foundation_inc_payment_vouchers.status',
                    'dno_foundation_inc_payment_vouchers.cheque_number',
                    'dno_foundation_inc_payment_vouchers.cheque_amount',
                    'dno_foundation_inc_payment_vouchers.sub_category',
                    'dno_foundation_inc_payment_vouchers.sub_category_account_id',
                    'dno_foundation_inc_codes.dno_foundation_code',
                    'dno_foundation_inc_codes.module_id',
                    'dno_foundation_inc_codes.module_code',
                    'dno_foundation_inc_codes.module_name')
                    ->join('dno_foundation_inc_codes', 'dno_foundation_inc_payment_vouchers.id', '=', 'dno_foundation_inc_codes.module_id')
                    ->where('dno_foundation_inc_payment_vouchers.id', $id)
                    ->where('dno_foundation_inc_codes.module_name', $moduleName)
                    ->get();

        $getChequeNumbers = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        $getCashAmounts = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        

        //getParticular details
        $getParticulars = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        //amount
        $amount1 = DnoFoundationIncPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;

        $chequeAmount1 = DnoFoundationIncPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoFoundationIncPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
            
        return view('dno-foundation-inc-payables-detail', compact('transactionList', 'getChequeNumbers','sum', 
        'getParticulars', 'sumCheque', 'getCashAmounts'));
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
        $dataVoucherRef = DB::select('SELECT id, dno_foundation_code FROM dno_foundation_inc_codes ORDER BY id DESC LIMIT 1');
     
        //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->dno_foundation_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->dno_foundation_code +1;
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
                'dno_foundation_inc_payment_vouchers')
                ->where('invoice_number', $request->get('invoiceNumber'))
                ->get()->first();

        if ($target === NULL) {
            # code...
            $addPaymentVoucher = new DnoFoundationIncPaymentVoucher([
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

            $dnoHoldings = new DnoFoundationIncCode([
                'user_id'=>$user->id,
                'dno_foundation_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);

            $dnoHoldings->save();

            return redirect()->route('editPayablesDetailDnoFoundation', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormDnoFoundationInc')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }
       
    
    }

    public function paymentVoucherForm(){
        //get suppliers
        $suppliers = DnoFoundationIncSupplier::get()->toArray();

        return view('payment-voucher-form-dno-foundation-inc', compact('suppliers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dno-foundation-inc');
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
          $data = DB::select('SELECT id, dno_foundation_code FROM dno_foundation_inc_codes ORDER BY id DESC LIMIT 1');
        
          //if code is not zero add plus 1
         if(isset($data[0]->dno_foundation_code) != 0){
              //if code is not 0
              $newNum = $data[0]->dno_foundation_code +1;
              $uNum = sprintf("%06d",$newNum);    
          }else{
              //if code is 0 
              $newNum = 1;
              $uNum = sprintf("%06d",$newNum);
          }

          $purchaseOrder = new DnoFoundationIncPurchaseOrder([
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

          $dnoFoundationInc = new DnoFoundationIncCode([
                'user_id'=>$user->id,
                'dno_foundation_code'=>$uNum,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
          ]);

          $dnoFoundationInc->save();

          return redirect()->route('editDnoFoundationInc', ['id'=>$insertedId]);

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
        $purchaseOrder =  DnoFoundationIncPurchaseOrder::with(['user', 'purchase_orders'])
                                                    ->where('id', $id)
                                                    ->get(); 

        $pOrders = DnoFoundationIncPurchaseOrder::where('po_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoFoundationIncPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = DnoFoundationIncPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-dno-foundation-inc-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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
        $purchaseOrder = DnoFoundationIncPurchaseOrder::with(['user', 'purchase_orders'])
                                                        ->where('id', $id)
                                                        ->get();
        $pOrders = DnoFoundationIncPurchaseOrder::where('po_id', $id)->get()->toArray();

        return view('edit-dno-foundation-inc-purchase-order', compact('id', 'purchaseOrder', 'pOrders'));
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

        $paidTo = $request->get('paidTo');
        $address = $request->get('address');
        $quantity = $request->get('quantity');
        $description = $request->get('description');
        $date = $request->get('date');
        $unitPrice = $request->get('unitPrice');
        $amount = $request->get('amount');

        $purchaseOrder = DnoFoundationIncPurchaseOrder::find($id);
        
        $purchaseOrder->paid_to = $paidTo;
        $purchaseOrder->address = $address;
        $purchaseOrder->date = $date;
        $purchaseOrder->description = $description;
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();


        Session::flash('SuccessE', 'Successfully updated');

        return redirect()->route('editDnoFoundationInc', ['id'=>$id]);
    }

    public function destroyPettyCash($id){
        $pettyCash = DnoFoundationIncPettyCash::find($id);
        $pettyCash->delete();
    }

    public function destroyPO($id){
        $purchaseOrder = DnoFoundationIncPurchaseOrder::find($id);
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
        $poId = DnoFoundationIncPurchaseOrder::find($request->poId);

        $purchaseOrder = DnoFoundationIncPurchaseOrder::find($id);
        $getAmount = $poId->total_price - $purchaseOrder->amount;

        $poId->total_price = $getAmount;
        $poId->save();

        $purchaseOrder->delete();

    }
}
