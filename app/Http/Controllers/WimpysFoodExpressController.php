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

class WimpysFoodExpressController extends Controller
{

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
            'voucher_ref_number'=>$particulars['voucher_ref_number'],
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
