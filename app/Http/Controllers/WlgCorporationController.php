<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth; 
use Session; 
use PDF;
use App\User;
use App\WlgCorporationPaymentVoucher;
use App\WlgCorporationPurchaseOrder;
use App\WlgCorporationInvoice;
use App\WlgCorporationCode;


class WlgCorporationController extends Controller
{

    public function summaryReport(){
        $getDateToday = date("Y-m-d");

        $moduleName = "Purchase Order";
        $purchaseOrders = DB::table(
                        'wlg_corporation_purchase_orders')
                        ->select(
                            'wlg_corporation_purchase_orders.id',
                            'wlg_corporation_purchase_orders.user_id',
                            'wlg_corporation_purchase_orders.po_id',
                            'wlg_corporation_purchase_orders.paid_to',
                            'wlg_corporation_purchase_orders.address',
                            'wlg_corporation_purchase_orders.date',
                            'wlg_corporation_purchase_orders.model',
                            'wlg_corporation_purchase_orders.particulars',
                            'wlg_corporation_purchase_orders.quantity',
                            'wlg_corporation_purchase_orders.unit_price',
                            'wlg_corporation_purchase_orders.amount',
                            'wlg_corporation_purchase_orders.requested_by',
                            'wlg_corporation_purchase_orders.prepared_by',
                            'wlg_corporation_purchase_orders.checked_by',
                            'wlg_corporation_purchase_orders.created_by',
                            'wlg_corporation_purchase_orders.created_at',
                            'wlg_corporation_codes.wlg_code',
                            'wlg_corporation_codes.module_id',
                            'wlg_corporation_codes.module_code',
                            'wlg_corporation_codes.module_name')
                        ->leftJoin('wlg_corporation_codes', 'wlg_corporation_purchase_orders.id', '=', 'wlg_corporation_codes.module_id')
                        ->where('wlg_corporation_purchase_orders.po_id', NULL)
                        ->where('wlg_corporation_codes.module_name', $moduleName)
                        ->whereDate('wlg_corporation_purchase_orders.created_at', '=', date($getDateToday))
                        ->orderBy('wlg_corporation_purchase_orders.id', 'desc')
                        ->get()->toArray();

        return view('wlg-corporation-summary-report', compact('purchaseOrders'));
    }
   
    public function printPayablesWlg($id){
        $payableId = WlgCorporationPaymentVoucher::find($id);

        //getParticular details
         $getParticulars = WlgCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        $payablesVouchers = WlgCorporationPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = WlgCorporationPaymentVoucher::where('id', $id)->sum('amount_due');

        $countAmount = WlgCorporationPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesWlg', compact('payableId', 'user', 'payablesVouchers', 'sum', 'getParticulars'));

        return $pdf->download('wlg-corporation-payment-voucher.pdf');

    }

    public function viewPayableDetails($id){
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'wlg_corporation_payment_vouchers')
                            ->select( 
                            'wlg_corporation_payment_vouchers.id',
                            'wlg_corporation_payment_vouchers.user_id',
                            'wlg_corporation_payment_vouchers.pv_id',
                            'wlg_corporation_payment_vouchers.date',
                            'wlg_corporation_payment_vouchers.paid_to',
                            'wlg_corporation_payment_vouchers.account_no',
                            'wlg_corporation_payment_vouchers.account_name',
                            'wlg_corporation_payment_vouchers.particulars',
                            'wlg_corporation_payment_vouchers.amount',
                            'wlg_corporation_payment_vouchers.method_of_payment',
                            'wlg_corporation_payment_vouchers.prepared_by',
                            'wlg_corporation_payment_vouchers.approved_by',
                            'wlg_corporation_payment_vouchers.date_approved',
                            'wlg_corporation_payment_vouchers.received_by_date',
                            'wlg_corporation_payment_vouchers.created_by',
                            'wlg_corporation_payment_vouchers.invoice_number',
                            'wlg_corporation_payment_vouchers.voucher_ref_number',
                            'wlg_corporation_payment_vouchers.issued_date',
                            'wlg_corporation_payment_vouchers.category',
                            'wlg_corporation_payment_vouchers.amount_due',
                            'wlg_corporation_payment_vouchers.delivered_date',
                            'wlg_corporation_payment_vouchers.status',
                            'wlg_corporation_payment_vouchers.cheque_number',
                            'wlg_corporation_payment_vouchers.cheque_amount',
                            'wlg_corporation_payment_vouchers.sub_category',
                            'wlg_corporation_payment_vouchers.sub_category_account_id',
                            'wlg_corporation_codes.wlg_code',
                            'wlg_corporation_codes.module_id',
                            'wlg_corporation_codes.module_code',
                            'wlg_corporation_codes.module_name')
                            ->leftJoin('wlg_corporation_codes', 'wlg_corporation_payment_vouchers.id', '=', 'wlg_corporation_codes.module_id')
                            ->where('wlg_corporation_payment_vouchers.id', $id)
                            ->where('wlg_corporation_codes.module_name', $moduleName)
                            ->get();

        $getViewPaymentDetails = WlgCorporationPaymentVoucher::where('pv_id', $id)->get()->toArray();

         //getParticular details
         $getParticulars = WlgCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        return view('view-wlg-corporation-payable-details', compact('user', 'viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
   
    }

    public function viewInvoice($id){
        $viewInvoice = WlgCorporationInvoice::find($id);

        $invoices = WlgCorporationInvoice::where('if_id', $id)->get()->toArray();

        $totInvoice = WlgCorporationInvoice::where('id', $id)->sum('total_amount');
        $totInvoice2 = WlgCorporationInvoice::where('if_id', $id)->sum('total_amount');

        $sum =  $totInvoice + $totInvoice2;

        return view('view-wlg-corporation-invoice', compact('viewInvoice', 'invoices', 'sum'));
    }

    //update packing list
    public function updatePackingList(Request $request, $id){
        $updateInvoice = WlgCorporationInvoice::find($id);
        $updateInvoice->number_of_goods = $request->get('no');
        $updateInvoice->description_of_goods = $request->get('descGoods');
        $updateInvoice->qty = $request->get('qty');
        $updateInvoice->kg_cbm = $request->get('kg');
        $updateInvoice->gross_weight = $request->get('grossWeight');
        $updateInvoice->save();

        Session::flash('successEdit', 'Successfully updated');
        return redirect()->route('editPackingListWlg', ['id'=>$request->get('packingListId')]);
    }

    //update quotatation invoice
    public function updateQuotation(Request $request, $id){
        $updateInvoice = WlgCorporationInvoice::find($id);
        $updateInvoice->number_of_goods = $request->get('no');
        $updateInvoice->description_of_goods = $request->get('descGoods');
        $updateInvoice->qty = $request->get('qty');
        $updateInvoice->unit_price = $request->get('unitPrice');
        $updateInvoice->total_amount = $request->get('totalAmount');
        $updateInvoice->save();

        Session::flash('successEdit', 'Successfully updated');
        return redirect()->route('editQuotationInvoiceWlg', ['id'=>$request->get('quotationId')]);
    }

    //update commercial invoice
    public function updateCommercialInvoice(Request $request, $id){
        $updateInvoice = WlgCorporationInvoice::find($id);
        $updateInvoice->number_of_goods = $request->get('no');
        $updateInvoice->description_of_goods = $request->get('descGoods');
        $updateInvoice->qty = $request->get('qty');
        $updateInvoice->unit_price = $request->get('unitPrice');
        $updateInvoice->total_amount = $request->get('totalAmount');
        $updateInvoice->save();

        Session::flash('successEdit', 'Successfully updated');
        return redirect()->route('editCommercialInvoiceWlg', ['id'=>$request->get('commercialInvoiceId')]);
    }


    //update pro-forma invoice
    public function updateProForma(Request $request, $id){
        $updateInvoice = WlgCorporationInvoice::find($id);
        $updateInvoice->number_of_goods = $request->get('no');
        $updateInvoice->description_of_goods = $request->get('descGoods');
        $updateInvoice->qty = $request->get('qty');
        $updateInvoice->unit_price = $request->get('unitPrice');
        $updateInvoice->total_amount = $request->get('totalAmount');
        $updateInvoice->save();

        Session::flash('successEdit', 'Successfully updated');
        return redirect()->route('editInvoiceProForma', ['id'=>$request->get('proFormaId')]);
    }

    //update invoice form
    public function updateIF(Request $request, $id){
       
        $updateInvoice = WlgCorporationInvoice::find($id);
        $updateInvoice->number_of_goods = $request->get('no');
        $updateInvoice->description_of_goods = $request->get('descGoods');
        $updateInvoice->qty = $request->get('qty');
        $updateInvoice->unit_price = $request->get('unitPrice');
        $updateInvoice->total_amount = $request->get('totalAmount');
        $updateInvoice->save();

        Session::flash('successEdit', 'Successfully updated');
        return redirect()->route('editInvoiceWlg', ['id'=>$request->get('iFId')]);
    }

    //add new packing list
    public function addNewPackingList(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addNewInvoice = new WlgCorporationInvoice([
            'user_id'=>$user->id,
            'if_id'=>$id,
            'number_of_goods'=>$request->get('no'),
            'description_of_goods'=>$request->get('descGoods'),
            'qty'=>$request->get('qty'),
            'kg_cbm'=>$request->get('kg'),
            'gross_weight'=>$request->get('grossWeight'),
            'created_by'=>$name,
        ]);

        $addNewInvoice->save();
        Session::flash('successAdd', 'Successfully added');

        return redirect()->route('editPackingListWlg', ['id'=>$id]);
    }


    //add new for quotation
    public function addNewQuotation(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addNewInvoice = new WlgCorporationInvoice([
            'user_id'=>$user->id,
            'if_id'=>$id,
            'number_of_goods'=>$request->get('no'),
            'description_of_goods'=>$request->get('descGoods'),
            'qty'=>$request->get('qty'),
            'unit_price'=>$request->get('unitPrice'),
            'total_amount'=>$request->get('totalAmount'),
            'created_by'=>$name,
        ]);

        $addNewInvoice->save();
        Session::flash('successAdd', 'Successfully added');

        return redirect()->route('editQuotationInvoiceWlg', ['id'=>$id]);

    }

    //add new for commercial invoice
    public function addNewCommercialInvoice(Request $request, $id){ 
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addNewInvoice = new WlgCorporationInvoice([
            'user_id'=>$user->id,
            'if_id'=>$id,
            'number_of_goods'=>$request->get('no'),
            'description_of_goods'=>$request->get('descGoods'),
            'qty'=>$request->get('qty'),
            'unit_price'=>$request->get('unitPrice'),
            'total_amount'=>$request->get('totalAmount'),
            'created_by'=>$name,
        ]);

        $addNewInvoice->save();
        Session::flash('successAdd', 'Successfully added');

        return redirect()->route('editCommercialInvoiceWlg', ['id'=>$id]);
    }

    //add new for pro-forma invoice
    public function addNewInvoiceProForma(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addNewInvoice = new WlgCorporationInvoice([
            'user_id'=>$user->id,
            'if_id'=>$id,
            'number_of_goods'=>$request->get('no'),
            'description_of_goods'=>$request->get('descGoods'),
            'qty'=>$request->get('qty'),
            'unit_price'=>$request->get('unitPrice'),
            'total_amount'=>$request->get('totalAmount'),
            'created_by'=>$name,
        ]);

        $addNewInvoice->save();
        Session::flash('successAdd', 'Successfully added');

        return redirect()->route('editInvoiceProForma', ['id'=>$id]);

    }

    //add new for invoice form
    public function addNewInvoice(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $addNewInvoice = new WlgCorporationInvoice([
            'user_id'=>$user->id,
            'if_id'=>$id,
            'number_of_goods'=>$request->get('no'),
            'description_of_goods'=>$request->get('descGoods'),
            'qty'=>$request->get('qty'),
            'unit_price'=>$request->get('unitPrice'),
            'total_amount'=>$request->get('totalAmount'),
            'created_by'=>$name,
        ]);

        $addNewInvoice->save();
        Session::flash('successAdd', 'Successfully added');

        return redirect()->route('editInvoiceWlg', ['id'=>$id]);

    }
    

    //edit page for packing list
    public function editPackingList($id){
        $invoice  = WlgCorporationInvoice::find($id);

        $invoiceForms = WlgCorporationInvoice::where('if_id', $id)->get()->toArray();
        return view('edit-wlg-corportaion-invoice', compact('invoice', 'invoiceForms'));
    }

    //edit page for quitation invoice
    public function editQuotationInvoice($id){
        $invoice  = WlgCorporationInvoice::find($id);

        $invoiceForms = WlgCorporationInvoice::where('if_id', $id)->get()->toArray();
        return view('edit-wlg-corportaion-invoice', compact('invoice', 'invoiceForms'));
    }

    //edit page for commercial page
    public function editCommercialInvoice($id){
        $invoice  = WlgCorporationInvoice::find($id);

        $invoiceForms = WlgCorporationInvoice::where('if_id', $id)->get()->toArray();
        return view('edit-wlg-corportaion-invoice', compact('invoice', 'invoiceForms'));
    }

    //edit page for pro-forma invoice form 
    public function editInvoiceProForma($id){
        $invoice  = WlgCorporationInvoice::find($id);

        $invoiceForms = WlgCorporationInvoice::where('if_id', $id)->get()->toArray();
        return view('edit-wlg-corportaion-invoice', compact('invoice', 'invoiceForms'));
    }

    //edit page for invoice form
    public function editInvoice($id){   
        $invoice  = WlgCorporationInvoice::find($id);

        $invoiceForms = WlgCorporationInvoice::where('if_id', $id)->get()->toArray();
        return view('edit-wlg-corportaion-invoice', compact('invoice', 'invoiceForms'));
    }

    public function addPackingList(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $this->validate($request, [
            'date' => 'required',
            'deliveryTerms'=> 'required',
            'shipper'=>'required',
            'descGoods'=>'required',
        ]);

           //check if invoice number already exists
           $target = DB::table(
            'wlg_corporation_invoices')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        $status = "Packing List";
        if($target === NULL){
            $addInvoice = new WlgCorporationInvoice([
                'user_id'=>$user->id,
                'date'=>$request->get('date'),
                'delivery_terms'=>$request->get('deliveryTerms'),
                'tranport_by'=>$request->get('transportBy'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'shipper'=>$request->get('shipper'),
                'consignee'=>$request->get('consignee'),
                'notify_party'=>$request->get('notifyParty'),
                'attention'=>$request->get('attention'),
                'number_of_goods'=>$request->get('no'),
                'description_of_goods'=>$request->get('descGoods'),
                'qty'=>$request->get('qty'),
                'kg_cbm'=>$request->get('kg'),
                'gross_weight'=>$request->get('grossWeight'),
                'status'=>$status,
                'created_by'=>$name,
            ]);
    
            $addInvoice->save();
            $insertedId = $addInvoice->id;
    
            return redirect()->route('editPackingListWlg', ['id'=>$insertedId]);
        }else{
            return redirect()->route('invoiceFormPackingList')->with('error', 'Invoice Number Already Exists.');
        }

    }

    public function addQuotationInvoice(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        
        $this->validate($request, [
            'date' => 'required',
            'deliveryTerms'=> 'required',
            'shipper'=>'required',
            'descGoods'=>'required',
        ]);

          //check if invoice number already exists
        $target = DB::table(
            'wlg_corporation_invoices')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        $status = "Quotation Invoice";
        if($target === NULL){
            $addInvoice = new WlgCorporationInvoice([
                'user_id'=>$user->id,
                'date'=>$request->get('date'),
                'delivery_terms'=>$request->get('deliveryTerms'),
                'tranport_by'=>$request->get('transportBy'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'shipper'=>$request->get('shipper'),
                'consignee'=>$request->get('consignee'),
                'notify_party'=>$request->get('notifyParty'),
                'attention'=>$request->get('attention'),
                'number_of_goods'=>$request->get('no'),
                'description_of_goods'=>$request->get('descGoods'),
                'qty'=>$request->get('qty'),
                'unit_price'=>$request->get('unitPrice'),
                'total_amount'=>$request->get('totalAmount'),
                'status'=>$status,
                'created_by'=>$name,
            ]);
    
            $addInvoice->save();
            $insertedId = $addInvoice->id;
    
            return redirect()->route('editQuotationInvoiceWlg', ['id'=>$insertedId]);
        }else{
            return redirect()->route('invoiceFormQuotation')->with('error', 'Invoice Number Already Exists.');
        }

        
    }

    public function addCommercialInvoice(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        
        $this->validate($request, [
            'date' => 'required',
            'deliveryTerms'=> 'required',
            'shipper'=>'required',
            'descGoods'=>'required',
        ]);

         //check if invoice number already exists
        $target = DB::table(
            'wlg_corporation_invoices')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        $status = "Commercial Invoice";
        if($target === NULL){
            $addInvoice = new WlgCorporationInvoice([
                'user_id'=>$user->id,
                'date'=>$request->get('date'),
                'delivery_terms'=>$request->get('deliveryTerms'),
                'tranport_by'=>$request->get('transportBy'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'shipper'=>$request->get('shipper'),
                'consignee'=>$request->get('consignee'),
                'notify_party'=>$request->get('notifyParty'),
                'attention'=>$request->get('attention'),
                'number_of_goods'=>$request->get('no'),
                'description_of_goods'=>$request->get('descGoods'),
                'qty'=>$request->get('qty'),
                'unit_price'=>$request->get('unitPrice'),
                'total_amount'=>$request->get('totalAmount'),
                'status'=>$status,
                'created_by'=>$name,
            ]);
    
            $addInvoice->save();
            $insertedId = $addInvoice->id;
    
            return redirect()->route('editCommercialInvoiceWlg', ['id'=>$insertedId]);
        }else{
            return redirect()->route('invoiceFormCommercial')->with('error', 'Invoice Number Already Exists.');
        }

    }

    public function addProFormaInvoice(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


        $this->validate($request, [
            'date' => 'required',
            'deliveryTerms'=> 'required',
            'shipper'=>'required',
            'descGoods'=>'required',
        ]);

         //check if invoice number already exists
         $target = DB::table(
            'wlg_corporation_invoices')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        $status = "Pro-Forma Invoice";
        if($target === NULL){
            $addInvoice = new WlgCorporationInvoice([
                'user_id'=>$user->id,
                'date'=>$request->get('date'),
                'delivery_terms'=>$request->get('deliveryTerms'),
                'tranport_by'=>$request->get('transportBy'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'shipper'=>$request->get('shipper'),
                'consignee'=>$request->get('consignee'),
                'notify_party'=>$request->get('notifyParty'),
                'attention'=>$request->get('attention'),
                'number_of_goods'=>$request->get('no'),
                'description_of_goods'=>$request->get('descGoods'),
                'qty'=>$request->get('qty'),
                'unit_price'=>$request->get('unitPrice'),
                'total_amount'=>$request->get('totalAmount'),
                'status'=>$status,
                'created_by'=>$name,
            ]);
    
            $addInvoice->save();
            $insertedId = $addInvoice->id;
    
            return redirect()->route('editInvoiceProForma', ['id'=>$insertedId]);
        }else{
            return redirect()->route('invoiceFormProForma')->with('error', 'Invoice Number Already Exists.');
        }

    }

    public function addInvoice(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


        $this->validate($request, [
            'date' => 'required',
            'deliveryTerms'=> 'required',
            'shipper'=>'required',
            'descGoods'=>'required',
        ]);

         //check if invoice number already exists
         $target = DB::table(
            'wlg_corporation_invoices')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        $status = "Invoice Form";
        if($target === NULL){
            $addInvoice = new WlgCorporationInvoice([
                'user_id'=>$user->id,
                'date'=>$request->get('date'),
                'delivery_terms'=>$request->get('deliveryTerms'),
                'tranport_by'=>$request->get('transportBy'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'shipper'=>$request->get('shipper'),
                'consignee'=>$request->get('consignee'),
                'notify_party'=>$request->get('notifyParty'),
                'attention'=>$request->get('attention'),
                'number_of_goods'=>$request->get('no'),
                'description_of_goods'=>$request->get('descGoods'),
                'qty'=>$request->get('qty'),
                'unit_price'=>$request->get('unitPrice'),
                'total_amount'=>$request->get('totalAmount'),
                'status'=>$status,
                'created_by'=>$name,
            ]);
    
            $addInvoice->save();
            $insertedId = $addInvoice->id;
    
            return redirect()->route('editInvoiceWlg', ['id'=>$insertedId]);
        }else{
            return redirect()->route('invoiceFormWlg')->with('error', 'Invoice Number Already Exists.');
        }     
      
        
    }

    public function invoiceForm(){
        
        return view('wlg-corporation-invoice-form');
    }

    public function printPO($id){
        $purchaseOrder = WlgCorporationPurchaseOrder::find($id);

        $pOrders = WlgCorporationPurchaseOrder::where('po_id', $id)->get()->toArray();

            //count the total amount 
        $countTotalAmount = WlgCorporationPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = WlgCorporationPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printPOWlg', compact('purchaseOrder', 'pOrders', 'sum'));

        return $pdf->download('wlg-corporation-purchase-order.pdf');
    }

    public function purchaseOrderAllLists(){
        $moduleName = "Purchase Order";
        $purchaseOrders = DB::table(
                        'wlg_corporation_purchase_orders')
                        ->select(
                            'wlg_corporation_purchase_orders.id',
                            'wlg_corporation_purchase_orders.user_id',
                            'wlg_corporation_purchase_orders.po_id',
                            'wlg_corporation_purchase_orders.paid_to',
                            'wlg_corporation_purchase_orders.address',
                            'wlg_corporation_purchase_orders.date',
                            'wlg_corporation_purchase_orders.model',
                            'wlg_corporation_purchase_orders.particulars',
                            'wlg_corporation_purchase_orders.quantity',
                            'wlg_corporation_purchase_orders.unit_price',
                            'wlg_corporation_purchase_orders.amount',
                            'wlg_corporation_purchase_orders.requested_by',
                            'wlg_corporation_purchase_orders.prepared_by',
                            'wlg_corporation_purchase_orders.checked_by',
                            'wlg_corporation_purchase_orders.created_by',
                            'wlg_corporation_codes.wlg_code',
                            'wlg_corporation_codes.module_id',
                            'wlg_corporation_codes.module_code',
                            'wlg_corporation_codes.module_name')
                        ->leftJoin('wlg_corporation_codes', 'wlg_corporation_purchase_orders.id', '=', 'wlg_corporation_codes.module_id')
                        ->where('wlg_corporation_purchase_orders.po_id', NULL)
                        ->where('wlg_corporation_codes.module_name', $moduleName)
                        ->orderBy('wlg_corporation_purchase_orders.id', 'desc')
                        ->get()->toArray();

        return view('wlg-corporation-purchase-order-lists', compact('purchaseOrders'));
    }

    public function updatePo(Request $request, $id){
        
        $order = WlgCorporationPurchaseOrder::find($id);

        $order->model = $request->get('model');
        $order->particulars = $request->get('particulars');
        $order->quantity = $request->get('quantity');
        $order->unit_price = $request->get('unitPrice');
        $order->amount = $request->get('amount');
        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect()->route('editWlg', ['id'=>$request->get('poId')]);
    }

    public function addNewParticulars(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pO = WlgCorporationPurchaseOrder::find($id);

        $addNewParticulars = new WlgCorporationPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'model'=>$request->get('model'),
            'particulars'=>$request->get('particulars'),
            'quantity'=>$request->get('quantity'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNewParticulars->save();
        Session::flash('particularsAdded', 'Particulars added.');

        return redirect()->route('editWlg', ['id'=>$id]);

    }

    public function purchaseOrderForm(){
        
        return view('wlg-corporation-purchase-order');
    }

    public function transactionList(){
      
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'wlg_corporation_payment_vouchers')
                            ->select( 
                            'wlg_corporation_payment_vouchers.id',
                            'wlg_corporation_payment_vouchers.user_id',
                            'wlg_corporation_payment_vouchers.pv_id',
                            'wlg_corporation_payment_vouchers.date',
                            'wlg_corporation_payment_vouchers.paid_to',
                            'wlg_corporation_payment_vouchers.account_no',
                            'wlg_corporation_payment_vouchers.account_name',
                            'wlg_corporation_payment_vouchers.particulars',
                            'wlg_corporation_payment_vouchers.amount',
                            'wlg_corporation_payment_vouchers.method_of_payment',
                            'wlg_corporation_payment_vouchers.prepared_by',
                            'wlg_corporation_payment_vouchers.approved_by',
                            'wlg_corporation_payment_vouchers.date_approved',
                            'wlg_corporation_payment_vouchers.received_by_date',
                            'wlg_corporation_payment_vouchers.created_by',
                            'wlg_corporation_payment_vouchers.invoice_number',
                            'wlg_corporation_payment_vouchers.voucher_ref_number',
                            'wlg_corporation_payment_vouchers.issued_date',
                            'wlg_corporation_payment_vouchers.category',
                            'wlg_corporation_payment_vouchers.amount_due',
                            'wlg_corporation_payment_vouchers.delivered_date',
                            'wlg_corporation_payment_vouchers.status',
                            'wlg_corporation_payment_vouchers.cheque_number',
                            'wlg_corporation_payment_vouchers.cheque_amount',
                            'wlg_corporation_payment_vouchers.sub_category',
                            'wlg_corporation_payment_vouchers.sub_category_account_id',
                            'wlg_corporation_codes.wlg_code',
                            'wlg_corporation_codes.module_id',
                            'wlg_corporation_codes.module_code',
                            'wlg_corporation_codes.module_name')
                            ->leftJoin('wlg_corporation_codes', 'wlg_corporation_payment_vouchers.id', '=', 'wlg_corporation_codes.module_id')
                            ->where('wlg_corporation_payment_vouchers.pv_id', NULL)
                            ->where('wlg_corporation_codes.module_name', $moduleName)
                            ->orderBy('wlg_corporation_payment_vouchers.id', 'desc')
                            ->get()->toArray();
    

        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmountDue = WlgCorporationPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('wlg-corporation-transaction-list', compact('getTransactionLists', 'totalAmountDue'));

    }

    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        $paymentData = WlgCorporationPaymentVoucher::find($id);
         
        //save payment cheque num and cheque amount
         $addPayment = new WlgCorporationPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'date'=>$request->get('date'),
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,
        ]);

        $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

        return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);
    }

    public function accept(Request $request, $id){
         //get the status 
         $status = $request->get('status');
         if($status == "FULLY PAID AND RELEASED"){
             switch ($request->get('action')) {
                 case 'PAID AND RELEASE':
                     # code...
                     $payables = WlgCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                     Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');
 
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
 
         }else if($status == "FOR APPROVAL"){
             switch ($request->get('action')) {
                 case 'PAID & HOLD':
                     # code...
                     $payables = WlgCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                      Session::flash('payablesSuccess', 'Status set for approval.');
 
                      return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);
 
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                     break;
             }
         }else{
 
             switch ($request->get('action')) {
                 case 'PAID & HOLD':
                     # code...
                     $payables = WlgCorporationPaymentVoucher::find($id);
 
                     $payables->status = $status;
                     $payables->save();
 
                     Session::flash('payablesSuccess', 'Status set for confirmation.');
 
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);
                     
                     break;
                 
                 default:
                     # code...
                     return redirect()->route('editPayablesDetailWlg', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = WlgCorporationPaymentVoucher::find($id);

        //add current amount
         $add = $particulars['amount_due'] + $request->get('amount');

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $addParticulars = new WlgCorporationPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'date'=>$request->get('date'),
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

         return redirect()->route('editPayablesDetailWlg', ['id'=>$id]);

    }

    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'wlg_corporation_payment_vouchers')
                            ->select( 
                            'wlg_corporation_payment_vouchers.id',
                            'wlg_corporation_payment_vouchers.user_id',
                            'wlg_corporation_payment_vouchers.pv_id',
                            'wlg_corporation_payment_vouchers.date',
                            'wlg_corporation_payment_vouchers.paid_to',
                            'wlg_corporation_payment_vouchers.account_no',
                            'wlg_corporation_payment_vouchers.account_name',
                            'wlg_corporation_payment_vouchers.particulars',
                            'wlg_corporation_payment_vouchers.amount',
                            'wlg_corporation_payment_vouchers.method_of_payment',
                            'wlg_corporation_payment_vouchers.prepared_by',
                            'wlg_corporation_payment_vouchers.approved_by',
                            'wlg_corporation_payment_vouchers.date_approved',
                            'wlg_corporation_payment_vouchers.received_by_date',
                            'wlg_corporation_payment_vouchers.created_by',
                            'wlg_corporation_payment_vouchers.invoice_number',
                            'wlg_corporation_payment_vouchers.voucher_ref_number',
                            'wlg_corporation_payment_vouchers.issued_date',
                            'wlg_corporation_payment_vouchers.category',
                            'wlg_corporation_payment_vouchers.amount_due',
                            'wlg_corporation_payment_vouchers.delivered_date',
                            'wlg_corporation_payment_vouchers.status',
                            'wlg_corporation_payment_vouchers.cheque_number',
                            'wlg_corporation_payment_vouchers.cheque_amount',
                            'wlg_corporation_payment_vouchers.sub_category',
                            'wlg_corporation_payment_vouchers.sub_category_account_id',
                            'wlg_corporation_codes.wlg_code',
                            'wlg_corporation_codes.module_id',
                            'wlg_corporation_codes.module_code',
                            'wlg_corporation_codes.module_name')
                            ->leftJoin('wlg_corporation_codes', 'wlg_corporation_payment_vouchers.id', '=', 'wlg_corporation_codes.module_id')
                            ->where('wlg_corporation_payment_vouchers.id', $id)
                            ->where('wlg_corporation_codes.module_name', $moduleName)
                            ->get();
        
        $getChequeNumbers = WlgCorporationPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //getParticular details
        $getParticulars = WlgCorporationPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
          //amount
        $amount1 = WlgCorporationPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = WlgCorporationPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;

        $chequeAmount1 = WlgCorporationPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = WlgCorporationPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('wlg-corporation-payables-detail', compact('transactionList', 'getParticulars', 'sum' , 
        'getChequeNumbers', 'sumCheque'));
    }

    public function paymentVoucherStore(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the latest insert id query in table payment voucher ref number
        $dataVoucherRef = DB::select('SELECT id, wlg_code FROM wlg_corporation_codes ORDER BY id DESC LIMIT 1');
        
        //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->wlg_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->wlg_code +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
        } 


         //check if invoice number already exists
         $target = DB::table(
            'wlg_corporation_payment_vouchers')
            ->where('invoice_number', $request->get('invoiceNumber'))
            ->get()->first();

        if($target === NULL){
            $addPaymentVoucher = new WlgCorporationPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'method_of_payment'=>$request->get('paymentMethod'),
                'account_name'=>$request->get('accountName'),
                'issued_date'=>$request->get('issuedDate'),
                'delivered_date'=>$request->get('deliveredDate'),
                'amount'=>$request->get('amount'),
                'amount_due'=>$request->get('amount'),
                'particulars'=>$request->get('particulars'),
                'category'=>$request->get('category'),
                'prepared_by'=>$name,
                'created_by'=>$name,
            ]);
            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;

            $moduleCode = "PV-";
            $moduleName = "Payment Voucher";

            $wlg = new WlgCorporationCode([
                'user_id'=>$user->id,
                'wlg_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);
            $wlg->save();

            return redirect()->route('editPayablesDetailWlg', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormWlg')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');

        }

    }

    public function paymentVoucherForm(){

        return view('payment-voucher-form-wlg-corp');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statusForma = "Pro-Forma Invoice";
        $statusComm = "Commercial Invoice";
        $statusQuo = "Quotation Invoice";
        $statusPacking = "Packing List";
        $status = "Invoice Form";

        $invoices = WlgCorporationInvoice::where('if_id', NULL)->where('status', $status)->get()->toArray();

        $invoiceProFormas = WlgCorporationInvoice::where('if_id', NULL)->where('status', $statusForma)->get()->toArray();

        $invoiceCommercialInvoices = WlgCorporationInvoice::where('if_id', NULL)->where('status', $statusComm)->get()->toArray();
        
        $invoiceQuotations = WlgCorporationInvoice::where('if_id', NULL)->where('status', $statusQuo)->get()->toArray();
        
        $packingLists = WlgCorporationInvoice::where('if_id', NULL)->where('status', $statusPacking)->get()->toArray();
     

        return view('wlg-corporation', compact('invoices', 'invoiceProFormas', 'invoiceCommercialInvoices', 
        'invoiceQuotations', 'packingLists'));
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

        $this->validate($request, [
            'paidTo' => 'required',
            'address'=> 'required',
        ]);

        //get the latest insert id query in table purchase order
        $data = DB::select('SELECT id, wlg_code FROM wlg_corporation_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1
          if(isset($data[0]->wlg_code) != 0){
            //if code is not 0
            $newNum = $data[0]->wlg_code +1;
            $uNum = sprintf("%06d",$newNum);    
        }else{
            //if code is 0 
            $newNum = 1;
            $uNum = sprintf("%06d",$newNum);
        }

        $purchaseOrder = new WlgCorporationPurchaseOrder([
            'user_id' =>$user->id,
            'paid_to'=>$request->get('paidTo'),
            'address'=>$request->get('address'),
            'date'=>$request->get('date'),
            'model'=>$request->get('model'),
            'particulars'=>$request->get('particulars'),
            'quantity'=>$request->get('quantity'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $purchaseOrder->save();

        $insertedId = $purchaseOrder->id;

        $moduleCode = "PO-";
        $moduleName = "Purchase Order";

        $wlg = new WlgCorporationCode([
            'user_id'=>$user->id,
            'wlg_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);

        $wlg->save();
        
        return redirect()->route('editWlg', ['id'=>$insertedId]);
      
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                        'wlg_corporation_purchase_orders')
                        ->select(
                            'wlg_corporation_purchase_orders.id',
                            'wlg_corporation_purchase_orders.user_id',
                            'wlg_corporation_purchase_orders.po_id',
                            'wlg_corporation_purchase_orders.paid_to',
                            'wlg_corporation_purchase_orders.address',
                            'wlg_corporation_purchase_orders.date',
                            'wlg_corporation_purchase_orders.model',
                            'wlg_corporation_purchase_orders.particulars',
                            'wlg_corporation_purchase_orders.quantity',
                            'wlg_corporation_purchase_orders.unit_price',
                            'wlg_corporation_purchase_orders.amount',
                            'wlg_corporation_purchase_orders.requested_by',
                            'wlg_corporation_purchase_orders.prepared_by',
                            'wlg_corporation_purchase_orders.checked_by',
                            'wlg_corporation_purchase_orders.created_by',
                            'wlg_corporation_codes.wlg_code',
                            'wlg_corporation_codes.module_id',
                            'wlg_corporation_codes.module_code',
                            'wlg_corporation_codes.module_name')
                        ->leftJoin('wlg_corporation_codes', 'wlg_corporation_purchase_orders.id', '=', 'wlg_corporation_codes.module_id')
                        ->where('wlg_corporation_purchase_orders.id', $id)
                        ->where('wlg_corporation_codes.module_name', $moduleName)
                        ->get();


        $pOrders = WlgCorporationPurchaseOrder::where('po_id', $id)->get()->toArray();
        //count the total amount 
        $countTotalAmount = WlgCorporationPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = WlgCorporationPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-wlg-corporation-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchaseOrder = WlgCorporationPurchaseOrder::find($id);

        $pOrders = WlgCorporationPurchaseOrder::where('po_id', $id)->get()->toArray();

        return view('edit-wlg-corporation-purchase-order', compact('purchaseOrder', 'pOrders'));
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


    public function destroyInvoice($id){
        $invoice = WlgCorporationInvoice::find($id);
        $invoice->delete();
    }

    public function destroyTransaction($id){
        $transactionList = WlgCorporationPaymentVoucher::find($id);
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
        $purchaseOrder = WlgCorporationPaymentVoucher::find($id);
        $purchaseOrder->delete();
    }
}
