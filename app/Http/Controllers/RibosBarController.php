<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session;
use Auth;
use PDF; 
use App\User;
use App\RibosBarDeliveryReceipt;
use App\RibosBarPurchaseOrder;
use App\RibosBarPaymentVoucher;
use App\RibosBarSalesInvoice;
use App\RibosBarBillingStatement;
use App\RibosBarStatementOfAccount;
use App\RibosBarCashiersForm;
use App\RibosBarUtility;
use App\RibosBarRawMaterial;

class RibosBarController extends Controller
{

    public function inventoryStockUpdate(Request $request, $id){
        $updateInventoryStock = RibosBarRawMaterial::find($id);

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

        return redirect('ribos-bar/store-stock/view-inventory-of-stocks/'.$request->get('iSId'));
    }
    
    public function viewInventoryOfStocks($id){
        $viewStockDetail = RibosBarRawMaterial::find($id);
        
        //transaction table
        $getViewStockDetails = RibosBarRawMaterial::where('rm_id', $id)->get()->toArray();

        return view('ribos-bar-view-inventory-stock', compact('viewStockDetail', 'getViewStockDetails'));
    }

    public function inventoryOfStocks(){
        //getRawMaterial
        $getRawMaterials = RibosBarRawMaterial::where('rm_id', NULL)->get()->toArray();

        return view('ribos-bar-stocks-inventory', compact('getRawMaterials'));
    }

    public function viewStockInventory($id){
        $viewStockDetail = RibosBarRawMaterial::find($id);
        //transaction table
        $getViewStockDetails = RibosBarRawMaterial::where('rm_id', $id)->get()->toArray();

        return view('ribos-bar-view-stock-inventory', compact('viewStockDetail', 'getViewStockDetails'));
    }

    public function deliveryOutlet(){
        $getDeliveryOutlets = RibosBarRawMaterial::where('rm_id', '!=', NULL)->get()->toArray();
        return view('ribos-bar-delivery-outlet', compact('getDeliveryOutlets'));
    }

    public function stocksInventory(){
        //getRawMaterial
        $getRawMaterials = RibosBarRawMaterial::where('rm_id', NULL)->get()->toArray();
        
        return view('ribos-bar-store-stock-inventory', compact('getRawMaterials'));
    }

    public function addDeliveryIn(Request $request){

        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $rawMaterial = RibosBarRawMaterial::find($request->id);
      
        $qty = $request->qty;

         //compute qty times unit price
         $compute  = $qty * $rawMaterial->unit_price;
         $sum = $compute;

        //get date today
        $getDateToday =  date('Y-m-d');

        //condition if request stock out 
        if($request->rStockOut == "REQUEST STOCK OUT"){
            $requestingBranch  = $request->requestingBranch;
        }else{
            $requestingBranch = "NULL";
        }

        //check if the reference no is already exits
        $target =  DB::table(
                'ribos_bar_raw_materials')
                ->where('reference_no', $request->refNo)
                ->get()->first();
        if($target == NULL){
            $addDeliveryIn = new RibosBarRawMaterial([
                'user_id'=>$user->id,
                'rm_id'=>$request->id,
                'product_id_no'=>$request->productId,
                'description'=>$request->description,
                'date'=>$getDateToday,
                'item'=>$rawMaterial->product_name,
                'reference_no'=>$request->refNo,
                'qty'=>$request->qty,
                'unit'=>$rawMaterial->unit,
                'amount'=>$sum,
                'status'=>$request->status,
                'cheque_no_issued'=>$request->chequeNoIssued,
                'requesting_branch'=>$requestingBranch,
                'created_by'=>$name,
            ]);
    
            $addDeliveryIn->save();
    
            return response()->json('Success: successfull added a data');
        }else{
            return response()->json('Error: Reference no already exist.');
        }
       


    }

    public function viewRawMaterialDetails($id){
        $viewRawDetail = RibosBarRawMaterial::find($id);
        
        //transaction table
        $getViewRawDetails = RibosBarRawMaterial::where('rm_id', $id)->get()->toArray();

        return view('view-ribos-bar-raw-material-details', compact('viewRawDetail', 'getViewRawDetails'));
    }

    public function addRawMaterial(Request $request){   
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the latest insert id query in table commissary RAW material product id no
        $dataProductId = DB::select('SELECT id, product_id_no FROM ribos_bar_raw_materials ORDER BY id DESC LIMIT 1');

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

        //check if product name exists
        $target = DB::table(
                'ribos_bar_raw_materials')
                ->where('product_name', $request->prductName)
                ->get()->first();

        if($target == NULL){

            $addNewRawMaterial = new RibosBarRawMaterial([
                'user_id'=>$user->id,
                'branch'=>$request->branch,
                'product_id_no'=>$uProd,
                'product_name'=>$request->prductName,
                'unit_price'=>$request->unitPrice,
                'unit'=>$request->unit,
                'in'=>$request->inData,
                'out'=>$request->outData,
                'stock_amount'=>$request->stockOutAmount,
                'remaining_stock'=>$request->remainingStock,
                'amount'=>$request->amount,
                'supplier'=>$request->supplier,
                'created_by'=>$name,
    
            ]);
            $addNewRawMaterial->save();
            return response()->json('Success: successfully added a RAW Material');

        }else{
            return response()->json('Error: Product name already exist.');
        }
       


    }

    public function rawMaterials(){
        $getRawMaterials = RibosBarRawMaterial::where('rm_id', NULL)->get()->toArray();
        return view('ribos-bar-raw-materials', compact('getRawMaterials'));
    }

    public function viewPettyCash($id){ 
        $getPettyCash = RibosBarPaymentVoucher::find($id);

        $getPettyCashSummaries = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //total
        $totalPettyCash = RibosBarPaymentVoucher::where('id', $id)->where('pv_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = RibosBarPaymentVoucher::where('pv_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

          
        return view('ribos-bar-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
    }

  
    public function viewBills($id){
        
        $viewBill = RibosBarUtility::find($id);

        $viewParticulars = RibosBarPaymentVoucher::where('sub_category_account_id', $id)->get()->toArray();
 
      
        return view('ribos-bar-view-utility', compact('viewBill', 'viewParticulars'));
    }

  
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
                'ribos_bar_utilities')
                ->where('account_id', $request->accountIdInternet)
                ->get()->first();

        if($target ==  NULL){

            $addInternet = new RibosBarUtility([
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
            'ribos_bar_utilities')
            ->where('account_id', $request->accountId)
            ->get()->first();
        
        if($target == NULL){

            $addBills = new RibosBarUtility([
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

  
    public function utilities(){
        $flag = "Veco";
        $flagMCWD = "MCWD";
        $flagInternet = "Internet";

        $vecoDocuments = RibosBarUtility::where('flag', $flag)->get()->toArray();
        $mcwdDocuments = RibosBarUtility::where('flag', $flagMCWD)->get()->toArray();

        $internetDocuments = RibosBarUtility::where('flag', $flagInternet)->get()->toArray();


        return view('ribos-bar-utilities', compact('vecoDocuments', 'mcwdDocuments', 'internetDocuments'));
    }

 
    public function pettyCashList(){
        $cat = "Petty Cash";
        $getPettyCashLists = RibosBarPaymentVoucher::where('pv_id', NULL)->where('category',$cat)->get()->toArray();

        return view('ribos-bar-petty-cash-list', compact('getPettyCashLists'));
    }

   
    public function printPO($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $purchaseOrder = RibosBarPurchaseOrder::find($id);
        $pOrders = RibosBarPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = RibosBarPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = RibosBarPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        $pdf = PDF::loadView('printRibosBarPO', compact('purchaseOrder', 'pOrders', 'sum'));

        return $pdf->download('ribos-bar-purchase-order.pdf');
    }
    
    
    public function printCashiersReport($id){
      
        $cashiersId = RibosBarCashiersForm::find($id);

        $cashiersReports = RibosBarCashiersForm::where('cf_id', $id)->get()->toArray();

        $total = RibosBarCashiersForm::where('cf_id', $id)->sum('total');
    
        $pdf = PDF::loadView('printCashiersReport', compact('cashiersId', 'cashiersReports', 'total'));

        return $pdf->download('ribos-bar-cashiers-report.pdf');
    }

   
    public function updateItem(Request $request, $id){
        $updateItems = RibosBarCashiersForm::find($id);

        $updateItems->items = $request->get('items');
        $updateItems->opening_inventory = $request->get('openingInventory');
        $updateItems->sold = $request->get('sold');
        $updateItems->closing = $request->get('closing');
        $updateItems->total = $request->get('total');

        $updateItems->save();

        Session::flash('updateItemSucc', 'Successfully updated.');

        return redirect('ribos-bar/edit-cashiers-report-inventory-list/'.$request->get('cashiersId'));

    }


    public function  viewCashiersReportList($id){
    
        $getViewCashierReport = RibosBarCashiersForm::find($id);

        $getAllItems = RibosBarCashiersForm::where('cf_id', $id)->get()->toArray();

        $total = RibosBarCashiersForm::where('cf_id', $id)->sum('total');
        

        return view('view-ribos-bar-cashiers-report-list', compact('getViewCashierReport', 'getAllItems', 'total'));
    }

    public function cashiersInventoryList(){

        $getAllCashiersReports = RibosBarCashiersForm::where('cf_id', NULL)->get()->toArray();

        return view('ribos-bar-cashiers-repost-inventory-list', compact('getAllCashiersReports'));
    }


    public function  addCashiersList(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addCashiersList = new RibosBarCashiersForm([
            'user_id'=>$user->id,
            'cf_id'=>$id,
            'items'=>$request->get('items'),
            'opening_inventory'=>$request->get('openingInventory'),
            'sold'=>$request->get('sold'),
            'closing'=>$request->get('closing'),
            'total'=>$request->get('total'),
            'created_by'=>$name,
        ]);
        
        $addCashiersList->save();

        Session::flash('cashiersAddSuccess', 'Successfully added.');

        return redirect('ribos-bar/edit-cashiers-report-inventory-list/'.$id);

    
    }

   
    public function updateCashiersForm(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $updateCashiersReport = RibosBarCashiersForm::find($id);

        $updateCashiersReport->date = $request->get('date');
        $updateCashiersReport->cashier_name = $request->get('cashierName');
        $updateCashiersReport->bar_tender_name = $request->get('barTender');
        $updateCashiersReport->shifting_schedule = $request->get('shiftSchedule');
        $updateCashiersReport->starting_os = $request->get('startingOs');
        $updateCashiersReport->closing_os = $request->get('closingOs');
        $updateCashiersReport->cash_sales = $request->get('cashSales');
        $updateCashiersReport->credit_card_sales = $request->get('ccSales');
        $updateCashiersReport->signing_privilage_sales = $request->get('privilageSales');
        $updateCashiersReport->total_reading = $request->get('totalReading');
        $updateCashiersReport->created_by = $name;
        $updateCashiersReport->save();

        Session::flash('cashiersSuccess', 'Successfully updated.');

        return redirect('ribos-bar/edit-cashiers-report-inventory-list/'.$id);

    }

   
    public function editCashiersForm($id){
     
        $getCashiersReport = RibosBarCashiersForm::find($id);

        $getCashiersReportItems = RibosBarCashiersForm::where('cf_id',  $id)->get()->toArray();

        return view('edit-ribos-bar-cashier-form', compact('getCashiersReport', 'getCashiersReportItems'));
    }


    public function cashiersFormStore(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $cashiersForm = new RibosBarCashiersForm([
            'user_id'=>$user->id,
            'date'=>$request->get('date'),
            'cashier_name'=>$request->get('cashierName'),
            'bar_tender_name'=>$request->get('barTender'),
            'shifting_schedule'=>$request->get('shiftSchedule'),
            'starting_os'=>$request->get('startingOs'),
            'closing_os'=>$request->get('closingOs'),
            'created_by'=>$name,
        ]);

        $cashiersForm->save();
        $insertedId = $cashiersForm->id;

        return redirect('ribos-bar/edit-cashiers-report-inventory-list/'.$insertedId);
    }
    
    
    public function cashiersForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('ribos-bar-cashiers-form', compact('user'));
    }

   
    public function printPayablesRibosBar($id){
    
        $payableId = RibosBarPaymentVoucher::find($id);

        $payablesVouchers = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = RibosBarPaymentVoucher::where('id', $id)->sum('amount_due');

        $countAmount = RibosBarPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesRibosBar', compact('payableId',  'payablesVouchers', 'sum'));

        return $pdf->download('ribos-bar-payment-voucher.pdf');
    }
    
  
    public function viewPayableDetails($id){
       
        $viewPaymentDetail = RibosBarPaymentVoucher::find($id);

        $getViewPaymentDetails = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('view-ribos-bar-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails'));

    }


    public function accept(Request $request, $id){
         //get the status 
        $status = $request->get('status');
        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                    $payables = RibosBarPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect()->route('editPayablesDetailRibosBar', ['id'=>$id]);
                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailRibosBar', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = RibosBarPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect()->route('editPayablesDetailRibosBar', ['id'=>$id]);

                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailRibosBar', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = RibosBarPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect()->route('editPayablesDetailRibosBar', ['id'=>$id]);
                    
                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailRibosBar', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = RibosBarPaymentVoucher::find($id);

         //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

         //get Category
        $cat = $particulars['category'];

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $subAccountId = $particulars['sub_category_account_id'];

        $addParticulars = new RibosBarPaymentVoucher([
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
        return redirect()->route('editPayablesDetailRibosBar', ['id'=>$id]);
    }

    //
    public function addPayment(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         $paymentData = RibosBarPaymentVoucher::find($id);

        //save payment cheque num and cheque amount
        $addPayment = new RibosBarPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

         $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

         return redirect()->route('editPayablesDetailRibosBar', ['id'=>$id]);
    }

    
    public function editPayablesDetail(Request $request, $id){
        $transactionList = RibosBarPaymentVoucher::find($id);

        
        $getChequeNumbers = RibosBarPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //getParticular details
        $getParticulars = RibosBarPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        //amount
        $amount1 = RibosBarPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = RibosBarPaymentVoucher::where('pv_id', $id)->sum('amount');
          
        $sum = $amount1 + $amount2;

         $chequeAmount1 = RibosBarPaymentVoucher::where('id', $id)->sum('cheque_amount');
         $chequeAmount2 = RibosBarPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
         
         $sumCheque = $chequeAmount1 + $chequeAmount2;

         return view('ribos-bar-payables-detail', compact('transactionList', 'getChequeNumbers','sum'
            , 'getParticulars', 'sumCheque'));
    }

    //
    public function transactionList(){
        $getTransactionLists = RibosBarPaymentVoucher::where('pv_id', NULL)->get()->toArray();

        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = RibosBarPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('ribos-bar-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));

    }

    //
    public function viewStatementAccount($id){
    
        //getStatementAccounts
        $getStatementAccounts = RibosBarStatementOfAccount::where('id', $id)->get()->toArray();

        return view('view-ribos-bar-statement-account', compact('getStatementAccounts'));
    }

    //
    public function statementOfAccountList(){
       
        $status = "Unpaid";
        $paid = "Paid";

        //get statement of account 
        $statementOfAccounts = RibosBarStatementOfAccount::where('soa_id', NULL)->where('status', $status)->get()->toArray();

        $statementOfAccountPaids = RibosBarStatementOfAccount::where('soa_id', NULL)->where('status', $paid)->get()->toArray();


        return view('ribos-bar-statement-of-account-lists', compact('statementOfAccounts', 'statementOfAccountPaids'));
    }

    //
    public function updateStatementInfo(Request $request, $id){
         $updateStatmentInfo = RibosBarStatementOfAccount::find($id);

        $updateStatmentInfo->date = $request->get('date');
        $updateStatmentInfo->branch = $request->get('branch');
        $updateStatmentInfo->kilos = $request->get('kilos');
        $updateStatmentInfo->unit_price = $request->get('unitPrice');
        $updateStatmentInfo->payment_method = $request->get('paymentMethod');
        $updateStatmentInfo->amount = $request->get('amount');
        $updateStatmentInfo->status = $request->get('status');
        $updateStatmentInfo->paid_amount = $request->get('paidAmount');
        $updateStatmentInfo->collection_date = $request->get('collectionDate');
        $updateStatmentInfo->check_number = $request->get('checkNumber');
        $updateStatmentInfo->check_amount = $request->get('checkAmount');
        $updateStatmentInfo->or_number = $request->get('orNumber');

        $updateStatmentInfo->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect('ribos-bar/edit-ribos-bar-statement-of-account/'.$id);
    }

    //
    public function editStatementOfAccount($id){
     
         //getStatementOfAccount
        $getStatementOfAccount = RibosBarStatementOfAccount::find($id);

        $sAccounts = RibosBarStatementOfAccount::where('soa_id', $id)->get()->toArray();
        
        return view('edit-ribos-bar-statement-of-account', compact('getStatementOfAccount', 'sAccounts'));
    }

    //
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
        $invoiceNumber = DB::select('SELECT id, invoice_number FROM ribos_bar_statement_of_accounts ORDER BY id DESC LIMIT 1');

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


         $addStatementAccount = new RibosBarStatementOfAccount([
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

        return redirect('ribos-bar/edit-ribos-bar-statement-of-account/'.$insertedId);


    }

    //
    public function statementOfAccountForm(){
        return view('ribos-bar-statement-of-account');
    }

    //
    public function viewBillingStatement($id){

        $viewBillingStatement = RibosBarBillingStatement::find($id);
        

        $billingStatements = RibosBarBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = RibosBarBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = RibosBarBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-ribos-bar-billing-statement', compact('viewBillingStatement', 'billingStatements', 'sum'));
    }

    //
    public function billingStatementLists(){
      
        $billingStatements = RibosBarBillingStatement::where('billing_statement_id', NULL)->get()->toArray();


        return view('ribos-bar-billing-statement-lists', compact('billingStatements'));
    }

    //
    public function updateBillingStatement(Request $request, $id){
        $updateBilling = RibosBarBillingStatement::find($id);

        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $updateBilling->date_of_transaction = $request->get('transactionDate');
        $updateBilling->whole_lechon = $wholeLechon;
        $updateBilling->description = $request->get('description');
        $updateBilling->invoice_number = $request->get('invoiceNumber');
        $updateBilling->amount = $add;

        $updateBilling->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('ribos-bar/edit-ribos-bar-billing-statement/'.$request->get('billingStatementId'));
    }

    //
    public function addNewBillingData(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = RibosBarBillingStatement::find($id);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //get the whole lechon then multiply by 500
        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $addBillingStatement = new RibosBarBillingStatement([
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

        $addBillingStatement->save();

        Session::flash('addBillingSuccess', 'Successfully added.');

        return redirect('ribos-bar/add-new-ribos-bar-billing/'.$id);

    }

    //
    public function addNewBilling($id){

        return view('add-new-ribos-bar-billing-statement', compact('id'));
    }

    //
    public function updateBillingInfo(Request $request, $id){
        $updateBillingOrder = RibosBarBillingStatement::find($id);

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

        return redirect('ribos-bar/edit-ribos-bar-billing-statement/'.$id);
    }

    //
    public function editBillingStatement($id){
      
        $billingStatement = RibosBarBillingStatement::find($id);
       
        $bStatements = RibosBarBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //get the purchase order lists
        $getPurchaseOrders = RibosBarPurchaseOrder::where('po_id', NULL)->get()->toArray();
        
        return view('edit-ribos-bar-billing-statement-form', compact('billingStatement', 'bStatements', 'getPurchaseOrders'));
    }

    //
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
            'invoiceNumber'=>'required',
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
        $dataReferenceNum = DB::select('SELECT id, reference_number FROM ribos_bar_billing_statements ORDER BY id DESC LIMIT 1');

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

          $billingStatement = new RibosBarBillingStatement([
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

         return redirect('ribos-bar/edit-ribos-bar-billing-statement/'.$insertedId);

    }

    //
    public function billingStatementForm(){

        //get the purchase order lists
        $getPurchaseOrders = RibosBarPurchaseOrder::where('po_id', NULL)->get()->toArray();
       

        return view('ribos-bar-billing-statement-form', compact('getPurchaseOrders'));
    }

    //
    public function viewSalesInvoice($id){
       

        $viewSalesInvoice = RibosBarSalesInvoice::find($id);

        $salesInvoices = RibosBarSalesInvoice::where('si_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = RibosBarSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = RibosBarSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-ribos-bar-sales-invoice', compact('viewSalesInvoice', 'salesInvoices', 'sum'));
    }

    //
    public function updateSi(Request $request, $id){
        
        $updateSi = RibosBarSalesInvoice::find($id);

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

        return redirect('ribos-bar/edit-ribos-bar-sales-invoice/'.$request->get('siId'));
    }

    //
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

        $addNewSalesInvoice = new RibosBarSalesInvoice([
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


        return redirect('ribos-bar/add-new-ribos-bar-sales-invoice/'. $id);

    }

    //
    public function addNewSalesInvoice($id){
     
        return view('add-new-ribos-bar-sales-invoice', compact('id'));
    }

    //
    public function updateSalesInvoice(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $updateSalesInvoice = RibosBarSalesInvoice::find($id);

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

        return redirect('ribos-bar/edit-ribos-bar-sales-invoice/'.$id);
    }

    //
    public function editSalesInvoice($id){
      
        //getSalesInvoice
        $getSalesInvoice = RibosBarSalesInvoice::find($id);

        $sInvoices  = RibosBarSalesInvoice::where('si_id', $id)->get()->toArray();

        return view('edit-ribos-bar-sales-invoice', compact('getSalesInvoice', 'sInvoices'));
    }

    //
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

        $addSalesInvoice = new RibosBarSalesInvoice([
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

        return redirect('ribos-bar/edit-ribos-bar-sales-invoice/'.$insertedId);
    }

    //
    public function salesInvoiceForm(){
        return view('ribos-bar-sales-invoice-form');
    }

    //
    public function viewPaymentVoucher($id){
    
        //paymentVoucher
        $paymentVoucher = RibosBarPaymentVoucher::find($id);

        $pVouchers = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();


         //count the total amount 
        $countTotalAmount = RibosBarPaymentVoucher::where('id', $id)->sum('amount');

        //
        $countAmount = RibosBarPaymentVoucher::where('pv_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-payment-voucher-ribos-bar', compact('paymentVoucher', 'pVouchers', 'sum'));
    }

    //
    public function chequeVoucher(){
      
        //getAllChequeVouchers
        $method = "Cheque";

        $getAllChequeVouchers = RibosBarPaymentVoucher::where('method_of_payment', $method)->get()->toArray(); 

        return view('cheque-vouchers-lists-ribos-bar', compact('getAllChequeVouchers'));
    }

    //
    public function cashVoucher(){
      
        //getAllCashVouchers
        $method = "Cash";

        $getAllCashVouchers = RibosBarPaymentVoucher::where('method_of_payment', $method)->get()->toArray();

        return view('cash-vouchers-list-ribos-bar', compact('getAllCashVouchers'));
    }

    //
    public function updatePV(Request $request, $id){
         $updatePV = RibosBarPaymentVoucher::find($id);
      

        $updatePV->particulars = $request->get('particulars');
        $updatePV->amount = $request->get('amount');

        $updatePV->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('ribos-bar/edit-ribos-bar-payment-voucher/'.$request->get('pvId'));
    }

    //
    public function addNewPaymentVoucherData(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentVoucher = RibosBarPaymentVoucher::find($id);

         $addNewPaymentVoucherData = new RibosBarPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'reference_number'=>$paymentVoucher['reference_number'],
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewPaymentVoucherData->save();

        Session::flash('addPaymentVoucherSuccess', 'Successfully added.');

        return redirect('ribos-bar/add-new-ribos-bar-payment-voucher/'.$id);

    }

    //
    public function addNewPaymentVoucher($id){

        return view('add-new-ribos-bar-payment-voucher', compact('id'));
    }

    //
    public function updatePaymentVoucher(Request $request, $id){
        $updatePaymentVoucher = RibosBarPaymentVoucher::find($id);

        $updatePaymentVoucher->paid_to = $request->get('paidTo');
        $updatePaymentVoucher->account_no = $request->get('accountNumber');
        $updatePaymentVoucher->date = $request->get('date');
        $updatePaymentVoucher->particulars = $request->get('particulars');
        $updatePaymentVoucher->amount = $request->get('amount');
        $updatePaymentVoucher->method_of_payment = $request->get('methodOfPayment');

        $updatePaymentVoucher->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('ribos-bar/edit-ribos-bar-payment-voucher/'.$id);
    }


    //
    public function editPaymentVoucher($id){
      
          //getPaymentVoucher 
        $getPaymentVoucher = RibosBarPaymentVoucher::find($id);

        //pVoucher
        $pVouchers = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('edit-payment-voucher-ribos-bar', compact('getPaymentVoucher', 'pVouchers'));
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
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM ribos_bar_payment_vouchers ORDER BY id DESC LIMIT 1');

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
                        'ribos_bar_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...
             $addPaymentVoucher = new RibosBarPaymentVoucher([
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
            return redirect()->route('editPayablesDetailRibosBar', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormRibosBar')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    
    }

    //payment voucher form
    public function paymentVoucherForm(){
    
        $getAllFlags = RibosBarUtility::where('u_id', NULL)->get()->toArray();
        return view('payment-voucher-form-ribos-bar', compact('getAllFlags'));
    }

    //
    public function purchaseOrderList(){
      
        $purchaseOrders = RibosBarPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('ribos-bar-purchase-order-lists', compact('purchaseOrders'));
    }

    //
    public function updatePo(Request $request, $id){
        $order = RibosBarPurchaseOrder::find($id);
        
        $order->quantity = $request->get('quantity');
        $order->description = $request->get('description');
        $order->unit_price  = $request->get('unitPrice');
        $order->amount = $request->get('amount');
    
        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('ribos-bar/edit-ribos-bar-purchase-order/'.$request->get('poId'));
    }

   
    //add new
    public function addNew(Request $request, $id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        //
          $this->validate($request, [
            'amount'=>'required',
        ]);

        $pO = RibosBarPurchaseOrder::find($id);

        $addNewParticulars = new RibosBarPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewParticulars->save();

        Session::flash('addNewSuccess', 'Successfully added');

        return redirect('ribos-bar/edit-ribos-bar-purchase-order/'.$id);
    }

    //
    public function purchaseOrder(){

        return view('ribos-bar-purchase-order');
    }

    //print delivery
    public function printDelivery($id){

        $deliveryId = RibosBarDeliveryReceipt::find($id);

        $deliveryReceipts = RibosBarDeliveryReceipt::where('dr_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = RibosBarDeliveryReceipt::where('id', $id)->sum('amount');


          //
        $countAmount = RibosBarDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

         $pdf = PDF::loadView('ribos-bar-printDelivery', compact('deliveryId', 'deliveryReceipts', 'sum'));

        return $pdf->download('ribos-bar-delivery-receipt.pdf');

    }

    //
    public function viewDeliveryReceipt($id){

        $viewDeliveryReceipt = RibosBarDeliveryReceipt::find($id);

        $deliveryReceipts = RibosBarDeliveryReceipt::where('dr_id', $id)->get()->toArray();

         //count the total unit price
        $countTotalUnitPrice = RibosBarDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = RibosBarDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = RibosBarDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = RibosBarDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        return view('view-ribos-bar-delivery-receipt', compact('viewDeliveryReceipt', 'deliveryReceipts', 'countUnit', 'sum', 'sum2'));
    }

    //
    public function deliveryReceiptList(){
      
         //getAllDeliveryReceipt
        $getAllDeliveryReceipts = RibosBarDeliveryReceipt::where('dr_id', NULL)->get()->toArray();

        return view('ribos-bar-delivery-receipt-list', compact('getAllDeliveryReceipts'));
    }

    //
    public function updateDr(Request $request, $id){
        $delivery = RibosBarDeliveryReceipt::find($id);

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

        return redirect('ribos-bar/edit-ribos-bar-delivery-receipt/'.$request->get('drId'));
    }

    //
    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $deliveryReceipt = RibosBarDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

          //get date today
        $getDateToday =  date('Y-m-d');

        $addNewDeliveryReceipt = new RibosBarDeliveryReceipt([
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

        return redirect('ribos-bar/add-new-delivery-receipt/'.$id);

    }

    //
    public function addNewDelivery($id){

        return view('add-new-ribos-bar-delivery-receipt', compact('id'));
    }

    //
    public function updateDeliveryReceipt(Request $request, $id){
        $updateDeliveryReceipt = RibosBarDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $updateDeliveryReceipt->delivered_to = $request->get('deliveredTo');
        $updateDeliveryReceipt->qty = $request->get('qty');
        $updateDeliveryReceipt->unit = $request->get('unit');
        $updateDeliveryReceipt->product_id = $request->get('productId');
        $updateDeliveryReceipt->item_description = $request->get('itemDescription');
        $updateDeliveryReceipt->unit_price = $unitPrice;
        $updateDeliveryReceipt->address = $request->get('address');
        $updateDeliveryReceipt->amount = $sum;

        $updateDeliveryReceipt->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

         return redirect('ribos-bar/edit-ribos-bar-delivery-receipt/'.$id);
    }

    //
    public function editDeliveryReceipt($id){
        
        //getDeliveryReceipt
        $getDeliveryReceipt = RibosBarDeliveryReceipt::find($id);

         //dReceipts
        $dReceipts = RibosBarDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-ribos-bar-delivery-receipt', compact('getDeliveryReceipt', 'dReceipts'));
    }   

    //store delivery receipt
    public function storeDeliveryReceipt(Request $request){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        
        //validate
        $this->validate($request, [
            'deliveredTo' =>'required',
            'productId' =>'required',
            'qty'=>'required',
            'unit'=>'required',
            'itemDescription'=>'required',
            'unitPrice'=>'required',
           
        ]);


         //get the latest insert id query in table delivery receipt dr_no
        $dataDrNo = DB::select('SELECT id, dr_no FROM ribos_bar_delivery_receipts ORDER BY id DESC LIMIT 1');
        
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

         $storeDeliveryReceipt = new RibosBarDeliveryReceipt([
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

        return redirect('ribos-bar/edit-ribos-bar-delivery-receipt/'.$insertedId);
    }

    //
    public function deliveryReceiptForm(){
     
        return view('ribos-bar-delivery-receipt-form');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
      
         $getAllSalesInvoices = RibosBarSalesInvoice::where('si_id', NULL)->get()->toArray();

        return view('ribos-bar', compact('getAllSalesInvoices')); 
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
            'date'=> 'required',
            'description'=>'required',
        ]);

           //get the latest insert id query in table purchase order
        $data = DB::select('SELECT id, p_o_number FROM ribos_bar_purchase_orders ORDER BY id DESC LIMIT 1');

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

        $purchaseOrder = new RibosBarPurchaseOrder([
            'user_id' =>$user->id,
            'p_o_number'=>$uNum,
            'paid_to'=>$request->get('paidTo'),
            'date'=>$request->get('date'),
            'address'=>$request->get('address'),
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'prepared_by'=>$name,
            'created_by'=>$name,
        ]);

        $purchaseOrder->save();

        $insertedId = $purchaseOrder->id;

        return redirect('ribos-bar/edit-ribos-bar-purchase-order/'.$insertedId);
        
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
      
        $purchaseOrder = RibosBarPurchaseOrder::find($id);


        //
        $pOrders = RibosBarPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = RibosBarPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = RibosBarPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;
    

        return view('view-ribos-bar-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $purchaseOrder = RibosBarPurchaseOrder::find($id);

        $pOrders = RibosBarPurchaseOrder::where('po_id', $id)->get()->toArray();

        //get users
        $getUsers = User::get()->toArray();
       

        return view('edit-ribos-bar-purchase-order', compact('purchaseOrder', 'pOrders', 'getUsers'));
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

        $purchaseOrder = RibosBarPurchaseOrder::find($id);
        
        $purchaseOrder->paid_to = $paidTo;
        $purchaseOrder->address = $address;
        $purchaseOrder->date = $date;
        $purchaseOrder->description = $description;
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();


        Session::flash('SuccessE', 'Successfully updated');

        return redirect('ribos-bar/edit-ribos-bar-purchase-order/'.$id);
    }

    //  
    public function destroyCashiersReport($id){
        $cashiersReport = RibosBarCashiersForm::find($id);
        $cashiersReport->delete();
    }

    //
    public function destroyTransactionList($id){    
         $transactionList = RibosBarPaymentVoucher::find($id);
        $transactionList->delete();
    }

     //
    public function destroyBillingStatement($id){
        $billingStatement = RibosBarBillingStatement::find($id);
        $billingStatement->delete();
    }

    //
    public function destroySalesInvoice($id){
        $salesInvoice = RibosBarSalesInvoice::find($id);
        $salesInvoice->delete();
    }

    //
    public function destroyPaymentVoucher($id){
        $paymentVoucher = RibosBarPaymentVoucher::find($id);
        $paymentVoucher->delete();
    }


    public function destroyDeliveryReceipt($id){
        $deliveryReceipt = RibosBarDeliveryReceipt::find($id);
        $deliveryReceipt->delete();
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
        $purchaseOrder = RibosBarPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }

    
}
