<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF;
use Auth; 
use Session; 
use App\User;
use App\LoloPinoyGrillCommissaryDeliveryReceipt;
use App\LoloPinoyGrillCommissaryPurchaseOrder;
use App\LoloPinoyGrillCommissaryBillingStatement;
use App\LoloPinoyGrillCommissaryPaymentVoucher;
use App\LoloPinoyGrillCommissarySalesInvoice;
use App\LoloPinoyGrillCommissaryStatementOfAccount;
use App\LoloPinoyGrillCommissaryRawMaterial;

class LoloPinoyGrillCommissaryController extends Controller
{

    //
    public function production(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('commissary-production-lolo-pinoy-grill', compact('user'));
    }

    //
    public function printPayables($id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $payableId = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        $payablesVouchers = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryPaymentVoucher::where('id', $id)->sum('amount_due');


          //
        $countAmount = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesLoloPinoyGrillCommissary', compact('payableId', 'user', 'payablesVouchers', 'sum'));

        return $pdf->download('lolo-pinoy-grill-commissary-payment-voucher.pdf');
    }

    //
    public function printSOA($id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $Soa = LoloPinoyGrillCommissaryBillingStatement::find($id);

        $statementAccounts = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->sum('paid_amount');


          //
        $countAmount = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->sum('paid_amount');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printSOA-lolo-pinoy-grill', compact('Soa', 'user', 'statementAccounts', 'sum'));

        return $pdf->download('lolo-pinoy-grill-statement-of-account.pdf');
    }

    //
    public function sAccountUpdate(Request $request, $id){
         $accountPaid = LoloPinoyGrillCommissaryBillingStatement::find($id);
        
        $accountPaid->paid_amount = $request->get('paidAmount');
        $accountPaid->status = $request->get('status');
        $accountPaid->collection_date = $request->get('collectionDate');
        $accountPaid->check_number = $request->get('chequeNumber');
        $accountPaid->check_amount = $request->get('chequeAmount');
        $accountPaid->or_number = $request->get('orNumber');
        $accountPaid->payment_method = $request->get('paymentMethod');

        $accountPaid->save();

        Session::flash('sAccountUpdate', 'SOA updated.');

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-statement-of-account/'.$request->get('soaId'));
    }

    //
    public function inventoryStockUpdate(Request $request, $id){
        $updateInventoryStock = LoloPinoyGrillCommissaryRawMaterial::find($id);

        $updateInventoryStock->date = $request->get('date');
        $updateInventoryStock->reference_no = $request->get('referenceNumber');
        $updateInventoryStock->description  =$request->get('description');
        $updateInventoryStock->item = $request->get('item');
        $updateInventoryStock->qty = $request->get('qty');
        $updateInventoryStock->unit = $request->get('unit');
        $updateInventoryStock->amount = $request->get('amount');
        $updateInventoryStock->status = $request->get('status');
        $updateInventoryStock->requesting_branch = $request->get('requestingBranch');
        $updateInventoryStock->cheque_no_issued = $request->get('chequeNoIssued');
        $updateInventoryStock->remarks = $request->get('remarks');

        $updateInventoryStock->save();

        Session::flash('viewInventoryOfStocks', 'Successfully updated.');

        return redirect('lolo-pinoy-grill-commissary/view-inventory-of-stocks/'.$request->get('iSId'));
    }

    //
    public function viewInventoryOfStocks($id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewStockDetail = LoloPinoyGrillCommissaryRawMaterial::find($id);

        //transaction table
        $getViewStockDetails = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', $id)->get()->toArray();

      

        return view('view-lolo-pinoy-grill-commissary-inventory-stock', compact('user', 'viewStockDetail', 'getViewStockDetails'));
    }

    //
    public function inventoryOfStocks(){
          $ids = Auth::user()->id;    
        $user = User::find($ids);

         //getRawMaterial
        $getRawMaterials = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

        //count the total stock out amount value
        $countStockAmount = LoloPinoyGrillCommissaryRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', NULL)->sum('amount');
        
        return view('commissary-inventory-of-stocks-lolo-pinoy-grill', compact('user', 'getRawMaterials', 'countStockAmount', 'countTotalAmount'));
    }

    //
    public function viewPayableDetails($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewPaymentDetail = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        //
        $getViewPaymentDetails = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('view-lolo-pinoy-grill-payable-details', compact('user', 'viewPaymentDetail', 'getViewPaymentDetails'));
    }

    //
    public function accept(Request $request, $id){
         //get the status 
        $status = $request->get('status');
        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                    $payables = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
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

        $paymentData = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        //save payment cheque num and cheque amount
        $addPayment = new LoloPinoyGrillCommissaryPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

        $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$id);
    }

    //
    public function editPayablesDetail(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        //
        $transactionList = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        //
        $getChequeNumbers = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //getParticular details
        $getParticulars = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      

        //amount
        $amount1 = LoloPinoyGrillCommissaryPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;

        $chequeAmount1 = LoloPinoyGrillCommissaryPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
          
         return view('lolo-pinoy-grill-payables-detail', compact('user', 'transactionList', 'getChequeNumbers',
             'getParticulars', 'sum', 'sumCheque'));
    }

    //
    public function transactionList(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         //
        $getTransactionLists = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', NULL)->get()->toArray();

        //get total amount due
        $status = "FULLY PAID AND RELEASED";
    
        $totalAmoutDue = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');
        
        return view('lolo-pinoy-grill-commissary-transaction-list', compact('user', 'getTransactionLists', 'totalAmoutDue'));

    }

    //
    public function commissaryDeliveryOutlet(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $getDeliveryOutlets = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', '!=', NULL)->get()->toArray();

        return view('commissary-delivery-outlet-lolo-pinoy-grill', compact('user', 'getDeliveryOutlets'));
    }

    //
    public function viewStockInventory($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewStockDetail = LoloPinoyGrillCommissaryRawMaterial::find($id);

        //transaction table
        $getViewStockDetails = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', $id)->get()->toArray();

        return view('view-lolo-pinoy-grill-stock-inventory', compact('user', 'viewStockDetail', 'getViewStockDetails'));
    }

    //
    public function requestStockOut(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $requestStockOut = LoloPinoyGrillCommissaryRawMaterial::find($id);

        $qty = $request->get('qty');

        //compute qty times unit price
        $compute  = $qty * $requestStockOut->unit_price;
        $sum = $compute;

          //get date today
        $getDateToday =  date('Y-m-d');

         $addRequestStockOut = new LoloPinoyGrillCommissaryRawMaterial([
            'user_id'=>$user->id,
            'rm_id'=>$id,
            'product_id_no'=>$request->get('productId'),
            'description'=>$request->get('description'),
            'date'=>$getDateToday,
            'item'=>$requestStockOut->product_name,
            'reference_no'=>$request->get('referenceNum'),
            'qty'=>$qty,
            'unit'=>$requestStockOut->unit,
            'amount'=>$sum,
            'status'=>$request->get('status'),
            'cheque_no_issued'=>$request->get('chequeNo'),
            'requesting_branch'=>$request->get('requestingBranch'),
            'created_by'=>$name,
        ]);

        $addRequestStockOut->save();

         Session::flash('requestStockOut', 'Request Stock Out Successfully Added');

         return redirect('lolo-pinoy-grill-commissary/raw-material/request-stock-out/'.$id);

    }

    //
    public function rawMaterialRequestStockOut($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $getRequestStock = LoloPinoyGrillCommissaryRawMaterial::find($id);

        return view('request-stock-out-raw-material-lolo-pinoy-grill', compact('user', 'getRequestStock', 'id'));
    }


    //
    public function addDeliveryInRawMaterial(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $rawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($id);

        $qty = $request->get('qty');

         //compute qty times unit price
        $compute  = $qty * $rawMaterial->unit_price;
        $sum = $compute;

          //get date today
        $getDateToday =  date('Y-m-d');

        $addDeliveryIn = new LoloPinoyGrillCommissaryRawMaterial([
            'user_id'=>$user->id,
            'rm_id'=>$id,
            'product_id_no'=>$request->get('productId'),
            'description'=>$request->get('description'),
            'date'=>$getDateToday,
            'item'=>$rawMaterial->product_name,
            'reference_no'=>$request->get('referenceNum'),
            'qty'=>$qty,
            'unit'=>$rawMaterial->unit,
            'amount'=>$sum,
            'status'=>$request->get('status'),
            'cheque_no_issued'=>$request->get('chequeNo'),
            'created_by'=>$name,
        ]);

        $addDeliveryIn->save();

         Session::flash('addDeliveryIn', 'Delivery In Successfully Added');

         return redirect('lolo-pinoy-grill-commissary/raw-material/add-delivery-in/'.$id);



    }

    //
    public function rawMaterialAddDeliveryIn($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $getRawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($id);

        return view('add-delivery-in-raw-material-lolo-pinoy-grill', compact('user', 'getRawMaterial', 'id'));
    }

    //
    public function viewRawMaterialDetails($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewRawDetail = LoloPinoyGrillCommissaryRawMaterial::find($id);

        //transaction table
        $getViewRawDetails = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', $id)->get()->toArray();
        
        return view('view-lolo-pinoy-grill-raw-material-details', compact('user', 'viewRawDetail', 'getViewRawDetails'));
    }

    //
    public function stocksInventory(){
          $ids = Auth::user()->id;
        $user = User::find($ids);

    
        //getRawMaterial
        $getRawMaterials = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

        //count the total stock out amount value
        $countStockAmount = LoloPinoyGrillCommissaryRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryRawMaterial::all()->sum('amount');

        return view('commissary-stocks-inventory-lolo-pinoy-grill', compact('user', 'getRawMaterials', 'countStockAmount', 'countTotalAmount'));
    }

    //
    public function updateRawMaterial(Request $request, $id){
        $updateRawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($id);

        $updateRawMaterial->branch = $request->get('branch');
        $updateRawMaterial->product_name = $request->get('productName');
        $updateRawMaterial->unit_price = $request->get('unitPrice');
        $updateRawMaterial->unit = $request->get('unit');
        $updateRawMaterial->in = $request->get('in');
        $updateRawMaterial->out = $request->get('out');
        $updateRawMaterial->stock_amount = $request->get('stockAmount');
        $updateRawMaterial->remaining_stock = $request->get('remainingStock');
        $updateRawMaterial->amount = $request->get('amount');
        $updateRawMaterial->supplier = $request->get('supplier');

        $updateRawMaterial->save();

         Session::flash('successRawMaterial', 'Successfully updated');

        return redirect('lolo-pinoy-grill-commissary/commissary/edit-raw-materials/'.$id);
    }

    //
    public function editRawMaterials($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $getRawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($id);

        return view('edit-lolo-pinoy-grill-commissary-raw-material', compact('user', 'getRawMaterial'));
    }

    //
    public function addRawMaterial(Request $request){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //validate
        $this->validate($request,[
            'productName' =>'required',
        ]);


         //get the latest insert id query in table commissary RAW material product id no
        $dataProductId = DB::select('SELECT id, product_id_no FROM lolo_pinoy_grill_commissary_raw_materials ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 product id no
        if(isset($dataProductId[0]->product_id_no) != 0){
            //if code is not 0
            $newProd = $dataProductId[0]->product_id_no +1;
            $uProd = sprintf("%06d",$newProd);   

        }else{
            //if code is 0 
            $newProd = 1;
            $uProd = sprintf("%06d",$newProd);
        } 

        $addNewRawMaterial = new LoloPinoyGrillCommissaryRawMaterial([
            'user_id'=>$user->id,
            'branch'=>$request->get('branch'),
            'product_id_no'=>$uProd,
            'product_name'=>$request->get('productName'),
            'unit_price'=>$request->get('unitPrice'),
            'unit'=>$request->get('unit'),
            'in'=>$request->get('in'),
            'out'=>$request->get('out'),
            'stock_amount'=>$request->get('stockAmount'),
            'remaining_stock'=>$request->get('remainingStock'),
            'amount'=>$request->get('amount'),
            'supplier'=>$request->get('supplier'),
            'created_by'=>$name,

        ]);

        $addNewRawMaterial->save();

        Session::flash('addRawMaterial', 'Successfully added.');

        return redirect('lolo-pinoy-grill-commissary/commissary/create-raw-materials');


    }

    //
    public function createRawMaterials(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('commissary-add-raw-materials-lolo-pinoy-grill', compact('user'));
    }

    //
    public function rawMaterials(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $getRawMaterials = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

        return view('commissary-raw-materials-lolo-pinoy-grill', compact('user', 'getRawMaterials'));
    }

    //
    public function viewStatementAccount($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //viewStatementAccount
        $viewStatementAccount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->get()->toArray();
       
        
        $statementAccounts = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->get();


        //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->sum('amount');

          //
        $countAmount = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


         //count the total balance if there are paid amount
        $paidAmountCount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->sum('paid_amount');
       
        //
        $countAmountOthersPaid = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');
        
        $compute  = $paidAmountCount + $countAmountOthersPaid;


        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('view-lolo-pinoy-grill-statement-account', compact('user','viewStatementAccount', 'statementAccounts', 'sum', 'computeAll'));
    }

    //
    public function statementOfAccountList(){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        /*$status = "Unpaid";
        $paid = "Paid";

        //get statement of account 
        $statementOfAccounts = LoloPinoyGrillCommissaryStatementOfAccount::where('soa_id', NULL)->where('status', $status)->get()->toArray();

        $statementOfAccountPaids = LoloPinoyGrillCommissaryStatementOfAccount::where('soa_id', NULL)->where('status', $paid)->get()->toArray();*/
         $statementOfAccounts = LoloPinoyGrillCommissaryBillingStatement::where('bill_to', '!=', NULL)->get()->toArray();


        return view('lolo-pinoy-grill-statement-of-account-lists', compact('user', 'statementOfAccounts', 'statementOfAccountPaids'));
    }

  

    //
    public function editStatementOfAccount($id){
         $ids =  Auth::user()->id;
        $user = User::find($ids);


         //getStatementOfAccount
        $getStatementOfAccount = LoloPinoyGrillCommissaryBillingStatement::find($id);

        $sAccounts = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->get()->toArray();

         //AllAcounts not yet paid
       $allAccounts = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->where('status', NULL)->get()->toArray();

    
       $stat = "PAID";

       $allAccountsPaids = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->where('status', $stat)->get()->toArray();  

        //$sAccounts = LechonDeCebuStatementOfAccount::where('soa_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->sum('amount');

          //
        $countAmount = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        //count the total balance if there are paid amount
        $paidAmountCount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->sum('paid_amount');
       
        //
        $countAmountOthersPaid = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');
        
        $compute  = $paidAmountCount + $countAmountOthersPaid;


        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;
        
        return view('edit-lolo-pinoy-grill-statement-of-account', compact('user', 'getStatementOfAccount', 'sAccounts', 'allAccounts', 'allAccountsPaids', 'sum', 'computeAll'));
    }

    //store statement of account
    public function storeStatementAccount(Request $request){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName." ".$lastName;

         //validate
        $this->validate($request, [
            'date' =>'required',
            'kilos'=>'required',
            'amount'=>'required',

        ]);

         //get the latest insert id query in table statement of account invoice number
        $invoiceNumber = DB::select('SELECT id, invoice_number FROM lolo_pinoy_grill_commissary_statement_of_accounts ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 reference number
        if(isset($invoiceNumber[0]->invoice_number) != 0){
            //if code is not 0
            $newInvoice = $invoiceNumber[0]->invoice_number +1;
            $uInvoice = sprintf("%06d",$newInvoice);   

        }else{
            //if code is 0 
            $newInvoice = 1;
            $uInvoice = sprintf("%06d",$newInvoice);
        } 

        $addStatementAccount = new LoloPinoyGrillCommissaryStatementOfAccount([
            'user_id'=>$user->id,
            'date'=>$request->get('date'),
            'branch'=>$request->get('branch'),
            'invoice_number'=>$uInvoice,
            'kilos'=>$request->get('kilos'),
            'unit_price'=>$request->get('unitPrice'),
            'payment_method'=>$request->get('paymentMethod'),
            'amount'=>$request->get('amount'),
            'status'=>$request->get('status'),
            'paid_amount'=>$request->get('paidAmount'),
            'collection_date'=>$request->get('collectionDate'),
            'check_number'=>$request->get('checkNumber'),
            'check_amount'=>$request->get('checkAmount'),
            'or_number'=>$request->get('orNumber'),
            'created_by'=>$name,
        ]);

        $addStatementAccount->save();

        $insertedId = $addStatementAccount->id;

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-statement-of-account/'.$insertedId);

    }


    //
    public function viewSalesInvoice($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         $viewSalesInvoice = LoloPinoyGrillCommissarySalesInvoice::find($id);

        $salesInvoices = LoloPinoyGrillCommissarySalesInvoice::where('si_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissarySalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = LoloPinoyGrillCommissarySalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-lolo-pinoy-grill-sales-invoice', compact('user', 'viewSalesInvoice', 'salesInvoices', 'sum'));
    }

    //
    public function updateSi(Request $request, $id){
        $updateSi = LoloPinoyGrillCommissarySalesInvoice::find($id);

          //kls
        $kls  = $request->get('totalKls');

         //compute kls * unit price
        $unitPrice = $updateSi->unit_price;
        $compute = $kls * $unitPrice;
        $sum = $compute;

        $updateSi->qty = $request->get('qty');
        $updateSi->total_kls = $kls;
        $updateSi->item_description = $request->get('itemDescription');
        $updateSi->unit_price = $unitPrice;
        $updateSi->amount = $sum;

        $updateSi->save();

        Session::flash('SuccessEdit', 'Successfully updated');

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-sales-invoice/'.$request->get('siId'));
    }

    //add new sales invoice
    public function addNewSalesInvoiceData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //get date today
        $getDateToday =  date('Y-m-d');

        //kls
        $kls  = $request->get('totalKls');

         //compute kls * unit price
        $unitPrice = 500;
        $compute = $kls * $unitPrice;
        $sum = $compute;

         $addNewSalesInvoice = new LoloPinoyGrillCommissarySalesInvoice([
            'user_id'=>$user->id,
            'si_id'=>$id,
            'date'=>$getDateToday,
            'qty'=>$request->get('qty'),
            'total_kls'=>$kls,
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'created_by'=>$name,
        ]);

        $addNewSalesInvoice->save();
        Session::flash('addSalesInvoiceSuccess', 'Successfully added.');

        return redirect('lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-sales-invoice/'.$id);
    }

    //add new sales invoice
    public function addNewSalesInvoice($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
    

        return view('add-new-lolo-pinoy-grill-sales-invoice', compact('user', 'id'));
    }

    //
    public function updateSalesInvoice(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $updateSalesInvoice = LoloPinoyGrillCommissarySalesInvoice::find($id);

          //kls
        $kls  = $request->get('totalKls');

         //compute kls * unit price
        $unitPrice = $updateSalesInvoice->unit_price;
        $compute = $kls * $unitPrice;
        $sum = $compute;

        $updateSalesInvoice->invoice_number = $request->get('invoiceNum');
        $updateSalesInvoice->ordered_by = $request->get('orderedBy');
        $updateSalesInvoice->address = $request->get('address');
        $updateSalesInvoice->qty = $request->get('qty');
        $updateSalesInvoice->total_kls = $kls;
        $updateSalesInvoice->item_description = $request->get('itemDescription');
        $updateSalesInvoice->amount = $sum;
        $updateSalesInvoice->created_by = $name; 

        $updateSalesInvoice->save();

         Session::flash('updateSuccessfull', 'Successfully updated');

         return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-sales-invoice/'.$id);
    }


    //edit sales invoice
    public function editSalesInvoice($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

         //getSalesInvoice
        $getSalesInvoice = LoloPinoyGrillCommissarySalesInvoice::find($id);

        $sInvoices  = LoloPinoyGrillCommissarySalesInvoice::where('si_id', $id)->get()->toArray();

        return view('edit-lolo-pinoy-grill-sales-invoice', compact('user', 'getSalesInvoice', 'sInvoices'));
    }

    //store sales invoice
    public function storeSalesInvoice(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //validate
        $this->validate($request, [
            'invoiceNum' =>'required',
            'orderedBy'=>'required',
           
        ]);

         //get date today
        $getDateToday =  date('Y-m-d');

        //total kls
        $kls = $request->get('totalKls');

        //compute kls * unit price
        $unitPrice = 500;
        $compute = $kls * $unitPrice;
        $sum = $compute;

        $addSalesInvoice = new LoloPinoyGrillCommissarySalesInvoice([
            'user_id'=>$user->id,
            'invoice_number'=>$request->get('invoiceNum'),
            'ordered_by'=>$request->get('orderedBy'),
            'address'=>$request->get('address'),
            'date'=>$getDateToday,
            'qty'=>$request->get('qty'),
            'total_kls'=>$kls,
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'created_by'=>$name,
        ]);

        $addSalesInvoice->save();

        $insertedId = $addSalesInvoice->id;

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-sales-invoice/'.$insertedId);
    }

    //sales invoice
    public function salesInvoiceForm(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('lolo-pinoy-grill-sales-invoice-form', compact('user'));
    }

    //view payment voucher
    public function viewPaymentVoucher($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

         //paymentVoucher
        $paymentVoucher = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        $pVouchers = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->get()->toArray();


         //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryPaymentVoucher::where('id', $id)->sum('amount');

        //
        $countAmount = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-payment-voucher-lolo-pinoy-grill', compact('user', 'paymentVoucher', 'pVouchers', 'sum'));
    }

    //cheque vouchers
    public function chequeVouchers(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getAllChequeVouchers
        $method = "Cheque";

        $getAllChequeVouchers = LoloPinoyGrillCommissaryPaymentVoucher::where('method_of_payment', $method)->get()->toArray(); 

        return view('cheque-vouchers-lists-lolo-pinoy-grill', compact('user', 'getAllChequeVouchers')); 
    }

    //cash vouchers
    public function cashVouchers(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        //getAllCashVouchers
        $method = "Cash";

        $getAllCashVouchers = LoloPinoyGrillCommissaryPaymentVoucher::where('method_of_payment', $method)->get()->toArray();

        return view('cash-vouchers-list-lolo-pinoy-grill', compact('user', 'getAllCashVouchers'));
    }  

    //
    public function updatePV(Request $request, $id){
        $updatePV = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        $updatePV->particulars = $request->get('particulars');
        $updatePV->amount = $request->get('amount');

        $updatePV->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payment-voucher/'.$request->get('pvId'));
    }

    //
    public function addNewPaymentVoucherData(Request $request, $id){

        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentVoucher = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        $addNewPaymentVoucherData = new LoloPinoyGrillCommissaryPaymentVoucher([
             'user_id'=>$user->id,
            'pv_id'=>$id,
            'reference_number'=>$paymentVoucher['reference_number'],
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewPaymentVoucherData->save();

        Session::flash('addPaymentVoucherSuccess', 'Successfully added.');

        return redirect('lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-payment-voucher/'.$id);
    }


    //
    public function addNewPaymentVoucher($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-lolo-pinoy-grill-payment-voucher', compact('user', 'id'));
    }   

    //
    public function updatePaymentVoucher(Request $request, $id){
        $updatePaymentVoucher = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        $updatePaymentVoucher->paid_to = $request->get('paidTo');
        $updatePaymentVoucher->account_no = $request->get('accountNum');
        $updatePaymentVoucher->date = $request->get('date');
        $updatePaymentVoucher->particulars = $request->get('particulars');
        $updatePaymentVoucher->amount = $request->get('amount');
        $updatePaymentVoucher->method_of_payment = $request->get('methodOfPayment');

        $updatePaymentVoucher->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payment-voucher/'.$id);
    }

    //edit payment voucher
    public function editPaymentVoucher($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         //getPaymentVoucher 
        $getPaymentVoucher = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        //pVoucher
        $pVouchers = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('edit-payment-voucher-lolo-pinoy-grill', compact('user', 'getPaymentVoucher', 'pVouchers'));
    }

    //
    public function addParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = LoloPinoyGrillCommissaryPaymentVoucher::find($id);
       
       //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');
    
        $addParticulars = new LoloPinoyGrillCommissaryPaymentVoucher([
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

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$id);

    }

    //store payment voucher 
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
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM lolo_pinoy_grill_commissary_payment_vouchers ORDER BY id DESC LIMIT 1');

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
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();
        if ($target === NULL) {
            # code...

            $addPaymentVoucher = new LoloPinoyGrillCommissaryPaymentVoucher([
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
            
            return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payables-detail/'.$insertedId);

        }else{
             return redirect('lolo-pinoy-grill-commissary/payment-voucher-form/')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    }   


    //payment vouceher form
    public function paymentVoucherForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('payment-voucher-form-lolo-pinoy-grill', compact('user'));
    }

    //view billing statement
    public function viewBillingStatement($id){

         $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewBillingStatement = LoloPinoyGrillCommissaryBillingStatement::find($id);

        $billingStatements = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-lolo-pinoy-grill-commissary-billing-statement', compact('user', 'viewBillingStatement', 'billingStatements', 'sum'));
    }


    //billingStatementLists
    public function billingStatementLists(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingStatements = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', NULL)->get()->toArray();


        return view('lolo-pinoy-grill-commissary-billing-statement-lists', compact('user', 'billingStatements'));
    }

    //updateBillingStatement
    public function updateBillingStatement(Request $request, $id){
        $updateBilling = LoloPinoyGrillCommissaryBillingStatement::find($id);


        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500;

        $updateBilling->date_of_transaction = $request->get('transactionDate');
        $updateBilling->whole_lechon = $wholeLechon;
        $updateBilling->description = $request->get('description');
        $updateBilling->invoice_number = $request->get('invoiceNumber');
        $updateBilling->amount = $add;

        $updateBilling->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-billing-statement/'
            .$request->get('billingStatementId'));


    }

    //add new billing statement data
    public function addNewBillingData(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = LoloPinoyGrillCommissaryBillingStatement::find($id);

         $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        //get the whole lechon then multiply by 500
        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $addNewBillingStatement = new LoloPinoyGrillCommissaryBillingStatement([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'reference_number'=>$billingOrder['reference_number'],
            'p_o_number'=>$billingOrder['p_o_number'],
            'date_of_transaction'=>$request->get('transactionDate'),
            'invoice_number'=>$request->get('invoiceNumber'),
            'whole_lechon'=>$wholeLechon,
            'description'=>$request->get('description'),
            'amount'=>$add,
            'created_by'=>$name,
        ]);

        $addNewBillingStatement->save();

         Session::flash('addBillingSuccess', 'Successfully added.');

         return redirect('lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-billing-statement/'.$id);
    
    }

    //add new billing statement
    public function addNewBillingStatement($id){
         $ids =  Auth::user()->id;
        $user = User::find($ids);


        return view('add-new-lolo-pinoy-grill-billing-statement', compact('user', 'id'));
    }

    //update billing statement
    public function updateBillingInfo(Request $request, $id){
         $updateBillingOrder = LoloPinoyGrillCommissaryBillingStatement::find($id);

          $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $updateBillingOrder->bill_to = $request->get('billTo');
        $updateBillingOrder->address = $request->get('address');
        $updateBillingOrder->period_cover = $request->get('periodCovered');
        $updateBillingOrder->date = $request->get('date');
        $updateBillingOrder->terms = $request->get('terms');
        $updateBillingOrder->p_o_number = $request->get('poNumber');
        $updateBillingOrder->invoice_number = $request->get('invoiceNumber');
        $updateBillingOrder->date_of_transaction = $request->get('transactionDate');
        $updateBillingOrder->whole_lechon = $wholeLechon;
        $updateBillingOrder->description = $request->get('description');
        $updateBillingOrder->amount = $add;

        $updateBillingOrder->save();
        
        Session::flash('SuccessE', 'Successfully updated');

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-billing-statement/'.$id);

    }

    //edit billing statement
    public function editBillingStatement($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

         $billingStatement = LoloPinoyGrillCommissaryBillingStatement::find($id);

          $bStatements = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //get the purchase order lists
        $getPurchaseOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('edit-lolo-pinoy-grill-commissary-billing-statement', compact('user', 'billingStatement', 'getPurchaseOrders', 'bStatements'));
    }

    //store billing statement form
    public function storeBillingStatement(Request $request){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName.$lastName;

          //validate
        $this->validate($request, [
            'billTo' =>'required',
            'address'=>'required',
            'periodCovered'=>'required',
            'date'=>'required',
            'terms'=>'required',
            'transactionDate'=>'required',
            'wholeLechon'=>'required',
            'description'=>'required',
        ]);

         $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

         //get the latest insert id query in table billing statements ref number
        $dataReferenceNum = DB::select('SELECT id, reference_number FROM lolo_pinoy_grill_commissary_billing_statements ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataReferenceNum[0]->reference_number) != 0){
            //if code is not 0
            $newRefNum = $dataReferenceNum[0]->reference_number +1;
            $uRef = sprintf("%06d",$newRefNum);   

        }else{
            //if code is 0 
            $newRefNum = 1;
            $uRef = sprintf("%06d",$newRefNum);
        } 

        $billingStatement = new LoloPinoyGrillCommissaryBillingStatement([
            'user_id'=>$user->id,
            'bill_to'=>$request->get('billTo'),
            'address'=>$request->get('address'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'invoice_number'=>$request->get('invoiceNumber'),
            'reference_number'=>$uRef,
            'p_o_number'=>$request->get('poNumber'),
            'terms'=>$request->get('terms'),
            'date_of_transaction'=>$request->get('transactionDate'),
            'whole_lechon'=>$wholeLechon,
            'description'=>$request->get('description'),
            'amount'=>$add,
            'created_by'=>$name,
            'prepared_by'=>$name,

        ]);

        $billingStatement->save();

        $insertedId = $billingStatement->id;

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-billing-statement/'.$insertedId);

    }

    //billing statement form
    public function billingStatementForm(){
        $id =  Auth::user()->id;
        $user = User::find($id);

          //get the purchase order lists
        $getPurchaseOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('lolo-pinoy-grill-commissary-billing-statement-form', compact('user', 'getPurchaseOrders'));
    }

    
    //purchase order lists
    public function purchaseOrderAllLists(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        $purchaseOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('lolo-pinoy-grill-commissary-purchase-order-lists', compact('user', 'purchaseOrders'));
    }

    //updatePO 
    public function updatePo(Request $request, $id){
        $order = LoloPinoyGrillCommissaryPurchaseOrder::find($id);

        $order->quantity = $request->get('quantity');
        $order->description = $request->get('description');
        $order->unit_price = $request->get('unitPrice');
        $order->amount = $request->get('amount');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/'.$request->get('poId'));
    }

    //store add new purchase order
    public function addNewPurchaseOrder(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $pO = LoloPinoyGrillCommissaryPurchaseOrder::find($id);

        $addNewPurchaseOrder = new LoloPinoyGrillCommissaryPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'total_price'=>$request->get('amount'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $addNewPurchaseOrder->save();

        Session::flash('purchaseOrderSuccess', 'Successfully added purchase order');


        return redirect('lolo-pinoy-grill-commissary/add-new/'.$id);
    }

    //add new purchase order
    public function addNew(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        return view('add-new-lolo-pinoy-grill-purchase-order', compact('user', 'id'));

    }

    //purchase order
    public function purchaseOrder(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('lolo-pinoy-grill-commissary-purchase-order', compact('user'));
    }


    //printDelivery
    public function printDelivery($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $deliveryId = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

        $deliveryReceipts = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->get()->toArray();

          //count the total unit price
        $countTotalUnitPrice = LoloPinoyGrillCommissaryDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = LoloPinoyGrillCommissaryDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('lolo-pinoy-grill-printDelivery', compact('deliveryId', 'user', 'deliveryReceipts', 'sum2'));

        return $pdf->download('lolo-pinoy-grill-commissary-delivery-receipt.pdf');
    }

    //view delivery receipt
    public function viewDeliveryReceipt($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewDeliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

        $deliveryReceipts = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->get()->toArray();

         //count the total unit price
        $countTotalUnitPrice = LoloPinoyGrillCommissaryDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = LoloPinoyGrillCommissaryDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        return view('view-lolo-pinoy-grill-commissary-delivery-receipt', compact('user', 'viewDeliveryReceipt', 'deliveryReceipts', 'countUnit', 'sum', 'sum2'));
    }

    //delivery lists
    public function deliveryReceiptList(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         //getAllDeliveryReceipt
        $getAllDeliveryReceipts = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', NULL)->get()->toArray();


        return view('lolo-pinoy-grill-commissary-delivery-receipt-list', compact('user', 'getAllDeliveryReceipts'));
    }

    //updateDr
    public function updateDr(Request $request, $id){
        $delivery = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $delivery->product_id = $request->get('productId');
        $delivery->qty = $qty;
        $delivery->unit = $request->get('unit');
        $delivery->item_description = $request->get('itemDescription');
        $delivery->unit_price = $unitPrice;
        $delivery->amount = $sum;

        $delivery->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$request->get('drId'));

    }

    //store add new 
    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $deliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

         //get date today
        $getDateToday =  date('Y-m-d');

        $addNewDeliveryReceipt = new LoloPinoyGrillCommissaryDeliveryReceipt([
            'user_id'=>$user->id,
            'dr_id'=>$id,
            'dr_no'=>$deliveryReceipt['dr_no'],
            'date'=>$getDateToday,
            'delivered_to'=>$request->get('deliveredTo'),
            'product_id'=>$request->get('productId'),
            'qty'=>$qty,
            'unit'=>$request->get('unit'),
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $addNewDeliveryReceipt->save();

        Session::flash('addDeliveryReceiptSuccess', 'Successfully added.');

         return redirect('lolo-pinoy-grill-commissary/add-new-lolo-pinoy-grill-delivery-receipt/'.$id);


    }

    //add new delivery receipt
    public function addNewDelivery($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

          //get Raw material
        $getRawMaterials = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

        return view('add-new-lolo-pinoy-grill-delivery-receipt', compact('user', 'id', 'getRawMaterials'));
    }

    //update delivery receipt
    public function updateDeliveryReceipt(Request $request, $id){
        $updateDeliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);


        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $updateDeliveryReceipt->delivered_to = $request->get('deliveredTo');
        $updateDeliveryReceipt->product_id  = $request->get('productId');
        $updateDeliveryReceipt->qty = $request->get('qty');
        $updateDeliveryReceipt->unit = $request->get('unit');
        $updateDeliveryReceipt->item_description = $request->get('itemDescription');
        $updateDeliveryReceipt->unit_price = $unitPrice;
        $updateDeliveryReceipt->address = $request->get('address');
        $updateDeliveryReceipt->amount = $sum;

        $updateDeliveryReceipt->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$id);
    }

    //edit delivery receipt
    public function editDeliveryReceipt($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         //getDeliveryReceipt
        $getDeliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);

          //get Raw material
        $getRawMaterials = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

         //dReceipts
        $dReceipts = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-lolo-pinoy-grill-commissary-delivery-receipt', compact('user','getDeliveryReceipt', 'dReceipts', 'getRawMaterials'));
    }

    //storeDeliveryReceipt
    public function storeDeliveryReceipt(Request $request){
          //validate
        $this->validate($request, [
            'deliveredTo' =>'required',
           
        ]);

         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

         //get the latest insert id query in table delivery receipt dr_no
        $dataDrNo = DB::select('SELECT id, dr_no FROM lolo_pinoy_grill_commissary_delivery_receipts ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 dr_no
        if(isset($dataDrNo[0]->dr_no) != 0){
            //if code is not 0
            $newDr = $dataDrNo[0]->dr_no +1;
            $uDr = sprintf("%06d",$newDr);   

        }else{
            //if code is 0 
            $newDr = 1;
            $uDr = sprintf("%06d",$newDr);
        } 

        //get date today
        $getDateToday =  date('Y-m-d');

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $storeDeliveryReceipt = new LoloPinoyGrillCommissaryDeliveryReceipt([
            'user_id'=>$user->id,            
            'dr_no'=>$uDr,
            'date'=>$getDateToday,
            'delivered_to'=>$request->get('deliveredTo'),
            'product_id'=>$request->get('productId'),
            'qty'=>$qty,
            'unit'=>$request->get('unit'),
            'item_description'=>$request->get('itemDescription'),
            'address'=>$request->get('address'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $storeDeliveryReceipt->save();
        $insertedId  = $storeDeliveryReceipt->id;

         return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-delivery-receipt/'.$insertedId);


    }

    //delivery receipt
    public function deliveryReceiptForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //get Raw material
        $getRawMaterials = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

        return view('lolo-pinoy-grill-commissary-delivery-receipt-form', compact('user', 'getRawMaterials'));
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

        $getAllSalesInvoices = LoloPinoyGrillCommissarySalesInvoice::where('si_id', NULL)->get()->toArray();

        return view('lolo-pinoy-grill', compact('user', 'getAllSalesInvoices'));
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

        $name  = $firstName.$lastName;


        //
         $this->validate($request, [
            'paidTo' => 'required',
            'address'=> 'required',
            'quantity'=>'required',
            'description'=>'required',
            'unitPrice'=>'required',
            'amount'=>'required',
        ]);

          //get the latest insert id query in table purchase order
        $data = DB::select('SELECT id, p_o_number FROM lolo_pinoy_grill_commissary_purchase_orders ORDER BY id DESC LIMIT 1');
        
        //if code is not zero add plus 1
         if(isset($data[0]->p_o_number) != 0){
            //if code is not 0
            $newNum = $data[0]->p_o_number +1;
            $uNum = sprintf("%06d",$newNum);    
        }else{
            //if code is 0 
            $newNum = 1;
            $uNum = sprintf("%06d",$newNum);
        }

        $purchaseOrder = new LoloPinoyGrillCommissaryPurchaseOrder([
            'user_id' =>$user->id,
            'paid_to'=>$request->get('paidTo'),
            'address'=>$request->get('address'),
            'p_o_number'=>$uNum,
            'date'=>$request->get('date'),
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'total_price'=>$request->get('amount'),
            'requesting_branch'=>$request->get('requestingBranch'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $purchaseOrder->save();

         $insertedId = $purchaseOrder->id;
         
        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/'.$insertedId);

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
        $ids = Auth::user()->id;
        $user = User::find($ids);

         $purchaseOrder = LoloPinoyGrillCommissaryPurchaseOrder::find($id);

         $pOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', $id)->get()->toArray();


        return view('edit-lolo-pinoy-grill-commissary-purchase-order', compact('user', 'purchaseOrder', 'pOrders'));

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

        $name  = $firstName.$lastName;

        $paidTo = $request->get('paidTo');
        $address = $request->get('address');
        $quantity = $request->get('quantity');
        $description = $request->get('description');
        $date = $request->get('date');
        $unitPrice = $request->get('unitPrice');
        $amount = $request->get('amount');

        $purchaseOrder = LoloPinoyGrillCommissaryPurchaseOrder::find($id);
        
        $purchaseOrder->paid_to = $paidTo;
        $purchaseOrder->address = $address;
        $purchaseOrder->date = $date;
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->description = $description;
        $purchaseOrder->requesting_branch = $request->get('requestingBranch');
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-commissary-purchase-order/'.$id);

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
        $purchaseOrder = LoloPinoyGrillCommissaryPurchaseOrder::find($id);
        $purchaseOrder->delete();

    }

    public function destroyStatementAccount($id){
        $statementAccount = LoloPinoyGrillCommissaryStatementOfAccount::find($id);
        $statementAccount->delete();
    }       

    public function destroySalesInvoice($id){
        $salesInvoice = LoloPinoyGrillCommissarySalesInvoice::find($id);
        $salesInvoice->delete();
    }


    public function destroyPaymentVoucher($id){
        $paymentVoucher = LoloPinoyGrillCommissaryPaymentVoucher::find($id);
        $paymentVoucher->delete();
    }

    public function destroyBillingStatement($id){
        $billingStatement = LoloPinoyGrillCommissaryBillingStatement::find($id);
        $billingStatement->delete();
    }

    //destroy delivery receipt
    public function destroyDeliveryReceipt($id){
        $deliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);
        $deliveryReceipt->delete();
    }

    public function destroyRawMaterial($id){
         $rawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($id);
        $rawMaterial->delete();
    }

     public function destroyTransactionList($id){
        $transactionList = LoloPinoyGrillCommissaryPaymentVoucher::find($id);
        $transactionList->delete();
    }
}
