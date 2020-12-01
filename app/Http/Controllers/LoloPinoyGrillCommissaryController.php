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
use App\LoloPinoyGrillCommissaryRawMaterialProduct;
use App\LoloPinoyGrillCommissaryUtility;
use App\LoloPinoyGrillCommissaryPettyCash;
use App\LoloPinoyGrillCommissaryCode;
use App\LoloPinoyGrillBranchesSalesForm;
use App\LoloPinoyGrillCommissarySupplier;

class LoloPinoyGrillCommissaryController extends Controller
{

    public function printStockInventory(){
        $getStockInventories = DB::table(
                    'lolo_pinoy_grill_commissary_raw_materials')
                    ->select(
                        'lolo_pinoy_grill_commissary_raw_materials.id',
                        'lolo_pinoy_grill_commissary_raw_materials.user_id',
                        'lolo_pinoy_grill_commissary_raw_materials.rm_id',
                        'lolo_pinoy_grill_commissary_raw_materials.product_name',
                        'lolo_pinoy_grill_commissary_raw_materials.unit_price',
                        'lolo_pinoy_grill_commissary_raw_materials.unit',
                        'lolo_pinoy_grill_commissary_raw_materials.in',
                        'lolo_pinoy_grill_commissary_raw_materials.out',
                        'lolo_pinoy_grill_commissary_raw_materials.stock_amount',
                        'lolo_pinoy_grill_commissary_raw_materials.remaining_stock',
                        'lolo_pinoy_grill_commissary_raw_materials.amount',
                        'lolo_pinoy_grill_commissary_raw_materials.supplier',
                        'lolo_pinoy_grill_commissary_raw_materials.date',
                        'lolo_pinoy_grill_commissary_raw_materials.item',
                        'lolo_pinoy_grill_commissary_raw_materials.description',
                        'lolo_pinoy_grill_commissary_raw_materials.reference_no',
                        'lolo_pinoy_grill_commissary_raw_materials.qty',
                        'lolo_pinoy_grill_commissary_raw_materials.requesting_branch',
                        'lolo_pinoy_grill_commissary_raw_materials.cheque_no_issued',
                        'lolo_pinoy_grill_commissary_raw_materials.status',
                        'lolo_pinoy_grill_commissary_raw_materials.created_by',
                        'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id',
                        'lolo_pinoy_grill_commissary_raw_material_products.branch',
                        'lolo_pinoy_grill_commissary_raw_material_products.product_id_no')
                    ->join('lolo_pinoy_grill_commissary_raw_material_products', 'lolo_pinoy_grill_commissary_raw_materials.id', '=', 'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id')
                    ->where('lolo_pinoy_grill_commissary_raw_materials.rm_id', NULL)
                    ->orderBy('lolo_pinoy_grill_commissary_raw_materials.id', 'desc')
                    ->get()->toArray();

        //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryRawMaterial::all()->sum('amount');

        $pdf = PDF::loadView('printStocksInventoryLoloPinoyGrillCommissary', compact('getStockInventories','countTotalAmount'));

        return $pdf->download('lolo-pinoy-grill-commissary-stock-inventory.pdf');
                        
        

    }

    public function printSOALists(){
        $moduleName = "Statement Of Account";
        $printSOAStatements = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->orderBy('lolo_pinoy_grill_commissary_statement_of_accounts.id', 'desc')
                        ->get()->toArray();

        $status = "PAID";
        $totalAmount = DB::table(
                                'lolo_pinoy_grill_commissary_statement_of_accounts')
                                ->select(
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->where('lolo_pinoy_grill_commissary_statement_of_accounts.status', $status)
                                ->sum('lolo_pinoy_grill_commissary_statement_of_accounts.total_amount');
        
            $totalRemainingBalance = DB::table(
                                    'lolo_pinoy_grill_commissary_statement_of_accounts')
                                    ->select(
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                                        'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                        'lolo_pinoy_grill_commissary_codes.module_id',
                                        'lolo_pinoy_grill_commissary_codes.module_code',
                                        'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                    ->where('lolo_pinoy_grill_commissary_statement_of_accounts.status', NULL)
                                    ->sum('lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance');
        
        $pdf = PDF::loadView('printSOAListsLoloPinoyGrillCommissary', compact('printSOAStatements', 'totalAmount', 'totalRemainingBalance'));

        return $pdf->download('lolo-pinoy-grill-commissary-statement-of-account-list.pdf');
    }

    public function printSupplier($id){
        $viewSupplier = LoloPinoyGrillCommissarySupplier::where('id', $id)->get();

        $printSuppliers = DB::table(
                    'lolo_pinoy_grill_commissary_payment_vouchers')
                    ->select( 
                    'lolo_pinoy_grill_commissary_payment_vouchers.id',
                    'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                    'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                    'lolo_pinoy_grill_commissary_payment_vouchers.date',
                    'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                    'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                    'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                    'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                    'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                    'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                    'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                    'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                    'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                    'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                    'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                    'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                    'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                    'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                    'lolo_pinoy_grill_commissary_payment_vouchers.category',
                    'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                    'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                    'lolo_pinoy_grill_commissary_payment_vouchers.status',
                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                    'lolo_pinoy_grill_commissary_payment_vouchers.supplier_name',
                    'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                    'lolo_pinoy_grill_commissary_suppliers.id',
                    'lolo_pinoy_grill_commissary_suppliers.date',
                    'lolo_pinoy_grill_commissary_suppliers.supplier_name')
                    ->leftJoin('lolo_pinoy_grill_commissary_suppliers', 'lolo_pinoy_grill_commissary_payment_vouchers.supplier_id', '=', 'lolo_pinoy_grill_commissary_suppliers.id')
                    ->where('lolo_pinoy_grill_commissary_suppliers.id', $id)
                    ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_commissary_payment_vouchers.id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.status',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.supplier_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.supplier_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_commissary_suppliers.id',
                        'lolo_pinoy_grill_commissary_suppliers.date',
                        'lolo_pinoy_grill_commissary_suppliers.supplier_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_suppliers', 'lolo_pinoy_grill_commissary_payment_vouchers.supplier_id', '=', 'lolo_pinoy_grill_commissary_suppliers.id')
                        ->where('lolo_pinoy_grill_commissary_suppliers.id', $id)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                        ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSupplierLoloPinoyGrillCommissary', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('lolo-pinoy-grill-commissary-supplier.pdf');
    }

    public function viewSupplier($id){
        $viewSupplier = LoloPinoyGrillCommissarySupplier::where('id', $id)->get();

        $supplierLists = DB::table(
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_commissary_payment_vouchers.id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.status',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.supplier_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                       
                        'lolo_pinoy_grill_commissary_suppliers.date',
                        'lolo_pinoy_grill_commissary_suppliers.supplier_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_suppliers', 'lolo_pinoy_grill_commissary_payment_vouchers.supplier_id', '=', 'lolo_pinoy_grill_commissary_suppliers.id')
                        ->where('lolo_pinoy_grill_commissary_suppliers.id', $id)
                        ->get();
        
        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.supplier_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.supplier_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_suppliers.id',
                            'lolo_pinoy_grill_commissary_suppliers.date',
                            'lolo_pinoy_grill_commissary_suppliers.supplier_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_suppliers', 'lolo_pinoy_grill_commissary_payment_vouchers.supplier_id', '=', 'lolo_pinoy_grill_commissary_suppliers.id')
                            ->where('lolo_pinoy_grill_commissary_suppliers.id', $id)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                            ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        return view('view-lolo-pinoy-grill-commissary-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue'));
    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //check if supplier name exits
         $target = DB::table(
                    'lolo_pinoy_grill_commissary_suppliers')
                    ->where('supplier_name', $request->supplierName)
                    ->get()->first();

        if($target === NULL){
            $supplier = new LoloPinoyGrillCommissarySupplier([
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
        $suppliers = LoloPinoyGrillCommissarySupplier::orderBy('id', 'desc')->get()->toArray();

        return view('lolo-pinoy-grill-commissary-supplier', compact('suppliers'));
    }

    public function viewPerBranch(){
        $baniladBranch = "LOLO PINOY GRILL BANILAD BRANCH";
        $moduleName = "Delivery Receipt";
        $getBaniladBranches = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.delivered_to', $baniladBranch)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();

        $velezBranch = "LOLO PINOY GRILL VELEZ BRANCH";
        $getVelezBranches = DB::table(
                            'lolo_pinoy_grill_commissary_delivery_receipts')
                            ->select( 
                            'lolo_pinoy_grill_commissary_delivery_receipts.id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.address',
                            'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                            'lolo_pinoy_grill_commissary_delivery_receipts.date',
                            'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                            'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                            'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                            'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                            'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                            'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.delivered_to', $velezBranch)
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                            ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                            ->get()->toArray();

        $gqsBranch = "LOLO PINOY GRILL GQS BRANCH";
        $getGqsBranches = DB::table(
                            'lolo_pinoy_grill_commissary_delivery_receipts')
                            ->select( 
                            'lolo_pinoy_grill_commissary_delivery_receipts.id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.address',
                            'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                            'lolo_pinoy_grill_commissary_delivery_receipts.date',
                            'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                            'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                            'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                            'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                            'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                            'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.delivered_to', $gqsBranch)
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                            ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                            ->get()->toArray();

        $urgelloBranch = "LOLO PINOY GRILL URGELLO BRANCH";
        $getUrgelloBranches = DB::table(
                            'lolo_pinoy_grill_commissary_delivery_receipts')
                            ->select( 
                            'lolo_pinoy_grill_commissary_delivery_receipts.id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.address',
                            'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                            'lolo_pinoy_grill_commissary_delivery_receipts.date',
                            'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                            'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                            'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                            'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                            'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                            'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.delivered_to', $urgelloBranch)
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                            ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                            ->get()->toArray();

        return view('lolo-pinoy-grill-commissary-view-per-branch', compact('getBaniladBranches', 
        'getVelezBranches', 'getGqsBranches', 'getUrgelloBranches'));
    }

    public function updateDetails(Request $request){
        $updateDetail = LoloPinoyGrillCommissaryPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }   

    public function updateCash(Request $request){
        $updateCash = LoloPinoyGrillCommissaryPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = LoloPinoyGrillCommissaryPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
         //main id 
         $updateParticular = LoloPinoyGrillCommissaryPaymentVoucher::find($request->transId);

         //particular id
         $uIdParticular = LoloPinoyGrillCommissaryPaymentVoucher::find($request->id);

         $amount = $request->amount; 

         $updateAmount =  $updateParticular->amount; 
        
         $uParticular = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
         
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
        $updateParticular =  LoloPinoyGrillCommissaryPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 
 
        $updateParticular->date = $request->date;
        $updateParticular->invoice_number = $request->invoiceNo;
        $updateParticular->particulars = $request->particulars;
        $updateParticular->amount = $amount;
        $updateParticular->amount_due = $sum;
        $updateParticular->save();
 
        return response()->json('Success: successfully updated.');
    }

    public function printMultipleSummary(Request $request, $date) {
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices  = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->whereBetween('lolo_pinoy_grill_commissary_sales_invoices.created_at', [$uri0, $uri1])
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->get()->toArray();
            
            $totalSalesInvoice  = DB::table(
                                    'lolo_pinoy_grill_commissary_sales_invoices')
                                    ->select(
                                        'lolo_pinoy_grill_commissary_sales_invoices.id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                        'lolo_pinoy_grill_commissary_sales_invoices.date',
                                        'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.address',
                                        'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                        'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                        'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                        'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                        'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                        'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                        'lolo_pinoy_grill_commissary_codes.module_id',
                                        'lolo_pinoy_grill_commissary_codes.module_code',
                                        'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                    ->whereBetween('lolo_pinoy_grill_commissary_sales_invoices.created_at', [$uri0, $uri1])    
                                    ->sum('lolo_pinoy_grill_commissary_sales_invoices.amount');
        
        //Delivery Receipt  
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                ->whereBetween('lolo_pinoy_grill_commissary_delivery_receipts.created_at', [$uri0, $uri1]) 
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
    
            $totalDeliveryReceipt = DB::table(
                                    'lolo_pinoy_grill_commissary_delivery_receipts')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                    ->whereBetween('lolo_pinoy_grill_commissary_delivery_receipts.created_at', [$uri0, $uri1]) 
                               
                                    ->sum('lolo_pinoy_grill_commissary_delivery_receipts.total_amount');
        
        //purchase order
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                            ->whereBetween('lolo_pinoy_grill_commissary_purchase_orders.created_at', [$uri0, $uri1]) 
                            ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                            ->get()->toArray();
        
        $totalPOrder = DB::table(
                                'lolo_pinoy_grill_commissary_purchase_orders')
                                ->select(
                                    'lolo_pinoy_grill_commissary_purchase_orders.id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                                    'lolo_pinoy_grill_commissary_purchase_orders.address',
                                    'lolo_pinoy_grill_commissary_purchase_orders.date',
                                    'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                                    'lolo_pinoy_grill_commissary_purchase_orders.description',
                                    'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.amount',
                                    'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                                    ->whereBetween('lolo_pinoy_grill_commissary_purchase_orders.created_at', [$uri0, $uri1])                                    
                                    ->sum('lolo_pinoy_grill_commissary_purchase_orders.total_price');
    
        //


        $moduleNamePettyCash = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',   
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_at',
                                'lolo_pinoy_grill_commissary_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePettyCash)
                                ->whereBetween('lolo_pinoy_grill_commissary_petty_cashes.created_at', [$uri0, $uri1])                                    
                                                                   
                                ->orderBy('lolo_pinoy_grill_commissary_codes.id', 'desc')
                                ->get()->toArray();

        $moduleNamePaymentVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$uri0, $uri1])                                  
                                ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                ->get()->toArray();
                        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                                    'lolo_pinoy_grill_commissary_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                    ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$uri0, $uri1])                                    
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                    ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                    ->get()->toArray();      

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$uri0, $uri1])                                    
                                   
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                            ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$uri0, $uri1])                                                           
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                            ->get()->toArray();  


        $totalAmountCheck = DB::table(
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_commissary_payment_vouchers.id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                        'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.status',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                        'lolo_pinoy_grill_commissary_codes.module_id',
                        'lolo_pinoy_grill_commissary_codes.module_code',
                        'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                        ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$uri0, $uri1])                                    
                                                                  
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                        ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        //total paid amount check
        $totalPaidAmountCheck = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                            ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$uri0, $uri1])                                    
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', $status)
                            ->sum('lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount');
                    
        $pdf = PDF::loadView('printSummaryLoloPinoyGrill',  compact('date', 'uri0', 'uri1', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 'totalPOrder', 'totalBStatement', 
        'totalAmountCash','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report.pdf');


    }


    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices  = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->whereBetween('lolo_pinoy_grill_commissary_sales_invoices.created_at', [$startDate, $endDate])
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->get()->toArray();
            
            $totalSalesInvoice  = DB::table(
                                    'lolo_pinoy_grill_commissary_sales_invoices')
                                    ->select(
                                        'lolo_pinoy_grill_commissary_sales_invoices.id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                        'lolo_pinoy_grill_commissary_sales_invoices.date',
                                        'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.address',
                                        'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                        'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                        'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                        'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                        'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                        'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                        'lolo_pinoy_grill_commissary_codes.module_id',
                                        'lolo_pinoy_grill_commissary_codes.module_code',
                                        'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                    ->whereBetween('lolo_pinoy_grill_commissary_sales_invoices.created_at', [$startDate, $endDate])
                                    ->sum('lolo_pinoy_grill_commissary_sales_invoices.amount');
        
        //Delivery Receipt
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                ->whereBetween('lolo_pinoy_grill_commissary_delivery_receipts.created_at', [$startDate, $endDate])
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
    
            $totalDeliveryReceipt = DB::table(
                                    'lolo_pinoy_grill_commissary_delivery_receipts')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                    ->whereBetween('lolo_pinoy_grill_commissary_delivery_receipts.created_at', [$startDate, $endDate])
                                    ->sum('lolo_pinoy_grill_commissary_delivery_receipts.total_amount');
        
        //purchase order
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at')
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                            ->whereBetween('lolo_pinoy_grill_commissary_purchase_orders.created_at', [$startDate, $endDate])                                  
                            ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                            ->get()->toArray();
        
        $totalPOrder = DB::table(
                                'lolo_pinoy_grill_commissary_purchase_orders')
                                ->select(
                                    'lolo_pinoy_grill_commissary_purchase_orders.id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                                    'lolo_pinoy_grill_commissary_purchase_orders.address',
                                    'lolo_pinoy_grill_commissary_purchase_orders.date',
                                    'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                                    'lolo_pinoy_grill_commissary_purchase_orders.description',
                                    'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.amount',
                                    'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                                    ->whereBetween('lolo_pinoy_grill_commissary_purchase_orders.created_at', [$startDate, $endDate])                                  
                                    ->sum('lolo_pinoy_grill_commissary_purchase_orders.total_price');
    
        //
        $moduleName = "Statement Of Account";
        $statementOfAccounts = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.order',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.status',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.dr_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.dr_list_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereBetween('lolo_pinoy_grill_commissary_statement_of_accounts.created_at', [$startDate, $endDate])
                        ->orderBy('lolo_pinoy_grill_commissary_statement_of_accounts.id', 'desc')
                        ->get()->toArray();



        $moduleNamePettyCash = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',   
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_at',
                                'lolo_pinoy_grill_commissary_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePettyCash)
                                ->whereBetween('lolo_pinoy_grill_commissary_petty_cashes.created_at', [$startDate, $endDate])                                  
                                   
                                ->orderBy('lolo_pinoy_grill_commissary_codes.id', 'desc')
                                ->get()->toArray();

        $moduleNamePaymentVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$startDate, $endDate])                                  
                                ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                ->get()->toArray();
                        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                                    'lolo_pinoy_grill_commissary_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                    ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$startDate, $endDate])                                  
                                                                 
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                    ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                    ->get()->toArray();                            
    
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$startDate, $endDate])                                  
                              
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                            ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$startDate, $endDate])                                  
                              
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                            ->get()->toArray();  


        $totalAmountCheck = DB::table(
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_commissary_payment_vouchers.id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                        'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.status',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                        'lolo_pinoy_grill_commissary_codes.module_id',
                        'lolo_pinoy_grill_commissary_codes.module_code',
                        'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                        ->whereBetween('lolo_pinoy_grill_commissary_payment_vouchers.created_at', [$startDate, $endDate])                                  
                                                                 
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                       ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                        ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        return view('lolo-pinoy-grill-commissary-multiple-summary-report', compact('getAllSalesInvoices', 'startDate', 'endDate',
        'totalSalesInvoice', 'getAllDeliveryReceipts', 'totalDeliveryReceipt', 'purchaseOrders', 'totalPOrder',
        'pettyCashLists', 'statementOfAccounts', 'getTransactionLists', 'getTransactionListCashes', 'totalAmountCash' , 
        'getTransactionListChecks', 'totalAmountCheck'));



    }

    public function search(Request $request){
        $getSearchResults =LoloPinoyGrillCommissaryCode::where('lolo_pinoy_grill_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Sales Invoice"){
            $getSearchSalesInvoices  = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.id', $getSearchResults[0]->module_id)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $getSearchResults[0]->module_name)
                                ->get()->toArray();

            $getAllCodes = LoloPinoyGrillCommissaryCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-commissary-search-results',  compact('module', 'getAllCodes', 'getSearchSalesInvoices'));
        }else if($getSearchResults[0]->module_name === "Delivery Receipt"){
            $getSearchDeliveryReceipts = DB::table(
                            'lolo_pinoy_grill_commissary_delivery_receipts')
                            ->select( 
                            'lolo_pinoy_grill_commissary_delivery_receipts.id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.address',
                            'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                            'lolo_pinoy_grill_commissary_delivery_receipts.date',
                            'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                            'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                            'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                            'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                            'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                            'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                            'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                            'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                            'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                            'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                            'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_delivery_receipts.id', $getSearchResults[0]->module_id)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $getSearchResults[0]->module_name)
                            ->get()->toArray();

            $getAllCodes = LoloPinoyGrillCommissaryCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-commissary-search-results',  compact('module', 'getAllCodes', 'getSearchDeliveryReceipts'));
            
        }else if($getSearchResults[0]->module_name === "Purchase Order"){
            $getSearchPurchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.id', $getSearchResults[0]->module_id)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $getSearchResults[0]->module_name)
                            ->get()->toArray();
            
            $getAllCodes = LoloPinoyGrillCommissaryCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-commissary-search-results',  compact('module', 'getAllCodes', 'getSearchPurchaseOrders'));
                     
        }else if($getSearchResults[0]->module_name === "Petty Cash"){
            $getSearchPettyCashes = DB::table(
                            'lolo_pinoy_grill_commissary_petty_cashes')
                            ->select( 
                            'lolo_pinoy_grill_commissary_petty_cashes.id',
                            'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                            'lolo_pinoy_grill_commissary_petty_cashes.pc_id',   
                            'lolo_pinoy_grill_commissary_petty_cashes.date',
                            'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                            'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                            'lolo_pinoy_grill_commissary_petty_cashes.amount',
                            'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                            'lolo_pinoy_grill_commissary_petty_cashes.created_at',
                            'lolo_pinoy_grill_commissary_petty_cashes.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_petty_cashes.id', $getSearchResults[0]->module_id)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $getSearchResults[0]->module_name)
                            ->get()->toArray();
            
            $getAllCodes = LoloPinoyGrillCommissaryCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-commissary-search-results',  compact('module', 'getAllCodes', 'getSearchPettyCashes'));
                     

        }else if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.id', $getSearchResults[0]->module_id)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $getSearchResults[0]->module_name)
                           
                            ->get()->toArray();


            $getAllCodes = LoloPinoyGrillCommissaryCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-commissary-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
                         
                        
        
        }
    }

    public function searchNumberCode(){
        $getAllCodes = LoloPinoyGrillCommissaryCode::get()->toArray();
        return view('lolo-pinoy-grill-commissary-search-number-code', compact('getAllCodes'));
    }

    public function printMultipleSummaryBillingStatement(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1]; 

        $moduleName = "Billing Statement";
        $billingStatements = DB::table(
                        'lolo_pinoy_grill_commissary_billing_statements')
                        ->select(
                            'lolo_pinoy_grill_commissary_billing_statements.id',
                            'lolo_pinoy_grill_commissary_billing_statements.user_id',
                            'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                            'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                            'lolo_pinoy_grill_commissary_billing_statements.address',
                            'lolo_pinoy_grill_commissary_billing_statements.date',
                            'lolo_pinoy_grill_commissary_billing_statements.branch',
                            'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                            'lolo_pinoy_grill_commissary_billing_statements.terms',
                            'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                            'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                            'lolo_pinoy_grill_commissary_billing_statements.description',
                            'lolo_pinoy_grill_commissary_billing_statements.amount',
                            'lolo_pinoy_grill_commissary_billing_statements.total_amount',
                            'lolo_pinoy_grill_commissary_billing_statements.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_billing_statements.billing_statement_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereBetween('lolo_pinoy_grill_commissary_billing_statements.created_at', [$uri0, $uri1])
                        ->orderBy('lolo_pinoy_grill_commissary_billing_statements.id', 'desc')
                        ->get(); 
                        
        
        $totalBStatement = DB::table(
                            'lolo_pinoy_grill_commissary_billing_statements')
                            ->select(
                                'lolo_pinoy_grill_commissary_billing_statements.id',
                                'lolo_pinoy_grill_commissary_billing_statements.user_id',
                                'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                                'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                                'lolo_pinoy_grill_commissary_billing_statements.address',
                                'lolo_pinoy_grill_commissary_billing_statements.date',
                                'lolo_pinoy_grill_commissary_billing_statements.branch',
                                'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                                'lolo_pinoy_grill_commissary_billing_statements.terms',
                                'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                                'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                                'lolo_pinoy_grill_commissary_billing_statements.order',
                                'lolo_pinoy_grill_commissary_billing_statements.whole_lechon',
                                'lolo_pinoy_grill_commissary_billing_statements.description',
                                'lolo_pinoy_grill_commissary_billing_statements.amount',
                                'lolo_pinoy_grill_commissary_billing_statements.total_amount',
                                'lolo_pinoy_grill_commissary_billing_statements.paid_amount',
                                'lolo_pinoy_grill_commissary_billing_statements.created_by',
                                'lolo_pinoy_grill_commissary_billing_statements.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_billing_statements.billing_statement_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->where('lolo_pinoy_grill_commissary_billing_statements.deleted_at', NULL)
                            ->whereBetween('lolo_pinoy_grill_commissary_billing_statements.created_at', [$uri0, $uri1])
                            ->sum('lolo_pinoy_grill_commissary_billing_statements.total_amount');

        $pdf = PDF::loadView('printSummaryLoloPinoyGrillBillingStatement',  compact('date', 'uri0', 'uri1', 
        'billingStatements', 'totalBStatement'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report-billing-statement.pdf');

    }

    public function printGetSummaryBillingStatement($date){
        
        $moduleName = "Billing Statement";
        $billingStatements = DB::table(
                        'lolo_pinoy_grill_commissary_billing_statements')
                        ->select(
                            'lolo_pinoy_grill_commissary_billing_statements.id',
                            'lolo_pinoy_grill_commissary_billing_statements.user_id',
                            'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                            'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                            'lolo_pinoy_grill_commissary_billing_statements.address',
                            'lolo_pinoy_grill_commissary_billing_statements.date',
                            'lolo_pinoy_grill_commissary_billing_statements.branch',
                            'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                            'lolo_pinoy_grill_commissary_billing_statements.terms',
                            'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                            'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                            'lolo_pinoy_grill_commissary_billing_statements.description',
                            'lolo_pinoy_grill_commissary_billing_statements.amount',
                            'lolo_pinoy_grill_commissary_billing_statements.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_billing_statements.billing_statement_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_commissary_billing_statements.created_at', '=', date($date))
                        ->orderBy('lolo_pinoy_grill_commissary_billing_statements.id', 'desc')
                        ->get();

        $totalBStatement = DB::table(
                            'lolo_pinoy_grill_commissary_billing_statements')
                            ->select(
                                'lolo_pinoy_grill_commissary_billing_statements.id',
                                'lolo_pinoy_grill_commissary_billing_statements.user_id',
                                'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                                'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                                'lolo_pinoy_grill_commissary_billing_statements.address',
                                'lolo_pinoy_grill_commissary_billing_statements.date',
                                'lolo_pinoy_grill_commissary_billing_statements.branch',
                                'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                                'lolo_pinoy_grill_commissary_billing_statements.terms',
                                'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                                'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                                'lolo_pinoy_grill_commissary_billing_statements.order',
                                'lolo_pinoy_grill_commissary_billing_statements.whole_lechon',
                                'lolo_pinoy_grill_commissary_billing_statements.description',
                                'lolo_pinoy_grill_commissary_billing_statements.amount',
                                'lolo_pinoy_grill_commissary_billing_statements.total_amount',
                                'lolo_pinoy_grill_commissary_billing_statements.paid_amount',
                                'lolo_pinoy_grill_commissary_billing_statements.created_by',
                                'lolo_pinoy_grill_commissary_billing_statements.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_billing_statements.billing_statement_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameBillingStatement)
                            ->where('lolo_pinoy_grill_commissary_billing_statements.deleted_at', NULL)
                            ->whereDate('lolo_pinoy_grill_commissary_billing_statements.created_at', '=', date($date))
                            ->sum('lolo_pinoy_grill_commissary_billing_statements.total_amount');

            $getDateToday = "";
            $uri0 ="";
            $uri1 = "";
            $pdf = PDF::loadView('printSummaryLoloPinoyGrillBillingStatement',  compact('date', 'uri0', 'uri1', 'getDateToday',
            'billingStatements', 'totalBStatement'));
                            
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report-billing-statement.pdf');
    }

    public function printSummaryBillingStatement(){
        $getDateToday = date("Y-m-d");
        
        $moduleName = "Billing Statement";
        $billingStatements = DB::table(
                        'lolo_pinoy_grill_commissary_billing_statements')
                        ->select(
                            'lolo_pinoy_grill_commissary_billing_statements.id',
                            'lolo_pinoy_grill_commissary_billing_statements.user_id',
                            'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                            'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                            'lolo_pinoy_grill_commissary_billing_statements.address',
                            'lolo_pinoy_grill_commissary_billing_statements.date',
                            'lolo_pinoy_grill_commissary_billing_statements.branch',
                            'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                            'lolo_pinoy_grill_commissary_billing_statements.terms',
                            'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                            'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                            'lolo_pinoy_grill_commissary_billing_statements.description',
                            'lolo_pinoy_grill_commissary_billing_statements.amount',
                            'lolo_pinoy_grill_commissary_billing_statements.total_amount',
                            'lolo_pinoy_grill_commissary_billing_statements.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_billing_statements.billing_statement_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_commissary_billing_statements.created_at', '=', date($getDateToday))
                        ->orderBy('lolo_pinoy_grill_commissary_billing_statements.id', 'desc')
                        ->get();

        $totalBStatement = DB::table(
                            'lolo_pinoy_grill_commissary_billing_statements')
                            ->select(
                                'lolo_pinoy_grill_commissary_billing_statements.id',
                                'lolo_pinoy_grill_commissary_billing_statements.user_id',
                                'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                                'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                                'lolo_pinoy_grill_commissary_billing_statements.address',
                                'lolo_pinoy_grill_commissary_billing_statements.date',
                                'lolo_pinoy_grill_commissary_billing_statements.branch',
                                'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                                'lolo_pinoy_grill_commissary_billing_statements.terms',
                                'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                                'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                                'lolo_pinoy_grill_commissary_billing_statements.order',
                                'lolo_pinoy_grill_commissary_billing_statements.whole_lechon',
                                'lolo_pinoy_grill_commissary_billing_statements.description',
                                'lolo_pinoy_grill_commissary_billing_statements.amount',
                                'lolo_pinoy_grill_commissary_billing_statements.total_amount',
                                'lolo_pinoy_grill_commissary_billing_statements.paid_amount',
                                'lolo_pinoy_grill_commissary_billing_statements.created_by',
                                'lolo_pinoy_grill_commissary_billing_statements.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_billing_statements.billing_statement_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->where('lolo_pinoy_grill_commissary_billing_statements.deleted_at', NULL)
                            ->whereDate('lolo_pinoy_grill_commissary_billing_statements.created_at', '=', date($getDateToday))
                            ->sum('lolo_pinoy_grill_commissary_billing_statements.total_amount');

            
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillBillingStatement',  compact('uri0', 'uri1', 'getDateToday', 
        'billingStatements', 'totalBStatement'));
                            
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report-billing-statement.pdf');
                    


    }

    public function printGetSummaryStatementOfAccount($date){
        $moduleName = "Statement Of Account";
        $statementOfAccounts = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_commissary_statement_of_accounts.created_at', '=', date($date))
                        ->orderBy('lolo_pinoy_grill_commissary_statement_of_accounts.id', 'desc')
                        ->get()->toArray();

        $getDateToday = "";
        $uri0 ="";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillStatementOfAccount',  compact('date', 'uri0', 'uri1', 'getDateToday',
        'statementOfAccounts'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report-soa.pdf');
                     
    }

    public function printMultipleSummaryStatementOfAccount(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1]; 

        $moduleName = "Statement Of Account";
        $statementOfAccounts = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.order',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.status',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.dr_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.dr_list_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereBetween('lolo_pinoy_grill_commissary_statement_of_accounts.created_at', [$uri0, $uri1])
                        ->orderBy('lolo_pinoy_grill_commissary_statement_of_accounts.id', 'desc')
                        ->get()->toArray();

        $pdf = PDF::loadView('printSummaryLoloPinoyGrillStatementOfAccount',  compact('date', 'uri0', 'uri1', 
        'statementOfAccounts'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-multiple-summary-report-soa.pdf');
               
        
    }

    public function printSummaryStatementOfAccount(){
        $getDateToday = date("Y-m-d");

        $moduleName = "Statement Of Account";
        $statementOfAccounts = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_commissary_statement_of_accounts.created_at', '=', date($getDateToday))
                        ->orderBy('lolo_pinoy_grill_commissary_statement_of_accounts.id', 'desc')
                        ->get()->toArray();
                        
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillStatementOfAccount',  compact('uri0', 'uri1', 'getDateToday', 
        'statementOfAccounts'));
                                
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report-soa.pdf');

    }

    public function printMultipleSummaryPurchaseOrder(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];  

        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                            ->whereBetween('lolo_pinoy_grill_commissary_purchase_orders.created_at', [$uri0, $uri1])                                   
                            ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                            ->get()->toArray();

         
        $totalPOrder = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                            ->whereBetween('lolo_pinoy_grill_commissary_purchase_orders.created_at', [$uri0, $uri1])                                   
                            ->sum('lolo_pinoy_grill_commissary_purchase_orders.total_price');
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillPurchaseOrder',  compact('date', 'uri0', 'uri1', 
        'purchaseOrders', 'totalPOrder'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-multiple-summary-report-purchase-order.pdf');
        

    }

    public function printGetSummaryPurchaseOrder($date){
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                            ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($date))                                   
                            ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                            ->get()->toArray();
        
        $totalPOrder = DB::table(
                                'lolo_pinoy_grill_commissary_purchase_orders')
                                ->select(
                                    'lolo_pinoy_grill_commissary_purchase_orders.id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                                    'lolo_pinoy_grill_commissary_purchase_orders.address',
                                    'lolo_pinoy_grill_commissary_purchase_orders.date',
                                    'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                                    'lolo_pinoy_grill_commissary_purchase_orders.description',
                                    'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.amount',
                                    'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                                    ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($date))                                   
                                    ->sum('lolo_pinoy_grill_commissary_purchase_orders.total_price');

            $getDateToday = "";
            $uri0 ="";
            $uri1 = "";
            $pdf = PDF::loadView('printSummaryLoloPinoyGrillPurchaseOrder',  compact('date', 'uri0', 'uri1', 'getDateToday',
            'purchaseOrders', 'totalPOrder'));
            
            return $pdf->download('lolo-pinoy-grill-commissary-summary-report-purchase-order.pdf');

    }

    public function printSummaryPurchaseOrder(){
        $getDateToday = date("Y-m-d");

         //purchase order
         $moduleNamePurchase = "Purchase Order";
         $purchaseOrders = DB::table(
                         'lolo_pinoy_grill_commissary_purchase_orders')
                         ->select(
                             'lolo_pinoy_grill_commissary_purchase_orders.id',
                             'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                             'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                             'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                             'lolo_pinoy_grill_commissary_purchase_orders.address',
                             'lolo_pinoy_grill_commissary_purchase_orders.date',
                             'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                             'lolo_pinoy_grill_commissary_purchase_orders.description',
                             'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                             'lolo_pinoy_grill_commissary_purchase_orders.amount',
                             'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                             'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                             'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                             'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                             'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                             'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                             'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                             'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                             'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                             'lolo_pinoy_grill_commissary_codes.module_id',
                             'lolo_pinoy_grill_commissary_codes.module_code',
                             'lolo_pinoy_grill_commissary_codes.module_name')
                             ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                             ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                             ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                             ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                             ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($getDateToday))                                   
                             ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                             ->get()->toArray();
         
         $totalPOrder = DB::table(
                                 'lolo_pinoy_grill_commissary_purchase_orders')
                                 ->select(
                                     'lolo_pinoy_grill_commissary_purchase_orders.id',
                                     'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                                     'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                                     'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                                     'lolo_pinoy_grill_commissary_purchase_orders.address',
                                     'lolo_pinoy_grill_commissary_purchase_orders.date',
                                     'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                                     'lolo_pinoy_grill_commissary_purchase_orders.description',
                                     'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                                     'lolo_pinoy_grill_commissary_purchase_orders.amount',
                                     'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                                     'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                                     'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                                     'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                                     'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                                     'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                                     'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                                     'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                                     'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                     'lolo_pinoy_grill_commissary_codes.module_id',
                                     'lolo_pinoy_grill_commissary_codes.module_code',
                                     'lolo_pinoy_grill_commissary_codes.module_name')
                                     ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                     ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                                     ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                                     ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                                     ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($getDateToday))                                   
                                     ->sum('lolo_pinoy_grill_commissary_purchase_orders.total_price');

            $uri0 = "";
            $uri1 = "";
            $pdf = PDF::loadView('printSummaryLoloPinoyGrillPurchaseOrder',  compact('uri0', 'uri1', 'getDateToday', 
            'purchaseOrders', 'totalPOrder'));
            
            return $pdf->download('lolo-pinoy-grill-commissary-summary-report-purchase-order.pdf');
     


    }

    public function printMultipleSummaryDeliveryReceipt(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];  

        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                ->whereBetween('lolo_pinoy_grill_commissary_delivery_receipts.created_at', [$uri0, $uri1])
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
    
            $totalDeliveryReceipt = DB::table(
                                    'lolo_pinoy_grill_commissary_delivery_receipts')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                    ->whereBetween('lolo_pinoy_grill_commissary_delivery_receipts.created_at', [$uri0, $uri1])
                                    ->sum('lolo_pinoy_grill_commissary_delivery_receipts.total_amount');

        $pdf = PDF::loadView('printSummaryLoloPinoyGrillDeliveryReceipt',  compact('date', 'uri0', 'uri1', 
        'getAllDeliveryReceipts',  'totalDeliveryReceipt'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-multiple-summary-report-delivery-receipt.pdf');


    }

    public function printGetSummaryDeliveryReceipt($date){
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($date))
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
    
            $totalDeliveryReceipt = DB::table(
                                    'lolo_pinoy_grill_commissary_delivery_receipts')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                    ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($date))
                                    ->sum('lolo_pinoy_grill_commissary_delivery_receipts.total_amount');

        $getDateToday = "";
        $uri0 ="";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillDeliveryReceipt',  compact('date', 'uri0', 'uri1', 'getDateToday',
        'getAllDeliveryReceipts', 'totalDeliveryReceipt'));
                                    
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report-delivery-receipt.pdf');

    }

    public function printSummaryDeliveryReceipt(){
        $getDateToday = date("Y-m-d");

        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($getDateToday))
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
    
            $totalDeliveryReceipt = DB::table(
                                    'lolo_pinoy_grill_commissary_delivery_receipts')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                    ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($getDateToday))
                                    ->sum('lolo_pinoy_grill_commissary_delivery_receipts.total_amount');

        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillDeliveryReceipt',  compact('uri0', 'uri1', 'getDateToday', 
        'getAllDeliveryReceipts', 'totalDeliveryReceipt'));
                                
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report-delivery-receipt.pdf');
        
    }

    public function printMultipleSummarySalesInvoice(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];

        $moduleName = "Sales Invoice";

        $getAllSalesInvoices  = DB::table(
                    'lolo_pinoy_grill_commissary_sales_invoices')
                    ->select(
                        'lolo_pinoy_grill_commissary_sales_invoices.id',
                        'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                        'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                        'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                        'lolo_pinoy_grill_commissary_sales_invoices.date',
                        'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                        'lolo_pinoy_grill_commissary_sales_invoices.address',
                        'lolo_pinoy_grill_commissary_sales_invoices.qty',
                        'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                        'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                        'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                        'lolo_pinoy_grill_commissary_sales_invoices.amount',
                        'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                        'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                        'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                        'lolo_pinoy_grill_commissary_codes.module_id',
                        'lolo_pinoy_grill_commissary_codes.module_code',
                        'lolo_pinoy_grill_commissary_codes.module_name')
                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                    ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                    ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                    ->whereBetween('lolo_pinoy_grill_commissary_sales_invoices.created_at', [$uri0, $uri1])
                    ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                    ->get()->toArray();
        
        $totalSalesInvoice  = DB::table(
                        'lolo_pinoy_grill_commissary_sales_invoices')
                        ->select(
                            'lolo_pinoy_grill_commissary_sales_invoices.id',
                            'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                            'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                            'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                            'lolo_pinoy_grill_commissary_sales_invoices.date',
                            'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                            'lolo_pinoy_grill_commissary_sales_invoices.address',
                            'lolo_pinoy_grill_commissary_sales_invoices.qty',
                            'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                            'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                            'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                            'lolo_pinoy_grill_commissary_sales_invoices.amount',
                            'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                            'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                            'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereBetween('lolo_pinoy_grill_commissary_sales_invoices.created_at', [$uri0, $uri1])
                        ->sum('lolo_pinoy_grill_commissary_sales_invoices.amount');

        $pdf = PDF::loadView('printSummaryLoloPinoyGrillSalesInvoice',  compact('date', 'uri0', 'uri1', 'getAllSalesInvoices', 
        'totalSalesInvoice'));
        
        return $pdf->download('lechon-de-cebu-summary-report-sales-report.pdf');
    }   

    public function printGetSummarySalesInvoice($date){
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices  = DB::table(
                        'lolo_pinoy_grill_commissary_sales_invoices')
                        ->select(
                            'lolo_pinoy_grill_commissary_sales_invoices.id',
                            'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                            'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                            'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                            'lolo_pinoy_grill_commissary_sales_invoices.date',
                            'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                            'lolo_pinoy_grill_commissary_sales_invoices.address',
                            'lolo_pinoy_grill_commissary_sales_invoices.qty',
                            'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                            'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                            'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                            'lolo_pinoy_grill_commissary_sales_invoices.amount',
                            'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                            'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                            'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($date))
                        ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                        ->get()->toArray();
            
        $totalSalesInvoice  = DB::table(
                            'lolo_pinoy_grill_commissary_sales_invoices')
                            ->select(
                                'lolo_pinoy_grill_commissary_sales_invoices.id',
                                'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                'lolo_pinoy_grill_commissary_sales_invoices.date',
                                'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                'lolo_pinoy_grill_commissary_sales_invoices.address',
                                'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($date))
                            ->sum('lolo_pinoy_grill_commissary_sales_invoices.amount');

                            
        $getDateToday = "";
        $uri0 ="";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillSalesInvoice',  compact('date', 'uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'totalSalesInvoice'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report-sales-invoice.pdf');
    }

    public function printSummarySalesInvoice(){
          //sales invoice
        $getDateToday = date("Y-m-d");

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices  = DB::table(
                                 'lolo_pinoy_grill_commissary_sales_invoices')
                                 ->select(
                                     'lolo_pinoy_grill_commissary_sales_invoices.id',
                                     'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                     'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                     'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                     'lolo_pinoy_grill_commissary_sales_invoices.date',
                                     'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                     'lolo_pinoy_grill_commissary_sales_invoices.address',
                                     'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                     'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                     'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                     'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                     'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                     'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                     'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                     'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                     'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                     'lolo_pinoy_grill_commissary_codes.module_id',
                                     'lolo_pinoy_grill_commissary_codes.module_code',
                                     'lolo_pinoy_grill_commissary_codes.module_name')
                                 ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                 ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                 ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                 ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                 ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($getDateToday))
                                 ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                 ->get()->toArray();
             
             $totalSalesInvoice  = DB::table(
                                     'lolo_pinoy_grill_commissary_sales_invoices')
                                     ->select(
                                         'lolo_pinoy_grill_commissary_sales_invoices.id',
                                         'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                         'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                         'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                         'lolo_pinoy_grill_commissary_sales_invoices.date',
                                         'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                         'lolo_pinoy_grill_commissary_sales_invoices.address',
                                         'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                         'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                         'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                         'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                         'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                         'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                         'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                         'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                         'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                         'lolo_pinoy_grill_commissary_codes.module_id',
                                         'lolo_pinoy_grill_commissary_codes.module_code',
                                         'lolo_pinoy_grill_commissary_codes.module_name')
                                     ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                     ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                     ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                     ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                     ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($getDateToday))
                                     ->sum('lolo_pinoy_grill_commissary_sales_invoices.amount');

        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillSalesInvoice', compact('uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'totalSalesInvoice'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report-sales-invoice.pdf');
                             
        
         
    }

    public function printGetSummary($date){
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices  = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($date))
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->get()->toArray();
            
            $totalSalesInvoice  = DB::table(
                                    'lolo_pinoy_grill_commissary_sales_invoices')
                                    ->select(
                                        'lolo_pinoy_grill_commissary_sales_invoices.id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                        'lolo_pinoy_grill_commissary_sales_invoices.date',
                                        'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.address',
                                        'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                        'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                        'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                        'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                        'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                        'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                        'lolo_pinoy_grill_commissary_codes.module_id',
                                        'lolo_pinoy_grill_commissary_codes.module_code',
                                        'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                    ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($date))
                                    ->sum('lolo_pinoy_grill_commissary_sales_invoices.amount');
        
        //Delivery Receipt
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($date))
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
    
            $totalDeliveryReceipt = DB::table(
                                    'lolo_pinoy_grill_commissary_delivery_receipts')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                    ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($date))
                                    ->sum('lolo_pinoy_grill_commissary_delivery_receipts.total_amount');
        
        //purchase order
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                            ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($date))                                   
                            ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                            ->get()->toArray();
        
        $totalPOrder = DB::table(
                                'lolo_pinoy_grill_commissary_purchase_orders')
                                ->select(
                                    'lolo_pinoy_grill_commissary_purchase_orders.id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                                    'lolo_pinoy_grill_commissary_purchase_orders.address',
                                    'lolo_pinoy_grill_commissary_purchase_orders.date',
                                    'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                                    'lolo_pinoy_grill_commissary_purchase_orders.description',
                                    'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.amount',
                                    'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                                    ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($date))                                   
                                    ->sum('lolo_pinoy_grill_commissary_purchase_orders.total_price');
    
        $moduleNamePettyCash = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',   
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_at',
                                'lolo_pinoy_grill_commissary_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePettyCash)
                                ->whereDate('lolo_pinoy_grill_commissary_petty_cashes.created_at', '=', date($date))                                   
                                ->orderBy('lolo_pinoy_grill_commissary_codes.id', 'desc')
                                ->get()->toArray();

        $moduleNamePaymentVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($date))                                   
                                ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                ->get()->toArray();
                        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                                    'lolo_pinoy_grill_commissary_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                    ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($date))                                   
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                    ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                    ->get()->toArray();                            
    
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($date))                                   
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                            ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($date))                                   
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                            ->get()->toArray();  


        $totalAmountCheck = DB::table(
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_commissary_payment_vouchers.id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                        'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.status',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                        'lolo_pinoy_grill_commissary_codes.module_id',
                        'lolo_pinoy_grill_commissary_codes.module_code',
                        'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                        ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($date))                                   
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                        ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        
        
        $totalPaidAmountCheck  = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                            ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($date))                                   
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', $status)
                            ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');


        $getDateToday = "";
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrill',  compact('date', 'uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 'totalPOrder', 'totalBStatement', 
        'totalAmountCash','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report.pdf');


    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices  = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($getDate))
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->get()->toArray();
            
            $totalSalesInvoice  = DB::table(
                                    'lolo_pinoy_grill_commissary_sales_invoices')
                                    ->select(
                                        'lolo_pinoy_grill_commissary_sales_invoices.id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                        'lolo_pinoy_grill_commissary_sales_invoices.date',
                                        'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.address',
                                        'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                        'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                        'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                        'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                        'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                        'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                        'lolo_pinoy_grill_commissary_codes.module_id',
                                        'lolo_pinoy_grill_commissary_codes.module_code',
                                        'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                    ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($getDate))
                                    ->sum('lolo_pinoy_grill_commissary_sales_invoices.amount');
        
        //Delivery Receipt
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($getDate))
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
    
            $totalDeliveryReceipt = DB::table(
                                    'lolo_pinoy_grill_commissary_delivery_receipts')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                    ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($getDate))
                                    ->sum('lolo_pinoy_grill_commissary_delivery_receipts.total_amount');
        
        //purchase order
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                            ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($getDate))                                   
                            ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                            ->get()->toArray();
        
        $totalPOrder = DB::table(
                                'lolo_pinoy_grill_commissary_purchase_orders')
                                ->select(
                                    'lolo_pinoy_grill_commissary_purchase_orders.id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                                    'lolo_pinoy_grill_commissary_purchase_orders.address',
                                    'lolo_pinoy_grill_commissary_purchase_orders.date',
                                    'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                                    'lolo_pinoy_grill_commissary_purchase_orders.description',
                                    'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.amount',
                                    'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                                    ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($getDate))                                   
                                    ->sum('lolo_pinoy_grill_commissary_purchase_orders.total_price');
    
        //
        $moduleNameSOA = "Statement Of Account";
        $statementOfAccounts = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameSOA)
                        ->whereDate('lolo_pinoy_grill_commissary_statement_of_accounts.created_at', '=', date($getDate))
                        ->orderBy('lolo_pinoy_grill_commissary_statement_of_accounts.id', 'desc')
                        ->get()->toArray();

        

        $moduleNamePettyCash = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',   
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_at',
                                'lolo_pinoy_grill_commissary_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePettyCash)
                                ->whereDate('lolo_pinoy_grill_commissary_petty_cashes.created_at', '=', date($getDate))                                   
                                ->orderBy('lolo_pinoy_grill_commissary_codes.id', 'desc')
                                ->get()->toArray();

        $moduleNamePaymentVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDate))                                   
                                ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                ->get()->toArray();
                        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                                    'lolo_pinoy_grill_commissary_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                    ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDate))                                   
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                    ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                    ->get()->toArray();                            
    
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDate))                                   
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                            ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDate))                                   
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                            ->get()->toArray();  


        $totalAmountCheck = DB::table(
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_commissary_payment_vouchers.id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                        'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.status',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                        'lolo_pinoy_grill_commissary_codes.module_id',
                        'lolo_pinoy_grill_commissary_codes.module_code',
                        'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                        ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDate))                                   
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                        ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        return view('lolo-pinoy-grill-get-summary-report', compact('getDate', 'getAllSalesInvoices', 
        'totalSalesInvoice', 'getAllDeliveryReceipts', 'totalDeliveryReceipt', 'purchaseOrders', 
        'totalPOrder', 'statementOfAccounts',
        'pettyCashLists', 'getTransactionLists', 'getTransactionListCashes', 'totalAmountCash' , 
        'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function printSummary(){
         //sales invoice
         $getDateToday = date("Y-m-d");

         $moduleName = "Sales Invoice";
        $getAllSalesInvoices  = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($getDateToday))
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->get()->toArray();
            
            $totalSalesInvoice  = DB::table(
                                    'lolo_pinoy_grill_commissary_sales_invoices')
                                    ->select(
                                        'lolo_pinoy_grill_commissary_sales_invoices.id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                        'lolo_pinoy_grill_commissary_sales_invoices.date',
                                        'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.address',
                                        'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                        'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                        'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                        'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                        'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                        'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                        'lolo_pinoy_grill_commissary_codes.module_id',
                                        'lolo_pinoy_grill_commissary_codes.module_code',
                                        'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                    ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($getDateToday))
                                    ->sum('lolo_pinoy_grill_commissary_sales_invoices.amount');
        
        //Delivery Receipt  
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($getDateToday))
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
    
            $totalDeliveryReceipt = DB::table(
                                    'lolo_pinoy_grill_commissary_delivery_receipts')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                    ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($getDateToday))
                                    ->sum('lolo_pinoy_grill_commissary_delivery_receipts.total_amount');
        
        //purchase order
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                            ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($getDateToday))                                   
                            ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                            ->get()->toArray();
        
        $totalPOrder = DB::table(
                                'lolo_pinoy_grill_commissary_purchase_orders')
                                ->select(
                                    'lolo_pinoy_grill_commissary_purchase_orders.id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                                    'lolo_pinoy_grill_commissary_purchase_orders.address',
                                    'lolo_pinoy_grill_commissary_purchase_orders.date',
                                    'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                                    'lolo_pinoy_grill_commissary_purchase_orders.description',
                                    'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.amount',
                                    'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                                    ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($getDateToday))                                   
                                    ->sum('lolo_pinoy_grill_commissary_purchase_orders.total_price');
    
        //


        $moduleNamePettyCash = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',   
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_at',
                                'lolo_pinoy_grill_commissary_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePettyCash)
                                ->whereDate('lolo_pinoy_grill_commissary_petty_cashes.created_at', '=', date($getDateToday))                                   
                                ->orderBy('lolo_pinoy_grill_commissary_codes.id', 'desc')
                                ->get()->toArray();

        $moduleNamePaymentVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                                ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                ->get()->toArray();
                        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                                    'lolo_pinoy_grill_commissary_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                    ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                    ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                    ->get()->toArray();      

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                            ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                            ->get()->toArray();  


        $totalAmountCheck = DB::table(
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_commissary_payment_vouchers.id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                        'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.status',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                        'lolo_pinoy_grill_commissary_codes.module_id',
                        'lolo_pinoy_grill_commissary_codes.module_code',
                        'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                        ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                        ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        //total paid amount check
        $totalPaidAmountCheck = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                            ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', $status)
                            ->sum('lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount');
        
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrill',  compact('uri0', 'uri1', 'date', 'getDateToday', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 'totalPOrder', 'totalBStatement', 
        'totalAmountCash','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-summary-report.pdf');

    }

    public function summaryReport(){
         //sales invoice
        $getDateToday = date("Y-m-d");
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices  = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($getDateToday))
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->get()->toArray();
            
            $totalSalesInvoice  = DB::table(
                                    'lolo_pinoy_grill_commissary_sales_invoices')
                                    ->select(
                                        'lolo_pinoy_grill_commissary_sales_invoices.id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                        'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                        'lolo_pinoy_grill_commissary_sales_invoices.date',
                                        'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.address',
                                        'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                        'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                        'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                        'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                        'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                        'lolo_pinoy_grill_commissary_sales_invoices.created_at',
                                        'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                        'lolo_pinoy_grill_commissary_codes.module_id',
                                        'lolo_pinoy_grill_commissary_codes.module_code',
                                        'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                    ->whereDate('lolo_pinoy_grill_commissary_sales_invoices.created_at', '=', date($getDateToday))
                                    ->sum('lolo_pinoy_grill_commissary_sales_invoices.amount');
        
        //Delivery Receipt
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.total_amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($getDateToday))
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
    
            $totalDeliveryReceipt = DB::table(
                                    'lolo_pinoy_grill_commissary_delivery_receipts')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.created_at',
                                    'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameDelivery)
                                    ->whereDate('lolo_pinoy_grill_commissary_delivery_receipts.created_at', '=', date($getDateToday))
                                    ->sum('lolo_pinoy_grill_commissary_delivery_receipts.total_amount');
        
        //purchase order
        $moduleNamePurchase = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at')
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                            ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($getDateToday))                                   
                            ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                            ->get()->toArray();
        
        $totalPOrder = DB::table(
                                'lolo_pinoy_grill_commissary_purchase_orders')
                                ->select(
                                    'lolo_pinoy_grill_commissary_purchase_orders.id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                                    'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                                    'lolo_pinoy_grill_commissary_purchase_orders.address',
                                    'lolo_pinoy_grill_commissary_purchase_orders.date',
                                    'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                                    'lolo_pinoy_grill_commissary_purchase_orders.description',
                                    'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.amount',
                                    'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                                    'lolo_pinoy_grill_commissary_purchase_orders.created_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                                    'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePurchase)
                                    ->whereDate('lolo_pinoy_grill_commissary_purchase_orders.created_at', '=', date($getDateToday))                                   
                                    ->sum('lolo_pinoy_grill_commissary_purchase_orders.total_price');
    
        //
        $moduleName = "Statement Of Account";
        $statementOfAccounts = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_commissary_statement_of_accounts.created_at', '=', date($getDateToday))
                        ->orderBy('lolo_pinoy_grill_commissary_statement_of_accounts.id', 'desc')
                        ->get()->toArray();


            $moduleNameBS = "Billing Statement";
            $billingStatements = DB::table(
                            'lolo_pinoy_grill_commissary_billing_statements')
                            ->select(
                                'lolo_pinoy_grill_commissary_billing_statements.id',
                                'lolo_pinoy_grill_commissary_billing_statements.user_id',
                                'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                                'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                                'lolo_pinoy_grill_commissary_billing_statements.address',
                                'lolo_pinoy_grill_commissary_billing_statements.date',
                                'lolo_pinoy_grill_commissary_billing_statements.branch',
                                'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                                'lolo_pinoy_grill_commissary_billing_statements.terms',
                                'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                                'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                                'lolo_pinoy_grill_commissary_billing_statements.description',
                                'lolo_pinoy_grill_commissary_billing_statements.amount',
                                'lolo_pinoy_grill_commissary_billing_statements.created_by',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_billing_statements.billing_statement_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameBS)
                            ->whereDate('lolo_pinoy_grill_commissary_billing_statements.created_at', '=', date($getDateToday))
                            ->orderBy('lolo_pinoy_grill_commissary_billing_statements.id', 'desc')
                            ->get();
                
            $totalBStatement = DB::table(
                                'lolo_pinoy_grill_commissary_billing_statements')
                                ->select(
                                    'lolo_pinoy_grill_commissary_billing_statements.id',
                                    'lolo_pinoy_grill_commissary_billing_statements.user_id',
                                    'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                                    'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                                    'lolo_pinoy_grill_commissary_billing_statements.address',
                                    'lolo_pinoy_grill_commissary_billing_statements.date',
                                    'lolo_pinoy_grill_commissary_billing_statements.branch',
                                    'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                                    'lolo_pinoy_grill_commissary_billing_statements.terms',
                                    'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                                    'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                                    'lolo_pinoy_grill_commissary_billing_statements.order',
                                    'lolo_pinoy_grill_commissary_billing_statements.whole_lechon',
                                    'lolo_pinoy_grill_commissary_billing_statements.description',
                                    'lolo_pinoy_grill_commissary_billing_statements.amount',
                                    'lolo_pinoy_grill_commissary_billing_statements.total_amount',
                                    'lolo_pinoy_grill_commissary_billing_statements.paid_amount',
                                    'lolo_pinoy_grill_commissary_billing_statements.created_by',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_billing_statements.billing_statement_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameBS)
                                ->whereDate('lolo_pinoy_grill_commissary_billing_statements.created_at', '=', date($getDateToday))
                                ->sum('lolo_pinoy_grill_commissary_billing_statements.total_amount');
                

        $moduleNamePettyCash = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',   
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_at',
                                'lolo_pinoy_grill_commissary_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePettyCash)
                                ->whereDate('lolo_pinoy_grill_commissary_petty_cashes.created_at', '=', date($getDateToday))                                   
                                ->orderBy('lolo_pinoy_grill_commissary_codes.id', 'desc')
                                ->get()->toArray();

        $moduleNamePaymentVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                                ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                ->get()->toArray();
                        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                                    'lolo_pinoy_grill_commissary_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                    ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                    ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                                    ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                    ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                    ->get()->toArray();                            
    
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                                'lolo_pinoy_grill_commissary_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_commissary_payment_vouchers.id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                                'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                                'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                                'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                                'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_commissary_payment_vouchers.status',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                                ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                                ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $cash)
                                ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                                ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                            ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                            ->get()->toArray();  


        $totalAmountCheck = DB::table(
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_commissary_payment_vouchers.id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                        'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                        'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                        'lolo_pinoy_grill_commissary_payment_vouchers.created_at',
                        'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_commissary_payment_vouchers.status',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.cheque_total_amount',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                        'lolo_pinoy_grill_commissary_codes.module_id',
                        'lolo_pinoy_grill_commissary_codes.module_code',
                        'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNamePaymentVoucher)
                        ->whereDate('lolo_pinoy_grill_commissary_payment_vouchers.created_at', '=', date($getDateToday))                                   
                        ->where('lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment', $check)
                       ->where('lolo_pinoy_grill_commissary_payment_vouchers.status', '!=', $status)
                        ->sum('lolo_pinoy_grill_commissary_payment_vouchers.amount_due');

        return view('lolo-pinoy-grill-commissary-summary-report', compact('getAllSalesInvoices', 
        'totalSalesInvoice', 'getAllDeliveryReceipts', 'totalDeliveryReceipt', 'purchaseOrders', 
        'totalPOrder', 'statementOfAccounts', 'billingStatements', 'totalBStatement', 
        'pettyCashLists', 'getTransactionLists', 'getTransactionListCashes', 'totalAmountCash' , 
        'getTransactionListChecks', 'totalAmountCheck'));
    }

    
    public function printPO($id){   
    
        $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_purchase_orders.id', $id)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                        ->get()->toArray();
   

                //
            $pOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', $id)->get()->toArray();

                //count the total amount 
            $countTotalAmount = LoloPinoyGrillCommissaryPurchaseOrder::where('id', $id)->sum('amount');

            //
            $countAmount = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', $id)->sum('amount');

            $sum  = $countTotalAmount + $countAmount;


            $pdf = PDF::loadView('printPOLoloPinoyGrill', compact('purchaseOrder', 'pOrders', 'sum'));

            return $pdf->download('lolo-pinoy-grill-commissary-purchase-order.pdf');
    }

    public function printBillingStatement($id){
     
        $moduleName = "Billing Statement";
        $printBillingStatement = DB::table(
                                'lolo_pinoy_grill_commissary_billing_statements')
                                ->select(
                                    'lolo_pinoy_grill_commissary_billing_statements.id',
                                    'lolo_pinoy_grill_commissary_billing_statements.user_id',
                                    'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                                    'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                                    'lolo_pinoy_grill_commissary_billing_statements.address',
                                    'lolo_pinoy_grill_commissary_billing_statements.date',
                                    'lolo_pinoy_grill_commissary_billing_statements.branch',
                                    'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                                    'lolo_pinoy_grill_commissary_billing_statements.terms',
                                    'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                                    'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                                    'lolo_pinoy_grill_commissary_billing_statements.description',
                                    'lolo_pinoy_grill_commissary_billing_statements.amount',
                                    'lolo_pinoy_grill_commissary_billing_statements.created_by',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_billing_statements.id', $id)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->get();

        $billingStatements = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printBillingStatementLoloPinoyGrill', compact('printBillingStatement', 'billingStatements', 'sum'));

        return $pdf->download('lolo-pinoy-grill-billing-statement.pdf');
    }

    public function printPettyCash($id){
       $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.id', $id)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->orderBy('lolo_pinoy_grill_commissary_codes.id', 'desc')
                                ->get();

        $getPettyCashSummaries = LoloPinoyGrillCommissaryPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = LoloPinoyGrillCommissaryPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = LoloPinoyGrillCommissaryPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashLoloPinoyGrill', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
        return $pdf->download('lolo-pinoy-grill-commissary-petty-cash.pdf');
    }

    public function updatePC(Request $request, $id){
        $updatePC = LoloPinoyGrillCommissaryPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashLoloPinoyGrill', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pettyCash = LoloPinoyGrillCommissaryPettyCash::find($id);

        $addNew = new LoloPinoyGrillCommissaryPettyCash([
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

        return redirect()->route('editPettyCashLoloPinoyGrill', ['id'=>$id]);
    }


    public function updatePettyCash(Request $request, $id){
        $updatePettyCash = LoloPinoyGrillCommissaryPettyCash::find($id);
        $updatePettyCash->date = $request->get('date');
        $updatePettyCash->petty_cash_name = $request->get('pettyCashName');
        $updatePettyCash->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePettyCash->save();

        Session::flash('editSuccess', 'Successfully updated.');

        return redirect()->route('editPettyCashLoloPinoyGrill', ['id'=>$id]);

    }

    public function editPettyCash($id){
        $pettyCash = LoloPinoyGrillCommissaryPettyCash::find($id);

        $moduleName = "Petty Cash";
        $pettyCash = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.id', $id)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->get();
      
        $pettyCashSummaries = LoloPinoyGrillCommissaryPettyCash::where('pc_id', $id)->get()->toArray();
        return view('edit-lolo-pinoy-grill-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }

    public function addPettyCash(Request $request){

        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the latest insert id query in table lolo_pinoy_grill_commissary_codes
        $dataCashNo = DB::select('SELECT id, lolo_pinoy_grill_code  FROM lolo_pinoy_grill_commissary_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
        if(isset($dataCashNo[0]->lolo_pinoy_grill_code) != 0){
            //if code is not 0
            $newProd = $dataCashNo[0]->lolo_pinoy_grill_code +1;
            $uPetty = sprintf("%06d",$newProd);   

        }else{
            //if code is 0 
            $newProd = 1;
            $uPetty = sprintf("%06d",$newProd);
        } 

        $addPettyCash = new LoloPinoyGrillCommissaryPettyCash([
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

         //save to lolo_pinoy_grill_commissary_codes table
        $lpGrill = new LoloPinoyGrillCommissaryCode([
            'user_id'=>$user->id,
            'lolo_pinoy_grill_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $lpGrill->save();
      
        return response()->json($insertId);
    }


    public function listPerBranch(){
        $urgelloBranch = "Urgello";
        $velezBranch = "Velez";
        $baniladBranch = "Banilad";
        $gqsBranch = "GQS";

        $getTransactionUrgelloBranches = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $urgelloBranch)->get()->toArray();

        $getTransactionVelezBranches = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $velezBranch)->get()->toArray();

        $getTransactionBaniladBranches = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $baniladBranch)->get()->toArray();

        $getTransactionGqsBranches = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $gqsBranch)->get()->toArray();

        $sumUrgello = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $urgelloBranch)->sum('total_amount_of_sales');
        
        $sumVelez= LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $velezBranch)->sum('total_amount_of_sales');
       
        $sumBanilad= LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $baniladBranch)->sum('total_amount_of_sales');
       
        $sumGqs= LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)->where('branch', $gqsBranch)->sum('total_amount_of_sales');
       
        return view('lolo-pinoy-grill-commissary-list-per-branch' , compact('getTransactionUrgelloBranches',
        'getTransactionVelezBranches', 'getTransactionBaniladBranches', 'getTransactionGqsBranches', 
        'sumUrgello', 'sumVelez', 'sumBanilad', 'sumGqs'));
    }

    public function viewPettyCash($id){
  
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.id', $id)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->get();
      

        $getPettyCashSummaries = LoloPinoyGrillCommissaryPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = LoloPinoyGrillCommissaryPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = LoloPinoyGrillCommissaryPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        return view('lolo-pinoy-grill-commissary-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries','sum'));
    }

    //
    public function viewBills($id){
        //
        $viewBill = LoloPinoyGrillCommissaryUtility::find($id);

        //view particulars
    
        $viewParticulars = LoloPinoyGrillCommissaryPaymentVoucher::where('sub_category_account_id', $id)->get()->toArray();
        return view('lolo-pinoy-grill-commissary-view-utility', compact('viewBill', 'viewParticulars'));
    }

    //ajax call save internet account
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
                'lolo_pinoy_grill_commissary_utilities')
                ->where('account_id', $request->accountId)
                ->get()->first();
        if($target ==  NULL){
            
            $addInternet = new LoloPinoyGrillCommissaryUtility([
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

    //ajax call save
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
                        'lolo_pinoy_grill_commissary_utilities')
                        ->where('account_id', $request->accountId)
                        ->get()->first();

        if($target ==  NULL){
            
            $addBills = new LoloPinoyGrillCommissaryUtility([
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
        //
        $flag = "Veco";
        $flagMCWD = "MCWD";
        $flagInternet = "Internet";

        $vecoDocuments = LoloPinoyGrillCommissaryUtility::where('flag', $flag)->get()->toArray();

        $mcwdDocuments = LoloPinoyGrillCommissaryUtility::where('flag', $flagMCWD)->get()->toArray();

        $internetDocuments = LoloPinoyGrillCommissaryUtility::where('flag', $flagInternet)->get()->toArray();

        return view('lolo-pinoy-grill-commissary-utilities', compact('vecoDocuments', 
        'mcwdDocuments','internetDocuments'));
    }


    public function pettyCashList(){
        $moduleName = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_commissary_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_commissary_petty_cashes.id',
                                'lolo_pinoy_grill_commissary_petty_cashes.user_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.pc_id',
                                'lolo_pinoy_grill_commissary_petty_cashes.date',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_commissary_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_commissary_petty_cashes.amount',
                                'lolo_pinoy_grill_commissary_petty_cashes.created_by',
                                'lolo_pinoy_grill_commissary_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_petty_cashes.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->where('lolo_pinoy_grill_commissary_petty_cashes.deleted_at', NULL)
                                ->orderBy('lolo_pinoy_grill_commissary_codes.id', 'desc')
                                ->get()->toArray();
    
        return view('lolo-pinoy-grill-commissary-petty-cash-list', compact('pettyCashLists'));
    }

    //
    public function production(){
        return view('commissary-production-lolo-pinoy-grill');
    }

    //
    public function printPayables($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.id', $id)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->get();


         //getParticular details
         $getParticulars = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
         $getChequeNumbers = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();
 
         $getCashAmounts = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
         
          $amount1 = LoloPinoyGrillCommissaryPaymentVoucher::where('id', $id)->sum('amount');
          $amount2 = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->sum('amount');
            
          $sum = $amount1 + $amount2;
          
          //
          $chequeAmount1 = LoloPinoyGrillCommissaryPaymentVoucher::where('id', $id)->sum('cheque_amount');
          $chequeAmount2 = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
          
          $sumCheque = $chequeAmount1 + $chequeAmount2;
       

        $pdf = PDF::loadView('printPayablesLoloPinoyGrillCommissary', compact('payableId',  
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));
        
        return $pdf->download('lolo-pinoy-grill-commissary-payment-voucher.pdf');
    }

    //
    public function printSOA($id){
    
        $moduleName = "Statement Of Account";
        $Soa = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.address',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.terms',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.payment_method',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.collection_date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.check_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.or_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.status',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.id', $id)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->get();


        $statementAccounts = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->sum('paid_amount');


          //
        $countAmount = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->sum('paid_amount');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printSOA-lolo-pinoy-grill', compact('Soa', 'statementAccounts', 'sum'));

        return $pdf->download('lolo-pinoy-grill-statement-of-account.pdf');
    }

    //
    public function sAccountUpdate(Request $request, $id){
        //get the main id
        $mainIdSoa = LoloPinoyGrillCommissaryStatementOfAccount::find($request->mainId);
        
        $compute = $mainIdSoa->total_remaining_balance - $request->paidAmount;

        $mainIdSoa->total_remaining_balance = $compute; 
        $mainIdSoa->save();
        
        $statementAccountPaid = LoloPinoyGrillCommissaryStatementOfAccount::find($request->id);

        $statementAccountPaid->paid_amount = $request->paidAmount;
        $statementAccountPaid->status = $request->status;
        $statementAccountPaid->collection_date = $request->collectionDate;
        $statementAccountPaid->check_number = $request->checkNumber;
        $statementAccountPaid->check_amount = $request->checkAmount;
        $statementAccountPaid->or_number = $request->orNumber;
        $statementAccountPaid->payment_method = $request->payment;

        $statementAccountPaid->save();
        
        return response()->json('Success: paid successfully');
        
    }

    //
    public function inventoryStockUpdate(Request $request){

        $updateInventoryStock = LoloPinoyGrillCommissaryRawMaterial::find($request->id);
        $qty = $request->qty;

        $updateInventoryStock->date = $request->date;
        $updateInventoryStock->qty = $qty;
        $updateInventoryStock->unit = $request->unit;
        $updateInventoryStock->status = $request->status;
        $updateInventoryStock->requesting_branch = $request->requestingBranch;
        $updateInventoryStock->cheque_no_issued = $request->chequeNoIssued;
        $updateInventoryStock->remarks = $request->remarks;

        $updateInventoryStock->save();

        $updateRawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($request->mainId);
        $unitPrice = $updateRawMaterial->unit_price; 
      
        $add  = $qty + $updateRawMaterial->in; 

        $compute = $unitPrice * $add; 

        $updateRawMaterial->in = $add;
        $updateRawMaterial->amount = $compute;
        $updateRawMaterial->save();

        return response()->json('Success: Succesfully added a remarks.');
       
    }

    
    public function viewInventoryOfStocks($id){
    
        $viewStockDetail = LoloPinoyGrillCommissaryRawMaterial::find($id);

        //transaction table
        $getViewStockDetails = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', $id)->get()->toArray();

    
        return view('view-lolo-pinoy-grill-commissary-inventory-stock', compact('viewStockDetail', 'getViewStockDetails'));
    }


    public function inventoryOfStocks(){
        //getRawMaterial
         $getRawMaterials = DB::table(
                        'lolo_pinoy_grill_commissary_raw_materials')
                        ->select(
                            'lolo_pinoy_grill_commissary_raw_materials.id',
                            'lolo_pinoy_grill_commissary_raw_materials.user_id',
                            'lolo_pinoy_grill_commissary_raw_materials.rm_id',
                            'lolo_pinoy_grill_commissary_raw_materials.product_name',
                            'lolo_pinoy_grill_commissary_raw_materials.unit_price',
                            'lolo_pinoy_grill_commissary_raw_materials.unit',
                            'lolo_pinoy_grill_commissary_raw_materials.in',
                            'lolo_pinoy_grill_commissary_raw_materials.out',
                            'lolo_pinoy_grill_commissary_raw_materials.stock_amount',
                            'lolo_pinoy_grill_commissary_raw_materials.remaining_stock',
                            'lolo_pinoy_grill_commissary_raw_materials.amount',
                            'lolo_pinoy_grill_commissary_raw_materials.supplier',
                            'lolo_pinoy_grill_commissary_raw_materials.date',
                            'lolo_pinoy_grill_commissary_raw_materials.item',
                            'lolo_pinoy_grill_commissary_raw_materials.description',
                            'lolo_pinoy_grill_commissary_raw_materials.reference_no',
                            'lolo_pinoy_grill_commissary_raw_materials.qty',
                            'lolo_pinoy_grill_commissary_raw_materials.requesting_branch',
                            'lolo_pinoy_grill_commissary_raw_materials.cheque_no_issued',
                            'lolo_pinoy_grill_commissary_raw_materials.status',
                            'lolo_pinoy_grill_commissary_raw_materials.created_by',
                            'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id',
                            'lolo_pinoy_grill_commissary_raw_material_products.branch',
                            'lolo_pinoy_grill_commissary_raw_material_products.product_id_no')
                        ->join('lolo_pinoy_grill_commissary_raw_material_products', 'lolo_pinoy_grill_commissary_raw_materials.id', '=', 'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id')
                        ->where('lolo_pinoy_grill_commissary_raw_materials.rm_id', NULL)
                        ->orderBy('lolo_pinoy_grill_commissary_raw_materials.id', 'desc')
                        ->get()->toArray();


        //count the total stock out amount value
        $countStockAmount = LoloPinoyGrillCommissaryRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', NULL)->sum('amount');
        
        return view('commissary-inventory-of-stocks-lolo-pinoy-grill', compact('getRawMaterials', 'countStockAmount', 'countTotalAmount'));
    }

    public function viewPayableDetails($id){

        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.id', $id)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->get();


        //
        $getViewPaymentDetails = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->get()->toArray();

           //getParticular details
        $getParticulars = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
       

        return view('view-lolo-pinoy-grill-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
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

                    $payables = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
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

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');


        //save payment cheque num and cheque amount
        $addPayment = new LoloPinoyGrillCommissaryPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'invoice_number'=>$request->get('invoiceNo'),
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

        return redirect()->route('editPayablesDetailLoloPinoyGrill', ['id'=>$id]);
    }

    //
    public function editPayablesDetail(Request $request, $id){   
        $transactionList = LoloPinoyGrillCommissaryPaymentVoucher::find($id);
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.id', $id)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->get();

        //
        $getChequeNumbers = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
      

        //getParticular details
        $getParticulars = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      

        //amount
        $amount1 = LoloPinoyGrillCommissaryPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;

        $chequeAmount1 = LoloPinoyGrillCommissaryPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
          
         return view('lolo-pinoy-grill-payables-detail', compact('transactionList', 'getChequeNumbers',
             'getParticulars', 'sum', 'sumCheque', 'getCashAmounts'));
    }

    //
    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'lolo_pinoy_grill_commissary_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_commissary_payment_vouchers.id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.user_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_no',
                            'lolo_pinoy_grill_commissary_payment_vouchers.account_name',
                            'lolo_pinoy_grill_commissary_payment_vouchers.particulars',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_commissary_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_commissary_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.created_by',
                            'lolo_pinoy_grill_commissary_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_commissary_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.voucher_ref_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_commissary_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_commissary_payment_vouchers.status',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_commissary_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_commissary_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_payment_vouchers.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->where('lolo_pinoy_grill_commissary_payment_vouchers.deleted_at', NULL)
                            ->orderBy('lolo_pinoy_grill_commissary_payment_vouchers.id',  'desc')
                            ->get()->toArray();

        //get total amount due
        $status = "FULLY PAID AND RELEASED";
    
        $totalAmoutDue = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');
        
        return view('lolo-pinoy-grill-commissary-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));

    }

    
    public function commissaryDeliveryOutlet(){
        $descriptionDIn = "DELIVERY IN";
        $descriptionDOut = "DELIVERY OUT";

        $getDeliveryOutlets = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', '!=', NULL)->where('description', $descriptionDIn)->get()->toArray();
        $getDeliveryOutletsOuts = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', '!=', NULL)->where('description', $descriptionDOut)->get()->toArray();
        
        
        return view('commissary-delivery-outlet-lolo-pinoy-grill', compact('getDeliveryOutlets', 'getDeliveryOutletsOuts'));
    }

    
    public function viewStockInventory($id){
        
        $viewStockDetail = LoloPinoyGrillCommissaryRawMaterial::find($id);

        //transaction table
        $getViewStockDetails = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', $id)->get()->toArray();

        return view('view-lolo-pinoy-grill-stock-inventory', compact('viewStockDetail', 'getViewStockDetails'));
    }

     
    public function addDIRST(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $rawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($request->id);

        $qty = $request->qty;

         //compute qty times unit price
        $compute  = $qty * $rawMaterial->unit_price;
        $sum = $compute;

        //add the product IN
        $addProduct = $rawMaterial->in + $qty;

        if($request->requestingBranch === NULL){
            $reqBranch = NULL;
        }else{
            $reqBranch = $request->requestingBranch;
        }

        $addDeliveryIn = new LoloPinoyGrillCommissaryRawMaterial([
            'user_id'=>$user->id,
            'rm_id'=>$request->id,
            'description'=>$request->description,
            'date'=>$request->date,
            'item'=>$rawMaterial->product_name,
            'reference_no'=>$request->referenceNum,
            'qty'=>$qty,
            'unit'=>$rawMaterial->unit,
            'amount'=>$sum,
            'status'=>$request->status,
            'cheque_no_issued'=>$request->chequeNo,
            'requesting_branch'=>$reqBranch,
            'created_by'=>$name,
        ]);

        $addDeliveryIn->save();

        $outProduct = 0.00;
        //update IN number of products
        $rawMaterial->in = $addProduct;
        $rawMaterial->out = $outProduct;
        $rawMaterial->remaining_stock = $addProduct;
        $rawMaterial->save();

        return response()->json('Success: Delivery In/Request Stock Out Successfully Added.'); 

    }
    
    public function viewRawMaterialDetails($id){
        $viewRawDetail = DB::table(
                    'lolo_pinoy_grill_commissary_raw_materials')
                    ->select(
                        'lolo_pinoy_grill_commissary_raw_materials.id',
                        'lolo_pinoy_grill_commissary_raw_materials.user_id',
                        'lolo_pinoy_grill_commissary_raw_materials.rm_id',
                        'lolo_pinoy_grill_commissary_raw_materials.product_name',
                        'lolo_pinoy_grill_commissary_raw_materials.unit_price',
                        'lolo_pinoy_grill_commissary_raw_materials.unit',
                        'lolo_pinoy_grill_commissary_raw_materials.in',
                        'lolo_pinoy_grill_commissary_raw_materials.out',
                        'lolo_pinoy_grill_commissary_raw_materials.stock_amount',
                        'lolo_pinoy_grill_commissary_raw_materials.remaining_stock',
                        'lolo_pinoy_grill_commissary_raw_materials.amount',
                        'lolo_pinoy_grill_commissary_raw_materials.supplier',
                        'lolo_pinoy_grill_commissary_raw_materials.date',
                        'lolo_pinoy_grill_commissary_raw_materials.item',
                        'lolo_pinoy_grill_commissary_raw_materials.description',
                        'lolo_pinoy_grill_commissary_raw_materials.reference_no',
                        'lolo_pinoy_grill_commissary_raw_materials.qty',
                        'lolo_pinoy_grill_commissary_raw_materials.requesting_branch',
                        'lolo_pinoy_grill_commissary_raw_materials.cheque_no_issued',
                        'lolo_pinoy_grill_commissary_raw_materials.status',
                        'lolo_pinoy_grill_commissary_raw_materials.created_by',
                        'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id',
                        'lolo_pinoy_grill_commissary_raw_material_products.branch',
                        'lolo_pinoy_grill_commissary_raw_material_products.product_id_no')
                    ->join('lolo_pinoy_grill_commissary_raw_material_products', 'lolo_pinoy_grill_commissary_raw_materials.id', '=', 'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id')
                    ->where('lolo_pinoy_grill_commissary_raw_materials.id', $id)
                    ->get();

        //transaction table
        $getViewRawDetails = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', $id)->get()->toArray();
        
        return view('view-lolo-pinoy-grill-raw-material-details', compact('viewRawDetail', 'getViewRawDetails'));
    }

    //
    public function stocksInventory(){    
        $getRawMaterials = DB::table(
                    'lolo_pinoy_grill_commissary_raw_materials')
                    ->select(
                        'lolo_pinoy_grill_commissary_raw_materials.id',
                        'lolo_pinoy_grill_commissary_raw_materials.user_id',
                        'lolo_pinoy_grill_commissary_raw_materials.rm_id',
                        'lolo_pinoy_grill_commissary_raw_materials.product_name',
                        'lolo_pinoy_grill_commissary_raw_materials.unit_price',
                        'lolo_pinoy_grill_commissary_raw_materials.unit',
                        'lolo_pinoy_grill_commissary_raw_materials.in',
                        'lolo_pinoy_grill_commissary_raw_materials.out',
                        'lolo_pinoy_grill_commissary_raw_materials.stock_amount',
                        'lolo_pinoy_grill_commissary_raw_materials.remaining_stock',
                        'lolo_pinoy_grill_commissary_raw_materials.amount',
                        'lolo_pinoy_grill_commissary_raw_materials.supplier',
                        'lolo_pinoy_grill_commissary_raw_materials.date',
                        'lolo_pinoy_grill_commissary_raw_materials.item',
                        'lolo_pinoy_grill_commissary_raw_materials.description',
                        'lolo_pinoy_grill_commissary_raw_materials.reference_no',
                        'lolo_pinoy_grill_commissary_raw_materials.qty',
                        'lolo_pinoy_grill_commissary_raw_materials.requesting_branch',
                        'lolo_pinoy_grill_commissary_raw_materials.cheque_no_issued',
                        'lolo_pinoy_grill_commissary_raw_materials.status',
                        'lolo_pinoy_grill_commissary_raw_materials.created_by',
                        'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id',
                        'lolo_pinoy_grill_commissary_raw_material_products.branch',
                        'lolo_pinoy_grill_commissary_raw_material_products.product_id_no')
                    ->join('lolo_pinoy_grill_commissary_raw_material_products', 'lolo_pinoy_grill_commissary_raw_materials.id', '=', 'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id')
                    ->where('lolo_pinoy_grill_commissary_raw_materials.rm_id', NULL)
                    ->orderBy('lolo_pinoy_grill_commissary_raw_materials.id', 'desc')
                    ->get()->toArray();


        //count the total stock out amount value
        $countStockAmount = LoloPinoyGrillCommissaryRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryRawMaterial::all()->sum('amount');

        return view('commissary-stocks-inventory-lolo-pinoy-grill', compact('getRawMaterials', 'countStockAmount', 'countTotalAmount'));
    }

    //
    public function updateRawMaterial(Request $request){
        $updateRawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($request->id);

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


    public function addRawMaterial(Request $request){
         $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //
        $dataProductId = DB::select('SELECT id, product_id_no FROM lolo_pinoy_grill_commissary_raw_material_products ORDER BY id DESC LIMIT 1');

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

         //check if product name name exits
         $target = DB::table(
                'lolo_pinoy_grill_commissary_raw_materials')
                ->where('product_name', $request->productName)
                ->get()->first();

                
        if($target  === NULL){
            $addNewRawMaterial = new LoloPinoyGrillCommissaryRawMaterial([
                'user_id'=>$user->id,
                'product_name'=>$request->productName,
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
    
            //save to table lolo_pinoy_grill_commissary_raw_material_products
            $addNewProd = new LoloPinoyGrillCommissaryRawMaterialProduct([
                'raw_materials_id'=>$insertedId,
                'branch'=>$request->branch,
                'product_id_no'=>$uProd,
            ]);
    
            $addNewProd->save();
    
            return response()->json('Success: successfully add RAW material.');    
    
        }else{
            return response()->json('Failed: Already exist.');

        }
       
    }

    public function rawMaterials(){
        
        $getRawMaterials = DB::table(
                            'lolo_pinoy_grill_commissary_raw_materials')
                            ->select(
                                'lolo_pinoy_grill_commissary_raw_materials.id',
                                'lolo_pinoy_grill_commissary_raw_materials.user_id',
                                'lolo_pinoy_grill_commissary_raw_materials.rm_id',
                                'lolo_pinoy_grill_commissary_raw_materials.product_name',
                                'lolo_pinoy_grill_commissary_raw_materials.unit_price',
                                'lolo_pinoy_grill_commissary_raw_materials.unit',
                                'lolo_pinoy_grill_commissary_raw_materials.in',
                                'lolo_pinoy_grill_commissary_raw_materials.out',
                                'lolo_pinoy_grill_commissary_raw_materials.stock_amount',
                                'lolo_pinoy_grill_commissary_raw_materials.remaining_stock',
                                'lolo_pinoy_grill_commissary_raw_materials.amount',
                                'lolo_pinoy_grill_commissary_raw_materials.supplier',
                                'lolo_pinoy_grill_commissary_raw_materials.date',
                                'lolo_pinoy_grill_commissary_raw_materials.item',
                                'lolo_pinoy_grill_commissary_raw_materials.description',
                                'lolo_pinoy_grill_commissary_raw_materials.reference_no',
                                'lolo_pinoy_grill_commissary_raw_materials.qty',
                                'lolo_pinoy_grill_commissary_raw_materials.requesting_branch',
                                'lolo_pinoy_grill_commissary_raw_materials.cheque_no_issued',
                                'lolo_pinoy_grill_commissary_raw_materials.status',
                                'lolo_pinoy_grill_commissary_raw_materials.created_by',
                                'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id',
                                'lolo_pinoy_grill_commissary_raw_material_products.branch',
                                'lolo_pinoy_grill_commissary_raw_material_products.product_id_no')
                            ->join('lolo_pinoy_grill_commissary_raw_material_products', 'lolo_pinoy_grill_commissary_raw_materials.id', '=', 'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id')
                            ->where('lolo_pinoy_grill_commissary_raw_materials.rm_id', NULL)
                            ->orderBy('lolo_pinoy_grill_commissary_raw_materials.id', 'desc')
                            ->get()->toArray();
      
    
        return view('commissary-raw-materials-lolo-pinoy-grill', compact('getRawMaterials'));
    }

    //
    public function viewStatementAccount($id){
        $moduleName = "Statement Of Account";
        $viewStatementAccount = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.address',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.terms',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.payment_method',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.collection_date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.check_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.or_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.status',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.id', $id)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->get();

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

        return view('view-lolo-pinoy-grill-statement-account', compact('viewStatementAccount', 'statementAccounts', 'sum', 'computeAll'));
    }

    //
    public function statementOfAccountList(){
         
        $moduleName = "Statement Of Account";
        $statementOfAccounts = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->orderBy('lolo_pinoy_grill_commissary_statement_of_accounts.id', 'desc')
                        ->get()->toArray();

    $status = "PAID";
    $totalAmount = DB::table(
                            'lolo_pinoy_grill_commissary_statement_of_accounts')
                            ->select(
                                'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                                'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                            ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                            ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                            ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                            ->where('lolo_pinoy_grill_commissary_statement_of_accounts.status', $status)
                            ->sum('lolo_pinoy_grill_commissary_statement_of_accounts.total_amount');
    
        $totalRemainingBalance = DB::table(
                                'lolo_pinoy_grill_commissary_statement_of_accounts')
                                ->select(
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.bs_no',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.total_amount',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                                    'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->where('lolo_pinoy_grill_commissary_statement_of_accounts.status', NULL)
                                ->sum('lolo_pinoy_grill_commissary_statement_of_accounts.total_remaining_balance');
        
        return view('lolo-pinoy-grill-statement-of-account-lists', compact('statementOfAccounts', 
         'totalAmount', 'totalRemainingBalance'));
    }


    //
    public function editStatementOfAccount($id){
    
        $moduleName = "Statement Of Account";
        $getStatementOfAccount = DB::table(
                        'lolo_pinoy_grill_commissary_statement_of_accounts')
                        ->select(
                            'lolo_pinoy_grill_commissary_statement_of_accounts.id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.user_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.billing_statement_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.bill_to',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.dr_no',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.branch',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.period_cover',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.date_of_transaction',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.invoice_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.description',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.unit_price',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.unit',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.product_id',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.order',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.terms',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.status',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.collection_date',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.check_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.check_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.or_number',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.paid_amount',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.payment_method',
                            'lolo_pinoy_grill_commissary_statement_of_accounts.created_by',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_statement_of_accounts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_statement_of_accounts.id', $id)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->get();
        
        
        //AllAcounts not yet paid
       $allAccounts = LoloPinoyGrillCommissaryStatementOfAccount::where('billing_statement_id', $id)->where('status', NULL)->get()->toArray();

       $stat = "PAID";
       $allAccountsPaids = LoloPinoyGrillCommissaryStatementOfAccount::where('billing_statement_id', $id)->where('status', $stat)->get()->toArray();  

        //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryStatementOfAccount::where('id', $id)->sum('amount');

          //
        $countAmount = LoloPinoyGrillCommissaryStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        //count the total balance if there are paid amount
        $paidAmountCount = LoloPinoyGrillCommissaryStatementOfAccount::where('id', $id)->sum('paid_amount');
       
        //
        $countAmountOthersPaid = LoloPinoyGrillCommissaryStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');
        
        $compute  = $paidAmountCount + $countAmountOthersPaid;

        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;
        
        return view('edit-lolo-pinoy-grill-statement-of-account', compact('getStatementOfAccount', 'allAccounts', 'allAccountsPaids', 'sum', 'computeAll'));
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

        $moduleName = "Sales Invoice";
        $viewSalesInvoice = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.id', $id)
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->get()->toArray();
    

        $salesInvoices = LoloPinoyGrillCommissarySalesInvoice::where('si_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissarySalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = LoloPinoyGrillCommissarySalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-lolo-pinoy-grill-sales-invoice', compact('viewSalesInvoice', 'salesInvoices', 'sum'));
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
        return view('add-new-lolo-pinoy-grill-sales-invoice', compact('id'));
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

         //getSalesInvoice
        $getSalesInvoice = LoloPinoyGrillCommissarySalesInvoice::find($id);

        $sInvoices  = LoloPinoyGrillCommissarySalesInvoice::where('si_id', $id)->get()->toArray();

        return view('edit-lolo-pinoy-grill-sales-invoice', compact('getSalesInvoice', 'sInvoices'));
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

        //get the latest insert id query in table lolo_pinoy_grill_commissary
        $dataSalesNo = DB::select('SELECT id, lolo_pinoy_grill_code FROM lolo_pinoy_grill_commissary_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 dr_no
        if(isset($dataSalesNo[0]->lolo_pinoy_grill_code) != 0){
            //if code is not 0
            $newSI = $dataSalesNo[0]->lolo_pinoy_grill_code +1;
            $uSI = sprintf("%06d",$newSI);   

        }else{
            //if code is 0 
            $newSI = 1;
            $uSI = sprintf("%06d",$newSI);
        } 

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
            'date'=>$request->get('date'),
            'qty'=>$request->get('qty'),
            'total_kls'=>$kls,
            'item_description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'amount'=>$sum,
            'created_by'=>$name,
        ]);

        $addSalesInvoice->save();

        $insertedId = $addSalesInvoice->id;

        $moduleCode = "SI-";
        $moduleName = "Sales Invoice";

        //save to lolo_pinoy_grill_commissary_codes table
        $lpGrill = new LoloPinoyGrillCommissaryCode([
            'user_id'=>$user->id,
            'lolo_pinoy_grill_code'=>$uSI,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);

        $lpGrill->save();

        return redirect()->route('editSalesInvoiceLpGrillCommissary', ['id'=>$insertedId]);
        
    }

    //sales invoice
    public function salesInvoiceForm(){
        
        return view('lolo-pinoy-grill-sales-invoice-form');
    }

    //view payment voucher
    public function viewPaymentVoucher($id){
    
         //paymentVoucher
        $paymentVoucher = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        $pVouchers = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->get()->toArray();


         //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryPaymentVoucher::where('id', $id)->sum('amount');

        //
        $countAmount = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-payment-voucher-lolo-pinoy-grill', compact('paymentVoucher', 'pVouchers', 'sum'));
    }

    //cheque vouchers
    public function chequeVouchers(){
        //getAllChequeVouchers
        $method = "Cheque";

        $getAllChequeVouchers = LoloPinoyGrillCommissaryPaymentVoucher::where('method_of_payment', $method)->get()->toArray(); 

        return view('cheque-vouchers-lists-lolo-pinoy-grill', compact('getAllChequeVouchers')); 
    }

    //cash vouchers
    public function cashVouchers(){
        //getAllCashVouchers
        $method = "Cash";

        $getAllCashVouchers = LoloPinoyGrillCommissaryPaymentVoucher::where('method_of_payment', $method)->get()->toArray();

        return view('cash-vouchers-list-lolo-pinoy-grill', compact('getAllCashVouchers'));
    }  

    
    public function updatePV(Request $request, $id){
        $updatePV = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        $updatePV->particulars = $request->get('particulars');
        $updatePV->amount = $request->get('amount');

        $updatePV->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-grill-commissary/edit-lolo-pinoy-grill-payment-voucher/'.$request->get('pvId'));
    }


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



    public function addNewPaymentVoucher($id){
    
        return view('add-new-lolo-pinoy-grill-payment-voucher', compact('id'));
    }   

    
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
     
         //getPaymentVoucher 
        $getPaymentVoucher = LoloPinoyGrillCommissaryPaymentVoucher::find($id);

        //pVoucher
        $pVouchers = LoloPinoyGrillCommissaryPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('edit-payment-voucher-lolo-pinoy-grill', compact('getPaymentVoucher', 'pVouchers'));
    }

    
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

        return redirect()->route('editPayablesDetailLoloPinoyGrill', ['id'=>$id]);

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

         //get the latest insert id query in table lolo pinoy grill commissary code
         $dataCode = DB::select('SELECT id, lolo_pinoy_grill_code FROM lolo_pinoy_grill_commissary_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 reference number
         if(isset($dataCode[0]->lolo_pinoy_grill_code) != 0){
             //if code is not 0
             $newCode= $dataCode[0]->lolo_pinoy_grill_code +1;
             $uCode = sprintf("%06d",$newCode);   
 
         }else{
             //if code is 0 
             $newCode = 1;
             $uCode = sprintf("%06d",$newCode);
         } 
 

       //get the category
       if($request->get('category') === "Petty Cash"){

            $subCat = "NULL";
            $subCatAcctId = "NULL";
            $supplierExp = NULL;
            $supplierExp1 = NULL;
       }else if($request->get('category') === "Utilities"){

            $subCat = $request->get('bills');
            $subCatAcctId = $request->get('selectAccountID');
            $supplierExp = NULL;
            $supplierExp1 = NULL;
       }else if($request->get('category') == "None"){
            $subCat = "NULL";
            $subCatAcctId = "NULL";

            $supplierExp = NULL;
            $supplierExp1 = NULL;
       }else if($request->get('category') == "Payroll"){
            $subCat = "NULL";
            $subCatAcctId = "NULL";
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
                        'lolo_pinoy_grill_commissary_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();
        if ($target === NULL) {
            # code...

            $addPaymentVoucher = new LoloPinoyGrillCommissaryPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'method_of_payment'=>$request->get('paymentMethod'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'issued_date'=>$request->get('issuedDate'),
                'account_name'=>$request->get('accountName'),
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

            $lpGrill =  new LoloPinoyGrillCommissaryCode([
                'user_id'=>$user->id,
                'lolo_pinoy_grill_code'=>$uCode,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
            ]);
            $lpGrill->save();

            return redirect()->route('editPayablesDetailLoloPinoyGrill', ['id'=>$insertedId]);

        }else{
            return redirect()->route('paymentVoucherFormLoloPinoyGril')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    }   


    //payment vouceher form
    public function paymentVoucherForm(){

        //get all flag expect cebu and manila properties
        
        $getAllFlags = LoloPinoyGrillCommissaryUtility::where('u_id', NULL)->get()->toArray();

         //get suppliers
         $suppliers = LoloPinoyGrillCommissarySupplier::get()->toArray();

         $pettyCashes = LoloPinoyGrillCommissaryPettyCash::with(['user', 'petty_cashes'])
                                                    ->where('pc_id', NULL)
                                                    ->where('deleted_at', NULL)
                                                    ->get();
    
        return view('payment-voucher-form-lolo-pinoy-grill', compact('getAllFlags', 'suppliers', 'pettyCashes'));
    }

    //view billing statement
    public function viewBillingStatement($id){
        $moduleName = "Billing Statement";
        $viewBillingStatement = DB::table(
                                'lolo_pinoy_grill_commissary_billing_statements')
                                ->select(
                                    'lolo_pinoy_grill_commissary_billing_statements.id',
                                    'lolo_pinoy_grill_commissary_billing_statements.user_id',
                                    'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                                    'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                                    'lolo_pinoy_grill_commissary_billing_statements.address',
                                    'lolo_pinoy_grill_commissary_billing_statements.date',
                                    'lolo_pinoy_grill_commissary_billing_statements.branch',
                                    'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                                    'lolo_pinoy_grill_commissary_billing_statements.terms',
                                    'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                                    'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                                    'lolo_pinoy_grill_commissary_billing_statements.description',
                                    'lolo_pinoy_grill_commissary_billing_statements.amount',
                                    'lolo_pinoy_grill_commissary_billing_statements.created_by',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_billing_statements.id', $id)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->get();


        $billingStatements = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-lolo-pinoy-grill-commissary-billing-statement', compact('viewBillingStatement', 'billingStatements', 'sum'));
    }


    //billingStatementLists
    public function billingStatementLists(){
        $moduleName = "Billing Statement";
        $billingStatements = DB::table(
                                'lolo_pinoy_grill_commissary_billing_statements')
                                ->select(
                                    'lolo_pinoy_grill_commissary_billing_statements.id',
                                    'lolo_pinoy_grill_commissary_billing_statements.user_id',
                                    'lolo_pinoy_grill_commissary_billing_statements.billing_statement_id',
                                    'lolo_pinoy_grill_commissary_billing_statements.bill_to',
                                    'lolo_pinoy_grill_commissary_billing_statements.address',
                                    'lolo_pinoy_grill_commissary_billing_statements.date',
                                    'lolo_pinoy_grill_commissary_billing_statements.branch',
                                    'lolo_pinoy_grill_commissary_billing_statements.period_cover',
                                    'lolo_pinoy_grill_commissary_billing_statements.terms',
                                    'lolo_pinoy_grill_commissary_billing_statements.date_of_transaction',
                                    'lolo_pinoy_grill_commissary_billing_statements.invoice_number',
                                    'lolo_pinoy_grill_commissary_billing_statements.description',
                                    'lolo_pinoy_grill_commissary_billing_statements.amount',
                                    'lolo_pinoy_grill_commissary_billing_statements.created_by',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_billing_statements.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_billing_statements.billing_statement_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->orderBy('lolo_pinoy_grill_commissary_billing_statements.id', 'desc')
                                ->get();

        return view('lolo-pinoy-grill-commissary-billing-statement-lists', compact('billingStatements'));
    }

    //add new billing statement data
    public function addNewBillingData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = LoloPinoyGrillCommissaryBillingStatement::find($id);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

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

        $addNewBillingStatement = new LoloPinoyGrillCommissaryBillingStatement([
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
            'unit_price'=>$unitPrice,
            'unit'=>$unit,
            'amount'=>$request->get('amount'),
            'total_amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addNewBillingStatement->save();

         //save to table statement of account
         $addStatementAccount =  new LoloPinoyGrillCommissaryStatementOfAccount([
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

        $statementOrder = LoloPinoyGrillCommissaryStatementOfAccount::find($id);
            
        //update
        $billingOrder->total_amount = $tot;
        $billingOrder->save();


        //update soa table
        $statementOrder->total_amount  = $tot;
        $statementOrder->total_remaining_balance = $tot;
        $statementOrder->save();
  
        Session::flash('addBillingSuccess', 'Successfully added.');
        return redirect()->route('editBillingStatementLpGrillComm', ['id'=>$id]);
    
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
        $billingStatement = LoloPinoyGrillCommissaryBillingStatement::find($id);

        $moduleName = "Delivery Receipt";
        $drNos = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->get()->toArray();

        $moduleNameSales = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameSales)
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                ->get()->toArray();
                        

        $bStatements = LoloPinoyGrillCommissaryBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //get the purchase order lists
        $getPurchaseOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', NULL)->get()->toArray();

        return view('edit-lolo-pinoy-grill-commissary-billing-statement', compact('id', 'billingStatement', 
        'getPurchaseOrders', 'bStatements', 'drNos', 'getAllSalesInvoices'));
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
            'description'=>'required',
        ]);

    
        $dataReferenceNum = DB::select('SELECT lolo_pinoy_grill_code FROM lolo_pinoy_grill_commissary_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataReferenceNum[0]->lolo_pinoy_grill_code) != 0){
            //if code is not 0
            $newRefNum = $dataReferenceNum[0]->lolo_pinoy_grill_code +1;
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

            $drno = NULL;
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


        $billingStatement = new LoloPinoyGrillCommissaryBillingStatement([
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

        $loloPinoyGrill = new LoloPinoyGrillCommissaryCode([
            'user_id'=>$user->id,
            'lolo_pinoy_grill_code'=>$uRef,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);

        $loloPinoyGrill->save();
        $bsNo = $loloPinoyGrill->id;
        $bsNoId = LoloPinoyGrillCommissaryCode::find($bsNo);

        $statementAccount = new LoloPinoyGrillCommissaryStatementOfAccount([
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

        $statement = new LoloPinoyGrillCommissaryCode([
            'user_id'=>$user->id,
            'lolo_pinoy_grill_code'=>$uRefState,
            'module_id'=>$insertedIdStatement,
            'module_code'=>$moduleCodeSOA,
            'module_name'=>$moduleNameSOA,
        ]);
        $statement->save();
        
        return redirect()->route('editBillingStatementLpGrillComm', ['id'=>$insertedId]);
        
    }

    //billing statement form
    public function billingStatementForm(){
        $moduleName = "Delivery Receipt";
        $drNos = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->get()->toArray();

        $moduleNameSales = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleNameSales)
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                ->get()->toArray();

        return view('lolo-pinoy-grill-commissary-billing-statement-form', compact('drNos', 'getAllSalesInvoices'));
    }

    
    //purchase order lists
    public function purchaseOrderAllLists(){
        $moduleName = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_purchase_orders.po_id', NULL)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->where('lolo_pinoy_grill_commissary_purchase_orders.deleted_at', NULL)
                        ->orderBy('lolo_pinoy_grill_commissary_purchase_orders.id', 'desc')
                        ->get()->toArray();
   

        return view('lolo-pinoy-grill-commissary-purchase-order-lists', compact('purchaseOrders'));
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
        return redirect()->route('editLoloPinoyGrill', ['id'=>$request->get('poId')]);
    }

    //store add new purchase order
    public function addNewPurchaseOrder(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $pO = LoloPinoyGrillCommissaryPurchaseOrder::find($id);
       
        $amount = $request->get('amount') + $pO->total_price; 
     

        $addNewPurchaseOrder = new LoloPinoyGrillCommissaryPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'p_o_number'=>$pO['p_o_number'],
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $addNewPurchaseOrder->save();

        $pO->total_price = $amount; 
        $pO->save();

        Session::flash('purchaseOrderSuccess', 'Successfully added purchase order');


        return redirect('lolo-pinoy-grill-commissary/add-new/'.$id);
    }

    //add new purchase order
    public function addNew(Request $request, $id){
        return view('add-new-lolo-pinoy-grill-purchase-order', compact('id'));

    }

    //purchase order
    public function purchaseOrder(){
        return view('lolo-pinoy-grill-commissary-purchase-order');
    }


    //printDelivery
    public function printDelivery($id){

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

        $pdf = PDF::loadView('lolo-pinoy-grill-printDelivery', compact('deliveryId', 'deliveryReceipts', 'sum2'));

        return $pdf->download('lolo-pinoy-grill-commissary-delivery-receipt.pdf');
    }

    //view delivery receipt
    public function viewDeliveryReceipt($id){
        $moduleName = "Delivery Receipt";
        $viewDeliveryReceipt = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.id', $id)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->get();
                                

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

        return view('view-lolo-pinoy-grill-commissary-delivery-receipt', compact('viewDeliveryReceipt', 'deliveryReceipts', 'sum', 'sum2'));
    }

    //delivery lists
    public function deliveryReceiptList(){
        $moduleName = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lolo_pinoy_grill_commissary_delivery_receipts')
                                ->select( 
                                'lolo_pinoy_grill_commissary_delivery_receipts.id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.user_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.delivered_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address',
                                'lolo_pinoy_grill_commissary_delivery_receipts.dr_no',
                                'lolo_pinoy_grill_commissary_delivery_receipts.date',
                                'lolo_pinoy_grill_commissary_delivery_receipts.product_id',
                                'lolo_pinoy_grill_commissary_delivery_receipts.qty',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit',
                                'lolo_pinoy_grill_commissary_delivery_receipts.item_description',
                                'lolo_pinoy_grill_commissary_delivery_receipts.unit_price',
                                'lolo_pinoy_grill_commissary_delivery_receipts.amount',
                                'lolo_pinoy_grill_commissary_delivery_receipts.charge_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.address_to',
                                'lolo_pinoy_grill_commissary_delivery_receipts.prepared_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.approved_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.checked_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.received_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.created_by',
                                'lolo_pinoy_grill_commissary_delivery_receipts.deleted_at',
                                'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                'lolo_pinoy_grill_commissary_codes.module_id',
                                'lolo_pinoy_grill_commissary_codes.module_code',
                                'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_delivery_receipts.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.dr_id', NULL)
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->where('lolo_pinoy_grill_commissary_delivery_receipts.deleted_at', NULL)
                                ->orderBy('lolo_pinoy_grill_commissary_delivery_receipts.id', 'desc')
                                ->get()->toArray();
                                    

        return view('lolo-pinoy-grill-commissary-delivery-receipt-list', compact('getAllDeliveryReceipts'));
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
    
        return redirect()->route('editDeliveryReceiptLoloPinoyGrillCommissary', ['id'=>$request->get('drId')]);
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

        $getAmount = $deliveryReceipt->total_amount + $sum;


        $avail = $request->get('productId'); 
        $availExp = explode("-", $avail);


        $rawMaterial = DB::table(
                        'lolo_pinoy_grill_commissary_raw_materials')
                        ->select(
                            'lolo_pinoy_grill_commissary_raw_materials.id',
                            'lolo_pinoy_grill_commissary_raw_materials.user_id',
                            'lolo_pinoy_grill_commissary_raw_materials.rm_id',
                            'lolo_pinoy_grill_commissary_raw_materials.product_name',
                            'lolo_pinoy_grill_commissary_raw_materials.unit_price',
                            'lolo_pinoy_grill_commissary_raw_materials.unit',
                            'lolo_pinoy_grill_commissary_raw_materials.in',
                            'lolo_pinoy_grill_commissary_raw_materials.out',
                            'lolo_pinoy_grill_commissary_raw_materials.stock_amount',
                            'lolo_pinoy_grill_commissary_raw_materials.remaining_stock',
                            'lolo_pinoy_grill_commissary_raw_materials.amount',
                            'lolo_pinoy_grill_commissary_raw_materials.supplier',
                            'lolo_pinoy_grill_commissary_raw_materials.date',
                            'lolo_pinoy_grill_commissary_raw_materials.item',
                            'lolo_pinoy_grill_commissary_raw_materials.description',
                            'lolo_pinoy_grill_commissary_raw_materials.reference_no',
                            'lolo_pinoy_grill_commissary_raw_materials.qty',
                            'lolo_pinoy_grill_commissary_raw_materials.requesting_branch',
                            'lolo_pinoy_grill_commissary_raw_materials.cheque_no_issued',
                            'lolo_pinoy_grill_commissary_raw_materials.status',
                            'lolo_pinoy_grill_commissary_raw_materials.created_by',
                            'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id',
                            'lolo_pinoy_grill_commissary_raw_material_products.branch',
                            'lolo_pinoy_grill_commissary_raw_material_products.product_id_no')
                        ->leftJoin('lolo_pinoy_grill_commissary_raw_material_products', 'lolo_pinoy_grill_commissary_raw_materials.id', '=', 'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id')
                        ->where('lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id', $availExp[0])
                        ->orderBy('lolo_pinoy_grill_commissary_raw_materials.id', 'desc')
                        ->get();

        //minus available pcs from the qty
        $aPcs = $rawMaterial[0]->remaining_stock - $qty;
        
        //add qty to out 
        $out = $rawMaterial[0]->out + $qty;
            
        //compute the stock out amount in unit price
        $stockAmount = $rawMaterial[0]->unit_price * $qty;
            
        //update raw material table
        $updateRawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($availExp[0]);
        
        $updateRawMaterial->out = $out;
        $updateRawMaterial->remaining_stock = $aPcs;
        $updateRawMaterial->stock_amount = $stockAmount;
        $updateRawMaterial->save();


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

        $deliveryReceipt->total_amount  = $getAmount; 
        $deliveryReceipt->save();

        Session::flash('addDeliveryReceiptSuccess', 'Successfully added.');

        return redirect()->route('editDeliveryReceiptLoloPinoyGrillCommissary', ['id'=>$id]);

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
        $updateDeliveryReceipt->charge_to = $request->get('chargeTo');
        $updateDeliveryReceipt->address_to = $request->get('addressTo');
        $updateDeliveryReceipt->amount = $sum;

        $updateDeliveryReceipt->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect()->route('editDeliveryReceiptLoloPinoyGrillCommissary', ['id'=>$id]);
    }

    //edit delivery receipt
    public function editDeliveryReceipt($id){
       
         //getDeliveryReceipt
        $getDeliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);
        
        $getRawMaterials = DB::table(
                        'lolo_pinoy_grill_commissary_raw_materials')
                        ->select(
                            'lolo_pinoy_grill_commissary_raw_materials.id',
                            'lolo_pinoy_grill_commissary_raw_materials.user_id',
                            'lolo_pinoy_grill_commissary_raw_materials.rm_id',
                            'lolo_pinoy_grill_commissary_raw_materials.product_name',
                            'lolo_pinoy_grill_commissary_raw_materials.unit_price',
                            'lolo_pinoy_grill_commissary_raw_materials.unit',
                            'lolo_pinoy_grill_commissary_raw_materials.in',
                            'lolo_pinoy_grill_commissary_raw_materials.out',
                            'lolo_pinoy_grill_commissary_raw_materials.stock_amount',
                            'lolo_pinoy_grill_commissary_raw_materials.remaining_stock',
                            'lolo_pinoy_grill_commissary_raw_materials.amount',
                            'lolo_pinoy_grill_commissary_raw_materials.supplier',
                            'lolo_pinoy_grill_commissary_raw_materials.date',
                            'lolo_pinoy_grill_commissary_raw_materials.item',
                            'lolo_pinoy_grill_commissary_raw_materials.description',
                            'lolo_pinoy_grill_commissary_raw_materials.reference_no',
                            'lolo_pinoy_grill_commissary_raw_materials.qty',
                            'lolo_pinoy_grill_commissary_raw_materials.requesting_branch',
                            'lolo_pinoy_grill_commissary_raw_materials.cheque_no_issued',
                            'lolo_pinoy_grill_commissary_raw_materials.status',
                            'lolo_pinoy_grill_commissary_raw_materials.created_by',
                            'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id',
                            'lolo_pinoy_grill_commissary_raw_material_products.branch',
                            'lolo_pinoy_grill_commissary_raw_material_products.product_id_no')
                        ->join('lolo_pinoy_grill_commissary_raw_material_products', 'lolo_pinoy_grill_commissary_raw_materials.id', '=', 'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id')
                        ->where('lolo_pinoy_grill_commissary_raw_materials.rm_id', NULL)
                        ->orderBy('lolo_pinoy_grill_commissary_raw_materials.id', 'desc')
                        ->get()->toArray();

         //dReceipts
        $dReceipts = LoloPinoyGrillCommissaryDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-lolo-pinoy-grill-commissary-delivery-receipt', compact('id',
        'getDeliveryReceipt', 'dReceipts', 'getRawMaterials'));
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

         //get the latest insert id query in table lolo_pinoy_grill_code
         $dataDrNo = DB::select('SELECT id, lolo_pinoy_grill_code FROM lolo_pinoy_grill_commissary_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 dr_no
        if(isset($dataDrNo[0]->lolo_pinoy_grill_code) != 0){
            //if code is not 0
            $newDr = $dataDrNo[0]->lolo_pinoy_grill_code +1;
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

        $avail = $request->get('productId'); 
        $availExp = explode("-", $avail);
    
        $rawMaterial = DB::table(
                    'lolo_pinoy_grill_commissary_raw_materials')
                    ->select(
                        'lolo_pinoy_grill_commissary_raw_materials.id',
                        'lolo_pinoy_grill_commissary_raw_materials.user_id',
                        'lolo_pinoy_grill_commissary_raw_materials.rm_id',
                        'lolo_pinoy_grill_commissary_raw_materials.product_name',
                        'lolo_pinoy_grill_commissary_raw_materials.unit_price',
                        'lolo_pinoy_grill_commissary_raw_materials.unit',
                        'lolo_pinoy_grill_commissary_raw_materials.in',
                        'lolo_pinoy_grill_commissary_raw_materials.out',
                        'lolo_pinoy_grill_commissary_raw_materials.stock_amount',
                        'lolo_pinoy_grill_commissary_raw_materials.remaining_stock',
                        'lolo_pinoy_grill_commissary_raw_materials.amount',
                        'lolo_pinoy_grill_commissary_raw_materials.supplier',
                        'lolo_pinoy_grill_commissary_raw_materials.date',
                        'lolo_pinoy_grill_commissary_raw_materials.item',
                        'lolo_pinoy_grill_commissary_raw_materials.description',
                        'lolo_pinoy_grill_commissary_raw_materials.reference_no',
                        'lolo_pinoy_grill_commissary_raw_materials.qty',
                        'lolo_pinoy_grill_commissary_raw_materials.requesting_branch',
                        'lolo_pinoy_grill_commissary_raw_materials.cheque_no_issued',
                        'lolo_pinoy_grill_commissary_raw_materials.status',
                        'lolo_pinoy_grill_commissary_raw_materials.created_by',
                        'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id',
                        'lolo_pinoy_grill_commissary_raw_material_products.branch',
                        'lolo_pinoy_grill_commissary_raw_material_products.product_id_no')
                    ->leftJoin('lolo_pinoy_grill_commissary_raw_material_products', 'lolo_pinoy_grill_commissary_raw_materials.id', '=', 'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id')
                    ->where('lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id', $availExp[0])
                    ->orderBy('lolo_pinoy_grill_commissary_raw_materials.id', 'desc')
                    ->get();

        //minus available pcs from the qty
        $aPcs = $rawMaterial[0]->remaining_stock - $qty;
    
        //add qty to out 
        $out = $rawMaterial[0]->out + $qty;

        //compute the stock out amount in unit price
        $stockAmount = $rawMaterial[0]->unit_price * $qty;
       
        //update 
        $updateRawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($availExp[0]);
        
        $updateRawMaterial->out = $out;
        $updateRawMaterial->remaining_stock = $aPcs;
        $updateRawMaterial->stock_amount = $stockAmount;
        $updateRawMaterial->save();

        $storeDeliveryReceipt = new LoloPinoyGrillCommissaryDeliveryReceipt([
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
            'charge_to'=>$request->get('chargeTo'),
            'address_to'=>$request->get('addressTo'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $storeDeliveryReceipt->save();
        $insertedId  = $storeDeliveryReceipt->id;

        $moduleCode = "DR-";
        $moduleName = "Delivery Receipt";

        //save to lolo_pinoy_grill_commissary_codes table
        $lpGrill = new LoloPinoyGrillCommissaryCode([
            'user_id'=>$user->id,
            'lolo_pinoy_grill_code'=>$uDr,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);

        $lpGrill->save();

        return redirect()->route('editDeliveryReceiptLoloPinoyGrillCommissary', ['id'=>$insertedId]);
       
    }

    //delivery receipt
    public function deliveryReceiptForm(){
        
        $getRawMaterials = DB::table(
                    'lolo_pinoy_grill_commissary_raw_materials')
                    ->select(
                        'lolo_pinoy_grill_commissary_raw_materials.id',
                        'lolo_pinoy_grill_commissary_raw_materials.user_id',
                        'lolo_pinoy_grill_commissary_raw_materials.rm_id',
                        'lolo_pinoy_grill_commissary_raw_materials.product_name',
                        'lolo_pinoy_grill_commissary_raw_materials.unit_price',
                        'lolo_pinoy_grill_commissary_raw_materials.unit',
                        'lolo_pinoy_grill_commissary_raw_materials.in',
                        'lolo_pinoy_grill_commissary_raw_materials.out',
                        'lolo_pinoy_grill_commissary_raw_materials.stock_amount',
                        'lolo_pinoy_grill_commissary_raw_materials.remaining_stock',
                        'lolo_pinoy_grill_commissary_raw_materials.amount',
                        'lolo_pinoy_grill_commissary_raw_materials.supplier',
                        'lolo_pinoy_grill_commissary_raw_materials.date',
                        'lolo_pinoy_grill_commissary_raw_materials.item',
                        'lolo_pinoy_grill_commissary_raw_materials.description',
                        'lolo_pinoy_grill_commissary_raw_materials.reference_no',
                        'lolo_pinoy_grill_commissary_raw_materials.qty',
                        'lolo_pinoy_grill_commissary_raw_materials.requesting_branch',
                        'lolo_pinoy_grill_commissary_raw_materials.cheque_no_issued',
                        'lolo_pinoy_grill_commissary_raw_materials.status',
                        'lolo_pinoy_grill_commissary_raw_materials.created_by',
                        'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id',
                        'lolo_pinoy_grill_commissary_raw_material_products.branch',
                        'lolo_pinoy_grill_commissary_raw_material_products.product_id_no')
                    ->join('lolo_pinoy_grill_commissary_raw_material_products', 'lolo_pinoy_grill_commissary_raw_materials.id', '=', 'lolo_pinoy_grill_commissary_raw_material_products.raw_materials_id')
                    ->where('lolo_pinoy_grill_commissary_raw_materials.rm_id', NULL)
                    ->orderBy('lolo_pinoy_grill_commissary_raw_materials.id', 'desc')
                    ->get()->toArray();


        return view('lolo-pinoy-grill-commissary-delivery-receipt-form', compact('getRawMaterials'));
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
                                'lolo_pinoy_grill_commissary_sales_invoices')
                                ->select(
                                    'lolo_pinoy_grill_commissary_sales_invoices.id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.user_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.si_id',
                                    'lolo_pinoy_grill_commissary_sales_invoices.invoice_number',
                                    'lolo_pinoy_grill_commissary_sales_invoices.date',
                                    'lolo_pinoy_grill_commissary_sales_invoices.ordered_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.address',
                                    'lolo_pinoy_grill_commissary_sales_invoices.qty',
                                    'lolo_pinoy_grill_commissary_sales_invoices.total_kls',
                                    'lolo_pinoy_grill_commissary_sales_invoices.item_description',
                                    'lolo_pinoy_grill_commissary_sales_invoices.unit_price',
                                    'lolo_pinoy_grill_commissary_sales_invoices.amount',
                                    'lolo_pinoy_grill_commissary_sales_invoices.created_by',
                                    'lolo_pinoy_grill_commissary_sales_invoices.deleted_at',
                                    'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                                    'lolo_pinoy_grill_commissary_codes.module_id',
                                    'lolo_pinoy_grill_commissary_codes.module_code',
                                    'lolo_pinoy_grill_commissary_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_sales_invoices.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.si_id', NULL)
                                ->orderBy('lolo_pinoy_grill_commissary_sales_invoices.id', 'desc')
                                ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                                ->where('lolo_pinoy_grill_commissary_sales_invoices.deleted_at', NULL)
                                ->get()->toArray();
       

        return view('lolo-pinoy-grill', compact('getAllSalesInvoices'));
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


         $this->validate($request, [
            'paidTo' => 'required',
            'address'=> 'required',
            'quantity'=>'required',
            'description'=>'required',
            'unitPrice'=>'required',
            'amount'=>'required',
        ]);

          //get the latest insert id query in table lolo_pinoy_grill_commissary_codes
          $data = DB::select('SELECT id, lolo_pinoy_grill_code  FROM lolo_pinoy_grill_commissary_codes ORDER BY id DESC LIMIT 1');
        
          //if code is not zero add plus 1
           if(isset($data[0]->lolo_pinoy_grill_code) != 0){
              //if code is not 0
              $newNum = $data[0]->lolo_pinoy_grill_code +1;
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

         $moduleCode = "PO-";
         $moduleName = "Purchase Order";

        //save to lolo_pinoy_grill_commissary_codes table
        $lpGrill = new LoloPinoyGrillCommissaryCode([
            'user_id'=>$user->id,
            'lolo_pinoy_grill_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]); 
        $lpGrill->save();
         
        return redirect()->route('editLoloPinoyGrill', ['id'=>$insertedId]);
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
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_purchase_orders.deleted_at',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_purchase_orders.id', $id)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->get();
   
        $pOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LoloPinoyGrillCommissaryPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-lolo-pinoy-grill-commissary-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $purchaseOrder = LoloPinoyGrillCommissaryPurchaseOrder::find($id);

         $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                        'lolo_pinoy_grill_commissary_purchase_orders')
                        ->select(
                            'lolo_pinoy_grill_commissary_purchase_orders.id',
                            'lolo_pinoy_grill_commissary_purchase_orders.user_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.po_id',
                            'lolo_pinoy_grill_commissary_purchase_orders.paid_to',
                            'lolo_pinoy_grill_commissary_purchase_orders.address',
                            'lolo_pinoy_grill_commissary_purchase_orders.date',
                            'lolo_pinoy_grill_commissary_purchase_orders.quantity',
                            'lolo_pinoy_grill_commissary_purchase_orders.description',
                            'lolo_pinoy_grill_commissary_purchase_orders.unit_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.amount',
                            'lolo_pinoy_grill_commissary_purchase_orders.total_price',
                            'lolo_pinoy_grill_commissary_purchase_orders.requested_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.prepared_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.checked_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.created_by',
                            'lolo_pinoy_grill_commissary_purchase_orders.requesting_branch',
                            'lolo_pinoy_grill_commissary_codes.lolo_pinoy_grill_code',
                            'lolo_pinoy_grill_commissary_codes.module_id',
                            'lolo_pinoy_grill_commissary_codes.module_code',
                            'lolo_pinoy_grill_commissary_codes.module_name')
                        ->join('lolo_pinoy_grill_commissary_codes', 'lolo_pinoy_grill_commissary_purchase_orders.id', '=', 'lolo_pinoy_grill_commissary_codes.module_id')
                        ->where('lolo_pinoy_grill_commissary_purchase_orders.id', $id)
                        ->where('lolo_pinoy_grill_commissary_codes.module_name', $moduleName)
                        ->get();
   

         $pOrders = LoloPinoyGrillCommissaryPurchaseOrder::where('po_id', $id)->get()->toArray();


        return view('edit-lolo-pinoy-grill-commissary-purchase-order', compact('purchaseOrder', 'pOrders'));

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

    public function destroyPO($id){
        $purchaseOrder = LoloPinoyGrillCommissaryPurchaseOrder::find($id);
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
        
        $poId = LoloPinoyGrillCommissaryPurchaseOrder::find($request->poId);

        $purchaseOrder = LoloPinoyGrillCommissaryPurchaseOrder::find($id);
        $getAmount = $poId->total_price - $purchaseOrder->amount;

        $poId->total_price = $getAmount;
        $poId->save();

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

    public function destroyBillingDataStatement(Request $request, $id){
        $billStatement = LoloPinoyGrillCommissaryBillingStatement::find($request->billingStatementId);

        $billingStatement = LoloPinoyGrillCommissaryBillingStatement::find($id);

        $getAmount = $billStatement->total_amount - $billingStatement->amount;
        $billStatement->total_amount = $getAmount;
        $billStatement->save();

        $billingStatement->delete();

    }

    public function destroyBillingStatement($id){
        $billingStatement = LoloPinoyGrillCommissaryBillingStatement::find($id);
        $billingStatement->delete();
    }

    public function destroyDR($id){
        $deliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);
    

        $dR = explode("-", $deliveryReceipt->product_id);
        $expDr = $dR[1];


        $rawMaterialProduct = LoloPinoyGrillCommissaryRawMaterialProduct::find($expDr);
            
        $rawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($rawMaterialProduct->raw_materials_id);
        $calcIn = $rawMaterial->in + $deliveryReceipt->qty;
        $calc =  $rawMaterial->out - $deliveryReceipt->qty; 


        $rawMaterial->out = $calc;
        $rawMaterial->in = $calcIn;
        $rawMaterial->remaining_stock = $calcIn;
        $rawMaterial->save();

        $deliveryReceipt->delete();
    }

    //destroy delivery receipt
    public function destroyDeliveryReceipt(Request $request, $id){
        $drId = LoloPinoyGrillCommissaryDeliveryReceipt::find($request->drId);
      
        $deliveryReceipt = LoloPinoyGrillCommissaryDeliveryReceipt::find($id);
        $dR = explode("-", $deliveryReceipt->product_id);
        $expDr = $dR[1];
        
        $rawMaterialProduct = LoloPinoyGrillCommissaryRawMaterialProduct::find($expDr);
            
        $rawMaterial = LoloPinoyGrillCommissaryRawMaterial::find($rawMaterialProduct->raw_materials_id);
        $calcIn = $rawMaterial->in + $deliveryReceipt->qty;
        $calc =  $rawMaterial->out - $deliveryReceipt->qty; 


        $rawMaterial->out = $calc;
        $rawMaterial->in = $calcIn;
        $rawMaterial->remaining_stock = $calcIn;
        $rawMaterial->save();
    
        $getAmount = $drId->total_amount - $deliveryReceipt->amount; 

        $drId->total_amount = $getAmount; 
        $drId->save();

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

    public function destroyUtility($id){
        $utility = LoloPinoyGrillCommissaryUtility::find($id);
        $utility->delete();
    }

    public function destroyPettyCash($id){
        $pettyCash = LoloPinoyGrillCommissaryPettyCash::find($id);
        $pettyCash->delete();
    }
}
