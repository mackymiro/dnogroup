<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use App\User; 
use App\DongFangCorporationPaymentVoucher;
use App\DongFangCorporationBillingStatement;

class DongFangCorporationController extends Controller
{
    public function viewBillingStatement($id){
        $viewBillingStatement = DongFangCorporationBillingStatement::find($id);

        $billingStatements = DongFangCorporationBillingStatement::where('bs_id', $id)->get()->toArray();

        $billTotal = DongFangCorporationBillingStatement::where('id', $id)->sum('amount');
        $billTotal2 = DongFangCorporationBillingStatement::where('bs_id', $id)->sum('amount');

        $sum = $billTotal + $billTotal2;

        return view('view-dong-fang-corporation-billing-statement', compact('viewBillingStatement', 'billingStatements', 'sum'));
    }

    public function billingStatementList(){
        $billingLists = DongFangCorporationBillingStatement::where('bs_id', NULL)->get()->toArray();
        return view('dong-fang-corporation-billing-list', compact('billingLists'));
    }

    public function updateBL(Request $request, $id){
        $updateBilling = DongFangCorporationBillingStatement::find($id);
        $updateBilling->date_detail = $request->get('dateDetails');
        $updateBilling->no_pax = $request->get('noPax');
        $updateBilling->particular = $request->get('particular');
        $updateBilling->price_per_pax = $request->get('pricePerPax');
        $updateBilling->amount = $request->get('amount');
        $updateBilling->save();

        Session::flash('updateBilling', 'Successfully updated.');
        return redirect()->route('editBillingStatementDongFang', ['id'=>$request->get('bsId')]); 
    }

    public function addNewBillingStatement(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addNewBilling = new DongFangCorporationBillingStatement([
            'user_id'=>$user->id,
            'bs_id'=>$id,
            'date'=>$request->get('dateDetails'),
            'no_pax'=>$request->get('noPax'),
            'particular'=>$request->get('particular'),
            'price_per_pax'=>$request->get('pricePerPax'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNewBilling->save();
        Session::flash('billingsAdded', 'Successfully added.');
        return redirect()->route('editBillingStatementDongFang', ['id'=>$id]);

    }

    public function editBillingStatement($id){
        $billingStatement = DongFangCorporationBillingStatement::find($id);

        $billingLists = DongFangCorporationBillingStatement::where('bs_id', $id)->get()->toArray();
        return view('edit-dong-fang-billing-statement', compact('billingStatement', 'billingLists'));
    }

    public function storeBillingStamtement(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //validate
        $this->validate($request, [
            'accountNo' =>'required',
            'companyName'=>'required',
            'particular'=>'required',          
        ]);

        
        //check if invoice number already exists
        $target = DB::table(
            'dong_fang_corporation_billing_statements')
            ->where('account_no', $request->get('accountNo'))
            ->get()->first();

        if($target === NULL){
            $storeBilling = new DongFangCorporationBillingStatement([
                'user_id'=>$user->id,
                'date'=>$request->get('date'),
                'account_no'=>$request->get('accountNo'),
                'company_name'=>$request->get('companyName'),
                'address'=>$request->get('address'),
                'billing_statement_no'=>$request->get('billingStatementNo'),
                'attention'=>$request->get('attention'),
                'ref_no'=>$request->get('refNumber'),
                'po_no'=>$request->get('poNumber'),
                'terms'=>$request->get('terms'),
                'due_date'=>$request->get('dueDate'),
                'date_detail'=>$request->get('dateDetails'),
                'no_pax'=>$request->get('noPax'),
                'particular'=>$request->get('particular'),
                'price_per_pax'=>$request->get('pricePerPax'),
                'amount'=>$request->get('amount'),
                'created_by'=>$name,
            ]);
    
            $storeBilling->save();
            $insertedId = $storeBilling->id;
    
            return redirect()->route('editBillingStatementDongFang', ['id'=>$insertedId]);
        }else{
            return redirect()->route('billingStatementFormDongFang')->with('error', 'Account Number Already Exists. Please See Transaction List For Your Reference');

        }
       
    }

    public function billingStatementForm(){

        return view('dong-fang-billing-statement-form');
    }

    public function transactionList(){
        $getTransactionLists = DongFangCorporationPaymentVoucher::where('pv_id', NULL)->get()->toArray();

         //get total amount due
         $status = "FULLY PAID AND RELEASED";

         $totalAmountDue = DongFangCorporationPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

         
        return view('dong-fang-corporation-transaction-list', compact('getTransactionLists', 'totalAmountDue'));
    }

    public function addParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = DongFangCorporationPaymentVoucher::find($id);

         //add current amount
         $add = $particulars['amount_due'] + $request->get('amount');

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $addParticulars = new DongFangCorporationPaymentVoucher([
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
         return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);
    }

    public function addPayment(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = DongFangCorporationPaymentVoucher::find($id);
         
        //save payment cheque num and cheque amount
         $addPayment = new DongFangCorporationPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,
        ]);

        $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');
        
        return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);

    }

    public function accept(Request $request, $id){
         //get the status 
         $status = $request->get('status');
         if($status == "FULLY PAID AND RELEASED"){
             switch ($request->get('action')) {
                 case 'PAID AND RELEASE':
                     # code...
                     $payables = DongFangCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                     Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');
 
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
 
         }else if($status == "FOR APPROVAL"){
             switch ($request->get('action')) {
                 case 'PAID & HOLD':
                     # code...
                     $payables = DongFangCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                      Session::flash('payablesSuccess', 'Status set for approval.');
 
                      return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);
 
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
         }else{
 
             switch ($request->get('action')) {
                 case 'PAID & HOLD':
                     # code...
                     $payables = DongFangCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                     Session::flash('payablesSuccess', 'Status set for confirmation.');
 
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id]);
                     
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailDongFang', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
         }  
    }

    public function editPayablesDetail(Request $request, $id){
        $transactionList = DongFangCorporationPaymentVoucher::find($id);

        $getChequeNumbers = DongFangCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        //getParticular details
        $getParticulars = DongFangCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        //amount
        $amount1 = DongFangCorporationPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DongFangCorporationPaymentVoucher::where('pv_id', $id)->sum('amount');
           
        $sum = $amount1 + $amount2;

        $chequeAmount1 = DongFangCorporationPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DongFangCorporationPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('dong-fang-corporation-payables-detail', compact('transactionList', 'getParticulars', 'sum', 
        'getChequeNumbers', 'sumCheque'));
    }

    public function paymentVoucherStore(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table payment voucher ref number
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM dong_fang_corporation_payment_vouchers ORDER BY id DESC LIMIT 1');

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


        //check if invoice number already exists
        $target = DB::table(
            'dong_fang_corporation_payment_vouchers')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();
        
        if($target === NULL){
            $addPaymentVoucher = new DongFangCorporationPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'voucher_ref_number'=>$uVoucher,
                'issued_date'=>$request->get('issuedDate'),
                'delivered_date'=>$request->get('deliveredDate'),
                'amount'=>$request->get('amount'),
                'amount_due'=>$request->get('amount'),
                'particulars'=>$request->get('particulars'),
                'prepared_by'=>$name,
                'created_by'=>$name,
            ]);
            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;
            
            return redirect()->route('editPayablesDetailDongFang', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormDongFang')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');

        }

    }

    public function paymentVoucherForm(){

        return view('payment-voucher-form-dong-fang-corp');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('dong-fang-corporation');
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

    public function destroyBillingStatment($id){
        $billingStatement = DongFangCorporationBillingStatement::find($id);
        $billingStatement->delete();
    }

    public function destroyTransaction($id){
        $transactionList = DongFangCorporationPaymentVoucher::find($id);
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
