<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Session;
use Auth; 
use PDF;
use App\User;
use App\MrPotatoPurchaseOrder;
use App\MrPotatoDeliveryReceipt;
use App\MrPotatoPaymentVoucher;
use App\MrPotatoSalesInvoice;
use App\MrPotatoUtility;
use App\MrPotatoPettyCash;
use App\MrPotatoCode;
use App\MrPotatoBillingStatement; 
use App\MrPotatoSupplier;

class MrPotatoController extends Controller
{   

    public function printPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                    'mr_potato_petty_cashes')
                    ->select( 
                    'mr_potato_petty_cashes.id',
                    'mr_potato_petty_cashes.user_id',
                    'mr_potato_petty_cashes.pc_id',
                    'mr_potato_petty_cashes.date',
                    'mr_potato_petty_cashes.petty_cash_name',
                    'mr_potato_petty_cashes.petty_cash_summary',
                    'mr_potato_petty_cashes.amount',
                    'mr_potato_petty_cashes.created_by',
                    'mr_potato_petty_cashes.deleted_at',
                    'mr_potato_codes.mr_potato_code',
                    'mr_potato_codes.module_id',
                    'mr_potato_codes.module_code',
                    'mr_potato_codes.module_name')
                    ->leftJoin('mr_potato_codes', 'mr_potato_petty_cashes.id', '=', 'mr_potato_codes.module_id')
                    ->where('mr_potato_petty_cashes.id', $id)
                    ->where('mr_potato_codes.module_name', $moduleName)
                    ->get()->toArray();

        $getPettyCashSummaries = MrPotatoPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = MrPotatoPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = MrPotatoPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashMrPotato', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
        return $pdf->download('mr-potato-petty-cash.pdf');
            


    }

    public function printSupplier($id){
        $viewSupplier = MrPotatoSupplier::where('id', $id)->get();

        $printSuppliers = DB::table(
                        'mr_potato_payment_vouchers')
                        ->select( 
                        'mr_potato_payment_vouchers.id',
                        'mr_potato_payment_vouchers.user_id',
                        'mr_potato_payment_vouchers.pv_id',
                        'mr_potato_payment_vouchers.date',
                        'mr_potato_payment_vouchers.paid_to',
                        'mr_potato_payment_vouchers.account_no',
                        'mr_potato_payment_vouchers.account_name',
                        'mr_potato_payment_vouchers.particulars',
                        'mr_potato_payment_vouchers.amount',
                        'mr_potato_payment_vouchers.method_of_payment',
                        'mr_potato_payment_vouchers.prepared_by',
                        'mr_potato_payment_vouchers.approved_by',
                        'mr_potato_payment_vouchers.date_apprroved',
                        'mr_potato_payment_vouchers.received_by_date',
                        'mr_potato_payment_vouchers.created_by',
                        'mr_potato_payment_vouchers.created_at',
                        'mr_potato_payment_vouchers.invoice_number',
                        'mr_potato_payment_vouchers.voucher_ref_number',
                        'mr_potato_payment_vouchers.issued_date',
                        'mr_potato_payment_vouchers.category',
                        'mr_potato_payment_vouchers.amount_due',
                        'mr_potato_payment_vouchers.delivered_date',
                        'mr_potato_payment_vouchers.status',
                        'mr_potato_payment_vouchers.cheque_number',
                        'mr_potato_payment_vouchers.cheque_amount',
                        'mr_potato_payment_vouchers.sub_category',
                        'mr_potato_payment_vouchers.sub_category_account_id',
                        'mr_potato_payment_vouchers.supplier_name',
                        'mr_potato_payment_vouchers.deleted_at',
                        'mr_potato_suppliers.id',
                        'mr_potato_suppliers.date',
                        'mr_potato_suppliers.supplier_name')
                        ->leftJoin('mr_potato_suppliers', 'mr_potato_payment_vouchers.supplier_id', '=', 'mr_potato_suppliers.id')
                        ->where('mr_potato_suppliers.id', $id)  
                        ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
                        'mr_potato_payment_vouchers')
                        ->select( 
                        'mr_potato_payment_vouchers.id',
                        'mr_potato_payment_vouchers.user_id',
                        'mr_potato_payment_vouchers.pv_id',
                        'mr_potato_payment_vouchers.date',
                        'mr_potato_payment_vouchers.paid_to',
                        'mr_potato_payment_vouchers.account_no',
                        'mr_potato_payment_vouchers.account_name',
                        'mr_potato_payment_vouchers.particulars',
                        'mr_potato_payment_vouchers.amount',
                        'mr_potato_payment_vouchers.method_of_payment',
                        'mr_potato_payment_vouchers.prepared_by',
                        'mr_potato_payment_vouchers.approved_by',
                        'mr_potato_payment_vouchers.date_apprroved',
                        'mr_potato_payment_vouchers.received_by_date',
                        'mr_potato_payment_vouchers.created_by',
                        'mr_potato_payment_vouchers.created_at',
                        'mr_potato_payment_vouchers.invoice_number',
                        'mr_potato_payment_vouchers.voucher_ref_number',
                        'mr_potato_payment_vouchers.issued_date',
                        'mr_potato_payment_vouchers.category',
                        'mr_potato_payment_vouchers.amount_due',
                        'mr_potato_payment_vouchers.delivered_date',
                        'mr_potato_payment_vouchers.status',
                        'mr_potato_payment_vouchers.cheque_number',
                        'mr_potato_payment_vouchers.cheque_amount',
                        'mr_potato_payment_vouchers.sub_category',
                        'mr_potato_payment_vouchers.sub_category_account_id',
                        'mr_potato_payment_vouchers.supplier_id',
                        'mr_potato_payment_vouchers.supplier_name',
                        'mr_potato_payment_vouchers.deleted_at',
                        'mr_potato_suppliers.id',
                        'mr_potato_suppliers.date',
                        'mr_potato_suppliers.supplier_name')
                        ->leftJoin('mr_potato_suppliers', 'mr_potato_payment_vouchers.supplier_id', '=', 'mr_potato_suppliers.id')
                        ->where('mr_potato_suppliers.id', $id)  
                        ->where('mr_potato_payment_vouchers.status', '!=',  $status)  
                        ->sum('mr_potato_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSupplierMrPotato', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('mr-potato-supplier.pdf');
    }


    public function viewSupplier($id){
        $viewSupplier = MrPotatoSupplier::where('id', $id)->get();

        $supplierLists = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.created_at',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.supplier_name',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_suppliers.id',
                            'mr_potato_suppliers.date',
                            'mr_potato_suppliers.supplier_name')
                            ->leftJoin('mr_potato_suppliers', 'mr_potato_payment_vouchers.supplier_id', '=', 'mr_potato_suppliers.id')
                            ->where('mr_potato_suppliers.id', $id)  
                            ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
                        'mr_potato_payment_vouchers')
                        ->select( 
                        'mr_potato_payment_vouchers.id',
                        'mr_potato_payment_vouchers.user_id',
                        'mr_potato_payment_vouchers.pv_id',
                        'mr_potato_payment_vouchers.date',
                        'mr_potato_payment_vouchers.paid_to',
                        'mr_potato_payment_vouchers.account_no',
                        'mr_potato_payment_vouchers.account_name',
                        'mr_potato_payment_vouchers.particulars',
                        'mr_potato_payment_vouchers.amount',
                        'mr_potato_payment_vouchers.method_of_payment',
                        'mr_potato_payment_vouchers.prepared_by',
                        'mr_potato_payment_vouchers.approved_by',
                        'mr_potato_payment_vouchers.date_apprroved',
                        'mr_potato_payment_vouchers.received_by_date',
                        'mr_potato_payment_vouchers.created_by',
                        'mr_potato_payment_vouchers.created_at',
                        'mr_potato_payment_vouchers.invoice_number',
                        'mr_potato_payment_vouchers.voucher_ref_number',
                        'mr_potato_payment_vouchers.issued_date',
                        'mr_potato_payment_vouchers.category',
                        'mr_potato_payment_vouchers.amount_due',
                        'mr_potato_payment_vouchers.delivered_date',
                        'mr_potato_payment_vouchers.status',
                        'mr_potato_payment_vouchers.cheque_number',
                        'mr_potato_payment_vouchers.cheque_amount',
                        'mr_potato_payment_vouchers.sub_category',
                        'mr_potato_payment_vouchers.sub_category_account_id',
                        'mr_potato_payment_vouchers.supplier_id',
                        'mr_potato_payment_vouchers.supplier_name',
                        'mr_potato_payment_vouchers.deleted_at',
                        'mr_potato_suppliers.id',
                        'mr_potato_suppliers.date',
                        'mr_potato_suppliers.supplier_name')
                        ->leftJoin('mr_potato_suppliers', 'mr_potato_payment_vouchers.supplier_id', '=', 'mr_potato_suppliers.id')
                        ->where('mr_potato_suppliers.id', $id)  
                        ->where('mr_potato_payment_vouchers.status', '!=',  $status)  
                        ->sum('mr_potato_payment_vouchers.amount_due');

        return view('view-mr-potato-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue'));

    }

    public function addSupplier(Request $request){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //check if supplier name exits
        $target = DB::table(
                'mr_potato_suppliers')
                ->where('supplier_name', $request->supplierName)
                ->get()->first();

        if($target === NULL){
            $supplier = new MrPotatoSupplier([
                'user_id'=>$user->id,
                'date'=>$request->date,
                'supplier_name'=>$request->supplierName, 
                'created_by'=>$name,
            ]);
    
            $supplier->save();
            return response()->json('Success: successfully updated.');        
        }else{
            return response()->json('Failed: Already exist.');
        }
    }


    public function supplier(){
        $suppliers = MrPotatoSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('mr-potato-supplier', compact('suppliers'));
    }

    public function updateDetails(Request $request){
        $updateDetail = MrPotatoPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = MrPotatoPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = MrPotatoPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
         //main id 
         $updateParticular = MrPotatoPaymentVoucher::find($request->transId);

         //particular id
         $uIdParticular = MrPotatoPaymentVoucher::find($request->id);

         $amount = $request->amount; 

         $updateAmount =  $updateParticular->amount; 
        
         $uParticular = MrPotatoPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
         
         $tot = $updateAmount + $uParticular; 
        
       
         $uIdParticular->date  = $request->date;
         $uIdParticular->particulars = $request->particulars;
         $uIdParticular->amount = $amount; 
         $uIdParticular->save();
 
         $updateParticular->amount_due = $tot;
         $updateParticular->save();
         
         return response()->json('Success: successfully updated.');

    }

    public function updateParticulars(Request $request){
        $updateParticular =  MrPotatoPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = MrPotatoPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 
 
        $updateParticular->date = $request->date;
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
                                'mr_potato_sales_invoices')
                                ->select(
                                    'mr_potato_sales_invoices.id',
                                    'mr_potato_sales_invoices.user_id',
                                    'mr_potato_sales_invoices.si_id',
                                    'mr_potato_sales_invoices.invoice_number',
                                    'mr_potato_sales_invoices.date',
                                    'mr_potato_sales_invoices.ordered_by',
                                    'mr_potato_sales_invoices.address',
                                    'mr_potato_sales_invoices.qty',
                                    'mr_potato_sales_invoices.total_kls',
                                    'mr_potato_sales_invoices.item_description',
                                    'mr_potato_sales_invoices.unit_price',
                                    'mr_potato_sales_invoices.amount',
                                    'mr_potato_sales_invoices.total_amount',
                                    'mr_potato_sales_invoices.created_by',
                                    'mr_potato_sales_invoices.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_sales_invoices.si_id', NULL)
                                ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->whereBetween('mr_potato_sales_invoices.created_at', [$uri0, $uri1])
                                ->orderBy('mr_potato_sales_invoices.id', 'desc')
                                ->get()->toArray();
      
          $totalSalesInvoice = DB::table(
                                  'mr_potato_sales_invoices')
                                  ->select(
                                      'mr_potato_sales_invoices.id',
                                      'mr_potato_sales_invoices.user_id',
                                      'mr_potato_sales_invoices.si_id',
                                      'mr_potato_sales_invoices.invoice_number',
                                      'mr_potato_sales_invoices.date',
                                      'mr_potato_sales_invoices.ordered_by',
                                      'mr_potato_sales_invoices.address',
                                      'mr_potato_sales_invoices.qty',
                                      'mr_potato_sales_invoices.total_kls',
                                      'mr_potato_sales_invoices.item_description',
                                      'mr_potato_sales_invoices.unit_price',
                                      'mr_potato_sales_invoices.amount',
                                      'mr_potato_sales_invoices.total_amount',
                                      'mr_potato_sales_invoices.created_by',
                                      'mr_potato_sales_invoices.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_sales_invoices.si_id', NULL)
                                  ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleName)
                                  ->whereBetween('mr_potato_sales_invoices.created_at', [$uri0, $uri1])
                                  ->sum('mr_potato_sales_invoices.total_amount');
      
          $moduleNameDR = "Delivery Receipt";
          $getAllDeliveryReceipts = DB::table(
                                  'mr_potato_delivery_receipts')
                                  ->select( 
                                  'mr_potato_delivery_receipts.id',
                                  'mr_potato_delivery_receipts.user_id',
                                  'mr_potato_delivery_receipts.dr_id',
                                  'mr_potato_delivery_receipts.delivered_to',
                                  'mr_potato_delivery_receipts.date',
                                  'mr_potato_delivery_receipts.address',
                                  'mr_potato_delivery_receipts.product_id',
                                  'mr_potato_delivery_receipts.unit',
                                  'mr_potato_delivery_receipts.item_description',
                                  'mr_potato_delivery_receipts.unit_price',
                                  'mr_potato_delivery_receipts.amount',
                                  'mr_potato_delivery_receipts.total_amount',
                                  'mr_potato_delivery_receipts.qty',
                                  'mr_potato_delivery_receipts.prepared_by',
                                  'mr_potato_delivery_receipts.checked_by',
                                  'mr_potato_delivery_receipts.received_by',
                                  'mr_potato_delivery_receipts.created_by',
                                  'mr_potato_delivery_receipts.created_at',
                                  'mr_potato_delivery_receipts.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                  ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNameDR)
                                  ->whereBetween('mr_potato_delivery_receipts.created_at', [$uri0, $uri1])
                                  ->orderBy('mr_potato_delivery_receipts.id', 'desc')
                                  ->get()->toArray();
                                
          $totalDeliveryReceipt = DB::table(
                                      'mr_potato_delivery_receipts')
                                      ->select( 
                                      'mr_potato_delivery_receipts.id',
                                      'mr_potato_delivery_receipts.user_id',
                                      'mr_potato_delivery_receipts.dr_id',
                                      'mr_potato_delivery_receipts.delivered_to',
                                      'mr_potato_delivery_receipts.date',
                                      'mr_potato_delivery_receipts.address',
                                      'mr_potato_delivery_receipts.product_id',
                                      'mr_potato_delivery_receipts.unit',
                                      'mr_potato_delivery_receipts.item_description',
                                      'mr_potato_delivery_receipts.unit_price',
                                      'mr_potato_delivery_receipts.amount',
                                      'mr_potato_delivery_receipts.total_amount',
                                      'mr_potato_delivery_receipts.qty',
                                      'mr_potato_delivery_receipts.prepared_by',
                                      'mr_potato_delivery_receipts.checked_by',
                                      'mr_potato_delivery_receipts.received_by',
                                      'mr_potato_delivery_receipts.created_by',
                                      'mr_potato_delivery_receipts.created_at',
                                      'mr_potato_delivery_receipts.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                      ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                      ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                      ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                      ->where('mr_potato_codes.module_name', $moduleNameDR)
                                      ->whereBetween('mr_potato_delivery_receipts.created_at', [$uri0, $uri1])
                                     ->sum('mr_potato_delivery_receipts.total_amount');

      $moduleNamePurchase = "Purchase Order";
      $purchaseOrders = DB::table(
                              'mr_potato_purchase_orders')
                              ->select(
                                  'mr_potato_purchase_orders.id',
                                  'mr_potato_purchase_orders.user_id',
                                  'mr_potato_purchase_orders.po_id',
                                  'mr_potato_purchase_orders.paid_to',
                                  'mr_potato_purchase_orders.branch_location',
                                  'mr_potato_purchase_orders.address',
                                  'mr_potato_purchase_orders.date',
                                  'mr_potato_purchase_orders.quantity',
                                  'mr_potato_purchase_orders.description',
                                  'mr_potato_purchase_orders.unit_price',
                                  'mr_potato_purchase_orders.amount',
                                  'mr_potato_purchase_orders.total_price',
                                  'mr_potato_purchase_orders.requested_by',
                                  'mr_potato_purchase_orders.prepared_by',
                                  'mr_potato_purchase_orders.checked_by',
                                  'mr_potato_purchase_orders.created_by',
                                  'mr_potato_purchase_orders.created_at',
                                  'mr_potato_purchase_orders.requesting_branch',
                                  'mr_potato_purchase_orders.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_purchase_orders.po_id', NULL)
                                  ->where('mr_potato_purchase_orders.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePurchase)   
                                  ->whereBetween('mr_potato_purchase_orders.created_at', [$uri0, $uri1])
                                  ->orderBy('mr_potato_purchase_orders.id', 'desc')
                                  ->get()->toArray();


        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.created_at',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.pv_id', NULL)
                            ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                            ->where('mr_potato_codes.module_name', $moduleNamePV)
                            ->whereBetween('mr_potato_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                            ->get()->toArray();

    $status = "FULLY PAID AND RELEASED";
    $totalAmountCash = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereBetween('mr_potato_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                                ->sum('mr_potato_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.created_at',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.cheque_total_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.pv_id', NULL)
                            ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                            ->where('mr_potato_codes.module_name', $moduleNamePV)
                            ->whereBetween('mr_potato_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                            ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                            ->get()->toArray();
                
    $totalAmountCheck = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereBetween('mr_potato_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                ->where('mr_potato_payment_vouchers.status', '!=', $status)
                                ->sum('mr_potato_payment_vouchers.amount_due');

        $totalPaidAmountCheck = DB::table(
                                    'mr_potato_payment_vouchers')
                                    ->select( 
                                    'mr_potato_payment_vouchers.id',
                                    'mr_potato_payment_vouchers.user_id',
                                    'mr_potato_payment_vouchers.pv_id',
                                    'mr_potato_payment_vouchers.date',
                                    'mr_potato_payment_vouchers.paid_to',
                                    'mr_potato_payment_vouchers.account_no',
                                    'mr_potato_payment_vouchers.account_name',
                                    'mr_potato_payment_vouchers.particulars',
                                    'mr_potato_payment_vouchers.amount',
                                    'mr_potato_payment_vouchers.method_of_payment',
                                    'mr_potato_payment_vouchers.prepared_by',
                                    'mr_potato_payment_vouchers.approved_by',
                                    'mr_potato_payment_vouchers.date_apprroved',
                                    'mr_potato_payment_vouchers.received_by_date',
                                    'mr_potato_payment_vouchers.created_by',
                                    'mr_potato_payment_vouchers.created_at',
                                    'mr_potato_payment_vouchers.invoice_number',
                                    'mr_potato_payment_vouchers.voucher_ref_number',
                                    'mr_potato_payment_vouchers.issued_date',
                                    'mr_potato_payment_vouchers.category',
                                    'mr_potato_payment_vouchers.amount_due',
                                    'mr_potato_payment_vouchers.delivered_date',
                                    'mr_potato_payment_vouchers.status',
                                    'mr_potato_payment_vouchers.cheque_number',
                                    'mr_potato_payment_vouchers.cheque_amount',
                                    'mr_potato_payment_vouchers.cheque_total_amount',
                                    'mr_potato_payment_vouchers.sub_category',
                                    'mr_potato_payment_vouchers.sub_category_account_id',
                                    'mr_potato_payment_vouchers.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                    ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                    ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                    ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                    ->where('mr_potato_codes.module_name', $moduleNamePV)
                                    ->whereBetween('mr_potato_payment_vouchers.created_at', [$uri0, $uri1])
                                    ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                    ->where('mr_potato_payment_vouchers.status', $status)
                                    ->sum('mr_potato_payment_vouchers.cheque_total_amount');
                      
        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryMrPotato',  compact('date', 'uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 'totalPOrder', 'totalBStatement', 
        'totalAmountCash','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('mr-potato-summary-report.pdf');


    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));
        
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'mr_potato_sales_invoices')
                                ->select(
                                    'mr_potato_sales_invoices.id',
                                    'mr_potato_sales_invoices.user_id',
                                    'mr_potato_sales_invoices.si_id',
                                    'mr_potato_sales_invoices.invoice_number',
                                    'mr_potato_sales_invoices.date',
                                    'mr_potato_sales_invoices.ordered_by',
                                    'mr_potato_sales_invoices.address',
                                    'mr_potato_sales_invoices.qty',
                                    'mr_potato_sales_invoices.total_kls',
                                    'mr_potato_sales_invoices.item_description',
                                    'mr_potato_sales_invoices.unit_price',
                                    'mr_potato_sales_invoices.amount',
                                    'mr_potato_sales_invoices.total_amount',
                                    'mr_potato_sales_invoices.created_by',
                                    'mr_potato_sales_invoices.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_sales_invoices.si_id', NULL)
                                ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->whereBetween('mr_potato_sales_invoices.created_at', [$startDate, $endDate]) 
                                ->orderBy('mr_potato_sales_invoices.id', 'desc')
                                ->get()->toArray();
      
          $totalSalesInvoice = DB::table(
                                  'mr_potato_sales_invoices')
                                  ->select(
                                      'mr_potato_sales_invoices.id',
                                      'mr_potato_sales_invoices.user_id',
                                      'mr_potato_sales_invoices.si_id',
                                      'mr_potato_sales_invoices.invoice_number',
                                      'mr_potato_sales_invoices.date',
                                      'mr_potato_sales_invoices.ordered_by',
                                      'mr_potato_sales_invoices.address',
                                      'mr_potato_sales_invoices.qty',
                                      'mr_potato_sales_invoices.total_kls',
                                      'mr_potato_sales_invoices.item_description',
                                      'mr_potato_sales_invoices.unit_price',
                                      'mr_potato_sales_invoices.amount',
                                      'mr_potato_sales_invoices.total_amount',
                                      'mr_potato_sales_invoices.created_by',
                                      'mr_potato_sales_invoices.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_sales_invoices.si_id', NULL)
                                  ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleName)
                                  ->whereBetween('mr_potato_sales_invoices.created_at', [$startDate, $endDate]) 
                                  ->sum('mr_potato_sales_invoices.total_amount');
      
          $moduleNameDR = "Delivery Receipt";
          $getAllDeliveryReceipts = DB::table(
                                  'mr_potato_delivery_receipts')
                                  ->select( 
                                  'mr_potato_delivery_receipts.id',
                                  'mr_potato_delivery_receipts.user_id',
                                  'mr_potato_delivery_receipts.dr_id',
                                  'mr_potato_delivery_receipts.delivered_to',
                                  'mr_potato_delivery_receipts.date',
                                  'mr_potato_delivery_receipts.address',
                                  'mr_potato_delivery_receipts.product_id',
                                  'mr_potato_delivery_receipts.unit',
                                  'mr_potato_delivery_receipts.item_description',
                                  'mr_potato_delivery_receipts.unit_price',
                                  'mr_potato_delivery_receipts.amount',
                                  'mr_potato_delivery_receipts.total_amount',
                                  'mr_potato_delivery_receipts.qty',
                                  'mr_potato_delivery_receipts.prepared_by',
                                  'mr_potato_delivery_receipts.checked_by',
                                  'mr_potato_delivery_receipts.received_by',
                                  'mr_potato_delivery_receipts.created_by',
                                  'mr_potato_delivery_receipts.created_at',
                                  'mr_potato_delivery_receipts.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                  ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNameDR)
                                  ->whereBetween('mr_potato_delivery_receipts.created_at', [$startDate, $endDate]) 
                                  ->orderBy('mr_potato_delivery_receipts.id', 'desc')
                                  ->get()->toArray();
                                
          $totalDeliveryReceipt = DB::table(
                                      'mr_potato_delivery_receipts')
                                      ->select( 
                                      'mr_potato_delivery_receipts.id',
                                      'mr_potato_delivery_receipts.user_id',
                                      'mr_potato_delivery_receipts.dr_id',
                                      'mr_potato_delivery_receipts.delivered_to',
                                      'mr_potato_delivery_receipts.date',
                                      'mr_potato_delivery_receipts.address',
                                      'mr_potato_delivery_receipts.product_id',
                                      'mr_potato_delivery_receipts.unit',
                                      'mr_potato_delivery_receipts.item_description',
                                      'mr_potato_delivery_receipts.unit_price',
                                      'mr_potato_delivery_receipts.amount',
                                      'mr_potato_delivery_receipts.total_amount',
                                      'mr_potato_delivery_receipts.qty',
                                      'mr_potato_delivery_receipts.prepared_by',
                                      'mr_potato_delivery_receipts.checked_by',
                                      'mr_potato_delivery_receipts.received_by',
                                      'mr_potato_delivery_receipts.created_by',
                                      'mr_potato_delivery_receipts.created_at',
                                      'mr_potato_delivery_receipts.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                      ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                      ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                      ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                      ->where('mr_potato_codes.module_name', $moduleNameDR)
                                      ->whereBetween('mr_potato_delivery_receipts.created_at', [$startDate, $endDate]) 
                                     ->sum('mr_potato_delivery_receipts.total_amount');

      $moduleNamePurchase = "Purchase Order";
      $purchaseOrders = DB::table(
                              'mr_potato_purchase_orders')
                              ->select(
                                  'mr_potato_purchase_orders.id',
                                  'mr_potato_purchase_orders.user_id',
                                  'mr_potato_purchase_orders.po_id',
                                  'mr_potato_purchase_orders.paid_to',
                                  'mr_potato_purchase_orders.branch_location',
                                  'mr_potato_purchase_orders.address',
                                  'mr_potato_purchase_orders.date',
                                  'mr_potato_purchase_orders.quantity',
                                  'mr_potato_purchase_orders.description',
                                  'mr_potato_purchase_orders.unit_price',
                                  'mr_potato_purchase_orders.amount',
                                  'mr_potato_purchase_orders.total_price',
                                  'mr_potato_purchase_orders.requested_by',
                                  'mr_potato_purchase_orders.prepared_by',
                                  'mr_potato_purchase_orders.checked_by',
                                  'mr_potato_purchase_orders.created_by',
                                  'mr_potato_purchase_orders.created_at',
                                  'mr_potato_purchase_orders.requesting_branch',
                                  'mr_potato_purchase_orders.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_purchase_orders.po_id', NULL)
                                  ->where('mr_potato_purchase_orders.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePurchase)   
                                  ->whereBetween('mr_potato_purchase_orders.created_at', [$startDate, $endDate])
                                  ->orderBy('mr_potato_purchase_orders.id', 'desc')
                                  ->get()->toArray();

          $moduleNamePC = "Petty Cash";
          $pettyCashLists = DB::table(
                                  'mr_potato_petty_cashes')
                                  ->select( 
                                  'mr_potato_petty_cashes.id',
                                  'mr_potato_petty_cashes.user_id',
                                  'mr_potato_petty_cashes.pc_id',
                                  'mr_potato_petty_cashes.date',
                                  'mr_potato_petty_cashes.petty_cash_name',
                                  'mr_potato_petty_cashes.petty_cash_summary',
                                  'mr_potato_petty_cashes.amount',
                                  'mr_potato_petty_cashes.created_by',
                                  'mr_potato_petty_cashes.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_petty_cashes.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_petty_cashes.pc_id', NULL)
                                  ->where('mr_potato_petty_cashes.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePC)
                                  ->whereBetween('mr_potato_petty_cashes.created_at', [$startDate, $endDate])
                                  ->orderBy('mr_potato_petty_cashes.id', 'desc')
                                  ->get()->toArray();
  
          $moduleNamePV = "Payment Voucher";
          $getTransactionLists = DB::table(
                              'mr_potato_payment_vouchers')
                              ->select( 
                              'mr_potato_payment_vouchers.id',
                              'mr_potato_payment_vouchers.user_id',
                              'mr_potato_payment_vouchers.pv_id',
                              'mr_potato_payment_vouchers.date',
                              'mr_potato_payment_vouchers.paid_to',
                              'mr_potato_payment_vouchers.account_no',
                              'mr_potato_payment_vouchers.account_name',
                              'mr_potato_payment_vouchers.particulars',
                              'mr_potato_payment_vouchers.amount',
                              'mr_potato_payment_vouchers.method_of_payment',
                              'mr_potato_payment_vouchers.prepared_by',
                              'mr_potato_payment_vouchers.approved_by',
                              'mr_potato_payment_vouchers.date_apprroved',
                              'mr_potato_payment_vouchers.received_by_date',
                              'mr_potato_payment_vouchers.created_by',
                              'mr_potato_payment_vouchers.created_at',
                              'mr_potato_payment_vouchers.invoice_number',
                              'mr_potato_payment_vouchers.voucher_ref_number',
                              'mr_potato_payment_vouchers.issued_date',
                              'mr_potato_payment_vouchers.category',
                              'mr_potato_payment_vouchers.amount_due',
                              'mr_potato_payment_vouchers.delivered_date',
                              'mr_potato_payment_vouchers.status',
                              'mr_potato_payment_vouchers.cheque_number',
                              'mr_potato_payment_vouchers.cheque_amount',
                              'mr_potato_payment_vouchers.cheque_total_amount',
                              'mr_potato_payment_vouchers.sub_category',
                              'mr_potato_payment_vouchers.sub_category_account_id',
                              'mr_potato_payment_vouchers.deleted_at',
                              'mr_potato_codes.mr_potato_code',
                              'mr_potato_codes.module_id',
                              'mr_potato_codes.module_code',
                              'mr_potato_codes.module_name')
                              ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                              ->where('mr_potato_payment_vouchers.pv_id', NULL)
                              ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                              ->where('mr_potato_codes.module_name', $moduleNamePV)
                              ->whereBetween('mr_potato_payment_vouchers.created_at', [$startDate, $endDate])    
                              ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                              ->get()->toArray();
                  
          $cash = "CASH";
          $getTransactionListCashes = DB::table(
                              'mr_potato_payment_vouchers')
                              ->select( 
                              'mr_potato_payment_vouchers.id',
                              'mr_potato_payment_vouchers.user_id',
                              'mr_potato_payment_vouchers.pv_id',
                              'mr_potato_payment_vouchers.date',
                              'mr_potato_payment_vouchers.paid_to',
                              'mr_potato_payment_vouchers.account_no',
                              'mr_potato_payment_vouchers.account_name',
                              'mr_potato_payment_vouchers.particulars',
                              'mr_potato_payment_vouchers.amount',
                              'mr_potato_payment_vouchers.method_of_payment',
                              'mr_potato_payment_vouchers.prepared_by',
                              'mr_potato_payment_vouchers.approved_by',
                              'mr_potato_payment_vouchers.date_apprroved',
                              'mr_potato_payment_vouchers.received_by_date',
                              'mr_potato_payment_vouchers.created_by',
                              'mr_potato_payment_vouchers.created_at',
                              'mr_potato_payment_vouchers.invoice_number',
                              'mr_potato_payment_vouchers.voucher_ref_number',
                              'mr_potato_payment_vouchers.issued_date',
                              'mr_potato_payment_vouchers.category',
                              'mr_potato_payment_vouchers.amount_due',
                              'mr_potato_payment_vouchers.delivered_date',
                              'mr_potato_payment_vouchers.status',
                              'mr_potato_payment_vouchers.cheque_number',
                              'mr_potato_payment_vouchers.cheque_amount',
                              'mr_potato_payment_vouchers.sub_category',
                              'mr_potato_payment_vouchers.sub_category_account_id',
                              'mr_potato_payment_vouchers.deleted_at',
                              'mr_potato_codes.mr_potato_code',
                              'mr_potato_codes.module_id',
                              'mr_potato_codes.module_code',
                              'mr_potato_codes.module_name')
                              ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                              ->where('mr_potato_payment_vouchers.pv_id', NULL)
                              ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                              ->where('mr_potato_codes.module_name', $moduleNamePV)
                              ->whereBetween('mr_potato_payment_vouchers.created_at', [$startDate, $endDate])
                              ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                              ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                              ->get()->toArray();

      $status = "FULLY PAID AND RELEASED";
      $totalAmountCashes = DB::table(
                                  'mr_potato_payment_vouchers')
                                  ->select( 
                                  'mr_potato_payment_vouchers.id',
                                  'mr_potato_payment_vouchers.user_id',
                                  'mr_potato_payment_vouchers.pv_id',
                                  'mr_potato_payment_vouchers.date',
                                  'mr_potato_payment_vouchers.paid_to',
                                  'mr_potato_payment_vouchers.account_no',
                                  'mr_potato_payment_vouchers.account_name',
                                  'mr_potato_payment_vouchers.particulars',
                                  'mr_potato_payment_vouchers.amount',
                                  'mr_potato_payment_vouchers.method_of_payment',
                                  'mr_potato_payment_vouchers.prepared_by',
                                  'mr_potato_payment_vouchers.approved_by',
                                  'mr_potato_payment_vouchers.date_apprroved',
                                  'mr_potato_payment_vouchers.received_by_date',
                                  'mr_potato_payment_vouchers.created_by',
                                  'mr_potato_payment_vouchers.created_at',
                                  'mr_potato_payment_vouchers.invoice_number',
                                  'mr_potato_payment_vouchers.voucher_ref_number',
                                  'mr_potato_payment_vouchers.issued_date',
                                  'mr_potato_payment_vouchers.category',
                                  'mr_potato_payment_vouchers.amount_due',
                                  'mr_potato_payment_vouchers.delivered_date',
                                  'mr_potato_payment_vouchers.status',
                                  'mr_potato_payment_vouchers.cheque_number',
                                  'mr_potato_payment_vouchers.cheque_amount',
                                  'mr_potato_payment_vouchers.sub_category',
                                  'mr_potato_payment_vouchers.sub_category_account_id',
                                  'mr_potato_payment_vouchers.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                  ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePV)
                                  ->whereBetween('mr_potato_payment_vouchers.created_at', [$startDate, $endDate])
                                  ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                                  ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                                 ->sum('mr_potato_payment_vouchers.amount_due');

          $check = "CHECK";
          $getTransactionListChecks = DB::table(
                              'mr_potato_payment_vouchers')
                              ->select( 
                              'mr_potato_payment_vouchers.id',
                              'mr_potato_payment_vouchers.user_id',
                              'mr_potato_payment_vouchers.pv_id',
                              'mr_potato_payment_vouchers.date',
                              'mr_potato_payment_vouchers.paid_to',
                              'mr_potato_payment_vouchers.account_no',
                              'mr_potato_payment_vouchers.account_name',
                              'mr_potato_payment_vouchers.particulars',
                              'mr_potato_payment_vouchers.amount',
                              'mr_potato_payment_vouchers.method_of_payment',
                              'mr_potato_payment_vouchers.prepared_by',
                              'mr_potato_payment_vouchers.approved_by',
                              'mr_potato_payment_vouchers.date_apprroved',
                              'mr_potato_payment_vouchers.received_by_date',
                              'mr_potato_payment_vouchers.created_by',
                              'mr_potato_payment_vouchers.created_at',
                              'mr_potato_payment_vouchers.invoice_number',
                              'mr_potato_payment_vouchers.voucher_ref_number',
                              'mr_potato_payment_vouchers.issued_date',
                              'mr_potato_payment_vouchers.category',
                              'mr_potato_payment_vouchers.amount_due',
                              'mr_potato_payment_vouchers.delivered_date',
                              'mr_potato_payment_vouchers.status',
                              'mr_potato_payment_vouchers.cheque_number',
                              'mr_potato_payment_vouchers.cheque_amount',
                              'mr_potato_payment_vouchers.cheque_total_amount',
                              'mr_potato_payment_vouchers.sub_category',
                              'mr_potato_payment_vouchers.sub_category_account_id',
                              'mr_potato_payment_vouchers.deleted_at',
                              'mr_potato_codes.mr_potato_code',
                              'mr_potato_codes.module_id',
                              'mr_potato_codes.module_code',
                              'mr_potato_codes.module_name')
                              ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                              ->where('mr_potato_payment_vouchers.pv_id', NULL)
                              ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                              ->where('mr_potato_codes.module_name', $moduleNamePV)
                              ->whereBetween('mr_potato_payment_vouchers.created_at', [$startDate, $endDate])
                              ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                              ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                              ->get()->toArray();
                  
      $totalAmountCheck = DB::table(
                                  'mr_potato_payment_vouchers')
                                  ->select( 
                                  'mr_potato_payment_vouchers.id',
                                  'mr_potato_payment_vouchers.user_id',
                                  'mr_potato_payment_vouchers.pv_id',
                                  'mr_potato_payment_vouchers.date',
                                  'mr_potato_payment_vouchers.paid_to',
                                  'mr_potato_payment_vouchers.account_no',
                                  'mr_potato_payment_vouchers.account_name',
                                  'mr_potato_payment_vouchers.particulars',
                                  'mr_potato_payment_vouchers.amount',
                                  'mr_potato_payment_vouchers.method_of_payment',
                                  'mr_potato_payment_vouchers.prepared_by',
                                  'mr_potato_payment_vouchers.approved_by',
                                  'mr_potato_payment_vouchers.date_apprroved',
                                  'mr_potato_payment_vouchers.received_by_date',
                                  'mr_potato_payment_vouchers.created_by',
                                  'mr_potato_payment_vouchers.created_at',
                                  'mr_potato_payment_vouchers.invoice_number',
                                  'mr_potato_payment_vouchers.voucher_ref_number',
                                  'mr_potato_payment_vouchers.issued_date',
                                  'mr_potato_payment_vouchers.category',
                                  'mr_potato_payment_vouchers.amount_due',
                                  'mr_potato_payment_vouchers.delivered_date',
                                  'mr_potato_payment_vouchers.status',
                                  'mr_potato_payment_vouchers.cheque_number',
                                  'mr_potato_payment_vouchers.cheque_amount',
                                  'mr_potato_payment_vouchers.sub_category',
                                  'mr_potato_payment_vouchers.sub_category_account_id',
                                  'mr_potato_payment_vouchers.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                  ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePV)
                                  ->whereBetween('mr_potato_payment_vouchers.created_at', [$startDate, $endDate])
                                  ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                  ->where('mr_potato_payment_vouchers.status', '!=', $status)
                                  ->sum('mr_potato_payment_vouchers.amount_due');

        return view('mr-potato-multiple-summary-report', compact('getAllSalesInvoices', 'startDate', 'endDate',
        'totalSalesInvoice', 'getAllDeliveryReceipts', 'totalDeliveryReceipt','purchaseOrders', 'pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
                            

    }

    public function search(Request $request){   
        $getSearchResults =MrPotatoCode::where('mr_potato_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Sales Invoice"){
            $getSearchSalesInvoices = DB::table(
                            'mr_potato_sales_invoices')
                            ->select(
                                'mr_potato_sales_invoices.id',
                                'mr_potato_sales_invoices.user_id',
                                'mr_potato_sales_invoices.si_id',
                                'mr_potato_sales_invoices.invoice_number',
                                'mr_potato_sales_invoices.date',
                                'mr_potato_sales_invoices.ordered_by',
                                'mr_potato_sales_invoices.address',
                                'mr_potato_sales_invoices.qty',
                                'mr_potato_sales_invoices.total_kls',
                                'mr_potato_sales_invoices.item_description',
                                'mr_potato_sales_invoices.unit_price',
                                'mr_potato_sales_invoices.amount',
                                'mr_potato_sales_invoices.total_amount',
                                'mr_potato_sales_invoices.created_by',
                                'mr_potato_sales_invoices.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                            ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_sales_invoices.id', $getSearchResults[0]->module_id)
                            ->where('mr_potato_codes.module_name', $getSearchResults[0]->module_name)
                            ->get()->toArray();

            $getAllCodes = MrPotatoCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('mr-potato-search-results',  compact('module', 'getAllCodes', 'getSearchSalesInvoices'));
        

        }else if($getSearchResults[0]->module_name === "Delivery Receipt"){
            $getSearchDeliveryReceipts = DB::table(
                            'mr_potato_delivery_receipts')
                            ->select( 
                            'mr_potato_delivery_receipts.id',
                            'mr_potato_delivery_receipts.user_id',
                            'mr_potato_delivery_receipts.dr_id',
                            'mr_potato_delivery_receipts.delivered_to',
                            'mr_potato_delivery_receipts.date',
                            'mr_potato_delivery_receipts.address',
                            'mr_potato_delivery_receipts.product_id',
                            'mr_potato_delivery_receipts.unit',
                            'mr_potato_delivery_receipts.item_description',
                            'mr_potato_delivery_receipts.unit_price',
                            'mr_potato_delivery_receipts.amount',
                            'mr_potato_delivery_receipts.total_amount',
                            'mr_potato_delivery_receipts.qty',
                            'mr_potato_delivery_receipts.prepared_by',
                            'mr_potato_delivery_receipts.checked_by',
                            'mr_potato_delivery_receipts.received_by',
                            'mr_potato_delivery_receipts.created_by',
                            'mr_potato_delivery_receipts.created_at',
                            'mr_potato_delivery_receipts.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_delivery_receipts.id',$getSearchResults[0]->module_id)
                            ->where('mr_potato_codes.module_name', $getSearchResults[0]->module_name)
                            ->get()->toArray();

            $getAllCodes = MrPotatoCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('mr-potato-search-results',  compact('module', 'getAllCodes', 'getSearchDeliveryReceipts'));
                        
        }else if($getSearchResults[0]->module_name === "Purchase Order"){
            $getSearchPurchaseOrders = DB::table(
                    'mr_potato_purchase_orders')
                    ->select(
                        'mr_potato_purchase_orders.id',
                        'mr_potato_purchase_orders.user_id',
                        'mr_potato_purchase_orders.po_id',
                        'mr_potato_purchase_orders.paid_to',
                        'mr_potato_purchase_orders.branch_location',
                        'mr_potato_purchase_orders.address',
                        'mr_potato_purchase_orders.date',
                        'mr_potato_purchase_orders.quantity',
                        'mr_potato_purchase_orders.description',
                        'mr_potato_purchase_orders.unit_price',
                        'mr_potato_purchase_orders.amount',
                        'mr_potato_purchase_orders.total_price',
                        'mr_potato_purchase_orders.requested_by',
                        'mr_potato_purchase_orders.prepared_by',
                        'mr_potato_purchase_orders.checked_by',
                        'mr_potato_purchase_orders.created_by',
                        'mr_potato_purchase_orders.created_at',
                        'mr_potato_purchase_orders.deleted_at',
                        'mr_potato_purchase_orders.requesting_branch',
                        'mr_potato_codes.mr_potato_code',
                        'mr_potato_codes.module_id',
                        'mr_potato_codes.module_code',
                        'mr_potato_codes.module_name')
                        ->leftJoin('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                        ->where('mr_potato_purchase_orders.id', $getSearchResults[0]->module_id)
                        ->where('mr_potato_codes.module_name', $getSearchResults[0]->module_name)   
                        ->get()->toArray();

            $getAllCodes = MrPotatoCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('mr-potato-search-results',  compact('module', 'getAllCodes', 'getSearchPurchaseOrders'));
                 
        }else if($getSearchResults[0]->module_name === "Petty Cash"){
            $getSearchPettyCashes = DB::table(
                        'mr_potato_petty_cashes')
                        ->select( 
                        'mr_potato_petty_cashes.id',
                        'mr_potato_petty_cashes.user_id',
                        'mr_potato_petty_cashes.pc_id',
                        'mr_potato_petty_cashes.date',
                        'mr_potato_petty_cashes.petty_cash_name',
                        'mr_potato_petty_cashes.petty_cash_summary',
                        'mr_potato_petty_cashes.amount',
                        'mr_potato_petty_cashes.created_by',
                        'mr_potato_petty_cashes.created_at',
                        'mr_potato_petty_cashes.deleted_at',
                        'mr_potato_codes.mr_potato_code',
                        'mr_potato_codes.module_id',
                        'mr_potato_codes.module_code',
                        'mr_potato_codes.module_name')
                        ->join('mr_potato_codes', 'mr_potato_petty_cashes.id', '=', 'mr_potato_codes.module_id')
                        ->where('mr_potato_petty_cashes.id', $getSearchResults[0]->module_id)
                        ->where('mr_potato_codes.module_name', $getSearchResults[0]->module_name)
                        ->get()->toArray();
            
            $getAllCodes = MrPotatoCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('mr-potato-search-results',  compact('module', 'getAllCodes', 'getSearchPettyCashes'));
                    
        }else if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.created_at',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->join('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.id', $getSearchResults[0]->module_id)
                            ->where('mr_potato_codes.module_name', $getSearchResults[0]->module_name)
                            ->get()->toArray();

            $getAllCodes = MrPotatoCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('mr-potato-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
                   
        }
       
    }

    public function searchNumberCode(){
        $getAllCodes = MrPotatoCode::get()->toArray();
        return view('mr-potato-search-number-code', compact('getAllCodes'));
    }

    public function printGetSummary($date){
        
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'mr_potato_sales_invoices')
                                ->select(
                                    'mr_potato_sales_invoices.id',
                                    'mr_potato_sales_invoices.user_id',
                                    'mr_potato_sales_invoices.si_id',
                                    'mr_potato_sales_invoices.invoice_number',
                                    'mr_potato_sales_invoices.date',
                                    'mr_potato_sales_invoices.ordered_by',
                                    'mr_potato_sales_invoices.address',
                                    'mr_potato_sales_invoices.qty',
                                    'mr_potato_sales_invoices.total_kls',
                                    'mr_potato_sales_invoices.item_description',
                                    'mr_potato_sales_invoices.unit_price',
                                    'mr_potato_sales_invoices.amount',
                                    'mr_potato_sales_invoices.total_amount',
                                    'mr_potato_sales_invoices.created_by',
                                    'mr_potato_sales_invoices.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_sales_invoices.si_id', NULL)
                                ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->whereDate('mr_potato_sales_invoices.created_at', '=', date($date))
                                ->orderBy('mr_potato_sales_invoices.id', 'desc')
                                ->get()->toArray();
      
          $totalSalesInvoice = DB::table(
                                  'mr_potato_sales_invoices')
                                  ->select(
                                      'mr_potato_sales_invoices.id',
                                      'mr_potato_sales_invoices.user_id',
                                      'mr_potato_sales_invoices.si_id',
                                      'mr_potato_sales_invoices.invoice_number',
                                      'mr_potato_sales_invoices.date',
                                      'mr_potato_sales_invoices.ordered_by',
                                      'mr_potato_sales_invoices.address',
                                      'mr_potato_sales_invoices.qty',
                                      'mr_potato_sales_invoices.total_kls',
                                      'mr_potato_sales_invoices.item_description',
                                      'mr_potato_sales_invoices.unit_price',
                                      'mr_potato_sales_invoices.amount',
                                      'mr_potato_sales_invoices.total_amount',
                                      'mr_potato_sales_invoices.created_by',
                                      'mr_potato_sales_invoices.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_sales_invoices.si_id', NULL)
                                  ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleName)
                                  ->whereDate('mr_potato_sales_invoices.created_at', '=', date($date))
                                  ->sum('mr_potato_sales_invoices.total_amount');
      
          $moduleNameDR = "Delivery Receipt";
          $getAllDeliveryReceipts = DB::table(
                                  'mr_potato_delivery_receipts')
                                  ->select( 
                                  'mr_potato_delivery_receipts.id',
                                  'mr_potato_delivery_receipts.user_id',
                                  'mr_potato_delivery_receipts.dr_id',
                                  'mr_potato_delivery_receipts.delivered_to',
                                  'mr_potato_delivery_receipts.date',
                                  'mr_potato_delivery_receipts.address',
                                  'mr_potato_delivery_receipts.product_id',
                                  'mr_potato_delivery_receipts.unit',
                                  'mr_potato_delivery_receipts.item_description',
                                  'mr_potato_delivery_receipts.unit_price',
                                  'mr_potato_delivery_receipts.amount',
                                  'mr_potato_delivery_receipts.total_amount',
                                  'mr_potato_delivery_receipts.qty',
                                  'mr_potato_delivery_receipts.prepared_by',
                                  'mr_potato_delivery_receipts.checked_by',
                                  'mr_potato_delivery_receipts.received_by',
                                  'mr_potato_delivery_receipts.created_by',
                                  'mr_potato_delivery_receipts.created_at',
                                  'mr_potato_delivery_receipts.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                  ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNameDR)
                                  ->whereDate('mr_potato_delivery_receipts.created_at', '=', date($date))
                                  ->orderBy('mr_potato_delivery_receipts.id', 'desc')
                                  ->get()->toArray();
                                
          $totalDeliveryReceipt = DB::table(
                                      'mr_potato_delivery_receipts')
                                      ->select( 
                                      'mr_potato_delivery_receipts.id',
                                      'mr_potato_delivery_receipts.user_id',
                                      'mr_potato_delivery_receipts.dr_id',
                                      'mr_potato_delivery_receipts.delivered_to',
                                      'mr_potato_delivery_receipts.date',
                                      'mr_potato_delivery_receipts.address',
                                      'mr_potato_delivery_receipts.product_id',
                                      'mr_potato_delivery_receipts.unit',
                                      'mr_potato_delivery_receipts.item_description',
                                      'mr_potato_delivery_receipts.unit_price',
                                      'mr_potato_delivery_receipts.amount',
                                      'mr_potato_delivery_receipts.total_amount',
                                      'mr_potato_delivery_receipts.qty',
                                      'mr_potato_delivery_receipts.prepared_by',
                                      'mr_potato_delivery_receipts.checked_by',
                                      'mr_potato_delivery_receipts.received_by',
                                      'mr_potato_delivery_receipts.created_by',
                                      'mr_potato_delivery_receipts.created_at',
                                      'mr_potato_delivery_receipts.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                      ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                      ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                      ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                      ->where('mr_potato_codes.module_name', $moduleNameDR)
                                      ->whereDate('mr_potato_delivery_receipts.created_at', '=', date($date))
                                     ->sum('mr_potato_delivery_receipts.total_amount');

      $moduleNamePurchase = "Purchase Order";
      $purchaseOrders = DB::table(
                              'mr_potato_purchase_orders')
                              ->select(
                                  'mr_potato_purchase_orders.id',
                                  'mr_potato_purchase_orders.user_id',
                                  'mr_potato_purchase_orders.po_id',
                                  'mr_potato_purchase_orders.paid_to',
                                  'mr_potato_purchase_orders.branch_location',
                                  'mr_potato_purchase_orders.address',
                                  'mr_potato_purchase_orders.date',
                                  'mr_potato_purchase_orders.quantity',
                                  'mr_potato_purchase_orders.description',
                                  'mr_potato_purchase_orders.unit_price',
                                  'mr_potato_purchase_orders.amount',
                                  'mr_potato_purchase_orders.total_price',
                                  'mr_potato_purchase_orders.requested_by',
                                  'mr_potato_purchase_orders.prepared_by',
                                  'mr_potato_purchase_orders.checked_by',
                                  'mr_potato_purchase_orders.created_by',
                                  'mr_potato_purchase_orders.created_at',
                                  'mr_potato_purchase_orders.requesting_branch',
                                  'mr_potato_purchase_orders.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_purchase_orders.po_id', NULL)
                                  ->where('mr_potato_purchase_orders.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePurchase)   
                                  ->whereDate('mr_potato_purchase_orders.created_at', '=', date($date))
                                                                     
                                  ->orderBy('mr_potato_purchase_orders.id', 'desc')
                                  ->get()->toArray();


        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.created_at',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.pv_id', NULL)
                            ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                            ->where('mr_potato_codes.module_name', $moduleNamePV)
                            ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($date))
                            ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                            ->get()->toArray();

    $status = "FULLY PAID AND RELEASED";
    $totalAmountCash = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($date))
                                ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                                ->sum('mr_potato_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.created_at',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.cheque_total_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.pv_id', NULL)
                            ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                            ->where('mr_potato_codes.module_name', $moduleNamePV)
                            ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($date))
                            ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                            ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                            ->get()->toArray();
                
    $totalAmountCheck = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($date))
                                ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                ->where('mr_potato_payment_vouchers.status', '!=', $status)
                                ->sum('mr_potato_payment_vouchers.amount_due');
        
    $totalPaidAmountCheck  = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.cheque_total_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($date))
                                ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                ->where('mr_potato_payment_vouchers.status', $status)
                                ->sum('mr_potato_payment_vouchers.cheque_total_amount');
        $getDateToday = "";
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryMrPotato',  compact('date', 'uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 'totalPOrder', 'totalBStatement', 
        'totalAmountCash','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('mr-potato-summary-report.pdf');
                      
        
    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'mr_potato_sales_invoices')
                                ->select(
                                    'mr_potato_sales_invoices.id',
                                    'mr_potato_sales_invoices.user_id',
                                    'mr_potato_sales_invoices.si_id',
                                    'mr_potato_sales_invoices.invoice_number',
                                    'mr_potato_sales_invoices.date',
                                    'mr_potato_sales_invoices.ordered_by',
                                    'mr_potato_sales_invoices.address',
                                    'mr_potato_sales_invoices.qty',
                                    'mr_potato_sales_invoices.total_kls',
                                    'mr_potato_sales_invoices.item_description',
                                    'mr_potato_sales_invoices.unit_price',
                                    'mr_potato_sales_invoices.amount',
                                    'mr_potato_sales_invoices.total_amount',
                                    'mr_potato_sales_invoices.created_by',
                                    'mr_potato_sales_invoices.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_sales_invoices.si_id', NULL)
                                ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->whereDate('mr_potato_sales_invoices.created_at', '=', date($getDate))
                                ->orderBy('mr_potato_sales_invoices.id', 'desc')
                                ->get()->toArray();
      
          $totalSalesInvoice = DB::table(
                                  'mr_potato_sales_invoices')
                                  ->select(
                                      'mr_potato_sales_invoices.id',
                                      'mr_potato_sales_invoices.user_id',
                                      'mr_potato_sales_invoices.si_id',
                                      'mr_potato_sales_invoices.invoice_number',
                                      'mr_potato_sales_invoices.date',
                                      'mr_potato_sales_invoices.ordered_by',
                                      'mr_potato_sales_invoices.address',
                                      'mr_potato_sales_invoices.qty',
                                      'mr_potato_sales_invoices.total_kls',
                                      'mr_potato_sales_invoices.item_description',
                                      'mr_potato_sales_invoices.unit_price',
                                      'mr_potato_sales_invoices.amount',
                                      'mr_potato_sales_invoices.total_amount',
                                      'mr_potato_sales_invoices.created_by',
                                      'mr_potato_sales_invoices.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_sales_invoices.si_id', NULL)
                                  ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleName)
                                  ->whereDate('mr_potato_sales_invoices.created_at', '=', date($getDate))
                                  ->sum('mr_potato_sales_invoices.total_amount');
      
          $moduleNameDR = "Delivery Receipt";
          $getAllDeliveryReceipts = DB::table(
                                  'mr_potato_delivery_receipts')
                                  ->select( 
                                  'mr_potato_delivery_receipts.id',
                                  'mr_potato_delivery_receipts.user_id',
                                  'mr_potato_delivery_receipts.dr_id',
                                  'mr_potato_delivery_receipts.delivered_to',
                                  'mr_potato_delivery_receipts.date',
                                  'mr_potato_delivery_receipts.address',
                                  'mr_potato_delivery_receipts.product_id',
                                  'mr_potato_delivery_receipts.unit',
                                  'mr_potato_delivery_receipts.item_description',
                                  'mr_potato_delivery_receipts.unit_price',
                                  'mr_potato_delivery_receipts.amount',
                                  'mr_potato_delivery_receipts.total_amount',
                                  'mr_potato_delivery_receipts.qty',
                                  'mr_potato_delivery_receipts.prepared_by',
                                  'mr_potato_delivery_receipts.checked_by',
                                  'mr_potato_delivery_receipts.received_by',
                                  'mr_potato_delivery_receipts.created_by',
                                  'mr_potato_delivery_receipts.created_at',
                                  'mr_potato_delivery_receipts.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                  ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNameDR)
                                  ->whereDate('mr_potato_delivery_receipts.created_at', '=', date($getDate))
                                  ->orderBy('mr_potato_delivery_receipts.id', 'desc')
                                  ->get()->toArray();
                                
          $totalDeliveryReceipt = DB::table(
                                      'mr_potato_delivery_receipts')
                                      ->select( 
                                      'mr_potato_delivery_receipts.id',
                                      'mr_potato_delivery_receipts.user_id',
                                      'mr_potato_delivery_receipts.dr_id',
                                      'mr_potato_delivery_receipts.delivered_to',
                                      'mr_potato_delivery_receipts.date',
                                      'mr_potato_delivery_receipts.address',
                                      'mr_potato_delivery_receipts.product_id',
                                      'mr_potato_delivery_receipts.unit',
                                      'mr_potato_delivery_receipts.item_description',
                                      'mr_potato_delivery_receipts.unit_price',
                                      'mr_potato_delivery_receipts.amount',
                                      'mr_potato_delivery_receipts.total_amount',
                                      'mr_potato_delivery_receipts.qty',
                                      'mr_potato_delivery_receipts.prepared_by',
                                      'mr_potato_delivery_receipts.checked_by',
                                      'mr_potato_delivery_receipts.received_by',
                                      'mr_potato_delivery_receipts.created_by',
                                      'mr_potato_delivery_receipts.created_at',
                                      'mr_potato_delivery_receipts.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                      ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                      ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                      ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                      ->where('mr_potato_codes.module_name', $moduleNameDR)
                                      ->whereDate('mr_potato_delivery_receipts.created_at', '=', date($getDate))
                                     ->sum('mr_potato_delivery_receipts.total_amount');

      $moduleNamePurchase = "Purchase Order";
      $purchaseOrders = DB::table(
                              'mr_potato_purchase_orders')
                              ->select(
                                  'mr_potato_purchase_orders.id',
                                  'mr_potato_purchase_orders.user_id',
                                  'mr_potato_purchase_orders.po_id',
                                  'mr_potato_purchase_orders.paid_to',
                                  'mr_potato_purchase_orders.branch_location',
                                  'mr_potato_purchase_orders.address',
                                  'mr_potato_purchase_orders.date',
                                  'mr_potato_purchase_orders.quantity',
                                  'mr_potato_purchase_orders.description',
                                  'mr_potato_purchase_orders.unit_price',
                                  'mr_potato_purchase_orders.amount',
                                  'mr_potato_purchase_orders.total_price',
                                  'mr_potato_purchase_orders.requested_by',
                                  'mr_potato_purchase_orders.prepared_by',
                                  'mr_potato_purchase_orders.checked_by',
                                  'mr_potato_purchase_orders.created_by',
                                  'mr_potato_purchase_orders.created_at',
                                  'mr_potato_purchase_orders.requesting_branch',
                                  'mr_potato_purchase_orders.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_purchase_orders.po_id', NULL)
                                  ->where('mr_potato_purchase_orders.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePurchase)   
                                  ->whereDate('mr_potato_purchase_orders.created_at', '=', date($getDate))
                                                                     
                                  ->orderBy('mr_potato_purchase_orders.id', 'desc')
                                  ->get()->toArray();

          $moduleNamePC = "Petty Cash";
          $pettyCashLists = DB::table(
                                  'mr_potato_petty_cashes')
                                  ->select( 
                                  'mr_potato_petty_cashes.id',
                                  'mr_potato_petty_cashes.user_id',
                                  'mr_potato_petty_cashes.pc_id',
                                  'mr_potato_petty_cashes.date',
                                  'mr_potato_petty_cashes.petty_cash_name',
                                  'mr_potato_petty_cashes.petty_cash_summary',
                                  'mr_potato_petty_cashes.amount',
                                  'mr_potato_petty_cashes.created_by',
                                  'mr_potato_petty_cashes.created_at',
                                  'mr_potato_petty_cashes.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_petty_cashes.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_petty_cashes.pc_id', NULL)
                                  ->where('mr_potato_petty_cashes.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePC)
                                  ->whereDate('mr_potato_petty_cashes.created_at', '=', date($getDate))
                                
                                  ->orderBy('mr_potato_petty_cashes.id', 'desc')
                                  ->get()->toArray();
  
          $moduleNamePV = "Payment Voucher";
          $getTransactionLists = DB::table(
                              'mr_potato_payment_vouchers')
                              ->select( 
                              'mr_potato_payment_vouchers.id',
                              'mr_potato_payment_vouchers.user_id',
                              'mr_potato_payment_vouchers.pv_id',
                              'mr_potato_payment_vouchers.date',
                              'mr_potato_payment_vouchers.paid_to',
                              'mr_potato_payment_vouchers.account_no',
                              'mr_potato_payment_vouchers.account_name',
                              'mr_potato_payment_vouchers.particulars',
                              'mr_potato_payment_vouchers.amount',
                              'mr_potato_payment_vouchers.method_of_payment',
                              'mr_potato_payment_vouchers.prepared_by',
                              'mr_potato_payment_vouchers.approved_by',
                              'mr_potato_payment_vouchers.date_apprroved',
                              'mr_potato_payment_vouchers.received_by_date',
                              'mr_potato_payment_vouchers.created_by',
                              'mr_potato_payment_vouchers.created_at',
                              'mr_potato_payment_vouchers.invoice_number',
                              'mr_potato_payment_vouchers.voucher_ref_number',
                              'mr_potato_payment_vouchers.issued_date',
                              'mr_potato_payment_vouchers.category',
                              'mr_potato_payment_vouchers.amount_due',
                              'mr_potato_payment_vouchers.delivered_date',
                              'mr_potato_payment_vouchers.status',
                              'mr_potato_payment_vouchers.cheque_number',
                              'mr_potato_payment_vouchers.cheque_amount',
                              'mr_potato_payment_vouchers.sub_category',
                              'mr_potato_payment_vouchers.sub_category_account_id',
                              'mr_potato_payment_vouchers.deleted_at',
                              'mr_potato_codes.mr_potato_code',
                              'mr_potato_codes.module_id',
                              'mr_potato_codes.module_code',
                              'mr_potato_codes.module_name')
                              ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                              ->where('mr_potato_payment_vouchers.pv_id', NULL)
                              ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                              ->where('mr_potato_codes.module_name', $moduleNamePV)
                              ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDate))
                                
                              ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                              ->get()->toArray();
                  
          $cash = "CASH";
          $getTransactionListCashes = DB::table(
                              'mr_potato_payment_vouchers')
                              ->select( 
                              'mr_potato_payment_vouchers.id',
                              'mr_potato_payment_vouchers.user_id',
                              'mr_potato_payment_vouchers.pv_id',
                              'mr_potato_payment_vouchers.date',
                              'mr_potato_payment_vouchers.paid_to',
                              'mr_potato_payment_vouchers.account_no',
                              'mr_potato_payment_vouchers.account_name',
                              'mr_potato_payment_vouchers.particulars',
                              'mr_potato_payment_vouchers.amount',
                              'mr_potato_payment_vouchers.method_of_payment',
                              'mr_potato_payment_vouchers.prepared_by',
                              'mr_potato_payment_vouchers.approved_by',
                              'mr_potato_payment_vouchers.date_apprroved',
                              'mr_potato_payment_vouchers.received_by_date',
                              'mr_potato_payment_vouchers.created_by',
                              'mr_potato_payment_vouchers.created_at',
                              'mr_potato_payment_vouchers.invoice_number',
                              'mr_potato_payment_vouchers.voucher_ref_number',
                              'mr_potato_payment_vouchers.issued_date',
                              'mr_potato_payment_vouchers.category',
                              'mr_potato_payment_vouchers.amount_due',
                              'mr_potato_payment_vouchers.delivered_date',
                              'mr_potato_payment_vouchers.status',
                              'mr_potato_payment_vouchers.cheque_number',
                              'mr_potato_payment_vouchers.cheque_amount',
                              'mr_potato_payment_vouchers.sub_category',
                              'mr_potato_payment_vouchers.sub_category_account_id',
                              'mr_potato_payment_vouchers.deleted_at',
                              'mr_potato_codes.mr_potato_code',
                              'mr_potato_codes.module_id',
                              'mr_potato_codes.module_code',
                              'mr_potato_codes.module_name')
                              ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                              ->where('mr_potato_payment_vouchers.pv_id', NULL)
                              ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                              ->where('mr_potato_codes.module_name', $moduleNamePV)
                              ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDate))
                              ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                              ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                              ->get()->toArray();

     $status = "FULLY PAID AND RELEASED";
      $totalAmountCashes = DB::table(
                                  'mr_potato_payment_vouchers')
                                  ->select( 
                                  'mr_potato_payment_vouchers.id',
                                  'mr_potato_payment_vouchers.user_id',
                                  'mr_potato_payment_vouchers.pv_id',
                                  'mr_potato_payment_vouchers.date',
                                  'mr_potato_payment_vouchers.paid_to',
                                  'mr_potato_payment_vouchers.account_no',
                                  'mr_potato_payment_vouchers.account_name',
                                  'mr_potato_payment_vouchers.particulars',
                                  'mr_potato_payment_vouchers.amount',
                                  'mr_potato_payment_vouchers.method_of_payment',
                                  'mr_potato_payment_vouchers.prepared_by',
                                  'mr_potato_payment_vouchers.approved_by',
                                  'mr_potato_payment_vouchers.date_apprroved',
                                  'mr_potato_payment_vouchers.received_by_date',
                                  'mr_potato_payment_vouchers.created_by',
                                  'mr_potato_payment_vouchers.created_at',
                                  'mr_potato_payment_vouchers.invoice_number',
                                  'mr_potato_payment_vouchers.voucher_ref_number',
                                  'mr_potato_payment_vouchers.issued_date',
                                  'mr_potato_payment_vouchers.category',
                                  'mr_potato_payment_vouchers.amount_due',
                                  'mr_potato_payment_vouchers.delivered_date',
                                  'mr_potato_payment_vouchers.status',
                                  'mr_potato_payment_vouchers.cheque_number',
                                  'mr_potato_payment_vouchers.cheque_amount',
                                  'mr_potato_payment_vouchers.sub_category',
                                  'mr_potato_payment_vouchers.sub_category_account_id',
                                  'mr_potato_payment_vouchers.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                  ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePV)
                                  ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDate))
                                  ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                                  ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                                 ->sum('mr_potato_payment_vouchers.amount_due');

          $check = "CHECK";
          $getTransactionListChecks = DB::table(
                              'mr_potato_payment_vouchers')
                              ->select( 
                              'mr_potato_payment_vouchers.id',
                              'mr_potato_payment_vouchers.user_id',
                              'mr_potato_payment_vouchers.pv_id',
                              'mr_potato_payment_vouchers.date',
                              'mr_potato_payment_vouchers.paid_to',
                              'mr_potato_payment_vouchers.account_no',
                              'mr_potato_payment_vouchers.account_name',
                              'mr_potato_payment_vouchers.particulars',
                              'mr_potato_payment_vouchers.amount',
                              'mr_potato_payment_vouchers.method_of_payment',
                              'mr_potato_payment_vouchers.prepared_by',
                              'mr_potato_payment_vouchers.approved_by',
                              'mr_potato_payment_vouchers.date_apprroved',
                              'mr_potato_payment_vouchers.received_by_date',
                              'mr_potato_payment_vouchers.created_by',
                              'mr_potato_payment_vouchers.created_at',
                              'mr_potato_payment_vouchers.invoice_number',
                              'mr_potato_payment_vouchers.voucher_ref_number',
                              'mr_potato_payment_vouchers.issued_date',
                              'mr_potato_payment_vouchers.category',
                              'mr_potato_payment_vouchers.amount_due',
                              'mr_potato_payment_vouchers.delivered_date',
                              'mr_potato_payment_vouchers.status',
                              'mr_potato_payment_vouchers.cheque_number',
                              'mr_potato_payment_vouchers.cheque_amount',
                              'mr_potato_payment_vouchers.cheque_total_amount',
                              'mr_potato_payment_vouchers.sub_category',
                              'mr_potato_payment_vouchers.sub_category_account_id',
                              'mr_potato_payment_vouchers.deleted_at',
                              'mr_potato_codes.mr_potato_code',
                              'mr_potato_codes.module_id',
                              'mr_potato_codes.module_code',
                              'mr_potato_codes.module_name')
                              ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                              ->where('mr_potato_payment_vouchers.pv_id', NULL)
                              ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                              ->where('mr_potato_codes.module_name', $moduleNamePV)
                              ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDate))
                              ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                              ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                              ->get()->toArray();
                  
      $totalAmountCheck = DB::table(
                                  'mr_potato_payment_vouchers')
                                  ->select( 
                                  'mr_potato_payment_vouchers.id',
                                  'mr_potato_payment_vouchers.user_id',
                                  'mr_potato_payment_vouchers.pv_id',
                                  'mr_potato_payment_vouchers.date',
                                  'mr_potato_payment_vouchers.paid_to',
                                  'mr_potato_payment_vouchers.account_no',
                                  'mr_potato_payment_vouchers.account_name',
                                  'mr_potato_payment_vouchers.particulars',
                                  'mr_potato_payment_vouchers.amount',
                                  'mr_potato_payment_vouchers.method_of_payment',
                                  'mr_potato_payment_vouchers.prepared_by',
                                  'mr_potato_payment_vouchers.approved_by',
                                  'mr_potato_payment_vouchers.date_apprroved',
                                  'mr_potato_payment_vouchers.received_by_date',
                                  'mr_potato_payment_vouchers.created_by',
                                  'mr_potato_payment_vouchers.created_at',
                                  'mr_potato_payment_vouchers.invoice_number',
                                  'mr_potato_payment_vouchers.voucher_ref_number',
                                  'mr_potato_payment_vouchers.issued_date',
                                  'mr_potato_payment_vouchers.category',
                                  'mr_potato_payment_vouchers.amount_due',
                                  'mr_potato_payment_vouchers.delivered_date',
                                  'mr_potato_payment_vouchers.status',
                                  'mr_potato_payment_vouchers.cheque_number',
                                  'mr_potato_payment_vouchers.cheque_amount',
                                  'mr_potato_payment_vouchers.sub_category',
                                  'mr_potato_payment_vouchers.sub_category_account_id',
                                  'mr_potato_payment_vouchers.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                  ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePV)
                                  ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDate))
                                  ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                  ->where('mr_potato_payment_vouchers.status', '!=', $status)
                                  ->sum('mr_potato_payment_vouchers.amount_due');
        
        return view('mr-potato-get-summary-report',  compact('getDate', 'getAllSalesInvoices', 
        'totalSalesInvoice', 'getAllDeliveryReceipts', 'totalDeliveryReceipt','purchaseOrders', 'pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
    

    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'mr_potato_sales_invoices')
                                ->select(
                                    'mr_potato_sales_invoices.id',
                                    'mr_potato_sales_invoices.user_id',
                                    'mr_potato_sales_invoices.si_id',
                                    'mr_potato_sales_invoices.invoice_number',
                                    'mr_potato_sales_invoices.date',
                                    'mr_potato_sales_invoices.ordered_by',
                                    'mr_potato_sales_invoices.address',
                                    'mr_potato_sales_invoices.qty',
                                    'mr_potato_sales_invoices.total_kls',
                                    'mr_potato_sales_invoices.item_description',
                                    'mr_potato_sales_invoices.unit_price',
                                    'mr_potato_sales_invoices.amount',
                                    'mr_potato_sales_invoices.total_amount',
                                    'mr_potato_sales_invoices.created_by',
                                    'mr_potato_sales_invoices.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_sales_invoices.si_id', NULL)
                                ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->whereDate('mr_potato_sales_invoices.created_at', '=', date($getDateToday))
                                ->orderBy('mr_potato_sales_invoices.id', 'desc')
                                ->get()->toArray();
      
          $totalSalesInvoice = DB::table(
                                  'mr_potato_sales_invoices')
                                  ->select(
                                      'mr_potato_sales_invoices.id',
                                      'mr_potato_sales_invoices.user_id',
                                      'mr_potato_sales_invoices.si_id',
                                      'mr_potato_sales_invoices.invoice_number',
                                      'mr_potato_sales_invoices.date',
                                      'mr_potato_sales_invoices.ordered_by',
                                      'mr_potato_sales_invoices.address',
                                      'mr_potato_sales_invoices.qty',
                                      'mr_potato_sales_invoices.total_kls',
                                      'mr_potato_sales_invoices.item_description',
                                      'mr_potato_sales_invoices.unit_price',
                                      'mr_potato_sales_invoices.amount',
                                      'mr_potato_sales_invoices.total_amount',
                                      'mr_potato_sales_invoices.created_by',
                                      'mr_potato_sales_invoices.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_sales_invoices.si_id', NULL)
                                  ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleName)
                                  ->whereDate('mr_potato_sales_invoices.created_at', '=', date($getDateToday))
                                  ->sum('mr_potato_sales_invoices.total_amount');
      
          $moduleNameDR = "Delivery Receipt";
          $getAllDeliveryReceipts = DB::table(
                                  'mr_potato_delivery_receipts')
                                  ->select( 
                                  'mr_potato_delivery_receipts.id',
                                  'mr_potato_delivery_receipts.user_id',
                                  'mr_potato_delivery_receipts.dr_id',
                                  'mr_potato_delivery_receipts.delivered_to',
                                  'mr_potato_delivery_receipts.date',
                                  'mr_potato_delivery_receipts.address',
                                  'mr_potato_delivery_receipts.product_id',
                                  'mr_potato_delivery_receipts.unit',
                                  'mr_potato_delivery_receipts.item_description',
                                  'mr_potato_delivery_receipts.unit_price',
                                  'mr_potato_delivery_receipts.amount',
                                  'mr_potato_delivery_receipts.total_amount',
                                  'mr_potato_delivery_receipts.qty',
                                  'mr_potato_delivery_receipts.prepared_by',
                                  'mr_potato_delivery_receipts.checked_by',
                                  'mr_potato_delivery_receipts.received_by',
                                  'mr_potato_delivery_receipts.created_by',
                                  'mr_potato_delivery_receipts.created_at',
                                  'mr_potato_delivery_receipts.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                  ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNameDR)
                                  ->whereDate('mr_potato_delivery_receipts.created_at', '=', date($getDateToday))
                                  ->orderBy('mr_potato_delivery_receipts.id', 'desc')
                                  ->get()->toArray();
                                
          $totalDeliveryReceipt = DB::table(
                                      'mr_potato_delivery_receipts')
                                      ->select( 
                                      'mr_potato_delivery_receipts.id',
                                      'mr_potato_delivery_receipts.user_id',
                                      'mr_potato_delivery_receipts.dr_id',
                                      'mr_potato_delivery_receipts.delivered_to',
                                      'mr_potato_delivery_receipts.date',
                                      'mr_potato_delivery_receipts.address',
                                      'mr_potato_delivery_receipts.product_id',
                                      'mr_potato_delivery_receipts.unit',
                                      'mr_potato_delivery_receipts.item_description',
                                      'mr_potato_delivery_receipts.unit_price',
                                      'mr_potato_delivery_receipts.amount',
                                      'mr_potato_delivery_receipts.total_amount',
                                      'mr_potato_delivery_receipts.qty',
                                      'mr_potato_delivery_receipts.prepared_by',
                                      'mr_potato_delivery_receipts.checked_by',
                                      'mr_potato_delivery_receipts.received_by',
                                      'mr_potato_delivery_receipts.created_by',
                                      'mr_potato_delivery_receipts.created_at',
                                      'mr_potato_delivery_receipts.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                      ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                      ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                      ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                      ->where('mr_potato_codes.module_name', $moduleNameDR)
                                      ->whereDate('mr_potato_delivery_receipts.created_at', '=', date($getDateToday))
                                     ->sum('mr_potato_delivery_receipts.total_amount');

      $moduleNamePurchase = "Purchase Order";
      $purchaseOrders = DB::table(
                              'mr_potato_purchase_orders')
                              ->select(
                                  'mr_potato_purchase_orders.id',
                                  'mr_potato_purchase_orders.user_id',
                                  'mr_potato_purchase_orders.po_id',
                                  'mr_potato_purchase_orders.paid_to',
                                  'mr_potato_purchase_orders.branch_location',
                                  'mr_potato_purchase_orders.address',
                                  'mr_potato_purchase_orders.date',
                                  'mr_potato_purchase_orders.quantity',
                                  'mr_potato_purchase_orders.description',
                                  'mr_potato_purchase_orders.unit_price',
                                  'mr_potato_purchase_orders.amount',
                                  'mr_potato_purchase_orders.total_price',
                                  'mr_potato_purchase_orders.requested_by',
                                  'mr_potato_purchase_orders.prepared_by',
                                  'mr_potato_purchase_orders.checked_by',
                                  'mr_potato_purchase_orders.created_by',
                                  'mr_potato_purchase_orders.created_at',
                                  'mr_potato_purchase_orders.requesting_branch',
                                  'mr_potato_purchase_orders.deleted_at',
                                  'mr_potato_codes.mr_potato_code',
                                  'mr_potato_codes.module_id',
                                  'mr_potato_codes.module_code',
                                  'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_purchase_orders.po_id', NULL)
                                  ->where('mr_potato_purchase_orders.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleNamePurchase)   
                                  ->whereDate('mr_potato_purchase_orders.created_at', '=', date($getDateToday))
                                                                     
                                  ->orderBy('mr_potato_purchase_orders.id', 'desc')
                                  ->get()->toArray();


        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.created_at',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.pv_id', NULL)
                            ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                            ->where('mr_potato_codes.module_name', $moduleNamePV)
                            ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                            ->get()->toArray();

    $status = "FULLY PAID AND RELEASED";
    $totalAmountCash = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                                ->sum('mr_potato_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.created_at',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.cheque_total_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.pv_id', NULL)
                            ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                            ->where('mr_potato_codes.module_name', $moduleNamePV)
                            ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                            ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                            ->get()->toArray();
                
    $totalAmountCheck = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                ->where('mr_potato_payment_vouchers.status', '!=', $status)
                                ->sum('mr_potato_payment_vouchers.amount_due');

        $totalPaidAmountCheck = DB::table(
                                    'mr_potato_payment_vouchers')
                                    ->select( 
                                    'mr_potato_payment_vouchers.id',
                                    'mr_potato_payment_vouchers.user_id',
                                    'mr_potato_payment_vouchers.pv_id',
                                    'mr_potato_payment_vouchers.date',
                                    'mr_potato_payment_vouchers.paid_to',
                                    'mr_potato_payment_vouchers.account_no',
                                    'mr_potato_payment_vouchers.account_name',
                                    'mr_potato_payment_vouchers.particulars',
                                    'mr_potato_payment_vouchers.amount',
                                    'mr_potato_payment_vouchers.method_of_payment',
                                    'mr_potato_payment_vouchers.prepared_by',
                                    'mr_potato_payment_vouchers.approved_by',
                                    'mr_potato_payment_vouchers.date_apprroved',
                                    'mr_potato_payment_vouchers.received_by_date',
                                    'mr_potato_payment_vouchers.created_by',
                                    'mr_potato_payment_vouchers.created_at',
                                    'mr_potato_payment_vouchers.invoice_number',
                                    'mr_potato_payment_vouchers.voucher_ref_number',
                                    'mr_potato_payment_vouchers.issued_date',
                                    'mr_potato_payment_vouchers.category',
                                    'mr_potato_payment_vouchers.amount_due',
                                    'mr_potato_payment_vouchers.delivered_date',
                                    'mr_potato_payment_vouchers.status',
                                    'mr_potato_payment_vouchers.cheque_number',
                                    'mr_potato_payment_vouchers.cheque_amount',
                                    'mr_potato_payment_vouchers.cheque_total_amount',
                                    'mr_potato_payment_vouchers.sub_category',
                                    'mr_potato_payment_vouchers.sub_category_account_id',
                                    'mr_potato_payment_vouchers.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                    ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                    ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                    ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                    ->where('mr_potato_codes.module_name', $moduleNamePV)
                                    ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                    ->where('mr_potato_payment_vouchers.status', $status)
                                    ->sum('mr_potato_payment_vouchers.cheque_total_amount');
                      
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryMrPotato',  compact('uri0', 'uri1', 'date', 'getDateToday', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 'totalPOrder', 'totalBStatement', 
        'totalAmountCash','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('mr-potato-summary-report.pdf');
        
    }

    public function summaryReport(){
          //sales invoice
          $getDateToday = date("Y-m-d");
        
          $moduleName = "Sales Invoice";
          $getAllSalesInvoices = DB::table(
                                  'mr_potato_sales_invoices')
                                  ->select(
                                      'mr_potato_sales_invoices.id',
                                      'mr_potato_sales_invoices.user_id',
                                      'mr_potato_sales_invoices.si_id',
                                      'mr_potato_sales_invoices.invoice_number',
                                      'mr_potato_sales_invoices.date',
                                      'mr_potato_sales_invoices.ordered_by',
                                      'mr_potato_sales_invoices.address',
                                      'mr_potato_sales_invoices.qty',
                                      'mr_potato_sales_invoices.total_kls',
                                      'mr_potato_sales_invoices.item_description',
                                      'mr_potato_sales_invoices.unit_price',
                                      'mr_potato_sales_invoices.amount',
                                      'mr_potato_sales_invoices.total_amount',
                                      'mr_potato_sales_invoices.created_by',
                                      'mr_potato_sales_invoices.deleted_at',
                                      'mr_potato_codes.mr_potato_code',
                                      'mr_potato_codes.module_id',
                                      'mr_potato_codes.module_code',
                                      'mr_potato_codes.module_name')
                                  ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                  ->where('mr_potato_sales_invoices.si_id', NULL)
                                  ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                  ->where('mr_potato_codes.module_name', $moduleName)
                                  ->whereDate('mr_potato_sales_invoices.created_at', '=', date($getDateToday))
                                  ->orderBy('mr_potato_sales_invoices.id', 'desc')
                                  ->get()->toArray();
        
            $totalSalesInvoice = DB::table(
                                    'mr_potato_sales_invoices')
                                    ->select(
                                        'mr_potato_sales_invoices.id',
                                        'mr_potato_sales_invoices.user_id',
                                        'mr_potato_sales_invoices.si_id',
                                        'mr_potato_sales_invoices.invoice_number',
                                        'mr_potato_sales_invoices.date',
                                        'mr_potato_sales_invoices.ordered_by',
                                        'mr_potato_sales_invoices.address',
                                        'mr_potato_sales_invoices.qty',
                                        'mr_potato_sales_invoices.total_kls',
                                        'mr_potato_sales_invoices.item_description',
                                        'mr_potato_sales_invoices.unit_price',
                                        'mr_potato_sales_invoices.amount',
                                        'mr_potato_sales_invoices.total_amount',
                                        'mr_potato_sales_invoices.created_by',
                                        'mr_potato_sales_invoices.deleted_at',
                                        'mr_potato_codes.mr_potato_code',
                                        'mr_potato_codes.module_id',
                                        'mr_potato_codes.module_code',
                                        'mr_potato_codes.module_name')
                                    ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                    ->where('mr_potato_sales_invoices.si_id', NULL)
                                    ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                    ->where('mr_potato_codes.module_name', $moduleName)
                                    ->whereDate('mr_potato_sales_invoices.created_at', '=', date($getDateToday))
                                    ->sum('mr_potato_sales_invoices.total_amount');
        
            $moduleNameDR = "Delivery Receipt";
            $getAllDeliveryReceipts = DB::table(
                                    'mr_potato_delivery_receipts')
                                    ->select( 
                                    'mr_potato_delivery_receipts.id',
                                    'mr_potato_delivery_receipts.user_id',
                                    'mr_potato_delivery_receipts.dr_id',
                                    'mr_potato_delivery_receipts.delivered_to',
                                    'mr_potato_delivery_receipts.date',
                                    'mr_potato_delivery_receipts.address',
                                    'mr_potato_delivery_receipts.product_id',
                                    'mr_potato_delivery_receipts.unit',
                                    'mr_potato_delivery_receipts.item_description',
                                    'mr_potato_delivery_receipts.unit_price',
                                    'mr_potato_delivery_receipts.amount',
                                    'mr_potato_delivery_receipts.total_amount',
                                    'mr_potato_delivery_receipts.qty',
                                    'mr_potato_delivery_receipts.prepared_by',
                                    'mr_potato_delivery_receipts.checked_by',
                                    'mr_potato_delivery_receipts.received_by',
                                    'mr_potato_delivery_receipts.created_by',
                                    'mr_potato_delivery_receipts.created_at',
                                    'mr_potato_delivery_receipts.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                    ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                    ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                    ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                    ->where('mr_potato_codes.module_name', $moduleNameDR)
                                    ->whereDate('mr_potato_delivery_receipts.created_at', '=', date($getDateToday))
                                    ->orderBy('mr_potato_delivery_receipts.id', 'desc')
                                    ->get()->toArray();
                                  
            $totalDeliveryReceipt = DB::table(
                                        'mr_potato_delivery_receipts')
                                        ->select( 
                                        'mr_potato_delivery_receipts.id',
                                        'mr_potato_delivery_receipts.user_id',
                                        'mr_potato_delivery_receipts.dr_id',
                                        'mr_potato_delivery_receipts.delivered_to',
                                        'mr_potato_delivery_receipts.date',
                                        'mr_potato_delivery_receipts.address',
                                        'mr_potato_delivery_receipts.product_id',
                                        'mr_potato_delivery_receipts.unit',
                                        'mr_potato_delivery_receipts.item_description',
                                        'mr_potato_delivery_receipts.unit_price',
                                        'mr_potato_delivery_receipts.amount',
                                        'mr_potato_delivery_receipts.total_amount',
                                        'mr_potato_delivery_receipts.qty',
                                        'mr_potato_delivery_receipts.prepared_by',
                                        'mr_potato_delivery_receipts.checked_by',
                                        'mr_potato_delivery_receipts.received_by',
                                        'mr_potato_delivery_receipts.created_by',
                                        'mr_potato_delivery_receipts.created_at',
                                        'mr_potato_delivery_receipts.deleted_at',
                                        'mr_potato_codes.mr_potato_code',
                                        'mr_potato_codes.module_id',
                                        'mr_potato_codes.module_code',
                                        'mr_potato_codes.module_name')
                                        ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                        ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                        ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                        ->where('mr_potato_codes.module_name', $moduleNameDR)
                                        ->whereDate('mr_potato_delivery_receipts.created_at', '=', date($getDateToday))
                                       ->sum('mr_potato_delivery_receipts.total_amount');

        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                                'mr_potato_purchase_orders')
                                ->select(
                                    'mr_potato_purchase_orders.id',
                                    'mr_potato_purchase_orders.user_id',
                                    'mr_potato_purchase_orders.po_id',
                                    'mr_potato_purchase_orders.paid_to',
                                    'mr_potato_purchase_orders.branch_location',
                                    'mr_potato_purchase_orders.address',
                                    'mr_potato_purchase_orders.date',
                                    'mr_potato_purchase_orders.quantity',
                                    'mr_potato_purchase_orders.description',
                                    'mr_potato_purchase_orders.unit_price',
                                    'mr_potato_purchase_orders.amount',
                                    'mr_potato_purchase_orders.total_price',
                                    'mr_potato_purchase_orders.requested_by',
                                    'mr_potato_purchase_orders.prepared_by',
                                    'mr_potato_purchase_orders.checked_by',
                                    'mr_potato_purchase_orders.created_by',
                                    'mr_potato_purchase_orders.created_at',
                                    'mr_potato_purchase_orders.requesting_branch',
                                    'mr_potato_purchase_orders.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                    ->leftJoin('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                                    ->where('mr_potato_purchase_orders.po_id', NULL)
                                    ->where('mr_potato_purchase_orders.deleted_at', NULL)
                                    ->where('mr_potato_codes.module_name', $moduleNamePurchase)   
                                    ->whereDate('mr_potato_purchase_orders.created_at', '=', date($getDateToday))
                                                                       
                                    ->orderBy('mr_potato_purchase_orders.id', 'desc')
                                    ->get()->toArray();

            $moduleNamePC = "Petty Cash";
            $pettyCashLists = DB::table(
                                    'mr_potato_petty_cashes')
                                    ->select( 
                                    'mr_potato_petty_cashes.id',
                                    'mr_potato_petty_cashes.user_id',
                                    'mr_potato_petty_cashes.pc_id',
                                    'mr_potato_petty_cashes.date',
                                    'mr_potato_petty_cashes.petty_cash_name',
                                    'mr_potato_petty_cashes.petty_cash_summary',
                                    'mr_potato_petty_cashes.amount',
                                    'mr_potato_petty_cashes.created_by',
                                    'mr_potato_petty_cashes.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                    ->leftJoin('mr_potato_codes', 'mr_potato_petty_cashes.id', '=', 'mr_potato_codes.module_id')
                                    ->where('mr_potato_petty_cashes.pc_id', NULL)
                                    ->where('mr_potato_petty_cashes.deleted_at', NULL)
                                    ->where('mr_potato_codes.module_name', $moduleNamePC)
                                    ->orderBy('mr_potato_petty_cashes.id', 'desc')
                                    ->get()->toArray();
    
            $moduleNamePV = "Payment Voucher";
            $getTransactionLists = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.cheque_total_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                                  
                                ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                                ->get()->toArray();
                    
            $cash = "CASH";
            $getTransactionListCashes = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                                ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                                    'mr_potato_payment_vouchers')
                                    ->select( 
                                    'mr_potato_payment_vouchers.id',
                                    'mr_potato_payment_vouchers.user_id',
                                    'mr_potato_payment_vouchers.pv_id',
                                    'mr_potato_payment_vouchers.date',
                                    'mr_potato_payment_vouchers.paid_to',
                                    'mr_potato_payment_vouchers.account_no',
                                    'mr_potato_payment_vouchers.account_name',
                                    'mr_potato_payment_vouchers.particulars',
                                    'mr_potato_payment_vouchers.amount',
                                    'mr_potato_payment_vouchers.method_of_payment',
                                    'mr_potato_payment_vouchers.prepared_by',
                                    'mr_potato_payment_vouchers.approved_by',
                                    'mr_potato_payment_vouchers.date_apprroved',
                                    'mr_potato_payment_vouchers.received_by_date',
                                    'mr_potato_payment_vouchers.created_by',
                                    'mr_potato_payment_vouchers.created_at',
                                    'mr_potato_payment_vouchers.invoice_number',
                                    'mr_potato_payment_vouchers.voucher_ref_number',
                                    'mr_potato_payment_vouchers.issued_date',
                                    'mr_potato_payment_vouchers.category',
                                    'mr_potato_payment_vouchers.amount_due',
                                    'mr_potato_payment_vouchers.delivered_date',
                                    'mr_potato_payment_vouchers.status',
                                    'mr_potato_payment_vouchers.cheque_number',
                                    'mr_potato_payment_vouchers.cheque_amount',
                                    'mr_potato_payment_vouchers.sub_category',
                                    'mr_potato_payment_vouchers.sub_category_account_id',
                                    'mr_potato_payment_vouchers.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                    ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                    ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                    ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                    ->where('mr_potato_codes.module_name', $moduleNamePV)
                                    ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('mr_potato_payment_vouchers.method_of_payment', $cash)
                                    ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                                   ->sum('mr_potato_payment_vouchers.amount_due');

            $check = "CHECK";
            $getTransactionListChecks = DB::table(
                                'mr_potato_payment_vouchers')
                                ->select( 
                                'mr_potato_payment_vouchers.id',
                                'mr_potato_payment_vouchers.user_id',
                                'mr_potato_payment_vouchers.pv_id',
                                'mr_potato_payment_vouchers.date',
                                'mr_potato_payment_vouchers.paid_to',
                                'mr_potato_payment_vouchers.account_no',
                                'mr_potato_payment_vouchers.account_name',
                                'mr_potato_payment_vouchers.particulars',
                                'mr_potato_payment_vouchers.amount',
                                'mr_potato_payment_vouchers.method_of_payment',
                                'mr_potato_payment_vouchers.prepared_by',
                                'mr_potato_payment_vouchers.approved_by',
                                'mr_potato_payment_vouchers.date_apprroved',
                                'mr_potato_payment_vouchers.received_by_date',
                                'mr_potato_payment_vouchers.created_by',
                                'mr_potato_payment_vouchers.created_at',
                                'mr_potato_payment_vouchers.invoice_number',
                                'mr_potato_payment_vouchers.voucher_ref_number',
                                'mr_potato_payment_vouchers.issued_date',
                                'mr_potato_payment_vouchers.category',
                                'mr_potato_payment_vouchers.amount_due',
                                'mr_potato_payment_vouchers.delivered_date',
                                'mr_potato_payment_vouchers.status',
                                'mr_potato_payment_vouchers.cheque_number',
                                'mr_potato_payment_vouchers.cheque_amount',
                                'mr_potato_payment_vouchers.cheque_total_amount',
                                'mr_potato_payment_vouchers.sub_category',
                                'mr_potato_payment_vouchers.sub_category_account_id',
                                'mr_potato_payment_vouchers.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNamePV)
                                ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                                ->get()->toArray();
                    
        $totalAmountCheck = DB::table(
                                    'mr_potato_payment_vouchers')
                                    ->select( 
                                    'mr_potato_payment_vouchers.id',
                                    'mr_potato_payment_vouchers.user_id',
                                    'mr_potato_payment_vouchers.pv_id',
                                    'mr_potato_payment_vouchers.date',
                                    'mr_potato_payment_vouchers.paid_to',
                                    'mr_potato_payment_vouchers.account_no',
                                    'mr_potato_payment_vouchers.account_name',
                                    'mr_potato_payment_vouchers.particulars',
                                    'mr_potato_payment_vouchers.amount',
                                    'mr_potato_payment_vouchers.method_of_payment',
                                    'mr_potato_payment_vouchers.prepared_by',
                                    'mr_potato_payment_vouchers.approved_by',
                                    'mr_potato_payment_vouchers.date_apprroved',
                                    'mr_potato_payment_vouchers.received_by_date',
                                    'mr_potato_payment_vouchers.created_by',
                                    'mr_potato_payment_vouchers.created_at',
                                    'mr_potato_payment_vouchers.invoice_number',
                                    'mr_potato_payment_vouchers.voucher_ref_number',
                                    'mr_potato_payment_vouchers.issued_date',
                                    'mr_potato_payment_vouchers.category',
                                    'mr_potato_payment_vouchers.amount_due',
                                    'mr_potato_payment_vouchers.delivered_date',
                                    'mr_potato_payment_vouchers.status',
                                    'mr_potato_payment_vouchers.cheque_number',
                                    'mr_potato_payment_vouchers.cheque_amount',
                                    'mr_potato_payment_vouchers.sub_category',
                                    'mr_potato_payment_vouchers.sub_category_account_id',
                                    'mr_potato_payment_vouchers.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                    ->leftJoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                                    ->where('mr_potato_payment_vouchers.pv_id', NULL)
                                    ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                                    ->where('mr_potato_codes.module_name', $moduleNamePV)
                                    ->whereDate('mr_potato_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('mr_potato_payment_vouchers.method_of_payment', $check)
                                    ->where('mr_potato_payment_vouchers.status', '!=', $status)
                                    ->sum('mr_potato_payment_vouchers.amount_due');

        return view('mr-potato-summary-report', compact('getAllSalesInvoices', 
        'totalSalesInvoice', 'getAllDeliveryReceipts', 'totalDeliveryReceipt','purchaseOrders', 'pettyCashLists', 
        'getTransactionLists', 'getTransactionListCashes', 'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
    }

    public function storeBillingStatement(Request $request){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName." ".$lastName;

          //if user selects an order
        if($request->get('choose') === "Sales Invoice"){
            $invoiceNo = $request->get('invoiceNumber');
            $invoiceListId = $request->get('invoiceListId');
            $qty = $request->get('qty');
            $totalKls = $request->get('totalKls');
            $itemDesc = $request->get('itemDescription');
            $unitPrice = $request->get('unitPrice');
            $amount = $request->get('amount');

            $drNo = NULL;
            $drList = NULL;
            $productId = NULL;
            $unit = NULL;
            
        }else{
            $drNo = $request->get('drNo');
            $drList = $request->get('drList');
            $productId = $request->get('productId');
            $qty = $request->get('qty');
            $unit = $request->get('unit');
            $itemDesc = $request->get('itemDescription');
            $unitPrice = $request->get('unitPrice');
            $amount = $request->get('amount');

            $invoiceNo = NULL;
            $invoiceListId = NULL;
            $totalKls = NULL;

        }

          //get the latest insert id query in table mr potato codes
          $dataReferenceNum = DB::select('SELECT id, mr_potato_code FROM mr_potato_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 reference number
          if(isset($dataReferenceNum[0]->mr_potato_code) != 0){
              //if code is not 0
              $newRefNum = $dataReferenceNum[0]->mr_potato_code +1;
              $uRef = sprintf("%06d",$newRefNum);   
  
          }else{
              //if code is 0 
              $newRefNum = 1;
              $uRef = sprintf("%06d",$newRefNum);
          } 

          $billingStatement = new MrPotatoBillingStatement([
                'user_id'=>$user->id,
                'bill_to'=>$request->get('bill_to'),
                'address'=>$request->get('address'),
                'period_covered'=>$request->get('periodCovered'),
                'terms'=>$request->get('terms'),
                'date_of_transaction'=>$request->get('dateTransaction'),
                'order'=>$request->get('choose'),
                'invoice_no'=>$invoiceNo,
                'invoice_list_id'=>$invoiceListId,
                'qty'=>$qty,
                'total_kls'=>$totalKls,
                'item_description'=>$itemDesc,
                'unit_price'=>$unitPrice,
                'amount'=>$amount,
                'dr_no'=>$drNo,
                'dr_list_id'=>$drList,
                'product_id'=>$productId,
                'unit'=>$unit,
                'created_by'=>$name,
          ]);

          $billingStatement->save();
        
          $insertedId = $billingStatement->id;



    }

    public function billingStatementForm(){
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'mr_potato_sales_invoices')
                                ->select(
                                    'mr_potato_sales_invoices.id',
                                    'mr_potato_sales_invoices.user_id',
                                    'mr_potato_sales_invoices.si_id',
                                    'mr_potato_sales_invoices.invoice_number',
                                    'mr_potato_sales_invoices.date',
                                    'mr_potato_sales_invoices.ordered_by',
                                    'mr_potato_sales_invoices.address',
                                    'mr_potato_sales_invoices.qty',
                                    'mr_potato_sales_invoices.total_kls',
                                    'mr_potato_sales_invoices.item_description',
                                    'mr_potato_sales_invoices.unit_price',
                                    'mr_potato_sales_invoices.amount',
                                    'mr_potato_sales_invoices.created_by',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                ->join('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_sales_invoices.si_id', NULL)
                                ->orderBy('mr_potato_sales_invoices.id', 'desc')
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->get()->toArray();

        $moduleNameDelivery = "Delivery Receipt";
        $drNos = DB::table(
                                'mr_potato_delivery_receipts')
                                ->select( 
                                'mr_potato_delivery_receipts.id',
                                'mr_potato_delivery_receipts.user_id',
                                'mr_potato_delivery_receipts.dr_id',
                                'mr_potato_delivery_receipts.delivered_to',
                                'mr_potato_delivery_receipts.date',
                                'mr_potato_delivery_receipts.address',
                                'mr_potato_delivery_receipts.product_id',
                                'mr_potato_delivery_receipts.unit',
                                'mr_potato_delivery_receipts.item_description',
                                'mr_potato_delivery_receipts.unit_price',
                                'mr_potato_delivery_receipts.amount',
                                'mr_potato_delivery_receipts.qty',
                                'mr_potato_delivery_receipts.prepared_by',
                                'mr_potato_delivery_receipts.checked_by',
                                'mr_potato_delivery_receipts.received_by',
                                'mr_potato_delivery_receipts.created_by',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->join('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                ->where('mr_potato_codes.module_name', $moduleNameDelivery)
                                ->get();
                              
       
        return view('mr-potato-billing-statement-form', compact('getAllSalesInvoices', 'drNos'));
    }

    public function viewPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                                'mr_potato_petty_cashes')
                                ->select( 
                                'mr_potato_petty_cashes.id',
                                'mr_potato_petty_cashes.user_id',
                                'mr_potato_petty_cashes.pc_id',
                                'mr_potato_petty_cashes.date',
                                'mr_potato_petty_cashes.petty_cash_name',
                                'mr_potato_petty_cashes.petty_cash_summary',
                                'mr_potato_petty_cashes.amount',
                                'mr_potato_petty_cashes.created_by',
                                'mr_potato_petty_cashes.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->join('mr_potato_codes', 'mr_potato_petty_cashes.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_petty_cashes.id', $id)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->get();

        $getPettyCashSummaries = MrPotatoPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = MrPotatoPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = MrPotatoPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        return view('mr-potato-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
  
    }


    public function updatePC(Request $request, $id){
        $updatePC = MrPotatoPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashMrPotato', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;
        
        $addNew = new MrPotatoPettyCash([
            'user_id'=>$user->id,
            'pc_id'=>$id,
            'date'=>$request->get('date'),
            'petty_cash_summary'=>$request->get('pettyCashSummary'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNew->save();
        Session::flash('addNewSuccess', 'Successfully added.');

        return redirect()->route('editPettyCashMrPotato', ['id'=>$id]);

    }

    public function updatePettyCash(Request $request, $id){
        $updatePettyCash = MrPotatoPettyCash::find($id);
        $updatePettyCash->date = $request->get('date');
        $updatePettyCash->petty_cash_name = $request->get('pettyCashName');
        $updatePettyCash->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePettyCash->save();

        Session::flash('editSuccess', 'Successfully updated.');


    }

    public function editPettyCash($id){
        $moduleName = "Petty Cash";
        $pettyCash = DB::table(
                                'mr_potato_petty_cashes')
                                ->select( 
                                'mr_potato_petty_cashes.id',
                                'mr_potato_petty_cashes.user_id',
                                'mr_potato_petty_cashes.pc_id',
                                'mr_potato_petty_cashes.date',
                                'mr_potato_petty_cashes.petty_cash_name',
                                'mr_potato_petty_cashes.petty_cash_summary',
                                'mr_potato_petty_cashes.amount',
                                'mr_potato_petty_cashes.created_by',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->join('mr_potato_codes', 'mr_potato_petty_cashes.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_petty_cashes.id', $id)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->get();

        $pettyCashSummaries = MrPotatoPettyCash::where('pc_id', $id)->get()->toArray();
        return view('edit-mr-potato-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }
    
    public function addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table mr_potato_codes
         $dataCashNo = DB::select('SELECT id, mr_potato_code FROM mr_potato_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
        if(isset($dataCashNo[0]->mr_potato_code ) != 0){
            //if code is not 0
            $newProd = $dataCashNo[0]->mr_potato_code +1;
            $uPetty = sprintf("%06d",$newProd);   

        }else{
            //if code is 0 
            $newProd = 1;
            $uPetty = sprintf("%06d",$newProd);
        } 

        $addPettyCash = new MrPotatoPettyCash([
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

        $mrPotato = new MrPotatoCode([
            'user_id'=>$user->id,
            'mr_potato_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $mrPotato->save();

        return response()->json($insertId);
    }

    public function viewBills($id){
         //
        $viewBill = MrPotatoUtility::find($id);
        
        //view particulars
         $viewParticulars = MrPotatoPaymentVoucher::where('sub_category_account_id', $id)->get()->toArray();
 
        return view('mr-potato-view-utility', compact('viewBill', 'viewParticulars'));
    }

    //
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
                'mr_potato_utilities')
                ->where('account_id', $request->accountIdInternet)
                ->get()->first();

        if($target ==  NULL){
    
            $addInternet = new MrPotatoUtility([
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

    //
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
                'mr_potato_utilities')
                ->where('account_id', $request->accountId)
                ->get()->first();

        if($target == NULL){

            $addBills = new MrPotatoUtility([
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

    //
    public function utilities(){
        $flag = "Veco";
        $flagMCWD = "MCWD";
        $flagInternet = "Internet";

        $vecoDocuments = MrPotatoUtility::where('flag', $flag)->get()->toArray();

        $mcwdDocuments = MrPotatoUtility::where('flag', $flagMCWD)->get()->toArray();

        $internetDocuments = MrPotatoUtility::where('flag', $flagInternet)->get()->toArray();

        return view('mr-potato-utilities', compact('vecoDocuments', 'mcwdDocuments', 'internetDocuments'));
    }

    //
    public function pettyCashList(){
        $moduleName = "Petty Cash";
        $pettyCashLists = DB::table(
                                'mr_potato_petty_cashes')
                                ->select( 
                                'mr_potato_petty_cashes.id',
                                'mr_potato_petty_cashes.user_id',
                                'mr_potato_petty_cashes.pc_id',
                                'mr_potato_petty_cashes.date',
                                'mr_potato_petty_cashes.petty_cash_name',
                                'mr_potato_petty_cashes.petty_cash_summary',
                                'mr_potato_petty_cashes.amount',
                                'mr_potato_petty_cashes.created_by',
                                'mr_potato_petty_cashes.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->join('mr_potato_codes', 'mr_potato_petty_cashes.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_petty_cashes.pc_id', NULL)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->where('mr_potato_petty_cashes.deleted_at', NULL)
                                ->orderBy('mr_potato_petty_cashes.id', 'desc')
                                ->get()->toArray();


        return view('mr-potato-petty-cash-list', compact('pettyCashLists'));
    }

    //
    public function printPO($id){
    
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrder = DB::table(
                        'mr_potato_purchase_orders')
                        ->select(
                            'mr_potato_purchase_orders.id',
                            'mr_potato_purchase_orders.user_id',
                            'mr_potato_purchase_orders.po_id',
                            'mr_potato_purchase_orders.paid_to',
                            'mr_potato_purchase_orders.branch_location',
                            'mr_potato_purchase_orders.address',
                            'mr_potato_purchase_orders.date',
                            'mr_potato_purchase_orders.quantity',
                            'mr_potato_purchase_orders.description',
                            'mr_potato_purchase_orders.unit_price',
                            'mr_potato_purchase_orders.ordered_by',
                            'mr_potato_purchase_orders.qty',
                            'mr_potato_purchase_orders.unit',
                            'mr_potato_purchase_orders.price',
                            'mr_potato_purchase_orders.particulars',
                            'mr_potato_purchase_orders.amount',
                            'mr_potato_purchase_orders.total_price',
                            'mr_potato_purchase_orders.subtotal',
                            'mr_potato_purchase_orders.requested_by',
                            'mr_potato_purchase_orders.prepared_by',
                            'mr_potato_purchase_orders.checked_by',
                            'mr_potato_purchase_orders.created_by',
                            'mr_potato_purchase_orders.requesting_branch',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->join('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_purchase_orders.id', $id)
                            ->where('mr_potato_codes.module_name', $moduleNamePurchase)                                   
                            ->get();

        $pOrders = MrPotatoPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = MrPotatoPurchaseOrder::where('id', $id)->sum('price');

        //
        $countAmount = MrPotatoPurchaseOrder::where('po_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;


        $pdf = PDF::loadView('printMrPotatoPO', compact('purchaseOrder', 'pOrders', 'sum'));

        return $pdf->download('mr-potato-purchase-order.pdf');
    }

    //
    public function printPayables($id){
    
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->join('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.id', $id)
                            ->where('mr_potato_codes.module_name', $moduleName)
                            ->get();

       //getParticular details
       $getParticulars = MrPotatoPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
    
       $getChequeNumbers = MrPotatoPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

       $getCashAmounts = MrPotatoPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
       
       $amount1 = MrPotatoPaymentVoucher::where('id', $id)->sum('amount');
       $amount2 = MrPotatoPaymentVoucher::where('pv_id', $id)->sum('amount');
           
       $sum = $amount1 + $amount2;
       
       //
       $chequeAmount1 = MrPotatoPaymentVoucher::where('id', $id)->sum('cheque_amount');
       $chequeAmount2 = MrPotatoPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
       
       $sumCheque = $chequeAmount1 + $chequeAmount2;
       
         $pdf = PDF::loadView('printPayablesMrPotato',  compact('payableId',  
         'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));
        return $pdf->download('mr-potato-payment-voucher.pdf');
    }  

    //
    public function viewPayableDetails($id){

        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->join('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.id', $id)
                            ->where('mr_potato_codes.module_name', $moduleName)
                            ->get();


        //
        $getViewPaymentDetails = MrPotatoPaymentVoucher::where('pv_id', $id)->get()->toArray();

         //getParticular details
         $getParticulars = MrPotatoPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
       

        return view('view-mr-potato-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
    }

    //
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

                    $payables = MrPotatoPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = MrPotatoPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = MrPotatoPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = MrPotatoPaymentVoucher::find($id);

        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

        //get Category
        $cat = $particulars['category'];

        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $subAccountId = $particulars['sub_category_account_id'];

        $addParticulars = new MrPotatoPaymentVoucher([
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

        return redirect('mr-potato/edit-mr-potato-payables-detail/'.$id);
    }

    //
    public function addPayment(Request $request, $id){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = MrPotatoPaymentVoucher::find($id);

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');

        //save payment cheque num and cheque amount
        $addPayment = new MrPotatoPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'account_name_no'=>$request->get('accountNameNo'),
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

         $addPayment->save();

        //update the total cheque amount
        $paymentData->cheque_total_amount = $totalChequeAmount;
        $paymentData->save();
   

        Session::flash('paymentAdded', 'Payment added.');

        return redirect()->route('editPayablesDetailMrPotato', ['id'=>$id]);

    }

    //
    public function editPayablesDetail(Request $request, $id){

        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->leftjoin('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.id', $id)
                            ->where('mr_potato_codes.module_name', $moduleName)
                            ->get();

          //
        $getChequeNumbers = MrPotatoPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = MrPotatoPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
      
        //getParticular details
        $getParticulars = MrPotatoPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        //amount
        $amount1 = MrPotatoPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = MrPotatoPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;

        $chequeAmount1 = MrPotatoPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = MrPotatoPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('mr-potato-payables-detail', compact('transactionList', 'getChequeNumbers',
            'getParticulars', 'sum', 'sumCheque', 'getCashAmounts'));
    }

    //
    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'mr_potato_payment_vouchers')
                            ->select( 
                            'mr_potato_payment_vouchers.id',
                            'mr_potato_payment_vouchers.user_id',
                            'mr_potato_payment_vouchers.pv_id',
                            'mr_potato_payment_vouchers.date',
                            'mr_potato_payment_vouchers.paid_to',
                            'mr_potato_payment_vouchers.account_no',
                            'mr_potato_payment_vouchers.account_name',
                            'mr_potato_payment_vouchers.particulars',
                            'mr_potato_payment_vouchers.amount',
                            'mr_potato_payment_vouchers.method_of_payment',
                            'mr_potato_payment_vouchers.prepared_by',
                            'mr_potato_payment_vouchers.approved_by',
                            'mr_potato_payment_vouchers.date_apprroved',
                            'mr_potato_payment_vouchers.received_by_date',
                            'mr_potato_payment_vouchers.created_by',
                            'mr_potato_payment_vouchers.invoice_number',
                            'mr_potato_payment_vouchers.voucher_ref_number',
                            'mr_potato_payment_vouchers.issued_date',
                            'mr_potato_payment_vouchers.category',
                            'mr_potato_payment_vouchers.amount_due',
                            'mr_potato_payment_vouchers.delivered_date',
                            'mr_potato_payment_vouchers.status',
                            'mr_potato_payment_vouchers.cheque_number',
                            'mr_potato_payment_vouchers.cheque_amount',
                            'mr_potato_payment_vouchers.sub_category',
                            'mr_potato_payment_vouchers.sub_category_account_id',
                            'mr_potato_payment_vouchers.deleted_at',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->join('mr_potato_codes', 'mr_potato_payment_vouchers.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_payment_vouchers.pv_id', NULL)
                            ->where('mr_potato_codes.module_name', $moduleName)
                            ->where('mr_potato_payment_vouchers.deleted_at', NULL)
                            ->orderBy('mr_potato_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        
        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = MrPotatoPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('mr-potato-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));

    }


    //
    public function printDelivery($id){
       $moduleName = "Delivery Receipt";
       $deliveryId = DB::table(
                               'mr_potato_delivery_receipts')
                               ->select( 
                               'mr_potato_delivery_receipts.id',
                               'mr_potato_delivery_receipts.user_id',
                               'mr_potato_delivery_receipts.dr_id',
                               'mr_potato_delivery_receipts.delivered_to',
                               'mr_potato_delivery_receipts.date',
                               'mr_potato_delivery_receipts.address',
                               'mr_potato_delivery_receipts.product_id',
                               'mr_potato_delivery_receipts.unit',
                               'mr_potato_delivery_receipts.item_description',
                               'mr_potato_delivery_receipts.unit_price',
                               'mr_potato_delivery_receipts.amount',
                               'mr_potato_delivery_receipts.qty',
                               'mr_potato_delivery_receipts.prepared_by',
                               'mr_potato_delivery_receipts.checked_by',
                               'mr_potato_delivery_receipts.received_by',
                               'mr_potato_delivery_receipts.created_by',
                               'mr_potato_codes.mr_potato_code',
                               'mr_potato_codes.module_id',
                               'mr_potato_codes.module_code',
                               'mr_potato_codes.module_name')
                               ->join('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                               ->where('mr_potato_delivery_receipts.id', $id)
                               ->where('mr_potato_codes.module_name', $moduleName)
                               ->get();
     


        $deliveryReceipts = MrPotatoDeliveryReceipt::where('dr_id', $id)->get()->toArray();

          //count the total unit price
        $countTotalUnitPrice = MrPotatoDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = MrPotatoDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = MrPotatoDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = MrPotatoDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('mr-potato-printDelivery', compact('deliveryId', 'deliveryReceipts', 'sum'));

        return $pdf->download('mr-potato-delivery-receipt.pdf');
    }

    //
    public function viewSalesInvoice($id){

        $moduleName = "Sales Invoice";
        $viewSalesInvoice = DB::table(
                                'mr_potato_sales_invoices')
                                ->select(
                                    'mr_potato_sales_invoices.id',
                                    'mr_potato_sales_invoices.user_id',
                                    'mr_potato_sales_invoices.si_id',
                                    'mr_potato_sales_invoices.invoice_number',
                                    'mr_potato_sales_invoices.date',
                                    'mr_potato_sales_invoices.ordered_by',
                                    'mr_potato_sales_invoices.address',
                                    'mr_potato_sales_invoices.qty',
                                    'mr_potato_sales_invoices.total_kls',
                                    'mr_potato_sales_invoices.item_description',
                                    'mr_potato_sales_invoices.unit_price',
                                    'mr_potato_sales_invoices.amount',
                                    'mr_potato_sales_invoices.created_by',
                                    'mr_potato_sales_invoices.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                ->join('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_sales_invoices.id', $id)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->get();

        $salesInvoices = MrPotatoSalesInvoice::where('si_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = MrPotatoSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = MrPotatoSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-mr-potato-sales-invoice', compact('viewSalesInvoice', 'salesInvoices', 'sum'));
    }

    //
    public function updateSi(Request $request, $id){
        $updateSi = MrPotatoSalesInvoice::find($id);

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

        return redirect('mr-potato/edit-mr-potato-sales-invoice/'.$request->get('siId'));
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

        $salesInvoiceData = MrPotatoSalesInvoice::find($id);
        $getCurrentTotal = $salesInvoiceData->total_amount + $sum;
    

        $addNewSalesInvoice = new MrPotatoSalesInvoice([
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

        $salesInvoiceData->total_amount = $getCurrentTotal;
        $salesInvoiceData->save();


        Session::flash('addSalesInvoiceSuccess', 'Successfully added.');

        return redirect('mr-potato/add-new-mr-potato-sales-invoice/'.$id);
    }

    //
    public function addNewSalesInvoice($id){
    
        return view('add-new-mr-potato-sales-invoice', compact('id'));
    }

    //
    public function updateSalesInvoice(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $updateSalesInvoice = MrPotatoSalesInvoice::find($id);

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

         return redirect('mr-potato/edit-mr-potato-sales-invoice/'.$id);
    } 

    //]
    public function editSalesInvoice($id){
    
         //getSalesInvoice
        $getSalesInvoice = MrPotatoSalesInvoice::find($id);

        $sInvoices  = MrPotatoSalesInvoice::where('si_id', $id)->get()->toArray();
    
        return view('edit-mr-potato-sales-invoice', compact('getSalesInvoice', 'sInvoices'));
    }

    //store sales invoice form
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

         //get the latest insert id query in table mr_potato_code
         $dataSalesNo = DB::select('SELECT id, mr_potato_code FROM mr_potato_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 dr_no
         if(isset($dataSalesNo[0]->mr_potato_code) != 0){
             //if code is not 0
             $newSI = $dataSalesNo[0]->mr_potato_code +1;
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

        $addSalesInvoice = new MrPotatoSalesInvoice([
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

        $mrPotato = new MrPotatoCode([
            'user_id'=>$user->id,
            'mr_potato_code'=>$uSI,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);

        $mrPotato->save();

        return redirect()->route('editSalesInvoiceMrPotato', ['id'=>$insertedId]);

    }

    //sales invoice form
    public function salesInvoiceForm(){

        return view('mr-potato-sales-invoice-form');
    }                                                   

    //
    public function chequeVouchers(){

        //getAllChequeVouchers
        $method = "Cheque";

        $getAllChequeVouchers = MrPotatoPaymentVoucher::where('method_of_payment', $method)->get()->toArray(); 

        return view('cheque-vouchers-lists-mr-potato', compact('getAllChequeVouchers')); 
    }

    //
    public function cashVouchers(){
    
         //getAllCashVouchers
        $method = "Cash";

        $getAllCashVouchers = MrPotatoPaymentVoucher::where('method_of_payment', $method)->get()->toArray();

        return view('cash-vouchers-list-mr-potato', compact('getAllCashVouchers'));

    }

    //
    public function updatePV(Request $request, $id){
         $updatePV = MrPotatoPaymentVoucher::find($id);

        $updatePV->particulars = $request->get('particulars');
        $updatePV->amount = $request->get('amount');

        $updatePV->save();

        Session::flash('SuccessEdit', 'Successfully updated');

         return redirect('mr-potato/edit-mr-potato-payment-voucher/'.$request->get('pvId'));
    }

    //
    public function addNewPaymentVoucherData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentVoucher = MrPotatoPaymentVoucher::find($id);

         $addNewPaymentVoucherData = new MrPotatoPaymentVoucher([
             'user_id'=>$user->id,
            'pv_id'=>$id,
            'reference_number'=>$paymentVoucher['reference_number'],
            'particulars'=>$request->get('particulars'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewPaymentVoucherData->save();

        Session::flash('addPaymentVoucherSuccess', 'Successfully added.');
        
        return redirect('mr-potato/add-new-mr-potato-payment-voucher/'.$id);
    }


    //
    public function addNewPaymentVoucher($id){
      
        return view('add-new-mr-potato-payment-voucher', compact('id'));
    }


    //updatePaymentVoucher
    public function updatePaymentVoucher(Request $request, $id){
        $updatePaymentVoucher = MrPotatoPaymentVoucher::find($id);

        $updatePaymentVoucher->paid_to = $request->get('paidTo');
        $updatePaymentVoucher->account_no = $request->get('accountNumber');
        $updatePaymentVoucher->date = $request->get('date');
        $updatePaymentVoucher->particulars = $request->get('particulars');
        $updatePaymentVoucher->amount = $request->get('amount');
        $updatePaymentVoucher->method_of_payment = $request->get('methodOfPayment');

        $updatePaymentVoucher->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('mr-potato/edit-mr-potato-payment-voucher/'.$id);

    }


    public function editPaymentVoucher($id){    
          //getPaymentVoucher 
        $getPaymentVoucher = MrPotatoPaymentVoucher::find($id);

        //pVoucher
        $pVouchers = MrPotatoPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('edit-payment-voucher-mr-potato', compact('getPaymentVoucher', 'pVouchers'));
    }

    //store voucher
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

         //get the latest insert id query in table mr potato code
        $dataVoucherRef = DB::select('SELECT id, mr_potato_code FROM mr_potato_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->mr_potato_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->mr_potato_code +1;
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
        }else if($request->get('category') == "Utilities"){
            $subCat = $request->get('bills');
            $subCatAcctId = $request->get('selectAccountID');
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') == "None"){
            $subCat = NULL;
            $subCatAcctId = NULL;
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') == "Payroll"){
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
                        'mr_potato_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...
              $addPaymentVoucher = new MrPotatoPaymentVoucher([
                    'user_id'=>$user->id,
                    'paid_to'=>$request->get('paidTo'),
                    'invoice_number'=>$request->get('invoiceNumber'),
                    'account_name'=>$request->get('accountName'),
                    'method_of_payment'=>$request->get('paymentMethod'),
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

                $mrPotato = new MrPotatoCode([
                    'user_id'=>$user->id,
                    'mr_potato_code'=>$uVoucher,
                    'module_id'=>$insertedId,
                    'module_code'=>$moduleCode,
                    'module_name'=>$moduleName,
                ]);

                $mrPotato->save();

                 return redirect()->route('editPayablesDetailMrPotato', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormMrPotato')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    
    }

    //
    public function paymentVoucherForm(){
        $getAllFlags = MrPotatoUtility::where('u_id', NULL)->get()->toArray();

         //get suppliers
         $suppliers = MrPotatoSupplier::get()->toArray();

         $pettyCashes = MrPotatoPettyCash::with(['user', 'petty_cashes'])
                                                            ->where('pc_id', NULL)
                                                            ->where('deleted_at', NULL)
                                                            ->get();



        return view('payment-voucher-form-mr-potato', compact('getAllFlags', 'suppliers', 'pettyCashes'));
    }

    //
    public function viewDeliveryReceipt($id){
       $moduleName = "Delivery Receipt";
        $viewDeliveryReceipt = DB::table(
                                'mr_potato_delivery_receipts')
                                ->select( 
                                'mr_potato_delivery_receipts.id',
                                'mr_potato_delivery_receipts.user_id',
                                'mr_potato_delivery_receipts.dr_id',
                                'mr_potato_delivery_receipts.delivered_to',
                                'mr_potato_delivery_receipts.date',
                                'mr_potato_delivery_receipts.address',
                                'mr_potato_delivery_receipts.product_id',
                                'mr_potato_delivery_receipts.unit',
                                'mr_potato_delivery_receipts.item_description',
                                'mr_potato_delivery_receipts.unit_price',
                                'mr_potato_delivery_receipts.amount',
                                'mr_potato_delivery_receipts.qty',
                                'mr_potato_delivery_receipts.prepared_by',
                                'mr_potato_delivery_receipts.checked_by',
                                'mr_potato_delivery_receipts.received_by',
                                'mr_potato_delivery_receipts.created_by',
                                'mr_potato_delivery_receipts.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->join('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_delivery_receipts.id', $id)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->get();
      

        $deliveryReceipts = MrPotatoDeliveryReceipt::where('dr_id', $id)->get()->toArray();

         //count the total unit price
        $countTotalUnitPrice = MrPotatoDeliveryReceipt::where('id', $id)->sum('unit_price');
       
        //
        $countUnitPrice = MrPotatoDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


          //count the total amount
        $countTotalAmount = MrPotatoDeliveryReceipt::where('id', $id)->sum('amount');
       
        //
        $countAmount = MrPotatoDeliveryReceipt::where('dr_id', $id)->sum('amount');

        $sum2  = $countTotalAmount + $countAmount;

        return view('view-mr-potato-delivery-receipt', compact('viewDeliveryReceipt', 'deliveryReceipts', 'countUnit', 'sum', 'sum2'));
    }

    //
    public function deliveryReceiptList(){
        $moduleName = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'mr_potato_delivery_receipts')
                                ->select( 
                                'mr_potato_delivery_receipts.id',
                                'mr_potato_delivery_receipts.user_id',
                                'mr_potato_delivery_receipts.dr_id',
                                'mr_potato_delivery_receipts.delivered_to',
                                'mr_potato_delivery_receipts.date',
                                'mr_potato_delivery_receipts.address',
                                'mr_potato_delivery_receipts.product_id',
                                'mr_potato_delivery_receipts.unit',
                                'mr_potato_delivery_receipts.item_description',
                                'mr_potato_delivery_receipts.unit_price',
                                'mr_potato_delivery_receipts.amount',
                                'mr_potato_delivery_receipts.qty',
                                'mr_potato_delivery_receipts.prepared_by',
                                'mr_potato_delivery_receipts.checked_by',
                                'mr_potato_delivery_receipts.received_by',
                                'mr_potato_delivery_receipts.created_by',
                                'mr_potato_delivery_receipts.deleted_at',
                                'mr_potato_codes.mr_potato_code',
                                'mr_potato_codes.module_id',
                                'mr_potato_codes.module_code',
                                'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_delivery_receipts.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_delivery_receipts.dr_id', NULL)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->where('mr_potato_delivery_receipts.deleted_at', NULL)
                                ->orderBy('mr_potato_delivery_receipts.id', 'desc')
                                ->get()->toArray();
      

        return view('mr-potato-delivery-receipt-list', compact('getAllDeliveryReceipts'));
    }

    //
    public function updateDr(Request $request, $id){
        $delivery = MrPotatoDeliveryReceipt::find($id);

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

        return redirect('mr-potato/edit-mr-potato-delivery-receipt/'.$request->get('drId'));

    }

    //
    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $deliveryReceipt = MrPotatoDeliveryReceipt::find($id);
        $getCurrentAmount = $deliveryReceipt->total_amount + $sum;

         //get date today
        $getDateToday =  date('Y-m-d');

          $addNewDeliveryReceipt = new MrPotatoDeliveryReceipt([
            'user_id'=>$user->id,
            'dr_id'=>$id,
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

        $deliveryReceipt->total_amount = $getCurrentAmount;
        $deliveryReceipt->save();

        Session::flash('addDeliveryReceiptSuccess', 'Successfully added.');

        return redirect('mr-potato/add-new-delivery-receipt/'.$id);

    }

    //add new
    public function addNewDelivery($id){
        return view('add-new-mr-potato-delivery-receipt', compact('id'));
    }

    //update 
    public function updateDeliveryReceipt(Request $request, $id){
        $updateDeliveryReceipt = MrPotatoDeliveryReceipt::find($id);

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

         return redirect('mr-potato/edit-mr-potato-delivery-receipt/'.$id);

    }

    public function editDeliveryReceipt($id){
        
        //getDeliveryReceipt
        $getDeliveryReceipt = MrPotatoDeliveryReceipt::find($id);

         //dReceipts
        $dReceipts = MrPotatoDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-mr-potato-delivery-receipt', compact('getDeliveryReceipt', 'dReceipts'));
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


         //get the latest insert id query in table mr potato codes
        $dataDrNo = DB::select('SELECT id, mr_potato_code FROM mr_potato_codes ORDER BY id DESC LIMIT 1');
        
         //if code is not zero add plus 1 dr_no
        if(isset($dataDrNo[0]->mr_potato_code) != 0){
            //if code is not 0
            $newDr = $dataDrNo[0]->mr_potato_code +1;
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

        $storeDeliveryReceipt = new MrPotatoDeliveryReceipt([
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
            'total_amount'=>$sum,
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $storeDeliveryReceipt->save();

        $insertedId  = $storeDeliveryReceipt->id;

        $moduleCode = "DR-";
        $moduleName = "Delivery Receipt";
        
        $mrPotato = new MrPotatoCode([
            'user_id'=>$user->id,
            'mr_potato_code'=>$uDr,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);

        $mrPotato->save();

        return redirect()->route('editDeliveryReceiptMrPotato', ['id'=>$insertedId]);
    
    }

    public function deliveryReceiptForm(){
        return view('mr-potato-delivery-receipt-form');
    }

    //purchase order all lists
    public function purchaseOrderAllLists(){
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                        'mr_potato_purchase_orders')
                        ->select(
                            'mr_potato_purchase_orders.id',
                            'mr_potato_purchase_orders.user_id',
                            'mr_potato_purchase_orders.po_id',
                            'mr_potato_purchase_orders.paid_to',
                            'mr_potato_purchase_orders.branch_location',
                            'mr_potato_purchase_orders.address',
                            'mr_potato_purchase_orders.date',
                            'mr_potato_purchase_orders.quantity',
                            'mr_potato_purchase_orders.description',
                            'mr_potato_purchase_orders.unit_price',
                            'mr_potato_purchase_orders.amount',
                            'mr_potato_purchase_orders.total_price',
                            'mr_potato_purchase_orders.requested_by',
                            'mr_potato_purchase_orders.prepared_by',
                            'mr_potato_purchase_orders.checked_by',
                            'mr_potato_purchase_orders.created_by',
                            'mr_potato_purchase_orders.deleted_at',
                            'mr_potato_purchase_orders.requesting_branch',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->join('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_purchase_orders.po_id', NULL)
                            ->where('mr_potato_codes.module_name', $moduleNamePurchase)   
                            ->where('mr_potato_purchase_orders.deleted_at', NULL)                                
                            ->orderBy('mr_potato_purchase_orders.id', 'desc')
                            ->get()->toArray();

        return view('mr-potato-purchase-order-lists', compact('purchaseOrders')); 
    }

    //update Po
    public function updatePo(Request $request, $id){
        $order = MrPotatoPurchaseOrder::find($id);
        
        $order->particulars = $request->get('particulars');
        $order->qty = $request->get('qty');
        $order->unit = $request->get('unit');
        $order->price = $request->get('price');
        $order->subtotal = $request->get('subtotal');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');

        return redirect('mr-potato/edit-mr-potato-purchase-order/'.$request->get('poId'));
    }

  
    //add new pO
    public function addNew(Request $request, $id){

        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

         //
         $this->validate($request, [
            'price'=>'required',
        ]);

        $pO = MrPotatoPurchaseOrder::find($id);

        $addNewParticulars = new MrPotatoPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'particulars'=>$request->get('particulars'),
            'qty'=>$request->get('qty'),
            'unit'=>$request->get('unit'),
            'price'=>$request->get('price'),
            'subtotal'=>$request->get('subtotal'),
            'created_by'=>$name,
        ]);

        $addNewParticulars->save();

        Session::flash('addNewSuccess', 'Successfully added');

        return redirect('mr-potato/edit-mr-potato-purchase-order/'.$id);

    }

    //purchase order
    public function purchaseOrder(){

        return view('mr-potato-purchase-order');
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
                                'mr_potato_sales_invoices')
                                ->select(
                                    'mr_potato_sales_invoices.id',
                                    'mr_potato_sales_invoices.user_id',
                                    'mr_potato_sales_invoices.si_id',
                                    'mr_potato_sales_invoices.invoice_number',
                                    'mr_potato_sales_invoices.date',
                                    'mr_potato_sales_invoices.ordered_by',
                                    'mr_potato_sales_invoices.address',
                                    'mr_potato_sales_invoices.qty',
                                    'mr_potato_sales_invoices.total_kls',
                                    'mr_potato_sales_invoices.item_description',
                                    'mr_potato_sales_invoices.unit_price',
                                    'mr_potato_sales_invoices.amount',
                                    'mr_potato_sales_invoices.created_by',
                                    'mr_potato_sales_invoices.deleted_at',
                                    'mr_potato_codes.mr_potato_code',
                                    'mr_potato_codes.module_id',
                                    'mr_potato_codes.module_code',
                                    'mr_potato_codes.module_name')
                                ->leftJoin('mr_potato_codes', 'mr_potato_sales_invoices.id', '=', 'mr_potato_codes.module_id')
                                ->where('mr_potato_sales_invoices.si_id', NULL)
                                ->orderBy('mr_potato_sales_invoices.id', 'desc')
                                ->where('mr_potato_sales_invoices.deleted_at', NULL)
                                ->where('mr_potato_codes.module_name', $moduleName)
                                ->get()->toArray();
       
        return view('mr-potato', compact('getAllSalesInvoices'));
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
            'branchLocation' => 'required',
            'orderedBy'=> 'required',
            'unit'=>'required',
            'price'=>'required',
        ]);

        //get the latest insert id query in mr potato code
        $data = DB::select('SELECT id, mr_potato_code FROM mr_potato_codes ORDER BY id DESC LIMIT 1');


         //if code is not zero add plus 1
         if(isset($data[0]->mr_potato_code) != 0){
            //if code is not 0
            $newNum = $data[0]->mr_potato_code +1;
            $uNum = sprintf("%06d",$newNum);    
        }else{
            //if code is 0 
            $newNum = 1;
            $uNum = sprintf("%06d",$newNum);
        }

        $purchaseOrder = new MrPotatoPurchaseOrder([
            'user_id' =>$user->id,
            'branch_location'=>$request->get('branchLocation'),
            'date'=>$request->get('date'),
            'ordered_by'=>$request->get('orderedBy'),
            'particulars'=>$request->get('particulars'),
            'qty'=>$request->get('qty'),
            'unit'=>$request->get('unit'),
            'price'=>$request->get('price'),
            'subtotal'=>$request->get('subtotal'),
            'prepared_by'=>$name,
            'created_by'=>$name,
        ]);

        $purchaseOrder->save();

        $insertedId = $purchaseOrder->id;

        $moduleCode = "PO-";
        $moduleName = "Purchase Order";
        
        $mrPotato = new MrPotatoCode([
            'user_id'=>$user->id,
            'mr_potato_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        
        $mrPotato->save();

        return redirect('mr-potato/edit-mr-potato-purchase-order/'.$insertedId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrder = DB::table(
                        'mr_potato_purchase_orders')
                        ->select(
                            'mr_potato_purchase_orders.id',
                            'mr_potato_purchase_orders.user_id',
                            'mr_potato_purchase_orders.po_id',
                            'mr_potato_purchase_orders.paid_to',
                            'mr_potato_purchase_orders.branch_location',
                            'mr_potato_purchase_orders.address',
                            'mr_potato_purchase_orders.date',
                            'mr_potato_purchase_orders.quantity',
                            'mr_potato_purchase_orders.description',
                            'mr_potato_purchase_orders.unit_price',
                            'mr_potato_purchase_orders.ordered_by',
                            'mr_potato_purchase_orders.qty',
                            'mr_potato_purchase_orders.unit',
                            'mr_potato_purchase_orders.price',
                            'mr_potato_purchase_orders.particulars',
                            'mr_potato_purchase_orders.amount',
                            'mr_potato_purchase_orders.total_price',
                            'mr_potato_purchase_orders.subtotal',
                            'mr_potato_purchase_orders.requested_by',
                            'mr_potato_purchase_orders.prepared_by',
                            'mr_potato_purchase_orders.checked_by',
                            'mr_potato_purchase_orders.created_by',
                            'mr_potato_purchase_orders.deleted_at',
                            'mr_potato_purchase_orders.requesting_branch',
                            'mr_potato_codes.mr_potato_code',
                            'mr_potato_codes.module_id',
                            'mr_potato_codes.module_code',
                            'mr_potato_codes.module_name')
                            ->leftJoin('mr_potato_codes', 'mr_potato_purchase_orders.id', '=', 'mr_potato_codes.module_id')
                            ->where('mr_potato_purchase_orders.id', $id)
                            ->where('mr_potato_codes.module_name', $moduleNamePurchase)                                   
                            ->get();



        //
        $pOrders = MrPotatoPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = MrPotatoPurchaseOrder::where('id', $id)->sum('price');

        //
        $countAmount = MrPotatoPurchaseOrder::where('po_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;

         return view('view-mr-potato-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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

        $purchaseOrder = MrPotatoPurchaseOrder::find($id);

        $pOrders = MrPotatoPurchaseOrder::where('po_id', $id)->get()->toArray();

         return view('edit-mr-potato-purchase-order', compact('purchaseOrder', 'pOrders'));
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

        $purchaseOrder = MrPotatoPurchaseOrder::find($id);

        $purchaseOrder->branch_location = $request->get('branchLocation');
        $purchaseOrder->date = $request->get('date');
        $purchaseOrder->ordered_by = $request->get('orderedBy');
        $purchaseOrder->particulars = $request->get('particulars');
        $purchaseOrder->qty = $request->get('qty');
        $purchaseOrder->unit = $request->get('unit');
        $purchaseOrder->price = $request->get('price');
        $purchaseOrder->subtotal = $request->get('subtotal');
 
        $purchaseOrder->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect('mr-potato/edit-mr-potato-purchase-order/'.$id);
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
        $purchaseOrder = MrPotatoPurchaseOrder::find($id);
        $purchaseOrder->delete();
    }


    public function destroyDeliveryReceipt(Request $request, $id){
        $drId = MrPotatoDeliveryReceipt::find($request->drId);

        $deliveryReceipt = MrPotatoDeliveryReceipt::find($id);
        $getAmount = $drId->total_amount - $deliveryReceipt->amount;

        $drId->total_amount = $getAmount;
        $drId->save();

        $deliveryReceipt->delete();
    }

    public function destroyDR($id){

        $deliveryReceipt = MrPotatoDeliveryReceipt::find($id);
        $deliveryReceipt->delete();
    }

    public function destroyPaymentVoucher($id){
        $paymentVoucher = MrPotatoPaymentVoucher::find($id);
        $paymentVoucher->delete();
    }

    public function destroySalesInvoice(Request $request, $id){
        $siId = MrPotatoSalesInvoice::find($request->siId);
      
        $salesInvoice = MrPotatoSalesInvoice::find($id);
        $getAmount = $siId->total_amount - $salesInvoice->amount;
       
        $siId->total_amount = $getAmount;
        $siId->save();

        $salesInvoice->delete();
    }

    public function destroySI($id){
        $salesInvoice = MrPotatoSalesInvoice::find($id);
        $salesInvoice->delete();
    }

    public function destroyTransactionList($id){
        $transactionList = MrPotatoPaymentVoucher::find($id);
        $transactionList->delete();
    }

    public function destroyPettyCash($id){
        $pettyCash = MrPotatoPettyCash::find($id);
        $pettyCash->delete();
    }
}
