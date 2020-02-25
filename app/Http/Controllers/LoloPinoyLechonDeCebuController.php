<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
use Session;

class LoloPinoyLechonDeCebuController extends Controller
{
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

        $name  = $firstName.$lastName;

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

        $getRawMaterials = CommissaryRawMaterial::get()->toArray();

        return view('commissary-raw-materials', compact('user', 'getRawMaterials'));
    }

    //view sales invoice
    public function viewSalesInvoice($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewSalesInvoice = LechonDeCebuSalesInvoice::find($id);

        $salesInvoices = LechonDeCebuSalesInvoice::where('si_id', $id)->get()->toArray();

        return view('view-lechon-de-cebu-sales-invoice', compact('user', 'viewSalesInvoice', 'salesInvoices'));

    }

    //update for the add new sales invoice
    public function updateSi(Request $request, $id){

        $updateSi = LechonDeCebuSalesInvoice::find($id);

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

        return redirect('lolo-pinoy-lechon-de-cebu/edit-sales-invoice/'.$request->get('siId'));

    }

    //add new sales invoice
    public function addNewSalesInvoiceData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

          //get date today
        $getDateToday =  date('Y-m-d');

        //kls
        $kls  = $request->get('totalKls');

         //compute kls * unit price
        $unitPrice = 500;
        $compute = $kls * $unitPrice;
        $sum = $compute;

        $addNewSalesInvoice = new LechonDeCebuSalesInvoice([
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


        return redirect('lolo-pinoy-lechon-de-cebu/add-new-sales-invoice/'. $id);
    }

    //add new sales invoice
    public function addNewSalesInvoice($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

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


        $addSalesInvoice = new LechonDeCebuSalesInvoice([
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


        return view('view-delivery-duplicate', compact('user', 'viewDeliveryReceiptDuplicate', 'deliveryReceiptDuplicates'));
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

        

        return view('view-lechon-de-cebu-delivery-receipt', compact('user', 'viewDeliveryReceipt', 'deliveryReceipts'));
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

        $name  = $firstName.$lastName;

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

        return view('view-payment-voucher', compact('user', 'paymentVoucher', 'pVouchers'));
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

        $name  = $firstName.$lastName;

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

        $name  = $firstName.$lastName;

         //get the latest insert id query in table payment voucher ref number
        $dataReferenceNum = DB::select('SELECT id, reference_number FROM lechon_de_cebu_payment_vouchers ORDER BY id DESC LIMIT 1');

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

        $addPaymentVoucher = new LechonDeCebuPaymentVoucher([
            'user_id'=>$user->id,
            'reference_number'=>$uRef,
            'paid_to'=>$request->get('paidTo'),
            'account_no'=>$request->get('accountNo'),
            'date'=>$request->get('date'),
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'method_of_payment'=>$request->get('paymentMethod'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $addPaymentVoucher->save();
        $insertedId = $addPaymentVoucher->id; 

        return redirect('lolo-pinoy-lechon-de-cebu/edit-payment-voucher/'.$insertedId);

    }

    //payment voucher form
    public function paymentVoucherForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('payment-voucher-form',compact('user'));
    }

  

    //update commissary stocks inventory
    public function updateStocksInventory(Request $request, $id){
        $updateStocksInventory = CommissaryStockInventory::find($id);

        $updateStocksInventory->branch = $request->get('branch');
        $updateStocksInventory->product_name = $request->get('productName');
        $updateStocksInventory->unit_price = $request->get('unitPrice');
        $updateStocksInventory->unit = $request->get('unit');
        $updateStocksInventory->in = $request->get('in');
        $updateStocksInventory->out = $request->get('out');
        $updateStocksInventory->stock_amount = $request->get('stockAmount');
        $updateStocksInventory->remaining_stock = $request->get('remainingStock');
        $updateStocksInventory->amount = $request->get('amount');
        $updateStocksInventory->supplier = $request->get('supplier');

        $updateStocksInventory->save();

        Session::flash('successStocksInventory', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/commissary/edit-stocks-inventory/'.$id);

    }

    //edit commissary stocks inventory
    public function editStocksInventory($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $getStocksInventory = CommissaryStockInventory::find($id);

        return view('edit-commissary-stocks-inventory', compact('user', 'getStocksInventory'));
    }

    //commissary add stocks inventory
    public function addStockInventory(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        //validate
        $this->validate($request,[
            'productName' =>'required',
        ]);

         //get the latest insert id query in table commissary stock inventories product id no
        $dataProductId = DB::select('SELECT id, product_id_no FROM commissary_stock_inventories ORDER BY id DESC LIMIT 1');

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


        $addNewStock = new CommissaryStockInventory([
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

        $addNewStock->save();

        Session::flash('addStockInventory', 'Successfully added.');

        return redirect('lolo-pinoy-lechon-de-cebu/commissary/create-stocks');
    }

    //commissary create stocks inventory
    public function commissaryCreateStocks(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        return view('commissary-add-stocks-inventory', compact('user'));
    }


    //stocks inventory
    public function stocksInventory(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getStocksInventory
        $getStocksInventories = CommissaryStockInventory::get()->toArray();

        //count the total stock out amount value
        $countStockAmount = CommissaryStockInventory::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = CommissaryStockInventory::all()->sum('amount');

        return view('commissary-stocks-inventory', compact('user', 'getStocksInventories', 'countStockAmount', 'countTotalAmount'));
    }

    //view statement of account
    public function viewStatementAccount($id){
       
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getStatementAccounts
        $getStatementAccounts = LechonDeCebuStatementOfAccount::where('id', $id)->get()->toArray();

        return view('view-lechon-de-cebu-statement-account', compact('user','getStatementAccounts'));
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

    //update statment info
    public function updateStatementInfo(Request $request, $id){
        $updateStatmentInfo = LechonDeCebuStatementOfAccount::find($id);

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

        return redirect('lolo-pinoy-lechon-de-cebu/edit-statement-of-account/'.$id);
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
        $getStatementOfAccount = LechonDeCebuStatementOfAccount::find($id);

        $sAccounts = LechonDeCebuStatementOfAccount::where('soa_id', $id)->get()->toArray();
        
        return view('edit-statement-of-account', compact('user', 'getStatementOfAccount', 'sAccounts'));
    }


    //statement of account lists
    public function statementOfAccountLists(){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $status = "Unpaid";
        $paid = "Paid";

        //get statement of account 
        $statementOfAccounts = LechonDeCebuStatementOfAccount::where('soa_id', NULL)->where('status', $status)->get()->toArray();

        $statementOfAccountPaids = LechonDeCebuStatementOfAccount::where('soa_id', NULL)->where('status', $paid)->get()->toArray();


        return view('lechon-de-cebu-statement-of-account-lists', compact('user', 'statementOfAccounts', 'statementOfAccountPaids'));
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


    //viewBillingStatement
    public function viewBillingStatement($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewBillingStatement = LechonDeCebuBillingStatement::find($id);
        

        $billingStatements = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        return view('view-lechon-de-cebu-billing-statement', compact('user', 'viewBillingStatement', 'billingStatements'));
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

        $name  = $firstName.$lastName;

        //get the whole lechon then multiply by 500
        $wholeLechon = $request->get('wholeLechon');
        $add = $wholeLechon * 500; 


        $addBillingStatement = new LechonDeCebuBillingStatement([
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
        $name  = $firstName.$lastName;

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
       

        return view('lechon-de-cebu-billing-statement-form', compact('user', 'getPurchaseOrders'));
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

        $name  = $firstName.$lastName;

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

        return view('lolo-pinoy-lechon-de-cebu', compact('user', 'getAllSalesInvoices'));
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

        Session::flash('purchaseOrderSuccess', 'Successfully added');
         
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
        

        return view('view-lechon-de-cebu-purchase-order', compact('user', 'purchaseOrder', 'pOrders'));
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

        $name  = $firstName.$lastName;

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
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();


        Session::flash('SuccessE', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit/'.$id);


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

    //delete commissary stocks inventory
    public function destroyStocksInventory($id){
        $stocksInventory = CommissaryStockInventory::find($id);
        $stocksInventory->delete();
    }

    //delete statement account
    public function destroyStatementAddAccount($id){
        $statementAccount = LechonDeCebuStatementOfAccount::find($id);
        $statementAccount->delete();
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
