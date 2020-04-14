<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF; 
use Session;
use Auth; 
use App\User;
use App\DnoPersonalPaymentVoucher;

class DnoPersonalController extends Controller
{

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

           //check if invoice number already exists
        $target = DB::table(
                        'dno_personal_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...
              $addPaymentVoucher = new DnoPersonalPaymentVoucher([
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

            return redirect('dno-personal/edit-dno-personal-payables-detail/'.$insertedId);
        }else{
             return redirect('dno-personal/payment-voucher-form/')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    }
    
     //
    public function paymentVoucherForm(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('payment-voucher-form-dno-personal', compact('user'));
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


        return view('dno-personal', compact('user'));
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
