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
use App\LoloPinoyGrillBranchesUtility;
use App\LoloPinoyGrillCommissaryRawMaterial;
use App\LoloPinoyGrillBranchesSalesForm;
use App\LoloPinoyGrillBranchesPettyCash;
use Hash;
use App\LoloPinoyGrillBranchesCode;
use App\LoloPinoyGrillBranchesSupplier;
use App\LoloPinoyGrillBranchesStoreStock;
use App\LoloPinoyGrillBranchesStoreStockProduct;

class LoloPinoyGrillBranchesController extends Controller
{   
    public function addSenior(Request $request, $id){    
        $addSenior = LoloPinoyGrillBranchesSalesForm::withTrashed()->find($id);
        
    
        if(!empty($request->get('seniorAmount'))){
            $totalAmountSales = $addSenior->total_amount_of_sales;

            //compute vat exempt sales set to 300 pesos
            $vat = 300 / 1.12;
            $vatExempt = round($vat, 2);

             //Senior Citizen Discount = VAT Exempt Sale x 20%
             $senior = 300 * 0.20;
             $seniorAmount = number_format($senior, 2);

            //compute the vat and senior 
            $vatSenior = $vatExempt - $seniorAmount;

            $getTotalBill = $totalAmountSales - $vatSenior;

            //get subtotal - senior discount
            $getTotalAmount = $totalAmountSales - $getTotalBill;

            $addSenior->senior_citizen_label = $request->get('senior');
            $addSenior->senior_citizen_id = $request->get('seniorCitizenId');
            $addSenior->senior_citizen_name = $request->get('seniorCitizenName');
            $addSenior->senior_amount = $getTotalBill; 
            $addSenior->senior_discount = $getTotalBill; 
            $addSenior->total = $getTotalAmount; 
            $addSenior->save();
            
            return redirect()->route('detailTransactions', ['id'=>$request->get('mainId')]);



        }else{
            $totalAmountSales = $addSenior->total_amount_of_sales;

            //compute vat exempt sales
            $vat = $totalAmountSales / 1.12;
            $vatExempt = round($vat, 2);  
    
            //Senior Citizen Discount = VAT Exempt Sale x 20%
            $senior = $vatExempt * 0.20;

            $seniorAmount = number_format($senior, 2);
          
            //compute the vat and senior 
            $vatSenior = $vatExempt - $seniorAmount;
            
            $getTotalBill = $totalAmountSales - $vatSenior;

            //get subtotal - senior discount
            $getTotalAmount = $totalAmountSales - $getTotalBill;
        
            $addSenior->senior_citizen_label = $request->get('senior');
            $addSenior->senior_citizen_id = $request->get('seniorCitizenId');
            $addSenior->senior_citizen_name = $request->get('seniorCitizenName');
            $addSenior->senior_amount = $getTotalBill; 
            $addSenior->senior_discount = $getTotalBill; 
            $addSenior->total = $getTotalAmount; 
            $addSenior->save();
            
            return redirect()->route('detailTransactions', ['id'=>$request->get('mainId')]);
          
        }

       
    }

    public function printReceipt(Request $request, $id){
        $branch = $request->session()->get('sessionBranch');
        $getBranchItem = DB::table(
                        'lolo_pinoy_grill_branches_sales_forms')
                        ->select(
                        'lolo_pinoy_grill_branches_sales_forms.id',
                        'lolo_pinoy_grill_branches_sales_forms.user_id',
                        'lolo_pinoy_grill_branches_sales_forms.sf_id',
                        'lolo_pinoy_grill_branches_sales_forms.invoice_number',
                        'lolo_pinoy_grill_branches_sales_forms.ordered_by',
                        'lolo_pinoy_grill_branches_sales_forms.table_no',
                        'lolo_pinoy_grill_branches_sales_forms.date',
                        'lolo_pinoy_grill_branches_sales_forms.branch',
                        'lolo_pinoy_grill_branches_sales_forms.qty',
                        'lolo_pinoy_grill_branches_sales_forms.item_description',
                        'lolo_pinoy_grill_branches_sales_forms.amount',
                        'lolo_pinoy_grill_branches_sales_forms.total_discounts_seniors_pwds',
                        'lolo_pinoy_grill_branches_sales_forms.total_amount_of_sales',
                        'lolo_pinoy_grill_branches_sales_forms.senior_citizen_id',
                        'lolo_pinoy_grill_branches_sales_forms.senior_citizen_name',
                        'lolo_pinoy_grill_branches_sales_forms.senior_citizen_label',
                        'lolo_pinoy_grill_branches_sales_forms.senior_amount',
                        'lolo_pinoy_grill_branches_sales_forms.gift_cert',
                        'lolo_pinoy_grill_branches_sales_forms.cash_amount',
                        'lolo_pinoy_grill_branches_sales_forms.change',
                        'lolo_pinoy_grill_branches_sales_forms.created_by',
                        'lolo_pinoy_grill_branches_sales_forms.flag',
                        'lolo_pinoy_grill_branches_sales_forms.deleted_at')
                        ->where('lolo_pinoy_grill_branches_sales_forms.branch', $branch)
                        ->where('lolo_pinoy_grill_branches_sales_forms.id', $id)
                        ->where('lolo_pinoy_grill_branches_sales_forms.deleted_at', NULL)
                        ->get();
        

        $getOtherItems = DB::table(
                        'lolo_pinoy_grill_branches_sales_forms')
                        ->select(
                        'lolo_pinoy_grill_branches_sales_forms.id',
                        'lolo_pinoy_grill_branches_sales_forms.user_id',
                        'lolo_pinoy_grill_branches_sales_forms.sf_id',
                        'lolo_pinoy_grill_branches_sales_forms.invoice_number',
                        'lolo_pinoy_grill_branches_sales_forms.ordered_by',
                        'lolo_pinoy_grill_branches_sales_forms.table_no',
                        'lolo_pinoy_grill_branches_sales_forms.date',
                        'lolo_pinoy_grill_branches_sales_forms.branch',
                        'lolo_pinoy_grill_branches_sales_forms.qty',
                        'lolo_pinoy_grill_branches_sales_forms.item_description',
                        'lolo_pinoy_grill_branches_sales_forms.amount',
                        'lolo_pinoy_grill_branches_sales_forms.total_discounts_seniors_pwds',
                        'lolo_pinoy_grill_branches_sales_forms.total_amount_of_sales',
                        'lolo_pinoy_grill_branches_sales_forms.senior_citizen_id',
                        'lolo_pinoy_grill_branches_sales_forms.senior_citizen_name',
                        'lolo_pinoy_grill_branches_sales_forms.senior_citizen_label',
                        'lolo_pinoy_grill_branches_sales_forms.senior_amount',
                        'lolo_pinoy_grill_branches_sales_forms.gift_cert',
                        'lolo_pinoy_grill_branches_sales_forms.cash_amount',
                        'lolo_pinoy_grill_branches_sales_forms.change',
                        'lolo_pinoy_grill_branches_sales_forms.created_by',
                        'lolo_pinoy_grill_branches_sales_forms.flag',
                        'lolo_pinoy_grill_branches_sales_forms.deleted_at')
                        ->where('lolo_pinoy_grill_branches_sales_forms.branch', $branch)
                        ->where('lolo_pinoy_grill_branches_sales_forms.sf_id', $id)
                        ->where('lolo_pinoy_grill_branches_sales_forms.deleted_at', NULL)
                        ->get()->toArray();

     
        $customPaper = array(0,0,200,76);
        $pdf = PDF::loadView('printReceipt',  compact('getBranchItem', 'getOtherItems', 'branch'))->setPaper($customPaper, 'landscape');
        $getDateToday = date("Y-m-d");

        return $pdf->download('official-receipt-'.$getDateToday.'.pdf');
    }

    public function voidItemSecond(Request $request, $id){
          
        $getSalesInfo = LoloPinoyGrillBranchesSalesForm::where('id', $id)->get()->toArray();
        $getItem = explode("-", $getSalesInfo[0]['item_description']);
        $getItemExp = $getItem[0];
       

        $qty = $getSalesInfo[0]['qty']; 

        $branch = $request->session()->get('sessionBranch');
       
        if($getSalesInfo[0]['flag'] === "Foods"){
            $flag = "Foods";
            $getBranchItem = DB::table(
                                    'lolo_pinoy_grill_branches_store_stocks')
                                    ->select(
                                    'lolo_pinoy_grill_branches_store_stocks.id',
                                    'lolo_pinoy_grill_branches_store_stocks.user_id',
                                    'lolo_pinoy_grill_branches_store_stocks.date',
                                    'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                    'lolo_pinoy_grill_branches_store_stocks.supplier',
                                    'lolo_pinoy_grill_branches_store_stocks.product_name',
                                    'lolo_pinoy_grill_branches_store_stocks.price',
                                    'lolo_pinoy_grill_branches_store_stocks.qty',
                                    'lolo_pinoy_grill_branches_store_stocks.unit',
                                    'lolo_pinoy_grill_branches_store_stocks.product_in',
                                    'lolo_pinoy_grill_branches_store_stocks.product_out',
                                    'lolo_pinoy_grill_branches_store_stocks.amount',
                                    'lolo_pinoy_grill_branches_store_stocks.branch',
                                    'lolo_pinoy_grill_branches_store_stocks.flag',
                                    'lolo_pinoy_grill_branches_store_stocks.created_by',
                                    'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                    'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                    ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                    ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branch)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flag)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.product_name', $getItemExp)
                                    ->get()->toArray();

        
            $computeProductIn = $qty + $getBranchItem[0]->product_in;

            //update the product in. add
            $updateProductItem = LoloPinoyGrillBranchesStoreStock::find($getBranchItem[0]->id);
            $updateProductItem->product_in = $computeProductIn; 
            $updateProductItem->save();
    
            //delete the transction
            $deleteTransaction = LoloPinoyGrillBranchesSalesForm::find($id);
            $deleteTransaction->delete();
    
            //get the main id Item
            $getMainItem = LoloPinoyGrillBranchesSalesForm::where('id', $request->get('mainId'))->where('deleted_at', NULL)->sum('amount');
            
            $getOtherItem = LoloPinoyGrillBranchesSalesForm::where('sf_id', $request->get('mainId'))->where('deleted_at', NULL)->sum('amount');
            
    
            $computeMainId = $getMainItem + $getOtherItem; 
            
            //update the main food item id
            $updateMainFoodItem = LoloPinoyGrillBranchesSalesForm::find($request->get('mainId'));
            $updateMainFoodItem->total_amount_of_sales = $computeMainId;
            $updateMainFoodItem->save();
    
            
        
            return redirect()->route('transactionListDetailsLoloPinoyGrillBranches', ['id'=>$request->get('mainId')]);

    
        }else{
            $flag = "Drinks";
            $getBranchItem = DB::table(
                        'lolo_pinoy_grill_branches_store_stocks')
                        ->select(
                        'lolo_pinoy_grill_branches_store_stocks.id',
                        'lolo_pinoy_grill_branches_store_stocks.user_id',
                        'lolo_pinoy_grill_branches_store_stocks.date',
                        'lolo_pinoy_grill_branches_store_stocks.dr_no',
                        'lolo_pinoy_grill_branches_store_stocks.supplier',
                        'lolo_pinoy_grill_branches_store_stocks.product_name',
                        'lolo_pinoy_grill_branches_store_stocks.price',
                        'lolo_pinoy_grill_branches_store_stocks.qty',
                        'lolo_pinoy_grill_branches_store_stocks.unit',
                        'lolo_pinoy_grill_branches_store_stocks.product_in',
                        'lolo_pinoy_grill_branches_store_stocks.product_out',
                        'lolo_pinoy_grill_branches_store_stocks.amount',
                        'lolo_pinoy_grill_branches_store_stocks.branch',
                        'lolo_pinoy_grill_branches_store_stocks.flag',
                        'lolo_pinoy_grill_branches_store_stocks.created_by',
                        'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                        'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                        ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                        ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branch)
                        ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flag)
                        ->where('lolo_pinoy_grill_branches_store_stocks.product_name', $getItemExp)
                        ->get()->toArray();


        $computeProductIn = $qty + $getBranchItem[0]->product_in;

        //update the product in. add
        $updateProductItem = LoloPinoyGrillBranchesStoreStock::find($getBranchItem[0]->id);
        $updateProductItem->product_in = $computeProductIn; 
        $updateProductItem->save();

        //delete the transction
        $deleteTransaction = LoloPinoyGrillBranchesSalesForm::find($id);
        $deleteTransaction->delete();

        //get the main id Item
        $getMainItem = LoloPinoyGrillBranchesSalesForm::where('id', $request->get('mainId'))->where('deleted_at', NULL)->sum('amount');
        
        $getOtherItem = LoloPinoyGrillBranchesSalesForm::where('sf_id', $request->get('mainId'))->where('deleted_at', NULL)->sum('amount');
        

        $computeMainId = $getMainItem + $getOtherItem; 
        
        //update the main food item id
        $updateMainFoodItem = LoloPinoyGrillBranchesSalesForm::find($request->get('mainId'));
        $updateMainFoodItem->total_amount_of_sales = $computeMainId;
        $updateMainFoodItem->save();

        
    
        return redirect()->route('transactionListDetailsLoloPinoyGrillBranches', ['id'=>$request->get('mainId')]);

    
        }
       
       
    }

    public function voidItem(Request $request, $id){
        $getSalesInfo = LoloPinoyGrillBranchesSalesForm::where('id', $id)->get()->toArray();
      
        $getItem = explode("-", $getSalesInfo[0]['item_description']);
        $getItemExp = $getItem[0];
       
        $qty = $getSalesInfo[0]['qty']; 
     
        $branch = $request->session()->get('sessionBranch');

        if($getSalesInfo[0]['flag'] === "Foods"){
            $flag = "Foods";
            $getBranchItem = DB::table(
                                    'lolo_pinoy_grill_branches_store_stocks')
                                    ->select(
                                    'lolo_pinoy_grill_branches_store_stocks.id',
                                    'lolo_pinoy_grill_branches_store_stocks.user_id',
                                    'lolo_pinoy_grill_branches_store_stocks.date',
                                    'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                    'lolo_pinoy_grill_branches_store_stocks.supplier',
                                    'lolo_pinoy_grill_branches_store_stocks.product_name',
                                    'lolo_pinoy_grill_branches_store_stocks.price',
                                    'lolo_pinoy_grill_branches_store_stocks.qty',
                                    'lolo_pinoy_grill_branches_store_stocks.unit',
                                    'lolo_pinoy_grill_branches_store_stocks.product_in',
                                    'lolo_pinoy_grill_branches_store_stocks.product_out',
                                    'lolo_pinoy_grill_branches_store_stocks.amount',
                                    'lolo_pinoy_grill_branches_store_stocks.branch',
                                    'lolo_pinoy_grill_branches_store_stocks.flag',
                                    'lolo_pinoy_grill_branches_store_stocks.created_by',
                                    'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                    'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                    ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                    ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branch)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flag)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.product_name', $getItemExp)
                                    ->get()->toArray();
    
           
            $computeProductIn = $qty + $getBranchItem[0]->product_in;
    
            //update the product in. add
            $updateProductItem = LoloPinoyGrillBranchesStoreStock::find($getBranchItem[0]->id);
            $updateProductItem->product_in = $computeProductIn; 
            $updateProductItem->save();
    
        
            //get the main id Item
            $getMainItem = LoloPinoyGrillBranchesSalesForm::where('id', $request->get('mainId'))->where('deleted_at', '!=', NULL)->sum('amount');

            //get the query or the other food items amount
            $getOtherItemAmount = LoloPinoyGrillBranchesSalesForm::where('sf_id', $id)->where('deleted_at', NULL)->sum('amount');
        
    
            $computeMainId = $getMainItem + $getOtherItemAmount; 
           

            //update the main food item id
            $updateMainFoodItem = LoloPinoyGrillBranchesSalesForm::find($id);
            $updateMainFoodItem->total_amount_of_sales = $computeMainId;
            $updateMainFoodItem->save();
            
            //delete the transction
            $deleteTransaction = LoloPinoyGrillBranchesSalesForm::find($id);
            $deleteTransaction->delete(); 
    
       
    
    
            return redirect()->route('transactionListDetailsLoloPinoyGrillBranches', ['id'=>$id]);
    

        }else{
            $flag = "Drinks";
            $getBranchItem = DB::table(
                                    'lolo_pinoy_grill_branches_store_stocks')
                                    ->select(
                                    'lolo_pinoy_grill_branches_store_stocks.id',
                                    'lolo_pinoy_grill_branches_store_stocks.user_id',
                                    'lolo_pinoy_grill_branches_store_stocks.date',
                                    'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                    'lolo_pinoy_grill_branches_store_stocks.supplier',
                                    'lolo_pinoy_grill_branches_store_stocks.product_name',
                                    'lolo_pinoy_grill_branches_store_stocks.price',
                                    'lolo_pinoy_grill_branches_store_stocks.qty',
                                    'lolo_pinoy_grill_branches_store_stocks.unit',
                                    'lolo_pinoy_grill_branches_store_stocks.product_in',
                                    'lolo_pinoy_grill_branches_store_stocks.product_out',
                                    'lolo_pinoy_grill_branches_store_stocks.amount',
                                    'lolo_pinoy_grill_branches_store_stocks.branch',
                                    'lolo_pinoy_grill_branches_store_stocks.flag',
                                    'lolo_pinoy_grill_branches_store_stocks.created_by',
                                    'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                    'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                    ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                    ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branch)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flag)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.product_name', $getItemExp)
                                    ->get()->toArray();
    
           
            $computeProductIn = $qty + $getBranchItem[0]->product_in;
    
            //update the product in. add
            $updateProductItem = LoloPinoyGrillBranchesStoreStock::find($getBranchItem[0]->id);
            $updateProductItem->product_in = $computeProductIn; 
            $updateProductItem->save();
    
    
             //get the main id Item
             $getMainItem = LoloPinoyGrillBranchesSalesForm::where('id', $request->get('mainId'))->where('deleted_at', '!=', NULL)->sum('amount');

            //get the query or the other food items amount
            $getOtherItemAmount = LoloPinoyGrillBranchesSalesForm::where('sf_id', $id)->where('deleted_at', NULL)->sum('amount');
        
            $computeMainId = $getMainItem + $getOtherItemAmount; 
    
            //update the main food item id
            $updateMainFoodItem = LoloPinoyGrillBranchesSalesForm::find($id);
            $updateMainFoodItem->total_amount_of_sales = $computeMainId;
            $updateMainFoodItem->save();
    
    
            //delete the transction
            $deleteTransaction = LoloPinoyGrillBranchesSalesForm::find($id);
            $deleteTransaction->delete();
    
            return redirect()->route('transactionListDetailsLoloPinoyGrillBranches', ['id'=>$id]);
    
        }
       

    }

    public function transactionListAll(Request $request){
        $data =  $request->session()->get('sessionBranch');

        $getTransactionBranches = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)
                                ->where('branch', $data)
                                ->get()->toArray();

        $sum = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)
                ->where('branch', $data)
                ->sum('total_amount_of_sales');
        return view('lolo-pinoy-grill-branches-transaction-list-all', compact('data', 'getTransactionBranches', 'sum'));
    }

    public function transactionListDetails(Request $request, $id){
        $data =  $request->session()->get('sessionBranch');

        $getOrder = DB::table(
                        'lolo_pinoy_grill_branches_sales_forms')
                        ->select(
                        'lolo_pinoy_grill_branches_sales_forms.id',
                        'lolo_pinoy_grill_branches_sales_forms.user_id',
                        'lolo_pinoy_grill_branches_sales_forms.sf_id',
                        'lolo_pinoy_grill_branches_sales_forms.invoice_number',
                        'lolo_pinoy_grill_branches_sales_forms.ordered_by',
                        'lolo_pinoy_grill_branches_sales_forms.table_no',
                        'lolo_pinoy_grill_branches_sales_forms.date',
                        'lolo_pinoy_grill_branches_sales_forms.branch',
                        'lolo_pinoy_grill_branches_sales_forms.qty',
                        'lolo_pinoy_grill_branches_sales_forms.item_description',
                        'lolo_pinoy_grill_branches_sales_forms.amount',
                        'lolo_pinoy_grill_branches_sales_forms.total_discounts_seniors_pwds',
                        'lolo_pinoy_grill_branches_sales_forms.total_amount_of_sales',
                        'lolo_pinoy_grill_branches_sales_forms.senior_citizen_id',
                        'lolo_pinoy_grill_branches_sales_forms.senior_citizen_label',
                        'lolo_pinoy_grill_branches_sales_forms.senior_amount',
                        'lolo_pinoy_grill_branches_sales_forms.gift_cert',
                        'lolo_pinoy_grill_branches_sales_forms.cash_amount',
                        'lolo_pinoy_grill_branches_sales_forms.change',
                        'lolo_pinoy_grill_branches_sales_forms.deleted_at')
                        ->where('lolo_pinoy_grill_branches_sales_forms.id', $id)
                        ->get();
       
        $getTransactions = DB::table(
                            'lolo_pinoy_grill_branches_sales_forms')
                            ->select(
                            'lolo_pinoy_grill_branches_sales_forms.id',
                            'lolo_pinoy_grill_branches_sales_forms.user_id',
                            'lolo_pinoy_grill_branches_sales_forms.sf_id',
                            'lolo_pinoy_grill_branches_sales_forms.invoice_number',
                            'lolo_pinoy_grill_branches_sales_forms.ordered_by',
                            'lolo_pinoy_grill_branches_sales_forms.table_no',
                            'lolo_pinoy_grill_branches_sales_forms.date',
                            'lolo_pinoy_grill_branches_sales_forms.branch',
                            'lolo_pinoy_grill_branches_sales_forms.qty',
                            'lolo_pinoy_grill_branches_sales_forms.item_description',
                            'lolo_pinoy_grill_branches_sales_forms.amount',
                            'lolo_pinoy_grill_branches_sales_forms.total_discounts_seniors_pwds',
                            'lolo_pinoy_grill_branches_sales_forms.total_amount_of_sales',
                            'lolo_pinoy_grill_branches_sales_forms.senior_citizen_id',
                            'lolo_pinoy_grill_branches_sales_forms.senior_citizen_label',
                            'lolo_pinoy_grill_branches_sales_forms.senior_amount',
                            'lolo_pinoy_grill_branches_sales_forms.gift_cert',
                            'lolo_pinoy_grill_branches_sales_forms.cash_amount',
                            'lolo_pinoy_grill_branches_sales_forms.deleted_at',
                            'lolo_pinoy_grill_branches_sales_forms.change')
                            ->where('lolo_pinoy_grill_branches_sales_forms.sf_id', $id)
                            ->get()->toArray();
           
            
        return view('lolo-pinoy-grill-branches-transaction-list-details', compact('data', 'getOrder', 'getTransactions'));
    }
    
    public function updateDeliveryIn(Request $request){
        $updateDeliveryIn  = LoloPinoyGrillBranchesStoreStock::find($request->id);
        $updateDeliveryIn->date = $request->dateUpdate;
        $updateDeliveryIn->dr_no = $request->drNoUpdate;
        $updateDeliveryIn->supplier = $request->supplierUpdate;
        $updateDeliveryIn->product_name = $request->productNameUpdate;
        $updateDeliveryIn->price = $request->priceUpdate;
        $updateDeliveryIn->qty = $request->qtyUpdate;
        $updateDeliveryIn->product_in = $request->productInUpdate;
        $updateDeliveryIn->unit = $request->unitUpdate; 
        $updateDeliveryIn->amount = $request->amountUpdate;
        $updateDeliveryIn->save();

        return response()->json('Success: successfully updated');
    }

    public function logoutDeliveryIn(Request $request){
        $request->session()->forget('sessionDeliveryInTransaction');
        return redirect()->route('deliveryInTransactionLpGrillBranches');
    }
    
    public function storeDeliveryIn(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //
        $dataProductId = DB::select('SELECT id, product_id_no FROM lolo_pinoy_grill_branches_store_stock_products ORDER BY id DESC LIMIT 1');

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

        
            if($request->flag === "Foods"){
                $flag = $request->flag;
            }else{
                $flag = $request->flag;
            }
    
            $addDeliveryIn = new LoloPinoyGrillBranchesStoreStock([
                'user_id'=>$user->id,
                'date'=>$request->date,
                'dr_no'=>$request->drNo,
                'supplier'=>$request->supplier,
                'product_name'=>$request->productName,
                'price'=>$request->price,
                'qty'=>$request->qty,
                'unit'=>$request->unit,
                'product_in'=>$request->productIn,
                'branch'=>$request->branchName,
                'flag'=>$flag,
                'amount'=>$request->amount,
                'created_by'=>$name,
            ]);
            $addDeliveryIn->save();
            $insertedId = $addDeliveryIn->id;

            //save to store stock products
            $addProductId = new LoloPinoyGrillBranchesStoreStockProduct([
                'store_stock_id'=>$insertedId,
                'product_id_no'=>$uProd,
            ]);

            $addProductId->save();

            return response()->json('Success: successfuly added delivery in');

   
    }

    public function deliveryInTransactionBranch(Request $request, $type){
        $data = $request->session()->get('sessionDeliveryInTransaction');
        if(empty($data)){
            return redirect()->route('deliveryInTransactionLpGrillBranches');
        }else{
            $branch = $request->session()->get('sessionDeliveryInTransaction');
            $flag = "Foods";
            $getDeliveryBranches = DB::table(
                                    'lolo_pinoy_grill_branches_store_stocks')
                                    ->select(
                                    'lolo_pinoy_grill_branches_store_stocks.id',
                                    'lolo_pinoy_grill_branches_store_stocks.user_id',
                                    'lolo_pinoy_grill_branches_store_stocks.date',
                                    'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                    'lolo_pinoy_grill_branches_store_stocks.supplier',
                                    'lolo_pinoy_grill_branches_store_stocks.product_name',
                                    'lolo_pinoy_grill_branches_store_stocks.price',
                                    'lolo_pinoy_grill_branches_store_stocks.qty',
                                    'lolo_pinoy_grill_branches_store_stocks.unit',
                                    'lolo_pinoy_grill_branches_store_stocks.product_in',
                                    'lolo_pinoy_grill_branches_store_stocks.product_out',
                                    'lolo_pinoy_grill_branches_store_stocks.amount',
                                    'lolo_pinoy_grill_branches_store_stocks.branch',
                                    'lolo_pinoy_grill_branches_store_stocks.flag',
                                    'lolo_pinoy_grill_branches_store_stocks.created_by',
                                    'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                    'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                    ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                    ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branch)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flag)
                                    ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                    ->get()->toArray();

            $flagDrinks = "Drinks";
            $getDeliveryBranchDrinks = DB::table(
                                    'lolo_pinoy_grill_branches_store_stocks')
                                    ->select(
                                    'lolo_pinoy_grill_branches_store_stocks.id',
                                    'lolo_pinoy_grill_branches_store_stocks.user_id',
                                    'lolo_pinoy_grill_branches_store_stocks.date',
                                    'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                    'lolo_pinoy_grill_branches_store_stocks.supplier',
                                    'lolo_pinoy_grill_branches_store_stocks.product_name',
                                    'lolo_pinoy_grill_branches_store_stocks.price',
                                    'lolo_pinoy_grill_branches_store_stocks.qty',
                                    'lolo_pinoy_grill_branches_store_stocks.unit',
                                    'lolo_pinoy_grill_branches_store_stocks.product_in',
                                    'lolo_pinoy_grill_branches_store_stocks.product_out',
                                    'lolo_pinoy_grill_branches_store_stocks.amount',
                                    'lolo_pinoy_grill_branches_store_stocks.branch',
                                    'lolo_pinoy_grill_branches_store_stocks.flag',
                                    'lolo_pinoy_grill_branches_store_stocks.created_by',
                                    'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                    'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                    ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                    ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branch)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagDrinks)
                                    ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                    ->get()->toArray();
    
            return view('lolo-pinoy-grill-branches-delivery-in-transaction-branch', compact(
                'data','getDeliveryBranches', 'getDeliveryBranchDrinks'));
        }
    }

    public function loginDeliveryTransaction(Request $request){
        //get the data from the users table
        $getBranch = User::where('select_branch', $request->get('selectBranch'))->get()->toArray();

        if($getBranch == NULL){
            $findAccess = User::find(isset($getBranch[0]['id']));
            return redirect()->route('deliveryInTransactionLpGrillBranches')->with('noAccess', 'No Access'); 
        }else{
            $findAccess = User::find($getBranch[0]['id']);

            $password = $request->get('password');
            //check if  password is the same 
            if(Hash::check($password, $findAccess['password'])){
                $stat = "1";
                $updateStatus = User::find($findAccess['id']);
                $updateStatus->status = $stat;
                $updateStatus->save();
                
                $value = $findAccess['select_branch'];
                Session::put('sessionDeliveryInTransaction', $value);

                //redirect to what branch selected in login
                return redirect()->route('deliveryInTransactionBranch', ['branch'=>$findAccess['select_branch']]);

            }else{
                $request->session()->flash('error', 'Password does not match.');
                return redirect()->route('deliveryInTransactionLpGrillBranches');
            }

        }

    }

    public function deliveryInTransaction(Request $request){
        $data = $request->session()->get('sessionDeliveryInTransaction');
        if(empty($data)){
             return view('lolo-pinoy-grill-branches-delivery-in-transaction', compact('data'));   
        }else{
             return redirect()->route('deliveryInTransactionBranch', ['type'=>$data]);
         
        }
       
    }

    public function printSupplier($id){
        $viewSupplier = LoloPinoyGrillBranchesSupplier::where('id', $id)->get();

        $printSuppliers = DB::table(
            'lolo_pinoy_grill_branches_payment_vouchers')
            ->select( 
            'lolo_pinoy_grill_branches_payment_vouchers.id',
            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
            'lolo_pinoy_grill_branches_payment_vouchers.date',
            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
            'lolo_pinoy_grill_branches_payment_vouchers.amount',
            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
            'lolo_pinoy_grill_branches_payment_vouchers.voucher_ref_number',
            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
            'lolo_pinoy_grill_branches_payment_vouchers.category',
            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
            'lolo_pinoy_grill_branches_payment_vouchers.status',
            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
            'lolo_pinoy_grill_branches_payment_vouchers.supplier_name',
            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
            'lolo_pinoy_grill_branches_suppliers.id',
            'lolo_pinoy_grill_branches_suppliers.date',
            'lolo_pinoy_grill_branches_suppliers.supplier_name')
            ->leftJoin('lolo_pinoy_grill_branches_suppliers', 'lolo_pinoy_grill_branches_payment_vouchers.supplier_id', '=', 'lolo_pinoy_grill_branches_suppliers.id')
            ->where('lolo_pinoy_grill_branches_suppliers.id', $id)
            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.voucher_ref_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.supplier_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.supplier_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_suppliers.id',
                        'lolo_pinoy_grill_branches_suppliers.date',
                        'lolo_pinoy_grill_branches_suppliers.supplier_name')
                        ->leftJoin('lolo_pinoy_grill_branches_suppliers', 'lolo_pinoy_grill_branches_payment_vouchers.supplier_id', '=', 'lolo_pinoy_grill_branches_suppliers.id')
                        ->where('lolo_pinoy_grill_branches_suppliers.id', $id)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $pdf = PDF::loadView('printSupplierLoloPinoyGrillBranches', compact('viewSupplier', 'printSuppliers', 'totalAmountDue'));

        return $pdf->download('lolo-pinoy-grill-branches-supplier.pdf');

    }

    public function viewSupplier($id){
        $viewSupplier = LoloPinoyGrillBranchesSupplier::where('id', $id)->get();

        $supplierLists = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.supplier_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.supplier_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_suppliers.date',
                        'lolo_pinoy_grill_branches_suppliers.supplier_name')
                        ->leftJoin('lolo_pinoy_grill_branches_suppliers', 'lolo_pinoy_grill_branches_payment_vouchers.supplier_id', '=', 'lolo_pinoy_grill_branches_suppliers.id')
                        ->where('lolo_pinoy_grill_branches_suppliers.id', $id)
                        ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_suppliers.id',
                            'lolo_pinoy_grill_branches_suppliers.date',
                            'lolo_pinoy_grill_branches_suppliers.supplier_name')
                            ->leftJoin('lolo_pinoy_grill_branches_suppliers', 'lolo_pinoy_grill_branches_payment_vouchers.supplier_id', '=', 'lolo_pinoy_grill_branches_suppliers.id')
                            ->where('lolo_pinoy_grill_branches_suppliers.id', $id)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                            ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');
    

        return view('view-lolo-pinoy-grill-branches-supplier', compact('viewSupplier', 'supplierLists', 'totalAmountDue'));
    }

    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


          //check if supplier name exits
        $target = DB::table(
                'lolo_pinoy_grill_branches_suppliers')
                ->where('supplier_name', $request->supplierName)
                ->get()->first();

        if($target === NULL){
            $supplier = new LoloPinoyGrillBranchesSupplier([
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
        $suppliers = LoloPinoyGrillBranchesSupplier::orderBy('id', 'desc')->get()->toArray();

        return view('lolo-pinoy-grill-branches-supplier', compact('suppliers'));
    }

    public function updateDetails(Request $request){
        $updateDetail = LoloPinoyGrillBranchesPaymentVoucher::find($request->id);

        $updateDetail->paid_to = $request->paidTo;
        $updateDetail->invoice_number = $request->invoiceNo;
        $updateDetail->account_name = $request->accountName;
        $updateDetail->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){
        $updateCash = LoloPinoyGrillBranchesPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = LoloPinoyGrillBranchesPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
          //main id 
          $updateParticular = LoloPinoyGrillBranchesPaymentVoucher::find($request->transId);

          //particular id
          $uIdParticular = LoloPinoyGrillBranchesPaymentVoucher::find($request->id);
 
          $amount = $request->amount; 
 
          $updateAmount =  $updateParticular->amount; 
         
          $uParticular = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
          
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
        $updateParticular =  LoloPinoyGrillBranchesPaymentVoucher::find($request->id);

        $amount = $request->amount; 
    
        $tot = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
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

        $moduleNameVoucher = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $totalPaidAmountCheck  = DB::table(
                                    'lolo_pinoy_grill_branches_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_branches_payment_vouchers.id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.status',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                    'lolo_pinoy_grill_branches_codes.module_id',
                                    'lolo_pinoy_grill_branches_codes.module_code',
                                    'lolo_pinoy_grill_branches_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                    ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$uri0, $uri1])
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.status', $status)
                                    ->sum('lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount');

        $getDateToday = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillBranches',  compact('date', 'getDateToday', 'uri0', 'uri1', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lolo-pinoy-grill-branches-summary-report.pdf');

    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));

        
        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_at',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->whereBetween('lolo_pinoy_grill_branches_requisition_slips.created_at', [$startDate, $endDate])        
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        $transactionLists = DB::table(
                            'lolo_pinoy_grill_branches_requisition_slips')
                            ->select(
                                'lolo_pinoy_grill_branches_requisition_slips.id',
                                'lolo_pinoy_grill_branches_requisition_slips.user_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                                'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                                'lolo_pinoy_grill_branches_requisition_slips.request_date',
                                'lolo_pinoy_grill_branches_requisition_slips.date_released',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                                'lolo_pinoy_grill_branches_requisition_slips.unit',
                                'lolo_pinoy_grill_branches_requisition_slips.item',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                                'lolo_pinoy_grill_branches_requisition_slips.released_by',
                                'lolo_pinoy_grill_branches_requisition_slips.received_by',
                                'lolo_pinoy_grill_branches_requisition_slips.created_by',
                                'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                            ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->whereBetween('lolo_pinoy_grill_branches_requisition_slips.created_at', [$startDate, $endDate])
                     
                            ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                            ->get()->toArray();

        $moduleNamePetty = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.created_at',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_branches_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNamePetty)
                                ->whereBetween('lolo_pinoy_grill_branches_petty_cashes.created_at', [$startDate, $endDate])
                     
                                ->orderBy('lolo_pinoy_grill_branches_petty_cashes.id', 'desc')
                                ->get()->toArray();
                    
            $moduleNameVoucher = "Payment Voucher";
            $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                     
                                ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                                ->get()->toArray();
        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                     
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereBetween('lolo_pinoy_grill_branches_payment_vouchers.created_at', [$startDate, $endDate])
                     
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        return view('lolo-pinoy-grill-branches-multiple-summary-report', compact('requisitionLists', 'startDate', 'endDate',
        'transactionLists', 'pettyCashLists', 'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function search(Request $request){
        $getSearchResults =LoloPinoyGrillBranchesCode::where('lolo_pinoy_branches_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Requisition Slip"){
            $getSearchReqSlips = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_requisition_slips.created_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.id', $getSearchResults[0]->module_id)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $getSearchResults[0]->module_name)
                        ->get()->toArray();
            
            $getAllCodes = LoloPinoyGrillBranchesCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-branches-search-results',  compact('module', 'getAllCodes', 'getSearchReqSlips'));
                   

        }else if($getSearchResults[0]->module_name === "Petty Cash"){
            $getSearchPettyCashes = DB::table(
                            'lolo_pinoy_grill_branches_petty_cashes')
                            ->select( 
                            'lolo_pinoy_grill_branches_petty_cashes.id',
                            'lolo_pinoy_grill_branches_petty_cashes.user_id',
                            'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                            'lolo_pinoy_grill_branches_petty_cashes.date',
                            'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                            'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                            'lolo_pinoy_grill_branches_petty_cashes.amount',
                            'lolo_pinoy_grill_branches_petty_cashes.created_by',
                            'lolo_pinoy_grill_branches_petty_cashes.created_at',
                            'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_petty_cashes.id', $getSearchResults[0]->module_id)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $getSearchResults[0]->module_name)       
                            ->get()->toArray();
                    
            $getAllCodes = LoloPinoyGrillBranchesCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-branches-search-results',  compact('module', 'getAllCodes', 'getSearchPettyCashes'));
                      
        }else if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.id', $getSearchResults[0]->module_id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $getSearchResults[0]->module_name)
                                ->get()->toArray(); 
            
            $getAllCodes = LoloPinoyGrillBranchesCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;

            return view('lolo-pinoy-grill-branches-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
                          

        }
    
    }

    public function searchNumberCode(){
        $getAllCodes = LoloPinoyGrillBranchesCode::get()->toArray();
        return view('lolo-pinoy-grill-branches-search-number-code', compact('getAllCodes'));
    }

    public function printGetSummary($date){
        $moduleNameVoucher = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');
            
            $totalPaidAmountCheck = DB::table(
                                    'lolo_pinoy_grill_branches_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_branches_payment_vouchers.id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.status',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                    'lolo_pinoy_grill_branches_codes.module_id',
                                    'lolo_pinoy_grill_branches_codes.module_code',
                                    'lolo_pinoy_grill_branches_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                    ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($date))
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.status', $status)
                                    ->sum('lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount');
        
        $getDateToday = "";
        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillBranches',  compact('date', 'uri0', 'uri1', 'getDateToday', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lolo-pinoy-grill-branches-summary-report.pdf');
    }

    public function getSummaryReport(Request $request){ 
        $getDate = $request->get('selectDate');
        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_at',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_branches_requisition_slips.created_at', '=', date($getDate))
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        $transactionLists = DB::table(
                            'lolo_pinoy_grill_branches_requisition_slips')
                            ->select(
                                'lolo_pinoy_grill_branches_requisition_slips.id',
                                'lolo_pinoy_grill_branches_requisition_slips.user_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                                'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                                'lolo_pinoy_grill_branches_requisition_slips.request_date',
                                'lolo_pinoy_grill_branches_requisition_slips.date_released',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                                'lolo_pinoy_grill_branches_requisition_slips.unit',
                                'lolo_pinoy_grill_branches_requisition_slips.item',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                                'lolo_pinoy_grill_branches_requisition_slips.released_by',
                                'lolo_pinoy_grill_branches_requisition_slips.received_by',
                                'lolo_pinoy_grill_branches_requisition_slips.created_by',
                                'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                            ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->whereDate('lolo_pinoy_grill_branches_requisition_slips.created_at', '=', date($getDate))
                            ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                            ->get()->toArray();

        $moduleNamePetty = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.created_at',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_branches_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNamePetty)
                                ->whereDate('lolo_pinoy_grill_branches_petty_cashes.created_at', '=', date($getDate))
                                ->orderBy('lolo_pinoy_grill_branches_petty_cashes.id', 'desc')
                                ->get()->toArray();
                    


        $moduleNameVoucher = "Payment Voucher";

        $getTransactionLists = DB::table(
                    'lolo_pinoy_grill_branches_payment_vouchers')
                    ->select( 
                    'lolo_pinoy_grill_branches_payment_vouchers.id',
                    'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                    'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                    'lolo_pinoy_grill_branches_payment_vouchers.date',
                    'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                    'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                    'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                    'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                    'lolo_pinoy_grill_branches_payment_vouchers.amount',
                    'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                    'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                    'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                    'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                    'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                    'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                    'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                    'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                    'lolo_pinoy_grill_branches_payment_vouchers.category',
                    'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                    'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                    'lolo_pinoy_grill_branches_payment_vouchers.status',
                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                    'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                    'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                    'lolo_pinoy_grill_branches_codes.module_id',
                    'lolo_pinoy_grill_branches_codes.module_code',
                    'lolo_pinoy_grill_branches_codes.module_name')
                    ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                    ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                    ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                    ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                    ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                    ->get()->toArray();



        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDate))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDate))
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDate))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDate))
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');
        
        return view('lolo-pinoy-grill-branches-get-summary-report', compact('getDate', 
        'requisitionLists', 'transactionLists', 'getTransactionListCashes', 'pettyCashLists', 'getTransactionLists',
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck'));


    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");

        $moduleNameVoucher = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $totalPaidAmountCheck  = DB::table(
                                    'lolo_pinoy_grill_branches_payment_vouchers')
                                    ->select( 
                                    'lolo_pinoy_grill_branches_payment_vouchers.id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                    'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                    'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                    'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                    'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                    'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                    'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                    'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                    'lolo_pinoy_grill_branches_payment_vouchers.status',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                    'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                    'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                    'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                    'lolo_pinoy_grill_branches_codes.module_id',
                                    'lolo_pinoy_grill_branches_codes.module_code',
                                    'lolo_pinoy_grill_branches_codes.module_name')
                                    ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                    ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                    ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                    ->where('lolo_pinoy_grill_branches_payment_vouchers.status', $status)
                                    ->sum('lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount');

        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryLoloPinoyGrillBranches',  compact('uri0', 'uri1', 'getDateToday', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('lolo-pinoy-grill-branches-summary-report.pdf');

    }

    public function summaryReport(){
         
        $getDateToday = date("Y-m-d");

        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_at',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->whereDate('lolo_pinoy_grill_branches_requisition_slips.created_at', '=', date($getDateToday))
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        $transactionLists = DB::table(
                            'lolo_pinoy_grill_branches_requisition_slips')
                            ->select(
                                'lolo_pinoy_grill_branches_requisition_slips.id',
                                'lolo_pinoy_grill_branches_requisition_slips.user_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                                'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                                'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                                'lolo_pinoy_grill_branches_requisition_slips.request_date',
                                'lolo_pinoy_grill_branches_requisition_slips.date_released',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                                'lolo_pinoy_grill_branches_requisition_slips.unit',
                                'lolo_pinoy_grill_branches_requisition_slips.item',
                                'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                                'lolo_pinoy_grill_branches_requisition_slips.released_by',
                                'lolo_pinoy_grill_branches_requisition_slips.received_by',
                                'lolo_pinoy_grill_branches_requisition_slips.created_by',
                                'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                            ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->whereDate('lolo_pinoy_grill_branches_requisition_slips.created_at', '=', date($getDateToday))
                            ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                            ->get()->toArray();

        $moduleNamePetty = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.created_at',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_branches_petty_cashes.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNamePetty)
                                ->whereDate('lolo_pinoy_grill_branches_petty_cashes.created_at', '=', date($getDateToday))
                                ->orderBy('lolo_pinoy_grill_branches_petty_cashes.id', 'desc')
                                ->get()->toArray();
                    
            $moduleNameVoucher = "Payment Voucher";
            $getTransactionLists = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                               
                                ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                                ->get()->toArray();
        
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCash = DB::table(
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->select( 
                        'lolo_pinoy_grill_branches_payment_vouchers.id',
                        'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.date',
                        'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                        'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                        'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                        'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                        'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                        'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                        'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.category',
                        'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                        'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                        'lolo_pinoy_grill_branches_payment_vouchers.status',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                        'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                        'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                        'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                        'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                        'lolo_pinoy_grill_branches_codes.module_id',
                        'lolo_pinoy_grill_branches_codes.module_code',
                        'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                        ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                        ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_total_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                            ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray(); 
            
        $totalAmountCheck = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_at',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleNameVoucher)
                                ->whereDate('lolo_pinoy_grill_branches_payment_vouchers.created_at', '=', date($getDateToday))
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.method_of_payment', $check)
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.status', '!=', $status)
                                ->sum('lolo_pinoy_grill_branches_payment_vouchers.amount_due');

                
        return view('lolo-pinoy-grill-branches-summary-report', compact('requisitionLists', 
        'transactionLists', 'pettyCashLists', 'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCash', 'getTransactionListChecks', 'totalAmountCheck'));
    }

    public function printPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.id', $id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->get();
        

        $getPettyCashSummaries = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = LoloPinoyGrillBranchesPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        $pdf = PDF::loadView('printPettyCashLoloPinoyGrillBranches', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
        return $pdf->download('lolo-pinoy-grill-branches-petty-cash.pdf');

    }

    public function updatePC(Request $request, $id){
        $updatePC = LoloPinoyGrillBranchesPettyCash::find($id);

        $updatePC->date = $request->get('date');
        $updatePC->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePC->amount = $request->get('amount');
        $updatePC->save();

        Session::flash('updatePC', 'Successfully updated.');
        return redirect()->route('editPettyCashLoloPinoyGrillBranches', ['id'=>$request->get('pcId')]);
    }

    public function addNewPettyCash(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


        $addNew = new LoloPinoyGrillBranchesPettyCash([
            'user_id'=>$user->id,
            'pc_id'=>$id,
            'date'=>$request->get('date'),
            'petty_cash_summary'=>$request->get('pettyCashSummary'),
            'amount'=>$request->get('amount'),
            'created_by'=>$name,
        ]);
        $addNew->save();
        Session::flash('addNewSuccess', 'Successfully added.');

        return redirect()->route('editPettyCashLoloPinoyGrillBranches', ['id'=>$id]);
    }

    public function updatePettyCash(Request $request, $id){
        $updatePettyCash = LoloPinoyGrillBranchesPettyCash::find($id);
        $updatePettyCash->date = $request->get('date');
        $updatePettyCash->petty_cash_name = $request->get('pettyCashName');
        $updatePettyCash->petty_cash_summary = $request->get('pettyCashSummary');
        $updatePettyCash->save();

        Session::flash('editSuccess', 'Successfully updated.');

        return redirect()->route('editPettyCashLoloPinoyGrillBranches', ['id'=>$id]);
    }

    public function editPettyCash($id){
        $moduleName = "Petty Cash";
        $pettyCash = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.id', $id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->get();

        $pettyCashSummaries = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->get()->toArray();
        return view('edit-lolo-pinoy-grill-branches-petty-cash', compact('pettyCash', 'pettyCashSummaries'));
    }

    public function  addPettyCash(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the latest insert id query in table lolo_pinoy_grill_branches_codes
        $dataCashNo = DB::select('SELECT id, lolo_pinoy_branches_code  FROM lolo_pinoy_grill_branches_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 petty cash no
        if(isset($dataCashNo[0]->lolo_pinoy_branches_code ) != 0){
            //if code is not 0
            $newProd = $dataCashNo[0]->lolo_pinoy_branches_code  +1;
            $uPetty = sprintf("%06d",$newProd);   

        }else{
            //if code is 0 
            $newProd = 1;
            $uPetty = sprintf("%06d",$newProd);
        } 

        $addPettyCash = new LoloPinoyGrillBranchesPettyCash([
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

        $lpBranches = new LoloPinoyGrillBranchesCode([
            'user_id'=>$user->id,
            'lolo_pinoy_branches_code'=>$uPetty,
            'module_id'=>$insertId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $lpBranches->save();
      
        return response()->json($insertId);


    }


    //logout session in branches
    public function logOutBranch(Request $request){
        $request->session()->forget('sessionBranch');
        return redirect()->route('salesInvoiceFormLoloPinoyGrillBranches');

    }

    //redirect to branch
    public function salesInvoiceFormBranch(Request $request, $type){
        $data = $request->session()->get('sessionBranch');
        if(empty($data)){
            return redirect()->route('salesInvoiceFormLoloPinoyGrillBranches');
        }else{
            $branch = $request->session()->get('sessionBranch');
            $flag = "Foods";
            $getBranches = DB::table(
                                    'lolo_pinoy_grill_branches_store_stocks')
                                    ->select(
                                    'lolo_pinoy_grill_branches_store_stocks.id',
                                    'lolo_pinoy_grill_branches_store_stocks.user_id',
                                    'lolo_pinoy_grill_branches_store_stocks.date',
                                    'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                    'lolo_pinoy_grill_branches_store_stocks.supplier',
                                    'lolo_pinoy_grill_branches_store_stocks.product_name',
                                    'lolo_pinoy_grill_branches_store_stocks.price',
                                    'lolo_pinoy_grill_branches_store_stocks.qty',
                                    'lolo_pinoy_grill_branches_store_stocks.unit',
                                    'lolo_pinoy_grill_branches_store_stocks.product_in',
                                    'lolo_pinoy_grill_branches_store_stocks.product_out',
                                    'lolo_pinoy_grill_branches_store_stocks.amount',
                                    'lolo_pinoy_grill_branches_store_stocks.branch',
                                    'lolo_pinoy_grill_branches_store_stocks.flag',
                                    'lolo_pinoy_grill_branches_store_stocks.created_by',
                                    'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                    'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                    ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                    ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branch)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flag)
                                    ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'asc')
                                    ->get()->toArray();

            $flagDrinks = "Drinks";
            $getBranchDrinks = DB::table(
                                        'lolo_pinoy_grill_branches_store_stocks')
                                        ->select(
                                        'lolo_pinoy_grill_branches_store_stocks.id',
                                        'lolo_pinoy_grill_branches_store_stocks.user_id',
                                        'lolo_pinoy_grill_branches_store_stocks.date',
                                        'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                        'lolo_pinoy_grill_branches_store_stocks.supplier',
                                        'lolo_pinoy_grill_branches_store_stocks.product_name',
                                        'lolo_pinoy_grill_branches_store_stocks.price',
                                        'lolo_pinoy_grill_branches_store_stocks.qty',
                                        'lolo_pinoy_grill_branches_store_stocks.unit',
                                        'lolo_pinoy_grill_branches_store_stocks.product_in',
                                        'lolo_pinoy_grill_branches_store_stocks.product_out',
                                        'lolo_pinoy_grill_branches_store_stocks.amount',
                                        'lolo_pinoy_grill_branches_store_stocks.branch',
                                        'lolo_pinoy_grill_branches_store_stocks.flag',
                                        'lolo_pinoy_grill_branches_store_stocks.created_by',
                                        'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                        'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                        ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                        ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branch)
                                        ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagDrinks)
                                        ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'asc')
                                        ->get()->toArray();

            return view('lolo-pinoy-grill-branches-sales-invoice-form', compact('getBranches', 'getBranchDrinks'));
        }
        
    }

    //login branch 
    public function loginSales(Request $request){

        //get the data from the users table
        $getBranch = User::where('select_branch', $request->get('selectBranch'))->get()->toArray();
       
        if($getBranch == NULL){
            $findAccess = User::find(isset($getBranch[0]['id']));
            return redirect()->route('salesInvoiceForm')->with('noAccess', 'No Access'); 
        }else{
            $findAccess = User::find($getBranch[0]['id']);

            $password = $request->get('password');
            //check if  password is the same 
            if(Hash::check($password, $findAccess['password'])){
                $stat = "1";
                $updateStatus = User::find($findAccess['id']);
                $updateStatus->status = $stat;
                $updateStatus->save();
                
                $value = $findAccess['select_branch'];
                Session::put('sessionBranch', $value);

                //redirect to what branch selected in login
                return redirect()->route('salesInvoiceFormBranch', ['branch'=>$findAccess['select_branch']]);

            }else{
                $request->session()->flash('error', 'Password does not match.');
                return redirect()->route('salesInvoiceFormLoloPinoyGrillBranches');
            }
        
        }

    }   

    //pay cash
    public function payCash(Request $request, $id){
         //validate
         $this->validate($request, [
            'cash' =>'required|integer|min:0',
           
        ]);

        $payCash = LoloPinoyGrillBranchesSalesForm::withTrashed()->find($id);

        if($payCash->senior_amount != NULL){
            $payTotalSenior = $request->get('cash') - $payCash->total;
            $payCash->cash_amount = $request->get('cash');
            $payCash->change = $payTotalSenior;
            $payCash->save();

            Session::flash('successPay', 'Paid Successfully. Kindly click the OK button below.');
            return redirect()->route('detailTransactions', ['id'=>$id]);

        }else{
            $payTotal = $request->get('cash') - $payCash->total;
        
            $payCash->cash_amount = $request->get('cash');
            $payCash->change = $payTotal; 
            $payCash->save();
    
            Session::flash('successPay', 'Paid Successfully. Kindly click the OK button below.');
            return redirect()->route('detailTransactions', ['id'=>$id]);
           
        }

        
    }

    //detail transaction
    public function detailTransactions(Request $request, $id){
        $data = $request->session()->get('sessionBranch');

        $transaction = DB::table(
                    'lolo_pinoy_grill_branches_sales_forms')
                    ->select(
                    'lolo_pinoy_grill_branches_sales_forms.id',
                    'lolo_pinoy_grill_branches_sales_forms.user_id',
                    'lolo_pinoy_grill_branches_sales_forms.sf_id',
                    'lolo_pinoy_grill_branches_sales_forms.invoice_number',
                    'lolo_pinoy_grill_branches_sales_forms.ordered_by',
                    'lolo_pinoy_grill_branches_sales_forms.table_no',
                    'lolo_pinoy_grill_branches_sales_forms.date',
                    'lolo_pinoy_grill_branches_sales_forms.branch',
                    'lolo_pinoy_grill_branches_sales_forms.qty',
                    'lolo_pinoy_grill_branches_sales_forms.item_description',
                    'lolo_pinoy_grill_branches_sales_forms.amount',
                    'lolo_pinoy_grill_branches_sales_forms.total_discounts_seniors_pwds',
                    'lolo_pinoy_grill_branches_sales_forms.total_amount_of_sales',
                    'lolo_pinoy_grill_branches_sales_forms.total',
                    'lolo_pinoy_grill_branches_sales_forms.senior_citizen_label',
                    'lolo_pinoy_grill_branches_sales_forms.senior_citizen_id',
                    'lolo_pinoy_grill_branches_sales_forms.senior_amount',
                    'lolo_pinoy_grill_branches_sales_forms.senior_discount',
                    'lolo_pinoy_grill_branches_sales_forms.senior_citizen_name',
                    'lolo_pinoy_grill_branches_sales_forms.gift_cert',
                    'lolo_pinoy_grill_branches_sales_forms.cash_amount',
                    'lolo_pinoy_grill_branches_sales_forms.change',
                    'lolo_pinoy_grill_branches_sales_forms.deleted_at')
                    ->where('lolo_pinoy_grill_branches_sales_forms.id', $id)
                    ->get();

         //getTransactions
        $getTransactions = LoloPinoyGrillBranchesSalesForm::where('sf_id', $id)->get()->toArray();
        return view('lolo-pinoy-grill-branches-detail-transactions', compact('transaction', 'getTransactions', 'data'));
    }

    //settle transactions
    public function settleTransactions(Request $request, $id){
        

        $settleTransactions = LoloPinoyGrillBranchesSalesForm::withTrashed()->find($id);
        $settleTransactions->invoice_number = $request->get('invoiceNum');
        $settleTransactions->ordered_by = $request->get('orderedBy');
        $settleTransactions->table_no = $request->get('tableNo');
        $settleTransactions->save();

        return redirect()->route('detailTransactions', ['id'=>$id]);

    }

    //save additional transactions
    public function addSalesAdditional(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
        $getDate =  date("Y-m-d");

        //get transaction id
        $getTransId = LoloPinoyGrillBranchesSalesForm::withTrashed()->find($request->transactionId);

        //compute 
        $amt = $request->amount + $getTransId->total_amount_of_sales;

        //update
        $getTransId->total_amount_of_sales = $amt;
        $getTransId->total = $amt;
        $getTransId->save();

        $addAdditional = new LoloPinoyGrillBranchesSalesForm([
            'user_id'=>$user->id,
            'sf_id'=>$request->transactionId,
            'date'=>$getDate,
            'qty'=>$request->quantity,
            'item_description'=>$request->itemDescription,
            'amount'=>$request->amount,
            'branch'=>$request->branch,
            "flag"=>$request->flag,
            'created_by'=>$name,
        ]);
        $addAdditional->save();


        //update store stock 
        $updateStoreStock = LoloPinoyGrillBranchesStoreStock::find($request->foodId);
        $updateStoreStock->product_in = $request->compute;
        $updateStoreStock->save();
    
        return response()->json($getTransId->total_amount_of_sales);

    }

    public function salesTransaction($type, $id){
     
        $transaction = DB::table(
                        'lolo_pinoy_grill_branches_sales_forms')
                        ->select(
                        'lolo_pinoy_grill_branches_sales_forms.id',
                        'lolo_pinoy_grill_branches_sales_forms.user_id',
                        'lolo_pinoy_grill_branches_sales_forms.sf_id',
                        'lolo_pinoy_grill_branches_sales_forms.invoice_number',
                        'lolo_pinoy_grill_branches_sales_forms.ordered_by',
                        'lolo_pinoy_grill_branches_sales_forms.table_no',
                        'lolo_pinoy_grill_branches_sales_forms.date',
                        'lolo_pinoy_grill_branches_sales_forms.branch',
                        'lolo_pinoy_grill_branches_sales_forms.qty',
                        'lolo_pinoy_grill_branches_sales_forms.item_description',
                        'lolo_pinoy_grill_branches_sales_forms.amount',
                        'lolo_pinoy_grill_branches_sales_forms.total_discounts_seniors_pwds',
                        'lolo_pinoy_grill_branches_sales_forms.total_amount_of_sales',
                        'lolo_pinoy_grill_branches_sales_forms.gift_cert',
                        'lolo_pinoy_grill_branches_sales_forms.cash_amount',
                        'lolo_pinoy_grill_branches_sales_forms.change',
                        'lolo_pinoy_grill_branches_sales_forms.deleted_at')
                        ->where('lolo_pinoy_grill_branches_sales_forms.id', $id)
                        ->get();

        //getTransactions
        $getTransactions = LoloPinoyGrillBranchesSalesForm::where('sf_id', $id)->get()->toArray();
       
        $flag = "Foods";
        $getBranches = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.price',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.flag',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $type)
                                ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flag)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'asc')
                                ->get()->toArray();

        $flagDrinks = "Drinks";
        $getBranchDrinks = DB::table(
                                    'lolo_pinoy_grill_branches_store_stocks')
                                    ->select(
                                    'lolo_pinoy_grill_branches_store_stocks.id',
                                    'lolo_pinoy_grill_branches_store_stocks.user_id',
                                    'lolo_pinoy_grill_branches_store_stocks.date',
                                    'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                    'lolo_pinoy_grill_branches_store_stocks.supplier',
                                    'lolo_pinoy_grill_branches_store_stocks.product_name',
                                    'lolo_pinoy_grill_branches_store_stocks.price',
                                    'lolo_pinoy_grill_branches_store_stocks.qty',
                                    'lolo_pinoy_grill_branches_store_stocks.unit',
                                    'lolo_pinoy_grill_branches_store_stocks.product_in',
                                    'lolo_pinoy_grill_branches_store_stocks.product_out',
                                    'lolo_pinoy_grill_branches_store_stocks.amount',
                                    'lolo_pinoy_grill_branches_store_stocks.branch',
                                    'lolo_pinoy_grill_branches_store_stocks.flag',
                                    'lolo_pinoy_grill_branches_store_stocks.created_by',
                                    'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                    'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                    ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                    ->where('lolo_pinoy_grill_branches_store_stocks.branch', $type)
                                    ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagDrinks)
                                    ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'asc')
                                    ->get()->toArray();

        return view('lolo-pinoy-grill-branches-transactions', compact('id', 'transaction', 
        'getTransactions', 'getBranches', 'getBranchDrinks'));
    }

    //save first transactions
    public function addSalesTransaction(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
        $getDate =  date("Y-m-d");

    
        $addNewSales = new LoloPinoyGrillBranchesSalesForm([
            'user_id'=>$user->id,
            'date'=>$getDate,
            'qty'=>$request->quantity,
            'item_description'=>$request->itemDescription,
            'amount'=>$request->amount,
            'total_amount_of_sales'=>$request->amount,
            'total'=>$request->amount,
            'branch'=>$request->branch,
            'flag'=>$request->flag,
            'created_by'=>$name,
        ]);
        $addNewSales->save();
        $insertId = $addNewSales->id; 

        //update the store stock inventory 
        $updateStoreStock = LoloPinoyGrillBranchesStoreStock::find($request->foodId);
        $updateStoreStock->product_in = $request->compute;
        $updateStoreStock->save();


        return response()->json($insertId);

    }

    public function viewStockInventory($id){
        $viewStockInventory = LoloPinoyGrillCommissaryRawMaterial::find($id);
        $getStoreStockDetails = LoloPinoyGrillCommissaryRawMaterial::where('rm_id', $id)->get()->toArray();
        return view('view-lolo-pinoy-grill-branches-store-stock', compact('viewStockInventory', 'getStoreStockDetails'));
    }

    public function stockInventory(Request $request){
        $data =  $request->session()->get('sessionDeliveryInTransaction');
        
        $branchUrgello = "Urgello";
        $flagUrgello = "Foods";
        $getStockStatusUrgellos = DB::table(
                            'lolo_pinoy_grill_branches_store_stocks')
                            ->select(
                            'lolo_pinoy_grill_branches_store_stocks.id',
                            'lolo_pinoy_grill_branches_store_stocks.user_id',
                            'lolo_pinoy_grill_branches_store_stocks.date',
                            'lolo_pinoy_grill_branches_store_stocks.dr_no',
                            'lolo_pinoy_grill_branches_store_stocks.supplier',
                            'lolo_pinoy_grill_branches_store_stocks.product_name',
                            'lolo_pinoy_grill_branches_store_stocks.price',
                            'lolo_pinoy_grill_branches_store_stocks.qty',
                            'lolo_pinoy_grill_branches_store_stocks.unit',
                            'lolo_pinoy_grill_branches_store_stocks.product_in',
                            'lolo_pinoy_grill_branches_store_stocks.product_out',
                            'lolo_pinoy_grill_branches_store_stocks.amount',
                            'lolo_pinoy_grill_branches_store_stocks.branch',
                            'lolo_pinoy_grill_branches_store_stocks.created_by',
                            'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                            'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                            ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                            ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchUrgello)
                            ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagUrgello)
                            ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                            ->get()->toArray();

            $flagUrgelloDrinks = "Drinks";
            $getStockStatusUrgelloDrinks = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.price',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchUrgello)
                                ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagUrgelloDrinks)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                ->get()->toArray();
    
        $branchVelez = "Velez";
        $flagVelez = "Foods";
        $getStockStatusVelezes = DB::table(
                            'lolo_pinoy_grill_branches_store_stocks')
                            ->select(
                            'lolo_pinoy_grill_branches_store_stocks.id',
                            'lolo_pinoy_grill_branches_store_stocks.user_id',
                            'lolo_pinoy_grill_branches_store_stocks.date',
                            'lolo_pinoy_grill_branches_store_stocks.dr_no',
                            'lolo_pinoy_grill_branches_store_stocks.supplier',
                            'lolo_pinoy_grill_branches_store_stocks.product_name',
                            'lolo_pinoy_grill_branches_store_stocks.qty',
                            'lolo_pinoy_grill_branches_store_stocks.unit',
                            'lolo_pinoy_grill_branches_store_stocks.product_in',
                            'lolo_pinoy_grill_branches_store_stocks.product_out',
                            'lolo_pinoy_grill_branches_store_stocks.amount',
                            'lolo_pinoy_grill_branches_store_stocks.branch',
                            'lolo_pinoy_grill_branches_store_stocks.created_by',
                            'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                            'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                            ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                            ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchVelez)
                            ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagVelez)
                            ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                            ->get()->toArray();

            $flagVelezDrinks = "Drinks";
            $getStockStatusVelezDrinks = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchVelez)
                                ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagVelezDrinks)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                ->get()->toArray();
    
        $branchBanilad = "Banilad";
        $flagBanilad = "Foods";
        $getStockStatusBanilads = DB::table(
                            'lolo_pinoy_grill_branches_store_stocks')
                            ->select(
                            'lolo_pinoy_grill_branches_store_stocks.id',
                            'lolo_pinoy_grill_branches_store_stocks.user_id',
                            'lolo_pinoy_grill_branches_store_stocks.date',
                            'lolo_pinoy_grill_branches_store_stocks.dr_no',
                            'lolo_pinoy_grill_branches_store_stocks.supplier',
                            'lolo_pinoy_grill_branches_store_stocks.product_name',
                            'lolo_pinoy_grill_branches_store_stocks.price',
                            'lolo_pinoy_grill_branches_store_stocks.qty',
                            'lolo_pinoy_grill_branches_store_stocks.unit',
                            'lolo_pinoy_grill_branches_store_stocks.product_in',
                            'lolo_pinoy_grill_branches_store_stocks.product_out',
                            'lolo_pinoy_grill_branches_store_stocks.amount',
                            'lolo_pinoy_grill_branches_store_stocks.branch',
                            'lolo_pinoy_grill_branches_store_stocks.created_by',
                            'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                            'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                            ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                            ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchBanilad)
                            ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagBanilad)
                            ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                            ->get()->toArray();

        $flagBaniladDrinks = "Drinks";
        $getStockStatusBaniladDrinks = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.price',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchBanilad)
                                ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagBaniladDrinks)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                ->get()->toArray();
    
            $branchGqs = "GQS";
            $flagGQS = "Foods";
            $getStockStatusGqses = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.price',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchGqs)
                                ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagGQS)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                ->get()->toArray();

            $flagGQSDrinks = "Drinks";
            $getStockStatusGqsDrinks = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.price',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchGqs)
                                ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagGQSDrinks)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                ->get()->toArray();
                    
        return view('lolo-pinoy-grill-branches-stock-inventory', compact('data', 
        'getStockStatusUrgellos', 'getStockStatusUrgelloDrinks', 
        'getStockStatusVelezes', 'getStockStatusVelezDrinks',
        'getStockStatusBanilads',  'getStockStatusBaniladDrinks', 'getStockStatusGqses', 'getStockStatusGqsDrinks'));
    }

    public function stockStatus(Request $request){
        $data =  $request->session()->get('sessionDeliveryInTransaction'); 
        
        $branchUrgello = "Urgello";
        $flagUrgello = "Foods";
        $getStockStatusUrgellos = DB::table(
                            'lolo_pinoy_grill_branches_store_stocks')
                            ->select(
                            'lolo_pinoy_grill_branches_store_stocks.id',
                            'lolo_pinoy_grill_branches_store_stocks.user_id',
                            'lolo_pinoy_grill_branches_store_stocks.date',
                            'lolo_pinoy_grill_branches_store_stocks.dr_no',
                            'lolo_pinoy_grill_branches_store_stocks.supplier',
                            'lolo_pinoy_grill_branches_store_stocks.product_name',
                            'lolo_pinoy_grill_branches_store_stocks.qty',
                            'lolo_pinoy_grill_branches_store_stocks.unit',
                            'lolo_pinoy_grill_branches_store_stocks.product_in',
                            'lolo_pinoy_grill_branches_store_stocks.product_out',
                            'lolo_pinoy_grill_branches_store_stocks.amount',
                            'lolo_pinoy_grill_branches_store_stocks.branch',
                            'lolo_pinoy_grill_branches_store_stocks.created_by',
                            'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                            'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                            ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                            ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchUrgello)
                            ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagUrgello)
                            ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                            ->get()->toArray();

        $flagUrgelloDrinks = "Drinks";
        $getStockStatusUrgelloDrinks = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchUrgello)
                                ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagUrgelloDrinks)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                ->get()->toArray();

        $branchVelez = "Velez";
        $flagVelez = "Foods";
        $getStockStatusVelezes = DB::table(
                            'lolo_pinoy_grill_branches_store_stocks')
                            ->select(
                            'lolo_pinoy_grill_branches_store_stocks.id',
                            'lolo_pinoy_grill_branches_store_stocks.user_id',
                            'lolo_pinoy_grill_branches_store_stocks.date',
                            'lolo_pinoy_grill_branches_store_stocks.dr_no',
                            'lolo_pinoy_grill_branches_store_stocks.supplier',
                            'lolo_pinoy_grill_branches_store_stocks.product_name',
                            'lolo_pinoy_grill_branches_store_stocks.qty',
                            'lolo_pinoy_grill_branches_store_stocks.unit',
                            'lolo_pinoy_grill_branches_store_stocks.product_in',
                            'lolo_pinoy_grill_branches_store_stocks.product_out',
                            'lolo_pinoy_grill_branches_store_stocks.amount',
                            'lolo_pinoy_grill_branches_store_stocks.branch',
                            'lolo_pinoy_grill_branches_store_stocks.created_by',
                            'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                            'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                            ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                            ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchVelez)
                            ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagVelez)
                            ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                            ->get()->toArray();

        $flagVelezDrinks = "Drinks";
        $getStockStatusVelezDrinks = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchVelez)
                                ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagVelezDrinks)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                ->get()->toArray();
           
        $branchBanilad = "Banilad";
        $flagBanilad = "Foods";
        $getStockStatusBanilads = DB::table(
                            'lolo_pinoy_grill_branches_store_stocks')
                            ->select(
                            'lolo_pinoy_grill_branches_store_stocks.id',
                            'lolo_pinoy_grill_branches_store_stocks.user_id',
                            'lolo_pinoy_grill_branches_store_stocks.date',
                            'lolo_pinoy_grill_branches_store_stocks.dr_no',
                            'lolo_pinoy_grill_branches_store_stocks.supplier',
                            'lolo_pinoy_grill_branches_store_stocks.product_name',
                            'lolo_pinoy_grill_branches_store_stocks.qty',
                            'lolo_pinoy_grill_branches_store_stocks.unit',
                            'lolo_pinoy_grill_branches_store_stocks.product_in',
                            'lolo_pinoy_grill_branches_store_stocks.product_out',
                            'lolo_pinoy_grill_branches_store_stocks.amount',
                            'lolo_pinoy_grill_branches_store_stocks.branch',
                            'lolo_pinoy_grill_branches_store_stocks.created_by',
                            'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                            'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                            ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                            ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchBanilad)
                            ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagBanilad)
                            ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                            ->get()->toArray();

            $flagBaniladDrinks = "Drinks";
            $getStockStatusBaniladDrinks = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchBanilad)
                                ->where('lolo_pinoy_grill_branches_store_stocks.flag', $flagBaniladDrinks)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                ->get()->toArray();
    
    
            $branchGqs = "GQS";
            $getStockStatusGqses = DB::table(
                                'lolo_pinoy_grill_branches_store_stocks')
                                ->select(
                                'lolo_pinoy_grill_branches_store_stocks.id',
                                'lolo_pinoy_grill_branches_store_stocks.user_id',
                                'lolo_pinoy_grill_branches_store_stocks.date',
                                'lolo_pinoy_grill_branches_store_stocks.dr_no',
                                'lolo_pinoy_grill_branches_store_stocks.supplier',
                                'lolo_pinoy_grill_branches_store_stocks.product_name',
                                'lolo_pinoy_grill_branches_store_stocks.qty',
                                'lolo_pinoy_grill_branches_store_stocks.unit',
                                'lolo_pinoy_grill_branches_store_stocks.product_in',
                                'lolo_pinoy_grill_branches_store_stocks.product_out',
                                'lolo_pinoy_grill_branches_store_stocks.amount',
                                'lolo_pinoy_grill_branches_store_stocks.branch',
                                'lolo_pinoy_grill_branches_store_stocks.created_by',
                                'lolo_pinoy_grill_branches_store_stock_products.store_stock_id',
                                'lolo_pinoy_grill_branches_store_stock_products.product_id_no')
                                ->join('lolo_pinoy_grill_branches_store_stock_products', 'lolo_pinoy_grill_branches_store_stocks.id', '=', 'lolo_pinoy_grill_branches_store_stock_products.store_stock_id')
                                ->where('lolo_pinoy_grill_branches_store_stocks.branch', $branchGqs)
                                ->orderBy('lolo_pinoy_grill_branches_store_stocks.id', 'desc')
                                ->get()->toArray();

      
        return view('lolo-pinoy-grill-branches-stock-status', compact('data', 'getStockStatusUrgellos', 
        'getStockStatusUrgelloDrinks',
        'getStockStatusVelezes', 'getStockStatusVelezDrinks', 'getStockStatusBanilads', 'getStockStatusGqses'));
    }
    
    public function viewBills($id){
        
        $viewBill = LoloPinoyGrillBranchesUtility::find($id);
        //view particulars
        $viewParticulars = LoloPinoyGrillBranchesPaymentVoucher::where('sub_category_account_id', $id)->get()->toArray();

        return view('lolo-pinoy-grill-branches-view-utility', compact('viewBill', 'viewParticulars'));
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
                'lolo_pinoy_grill_branches_utilities')
                ->where('account_id', $request->accountId)
                ->get()->first();

        if($target ==  NULL){
    
            $addInternet = new LoloPinoyGrillBranchesUtility([
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
                'lolo_pinoy_grill_branches_utilities')
                ->where('account_id', $request->accountId)
                ->get()->first();

        if($target == NULL){
            $addBills = new LoloPinoyGrillBranchesUtility([
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

        $vecoDocuments = LoloPinoyGrillBranchesUtility::where('flag', $flag)->get()->toArray();

        $mcwdDocuments = LoloPinoyGrillBranchesUtility::where('flag', $flagMCWD)->get()->toArray();

        $internetDocuments = LoloPinoyGrillBranchesUtility::where('flag', $flagInternet)->get()->toArray();

        return view('lolo-pinoy-grill-branches-utilities', compact('vecoDocuments', 'mcwdDocuments', 'internetDocuments'));
    }

    //
    public function viewPettyCash($id){
        $moduleName = "Petty Cash";
        $getPettyCash = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.id', $id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->get();

        $getPettyCashSummaries = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->get()->toArray();

        //total
        $totalPettyCash = LoloPinoyGrillBranchesPettyCash::where('id', $id)->where('pc_id', NULL)->sum('amount');

        $pettyCashSummaryTotal = LoloPinoyGrillBranchesPettyCash::where('pc_id', $id)->sum('amount');

        $sum = $totalPettyCash + $pettyCashSummaryTotal;

        return view('lolo-pinoy-grill-branches-view-petty-cash', compact('getPettyCash', 'getPettyCashSummaries', 'sum'));
    }

    //
    public function pettyCashList(){
        $moduleName = "Petty Cash";
        $pettyCashLists = DB::table(
                                'lolo_pinoy_grill_branches_petty_cashes')
                                ->select( 
                                'lolo_pinoy_grill_branches_petty_cashes.id',
                                'lolo_pinoy_grill_branches_petty_cashes.user_id',
                                'lolo_pinoy_grill_branches_petty_cashes.pc_id',
                                'lolo_pinoy_grill_branches_petty_cashes.date',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_name',
                                'lolo_pinoy_grill_branches_petty_cashes.petty_cash_summary',
                                'lolo_pinoy_grill_branches_petty_cashes.amount',
                                'lolo_pinoy_grill_branches_petty_cashes.created_by',
                                'lolo_pinoy_grill_branches_petty_cashes.deleted_at',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_petty_cashes.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_petty_cashes.pc_id', NULL)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->where('lolo_pinoy_grill_branches_petty_cashes.deleted_at', NULL)
                                ->orderBy('lolo_pinoy_grill_branches_petty_cashes.id', 'desc')
                                ->get()->toArray();

        return view('lolo-pinoy-grill-branches-petty-cash-list', compact('pettyCashLists'));
    }

    //
    public function salesInvoiceForm(Request $request){
        $data = $request->session()->get('sessionBranch');
       if(empty($data)){
            return view('lolo-pinoy-grill-branches-login-form', compact('data'));      
       }else{
            return redirect()->route('salesInvoiceFormBranch', ['type'=>$data]);
        
       }
         
    }

    //
    public function reqTransactionList(){
        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        return view('lolo-pinoy-grill-branches-requisition-slip-transaction-list', compact('requisitionLists'));
    }

    //  
    public function printRS($id){
    
        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);

          //
        $rSlips = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', $id)->get()->toArray();


        $pdf = PDF::loadView('printRS', compact('requisitionSlip', 'rSlips'));

        return $pdf->download('lolo-pinoy-grill-branches-requisition-slip.pdf');

    }

    //
    public function requisitionSlipList(){
        $moduleName = "Requisition Slip";
        $requisitionLists = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.rs_id', NULL)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->where('lolo_pinoy_grill_branches_requisition_slips.deleted_at', NULL)
                        ->orderBy('lolo_pinoy_grill_branches_requisition_slips.id', 'desc')
                        ->get()->toArray();

        return view('lolo-pinoy-grill-branches-all-lists', compact('requisitionLists'));
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
        return view('add-new-lolo-pinoy-grill-branches-requisition-slip', compact('id'));
    }

    //
    public function requisitionSlip(){
    
        return view('lolo-pinoy-grill-branches-requisition-slip');
    }

    //
    public function printPayables($id){
        $moduleName = "Payment Voucher";
        $payableId = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.id', $id)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->get();

       //

        //getParticular details
        $getParticulars = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
    
        $getChequeNumbers = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
        $amount1 = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
       

        $pdf = PDF::loadView('printPayablesLoloPinoyGrillBranches', compact('payableId',  
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));
        return $pdf->download('lolo-pinoy-grill-branches-payment-voucher.pdf');
    }   

    //
    public function viewPayableDetails($id){
         $moduleName = "Payment Voucher";
         $viewPaymentDetail = DB::table(
                             'lolo_pinoy_grill_branches_payment_vouchers')
                             ->select( 
                             'lolo_pinoy_grill_branches_payment_vouchers.id',
                             'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                             'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                             'lolo_pinoy_grill_branches_payment_vouchers.date',
                             'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                             'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                             'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                             'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                             'lolo_pinoy_grill_branches_payment_vouchers.amount',
                             'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                             'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                             'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                             'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                             'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                             'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                             'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                             'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                             'lolo_pinoy_grill_branches_payment_vouchers.category',
                             'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                             'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                             'lolo_pinoy_grill_branches_payment_vouchers.status',
                             'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                             'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                             'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                             'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                             'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                             'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                             'lolo_pinoy_grill_branches_codes.module_id',
                             'lolo_pinoy_grill_branches_codes.module_code',
                             'lolo_pinoy_grill_branches_codes.module_name')
                             ->join('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                             ->where('lolo_pinoy_grill_branches_payment_vouchers.id', $id)
                             ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                             ->get();

        //
        $getViewPaymentDetails = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->get()->toArray();

           //getParticular details
           $getParticulars = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
       

        return view('view-lolo-pinoy-grill-branches-payable-details', compact('viewPaymentDetail', 'getViewPaymentDetails', 'getParticulars'));
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

                    $payables = LoloPinoyGrillBranchesPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
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
    public function addParticulars(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = LoloPinoyGrillBranchesPaymentVoucher::find($id);

        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');



        //get current voucher ref number
        $voucherRef = $particulars['voucher_ref_number'];

        $subAccountId = $particulars['sub_category_account_id'];
        
        $addParticulars = new LoloPinoyGrillBranchesPaymentVoucher([
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

        return redirect('lolo-pinoy-grill-branches/edit-lolo-pinoy-grill-branches-payables-detail/'.$id);
    }

    //
    public function addPayment(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = LoloPinoyGrillBranchesPaymentVoucher::find($id);

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');


        //save payment cheque num and cheque amount
        $addPayment = new LoloPinoyGrillBranchesPaymentVoucher([
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

        return redirect()->route('editPayablesDetailLpBranches', ['id'=>$id]);

    }

    //
    public function editPayablesDetail(Request $request, $id){
            $moduleName = "Payment Voucher";
            $transactionList = DB::table(
                                'lolo_pinoy_grill_branches_payment_vouchers')
                                ->select( 
                                'lolo_pinoy_grill_branches_payment_vouchers.id',
                                'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                                'lolo_pinoy_grill_branches_payment_vouchers.date',
                                'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                                'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                                'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                                'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                                'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                                'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.category',
                                'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                                'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                                'lolo_pinoy_grill_branches_payment_vouchers.status',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                                'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                                'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                                'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                                'lolo_pinoy_grill_branches_codes.module_id',
                                'lolo_pinoy_grill_branches_codes.module_code',
                                'lolo_pinoy_grill_branches_codes.module_name')
                                ->leftjoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                                ->where('lolo_pinoy_grill_branches_payment_vouchers.id', $id)
                                ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                                ->get();


          //
        $getChequeNumbers = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();
        
        $getCashAmounts = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
      
        
        //getParticular details
        $getParticulars = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
         //amount
        $amount1 = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('amount');
         
         $sum = $amount1 + $amount2;

        $chequeAmount1 = LoloPinoyGrillBranchesPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
      

         return view('lolo-pinoy-grill-branches-payables-detail', compact('transactionList', 
            'getChequeNumbers','sum', 'getParticulars', 'sumCheque', 'getCashAmounts'));
    }

    //
    public function transactionList(){
        $moduleName = "Payment Voucher";
        $getTransactionLists = DB::table(
                            'lolo_pinoy_grill_branches_payment_vouchers')
                            ->select( 
                            'lolo_pinoy_grill_branches_payment_vouchers.id',
                            'lolo_pinoy_grill_branches_payment_vouchers.user_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.pv_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.date',
                            'lolo_pinoy_grill_branches_payment_vouchers.paid_to',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_no',
                            'lolo_pinoy_grill_branches_payment_vouchers.account_name',
                            'lolo_pinoy_grill_branches_payment_vouchers.particulars',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.method_of_payment',
                            'lolo_pinoy_grill_branches_payment_vouchers.prepared_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.approved_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.date_apprroved',
                            'lolo_pinoy_grill_branches_payment_vouchers.received_by_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.created_by',
                            'lolo_pinoy_grill_branches_payment_vouchers.invoice_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.issued_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.category',
                            'lolo_pinoy_grill_branches_payment_vouchers.amount_due',
                            'lolo_pinoy_grill_branches_payment_vouchers.delivered_date',
                            'lolo_pinoy_grill_branches_payment_vouchers.status',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_number',
                            'lolo_pinoy_grill_branches_payment_vouchers.cheque_amount',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category',
                            'lolo_pinoy_grill_branches_payment_vouchers.sub_category_account_id',
                            'lolo_pinoy_grill_branches_payment_vouchers.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                            ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_payment_vouchers.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.pv_id', NULL)
                            ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                            ->where('lolo_pinoy_grill_branches_payment_vouchers.deleted_at', NULL)
                            ->orderBy('lolo_pinoy_grill_branches_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        
        
        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = LoloPinoyGrillBranchesPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');

        return view('lolo-pinoy-grill-branches-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));
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

        //get the latest insert id query in table lolo_pinoy_grill_branches_codes
        $dataVoucherRef = DB::select('SELECT id, lolo_pinoy_branches_code  FROM lolo_pinoy_grill_branches_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 reference number
        if(isset($dataVoucherRef[0]->lolo_pinoy_branches_code) != 0){
            //if code is not 0
            $newVoucherRef = $dataVoucherRef[0]->lolo_pinoy_branches_code +1;
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

            $supplierExp = NULL;
            $supplierExp1 = NULL;
       }else if($request->get('category') == "Utilities"){

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
                        'lolo_pinoy_grill_branches_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...   
            $addPaymentVoucher = new LoloPinoyGrillBranchesPaymentVoucher([
                'user_id'=>$user->id,
                'paid_to'=>$request->get('paidTo'),
                'method_of_payment'=>$request->get('paymentMethod'),
                'account_name'=>$request->get('accountName'),
                'invoice_number'=>$request->get('invoiceNumber'),
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
             
             $lpBranches = new LoloPinoyGrillBranchesCode([
                'user_id'=>$user->id,
                'lolo_pinoy_branches_code'=>$uVoucher,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
             ]);
             $lpBranches->save();

            return redirect()->route('editPayablesDetailLpBranches', ['id'=>$insertedId]);
        }else{
            return redirect()->route('paymentVoucherFormLpBranches')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    }


    //
    public function paymentVoucherForm(){
        $getAllFlags = LoloPinoyGrillBranchesUtility::where('u_id', NULL)->get()->toArray();

         //get suppliers
         $suppliers = LoloPinoyGrillBranchesSupplier::get()->toArray();

         $pettyCashes = LoloPinoyGrillBranchesPettyCash::with(['user', 'petty_cashes'])
                                                        ->where('pc_id', NULL)
                                                        ->where('deleted_at', NULL)
                                                        ->get();


        return view('payment-voucher-form-lolo-pinoy-grill-branches', compact('getAllFlags', 'suppliers', 'pettyCashes'));
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data =  $request->session()->get('sessionBranch');

        $getDateToday = date("Y-m-d");
        $getTransactionBranches = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)
                                ->where('branch', $data)
                                ->where('date', $getDateToday)
                                ->withTrashed()
                                ->get()->toArray();
                                

        $sum = LoloPinoyGrillBranchesSalesForm::where('sf_id', NULL)
                ->where('branch', $data)
                ->where('date', $getDateToday)
                ->withTrashed()
                ->sum('total_amount_of_sales');
               

        return view('lolo-pinoy-grill-branches', compact('getTransactionBranches', 'data', 'sum'));


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

          //get the latest insert id query in table lolo_pinoy_grill_branches_codes
          $data = DB::select('SELECT id, lolo_pinoy_branches_code FROM lolo_pinoy_grill_branches_codes ORDER BY id DESC LIMIT 1');
        
          //if code is not zero add plus 1
           if(isset($data[0]->lolo_pinoy_branches_code) != 0){
              //if code is not 0
              $newNum = $data[0]->lolo_pinoy_branches_code +1;
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

        $moduleCode = "RS-";
        $moduleName = "Requisition Slip";

        $lpBranches = new LoloPinoyGrillBranchesCode([
            'user_id'=>$user->id,
            'lolo_pinoy_branches_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,
        ]);
        $lpBranches->save();

        return redirect()->route('editLpBranches', ['id'=>$insertedId]);
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        $moduleName = "Requisition Slip";
        $requisitionSlip = DB::table(
                        'lolo_pinoy_grill_branches_requisition_slips')
                        ->select(
                            'lolo_pinoy_grill_branches_requisition_slips.id',
                            'lolo_pinoy_grill_branches_requisition_slips.user_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_id',
                            'lolo_pinoy_grill_branches_requisition_slips.rs_number',
                            'lolo_pinoy_grill_branches_requisition_slips.requesting_department',
                            'lolo_pinoy_grill_branches_requisition_slips.request_date',
                            'lolo_pinoy_grill_branches_requisition_slips.date_released',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_requested',
                            'lolo_pinoy_grill_branches_requisition_slips.unit',
                            'lolo_pinoy_grill_branches_requisition_slips.item',
                            'lolo_pinoy_grill_branches_requisition_slips.quantity_given',
                            'lolo_pinoy_grill_branches_requisition_slips.released_by',
                            'lolo_pinoy_grill_branches_requisition_slips.received_by',
                            'lolo_pinoy_grill_branches_requisition_slips.created_by',
                            'lolo_pinoy_grill_branches_requisition_slips.deleted_at',
                            'lolo_pinoy_grill_branches_codes.lolo_pinoy_branches_code',
                            'lolo_pinoy_grill_branches_codes.module_id',
                            'lolo_pinoy_grill_branches_codes.module_code',
                            'lolo_pinoy_grill_branches_codes.module_name')
                        ->leftJoin('lolo_pinoy_grill_branches_codes', 'lolo_pinoy_grill_branches_requisition_slips.id', '=', 'lolo_pinoy_grill_branches_codes.module_id')
                        ->where('lolo_pinoy_grill_branches_requisition_slips.id', $id)
                        ->where('lolo_pinoy_grill_branches_codes.module_name', $moduleName)
                        ->get();

        $rSlips = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', $id)->get()->toArray();
    

        return view('view-lolo-pinoy-grill-branches-requisition-slip', compact('requisitionSlip', 'rSlips'));

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
    
        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);

        $rSlips = LoloPinoyGrillBranchesRequisitionSlip::where('rs_id', $id)->get()->toArray();

        //get users
        $getUsers = User::get()->toArray();
       

        return view('edit-lolo-pinoy-grill-branches-requisition-slip', compact('requisitionSlip', 'rSlips', 'getUsers'));

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

    public function destroyDeliveryInTransaction($id){
        $destroyDeliveryTransaction  = LoloPinoyGrillBranchesStoreStock::find($id);
        $destroyDeliveryTransaction->delete();
    }

    public function destroyUtility($id){
        $utility = LoloPinoyGrillBranchesUtility::find($id);
        $utility->delete();
    }

    public function destroyPettyCash($id){
        $pettyCash = LoloPinoyGrillBranchesPettyCash::find($id);
        $pettyCash->delete();
    }

    public function destroyTransactionList($id){
        $transactionList = LoloPinoyGrillBranchesPaymentVoucher::find($id);
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
        //
        $requisitionSlip = LoloPinoyGrillBranchesRequisitionSlip::find($id);
        $requisitionSlip->delete();
    }
}
