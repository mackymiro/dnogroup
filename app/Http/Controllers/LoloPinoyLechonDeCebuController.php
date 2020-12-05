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
use App\LechonDeCebuRawMaterialProduct;
use App\LechonDeCebuPettyCash;
use App\LechonDeCebuUtility;
use App\LechonDeCebuCode;
use App\LechonDeCebuSupplier;
use Session;


class LoloPinoyLechonDeCebuController extends Controller
{ 
    
    public function printStocksInventory(){
        $getStockInventories = DB::table(
                'commissary_raw_materials')
                ->select(
                    'commissary_raw_materials.id',
                    'commissary_raw_materials.user_id',
                    'commissary_raw_materials.rm_id',
                    'commissary_raw_materials.product_name',
                    'commissary_raw_materials.unit_price',
                    'commissary_raw_materials.unit',
                    'commissary_raw_materials.in',
                    'commissary_raw_materials.out',
                    'commissary_raw_materials.stock_amount',
                    'commissary_raw_materials.remaining_stock',
                    'commissary_raw_materials.amount',
                    'commissary_raw_materials.supplier',
                    'commissary_raw_materials.date',
                    'commissary_raw_materials.item',
                    'commissary_raw_materials.description',
                    'commissary_raw_materials.reference_no',
                    'commissary_raw_materials.qty',
                    'commissary_raw_materials.requesting_branch',
                    'commissary_raw_materials.cheque_no_issued',
                    'commissary_raw_materials.status',
                    'commissary_raw_materials.created_by',
                    'lechon_de_cebu_raw_material_products.raw_materials_id',
                    'lechon_de_cebu_raw_material_products.branch',
                    'lechon_de_cebu_raw_material_products.product_id_no')
                ->join('lechon_de_cebu_raw_material_products', 'commissary_raw_materials.id', '=', 'lechon_de_cebu_raw_material_products.raw_materials_id')
                ->where('commissary_raw_materials.rm_id', NULL)
                ->orderBy('commissary_raw_materials.id', 'desc')
                ->get()->toArray();

        //count the total amount 
        $countTotalAmount = CommissaryRawMaterial::where('rm_id', NULL)->sum('amount');

        $pdf = PDF::loadView('printStocksInventoryLechonDeCebu', compact('getStockInventories', 'countTotalAmount'));

        return $pdf->download('lechon-de-cebu-stock-inventory.pdf');
    }

    public function printSOAListsPO(){
        
        $moduleName = "Statement Of Account";
        $pO = "Private Order";
        $printSOAStatements = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.bs_no',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.dr_no',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.unit',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.collection_date',
                                    'lechon_de_cebu_statement_of_accounts.check_number',
                                    'lechon_de_cebu_statement_of_accounts.check_amount',
                                    'lechon_de_cebu_statement_of_accounts.or_number',
                                    'lechon_de_cebu_statement_of_accounts.payment_method',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.billing_statement_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_statement_of_accounts.order', $pO)
                                ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                ->get()->toArray(); 
            $status = "PAID";
            $totalAmount = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_statement_of_accounts.status', $status)
                                ->where('lechon_de_cebu_statement_of_accounts.order', $pO)
                                ->sum('lechon_de_cebu_statement_of_accounts.total_amount');

            $totalRemainingBalance = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_statement_of_accounts.status', NULL)
                                ->where('lechon_de_cebu_statement_of_accounts.order', $pO)
                                ->sum('lechon_de_cebu_statement_of_accounts.total_remaining_balance');
                        

        $pdf = PDF::loadView('printSOAListsPO', compact('printSOAStatements', 
        'totalAmount', 'totalRemainingBalance'));

        return $pdf->download('lechon-de-cebu-statement-of-account-list-private-order.pdf');
    }

    public function printSOAListsSsp(){
        $moduleName = "Statement Of Account";
        $sspOrder = "Ssp";
        $printSOAStatements = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.bs_no',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.dr_no',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.unit',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.collection_date',
                                    'lechon_de_cebu_statement_of_accounts.check_number',
                                    'lechon_de_cebu_statement_of_accounts.check_amount',
                                    'lechon_de_cebu_statement_of_accounts.or_number',
                                    'lechon_de_cebu_statement_of_accounts.payment_method',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.billing_statement_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_statement_of_accounts.order', $sspOrder)
                                ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                ->get()->toArray(); 
            $status = "PAID";
            $totalAmount = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_statement_of_accounts.status', $status)
                                ->where('lechon_de_cebu_statement_of_accounts.order', $sspOrder)
                                ->sum('lechon_de_cebu_statement_of_accounts.total_amount');

            $totalRemainingBalance = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_statement_of_accounts.status', NULL)
                                ->where('lechon_de_cebu_statement_of_accounts.order', $sspOrder)
                                ->sum('lechon_de_cebu_statement_of_accounts.total_remaining_balance');
                        

        $pdf = PDF::loadView('printSOALists', compact('printSOAStatements', 
        'totalAmount', 'totalRemainingBalance'));

        return $pdf->download('lechon-de-cebu-statement-of-account-list-ssp.pdf');
    }
   
    public function printSupplier($id){
        $viewSupplier = LechonDeCebuSupplier::where('id', $id)->get();

        $printSuppliers = DB::table(
                    'lechon_de_cebu_payment_vouchers')
                    ->select( 
                    'lechon_de_cebu_payment_vouchers.id',
                    'lechon_de_cebu_payment_vouchers.user_id',
                    'lechon_de_cebu_payment_vouchers.pv_id',
                    'lechon_de_cebu_payment_vouchers.date',
                    'lechon_de_cebu_payment_vouchers.paid_to',
                    'lechon_de_cebu_payment_vouchers.account_no',
                    'lechon_de_cebu_payment_vouchers.account_name',
                    'lechon_de_cebu_payment_vouchers.particulars',
                    'lechon_de_cebu_payment_vouchers.amount',
                    'lechon_de_cebu_payment_vouchers.method_of_payment',
                    'lechon_de_cebu_payment_vouchers.prepared_by',
                    'lechon_de_cebu_payment_vouchers.approved_by',
                    'lechon_de_cebu_payment_vouchers.date_apprroved',
                    'lechon_de_cebu_payment_vouchers.received_by_date',
                    'lechon_de_cebu_payment_vouchers.created_by',
                    'lechon_de_cebu_payment_vouchers.invoice_number',
                    'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                    'lechon_de_cebu_payment_vouchers.issued_date',
                    'lechon_de_cebu_payment_vouchers.category',
                    'lechon_de_cebu_payment_vouchers.amount_due',
                    'lechon_de_cebu_payment_vouchers.delivered_date',
                    'lechon_de_cebu_payment_vouchers.status',
                    'lechon_de_cebu_payment_vouchers.cheque_number',
                    'lechon_de_cebu_payment_vouchers.cheque_amount',
                    'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                    'lechon_de_cebu_payment_vouchers.sub_category',
                    'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                    'lechon_de_cebu_payment_vouchers.supplier_name',
                    'lechon_de_cebu_payment_vouchers.deleted_at',
                    'lechon_de_cebu_suppliers.id',
                    'lechon_de_cebu_suppliers.date',
                    'lechon_de_cebu_suppliers.supplier_name')
                    ->leftJoin('lechon_de_cebu_suppliers', 'lechon_de_cebu_payment_vouchers.supplier_id', '=', 'lechon_de_cebu_suppliers.id')
                    ->where('lechon_de_cebu_suppliers.id', $id)
                    ->get()->toArray();

    $status = "FULLY PAID AND RELEASED";
    $totalAmountDue = DB::table(
                        'lechon_de_cebu_payment_vouchers')
                        ->select( 
                        'lechon_de_cebu_payment_vouchers.id',
                        'lechon_de_cebu_payment_vouchers.user_id',
                        'lechon_de_cebu_payment_vouchers.pv_id',
                        'lechon_de_cebu_payment_vouchers.date',
                        'lechon_de_cebu_payment_vouchers.paid_to',
                        'lechon_de_cebu_payment_vouchers.account_no',
                        'lechon_de_cebu_payment_vouchers.account_name',
                        'lechon_de_cebu_payment_vouchers.particulars',
                        'lechon_de_cebu_payment_vouchers.amount',
                        'lechon_de_cebu_payment_vouchers.method_of_payment',
                        'lechon_de_cebu_payment_vouchers.prepared_by',
                        'lechon_de_cebu_payment_vouchers.approved_by',
                        'lechon_de_cebu_payment_vouchers.date_apprroved',
                        'lechon_de_cebu_payment_vouchers.received_by_date',
                        'lechon_de_cebu_payment_vouchers.created_by',
                        'lechon_de_cebu_payment_vouchers.invoice_number',
                        'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                        'lechon_de_cebu_payment_vouchers.issued_date',
                        'lechon_de_cebu_payment_vouchers.category',
                        'lechon_de_cebu_payment_vouchers.amount_due',
                        'lechon_de_cebu_payment_vouchers.delivered_date',
                        'lechon_de_cebu_payment_vouchers.status',
                        'lechon_de_cebu_payment_vouchers.cheque_number',
                        'lechon_de_cebu_payment_vouchers.cheque_amount',
                        'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                        'lechon_de_cebu_payment_vouchers.sub_category',
                        'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                        'lechon_de_cebu_payment_vouchers.supplier_id',
                        'lechon_de_cebu_payment_vouchers.supplier_name',
                        'lechon_de_cebu_payment_vouchers.deleted_at',
                        'lechon_de_cebu_suppliers.id',
                        'lechon_de_cebu_suppliers.date',
                        'lechon_de_cebu_suppliers.supplier_name')
                        ->leftJoin('lechon_de_cebu_suppliers', 'lechon_de_cebu_payment_vouchers.supplier_id', '=', 'lechon_de_cebu_suppliers.id')
                        ->where('lechon_de_cebu_suppliers.id', $id)
                        ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                        ->sum('lechon_de_cebu_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSupplierLechonDeCebu', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('lechon-de-cebu-supplier.pdf');

    }
    
    public function viewSupplier($id){
        $viewSupplier = LechonDeCebuSupplier::where('id', $id)->get();
        
        $supplierLists = DB::table(
                            'lechon_de_cebu_payment_vouchers')
                            ->select( 
                            'lechon_de_cebu_payment_vouchers.id',
                            'lechon_de_cebu_payment_vouchers.user_id',
                            'lechon_de_cebu_payment_vouchers.pv_id',
                            'lechon_de_cebu_payment_vouchers.date',
                            'lechon_de_cebu_payment_vouchers.paid_to',
                            'lechon_de_cebu_payment_vouchers.account_no',
                            'lechon_de_cebu_payment_vouchers.account_name',
                            'lechon_de_cebu_payment_vouchers.particulars',
                            'lechon_de_cebu_payment_vouchers.amount',
                            'lechon_de_cebu_payment_vouchers.method_of_payment',
                            'lechon_de_cebu_payment_vouchers.prepared_by',
                            'lechon_de_cebu_payment_vouchers.approved_by',
                            'lechon_de_cebu_payment_vouchers.date_apprroved',
                            'lechon_de_cebu_payment_vouchers.received_by_date',
                            'lechon_de_cebu_payment_vouchers.created_by',
                            'lechon_de_cebu_payment_vouchers.invoice_number',
                            'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                            'lechon_de_cebu_payment_vouchers.issued_date',
                            'lechon_de_cebu_payment_vouchers.category',
                            'lechon_de_cebu_payment_vouchers.amount_due',
                            'lechon_de_cebu_payment_vouchers.delivered_date',
                            'lechon_de_cebu_payment_vouchers.status',
                            'lechon_de_cebu_payment_vouchers.supplier_id',
                            'lechon_de_cebu_payment_vouchers.cheque_number',
                            'lechon_de_cebu_payment_vouchers.cheque_amount',
                            'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                            'lechon_de_cebu_payment_vouchers.sub_category',
                            'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                            'lechon_de_cebu_payment_vouchers.supplier_name',
                            'lechon_de_cebu_payment_vouchers.deleted_at',
                            'lechon_de_cebu_suppliers.date',
                            'lechon_de_cebu_suppliers.supplier_name')
                            ->leftJoin('lechon_de_cebu_suppliers', 'lechon_de_cebu_payment_vouchers.supplier_id', '=', 'lechon_de_cebu_suppliers.id')
                            ->where('lechon_de_cebu_suppliers.id', $id)
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
                                'lechon_de_cebu_payment_vouchers')
                                ->select( 
                                'lechon_de_cebu_payment_vouchers.id',
                                'lechon_de_cebu_payment_vouchers.user_id',
                                'lechon_de_cebu_payment_vouchers.pv_id',
                                'lechon_de_cebu_payment_vouchers.date',
                                'lechon_de_cebu_payment_vouchers.paid_to',
                                'lechon_de_cebu_payment_vouchers.account_no',
                                'lechon_de_cebu_payment_vouchers.account_name',
                                'lechon_de_cebu_payment_vouchers.particulars',
                                'lechon_de_cebu_payment_vouchers.amount',
                                'lechon_de_cebu_payment_vouchers.method_of_payment',
                                'lechon_de_cebu_payment_vouchers.prepared_by',
                                'lechon_de_cebu_payment_vouchers.approved_by',
                                'lechon_de_cebu_payment_vouchers.date_apprroved',
                                'lechon_de_cebu_payment_vouchers.received_by_date',
                                'lechon_de_cebu_payment_vouchers.created_by',
                                'lechon_de_cebu_payment_vouchers.invoice_number',
                                'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                'lechon_de_cebu_payment_vouchers.issued_date',
                                'lechon_de_cebu_payment_vouchers.category',
                                'lechon_de_cebu_payment_vouchers.amount_due',
                                'lechon_de_cebu_payment_vouchers.delivered_date',
                                'lechon_de_cebu_payment_vouchers.status',
                                'lechon_de_cebu_payment_vouchers.cheque_number',
                                'lechon_de_cebu_payment_vouchers.cheque_amount',
                                'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                'lechon_de_cebu_payment_vouchers.sub_category',
                                'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                'lechon_de_cebu_payment_vouchers.supplier_id',
                                'lechon_de_cebu_payment_vouchers.supplier_name',
                                'lechon_de_cebu_payment_vouchers.deleted_at',
                                'lechon_de_cebu_suppliers.id',
                                'lechon_de_cebu_suppliers.date',
                                'lechon_de_cebu_suppliers.supplier_name')
                                ->leftJoin('lechon_de_cebu_suppliers', 'lechon_de_cebu_payment_vouchers.supplier_id', '=', 'lechon_de_cebu_suppliers.id')
                                ->where('lechon_de_cebu_suppliers.id', $id)
                                ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                                ->sum('lechon_de_cebu_payment_vouchers.amount_due');

      
    
        return view('view-lechon-de-cebu-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue'));
    }

    public function addSupplier(Request $request){

        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


        //check if supplier name exits
        $target = DB::table(
                'lechon_de_cebu_suppliers')
                ->where('supplier_name', $request->supplierName)
                ->get()->first();

        if($target === NULL){
            $supplier = new LechonDeCebuSupplier([
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
        $suppliers = LechonDeCebuSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('lechon-de-cebu-supplier', compact('suppliers'));
    }

    public function updateDetails(Request $request){
        $updateDetail = LechonDeCebuPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = LechonDeCebuPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){  
        $updateCheck = LechonDeCebuPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
         //main id 
         $updateParticular = LechonDeCebuPaymentVoucher::find($request->transId);

         //particular id
         $uIdParticular = LechonDeCebuPaymentVoucher::find($request->id);

         $amount = $request->amount; 

         $updateAmount =  $updateParticular->amount; 
        
         $uParticular = LechonDeCebuPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
         
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
        $updateParticular =  LechonDeCebuPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = LechonDeCebuPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 
 
        $updateParticular->date = $request->date;
        $updateParticular->invoice_number = $request->invoiceN;
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
                        'lechon_de_cebu_sales_invoices')
                        ->select(
                            'lechon_de_cebu_sales_invoices.id',
                            'lechon_de_cebu_sales_invoices.user_id',
                            'lechon_de_cebu_sales_invoices.si_id',
                            'lechon_de_cebu_sales_invoices.invoice_number',
                            'lechon_de_cebu_sales_invoices.date',
                            'lechon_de_cebu_sales_invoices.ordered_by',
                            'lechon_de_cebu_sales_invoices.address',
                            'lechon_de_cebu_sales_invoices.qty',
                            'lechon_de_cebu_sales_invoices.total_kls',
                            'lechon_de_cebu_sales_invoices.body',
                            'lechon_de_cebu_sales_invoices.head_and_feet',
                            'lechon_de_cebu_sales_invoices.item_description',
                            'lechon_de_cebu_sales_invoices.unit_price',
                            'lechon_de_cebu_sales_invoices.amount',
                            'lechon_de_cebu_sales_invoices.total_amount',
                            'lechon_de_cebu_sales_invoices.created_by',
                            'lechon_de_cebu_sales_invoices.created_at',
                            'lechon_de_cebu_sales_invoices.updated_at',  
                            'lechon_de_cebu_sales_invoices.deleted_at',                            
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                        ->whereBetween('lechon_de_cebu_sales_invoices.created_at', [$uri0, $uri1])
                        ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                        ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                        ->get()->toArray();

        $totalSalesInvoice = DB::table(
                            'lechon_de_cebu_sales_invoices')
                            ->select(
                                'lechon_de_cebu_sales_invoices.id',
                                'lechon_de_cebu_sales_invoices.user_id',
                                'lechon_de_cebu_sales_invoices.si_id',
                                'lechon_de_cebu_sales_invoices.invoice_number',
                                'lechon_de_cebu_sales_invoices.date',
                                'lechon_de_cebu_sales_invoices.ordered_by',
                                'lechon_de_cebu_sales_invoices.address',
                                'lechon_de_cebu_sales_invoices.qty',
                                'lechon_de_cebu_sales_invoices.total_kls',
                                'lechon_de_cebu_sales_invoices.body',
                                'lechon_de_cebu_sales_invoices.head_and_feet',
                                'lechon_de_cebu_sales_invoices.item_description',
                                'lechon_de_cebu_sales_invoices.unit_price',
                                'lechon_de_cebu_sales_invoices.amount',
                                'lechon_de_cebu_sales_invoices.total_amount',
                                'lechon_de_cebu_sales_invoices.created_by',
                                'lechon_de_cebu_sales_invoices.created_at',
                                'lechon_de_cebu_sales_invoices.updated_at',   
                                'lechon_de_cebu_sales_invoices.deleted_at',                            
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->whereBetween('lechon_de_cebu_sales_invoices.created_at', [$uri0, $uri1])
                            ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                            ->sum('lechon_de_cebu_sales_invoices.total_amount');


          //Delivery Receipt
          $moduleNameDelivery = "Delivery Receipt";
          $getAllDeliveryReceipts = DB::table(
                                  'lechon_de_cebu_delivery_receipts')
                                  ->select( 
                                  'lechon_de_cebu_delivery_receipts.id',
                                  'lechon_de_cebu_delivery_receipts.user_id',
                                  'lechon_de_cebu_delivery_receipts.dr_id',
                                  'lechon_de_cebu_delivery_receipts.sold_to',
                                  'lechon_de_cebu_delivery_receipts.delivered_to',
                                  'lechon_de_cebu_delivery_receipts.time',
                                  'lechon_de_cebu_delivery_receipts.date',
                                  'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                  'lechon_de_cebu_delivery_receipts.contact_person',
                                  'lechon_de_cebu_delivery_receipts.mobile_num',
                                  'lechon_de_cebu_delivery_receipts.qty',
                                  'lechon_de_cebu_delivery_receipts.description',
                                  'lechon_de_cebu_delivery_receipts.price',
                                  'lechon_de_cebu_delivery_receipts.total',
                                  'lechon_de_cebu_delivery_receipts.special_instruction',
                                  'lechon_de_cebu_delivery_receipts.consignee_name',
                                  'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                  'lechon_de_cebu_delivery_receipts.prepared_by',
                                  'lechon_de_cebu_delivery_receipts.checked_by',
                                  'lechon_de_cebu_delivery_receipts.received_by',
                                  'lechon_de_cebu_delivery_receipts.duplicate_status',
                                  'lechon_de_cebu_delivery_receipts.created_by',
                                  'lechon_de_cebu_delivery_receipts.deleted_at',
                                  'lechon_de_cebu_codes.lechon_de_cebu_code',
                                  'lechon_de_cebu_codes.module_id',
                                  'lechon_de_cebu_codes.module_code',
                                  'lechon_de_cebu_codes.module_name')
                                  ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                  ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                  ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                  ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                  ->whereBetween('lechon_de_cebu_delivery_receipts.created_at', [$uri0, $uri1])
                                  ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                  ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                  ->get()->toArray();
  
          //total for delivery receipt
          $totalDeliveryReceipt = DB::table(
                                  'lechon_de_cebu_delivery_receipts')
                                  ->select( 
                                  'lechon_de_cebu_delivery_receipts.id',
                                  'lechon_de_cebu_delivery_receipts.user_id',
                                  'lechon_de_cebu_delivery_receipts.dr_id',
                                  'lechon_de_cebu_delivery_receipts.sold_to',
                                  'lechon_de_cebu_delivery_receipts.delivered_to',
                                  'lechon_de_cebu_delivery_receipts.time',
                                  'lechon_de_cebu_delivery_receipts.date',
                                  'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                  'lechon_de_cebu_delivery_receipts.contact_person',
                                  'lechon_de_cebu_delivery_receipts.mobile_num',
                                  'lechon_de_cebu_delivery_receipts.qty',
                                  'lechon_de_cebu_delivery_receipts.description',
                                  'lechon_de_cebu_delivery_receipts.price',
                                  'lechon_de_cebu_delivery_receipts.total',
                                  'lechon_de_cebu_delivery_receipts.special_instruction',
                                  'lechon_de_cebu_delivery_receipts.consignee_name',
                                  'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                  'lechon_de_cebu_delivery_receipts.prepared_by',
                                  'lechon_de_cebu_delivery_receipts.checked_by',
                                  'lechon_de_cebu_delivery_receipts.received_by',
                                  'lechon_de_cebu_delivery_receipts.duplicate_status',
                                  'lechon_de_cebu_delivery_receipts.created_by',
                                  'lechon_de_cebu_delivery_receipts.deleted_at',
                                  'lechon_de_cebu_codes.lechon_de_cebu_code',
                                  'lechon_de_cebu_codes.module_id',
                                  'lechon_de_cebu_codes.module_code',
                                  'lechon_de_cebu_codes.module_name')
                                  ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                  ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                  ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                  ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                  ->whereBetween('lechon_de_cebu_delivery_receipts.created_at', [$uri0, $uri1])
                                  ->sum('lechon_de_cebu_delivery_receipts.total');
 
 
         //purchase order
         $moduleNamePurchaseOrder = "Purchase Order";
         $purchaseOrders = DB::table(
                         'lechon_de_cebu_purchase_orders')
                         ->select(
                             'lechon_de_cebu_purchase_orders.id',
                             'lechon_de_cebu_purchase_orders.user_id',
                             'lechon_de_cebu_purchase_orders.po_id',
                             'lechon_de_cebu_purchase_orders.paid_to',
                             'lechon_de_cebu_purchase_orders.address',
                             'lechon_de_cebu_purchase_orders.date',
                             'lechon_de_cebu_purchase_orders.quantity',
                             'lechon_de_cebu_purchase_orders.total_kls',
                             'lechon_de_cebu_purchase_orders.description',
                             'lechon_de_cebu_purchase_orders.unit_price',
                             'lechon_de_cebu_purchase_orders.amount',
                             'lechon_de_cebu_purchase_orders.total_price',
                             'lechon_de_cebu_purchase_orders.requested_by',
                             'lechon_de_cebu_purchase_orders.prepared_by',
                             'lechon_de_cebu_purchase_orders.checked_by',
                             'lechon_de_cebu_purchase_orders.created_by',
                             'lechon_de_cebu_purchase_orders.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                         ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                         ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                         ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                         ->whereBetween('lechon_de_cebu_purchase_orders.created_at', [$uri0, $uri1])
                         ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                         ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                         ->get()->toArray();
 
         $totalPOrder = DB::table(
                             'lechon_de_cebu_purchase_orders')
                             ->select(
                                 'lechon_de_cebu_purchase_orders.id',
                                 'lechon_de_cebu_purchase_orders.user_id',
                                 'lechon_de_cebu_purchase_orders.po_id',
                                 'lechon_de_cebu_purchase_orders.paid_to',
                                 'lechon_de_cebu_purchase_orders.address',
                                 'lechon_de_cebu_purchase_orders.date',
                                 'lechon_de_cebu_purchase_orders.quantity',
                                 'lechon_de_cebu_purchase_orders.total_kls',
                                 'lechon_de_cebu_purchase_orders.description',
                                 'lechon_de_cebu_purchase_orders.unit_price',
                                 'lechon_de_cebu_purchase_orders.amount',
                                 'lechon_de_cebu_purchase_orders.total_price',
                                 'lechon_de_cebu_purchase_orders.requested_by',
                                 'lechon_de_cebu_purchase_orders.prepared_by',
                                 'lechon_de_cebu_purchase_orders.checked_by',
                                 'lechon_de_cebu_purchase_orders.created_by',
                                 'lechon_de_cebu_purchase_orders.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                             ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                             ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                             ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                             ->whereBetween('lechon_de_cebu_purchase_orders.created_at', [$uri0, $uri1])
                             ->sum('lechon_de_cebu_purchase_orders.total_price');
         
           //statement of account
           $moduleNameSOA = "Statement Of Account";
           $statementOfAccounts = DB::table(
                                   'lechon_de_cebu_statement_of_accounts')
                                   ->select(
                                       'lechon_de_cebu_statement_of_accounts.id',
                                       'lechon_de_cebu_statement_of_accounts.user_id',
                                       'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                       'lechon_de_cebu_statement_of_accounts.bill_to',
                                       'lechon_de_cebu_statement_of_accounts.bs_no',
                                       'lechon_de_cebu_statement_of_accounts.address',
                                       'lechon_de_cebu_statement_of_accounts.date',
                                       'lechon_de_cebu_statement_of_accounts.branch',
                                       'lechon_de_cebu_statement_of_accounts.period_cover',
                                       'lechon_de_cebu_statement_of_accounts.terms',
                                       'lechon_de_cebu_statement_of_accounts.transaction_date',
                                       'lechon_de_cebu_statement_of_accounts.invoice_number',
                                       'lechon_de_cebu_statement_of_accounts.order',
                                       'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                       'lechon_de_cebu_statement_of_accounts.description',
                                       'lechon_de_cebu_statement_of_accounts.amount',
                                       'lechon_de_cebu_statement_of_accounts.paid_amount',
                                        'lechon_de_cebu_statement_of_accounts.status',
                                       'lechon_de_cebu_statement_of_accounts.total_amount',
                                       'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                       'lechon_de_cebu_statement_of_accounts.created_by',
                                       'lechon_de_cebu_codes.lechon_de_cebu_code',
                                       'lechon_de_cebu_codes.module_id',
                                       'lechon_de_cebu_codes.module_code',
                                       'lechon_de_cebu_codes.module_name')
                                   ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                   ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                   ->where('lechon_de_cebu_codes.module_name', $moduleNameSOA)
                                   ->whereBetween('lechon_de_cebu_statement_of_accounts.created_at', [$uri0, $uri1])
                                   ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                   ->get()->toArray();
 
 
         //billing statement
         $moduleNameBillingStatement = "Billing Statement";
         $billingStatements = DB::table(
                                 'lechon_de_cebu_billing_statements')
                                 ->select(
                                     'lechon_de_cebu_billing_statements.id',
                                     'lechon_de_cebu_billing_statements.user_id',
                                     'lechon_de_cebu_billing_statements.billing_statement_id',
                                     'lechon_de_cebu_billing_statements.bill_to',
                                     'lechon_de_cebu_billing_statements.address',
                                     'lechon_de_cebu_billing_statements.date',
                                     'lechon_de_cebu_billing_statements.branch',
                                     'lechon_de_cebu_billing_statements.period_cover',
                                     'lechon_de_cebu_billing_statements.terms',
                                     'lechon_de_cebu_billing_statements.date_of_transaction',
                                     'lechon_de_cebu_billing_statements.invoice_number',
                                     'lechon_de_cebu_billing_statements.order',
                                     'lechon_de_cebu_billing_statements.whole_lechon',
                                     'lechon_de_cebu_billing_statements.description',
                                     'lechon_de_cebu_billing_statements.amount',
                                     'lechon_de_cebu_billing_statements.total_amount',
                                     'lechon_de_cebu_billing_statements.paid_amount',
                                     'lechon_de_cebu_billing_statements.created_by',
                                     'lechon_de_cebu_billing_statements.deleted_at',
                                     'lechon_de_cebu_codes.lechon_de_cebu_code',
                                     'lechon_de_cebu_codes.module_id',
                                     'lechon_de_cebu_codes.module_code',
                                     'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                 ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                 ->whereBetween('lechon_de_cebu_billing_statements.created_at', [$uri0, $uri1])
                                 ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                 ->get()->toArray();
         
         $totalBStatement = DB::table(
                                     'lechon_de_cebu_billing_statements')
                                     ->select(
                                         'lechon_de_cebu_billing_statements.id',
                                         'lechon_de_cebu_billing_statements.user_id',
                                         'lechon_de_cebu_billing_statements.billing_statement_id',
                                         'lechon_de_cebu_billing_statements.bill_to',
                                         'lechon_de_cebu_billing_statements.address',
                                         'lechon_de_cebu_billing_statements.date',
                                         'lechon_de_cebu_billing_statements.branch',
                                         'lechon_de_cebu_billing_statements.period_cover',
                                         'lechon_de_cebu_billing_statements.terms',
                                         'lechon_de_cebu_billing_statements.date_of_transaction',
                                         'lechon_de_cebu_billing_statements.invoice_number',
                                         'lechon_de_cebu_billing_statements.order',
                                         'lechon_de_cebu_billing_statements.whole_lechon',
                                         'lechon_de_cebu_billing_statements.description',
                                         'lechon_de_cebu_billing_statements.amount',
                                         'lechon_de_cebu_billing_statements.total_amount',
                                         'lechon_de_cebu_billing_statements.paid_amount',
                                         'lechon_de_cebu_billing_statements.created_by',
                                         'lechon_de_cebu_billing_statements.deleted_at',
                                         'lechon_de_cebu_codes.lechon_de_cebu_code',
                                         'lechon_de_cebu_codes.module_id',
                                         'lechon_de_cebu_codes.module_code',
                                         'lechon_de_cebu_codes.module_name')
                                     ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                     ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                     ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                     ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                     ->whereBetween('lechon_de_cebu_billing_statements.created_at', [$uri0, $uri1])
                                     ->sum('lechon_de_cebu_billing_statements.total_amount');
         
              
          //petty cash
          $moduleNamePettyCash = "Petty Cash";
          $pettyCashLists = DB::table(
                                  'lechon_de_cebu_petty_cashes')
                                  ->select( 
                                  'lechon_de_cebu_petty_cashes.id',
                                  'lechon_de_cebu_petty_cashes.user_id',
                                  'lechon_de_cebu_petty_cashes.pc_id',
                                  'lechon_de_cebu_petty_cashes.date',
                                  'lechon_de_cebu_petty_cashes.petty_cash_name',
                                  'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                  'lechon_de_cebu_petty_cashes.amount',
                                  'lechon_de_cebu_petty_cashes.created_by',
                                  'lechon_de_cebu_petty_cashes.deleted_at',
                                  'lechon_de_cebu_codes.lechon_de_cebu_code',
                                  'lechon_de_cebu_codes.module_id',
                                  'lechon_de_cebu_codes.module_code',
                                  'lechon_de_cebu_codes.module_name')
                                  ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                  ->where('lechon_de_cebu_petty_cashes.pc_id', NULL)
                                  ->where('lechon_de_cebu_codes.module_name', $moduleNamePettyCash)
                                  ->where('lechon_de_cebu_petty_cashes.deleted_at', NULL)
                                  ->whereBetween('lechon_de_cebu_petty_cashes.created_at', [$uri0, $uri1])
                                  ->orderBy('lechon_de_cebu_petty_cashes.id', 'desc')
                                  ->get()->toArray();
 
 
          //payment voucher
      
         //payment voucher
         $moduleNameVoucher = "Payment Voucher";
         $cash = "CASH";
         $getTransactionListCashes = DB::table(
                                 'lechon_de_cebu_payment_vouchers')
                                 ->select( 
                                 'lechon_de_cebu_payment_vouchers.id',
                                 'lechon_de_cebu_payment_vouchers.user_id',
                                 'lechon_de_cebu_payment_vouchers.pv_id',
                                 'lechon_de_cebu_payment_vouchers.date',
                                 'lechon_de_cebu_payment_vouchers.paid_to',
                                 'lechon_de_cebu_payment_vouchers.account_no',
                                 'lechon_de_cebu_payment_vouchers.account_name',
                                 'lechon_de_cebu_payment_vouchers.particulars',
                                 'lechon_de_cebu_payment_vouchers.amount',
                                 'lechon_de_cebu_payment_vouchers.method_of_payment',
                                 'lechon_de_cebu_payment_vouchers.prepared_by',
                                 'lechon_de_cebu_payment_vouchers.approved_by',
                                 'lechon_de_cebu_payment_vouchers.date_apprroved',
                                 'lechon_de_cebu_payment_vouchers.received_by_date',
                                 'lechon_de_cebu_payment_vouchers.created_by',
                                 'lechon_de_cebu_payment_vouchers.invoice_number',
                                 'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                 'lechon_de_cebu_payment_vouchers.issued_date',
                                 'lechon_de_cebu_payment_vouchers.category',
                                 'lechon_de_cebu_payment_vouchers.amount_due',
                                 'lechon_de_cebu_payment_vouchers.delivered_date',
                                 'lechon_de_cebu_payment_vouchers.status',
                                 'lechon_de_cebu_payment_vouchers.cheque_number',
                                 'lechon_de_cebu_payment_vouchers.cheque_amount',
                                 'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                 'lechon_de_cebu_payment_vouchers.sub_category',
                                 'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                 'lechon_de_cebu_payment_vouchers.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                 ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$uri0, $uri1])
                                 ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                 ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                                 ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                 ->get()->toArray();
            $check = "CHECK";
            $getTransactionListChecks = DB::table(
                                        'lechon_de_cebu_payment_vouchers')
                                        ->select( 
                                        'lechon_de_cebu_payment_vouchers.id',
                                        'lechon_de_cebu_payment_vouchers.user_id',
                                        'lechon_de_cebu_payment_vouchers.pv_id',
                                        'lechon_de_cebu_payment_vouchers.date',
                                        'lechon_de_cebu_payment_vouchers.paid_to',
                                        'lechon_de_cebu_payment_vouchers.account_no',
                                        'lechon_de_cebu_payment_vouchers.account_name',
                                        'lechon_de_cebu_payment_vouchers.particulars',
                                        'lechon_de_cebu_payment_vouchers.amount',
                                        'lechon_de_cebu_payment_vouchers.method_of_payment',
                                        'lechon_de_cebu_payment_vouchers.prepared_by',
                                        'lechon_de_cebu_payment_vouchers.approved_by',
                                        'lechon_de_cebu_payment_vouchers.date_apprroved',
                                        'lechon_de_cebu_payment_vouchers.received_by_date',
                                        'lechon_de_cebu_payment_vouchers.created_by',
                                        'lechon_de_cebu_payment_vouchers.invoice_number',
                                        'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                        'lechon_de_cebu_payment_vouchers.issued_date',
                                        'lechon_de_cebu_payment_vouchers.category',
                                        'lechon_de_cebu_payment_vouchers.amount_due',
                                        'lechon_de_cebu_payment_vouchers.delivered_date',
                                        'lechon_de_cebu_payment_vouchers.status',
                                        'lechon_de_cebu_payment_vouchers.cheque_number',
                                        'lechon_de_cebu_payment_vouchers.cheque_amount',
                                        'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                        'lechon_de_cebu_payment_vouchers.sub_category',
                                        'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                        'lechon_de_cebu_payment_vouchers.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                        ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                        ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$uri0, $uri1])
                                        ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                        ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                        ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                        ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                        ->get()->toArray();
       
        $status = "FULLY PAID AND RELEASED"; 
         $totalPaymentVoucherCash = DB::table(
                             'lechon_de_cebu_payment_vouchers')
                             ->select( 
                             'lechon_de_cebu_payment_vouchers.id',
                             'lechon_de_cebu_payment_vouchers.user_id',
                             'lechon_de_cebu_payment_vouchers.pv_id',
                             'lechon_de_cebu_payment_vouchers.date',
                             'lechon_de_cebu_payment_vouchers.paid_to',
                             'lechon_de_cebu_payment_vouchers.account_no',
                             'lechon_de_cebu_payment_vouchers.account_name',
                             'lechon_de_cebu_payment_vouchers.particulars',
                             'lechon_de_cebu_payment_vouchers.amount',
                             'lechon_de_cebu_payment_vouchers.method_of_payment',
                             'lechon_de_cebu_payment_vouchers.prepared_by',
                             'lechon_de_cebu_payment_vouchers.approved_by',
                             'lechon_de_cebu_payment_vouchers.date_apprroved',
                             'lechon_de_cebu_payment_vouchers.received_by_date',
                             'lechon_de_cebu_payment_vouchers.created_by',
                             'lechon_de_cebu_payment_vouchers.invoice_number',
                             'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                             'lechon_de_cebu_payment_vouchers.issued_date',
                             'lechon_de_cebu_payment_vouchers.category',
                             'lechon_de_cebu_payment_vouchers.amount_due',
                             'lechon_de_cebu_payment_vouchers.delivered_date',
                             'lechon_de_cebu_payment_vouchers.status',
                             'lechon_de_cebu_payment_vouchers.cheque_number',
                             'lechon_de_cebu_payment_vouchers.cheque_amount',
                             'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                             'lechon_de_cebu_payment_vouchers.sub_category',
                             'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                             'lechon_de_cebu_payment_vouchers.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                             ->join('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                             ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$uri0, $uri1])
                             ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                             ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                             ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                             ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                             ->sum('lechon_de_cebu_payment_vouchers.amount_due');

        $totalPaymentVoucherCheck = DB::table(
                                'lechon_de_cebu_payment_vouchers')
                                ->select( 
                                'lechon_de_cebu_payment_vouchers.id',
                                'lechon_de_cebu_payment_vouchers.user_id',
                                'lechon_de_cebu_payment_vouchers.pv_id',
                                'lechon_de_cebu_payment_vouchers.date',
                                'lechon_de_cebu_payment_vouchers.paid_to',
                                'lechon_de_cebu_payment_vouchers.account_no',
                                'lechon_de_cebu_payment_vouchers.account_name',
                                'lechon_de_cebu_payment_vouchers.particulars',
                                'lechon_de_cebu_payment_vouchers.amount',
                                'lechon_de_cebu_payment_vouchers.method_of_payment',
                                'lechon_de_cebu_payment_vouchers.prepared_by',
                                'lechon_de_cebu_payment_vouchers.approved_by',
                                'lechon_de_cebu_payment_vouchers.date_apprroved',
                                'lechon_de_cebu_payment_vouchers.received_by_date',
                                'lechon_de_cebu_payment_vouchers.created_by',
                                'lechon_de_cebu_payment_vouchers.invoice_number',
                                'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                'lechon_de_cebu_payment_vouchers.issued_date',
                                'lechon_de_cebu_payment_vouchers.category',
                                'lechon_de_cebu_payment_vouchers.amount_due',
                                'lechon_de_cebu_payment_vouchers.delivered_date',
                                'lechon_de_cebu_payment_vouchers.status',
                                'lechon_de_cebu_payment_vouchers.cheque_number',
                                'lechon_de_cebu_payment_vouchers.cheque_amount',
                                'lechon_de_cebu_payment_vouchers.sub_category',
                                'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                'lechon_de_cebu_payment_vouchers.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                                ->sum('lechon_de_cebu_payment_vouchers.amount_due');
         
        
        $totalPaidAmountCheck  = DB::table(
                                    'lechon_de_cebu_payment_vouchers')
                                    ->select( 
                                    'lechon_de_cebu_payment_vouchers.id',
                                    'lechon_de_cebu_payment_vouchers.user_id',
                                    'lechon_de_cebu_payment_vouchers.pv_id',
                                    'lechon_de_cebu_payment_vouchers.date',
                                    'lechon_de_cebu_payment_vouchers.paid_to',
                                    'lechon_de_cebu_payment_vouchers.account_no',
                                    'lechon_de_cebu_payment_vouchers.account_name',
                                    'lechon_de_cebu_payment_vouchers.particulars',
                                    'lechon_de_cebu_payment_vouchers.amount',
                                    'lechon_de_cebu_payment_vouchers.method_of_payment',
                                    'lechon_de_cebu_payment_vouchers.prepared_by',
                                    'lechon_de_cebu_payment_vouchers.approved_by',
                                    'lechon_de_cebu_payment_vouchers.date_apprroved',
                                    'lechon_de_cebu_payment_vouchers.received_by_date',
                                    'lechon_de_cebu_payment_vouchers.created_by',
                                    'lechon_de_cebu_payment_vouchers.invoice_number',
                                    'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                    'lechon_de_cebu_payment_vouchers.issued_date',
                                    'lechon_de_cebu_payment_vouchers.category',
                                    'lechon_de_cebu_payment_vouchers.amount_due',
                                    'lechon_de_cebu_payment_vouchers.delivered_date',
                                    'lechon_de_cebu_payment_vouchers.status',
                                    'lechon_de_cebu_payment_vouchers.cheque_number',
                                    'lechon_de_cebu_payment_vouchers.cheque_amount',
                                    'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                    'lechon_de_cebu_payment_vouchers.sub_category',
                                    'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                    'lechon_de_cebu_payment_vouchers.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                    ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$uri0, $uri1])
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                    ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                    ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                    ->where('lechon_de_cebu_payment_vouchers.status', $status)
                                    ->sum('lechon_de_cebu_payment_vouchers.cheque_total_amount');


        $pdf = PDF::loadView('printSummary',  compact('date', 'uri0', 'uri1', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 'totalPOrder', 'totalBStatement', 
        'totalPaymentVoucherCash','totalPaymentVoucherCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lechon-de-cebu-summary-report.pdf');

    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'lechon_de_cebu_sales_invoices')
                        ->select(
                            'lechon_de_cebu_sales_invoices.id',
                            'lechon_de_cebu_sales_invoices.user_id',
                            'lechon_de_cebu_sales_invoices.si_id',
                            'lechon_de_cebu_sales_invoices.invoice_number',
                            'lechon_de_cebu_sales_invoices.date',
                            'lechon_de_cebu_sales_invoices.ordered_by',
                            'lechon_de_cebu_sales_invoices.address',
                            'lechon_de_cebu_sales_invoices.qty',
                            'lechon_de_cebu_sales_invoices.total_kls',
                            'lechon_de_cebu_sales_invoices.body',
                            'lechon_de_cebu_sales_invoices.head_and_feet',
                            'lechon_de_cebu_sales_invoices.item_description',
                            'lechon_de_cebu_sales_invoices.unit_price',
                            'lechon_de_cebu_sales_invoices.amount',
                            'lechon_de_cebu_sales_invoices.total_amount',
                            'lechon_de_cebu_sales_invoices.created_by',
                            'lechon_de_cebu_sales_invoices.created_at',
                            'lechon_de_cebu_sales_invoices.updated_at',  
                            'lechon_de_cebu_sales_invoices.deleted_at',                            
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                        ->whereBetween('lechon_de_cebu_sales_invoices.created_at', [$startDate, $endDate])
                        ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                        ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                        ->get()->toArray();

            $totalSalesInvoice = DB::table(
                            'lechon_de_cebu_sales_invoices')
                            ->select(
                                'lechon_de_cebu_sales_invoices.id',
                                'lechon_de_cebu_sales_invoices.user_id',
                                'lechon_de_cebu_sales_invoices.si_id',
                                'lechon_de_cebu_sales_invoices.invoice_number',
                                'lechon_de_cebu_sales_invoices.date',
                                'lechon_de_cebu_sales_invoices.ordered_by',
                                'lechon_de_cebu_sales_invoices.address',
                                'lechon_de_cebu_sales_invoices.qty',
                                'lechon_de_cebu_sales_invoices.total_kls',
                                'lechon_de_cebu_sales_invoices.body',
                                'lechon_de_cebu_sales_invoices.head_and_feet',
                                'lechon_de_cebu_sales_invoices.item_description',
                                'lechon_de_cebu_sales_invoices.unit_price',
                                'lechon_de_cebu_sales_invoices.amount',
                                'lechon_de_cebu_sales_invoices.total_amount',
                                'lechon_de_cebu_sales_invoices.created_by',
                                'lechon_de_cebu_sales_invoices.created_at',
                                'lechon_de_cebu_sales_invoices.updated_at',   
                                'lechon_de_cebu_sales_invoices.deleted_at',                            
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->whereBetween('lechon_de_cebu_sales_invoices.created_at', [$startDate, $endDate])
                            ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                            ->sum('lechon_de_cebu_sales_invoices.total_amount');


         //Delivery Receipt
         $moduleNameDelivery = "Delivery Receipt";
         $getAllDeliveryReceipts = DB::table(
                                 'lechon_de_cebu_delivery_receipts')
                                 ->select( 
                                 'lechon_de_cebu_delivery_receipts.id',
                                 'lechon_de_cebu_delivery_receipts.user_id',
                                 'lechon_de_cebu_delivery_receipts.dr_id',
                                 'lechon_de_cebu_delivery_receipts.sold_to',
                                 'lechon_de_cebu_delivery_receipts.delivered_to',
                                 'lechon_de_cebu_delivery_receipts.time',
                                 'lechon_de_cebu_delivery_receipts.date',
                                 'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                 'lechon_de_cebu_delivery_receipts.contact_person',
                                 'lechon_de_cebu_delivery_receipts.mobile_num',
                                 'lechon_de_cebu_delivery_receipts.qty',
                                 'lechon_de_cebu_delivery_receipts.description',
                                 'lechon_de_cebu_delivery_receipts.price',
                                 'lechon_de_cebu_delivery_receipts.total',
                                 'lechon_de_cebu_delivery_receipts.special_instruction',
                                 'lechon_de_cebu_delivery_receipts.consignee_name',
                                 'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                 'lechon_de_cebu_delivery_receipts.prepared_by',
                                 'lechon_de_cebu_delivery_receipts.checked_by',
                                 'lechon_de_cebu_delivery_receipts.received_by',
                                 'lechon_de_cebu_delivery_receipts.duplicate_status',
                                 'lechon_de_cebu_delivery_receipts.created_by',
                                 'lechon_de_cebu_delivery_receipts.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                 ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                 ->whereBetween('lechon_de_cebu_delivery_receipts.created_at', [$startDate, $endDate])
                                 ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                 ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                 ->get()->toArray();
 
         //total for delivery receipt
         $totalDeliveryReceipt = DB::table(
                                 'lechon_de_cebu_delivery_receipts')
                                 ->select( 
                                 'lechon_de_cebu_delivery_receipts.id',
                                 'lechon_de_cebu_delivery_receipts.user_id',
                                 'lechon_de_cebu_delivery_receipts.dr_id',
                                 'lechon_de_cebu_delivery_receipts.sold_to',
                                 'lechon_de_cebu_delivery_receipts.delivered_to',
                                 'lechon_de_cebu_delivery_receipts.time',
                                 'lechon_de_cebu_delivery_receipts.date',
                                 'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                 'lechon_de_cebu_delivery_receipts.contact_person',
                                 'lechon_de_cebu_delivery_receipts.mobile_num',
                                 'lechon_de_cebu_delivery_receipts.qty',
                                 'lechon_de_cebu_delivery_receipts.description',
                                 'lechon_de_cebu_delivery_receipts.price',
                                 'lechon_de_cebu_delivery_receipts.total',
                                 'lechon_de_cebu_delivery_receipts.special_instruction',
                                 'lechon_de_cebu_delivery_receipts.consignee_name',
                                 'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                 'lechon_de_cebu_delivery_receipts.prepared_by',
                                 'lechon_de_cebu_delivery_receipts.checked_by',
                                 'lechon_de_cebu_delivery_receipts.received_by',
                                 'lechon_de_cebu_delivery_receipts.duplicate_status',
                                 'lechon_de_cebu_delivery_receipts.created_by',
                                 'lechon_de_cebu_delivery_receipts.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                 ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                 ->whereBetween('lechon_de_cebu_delivery_receipts.created_at', [$startDate, $endDate])
                                 ->sum('lechon_de_cebu_delivery_receipts.total');


        //purchase order
        $moduleNamePurchaseOrder = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lechon_de_cebu_purchase_orders')
                        ->select(
                            'lechon_de_cebu_purchase_orders.id',
                            'lechon_de_cebu_purchase_orders.user_id',
                            'lechon_de_cebu_purchase_orders.po_id',
                            'lechon_de_cebu_purchase_orders.paid_to',
                            'lechon_de_cebu_purchase_orders.address',
                            'lechon_de_cebu_purchase_orders.date',
                            'lechon_de_cebu_purchase_orders.quantity',
                            'lechon_de_cebu_purchase_orders.total_kls',
                            'lechon_de_cebu_purchase_orders.description',
                            'lechon_de_cebu_purchase_orders.unit_price',
                            'lechon_de_cebu_purchase_orders.amount',
                            'lechon_de_cebu_purchase_orders.total_price',
                            'lechon_de_cebu_purchase_orders.requested_by',
                            'lechon_de_cebu_purchase_orders.prepared_by',
                            'lechon_de_cebu_purchase_orders.checked_by',
                            'lechon_de_cebu_purchase_orders.created_by',
                            'lechon_de_cebu_purchase_orders.deleted_at',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                        ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                        ->whereBetween('lechon_de_cebu_purchase_orders.created_at', [$startDate, $endDate])
                        ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                        ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                        ->get()->toArray();

        $totalPOrder = DB::table(
                            'lechon_de_cebu_purchase_orders')
                            ->select(
                                'lechon_de_cebu_purchase_orders.id',
                                'lechon_de_cebu_purchase_orders.user_id',
                                'lechon_de_cebu_purchase_orders.po_id',
                                'lechon_de_cebu_purchase_orders.paid_to',
                                'lechon_de_cebu_purchase_orders.address',
                                'lechon_de_cebu_purchase_orders.date',
                                'lechon_de_cebu_purchase_orders.quantity',
                                'lechon_de_cebu_purchase_orders.total_kls',
                                'lechon_de_cebu_purchase_orders.description',
                                'lechon_de_cebu_purchase_orders.unit_price',
                                'lechon_de_cebu_purchase_orders.amount',
                                'lechon_de_cebu_purchase_orders.total_price',
                                'lechon_de_cebu_purchase_orders.requested_by',
                                'lechon_de_cebu_purchase_orders.prepared_by',
                                'lechon_de_cebu_purchase_orders.checked_by',
                                'lechon_de_cebu_purchase_orders.created_by',
                                'lechon_de_cebu_purchase_orders.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                            ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                            ->whereBetween('lechon_de_cebu_purchase_orders.created_at', [$startDate, $endDate])
                            ->sum('lechon_de_cebu_purchase_orders.total_price');
        
          //statement of account
          $moduleNameSOA = "Statement Of Account";
          $statementOfAccounts = DB::table(
                                  'lechon_de_cebu_statement_of_accounts')
                                  ->select(
                                      'lechon_de_cebu_statement_of_accounts.id',
                                      'lechon_de_cebu_statement_of_accounts.user_id',
                                      'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                      'lechon_de_cebu_statement_of_accounts.bill_to',
                                      'lechon_de_cebu_statement_of_accounts.bs_no',
                                      'lechon_de_cebu_statement_of_accounts.address',
                                      'lechon_de_cebu_statement_of_accounts.date',
                                      'lechon_de_cebu_statement_of_accounts.branch',
                                      'lechon_de_cebu_statement_of_accounts.period_cover',
                                      'lechon_de_cebu_statement_of_accounts.terms',
                                      'lechon_de_cebu_statement_of_accounts.transaction_date',
                                      'lechon_de_cebu_statement_of_accounts.invoice_number',
                                      'lechon_de_cebu_statement_of_accounts.order',
                                      'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                      'lechon_de_cebu_statement_of_accounts.description',
                                      'lechon_de_cebu_statement_of_accounts.amount',
                                      'lechon_de_cebu_statement_of_accounts.paid_amount',
                                      'lechon_de_cebu_statement_of_accounts.status',
                                      'lechon_de_cebu_statement_of_accounts.total_amount',
                                      'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                      'lechon_de_cebu_statement_of_accounts.created_by',
                                      'lechon_de_cebu_codes.lechon_de_cebu_code',
                                      'lechon_de_cebu_codes.module_id',
                                      'lechon_de_cebu_codes.module_code',
                                      'lechon_de_cebu_codes.module_name')
                                  ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                  ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                  ->where('lechon_de_cebu_codes.module_name', $moduleNameSOA)
                                  ->whereBetween('lechon_de_cebu_statement_of_accounts.created_at', [$startDate, $endDate])
                                  ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                  ->get()->toArray();


        //billing statement
        $moduleNameBillingStatement = "Billing Statement";
        $billingStatements = DB::table(
                                'lechon_de_cebu_billing_statements')
                                ->select(
                                    'lechon_de_cebu_billing_statements.id',
                                    'lechon_de_cebu_billing_statements.user_id',
                                    'lechon_de_cebu_billing_statements.billing_statement_id',
                                    'lechon_de_cebu_billing_statements.bill_to',
                                    'lechon_de_cebu_billing_statements.address',
                                    'lechon_de_cebu_billing_statements.date',
                                    'lechon_de_cebu_billing_statements.branch',
                                    'lechon_de_cebu_billing_statements.period_cover',
                                    'lechon_de_cebu_billing_statements.terms',
                                    'lechon_de_cebu_billing_statements.date_of_transaction',
                                    'lechon_de_cebu_billing_statements.invoice_number',
                                    'lechon_de_cebu_billing_statements.order',
                                    'lechon_de_cebu_billing_statements.whole_lechon',
                                    'lechon_de_cebu_billing_statements.description',
                                    'lechon_de_cebu_billing_statements.amount',
                                    'lechon_de_cebu_billing_statements.total_amount',
                                    'lechon_de_cebu_billing_statements.paid_amount',
                                    'lechon_de_cebu_billing_statements.created_by',
                                    'lechon_de_cebu_billing_statements.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                ->whereBetween('lechon_de_cebu_billing_statements.created_at', [$startDate, $endDate])
                                ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                ->get()->toArray();
        
        $totalBStatement = DB::table(
                                    'lechon_de_cebu_billing_statements')
                                    ->select(
                                        'lechon_de_cebu_billing_statements.id',
                                        'lechon_de_cebu_billing_statements.user_id',
                                        'lechon_de_cebu_billing_statements.billing_statement_id',
                                        'lechon_de_cebu_billing_statements.bill_to',
                                        'lechon_de_cebu_billing_statements.address',
                                        'lechon_de_cebu_billing_statements.date',
                                        'lechon_de_cebu_billing_statements.branch',
                                        'lechon_de_cebu_billing_statements.period_cover',
                                        'lechon_de_cebu_billing_statements.terms',
                                        'lechon_de_cebu_billing_statements.date_of_transaction',
                                        'lechon_de_cebu_billing_statements.invoice_number',
                                        'lechon_de_cebu_billing_statements.order',
                                        'lechon_de_cebu_billing_statements.whole_lechon',
                                        'lechon_de_cebu_billing_statements.description',
                                        'lechon_de_cebu_billing_statements.amount',
                                        'lechon_de_cebu_billing_statements.total_amount',
                                        'lechon_de_cebu_billing_statements.paid_amount',
                                        'lechon_de_cebu_billing_statements.created_by',
                                        'lechon_de_cebu_billing_statements.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                    ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                    ->whereBetween('lechon_de_cebu_billing_statements.created_at', [$startDate, $endDate])
                                    ->sum('lechon_de_cebu_billing_statements.total_amount');
        
             
         //petty cash
         $moduleNamePettyCash = "Petty Cash";
         $pettyCashLists = DB::table(
                                 'lechon_de_cebu_petty_cashes')
                                 ->select( 
                                 'lechon_de_cebu_petty_cashes.id',
                                 'lechon_de_cebu_petty_cashes.user_id',
                                 'lechon_de_cebu_petty_cashes.pc_id',
                                 'lechon_de_cebu_petty_cashes.date',
                                 'lechon_de_cebu_petty_cashes.petty_cash_name',
                                 'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                 'lechon_de_cebu_petty_cashes.amount',
                                 'lechon_de_cebu_petty_cashes.created_by',
                                 'lechon_de_cebu_petty_cashes.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_petty_cashes.pc_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNamePettyCash)
                                 ->where('lechon_de_cebu_petty_cashes.deleted_at', NULL)
                                 ->whereBetween('lechon_de_cebu_petty_cashes.created_at', [$startDate, $endDate])
                                 ->orderBy('lechon_de_cebu_petty_cashes.id', 'desc')
                                 ->get()->toArray();


         //payment voucher
         $moduleNameVoucher = "Payment Voucher";
         $getTransactionLists = DB::table(
                                 'lechon_de_cebu_payment_vouchers')
                                 ->select( 
                                 'lechon_de_cebu_payment_vouchers.id',
                                 'lechon_de_cebu_payment_vouchers.user_id',
                                 'lechon_de_cebu_payment_vouchers.pv_id',
                                 'lechon_de_cebu_payment_vouchers.date',
                                 'lechon_de_cebu_payment_vouchers.paid_to',
                                 'lechon_de_cebu_payment_vouchers.account_no',
                                 'lechon_de_cebu_payment_vouchers.account_name',
                                 'lechon_de_cebu_payment_vouchers.particulars',
                                 'lechon_de_cebu_payment_vouchers.amount',
                                 'lechon_de_cebu_payment_vouchers.method_of_payment',
                                 'lechon_de_cebu_payment_vouchers.prepared_by',
                                 'lechon_de_cebu_payment_vouchers.approved_by',
                                 'lechon_de_cebu_payment_vouchers.date_apprroved',
                                 'lechon_de_cebu_payment_vouchers.received_by_date',
                                 'lechon_de_cebu_payment_vouchers.created_by',
                                 'lechon_de_cebu_payment_vouchers.invoice_number',
                                 'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                 'lechon_de_cebu_payment_vouchers.issued_date',
                                 'lechon_de_cebu_payment_vouchers.category',
                                 'lechon_de_cebu_payment_vouchers.amount_due',
                                 'lechon_de_cebu_payment_vouchers.delivered_date',
                                 'lechon_de_cebu_payment_vouchers.status',
                                 'lechon_de_cebu_payment_vouchers.cheque_number',
                                 'lechon_de_cebu_payment_vouchers.cheque_amount',
                                 'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                 'lechon_de_cebu_payment_vouchers.sub_category',
                                 'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                 'lechon_de_cebu_payment_vouchers.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                 ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$startDate, $endDate])
                                 ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                 ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                 ->get()->toArray();
       
             $cash = "CASH";
             $getTransactionListCashes = DB::table(
                                     'lechon_de_cebu_payment_vouchers')
                                     ->select( 
                                     'lechon_de_cebu_payment_vouchers.id',
                                     'lechon_de_cebu_payment_vouchers.user_id',
                                     'lechon_de_cebu_payment_vouchers.pv_id',
                                     'lechon_de_cebu_payment_vouchers.date',
                                     'lechon_de_cebu_payment_vouchers.paid_to',
                                     'lechon_de_cebu_payment_vouchers.account_no',
                                     'lechon_de_cebu_payment_vouchers.account_name',
                                     'lechon_de_cebu_payment_vouchers.particulars',
                                     'lechon_de_cebu_payment_vouchers.amount',
                                     'lechon_de_cebu_payment_vouchers.method_of_payment',
                                     'lechon_de_cebu_payment_vouchers.prepared_by',
                                     'lechon_de_cebu_payment_vouchers.approved_by',
                                     'lechon_de_cebu_payment_vouchers.date_apprroved',
                                     'lechon_de_cebu_payment_vouchers.received_by_date',
                                     'lechon_de_cebu_payment_vouchers.created_by',
                                     'lechon_de_cebu_payment_vouchers.invoice_number',
                                     'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                     'lechon_de_cebu_payment_vouchers.issued_date',
                                     'lechon_de_cebu_payment_vouchers.category',
                                     'lechon_de_cebu_payment_vouchers.amount_due',
                                     'lechon_de_cebu_payment_vouchers.delivered_date',
                                     'lechon_de_cebu_payment_vouchers.status',
                                     'lechon_de_cebu_payment_vouchers.cheque_number',
                                     'lechon_de_cebu_payment_vouchers.cheque_amount',
                                     'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                     'lechon_de_cebu_payment_vouchers.sub_category',
                                     'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                     'lechon_de_cebu_payment_vouchers.deleted_at',
                                     'lechon_de_cebu_codes.lechon_de_cebu_code',
                                     'lechon_de_cebu_codes.module_id',
                                     'lechon_de_cebu_codes.module_code',
                                     'lechon_de_cebu_codes.module_name')
                                     ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                     ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                     ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$startDate, $endDate])
                                     ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                     ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                     ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                                     ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                     ->get()->toArray();
                                     
             $status = "FULLY PAID AND RELEASED";
             $totalAmountCashes = DB::table(
                                         'lechon_de_cebu_payment_vouchers')
                                         ->select( 
                                         'lechon_de_cebu_payment_vouchers.id',
                                         'lechon_de_cebu_payment_vouchers.user_id',
                                         'lechon_de_cebu_payment_vouchers.pv_id',
                                         'lechon_de_cebu_payment_vouchers.date',
                                         'lechon_de_cebu_payment_vouchers.paid_to',
                                         'lechon_de_cebu_payment_vouchers.account_no',
                                         'lechon_de_cebu_payment_vouchers.account_name',
                                         'lechon_de_cebu_payment_vouchers.particulars',
                                         'lechon_de_cebu_payment_vouchers.amount',
                                         'lechon_de_cebu_payment_vouchers.method_of_payment',
                                         'lechon_de_cebu_payment_vouchers.prepared_by',
                                         'lechon_de_cebu_payment_vouchers.approved_by',
                                         'lechon_de_cebu_payment_vouchers.date_apprroved',
                                         'lechon_de_cebu_payment_vouchers.received_by_date',
                                         'lechon_de_cebu_payment_vouchers.created_by',
                                         'lechon_de_cebu_payment_vouchers.invoice_number',
                                         'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                         'lechon_de_cebu_payment_vouchers.issued_date',
                                         'lechon_de_cebu_payment_vouchers.category',
                                         'lechon_de_cebu_payment_vouchers.amount_due',
                                         'lechon_de_cebu_payment_vouchers.delivered_date',
                                         'lechon_de_cebu_payment_vouchers.status',
                                         'lechon_de_cebu_payment_vouchers.cheque_number',
                                         'lechon_de_cebu_payment_vouchers.cheque_amount',
                                         'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                         'lechon_de_cebu_payment_vouchers.sub_category',
                                         'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                         'lechon_de_cebu_payment_vouchers.deleted_at',
                                         'lechon_de_cebu_codes.lechon_de_cebu_code',
                                         'lechon_de_cebu_codes.module_id',
                                         'lechon_de_cebu_codes.module_code',
                                         'lechon_de_cebu_codes.module_name')
                                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                         ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                         ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$startDate, $endDate])
                                         ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                         ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                         ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                                         ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                                         ->sum('lechon_de_cebu_payment_vouchers.amount_due');
 
 
             $check = "CHECK";
             $getTransactionListChecks = DB::table(
                                             'lechon_de_cebu_payment_vouchers')
                                             ->select( 
                                             'lechon_de_cebu_payment_vouchers.id',
                                             'lechon_de_cebu_payment_vouchers.user_id',
                                             'lechon_de_cebu_payment_vouchers.pv_id',
                                             'lechon_de_cebu_payment_vouchers.date',
                                             'lechon_de_cebu_payment_vouchers.paid_to',
                                             'lechon_de_cebu_payment_vouchers.account_no',
                                             'lechon_de_cebu_payment_vouchers.account_name',
                                             'lechon_de_cebu_payment_vouchers.particulars',
                                             'lechon_de_cebu_payment_vouchers.amount',
                                             'lechon_de_cebu_payment_vouchers.method_of_payment',
                                             'lechon_de_cebu_payment_vouchers.prepared_by',
                                             'lechon_de_cebu_payment_vouchers.approved_by',
                                             'lechon_de_cebu_payment_vouchers.date_apprroved',
                                             'lechon_de_cebu_payment_vouchers.received_by_date',
                                             'lechon_de_cebu_payment_vouchers.created_by',
                                             'lechon_de_cebu_payment_vouchers.invoice_number',
                                             'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                             'lechon_de_cebu_payment_vouchers.issued_date',
                                             'lechon_de_cebu_payment_vouchers.category',
                                             'lechon_de_cebu_payment_vouchers.amount_due',
                                             'lechon_de_cebu_payment_vouchers.delivered_date',
                                             'lechon_de_cebu_payment_vouchers.status',
                                             'lechon_de_cebu_payment_vouchers.cheque_number',
                                             'lechon_de_cebu_payment_vouchers.cheque_amount',
                                             'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                             'lechon_de_cebu_payment_vouchers.sub_category',
                                             'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                             'lechon_de_cebu_payment_vouchers.deleted_at',
                                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                                             'lechon_de_cebu_codes.module_id',
                                             'lechon_de_cebu_codes.module_code',
                                             'lechon_de_cebu_codes.module_name')
                                             ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                             ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                             ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$startDate, $endDate])
                                             ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                             ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                             ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                             ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                             ->get()->toArray();
             
            $totalAmountCheck = DB::table(
                                     'lechon_de_cebu_payment_vouchers')
                                     ->select( 
                                     'lechon_de_cebu_payment_vouchers.id',
                                     'lechon_de_cebu_payment_vouchers.user_id',
                                     'lechon_de_cebu_payment_vouchers.pv_id',
                                     'lechon_de_cebu_payment_vouchers.date',
                                     'lechon_de_cebu_payment_vouchers.paid_to',
                                     'lechon_de_cebu_payment_vouchers.account_no',
                                     'lechon_de_cebu_payment_vouchers.account_name',
                                     'lechon_de_cebu_payment_vouchers.particulars',
                                     'lechon_de_cebu_payment_vouchers.amount',
                                     'lechon_de_cebu_payment_vouchers.method_of_payment',
                                     'lechon_de_cebu_payment_vouchers.prepared_by',
                                     'lechon_de_cebu_payment_vouchers.approved_by',
                                     'lechon_de_cebu_payment_vouchers.date_apprroved',
                                     'lechon_de_cebu_payment_vouchers.received_by_date',
                                     'lechon_de_cebu_payment_vouchers.created_by',
                                     'lechon_de_cebu_payment_vouchers.invoice_number',
                                     'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                     'lechon_de_cebu_payment_vouchers.issued_date',
                                     'lechon_de_cebu_payment_vouchers.category',
                                     'lechon_de_cebu_payment_vouchers.amount_due',
                                     'lechon_de_cebu_payment_vouchers.delivered_date',
                                     'lechon_de_cebu_payment_vouchers.status',
                                     'lechon_de_cebu_payment_vouchers.cheque_number',
                                     'lechon_de_cebu_payment_vouchers.cheque_amount',
                                     'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                     'lechon_de_cebu_payment_vouchers.sub_category',
                                     'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                     'lechon_de_cebu_payment_vouchers.deleted_at',
                                     'lechon_de_cebu_codes.lechon_de_cebu_code',
                                     'lechon_de_cebu_codes.module_id',
                                     'lechon_de_cebu_codes.module_code',
                                     'lechon_de_cebu_codes.module_name')
                                     ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                     ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                     ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$startDate, $endDate])
                                     ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                     ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                     ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                     ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                                     ->sum('lechon_de_cebu_payment_vouchers.amount_due');
 
 
         //
         $totalPaymentVoucher = DB::table(
                             'lechon_de_cebu_payment_vouchers')
                             ->select( 
                             'lechon_de_cebu_payment_vouchers.id',
                             'lechon_de_cebu_payment_vouchers.user_id',
                             'lechon_de_cebu_payment_vouchers.pv_id',
                             'lechon_de_cebu_payment_vouchers.date',
                             'lechon_de_cebu_payment_vouchers.paid_to',
                             'lechon_de_cebu_payment_vouchers.account_no',
                             'lechon_de_cebu_payment_vouchers.account_name',
                             'lechon_de_cebu_payment_vouchers.particulars',
                             'lechon_de_cebu_payment_vouchers.amount',
                             'lechon_de_cebu_payment_vouchers.method_of_payment',
                             'lechon_de_cebu_payment_vouchers.prepared_by',
                             'lechon_de_cebu_payment_vouchers.approved_by',
                             'lechon_de_cebu_payment_vouchers.date_apprroved',
                             'lechon_de_cebu_payment_vouchers.received_by_date',
                             'lechon_de_cebu_payment_vouchers.created_by',
                             'lechon_de_cebu_payment_vouchers.invoice_number',
                             'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                             'lechon_de_cebu_payment_vouchers.issued_date',
                             'lechon_de_cebu_payment_vouchers.category',
                             'lechon_de_cebu_payment_vouchers.amount_due',
                             'lechon_de_cebu_payment_vouchers.delivered_date',
                             'lechon_de_cebu_payment_vouchers.status',
                             'lechon_de_cebu_payment_vouchers.cheque_number',
                             'lechon_de_cebu_payment_vouchers.cheque_amount',
                             'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                             'lechon_de_cebu_payment_vouchers.sub_category',
                             'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                             'lechon_de_cebu_payment_vouchers.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                             ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                             ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                             ->whereBetween('lechon_de_cebu_payment_vouchers.created_at', [$startDate, $endDate])
                             ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                             ->sum('lechon_de_cebu_payment_vouchers.amount_due');


        return view('lechon-de-cebu-multiple-summary-report', compact('getAllSalesInvoices', 'startDate', 'endDate',
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 
        'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 
        'totalPOrder', 'totalBStatement', 'totalPaymentVoucher', 'totalAmountCashes', 'totalAmountCheck'));

    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'lechon_de_cebu_sales_invoices')
                        ->select(
                            'lechon_de_cebu_sales_invoices.id',
                            'lechon_de_cebu_sales_invoices.user_id',
                            'lechon_de_cebu_sales_invoices.si_id',
                            'lechon_de_cebu_sales_invoices.invoice_number',
                            'lechon_de_cebu_sales_invoices.date',
                            'lechon_de_cebu_sales_invoices.ordered_by',
                            'lechon_de_cebu_sales_invoices.address',
                            'lechon_de_cebu_sales_invoices.qty',
                            'lechon_de_cebu_sales_invoices.total_kls',
                            'lechon_de_cebu_sales_invoices.body',
                            'lechon_de_cebu_sales_invoices.head_and_feet',
                            'lechon_de_cebu_sales_invoices.item_description',
                            'lechon_de_cebu_sales_invoices.unit_price',
                            'lechon_de_cebu_sales_invoices.amount',
                            'lechon_de_cebu_sales_invoices.total_amount',
                            'lechon_de_cebu_sales_invoices.created_by',
                            'lechon_de_cebu_sales_invoices.created_at',
                            'lechon_de_cebu_sales_invoices.updated_at',
                            'lechon_de_cebu_sales_invoices.deleted_at',                            
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                        ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($getDate))
                        ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                        ->get()->toArray();

            $totalSalesInvoice = DB::table(
                            'lechon_de_cebu_sales_invoices')
                            ->select(
                                'lechon_de_cebu_sales_invoices.id',
                                'lechon_de_cebu_sales_invoices.user_id',
                                'lechon_de_cebu_sales_invoices.si_id',
                                'lechon_de_cebu_sales_invoices.invoice_number',
                                'lechon_de_cebu_sales_invoices.date',
                                'lechon_de_cebu_sales_invoices.ordered_by',
                                'lechon_de_cebu_sales_invoices.address',
                                'lechon_de_cebu_sales_invoices.qty',
                                'lechon_de_cebu_sales_invoices.total_kls',
                                'lechon_de_cebu_sales_invoices.body',
                                'lechon_de_cebu_sales_invoices.head_and_feet',
                                'lechon_de_cebu_sales_invoices.item_description',
                                'lechon_de_cebu_sales_invoices.unit_price',
                                'lechon_de_cebu_sales_invoices.amount',
                                'lechon_de_cebu_sales_invoices.total_amount',
                                'lechon_de_cebu_sales_invoices.created_by',
                                'lechon_de_cebu_sales_invoices.created_at',
                                'lechon_de_cebu_sales_invoices.updated_at',    
                                'lechon_de_cebu_sales_invoices.deleted_at',                            
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                            ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($getDate))
                            ->sum('lechon_de_cebu_sales_invoices.total_amount');


        //Delivery Receipt
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_delivery_receipts.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($getDate))
                                ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                ->get()->toArray();

        //total for delivery receipt
        $moduleNameDelivery = "Delivery Receipt";
        $totalDeliveryReceipt = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_delivery_receipts.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($getDate))
                                ->sum('lechon_de_cebu_delivery_receipts.total');
        

        //purchase order
        $moduleNamePurchaseOrder = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lechon_de_cebu_purchase_orders')
                        ->select(
                            'lechon_de_cebu_purchase_orders.id',
                            'lechon_de_cebu_purchase_orders.user_id',
                            'lechon_de_cebu_purchase_orders.po_id',
                            'lechon_de_cebu_purchase_orders.paid_to',
                            'lechon_de_cebu_purchase_orders.address',
                            'lechon_de_cebu_purchase_orders.date',
                            'lechon_de_cebu_purchase_orders.quantity',
                            'lechon_de_cebu_purchase_orders.total_kls',
                            'lechon_de_cebu_purchase_orders.description',
                            'lechon_de_cebu_purchase_orders.unit_price',
                            'lechon_de_cebu_purchase_orders.amount',
                            'lechon_de_cebu_purchase_orders.total_price',
                            'lechon_de_cebu_purchase_orders.requested_by',
                            'lechon_de_cebu_purchase_orders.prepared_by',
                            'lechon_de_cebu_purchase_orders.checked_by',
                            'lechon_de_cebu_purchase_orders.created_by',
                            'lechon_de_cebu_purchase_orders.deleted_at',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                        ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                        ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($getDate))
                        ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                        ->get()->toArray();

            $totalPOrder = DB::table(
                            'lechon_de_cebu_purchase_orders')
                            ->select(
                                'lechon_de_cebu_purchase_orders.id',
                                'lechon_de_cebu_purchase_orders.user_id',
                                'lechon_de_cebu_purchase_orders.po_id',
                                'lechon_de_cebu_purchase_orders.paid_to',
                                'lechon_de_cebu_purchase_orders.address',
                                'lechon_de_cebu_purchase_orders.date',
                                'lechon_de_cebu_purchase_orders.quantity',
                                'lechon_de_cebu_purchase_orders.total_kls',
                                'lechon_de_cebu_purchase_orders.description',
                                'lechon_de_cebu_purchase_orders.unit_price',
                                'lechon_de_cebu_purchase_orders.amount',
                                'lechon_de_cebu_purchase_orders.total_price',
                                'lechon_de_cebu_purchase_orders.requested_by',
                                'lechon_de_cebu_purchase_orders.prepared_by',
                                'lechon_de_cebu_purchase_orders.checked_by',
                                'lechon_de_cebu_purchase_orders.created_by',
                                'lechon_de_cebu_purchase_orders.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->join('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                            ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                            ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($getDate))
                            ->sum('lechon_de_cebu_purchase_orders.total_price');

        //statement of account
        $moduleNameSOA = "Statement Of Account";
        $statementOfAccounts = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.bs_no',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameSOA)
                                ->whereDate('lechon_de_cebu_statement_of_accounts.created_at', '=', date($getDate))
                                ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                ->get()->toArray();
           
        
        //billing statement
        $moduleNameBillingStatement = "Billing Statement";
        $billingStatements = DB::table(
                                'lechon_de_cebu_billing_statements')
                                ->select(
                                    'lechon_de_cebu_billing_statements.id',
                                    'lechon_de_cebu_billing_statements.user_id',
                                    'lechon_de_cebu_billing_statements.billing_statement_id',
                                    'lechon_de_cebu_billing_statements.bill_to',
                                    'lechon_de_cebu_billing_statements.address',
                                    'lechon_de_cebu_billing_statements.date',
                                    'lechon_de_cebu_billing_statements.branch',
                                    'lechon_de_cebu_billing_statements.period_cover',
                                    'lechon_de_cebu_billing_statements.terms',
                                    'lechon_de_cebu_billing_statements.date_of_transaction',
                                    'lechon_de_cebu_billing_statements.invoice_number',
                                    'lechon_de_cebu_billing_statements.order',
                                    'lechon_de_cebu_billing_statements.whole_lechon',
                                    'lechon_de_cebu_billing_statements.description',
                                    'lechon_de_cebu_billing_statements.amount',
                                    'lechon_de_cebu_billing_statements.total_amount',
                                    'lechon_de_cebu_billing_statements.paid_amount',
                                    'lechon_de_cebu_billing_statements.created_by',
                                    'lechon_de_cebu_billing_statements.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($getDate))
                                ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                ->get()->toArray();
        
                $totalBStatement = DB::table(
                                    'lechon_de_cebu_billing_statements')
                                    ->select(
                                        'lechon_de_cebu_billing_statements.id',
                                        'lechon_de_cebu_billing_statements.user_id',
                                        'lechon_de_cebu_billing_statements.billing_statement_id',
                                        'lechon_de_cebu_billing_statements.bill_to',
                                        'lechon_de_cebu_billing_statements.address',
                                        'lechon_de_cebu_billing_statements.date',
                                        'lechon_de_cebu_billing_statements.branch',
                                        'lechon_de_cebu_billing_statements.period_cover',
                                        'lechon_de_cebu_billing_statements.terms',
                                        'lechon_de_cebu_billing_statements.date_of_transaction',
                                        'lechon_de_cebu_billing_statements.invoice_number',
                                        'lechon_de_cebu_billing_statements.order',
                                        'lechon_de_cebu_billing_statements.whole_lechon',
                                        'lechon_de_cebu_billing_statements.description',
                                        'lechon_de_cebu_billing_statements.amount',
                                        'lechon_de_cebu_billing_statements.total_amount',
                                        'lechon_de_cebu_billing_statements.paid_amount',
                                        'lechon_de_cebu_billing_statements.created_by',
                                        'lechon_de_cebu_billing_statements.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                    ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                    ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($getDate))
                                    ->sum('lechon_de_cebu_billing_statements.total_amount');
        
            
        //petty cash
        $moduleNamePettyCash = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lechon_de_cebu_petty_cashes')
                                ->select( 
                                'lechon_de_cebu_petty_cashes.id',
                                'lechon_de_cebu_petty_cashes.user_id',
                                'lechon_de_cebu_petty_cashes.pc_id',
                                'lechon_de_cebu_petty_cashes.date',
                                'lechon_de_cebu_petty_cashes.petty_cash_name',
                                'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                'lechon_de_cebu_petty_cashes.amount',
                                'lechon_de_cebu_petty_cashes.created_by',
                                'lechon_de_cebu_petty_cashes.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_petty_cashes.pc_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNamePettyCash)
                                ->where('lechon_de_cebu_petty_cashes.deleted_at', NULL)
                                ->whereDate('lechon_de_cebu_petty_cashes.created_at', '=', date($getDate))
                                ->orderBy('lechon_de_cebu_petty_cashes.id', 'desc')
                                ->get()->toArray();

        //payment voucher
        $moduleNameVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'lechon_de_cebu_payment_vouchers')
                                ->select( 
                                'lechon_de_cebu_payment_vouchers.id',
                                'lechon_de_cebu_payment_vouchers.user_id',
                                'lechon_de_cebu_payment_vouchers.pv_id',
                                'lechon_de_cebu_payment_vouchers.date',
                                'lechon_de_cebu_payment_vouchers.paid_to',
                                'lechon_de_cebu_payment_vouchers.account_no',
                                'lechon_de_cebu_payment_vouchers.account_name',
                                'lechon_de_cebu_payment_vouchers.particulars',
                                'lechon_de_cebu_payment_vouchers.amount',
                                'lechon_de_cebu_payment_vouchers.method_of_payment',
                                'lechon_de_cebu_payment_vouchers.prepared_by',
                                'lechon_de_cebu_payment_vouchers.approved_by',
                                'lechon_de_cebu_payment_vouchers.date_apprroved',
                                'lechon_de_cebu_payment_vouchers.received_by_date',
                                'lechon_de_cebu_payment_vouchers.created_by',
                                'lechon_de_cebu_payment_vouchers.invoice_number',
                                'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                'lechon_de_cebu_payment_vouchers.issued_date',
                                'lechon_de_cebu_payment_vouchers.category',
                                'lechon_de_cebu_payment_vouchers.amount_due',
                                'lechon_de_cebu_payment_vouchers.delivered_date',
                                'lechon_de_cebu_payment_vouchers.status',
                                'lechon_de_cebu_payment_vouchers.cheque_number',
                                'lechon_de_cebu_payment_vouchers.cheque_amount',
                                'lechon_de_cebu_payment_vouchers.sub_category',
                                'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                'lechon_de_cebu_payment_vouchers.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDate))
                                ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                ->get()->toArray();
      
            $cash = "CASH";
            $getTransactionListCashes = DB::table(
                                    'lechon_de_cebu_payment_vouchers')
                                    ->select( 
                                    'lechon_de_cebu_payment_vouchers.id',
                                    'lechon_de_cebu_payment_vouchers.user_id',
                                    'lechon_de_cebu_payment_vouchers.pv_id',
                                    'lechon_de_cebu_payment_vouchers.date',
                                    'lechon_de_cebu_payment_vouchers.paid_to',
                                    'lechon_de_cebu_payment_vouchers.account_no',
                                    'lechon_de_cebu_payment_vouchers.account_name',
                                    'lechon_de_cebu_payment_vouchers.particulars',
                                    'lechon_de_cebu_payment_vouchers.amount',
                                    'lechon_de_cebu_payment_vouchers.method_of_payment',
                                    'lechon_de_cebu_payment_vouchers.prepared_by',
                                    'lechon_de_cebu_payment_vouchers.approved_by',
                                    'lechon_de_cebu_payment_vouchers.date_apprroved',
                                    'lechon_de_cebu_payment_vouchers.received_by_date',
                                    'lechon_de_cebu_payment_vouchers.created_by',
                                    'lechon_de_cebu_payment_vouchers.invoice_number',
                                    'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                    'lechon_de_cebu_payment_vouchers.issued_date',
                                    'lechon_de_cebu_payment_vouchers.category',
                                    'lechon_de_cebu_payment_vouchers.amount_due',
                                    'lechon_de_cebu_payment_vouchers.delivered_date',
                                    'lechon_de_cebu_payment_vouchers.status',
                                    'lechon_de_cebu_payment_vouchers.cheque_number',
                                    'lechon_de_cebu_payment_vouchers.cheque_amount',
                                    'lechon_de_cebu_payment_vouchers.sub_category',
                                    'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                    'lechon_de_cebu_payment_vouchers.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                    ->join('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                    ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDate))
                                    ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                    ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                                    ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                    ->get()->toArray();

            $status = "FULLY PAID AND RELEASED";
            $totalPaymentVoucher = DB::table(
                                        'lechon_de_cebu_payment_vouchers')
                                        ->select( 
                                        'lechon_de_cebu_payment_vouchers.id',
                                        'lechon_de_cebu_payment_vouchers.user_id',
                                        'lechon_de_cebu_payment_vouchers.pv_id',
                                        'lechon_de_cebu_payment_vouchers.date',
                                        'lechon_de_cebu_payment_vouchers.paid_to',
                                        'lechon_de_cebu_payment_vouchers.account_no',
                                        'lechon_de_cebu_payment_vouchers.account_name',
                                        'lechon_de_cebu_payment_vouchers.particulars',
                                        'lechon_de_cebu_payment_vouchers.amount',
                                        'lechon_de_cebu_payment_vouchers.method_of_payment',
                                        'lechon_de_cebu_payment_vouchers.prepared_by',
                                        'lechon_de_cebu_payment_vouchers.approved_by',
                                        'lechon_de_cebu_payment_vouchers.date_apprroved',
                                        'lechon_de_cebu_payment_vouchers.received_by_date',
                                        'lechon_de_cebu_payment_vouchers.created_by',
                                        'lechon_de_cebu_payment_vouchers.invoice_number',
                                        'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                        'lechon_de_cebu_payment_vouchers.issued_date',
                                        'lechon_de_cebu_payment_vouchers.category',
                                        'lechon_de_cebu_payment_vouchers.amount_due',
                                        'lechon_de_cebu_payment_vouchers.delivered_date',
                                        'lechon_de_cebu_payment_vouchers.status',
                                        'lechon_de_cebu_payment_vouchers.cheque_number',
                                        'lechon_de_cebu_payment_vouchers.cheque_amount',
                                        'lechon_de_cebu_payment_vouchers.sub_category',
                                        'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                        'lechon_de_cebu_payment_vouchers.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                        ->join('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                        ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                        ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDate))
                                        ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                        ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                        ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                                        ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                                       ->sum('lechon_de_cebu_payment_vouchers.amount_due');
          
            $check = "CHECK";
            $getTransactionListChecks = DB::table(
                                            'lechon_de_cebu_payment_vouchers')
                                            ->select( 
                                            'lechon_de_cebu_payment_vouchers.id',
                                            'lechon_de_cebu_payment_vouchers.user_id',
                                            'lechon_de_cebu_payment_vouchers.pv_id',
                                            'lechon_de_cebu_payment_vouchers.date',
                                            'lechon_de_cebu_payment_vouchers.paid_to',
                                            'lechon_de_cebu_payment_vouchers.account_no',
                                            'lechon_de_cebu_payment_vouchers.account_name',
                                            'lechon_de_cebu_payment_vouchers.particulars',
                                            'lechon_de_cebu_payment_vouchers.amount',
                                            'lechon_de_cebu_payment_vouchers.method_of_payment',
                                            'lechon_de_cebu_payment_vouchers.prepared_by',
                                            'lechon_de_cebu_payment_vouchers.approved_by',
                                            'lechon_de_cebu_payment_vouchers.date_apprroved',
                                            'lechon_de_cebu_payment_vouchers.received_by_date',
                                            'lechon_de_cebu_payment_vouchers.created_by',
                                            'lechon_de_cebu_payment_vouchers.invoice_number',
                                            'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                            'lechon_de_cebu_payment_vouchers.issued_date',
                                            'lechon_de_cebu_payment_vouchers.category',
                                            'lechon_de_cebu_payment_vouchers.amount_due',
                                            'lechon_de_cebu_payment_vouchers.delivered_date',
                                            'lechon_de_cebu_payment_vouchers.status',
                                            'lechon_de_cebu_payment_vouchers.cheque_number',
                                            'lechon_de_cebu_payment_vouchers.cheque_amount',
                                            'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                            'lechon_de_cebu_payment_vouchers.sub_category',
                                            'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                            'lechon_de_cebu_payment_vouchers.deleted_at',
                                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                                            'lechon_de_cebu_codes.module_id',
                                            'lechon_de_cebu_codes.module_code',
                                            'lechon_de_cebu_codes.module_name')
                                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                            ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                            ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDate))
                                            ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                            ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                            ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                            ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                            ->get()->toArray();
                                  
        //
        $totalPaymentVoucherCheck = DB::table(
                            'lechon_de_cebu_payment_vouchers')
                            ->select( 
                            'lechon_de_cebu_payment_vouchers.id',
                            'lechon_de_cebu_payment_vouchers.user_id',
                            'lechon_de_cebu_payment_vouchers.pv_id',
                            'lechon_de_cebu_payment_vouchers.date',
                            'lechon_de_cebu_payment_vouchers.paid_to',
                            'lechon_de_cebu_payment_vouchers.account_no',
                            'lechon_de_cebu_payment_vouchers.account_name',
                            'lechon_de_cebu_payment_vouchers.particulars',
                            'lechon_de_cebu_payment_vouchers.amount',
                            'lechon_de_cebu_payment_vouchers.method_of_payment',
                            'lechon_de_cebu_payment_vouchers.prepared_by',
                            'lechon_de_cebu_payment_vouchers.approved_by',
                            'lechon_de_cebu_payment_vouchers.date_apprroved',
                            'lechon_de_cebu_payment_vouchers.received_by_date',
                            'lechon_de_cebu_payment_vouchers.created_by',
                            'lechon_de_cebu_payment_vouchers.invoice_number',
                            'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                            'lechon_de_cebu_payment_vouchers.issued_date',
                            'lechon_de_cebu_payment_vouchers.category',
                            'lechon_de_cebu_payment_vouchers.amount_due',
                            'lechon_de_cebu_payment_vouchers.delivered_date',
                            'lechon_de_cebu_payment_vouchers.status',
                            'lechon_de_cebu_payment_vouchers.cheque_number',
                            'lechon_de_cebu_payment_vouchers.cheque_amount',
                            'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                            'lechon_de_cebu_payment_vouchers.sub_category',
                            'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                            'lechon_de_cebu_payment_vouchers.deleted_at',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                            ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                            ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDate))
                            ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                            ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                            ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                            ->sum('lechon_de_cebu_payment_vouchers.amount_due');

        return view('lechon-de-cebu-get-summary-report', compact('getDate', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 
        'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 
        'totalPOrder', 'totalBStatement', 'totalPaymentVoucher', 'totalPaymentVoucherCheck'));
    

        
    }

    public function printGetSummary($date){
        $moduleName = "Sales Invoice";
         $getAllSalesInvoices = DB::table(
                         'lechon_de_cebu_sales_invoices')
                         ->select(
                             'lechon_de_cebu_sales_invoices.id',
                             'lechon_de_cebu_sales_invoices.user_id',
                             'lechon_de_cebu_sales_invoices.si_id',
                             'lechon_de_cebu_sales_invoices.invoice_number',
                             'lechon_de_cebu_sales_invoices.date',
                             'lechon_de_cebu_sales_invoices.ordered_by',
                             'lechon_de_cebu_sales_invoices.address',
                             'lechon_de_cebu_sales_invoices.qty',
                             'lechon_de_cebu_sales_invoices.total_kls',
                             'lechon_de_cebu_sales_invoices.body',
                             'lechon_de_cebu_sales_invoices.head_and_feet',
                             'lechon_de_cebu_sales_invoices.item_description',
                             'lechon_de_cebu_sales_invoices.unit_price',
                             'lechon_de_cebu_sales_invoices.amount',
                             'lechon_de_cebu_sales_invoices.total_amount',
                             'lechon_de_cebu_sales_invoices.created_by',
                             'lechon_de_cebu_sales_invoices.created_at',
                             'lechon_de_cebu_sales_invoices.updated_at',  
                             'lechon_de_cebu_sales_invoices.deleted_at',                            
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                         ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                         ->where('lechon_de_cebu_codes.module_name', $moduleName)
                         ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                         ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($date))
                         ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                         ->get()->toArray();
        
        $totalSalesInvoice = DB::table(
                            'lechon_de_cebu_sales_invoices')
                            ->select(
                                'lechon_de_cebu_sales_invoices.id',
                                'lechon_de_cebu_sales_invoices.user_id',
                                'lechon_de_cebu_sales_invoices.si_id',
                                'lechon_de_cebu_sales_invoices.invoice_number',
                                'lechon_de_cebu_sales_invoices.date',
                                'lechon_de_cebu_sales_invoices.ordered_by',
                                'lechon_de_cebu_sales_invoices.address',
                                'lechon_de_cebu_sales_invoices.qty',
                                'lechon_de_cebu_sales_invoices.total_kls',
                                'lechon_de_cebu_sales_invoices.body',
                                'lechon_de_cebu_sales_invoices.head_and_feet',
                                'lechon_de_cebu_sales_invoices.item_description',
                                'lechon_de_cebu_sales_invoices.unit_price',
                                'lechon_de_cebu_sales_invoices.amount',
                                'lechon_de_cebu_sales_invoices.total_amount',
                                'lechon_de_cebu_sales_invoices.created_by',
                                'lechon_de_cebu_sales_invoices.created_at',
                                'lechon_de_cebu_sales_invoices.updated_at',
                                'lechon_de_cebu_sales_invoices.deleted_at',                            
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                            ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($date))
                            ->sum('lechon_de_cebu_sales_invoices.total_amount');

        
 
         //Delivery Receipt
         $moduleNameDelivery = "Delivery Receipt";
         $getAllDeliveryReceipts = DB::table(
                                 'lechon_de_cebu_delivery_receipts')
                                 ->select( 
                                 'lechon_de_cebu_delivery_receipts.id',
                                 'lechon_de_cebu_delivery_receipts.user_id',
                                 'lechon_de_cebu_delivery_receipts.dr_id',
                                 'lechon_de_cebu_delivery_receipts.sold_to',
                                 'lechon_de_cebu_delivery_receipts.delivered_to',
                                 'lechon_de_cebu_delivery_receipts.time',
                                 'lechon_de_cebu_delivery_receipts.date',
                                 'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                 'lechon_de_cebu_delivery_receipts.contact_person',
                                 'lechon_de_cebu_delivery_receipts.mobile_num',
                                 'lechon_de_cebu_delivery_receipts.qty',
                                 'lechon_de_cebu_delivery_receipts.description',
                                 'lechon_de_cebu_delivery_receipts.price',
                                 'lechon_de_cebu_delivery_receipts.total',
                                 'lechon_de_cebu_delivery_receipts.special_instruction',
                                 'lechon_de_cebu_delivery_receipts.consignee_name',
                                 'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                 'lechon_de_cebu_delivery_receipts.prepared_by',
                                 'lechon_de_cebu_delivery_receipts.checked_by',
                                 'lechon_de_cebu_delivery_receipts.received_by',
                                 'lechon_de_cebu_delivery_receipts.duplicate_status',
                                 'lechon_de_cebu_delivery_receipts.created_by',
                                 'lechon_de_cebu_delivery_receipts.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                 ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($date))
                                 ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                 ->get()->toArray();
 
         //total for delivery receipt
         $totalDeliveryReceipt = DB::table(
                                 'lechon_de_cebu_delivery_receipts')
                                 ->select( 
                                 'lechon_de_cebu_delivery_receipts.id',
                                 'lechon_de_cebu_delivery_receipts.user_id',
                                 'lechon_de_cebu_delivery_receipts.dr_id',
                                 'lechon_de_cebu_delivery_receipts.sold_to',
                                 'lechon_de_cebu_delivery_receipts.delivered_to',
                                 'lechon_de_cebu_delivery_receipts.time',
                                 'lechon_de_cebu_delivery_receipts.date',
                                 'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                 'lechon_de_cebu_delivery_receipts.contact_person',
                                 'lechon_de_cebu_delivery_receipts.mobile_num',
                                 'lechon_de_cebu_delivery_receipts.qty',
                                 'lechon_de_cebu_delivery_receipts.description',
                                 'lechon_de_cebu_delivery_receipts.price',
                                 'lechon_de_cebu_delivery_receipts.total',
                                 'lechon_de_cebu_delivery_receipts.special_instruction',
                                 'lechon_de_cebu_delivery_receipts.consignee_name',
                                 'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                 'lechon_de_cebu_delivery_receipts.prepared_by',
                                 'lechon_de_cebu_delivery_receipts.checked_by',
                                 'lechon_de_cebu_delivery_receipts.received_by',
                                 'lechon_de_cebu_delivery_receipts.duplicate_status',
                                 'lechon_de_cebu_delivery_receipts.created_by',
                                 'lechon_de_cebu_delivery_receipts.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                 ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($date))
                                 ->sum('lechon_de_cebu_delivery_receipts.total');
         
 
         //purchase order
         $moduleNamePurchaseOrder = "Purchase Order";
         $purchaseOrders = DB::table(
                         'lechon_de_cebu_purchase_orders')
                         ->select(
                             'lechon_de_cebu_purchase_orders.id',
                             'lechon_de_cebu_purchase_orders.user_id',
                             'lechon_de_cebu_purchase_orders.po_id',
                             'lechon_de_cebu_purchase_orders.paid_to',
                             'lechon_de_cebu_purchase_orders.address',
                             'lechon_de_cebu_purchase_orders.date',
                             'lechon_de_cebu_purchase_orders.quantity',
                             'lechon_de_cebu_purchase_orders.total_kls',
                             'lechon_de_cebu_purchase_orders.description',
                             'lechon_de_cebu_purchase_orders.unit_price',
                             'lechon_de_cebu_purchase_orders.amount',
                             'lechon_de_cebu_purchase_orders.total_price',
                             'lechon_de_cebu_purchase_orders.requested_by',
                             'lechon_de_cebu_purchase_orders.prepared_by',
                             'lechon_de_cebu_purchase_orders.checked_by',
                             'lechon_de_cebu_purchase_orders.created_by',
                             'lechon_de_cebu_purchase_orders.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                         ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                         ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                         ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                         ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($date))
                         ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                         ->get()->toArray();
 
             $totalPOrder = DB::table(
                             'lechon_de_cebu_purchase_orders')
                             ->select(
                                 'lechon_de_cebu_purchase_orders.id',
                                 'lechon_de_cebu_purchase_orders.user_id',
                                 'lechon_de_cebu_purchase_orders.po_id',
                                 'lechon_de_cebu_purchase_orders.paid_to',
                                 'lechon_de_cebu_purchase_orders.address',
                                 'lechon_de_cebu_purchase_orders.date',
                                 'lechon_de_cebu_purchase_orders.quantity',
                                 'lechon_de_cebu_purchase_orders.total_kls',
                                 'lechon_de_cebu_purchase_orders.description',
                                 'lechon_de_cebu_purchase_orders.unit_price',
                                 'lechon_de_cebu_purchase_orders.amount',
                                 'lechon_de_cebu_purchase_orders.total_price',
                                 'lechon_de_cebu_purchase_orders.requested_by',
                                 'lechon_de_cebu_purchase_orders.prepared_by',
                                 'lechon_de_cebu_purchase_orders.checked_by',
                                 'lechon_de_cebu_purchase_orders.created_by',
                                 'lechon_de_cebu_purchase_orders.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                             ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                             ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                             ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                             ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($date))
                             ->sum('lechon_de_cebu_purchase_orders.total_price');

         
         //billing statement
         $moduleNameBillingStatement = "Billing Statement";
         $billingStatements = DB::table(
                                 'lechon_de_cebu_billing_statements')
                                 ->select(
                                     'lechon_de_cebu_billing_statements.id',
                                     'lechon_de_cebu_billing_statements.user_id',
                                     'lechon_de_cebu_billing_statements.billing_statement_id',
                                     'lechon_de_cebu_billing_statements.bill_to',
                                     'lechon_de_cebu_billing_statements.address',
                                     'lechon_de_cebu_billing_statements.date',
                                     'lechon_de_cebu_billing_statements.branch',
                                     'lechon_de_cebu_billing_statements.period_cover',
                                     'lechon_de_cebu_billing_statements.terms',
                                     'lechon_de_cebu_billing_statements.date_of_transaction',
                                     'lechon_de_cebu_billing_statements.invoice_number',
                                     'lechon_de_cebu_billing_statements.order',
                                     'lechon_de_cebu_billing_statements.whole_lechon',
                                     'lechon_de_cebu_billing_statements.description',
                                     'lechon_de_cebu_billing_statements.amount',
                                     'lechon_de_cebu_billing_statements.total_amount',
                                     'lechon_de_cebu_billing_statements.paid_amount',
                                     'lechon_de_cebu_billing_statements.created_by',
                                     'lechon_de_cebu_billing_statements.deleted_at',
                                     'lechon_de_cebu_codes.lechon_de_cebu_code',
                                     'lechon_de_cebu_codes.module_id',
                                     'lechon_de_cebu_codes.module_code',
                                     'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                 ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($date))
                                 ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                 ->get()->toArray();
         
                 $totalBStatement = DB::table(
                                     'lechon_de_cebu_billing_statements')
                                     ->select(
                                         'lechon_de_cebu_billing_statements.id',
                                         'lechon_de_cebu_billing_statements.user_id',
                                         'lechon_de_cebu_billing_statements.billing_statement_id',
                                         'lechon_de_cebu_billing_statements.bill_to',
                                         'lechon_de_cebu_billing_statements.address',
                                         'lechon_de_cebu_billing_statements.date',
                                         'lechon_de_cebu_billing_statements.branch',
                                         'lechon_de_cebu_billing_statements.period_cover',
                                         'lechon_de_cebu_billing_statements.terms',
                                         'lechon_de_cebu_billing_statements.date_of_transaction',
                                         'lechon_de_cebu_billing_statements.invoice_number',
                                         'lechon_de_cebu_billing_statements.order',
                                         'lechon_de_cebu_billing_statements.whole_lechon',
                                         'lechon_de_cebu_billing_statements.description',
                                         'lechon_de_cebu_billing_statements.amount',
                                         'lechon_de_cebu_billing_statements.total_amount',
                                         'lechon_de_cebu_billing_statements.paid_amount',
                                         'lechon_de_cebu_billing_statements.created_by',
                                         'lechon_de_cebu_billing_statements.deleted_at',
                                         'lechon_de_cebu_codes.lechon_de_cebu_code',
                                         'lechon_de_cebu_codes.module_id',
                                         'lechon_de_cebu_codes.module_code',
                                         'lechon_de_cebu_codes.module_name')
                                     ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                     ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                     ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                     ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                     ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($date))
                                     ->sum('lechon_de_cebu_billing_statements.total_amount');
         
             
         //petty cash
         $moduleNamePettyCash = "Petty Cash";
         $pettyCashLists = DB::table(
                                 'lechon_de_cebu_petty_cashes')
                                 ->select( 
                                 'lechon_de_cebu_petty_cashes.id',
                                 'lechon_de_cebu_petty_cashes.user_id',
                                 'lechon_de_cebu_petty_cashes.pc_id',
                                 'lechon_de_cebu_petty_cashes.date',
                                 'lechon_de_cebu_petty_cashes.petty_cash_name',
                                 'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                 'lechon_de_cebu_petty_cashes.amount',
                                 'lechon_de_cebu_petty_cashes.created_by',
                                 'lechon_de_cebu_petty_cashes.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_petty_cashes.pc_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNamePettyCash)
                                 ->where('lechon_de_cebu_petty_cashes.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_petty_cashes.created_at', '=', date($date))
                                 ->orderBy('lechon_de_cebu_petty_cashes.id', 'desc')
                                 ->get()->toArray();
 
         //payment voucher
         $moduleNameVoucher = "Payment Voucher";
         $cash = "CASH";
         $getTransactionListCashes = DB::table(
                                 'lechon_de_cebu_payment_vouchers')
                                 ->select( 
                                 'lechon_de_cebu_payment_vouchers.id',
                                 'lechon_de_cebu_payment_vouchers.user_id',
                                 'lechon_de_cebu_payment_vouchers.pv_id',
                                 'lechon_de_cebu_payment_vouchers.date',
                                 'lechon_de_cebu_payment_vouchers.paid_to',
                                 'lechon_de_cebu_payment_vouchers.account_no',
                                 'lechon_de_cebu_payment_vouchers.account_name',
                                 'lechon_de_cebu_payment_vouchers.particulars',
                                 'lechon_de_cebu_payment_vouchers.amount',
                                 'lechon_de_cebu_payment_vouchers.method_of_payment',
                                 'lechon_de_cebu_payment_vouchers.prepared_by',
                                 'lechon_de_cebu_payment_vouchers.approved_by',
                                 'lechon_de_cebu_payment_vouchers.date_apprroved',
                                 'lechon_de_cebu_payment_vouchers.received_by_date',
                                 'lechon_de_cebu_payment_vouchers.created_by',
                                 'lechon_de_cebu_payment_vouchers.invoice_number',
                                 'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                 'lechon_de_cebu_payment_vouchers.issued_date',
                                 'lechon_de_cebu_payment_vouchers.category',
                                 'lechon_de_cebu_payment_vouchers.amount_due',
                                 'lechon_de_cebu_payment_vouchers.delivered_date',
                                 'lechon_de_cebu_payment_vouchers.status',
                                 'lechon_de_cebu_payment_vouchers.cheque_number',
                                 'lechon_de_cebu_payment_vouchers.cheque_amount',
                                 'lechon_de_cebu_payment_vouchers.sub_category',
                                 'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                 'lechon_de_cebu_payment_vouchers.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                 ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($date))
                                 ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                 ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                                 ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                 ->get()->toArray();

            $check = "CHECK";
            $getTransactionListChecks = DB::table(
                                        'lechon_de_cebu_payment_vouchers')
                                        ->select( 
                                        'lechon_de_cebu_payment_vouchers.id',
                                        'lechon_de_cebu_payment_vouchers.user_id',
                                        'lechon_de_cebu_payment_vouchers.pv_id',
                                        'lechon_de_cebu_payment_vouchers.date',
                                        'lechon_de_cebu_payment_vouchers.paid_to',
                                        'lechon_de_cebu_payment_vouchers.account_no',
                                        'lechon_de_cebu_payment_vouchers.account_name',
                                        'lechon_de_cebu_payment_vouchers.particulars',
                                        'lechon_de_cebu_payment_vouchers.amount',
                                        'lechon_de_cebu_payment_vouchers.method_of_payment',
                                        'lechon_de_cebu_payment_vouchers.prepared_by',
                                        'lechon_de_cebu_payment_vouchers.approved_by',
                                        'lechon_de_cebu_payment_vouchers.date_apprroved',
                                        'lechon_de_cebu_payment_vouchers.received_by_date',
                                        'lechon_de_cebu_payment_vouchers.created_by',
                                        'lechon_de_cebu_payment_vouchers.invoice_number',
                                        'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                        'lechon_de_cebu_payment_vouchers.issued_date',
                                        'lechon_de_cebu_payment_vouchers.category',
                                        'lechon_de_cebu_payment_vouchers.amount_due',
                                        'lechon_de_cebu_payment_vouchers.delivered_date',
                                        'lechon_de_cebu_payment_vouchers.status',
                                        'lechon_de_cebu_payment_vouchers.cheque_number',
                                        'lechon_de_cebu_payment_vouchers.cheque_amount',
                                        'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                        'lechon_de_cebu_payment_vouchers.sub_category',
                                        'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                        'lechon_de_cebu_payment_vouchers.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                        ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                        ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($date))
                                        ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                        ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                        ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                        ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                        ->get()->toArray();
       
        $status = "FULLY PAID AND RELEASED";    
         $totalPaymentVoucherCash = DB::table(
                             'lechon_de_cebu_payment_vouchers')
                             ->select( 
                             'lechon_de_cebu_payment_vouchers.id',
                             'lechon_de_cebu_payment_vouchers.user_id',
                             'lechon_de_cebu_payment_vouchers.pv_id',
                             'lechon_de_cebu_payment_vouchers.date',
                             'lechon_de_cebu_payment_vouchers.paid_to',
                             'lechon_de_cebu_payment_vouchers.account_no',
                             'lechon_de_cebu_payment_vouchers.account_name',
                             'lechon_de_cebu_payment_vouchers.particulars',
                             'lechon_de_cebu_payment_vouchers.amount',
                             'lechon_de_cebu_payment_vouchers.method_of_payment',
                             'lechon_de_cebu_payment_vouchers.prepared_by',
                             'lechon_de_cebu_payment_vouchers.approved_by',
                             'lechon_de_cebu_payment_vouchers.date_apprroved',
                             'lechon_de_cebu_payment_vouchers.received_by_date',
                             'lechon_de_cebu_payment_vouchers.created_by',
                             'lechon_de_cebu_payment_vouchers.invoice_number',
                             'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                             'lechon_de_cebu_payment_vouchers.issued_date',
                             'lechon_de_cebu_payment_vouchers.category',
                             'lechon_de_cebu_payment_vouchers.amount_due',
                             'lechon_de_cebu_payment_vouchers.delivered_date',
                             'lechon_de_cebu_payment_vouchers.status',
                             'lechon_de_cebu_payment_vouchers.cheque_number',
                             'lechon_de_cebu_payment_vouchers.cheque_amount',
                             'lechon_de_cebu_payment_vouchers.sub_category',
                             'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                             'lechon_de_cebu_payment_vouchers.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                             ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                             ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($date))
                             ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                             ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                             ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                             ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                             ->sum('lechon_de_cebu_payment_vouchers.amount_due');

        $totalPaymentVoucherCheck = DB::table(
                                'lechon_de_cebu_payment_vouchers')
                                ->select( 
                                'lechon_de_cebu_payment_vouchers.id',
                                'lechon_de_cebu_payment_vouchers.user_id',
                                'lechon_de_cebu_payment_vouchers.pv_id',
                                'lechon_de_cebu_payment_vouchers.date',
                                'lechon_de_cebu_payment_vouchers.paid_to',
                                'lechon_de_cebu_payment_vouchers.account_no',
                                'lechon_de_cebu_payment_vouchers.account_name',
                                'lechon_de_cebu_payment_vouchers.particulars',
                                'lechon_de_cebu_payment_vouchers.amount',
                                'lechon_de_cebu_payment_vouchers.method_of_payment',
                                'lechon_de_cebu_payment_vouchers.prepared_by',
                                'lechon_de_cebu_payment_vouchers.approved_by',
                                'lechon_de_cebu_payment_vouchers.date_apprroved',
                                'lechon_de_cebu_payment_vouchers.received_by_date',
                                'lechon_de_cebu_payment_vouchers.created_by',
                                'lechon_de_cebu_payment_vouchers.invoice_number',
                                'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                'lechon_de_cebu_payment_vouchers.issued_date',
                                'lechon_de_cebu_payment_vouchers.category',
                                'lechon_de_cebu_payment_vouchers.amount_due',
                                'lechon_de_cebu_payment_vouchers.delivered_date',
                                'lechon_de_cebu_payment_vouchers.status',
                                'lechon_de_cebu_payment_vouchers.cheque_number',
                                'lechon_de_cebu_payment_vouchers.cheque_amount',
                                'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                'lechon_de_cebu_payment_vouchers.sub_category',
                                'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                'lechon_de_cebu_payment_vouchers.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($date))
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                                ->sum('lechon_de_cebu_payment_vouchers.amount_due');
         
        //
        $totalPaidAmountCheck = DB::table(
                                    'lechon_de_cebu_payment_vouchers')
                                    ->select( 
                                    'lechon_de_cebu_payment_vouchers.id',
                                    'lechon_de_cebu_payment_vouchers.user_id',
                                    'lechon_de_cebu_payment_vouchers.pv_id',
                                    'lechon_de_cebu_payment_vouchers.date',
                                    'lechon_de_cebu_payment_vouchers.paid_to',
                                    'lechon_de_cebu_payment_vouchers.account_no',
                                    'lechon_de_cebu_payment_vouchers.account_name',
                                    'lechon_de_cebu_payment_vouchers.particulars',
                                    'lechon_de_cebu_payment_vouchers.amount',
                                    'lechon_de_cebu_payment_vouchers.method_of_payment',
                                    'lechon_de_cebu_payment_vouchers.prepared_by',
                                    'lechon_de_cebu_payment_vouchers.approved_by',
                                    'lechon_de_cebu_payment_vouchers.date_apprroved',
                                    'lechon_de_cebu_payment_vouchers.received_by_date',
                                    'lechon_de_cebu_payment_vouchers.created_by',
                                    'lechon_de_cebu_payment_vouchers.invoice_number',
                                    'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                    'lechon_de_cebu_payment_vouchers.issued_date',
                                    'lechon_de_cebu_payment_vouchers.category',
                                    'lechon_de_cebu_payment_vouchers.amount_due',
                                    'lechon_de_cebu_payment_vouchers.delivered_date',
                                    'lechon_de_cebu_payment_vouchers.status',
                                    'lechon_de_cebu_payment_vouchers.cheque_number',
                                    'lechon_de_cebu_payment_vouchers.cheque_amount',
                                    'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                    'lechon_de_cebu_payment_vouchers.sub_category',
                                    'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                    'lechon_de_cebu_payment_vouchers.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                    ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($date))
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                    ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                    ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                    ->where('lechon_de_cebu_payment_vouchers.status',  $status)
                                    ->sum('lechon_de_cebu_payment_vouchers.cheque_total_amount');

        $getDateToday = "";
        $uri0 ="";
        $uri1 = "";
         $pdf = PDF::loadView('printSummary',  compact('date', 'uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 'totalPOrder', 'totalBStatement', 
        'totalPaymentVoucherCash','totalPaymentVoucherCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lechon-de-cebu-summary-report.pdf');
        

    }

  

    public function printMultipleSummaryBillingStatement(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];  

        $moduleNameBillingStatement = "Billing Statement";
        $billingStatements = DB::table(
                                'lechon_de_cebu_billing_statements')
                                ->select(
                                    'lechon_de_cebu_billing_statements.id',
                                    'lechon_de_cebu_billing_statements.user_id',
                                    'lechon_de_cebu_billing_statements.billing_statement_id',
                                    'lechon_de_cebu_billing_statements.bill_to',
                                    'lechon_de_cebu_billing_statements.address',
                                    'lechon_de_cebu_billing_statements.date',
                                    'lechon_de_cebu_billing_statements.branch',
                                    'lechon_de_cebu_billing_statements.period_cover',
                                    'lechon_de_cebu_billing_statements.terms',
                                    'lechon_de_cebu_billing_statements.date_of_transaction',
                                    'lechon_de_cebu_billing_statements.invoice_number',
                                    'lechon_de_cebu_billing_statements.order',
                                    'lechon_de_cebu_billing_statements.whole_lechon',
                                    'lechon_de_cebu_billing_statements.description',
                                    'lechon_de_cebu_billing_statements.amount',
                                    'lechon_de_cebu_billing_statements.total_amount',
                                    'lechon_de_cebu_billing_statements.paid_amount',
                                    'lechon_de_cebu_billing_statements.created_by',
                                    'lechon_de_cebu_billing_statements.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                ->whereBetween('lechon_de_cebu_billing_statements.created_at', [$uri0, $uri1])
                                ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                ->get()->toArray();
        
       $totalBStatement = DB::table(
                                    'lechon_de_cebu_billing_statements')
                                    ->select(
                                        'lechon_de_cebu_billing_statements.id',
                                        'lechon_de_cebu_billing_statements.user_id',
                                        'lechon_de_cebu_billing_statements.billing_statement_id',
                                        'lechon_de_cebu_billing_statements.bill_to',
                                        'lechon_de_cebu_billing_statements.address',
                                        'lechon_de_cebu_billing_statements.date',
                                        'lechon_de_cebu_billing_statements.branch',
                                        'lechon_de_cebu_billing_statements.period_cover',
                                        'lechon_de_cebu_billing_statements.terms',
                                        'lechon_de_cebu_billing_statements.date_of_transaction',
                                        'lechon_de_cebu_billing_statements.invoice_number',
                                        'lechon_de_cebu_billing_statements.order',
                                        'lechon_de_cebu_billing_statements.whole_lechon',
                                        'lechon_de_cebu_billing_statements.description',
                                        'lechon_de_cebu_billing_statements.amount',
                                        'lechon_de_cebu_billing_statements.total_amount',
                                        'lechon_de_cebu_billing_statements.paid_amount',
                                        'lechon_de_cebu_billing_statements.created_by',
                                        'lechon_de_cebu_billing_statements.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                    ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                    ->whereBetween('lechon_de_cebu_billing_statements.created_at', [$uri0, $uri1])
                                    ->sum('lechon_de_cebu_billing_statements.total_amount');
            

        $pdf = PDF::loadView('printSummaryBillingStatement',  compact('date', 'uri0', 'uri1', 
        'billingStatements', 'totalBStatement'));
        
        return $pdf->download('lechon-de-cebu-summary-report-billing-statement.pdf');

    }

    public function printGetSummaryBillingStatement($date){ 
        //billing statement
         $moduleNameBillingStatement = "Billing Statement";
         $billingStatements = DB::table(
                                 'lechon_de_cebu_billing_statements')
                                 ->select(
                                     'lechon_de_cebu_billing_statements.id',
                                     'lechon_de_cebu_billing_statements.user_id',
                                     'lechon_de_cebu_billing_statements.billing_statement_id',
                                     'lechon_de_cebu_billing_statements.bill_to',
                                     'lechon_de_cebu_billing_statements.address',
                                     'lechon_de_cebu_billing_statements.date',
                                     'lechon_de_cebu_billing_statements.branch',
                                     'lechon_de_cebu_billing_statements.period_cover',
                                     'lechon_de_cebu_billing_statements.terms',
                                     'lechon_de_cebu_billing_statements.date_of_transaction',
                                     'lechon_de_cebu_billing_statements.invoice_number',
                                     'lechon_de_cebu_billing_statements.order',
                                     'lechon_de_cebu_billing_statements.whole_lechon',
                                     'lechon_de_cebu_billing_statements.description',
                                     'lechon_de_cebu_billing_statements.amount',
                                     'lechon_de_cebu_billing_statements.total_amount',
                                     'lechon_de_cebu_billing_statements.paid_amount',
                                     'lechon_de_cebu_billing_statements.created_by',
                                     'lechon_de_cebu_billing_statements.deleted_at',
                                     'lechon_de_cebu_codes.lechon_de_cebu_code',
                                     'lechon_de_cebu_codes.module_id',
                                     'lechon_de_cebu_codes.module_code',
                                     'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                 ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($date))
                                 ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                 ->get()->toArray();
         
        $totalBStatement = DB::table(
                                     'lechon_de_cebu_billing_statements')
                                     ->select(
                                         'lechon_de_cebu_billing_statements.id',
                                         'lechon_de_cebu_billing_statements.user_id',
                                         'lechon_de_cebu_billing_statements.billing_statement_id',
                                         'lechon_de_cebu_billing_statements.bill_to',
                                         'lechon_de_cebu_billing_statements.address',
                                         'lechon_de_cebu_billing_statements.date',
                                         'lechon_de_cebu_billing_statements.branch',
                                         'lechon_de_cebu_billing_statements.period_cover',
                                         'lechon_de_cebu_billing_statements.terms',
                                         'lechon_de_cebu_billing_statements.date_of_transaction',
                                         'lechon_de_cebu_billing_statements.invoice_number',
                                         'lechon_de_cebu_billing_statements.order',
                                         'lechon_de_cebu_billing_statements.whole_lechon',
                                         'lechon_de_cebu_billing_statements.description',
                                         'lechon_de_cebu_billing_statements.amount',
                                         'lechon_de_cebu_billing_statements.total_amount',
                                         'lechon_de_cebu_billing_statements.paid_amount',
                                         'lechon_de_cebu_billing_statements.created_by',
                                         'lechon_de_cebu_billing_statements.deleted_at',
                                         'lechon_de_cebu_codes.lechon_de_cebu_code',
                                         'lechon_de_cebu_codes.module_id',
                                         'lechon_de_cebu_codes.module_code',
                                         'lechon_de_cebu_codes.module_name')
                                     ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                     ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                     ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                     ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                     ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($date))
                                     ->sum('lechon_de_cebu_billing_statements.total_amount');

        $getDateToday = "";
        $uri0 ="";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryBillingStatement',  compact('date', 'uri0', 'uri1', 'getDateToday',
        'billingStatements', 'totalBStatement'));
        
        return $pdf->download('lechon-de-cebu-summary-report-billing-statement.pdf');
    }

    public function printSummaryBillingStatement(){
        $getDateToday = date("Y-m-d");

         //billing statement
         $moduleNameBillingStatement = "Billing Statement";
         $billingStatements = DB::table(
                                 'lechon_de_cebu_billing_statements')
                                 ->select(
                                     'lechon_de_cebu_billing_statements.id',
                                     'lechon_de_cebu_billing_statements.user_id',
                                     'lechon_de_cebu_billing_statements.billing_statement_id',
                                     'lechon_de_cebu_billing_statements.bill_to',
                                     'lechon_de_cebu_billing_statements.address',
                                     'lechon_de_cebu_billing_statements.date',
                                     'lechon_de_cebu_billing_statements.branch',
                                     'lechon_de_cebu_billing_statements.period_cover',
                                     'lechon_de_cebu_billing_statements.terms',
                                     'lechon_de_cebu_billing_statements.date_of_transaction',
                                     'lechon_de_cebu_billing_statements.invoice_number',
                                     'lechon_de_cebu_billing_statements.order',
                                     'lechon_de_cebu_billing_statements.whole_lechon',
                                     'lechon_de_cebu_billing_statements.description',
                                     'lechon_de_cebu_billing_statements.amount',
                                     'lechon_de_cebu_billing_statements.total_amount',
                                     'lechon_de_cebu_billing_statements.paid_amount',
                                     'lechon_de_cebu_billing_statements.created_by',
                                     'lechon_de_cebu_billing_statements.deleted_at',
                                     'lechon_de_cebu_codes.lechon_de_cebu_code',
                                     'lechon_de_cebu_codes.module_id',
                                     'lechon_de_cebu_codes.module_code',
                                     'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                 ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($getDateToday))
                                 ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                 ->get()->toArray();
         
            $totalBStatement = DB::table(
                                     'lechon_de_cebu_billing_statements')
                                     ->select(
                                         'lechon_de_cebu_billing_statements.id',
                                         'lechon_de_cebu_billing_statements.user_id',
                                         'lechon_de_cebu_billing_statements.billing_statement_id',
                                         'lechon_de_cebu_billing_statements.bill_to',
                                         'lechon_de_cebu_billing_statements.address',
                                         'lechon_de_cebu_billing_statements.date',
                                         'lechon_de_cebu_billing_statements.branch',
                                         'lechon_de_cebu_billing_statements.period_cover',
                                         'lechon_de_cebu_billing_statements.terms',
                                         'lechon_de_cebu_billing_statements.date_of_transaction',
                                         'lechon_de_cebu_billing_statements.invoice_number',
                                         'lechon_de_cebu_billing_statements.order',
                                         'lechon_de_cebu_billing_statements.whole_lechon',
                                         'lechon_de_cebu_billing_statements.description',
                                         'lechon_de_cebu_billing_statements.amount',
                                         'lechon_de_cebu_billing_statements.total_amount',
                                         'lechon_de_cebu_billing_statements.paid_amount',
                                         'lechon_de_cebu_billing_statements.created_by',
                                         'lechon_de_cebu_billing_statements.deleted_at',
                                         'lechon_de_cebu_codes.lechon_de_cebu_code',
                                         'lechon_de_cebu_codes.module_id',
                                         'lechon_de_cebu_codes.module_code',
                                         'lechon_de_cebu_codes.module_name')
                                     ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                     ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                     ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                     ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                     ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($getDateToday))
                                     ->sum('lechon_de_cebu_billing_statements.total_amount');
         
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryBillingStatement',  compact('uri0', 'uri1', 'getDateToday', 
        'billingStatements', 'totalBStatement'));
                            
        return $pdf->download('lechon-de-cebu-summary-report-billing-statement.pdf');


    }

    public function printMultipleSummarySOA(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];  

        $moduleNameSOA = "Statement Of Account";

        $statementOfAccounts = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.bs_no',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameSOA)
                                ->whereBetween('lechon_de_cebu_statement_of_accounts.created_at', [$uri0, $uri1])
                                ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                ->get()->toArray();



        $pdf = PDF::loadView('printSummarySOA',  compact('date', 'uri0', 'uri1', 
        'statementOfAccounts'));
        
        return $pdf->download('lechon-de-cebu-summary-report-soa.pdf');

    }

    public function printGetSummarySOA($date){
        $moduleNameSOA = "Statement Of Account";

        $statementOfAccounts = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.bs_no',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameSOA)
                                ->whereDate('lechon_de_cebu_statement_of_accounts.created_at', '=', date($date))
                                ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                ->get()->toArray();

        $getDateToday = "";
        $uri0 ="";
        $uri1 = "";
        $pdf = PDF::loadView('printSummarySOA',  compact('date', 'uri0', 'uri1', 'getDateToday',
        'statementOfAccounts'));
        
        return $pdf->download('lechon-de-cebu-summary-report-soa.pdf');
           
    }


    public function printSummarySOA(){
        
        $getDateToday = date("Y-m-d");
        
        $moduleNameSOA = "Statement Of Account";
        $statementOfAccounts = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.bs_no',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameSOA)
                                ->whereDate('lechon_de_cebu_statement_of_accounts.created_at', '=', date($getDateToday))
                                ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                ->get()->toArray();
           
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummarySOA',  compact('uri0', 'uri1', 'getDateToday', 'statementOfAccounts'));
        return $pdf->download('lechon-de-cebu-summary-report-SOA.pdf');


    }

    public function printMultipleSummaryPurchaseOrder(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];  

         //purchase order
         $moduleNamePurchaseOrder = "Purchase Order";
         $purchaseOrders = DB::table(
                         'lechon_de_cebu_purchase_orders')
                         ->select(
                             'lechon_de_cebu_purchase_orders.id',
                             'lechon_de_cebu_purchase_orders.user_id',
                             'lechon_de_cebu_purchase_orders.po_id',
                             'lechon_de_cebu_purchase_orders.paid_to',
                             'lechon_de_cebu_purchase_orders.address',
                             'lechon_de_cebu_purchase_orders.date',
                             'lechon_de_cebu_purchase_orders.quantity',
                             'lechon_de_cebu_purchase_orders.total_kls',
                             'lechon_de_cebu_purchase_orders.description',
                             'lechon_de_cebu_purchase_orders.unit_price',
                             'lechon_de_cebu_purchase_orders.amount',
                             'lechon_de_cebu_purchase_orders.total_price',
                             'lechon_de_cebu_purchase_orders.requested_by',
                             'lechon_de_cebu_purchase_orders.prepared_by',
                             'lechon_de_cebu_purchase_orders.checked_by',
                             'lechon_de_cebu_purchase_orders.created_by',
                             'lechon_de_cebu_purchase_orders.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                         ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                         ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                         ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                         ->whereBetween('lechon_de_cebu_purchase_orders.created_at', [$uri0, $uri1])
                         ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                         ->get()->toArray();
 
             $totalPOrder = DB::table(
                             'lechon_de_cebu_purchase_orders')
                             ->select(
                                 'lechon_de_cebu_purchase_orders.id',
                                 'lechon_de_cebu_purchase_orders.user_id',
                                 'lechon_de_cebu_purchase_orders.po_id',
                                 'lechon_de_cebu_purchase_orders.paid_to',
                                 'lechon_de_cebu_purchase_orders.address',
                                 'lechon_de_cebu_purchase_orders.date',
                                 'lechon_de_cebu_purchase_orders.quantity',
                                 'lechon_de_cebu_purchase_orders.total_kls',
                                 'lechon_de_cebu_purchase_orders.description',
                                 'lechon_de_cebu_purchase_orders.unit_price',
                                 'lechon_de_cebu_purchase_orders.amount',
                                 'lechon_de_cebu_purchase_orders.total_price',
                                 'lechon_de_cebu_purchase_orders.requested_by',
                                 'lechon_de_cebu_purchase_orders.prepared_by',
                                 'lechon_de_cebu_purchase_orders.checked_by',
                                 'lechon_de_cebu_purchase_orders.created_by',
                                  'lechon_de_cebu_purchase_orders.created_by',
                                 'lechon_de_cebu_purchase_orders.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                             ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                             ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                             ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                             ->whereBetween('lechon_de_cebu_purchase_orders.created_at', [$uri0, $uri1])
                             ->sum('lechon_de_cebu_purchase_orders.total_price');

        
            $pdf = PDF::loadView('printSummaryPurchaseOrder',  compact('date', 'uri0', 'uri1', 
            'purchaseOrders', 'totalPOrder'));
            
            return $pdf->download('lechon-de-cebu-summary-report-purchase-order.pdf');

    }

    public function printGetSummaryPurchaseOrder($date){
         //purchase order
         $moduleNamePurchaseOrder = "Purchase Order";
         $purchaseOrders = DB::table(
                         'lechon_de_cebu_purchase_orders')
                         ->select(
                             'lechon_de_cebu_purchase_orders.id',
                             'lechon_de_cebu_purchase_orders.user_id',
                             'lechon_de_cebu_purchase_orders.po_id',
                             'lechon_de_cebu_purchase_orders.paid_to',
                             'lechon_de_cebu_purchase_orders.address',
                             'lechon_de_cebu_purchase_orders.date',
                             'lechon_de_cebu_purchase_orders.quantity',
                             'lechon_de_cebu_purchase_orders.total_kls',
                             'lechon_de_cebu_purchase_orders.description',
                             'lechon_de_cebu_purchase_orders.unit_price',
                             'lechon_de_cebu_purchase_orders.amount',
                             'lechon_de_cebu_purchase_orders.total_price',
                             'lechon_de_cebu_purchase_orders.requested_by',
                             'lechon_de_cebu_purchase_orders.prepared_by',
                             'lechon_de_cebu_purchase_orders.checked_by',
                             'lechon_de_cebu_purchase_orders.created_by',
                             'lechon_de_cebu_purchase_orders.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                         ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                         ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                         ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                         ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($date))
                         ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                         ->get()->toArray();
 
             $totalPOrder = DB::table(
                             'lechon_de_cebu_purchase_orders')
                             ->select(
                                 'lechon_de_cebu_purchase_orders.id',
                                 'lechon_de_cebu_purchase_orders.user_id',
                                 'lechon_de_cebu_purchase_orders.po_id',
                                 'lechon_de_cebu_purchase_orders.paid_to',
                                 'lechon_de_cebu_purchase_orders.address',
                                 'lechon_de_cebu_purchase_orders.date',
                                 'lechon_de_cebu_purchase_orders.quantity',
                                 'lechon_de_cebu_purchase_orders.total_kls',
                                 'lechon_de_cebu_purchase_orders.description',
                                 'lechon_de_cebu_purchase_orders.unit_price',
                                 'lechon_de_cebu_purchase_orders.amount',
                                 'lechon_de_cebu_purchase_orders.total_price',
                                 'lechon_de_cebu_purchase_orders.requested_by',
                                 'lechon_de_cebu_purchase_orders.prepared_by',
                                 'lechon_de_cebu_purchase_orders.checked_by',
                                 'lechon_de_cebu_purchase_orders.created_by',
                                  'lechon_de_cebu_purchase_orders.created_by',
                                 'lechon_de_cebu_purchase_orders.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                             ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                             ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                             ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                             ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($date))
                             ->sum('lechon_de_cebu_purchase_orders.total_price');

        $getDateToday = "";
        $uri0 ="";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryPurchaseOrder',  compact('date', 'uri0', 'uri1', 'getDateToday',
        'purchaseOrders', 'totalPOrder'));
        
        return $pdf->download('lechon-de-cebu-summary-report-purchase-order.pdf');

    }

    public function printSummaryPurchaseOrder(){
        $getDateToday = date("Y-m-d");

         //purchase order
         $moduleNamePurchaseOrder = "Purchase Order";
         $purchaseOrders = DB::table(
                         'lechon_de_cebu_purchase_orders')
                         ->select(
                             'lechon_de_cebu_purchase_orders.id',
                             'lechon_de_cebu_purchase_orders.user_id',
                             'lechon_de_cebu_purchase_orders.po_id',
                             'lechon_de_cebu_purchase_orders.paid_to',
                             'lechon_de_cebu_purchase_orders.address',
                             'lechon_de_cebu_purchase_orders.date',
                             'lechon_de_cebu_purchase_orders.quantity',
                             'lechon_de_cebu_purchase_orders.total_kls',
                             'lechon_de_cebu_purchase_orders.description',
                             'lechon_de_cebu_purchase_orders.unit_price',
                             'lechon_de_cebu_purchase_orders.amount',
                             'lechon_de_cebu_purchase_orders.total_price',
                             'lechon_de_cebu_purchase_orders.requested_by',
                             'lechon_de_cebu_purchase_orders.prepared_by',
                             'lechon_de_cebu_purchase_orders.checked_by',
                             'lechon_de_cebu_purchase_orders.created_by',
                             'lechon_de_cebu_purchase_orders.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                         ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                         ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                         ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                         ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($getDateToday))
                         ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                         ->get()->toArray();
 
             $totalPOrder = DB::table(
                             'lechon_de_cebu_purchase_orders')
                             ->select(
                                 'lechon_de_cebu_purchase_orders.id',
                                 'lechon_de_cebu_purchase_orders.user_id',
                                 'lechon_de_cebu_purchase_orders.po_id',
                                 'lechon_de_cebu_purchase_orders.paid_to',
                                 'lechon_de_cebu_purchase_orders.address',
                                 'lechon_de_cebu_purchase_orders.date',
                                 'lechon_de_cebu_purchase_orders.quantity',
                                 'lechon_de_cebu_purchase_orders.total_kls',
                                 'lechon_de_cebu_purchase_orders.description',
                                 'lechon_de_cebu_purchase_orders.unit_price',
                                 'lechon_de_cebu_purchase_orders.amount',
                                 'lechon_de_cebu_purchase_orders.total_price',
                                 'lechon_de_cebu_purchase_orders.requested_by',
                                 'lechon_de_cebu_purchase_orders.prepared_by',
                                 'lechon_de_cebu_purchase_orders.checked_by',
                                 'lechon_de_cebu_purchase_orders.created_by',
                                  'lechon_de_cebu_purchase_orders.created_by',
                                 'lechon_de_cebu_purchase_orders.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                             ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                             ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                             ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                             ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($getDateToday))
                             ->sum('lechon_de_cebu_purchase_orders.total_price');

            $uri0 = "";
            $uri1 = "";
            $pdf = PDF::loadView('printSummaryPurchaseOrder',  compact('uri0', 'uri1', 'getDateToday', 
            'purchaseOrders', 'totalPOrder'));
            
            return $pdf->download('lechon-de-cebu-summary-report-purchase-order.pdf');


    }

    public function printMultipleSummaryDeliveryReceipt(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];   
        
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_delivery_receipts.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                ->whereBetween('lechon_de_cebu_delivery_receipts.created_at', [$uri0, $uri1])
                                ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                ->get()->toArray();

        //total for delivery receipt
        $moduleNameDelivery = "Delivery Receipt";
        $totalDeliveryReceipt = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_delivery_receipts.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                ->whereBetween('lechon_de_cebu_delivery_receipts.created_at', [$uri0, $uri1])
                                ->sum('lechon_de_cebu_delivery_receipts.total');


        $pdf = PDF::loadView('printSummaryDeliveryReceipt',  compact('date', 'uri0', 'uri1', 
        'getAllDeliveryReceipts',  'totalDeliveryReceipt'));
        
        return $pdf->download('lechon-de-cebu-summary-report-delivery-receipt.pdf');

    }

    public function printGetSummaryDeliveryReceipt($date){
          //Delivery Receipt 
          $moduleNameDelivery = "Delivery Receipt";
          $getAllDeliveryReceipts = DB::table(
                                  'lechon_de_cebu_delivery_receipts')
                                  ->select( 
                                  'lechon_de_cebu_delivery_receipts.id',
                                  'lechon_de_cebu_delivery_receipts.user_id',
                                  'lechon_de_cebu_delivery_receipts.dr_id',
                                  'lechon_de_cebu_delivery_receipts.sold_to',
                                  'lechon_de_cebu_delivery_receipts.delivered_to',
                                  'lechon_de_cebu_delivery_receipts.time',
                                  'lechon_de_cebu_delivery_receipts.date',
                                  'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                  'lechon_de_cebu_delivery_receipts.contact_person',
                                  'lechon_de_cebu_delivery_receipts.mobile_num',
                                  'lechon_de_cebu_delivery_receipts.qty',
                                  'lechon_de_cebu_delivery_receipts.description',
                                  'lechon_de_cebu_delivery_receipts.price',
                                  'lechon_de_cebu_delivery_receipts.total',
                                  'lechon_de_cebu_delivery_receipts.special_instruction',
                                  'lechon_de_cebu_delivery_receipts.consignee_name',
                                  'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                  'lechon_de_cebu_delivery_receipts.prepared_by',
                                  'lechon_de_cebu_delivery_receipts.checked_by',
                                  'lechon_de_cebu_delivery_receipts.received_by',
                                  'lechon_de_cebu_delivery_receipts.duplicate_status',
                                  'lechon_de_cebu_delivery_receipts.created_by',
                                  'lechon_de_cebu_delivery_receipts.deleted_at',
                                  'lechon_de_cebu_codes.lechon_de_cebu_code',
                                  'lechon_de_cebu_codes.module_id',
                                  'lechon_de_cebu_codes.module_code',
                                  'lechon_de_cebu_codes.module_name')
                                  ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                  ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                  ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                  ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                  ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($date))
                                  ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                  ->get()->toArray();
  
          //total for delivery receipt
          $moduleNameDelivery = "Delivery Receipt";
          $totalDeliveryReceipt = DB::table(
                                  'lechon_de_cebu_delivery_receipts')
                                  ->select( 
                                  'lechon_de_cebu_delivery_receipts.id',
                                  'lechon_de_cebu_delivery_receipts.user_id',
                                  'lechon_de_cebu_delivery_receipts.dr_id',
                                  'lechon_de_cebu_delivery_receipts.sold_to',
                                  'lechon_de_cebu_delivery_receipts.delivered_to',
                                  'lechon_de_cebu_delivery_receipts.time',
                                  'lechon_de_cebu_delivery_receipts.date',
                                  'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                  'lechon_de_cebu_delivery_receipts.contact_person',
                                  'lechon_de_cebu_delivery_receipts.mobile_num',
                                  'lechon_de_cebu_delivery_receipts.qty',
                                  'lechon_de_cebu_delivery_receipts.description',
                                  'lechon_de_cebu_delivery_receipts.price',
                                  'lechon_de_cebu_delivery_receipts.total',
                                  'lechon_de_cebu_delivery_receipts.special_instruction',
                                  'lechon_de_cebu_delivery_receipts.consignee_name',
                                  'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                  'lechon_de_cebu_delivery_receipts.prepared_by',
                                  'lechon_de_cebu_delivery_receipts.checked_by',
                                  'lechon_de_cebu_delivery_receipts.received_by',
                                  'lechon_de_cebu_delivery_receipts.duplicate_status',
                                  'lechon_de_cebu_delivery_receipts.created_by',
                                  'lechon_de_cebu_delivery_receipts.deleted_at',
                                  'lechon_de_cebu_codes.lechon_de_cebu_code',
                                  'lechon_de_cebu_codes.module_id',
                                  'lechon_de_cebu_codes.module_code',
                                  'lechon_de_cebu_codes.module_name')
                                  ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                  ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                  ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                  ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                  ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($date))
                                  ->sum('lechon_de_cebu_delivery_receipts.total');

            $getDateToday = "";
            $uri0 ="";
            $uri1 = "";
            $pdf = PDF::loadView('printSummaryDeliveryReceipt',  compact('date', 'uri0', 'uri1', 'getDateToday',
            'getAllDeliveryReceipts', 'totalDeliveryReceipt'));
            
            return $pdf->download('lechon-de-cebu-summary-report-delivery-receipt.pdf');
 
    }

    public function printSummaryDeliveryReceipt(){
        $getDateToday = date("Y-m-d");

         //Delivery Receipt 
         $moduleNameDelivery = "Delivery Receipt";
         $getAllDeliveryReceipts = DB::table(
                                 'lechon_de_cebu_delivery_receipts')
                                 ->select( 
                                 'lechon_de_cebu_delivery_receipts.id',
                                 'lechon_de_cebu_delivery_receipts.user_id',
                                 'lechon_de_cebu_delivery_receipts.dr_id',
                                 'lechon_de_cebu_delivery_receipts.sold_to',
                                 'lechon_de_cebu_delivery_receipts.delivered_to',
                                 'lechon_de_cebu_delivery_receipts.time',
                                 'lechon_de_cebu_delivery_receipts.date',
                                 'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                 'lechon_de_cebu_delivery_receipts.contact_person',
                                 'lechon_de_cebu_delivery_receipts.mobile_num',
                                 'lechon_de_cebu_delivery_receipts.qty',
                                 'lechon_de_cebu_delivery_receipts.description',
                                 'lechon_de_cebu_delivery_receipts.price',
                                 'lechon_de_cebu_delivery_receipts.total',
                                 'lechon_de_cebu_delivery_receipts.special_instruction',
                                 'lechon_de_cebu_delivery_receipts.consignee_name',
                                 'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                 'lechon_de_cebu_delivery_receipts.prepared_by',
                                 'lechon_de_cebu_delivery_receipts.checked_by',
                                 'lechon_de_cebu_delivery_receipts.received_by',
                                 'lechon_de_cebu_delivery_receipts.duplicate_status',
                                 'lechon_de_cebu_delivery_receipts.created_by',
                                 'lechon_de_cebu_delivery_receipts.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                 ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($getDateToday))
                                 ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                 ->get()->toArray();
 
         //total for delivery receipt
         $moduleNameDelivery = "Delivery Receipt";
         $totalDeliveryReceipt = DB::table(
                                 'lechon_de_cebu_delivery_receipts')
                                 ->select( 
                                 'lechon_de_cebu_delivery_receipts.id',
                                 'lechon_de_cebu_delivery_receipts.user_id',
                                 'lechon_de_cebu_delivery_receipts.dr_id',
                                 'lechon_de_cebu_delivery_receipts.sold_to',
                                 'lechon_de_cebu_delivery_receipts.delivered_to',
                                 'lechon_de_cebu_delivery_receipts.time',
                                 'lechon_de_cebu_delivery_receipts.date',
                                 'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                 'lechon_de_cebu_delivery_receipts.contact_person',
                                 'lechon_de_cebu_delivery_receipts.mobile_num',
                                 'lechon_de_cebu_delivery_receipts.qty',
                                 'lechon_de_cebu_delivery_receipts.description',
                                 'lechon_de_cebu_delivery_receipts.price',
                                 'lechon_de_cebu_delivery_receipts.total',
                                 'lechon_de_cebu_delivery_receipts.special_instruction',
                                 'lechon_de_cebu_delivery_receipts.consignee_name',
                                 'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                 'lechon_de_cebu_delivery_receipts.prepared_by',
                                 'lechon_de_cebu_delivery_receipts.checked_by',
                                 'lechon_de_cebu_delivery_receipts.received_by',
                                 'lechon_de_cebu_delivery_receipts.duplicate_status',
                                 'lechon_de_cebu_delivery_receipts.created_by',
                                 'lechon_de_cebu_delivery_receipts.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                 ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($getDateToday))
                                 ->sum('lechon_de_cebu_delivery_receipts.total');

            $uri0 = "";
            $uri1 = "";
            $pdf = PDF::loadView('printSummaryDeliveryReceipt',  compact('uri0', 'uri1', 'getDateToday', 
            'getAllDeliveryReceipts', 'totalDeliveryReceipt'));
                                 
            return $pdf->download('lechon-de-cebu-summary-report-delivery-receipt.pdf');
         
    }   


    public function printMultipleSummarySalesInvoice(Request $request, $date){
        $urlSegment = \Request::segment(3);
        $uri = explode("TO", $urlSegment);
        $uri0 = $uri[0];
        $uri1 = $uri[1];

        $moduleName = "Sales Invoice";
         $getAllSalesInvoices = DB::table(
                         'lechon_de_cebu_sales_invoices')
                         ->select(
                             'lechon_de_cebu_sales_invoices.id',
                             'lechon_de_cebu_sales_invoices.user_id',
                             'lechon_de_cebu_sales_invoices.si_id',
                             'lechon_de_cebu_sales_invoices.invoice_number',
                             'lechon_de_cebu_sales_invoices.date',
                             'lechon_de_cebu_sales_invoices.ordered_by',
                             'lechon_de_cebu_sales_invoices.address',
                             'lechon_de_cebu_sales_invoices.qty',
                             'lechon_de_cebu_sales_invoices.total_kls',
                             'lechon_de_cebu_sales_invoices.body',
                             'lechon_de_cebu_sales_invoices.head_and_feet',
                             'lechon_de_cebu_sales_invoices.item_description',
                             'lechon_de_cebu_sales_invoices.unit_price',
                             'lechon_de_cebu_sales_invoices.amount',
                             'lechon_de_cebu_sales_invoices.total_amount',
                             'lechon_de_cebu_sales_invoices.created_by',
                             'lechon_de_cebu_sales_invoices.created_at',
                             'lechon_de_cebu_sales_invoices.updated_at',  
                             'lechon_de_cebu_sales_invoices.deleted_at',                            
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                         ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                         ->where('lechon_de_cebu_codes.module_name', $moduleName)
                         ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                         ->whereBetween('lechon_de_cebu_sales_invoices.created_at', [$uri0, $uri1])
                         ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                         ->get()->toArray();
        
        $totalSalesInvoice = DB::table(
                            'lechon_de_cebu_sales_invoices')
                            ->select(
                                'lechon_de_cebu_sales_invoices.id',
                                'lechon_de_cebu_sales_invoices.user_id',
                                'lechon_de_cebu_sales_invoices.si_id',
                                'lechon_de_cebu_sales_invoices.invoice_number',
                                'lechon_de_cebu_sales_invoices.date',
                                'lechon_de_cebu_sales_invoices.ordered_by',
                                'lechon_de_cebu_sales_invoices.address',
                                'lechon_de_cebu_sales_invoices.qty',
                                'lechon_de_cebu_sales_invoices.total_kls',
                                'lechon_de_cebu_sales_invoices.body',
                                'lechon_de_cebu_sales_invoices.head_and_feet',
                                'lechon_de_cebu_sales_invoices.item_description',
                                'lechon_de_cebu_sales_invoices.unit_price',
                                'lechon_de_cebu_sales_invoices.amount',
                                'lechon_de_cebu_sales_invoices.total_amount',
                                'lechon_de_cebu_sales_invoices.created_by',
                                'lechon_de_cebu_sales_invoices.created_at',
                                'lechon_de_cebu_sales_invoices.updated_at',
                                'lechon_de_cebu_sales_invoices.deleted_at',                            
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                            ->whereBetween('lechon_de_cebu_sales_invoices.created_at', [$uri0, $uri1])
                            ->sum('lechon_de_cebu_sales_invoices.total_amount');


        $pdf = PDF::loadView('printSummarySalesInvoice',  compact('date', 'uri0', 'uri1', 'getAllSalesInvoices', 
        'totalSalesInvoice'));
        
        return $pdf->download('lechon-de-cebu-summary-report-sales-report.pdf');
    }

    public function printGetSummarySalesInvoice($date){
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'lechon_de_cebu_sales_invoices')
                        ->select(
                            'lechon_de_cebu_sales_invoices.id',
                            'lechon_de_cebu_sales_invoices.user_id',
                            'lechon_de_cebu_sales_invoices.si_id',
                            'lechon_de_cebu_sales_invoices.invoice_number',
                            'lechon_de_cebu_sales_invoices.date',
                            'lechon_de_cebu_sales_invoices.ordered_by',
                            'lechon_de_cebu_sales_invoices.address',
                            'lechon_de_cebu_sales_invoices.qty',
                            'lechon_de_cebu_sales_invoices.total_kls',
                            'lechon_de_cebu_sales_invoices.body',
                            'lechon_de_cebu_sales_invoices.head_and_feet',
                            'lechon_de_cebu_sales_invoices.item_description',
                            'lechon_de_cebu_sales_invoices.unit_price',
                            'lechon_de_cebu_sales_invoices.amount',
                            'lechon_de_cebu_sales_invoices.total_amount',
                            'lechon_de_cebu_sales_invoices.created_by',
                            'lechon_de_cebu_sales_invoices.created_at',
                            'lechon_de_cebu_sales_invoices.updated_at',  
                            'lechon_de_cebu_sales_invoices.deleted_at',                            
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                        ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($date))
                        ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                        ->get()->toArray();
       
       $totalSalesInvoice = DB::table(
                           'lechon_de_cebu_sales_invoices')
                           ->select(
                               'lechon_de_cebu_sales_invoices.id',
                               'lechon_de_cebu_sales_invoices.user_id',
                               'lechon_de_cebu_sales_invoices.si_id',
                               'lechon_de_cebu_sales_invoices.invoice_number',
                               'lechon_de_cebu_sales_invoices.date',
                               'lechon_de_cebu_sales_invoices.ordered_by',
                               'lechon_de_cebu_sales_invoices.address',
                               'lechon_de_cebu_sales_invoices.qty',
                               'lechon_de_cebu_sales_invoices.total_kls',
                               'lechon_de_cebu_sales_invoices.body',
                               'lechon_de_cebu_sales_invoices.head_and_feet',
                               'lechon_de_cebu_sales_invoices.item_description',
                               'lechon_de_cebu_sales_invoices.unit_price',
                               'lechon_de_cebu_sales_invoices.amount',
                               'lechon_de_cebu_sales_invoices.total_amount',
                               'lechon_de_cebu_sales_invoices.created_by',
                               'lechon_de_cebu_sales_invoices.created_at',
                               'lechon_de_cebu_sales_invoices.updated_at',
                               'lechon_de_cebu_sales_invoices.deleted_at',                            
                               'lechon_de_cebu_codes.lechon_de_cebu_code',
                               'lechon_de_cebu_codes.module_id',
                               'lechon_de_cebu_codes.module_code',
                               'lechon_de_cebu_codes.module_name')
                           ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                           ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                           ->where('lechon_de_cebu_codes.module_name', $moduleName)
                           ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                           ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($date))
                           ->sum('lechon_de_cebu_sales_invoices.total_amount');

            $getDateToday = "";
            $uri0 ="";
            $uri1 = "";
            $pdf = PDF::loadView('printSummarySalesInvoice',  compact('date', 'uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
            'totalSalesInvoice'));
            
            return $pdf->download('lechon-de-cebu-summary-report-sales-invoice.pdf');

    }

    //printSummary sales invoice
    public function printSummarySalesInvoice(){
        //sales invoice
        $getDateToday = date("Y-m-d");

        $moduleName = "Sales Invoice";

        $getAllSalesInvoices = DB::table(
            'lechon_de_cebu_sales_invoices')
            ->select(
                'lechon_de_cebu_sales_invoices.id',
                'lechon_de_cebu_sales_invoices.user_id',
                'lechon_de_cebu_sales_invoices.si_id',
                'lechon_de_cebu_sales_invoices.invoice_number',
                'lechon_de_cebu_sales_invoices.date',
                'lechon_de_cebu_sales_invoices.ordered_by',
                'lechon_de_cebu_sales_invoices.address',
                'lechon_de_cebu_sales_invoices.qty',
                'lechon_de_cebu_sales_invoices.total_kls',
                'lechon_de_cebu_sales_invoices.body',
                'lechon_de_cebu_sales_invoices.head_and_feet',
                'lechon_de_cebu_sales_invoices.item_description',
                'lechon_de_cebu_sales_invoices.unit_price',
                'lechon_de_cebu_sales_invoices.amount',
                'lechon_de_cebu_sales_invoices.total_amount',
                'lechon_de_cebu_sales_invoices.created_by',
                'lechon_de_cebu_sales_invoices.created_at',
                'lechon_de_cebu_sales_invoices.updated_at',
                'lechon_de_cebu_sales_invoices.deleted_at',                            
                'lechon_de_cebu_codes.lechon_de_cebu_code',
                'lechon_de_cebu_codes.module_id',
                'lechon_de_cebu_codes.module_code',
                'lechon_de_cebu_codes.module_name')
            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
            ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
            ->where('lechon_de_cebu_codes.module_name', $moduleName)
            ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
            ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($getDateToday))
            ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
            ->get()->toArray();

        $totalSalesInvoice = DB::table(
               'lechon_de_cebu_sales_invoices')
               ->select(
                   'lechon_de_cebu_sales_invoices.id',
                   'lechon_de_cebu_sales_invoices.user_id',
                   'lechon_de_cebu_sales_invoices.si_id',
                   'lechon_de_cebu_sales_invoices.invoice_number',
                   'lechon_de_cebu_sales_invoices.date',
                   'lechon_de_cebu_sales_invoices.ordered_by',
                   'lechon_de_cebu_sales_invoices.address',
                   'lechon_de_cebu_sales_invoices.qty',
                   'lechon_de_cebu_sales_invoices.total_kls',
                   'lechon_de_cebu_sales_invoices.body',
                   'lechon_de_cebu_sales_invoices.head_and_feet',
                   'lechon_de_cebu_sales_invoices.item_description',
                   'lechon_de_cebu_sales_invoices.unit_price',
                   'lechon_de_cebu_sales_invoices.amount',
                   'lechon_de_cebu_sales_invoices.total_amount',
                   'lechon_de_cebu_sales_invoices.created_by',
                   'lechon_de_cebu_sales_invoices.created_at',
                   'lechon_de_cebu_sales_invoices.updated_at', 
                   'lechon_de_cebu_sales_invoices.deleted_at',                            
                   'lechon_de_cebu_codes.lechon_de_cebu_code',
                   'lechon_de_cebu_codes.module_id',
                   'lechon_de_cebu_codes.module_code',
                   'lechon_de_cebu_codes.module_name')
               ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
               ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
               ->where('lechon_de_cebu_codes.module_name', $moduleName)
               ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
               ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($getDateToday))
               ->sum('lechon_de_cebu_sales_invoices.total_amount');

        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummarySalesInvoice',  compact('uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
       'totalSalesInvoice'));   
        
        return $pdf->download('lechon-de-cebu-summary-report-sales-invoice.pdf');



    }
    
    public function printSummary(){
         //sales invoice
         $getDateToday = date("Y-m-d");
         
         $moduleName = "Sales Invoice";
         $getAllSalesInvoices = DB::table(
                         'lechon_de_cebu_sales_invoices')
                         ->select(
                             'lechon_de_cebu_sales_invoices.id',
                             'lechon_de_cebu_sales_invoices.user_id',
                             'lechon_de_cebu_sales_invoices.si_id',
                             'lechon_de_cebu_sales_invoices.invoice_number',
                             'lechon_de_cebu_sales_invoices.date',
                             'lechon_de_cebu_sales_invoices.ordered_by',
                             'lechon_de_cebu_sales_invoices.address',
                             'lechon_de_cebu_sales_invoices.qty',
                             'lechon_de_cebu_sales_invoices.total_kls',
                             'lechon_de_cebu_sales_invoices.body',
                             'lechon_de_cebu_sales_invoices.head_and_feet',
                             'lechon_de_cebu_sales_invoices.item_description',
                             'lechon_de_cebu_sales_invoices.unit_price',
                             'lechon_de_cebu_sales_invoices.amount',
                             'lechon_de_cebu_sales_invoices.total_amount',
                             'lechon_de_cebu_sales_invoices.created_by',
                             'lechon_de_cebu_sales_invoices.created_at',
                             'lechon_de_cebu_sales_invoices.updated_at',
                             'lechon_de_cebu_sales_invoices.deleted_at',                            
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                         ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                         ->where('lechon_de_cebu_codes.module_name', $moduleName)
                         ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                         ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($getDateToday))
                         ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                         ->get()->toArray();
        
        $totalSalesInvoice = DB::table(
                            'lechon_de_cebu_sales_invoices')
                            ->select(
                                'lechon_de_cebu_sales_invoices.id',
                                'lechon_de_cebu_sales_invoices.user_id',
                                'lechon_de_cebu_sales_invoices.si_id',
                                'lechon_de_cebu_sales_invoices.invoice_number',
                                'lechon_de_cebu_sales_invoices.date',
                                'lechon_de_cebu_sales_invoices.ordered_by',
                                'lechon_de_cebu_sales_invoices.address',
                                'lechon_de_cebu_sales_invoices.qty',
                                'lechon_de_cebu_sales_invoices.total_kls',
                                'lechon_de_cebu_sales_invoices.body',
                                'lechon_de_cebu_sales_invoices.head_and_feet',
                                'lechon_de_cebu_sales_invoices.item_description',
                                'lechon_de_cebu_sales_invoices.unit_price',
                                'lechon_de_cebu_sales_invoices.amount',
                                'lechon_de_cebu_sales_invoices.total_amount',
                                'lechon_de_cebu_sales_invoices.created_by',
                                'lechon_de_cebu_sales_invoices.created_at',
                                'lechon_de_cebu_sales_invoices.updated_at', 
                                'lechon_de_cebu_sales_invoices.deleted_at',                            
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                            ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($getDateToday))
                            ->sum('lechon_de_cebu_sales_invoices.total_amount');

        
 
         //Delivery Receipt
         $moduleNameDelivery = "Delivery Receipt";
         $getAllDeliveryReceipts = DB::table(
                                 'lechon_de_cebu_delivery_receipts')
                                 ->select( 
                                 'lechon_de_cebu_delivery_receipts.id',
                                 'lechon_de_cebu_delivery_receipts.user_id',
                                 'lechon_de_cebu_delivery_receipts.dr_id',
                                 'lechon_de_cebu_delivery_receipts.sold_to',
                                 'lechon_de_cebu_delivery_receipts.delivered_to',
                                 'lechon_de_cebu_delivery_receipts.time',
                                 'lechon_de_cebu_delivery_receipts.date',
                                 'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                 'lechon_de_cebu_delivery_receipts.contact_person',
                                 'lechon_de_cebu_delivery_receipts.mobile_num',
                                 'lechon_de_cebu_delivery_receipts.qty',
                                 'lechon_de_cebu_delivery_receipts.description',
                                 'lechon_de_cebu_delivery_receipts.price',
                                 'lechon_de_cebu_delivery_receipts.total',
                                 'lechon_de_cebu_delivery_receipts.special_instruction',
                                 'lechon_de_cebu_delivery_receipts.consignee_name',
                                 'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                 'lechon_de_cebu_delivery_receipts.prepared_by',
                                 'lechon_de_cebu_delivery_receipts.checked_by',
                                 'lechon_de_cebu_delivery_receipts.received_by',
                                 'lechon_de_cebu_delivery_receipts.duplicate_status',
                                 'lechon_de_cebu_delivery_receipts.created_by',
                                 'lechon_de_cebu_delivery_receipts.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                 ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($getDateToday))
                                 ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                 ->get()->toArray();
 
         //total for delivery receipt
         $moduleNameDelivery = "Delivery Receipt";
         $totalDeliveryReceipt = DB::table(
                                 'lechon_de_cebu_delivery_receipts')
                                 ->select( 
                                 'lechon_de_cebu_delivery_receipts.id',
                                 'lechon_de_cebu_delivery_receipts.user_id',
                                 'lechon_de_cebu_delivery_receipts.dr_id',
                                 'lechon_de_cebu_delivery_receipts.sold_to',
                                 'lechon_de_cebu_delivery_receipts.delivered_to',
                                 'lechon_de_cebu_delivery_receipts.time',
                                 'lechon_de_cebu_delivery_receipts.date',
                                 'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                 'lechon_de_cebu_delivery_receipts.contact_person',
                                 'lechon_de_cebu_delivery_receipts.mobile_num',
                                 'lechon_de_cebu_delivery_receipts.qty',
                                 'lechon_de_cebu_delivery_receipts.description',
                                 'lechon_de_cebu_delivery_receipts.price',
                                 'lechon_de_cebu_delivery_receipts.total',
                                 'lechon_de_cebu_delivery_receipts.special_instruction',
                                 'lechon_de_cebu_delivery_receipts.consignee_name',
                                 'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                 'lechon_de_cebu_delivery_receipts.prepared_by',
                                 'lechon_de_cebu_delivery_receipts.checked_by',
                                 'lechon_de_cebu_delivery_receipts.received_by',
                                 'lechon_de_cebu_delivery_receipts.duplicate_status',
                                 'lechon_de_cebu_delivery_receipts.created_by',
                                 'lechon_de_cebu_delivery_receipts.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                 ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($getDateToday))
                                 ->sum('lechon_de_cebu_delivery_receipts.total');
         
 
         //purchase order
         $moduleNamePurchaseOrder = "Purchase Order";
         $purchaseOrders = DB::table(
                         'lechon_de_cebu_purchase_orders')
                         ->select(
                             'lechon_de_cebu_purchase_orders.id',
                             'lechon_de_cebu_purchase_orders.user_id',
                             'lechon_de_cebu_purchase_orders.po_id',
                             'lechon_de_cebu_purchase_orders.paid_to',
                             'lechon_de_cebu_purchase_orders.address',
                             'lechon_de_cebu_purchase_orders.date',
                             'lechon_de_cebu_purchase_orders.quantity',
                             'lechon_de_cebu_purchase_orders.total_kls',
                             'lechon_de_cebu_purchase_orders.description',
                             'lechon_de_cebu_purchase_orders.unit_price',
                             'lechon_de_cebu_purchase_orders.amount',
                             'lechon_de_cebu_purchase_orders.total_price',
                             'lechon_de_cebu_purchase_orders.requested_by',
                             'lechon_de_cebu_purchase_orders.prepared_by',
                             'lechon_de_cebu_purchase_orders.checked_by',
                             'lechon_de_cebu_purchase_orders.created_by',
                             'lechon_de_cebu_purchase_orders.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                         ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                         ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                         ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                         ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                         ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($getDateToday))
                         ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                         ->get()->toArray();
 
             $totalPOrder = DB::table(
                             'lechon_de_cebu_purchase_orders')
                             ->select(
                                 'lechon_de_cebu_purchase_orders.id',
                                 'lechon_de_cebu_purchase_orders.user_id',
                                 'lechon_de_cebu_purchase_orders.po_id',
                                 'lechon_de_cebu_purchase_orders.paid_to',
                                 'lechon_de_cebu_purchase_orders.address',
                                 'lechon_de_cebu_purchase_orders.date',
                                 'lechon_de_cebu_purchase_orders.quantity',
                                 'lechon_de_cebu_purchase_orders.total_kls',
                                 'lechon_de_cebu_purchase_orders.description',
                                 'lechon_de_cebu_purchase_orders.unit_price',
                                 'lechon_de_cebu_purchase_orders.amount',
                                 'lechon_de_cebu_purchase_orders.total_price',
                                 'lechon_de_cebu_purchase_orders.requested_by',
                                 'lechon_de_cebu_purchase_orders.prepared_by',
                                 'lechon_de_cebu_purchase_orders.checked_by',
                                 'lechon_de_cebu_purchase_orders.created_by',
                                  'lechon_de_cebu_purchase_orders.created_by',
                                 'lechon_de_cebu_purchase_orders.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                             ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                             ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                             ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                             ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($getDateToday))
                             ->sum('lechon_de_cebu_purchase_orders.total_price');

         
         //billing statement
         $moduleNameBillingStatement = "Billing Statement";
         $billingStatements = DB::table(
                                 'lechon_de_cebu_billing_statements')
                                 ->select(
                                     'lechon_de_cebu_billing_statements.id',
                                     'lechon_de_cebu_billing_statements.user_id',
                                     'lechon_de_cebu_billing_statements.billing_statement_id',
                                     'lechon_de_cebu_billing_statements.bill_to',
                                     'lechon_de_cebu_billing_statements.address',
                                     'lechon_de_cebu_billing_statements.date',
                                     'lechon_de_cebu_billing_statements.branch',
                                     'lechon_de_cebu_billing_statements.period_cover',
                                     'lechon_de_cebu_billing_statements.terms',
                                     'lechon_de_cebu_billing_statements.date_of_transaction',
                                     'lechon_de_cebu_billing_statements.invoice_number',
                                     'lechon_de_cebu_billing_statements.order',
                                     'lechon_de_cebu_billing_statements.whole_lechon',
                                     'lechon_de_cebu_billing_statements.description',
                                     'lechon_de_cebu_billing_statements.amount',
                                     'lechon_de_cebu_billing_statements.total_amount',
                                     'lechon_de_cebu_billing_statements.paid_amount',
                                     'lechon_de_cebu_billing_statements.created_by',
                                     'lechon_de_cebu_billing_statements.deleted_at',
                                     'lechon_de_cebu_codes.lechon_de_cebu_code',
                                     'lechon_de_cebu_codes.module_id',
                                     'lechon_de_cebu_codes.module_code',
                                     'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                 ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($getDateToday))
                                 ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                 ->get()->toArray();
         
                 $totalBStatement = DB::table(
                                     'lechon_de_cebu_billing_statements')
                                     ->select(
                                         'lechon_de_cebu_billing_statements.id',
                                         'lechon_de_cebu_billing_statements.user_id',
                                         'lechon_de_cebu_billing_statements.billing_statement_id',
                                         'lechon_de_cebu_billing_statements.bill_to',
                                         'lechon_de_cebu_billing_statements.address',
                                         'lechon_de_cebu_billing_statements.date',
                                         'lechon_de_cebu_billing_statements.branch',
                                         'lechon_de_cebu_billing_statements.period_cover',
                                         'lechon_de_cebu_billing_statements.terms',
                                         'lechon_de_cebu_billing_statements.date_of_transaction',
                                         'lechon_de_cebu_billing_statements.invoice_number',
                                         'lechon_de_cebu_billing_statements.order',
                                         'lechon_de_cebu_billing_statements.whole_lechon',
                                         'lechon_de_cebu_billing_statements.description',
                                         'lechon_de_cebu_billing_statements.amount',
                                         'lechon_de_cebu_billing_statements.total_amount',
                                         'lechon_de_cebu_billing_statements.paid_amount',
                                         'lechon_de_cebu_billing_statements.created_by',
                                         'lechon_de_cebu_billing_statements.deleted_at',
                                         'lechon_de_cebu_codes.lechon_de_cebu_code',
                                         'lechon_de_cebu_codes.module_id',
                                         'lechon_de_cebu_codes.module_code',
                                         'lechon_de_cebu_codes.module_name')
                                     ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                     ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                     ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                     ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                     ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($getDateToday))
                                     ->sum('lechon_de_cebu_billing_statements.total_amount');
         
             
         //petty cash
         $moduleNamePettyCash = "Petty Cash";
         $pettyCashLists = DB::table(
                                 'lechon_de_cebu_petty_cashes')
                                 ->select( 
                                 'lechon_de_cebu_petty_cashes.id',
                                 'lechon_de_cebu_petty_cashes.user_id',
                                 'lechon_de_cebu_petty_cashes.pc_id',
                                 'lechon_de_cebu_petty_cashes.date',
                                 'lechon_de_cebu_petty_cashes.petty_cash_name',
                                 'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                 'lechon_de_cebu_petty_cashes.amount',
                                 'lechon_de_cebu_petty_cashes.created_by',
                                 'lechon_de_cebu_petty_cashes.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->join('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_petty_cashes.pc_id', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNamePettyCash)
                                 ->where('lechon_de_cebu_petty_cashes.deleted_at', NULL)
                                 ->whereDate('lechon_de_cebu_petty_cashes.created_at', '=', date($getDateToday))
                                 ->orderBy('lechon_de_cebu_petty_cashes.id', 'desc')
                                 ->get()->toArray();
 
         //payment voucher
         $moduleNameVoucher = "Payment Voucher";
         $cash = "CASH";
         $getTransactionListCashes = DB::table(
                                 'lechon_de_cebu_payment_vouchers')
                                 ->select( 
                                 'lechon_de_cebu_payment_vouchers.id',
                                 'lechon_de_cebu_payment_vouchers.user_id',
                                 'lechon_de_cebu_payment_vouchers.pv_id',
                                 'lechon_de_cebu_payment_vouchers.date',
                                 'lechon_de_cebu_payment_vouchers.paid_to',
                                 'lechon_de_cebu_payment_vouchers.account_no',
                                 'lechon_de_cebu_payment_vouchers.account_name',
                                 'lechon_de_cebu_payment_vouchers.particulars',
                                 'lechon_de_cebu_payment_vouchers.amount',
                                 'lechon_de_cebu_payment_vouchers.method_of_payment',
                                 'lechon_de_cebu_payment_vouchers.prepared_by',
                                 'lechon_de_cebu_payment_vouchers.approved_by',
                                 'lechon_de_cebu_payment_vouchers.date_apprroved',
                                 'lechon_de_cebu_payment_vouchers.received_by_date',
                                 'lechon_de_cebu_payment_vouchers.created_by',
                                 'lechon_de_cebu_payment_vouchers.invoice_number',
                                 'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                 'lechon_de_cebu_payment_vouchers.issued_date',
                                 'lechon_de_cebu_payment_vouchers.category',
                                 'lechon_de_cebu_payment_vouchers.amount_due',
                                 'lechon_de_cebu_payment_vouchers.delivered_date',
                                 'lechon_de_cebu_payment_vouchers.status',
                                 'lechon_de_cebu_payment_vouchers.cheque_number',
                                 'lechon_de_cebu_payment_vouchers.cheque_amount',
                                 'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                 'lechon_de_cebu_payment_vouchers.sub_category',
                                 'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                 'lechon_de_cebu_payment_vouchers.deleted_at',
                                 'lechon_de_cebu_codes.lechon_de_cebu_code',
                                 'lechon_de_cebu_codes.module_id',
                                 'lechon_de_cebu_codes.module_code',
                                 'lechon_de_cebu_codes.module_name')
                                 ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                 ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                 ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                                 ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                 ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                 ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                                 ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                 ->get()->toArray();
            $check = "CHECK";
            $getTransactionListChecks = DB::table(
                                        'lechon_de_cebu_payment_vouchers')
                                        ->select( 
                                        'lechon_de_cebu_payment_vouchers.id',
                                        'lechon_de_cebu_payment_vouchers.user_id',
                                        'lechon_de_cebu_payment_vouchers.pv_id',
                                        'lechon_de_cebu_payment_vouchers.date',
                                        'lechon_de_cebu_payment_vouchers.paid_to',
                                        'lechon_de_cebu_payment_vouchers.account_no',
                                        'lechon_de_cebu_payment_vouchers.account_name',
                                        'lechon_de_cebu_payment_vouchers.particulars',
                                        'lechon_de_cebu_payment_vouchers.amount',
                                        'lechon_de_cebu_payment_vouchers.method_of_payment',
                                        'lechon_de_cebu_payment_vouchers.prepared_by',
                                        'lechon_de_cebu_payment_vouchers.approved_by',
                                        'lechon_de_cebu_payment_vouchers.date_apprroved',
                                        'lechon_de_cebu_payment_vouchers.received_by_date',
                                        'lechon_de_cebu_payment_vouchers.created_by',
                                        'lechon_de_cebu_payment_vouchers.invoice_number',
                                        'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                        'lechon_de_cebu_payment_vouchers.issued_date',
                                        'lechon_de_cebu_payment_vouchers.category',
                                        'lechon_de_cebu_payment_vouchers.amount_due',
                                        'lechon_de_cebu_payment_vouchers.delivered_date',
                                        'lechon_de_cebu_payment_vouchers.status',
                                        'lechon_de_cebu_payment_vouchers.cheque_number',
                                        'lechon_de_cebu_payment_vouchers.cheque_amount',
                                        'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                        'lechon_de_cebu_payment_vouchers.sub_category',
                                        'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                        'lechon_de_cebu_payment_vouchers.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                        ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                        ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                                        ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                        ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                        ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                        ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                        ->get()->toArray();
       
        $status = "FULLY PAID AND RELEASED"; 
         $totalPaymentVoucherCash = DB::table(
                             'lechon_de_cebu_payment_vouchers')
                             ->select( 
                             'lechon_de_cebu_payment_vouchers.id',
                             'lechon_de_cebu_payment_vouchers.user_id',
                             'lechon_de_cebu_payment_vouchers.pv_id',
                             'lechon_de_cebu_payment_vouchers.date',
                             'lechon_de_cebu_payment_vouchers.paid_to',
                             'lechon_de_cebu_payment_vouchers.account_no',
                             'lechon_de_cebu_payment_vouchers.account_name',
                             'lechon_de_cebu_payment_vouchers.particulars',
                             'lechon_de_cebu_payment_vouchers.amount',
                             'lechon_de_cebu_payment_vouchers.method_of_payment',
                             'lechon_de_cebu_payment_vouchers.prepared_by',
                             'lechon_de_cebu_payment_vouchers.approved_by',
                             'lechon_de_cebu_payment_vouchers.date_apprroved',
                             'lechon_de_cebu_payment_vouchers.received_by_date',
                             'lechon_de_cebu_payment_vouchers.created_by',
                             'lechon_de_cebu_payment_vouchers.invoice_number',
                             'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                             'lechon_de_cebu_payment_vouchers.issued_date',
                             'lechon_de_cebu_payment_vouchers.category',
                             'lechon_de_cebu_payment_vouchers.amount_due',
                             'lechon_de_cebu_payment_vouchers.delivered_date',
                             'lechon_de_cebu_payment_vouchers.status',
                             'lechon_de_cebu_payment_vouchers.cheque_number',
                             'lechon_de_cebu_payment_vouchers.cheque_amount',
                             'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                             'lechon_de_cebu_payment_vouchers.sub_category',
                             'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                             'lechon_de_cebu_payment_vouchers.deleted_at',
                             'lechon_de_cebu_codes.lechon_de_cebu_code',
                             'lechon_de_cebu_codes.module_id',
                             'lechon_de_cebu_codes.module_code',
                             'lechon_de_cebu_codes.module_name')
                             ->join('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                             ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                             ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                             ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                             ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                             ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                             ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                             ->sum('lechon_de_cebu_payment_vouchers.amount_due');

        $totalPaymentVoucherCheck = DB::table(
                                'lechon_de_cebu_payment_vouchers')
                                ->select( 
                                'lechon_de_cebu_payment_vouchers.id',
                                'lechon_de_cebu_payment_vouchers.user_id',
                                'lechon_de_cebu_payment_vouchers.pv_id',
                                'lechon_de_cebu_payment_vouchers.date',
                                'lechon_de_cebu_payment_vouchers.paid_to',
                                'lechon_de_cebu_payment_vouchers.account_no',
                                'lechon_de_cebu_payment_vouchers.account_name',
                                'lechon_de_cebu_payment_vouchers.particulars',
                                'lechon_de_cebu_payment_vouchers.amount',
                                'lechon_de_cebu_payment_vouchers.method_of_payment',
                                'lechon_de_cebu_payment_vouchers.prepared_by',
                                'lechon_de_cebu_payment_vouchers.approved_by',
                                'lechon_de_cebu_payment_vouchers.date_apprroved',
                                'lechon_de_cebu_payment_vouchers.received_by_date',
                                'lechon_de_cebu_payment_vouchers.created_by',
                                'lechon_de_cebu_payment_vouchers.invoice_number',
                                'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                'lechon_de_cebu_payment_vouchers.issued_date',
                                'lechon_de_cebu_payment_vouchers.category',
                                'lechon_de_cebu_payment_vouchers.amount_due',
                                'lechon_de_cebu_payment_vouchers.delivered_date',
                                'lechon_de_cebu_payment_vouchers.status',
                                'lechon_de_cebu_payment_vouchers.cheque_number',
                                'lechon_de_cebu_payment_vouchers.cheque_amount',
                                'lechon_de_cebu_payment_vouchers.sub_category',
                                'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                'lechon_de_cebu_payment_vouchers.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                                ->sum('lechon_de_cebu_payment_vouchers.amount_due');
         
        
        $totalPaidAmountCheck  = DB::table(
                                    'lechon_de_cebu_payment_vouchers')
                                    ->select( 
                                    'lechon_de_cebu_payment_vouchers.id',
                                    'lechon_de_cebu_payment_vouchers.user_id',
                                    'lechon_de_cebu_payment_vouchers.pv_id',
                                    'lechon_de_cebu_payment_vouchers.date',
                                    'lechon_de_cebu_payment_vouchers.paid_to',
                                    'lechon_de_cebu_payment_vouchers.account_no',
                                    'lechon_de_cebu_payment_vouchers.account_name',
                                    'lechon_de_cebu_payment_vouchers.particulars',
                                    'lechon_de_cebu_payment_vouchers.amount',
                                    'lechon_de_cebu_payment_vouchers.method_of_payment',
                                    'lechon_de_cebu_payment_vouchers.prepared_by',
                                    'lechon_de_cebu_payment_vouchers.approved_by',
                                    'lechon_de_cebu_payment_vouchers.date_apprroved',
                                    'lechon_de_cebu_payment_vouchers.received_by_date',
                                    'lechon_de_cebu_payment_vouchers.created_by',
                                    'lechon_de_cebu_payment_vouchers.invoice_number',
                                    'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                    'lechon_de_cebu_payment_vouchers.issued_date',
                                    'lechon_de_cebu_payment_vouchers.category',
                                    'lechon_de_cebu_payment_vouchers.amount_due',
                                    'lechon_de_cebu_payment_vouchers.delivered_date',
                                    'lechon_de_cebu_payment_vouchers.status',
                                    'lechon_de_cebu_payment_vouchers.cheque_number',
                                    'lechon_de_cebu_payment_vouchers.cheque_amount',
                                    'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                    'lechon_de_cebu_payment_vouchers.sub_category',
                                    'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                    'lechon_de_cebu_payment_vouchers.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                    ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                    ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                    ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                    ->where('lechon_de_cebu_payment_vouchers.status', $status)
                                    ->sum('lechon_de_cebu_payment_vouchers.cheque_total_amount');


        $uri0 = "";
        $uri1 = "";
         $pdf = PDF::loadView('printSummary',  compact('uri0', 'uri1', 'getDateToday', 'getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'billingStatements', 
        'pettyCashLists',  'getTransactionListCashes', 'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 'totalPOrder', 'totalBStatement', 
        'totalPaymentVoucherCash','totalPaymentVoucherCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lechon-de-cebu-summary-report.pdf');
    }
   
    public function search(Request $request){
        $getSearchResults =LechonDeCebuCode::where('lechon_de_cebu_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Sales Invoice"){
            $getSearchSalesInvoices = DB::table(
                            'lechon_de_cebu_sales_invoices')
                            ->select(
                                'lechon_de_cebu_sales_invoices.id',
                                'lechon_de_cebu_sales_invoices.user_id',
                                'lechon_de_cebu_sales_invoices.si_id',
                                'lechon_de_cebu_sales_invoices.invoice_number',
                                'lechon_de_cebu_sales_invoices.date',
                                'lechon_de_cebu_sales_invoices.ordered_by',
                                'lechon_de_cebu_sales_invoices.address',
                                'lechon_de_cebu_sales_invoices.qty',
                                'lechon_de_cebu_sales_invoices.total_kls',
                                'lechon_de_cebu_sales_invoices.body',
                                'lechon_de_cebu_sales_invoices.head_and_feet',
                                'lechon_de_cebu_sales_invoices.item_description',
                                'lechon_de_cebu_sales_invoices.unit_price',
                                'lechon_de_cebu_sales_invoices.amount',
                                'lechon_de_cebu_sales_invoices.created_by',
                                'lechon_de_cebu_sales_invoices.created_at',
                                'lechon_de_cebu_sales_invoices.updated_at',
                                'lechon_de_cebu_sales_invoices.deleted_at',                            
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_sales_invoices.id', $getSearchResults[0]->module_id)
                            ->where('lechon_de_cebu_codes.module_name', $getSearchResults[0]->module_name)
                            ->get()->toArray();

           

            $getAllCodes = LechonDeCebuCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;
           
            return view('lechon-de-cebu-search-results', compact('module', 'getAllCodes', 'getSearchSalesInvoices'));

        }else if($getSearchResults[0]->module_name === "Delivery Receipt"){
            $getSearchDeliveryReceipts = DB::table(
                                    'lechon_de_cebu_delivery_receipts')
                                    ->select( 
                                    'lechon_de_cebu_delivery_receipts.id',
                                    'lechon_de_cebu_delivery_receipts.user_id',
                                    'lechon_de_cebu_delivery_receipts.dr_id',
                                    'lechon_de_cebu_delivery_receipts.sold_to',
                                    'lechon_de_cebu_delivery_receipts.delivered_to',
                                    'lechon_de_cebu_delivery_receipts.time',
                                    'lechon_de_cebu_delivery_receipts.date',
                                    'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                    'lechon_de_cebu_delivery_receipts.contact_person',
                                    'lechon_de_cebu_delivery_receipts.mobile_num',
                                    'lechon_de_cebu_delivery_receipts.qty',
                                    'lechon_de_cebu_delivery_receipts.description',
                                    'lechon_de_cebu_delivery_receipts.price',
                                    'lechon_de_cebu_delivery_receipts.total',
                                    'lechon_de_cebu_delivery_receipts.special_instruction',
                                    'lechon_de_cebu_delivery_receipts.consignee_name',
                                    'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                    'lechon_de_cebu_delivery_receipts.prepared_by',
                                    'lechon_de_cebu_delivery_receipts.checked_by',
                                    'lechon_de_cebu_delivery_receipts.received_by',
                                    'lechon_de_cebu_delivery_receipts.duplicate_status',
                                    'lechon_de_cebu_delivery_receipts.created_by',
                                    'lechon_de_cebu_delivery_receipts.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_delivery_receipts.id', $getSearchResults[0]->module_id)
                                    ->where('lechon_de_cebu_codes.module_name', $getSearchResults[0]->module_name)
                                    ->get()->toArray();

        
            $getAllCodes = LechonDeCebuCode::get()->toArray();
            $module = $getSearchResults[0]->module_name;  
            return view('lechon-de-cebu-search-results', compact('module', 'getAllCodes', 'getSearchDeliveryReceipts'));
    
        }else if($getSearchResults[0]->module_name === "Purchase Order"){
            $getSearchPurchaseOrders  = DB::table(
                                    'lechon_de_cebu_purchase_orders')
                                    ->select(
                                        'lechon_de_cebu_purchase_orders.id',
                                        'lechon_de_cebu_purchase_orders.user_id',
                                        'lechon_de_cebu_purchase_orders.po_id',
                                        'lechon_de_cebu_purchase_orders.paid_to',
                                        'lechon_de_cebu_purchase_orders.address',
                                        'lechon_de_cebu_purchase_orders.date',
                                        'lechon_de_cebu_purchase_orders.quantity',
                                        'lechon_de_cebu_purchase_orders.total_kls',
                                        'lechon_de_cebu_purchase_orders.description',
                                        'lechon_de_cebu_purchase_orders.unit_price',
                                        'lechon_de_cebu_purchase_orders.amount',
                                        'lechon_de_cebu_purchase_orders.total_price',
                                        'lechon_de_cebu_purchase_orders.requested_by',
                                        'lechon_de_cebu_purchase_orders.prepared_by',
                                        'lechon_de_cebu_purchase_orders.checked_by',
                                        'lechon_de_cebu_purchase_orders.created_by',
                                        'lechon_de_cebu_purchase_orders.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_purchase_orders.id', $getSearchResults[0]->module_id)
                                    ->where('lechon_de_cebu_codes.module_name', $getSearchResults[0]->module_name)
                                    ->get()->toArray();

            
           
            $getAllCodes = LechonDeCebuCode::get()->toArray();
            $module = $getSearchResults[0]->module_name;  
            return view('lechon-de-cebu-search-results', compact('module', 'getAllCodes', 'getSearchPurchaseOrders'));
                    

        }else if($getSearchResults[0]->module_name === "Statement Of Account"){
            $getSearchSOAS = DB::table(
                            'lechon_de_cebu_statement_of_accounts')
                            ->select(
                                'lechon_de_cebu_statement_of_accounts.id',
                                'lechon_de_cebu_statement_of_accounts.user_id',
                                'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                'lechon_de_cebu_statement_of_accounts.bill_to',
                                'lechon_de_cebu_statement_of_accounts.address',
                                'lechon_de_cebu_statement_of_accounts.date',
                                'lechon_de_cebu_statement_of_accounts.branch',
                                'lechon_de_cebu_statement_of_accounts.period_cover',
                                'lechon_de_cebu_statement_of_accounts.terms',
                                'lechon_de_cebu_statement_of_accounts.transaction_date',
                                'lechon_de_cebu_statement_of_accounts.invoice_number',
                                'lechon_de_cebu_statement_of_accounts.order',
                                'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                'lechon_de_cebu_statement_of_accounts.description',
                                'lechon_de_cebu_statement_of_accounts.amount',
                                'lechon_de_cebu_statement_of_accounts.paid_amount',
                                'lechon_de_cebu_statement_of_accounts.status',
                                'lechon_de_cebu_statement_of_accounts.collection_date',
                                'lechon_de_cebu_statement_of_accounts.check_number',
                                'lechon_de_cebu_statement_of_accounts.check_amount',
                                'lechon_de_cebu_statement_of_accounts.or_number',
                                'lechon_de_cebu_statement_of_accounts.payment_method',
                                'lechon_de_cebu_statement_of_accounts.created_by',
                                'lechon_de_cebu_statement_of_accounts.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_statement_of_accounts.id', $getSearchResults[0]->module_id)
                            ->where('lechon_de_cebu_codes.module_name', $getSearchResults[0]->module_name)
                            ->get()->toArray(); 

          
            $getAllCodes = LechonDeCebuCode::get()->toArray();
            $module = $getSearchResults[0]->module_name;  
            return view('lechon-de-cebu-search-results', compact('module', 'getAllCodes', 'getSearchSOAS'));
                
            
        }else if($getSearchResults[0]->module_name === "Billing Statement"){
            $getSearchBillingStatements = DB::table(
                                'lechon_de_cebu_billing_statements')
                                ->select(
                                    'lechon_de_cebu_billing_statements.id',
                                    'lechon_de_cebu_billing_statements.user_id',
                                    'lechon_de_cebu_billing_statements.billing_statement_id',
                                    'lechon_de_cebu_billing_statements.bill_to',
                                    'lechon_de_cebu_billing_statements.address',
                                    'lechon_de_cebu_billing_statements.date',
                                    'lechon_de_cebu_billing_statements.branch',
                                    'lechon_de_cebu_billing_statements.period_cover',
                                    'lechon_de_cebu_billing_statements.terms',
                                    'lechon_de_cebu_billing_statements.date_of_transaction',
                                    'lechon_de_cebu_billing_statements.invoice_number',
                                    'lechon_de_cebu_billing_statements.order',
                                    'lechon_de_cebu_billing_statements.whole_lechon',
                                    'lechon_de_cebu_billing_statements.description',
                                    'lechon_de_cebu_billing_statements.amount',
                                    'lechon_de_cebu_billing_statements.paid_amount',
                                    'lechon_de_cebu_billing_statements.created_by',
                                    'lechon_de_cebu_billing_statements.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_billing_statements.id', $getSearchResults[0]->module_id)
                                ->where('lechon_de_cebu_codes.module_name', $getSearchResults[0]->module_name)
                                ->get()->toArray();

           
            $getAllCodes = LechonDeCebuCode::get()->toArray();
            $module = $getSearchResults[0]->module_name;  
            return view('lechon-de-cebu-search-results', compact('module', 'getAllCodes', 'getSearchBillingStatements'));
            

        }else if($getSearchResults[0]->module_name === "Petty Cash"){
            $getSearchPettyCashes = DB::table(
                                'lechon_de_cebu_petty_cashes')
                                ->select( 
                                'lechon_de_cebu_petty_cashes.id',
                                'lechon_de_cebu_petty_cashes.user_id',
                                'lechon_de_cebu_petty_cashes.pc_id',
                                'lechon_de_cebu_petty_cashes.date',
                                'lechon_de_cebu_petty_cashes.petty_cash_name',
                                'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                'lechon_de_cebu_petty_cashes.amount',
                                'lechon_de_cebu_petty_cashes.created_by',
                                'lechon_de_cebu_petty_cashes.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_petty_cashes.id', $getSearchResults[0]->module_id)
                                ->where('lechon_de_cebu_codes.module_name', $getSearchResults[0]->module_name)
                                ->get()->toArray();

           
            $getAllCodes = LechonDeCebuCode::get()->toArray();
            $module = $getSearchResults[0]->module_name;  
            return view('lechon-de-cebu-search-results', compact('module', 'getAllCodes', 'getSearchPettyCashes'));
           
        }else if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                            'lechon_de_cebu_payment_vouchers')
                            ->select( 
                            'lechon_de_cebu_payment_vouchers.id',
                            'lechon_de_cebu_payment_vouchers.user_id',
                            'lechon_de_cebu_payment_vouchers.pv_id',
                            'lechon_de_cebu_payment_vouchers.date',
                            'lechon_de_cebu_payment_vouchers.paid_to',
                            'lechon_de_cebu_payment_vouchers.account_no',
                            'lechon_de_cebu_payment_vouchers.account_name',
                            'lechon_de_cebu_payment_vouchers.particulars',
                            'lechon_de_cebu_payment_vouchers.amount',
                            'lechon_de_cebu_payment_vouchers.method_of_payment',
                            'lechon_de_cebu_payment_vouchers.prepared_by',
                            'lechon_de_cebu_payment_vouchers.approved_by',
                            'lechon_de_cebu_payment_vouchers.date_apprroved',
                            'lechon_de_cebu_payment_vouchers.received_by_date',
                            'lechon_de_cebu_payment_vouchers.created_by',
                            'lechon_de_cebu_payment_vouchers.invoice_number',
                            'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                            'lechon_de_cebu_payment_vouchers.issued_date',
                            'lechon_de_cebu_payment_vouchers.category',
                            'lechon_de_cebu_payment_vouchers.amount_due',
                            'lechon_de_cebu_payment_vouchers.delivered_date',
                            'lechon_de_cebu_payment_vouchers.status',
                            'lechon_de_cebu_payment_vouchers.cheque_number',
                            'lechon_de_cebu_payment_vouchers.cheque_amount',
                            'lechon_de_cebu_payment_vouchers.sub_category',
                            'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                            'lechon_de_cebu_payment_vouchers.deleted_at',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_payment_vouchers.id', $getSearchResults[0]->module_id)
                            ->where('lechon_de_cebu_codes.module_name', $getSearchResults[0]->module_name)
                            ->get()->toArray();

        
            $getAllCodes = LechonDeCebuCode::get()->toArray();
            $module = $getSearchResults[0]->module_name;  
            return view('lechon-de-cebu-search-results', compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));

        }

    }

    public function searchNumberCode(){
        $getAllCodes = LechonDeCebuCode::get()->toArray();

        return view('lechon-de-cebu-search-number-code', compact('getAllCodes'));
    }

    public function summaryReportPerDay(){
        //sales invoice
        $getDateToday = date("Y-m-d");
        
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                        'lechon_de_cebu_sales_invoices')
                        ->select(
                            'lechon_de_cebu_sales_invoices.id',
                            'lechon_de_cebu_sales_invoices.user_id',
                            'lechon_de_cebu_sales_invoices.si_id',
                            'lechon_de_cebu_sales_invoices.invoice_number',
                            'lechon_de_cebu_sales_invoices.date',
                            'lechon_de_cebu_sales_invoices.ordered_by',
                            'lechon_de_cebu_sales_invoices.address',
                            'lechon_de_cebu_sales_invoices.qty',
                            'lechon_de_cebu_sales_invoices.total_kls',
                            'lechon_de_cebu_sales_invoices.body',
                            'lechon_de_cebu_sales_invoices.head_and_feet',
                            'lechon_de_cebu_sales_invoices.item_description',
                            'lechon_de_cebu_sales_invoices.unit_price',
                            'lechon_de_cebu_sales_invoices.amount',
                            'lechon_de_cebu_sales_invoices.total_amount',
                            'lechon_de_cebu_sales_invoices.created_by',
                            'lechon_de_cebu_sales_invoices.created_at',
                            'lechon_de_cebu_sales_invoices.updated_at',  
                            'lechon_de_cebu_sales_invoices.deleted_at',                            
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                        ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($getDateToday))
                        ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                        ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                        ->get()->toArray();

            $totalSalesInvoice = DB::table(
                            'lechon_de_cebu_sales_invoices')
                            ->select(
                                'lechon_de_cebu_sales_invoices.id',
                                'lechon_de_cebu_sales_invoices.user_id',
                                'lechon_de_cebu_sales_invoices.si_id',
                                'lechon_de_cebu_sales_invoices.invoice_number',
                                'lechon_de_cebu_sales_invoices.date',
                                'lechon_de_cebu_sales_invoices.ordered_by',
                                'lechon_de_cebu_sales_invoices.address',
                                'lechon_de_cebu_sales_invoices.qty',
                                'lechon_de_cebu_sales_invoices.total_kls',
                                'lechon_de_cebu_sales_invoices.body',
                                'lechon_de_cebu_sales_invoices.head_and_feet',
                                'lechon_de_cebu_sales_invoices.item_description',
                                'lechon_de_cebu_sales_invoices.unit_price',
                                'lechon_de_cebu_sales_invoices.amount',
                                'lechon_de_cebu_sales_invoices.total_amount',
                                'lechon_de_cebu_sales_invoices.created_by',
                                'lechon_de_cebu_sales_invoices.created_at',
                                'lechon_de_cebu_sales_invoices.updated_at',   
                                'lechon_de_cebu_sales_invoices.deleted_at',                            
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->whereDate('lechon_de_cebu_sales_invoices.created_at', '=', date($getDateToday))
                            ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                            ->sum('lechon_de_cebu_sales_invoices.total_amount');


        //Delivery Receipt
        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_delivery_receipts.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($getDateToday))
                                ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                ->get()->toArray();

        //total for delivery receipt
        $totalDeliveryReceipt = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_delivery_receipts.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                ->whereDate('lechon_de_cebu_delivery_receipts.created_at', '=', date($getDateToday))
                                ->sum('lechon_de_cebu_delivery_receipts.total');
        

        //purchase order
        $moduleNamePurchaseOrder = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lechon_de_cebu_purchase_orders')
                        ->select(
                            'lechon_de_cebu_purchase_orders.id',
                            'lechon_de_cebu_purchase_orders.user_id',
                            'lechon_de_cebu_purchase_orders.po_id',
                            'lechon_de_cebu_purchase_orders.paid_to',
                            'lechon_de_cebu_purchase_orders.address',
                            'lechon_de_cebu_purchase_orders.date',
                            'lechon_de_cebu_purchase_orders.quantity',
                            'lechon_de_cebu_purchase_orders.total_kls',
                            'lechon_de_cebu_purchase_orders.description',
                            'lechon_de_cebu_purchase_orders.unit_price',
                            'lechon_de_cebu_purchase_orders.amount',
                            'lechon_de_cebu_purchase_orders.total_price',
                            'lechon_de_cebu_purchase_orders.requested_by',
                            'lechon_de_cebu_purchase_orders.prepared_by',
                            'lechon_de_cebu_purchase_orders.checked_by',
                            'lechon_de_cebu_purchase_orders.created_by',
                            'lechon_de_cebu_purchase_orders.deleted_at',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                        ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                        ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($getDateToday))
                        ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                        ->get()->toArray();

        $totalPOrder = DB::table(
                            'lechon_de_cebu_purchase_orders')
                            ->select(
                                'lechon_de_cebu_purchase_orders.id',
                                'lechon_de_cebu_purchase_orders.user_id',
                                'lechon_de_cebu_purchase_orders.po_id',
                                'lechon_de_cebu_purchase_orders.paid_to',
                                'lechon_de_cebu_purchase_orders.address',
                                'lechon_de_cebu_purchase_orders.date',
                                'lechon_de_cebu_purchase_orders.quantity',
                                'lechon_de_cebu_purchase_orders.total_kls',
                                'lechon_de_cebu_purchase_orders.description',
                                'lechon_de_cebu_purchase_orders.unit_price',
                                'lechon_de_cebu_purchase_orders.amount',
                                'lechon_de_cebu_purchase_orders.total_price',
                                'lechon_de_cebu_purchase_orders.requested_by',
                                'lechon_de_cebu_purchase_orders.prepared_by',
                                'lechon_de_cebu_purchase_orders.checked_by',
                                'lechon_de_cebu_purchase_orders.created_by',
                                'lechon_de_cebu_purchase_orders.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleNamePurchaseOrder)
                            ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                            ->whereDate('lechon_de_cebu_purchase_orders.created_at', '=', date($getDateToday))
                            ->sum('lechon_de_cebu_purchase_orders.total_price');

        //statement of account
        $moduleNameSOA = "Statement Of Account";
        $statementOfAccounts = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.bs_no',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.bill_to', '!=', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameSOA)
                                ->whereDate('lechon_de_cebu_statement_of_accounts.created_at', '=', date($getDateToday))
                                ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                ->get()->toArray();
           
        
        //billing statement
        $moduleNameBillingStatement = "Billing Statement";
        $billingStatements = DB::table(
                                'lechon_de_cebu_billing_statements')
                                ->select(
                                    'lechon_de_cebu_billing_statements.id',
                                    'lechon_de_cebu_billing_statements.user_id',
                                    'lechon_de_cebu_billing_statements.billing_statement_id',
                                    'lechon_de_cebu_billing_statements.bill_to',
                                    'lechon_de_cebu_billing_statements.address',
                                    'lechon_de_cebu_billing_statements.date',
                                    'lechon_de_cebu_billing_statements.branch',
                                    'lechon_de_cebu_billing_statements.period_cover',
                                    'lechon_de_cebu_billing_statements.terms',
                                    'lechon_de_cebu_billing_statements.date_of_transaction',
                                    'lechon_de_cebu_billing_statements.invoice_number',
                                    'lechon_de_cebu_billing_statements.order',
                                    'lechon_de_cebu_billing_statements.whole_lechon',
                                    'lechon_de_cebu_billing_statements.description',
                                    'lechon_de_cebu_billing_statements.amount',
                                    'lechon_de_cebu_billing_statements.total_amount',
                                    'lechon_de_cebu_billing_statements.paid_amount',
                                    'lechon_de_cebu_billing_statements.created_by',
                                    'lechon_de_cebu_billing_statements.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($getDateToday))
                                ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                ->get()->toArray();
        
                $totalBStatement = DB::table(
                                    'lechon_de_cebu_billing_statements')
                                    ->select(
                                        'lechon_de_cebu_billing_statements.id',
                                        'lechon_de_cebu_billing_statements.user_id',
                                        'lechon_de_cebu_billing_statements.billing_statement_id',
                                        'lechon_de_cebu_billing_statements.bill_to',
                                        'lechon_de_cebu_billing_statements.address',
                                        'lechon_de_cebu_billing_statements.date',
                                        'lechon_de_cebu_billing_statements.branch',
                                        'lechon_de_cebu_billing_statements.period_cover',
                                        'lechon_de_cebu_billing_statements.terms',
                                        'lechon_de_cebu_billing_statements.date_of_transaction',
                                        'lechon_de_cebu_billing_statements.invoice_number',
                                        'lechon_de_cebu_billing_statements.order',
                                        'lechon_de_cebu_billing_statements.whole_lechon',
                                        'lechon_de_cebu_billing_statements.description',
                                        'lechon_de_cebu_billing_statements.amount',
                                        'lechon_de_cebu_billing_statements.total_amount',
                                        'lechon_de_cebu_billing_statements.paid_amount',
                                        'lechon_de_cebu_billing_statements.created_by',
                                        'lechon_de_cebu_billing_statements.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameBillingStatement)
                                    ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                    ->whereDate('lechon_de_cebu_billing_statements.created_at', '=', date($getDateToday))
                                    ->sum('lechon_de_cebu_billing_statements.total_amount');
        
            
        //petty cash
        $moduleNamePettyCash = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lechon_de_cebu_petty_cashes')
                                ->select( 
                                'lechon_de_cebu_petty_cashes.id',
                                'lechon_de_cebu_petty_cashes.user_id',
                                'lechon_de_cebu_petty_cashes.pc_id',
                                'lechon_de_cebu_petty_cashes.date',
                                'lechon_de_cebu_petty_cashes.petty_cash_name',
                                'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                'lechon_de_cebu_petty_cashes.amount',
                                'lechon_de_cebu_petty_cashes.created_by',
                                'lechon_de_cebu_petty_cashes.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_petty_cashes.pc_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNamePettyCash)
                                ->where('lechon_de_cebu_petty_cashes.deleted_at', NULL)
                                ->whereDate('lechon_de_cebu_petty_cashes.created_at', '=', date($getDateToday))
                                ->orderBy('lechon_de_cebu_petty_cashes.id', 'desc')
                                ->get()->toArray();

        //payment voucher
        $moduleNameVoucher = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'lechon_de_cebu_payment_vouchers')
                                ->select( 
                                'lechon_de_cebu_payment_vouchers.id',
                                'lechon_de_cebu_payment_vouchers.user_id',
                                'lechon_de_cebu_payment_vouchers.pv_id',
                                'lechon_de_cebu_payment_vouchers.date',
                                'lechon_de_cebu_payment_vouchers.paid_to',
                                'lechon_de_cebu_payment_vouchers.account_no',
                                'lechon_de_cebu_payment_vouchers.account_name',
                                'lechon_de_cebu_payment_vouchers.particulars',
                                'lechon_de_cebu_payment_vouchers.amount',
                                'lechon_de_cebu_payment_vouchers.method_of_payment',
                                'lechon_de_cebu_payment_vouchers.prepared_by',
                                'lechon_de_cebu_payment_vouchers.approved_by',
                                'lechon_de_cebu_payment_vouchers.date_apprroved',
                                'lechon_de_cebu_payment_vouchers.received_by_date',
                                'lechon_de_cebu_payment_vouchers.created_by',
                                'lechon_de_cebu_payment_vouchers.invoice_number',
                                'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                'lechon_de_cebu_payment_vouchers.issued_date',
                                'lechon_de_cebu_payment_vouchers.category',
                                'lechon_de_cebu_payment_vouchers.amount_due',
                                'lechon_de_cebu_payment_vouchers.delivered_date',
                                'lechon_de_cebu_payment_vouchers.status',
                                'lechon_de_cebu_payment_vouchers.cheque_number',
                                'lechon_de_cebu_payment_vouchers.cheque_amount',
                                'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                'lechon_de_cebu_payment_vouchers.sub_category',
                                'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                'lechon_de_cebu_payment_vouchers.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                ->get()->toArray();
      
            $cash = "CASH";
            $getTransactionListCashes = DB::table(
                                    'lechon_de_cebu_payment_vouchers')
                                    ->select( 
                                    'lechon_de_cebu_payment_vouchers.id',
                                    'lechon_de_cebu_payment_vouchers.user_id',
                                    'lechon_de_cebu_payment_vouchers.pv_id',
                                    'lechon_de_cebu_payment_vouchers.date',
                                    'lechon_de_cebu_payment_vouchers.paid_to',
                                    'lechon_de_cebu_payment_vouchers.account_no',
                                    'lechon_de_cebu_payment_vouchers.account_name',
                                    'lechon_de_cebu_payment_vouchers.particulars',
                                    'lechon_de_cebu_payment_vouchers.amount',
                                    'lechon_de_cebu_payment_vouchers.method_of_payment',
                                    'lechon_de_cebu_payment_vouchers.prepared_by',
                                    'lechon_de_cebu_payment_vouchers.approved_by',
                                    'lechon_de_cebu_payment_vouchers.date_apprroved',
                                    'lechon_de_cebu_payment_vouchers.received_by_date',
                                    'lechon_de_cebu_payment_vouchers.created_by',
                                    'lechon_de_cebu_payment_vouchers.invoice_number',
                                    'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                    'lechon_de_cebu_payment_vouchers.issued_date',
                                    'lechon_de_cebu_payment_vouchers.category',
                                    'lechon_de_cebu_payment_vouchers.amount_due',
                                    'lechon_de_cebu_payment_vouchers.delivered_date',
                                    'lechon_de_cebu_payment_vouchers.status',
                                    'lechon_de_cebu_payment_vouchers.cheque_number',
                                    'lechon_de_cebu_payment_vouchers.cheque_amount',
                                    'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                    'lechon_de_cebu_payment_vouchers.sub_category',
                                    'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                    'lechon_de_cebu_payment_vouchers.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                    ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                    ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                                    ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                    ->get()->toArray();
                                    
            $status = "FULLY PAID AND RELEASED";
            $totalAmountCashes = DB::table(
                                        'lechon_de_cebu_payment_vouchers')
                                        ->select( 
                                        'lechon_de_cebu_payment_vouchers.id',
                                        'lechon_de_cebu_payment_vouchers.user_id',
                                        'lechon_de_cebu_payment_vouchers.pv_id',
                                        'lechon_de_cebu_payment_vouchers.date',
                                        'lechon_de_cebu_payment_vouchers.paid_to',
                                        'lechon_de_cebu_payment_vouchers.account_no',
                                        'lechon_de_cebu_payment_vouchers.account_name',
                                        'lechon_de_cebu_payment_vouchers.particulars',
                                        'lechon_de_cebu_payment_vouchers.amount',
                                        'lechon_de_cebu_payment_vouchers.method_of_payment',
                                        'lechon_de_cebu_payment_vouchers.prepared_by',
                                        'lechon_de_cebu_payment_vouchers.approved_by',
                                        'lechon_de_cebu_payment_vouchers.date_apprroved',
                                        'lechon_de_cebu_payment_vouchers.received_by_date',
                                        'lechon_de_cebu_payment_vouchers.created_by',
                                        'lechon_de_cebu_payment_vouchers.invoice_number',
                                        'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                        'lechon_de_cebu_payment_vouchers.issued_date',
                                        'lechon_de_cebu_payment_vouchers.category',
                                        'lechon_de_cebu_payment_vouchers.amount_due',
                                        'lechon_de_cebu_payment_vouchers.delivered_date',
                                        'lechon_de_cebu_payment_vouchers.status',
                                        'lechon_de_cebu_payment_vouchers.cheque_number',
                                        'lechon_de_cebu_payment_vouchers.cheque_amount',
                                        'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                        'lechon_de_cebu_payment_vouchers.sub_category',
                                        'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                        'lechon_de_cebu_payment_vouchers.deleted_at',
                                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                                        'lechon_de_cebu_codes.module_id',
                                        'lechon_de_cebu_codes.module_code',
                                        'lechon_de_cebu_codes.module_name')
                                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                        ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                        ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                                        ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                        ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                        ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $cash)
                                        ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                                        ->sum('lechon_de_cebu_payment_vouchers.amount_due');


            $check = "CHECK";
            $getTransactionListChecks = DB::table(
                                            'lechon_de_cebu_payment_vouchers')
                                            ->select( 
                                            'lechon_de_cebu_payment_vouchers.id',
                                            'lechon_de_cebu_payment_vouchers.user_id',
                                            'lechon_de_cebu_payment_vouchers.pv_id',
                                            'lechon_de_cebu_payment_vouchers.date',
                                            'lechon_de_cebu_payment_vouchers.paid_to',
                                            'lechon_de_cebu_payment_vouchers.account_no',
                                            'lechon_de_cebu_payment_vouchers.account_name',
                                            'lechon_de_cebu_payment_vouchers.particulars',
                                            'lechon_de_cebu_payment_vouchers.amount',
                                            'lechon_de_cebu_payment_vouchers.method_of_payment',
                                            'lechon_de_cebu_payment_vouchers.prepared_by',
                                            'lechon_de_cebu_payment_vouchers.approved_by',
                                            'lechon_de_cebu_payment_vouchers.date_apprroved',
                                            'lechon_de_cebu_payment_vouchers.received_by_date',
                                            'lechon_de_cebu_payment_vouchers.created_by',
                                            'lechon_de_cebu_payment_vouchers.invoice_number',
                                            'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                            'lechon_de_cebu_payment_vouchers.issued_date',
                                            'lechon_de_cebu_payment_vouchers.category',
                                            'lechon_de_cebu_payment_vouchers.amount_due',
                                            'lechon_de_cebu_payment_vouchers.delivered_date',
                                            'lechon_de_cebu_payment_vouchers.status',
                                            'lechon_de_cebu_payment_vouchers.cheque_number',
                                            'lechon_de_cebu_payment_vouchers.cheque_amount',
                                            'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                            'lechon_de_cebu_payment_vouchers.sub_category',
                                            'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                            'lechon_de_cebu_payment_vouchers.deleted_at',
                                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                                            'lechon_de_cebu_codes.module_id',
                                            'lechon_de_cebu_codes.module_code',
                                            'lechon_de_cebu_codes.module_name')
                                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                            ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                            ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                                            ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                            ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                            ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                            ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                                            ->get()->toArray();
            
                $totalAmountCheck = DB::table(
                                    'lechon_de_cebu_payment_vouchers')
                                    ->select( 
                                    'lechon_de_cebu_payment_vouchers.id',
                                    'lechon_de_cebu_payment_vouchers.user_id',
                                    'lechon_de_cebu_payment_vouchers.pv_id',
                                    'lechon_de_cebu_payment_vouchers.date',
                                    'lechon_de_cebu_payment_vouchers.paid_to',
                                    'lechon_de_cebu_payment_vouchers.account_no',
                                    'lechon_de_cebu_payment_vouchers.account_name',
                                    'lechon_de_cebu_payment_vouchers.particulars',
                                    'lechon_de_cebu_payment_vouchers.amount',
                                    'lechon_de_cebu_payment_vouchers.method_of_payment',
                                    'lechon_de_cebu_payment_vouchers.prepared_by',
                                    'lechon_de_cebu_payment_vouchers.approved_by',
                                    'lechon_de_cebu_payment_vouchers.date_apprroved',
                                    'lechon_de_cebu_payment_vouchers.received_by_date',
                                    'lechon_de_cebu_payment_vouchers.created_by',
                                    'lechon_de_cebu_payment_vouchers.invoice_number',
                                    'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                    'lechon_de_cebu_payment_vouchers.issued_date',
                                    'lechon_de_cebu_payment_vouchers.category',
                                    'lechon_de_cebu_payment_vouchers.amount_due',
                                    'lechon_de_cebu_payment_vouchers.delivered_date',
                                    'lechon_de_cebu_payment_vouchers.status',
                                    'lechon_de_cebu_payment_vouchers.cheque_number',
                                    'lechon_de_cebu_payment_vouchers.cheque_amount',
                                    'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                                    'lechon_de_cebu_payment_vouchers.sub_category',
                                    'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                    'lechon_de_cebu_payment_vouchers.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                    ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                    ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                    ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                    ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                                    ->where('lechon_de_cebu_payment_vouchers.method_of_payment', $check)
                                    ->where('lechon_de_cebu_payment_vouchers.status', '!=', $status)
                                    ->sum('lechon_de_cebu_payment_vouchers.amount_due');


        //
        $totalPaymentVoucher = DB::table(
                            'lechon_de_cebu_payment_vouchers')
                            ->select( 
                            'lechon_de_cebu_payment_vouchers.id',
                            'lechon_de_cebu_payment_vouchers.user_id',
                            'lechon_de_cebu_payment_vouchers.pv_id',
                            'lechon_de_cebu_payment_vouchers.date',
                            'lechon_de_cebu_payment_vouchers.paid_to',
                            'lechon_de_cebu_payment_vouchers.account_no',
                            'lechon_de_cebu_payment_vouchers.account_name',
                            'lechon_de_cebu_payment_vouchers.particulars',
                            'lechon_de_cebu_payment_vouchers.amount',
                            'lechon_de_cebu_payment_vouchers.method_of_payment',
                            'lechon_de_cebu_payment_vouchers.prepared_by',
                            'lechon_de_cebu_payment_vouchers.approved_by',
                            'lechon_de_cebu_payment_vouchers.date_apprroved',
                            'lechon_de_cebu_payment_vouchers.received_by_date',
                            'lechon_de_cebu_payment_vouchers.created_by',
                            'lechon_de_cebu_payment_vouchers.invoice_number',
                            'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                            'lechon_de_cebu_payment_vouchers.issued_date',
                            'lechon_de_cebu_payment_vouchers.category',
                            'lechon_de_cebu_payment_vouchers.amount_due',
                            'lechon_de_cebu_payment_vouchers.delivered_date',
                            'lechon_de_cebu_payment_vouchers.status',
                            'lechon_de_cebu_payment_vouchers.cheque_number',
                            'lechon_de_cebu_payment_vouchers.cheque_amount',
                            'lechon_de_cebu_payment_vouchers.cheque_total_amount',
                            'lechon_de_cebu_payment_vouchers.sub_category',
                            'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                            'lechon_de_cebu_payment_vouchers.deleted_at',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                            ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                            ->whereDate('lechon_de_cebu_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('lechon_de_cebu_codes.module_name', $moduleNameVoucher)
                            ->sum('lechon_de_cebu_payment_vouchers.amount_due');
        

        return view('lechon-de-cebu-summary-report', compact('getAllSalesInvoices', 
        'getAllDeliveryReceipts', 'purchaseOrders', 'statementOfAccounts', 'billingStatements', 
        'pettyCashLists',  'getTransactionLists', 'getTransactionListCashes', 
        'getTransactionListChecks', 'totalSalesInvoice', 'totalDeliveryReceipt', 
        'totalPOrder', 'totalBStatement', 'totalPaymentVoucher', 'totalAmountCashes', 'totalAmountCheck'));
    }

    public function updatePettyCash(Request $request, $id){
        $updatePettyCash = LechonDeCebuPettyCash::find($id);
        $updatePettyCash->date = $request->get('date');
        $updatePettyCash->petty_cash_name = $request->get('pettyCashName');
        $updatePettyCash->petty_cash_summary = $request->geT('pettyCashSummary');
        $updatePettyCash->save();

        Session::flash('editSuccess', 'Successfully updated.');

        return redirect()->route('editPettyCashLechonDeCebu', ['id'=>$id]);

    }

    public function viewBills($id){
        //
        $viewBill = LechonDeCebuUtility::find($id);

        //view particulars
    
        $viewParticulars = LechonDeCebuPaymentVoucher::where('sub_category_account_id', $id)->get()->toArray();
        return view('lolo-pinoy-lechon-de-cebu-view-utility', compact('viewBill', 'viewParticulars'));
    }

    //ajax call save
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
            'lechon_de_cebu_utilities')
            ->where('account_id', $request->accountIdInternet)
            ->get()->first();
        
        if($target ==  NULL){
             $addInternet = new LechonDeCebuUtility([
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


           //check if veco account  already exists
        $target = DB::table(
            'lechon_de_cebu_utilities')
            ->where('account_id', $request->accountId)
            ->get()->first();

        if($target ==  NULL){
            $addBills = new LechonDeCebuUtility([
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

        $flagInternet = "Internet";

        $vecoDocuments = LechonDeCebuUtility::where('flag', $flag)->get()->toArray();
        $internetDocuments = LechonDeCebuUtility::where('flag', $flagInternet)->get()->toArray();
        return view('lechon-de-cebu-utilities', compact('vecoDocuments', 'internetDocuments'));
    }

    public function printPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                        'lechon_de_cebu_petty_cashes')
                        ->select( 
                        'lechon_de_cebu_petty_cashes.id',
                        'lechon_de_cebu_petty_cashes.user_id',
                        'lechon_de_cebu_petty_cashes.pc_id',
                        'lechon_de_cebu_petty_cashes.date',
                        'lechon_de_cebu_petty_cashes.petty_cash_name',
                        'lechon_de_cebu_petty_cashes.petty_cash_summary',
                        'lechon_de_cebu_petty_cashes.amount',
                        'lechon_de_cebu_petty_cashes.created_by',
                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                        'lechon_de_cebu_codes.module_id',
                        'lechon_de_cebu_codes.module_code',
                        'lechon_de_cebu_codes.module_name')
                        ->join('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_petty_cashes.id', $id)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->get();
       
        $getPettyCashSummaries = LechonDeCebuPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = LechonDeCebuPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = LechonDeCebuPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashLechonDeCebu', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
        return $pdf->download('lechon-de-cebu-petty-cash.pdf');
    }

    public function viewPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                                'lechon_de_cebu_petty_cashes')
                                ->select( 
                                'lechon_de_cebu_petty_cashes.id',
                                'lechon_de_cebu_petty_cashes.user_id',
                                'lechon_de_cebu_petty_cashes.pc_id',
                                'lechon_de_cebu_petty_cashes.date',
                                'lechon_de_cebu_petty_cashes.petty_cash_name',
                                'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                'lechon_de_cebu_petty_cashes.amount',
                                'lechon_de_cebu_petty_cashes.created_by',
                                'lechon_de_cebu_petty_cashes.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_petty_cashes.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get();


        $getPettyCashSummaries = LechonDeCebuPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $moduleNameP = "Petty Cash";
        $totalPettyCash = DB::table(
                                'lechon_de_cebu_petty_cashes')
                                ->select( 
                                'lechon_de_cebu_petty_cashes.id',
                                'lechon_de_cebu_petty_cashes.user_id',
                                'lechon_de_cebu_petty_cashes.pc_id',
                                'lechon_de_cebu_petty_cashes.date',
                                'lechon_de_cebu_petty_cashes.petty_cash_name',
                                'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                'lechon_de_cebu_petty_cashes.amount',
                                'lechon_de_cebu_petty_cashes.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_petty_cashes.id', $id)
                                ->where('lechon_de_cebu_petty_cashes.pc_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameP)
                                ->sum('lechon_de_cebu_petty_cashes.amount');

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
        $moduleName = "Petty Cash";
        $pettyCash = DB::table(
                                'lechon_de_cebu_petty_cashes')
                                ->select( 
                                'lechon_de_cebu_petty_cashes.id',
                                'lechon_de_cebu_petty_cashes.user_id',
                                'lechon_de_cebu_petty_cashes.pc_id',
                                'lechon_de_cebu_petty_cashes.date',
                                'lechon_de_cebu_petty_cashes.petty_cash_name',
                                'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                'lechon_de_cebu_petty_cashes.amount',
                                'lechon_de_cebu_petty_cashes.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_petty_cashes.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get()->toArray();

        $pettyCashSummaries = LechonDeCebuPettyCash::where('pc_id', $id)->get()->toArray();
        return view('edit-lechon-de-cebu-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }

    public function addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table lechon_de_cebu_code
        $dataCashNo = DB::select('SELECT id, lechon_de_cebu_code FROM lechon_de_cebu_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
        if(isset($dataCashNo[0]->lechon_de_cebu_code) != 0){
            //if code is not 0
            $newProd = $dataCashNo[0]->lechon_de_cebu_code +1;
            $uPetty = sprintf("%06d",$newProd);   

        }else{
            //if code is 0 
            $newProd = 1;
            $uPetty = sprintf("%06d",$newProd);
        } 

          
        $addPettyCash = new LechonDeCebuPettyCash([
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

        //save to lechon_de_cebu_codes table
        $lechonDeCebu = new LechonDeCebuCode([
            'user_id'=>$user->id,
            'lechon_de_cebu_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $lechonDeCebu->save();

        return response()->json($insertId);
    }

    public function pettyCashList(){
       $moduleName = "Petty Cash";
       $pettyCashLists = DB::table(
                               'lechon_de_cebu_petty_cashes')
                               ->select( 
                               'lechon_de_cebu_petty_cashes.id',
                               'lechon_de_cebu_petty_cashes.user_id',
                               'lechon_de_cebu_petty_cashes.pc_id',
                               'lechon_de_cebu_petty_cashes.date',
                               'lechon_de_cebu_petty_cashes.petty_cash_name',
                               'lechon_de_cebu_petty_cashes.petty_cash_summary',
                               'lechon_de_cebu_petty_cashes.amount',
                               'lechon_de_cebu_petty_cashes.created_by',
                               'lechon_de_cebu_petty_cashes.deleted_at',
                               'lechon_de_cebu_codes.lechon_de_cebu_code',
                               'lechon_de_cebu_codes.module_id',
                               'lechon_de_cebu_codes.module_code',
                               'lechon_de_cebu_codes.module_name')
                               ->join('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                               ->where('lechon_de_cebu_petty_cashes.pc_id', NULL)
                               ->where('lechon_de_cebu_codes.module_name', $moduleName)
                               ->orderBy('lechon_de_cebu_petty_cashes.id', 'desc')
                               ->where('lechon_de_cebu_petty_cashes.deleted_at', NULL)
                               ->get()->toArray();
     

        return view('lechon-de-cebu-petty-cash-list', compact('pettyCashLists'));
    }

    public function inventoryStockUpdate(Request $request){
        $updateInventoryStock = CommissaryRawMaterial::find($request->id);
        $qty = $request->qty;

        $updateInventoryStock->date = $request->date;
        $updateInventoryStock->qty = $qty;
        $updateInventoryStock->unit = $request->unit;
        $updateInventoryStock->status = $request->status;
        $updateInventoryStock->requesting_branch = $request->requestingBranch;
        $updateInventoryStock->cheque_no_issued = $request->chequeNoIssued;
        $updateInventoryStock->remarks = $request->remarks;

        $updateInventoryStock->save();

        $updateRawMaterial = CommissaryRawMaterial::find($request->mainId);
        $unitPrice = $updateRawMaterial->unit_price; 
      
        $add  = $qty + $updateRawMaterial->in; 

        $compute = $unitPrice * $add; 

        $updateRawMaterial->in = $add;
        $updateRawMaterial->amount = $compute;
        $updateRawMaterial->save();

        return response()->json('Success: successfully updated.');
    }

    //
    public function viewInventoryOfStocks($id){
      
        //
        $viewStockDetail = CommissaryRawMaterial::find($id);

        //transaction table
        $getViewStockDetails = CommissaryRawMaterial::where('rm_id', $id)->get()->toArray();

      

        return view('view-lechon-de-cebu-inventory-stock', compact('viewStockDetail', 'getViewStockDetails'));
    }

    //
    public function printSOA($id){
        $moduleName = "Statement Of Account";
         $soa =  DB::table(
                            'lechon_de_cebu_statement_of_accounts')
                            ->select(
                                'lechon_de_cebu_statement_of_accounts.id',
                                'lechon_de_cebu_statement_of_accounts.user_id',
                                'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                'lechon_de_cebu_statement_of_accounts.bill_to',
                                'lechon_de_cebu_statement_of_accounts.address',
                                'lechon_de_cebu_statement_of_accounts.date',
                                'lechon_de_cebu_statement_of_accounts.branch',
                                'lechon_de_cebu_statement_of_accounts.period_cover',
                                'lechon_de_cebu_statement_of_accounts.terms',
                                'lechon_de_cebu_statement_of_accounts.transaction_date',
                                'lechon_de_cebu_statement_of_accounts.invoice_number',
                                'lechon_de_cebu_statement_of_accounts.order',
                                'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                'lechon_de_cebu_statement_of_accounts.description',
                                'lechon_de_cebu_statement_of_accounts.amount',
                                'lechon_de_cebu_statement_of_accounts.total_amount',
                                'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                'lechon_de_cebu_statement_of_accounts.paid_amount',
                                'lechon_de_cebu_statement_of_accounts.payment_method',
                                'lechon_de_cebu_statement_of_accounts.collection_date',
                                'lechon_de_cebu_statement_of_accounts.check_number',
                                'lechon_de_cebu_statement_of_accounts.check_amount',
                                'lechon_de_cebu_statement_of_accounts.or_number',
                                'lechon_de_cebu_statement_of_accounts.status',
                                'lechon_de_cebu_statement_of_accounts.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_statement_of_accounts.id', $id)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->get();

        $statementAccounts = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();


         $countTotalAmount =  DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.payment_method',
                                    'lechon_de_cebu_statement_of_accounts.collection_date',
                                    'lechon_de_cebu_statement_of_accounts.check_number',
                                    'lechon_de_cebu_statement_of_accounts.check_amount',
                                    'lechon_de_cebu_statement_of_accounts.or_number',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->sum('lechon_de_cebu_statement_of_accounts.amount');
                                
        $countAmount = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

          //
        $countAmount = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');


        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printSOA', compact('soa', 'user', 'statementAccounts', 'sum'));

        return $pdf->download('lechon-de-cebu-statement-of-account.pdf');
    }

    //
    public function printPayables($id){
      
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'lechon_de_cebu_payment_vouchers')
                            ->select( 
                            'lechon_de_cebu_payment_vouchers.id',
                            'lechon_de_cebu_payment_vouchers.user_id',
                            'lechon_de_cebu_payment_vouchers.pv_id',
                            'lechon_de_cebu_payment_vouchers.date',
                            'lechon_de_cebu_payment_vouchers.paid_to',
                            'lechon_de_cebu_payment_vouchers.account_no',
                            'lechon_de_cebu_payment_vouchers.account_name',
                            'lechon_de_cebu_payment_vouchers.particulars',
                            'lechon_de_cebu_payment_vouchers.amount',
                            'lechon_de_cebu_payment_vouchers.method_of_payment',
                            'lechon_de_cebu_payment_vouchers.prepared_by',
                            'lechon_de_cebu_payment_vouchers.approved_by',
                            'lechon_de_cebu_payment_vouchers.date_apprroved',
                            'lechon_de_cebu_payment_vouchers.received_by_date',
                            'lechon_de_cebu_payment_vouchers.created_by',
                            'lechon_de_cebu_payment_vouchers.invoice_number',
                            'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                            'lechon_de_cebu_payment_vouchers.issued_date',
                            'lechon_de_cebu_payment_vouchers.category',
                            'lechon_de_cebu_payment_vouchers.amount_due',
                            'lechon_de_cebu_payment_vouchers.delivered_date',
                            'lechon_de_cebu_payment_vouchers.status',
                            'lechon_de_cebu_payment_vouchers.cheque_number',
                            'lechon_de_cebu_payment_vouchers.cheque_amount',
                            'lechon_de_cebu_payment_vouchers.sub_category',
                            'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                            ->join('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_payment_vouchers.id', $id)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->get();
          

        
        //getParticular details
        $getParticulars = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        $getChequeNumbers = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
         $amount1 = LechonDeCebuPaymentVoucher::where('id', $id)->sum('amount');
         $amount2 = LechonDeCebuPaymentVoucher::where('pv_id', $id)->sum('amount');
           
         $sum = $amount1 + $amount2;
         
         //
         $chequeAmount1 = LechonDeCebuPaymentVoucher::where('id', $id)->sum('cheque_amount');
         $chequeAmount2 = LechonDeCebuPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
         
         $sumCheque = $chequeAmount1 + $chequeAmount2;
       

        $pdf = PDF::loadView('printPayables', compact('payableId',  
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

        return $pdf->download('lechon-de-cebu-payment-voucher.pdf');
    }

    //
    public function viewPayableDetails($id){      
        $moduleName = "Payment Voucher";
        $viewPaymentDetail = DB::table(
                            'lechon_de_cebu_payment_vouchers')
                            ->select( 
                            'lechon_de_cebu_payment_vouchers.id',
                            'lechon_de_cebu_payment_vouchers.user_id',
                            'lechon_de_cebu_payment_vouchers.pv_id',
                            'lechon_de_cebu_payment_vouchers.date',
                            'lechon_de_cebu_payment_vouchers.paid_to',
                            'lechon_de_cebu_payment_vouchers.account_no',
                            'lechon_de_cebu_payment_vouchers.account_name',
                            'lechon_de_cebu_payment_vouchers.particulars',
                            'lechon_de_cebu_payment_vouchers.amount',
                            'lechon_de_cebu_payment_vouchers.method_of_payment',
                            'lechon_de_cebu_payment_vouchers.prepared_by',
                            'lechon_de_cebu_payment_vouchers.approved_by',
                            'lechon_de_cebu_payment_vouchers.date_apprroved',
                            'lechon_de_cebu_payment_vouchers.received_by_date',
                            'lechon_de_cebu_payment_vouchers.created_by',
                            'lechon_de_cebu_payment_vouchers.invoice_number',
                            'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                            'lechon_de_cebu_payment_vouchers.issued_date',
                            'lechon_de_cebu_payment_vouchers.category',
                            'lechon_de_cebu_payment_vouchers.amount_due',
                            'lechon_de_cebu_payment_vouchers.delivered_date',
                            'lechon_de_cebu_payment_vouchers.status',
                            'lechon_de_cebu_payment_vouchers.cheque_number',
                            'lechon_de_cebu_payment_vouchers.cheque_amount',
                            'lechon_de_cebu_payment_vouchers.sub_category',
                            'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                            'lechon_de_cebu_payment_vouchers.deleted_at',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                            ->join('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_payment_vouchers.id', $id)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->get();
          

        $getViewPaymentDetails = LechonDeCebuPaymentVoucher::where('pv_id', $id)->get()->toArray();

         //getParticular details
         $getParticulars = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        return view('view-lechon-de-cebu-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
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

                    $payables = LechonDeCebuPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
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

                     return redirect()->route('editPayablesDetailLechonDeCebu', ['id'=>$id]);

                    break;
                
                default:
                    # code...
                    return redirect()->route('editPayablesDetailLechonDeCebu', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
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

        return redirect()->route('editPayablesDetailLechonDeCebu', ['id'=>$id]);

    }

    //
    public function addPayment(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = LechonDeCebuPaymentVoucher::find($id);

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');

        
        //save payment cheque num and cheque amount
        $addPayment = new LechonDeCebuPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'date'=>$request->get('date'),
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

        return redirect()->route('editPayablesDetailLechonDeCebu', ['id'=>$id]);

    }


    public function editPayablesDetail(Request $request, $id){
        $moduleName = "Payment Voucher";
        $transactionList = DB::table(
                            'lechon_de_cebu_payment_vouchers')
                            ->select( 
                            'lechon_de_cebu_payment_vouchers.id',
                            'lechon_de_cebu_payment_vouchers.user_id',
                            'lechon_de_cebu_payment_vouchers.pv_id',
                            'lechon_de_cebu_payment_vouchers.date',
                            'lechon_de_cebu_payment_vouchers.paid_to',
                            'lechon_de_cebu_payment_vouchers.account_no',
                            'lechon_de_cebu_payment_vouchers.account_name',
                            'lechon_de_cebu_payment_vouchers.particulars',
                            'lechon_de_cebu_payment_vouchers.amount',
                            'lechon_de_cebu_payment_vouchers.method_of_payment',
                            'lechon_de_cebu_payment_vouchers.prepared_by',
                            'lechon_de_cebu_payment_vouchers.approved_by',
                            'lechon_de_cebu_payment_vouchers.date_apprroved',
                            'lechon_de_cebu_payment_vouchers.received_by_date',
                            'lechon_de_cebu_payment_vouchers.created_by',
                            'lechon_de_cebu_payment_vouchers.invoice_number',
                            'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                            'lechon_de_cebu_payment_vouchers.issued_date',
                            'lechon_de_cebu_payment_vouchers.category',
                            'lechon_de_cebu_payment_vouchers.amount_due',
                            'lechon_de_cebu_payment_vouchers.delivered_date',
                            'lechon_de_cebu_payment_vouchers.status',
                            'lechon_de_cebu_payment_vouchers.cheque_number',
                            'lechon_de_cebu_payment_vouchers.cheque_amount',
                            'lechon_de_cebu_payment_vouchers.sub_category',
                            'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                            ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_payment_vouchers.id', $id)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->get();
        
        $getChequeNumbers = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        
        $getCashAmounts = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
       
        //getParticular details
        $getParticulars = LechonDeCebuPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
      

        //amount
        $amount1 = LechonDeCebuPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = LechonDeCebuPaymentVoucher::where('pv_id', $id)->sum('amount');
       
        $sum = $amount1 + $amount2;

        $chequeAmount1 = LechonDeCebuPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = LechonDeCebuPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
        

        return view('lechon-de-cebu-payables-detail', compact('transactionList', 
        'getChequeNumbers', 'getParticulars', 'sum', 'sumCheque', 'getCashAmounts'));

    }

    //
    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                                'lechon_de_cebu_payment_vouchers')
                                ->select( 
                                'lechon_de_cebu_payment_vouchers.id',
                                'lechon_de_cebu_payment_vouchers.user_id',
                                'lechon_de_cebu_payment_vouchers.pv_id',
                                'lechon_de_cebu_payment_vouchers.date',
                                'lechon_de_cebu_payment_vouchers.paid_to',
                                'lechon_de_cebu_payment_vouchers.account_no',
                                'lechon_de_cebu_payment_vouchers.account_name',
                                'lechon_de_cebu_payment_vouchers.particulars',
                                'lechon_de_cebu_payment_vouchers.amount',
                                'lechon_de_cebu_payment_vouchers.method_of_payment',
                                'lechon_de_cebu_payment_vouchers.prepared_by',
                                'lechon_de_cebu_payment_vouchers.approved_by',
                                'lechon_de_cebu_payment_vouchers.date_apprroved',
                                'lechon_de_cebu_payment_vouchers.received_by_date',
                                'lechon_de_cebu_payment_vouchers.created_by',
                                'lechon_de_cebu_payment_vouchers.invoice_number',
                                'lechon_de_cebu_payment_vouchers.voucher_ref_number',
                                'lechon_de_cebu_payment_vouchers.issued_date',
                                'lechon_de_cebu_payment_vouchers.category',
                                'lechon_de_cebu_payment_vouchers.amount_due',
                                'lechon_de_cebu_payment_vouchers.delivered_date',
                                'lechon_de_cebu_payment_vouchers.status',
                                'lechon_de_cebu_payment_vouchers.cheque_number',
                                'lechon_de_cebu_payment_vouchers.cheque_amount',
                                'lechon_de_cebu_payment_vouchers.sub_category',
                                'lechon_de_cebu_payment_vouchers.sub_category_account_id',
                                'lechon_de_cebu_payment_vouchers.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_payment_vouchers.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_payment_vouchers.pv_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_payment_vouchers.deleted_at', NULL)
                                ->orderBy('lechon_de_cebu_payment_vouchers.id', 'desc')
                               
                                ->get()->toArray();
      

        //get total amount due
        $status = "FULLY PAID AND RELEASED";
        $totalAmoutDue = LechonDeCebuPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');
        
        return view('lechon-de-cebu-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));

    }

    //
    public function printSalesInvoice($id){

        $moduleName = "Sales Invoice";
        $printSales = DB::table(
                        'lechon_de_cebu_sales_invoices')
                        ->select(
                            'lechon_de_cebu_sales_invoices.id',
                            'lechon_de_cebu_sales_invoices.user_id',
                            'lechon_de_cebu_sales_invoices.si_id',
                            'lechon_de_cebu_sales_invoices.invoice_number',
                            'lechon_de_cebu_sales_invoices.date',
                            'lechon_de_cebu_sales_invoices.ordered_by',
                            'lechon_de_cebu_sales_invoices.address',
                            'lechon_de_cebu_sales_invoices.qty',
                            'lechon_de_cebu_sales_invoices.total_kls',
                            'lechon_de_cebu_sales_invoices.body',
                            'lechon_de_cebu_sales_invoices.head_and_feet',
                            'lechon_de_cebu_sales_invoices.item_description',
                            'lechon_de_cebu_sales_invoices.unit_price',
                            'lechon_de_cebu_sales_invoices.amount',
                            'lechon_de_cebu_sales_invoices.created_by',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_sales_invoices.id', $id)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->get();
           

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
        $moduleName = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                ->get()->toArray();
      


        return view('lechon-de-cebu-sales-invoice-private-orders', compact('user', 'getAllDeliveryReceipts'));
    }

    //sales invoice > sales pero outlet
    public function salesInvoiceSalesPerOutlet(){

        //getSalesInvoiceTerminal1
        $branch = "Ssp Food Avenue Terminal 1";
        $branch2 = "Ssp Food Avenue Terminal 2";

        $moduleName = "Sales Invoice";
        $statementOfAccountT1s = DB::table(
                        'lechon_de_cebu_sales_invoices')
                        ->select(
                            'lechon_de_cebu_sales_invoices.id',
                            'lechon_de_cebu_sales_invoices.user_id',
                            'lechon_de_cebu_sales_invoices.si_id',
                            'lechon_de_cebu_sales_invoices.invoice_number',
                            'lechon_de_cebu_sales_invoices.date',
                            'lechon_de_cebu_sales_invoices.ordered_by',
                            'lechon_de_cebu_sales_invoices.address',
                            'lechon_de_cebu_sales_invoices.qty',
                            'lechon_de_cebu_sales_invoices.total_kls',
                            'lechon_de_cebu_sales_invoices.body',
                            'lechon_de_cebu_sales_invoices.head_and_feet',
                            'lechon_de_cebu_sales_invoices.item_description',
                            'lechon_de_cebu_sales_invoices.unit_price',
                            'lechon_de_cebu_sales_invoices.amount',
                            'lechon_de_cebu_sales_invoices.created_by',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->where('ordered_by', $branch)
                        ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                        ->get()->toArray();



        //get total sales in terminal 1
        $totalSalesInTerminal1 = DB::table(
                                'lechon_de_cebu_sales_invoices')
                                ->select(
                                    'lechon_de_cebu_sales_invoices.id',
                                    'lechon_de_cebu_sales_invoices.user_id',
                                    'lechon_de_cebu_sales_invoices.si_id',
                                    'lechon_de_cebu_sales_invoices.invoice_number',
                                    'lechon_de_cebu_sales_invoices.date',
                                    'lechon_de_cebu_sales_invoices.ordered_by',
                                    'lechon_de_cebu_sales_invoices.address',
                                    'lechon_de_cebu_sales_invoices.qty',
                                    'lechon_de_cebu_sales_invoices.total_kls',
                                    'lechon_de_cebu_sales_invoices.body',
                                    'lechon_de_cebu_sales_invoices.head_and_feet',
                                    'lechon_de_cebu_sales_invoices.item_description',
                                    'lechon_de_cebu_sales_invoices.unit_price',
                                    'lechon_de_cebu_sales_invoices.amount',
                                    'lechon_de_cebu_sales_invoices.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('ordered_by', $branch)
                                ->sum('lechon_de_cebu_sales_invoices.amount');


        $statementOfAccountT2s = LechonDeCebuSalesInvoice::where('ordered_by', $branch2)->get()->toArray();

        $statementOfAccountT2s = DB::table(
                                'lechon_de_cebu_sales_invoices')
                                ->select(
                                    'lechon_de_cebu_sales_invoices.id',
                                    'lechon_de_cebu_sales_invoices.user_id',
                                    'lechon_de_cebu_sales_invoices.si_id',
                                    'lechon_de_cebu_sales_invoices.invoice_number',
                                    'lechon_de_cebu_sales_invoices.date',
                                    'lechon_de_cebu_sales_invoices.ordered_by',
                                    'lechon_de_cebu_sales_invoices.address',
                                    'lechon_de_cebu_sales_invoices.qty',
                                    'lechon_de_cebu_sales_invoices.total_kls',
                                    'lechon_de_cebu_sales_invoices.body',
                                    'lechon_de_cebu_sales_invoices.head_and_feet',
                                    'lechon_de_cebu_sales_invoices.item_description',
                                    'lechon_de_cebu_sales_invoices.unit_price',
                                    'lechon_de_cebu_sales_invoices.amount',
                                    'lechon_de_cebu_sales_invoices.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('ordered_by', $branch2)
                                ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                                ->get()->toArray();


          //get total sales in terminal 2
        $totalSalesInTerminal2 = DB::table(
                            'lechon_de_cebu_sales_invoices')
                            ->select(
                                'lechon_de_cebu_sales_invoices.id',
                                'lechon_de_cebu_sales_invoices.user_id',
                                'lechon_de_cebu_sales_invoices.si_id',
                                'lechon_de_cebu_sales_invoices.invoice_number',
                                'lechon_de_cebu_sales_invoices.date',
                                'lechon_de_cebu_sales_invoices.ordered_by',
                                'lechon_de_cebu_sales_invoices.address',
                                'lechon_de_cebu_sales_invoices.qty',
                                'lechon_de_cebu_sales_invoices.total_kls',
                                'lechon_de_cebu_sales_invoices.body',
                                'lechon_de_cebu_sales_invoices.head_and_feet',
                                'lechon_de_cebu_sales_invoices.item_description',
                                'lechon_de_cebu_sales_invoices.unit_price',
                                'lechon_de_cebu_sales_invoices.amount',
                                'lechon_de_cebu_sales_invoices.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->where('ordered_by', $branch2)
                            ->sum('lechon_de_cebu_sales_invoices.amount');

        return view('lechon-de-cebu-sales-invoice-sales-per-outlet', compact('statementOfAccountT1s', 'totalSalesInTerminal1', 'statementOfAccountT2s', 'totalSalesInTerminal2'));
    }

    //
    public function sAccountUpdate(Request $request, $id){
       
        //get the main Id 
        $mainIdSoa = LechonDeCebuStatementOfAccount::find($request->mainId);

        $compute = $mainIdSoa->total_remaining_balance - $request->paidAmount;
        
        $mainIdSoa->total_remaining_balance = $compute; 
        $mainIdSoa->save();

        $statementAccountPaid = LechonDeCebuStatementOfAccount::find($request->id);
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
        $moduleName = "Billing Statement";
        $printBillingStatement = DB::table(
                                'lechon_de_cebu_billing_statements')
                                ->select(
                                    'lechon_de_cebu_billing_statements.id',
                                    'lechon_de_cebu_billing_statements.user_id',
                                    'lechon_de_cebu_billing_statements.billing_statement_id',
                                    'lechon_de_cebu_billing_statements.bill_to',
                                    'lechon_de_cebu_billing_statements.address',
                                    'lechon_de_cebu_billing_statements.dr_no',
                                    'lechon_de_cebu_billing_statements.qty',
                                    'lechon_de_cebu_billing_statements.unit',
                                    'lechon_de_cebu_billing_statements.date',
                                    'lechon_de_cebu_billing_statements.branch',
                                    'lechon_de_cebu_billing_statements.period_cover',
                                    'lechon_de_cebu_billing_statements.terms',
                                    'lechon_de_cebu_billing_statements.date_of_transaction',
                                    'lechon_de_cebu_billing_statements.invoice_number',
                                    'lechon_de_cebu_billing_statements.order',
                                    'lechon_de_cebu_billing_statements.whole_lechon',
                                    'lechon_de_cebu_billing_statements.description',
                                    'lechon_de_cebu_billing_statements.amount',
                                    'lechon_de_cebu_billing_statements.paid_amount',
                                    'lechon_de_cebu_billing_statements.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_billing_statements.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get();
    
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
        $moduleName = "Purchase Order";
        $purchaseOrder = DB::table(
                        'lechon_de_cebu_purchase_orders')
                        ->select(
                            'lechon_de_cebu_purchase_orders.id',
                            'lechon_de_cebu_purchase_orders.user_id',
                            'lechon_de_cebu_purchase_orders.po_id',
                            'lechon_de_cebu_purchase_orders.paid_to',
                            'lechon_de_cebu_purchase_orders.address',
                            'lechon_de_cebu_purchase_orders.date',
                            'lechon_de_cebu_purchase_orders.quantity',
                            'lechon_de_cebu_purchase_orders.total_kls',
                            'lechon_de_cebu_purchase_orders.description',
                            'lechon_de_cebu_purchase_orders.unit_price',
                            'lechon_de_cebu_purchase_orders.amount',
                            'lechon_de_cebu_purchase_orders.total_price',
                            'lechon_de_cebu_purchase_orders.requested_by',
                            'lechon_de_cebu_purchase_orders.prepared_by',
                            'lechon_de_cebu_purchase_orders.checked_by',
                            'lechon_de_cebu_purchase_orders.created_by',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->join('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_purchase_orders.id', $id)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->get();
    

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
        $moduleName = "Delivery Receipt";
        $deliveryId = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.unit',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get()->toArray();
       


        $deliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuDeliveryReceipt::where('id', $id)->sum('price');

        $countAmount = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;

        //count the kilos 
        $countKls = LechonDeCebuDeliveryReceipt::where('id', $id)->sum('qty');
        $countAmountKls = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->sum('qty');
       
        $sumQty = $countKls + $countAmountKls;

        $pdf = PDF::loadView('printDelivery', compact('deliveryId', 'deliveryReceipts', 'sum', 'sumQty'));

        return $pdf->download('lechon-de-cebu-delivery-receipt.pdf');
    }

    //inventory of stocksInventory
    public function inventoryOfStocks(){
        $getRawMaterials = DB::table(
                        'commissary_raw_materials')
                        ->select(
                            'commissary_raw_materials.id',
                            'commissary_raw_materials.user_id',
                            'commissary_raw_materials.rm_id',
                            'commissary_raw_materials.product_name',
                            'commissary_raw_materials.unit_price',
                            'commissary_raw_materials.unit',
                            'commissary_raw_materials.in',
                            'commissary_raw_materials.out',
                            'commissary_raw_materials.stock_amount',
                            'commissary_raw_materials.remaining_stock',
                            'commissary_raw_materials.amount',
                            'commissary_raw_materials.supplier',
                            'commissary_raw_materials.date',
                            'commissary_raw_materials.item',
                            'commissary_raw_materials.description',
                            'commissary_raw_materials.reference_no',
                            'commissary_raw_materials.qty',
                            'commissary_raw_materials.requesting_branch',
                            'commissary_raw_materials.cheque_no_issued',
                            'commissary_raw_materials.status',
                            'commissary_raw_materials.created_by',
                            'lechon_de_cebu_raw_material_products.raw_materials_id',
                            'lechon_de_cebu_raw_material_products.branch',
                            'lechon_de_cebu_raw_material_products.product_id_no')
                        ->join('lechon_de_cebu_raw_material_products', 'commissary_raw_materials.id', '=', 'lechon_de_cebu_raw_material_products.raw_materials_id')
                        ->where('commissary_raw_materials.rm_id', NULL)
                        ->orderBy('commissary_raw_materials.id', 'desc')
                        ->get()->toArray();

        //count the total stock out amount value
        $countStockAmount = CommissaryRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = CommissaryRawMaterial::where('rm_id', NULL)->sum('amount');
        
        return view('commissary-inventory-of-stocks', compact('getRawMaterials', 'countStockAmount', 'countTotalAmount'));
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


    //save delivery in RAW material
    public function addDIRST(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $rawMaterial = CommissaryRawMaterial::find($request->id);

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

        $addDeliveryIn = new CommissaryRawMaterial([
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


        return response()->json('Success: Delivery In Successfully Added.'); 

    }

    //view RAW material details
    public function viewRawMaterialDetails($id){
        $viewRawDetail = DB::table(
                        'commissary_raw_materials')
                        ->select(
                            'commissary_raw_materials.id',
                            'commissary_raw_materials.user_id',
                            'commissary_raw_materials.rm_id',
                            'commissary_raw_materials.product_name',
                            'commissary_raw_materials.unit_price',
                            'commissary_raw_materials.unit',
                            'commissary_raw_materials.in',
                            'commissary_raw_materials.out',
                            'commissary_raw_materials.stock_amount',
                            'commissary_raw_materials.remaining_stock',
                            'commissary_raw_materials.amount',
                            'commissary_raw_materials.supplier',
                            'commissary_raw_materials.date',
                            'commissary_raw_materials.item',
                            'commissary_raw_materials.description',
                            'commissary_raw_materials.reference_no',
                            'commissary_raw_materials.qty',
                            'commissary_raw_materials.requesting_branch',
                            'commissary_raw_materials.cheque_no_issued',
                            'commissary_raw_materials.status',
                            'commissary_raw_materials.created_by',
                            'lechon_de_cebu_raw_material_products.raw_materials_id',
                            'lechon_de_cebu_raw_material_products.branch',
                            'lechon_de_cebu_raw_material_products.product_id_no')
                        ->join('lechon_de_cebu_raw_material_products', 'commissary_raw_materials.id', '=', 'lechon_de_cebu_raw_material_products.raw_materials_id')
                        ->where('commissary_raw_materials.id', $id)
                        ->get();


        //transaction table
        $getViewRawDetails = CommissaryRawMaterial::where('rm_id', $id)->get()->toArray();
        
        return view('view-lechon-de-cebu-raw-material-details', compact('viewRawDetail', 'getViewRawDetails'));
    }

    //update RAW material
    public function updateRawMaterial(Request $request){

        $updateRawMaterial = CommissaryRawMaterial::find($request->id);

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
        $dataProductId = DB::select('SELECT id, product_id_no FROM lechon_de_cebu_raw_material_products ORDER BY id DESC LIMIT 1');

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
                'commissary_raw_materials')
                ->where('product_name', $request->productName)
                ->get()->first(); 

        if($target === NULL){
            $addNewRawMaterial = new CommissaryRawMaterial([
                'user_id'=>$user->id,
                'product_name'=>$request->productName,
                'unit_price'=>$request->unitPrice,
                'unit'=>$request->unit,
                'in'=>$request->stockIn,
                'remaining_stock'=>$request->stockIn,
                'amount'=>$amount,
                'supplier'=>$request->get('supplier'),
                'created_by'=>$name,
    
            ]);
    
            $addNewRawMaterial->save();
            $insertedId = $addNewRawMaterial->id;

            //save to table lechon_de_cebu_raw_material_products
            $addNewProd = new LechonDeCebuRawMaterialProduct([
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

    //RAW materials
    public function rawMaterials(){
        $getRawMaterials = DB::table(
                    'commissary_raw_materials')
                    ->select(
                        'commissary_raw_materials.id',
                        'commissary_raw_materials.user_id',
                        'commissary_raw_materials.rm_id',
                        'commissary_raw_materials.product_name',
                        'commissary_raw_materials.unit_price',
                        'commissary_raw_materials.unit',
                        'commissary_raw_materials.in',
                        'commissary_raw_materials.out',
                        'commissary_raw_materials.stock_amount',
                        'commissary_raw_materials.remaining_stock',
                        'commissary_raw_materials.amount',
                        'commissary_raw_materials.supplier',
                        'commissary_raw_materials.date',
                        'commissary_raw_materials.item',
                        'commissary_raw_materials.description',
                        'commissary_raw_materials.reference_no',
                        'commissary_raw_materials.qty',
                        'commissary_raw_materials.requesting_branch',
                        'commissary_raw_materials.cheque_no_issued',
                        'commissary_raw_materials.status',
                        'commissary_raw_materials.created_by',
                        'lechon_de_cebu_raw_material_products.raw_materials_id',
                        'lechon_de_cebu_raw_material_products.branch',
                        'lechon_de_cebu_raw_material_products.product_id_no')
                    ->join('lechon_de_cebu_raw_material_products', 'commissary_raw_materials.id', '=', 'lechon_de_cebu_raw_material_products.raw_materials_id')
                    ->where('commissary_raw_materials.rm_id', NULL)
                    ->orderBy('commissary_raw_materials.id', 'desc')
                    ->get()->toArray();

        return view('commissary-raw-materials', compact('getRawMaterials'));
    }

    //view sales invoice
    public function viewSalesInvoice($id){

        $moduleName = "Sales Invoice";
        $viewSalesInvoice = DB::table(
                                'lechon_de_cebu_sales_invoices')
                                ->select(
                                    'lechon_de_cebu_sales_invoices.id',
                                    'lechon_de_cebu_sales_invoices.user_id',
                                    'lechon_de_cebu_sales_invoices.si_id',
                                    'lechon_de_cebu_sales_invoices.invoice_number',
                                    'lechon_de_cebu_sales_invoices.date',
                                    'lechon_de_cebu_sales_invoices.ordered_by',
                                    'lechon_de_cebu_sales_invoices.address',
                                    'lechon_de_cebu_sales_invoices.qty',
                                    'lechon_de_cebu_sales_invoices.total_kls',
                                    'lechon_de_cebu_sales_invoices.body',
                                    'lechon_de_cebu_sales_invoices.head_and_feet',
                                    'lechon_de_cebu_sales_invoices.item_description',
                                    'lechon_de_cebu_sales_invoices.unit_price',
                                    'lechon_de_cebu_sales_invoices.amount',
                                    'lechon_de_cebu_sales_invoices.created_by',
                                    'lechon_de_cebu_sales_invoices.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_sales_invoices.id', $id)
                                ->get();
    

        $salesInvoices = LechonDeCebuSalesInvoice::where('si_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = LechonDeCebuSalesInvoice::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuSalesInvoice::where('si_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-lechon-de-cebu-sales-invoice', compact( 'viewSalesInvoice', 'salesInvoices', 'sum'));

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

        $getSales = LechonDeCebuSalesInvoice::find($id);
        $tots =  $getSales->total_amount + $tot;

        $addNewSalesInvoice = new LechonDeCebuSalesInvoice([
            'user_id'=>$user->id,
            'si_id'=>$id,
            'sales_invoice_number'=>$getSales['sales_invoice_number'],
            'date'=>$getDateToday,
            'qty'=>$request->get('qty'),
            'body'=>$body,
            'head_and_feet'=>$head,
            'item_description'=>$request->get('itemDescription'),
            'amount'=>$tot,
            'created_by'=>$name,
        ]);

        $addNewSalesInvoice->save();

        //update 
        $getSales->total_amount = $tots;
        $getSales->save();

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

         //get the latest insert id query in table lechon_de_cebu_codes
         $dataSalesNo = DB::select('SELECT id, lechon_de_cebu_code FROM lechon_de_cebu_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 dr_no
         if(isset($dataSalesNo[0]->lechon_de_cebu_code) != 0){
             //if code is not 0
             $newSI = $dataSalesNo[0]->lechon_de_cebu_code +1;
             $uSI = sprintf("%06d",$newSI);   
 
         }else{
             //if code is 0 
             $newSI = 1;
             $uSI = sprintf("%06d",$newSI);
         } 
 
         //get date today
         $getDateToday =  date('Y-m-d');
 

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
            'sales_invoice_number'=>$uSI,
            'ordered_by'=>$request->get('orderedBy'),
            'address'=>$request->get('address'),
            'date'=>$request->get('date'),
            'qty'=>$request->get('qty'),
            'body'=>$body,
            'head_and_feet'=>$head,
            'item_description'=>$request->get('itemDescription'),
            'amount'=>$tot,
            'total_amount'=>$tot,
            'created_by'=>$name,
        ]);

        $addSalesInvoice->save();

        $insertedId = $addSalesInvoice->id;

        $moduleCode = "SI-";
        $moduleName = "Sales Invoice";

        //save to lechon_de_cebu_codes table
        $lechonDeCebu = new LechonDeCebuCode([
            'user_id'=>$user->id,
            'lechon_de_cebu_code'=>$uSI,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $lechonDeCebu->save();

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
    
        $moduleName = "Delivery Receipt";
        $viewDeliveryReceipt = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.unit',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_delivery_receipts.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get()->toArray();
       

        $deliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();
      

         //count the total amount 
        $countTotalAmount = LechonDeCebuDeliveryReceipt::where('id', $id)->sum('price');
       

        //
        $countAmount = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;
        

        return view('view-lechon-de-cebu-delivery-receipt', compact('viewDeliveryReceipt', 'deliveryReceipts', 'sum'));
    }

    //update for the add new delivery receipt
    public function updateDr(Request $request, $id){
        
        $delivery = LechonDeCebuDeliveryReceipt::find($id);
        $delivery->qty = $request->get('qty');
        $delivery->unit = $request->get('unit');
        $delivery->description = $request->get('description');
        $delivery->price = $request->get('price');

        $delivery->save();


        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect('lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/'.$request->get('drId'));



    }

    //delivery receipt lists
    public function deliveryReceiptLists(){
      
        //getAllDeliveryReceipt
        $moduleName = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_delivery_receipts.deleted_at',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_delivery_receipts.deleted_at', NULL)
                                ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                ->get()->toArray();
      
        //getDuplicateCopy
        $getDuplicateCopies = LechonDeCebuDeliveryReceiptDuplicateCopy::where('dr_id', NULL)->get()->toArray();

        return view('lechon-de-cebu-delivery-receipt-lists', compact('getAllDeliveryReceipts', 'getDuplicateCopies'));
    }

    //add new delivery recipt data
    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $deliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);

        $tot = $deliveryReceipt->total + $request->get('price');
        
        //calculate the small live hog 
        if($request->get('description') === "SPECIAL LOLO PINOY LECHON DE CEBU"){
            //query raw material minus the small live hog
            $productName = "SMALL LIVE HOG";
            $getRawMaterial = DB::table(
                        'commissary_raw_materials')
                        ->select(
                            'commissary_raw_materials.id',
                            'commissary_raw_materials.user_id',
                            'commissary_raw_materials.rm_id',
                            'commissary_raw_materials.product_name',
                            'commissary_raw_materials.unit_price',
                            'commissary_raw_materials.unit',
                            'commissary_raw_materials.in',
                            'commissary_raw_materials.out',
                            'commissary_raw_materials.stock_amount',
                            'commissary_raw_materials.remaining_stock',
                            'commissary_raw_materials.amount',
                            'commissary_raw_materials.supplier',
                            'commissary_raw_materials.date',
                            'commissary_raw_materials.item',
                            'commissary_raw_materials.description',
                            'commissary_raw_materials.reference_no',
                            'commissary_raw_materials.qty',
                            'commissary_raw_materials.requesting_branch',
                            'commissary_raw_materials.cheque_no_issued',
                            'commissary_raw_materials.status',
                            'commissary_raw_materials.created_by',
                            'lechon_de_cebu_raw_material_products.raw_materials_id',
                            'lechon_de_cebu_raw_material_products.branch',
                            'lechon_de_cebu_raw_material_products.product_id_no')
                        ->join('lechon_de_cebu_raw_material_products', 'commissary_raw_materials.id', '=', 'lechon_de_cebu_raw_material_products.raw_materials_id')
                        ->where('commissary_raw_materials.product_name', $productName)
                        ->get();

            $addOutOne = $getRawMaterial[0]->out + 1;

            $minusOne = $getRawMaterial[0]->in - $addOutOne;

            $stockOutAmt = $getRawMaterial[0]->unit_price * $addOutOne; 

            $updateSmallHog = CommissaryRawMaterial::find($getRawMaterial[0]->id);
            $updateSmallHog->out = $addOutOne;
            $updateSmallHog->stock_amount = $stockOutAmt;
            $updateSmallHog->remaining_stock = $minusOne; 
            $updateSmallHog->save();
            
            $description = $request->get('description');
        }else{
            $description = $request->get('description');
        }

        $addNewDeliveryReceipt = new LechonDeCebuDeliveryReceipt([
            'user_id'=>$user->id,
            'dr_id'=>$id,
            'dr_no'=>$deliveryReceipt['dr_no'],
            'qty'=>$request->get('qty'),
            'unit'=>$request->get('unit'),
            'description'=>$request->get('description'),
            'price'=>$request->get('price'),
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $addNewDeliveryReceipt->save();

        //update 
        $deliveryReceipt->total = $tot; 
        $deliveryReceipt->save();

        Session::flash('addDeliveryReceiptSuccess', 'Successfully added.');

        return redirect()->route('editDeliveryReceiptLechonDeCebu', ['id'=>$id]);

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
        $updateDeliveryReceipt->unit = $request->get('unit');
        $updateDeliveryReceipt->description = $request->get('description');
        $updateDeliveryReceipt->price = $request->get('price');

        $updateDeliveryReceipt->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect('lolo-pinoy-lechon-de-cebu/edit-delivery-receipt/'.$id);
    }

    //edit delivery receipt
    public function editDeliveryReceipt($id){
     
        //getDeliveryReceipt
        $getDeliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);

        //dReceipts
        $dReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-lechon-de-cebu-delivery-receipt', compact('id','getDeliveryReceipt', 'dReceipts'));
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

         //get the latest insert id query in table lechon_de_cebu_codes
        $dataDrNo = DB::select('SELECT id, lechon_de_cebu_code FROM lechon_de_cebu_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 dr_no
        if(isset($dataDrNo[0]->lechon_de_cebu_code) != 0){
            //if code is not 0
            $newDr = $dataDrNo[0]->lechon_de_cebu_code +1;
            $uDr = sprintf("%06d",$newDr);   

        }else{
            //if code is 0 
            $newDr = 1;
            $uDr = sprintf("%06d",$newDr);
        } 

        //calculate the small live hog 
        if($request->get('description') === "SPECIAL LOLO PINOY LECHON DE CEBU"){
            //query raw material minus the small live hog
            $productName = "SMALL LIVE HOG";
            $getRawMaterial = DB::table(
                        'commissary_raw_materials')
                        ->select(
                            'commissary_raw_materials.id',
                            'commissary_raw_materials.user_id',
                            'commissary_raw_materials.rm_id',
                            'commissary_raw_materials.product_name',
                            'commissary_raw_materials.unit_price',
                            'commissary_raw_materials.unit',
                            'commissary_raw_materials.in',
                            'commissary_raw_materials.out',
                            'commissary_raw_materials.stock_amount',
                            'commissary_raw_materials.remaining_stock',
                            'commissary_raw_materials.amount',
                            'commissary_raw_materials.supplier',
                            'commissary_raw_materials.date',
                            'commissary_raw_materials.item',
                            'commissary_raw_materials.description',
                            'commissary_raw_materials.reference_no',
                            'commissary_raw_materials.qty',
                            'commissary_raw_materials.requesting_branch',
                            'commissary_raw_materials.cheque_no_issued',
                            'commissary_raw_materials.status',
                            'commissary_raw_materials.created_by',
                            'lechon_de_cebu_raw_material_products.raw_materials_id',
                            'lechon_de_cebu_raw_material_products.branch',
                            'lechon_de_cebu_raw_material_products.product_id_no')
                        ->join('lechon_de_cebu_raw_material_products', 'commissary_raw_materials.id', '=', 'lechon_de_cebu_raw_material_products.raw_materials_id')
                        ->where('commissary_raw_materials.product_name', $productName)
                        ->get();

            $minusOne = $getRawMaterial[0]->in - $getRawMaterial[0]->out;
            $addOutOne = $getRawMaterial[0]->out + 1;

            $stockOutAmt = $getRawMaterial[0]->unit_price * $addOutOne; 

            $updateSmallHog = CommissaryRawMaterial::find($getRawMaterial[0]->id);
            $updateSmallHog->out = $addOutOne;
            $updateSmallHog->stock_amount = $stockOutAmt;
            $updateSmallHog->remaining_stock = $minusOne; 
            $updateSmallHog->save();
            
            $description = $request->get('description');
        }else{
            $description = $request->get('description');
        }
        
        $storeDeliveryReceipt = new LechonDeCebuDeliveryReceipt([
            'user_id'=>$user->id,
            'sold_to'=>$request->get('soldTo'),
            'time'=>$request->get('time'),
            'date'=>$request->get('date'),
            'date_to_be_delivered'=>$request->get('dateDelivered'),
            'dr_no'=>$uDr,
            'delivered_to'=>$request->get('deliveredTo'),
            'contact_person'=>$request->get('contactPerson'),
            'mobile_num'=>$request->get('mobile'),
            'special_instruction'=>$request->get('specialInstruction'),
            'consignee_name'=>$request->get('consigneeName'),
            'consignee_contact_num'=>$request->get('consigneeContact'),
            'qty'=>$request->get('qty'),
            'unit'=>$request->get('unit'),
            'description'=>$description,
            'price'=>$request->get('price'),
            'total'=>$request->get('price'),
            'prepared_by'=>$name,
            'created_by'=>$name,
        ]);

        $storeDeliveryReceipt->save();
        $insertedId  = $storeDeliveryReceipt->id;

        $moduleCode = "DR-";
        $moduleName = "Delivery Receipt";

        //save to lechon_de_cebu_codes table
        $lechonDeCebu = new LechonDeCebuCode([
            'user_id'=>$user->id,
            'lechon_de_cebu_code'=>$uDr,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $lechonDeCebu->save();

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

         //get the latest insert id query in table lechon de cebu
        $dataCode = DB::select('SELECT id, lechon_de_cebu_code FROM lechon_de_cebu_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataCode[0]->lechon_de_cebu_code) != 0){
            //if code is not 0
            $newCode= $dataCode[0]->lechon_de_cebu_code +1;
            $uCode = sprintf("%06d",$newCode);   

        }else{
            //if code is 0 
            $newCode = 1;
            $uCode = sprintf("%06d",$newCode);
        } 

        //if user selects category
        if($request->get('category') === "None"){

            $subCat = NULL;
            $subCatAccountId = NULL;

            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }elseif($request->get('category') === "Petty Cash"){

            $subCat = $request->get('pettyCashNo');
            $subCatAccountId = NULL;

            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') === "Utility"){
            $subCat = $request->get('utility');
            $subCatAccountId = $request->get('accountId');

            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') === "Payroll"){  
            $subCat = NULL;
            $subCatAccountId = NULL;
            $supplierExp = NULL;
            $supplierExp1 = NULL;
        }else if($request->get('category') === "Supplier"){
            
            $supplier = $request->get('supplierName');
            $supplierExps = explode("-", $supplier);

            $supplierExp =  $supplierExps[0];
            $supplierExp1 = $supplierExps[1];

            $subCat = NULL;
            $subCatAccountId = NULL;
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
                'method_of_payment'=>$request->get('paymentMethod'),
                'invoice_number'=>$request->get('invoiceNumber'),
                'account_name'=>$request->get('accountName'),
                'issued_date'=>$request->get('issuedDate'),
                'amount'=>$request->get('amount'),
                'amount_due'=>$request->get('amount'),
                'particulars'=>$request->get('particulars'),
                'category'=>$request->get('category'),
                'sub_category'=>$subCat,
                'sub_category_account_id'=>$subCatAccountId,
                'supplier_id'=>$supplierExp,
                'supplier_name'=>$supplierExp1,
                'prepared_by'=>$name,
                'created_by'=>$name,

            ]);

             $addPaymentVoucher->save();

             $insertedId = $addPaymentVoucher->id;
            
             $moduleCode = "PV-";
             $moduleName = "Payment Voucher";
     
             //save to lechon_de_cebu_codes table
             $lechonDeCebu = new LechonDeCebuCode([
                 'user_id'=>$user->id,
                 'lechon_de_cebu_code'=>$uCode,
                 'module_id'=>$insertedId,
                 'module_code'=>$moduleCode,
                 'module_name'=>$moduleName,
     
             ]);
             $lechonDeCebu->save();

             return redirect()->route('editPayablesDetailLechonDeCebu', ['id'=>$insertedId]);

        }else{
            return redirect()->route('paymentVoucherFormLechonDeCebu')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }      

    }

    //payment voucher form
    public function paymentVoucherForm(){

        $moduleName = "Petty Cash";
        $pettyCashes = DB::table(
                                'lechon_de_cebu_petty_cashes')
                                ->select( 
                                'lechon_de_cebu_petty_cashes.id',
                                'lechon_de_cebu_petty_cashes.user_id',
                                'lechon_de_cebu_petty_cashes.pc_id',
                                'lechon_de_cebu_petty_cashes.date',
                                'lechon_de_cebu_petty_cashes.petty_cash_name',
                                'lechon_de_cebu_petty_cashes.petty_cash_summary',
                                'lechon_de_cebu_petty_cashes.amount',
                                'lechon_de_cebu_petty_cashes.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_petty_cashes.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_petty_cashes.pc_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get();
    

        $getAllFlags = LechonDeCebuUtility::get()->toArray();
       
         //get suppliers
         $suppliers = LechonDeCebuSupplier::get()->toArray();

        return view('payment-voucher-form',compact('pettyCashes', 'getAllFlags', 'suppliers'));
        
    }

  
    //view stocks inventory
    public function viewStocksInventory($id){   
         $ids = Auth::user()->id;
        $user = User::find($ids);
        
        return view('view-lechon-de-cebu-stocks-inventory', compact('user'));
    }
  

    //stocks inventory
    public function stocksInventory(){

        $getRawMaterials = DB::table(
                    'commissary_raw_materials')
                    ->select(
                        'commissary_raw_materials.id',
                        'commissary_raw_materials.user_id',
                        'commissary_raw_materials.rm_id',
                        'commissary_raw_materials.product_name',
                        'commissary_raw_materials.unit_price',
                        'commissary_raw_materials.unit',
                        'commissary_raw_materials.in',
                        'commissary_raw_materials.out',
                        'commissary_raw_materials.stock_amount',
                        'commissary_raw_materials.remaining_stock',
                        'commissary_raw_materials.amount',
                        'commissary_raw_materials.supplier',
                        'commissary_raw_materials.date',
                        'commissary_raw_materials.item',
                        'commissary_raw_materials.description',
                        'commissary_raw_materials.reference_no',
                        'commissary_raw_materials.qty',
                        'commissary_raw_materials.requesting_branch',
                        'commissary_raw_materials.cheque_no_issued',
                        'commissary_raw_materials.status',
                        'commissary_raw_materials.created_by',
                        'lechon_de_cebu_raw_material_products.raw_materials_id',
                        'lechon_de_cebu_raw_material_products.branch',
                        'lechon_de_cebu_raw_material_products.product_id_no')
                    ->join('lechon_de_cebu_raw_material_products', 'commissary_raw_materials.id', '=', 'lechon_de_cebu_raw_material_products.raw_materials_id')
                    ->where('commissary_raw_materials.rm_id', NULL)
                    ->orderBy('commissary_raw_materials.id', 'desc')
                    ->get()->toArray();
                    

        //count the total stock out amount value
        $countStockAmount = CommissaryRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = CommissaryRawMaterial::where('rm_id', NULL)->sum('amount');

        return view('commissary-stocks-inventory', compact('getRawMaterials', 'countStockAmount', 'countTotalAmount'));
    }

    //view statement of account
    public function viewStatementAccount($id){
       
        //viewStatementAccount
        $moduleName = "Statement Of Account";
        $viewStatementAccount = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.payment_method',
                                    'lechon_de_cebu_statement_of_accounts.collection_date',
                                    'lechon_de_cebu_statement_of_accounts.check_number',
                                    'lechon_de_cebu_statement_of_accounts.check_amount',
                                    'lechon_de_cebu_statement_of_accounts.or_number',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get();

    
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
    
        return view('view-lechon-de-cebu-statement-account', compact('viewStatementAccount', 'statementAccounts', 'sum', 'computeAll'));
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
     
        $moduleName = "Statement Of Account";
        $getStatementOfAccount = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.dr_no',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.unit',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.collection_date',
                                    'lechon_de_cebu_statement_of_accounts.check_number',
                                    'lechon_de_cebu_statement_of_accounts.check_amount',
                                    'lechon_de_cebu_statement_of_accounts.or_number',
                                    'lechon_de_cebu_statement_of_accounts.payment_method',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get()->toArray(); 
    
     
       //AllAcounts not yet paid
       $allAccounts = LechonDeCebuStatementOfAccount::where('billing_statement_id', $id)->where('status', NULL)->get()->toArray();
    
       $stat = "PAID";
       $allAccountsPaids = LechonDeCebuStatementOfAccount::where('billing_statement_id', $id)->where('status', $stat)->get()->toArray();  
        
       //count the total amount 
        $countTotalAmount = LechonDeCebuStatementOfAccount::where('id', $id)->sum('amount');

         //
        $countAmount = LechonDeCebuStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        //count the total balance if there are paid amount
        $paidAmountCount = LechonDeCebuStatementOfAccount::where('id', $id)->sum('paid_amount');
       
        //
        $countAmountOthersPaid = LechonDeCebuStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');
        
        $compute  = $paidAmountCount + $countAmountOthersPaid;

        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('edit-statement-of-account', compact('id', 'getStatementOfAccount', 'computeAll', 'allAccounts', 'allAccountsPaids', 'sum'));
    }


    //statement of account lists
    public function statementOfAccountLists(){
        $moduleName = "Statement Of Account";
        $sspOrder = "Ssp";
        $statementOfAccounts = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bs_no',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.billing_statement_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_statement_of_accounts.order', $sspOrder)
                                ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                                ->get()->toArray();
           
        $status = "PAID";
        $totalAmount = DB::table('lechon_de_cebu_statement_of_accounts')
                            ->select(
                                'lechon_de_cebu_statement_of_accounts.id',
                                'lechon_de_cebu_statement_of_accounts.user_id',
                                'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                'lechon_de_cebu_statement_of_accounts.bill_to',
                                'lechon_de_cebu_statement_of_accounts.address',
                                'lechon_de_cebu_statement_of_accounts.date',
                                'lechon_de_cebu_statement_of_accounts.branch',
                                'lechon_de_cebu_statement_of_accounts.period_cover',
                                'lechon_de_cebu_statement_of_accounts.terms',
                                'lechon_de_cebu_statement_of_accounts.transaction_date',
                                'lechon_de_cebu_statement_of_accounts.invoice_number',
                                'lechon_de_cebu_statement_of_accounts.order',
                                'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                'lechon_de_cebu_statement_of_accounts.description',
                                'lechon_de_cebu_statement_of_accounts.amount',
                                'lechon_de_cebu_statement_of_accounts.total_amount',
                                'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                'lechon_de_cebu_statement_of_accounts.status',
                                'lechon_de_cebu_statement_of_accounts.paid_amount',
                                'lechon_de_cebu_statement_of_accounts.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_statement_of_accounts.billing_statement_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->where('lechon_de_cebu_statement_of_accounts.status', '=', $status)
                            ->where('lechon_de_cebu_statement_of_accounts.order', $sspOrder)
                            ->sum('lechon_de_cebu_statement_of_accounts.total_amount');


        $totalRemainingBalance = DB::table(
                            'lechon_de_cebu_statement_of_accounts')
                            ->select(
                                'lechon_de_cebu_statement_of_accounts.id',
                                'lechon_de_cebu_statement_of_accounts.user_id',
                                'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                'lechon_de_cebu_statement_of_accounts.bill_to',
                                'lechon_de_cebu_statement_of_accounts.address',
                                'lechon_de_cebu_statement_of_accounts.date',
                                'lechon_de_cebu_statement_of_accounts.branch',
                                'lechon_de_cebu_statement_of_accounts.period_cover',
                                'lechon_de_cebu_statement_of_accounts.terms',
                                'lechon_de_cebu_statement_of_accounts.transaction_date',
                                'lechon_de_cebu_statement_of_accounts.invoice_number',
                                'lechon_de_cebu_statement_of_accounts.order',
                                'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                'lechon_de_cebu_statement_of_accounts.description',
                                'lechon_de_cebu_statement_of_accounts.amount',
                                'lechon_de_cebu_statement_of_accounts.total_amount',
                                'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                'lechon_de_cebu_statement_of_accounts.status',
                                'lechon_de_cebu_statement_of_accounts.paid_amount',
                                'lechon_de_cebu_statement_of_accounts.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_statement_of_accounts.billing_statement_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->where('lechon_de_cebu_statement_of_accounts.status', NULL)
                            ->where('lechon_de_cebu_statement_of_accounts.order', $sspOrder)
                            ->sum('lechon_de_cebu_statement_of_accounts.total_remaining_balance');

        //private order
        $pO = "Private Order";
        $privateOrders = DB::table(
                            'lechon_de_cebu_statement_of_accounts')
                            ->select(
                                'lechon_de_cebu_statement_of_accounts.id',
                                'lechon_de_cebu_statement_of_accounts.user_id',
                                'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                'lechon_de_cebu_statement_of_accounts.bs_no',
                                'lechon_de_cebu_statement_of_accounts.bill_to',
                                'lechon_de_cebu_statement_of_accounts.address',
                                'lechon_de_cebu_statement_of_accounts.date',
                                'lechon_de_cebu_statement_of_accounts.branch',
                                'lechon_de_cebu_statement_of_accounts.period_cover',
                                'lechon_de_cebu_statement_of_accounts.terms',
                                'lechon_de_cebu_statement_of_accounts.transaction_date',
                                'lechon_de_cebu_statement_of_accounts.invoice_number',
                                'lechon_de_cebu_statement_of_accounts.order',
                                'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                'lechon_de_cebu_statement_of_accounts.description',
                                'lechon_de_cebu_statement_of_accounts.amount',
                                'lechon_de_cebu_statement_of_accounts.total_amount',
                                'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                'lechon_de_cebu_statement_of_accounts.status',
                                'lechon_de_cebu_statement_of_accounts.paid_amount',
                                'lechon_de_cebu_statement_of_accounts.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_statement_of_accounts.billing_statement_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->where('lechon_de_cebu_statement_of_accounts.order', $pO)
                            ->orderBy('lechon_de_cebu_statement_of_accounts.id', 'desc')
                            ->get()->toArray();

        $totalAmountPO = DB::table('lechon_de_cebu_statement_of_accounts')
                            ->select(
                                'lechon_de_cebu_statement_of_accounts.id',
                                'lechon_de_cebu_statement_of_accounts.user_id',
                                'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                'lechon_de_cebu_statement_of_accounts.bill_to',
                                'lechon_de_cebu_statement_of_accounts.address',
                                'lechon_de_cebu_statement_of_accounts.date',
                                'lechon_de_cebu_statement_of_accounts.branch',
                                'lechon_de_cebu_statement_of_accounts.period_cover',
                                'lechon_de_cebu_statement_of_accounts.terms',
                                'lechon_de_cebu_statement_of_accounts.transaction_date',
                                'lechon_de_cebu_statement_of_accounts.invoice_number',
                                'lechon_de_cebu_statement_of_accounts.order',
                                'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                'lechon_de_cebu_statement_of_accounts.description',
                                'lechon_de_cebu_statement_of_accounts.amount',
                                'lechon_de_cebu_statement_of_accounts.total_amount',
                                'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                'lechon_de_cebu_statement_of_accounts.status',
                                'lechon_de_cebu_statement_of_accounts.paid_amount',
                                'lechon_de_cebu_statement_of_accounts.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                            ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                            ->where('lechon_de_cebu_statement_of_accounts.billing_statement_id', NULL)
                            ->where('lechon_de_cebu_codes.module_name', $moduleName)
                            ->where('lechon_de_cebu_statement_of_accounts.status', '=', $status)
                            ->where('lechon_de_cebu_statement_of_accounts.order', $pO)
                            ->sum('lechon_de_cebu_statement_of_accounts.total_amount');

        
        $totalRemainingBalancePo = DB::table(
                                'lechon_de_cebu_statement_of_accounts')
                                ->select(
                                    'lechon_de_cebu_statement_of_accounts.id',
                                    'lechon_de_cebu_statement_of_accounts.user_id',
                                    'lechon_de_cebu_statement_of_accounts.billing_statement_id',
                                    'lechon_de_cebu_statement_of_accounts.bill_to',
                                    'lechon_de_cebu_statement_of_accounts.address',
                                    'lechon_de_cebu_statement_of_accounts.date',
                                    'lechon_de_cebu_statement_of_accounts.branch',
                                    'lechon_de_cebu_statement_of_accounts.period_cover',
                                    'lechon_de_cebu_statement_of_accounts.terms',
                                    'lechon_de_cebu_statement_of_accounts.transaction_date',
                                    'lechon_de_cebu_statement_of_accounts.invoice_number',
                                    'lechon_de_cebu_statement_of_accounts.order',
                                    'lechon_de_cebu_statement_of_accounts.whole_lechon',
                                    'lechon_de_cebu_statement_of_accounts.description',
                                    'lechon_de_cebu_statement_of_accounts.amount',
                                    'lechon_de_cebu_statement_of_accounts.total_amount',
                                    'lechon_de_cebu_statement_of_accounts.total_remaining_balance',
                                    'lechon_de_cebu_statement_of_accounts.status',
                                    'lechon_de_cebu_statement_of_accounts.paid_amount',
                                    'lechon_de_cebu_statement_of_accounts.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_statement_of_accounts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_statement_of_accounts.billing_statement_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_statement_of_accounts.status', NULL)
                                ->where('lechon_de_cebu_statement_of_accounts.order', $pO)
                                ->sum('lechon_de_cebu_statement_of_accounts.total_remaining_balance');

        return view('lechon-de-cebu-statement-of-account-lists', compact('statementOfAccounts', 
         'totalAmount', 'totalRemainingBalance', 'privateOrders', 'totalAmountPO', 'totalRemainingBalancePo'));
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

    
    public function viewPerAccountDeliveryReceipt($id){
    
        $moduleName = "Delivery Receipt";
        $viewDeliveryReceipt = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get();

     


        $deliveryReceipts = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->get()->toArray();

         //count the total amount 
        $countTotalAmount = LechonDeCebuDeliveryReceipt::where('id', $id)->sum('price');
       

        //
        $countAmount = LechonDeCebuDeliveryReceipt::where('dr_id', $id)->sum('price');

        $sum  = $countTotalAmount + $countAmount;
        

        return view('view-lechon-de-cebu-billing-statement-per-acccount-delivery', compact('viewDeliveryReceipt', 'deliveryReceipts', 'sum'));
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
        //getSalesInvoiceTerminal1
        $branch = "Ssp Food Avenue Terminal 1";
        $branch2 = "Ssp Food Avenue Terminal 2";

        $moduleName = "Sales Invoice";
        $statementOfAccountT1s = DB::table(
                                'lechon_de_cebu_sales_invoices')
                                ->select(
                                    'lechon_de_cebu_sales_invoices.id',
                                    'lechon_de_cebu_sales_invoices.user_id',
                                    'lechon_de_cebu_sales_invoices.si_id',
                                    'lechon_de_cebu_sales_invoices.invoice_number',
                                    'lechon_de_cebu_sales_invoices.date',
                                    'lechon_de_cebu_sales_invoices.ordered_by',
                                    'lechon_de_cebu_sales_invoices.address',
                                    'lechon_de_cebu_sales_invoices.qty',
                                    'lechon_de_cebu_sales_invoices.total_kls',
                                    'lechon_de_cebu_sales_invoices.body',
                                    'lechon_de_cebu_sales_invoices.head_and_feet',
                                    'lechon_de_cebu_sales_invoices.item_description',
                                    'lechon_de_cebu_sales_invoices.unit_price',
                                    'lechon_de_cebu_sales_invoices.amount',
                                    'lechon_de_cebu_sales_invoices.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                                ->where('lechon_de_cebu_sales_invoices.ordered_by', $branch)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                                ->get()->toArray();
      
    
        $statementOfAccountT2s = DB::table(
                                'lechon_de_cebu_sales_invoices')
                                ->select(
                                    'lechon_de_cebu_sales_invoices.id',
                                    'lechon_de_cebu_sales_invoices.user_id',
                                    'lechon_de_cebu_sales_invoices.si_id',
                                    'lechon_de_cebu_sales_invoices.invoice_number',
                                    'lechon_de_cebu_sales_invoices.date',
                                    'lechon_de_cebu_sales_invoices.ordered_by',
                                    'lechon_de_cebu_sales_invoices.address',
                                    'lechon_de_cebu_sales_invoices.qty',
                                    'lechon_de_cebu_sales_invoices.total_kls',
                                    'lechon_de_cebu_sales_invoices.body',
                                    'lechon_de_cebu_sales_invoices.head_and_feet',
                                    'lechon_de_cebu_sales_invoices.item_description',
                                    'lechon_de_cebu_sales_invoices.unit_price',
                                    'lechon_de_cebu_sales_invoices.amount',
                                    'lechon_de_cebu_sales_invoices.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                                ->where('lechon_de_cebu_sales_invoices.ordered_by', $branch2)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                                ->get()->toArray();
      


        $moduleNameDelivery = "Delivery Receipt";
        $getAllDeliveryReceipts = DB::table(
                                'lechon_de_cebu_delivery_receipts')
                                ->select( 
                                'lechon_de_cebu_delivery_receipts.id',
                                'lechon_de_cebu_delivery_receipts.user_id',
                                'lechon_de_cebu_delivery_receipts.dr_id',
                                'lechon_de_cebu_delivery_receipts.sold_to',
                                'lechon_de_cebu_delivery_receipts.delivered_to',
                                'lechon_de_cebu_delivery_receipts.time',
                                'lechon_de_cebu_delivery_receipts.date',
                                'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                                'lechon_de_cebu_delivery_receipts.contact_person',
                                'lechon_de_cebu_delivery_receipts.mobile_num',
                                'lechon_de_cebu_delivery_receipts.qty',
                                'lechon_de_cebu_delivery_receipts.description',
                                'lechon_de_cebu_delivery_receipts.price',
                                'lechon_de_cebu_delivery_receipts.total',
                                'lechon_de_cebu_delivery_receipts.special_instruction',
                                'lechon_de_cebu_delivery_receipts.consignee_name',
                                'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                                'lechon_de_cebu_delivery_receipts.prepared_by',
                                'lechon_de_cebu_delivery_receipts.checked_by',
                                'lechon_de_cebu_delivery_receipts.received_by',
                                'lechon_de_cebu_delivery_receipts.duplicate_status',
                                'lechon_de_cebu_delivery_receipts.created_by',
                                'lechon_de_cebu_codes.lechon_de_cebu_code',
                                'lechon_de_cebu_codes.module_id',
                                'lechon_de_cebu_codes.module_code',
                                'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameDelivery)
                                ->orderBy('lechon_de_cebu_delivery_receipts.id', 'desc')
                                ->get()->toArray();


        return view('lechon-de-cebu-view-per-accounts-billing-statement', compact('user', 'statementOfAccountT1s', 'statementOfAccountT2s', 'getAllDeliveryReceipts'));
    }


    //viewBillingStatement
    public function viewBillingStatement($id){
        $moduleName = "Billing Statement";
        $viewBillingStatement = DB::table(
                                'lechon_de_cebu_billing_statements')
                                ->select(
                                    'lechon_de_cebu_billing_statements.id',
                                    'lechon_de_cebu_billing_statements.user_id',
                                    'lechon_de_cebu_billing_statements.billing_statement_id',
                                    'lechon_de_cebu_billing_statements.bill_to',
                                    'lechon_de_cebu_billing_statements.address',
                                    'lechon_de_cebu_billing_statements.dr_no',
                                    'lechon_de_cebu_billing_statements.date',
                                    'lechon_de_cebu_billing_statements.branch',
                                    'lechon_de_cebu_billing_statements.period_cover',
                                    'lechon_de_cebu_billing_statements.terms',
                                    'lechon_de_cebu_billing_statements.date_of_transaction',
                                    'lechon_de_cebu_billing_statements.invoice_number',
                                    'lechon_de_cebu_billing_statements.qty',
                                    'lechon_de_cebu_billing_statements.unit',
                                    'lechon_de_cebu_billing_statements.order',
                                    'lechon_de_cebu_billing_statements.whole_lechon',
                                    'lechon_de_cebu_billing_statements.description',
                                    'lechon_de_cebu_billing_statements.amount',
                                    'lechon_de_cebu_billing_statements.paid_amount',
                                    'lechon_de_cebu_billing_statements.created_by',
                                    'lechon_de_cebu_billing_statements.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_billing_statements.id', $id)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->get();
     
     

        $billingStatements = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-lechon-de-cebu-billing-statement', compact('viewBillingStatement', 'billingStatements', 'sum'));
    }


    //updateBilling info
    public function updateBillingInfo(Request $request, $id){

        $updateBillingOrder = LechonDeCebuBillingStatement::find($id);

        $getOtherBilling = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get();

        if(isset($getOtherBilling[0]->amount) == ""){
            $amount = $request->get('amount');
            $getOtherAmount = 0 + $amount; 

        }else{
            $amount = $request->get('amount');
            $getOtherAmount = $getOtherBilling[0]->amount + $amount; 
        
        }



        $updateBillingOrder->bill_to = $request->get('billTo');
        $updateBillingOrder->address = $request->get('address');
        $updateBillingOrder->period_cover = $request->get('periodCovered');
      
        $updateBillingOrder->terms = $request->get('terms');
        $updateBillingOrder->branch = $request->get('branch');
        $updateBillingOrder->total_amount = $getOtherAmount;
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

        $moduleName = "Billing Statement";
        $billingStatements = DB::table(
                                'lechon_de_cebu_billing_statements')
                                ->select(
                                    'lechon_de_cebu_billing_statements.id',
                                    'lechon_de_cebu_billing_statements.user_id',
                                    'lechon_de_cebu_billing_statements.billing_statement_id',
                                    'lechon_de_cebu_billing_statements.bill_to',
                                    'lechon_de_cebu_billing_statements.address',
                                    'lechon_de_cebu_billing_statements.date',
                                    'lechon_de_cebu_billing_statements.branch',
                                    'lechon_de_cebu_billing_statements.period_cover',
                                    'lechon_de_cebu_billing_statements.terms',
                                    'lechon_de_cebu_billing_statements.date_of_transaction',
                                    'lechon_de_cebu_billing_statements.invoice_number',
                                    'lechon_de_cebu_billing_statements.order',
                                    'lechon_de_cebu_billing_statements.whole_lechon',
                                    'lechon_de_cebu_billing_statements.description',
                                    'lechon_de_cebu_billing_statements.amount',
                                    'lechon_de_cebu_billing_statements.paid_amount',
                                    'lechon_de_cebu_billing_statements.created_by',
                                    'lechon_de_cebu_billing_statements.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_billing_statements.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_billing_statements.billing_statement_id', NULL)
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_billing_statements.deleted_at', NULL)
                                ->orderBy('lechon_de_cebu_billing_statements.id', 'desc')
                                ->get()->toArray();
       

        return view('lechon-de-cebu-billing-statement-lists', compact('user', 'billingStatements'));
    }


    public function addNewBilling(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = LechonDeCebuBillingStatement::find($id);
      
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $amount = $request->get('amount');

        $tot = $billingOrder->total_amount + $amount; 

          //if user selects an order
        if($request->get('choose') === "Ssp"){
            $invoiceNum = $request->get('invoiceNumber');
            $wholeLechon = 0;
            $description = $request->get('description');
            $unit = 0;

            $drNo = NULL;
            $descriptionDrNo = NULL;
            $qty = $request->get('qty');
            $body = $request->get('body');
            $headFeet = $request->get('headFeet');
            $amount = $request->get('amount');

            $tot = $billingOrder->total_amount + $amount; 

        }else{
            $invoiceNum = NULL;
            $wholeLechon = $request->get('price');
            $description = $request->get('description');
            $drNo = $request->get('drNo');
           
            $qty = $request->get('qty');
            $amount = $request->get('price');
            $unit = $request->get('unit');

            $tot = $billingOrder->total_amount + $amount;
            $body = 0;
            $headFeet = 0;
        }

    
        $addBillingStatement = new LechonDeCebuBillingStatement([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'branch'=>$request->get('branch'),
            'date_of_transaction'=>$request->get('transactionDate'),
            'invoice_number'=>$invoiceNum,
            'whole_lechon'=>$wholeLechon,
            'description'=>$description,
            'order'=>$request->get('choose'),
            'qty'=>$qty,
            'unit'=>$unit,
            'dr_no'=>$drNo,
            'body'=>$body,
            'head_and_feet'=>$headFeet,
            'amount'=>$amount,
            'created_by'=>$name,
        ]);

        $addBillingStatement->save();

        //save to table statement of account
        $addStatementAccount = new LechonDeCebuStatementOfAccount([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'branch'=>$request->get('branch'),
            'transaction_date'=>$request->get('transactionDate'),
            'invoice_number'=>$invoiceNum,
            'whole_lechon'=>$wholeLechon,
            'description'=>$description,
            'order'=>$request->get('choose'),
            'qty'=>$request->get('qty'),
            'qty'=>$qty,
            'unit'=>$unit,
            'dr_no'=>$drNo,
            'body'=>$body,
            'head_and_feet'=>$headFeet,
            'amount'=>$amount,
            'total_amount', $amount,
            'created_by'=>$name,

        ]);

        $addStatementAccount->save();

        
        $statementOrder = LechonDeCebuStatementOfAccount::find($id);
       

        //update
        $billingOrder->total_amount = $tot;
        $billingOrder->save();

        //update soa table
        $statementOrder->total_amount  = $tot;
        $statementOrder->total_remaining_balance = $tot;
        $statementOrder->save();

        Session::flash('SuccessAdd', 'Successfully added.');

        return redirect()->route('editBillingStatementLechonDeCebu', ['id'=>$id]);    
     }


    //edit billing statement 
    public function editBillingStatement($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $billingStatement = LechonDeCebuBillingStatement::find($id);
       
        $bStatements = LechonDeCebuBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //get the purchase order lists
        $getPurchaseOrders = LechonDeCebuPurchaseOrder::where('po_id', NULL)->get()->toArray();

        $moduleName = "Delivery Receipt"; 
        $drNos = DB::table(
                        'lechon_de_cebu_delivery_receipts')
                        ->select( 
                        'lechon_de_cebu_delivery_receipts.id',
                        'lechon_de_cebu_delivery_receipts.user_id',
                        'lechon_de_cebu_delivery_receipts.dr_id',
                        'lechon_de_cebu_delivery_receipts.sold_to',
                        'lechon_de_cebu_delivery_receipts.delivered_to',
                        'lechon_de_cebu_delivery_receipts.time',
                        'lechon_de_cebu_delivery_receipts.date',
                        'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                        'lechon_de_cebu_delivery_receipts.contact_person',
                        'lechon_de_cebu_delivery_receipts.mobile_num',
                        'lechon_de_cebu_delivery_receipts.qty',
                        'lechon_de_cebu_delivery_receipts.description',
                        'lechon_de_cebu_delivery_receipts.price',
                        'lechon_de_cebu_delivery_receipts.total',
                        'lechon_de_cebu_delivery_receipts.special_instruction',
                        'lechon_de_cebu_delivery_receipts.consignee_name',
                        'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                        'lechon_de_cebu_delivery_receipts.prepared_by',
                        'lechon_de_cebu_delivery_receipts.checked_by',
                        'lechon_de_cebu_delivery_receipts.received_by',
                        'lechon_de_cebu_delivery_receipts.duplicate_status',
                        'lechon_de_cebu_delivery_receipts.created_by',
                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                        'lechon_de_cebu_codes.module_id',
                        'lechon_de_cebu_codes.module_code',
                        'lechon_de_cebu_codes.module_name')
                        ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->get()->toArray();

        $moduleNameSales = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'lechon_de_cebu_sales_invoices')
                                ->select(
                                    'lechon_de_cebu_sales_invoices.id',
                                    'lechon_de_cebu_sales_invoices.user_id',
                                    'lechon_de_cebu_sales_invoices.si_id',
                                    'lechon_de_cebu_sales_invoices.invoice_number',
                                    'lechon_de_cebu_sales_invoices.date',
                                    'lechon_de_cebu_sales_invoices.ordered_by',
                                    'lechon_de_cebu_sales_invoices.address',
                                    'lechon_de_cebu_sales_invoices.qty',
                                    'lechon_de_cebu_sales_invoices.total_kls',
                                    'lechon_de_cebu_sales_invoices.body',
                                    'lechon_de_cebu_sales_invoices.head_and_feet',
                                    'lechon_de_cebu_sales_invoices.item_description',
                                    'lechon_de_cebu_sales_invoices.unit_price',
                                    'lechon_de_cebu_sales_invoices.amount',
                                    'lechon_de_cebu_sales_invoices.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                                ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameSales)
                                ->get()->toArray();
            
        
        return view('edit-billing-statement-form', compact('billingStatement', 'bStatements', 
        'getPurchaseOrders', 'drNos', 'getAllSalesInvoices'));
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
            'periodCovered'=>'required',
            'date'=>'required',
            'terms'=>'required',
            'transactionDate'=>'required',
            
        ]);

        //if user selects an order
        if($request->get('choose') === "Ssp"){
            $invoiceNum = $request->get('invoiceNumber');
            $amount = $request->get('amount');
            $description = $request->get('description');
            $unit = 0;

            $add = $amount;

            $drNo = NULL;
            $descriptionDrNo = NULL;
            $wholeLechon = 0; 
           
            $qty = $request->get('qty');
            $body = $request->get('body');
            $headFeet = $request->get('headFeet');

        }else{
            $invoiceNum = NULL;
            $wholeLechon = $request->get('wholeLechon6000');
            $description = $request->get('descriptionDrNo');
            $drNo = $request->get('drNo');
            $qty = $request->get('qty');
            $unit = $request->get('unit');

            $add = $wholeLechon; 
            $body = NULL;
            $headFeet = NULL;
        }

        //get the latest insert id query in table lechon_de_cebu_codes
        $dataReferenceNum = DB::select('SELECT id, lechon_de_cebu_code FROM lechon_de_cebu_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataReferenceNum[0]->lechon_de_cebu_code) != 0){
            //if code is not 0
            $newRefNum = $dataReferenceNum[0]->lechon_de_cebu_code +1;
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
            'invoice_number'=>$invoiceNum,
            'order'=>$request->get('choose'),
            'branch'=>$request->get('branch'),
            'terms'=>$request->get('terms'),
            'date_of_transaction'=>$request->get('transactionDate'),
            'whole_lechon'=>$wholeLechon,
            'description'=>$description,
            'dr_no'=>$drNo,
            'qty'=>$qty,
            'unit'=>$unit,
            'body'=>$body,
            'head_and_feet'=>$headFeet,
            'amount'=>$add,
            'total_amount'=>$add,
            'created_by'=>$name,
            'prepared_by'=>$name,
        ]);

        $billingStatement->save();

        $insertedId = $billingStatement->id;

        $moduleCode = "BS-";
        $moduleName = "Billing Statement";

        //save to lechon_de_cebu_codes table
        $lechonDeCebu = new LechonDeCebuCode([
            'user_id'=>$user->id,
            'lechon_de_cebu_code'=>$uRef,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $lechonDeCebu->save();
        $bsNo = $lechonDeCebu->id; 
        $bsNoId = LechonDeCebuCode::find($bsNo);
    
        $statementAccount = new LechonDeCebuStatementOfAccount([
            'user_id'=>$user->id,
            'bs_no'=>$bsNoId->lechon_de_cebu_code,
            'bill_to'=>$request->get('billTo'),
            'address'=>$request->get('address'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'invoice_number'=>$invoiceNum,
            'order'=>$request->get('choose'),
            'branch'=>$request->get('branch'),
            'terms'=>$request->get('terms'),
            'date_of_transaction'=>$request->get('transactionDate'),
            'whole_lechon'=>$wholeLechon,
            'description'=>$description,
            'dr_no'=>$drNo,
            'qty'=>$qty,
            'unit'=>$unit,
            'body'=>$body,
            'head_and_feet'=>$headFeet,
            'amount'=>$add,
            'total_amount'=>$add,
            'total_remaining_balance'=>$add,
            'created_by'=>$name,
            'prepared_by'=>$name,
        ]);

        $statementAccount->save();

        $insertedIdStatement = $statementAccount->id;

       

        $moduleCodeSOA = "SOA-";
        $moduleNameSOA = "Statement Of Account";
        

        $uRefStatement = $uRef + 1; 
        $uRefState = sprintf("%06d",$uRefStatement);

        //save to lechon_de_cebu_codes table
        $statement = new LechonDeCebuCode([
            'user_id'=>$user->id,
            'lechon_de_cebu_code'=>$uRefState,
            'module_id'=>$insertedIdStatement,
            'module_code'=>$moduleCodeSOA,
            'module_name'=>$moduleNameSOA,

        ]);
        $statement->save();
        
        return redirect()->route('editBillingStatementLechonDeCebu', ['id'=>$insertedId]);

    }

    //billing statement form
    public function billingStatementForm(){
       $moduleName = "Delivery Receipt"; 
        $drNos = DB::table(
                        'lechon_de_cebu_delivery_receipts')
                        ->select( 
                        'lechon_de_cebu_delivery_receipts.id',
                        'lechon_de_cebu_delivery_receipts.user_id',
                        'lechon_de_cebu_delivery_receipts.dr_id',
                        'lechon_de_cebu_delivery_receipts.sold_to',
                        'lechon_de_cebu_delivery_receipts.delivered_to',
                        'lechon_de_cebu_delivery_receipts.time',
                        'lechon_de_cebu_delivery_receipts.date',
                        'lechon_de_cebu_delivery_receipts.date_to_be_delivered',
                        'lechon_de_cebu_delivery_receipts.contact_person',
                        'lechon_de_cebu_delivery_receipts.mobile_num',
                        'lechon_de_cebu_delivery_receipts.qty',
                        'lechon_de_cebu_delivery_receipts.description',
                        'lechon_de_cebu_delivery_receipts.price',
                        'lechon_de_cebu_delivery_receipts.total',
                        'lechon_de_cebu_delivery_receipts.special_instruction',
                        'lechon_de_cebu_delivery_receipts.consignee_name',
                        'lechon_de_cebu_delivery_receipts.consignee_contact_num',
                        'lechon_de_cebu_delivery_receipts.prepared_by',
                        'lechon_de_cebu_delivery_receipts.checked_by',
                        'lechon_de_cebu_delivery_receipts.received_by',
                        'lechon_de_cebu_delivery_receipts.duplicate_status',
                        'lechon_de_cebu_delivery_receipts.created_by',
                        'lechon_de_cebu_codes.lechon_de_cebu_code',
                        'lechon_de_cebu_codes.module_id',
                        'lechon_de_cebu_codes.module_code',
                        'lechon_de_cebu_codes.module_name')
                        ->join('lechon_de_cebu_codes', 'lechon_de_cebu_delivery_receipts.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_delivery_receipts.dr_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->get()->toArray();
        
        //sales invoice data
        $moduleNameSales = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'lechon_de_cebu_sales_invoices')
                                ->select(
                                    'lechon_de_cebu_sales_invoices.id',
                                    'lechon_de_cebu_sales_invoices.user_id',
                                    'lechon_de_cebu_sales_invoices.si_id',
                                    'lechon_de_cebu_sales_invoices.invoice_number',
                                    'lechon_de_cebu_sales_invoices.date',
                                    'lechon_de_cebu_sales_invoices.ordered_by',
                                    'lechon_de_cebu_sales_invoices.address',
                                    'lechon_de_cebu_sales_invoices.qty',
                                    'lechon_de_cebu_sales_invoices.total_kls',
                                    'lechon_de_cebu_sales_invoices.body',
                                    'lechon_de_cebu_sales_invoices.head_and_feet',
                                    'lechon_de_cebu_sales_invoices.item_description',
                                    'lechon_de_cebu_sales_invoices.unit_price',
                                    'lechon_de_cebu_sales_invoices.amount',
                                    'lechon_de_cebu_sales_invoices.created_by',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                                ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                                ->where('lechon_de_cebu_codes.module_name', $moduleNameSales)
                                ->get()->toArray();

        return view('lechon-de-cebu-billing-statement-form', compact('drNos', 'getAllSalesInvoices'));
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
    
        $tot = $pO->total_price + $request->get('amount');
      
    
        $addPurchaseOrder = new LechonDeCebuPurchaseOrder([
            'user_id'=>$user->id,
            'po_id'=>$id,
            'quantity'=>$request->get('quantity'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);

        $addPurchaseOrder->save();

        //update
        $pO->total_price = $tot;
        $pO->save();

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
        $moduleName = "Purchase Order";
        $purchaseOrders = DB::table(
                        'lechon_de_cebu_purchase_orders')
                        ->select(
                            'lechon_de_cebu_purchase_orders.id',
                            'lechon_de_cebu_purchase_orders.user_id',
                            'lechon_de_cebu_purchase_orders.po_id',
                            'lechon_de_cebu_purchase_orders.paid_to',
                            'lechon_de_cebu_purchase_orders.address',
                            'lechon_de_cebu_purchase_orders.date',
                            'lechon_de_cebu_purchase_orders.quantity',
                            'lechon_de_cebu_purchase_orders.total_kls',
                            'lechon_de_cebu_purchase_orders.description',
                            'lechon_de_cebu_purchase_orders.unit_price',
                            'lechon_de_cebu_purchase_orders.amount',
                            'lechon_de_cebu_purchase_orders.total_price',
                            'lechon_de_cebu_purchase_orders.requested_by',
                            'lechon_de_cebu_purchase_orders.prepared_by',
                            'lechon_de_cebu_purchase_orders.checked_by',
                            'lechon_de_cebu_purchase_orders.created_by',
                            'lechon_de_cebu_purchase_orders.deleted_at',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_purchase_orders.po_id', NULL)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->where('lechon_de_cebu_purchase_orders.deleted_at', NULL)
                        ->orderBy('lechon_de_cebu_purchase_orders.id', 'desc')
                        ->get()->toArray();

        //billing statement

        
      
        return view('lechon-de-cebu-all-lists', compact('purchaseOrders'));
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
        $moduleName = "Sales Invoice";
        $getAllSalesInvoices = DB::table(
                                'lechon_de_cebu_sales_invoices')
                                ->select(
                                    'lechon_de_cebu_sales_invoices.id',
                                    'lechon_de_cebu_sales_invoices.user_id',
                                    'lechon_de_cebu_sales_invoices.si_id',
                                    'lechon_de_cebu_sales_invoices.invoice_number',
                                    'lechon_de_cebu_sales_invoices.date',
                                    'lechon_de_cebu_sales_invoices.ordered_by',
                                    'lechon_de_cebu_sales_invoices.address',
                                    'lechon_de_cebu_sales_invoices.qty',
                                    'lechon_de_cebu_sales_invoices.total_kls',
                                    'lechon_de_cebu_sales_invoices.body',
                                    'lechon_de_cebu_sales_invoices.head_and_feet',
                                    'lechon_de_cebu_sales_invoices.item_description',
                                    'lechon_de_cebu_sales_invoices.unit_price',
                                    'lechon_de_cebu_sales_invoices.amount',
                                    'lechon_de_cebu_sales_invoices.created_by',
                                    'lechon_de_cebu_sales_invoices.deleted_at',
                                    'lechon_de_cebu_codes.lechon_de_cebu_code',
                                    'lechon_de_cebu_codes.module_id',
                                    'lechon_de_cebu_codes.module_code',
                                    'lechon_de_cebu_codes.module_name')
                                ->join('lechon_de_cebu_codes', 'lechon_de_cebu_sales_invoices.id', '=', 'lechon_de_cebu_codes.module_id')
                                ->where('lechon_de_cebu_sales_invoices.si_id', NULL)
                                ->orderBy('lechon_de_cebu_sales_invoices.id', 'desc')
                                ->where('lechon_de_cebu_codes.module_name', $moduleName)
                                ->where('lechon_de_cebu_sales_invoices.deleted_at', NULL)
                                ->get()->toArray();
      
        //
        $total = LechonDeCebuSalesInvoice::where('ordered_by', '!=', NULL)->sum('amount');

        return view('lolo-pinoy-lechon-de-cebu', compact('getAllSalesInvoices','total'));
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

        //get the latest insert id query in table lechon_de_cebu_codes
        $data = DB::select('SELECT id, lechon_de_cebu_code FROM lechon_de_cebu_codes ORDER BY id DESC LIMIT 1');
        
        //if code is not zero add plus 1
         if(isset($data[0]->lechon_de_cebu_code) != 0){
            //if code is not 0
            $newNum = $data[0]->lechon_de_cebu_code +1;
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

        
        $moduleCode = "PO-";
        $moduleName = "Purchase Order";

        //save to lechon_de_cebu_codes table
        $lechonDeCebu = new LechonDeCebuCode([
            'user_id'=>$user->id,
            'lechon_de_cebu_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $lechonDeCebu->save();
         
        return redirect()->route('editLechonDeCebu', ['id'=>$insertedId]);
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
                        'lechon_de_cebu_purchase_orders')
                        ->select(
                            'lechon_de_cebu_purchase_orders.id',
                            'lechon_de_cebu_purchase_orders.user_id',
                            'lechon_de_cebu_purchase_orders.po_id',
                            'lechon_de_cebu_purchase_orders.paid_to',
                            'lechon_de_cebu_purchase_orders.address',
                            'lechon_de_cebu_purchase_orders.date',
                            'lechon_de_cebu_purchase_orders.quantity',
                            'lechon_de_cebu_purchase_orders.total_kls',
                            'lechon_de_cebu_purchase_orders.description',
                            'lechon_de_cebu_purchase_orders.unit_price',
                            'lechon_de_cebu_purchase_orders.amount',
                            'lechon_de_cebu_purchase_orders.total_price',
                            'lechon_de_cebu_purchase_orders.requested_by',
                            'lechon_de_cebu_purchase_orders.prepared_by',
                            'lechon_de_cebu_purchase_orders.checked_by',
                            'lechon_de_cebu_purchase_orders.created_by',
                            'lechon_de_cebu_purchase_orders.deleted_at',
                            'lechon_de_cebu_codes.lechon_de_cebu_code',
                            'lechon_de_cebu_codes.module_id',
                            'lechon_de_cebu_codes.module_code',
                            'lechon_de_cebu_codes.module_name')
                        ->leftJoin('lechon_de_cebu_codes', 'lechon_de_cebu_purchase_orders.id', '=', 'lechon_de_cebu_codes.module_id')
                        ->where('lechon_de_cebu_purchase_orders.id', $id)
                        ->where('lechon_de_cebu_codes.module_name', $moduleName)
                        ->get();
   

        $pOrders = LechonDeCebuPurchaseOrder::where('po_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = LechonDeCebuPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = LechonDeCebuPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;
 

        return view('view-lechon-de-cebu-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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
        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);

        $pOrders = LechonDeCebuPurchaseOrder::where('po_id', $id)->get()->toArray();

        //get users
        $getUsers = User::get()->toArray();
       

        return view('edit-lechon-de-cebu-purchase-order', compact('purchaseOrder', 'pOrders', 'getUsers'));
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

    public function destroyUtility($id){
        $utility = LechonDeCebuUtility::find($id);
        $utility->delete();
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



    public function destroySI($id){
        $salesInvoice = LechonDeCebuSalesInvoice::find($id);
        $salesInvoice->delete();
    }

    //delete sales invoice 
    public function destroySalesInvoice(Request $request, $id){
        $siId = LechonDeCebuSalesInvoice::find($request->siId);

        $salesInvoice = LechonDeCebuSalesInvoice::find($id);
        $getAmount = $siId->total_amount - $salesInvoice->amount;

        $siId->total_amount = $getAmount;
        $siId->save();

        $salesInvoice->delete();
    }

    public function destroyDR($id){
        $deliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);
        $deliveryReceipt->delete();
    }

    //delete delivery receipt
    public function destroyDeliveryReceipt(Request $request, $id){
        $drId = LechonDeCebuDeliveryReceipt::find($request->drId);
 
        $deliveryReceipt = LechonDeCebuDeliveryReceipt::find($id);
        $getAmount = $drId->total - $deliveryReceipt->price;

        $drId->total = $getAmount; 
        $drId->save();

        $deliveryReceipt->delete();
    }





    //delete payment voucher 
    public function destroyPaymentVoucher($id){
        $paymentVoucher = LechonDeCebuPaymentVoucher::find($id);
        $paymentVoucher->delete();
    }


    public function destroyBillingDataStatement(Request $request, $id){
        
        $billStatement = LechonDeCebuBillingStatement::find($request->billingStatementId);

        $billingStatement = LechonDeCebuBillingStatement::find($id);
    
        $getAmount = $billStatement->total_amount - $billingStatement->amount;
        $billStatement->total_amount = $getAmount;
        $billStatement->save();

        $billingStatement->delete();

         //update statement of account table
         $statementAccount = LechoDeCebuStatementOfAccount::find($request->billingStatementId);

         $stateAccount = LechoDeCebuStatementOfAccount::find($id);
 
         $getStateAmount = $statementAccount->total_amount - $stateAccount->amount; 
         $statementAccount->total_amount = $getStateAmount;
         $statementAccount->total_remaining_balance = $getStateAmount;
         $statementAccount->save();
 
         $stateAccount->delete();

    }
   


    //delete billing statement
    public function destroyBillingStatement($id){
        $billingStatement = LechonDeCebuBillingStatement::find($id);
        $billingStatement->delete();

        //delete SOA 
        $soa = LechonDeCebuStatementOfAccount::find($id);
        $soa->delete();
    }

    public function destroyPO($id){
        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);
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
        $poId = LechonDeCebuPurchaseOrder::find($request->poId);

        $purchaseOrder = LechonDeCebuPurchaseOrder::find($id);
        $getAmount = $poId->total_price - $purchaseOrder->amount;

        $poId->total_price = $getAmount;
        $poId->save();

        $purchaseOrder->delete();
    }
}
