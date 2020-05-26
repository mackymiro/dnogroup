<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF; 
use Auth;
use App\User; 
use App\LechonDeCebuPurchaseOrder; 
use App\LechonDeCebuBillingStatement; 
use App\LechonDeCebuStatementOfAccount; 
use App\CommissaryStockInventory;
use App\LechonDeCebuPaymentVoucher;
use App\LechonDeCebuDeliveryReceipt;
use App\LechonDeCebuDeliveryReceiptDuplicateCopy;
use App\LechonDeCebuSalesInvoice;
use App\CommissaryRawMaterial;
use App\LechonDeCebuPettyCash;
use Session;


class LoloPinoyLechonDeCebuController extends Controller
{   

    public function viewPettyCash($id){
        $getPettyCash = LechonDeCebuPettyCash::find($id);

        $getPettyCashSummaries = LechonDeCebuPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = LechonDeCebuPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = LechonDeCebuPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;


        return view('lechon-de-cebu-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
    }

    public function updatePC(Request $request, $id){
        $updatePC = LechonDeCebuPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashLechonDeCebu', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pettyCash = LechonDeCebuPettyCash::find($id);

        $addNew = new LechonDeCebuPettyCash([
            'user_id'=>$user->id,
            'pc_id'=>$id,
            'petty_cash_no'=>$pettyCash->petty_cash_no,
            'date'=>$request->get('date'),
            'petty_cash_summary'=>$request->get('pettyCashSummary'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNew->save();
        Session::flash('addNewSuccess', 'Successfully added.');

        return redirect()->route('editPettyCashLechonDeCebu', ['id'=>$id]);
    }

    public function editPettyCash($id){
        $pettyCash = LechonDeCebuPettyCash::find($id);

        $pettyCashSummaries = LechonDeCebuPettyCash::where('pc_id', $id)->get()->toArray();
        return view('edit-lechon-de-cebu-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }

    public function addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table petty cash petty cash no
        $dataCashNo = DB::select('SELECT id, petty_cash_no FROM lechon_de_cebu_petty_cashes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
        if(isset($dataCashNo[0]->petty_cash_no) != 0){
            //if code is not 0
            $newProd = $dataCashNo[0]->petty_cash_no +1;
            $uProd = sprintf("%06d",$newProd);   

        }else{
            //if code is 0 
            $newProd = 1;
            $uProd = sprintf("%06d",$newProd);
        } 

          
        $addPettyCash = new LechonDeCebuPettyCash([
            'user_id'=>$user->id,
            'date'=>$request->date,
            'petty_cash_no'=>$uProd,
            'petty_cash_name'=>$request->pettyCashName,
            'petty_cash_summary'=>$request->pettyCashSummary,
            'amount'=>$request->amount,
            'created_by'=>$name,
        ]);

        $addPettyCash->save();
        $insertId = $addPettyCash->id;
      
        return response()->json($insertId);


    }

    public function pettyCashList(){
       
 
         $pettyCashLists = LechonDeCebuPettyCash::where('pc_id', NULL)->get()->toArray();

        return view('lechon-de-cebu-petty-cash-list', compact('pettyCashLists'));
    }

    public function inventoryStockUpdate(Request $request, $id){
        $updateInventoryStock = CommissaryRawMaterial::find($id);

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

        return redirect('lolo-pinoy-lechon-de-cebu/view-inventory-of-stocks/'.$request->get('iSId'));
    }

    //
    public function viewInventoryOfStocks($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewStockDetail = CommissaryRawMaterial::find($id);

        //transaction table
        $getViewStockDetails = CommissaryRawMaterial::where('rm_id', $id)->get()->toArray();

      

        return view('view-lechon-de-cebu-inventory-stock', compact('user', 'viewStockDetail', 'getViewStockDetails'));
    }

    //
    public function printSOA($id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $Soa = LechonDeCebuBillingStatement::find($id);

        $statementAccounts = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuBillingStatement::where('id', $id)->sum('paid_amount');


          //
        $countAmount = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->sum('paid_amount');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printSOA', compact('Soa', 'user', 'statementAccounts', 'sum'));

        return $pdf->download('lechon-de-cebu-statement-of-account.pdf');
    }

    //
    public function printPayables($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $payableId = LechonDeCebuPaymentVoucher::find($id);

          //getParticular details
          $getParticulars = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      

        $payablesVouchers = LechonDeCebuPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuPaymentVoucher::where('id', $id)->sum('amount_due');


          //
        $countAmount = LechonDeCebuPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayables', compact('payableId', 'user', 'payablesVouchers', 'sum', 'getParticulars'));

        return $pdf->download('lechon-de-cebu-payment-voucher.pdf');
    }

    //
    public function viewPayableDetails($id){    
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewPaymentDetail = LechonDeCebuPaymentVoucher::find($id);

        //
        $getViewPaymentDetails = LechonDeCebuPaymentVoucher::where('pv_id', $id)->get()->toArray();

         //getParticular details
         $getParticulars = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        


        return view('view-lechon-de-cebu-payable-details', compact('user', 'viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
    }

    //
    public function accept(Request $request, $id){

        //get the status 
        $status = $request->get('status');
        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                    $payables = LechonDeCebuPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = LechonDeCebuPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = LechonDeCebuPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = LechonDeCebuPaymentVoucher::find($id);

         //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

        $addParticulars = new LechonDeCebuPaymentVoucher([
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

        return redirect('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$id);

    }

    //
    public function addPayment(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        
        $paymentData = LechonDeCebuPaymentVoucher::find($id);

        //save payment cheque num and cheque amount
        $addPayment = new LechonDeCebuPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

        $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-payables-detail/'.$id);
    }

    //
    public function editPayablesDetail(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $transactionList = LechonDeCebuPaymentVoucher::find($id);

        //
        $getChequeNumbers = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //getParticular details
        $getParticulars = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      

        //amount
        $amount1 = LechonDeCebuPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = LechonDeCebuPaymentVoucher::where('pv_id', $id)->sum('amount');
       
        $sum = $amount1 + $amount2;

        $chequeAmount1 = LechonDeCebuPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = LechonDeCebuPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
        

        return view('lechon-de-cebu-payables-detail', compact('user', 
            'transactionList', 'getChequeNumbers', 'getParticulars', 'sum', 'sumCheque'));

    }

    //
    public function transactionList(){
        $ids = Auth::user()->id;
        $user = User::find($ids);


        //
        $getTransactionLists = LechonDeCebuPaymentVoucher::where('pv_id', NULL)->get()->toArray();
        

        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = LechonDeCebuPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');


        return view('lechon-de-cebu-transaction-list', compact('user', 'getTransactionLists', 'totalAmoutDue'));

    }

    //
    public function printSalesInvoice($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $printSales = LechonDeCebuSalesInvoice::find($id);

        $salesInvoices = LechonDeCebuSalesInvoice::where('si_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printSalesInvoice', compact('printSales', 'salesInvoices', 'sum'));

        return $pdf->download('lechon-de-cebu-sales-invoice.pdf');
    }

    //
    public function privateOrders(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getAllDeliveryReceipt
        $getAllDeliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', NULL)->get()->toArray();

        return view('lechon-de-cebu-sales-invoice-private-orders', compact('user', 'getAllDeliveryReceipts'));
    }

    //sales invoice > sales pero outlet
    public function salesInvoiceSalesPerOutlet(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getSalesInvoiceTerminal1
        $branch = "Ssp Food Avenue Terminal 1";
        $branch2 = "Ssp Food Avenue Terminal 2";

        $statementOfAccountT1s = LechonDeCebuSalesInvoice::where('ordered_by', $branch)->get()->toArray();

        //get total sales in terminal 1
        $totalSalesInTerminal1 =  LechonDeCebuSalesInvoice::where('ordered_by', $branch)->sum('amount');

        $statementOfAccountT2s = LechonDeCebuSalesInvoice::where('ordered_by', $branch2)->get()->toArray();

          //get total sales in terminal 1
        $totalSalesInTerminal2 =  LechonDeCebuSalesInvoice::where('ordered_by', $branch2)->sum('amount');

        return view('lechon-de-cebu-sales-invoice-sales-per-outlet', compact('user', 'statementOfAccountT1s', 'totalSalesInTerminal1', 'statementOfAccountT2s', 'totalSalesInTerminal2'));
    }

    //
    public function sAccountUpdate(Request $request, $id){
        $accountPaid = LechonDeCebuBillingStatement::find($id);
        
        $accountPaid->paid_amount = $request->get('paidAmount');
        $accountPaid->status = $request->get('status');
        $accountPaid->collection_date = $request->get('collectionDate');
        $accountPaid->check_number = $request->get('chequeNumber');
        $accountPaid->check_amount = $request->get('chequeAmount');
        $accountPaid->or_number = $request->get('orNumber');
        $accountPaid->payment_method = $request->get('paymentMethod');

        $accountPaid->save();

        Session::flash('sAccountUpdate', 'SOA updated.');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-statement-of-account/'.$request->get('soaId'));

    }

    //print payment voucher
    public function printPaymentVoucher($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $printPaymentVoucher = LechonDeCebuPaymentVoucher::find($id);
       

        $pVouchers = LechonDeCebuPaymentVoucher::where('pv_id', $id)->get()->toArray();


         //count the total amount 
        $countTotalAmount = LechonDeCebuPaymentVoucher::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuPaymentVoucher::where('pv_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        $pdf = PDF::loadView('printPaymentVoucher', compact('printPaymentVoucher', 'pVouchers', 'sum'));

        return $pdf->download('lechon-de-cebu-payment-voucher.pdf'); 
    }

    //print billing statement
    public function printBillingStatement($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $printBillingStatement = LechonDeCebuBillingStatement::find($id);

        $billingStatements = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printBillingStatement', compact('printBillingStatement', 'billingStatements', 'sum'));

        return $pdf->download('lechon-de-cebu-billing-statement.pdf');         
    }


    //print PO purchase order
    public function printPO($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);

          //
        $pOrders = LechonDeCebuPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        $pdf = PDF::loadView('printPO', compact('purchaseOrder', 'pOrders', 'sum'));

        return $pdf->download('lechon-de-cebu-purchase-order.pdf');


    }

    //print Duplicate Delivery
    public function printDuplicateDelivery($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $deliveryDuplicateId = LechonDeCebuDeliveryReceiptDuplicateCopy::find($id);

        $deliveryReceiptDuplicates = LechonDeCebuDeliveryReceiptDuplicateCopy::where('dr_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuDeliveryReceiptDuplicateCopy::where('id', $id)->sum('price');

        //
        $countAmount = LechonDeCebuDeliveryReceiptDuplicateCopy::where('dr_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;


        $pdf = PDF::loadView('printDuplicateDelivery', compact('deliveryDuplicateId', 'user', 'deliveryReceipts', 'sum', 'deliveryReceiptDuplicates'));

        return $pdf->download('lechon-de-cebu-duplicate-delivery-receipt.pdf');


    }

    //printDelivery
    public function printDelivery($id){

        $ids = Auth::user()->id;
        $user = User::find($ids);

        $deliveryId = LechonDeCebuDeliveryReceipt::find($id);

        $deliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuDeliveryReceipt::where('id', $id)->sum('price');


          //
        $countAmount = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printDelivery', compact('deliveryId', 'user', 'deliveryReceipts', 'sum'));

        return $pdf->download('lechon-de-cebu-delivery-receipt.pdf');
    }

    //inventory of stocksInventory
    public function inventoryOfStocks(){
        $ids = Auth::user()->id;    
        $user = User::find($ids);

         //getRawMaterial
        $getRawMaterials = CommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

        //count the total stock out amount value
        $countStockAmount = CommissaryRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = CommissaryRawMaterial::where('rm_id', NULL)->sum('amount');
        
        return view('commissary-inventory-of-stocks', compact('user', 'getRawMaterials', 'countStockAmount', 'countTotalAmount'));
    }

    //view stock inventory 
    public function viewStockInventory($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewStockDetail = CommissaryRawMaterial::find($id);

        //transaction table
        $getViewStockDetails = CommissaryRawMaterial::where('rm_id', $id)->get()->toArray();

        //total 
        $total = CommissaryRawMaterial::where('rm_id', $id)->sum('amount');

        return view('view-lechon-de-cebu-stock-inventory', compact('user', 'viewStockDetail', 'getViewStockDetails', 'total'));
    }


    //save request stock out RAW material
    public function requestStockOut(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $requestStockOut = CommissaryRawMaterial::find($id);

        $qty = $request->get('qty');

        //compute qty times unit price
        $compute  = $qty * $requestStockOut->unit_price;
        $sum = $compute;

          //get date today
        $getDateToday =  date('Y-m-d');

        $addRequestStockOut = new CommissaryRawMaterial([
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

         return redirect('lolo-pinoy-lechon-de-cebu/raw-material/request-stock-out/'.$id);


    }


    //request stock out RAW material
    public function rawMaterialRequestStockOut($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $getRequestStock = CommissaryRawMaterial::find($id);

        return view('request-stock-out-raw-material', compact('user', 'getRequestStock', 'id'));
    }

    //save delivery in RAW material
    public function addDeliveryInRawMaterial(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $rawMaterial = CommissaryRawMaterial::find($id);

        $qty = $request->get('qty');

        //compute qty times unit price
        $compute  = $qty * $rawMaterial->unit_price;
        $sum = $compute;

          //get date today
        $getDateToday =  date('Y-m-d');

        $addDeliveryIn = new CommissaryRawMaterial([
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

         return redirect('lolo-pinoy-lechon-de-cebu/raw-material/add-delivery-in/'.$id);

    }

    //add delivery in RAW material
    public function rawMaterialAddDeliveryIn($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $getRawMaterial = CommissaryRawMaterial::find($id);

        return view('add-delivery-in-raw-material', compact('user', 'getRawMaterial', 'id'));
    }


    //view RAW material details
    public function viewRawMaterialDetails($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewRawDetail = CommissaryRawMaterial::find($id);

        //transaction table
        $getViewRawDetails = CommissaryRawMaterial::where('rm_id', $id)->get()->toArray();
        
        return view('view-lechon-de-cebu-raw-material-details', compact('user', 'viewRawDetail', 'getViewRawDetails'));
    }

    //update RAW material
    public function updateRawMaterial(Request $request, $id){

        $updateRawMaterial = CommissaryRawMaterial::find($id);

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

        return redirect('lolo-pinoy-lechon-de-cebu/commissary/edit-raw-materials/'.$id);

    }

    //edit RAW materials
    public function editRawMaterial($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $getRawMaterial = CommissaryRawMaterial::find($id);

        return view('edit-commissary-raw-material', compact('user', 'getRawMaterial'));
    }


    //add RAW materials
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
        $dataProductId = DB::select('SELECT id, product_id_no FROM commissary_raw_materials ORDER BY id DESC LIMIT 1');

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

        $addNewRawMaterial = new CommissaryRawMaterial([
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

        return redirect('lolo-pinoy-lechon-de-cebu/commissary/create-raw-materials');




    }

    //create RAW materials
    public function createRawMaterials(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('commissary-add-raw-materials', compact('user'));
    }

    //RAW materials
    public function rawMaterials(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $getRawMaterials = CommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

        return view('commissary-raw-materials', compact('user', 'getRawMaterials'));
    }

    //view sales invoice
    public function viewSalesInvoice($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewSalesInvoice = LechonDeCebuSalesInvoice::find($id);

        $salesInvoices = LechonDeCebuSalesInvoice::where('si_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = LechonDeCebuSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-lechon-de-cebu-sales-invoice', compact('user', 'viewSalesInvoice', 'salesInvoices', 'sum'));

    }

    //update for the add new sales invoice
    public function updateSi(Request $request, $id){

        $updateSi = LechonDeCebuSalesInvoice::find($id);

        //kls
        /*$kls  = $request->get('totalKls');

         //compute kls * unit price
        $unitPrice = $updateSi->unit_price;
        $compute = $kls * $unitPrice;
        $sum = $compute;*/

           //body 400kls
        $body = $request->get('body');

        $bodyComp = 400;
        $computeBody = $body * $bodyComp;


        //head and feet 200kls
        $head = $request->get('headFeet');

        $headFeet = 200;
        $computeHeadFeet = $head * $headFeet;


        //total body and head and feet    
        $tot = $computeBody + $computeHeadFeet;

        $updateSi->qty = $request->get('qty');
        $updateSi->body = $body;
        $updateSi->head_and_feet = $head;
        $updateSi->item_description = $request->get('itemDescription');
        $updateSi->amount = $tot;

        $updateSi->save();

        Session::flash('SuccessEdit', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-sales-invoice/'.$request->get('siId'));

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
        /*$kls  = $request->get('totalKls');

         //compute kls * unit price
        $unitPrice = 500;
        $compute = $kls * $unitPrice;
        $sum = $compute;*/

        //body 400kls
        $body = $request->get('body');

        $bodyComp = 400;
        $computeBody = $body * $bodyComp;


        //head and feet 200kls
        $head = $request->get('headFeet');

        $headFeet = 200;
        $computeHeadFeet = $head * $headFeet;


        //total body and head and feet    
        $tot = $computeBody + $computeHeadFeet;

        $addNewSalesInvoice = new LechonDeCebuSalesInvoice([
            'user_id'=>$user->id,
            'si_id'=>$id,
            'date'=>$getDateToday,
            'qty'=>$request->get('qty'),
            'body'=>$body,
            'head_and_feet'=>$head,
            'item_description'=>$request->get('itemDescription'),
            'amount'=>$tot,
            'created_by'=>$name,
        ]);

        $addNewSalesInvoice->save();

        Session::flash('addSalesInvoiceSuccess', 'Successfully added.');


        return redirect('lolo-pinoy-lechon-de-cebu/add-new-sales-invoice/'. $id);
    }

    //add new sales invoice
    public function addNewSalesInvoice($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
       

        return view('add-new-lechon-de-cebu-sales-invoice', compact('user', 'id'));
    }

    //update sales invoice
    public function updateSalesInvoice(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $updateSalesInvoice = LechonDeCebuSalesInvoice::find($id);

        //kls
        /*$kls  = $request->get('totalKls');

         //compute kls * unit price
        $unitPrice = $updateSalesInvoice->unit_price;
        $compute = $kls * $unitPrice;
        $sum = $compute;*/

         //body 400kls
        $body = $request->get('body');

        $bodyComp = 400;
        $computeBody = $body * $bodyComp;


        //head and feet 200kls
        $head = $request->get('headFeet');

        $headFeet = 200;
        $computeHeadFeet = $head * $headFeet;


        //total body and head and feet    
        $tot = $computeBody + $computeHeadFeet;

       

        $updateSalesInvoice->invoice_number     = $request->get('invoiceNum');
        $updateSalesInvoice->date               = $request->get('date');
        $updateSalesInvoice->ordered_by         = $request->get('orderedBy');
        $updateSalesInvoice->address            = $request->get('address');
        $updateSalesInvoice->qty                = $request->get('qty');
        $updateSalesInvoice->body               = $body;
        $updateSalesInvoice->head_and_feet      = $head;
        $updateSalesInvoice->item_description   = $request->get('itemDescription');
        $updateSalesInvoice->amount             = $tot;
        $updateSalesInvoice->created_by         = $name; 

        $updateSalesInvoice->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-sales-invoice/'.$id);
 

    }

    //edit sales inovice
    public function editSalesInvoice($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getSalesInvoice
        $getSalesInvoice = LechonDeCebuSalesInvoice::find($id);

        $sInvoices  = LechonDeCebuSalesInvoice::where('si_id', $id)->get()->toArray();

        return view('edit-lechon-de-cebu-sales-invoice', compact('user', 'getSalesInvoice', 'sInvoices'));
    }

    //store sales invoice
    public function storeSalesInvoice(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;


           //validate
        $this->validate($request, [
            'date'=>'required',
            'invoiceNum' =>'required',
            'orderedBy'=>'required',
           
        ]);

        //total kls
        /*$kls = $request->get('totalKls');

        //compute kls * unit price
        $unitPrice = 500;
        $compute = $kls * $unitPrice;
        $sum = $compute;*/

        //body 400kls
        $body = $request->get('body');

        $bodyComp = 400;
        $computeBody = $body * $bodyComp;


        //head and feet 200kls
        $head = $request->get('headFeet');

        $headFeet = 200;
        $computeHeadFeet = $head * $headFeet;


        //total body and head and feet    
        $tot = $computeBody + $computeHeadFeet;


        $addSalesInvoice = new LechonDeCebuSalesInvoice([
            'user_id'=>$user->id,
            'invoice_number'=>$request->get('invoiceNum'),
            'ordered_by'=>$request->get('orderedBy'),
            'address'=>$request->get('address'),
            'date'=>$request->get('date'),
            'qty'=>$request->get('qty'),
            'body'=>$body,
            'head_and_feet'=>$head,
            'item_description'=>$request->get('itemDescription'),
            'amount'=>$tot,
            'created_by'=>$name,
        ]);

        $addSalesInvoice->save();

        $insertedId = $addSalesInvoice->id;

        return redirect('lolo-pinoy-lechon-de-cebu/edit-sales-invoice/'.$insertedId);

    }


    //sales invoice form
    public function salesInvoiceForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('lechon-de-cebu-sales-invoice-form', compact('user'));
    }

    //view delivery duplicate
    public function viewDeliveryDuplicate($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewDeliveryReceiptDuplicate = LechonDeCebuDeliveryReceiptDuplicateCopy::find($id);

        $deliveryReceiptDuplicates = LechonDeCebuDeliveryReceiptDuplicateCopy::where('dr_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuDeliveryReceiptDuplicateCopy::where('id', $id)->sum('price');

        //
        $countAmount = LechonDeCebuDeliveryReceiptDuplicateCopy::where('dr_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-delivery-duplicate', compact('user', 'viewDeliveryReceiptDuplicate', 'deliveryReceiptDuplicates', 'sum'));
    }

    //duplocicate copy of delivery receipt
    public function duplicateCopy($id){

        $getDeliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);

        //update table delivery receipt
        $dupStatus = 1;

        $getDeliveryReceipt->duplicate_status = $dupStatus;
        $getDeliveryReceipt->save();
        

        $getDReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();


        //save to duplicate copies table
        $duplicateCopy = new LechonDeCebuDeliveryReceiptDuplicateCopy([
            'user_id'=>$getDeliveryReceipt->user_id,
            'sold_to'=>$getDeliveryReceipt->sold_to,
            'time'=>$getDeliveryReceipt->time,
            'dr_no'=>$getDeliveryReceipt->dr_no,
            'date'=>$getDeliveryReceipt->date,
            'date_to_be_delivered'=>$getDeliveryReceipt->date_to_be_delivered,
            'delivered_to'=>$getDeliveryReceipt->delivered_to,
            'contact_person'=>$getDeliveryReceipt->contact_person,
            'mobile_num'=>$getDeliveryReceipt->mobile_num,
            'special_instruction'=>$getDeliveryReceipt->special_instruction,
            'qty'=>$getDeliveryReceipt->qty,
            'description'=>$getDeliveryReceipt->description,
            'price'=>$getDeliveryReceipt->price,
            'total'=>$getDeliveryReceipt->total,
            'prepared_by'=>$getDeliveryReceipt->prepared_by,
            'created_by'=>$getDeliveryReceipt->created_by,
        ]);

        $duplicateCopy->save();

        $insertedId  = $duplicateCopy->id;

        foreach($getDReceipts as $getDReceipt){

            $addedDataDuplicate = new LechonDeCebuDeliveryReceiptDuplicateCopy([
                    'user_id'=>$getDReceipt['user_id'],
                    'sold_to'=>$getDReceipt['sold_to'],
                    'time'=>$getDReceipt['time'],
                    'dr_id'=>$insertedId,
                    'dr_no'=>$getDReceipt['dr_no'],
                    'date'=>$getDReceipt['date'],
                    'delivered_to'=>$getDReceipt['delivered_to'],
                    'contact_person'=>$getDReceipt['contact_person'],
                    'mobile_num'=>$getDReceipt['mobile_num'],
                    'special_instruction'=>$getDReceipt['special_instruction'],
                    'qty'=>$getDReceipt['qty'],
                    'description'=>$getDReceipt['description'],
                    'price'=>$getDReceipt['price'],
                    'total'=>$getDReceipt['total'],
                    'prepared_by'=>$getDReceipt['prepared_by'],
                    'created_by'=>$getDReceipt['created_by'],
             ]);

            $addedDataDuplicate->save();
        }
       


        Session::flash('duplicateSuccess', 'Successfully duplicated a copy.');

        return redirect('lolo-pinoy-lechon-de-cebu/delivery-receipt/lists');

    }


    //view delivery receipt
    public function viewDeliveryReceipt($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewDeliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);


        $deliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = LechonDeCebuDeliveryReceipt::where('id', $id)->sum('price');
       

        //
        $countAmount = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;
        

        return view('view-lechon-de-cebu-delivery-receipt', compact('user', 'viewDeliveryReceipt', 'deliveryReceipts', 'sum'));
    }

    //update for the add new delivery receipt
    public function updateDr(Request $request, $id){
        
        $delivery = LechonDeCebuDeliveryReceipt::find($id);
        $delivery->qty = $request->get('qty');
        $delivery->description = $request->get('description');
        $delivery->price = $request->get('price');

        $delivery->save();


        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/'.$request->get('drId'));



    }

    //delivery receipt lists
    public function deliveryReceiptLists(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getAllDeliveryReceipt
        $getAllDeliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', NULL)->get()->toArray();

        //getDuplicateCopy
        $getDuplicateCopies = LechonDeCebuDeliveryReceiptDuplicateCopy::where('dr_id', NULL)->get()->toArray();

        return view('lechon-de-cebu-delivery-receipt-lists', compact('user', 'getAllDeliveryReceipts', 'getDuplicateCopies'));
    }

    //add new delivery recipt data
    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $deliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);

        $addNewDeliveryReceipt = new LechonDeCebuDeliveryReceipt([
            'user_id'=>$user->id,
            'dr_id'=>$id,
            'dr_no'=>$deliveryReceipt['dr_no'],
            'qty'=>$request->get('qty'),
            'description'=>$request->get('description'),
            'price'=>$request->get('price'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $addNewDeliveryReceipt->save();

         Session::flash('addDeliveryReceiptSuccess', 'Successfully added.');

        return redirect('lolo-pinoy-lechon-de-cebu/add-new-delivery-receipt/'.$id);


    }

    //add new delivery receipt
    public function addNewDeliveryReceipt($id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-lechon-de-cebu-delivery-receipt', compact('user', 'id'));
    }

    //update delivery receipt
    public function updateDeliveryReceipt(Request $request, $id){

        $updateDeliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);

        $updateDeliveryReceipt->sold_to = $request->get('soldTo');
        $updateDeliveryReceipt->time = $request->get('time');
        $updateDeliveryReceipt->delivered_to = $request->get('deliveredTo');
        $updateDeliveryReceipt->contact_person = $request->get('contactPerson');
        $updateDeliveryReceipt->mobile_num = $request->get('mobile');
        $updateDeliveryReceipt->special_instruction = $request->get('specialInstruction');
        $updateDeliveryReceipt->consignee_name = $request->get('consigneeName');
        $updateDeliveryReceipt->consignee_contact_num = $request->get('consigneeContact');
        $updateDeliveryReceipt->qty = $request->get('qty');
        $updateDeliveryReceipt->description = $request->get('description');
        $updateDeliveryReceipt->price = $request->get('price');

        $updateDeliveryReceipt->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/'.$id);
    }

    //edit delivery receipt
    public function editDeliveryReceipt($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getDeliveryReceipt
        $getDeliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);

        //dReceipts
        $dReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-lechon-de-cebu-delivery-receipt', compact('user','getDeliveryReceipt', 'dReceipts'));
    }

    //store delivery receipt
    public function storeDeliveryReceipt(Request $request){
         //validate
        $this->validate($request, [
            'soldTo' =>'required',
           
        ]);

        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table delivery receipt dr_no
        $dataDrNo = DB::select('SELECT id, dr_no FROM lechon_de_cebu_delivery_receipts ORDER BY id DESC LIMIT 1');

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

        $storeDeliveryReceipt = new LechonDeCebuDeliveryReceipt([
            'user_id'=>$user->id,
            'sold_to'=>$request->get('soldTo'),
            'time'=>$request->get('time'),
            'dr_no'=>$uDr,
            'date'=>$getDateToday,
            'date_to_be_delivered'=>$request->get('dateDelivered'),
            'delivered_to'=>$request->get('deliveredTo'),
            'contact_person'=>$request->get('contactPerson'),
            'mobile_num'=>$request->get('mobile'),
            'special_instruction'=>$request->get('specialInstruction'),
            'consignee_name'=>$request->get('consigneeName'),
            'consignee_contact_num'=>$request->get('consigneeContact'),
            'qty'=>$request->get('qty'),
            'description'=>$request->get('description'),
            'price'=>$request->get('price'),
            'total'=>$request->get('price'),
            'prepared_by'=>$name,
            'created_by'=>$name,
        ]);

        $storeDeliveryReceipt->save();
        $insertedId  = $storeDeliveryReceipt->id;

        return redirect('lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/'.$insertedId);

    }

    //delivery receipt
    public function deliveryReceiptForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('lechon-de-cebu-delivery-receipt-form', compact('user'));
    }


    //payment voucher view
    public function viewPaymentVoucher($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //paymentVoucher
        $paymentVoucher = LechonDeCebuPaymentVoucher::find($id);

        $pVouchers = LechonDeCebuPaymentVoucher::where('pv_id', $id)->get()->toArray();


         //count the total amount 
        $countTotalAmount = LechonDeCebuPaymentVoucher::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuPaymentVoucher::where('pv_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-payment-voucher', compact('user', 'paymentVoucher', 'pVouchers', 'sum'));
    }

    //payment voucher > cheque vouchers
    public function chequeVouchers(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getAllChequeVouchers
        $method = "Cheque";

        $getAllChequeVouchers = LechonDeCebuPaymentVoucher::where('method_of_payment', $method)->get()->toArray(); 

        return view('cheque-vouchers-lists', compact('user', 'getAllChequeVouchers')); 
    }

    //payment voucher > cash vouchers
    public function cashVouchers(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getAllCashVouchers
        $method = "Cash";

        $getAllCashVouchers = LechonDeCebuPaymentVoucher::where('method_of_payment', $method)->get()->toArray();

        return view('cash-vouchers-lists', compact('user', 'getAllCashVouchers'));
    }

    //update payment voucher pv
    public function updatePV(Request $request, $id){

        $updatePV = LechonDeCebuPaymentVoucher::find($id);
      

        $updatePV->particulars = $request->get('particulars');
        $updatePV->amount = $request->get('amount');

        $updatePV->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-lechon-de-cebu/edit-payment-voucher/'.$request->get('pvId'));

    }

    //add new payment voucher data
    public function addNewPaymentVoucherData(Request $request, $id){
       
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentVoucher = LechonDeCebuPaymentVoucher::find($id);

        $addNewPaymentVoucherData = new LechonDeCebuPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'reference_number'=>$paymentVoucher['reference_number'],
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewPaymentVoucherData->save();

        Session::flash('addPaymentVoucherSuccess', 'Successfully added.');

        return redirect('lolo-pinoy-lechon-de-cebu/add-new-payment-voucher/'.$id);
    }


    //add new payment voucher
    public function addNewPaymentVoucher($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-payment-voucher', compact('user', 'id'));
    }

    //update payment voucher
    public function updatePaymentVoucher(Request $request, $id){

        $updatePaymentVoucher = LechonDeCebuPaymentVoucher::find($id);

        $updatePaymentVoucher->paid_to = $request->get('paidTo');
        $updatePaymentVoucher->account_no = $request->get('accountNo');
        $updatePaymentVoucher->date = $request->get('date');
        $updatePaymentVoucher->particulars = $request->get('particulars');
        $updatePaymentVoucher->amount = $request->get('amount');
        $updatePaymentVoucher->method_of_payment = $request->get('methodOfPayment');

        $updatePaymentVoucher->save();

         Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-payment-voucher/'.$id);
    }

    //payment voucher edit
    public function editPaymentVoucher($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);


        //getPaymentVoucher 
        $getPaymentVoucher = LechonDeCebuPaymentVoucher::find($id);

        //pVoucher
        $pVouchers = LechonDeCebuPaymentVoucher::where('pv_id', $id)->get()->toArray();
       

        return view('edit-payment-voucher', compact('user', 'getPaymentVoucher', 'pVouchers'));
    }

    //payment voucher store 
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
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM lechon_de_cebu_payment_vouchers ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->voucher_ref_number) != 0){
            //if code is not 0
            $newVoucherRef= $dataVoucherRef[0]->voucher_ref_number +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
        } 

        //check if invoice number already exists
        $target = DB::table(
                        'lechon_de_cebu_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...
             $addPaymentVoucher = new LechonDeCebuPaymentVoucher([
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
            
             return redirect()->route('editPayablesDetail', ['id'=>$insertedId]);

        }else{
            return redirect()->route('paymentVoucherForm')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }


      

    }

    //payment voucher form
    public function paymentVoucherForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('payment-voucher-form',compact('user'));
        
    }

  
    //view stocks inventory
    public function viewStocksInventory($id){   
         $ids = Auth::user()->id;
        $user = User::find($ids);
        
        return view('view-lechon-de-cebu-stocks-inventory', compact('user'));
    }
  

    //stocks inventory
    public function stocksInventory(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

    
        //getRawMaterial
        $getRawMaterials = CommissaryRawMaterial::where('rm_id', NULL)->get()->toArray();

        //count the total stock out amount value
        $countStockAmount = CommissaryRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = CommissaryRawMaterial::where('rm_id', NULL)->sum('amount');

        return view('commissary-stocks-inventory', compact('user', 'getRawMaterials', 'countStockAmount', 'countTotalAmount'));
    }

    //view statement of account
    public function viewStatementAccount($id){
       
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //viewStatementAccount
        $viewStatementAccount = LechonDeCebuBillingStatement::where('id', $id)->get()->toArray();
       
        
        $statementAccounts = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->get();


        //count the total amount 
        $countTotalAmount = LechonDeCebuBillingStatement::where('id', $id)->sum('amount');

          //
        $countAmount = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


         //count the total balance if there are paid amount
        $paidAmountCount = LechonDeCebuBillingStatement::where('id', $id)->sum('paid_amount');
       
        //
        $countAmountOthersPaid = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');
        
        $compute  = $paidAmountCount + $countAmountOthersPaid;


        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;
    

        return view('view-lechon-de-cebu-statement-account', compact('user','viewStatementAccount', 'statementAccounts', 'sum', 'computeAll'));
    }

    //updateAddStatement
    public function updateAddStatement(Request $request, $id){
        $addedStatementAccount = LechonDeCebuStatementOfAccount::find($id);

        $statementAccountId = $request->get('statementAccountId');

        $addedStatementAccount->date = $request->get('date');
        $addedStatementAccount->branch = $request->get('branch');
        $addedStatementAccount->kilos = $request->get('kilos');
        $addedStatementAccount->unit_price = $request->get('unitPrice');
        $addedStatementAccount->payment_method = $request->get('paymentMethod');
        $addedStatementAccount->amount = $request->get('amount');
        $addedStatementAccount->status = $request->get('status');
        $addedStatementAccount->paid_amount = $request->get('paidAmount');
        $addedStatementAccount->collection_date = $request->get('collectionDate');
        $addedStatementAccount->check_number = $request->get('checkNumber');
        $addedStatementAccount->check_amount = $request->get('checkAmount');
        $addedStatementAccount->or_number = $request->get('orNumber');

        $addedStatementAccount->save();

        Session::flash('SuccessEdit', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-statement-of-account/'.$statementAccountId);

    }



    //add new statement of account data
    public function addNewStatementData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $statement = LechonDeCebuStatementOfAccount::find($id);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

         //get the latest insert id query in table billing statements ref number
        $dataInvoiceNum = DB::select('SELECT id, invoice_number FROM lechon_de_cebu_statement_of_accounts ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 inovice number
        if(isset($dataInvoiceNum[0]->invoice_number) != 0){
            //if code is not 0
            $newInvoice = $dataInvoiceNum[0]->invoice_number +1;
            $uInvoice = sprintf("%06d",$newInvoice);   

        }else{
            //if code is 0 
            $newInvoice = 1;
            $uInvoice = sprintf("%06d",$newInvoice);
        } 

        $addNewStatement = new LechonDeCebuStatementOfAccount([
            'date'=>$request->get('date'),
            'user_id'=>$user->id,
            'soa_id'=>$id,
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

        $addNewStatement->save();

        Session::flash('addStatementSuccess', 'Successfully added.');

        return redirect('lolo-pinoy-lechon-de-cebu/add-new-statement-account/'.$id);


    }

    //add new statement of account
    public function addNewStatementAccount($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-lechon-de-cebu-statement-account', compact('user', 'id'));
    }

    //edit statement of account
    public function editStatementAccount($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        //getStatementOfAccount
        $getStatementOfAccount = LechonDeCebuBillingStatement::find($id);
    
        //
       $sAccounts = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();
     
       //AllAcounts not yet paid
       $allAccounts = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->where('status', NULL)->get()->toArray();

    
       $stat = "PAID";

       $allAccountsPaids = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->where('status', $stat)->get()->toArray();  

        //$sAccounts = LechonDeCebuStatementOfAccount::where('soa_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuBillingStatement::where('id', $id)->sum('amount');

          //
        $countAmount = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        //count the total balance if there are paid amount
        $paidAmountCount = LechonDeCebuBillingStatement::where('id', $id)->sum('paid_amount');
       
        //
        $countAmountOthersPaid = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');
        
        $compute  = $paidAmountCount + $countAmountOthersPaid;


        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;


        return view('edit-statement-of-account', compact('user', 'getStatementOfAccount', 'computeAll','sAccounts', 'allAccounts', 'allAccountsPaids', 'sum'));
    }


    //statement of account lists
    public function statementOfAccountLists(){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        /*$status = "Unpaid";
        $paid = "Paid";

        //get statement of account 
        $statementOfAccounts = LechonDeCebuStatementOfAccount::where('soa_id', NULL)->where('status', $status)->get()->toArray();

        $statementOfAccountPaids = LechonDeCebuStatementOfAccount::where('soa_id', NULL)->where('status', $paid)->get()->toArray();*/

        //$status = "Unpaid";
        //$paid = "Paid";
        $statementOfAccounts = LechonDeCebuBillingStatement::where('bill_to', '!=', NULL)->get()->toArray();


        //$statementOfAccountsPaids = LechonDeCebuStatementOfAccount::where('bill_to', '!=', NULL)->where('status', $paid)->get()->toArray();

        return view('lechon-de-cebu-statement-of-account-lists', compact('user', 'statementOfAccounts', 'statementOfAccountsPaids'));
    }

    //store statement of account
    public function storeStatementAccount(Request $request){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName.$lastName;

         //validate
        $this->validate($request, [
            'date' =>'required',
            'kilos'=>'required',
            'amount'=>'required',
            'checkAmount'=>'required',
        ]);


         //get the latest insert id query in table statement of account invoice number
        $invoiceNumber = DB::select('SELECT id, invoice_number FROM lechon_de_cebu_statement_of_accounts ORDER BY id DESC LIMIT 1');

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

        $addStatementAccount =  new LechonDeCebuStatementOfAccount([
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

        return redirect('lolo-pinoy-lechon-de-cebu/edit-statement-of-account/'.$insertedId);



    }

    //statement of account
    public function statementOfAccount(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('lechon-de-cebu-statement-of-account-form', compact('user'));
    }

    //
    public function printBillingDelivery($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $deliveryId = LechonDeCebuDeliveryReceipt::find($id);

        $deliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuDeliveryReceipt::where('id', $id)->sum('price');


          //
        $countAmount = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printBillingDelivery', compact('deliveryId', 'deliveryReceipts', 'sum'));

        return $pdf->download('lechon-de-cebu-billing-statement-delivery.pdf');  
    }

    //
    public function printSsps($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $printSales = LechonDeCebuSalesInvoice::find($id);

        $salesInvoices = LechonDeCebuSalesInvoice::where('si_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printBillingSsp', compact('printSales', 'salesInvoices', 'sum'));

        return $pdf->download('lechon-de-cebu-billing-statement-ssp.pdf');
    }

    //
    public function viewPerAccountDeliveryReceipt($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewDeliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);


        $deliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = LechonDeCebuDeliveryReceipt::where('id', $id)->sum('price');
       

        //
        $countAmount = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;
        

        return view('view-lechon-de-cebu-billing-statement-per-acccount-delivery', compact('user', 'viewDeliveryReceipt', 'deliveryReceipts', 'sum'));
    }

    //
    public function viewSsps($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $viewSalesInvoice = LechonDeCebuSalesInvoice::find($id);

        $salesInvoices = LechonDeCebuSalesInvoice::where('si_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = LechonDeCebuSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-billing-statement-ssps', compact('user', 'viewSalesInvoice', 'salesInvoices', 'sum'));
    }

    //
    public function viewPerAccountsBilling(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

         $ids = Auth::user()->id;
        $user = User::find($ids);

        //getSalesInvoiceTerminal1
        $branch = "Ssp Food Avenue Terminal 1";
        $branch2 = "Ssp Food Avenue Terminal 2";

        $statementOfAccountT1s = LechonDeCebuSalesInvoice::where('ordered_by', $branch)->get()->toArray();


        $statementOfAccountT2s = LechonDeCebuSalesInvoice::where('ordered_by', $branch2)->get()->toArray();

        //getAllDeliveryReceipt
        $getAllDeliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', NULL)->get()->toArray();


        return view('lechon-de-cebu-view-per-accounts-billing-statement', compact('user', 'statementOfAccountT1s', 'statementOfAccountT2s', 'getAllDeliveryReceipts'));
    }


    //viewBillingStatement
    public function viewBillingStatement($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewBillingStatement = LechonDeCebuBillingStatement::find($id);
        

        $billingStatements = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-lechon-de-cebu-billing-statement', compact('user', 'viewBillingStatement', 'billingStatements', 'sum'));
    }


    //updateBilling info
    public function updateBillingInfo(Request $request, $id){

        $updateBillingOrder = LechonDeCebuBillingStatement::find($id);

        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $updateBillingOrder->bill_to = $request->get('billTo');
        $updateBillingOrder->address = $request->get('address');
        $updateBillingOrder->period_cover = $request->get('periodCovered');
        $updateBillingOrder->date = $request->get('date');
        $updateBillingOrder->terms = $request->get('terms');
        $updateBillingOrder->branch = $request->get('branch');
        $updateBillingOrder->p_o_number = $request->get('poNumber');
        $updateBillingOrder->invoice_number = $request->get('invoiceNumber');
        $updateBillingOrder->date_of_transaction = $request->get('transactionDate');
        $updateBillingOrder->whole_lechon = $wholeLechon;
        $updateBillingOrder->description = $request->get('description');
        $updateBillingOrder->amount = $add;

        $updateBillingOrder->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-billing-statement/'.$id);
    }

    //updateBillingStatement
    public function updateBillingStatement(Request $request, $id){

        $updateBilling = LechonDeCebuBillingStatement::find($id);

        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 

        $updateBilling->date_of_transaction = $request->get('transactionDate');
        $updateBilling->whole_lechon = $wholeLechon;
        $updateBilling->description = $request->get('description');
        $updateBilling->invoice_number = $request->get('invoiceNumber');
        $updateBilling->amount = $add;

        $updateBilling->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-lechon-de-cebu/edit-billing-statement/'.$request->get('billingStatementId'));
    }


    //billing statement lists
    public function billingStatementLists(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingStatements = LechonDeCebuBillingStatement::where('billing_statement_id', NULL)->get()->toArray();


        return view('lechon-de-cebu-billing-statement-lists', compact('user', 'billingStatements'));
    }


    //add new billing statement form 
    public function addNewBillingData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = LechonDeCebuBillingStatement::find($id);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the whole lechon then multiply by 500
        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 


        $addBillingStatement = new LechonDeCebuBillingStatement([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'reference_number'=>$billingOrder['reference_number'],
            'p_o_number'=>$billingOrder['p_o_number'],
            'branch'=>$request->get('branch'),
            'date_of_transaction'=>$request->get('transactionDate'),
            'invoice_number'=>$request->get('invoiceNumber'),
            'whole_lechon'=>$wholeLechon,
            'description'=>$request->get('description'),
            'amount'=>$add,
            'created_by'=>$name,
        ]);

        $addBillingStatement->save();

        //save to table statement of account
        $addStatementAccount = new LechonDeCebuStatementOfAccount([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'reference_number'=>$billingOrder['reference_number'],
            'p_o_number'=>$billingOrder['p_o_number'],
            'branch'=>$request->get('branch'),
            'transaction_date'=>$request->get('transactionDate'),
            'invoice_number'=>$request->get('invoiceNumber'),
            'whole_lechon'=>$wholeLechon,
            'description'=>$request->get('description'),
            'amount'=>$add,
            'created_by'=>$name,

        ]);

        $addStatementAccount->save();

        Session::flash('addBillingSuccess', 'Successfully added.');

        return redirect('lolo-pinoy-lechon-de-cebu/add-new-billing/'.$id);
        
    }

    //add new billing statement
    public function addNewBilling($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        return view('add-new-lechon-de-cebu-billing-statement', compact('user', 'id'));
    }


    //edit billing statement 
    public function editBillingStatement($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $billingStatement = LechonDeCebuBillingStatement::find($id);
       
        $bStatements = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //get the purchase order lists
        $getPurchaseOrders = LechonDeCebuPurchaseOrder::where('po_id', NULL)->get()->toArray();
        
        return view('edit-billing-statement-form', compact('user', 'billingStatement', 'bStatements', 'getPurchaseOrders'));
    }

    //storeBillingStatement
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
        $dataReferenceNum = DB::select('SELECT id, reference_number FROM lechon_de_cebu_billing_statements ORDER BY id DESC LIMIT 1');

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

       
        $billingStatement = new LechonDeCebuBillingStatement([
            'user_id'=>$user->id,
            'bill_to'=>$request->get('billTo'),
            'address'=>$request->get('address'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'invoice_number'=>$request->get('invoiceNumber'),
            'reference_number'=>$uRef,
            'p_o_number'=>$request->get('poNumber'),
            'branch'=>$request->get('branch'),
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

        //Session::flash('billingStatementSuccess', 'Successfully added');
         
        return redirect('lolo-pinoy-lechon-de-cebu/edit-billing-statement/'.$insertedId);

    }

    //billing statement form
    public function billingStatementForm(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        //get the purchase order lists
        $getPurchaseOrders = LechonDeCebuPurchaseOrder::where('po_id', NULL)->get()->toArray();

        //get data from sales invoice invoice #
        $getSalesInvoices = LechonDeCebuSalesInvoice::where('invoice_number', '!=', NULL)->get()->toArray();
       

        return view('lechon-de-cebu-billing-statement-form', compact('user', 'getPurchaseOrders', 'getSalesInvoices'));
    }

    //update-po
    public function updatePo(Request $request, $id){
        
        $order = LechonDeCebuPurchaseOrder::find($id);
        

        $order->quantity = $request->get('quant');
        $order->description = $request->get('desc');
        $order->unit_price = $request->get('unitP');
        $order->amount = $request->get('amt');

        $order->save();


        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-lechon-de-cebu/edit/'.$request->get('poId'));
    }

    //save new purchase order
    public function addNewPurchaseOrder(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pO = LechonDeCebuPurchaseOrder::find($id);


        $addPurchaseOrder = new LechonDeCebuPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addPurchaseOrder->save();

        Session::flash('purchaseOrderSuccess', 'Successfully added purchase order');

        return redirect('lolo-pinoy-lechon-de-cebu/add-new/'.$id);
    }

    //add new purchase order
    public function addNew($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        
        return view('add-new-lechon-de-cebu-purchase-order', compact('user', 'id'));

    }


    //all lists
    public function purchaseOrderAllLists(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        $purchaseOrders = LechonDeCebuPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('lechon-de-cebu-all-lists', compact('user', 'purchaseOrders'));
    }

    //purchase order
    public function purchaseOrder(){
        $id =  Auth::user()->id;
        $user = User::find($id);

        return view('lechon-de-cebu-purchase-order', compact('user'));
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

        $getAllSalesInvoices = LechonDeCebuSalesInvoice::where('si_id', NULL)->get()->toArray();

        //
        $total = LechonDeCebuSalesInvoice::where('ordered_by', '!=', NULL)->sum('amount');

        return view('lolo-pinoy-lechon-de-cebu', compact('user', 'getAllSalesInvoices','total'));
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

        //get the latest insert id query in table purchase order
        $data = DB::select('SELECT id, p_o_number FROM lechon_de_cebu_purchase_orders ORDER BY id DESC LIMIT 1');
        
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
       
        $purchaseOrder = new LechonDeCebuPurchaseOrder([
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
            'created_by'=>$name,
        ]);


        $purchaseOrder->save();

        $insertedId = $purchaseOrder->id;
         
        return redirect('lolo-pinoy-lechon-de-cebu/edit/'.$insertedId);
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

        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);


        //
        $pOrders = LechonDeCebuPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        

        return view('view-lechon-de-cebu-purchase-order', compact('user', 'purchaseOrder', 'pOrders', 'sum'));
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

        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);

        $pOrders = LechonDeCebuPurchaseOrder::where('po_id', $id)->get()->toArray();

        //get users
        $getUsers = User::get()->toArray();
       

        return view('edit-lechon-de-cebu-purchase-order', compact('user', 'purchaseOrder', 'pOrders', 'getUsers'));
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

        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);
        
        $purchaseOrder->paid_to = $paidTo;
        $purchaseOrder->address = $address;
        $purchaseOrder->date = $date;
        $purchaseOrder->description = $description;
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();


        Session::flash('SuccessE', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit/'.$id);


    }

    public function destroyPettyCash($id){
        $pettyCash = LechonDeCebuPettyCash::find($id);
        $pettyCash->delete();
    }

    public function destroyTransactionList($id){
        $transactionList = LechonDeCebuPaymentVoucher::find($id);
        $transactionList->delete();
    }

    //delete RAW materials
    public function destroyRawMaterial($id){
        $rawMaterial = CommissaryRawMaterial::find($id);
        $rawMaterial->delete();
    }

    //delete sales invoice 
    public function destroySalesInvoice($id){
        $salesInvoice = LechonDeCebuSalesInvoice::find($id);
        $salesInvoice->delete();
    }

    //delete delivery receipt
    public function destroyDeliveryReceipt($id){
        $deliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);
        $deliveryReceipt->delete();
    }

    //delete payment voucher 
    public function destroyPaymentVoucher($id){
        $paymentVoucher = LechonDeCebuPaymentVoucher::find($id);
        $paymentVoucher->delete();
    }

   


    //delete billing statement
    public function destroyBillingStatement($id){
        //
        $billingStatement = LechonDeCebuBillingStatement::find($id);
        $billingStatement->delete();
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
        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }
}
