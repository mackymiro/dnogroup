<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
use PDF;
use App\User;
use App\DinoIndustrialCorporationPaymentVoucher; 


class DinoIndustrialCorporationController extends Controller
{
    public function accept(Request $request, $id){
          //get the status 
          $status = $request->get('status');
          if($status == "FULLY PAID AND RELEASED"){
              switch ($request->get('action')) {
                  case 'PAID AND RELEASE':
                      # code...
                      $payables = DinoIndustrialCorporationPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                      Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');
  
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
  
          }else if($status == "FOR APPROVAL"){
              switch ($request->get('action')) {
                  case 'PAID & HOLD':
                      # code...
                      $payables = DinoIndustrialCorporationPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                       Session::flash('payablesSuccess', 'Status set for approval.');
  
                       return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);
  
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
          }else{
  
              switch ($request->get('action')) {
                  case 'PAID & HOLD':
                      # code...
                      $payables = DinoIndustrialCorporationPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                      Session::flash('payablesSuccess', 'Status set for confirmation.');
  
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);
                      
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
          }  
    }

    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        $paymentData = DinoIndustrialCorporationPaymentVoucher::find($id);
         
        //save payment cheque num and cheque amount
         $addPayment = new DinoIndustrialCorporationPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,
        ]);

        $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

        return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);
    }

    public function addParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = DinoIndustrialCorporationPaymentVoucher::find($id);

        //add current amount
         $add = $particulars['amount_due'] + $request->get('amount');

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $addParticulars = new DinoIndustrialCorporationPaymentVoucher([
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

         return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$id]);

    }

    public function transactionList(){
        $getTransactionLists = DinoIndustrialCorporationPaymentVoucher::where('pv_id', NULL)->get()->toArray();

        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmountDue = DinoIndustrialCorporationPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('dino-industrial-transaction-list', compact('getTransactionLists', 'totalAmountDue'));

    }

    public function editPayablesDetail(Request $request, $id){
        $transactionList = DinoIndustrialCorporationPaymentVoucher::find($id);

        $getChequeNumbers = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //getParticular details
        $getParticulars = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
          //amount
        $amount1 = DinoIndustrialCorporationPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;

        $chequeAmount1 = DinoIndustrialCorporationPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DinoIndustrialCorporationPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('dino-industrial-payables-detail', compact('transactionList', 'getParticulars', 'sum' , 
        'getChequeNumbers', 'sumCheque'));
    }

    public function paymentVoucherStore(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the latest insert id query in table payment voucher ref number
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM dino_industrial_corporation_payment_vouchers ORDER BY id DESC LIMIT 1');
        
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
            'dino_industrial_corporation_payment_vouchers')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        if($target === NULL){
            $addPaymentVoucher = new DinoIndustrialCorporationPaymentVoucher([
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

            return redirect()->route('editPayablesDetailDinoIndustrial', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormDinoIndustrial')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');

        }

    }

    public function paymentVoucherForm(){
        
        return view('payment-voucher-form-dino-industrial-corp');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dino-industrial-corporation');
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