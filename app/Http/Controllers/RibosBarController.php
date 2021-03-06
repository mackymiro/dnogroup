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
use App\RibosBarPettyCash;
use App\RibosBarCode;
use App\RibosBarSupplier;
use App\RibosBarRawMaterialProduct;

class RibosBarController extends Controller
{

    public function updateRawMaterial(Request $request){
        $updateRawMaterial = RibosBarRawMaterial::find($request->id);

        //unit price times number of IN products
        $unitPrice = $request->unitPrice1 * $request->stockIn1;

        $amount = $unitPrice;

        $updateRawMaterial->product_name = $request->productName1;
        $updateRawMaterial->unit_price = $request->unitPrice1;
        $updateRawMaterial->unit = $request->unit1;
        $updateRawMaterial->in = $request->stockIn1;
        $updateRawMaterial->remaining_stock = $request->stockIn1;
        $updateRawMaterial->amount = $amount;
        $updateRawMaterial->supplier = $request->supplier1;

        $updateRawMaterial->save();

        return response()->json('Success: successfully updated.'); 

    }

    public function printSupplier($id){
        $viewSupplier = RibosBarSupplier::where('id', $id)->get();
        
        $printSuppliers = DB::table(
                        'ribos_bar_payment_vouchers')
                        ->select( 
                        'ribos_bar_payment_vouchers.id',
                        'ribos_bar_payment_vouchers.user_id',
                        'ribos_bar_payment_vouchers.pv_id',
                        'ribos_bar_payment_vouchers.date',
                        'ribos_bar_payment_vouchers.paid_to',
                        'ribos_bar_payment_vouchers.account_no',
                        'ribos_bar_payment_vouchers.account_name',
                        'ribos_bar_payment_vouchers.particulars',
                        'ribos_bar_payment_vouchers.amount',
                        'ribos_bar_payment_vouchers.method_of_payment',
                        'ribos_bar_payment_vouchers.prepared_by',
                        'ribos_bar_payment_vouchers.approved_by',
                        'ribos_bar_payment_vouchers.date_apprroved',
                        'ribos_bar_payment_vouchers.received_by_date',
                        'ribos_bar_payment_vouchers.created_by',
                        'ribos_bar_payment_vouchers.created_at',
                        'ribos_bar_payment_vouchers.invoice_number',
                        'ribos_bar_payment_vouchers.voucher_ref_number',
                        'ribos_bar_payment_vouchers.issued_date',
                        'ribos_bar_payment_vouchers.category',
                        'ribos_bar_payment_vouchers.amount_due',
                        'ribos_bar_payment_vouchers.delivered_date',
                        'ribos_bar_payment_vouchers.status',
                        'ribos_bar_payment_vouchers.cheque_number',
                        'ribos_bar_payment_vouchers.cheque_amount',
                        'ribos_bar_payment_vouchers.sub_category',
                        'ribos_bar_payment_vouchers.sub_category_account_id',
                        'ribos_bar_payment_vouchers.supplier_name',
                        'ribos_bar_payment_vouchers.deleted_at',
                        'ribos_bar_suppliers.id',
                        'ribos_bar_suppliers.date',
                        'ribos_bar_suppliers.supplier_name')
                        ->leftJoin('ribos_bar_suppliers', 'ribos_bar_payment_vouchers.supplier_id', '=', 'ribos_bar_suppliers.id')
                        ->where('ribos_bar_suppliers.id', $id)
                        ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.supplier_name',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_suppliers.id',
                                'ribos_bar_suppliers.date',
                                'ribos_bar_suppliers.supplier_name')
                                ->leftJoin('ribos_bar_suppliers', 'ribos_bar_payment_vouchers.supplier_id', '=', 'ribos_bar_suppliers.id')
                                ->where('ribos_bar_suppliers.id', $id)
                                ->where('ribos_bar_payment_vouchers.status', '!=', $status)
                                ->sum('ribos_bar_payment_vouchers.amount_due');
                    

        $pdf = PDF::loadView('printSupplierRibosBar', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('ribos-bar-supplier.pdf');

    }

    public function viewSupplier($id){
        $viewSupplier = RibosBarSupplier::where('id', $id)->get();

        $supplierLists = DB::table(
                        'ribos_bar_payment_vouchers')
                        ->select( 
                        'ribos_bar_payment_vouchers.id',
                        'ribos_bar_payment_vouchers.user_id',
                        'ribos_bar_payment_vouchers.pv_id',
                        'ribos_bar_payment_vouchers.date',
                        'ribos_bar_payment_vouchers.paid_to',
                        'ribos_bar_payment_vouchers.account_no',
                        'ribos_bar_payment_vouchers.account_name',
                        'ribos_bar_payment_vouchers.particulars',
                        'ribos_bar_payment_vouchers.amount',
                        'ribos_bar_payment_vouchers.method_of_payment',
                        'ribos_bar_payment_vouchers.prepared_by',
                        'ribos_bar_payment_vouchers.approved_by',
                        'ribos_bar_payment_vouchers.date_apprroved',
                        'ribos_bar_payment_vouchers.received_by_date',
                        'ribos_bar_payment_vouchers.created_by',
                        'ribos_bar_payment_vouchers.created_at',
                        'ribos_bar_payment_vouchers.invoice_number',
                        'ribos_bar_payment_vouchers.voucher_ref_number',
                        'ribos_bar_payment_vouchers.issued_date',
                        'ribos_bar_payment_vouchers.category',
                        'ribos_bar_payment_vouchers.amount_due',
                        'ribos_bar_payment_vouchers.delivered_date',
                        'ribos_bar_payment_vouchers.status',
                        'ribos_bar_payment_vouchers.cheque_number',
                        'ribos_bar_payment_vouchers.cheque_amount',
                        'ribos_bar_payment_vouchers.sub_category',
                        'ribos_bar_payment_vouchers.sub_category_account_id',
                        'ribos_bar_payment_vouchers.supplier_name',
                        'ribos_bar_payment_vouchers.deleted_at',
                        'ribos_bar_suppliers.date',
                        'ribos_bar_suppliers.supplier_name')
                        ->leftJoin('ribos_bar_suppliers', 'ribos_bar_payment_vouchers.supplier_id', '=', 'ribos_bar_suppliers.id')
                        ->where('ribos_bar_suppliers.id', $id)
                        ->get();

    $status = "FULLY PAID AND RELEASED";
    $totalAmountDue = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.supplier_name',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_suppliers.id',
                            'ribos_bar_suppliers.date',
                            'ribos_bar_suppliers.supplier_name')
                            ->leftJoin('ribos_bar_suppliers', 'ribos_bar_payment_vouchers.supplier_id', '=', 'ribos_bar_suppliers.id')
                            ->where('ribos_bar_suppliers.id', $id)
                            ->where('ribos_bar_payment_vouchers.status', '!=', $status)
                            ->sum('ribos_bar_payment_vouchers.amount_due');

        return view('view-ribos-bar-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue')); 
                    

    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //check if supplier name exits
        $target = DB::table(
                    'ribos_bar_suppliers')
                    ->where('supplier_name', $request->supplierName)
                    ->get()->first();

        if($target === NULL){
            $supplier = new RibosBarSupplier([
                'user_id'=>$user->id,
                'date'=>$request->date,
                'supplier_name'=>$request->supplierName, 
                'created_by'=>$name,
            ]);

            $supplier->save();
            return response()->json('Success: successfully added.');        
        }else{
            return response()->json('Failed: Already exist.');
        }

    }
    
    public function supplier(){
        $suppliers = RibosBarSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('ribos-bar-supplier', compact('suppliers'));
    }

    public function updateDetails(Request $request){
        $updateDetail = RibosBarPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = RibosBarPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = RibosBarPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){

         //main id 
         $updateParticular = RibosBarPaymentVoucher::find($request->transId);

         //particular id
         $uIdParticular = RibosBarPaymentVoucher::find($request->id);

         $amount = $request->amount; 

         $updateAmount =  $updateParticular->amount; 
        
         $uParticular = RibosBarPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
         
         $tot = $updateAmount + $uParticular; 
        
       
         $uIdParticular->date  = $request->date;
         $uIdParticular->invoice_number = $request->invoiceN;
         $uIdParticular->particulars = $request->particulars;
         $uIdParticular->amount = $amount; 
         $uIdParticular->save();
 
         $updateParticular->amount_due = $tot;
         $updateParticular->save();
         
         return response()->json('Success: successfully updated.');
   
    }

    public function updateParticulars(Request $request){
        $updateParticular =  RibosBarPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = RibosBarPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 
 
        $updateParticular->date = $request->date;
        $updateParticular->invoice_number = $request->invoiceNo;
        $updateParticular->particulars = $request->particulars;
        $updateParticular->amount = $amount;
        $updateParticular->amount_due = $sum;
        $updateParticular->save();
 
        return response()->json('Success: successfully updated.');
 
    }

    public function printMultipleSummary(Request $request, $date){  
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'ribos_bar_sales_invoices')
                        ->select(
                            'ribos_bar_sales_invoices.id',
                            'ribos_bar_sales_invoices.user_id',
                            'ribos_bar_sales_invoices.si_id',
                            'ribos_bar_sales_invoices.invoice_number',
                            'ribos_bar_sales_invoices.date',
                            'ribos_bar_sales_invoices.ordered_by',
                            'ribos_bar_sales_invoices.address',
                            'ribos_bar_sales_invoices.qty',
                            'ribos_bar_sales_invoices.total_kls',
                            'ribos_bar_sales_invoices.item_description',
                            'ribos_bar_sales_invoices.unit_price',
                            'ribos_bar_sales_invoices.amount',
                            'ribos_bar_sales_invoices.total_amount', 
                            'ribos_bar_sales_invoices.created_by', 
                            'ribos_bar_sales_invoices.created_at',
                            'ribos_bar_sales_invoices.deleted_at',                     
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_sales_invoices.si_id', NULL)
                        ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->whereBetween('ribos_bar_sales_invoices.created_at', [$uri0, $uri1])
                        ->orderBy('ribos_bar_sales_invoices.id', 'desc')
                        ->get()->toArray();

        $totalSalesInvoice = DB::table(
                            'ribos_bar_sales_invoices')
                            ->select(
                                'ribos_bar_sales_invoices.id',
                                'ribos_bar_sales_invoices.user_id',
                                'ribos_bar_sales_invoices.si_id',
                                'ribos_bar_sales_invoices.invoice_number',
                                'ribos_bar_sales_invoices.date',
                                'ribos_bar_sales_invoices.ordered_by',
                                'ribos_bar_sales_invoices.address',
                                'ribos_bar_sales_invoices.qty',
                                'ribos_bar_sales_invoices.total_kls',
                                'ribos_bar_sales_invoices.item_description',
                                'ribos_bar_sales_invoices.unit_price',
                                'ribos_bar_sales_invoices.amount',
                                'ribos_bar_sales_invoices.total_amount', 
                                'ribos_bar_sales_invoices.created_by', 
                                'ribos_bar_sales_invoices.created_at', 
                                'ribos_bar_sales_invoices.deleted_at', 
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_sales_invoices.si_id', NULL)
                            ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->whereBetween('ribos_bar_sales_invoices.created_at', [$uri0, $uri1])
                            ->sum('ribos_bar_sales_invoices.total_amount');
        

        $moduleNamePO = "Purchase Order";
        $purchaseOrders = DB::table(
                        'ribos_bar_purchase_orders')
                        ->select(
                            'ribos_bar_purchase_orders.id',
                            'ribos_bar_purchase_orders.user_id',
                            'ribos_bar_purchase_orders.po_id',
                            'ribos_bar_purchase_orders.paid_to',
                            'ribos_bar_purchase_orders.address',
                            'ribos_bar_purchase_orders.branch_location',
                            'ribos_bar_purchase_orders.date',
                            'ribos_bar_purchase_orders.quantity',
                            'ribos_bar_purchase_orders.description',
                            'ribos_bar_purchase_orders.unit_price',
                            'ribos_bar_purchase_orders.amount',
                            'ribos_bar_purchase_orders.total_price',
                            'ribos_bar_purchase_orders.requested_by',
                            'ribos_bar_purchase_orders.prepared_by',
                            'ribos_bar_purchase_orders.checked_by',
                            'ribos_bar_purchase_orders.created_by',
                            'ribos_bar_purchase_orders.created_at',
                            'ribos_bar_purchase_orders.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_purchase_orders.po_id', NULL)
                        ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleNamePO)
                        ->whereBetween('ribos_bar_purchase_orders.created_at', [$uri0, $uri1])
                        ->orderBy('ribos_bar_purchase_orders.id', 'desc')
                        ->get()->toArray();
        
        $totalPOrder = DB::table(
                            'ribos_bar_purchase_orders')
                            ->select(
                                'ribos_bar_purchase_orders.id',
                                'ribos_bar_purchase_orders.user_id',
                                'ribos_bar_purchase_orders.po_id',
                                'ribos_bar_purchase_orders.paid_to',
                                'ribos_bar_purchase_orders.address',
                                'ribos_bar_purchase_orders.branch_location',
                                'ribos_bar_purchase_orders.date',
                                'ribos_bar_purchase_orders.quantity',
                                'ribos_bar_purchase_orders.description',
                                'ribos_bar_purchase_orders.unit_price',
                                'ribos_bar_purchase_orders.amount',
                                'ribos_bar_purchase_orders.total_price',
                                'ribos_bar_purchase_orders.requested_by',
                                'ribos_bar_purchase_orders.prepared_by',
                                'ribos_bar_purchase_orders.checked_by',
                                'ribos_bar_purchase_orders.created_by',
                                'ribos_bar_purchase_orders.created_at',
                                'ribos_bar_purchase_orders.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_purchase_orders.po_id', NULL)
                            ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePO)
                            ->whereBetween('ribos_bar_purchase_orders.created_at', [$uri0, $uri1])
                            ->sum('ribos_bar_purchase_orders.total_price');
        
        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereBetween('ribos_bar_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();
    
        $totalAmountCashes = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereBetween('ribos_bar_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                                ->sum('ribos_bar_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.cheque_total_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereBetween('ribos_bar_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";    
        $totalAmountCheck = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereBetween('ribos_bar_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->where('ribos_bar_payment_vouchers.status', '!=', $status)
                            ->sum('ribos_bar_payment_vouchers.amount_due');
            
        
        $totalPaidAmountCheck = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.cheque_total_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereBetween('ribos_bar_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                                ->where('ribos_bar_payment_vouchers.status', $status)
                                ->sum('ribos_bar_payment_vouchers.cheque_total_amount');

            
        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryRibosBar', compact('date', 'uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'totalSalesInvoice', 'purchaseOrders', 'totalPOrder','pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('ribos-bar-summary-report.pdf');
        
        
    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'ribos_bar_sales_invoices')
                        ->select(
                            'ribos_bar_sales_invoices.id',
                            'ribos_bar_sales_invoices.user_id',
                            'ribos_bar_sales_invoices.si_id',
                            'ribos_bar_sales_invoices.invoice_number',
                            'ribos_bar_sales_invoices.date',
                            'ribos_bar_sales_invoices.ordered_by',
                            'ribos_bar_sales_invoices.address',
                            'ribos_bar_sales_invoices.qty',
                            'ribos_bar_sales_invoices.total_kls',
                            'ribos_bar_sales_invoices.item_description',
                            'ribos_bar_sales_invoices.unit_price',
                            'ribos_bar_sales_invoices.amount',
                            'ribos_bar_sales_invoices.total_amount', 
                            'ribos_bar_sales_invoices.created_by', 
                            'ribos_bar_sales_invoices.created_at', 
                            'ribos_bar_sales_invoices.deleted_at',                     
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_sales_invoices.si_id', NULL)
                        ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->whereBetween('ribos_bar_sales_invoices.created_at', [$startDate, $endDate]) 
                        ->orderBy('ribos_bar_sales_invoices.id', 'desc')
                        ->get()->toArray();

        $totalSalesInvoice = DB::table(
                            'ribos_bar_sales_invoices')
                            ->select(
                                'ribos_bar_sales_invoices.id',
                                'ribos_bar_sales_invoices.user_id',
                                'ribos_bar_sales_invoices.si_id',
                                'ribos_bar_sales_invoices.invoice_number',
                                'ribos_bar_sales_invoices.date',
                                'ribos_bar_sales_invoices.ordered_by',
                                'ribos_bar_sales_invoices.address',
                                'ribos_bar_sales_invoices.qty',
                                'ribos_bar_sales_invoices.total_kls',
                                'ribos_bar_sales_invoices.item_description',
                                'ribos_bar_sales_invoices.unit_price',
                                'ribos_bar_sales_invoices.amount',
                                'ribos_bar_sales_invoices.total_amount', 
                                'ribos_bar_sales_invoices.created_by', 
                                'ribos_bar_sales_invoices.created_at',  
                                'ribos_bar_sales_invoices.deleted_at',                     
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_sales_invoices.si_id', NULL)
                            ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->whereBetween('ribos_bar_sales_invoices.created_at', [$startDate, $endDate]) 
                           ->sum('ribos_bar_sales_invoices.total_amount');
        

        $moduleNamePO = "Purchase Order";
        $purchaseOrders = DB::table(
                        'ribos_bar_purchase_orders')
                        ->select(
                            'ribos_bar_purchase_orders.id',
                            'ribos_bar_purchase_orders.user_id',
                            'ribos_bar_purchase_orders.po_id',
                            'ribos_bar_purchase_orders.paid_to',
                            'ribos_bar_purchase_orders.address',
                            'ribos_bar_purchase_orders.branch_location',
                            'ribos_bar_purchase_orders.date',
                            'ribos_bar_purchase_orders.quantity',
                            'ribos_bar_purchase_orders.description',
                            'ribos_bar_purchase_orders.unit_price',
                            'ribos_bar_purchase_orders.amount',
                            'ribos_bar_purchase_orders.total_price',
                            'ribos_bar_purchase_orders.requested_by',
                            'ribos_bar_purchase_orders.prepared_by',
                            'ribos_bar_purchase_orders.checked_by',
                            'ribos_bar_purchase_orders.created_by',
                            'ribos_bar_purchase_orders.created_at',
                            'ribos_bar_purchase_orders.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_purchase_orders.po_id', NULL)
                        ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleNamePO)
                        ->whereBetween('ribos_bar_purchase_orders.created_at', [$startDate, $endDate]) 
                        ->orderBy('ribos_bar_purchase_orders.id', 'desc')
                        ->get()->toArray();
        
        $totalPOrder = DB::table(
                            'ribos_bar_purchase_orders')
                            ->select(
                                'ribos_bar_purchase_orders.id',
                                'ribos_bar_purchase_orders.user_id',
                                'ribos_bar_purchase_orders.po_id',
                                'ribos_bar_purchase_orders.paid_to',
                                'ribos_bar_purchase_orders.address',
                                'ribos_bar_purchase_orders.branch_location',
                                'ribos_bar_purchase_orders.date',
                                'ribos_bar_purchase_orders.quantity',
                                'ribos_bar_purchase_orders.description',
                                'ribos_bar_purchase_orders.unit_price',
                                'ribos_bar_purchase_orders.amount',
                                'ribos_bar_purchase_orders.total_price',
                                'ribos_bar_purchase_orders.requested_by',
                                'ribos_bar_purchase_orders.prepared_by',
                                'ribos_bar_purchase_orders.checked_by',
                                'ribos_bar_purchase_orders.created_by',
                                'ribos_bar_purchase_orders.created_at',
                                'ribos_bar_purchase_orders.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_purchase_orders.po_id', NULL)
                            ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePO)
                            ->whereBetween('ribos_bar_purchase_orders.created_at', [$startDate, $endDate]) 
                            ->sum('ribos_bar_purchase_orders.total_price');
            
        $moduleNamePetty = "Petty Cash";
        $pettyCashLists = DB::table(
                                'ribos_bar_petty_cashes')
                                ->select( 
                                'ribos_bar_petty_cashes.id',
                                'ribos_bar_petty_cashes.user_id',
                                'ribos_bar_petty_cashes.pc_id',
                                'ribos_bar_petty_cashes.date',
                                'ribos_bar_petty_cashes.petty_cash_name',
                                'ribos_bar_petty_cashes.petty_cash_summary',
                                'ribos_bar_petty_cashes.amount',
                                'ribos_bar_petty_cashes.created_by',
                                'ribos_bar_petty_cashes.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_petty_cashes.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_petty_cashes.pc_id', NULL)
                                ->where('ribos_bar_petty_cashes.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePetty)
                                ->whereBetween('ribos_bar_petty_cashes.created_at', [$startDate, $endDate]) 
                                ->orderBy('ribos_bar_petty_cashes.id', 'desc')
                                ->get()->toArray();


        $moduleNamePV = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereBetween('ribos_bar_payment_vouchers.created_at', [$startDate, $endDate]) 
                                ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                                ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereBetween('ribos_bar_payment_vouchers.created_at', [$startDate, $endDate]) 
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();
    
        $totalAmountCashes = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereBetween('ribos_bar_payment_vouchers.created_at', [$startDate, $endDate]) 
                                ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                               ->sum('ribos_bar_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.cheque_total_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereBetween('ribos_bar_payment_vouchers.created_at', [$startDate, $endDate]) 
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereBetween('ribos_bar_payment_vouchers.created_at', [$startDate, $endDate]) 
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->where('ribos_bar_payment_vouchers.status', '!=', $status)
                            ->sum('ribos_bar_payment_vouchers.amount_due');

        return view('ribos-bar-multiple-summary-report', compact('getAllSalesInvoices', 'startDate', 'endDate',
        'totalSalesInvoice', 'purchaseOrders', 'totalPOrder','pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
        

    }

    public function search(Request $request){
        $getSearchResults =RibosBarCode::where('ribos_bar_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Sales Invoice"){
            $getSearchSalesInvoices = DB::table(
                        'ribos_bar_sales_invoices')
                        ->select(
                            'ribos_bar_sales_invoices.id',
                            'ribos_bar_sales_invoices.user_id',
                            'ribos_bar_sales_invoices.si_id',
                            'ribos_bar_sales_invoices.invoice_number',
                            'ribos_bar_sales_invoices.date',
                            'ribos_bar_sales_invoices.ordered_by',
                            'ribos_bar_sales_invoices.address',
                            'ribos_bar_sales_invoices.qty',
                            'ribos_bar_sales_invoices.total_kls',
                            'ribos_bar_sales_invoices.item_description',
                            'ribos_bar_sales_invoices.unit_price',
                            'ribos_bar_sales_invoices.amount',
                            'ribos_bar_sales_invoices.total_amount', 
                            'ribos_bar_sales_invoices.created_by', 
                            'ribos_bar_sales_invoices.created_at',  
                            'ribos_bar_sales_invoices.deleted_at',                     
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_sales_invoices.id', $getSearchResults[0]->module_id)
                        ->where('ribos_bar_codes.module_name', $getSearchResults[0]->module_name)
                      
                        ->get()->toArray();

            $getAllCodes = RibosBarCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('ribos-bar-search-results',  compact('module', 'getAllCodes', 'getSearchSalesInvoices'));
                    
        }else if($getSearchResults[0]->module_name === "Purchase Order"){
            $getSearchPurchaseOrders = DB::table(
                    'ribos_bar_purchase_orders')
                    ->select(
                        'ribos_bar_purchase_orders.id',
                        'ribos_bar_purchase_orders.user_id',
                        'ribos_bar_purchase_orders.po_id',
                        'ribos_bar_purchase_orders.paid_to',
                        'ribos_bar_purchase_orders.address',
                        'ribos_bar_purchase_orders.branch_location',
                        'ribos_bar_purchase_orders.date',
                        'ribos_bar_purchase_orders.quantity',
                        'ribos_bar_purchase_orders.description',
                        'ribos_bar_purchase_orders.unit_price',
                        'ribos_bar_purchase_orders.amount',
                        'ribos_bar_purchase_orders.total_price',
                        'ribos_bar_purchase_orders.requested_by',
                        'ribos_bar_purchase_orders.prepared_by',
                        'ribos_bar_purchase_orders.checked_by',
                        'ribos_bar_purchase_orders.created_by',
                        'ribos_bar_purchase_orders.created_at',
                        'ribos_bar_purchase_orders.deleted_at',
                        'ribos_bar_codes.ribos_bar_code',
                        'ribos_bar_codes.module_id',
                        'ribos_bar_codes.module_code',
                        'ribos_bar_codes.module_name')
                    ->join('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                    ->where('ribos_bar_purchase_orders.id', $getSearchResults[0]->module_id)
                    ->where('ribos_bar_codes.module_name', $getSearchResults[0]->module_name)
                    ->get()->toArray();

            $getAllCodes = RibosBarCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('ribos-bar-search-results',  compact('module', 'getAllCodes', 'getSearchPurchaseOrders'));
        

        }else if($getSearchResults[0]->module_name === "Petty Cash"){
            $getSearchPettyCashes = DB::table(
                    'ribos_bar_petty_cashes')
                    ->select( 
                    'ribos_bar_petty_cashes.id',
                    'ribos_bar_petty_cashes.user_id',
                    'ribos_bar_petty_cashes.pc_id',
                    'ribos_bar_petty_cashes.date',
                    'ribos_bar_petty_cashes.petty_cash_name',
                    'ribos_bar_petty_cashes.petty_cash_summary',
                    'ribos_bar_petty_cashes.amount',
                    'ribos_bar_petty_cashes.created_by',
                    'ribos_bar_petty_cashes.deleted_at',
                    'ribos_bar_codes.ribos_bar_code',
                    'ribos_bar_codes.module_id',
                    'ribos_bar_codes.module_code',
                    'ribos_bar_codes.module_name')
                    ->join('ribos_bar_codes', 'ribos_bar_petty_cashes.id', '=', 'ribos_bar_codes.module_id')
                    ->where('ribos_bar_petty_cashes.id', $getSearchResults[0]->module_id)
                    ->where('ribos_bar_codes.module_name', $getSearchResults[0]->module_name)
                    ->get()->toArray();
            
            $getAllCodes = RibosBarCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('ribos-bar-search-results',  compact('module', 'getAllCodes', 'getSearchPettyCashes'));
              
        }else if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                        'ribos_bar_payment_vouchers')
                        ->select( 
                        'ribos_bar_payment_vouchers.id',
                        'ribos_bar_payment_vouchers.user_id',
                        'ribos_bar_payment_vouchers.pv_id',
                        'ribos_bar_payment_vouchers.date',
                        'ribos_bar_payment_vouchers.paid_to',
                        'ribos_bar_payment_vouchers.account_no',
                        'ribos_bar_payment_vouchers.account_name',
                        'ribos_bar_payment_vouchers.particulars',
                        'ribos_bar_payment_vouchers.amount',
                        'ribos_bar_payment_vouchers.method_of_payment',
                        'ribos_bar_payment_vouchers.prepared_by',
                        'ribos_bar_payment_vouchers.approved_by',
                        'ribos_bar_payment_vouchers.date_apprroved',
                        'ribos_bar_payment_vouchers.received_by_date',
                        'ribos_bar_payment_vouchers.created_by',
                        'ribos_bar_payment_vouchers.created_at',
                        'ribos_bar_payment_vouchers.invoice_number',
                        'ribos_bar_payment_vouchers.voucher_ref_number',
                        'ribos_bar_payment_vouchers.issued_date',
                        'ribos_bar_payment_vouchers.category',
                        'ribos_bar_payment_vouchers.amount_due',
                        'ribos_bar_payment_vouchers.delivered_date',
                        'ribos_bar_payment_vouchers.status',
                        'ribos_bar_payment_vouchers.cheque_number',
                        'ribos_bar_payment_vouchers.cheque_amount',
                        'ribos_bar_payment_vouchers.sub_category',
                        'ribos_bar_payment_vouchers.sub_category_account_id',
                        'ribos_bar_payment_vouchers.deleted_at',
                        'ribos_bar_codes.ribos_bar_code',
                        'ribos_bar_codes.module_id',
                        'ribos_bar_codes.module_code',
                        'ribos_bar_codes.module_name')
                        ->join('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_payment_vouchers.id', $getSearchResults[0]->module_id)
                        ->where('ribos_bar_codes.module_name', $getSearchResults[0]->module_name)
                    
                        ->get()->toArray();
            
            $getAllCodes = RibosBarCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('ribos-bar-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
            
        }
    }

    public function searchNumberCode(){
        $getAllCodes = RibosBarCode::get()->toArray();
        return view('ribos-bar-search-number-code', compact('getAllCodes'));
    }

    public function printGetSummary($date){
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'ribos_bar_sales_invoices')
                        ->select(
                            'ribos_bar_sales_invoices.id',
                            'ribos_bar_sales_invoices.user_id',
                            'ribos_bar_sales_invoices.si_id',
                            'ribos_bar_sales_invoices.invoice_number',
                            'ribos_bar_sales_invoices.date',
                            'ribos_bar_sales_invoices.ordered_by',
                            'ribos_bar_sales_invoices.address',
                            'ribos_bar_sales_invoices.qty',
                            'ribos_bar_sales_invoices.total_kls',
                            'ribos_bar_sales_invoices.item_description',
                            'ribos_bar_sales_invoices.unit_price',
                            'ribos_bar_sales_invoices.amount',
                            'ribos_bar_sales_invoices.total_amount', 
                            'ribos_bar_sales_invoices.created_by', 
                            'ribos_bar_sales_invoices.created_at',   
                            'ribos_bar_sales_invoices.deleted_at',                      
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_sales_invoices.si_id', NULL)
                        ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->whereDate('ribos_bar_sales_invoices.created_at', '=', date($date))
                        ->orderBy('ribos_bar_sales_invoices.id', 'desc')
                        ->get()->toArray();

        $totalSalesInvoice = DB::table(
                            'ribos_bar_sales_invoices')
                            ->select(
                                'ribos_bar_sales_invoices.id',
                                'ribos_bar_sales_invoices.user_id',
                                'ribos_bar_sales_invoices.si_id',
                                'ribos_bar_sales_invoices.invoice_number',
                                'ribos_bar_sales_invoices.date',
                                'ribos_bar_sales_invoices.ordered_by',
                                'ribos_bar_sales_invoices.address',
                                'ribos_bar_sales_invoices.qty',
                                'ribos_bar_sales_invoices.total_kls',
                                'ribos_bar_sales_invoices.item_description',
                                'ribos_bar_sales_invoices.unit_price',
                                'ribos_bar_sales_invoices.amount',
                                'ribos_bar_sales_invoices.total_amount', 
                                'ribos_bar_sales_invoices.created_by', 
                                'ribos_bar_sales_invoices.created_at',  
                                'ribos_bar_sales_invoices.deleted_at',                     
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_sales_invoices.si_id', NULL)
                            ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->whereDate('ribos_bar_sales_invoices.created_at', '=', date($date))
                           ->sum('ribos_bar_sales_invoices.total_amount');
        

        $moduleNamePO = "Purchase Order";
        $purchaseOrders = DB::table(
                        'ribos_bar_purchase_orders')
                        ->select(
                            'ribos_bar_purchase_orders.id',
                            'ribos_bar_purchase_orders.user_id',
                            'ribos_bar_purchase_orders.po_id',
                            'ribos_bar_purchase_orders.paid_to',
                            'ribos_bar_purchase_orders.address',
                            'ribos_bar_purchase_orders.branch_location',
                            'ribos_bar_purchase_orders.date',
                            'ribos_bar_purchase_orders.quantity',
                            'ribos_bar_purchase_orders.description',
                            'ribos_bar_purchase_orders.unit_price',
                            'ribos_bar_purchase_orders.amount',
                            'ribos_bar_purchase_orders.total_price',
                            'ribos_bar_purchase_orders.requested_by',
                            'ribos_bar_purchase_orders.prepared_by',
                            'ribos_bar_purchase_orders.checked_by',
                            'ribos_bar_purchase_orders.created_by',
                            'ribos_bar_purchase_orders.created_at',
                            'ribos_bar_purchase_orders.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_purchase_orders.po_id', NULL)
                        ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleNamePO)
                        ->whereDate('ribos_bar_purchase_orders.created_at', '=', date($date))
                        ->orderBy('ribos_bar_purchase_orders.id', 'desc')
                        ->get()->toArray();
        
        $totalPOrder = DB::table(
                            'ribos_bar_purchase_orders')
                            ->select(
                                'ribos_bar_purchase_orders.id',
                                'ribos_bar_purchase_orders.user_id',
                                'ribos_bar_purchase_orders.po_id',
                                'ribos_bar_purchase_orders.paid_to',
                                'ribos_bar_purchase_orders.address',
                                'ribos_bar_purchase_orders.branch_location',
                                'ribos_bar_purchase_orders.date',
                                'ribos_bar_purchase_orders.quantity',
                                'ribos_bar_purchase_orders.description',
                                'ribos_bar_purchase_orders.unit_price',
                                'ribos_bar_purchase_orders.amount',
                                'ribos_bar_purchase_orders.total_price',
                                'ribos_bar_purchase_orders.requested_by',
                                'ribos_bar_purchase_orders.prepared_by',
                                'ribos_bar_purchase_orders.checked_by',
                                'ribos_bar_purchase_orders.created_by',
                                'ribos_bar_purchase_orders.created_at',
                                'ribos_bar_purchase_orders.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_purchase_orders.po_id', NULL)
                            ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePO)
                            ->whereDate('ribos_bar_purchase_orders.created_at', '=', date($date))
                            ->sum('ribos_bar_purchase_orders.total_price');
        
        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($date))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();
    
        $totalAmountCashes = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($date))
                                ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                                ->sum('ribos_bar_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.cheque_total_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($date))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";    
        $totalAmountCheck = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($date))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->where('ribos_bar_payment_vouchers.status', '!=', $status)
                            ->sum('ribos_bar_payment_vouchers.amount_due');

        $totalPaidAmountCheck = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($date))
                                ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                                ->where('ribos_bar_payment_vouchers.status', $status)
                                ->sum('ribos_bar_payment_vouchers.amount_due');
    
                    
        $getDateToday = "";
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryRibosBar', compact('date', 'uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'totalSalesInvoice', 'purchaseOrders', 'totalPOrder','pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('ribos-bar-summary-report.pdf');
   
    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'ribos_bar_sales_invoices')
                        ->select(
                            'ribos_bar_sales_invoices.id',
                            'ribos_bar_sales_invoices.user_id',
                            'ribos_bar_sales_invoices.si_id',
                            'ribos_bar_sales_invoices.invoice_number',
                            'ribos_bar_sales_invoices.date',
                            'ribos_bar_sales_invoices.ordered_by',
                            'ribos_bar_sales_invoices.address',
                            'ribos_bar_sales_invoices.qty',
                            'ribos_bar_sales_invoices.total_kls',
                            'ribos_bar_sales_invoices.item_description',
                            'ribos_bar_sales_invoices.unit_price',
                            'ribos_bar_sales_invoices.amount',
                            'ribos_bar_sales_invoices.total_amount', 
                            'ribos_bar_sales_invoices.created_by', 
                            'ribos_bar_sales_invoices.created_at',   
                            'ribos_bar_sales_invoices.deleted_at',                     
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_sales_invoices.si_id', NULL)
                        ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->whereDate('ribos_bar_sales_invoices.created_at', '=', date($getDate))
                        ->orderBy('ribos_bar_sales_invoices.id', 'desc')
                        ->get()->toArray();

        $totalSalesInvoice = DB::table(
                            'ribos_bar_sales_invoices')
                            ->select(
                                'ribos_bar_sales_invoices.id',
                                'ribos_bar_sales_invoices.user_id',
                                'ribos_bar_sales_invoices.si_id',
                                'ribos_bar_sales_invoices.invoice_number',
                                'ribos_bar_sales_invoices.date',
                                'ribos_bar_sales_invoices.ordered_by',
                                'ribos_bar_sales_invoices.address',
                                'ribos_bar_sales_invoices.qty',
                                'ribos_bar_sales_invoices.total_kls',
                                'ribos_bar_sales_invoices.item_description',
                                'ribos_bar_sales_invoices.unit_price',
                                'ribos_bar_sales_invoices.amount',
                                'ribos_bar_sales_invoices.total_amount', 
                                'ribos_bar_sales_invoices.created_by', 
                                'ribos_bar_sales_invoices.created_at',  
                                'ribos_bar_sales_invoices.deleted_at',                     
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_sales_invoices.si_id', NULL)
                            ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->whereDate('ribos_bar_sales_invoices.created_at', '=', date($getDate))
                           ->sum('ribos_bar_sales_invoices.total_amount');
        

        $moduleNamePO = "Purchase Order";
        $purchaseOrders = DB::table(
                        'ribos_bar_purchase_orders')
                        ->select(
                            'ribos_bar_purchase_orders.id',
                            'ribos_bar_purchase_orders.user_id',
                            'ribos_bar_purchase_orders.po_id',
                            'ribos_bar_purchase_orders.paid_to',
                            'ribos_bar_purchase_orders.address',
                            'ribos_bar_purchase_orders.branch_location',
                            'ribos_bar_purchase_orders.date',
                            'ribos_bar_purchase_orders.quantity',
                            'ribos_bar_purchase_orders.description',
                            'ribos_bar_purchase_orders.unit_price',
                            'ribos_bar_purchase_orders.amount',
                            'ribos_bar_purchase_orders.total_price',
                            'ribos_bar_purchase_orders.requested_by',
                            'ribos_bar_purchase_orders.prepared_by',
                            'ribos_bar_purchase_orders.checked_by',
                            'ribos_bar_purchase_orders.created_by',
                            'ribos_bar_purchase_orders.created_at',
                            'ribos_bar_purchase_orders.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_purchase_orders.po_id', NULL)
                        ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleNamePO)
                        ->whereDate('ribos_bar_purchase_orders.created_at', '=', date($getDate))
                        ->orderBy('ribos_bar_purchase_orders.id', 'desc')
                        ->get()->toArray();
        
        $totalPOrder = DB::table(
                            'ribos_bar_purchase_orders')
                            ->select(
                                'ribos_bar_purchase_orders.id',
                                'ribos_bar_purchase_orders.user_id',
                                'ribos_bar_purchase_orders.po_id',
                                'ribos_bar_purchase_orders.paid_to',
                                'ribos_bar_purchase_orders.address',
                                'ribos_bar_purchase_orders.branch_location',
                                'ribos_bar_purchase_orders.date',
                                'ribos_bar_purchase_orders.quantity',
                                'ribos_bar_purchase_orders.description',
                                'ribos_bar_purchase_orders.unit_price',
                                'ribos_bar_purchase_orders.amount',
                                'ribos_bar_purchase_orders.total_price',
                                'ribos_bar_purchase_orders.requested_by',
                                'ribos_bar_purchase_orders.prepared_by',
                                'ribos_bar_purchase_orders.checked_by',
                                'ribos_bar_purchase_orders.created_by',
                                'ribos_bar_purchase_orders.created_at',
                                'ribos_bar_purchase_orders.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_purchase_orders.po_id', NULL)
                            ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePO)
                            ->whereDate('ribos_bar_purchase_orders.created_at', '=', date($getDate))
                            ->sum('ribos_bar_purchase_orders.total_price');
            
        $moduleNamePetty = "Petty Cash";
        $pettyCashLists = DB::table(
                                'ribos_bar_petty_cashes')
                                ->select( 
                                'ribos_bar_petty_cashes.id',
                                'ribos_bar_petty_cashes.user_id',
                                'ribos_bar_petty_cashes.pc_id',
                                'ribos_bar_petty_cashes.date',
                                'ribos_bar_petty_cashes.petty_cash_name',
                                'ribos_bar_petty_cashes.petty_cash_summary',
                                'ribos_bar_petty_cashes.amount',
                                'ribos_bar_petty_cashes.created_by',
                                'ribos_bar_petty_cashes.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_petty_cashes.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_petty_cashes.pc_id', NULL)
                                ->where('ribos_bar_petty_cashes.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePetty)
                                ->whereDate('ribos_bar_petty_cashes.created_at', '=', date($getDate))
                                ->orderBy('ribos_bar_petty_cashes.id', 'desc')
                                ->get()->toArray();


        $moduleNamePV = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDate))
                                ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                                ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDate))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();
    
        $totalAmountCashes = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDate))
                                ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                               ->sum('ribos_bar_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.cheque_total_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDate))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDate))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->where('ribos_bar_payment_vouchers.status', '!=', $status)
                            ->sum('ribos_bar_payment_vouchers.amount_due');

          return view('ribos-bar-get-summary-report', compact('getDate', 'getAllSalesInvoices', 
        'totalSalesInvoice', 'purchaseOrders', 'totalPOrder','pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));


    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'ribos_bar_sales_invoices')
                        ->select(
                            'ribos_bar_sales_invoices.id',
                            'ribos_bar_sales_invoices.user_id',
                            'ribos_bar_sales_invoices.si_id',
                            'ribos_bar_sales_invoices.invoice_number',
                            'ribos_bar_sales_invoices.date',
                            'ribos_bar_sales_invoices.ordered_by',
                            'ribos_bar_sales_invoices.address',
                            'ribos_bar_sales_invoices.qty',
                            'ribos_bar_sales_invoices.total_kls',
                            'ribos_bar_sales_invoices.item_description',
                            'ribos_bar_sales_invoices.unit_price',
                            'ribos_bar_sales_invoices.amount',
                            'ribos_bar_sales_invoices.total_amount', 
                            'ribos_bar_sales_invoices.created_by', 
                            'ribos_bar_sales_invoices.created_at',
                            'ribos_bar_sales_invoices.deleted_at',                     
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_sales_invoices.si_id', NULL)
                        ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->whereDate('ribos_bar_sales_invoices.created_at', '=', date($getDateToday))
                        ->orderBy('ribos_bar_sales_invoices.id', 'desc')
                        ->get()->toArray();

        $totalSalesInvoice = DB::table(
                            'ribos_bar_sales_invoices')
                            ->select(
                                'ribos_bar_sales_invoices.id',
                                'ribos_bar_sales_invoices.user_id',
                                'ribos_bar_sales_invoices.si_id',
                                'ribos_bar_sales_invoices.invoice_number',
                                'ribos_bar_sales_invoices.date',
                                'ribos_bar_sales_invoices.ordered_by',
                                'ribos_bar_sales_invoices.address',
                                'ribos_bar_sales_invoices.qty',
                                'ribos_bar_sales_invoices.total_kls',
                                'ribos_bar_sales_invoices.item_description',
                                'ribos_bar_sales_invoices.unit_price',
                                'ribos_bar_sales_invoices.amount',
                                'ribos_bar_sales_invoices.total_amount', 
                                'ribos_bar_sales_invoices.created_by', 
                                'ribos_bar_sales_invoices.created_at', 
                                'ribos_bar_sales_invoices.deleted_at', 
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_sales_invoices.si_id', NULL)
                            ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->whereDate('ribos_bar_sales_invoices.created_at', '=', date($getDateToday))
                           ->sum('ribos_bar_sales_invoices.total_amount');
        

        $moduleNamePO = "Purchase Order";
        $purchaseOrders = DB::table(
                        'ribos_bar_purchase_orders')
                        ->select(
                            'ribos_bar_purchase_orders.id',
                            'ribos_bar_purchase_orders.user_id',
                            'ribos_bar_purchase_orders.po_id',
                            'ribos_bar_purchase_orders.paid_to',
                            'ribos_bar_purchase_orders.address',
                            'ribos_bar_purchase_orders.branch_location',
                            'ribos_bar_purchase_orders.date',
                            'ribos_bar_purchase_orders.quantity',
                            'ribos_bar_purchase_orders.description',
                            'ribos_bar_purchase_orders.unit_price',
                            'ribos_bar_purchase_orders.amount',
                            'ribos_bar_purchase_orders.total_price',
                            'ribos_bar_purchase_orders.requested_by',
                            'ribos_bar_purchase_orders.prepared_by',
                            'ribos_bar_purchase_orders.checked_by',
                            'ribos_bar_purchase_orders.created_by',
                            'ribos_bar_purchase_orders.created_at',
                            'ribos_bar_purchase_orders.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_purchase_orders.po_id', NULL)
                        ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleNamePO)
                        ->whereDate('ribos_bar_purchase_orders.created_at', '=', date($getDateToday))
                        ->orderBy('ribos_bar_purchase_orders.id', 'desc')
                        ->get()->toArray();
        
        $totalPOrder = DB::table(
                            'ribos_bar_purchase_orders')
                            ->select(
                                'ribos_bar_purchase_orders.id',
                                'ribos_bar_purchase_orders.user_id',
                                'ribos_bar_purchase_orders.po_id',
                                'ribos_bar_purchase_orders.paid_to',
                                'ribos_bar_purchase_orders.address',
                                'ribos_bar_purchase_orders.branch_location',
                                'ribos_bar_purchase_orders.date',
                                'ribos_bar_purchase_orders.quantity',
                                'ribos_bar_purchase_orders.description',
                                'ribos_bar_purchase_orders.unit_price',
                                'ribos_bar_purchase_orders.amount',
                                'ribos_bar_purchase_orders.total_price',
                                'ribos_bar_purchase_orders.requested_by',
                                'ribos_bar_purchase_orders.prepared_by',
                                'ribos_bar_purchase_orders.checked_by',
                                'ribos_bar_purchase_orders.created_by',
                                'ribos_bar_purchase_orders.created_at',
                                'ribos_bar_purchase_orders.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_purchase_orders.po_id', NULL)
                            ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePO)
                            ->whereDate('ribos_bar_purchase_orders.created_at', '=', date($getDateToday))
                            ->sum('ribos_bar_purchase_orders.total_price');
        
        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();
    
        $totalAmountCashes = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                                ->sum('ribos_bar_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.cheque_total_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";    
        $totalAmountCheck = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->where('ribos_bar_payment_vouchers.status', '!=', $status)
                            ->sum('ribos_bar_payment_vouchers.amount_due');
            
        
        $totalPaidAmountCheck = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.cheque_total_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                                ->where('ribos_bar_payment_vouchers.status', $status)
                                ->sum('ribos_bar_payment_vouchers.cheque_total_amount');
        
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryRibosBar', compact('date', 'uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'totalSalesInvoice', 'purchaseOrders', 'totalPOrder','pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('ribos-bar-summary-report.pdf');
    }

    public function summaryReport(){
        $getDateToday = date("Y-m-d");

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'ribos_bar_sales_invoices')
                        ->select(
                            'ribos_bar_sales_invoices.id',
                            'ribos_bar_sales_invoices.user_id',
                            'ribos_bar_sales_invoices.si_id',
                            'ribos_bar_sales_invoices.invoice_number',
                            'ribos_bar_sales_invoices.date',
                            'ribos_bar_sales_invoices.ordered_by',
                            'ribos_bar_sales_invoices.address',
                            'ribos_bar_sales_invoices.qty',
                            'ribos_bar_sales_invoices.total_kls',
                            'ribos_bar_sales_invoices.item_description',
                            'ribos_bar_sales_invoices.unit_price',
                            'ribos_bar_sales_invoices.amount',
                            'ribos_bar_sales_invoices.total_amount', 
                            'ribos_bar_sales_invoices.created_by', 
                            'ribos_bar_sales_invoices.created_at', 
                            'ribos_bar_sales_invoices.deleted_at',                     
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_sales_invoices.si_id', NULL)
                        ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->whereDate('ribos_bar_sales_invoices.created_at', '=', date($getDateToday))
                        ->orderBy('ribos_bar_sales_invoices.id', 'desc')
                        ->get()->toArray();

        $totalSalesInvoice = DB::table(
                            'ribos_bar_sales_invoices')
                            ->select(
                                'ribos_bar_sales_invoices.id',
                                'ribos_bar_sales_invoices.user_id',
                                'ribos_bar_sales_invoices.si_id',
                                'ribos_bar_sales_invoices.invoice_number',
                                'ribos_bar_sales_invoices.date',
                                'ribos_bar_sales_invoices.ordered_by',
                                'ribos_bar_sales_invoices.address',
                                'ribos_bar_sales_invoices.qty',
                                'ribos_bar_sales_invoices.total_kls',
                                'ribos_bar_sales_invoices.item_description',
                                'ribos_bar_sales_invoices.unit_price',
                                'ribos_bar_sales_invoices.amount',
                                'ribos_bar_sales_invoices.total_amount', 
                                'ribos_bar_sales_invoices.created_by', 
                                'ribos_bar_sales_invoices.created_at',  
                                'ribos_bar_sales_invoices.deleted_at',                     
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_sales_invoices.si_id', NULL)
                            ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->whereDate('ribos_bar_sales_invoices.created_at', '=', date($getDateToday))
                           ->sum('ribos_bar_sales_invoices.total_amount');
        

        $moduleNamePO = "Purchase Order";
        $purchaseOrders = DB::table(
                        'ribos_bar_purchase_orders')
                        ->select(
                            'ribos_bar_purchase_orders.id',
                            'ribos_bar_purchase_orders.user_id',
                            'ribos_bar_purchase_orders.po_id',
                            'ribos_bar_purchase_orders.paid_to',
                            'ribos_bar_purchase_orders.address',
                            'ribos_bar_purchase_orders.branch_location',
                            'ribos_bar_purchase_orders.date',
                            'ribos_bar_purchase_orders.quantity',
                            'ribos_bar_purchase_orders.description',
                            'ribos_bar_purchase_orders.unit_price',
                            'ribos_bar_purchase_orders.amount',
                            'ribos_bar_purchase_orders.total_price',
                            'ribos_bar_purchase_orders.requested_by',
                            'ribos_bar_purchase_orders.prepared_by',
                            'ribos_bar_purchase_orders.checked_by',
                            'ribos_bar_purchase_orders.created_by',
                            'ribos_bar_purchase_orders.created_at',
                            'ribos_bar_purchase_orders.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_purchase_orders.po_id', NULL)
                        ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleNamePO)
                        ->whereDate('ribos_bar_purchase_orders.created_at', '=', date($getDateToday))
                        ->orderBy('ribos_bar_purchase_orders.id', 'desc')
                        ->get()->toArray();
        
        $totalPOrder = DB::table(
                            'ribos_bar_purchase_orders')
                            ->select(
                                'ribos_bar_purchase_orders.id',
                                'ribos_bar_purchase_orders.user_id',
                                'ribos_bar_purchase_orders.po_id',
                                'ribos_bar_purchase_orders.paid_to',
                                'ribos_bar_purchase_orders.address',
                                'ribos_bar_purchase_orders.branch_location',
                                'ribos_bar_purchase_orders.date',
                                'ribos_bar_purchase_orders.quantity',
                                'ribos_bar_purchase_orders.description',
                                'ribos_bar_purchase_orders.unit_price',
                                'ribos_bar_purchase_orders.amount',
                                'ribos_bar_purchase_orders.total_price',
                                'ribos_bar_purchase_orders.requested_by',
                                'ribos_bar_purchase_orders.prepared_by',
                                'ribos_bar_purchase_orders.checked_by',
                                'ribos_bar_purchase_orders.created_by',
                                'ribos_bar_purchase_orders.created_at',
                                'ribos_bar_purchase_orders.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_purchase_orders.po_id', NULL)
                            ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePO)
                            ->whereDate('ribos_bar_purchase_orders.created_at', '=', date($getDateToday))
                            ->sum('ribos_bar_purchase_orders.total_price');
            
        $moduleNamePetty = "Petty Cash";
        $pettyCashLists = DB::table(
                                'ribos_bar_petty_cashes')
                                ->select( 
                                'ribos_bar_petty_cashes.id',
                                'ribos_bar_petty_cashes.user_id',
                                'ribos_bar_petty_cashes.pc_id',
                                'ribos_bar_petty_cashes.date',
                                'ribos_bar_petty_cashes.petty_cash_name',
                                'ribos_bar_petty_cashes.petty_cash_summary',
                                'ribos_bar_petty_cashes.amount',
                                'ribos_bar_petty_cashes.created_by',
                                'ribos_bar_petty_cashes.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_petty_cashes.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_petty_cashes.pc_id', NULL)
                                ->where('ribos_bar_petty_cashes.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePetty)
                                ->whereDate('ribos_bar_petty_cashes.created_at', '=', date($getDateToday))
                                ->orderBy('ribos_bar_petty_cashes.id', 'desc')
                                ->get()->toArray();


        $moduleNamePV = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                                ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                                ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();
    
        $totalAmountCashes = DB::table(
                                'ribos_bar_payment_vouchers')
                                ->select( 
                                'ribos_bar_payment_vouchers.id',
                                'ribos_bar_payment_vouchers.user_id',
                                'ribos_bar_payment_vouchers.pv_id',
                                'ribos_bar_payment_vouchers.date',
                                'ribos_bar_payment_vouchers.paid_to',
                                'ribos_bar_payment_vouchers.account_no',
                                'ribos_bar_payment_vouchers.account_name',
                                'ribos_bar_payment_vouchers.particulars',
                                'ribos_bar_payment_vouchers.amount',
                                'ribos_bar_payment_vouchers.method_of_payment',
                                'ribos_bar_payment_vouchers.prepared_by',
                                'ribos_bar_payment_vouchers.approved_by',
                                'ribos_bar_payment_vouchers.date_apprroved',
                                'ribos_bar_payment_vouchers.received_by_date',
                                'ribos_bar_payment_vouchers.created_by',
                                'ribos_bar_payment_vouchers.created_at',
                                'ribos_bar_payment_vouchers.invoice_number',
                                'ribos_bar_payment_vouchers.voucher_ref_number',
                                'ribos_bar_payment_vouchers.issued_date',
                                'ribos_bar_payment_vouchers.category',
                                'ribos_bar_payment_vouchers.amount_due',
                                'ribos_bar_payment_vouchers.delivered_date',
                                'ribos_bar_payment_vouchers.status',
                                'ribos_bar_payment_vouchers.cheque_number',
                                'ribos_bar_payment_vouchers.cheque_amount',
                                'ribos_bar_payment_vouchers.sub_category',
                                'ribos_bar_payment_vouchers.sub_category_account_id',
                                'ribos_bar_payment_vouchers.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                                ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleNamePV)
                                ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('ribos_bar_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                               ->sum('ribos_bar_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.cheque_total_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.created_at',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->leftJoin('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleNamePV)
                            ->whereDate('ribos_bar_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('ribos_bar_payment_vouchers.method_of_payment', $check)
                            ->where('ribos_bar_payment_vouchers.status', '!=', $status)
                            ->sum('ribos_bar_payment_vouchers.amount_due');

        $uri0 = "";
        $uri1 = "";

        return view('ribos-bar-summary-report', compact('getAllSalesInvoices', 
        'totalSalesInvoice', 'purchaseOrders', 'totalPOrder','pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
    }

    public function printPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash =  DB::table(
                            'ribos_bar_petty_cashes')
                            ->select( 
                            'ribos_bar_petty_cashes.id',
                            'ribos_bar_petty_cashes.user_id',
                            'ribos_bar_petty_cashes.pc_id',
                            'ribos_bar_petty_cashes.date',
                            'ribos_bar_petty_cashes.petty_cash_name',
                            'ribos_bar_petty_cashes.petty_cash_summary',
                            'ribos_bar_petty_cashes.amount',
                            'ribos_bar_petty_cashes.created_by',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->join('ribos_bar_codes', 'ribos_bar_petty_cashes.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_petty_cashes.id', $id)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->get();

        $getPettyCashSummaries = RibosBarPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = RibosBarPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = RibosBarPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashRibosBar', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
        return $pdf->download('ribos-bar-petty-cash.pdf');

    }

    public function updatePC(Request $request, $id){
        $updatePC = RibosBarPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashRibosBar', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pettyCash = RibosBarPettyCash::find($id);

        $addNew = new RibosBarPettyCash([
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

        return redirect()->route('editPettyCashRibosBar', ['id'=>$id]);
    }

    public function updatePettyCash(Request $request, $id){
        $updatePettyCash = RibosBarPettyCash::find($id);
        $updatePettyCash->date = $request->get('date');
        $updatePettyCash->petty_cash_name = $request->get('pettyCashName');
        $updatePettyCash->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePettyCash->save();

        Session::flash('editSuccess', 'Successfully updated.');

        return redirect()->route('editPettyCashRibosBar', ['id'=>$id]);

    }

    public function editPettyCash($id){
        $pettyCash = RibosBarPettyCash::find($id);

        $moduleName = "Petty Cash";
        $pettyCash = DB::table(
                                'ribos_bar_petty_cashes')
                                ->select( 
                                'ribos_bar_petty_cashes.id',
                                'ribos_bar_petty_cashes.user_id',
                                'ribos_bar_petty_cashes.pc_id',
                                'ribos_bar_petty_cashes.date',
                                'ribos_bar_petty_cashes.petty_cash_name',
                                'ribos_bar_petty_cashes.petty_cash_summary',
                                'ribos_bar_petty_cashes.amount',
                                'ribos_bar_petty_cashes.created_by',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->join('ribos_bar_codes', 'ribos_bar_petty_cashes.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_petty_cashes.id', $id)
                                ->where('ribos_bar_codes.module_name', $moduleName)
                                ->get();
      
        $pettyCashSummaries = RibosBarPettyCash::where('pc_id', $id)->get()->toArray();
        return view('edit-ribos-bar-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }

    public function addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
         //get the latest insert id query in table petty cash petty cash no
         $dataCashNo = DB::select('SELECT id, ribos_bar_code FROM ribos_bar_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
        if(isset($dataCashNo[0]->ribos_bar_code) != 0){
            //if code is not 0
            $newProd = $dataCashNo[0]->ribos_bar_code +1;
            $uPetty = sprintf("%06d",$newProd);   

        }else{
            //if code is 0 
            $newProd = 1;
            $uPetty = sprintf("%06d",$newProd);
        } 
 

        $addPettyCash = new RibosBarPettyCash([
            'user_id'=>$user->id,
            'date'=>$request->date,
            'petty_cash_name'=>$request->pettyCashName,
            'petty_cash_summary'=>$request->pettyCashSummary,
            'created_by'=>$name,
        ]);

        $addPettyCash->save();
        $insertId = $addPettyCash->id;
        
        $moduleCode = "PC-";
        $moduleName = "Petty Cash";

        $ribosBar = new RibosBarCode([
            'user_id'=>$user->id,
            'ribos_bar_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);

        $ribosBar->save();
      
        return response()->json($insertId);
    }

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

            //add the product IN
        $addProduct = $rawMaterial->in + $qty;

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

            $outProduct = 0.00;
            //update IN number of products
            $rawMaterial->in = $addProduct;
            $rawMaterial->out = $outProduct;
            $rawMaterial->remaining_stock = $addProduct;
            $rawMaterial->save();
    
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
        $dataProductId = DB::select('SELECT id, product_id_no FROM ribos_bar_raw_material_products ORDER BY id DESC LIMIT 1');

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

        //unit price times number of IN products
        $unitPrice = $request->unitPrice * $request->stockIn;
        $amount = $unitPrice;

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
                'in'=>$request->stockIn,
                'remaining_stock'=>$request->stockIn,
                'amount'=>$amount,
                'supplier'=>$request->supplier,
                'created_by'=>$name,
    
            ]);
            $addNewRawMaterial->save();
            $insertedId = $addNewRawMaterial->id;

            $addNewProd = new RibosBarRawMaterialProduct([
                'raw_materials_id'=>$insertedId,
                'branch'=>$request->branch,
                'product_id_no'=>$uProd,
            ]);
    
            $addNewProd->save();
            
            return response()->json('Success: successfully added a RAW Material');

        }else{
            return response()->json('Error: Product name already exist.');
        }
       


    }

    public function rawMaterials(){
        $getRawMaterials = DB::table(
                    'ribos_bar_raw_materials')
                    ->select(
                        'ribos_bar_raw_materials.id',
                        'ribos_bar_raw_materials.user_id',
                        'ribos_bar_raw_materials.rm_id',
                        'ribos_bar_raw_materials.product_name',
                        'ribos_bar_raw_materials.unit_price',
                        'ribos_bar_raw_materials.unit',
                        'ribos_bar_raw_materials.in',
                        'ribos_bar_raw_materials.out',
                        'ribos_bar_raw_materials.stock_amount',
                        'ribos_bar_raw_materials.remaining_stock',
                        'ribos_bar_raw_materials.amount',
                        'ribos_bar_raw_materials.supplier',
                        'ribos_bar_raw_materials.date',
                        'ribos_bar_raw_materials.item',
                        'ribos_bar_raw_materials.description',
                        'ribos_bar_raw_materials.reference_no',
                        'ribos_bar_raw_materials.qty',
                        'ribos_bar_raw_materials.requesting_branch',
                        'ribos_bar_raw_materials.cheque_no_issued',
                        'ribos_bar_raw_materials.status',
                        'ribos_bar_raw_materials.created_by',
                        'ribos_bar_raw_material_products.raw_materials_id',
                        'ribos_bar_raw_material_products.branch',
                        'ribos_bar_raw_material_products.product_id_no')
                    ->leftJoin('ribos_bar_raw_material_products', 'ribos_bar_raw_materials.id', '=', 'ribos_bar_raw_material_products.raw_materials_id')
                    ->where('ribos_bar_raw_materials.rm_id', NULL)
                    ->orderBy('ribos_bar_raw_materials.id', 'desc')
                    ->get()->toArray();
       
        return view('ribos-bar-raw-materials', compact('getRawMaterials'));
    }

    public function viewPettyCash($id){ 
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                                'ribos_bar_petty_cashes')
                                ->select( 
                                'ribos_bar_petty_cashes.id',
                                'ribos_bar_petty_cashes.user_id',
                                'ribos_bar_petty_cashes.pc_id',
                                'ribos_bar_petty_cashes.date',
                                'ribos_bar_petty_cashes.petty_cash_name',
                                'ribos_bar_petty_cashes.petty_cash_summary',
                                'ribos_bar_petty_cashes.amount',
                                'ribos_bar_petty_cashes.created_by',
                                'ribos_bar_petty_cashes.deleted_at',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->join('ribos_bar_codes', 'ribos_bar_petty_cashes.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_petty_cashes.id', $id)
                                ->where('ribos_bar_codes.module_name', $moduleName)
                                ->get();
      

        $getPettyCashSummaries = RibosBarPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = RibosBarPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = RibosBarPettyCash::where('pc_id', $id)->sum('amount');

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
         $moduleName = "Petty Cash";
         $pettyCashLists = DB::table(
                                 'ribos_bar_petty_cashes')
                                 ->select( 
                                 'ribos_bar_petty_cashes.id',
                                 'ribos_bar_petty_cashes.user_id',
                                 'ribos_bar_petty_cashes.pc_id',
                                 'ribos_bar_petty_cashes.date',
                                 'ribos_bar_petty_cashes.petty_cash_name',
                                 'ribos_bar_petty_cashes.petty_cash_summary',
                                 'ribos_bar_petty_cashes.amount',
                                 'ribos_bar_petty_cashes.created_by',
                                 'ribos_bar_petty_cashes.deleted_at',
                                 'ribos_bar_codes.ribos_bar_code',
                                 'ribos_bar_codes.module_id',
                                 'ribos_bar_codes.module_code',
                                 'ribos_bar_codes.module_name')
                                 ->join('ribos_bar_codes', 'ribos_bar_petty_cashes.id', '=', 'ribos_bar_codes.module_id')
                                 ->where('ribos_bar_petty_cashes.pc_id', NULL)
                                 ->where('ribos_bar_codes.module_name', $moduleName)
                                 ->where('ribos_bar_petty_cashes.deleted_at', NULL)
                                 ->orderBy('ribos_bar_petty_cashes.id', 'desc')
                                 ->get()->toArray();

       
        return view('ribos-bar-petty-cash-list', compact('pettyCashLists'));
    }

   
    public function printPO($id){
        $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                        'ribos_bar_purchase_orders')
                        ->select(
                            'ribos_bar_purchase_orders.id',
                            'ribos_bar_purchase_orders.user_id',
                            'ribos_bar_purchase_orders.po_id',
                            'ribos_bar_purchase_orders.paid_to',
                            'ribos_bar_purchase_orders.address',
                            'ribos_bar_purchase_orders.branch_location',
                            'ribos_bar_purchase_orders.date',
                            'ribos_bar_purchase_orders.quantity',
                            'ribos_bar_purchase_orders.description',
                            'ribos_bar_purchase_orders.unit_price',
                            'ribos_bar_purchase_orders.amount',
                            'ribos_bar_purchase_orders.total_price',
                            'ribos_bar_purchase_orders.requested_by',
                            'ribos_bar_purchase_orders.prepared_by',
                            'ribos_bar_purchase_orders.checked_by',
                            'ribos_bar_purchase_orders.created_by',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->join('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_purchase_orders.id', $id)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->orderBy('ribos_bar_purchase_orders.id', 'desc')
                        ->get();



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
    
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->join('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.id', $id)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->get();

        //getParticular details
        $getParticulars = RibosBarPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      
        $getChequeNumbers = RibosBarPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = RibosBarPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
         $amount1 = RibosBarPaymentVoucher::where('id', $id)->sum('amount');
         $amount2 = RibosBarPaymentVoucher::where('pv_id', $id)->sum('amount');
           
         $sum = $amount1 + $amount2;
         
         //
         $chequeAmount1 = RibosBarPaymentVoucher::where('id', $id)->sum('cheque_amount');
         $chequeAmount2 = RibosBarPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
         
         $sumCheque = $chequeAmount1 + $chequeAmount2;
       

        $pdf = PDF::loadView('printPayablesRibosBar', compact('payableId',  
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

        return $pdf->download('ribos-bar-payment-voucher.pdf');
    }
    
  
    public function viewPayableDetails($id){
       
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->join('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.id', $id)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->get();


        $getViewPaymentDetails = RibosBarPaymentVoucher::where('pv_id', $id)->get()->toArray();

        //getParticular details
        $getParticulars = RibosBarPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        return view('view-ribos-bar-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));

    }


    public function accept(Request $request, $id){
         //get the status 
        $status = $request->get('status');
        if($status == "FULLY PAID AND RELEASED"){
            switch ($request->get('action')) {
                case 'PAID AND RELEASE':
                    # code...
                     $ids = Auth::user()->id;
                    $user = User::find($ids);
            
                    $firstName = $user->first_name;
                    $lastName = $user->last_name;
            
                    $name  = $firstName." ".$lastName;

                     //get the date today
                     $getDate =  date("Y-m-d");

                    $payables = RibosBarPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
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


        $addParticulars = new RibosBarPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'date'=>$request->get('date'),
            'invoice_number'=>$request->get('invoiceNo'),
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
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

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');

        //save payment cheque num and cheque amount
        $addPayment = new RibosBarPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'invoice_number'=>$request->get('invoiceNo'),
            'account_name_no'=>$request->get('accountNameNo'),
            'date'=>$request->get('date'),
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

        $addPayment->save();

        //update the total cheque amount
        $paymentData->cheque_total_amount = $totalChequeAmount;
        $paymentData->save();
   

        Session::flash('paymentAdded', 'Payment added.');

         return redirect()->route('editPayablesDetailRibosBar', ['id'=>$id]);
    }

    
    public function editPayablesDetail(Request $request, $id){     
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->join('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.id', $id)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->get();
        

        
        $getChequeNumbers = RibosBarPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        $getCashAmounts = RibosBarPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
       

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
            , 'getParticulars', 'sumCheque', 'getCashAmounts'));
    }

    //
    public function transactionList(){
    
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'ribos_bar_payment_vouchers')
                            ->select( 
                            'ribos_bar_payment_vouchers.id',
                            'ribos_bar_payment_vouchers.user_id',
                            'ribos_bar_payment_vouchers.pv_id',
                            'ribos_bar_payment_vouchers.date',
                            'ribos_bar_payment_vouchers.paid_to',
                            'ribos_bar_payment_vouchers.account_no',
                            'ribos_bar_payment_vouchers.account_name',
                            'ribos_bar_payment_vouchers.particulars',
                            'ribos_bar_payment_vouchers.amount',
                            'ribos_bar_payment_vouchers.method_of_payment',
                            'ribos_bar_payment_vouchers.prepared_by',
                            'ribos_bar_payment_vouchers.approved_by',
                            'ribos_bar_payment_vouchers.date_apprroved',
                            'ribos_bar_payment_vouchers.received_by_date',
                            'ribos_bar_payment_vouchers.created_by',
                            'ribos_bar_payment_vouchers.invoice_number',
                            'ribos_bar_payment_vouchers.voucher_ref_number',
                            'ribos_bar_payment_vouchers.issued_date',
                            'ribos_bar_payment_vouchers.category',
                            'ribos_bar_payment_vouchers.amount_due',
                            'ribos_bar_payment_vouchers.delivered_date',
                            'ribos_bar_payment_vouchers.status',
                            'ribos_bar_payment_vouchers.cheque_number',
                            'ribos_bar_payment_vouchers.cheque_amount',
                            'ribos_bar_payment_vouchers.sub_category',
                            'ribos_bar_payment_vouchers.sub_category_account_id',
                            'ribos_bar_payment_vouchers.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                            ->join('ribos_bar_codes', 'ribos_bar_payment_vouchers.id', '=', 'ribos_bar_codes.module_id')
                            ->where('ribos_bar_payment_vouchers.pv_id', NULL)
                            ->where('ribos_bar_codes.module_name', $moduleName)
                            ->where('ribos_bar_payment_vouchers.deleted_at', NULL)
                            ->orderBy('ribos_bar_payment_vouchers.id', 'desc')
                            ->get()->toArray();
        

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

        $moduleName = "Billing Statement";
        $viewBillingStatement = DB::table(
                        'ribos_bar_billing_statements')
                        ->select(
                            'ribos_bar_billing_statements.id',
                            'ribos_bar_billing_statements.user_id',
                            'ribos_bar_billing_statements.billing_statement_id',
                            'ribos_bar_billing_statements.bill_to',
                            'ribos_bar_billing_statements.address',
                            'ribos_bar_billing_statements.date',
                            'ribos_bar_billing_statements.branch',
                            'ribos_bar_billing_statements.period_cover',
                            'ribos_bar_billing_statements.terms',
                            'ribos_bar_billing_statements.date_of_transaction',
                            'ribos_bar_billing_statements.invoice_number',
                            'ribos_bar_billing_statements.description',
                            'ribos_bar_billing_statements.amount',
                            'ribos_bar_billing_statements.created_by',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_billing_statements.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_billing_statements.id', $id)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->get();

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
        $moduleName = "Billing Statement";

        $billingStatements = DB::table(
                        'ribos_bar_billing_statements')
                        ->select(
                            'ribos_bar_billing_statements.id',
                            'ribos_bar_billing_statements.user_id',
                            'ribos_bar_billing_statements.billing_statement_id',
                            'ribos_bar_billing_statements.bill_to',
                            'ribos_bar_billing_statements.address',
                            'ribos_bar_billing_statements.date',
                            'ribos_bar_billing_statements.branch',
                            'ribos_bar_billing_statements.period_cover',
                            'ribos_bar_billing_statements.terms',
                            'ribos_bar_billing_statements.date_of_transaction',
                            'ribos_bar_billing_statements.invoice_number',
                            'ribos_bar_billing_statements.description',
                            'ribos_bar_billing_statements.amount',
                            'ribos_bar_billing_statements.created_by',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_billing_statements.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_billing_statements.billing_statement_id', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->orderBy('ribos_bar_billing_statements.id', 'desc')
                        ->get();


        return view('ribos-bar-billing-statement-lists', compact('billingStatements'));
    }

 

    //
    public function addNewBillingData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = RibosBarBillingStatement::find($id);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $amount = $request->get('amount');
        $tot = $billingOrder->total_amount + $amount;

        if($request->get('choose') === "Sales Invoice"){
            $order = $request->get('choose');
            $invoiceNo = $request->get('invoiceNumber');
            $invoiceListId = $request->get('invoiceListId');
            $qty = $request->get('qty');
            $totalKls = $request->get('totalKls');
            $unitPrice = $request->get('unitPrice');

            $drNo = NULL;
            $productId = NULL;
            $unit = NULL;
            $drList = NULL;
            $unit = NULL;
        }else{
            $order = $request->get('choose');
            $qty = $request->get('qty');
            $unitPrice = $request->get('unitPrice');
            $drNo = $request->get('drNo');
            $productId  = $request->get('productId');
            $unit = $request->get('unit'); 
            $drList = $request->get('drList');
            $unit = $request->get('unit');

            $invoiceNo = NULL;
            $invoiceListId = NULL;
            $totalKls = NULL; 
        }

        $addBillingStatement = new RibosBarBillingStatement([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'date_of_transaction'=>$request->get('transactionDate'),
            'order'=>$order,
            'invoice_list_id'=>$invoiceListId,
            'qty'=>$qty,
            'dr_no'=>$drNo,
            'dr_list_id'=>$drList,
            'product_id'=>$productId,
            'total_kls'=>$totalKls,
            'invoice_number'=>$request->get('invoiceNumber'),
            'description'=>$request->get('description'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addBillingStatement->save();

         //save to table statement of account
         $addStatementAccount =  new RibosBarStatementOfAccount([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'date_of_transaction'=>$request->get('transactionDate'),
            'invoice_number'=>$request->get('invoiceNumber'),
            'description'=>$request->get('description'),
            'order'=>$order,
            'invoice_list_id'=>$invoiceListId,
            'qty'=>$qty,
            'dr_no'=>$drNo,
            'dr_list_id'=>$drList,
            'product_id'=>$productId,
            'total_kls'=>$totalKls,
            'amount'=>$amount,
            'created_by'=>$name,
         ]);
         $addStatementAccount->save();

         $statementOrder = RibosBarStatementOfAccount::find($id);
            
         //update
         $billingOrder->total_amount = $tot;
         $billingOrder->save();

            //update soa table
        $statementOrder->total_amount  = $tot;
        $statementOrder->total_remaining_balance = $tot;
        $statementOrder->save();
  

        Session::flash('addBillingSuccess', 'Successfully added.');

        return redirect()->route('editBillingStatementRibosBar', ['id'=>$id]);
    }

    //
    public function addNewBilling($id){

        return view('add-new-ribos-bar-billing-statement', compact('id'));
    }

    //
    public function updateBillingInfo(Request $request, $id){
        $updateBillingOrder = RibosBarBillingStatement::find($id);

      

        $updateBillingOrder->bill_to = $request->get('billTo');
        $updateBillingOrder->address = $request->get('address');
        $updateBillingOrder->period_cover = $request->get('periodCovered');
        $updateBillingOrder->date = $request->get('date');
        $updateBillingOrder->terms = $request->get('terms');
        $updateBillingOrder->p_o_number = $request->get('poNumber');
        $updateBillingOrder->invoice_number = $request->get('invoiceNumber');
        $updateBillingOrder->date_of_transaction = $request->get('transactionDate');
        $updateBillingOrder->description = $request->get('description');
        $updateBillingOrder->amount = $add;

        $updateBillingOrder->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect('ribos-bar/edit-ribos-bar-billing-statement/'.$id);
    }

    //
    public function editBillingStatement($id){
      
        $billingStatement = RibosBarBillingStatement::find($id);

        $moduleName = "Delivery Receipt";
        $drNos = DB::table(
                    'ribos_bar_delivery_receipts')
                    ->select( 
                    'ribos_bar_delivery_receipts.id',
                    'ribos_bar_delivery_receipts.user_id',
                    'ribos_bar_delivery_receipts.dr_id',
                    'ribos_bar_delivery_receipts.delivered_to',
                    'ribos_bar_delivery_receipts.address',
                    'ribos_bar_delivery_receipts.dr_no',
                    'ribos_bar_delivery_receipts.date',
                    'ribos_bar_delivery_receipts.product_id',
                    'ribos_bar_delivery_receipts.qty',
                    'ribos_bar_delivery_receipts.unit',
                    'ribos_bar_delivery_receipts.item_description',
                    'ribos_bar_delivery_receipts.unit_price',
                    'ribos_bar_delivery_receipts.amount',
                    'ribos_bar_delivery_receipts.prepared_by',
                    'ribos_bar_delivery_receipts.approved_by',
                    'ribos_bar_delivery_receipts.checked_by',
                    'ribos_bar_delivery_receipts.received_by',
                    'ribos_bar_delivery_receipts.created_by',      
                    'ribos_bar_codes.ribos_bar_code',
                    'ribos_bar_codes.module_id',
                    'ribos_bar_codes.module_code',
                    'ribos_bar_codes.module_name')
                    ->leftJoin('ribos_bar_codes', 'ribos_bar_delivery_receipts.id', '=', 'ribos_bar_codes.module_id')
                    ->where('ribos_bar_delivery_receipts.dr_id', NULL)
                    ->where('ribos_bar_codes.module_name', $moduleName)
                    ->get()->toArray();

        $moduleNameSales = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                    'ribos_bar_sales_invoices')
                    ->select(
                        'ribos_bar_sales_invoices.id',
                        'ribos_bar_sales_invoices.user_id',
                        'ribos_bar_sales_invoices.si_id',
                        'ribos_bar_sales_invoices.invoice_number',
                        'ribos_bar_sales_invoices.date',
                        'ribos_bar_sales_invoices.ordered_by',
                        'ribos_bar_sales_invoices.address',
                        'ribos_bar_sales_invoices.qty',
                        'ribos_bar_sales_invoices.total_kls',
                        'ribos_bar_sales_invoices.item_description',
                        'ribos_bar_sales_invoices.unit_price',
                        'ribos_bar_sales_invoices.amount',
                        'ribos_bar_sales_invoices.total_amount', 
                        'ribos_bar_sales_invoices.created_by',
                        'ribos_bar_sales_invoices.deleted_at',                     
                        'ribos_bar_codes.ribos_bar_code',
                        'ribos_bar_codes.module_id',
                        'ribos_bar_codes.module_code',
                        'ribos_bar_codes.module_name')
                    ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                    ->where('ribos_bar_sales_invoices.si_id', NULL)
                    ->where('ribos_bar_codes.module_name', $moduleNameSales)
                    ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                    ->get()->toArray();


       
        $bStatements = RibosBarBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //get the purchase order lists
        $getPurchaseOrders = RibosBarPurchaseOrder::where('po_id', NULL)->get()->toArray();
        
        return view('edit-ribos-bar-billing-statement-form', compact('id', 'billingStatement', 'bStatements', 
        'getPurchaseOrders', 'drNos', 'getAllSalesInvoices'));
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
        ]);

         //get the latest insert id query in table billing statements ref number
        $dataReferenceNum = DB::select('SELECT id, ribos_bar_code FROM ribos_bar_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataReferenceNum[0]->ribos_bar_code) != 0){
            //if code is not 0
            $newRefNum = $dataReferenceNum[0]->ribos_bar_code +1;
            $uRef = sprintf("%06d",$newRefNum);   

        }else{
            //if code is 0 
            $newRefNum = 1;
            $uRef = sprintf("%06d",$newRefNum);
        } 

        if($request->get('choose') === "Sales Invoice"){
            $order = $request->get('choose');
            $invoiceNo = $request->get('invoiceNumber');
            $invoiceListId = $request->get('invoiceListId');
            $qty = $request->get('qty');
            $totalKls = $request->get('totalKls');
            $unitPrice = $request->get('unitPrice');

            $drNo = NULL;
            $productId = NULL;
            $unit = NULL;
            $drList = NULL;
            $unit = NULL;
        }else{
            $order = $request->get('choose');
            $qty = $request->get('qty');
            $unitPrice = $request->get('unitPrice');
            $drNo = $request->get('drNo');
            $productId  = $request->get('productId');
            $unit = $request->get('unit'); 
            $drList = $request->get('drList');
            $unit = $request->get('unit');

            $invoiceNo = NULL;
            $invoiceListId = NULL;
            $totalKls = NULL; 
        }

          $billingStatement = new RibosBarBillingStatement([
            'user_id'=>$user->id,
            'bill_to'=>$request->get('billTo'),
            'address'=>$request->get('address'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'invoice_number'=>$invoiceNo,
            'terms'=>$request->get('terms'),
            'date_of_transaction'=>$request->get('transactionDate'),
            'order'=>$order,
            'invoice_list_id'=>$invoiceListId,
            'qty'=>$qty,
            'dr_no'=>$drNo,
            'dr_list_id'=>$drList,
            'product_id'=>$productId,
            'total_kls'=>$totalKls,
            'description'=>$request->get('description'),
            'unit_price'=>$unitPrice,
            'unit'=>$unit,
            'amount'=>$request->get('amount'),
            'total_amount'=>$request->get('amount'),
            'created_by'=>$name,
            'prepared_by'=>$name,
        ]);

        $billingStatement->save();

        $insertedId = $billingStatement->id;

        $moduleCode = "BS-";
        $moduleName = "Billing Statement";

        $ribosBarCode = new RibosBarCode([
            'user_id'=>$user->id,
            'ribos_bar_code'=>$uRef,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);

        $ribosBarCode->save();
        $bsNo = $ribosBarCode->id;

        $bsNoId = RibosBarCode::find($bsNo);

        $statementAccount = new RibosBarStatementOfAccount([
            'user_id'=>$user->id,
            'bill_to'=>$request->get('billTo'),
            'bs_no'=>$bsNoId->lolo_pinoy_grill_code,
            'dr_no'=>$drNo,
            'product_id'=>$productId,
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'invoice_number'=>$request->get('invoiceNumber'),
            'terms'=>$request->get('terms'),
            'date_of_transaction'=>$request->get('transactionDate'),
            'qty'=>$qty,
            'description'=>$request->get('description'),
            'unit_price'=>$unitPrice,
            'unit'=>$unit,
            'amount'=>$request->get('amount'),
            'total_amount'=>$request->get('amount'),
            'total_remaining_balance'=>$request->get('amount'),
            'created_by'=>$name,
            'prepared_by'=>$name,
        ]);
        
        $statementAccount->save();
        $insertedIdStatement = $statementAccount->id;

        $moduleCodeSOA = "SOA-";
        $moduleNameSOA = "Statement Of Account";

        $uRefStatement = $uRef + 1; 
        $uRefState = sprintf("%06d",$uRefStatement);
        
        $statement = new RibosBarCode([
            'user_id'=>$user->id,
            'ribos_bar_code'=>$uRefState,
            'module_id'=>$insertedIdStatement,
            'module_code'=>$moduleCodeSOA,
            'module_name'=>$moduleNameSOA,
        ]);

        $statement->save();
        
        return redirect()->route('editBillingStatementRibosBar', ['id'=>$insertedId]);

    }

    //
    public function billingStatementForm(){
        $moduleName = "Delivery Receipt";
        $drNos = DB::table(
                    'ribos_bar_delivery_receipts')
                    ->select( 
                    'ribos_bar_delivery_receipts.id',
                    'ribos_bar_delivery_receipts.user_id',
                    'ribos_bar_delivery_receipts.dr_id',
                    'ribos_bar_delivery_receipts.delivered_to',
                    'ribos_bar_delivery_receipts.address',
                    'ribos_bar_delivery_receipts.dr_no',
                    'ribos_bar_delivery_receipts.date',
                    'ribos_bar_delivery_receipts.product_id',
                    'ribos_bar_delivery_receipts.qty',
                    'ribos_bar_delivery_receipts.unit',
                    'ribos_bar_delivery_receipts.item_description',
                    'ribos_bar_delivery_receipts.unit_price',
                    'ribos_bar_delivery_receipts.amount',
                    'ribos_bar_delivery_receipts.prepared_by',
                    'ribos_bar_delivery_receipts.approved_by',
                    'ribos_bar_delivery_receipts.checked_by',
                    'ribos_bar_delivery_receipts.received_by',
                    'ribos_bar_delivery_receipts.created_by',      
                    'ribos_bar_codes.ribos_bar_code',
                    'ribos_bar_codes.module_id',
                    'ribos_bar_codes.module_code',
                    'ribos_bar_codes.module_name')
                    ->leftJoin('ribos_bar_codes', 'ribos_bar_delivery_receipts.id', '=', 'ribos_bar_codes.module_id')
                    ->where('ribos_bar_delivery_receipts.dr_id', NULL)
                    ->where('ribos_bar_codes.module_name', $moduleName)
                    ->get()->toArray();



        $moduleNameSales = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'ribos_bar_sales_invoices')
                        ->select(
                            'ribos_bar_sales_invoices.id',
                            'ribos_bar_sales_invoices.user_id',
                            'ribos_bar_sales_invoices.si_id',
                            'ribos_bar_sales_invoices.invoice_number',
                            'ribos_bar_sales_invoices.date',
                            'ribos_bar_sales_invoices.ordered_by',
                            'ribos_bar_sales_invoices.address',
                            'ribos_bar_sales_invoices.qty',
                            'ribos_bar_sales_invoices.total_kls',
                            'ribos_bar_sales_invoices.item_description',
                            'ribos_bar_sales_invoices.unit_price',
                            'ribos_bar_sales_invoices.amount',
                            'ribos_bar_sales_invoices.total_amount', 
                            'ribos_bar_sales_invoices.created_by',
                            'ribos_bar_sales_invoices.deleted_at',                     
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_sales_invoices.si_id', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleNameSales)
                        ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                        ->get()->toArray();
       

        return view('ribos-bar-billing-statement-form', compact('getAllSalesInvoices', 'drNos'));
    }

    //
    public function viewSalesInvoice($id){
        $moduleName = "Sales Invoice";
        $viewSalesInvoice = DB::table(
                        'ribos_bar_sales_invoices')
                        ->select(
                            'ribos_bar_sales_invoices.id',
                            'ribos_bar_sales_invoices.user_id',
                            'ribos_bar_sales_invoices.si_id',
                            'ribos_bar_sales_invoices.invoice_number',
                            'ribos_bar_sales_invoices.date',
                            'ribos_bar_sales_invoices.ordered_by',
                            'ribos_bar_sales_invoices.address',
                            'ribos_bar_sales_invoices.qty',
                            'ribos_bar_sales_invoices.total_kls',
                            'ribos_bar_sales_invoices.item_description',
                            'ribos_bar_sales_invoices.unit_price',
                            'ribos_bar_sales_invoices.amount',
                            'ribos_bar_sales_invoices.total_amount', 
                            'ribos_bar_sales_invoices.created_by',
                            'ribos_bar_sales_invoices.deleted_at',                     
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_sales_invoices.id', $id)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->orderBy('ribos_bar_sales_invoices.id', 'desc')
                        ->get();



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

        $getRibosBar = RibosBarSalesInvoice::find($id);
        $totalAmount = $getRibosBar->total_amount + $sum;
    
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

        //update
        $getRibosBar->total_amount = $totalAmount; 
        $getRibosBar->save();

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


          //get the latest insert id query in table ribos_bar_codes
          $dataSalesNo = DB::select('SELECT id, ribos_bar_code FROM ribos_bar_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 dr_no
          if(isset($dataSalesNo[0]->ribos_bar_code) != 0){
              //if code is not 0
              $newSI = $dataSalesNo[0]->ribos_bar_code +1;
              $uSI = sprintf("%06d",$newSI);   
  
          }else{
              //if code is 0 
              $newSI = 1;
              $uSI = sprintf("%06d",$newSI);
          } 

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
            'date'=>$request->get('date'),
            'qty'=>$request->get('qty'),
            'total_kls'=>$kls,
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'total_amount'=>$sum,
            'created_by'=>$name,
        ]);

        $addSalesInvoice->save();

        $insertedId = $addSalesInvoice->id;

        $moduleCode = "SI-";
        $moduleName = "Sales Invoice";

        $ribosBar = new RibosBarCode([
            'user_id'=>$user->id,
            'ribos_bar_code'=>$uSI,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $ribosBar->save();

        return redirect()->route('editSalesInvoiceRB', ['id'=>$insertedId]);
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
        $dataVoucherRef = DB::select('SELECT id, ribos_bar_code FROM ribos_bar_codes ORDER BY id DESC LIMIT 1');

           //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->ribos_bar_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->ribos_bar_code +1;
            $uVoucher = sprintf("%06d",$newVoucherRef);   

        }else{
            //if code is 0 
            $newVoucherRef = 1;
            $uVoucher = sprintf("%06d",$newVoucherRef);
        } 

           //get the category
       if($request->get('category') == "Petty Cash"){
             $subCat = NULL;
             $subCatAcctId = NULL;

             $supplierExp = NULL;
             $supplierExp1 = NULL;
        }else if($request->get('category') == "Utility"){
            $subCat = $request->get('bills');
            $subCatAcctId = $request->get('selectAccountID');

            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') == "None"){
            $subCat = NULL;
            $subCatAcctId = NULL;
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') === "Payroll"){  
            $subCat = NULL;
            $subCatAcctId = NULL;
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') == "Supplier"){
            $supplier = $request->get('supplierName');
            $supplierExps = explode("-", $supplier);

            $supplierExp =  $supplierExps[0];
            $supplierExp1 = $supplierExps[1];

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
                    'method_of_payment'=>$request->get('paymentMethod'),
                    'invoice_number'=>$request->get('invoiceNumber'),
                    'account_name'=>$request->get('accountName'),
                    'issued_date'=>$request->get('issuedDate'),
                    'delivered_date'=>$request->get('deliveredDate'),
                    'amount'=>$request->get('amount'),
                    'amount_due'=>$request->get('amount'),
                    'particulars'=>$request->get('particulars'),
                    'category'=>$request->get('category'),
                    'sub_category'=>$subCat,
                    'sub_category_account_id'=>$subCatAcctId,
                    'supplier_id'=>$supplierExp,
                    'supplier_name'=>$supplierExp1,  
                    'prepared_by'=>$name,
                    'created_by'=>$name,
            ]);

            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;

            $moduleCode = "PV-";
            $moduleName = "Payment Voucher";

            $ribosBar = new RibosBarCode([
                'user_id'=>$user->id,
                'ribos_bar_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
    
            ]);

            $ribosBar->save();

            return redirect()->route('editPayablesDetailRibosBar', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormRibosBar')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    
    }

    //payment voucher form
    public function paymentVoucherForm(){
     
        $moduleName = "Petty Cash";
        $pettyCashes = DB::table(
                                'ribos_bar_petty_cashes')
                                ->select( 
                                'ribos_bar_petty_cashes.id',
                                'ribos_bar_petty_cashes.user_id',
                                'ribos_bar_petty_cashes.pc_id',
                                'ribos_bar_petty_cashes.date',
                                'ribos_bar_petty_cashes.petty_cash_name',
                                'ribos_bar_petty_cashes.petty_cash_summary',
                                'ribos_bar_petty_cashes.amount',
                                'ribos_bar_petty_cashes.created_by',
                                'ribos_bar_codes.ribos_bar_code',
                                'ribos_bar_codes.module_id',
                                'ribos_bar_codes.module_code',
                                'ribos_bar_codes.module_name')
                                ->join('ribos_bar_codes', 'ribos_bar_petty_cashes.id', '=', 'ribos_bar_codes.module_id')
                                ->where('ribos_bar_petty_cashes.pc_id', NULL)
                                ->where('ribos_bar_codes.module_name', $moduleName)
                                ->get()->toArray();


        $getAllFlags = RibosBarUtility::get()->toArray();

         //get suppliers
         $suppliers = RibosBarSupplier::get()->toArray();

        return view('payment-voucher-form-ribos-bar', compact('getAllFlags', 'pettyCashes', 'suppliers'));
    }

    //
    public function purchaseOrderList(){
        $moduleName = "Purchase Order";
        $purchaseOrders = DB::table(
                        'ribos_bar_purchase_orders')
                        ->select(
                            'ribos_bar_purchase_orders.id',
                            'ribos_bar_purchase_orders.user_id',
                            'ribos_bar_purchase_orders.po_id',
                            'ribos_bar_purchase_orders.paid_to',
                            'ribos_bar_purchase_orders.address',
                            'ribos_bar_purchase_orders.branch_location',
                            'ribos_bar_purchase_orders.date',
                            'ribos_bar_purchase_orders.quantity',
                            'ribos_bar_purchase_orders.description',
                            'ribos_bar_purchase_orders.unit_price',
                            'ribos_bar_purchase_orders.amount',
                            'ribos_bar_purchase_orders.total_price',
                            'ribos_bar_purchase_orders.requested_by',
                            'ribos_bar_purchase_orders.prepared_by',
                            'ribos_bar_purchase_orders.checked_by',
                            'ribos_bar_purchase_orders.created_by',
                            'ribos_bar_purchase_orders.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->join('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_purchase_orders.po_id', NULL)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->where('ribos_bar_purchase_orders.deleted_at', NULL)
                        ->orderBy('ribos_bar_purchase_orders.id', 'desc')
                        ->get();

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
        $amount = $pO->total_price + $request->get('amount');

        $addNewParticulars = new RibosBarPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewParticulars->save();

        $pO->total_price = $amount; 
        $pO->save();

        Session::flash('addNewSuccess', 'Successfully added');

        return redirect()->route('editRB', ['id'=>$id]);
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
        $moduleName = "Delivery Receipt";
        $viewDeliveryReceipt = DB::table(
                    'ribos_bar_delivery_receipts')
                    ->select( 
                    'ribos_bar_delivery_receipts.id',
                    'ribos_bar_delivery_receipts.user_id',
                    'ribos_bar_delivery_receipts.dr_id',
                    'ribos_bar_delivery_receipts.delivered_to',
                    'ribos_bar_delivery_receipts.address',
                    'ribos_bar_delivery_receipts.dr_no',
                    'ribos_bar_delivery_receipts.date',
                    'ribos_bar_delivery_receipts.product_id',
                    'ribos_bar_delivery_receipts.qty',
                    'ribos_bar_delivery_receipts.unit',
                    'ribos_bar_delivery_receipts.item_description',
                    'ribos_bar_delivery_receipts.unit_price',
                    'ribos_bar_delivery_receipts.amount',
                    'ribos_bar_delivery_receipts.prepared_by',
                    'ribos_bar_delivery_receipts.approved_by',
                    'ribos_bar_delivery_receipts.checked_by',
                    'ribos_bar_delivery_receipts.received_by',
                    'ribos_bar_delivery_receipts.created_by',      
                    'ribos_bar_codes.ribos_bar_code',
                    'ribos_bar_codes.module_id',
                    'ribos_bar_codes.module_code',
                    'ribos_bar_codes.module_name')
                    ->leftJoin('ribos_bar_codes', 'ribos_bar_delivery_receipts.id', '=', 'ribos_bar_codes.module_id')
                    ->where('ribos_bar_delivery_receipts.id', $id)
                    ->where('ribos_bar_codes.module_name', $moduleName)
                    ->get()->toArray();
    

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

        return view('view-ribos-bar-delivery-receipt', compact('viewDeliveryReceipt', 'deliveryReceipts', 'countUnitPrice', 'sum', 'sum2'));
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

        $getAmount = $deliveryReceipt->total_amount + $sum;

        $avail = $request->get('productId'); 
        $availExp = explode("-", $avail);

        $rawMaterial = DB::table(
                'ribos_bar_raw_materials')
                ->select(
                    'ribos_bar_raw_materials.id',
                    'ribos_bar_raw_materials.user_id',
                    'ribos_bar_raw_materials.rm_id',
                    'ribos_bar_raw_materials.product_name',
                    'ribos_bar_raw_materials.unit_price',
                    'ribos_bar_raw_materials.unit',
                    'ribos_bar_raw_materials.in',
                    'ribos_bar_raw_materials.out',
                    'ribos_bar_raw_materials.stock_amount',
                    'ribos_bar_raw_materials.remaining_stock',
                    'ribos_bar_raw_materials.amount',
                    'ribos_bar_raw_materials.supplier',
                    'ribos_bar_raw_materials.date',
                    'ribos_bar_raw_materials.item',
                    'ribos_bar_raw_materials.description',
                    'ribos_bar_raw_materials.reference_no',
                    'ribos_bar_raw_materials.qty',
                    'ribos_bar_raw_materials.requesting_branch',
                    'ribos_bar_raw_materials.cheque_no_issued',
                    'ribos_bar_raw_materials.status',
                    'ribos_bar_raw_materials.created_by',
                    'ribos_bar_raw_material_products.raw_materials_id',
                    'ribos_bar_raw_material_products.branch',
                    'ribos_bar_raw_material_products.product_id_no')
                ->leftJoin('ribos_bar_raw_material_products', 'ribos_bar_raw_materials.id', '=', 'ribos_bar_raw_material_products.raw_materials_id')
                ->where('ribos_bar_raw_material_products.raw_materials_id', $availExp[0])
                ->orderBy('ribos_bar_raw_materials.id', 'desc')
                ->get();

          //minus available pcs from the qty
          $aPcs = $rawMaterial[0]->remaining_stock - $qty;
        
          //add qty to out 
          $out = $rawMaterial[0]->out + $qty;
              
          //compute the stock out amount in unit price
          $stockAmount = $rawMaterial[0]->unit_price * $qty;
              
          //update raw material table
          $updateRawMaterial = RibosBarRawMaterial::find($availExp[0]);
          
          $updateRawMaterial->out = $out;
          $updateRawMaterial->remaining_stock = $aPcs;
          $updateRawMaterial->stock_amount = $stockAmount;
          $updateRawMaterial->save();
  

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
        $deliveryReceipt->total_amount  = $getAmount; 
        $deliveryReceipt->save();

        Session::flash('addDeliveryReceiptSuccess', 'Successfully added.');

        return redirect()->route('editDeliveryReceiptRibosBar', ['id'=>$id]);

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

        $getRawMaterials = DB::table(
                    'ribos_bar_raw_materials')
                    ->select(
                        'ribos_bar_raw_materials.id',
                        'ribos_bar_raw_materials.user_id',
                        'ribos_bar_raw_materials.rm_id',
                        'ribos_bar_raw_materials.product_name',
                        'ribos_bar_raw_materials.unit_price',
                        'ribos_bar_raw_materials.unit',
                        'ribos_bar_raw_materials.in',
                        'ribos_bar_raw_materials.out',
                        'ribos_bar_raw_materials.stock_amount',
                        'ribos_bar_raw_materials.remaining_stock',
                        'ribos_bar_raw_materials.amount',
                        'ribos_bar_raw_materials.supplier',
                        'ribos_bar_raw_materials.date',
                        'ribos_bar_raw_materials.item',
                        'ribos_bar_raw_materials.description',
                        'ribos_bar_raw_materials.reference_no',
                        'ribos_bar_raw_materials.qty',
                        'ribos_bar_raw_materials.requesting_branch',
                        'ribos_bar_raw_materials.cheque_no_issued',
                        'ribos_bar_raw_materials.status',
                        'ribos_bar_raw_materials.created_by',
                        'ribos_bar_raw_material_products.raw_materials_id',
                        'ribos_bar_raw_material_products.branch',
                        'ribos_bar_raw_material_products.product_id_no')
                    ->leftJoin('ribos_bar_raw_material_products', 'ribos_bar_raw_materials.id', '=', 'ribos_bar_raw_material_products.raw_materials_id')
                    ->where('ribos_bar_raw_materials.rm_id', NULL)
                    ->orderBy('ribos_bar_raw_materials.id', 'desc')
                    ->get()->toArray();


         //dReceipts
        $dReceipts = RibosBarDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-ribos-bar-delivery-receipt', compact('id','getDeliveryReceipt', 'dReceipts', 'getRawMaterials'));
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
        ]);


         //get the latest insert id query in table ribos_bar_codes
        $dataDrNo = DB::select('SELECT id, ribos_bar_code FROM ribos_bar_codes ORDER BY id DESC LIMIT 1');
        
         //if code is not zero add plus 1 dr_no
        if(isset($dataDrNo[0]->ribos_bar_code) != 0){
            //if code is not 0
            $newDr = $dataDrNo[0]->ribos_bar_code +1;
            $uDr = sprintf("%06d",$newDr);   

        }else{
            //if code is 0 
            $newDr = 1;
            $uDr = sprintf("%06d",$newDr);
        } 

     

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

         $storeDeliveryReceipt = new RibosBarDeliveryReceipt([
            'user_id'=>$user->id,
            'dr_no'=>$uDr,            
            'date'=>$request->get('date'),
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

        $moduleCode = "DR-";
        $moduleName = "Delivery Receipt";

        //save to lechon_de_cebu_codes table
        $ribosBar = new RibosBarCode([
            'user_id'=>$user->id,
            'ribos_bar_code'=>$uDr,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $ribosBar->save();
        
        return redirect('ribos-bar/edit-ribos-bar-delivery-receipt/'.$insertedId);
    }

    //
    public function deliveryReceiptForm(){
        $getRawMaterials = DB::table(
                    'ribos_bar_raw_materials')
                    ->select(
                        'ribos_bar_raw_materials.id',
                        'ribos_bar_raw_materials.user_id',
                        'ribos_bar_raw_materials.rm_id',
                        'ribos_bar_raw_materials.product_name',
                        'ribos_bar_raw_materials.unit_price',
                        'ribos_bar_raw_materials.unit',
                        'ribos_bar_raw_materials.in',
                        'ribos_bar_raw_materials.out',
                        'ribos_bar_raw_materials.stock_amount',
                        'ribos_bar_raw_materials.remaining_stock',
                        'ribos_bar_raw_materials.amount',
                        'ribos_bar_raw_materials.supplier',
                        'ribos_bar_raw_materials.date',
                        'ribos_bar_raw_materials.item',
                        'ribos_bar_raw_materials.description',
                        'ribos_bar_raw_materials.reference_no',
                        'ribos_bar_raw_materials.qty',
                        'ribos_bar_raw_materials.requesting_branch',
                        'ribos_bar_raw_materials.cheque_no_issued',
                        'ribos_bar_raw_materials.status',
                        'ribos_bar_raw_materials.created_by',
                        'ribos_bar_raw_material_products.raw_materials_id',
                        'ribos_bar_raw_material_products.branch',
                        'ribos_bar_raw_material_products.product_id_no')
                    ->leftJoin('ribos_bar_raw_material_products', 'ribos_bar_raw_materials.id', '=', 'ribos_bar_raw_material_products.raw_materials_id')
                    ->where('ribos_bar_raw_materials.rm_id', NULL)
                    ->orderBy('ribos_bar_raw_materials.id', 'desc')
                    ->get()->toArray();

        return view('ribos-bar-delivery-receipt-form', ['getRawMaterials'=>$getRawMaterials]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
        $moduleName = "Sales Invoice";
         $getAllSalesInvoices = DB::table(
                         'ribos_bar_sales_invoices')
                         ->select(
                             'ribos_bar_sales_invoices.id',
                             'ribos_bar_sales_invoices.user_id',
                             'ribos_bar_sales_invoices.si_id',
                             'ribos_bar_sales_invoices.invoice_number',
                             'ribos_bar_sales_invoices.date',
                             'ribos_bar_sales_invoices.ordered_by',
                             'ribos_bar_sales_invoices.address',
                             'ribos_bar_sales_invoices.qty',
                             'ribos_bar_sales_invoices.total_kls',
                             'ribos_bar_sales_invoices.item_description',
                             'ribos_bar_sales_invoices.unit_price',
                             'ribos_bar_sales_invoices.amount',
                             'ribos_bar_sales_invoices.total_amount', 
                             'ribos_bar_sales_invoices.created_by', 
                             'ribos_bar_sales_invoices.deleted_at',                     
                             'ribos_bar_codes.ribos_bar_code',
                             'ribos_bar_codes.module_id',
                             'ribos_bar_codes.module_code',
                             'ribos_bar_codes.module_name')
                         ->leftJoin('ribos_bar_codes', 'ribos_bar_sales_invoices.id', '=', 'ribos_bar_codes.module_id')
                         ->where('ribos_bar_sales_invoices.si_id', NULL)
                         ->where('ribos_bar_codes.module_name', $moduleName)
                         ->where('ribos_bar_sales_invoices.deleted_at', NULL)
                         ->orderBy('ribos_bar_sales_invoices.id', 'desc')
                         ->get()->toArray();

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

           //get the latest insert id query in table ribos bar codes
        $data = DB::select('SELECT id, ribos_bar_code FROM ribos_bar_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1
         if(isset($data[0]->ribos_bar_code) != 0){
            //if code is not 0
            $newNum = $data[0]->ribos_bar_code +1;
            $uNum = sprintf("%06d",$newNum);    
        }else{
            //if code is 0 
            $newNum = 1;
            $uNum = sprintf("%06d",$newNum);
        }

        $purchaseOrder = new RibosBarPurchaseOrder([
            'user_id' =>$user->id,
            'paid_to'=>$request->get('paidTo'),
            'date'=>$request->get('date'),
            'address'=>$request->get('address'),
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'total_price'=>$request->get('amount'),
            'prepared_by'=>$name,
            'created_by'=>$name,
        ]);

        $purchaseOrder->save();

        $insertedId = $purchaseOrder->id;

        $moduleCode = "PO-";
        $moduleName = "Purchase Order";

        $ribosBar = new RibosBarCode([
            'user_id'=>$user->id,
            'ribos_bar_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,    
        ]);
        $ribosBar->save();

        return redirect()->route('editRB', ['id'=>$insertedId]);
        
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
                        'ribos_bar_purchase_orders')
                        ->select(
                            'ribos_bar_purchase_orders.id',
                            'ribos_bar_purchase_orders.user_id',
                            'ribos_bar_purchase_orders.po_id',
                            'ribos_bar_purchase_orders.paid_to',
                            'ribos_bar_purchase_orders.address',
                            'ribos_bar_purchase_orders.branch_location',
                            'ribos_bar_purchase_orders.date',
                            'ribos_bar_purchase_orders.quantity',
                            'ribos_bar_purchase_orders.description',
                            'ribos_bar_purchase_orders.unit_price',
                            'ribos_bar_purchase_orders.amount',
                            'ribos_bar_purchase_orders.total_price',
                            'ribos_bar_purchase_orders.requested_by',
                            'ribos_bar_purchase_orders.prepared_by',
                            'ribos_bar_purchase_orders.checked_by',
                            'ribos_bar_purchase_orders.created_by',
                            'ribos_bar_purchase_orders.deleted_at',
                            'ribos_bar_codes.ribos_bar_code',
                            'ribos_bar_codes.module_id',
                            'ribos_bar_codes.module_code',
                            'ribos_bar_codes.module_name')
                        ->leftJoin('ribos_bar_codes', 'ribos_bar_purchase_orders.id', '=', 'ribos_bar_codes.module_id')
                        ->where('ribos_bar_purchase_orders.id', $id)
                        ->where('ribos_bar_codes.module_name', $moduleName)
                        ->orderBy('ribos_bar_purchase_orders.id', 'desc')
                        ->get();

    
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

    
    public function destroyPettyCash($id){
        $pettyCash = RibosBarPettyCash::find($id);
        $pettyCash->delete();
    }

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

    public function destroySI($id){
        $salesInvoice = RibosBarSalesInvoice::find($id);
        $salesInvoice->delete();
    }

    //
    public function destroySalesInvoice(Request $request, $id){
        $siId = RibosBarSalesInvoice::find($request->siId);

        $salesInvoice = RibosBarSalesInvoice::find($id);
        $getAmount = $siId->total_amount - $salesInvoice->amount;

        $siId->total_amount = $getAmount;
        $siId->save();

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


    public function destroyPO($id){
        $purchaseOrder = RibosBarPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $poId = RibosBarPurchaseOrder::find($request->poId);

        $purchaseOrder = RibosBarPurchaseOrder::find($id);
        $getAmount = $poId->total_price - $purchaseOrder->amount;
        
        $poId->total_price = $getAmount; 
        $poId->save();

        $purchaseOrder->delete();
    }

    
}
