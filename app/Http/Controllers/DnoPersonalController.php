<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF; 
use Session;
use Auth; 
use App\User;
use App\DnoPersonalPaymentVoucher;
use App\DnoPersonalCreditCard;
use App\DnoPersonalProperty;

class DnoPersonalController extends Controller
{

    //
    public function vehicles(){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        return view('dno-personal-vehicles', compact('user'));
    }

    //
    public function storeProperties(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //validate
        $this->validate($request, [
            'propName' =>'required',
            'propAccountCode'=>'required',
            'propAccountName'=>'required',
            'address'=>'required',
            'unit'=>'required',
        ]);

        $addProperties = new DnoPersonalProperty([
            'user_id'=>$user->id,
            'property_name'=>$request->get('propName'),
            'property_account_code'=>$request->get('propAccountCode'),
            'property_account_name'=>$request->get('propAccountName'),
            'address'=>$request->get('address'),
            'unit'=>$request->get('unit'),
            'status'=>$request->geT('status'),
            'flag'=>$request->get('flag'),
            'created_by'=>$name,
        ]);

        $addProperties->save();

        Session::flash('addProperty', 'Successfully added a property.');

        if($request->get('flag') == "Cebu Properties"){
            return redirect('dno-personal/cebu-properties');
        }else{
            return redirect('dno-personal/manila-properties');
        }
        
       
    }

    //
    public function properties(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $cebuFlag = "Cebu Properties";
        $manilaFlag = "Manila Properties";

        //getCebuProperties
        $getCebuProperties = DnoPersonalProperty::where('flag', $cebuFlag)->get()->toArray();

        //getManilaProperties
        $getManilaProperties = DnoPersonalProperty::where('flag', $manilaFlag)->get()->toArray();
         
        return view('dno-personal-properties', compact('user', 'getCebuProperties', 'getManilaProperties'));  
    }

    //
    public function printPersonalTransactions($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $personalExpenses = DnoPersonalPaymentVoucher::find($id);

        $particulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('amount', '!=', NULL)->get()->toArray();

        //
        $payments = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('amount', NULL)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount_due');
            //
        $countAmount = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;

        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        $pdf = PDF::loadView('printPersonalTransactions', compact('personalExpenses', 'user', 'particulars', 'sum', 
        'payments', 'sumCheque'));

        return $pdf->download('dno-personal-transaction.pdf');
   
    }

    //
    public function printCardTransactions($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $creditCard = DnoPersonalPaymentVoucher::find($id);

        $particulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('amount', '!=', NULL)->get()->toArray();

        //
        $payments = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('amount', NULL)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount_due');
            //
        $countAmount = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;

        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;


        $pdf = PDF::loadView('printCardTransactions', compact('creditCard', 'user', 'particulars', 'sum', 
        'payments', 'sumCheque'));

        return $pdf->download('dno-personal-card-transaction.pdf');
    }

    //
    public function personalTransaction($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

          //
        $viewTransaction = DnoPersonalPaymentVoucher::find($id);
    
        //getParticular details
        $getParticulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
          //
        $getChequeNumbers = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        //amount
        $amount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;

        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('dno-personal-personal-expenses-transaction', compact('user', 'viewTransaction', 
        'sum', 'getParticulars', 'getChequeNumbers', 'sumCheque'));
    }

    //
    public function viewTransaction($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewTransaction = DnoPersonalPaymentVoucher::find($id);

        //
        $getChequeNumbers = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        //getParticular details
        $getParticulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        //amount
        $amount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;

        

        return view('dno-personal-credit-card-view', compact('user', 'viewTransaction', 'getParticulars', 
            'getChequeNumbers', 'sumCheque', 'sum'));
    }

    //
    public function cardTransaction($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        
        //creditCardDetail
        $creditCardDetail = DnoPersonalCreditCard::find($id);
        
        //getTransaction
        $getTransactions = DnoPersonalPaymentVoucher::where('account_no', $creditCardDetail['account_no'])->get()->toArray();
       
        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmountDue = DnoPersonalPaymentVoucher::where('account_no', $creditCardDetail['account_no'])
        ->where('status' ,'!=', $status)->sum('amount_due');

            
        return view('dno-personal-credit-card-transaction', compact('user', 'getTransactions', 'creditCardDetail', 
        'totalAmountDue'));
    }

    //
    public function updateCard(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $updateCard = DnoPersonalCreditCard::find($id);
        $updateCard->bank_name = $request->get('bankName');
        $updateCard->account_no = $request->get('accountNo');
        $updateCard->account_name = $request->get('accountName');
        $updateCard->type_of_card = $request->get('typeOfCard');
        $updateCard->save();

        Session::flash('updatedCard', 'Successfully added a card.');

        return redirect('dno-personal/credit-card/accounts/edit/'.$id);

    }   

    //
    public function editCreditCardAccount($id){ 
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $getCreditCardDetail = DnoPersonalCreditCard::find($id);

        $accountName = "Alan Dino";
        $accountName2 = "MARY MARGARET O. DINO";

        $getCreditCards1 = DnoPersonalCreditCard::where('account_name', $accountName)->get()->toArray();

        $getCreditCards2 = DnoPersonalCreditCard::where('account_name', $accountName2)->get()->toArray();

        return view('dno-personal-credit-card-edit', compact('user', 'getCrediCards1', 'getCreditCards2', 'getCreditCardDetail'));
    }   

    //
    public function storeCreditCard(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //validate
        $this->validate($request, [
        'bankName' =>'required',
        'accountNo'=>'required',
        'accountName'=>'required',
        
         ]);

        $addCreditCard = new DnoPersonalCreditCard([
            'user_id'=>$user->id,
            'bank_name'=>$request->get('bankName'),
            'account_no'=>$request->get('accountNo'),
            'account_name'=>$request->get('accountName'),
            'type_of_card'=>$request->get('typeOfCard'),
            'created_by'=>$name,
        ]);

        $addCreditCard->save();

        Session::flash('cardAdded', 'Successfully added a card.');

        if (\Request::is('dno-personal/credit-card/ald-accounts')) { 
            return redirect('dno-personal/credit-card/ald-accounts');
        }else{
            return redirect('dno-personal/credit-card/mod-accounts');
        }
        
    }

    //
    public function creditCardAccount(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $accountName = "Alan Dino";
        $accountName2 = "MARY MARGARET O. DINO";

        $getCreditCards1 = DnoPersonalCreditCard::where('account_name', $accountName)->get()->toArray();

        $getCreditCards2 = DnoPersonalCreditCard::where('account_name', $accountName2)->get()->toArray();

        return view('dno-personal-credit-card', compact('user', 'getCreditCards1', 'getCreditCards2'));
    }

    //
    public function printPayablesDnoPersonal($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $payableId = DnoPersonalPaymentVoucher::find($id);

        $payablesVouchers = DnoPersonalPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount_due');


          //
        $countAmount = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesDnoPersonal', compact('payableId', 'user', 'payablesVouchers', 'sum'));

        return $pdf->download('dno-personal-payment-voucher.pdf');
    }


    //
    public function viewPayableDetails($id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewPaymentDetail = DnoPersonalPaymentVoucher::find($id);

        //
        $getViewPaymentDetails = DnoPersonalPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('view-dno-personal-payable-details', compact('user', 'viewPaymentDetail', 'getViewPaymentDetails'));
    }

    //
    public function accept(Request $request, $id){
        //get the status 
        $status = $request->get('status');
        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                    $payables = DnoPersonalPaymentVoucher::find($id);



                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoPersonalPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoPersonalPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('dno-personal/edit-dno-personalr-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = DnoPersonalPaymentVoucher::find($id);
    
        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

        $addParticulars = new DnoPersonalPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$particulars['voucher_ref_number'],
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,

        ]);

        $addParticulars->save();
           
        //update 
        $particulars->amount_due = $add;
        $particulars->save();
        
        Session::flash('particularsAdded', 'Particulars added.');

        return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);
    }

    //
    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         $paymentData = DnoPersonalPaymentVoucher::find($id);

        //save payment cheque num and cheque amount
        $addPayment = new DnoPersonalPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

         $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

         return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);
    }

    //
    public function editPayablesDetail(Request $request, $id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $transactionList = DnoPersonalPaymentVoucher::find($id);

        //
        $getChequeNumbers = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //getParticular details
        $getParticulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        //amount
        $amount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount');
          
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

         return view('dno-personal-payables-detail', compact('user', 'transactionList', 'getChequeNumbers','sum'
        , 'getParticulars', 'sumCheque'));
    }

    //
    public function transactionList(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

         //
        $getTransactionLists = DnoPersonalPaymentVoucher::where('pv_id', NULL)->get()->toArray();

           //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = DnoPersonalPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');
        

        return view('dno-personal-transaction-list', compact('user', 'getTransactionLists', 'totalAmoutDue'));
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
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM dno_personal_payment_vouchers ORDER BY id DESC LIMIT 1');

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

        if($request->get('paymentMethod') == "Cash"){
            $accountName = $request->get('accountNameCash');
            $paidTo = $request->get('paidToCash');
            echo $paidTo;

        }else if($request->get('paymentMethod') == "Cheque"){
            $accountName = $request->get('accountName');

            $paidToCC = explode("-", $request->get('paidTo'));
            $paidTo = $paidToCC[1]; 
        }

    
        //check if invoice number already exists
        $target = DB::table(
                        'dno_personal_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...
              $addPaymentVoucher = new DnoPersonalPaymentVoucher([
                    'user_id'=>$user->id,
                    'paid_to'=>$paidTo,
                    'invoice_number'=>$request->get('invoiceNumber'),
                    'account_no'=>$request->get('accountNo'),
                    'account_name'=>$accountName,
                    'type_of_card'=>$request->get('typeOfCard'),
                    'voucher_ref_number'=>$uVoucher,
                    'issued_date'=>$request->get('issuedDate'),
                    
                    'amount'=>$request->get('amount'),
                    'amount_due'=>$request->get('amount'),
                    'particulars'=>$request->get('particulars'),
                    'method_of_payment'=>$request->get('paymentMethod'),
                    'prepared_by'=>$name,
                    'created_by'=>$name,
            ]);

            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;

            return redirect('dno-personal/edit-dno-personal-payables-detail/'.$insertedId);
        }else{
             return redirect('dno-personal/payment-voucher-form/')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    }
    
     //
    public function paymentVoucherForm(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        //getCreditCards
        $getCreditCards = DnoPersonalCreditCard::get()->toArray();


        return view('payment-voucher-form-dno-personal', compact('user', 'getCreditCards'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $id =  Auth::user()->id;
        $user = User::find($id);

        $acctName = "Alan Dino";

        $modName = "MARY MARGARET O. DINO";

        $payment ="Cash";

        //getTransaction
        $getTransactions = DnoPersonalPaymentVoucher::where('account_no', NULL)->where('account_name', $acctName)
        ->where('method_of_payment', $payment)->get()->toArray();
        
        //getTransaction
        $getModTransactions = DnoPersonalPaymentVoucher::where('account_no', NULL)->where('account_name', $modName)
        ->where('method_of_payment', $payment)->get()->toArray();
       

         //get total amount due
         $status = "FULLY PAID AND RELEASED";

         $totalAmountDue = DnoPersonalPaymentVoucher::where('account_no',  NULl)->where('account_name', $acctName)
         ->where('status' ,'!=', $status)->sum('amount_due');

         $totalAmountDueMod = DnoPersonalPaymentVoucher::where('account_no',  NULl)->where('account_name', $modName)
         ->where('status' ,'!=', $status)->sum('amount_due');

        return view('dno-personal', compact('user', 'getTransactions', 'totalAmountDue', 'getModTransactions', 'totalAmountDueMod'));
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


    //
    public function destroyCreditCard($id){
        $creditCard = DnoPersonalCreditCard::find($id);
        $creditCard->delete();
    }

    public function destroyTransactionList($id){
        $transactionList = DnoPersonalPaymentVoucher::find($id);
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
