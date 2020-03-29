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

class LoloPinoyGrillBranchesController extends Controller
{

    //  
    public function printRS($id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);

          //
        $rSlips = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', $id)->get()->toArray();


        $pdf = PDF::loadView('printRS', compact('requisitionSlip', 'rSlips'));

        return $pdf->download('lolo-pinoy-grill-branches-requisition-slip.pdf');

    }

    //
    public function requisitionSlipList(){
          $id =  Auth::user()->id;
        $user = User::find($id);

        $requisitionLists = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', NULL)->get()->toArray();

        return view('lolo-pinoy-grill-branches-all-lists', compact('user', 'requisitionLists'));
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
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        
        return view('add-new-lolo-pinoy-grill-branches-requisition-slip', compact('user', 'id'));
    }

    //
    public function requisitionSlip(){
          $id =  Auth::user()->id;
        $user = User::find($id);

        return view('lolo-pinoy-grill-branches-requisition-slip', compact('user'));
    }

    //
    public function printPayables($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $payableId = LoloPinoyGrillBranchesPaymentVoucher::find($id);

        $payablesVouchers = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->sum('amount_due');


          //
        $countAmount = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesLoloPinoyGrillBranches', compact('payableId', 'user', 'payablesVouchers', 'sum'));

        return $pdf->download('lolo-pinoy-grill-branches-payment-voucher.pdf');
    }   

    //
    public function viewPayableDetails($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewPaymentDetail = LoloPinoyGrillBranchesPaymentVoucher::find($id);

        //
        $getViewPaymentDetails = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('view-lolo-pinoy-grill-branches-payable-details', compact('user', 'viewPaymentDetail', 'getViewPaymentDetails'));
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
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        //
        $transactionList = LoloPinoyGrillBranchesPaymentVoucher::find($id);

          //
        $getChequeNumbers = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //total the cheque amount
        $tot = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');

         return view('lolo-pinoy-grill-branches-payables-detail', compact('user', 'transactionList', 'getChequeNumbers','tot'));
    }

    //
    public function transactionList(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         //
        $getTransactionLists = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', NULL)->get()->toArray();

           //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('lolo-pinoy-grill-branches-transaction-list', compact('user', 'getTransactionLists', 'totalAmoutDue'));
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
                'amount_due'=>$request->get('amountDue'),
                'prepared_by'=>$name,
                'created_by'=>$name,

            ]);

             $addPaymentVoucher->save();
             Session::flash('addSuccess', 'Successfully created.');

            return redirect('lolo-pinoy-grill-branches/payment-voucher-form');
        }else{
             return redirect('lolo-pinoy-grill-branches/payment-voucher-form/')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    }


    //
    public function paymentVoucherForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('payment-voucher-form-lolo-pinoy-grill-branches', compact('user'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ids = Auth::user()->id;
        $user = User::find($ids);


        return view('lolo-pinoy-grill-branches', compact('user'));


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
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);

        //
        $rSlips = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', $id)->get()->toArray();
    

        return view('view-lolo-pinoy-grill-branches-requisition-slip', compact('user', 'requisitionSlip', 'rSlips'));

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
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);

        $rSlips = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', $id)->get()->toArray();

        //get users
        $getUsers = User::get()->toArray();
       

        return view('edit-lolo-pinoy-grill-branches-requisition-slip', compact('user', 'requisitionSlip', 'rSlips', 'getUsers'));

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
