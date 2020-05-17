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


class LoloPinoyGrillBranchesController extends Controller
{

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
    public function detailTransactions($id){    
        $transaction = LoloPinoyGrillBranchesSalesForm::find($id); 
         //getTransactions
        $getTransactions = LoloPinoyGrillBranchesSalesForm::where('sf_id', $id)->get()->toArray();
        return view('lolo-pinoy-grill-branches-detail-transactions', compact('transaction', 'getTransactions'));
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
            'created_by'=>$name,
        ]);
        $addAdditional->save();
    
        return response()->json($addAdditional);

    }

    public function salesTransaction($id){
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
        //
        $getPettyCash = LoloPinoyGrillBranchesPaymentVoucher::find($id);

        //
        $getPettyCashSummaries = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //total
        $totalPettyCash = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->where('pv_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        return view('lolo-pinoy-grill-branches-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
    }

    //
    public function pettyCashList(){
        $cat = "Petty Cash";
        $getPettyCashLists = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', NULL)->where('category',$cat)->get()->toArray();

        return view('lolo-pinoy-grill-branches-petty-cash-list', compact('getPettyCashLists'));
    }

    //
    public function salesInvoiceForm(){


        return view('lolo-pinoy-grill-branches-sales-invoice-form');
    }

    //
    public function reqTransactionList(){
    
        $requisitionLists = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', NULL)->get()->toArray();

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
        $requisitionLists = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', NULL)->get()->toArray();

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
        $payableId = LoloPinoyGrillBranchesPaymentVoucher::find($id);

        $payablesVouchers = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->sum('amount_due');


          //
        $countAmount = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesLoloPinoyGrillBranches', compact('payableId', 'payablesVouchers', 'sum'));

        return $pdf->download('lolo-pinoy-grill-branches-payment-voucher.pdf');
    }   

    //
    public function viewPayableDetails($id){
    
        //
        $viewPaymentDetail = LoloPinoyGrillBranchesPaymentVoucher::find($id);

        //
        $getViewPaymentDetails = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('view-lolo-pinoy-grill-branches-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails'));
    }

    //
    public function accept(Request $request, $id){
          //get the status 
        $status = $request->get('status');
        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                    $payables = LoloPinoyGrillBranchesPaymentVoucher::find($id);

                    $payables->status = $status;
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

        //save payment cheque num and cheque amount
        $addPayment = new LoloPinoyGrillBranchesPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

        $addPayment->save();

         Session::flash('paymentAdded', 'Payment added.');

        return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$id);

    }

    //
    public function editPayablesDetail(Request $request, $id){

        //
        $transactionList = LoloPinoyGrillBranchesPaymentVoucher::find($id);

          //
        $getChequeNumbers = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        
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
            'getChequeNumbers','sum', 'getParticulars', 'sumCheque'));
    }

    //
    public function transactionList(){
         //
        $getTransactionLists = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', NULL)->get()->toArray();

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

            //get the latest insert id query in table payment voucher ref number
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM lolo_pinoy_grill_branches_payment_vouchers ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->voucher_ref_number) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->voucher_ref_number +1;
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
                'invoice_number'=>$request->get('invoiceNumber'),
                'voucher_ref_number'=>$uVoucher,
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


            return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$insertedId);
        }else{
             return redirect('lolo-pinoy-grill-branches/payment-voucher-form/')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
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
    public function index()
    {
        //

        return view('lolo-pinoy-grill-branches');


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

         //get the latest insert id query in table purchase order
        $data = DB::select('SELECT id, rs_number FROM lolo_pinoy_grill_branches_requisition_slips ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1
         if(isset($data[0]->rs_number) != 0){
            //if code is not 0
            $newNum = $data[0]->rs_number +1;
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
            'rs_number'=>$uNum,
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
         
        return redirect('lolo-pinoy-grill-branches/edit/'.$insertedId);


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
        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);

        //
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
