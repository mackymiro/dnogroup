<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Auth;
use Session;
use PDF;
use App\User;
use App\WimpysFoodExpressPaymentVoucher;
use App\WimpysFoodExpressCode;
use App\WimpysFoodExpressSupplier;
use App\WimpysFoodExpressPurchaseOrder;
use App\WimpysFoodExpressBillingStatement; 
use App\WimpysFoodExpressStatementOfAccount;
use App\WimpysFoodExpressStockInventory; 
use App\WimpysFoodExpressOrderForm;
use App\WimpysFoodExpressMenuList;
use App\WimpysFoodExpressClientBookingForm;
use App\WimpysFoodExpressDeliveryReceipt;
use App\WimpysFoodExpressRawMaterial;
use App\WimpysFoodExpressRawMaterialProduct; 

class WimpysFoodExpressController extends Controller
{

    CONST ORDER_FORM_CB = "Client Booking Form";
    CONST ORDER_FORM_DR = "DR";
    CONST PAID = "PAID";

    public function viewStockInventory($id){
        $viewStockDetail = WimpysFoodExpressRawMaterial::find($id);

        //transaction table
        $getViewStockDetails = WimpysFoodExpressRawMaterial::where('rm_id', $id)->get()->toArray();


        return view('view-wimpys-food-express-stock-inventory', compact('viewStockDetail', 'getViewStockDetails'));

    }

    public function stockInventoryProducts(){
        $getRawMaterials = DB::table(
                        'wimpys_food_express_raw_materials')
                        ->select(
                            'wimpys_food_express_raw_materials.id',
                            'wimpys_food_express_raw_materials.user_id',
                            'wimpys_food_express_raw_materials.rm_id',
                            'wimpys_food_express_raw_materials.product_name',
                            'wimpys_food_express_raw_materials.unit_price',
                            'wimpys_food_express_raw_materials.unit',
                            'wimpys_food_express_raw_materials.in',
                            'wimpys_food_express_raw_materials.out',
                            'wimpys_food_express_raw_materials.stock_amount',
                            'wimpys_food_express_raw_materials.remaining_stock',
                            'wimpys_food_express_raw_materials.amount',
                            'wimpys_food_express_raw_materials.supplier',
                            'wimpys_food_express_raw_materials.date',
                            'wimpys_food_express_raw_materials.item',
                            'wimpys_food_express_raw_materials.description',
                            'wimpys_food_express_raw_materials.reference_no',
                            'wimpys_food_express_raw_materials.qty',
                            'wimpys_food_express_raw_materials.requesting_branch',
                            'wimpys_food_express_raw_materials.cheque_no_issued',
                            'wimpys_food_express_raw_materials.status',
                            'wimpys_food_express_raw_materials.created_by',
                            'wimpys_food_express_raw_material_products.raw_materials_id',
                            'wimpys_food_express_raw_material_products.branch',
                            'wimpys_food_express_raw_material_products.product_id_no')
                        ->join('wimpys_food_express_raw_material_products', 'wimpys_food_express_raw_materials.id', '=', 'wimpys_food_express_raw_material_products.raw_materials_id')
                        ->where('wimpys_food_express_raw_materials.rm_id', NULL)
                        ->orderBy('wimpys_food_express_raw_materials.id', 'desc')
                        ->get()->toArray();

        
        //count the total stock out amount value
        $countStockAmount = WimpysFoodExpressRawMaterial::all()->sum('stock_amount');
        
        //count the total amount 
        $countTotalAmount = WimpysFoodExpressRawMaterial::all()->sum('amount');

        return view('stocks-inventory-wimpys-food-express', compact('getRawMaterials', 'countStockAmount', 'countTotalAmount'));


    }

    public function updateRawMaterialProducts(Request $request){
        $updateRawMaterial = WimpysFoodExpressRawMaterial::find($request->id);

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

    public function addDIRST(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $rawMaterial = WimpysFoodExpressRawMaterial::find($request->id);

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

        $addDeliveryIn = new WimpysFoodExpressRawMaterial([
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
                    'wimpys_food_express_raw_materials')
                    ->select(
                        'wimpys_food_express_raw_materials.id',
                        'wimpys_food_express_raw_materials.user_id',
                        'wimpys_food_express_raw_materials.rm_id',
                        'wimpys_food_express_raw_materials.product_name',
                        'wimpys_food_express_raw_materials.unit_price',
                        'wimpys_food_express_raw_materials.unit',
                        'wimpys_food_express_raw_materials.in',
                        'wimpys_food_express_raw_materials.out',
                        'wimpys_food_express_raw_materials.stock_amount',
                        'wimpys_food_express_raw_materials.remaining_stock',
                        'wimpys_food_express_raw_materials.amount',
                        'wimpys_food_express_raw_materials.supplier',
                        'wimpys_food_express_raw_materials.date',
                        'wimpys_food_express_raw_materials.item',
                        'wimpys_food_express_raw_materials.description',
                        'wimpys_food_express_raw_materials.reference_no',
                        'wimpys_food_express_raw_materials.qty',
                        'wimpys_food_express_raw_materials.requesting_branch',
                        'wimpys_food_express_raw_materials.cheque_no_issued',
                        'wimpys_food_express_raw_materials.status',
                        'wimpys_food_express_raw_materials.created_by',
                        'wimpys_food_express_raw_material_products.raw_materials_id',
                        'wimpys_food_express_raw_material_products.branch',
                        'wimpys_food_express_raw_material_products.product_id_no')
                    ->join('wimpys_food_express_raw_material_products', 'wimpys_food_express_raw_materials.id', '=', 'wimpys_food_express_raw_material_products.raw_materials_id')
                    ->where('wimpys_food_express_raw_materials.id', $id)
                    ->get();
                    
        //transaction table
        $getViewRawDetails = WimpysFoodExpressRawMaterial::where('rm_id', $id)->get()->toArray();
        
        return view('view-wimpys-food-express-raw-material-details', compact('viewRawDetail', 'getViewRawDetails'));

    }

    public function addProductRawMaterial(Request $request){
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
        $dataProductId = DB::select('SELECT id, product_id_no FROM wimpys_food_express_raw_material_products ORDER BY id DESC LIMIT 1');

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
                  'wimpys_food_express_raw_materials')
                  ->where('product_name', $request->productName)
                  ->get()->first(); 

        if($target === NULL){
            $addNewRawMaterial = new WimpysFoodExpressRawMaterial([
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
             $addNewProd = new WimpysFoodExpressRawMaterialProduct([
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
                    'wimpys_food_express_raw_materials')
                    ->select(
                        'wimpys_food_express_raw_materials.id',
                        'wimpys_food_express_raw_materials.user_id',
                        'wimpys_food_express_raw_materials.rm_id',
                        'wimpys_food_express_raw_materials.product_name',
                        'wimpys_food_express_raw_materials.unit_price',
                        'wimpys_food_express_raw_materials.unit',
                        'wimpys_food_express_raw_materials.in',
                        'wimpys_food_express_raw_materials.out',
                        'wimpys_food_express_raw_materials.stock_amount',
                        'wimpys_food_express_raw_materials.remaining_stock',
                        'wimpys_food_express_raw_materials.amount',
                        'wimpys_food_express_raw_materials.supplier',
                        'wimpys_food_express_raw_materials.date',
                        'wimpys_food_express_raw_materials.item',
                        'wimpys_food_express_raw_materials.description',
                        'wimpys_food_express_raw_materials.reference_no',
                        'wimpys_food_express_raw_materials.qty',
                        'wimpys_food_express_raw_materials.requesting_branch',
                        'wimpys_food_express_raw_materials.cheque_no_issued',
                        'wimpys_food_express_raw_materials.status',
                        'wimpys_food_express_raw_materials.created_by',
                        'wimpys_food_express_raw_material_products.raw_materials_id',
                        'wimpys_food_express_raw_material_products.branch',
                        'wimpys_food_express_raw_material_products.product_id_no')
                    ->join('wimpys_food_express_raw_material_products', 'wimpys_food_express_raw_materials.id', '=', 'wimpys_food_express_raw_material_products.raw_materials_id')
                    ->where('wimpys_food_express_raw_materials.rm_id', NULL)
                    ->orderBy('wimpys_food_express_raw_materials.id', 'desc')
                    ->get()->toArray();

        return view('wimpys-food-express-stock-raw-materials', compact('getRawMaterials'));
    }

    public function printDelivery($id){
        $moduleName = "Delivery Receipt";
        $deliveryId = DB::table(
                        'wimpys_food_express_delivery_receipts')
                        ->select( 
                        'wimpys_food_express_delivery_receipts.id',
                        'wimpys_food_express_delivery_receipts.user_id',
                        'wimpys_food_express_delivery_receipts.dr_id',
                        'wimpys_food_express_delivery_receipts.sold_to',
                        'wimpys_food_express_delivery_receipts.delivered_to',
                        'wimpys_food_express_delivery_receipts.time',
                        'wimpys_food_express_delivery_receipts.date',
                        'wimpys_food_express_delivery_receipts.unit',
                        'wimpys_food_express_delivery_receipts.date_to_be_delivered',
                        'wimpys_food_express_delivery_receipts.contact_person',
                        'wimpys_food_express_delivery_receipts.mobile_num',
                        'wimpys_food_express_delivery_receipts.product_id',
                        'wimpys_food_express_delivery_receipts.unit_price',
                        'wimpys_food_express_delivery_receipts.qty',
                        'wimpys_food_express_delivery_receipts.description',
                        'wimpys_food_express_delivery_receipts.price',
                        'wimpys_food_express_delivery_receipts.total',
                        'wimpys_food_express_delivery_receipts.special_instruction',
                        'wimpys_food_express_delivery_receipts.consignee_name',
                        'wimpys_food_express_delivery_receipts.consignee_contact_num',
                        'wimpys_food_express_delivery_receipts.status',
                        'wimpys_food_express_delivery_receipts.prepared_by',
                        'wimpys_food_express_delivery_receipts.checked_by',
                        'wimpys_food_express_delivery_receipts.received_by',
                        'wimpys_food_express_delivery_receipts.created_by',
                        'wimpys_food_express_delivery_receipts.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_delivery_receipts.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_delivery_receipts.id', $id)
                        ->where('wimpys_food_express_codes.module_name', $moduleName)
                         ->get();


        $deliveryReceipts = WimpysFoodExpressDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        //count the total unit price
        $countTotalUnitPrice = WimpysFoodExpressDeliveryReceipt::where('id', $id)->sum('unit_price');
        
        //
        $countUnitPrice = WimpysFoodExpressDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


        //count the total amount
        $countTotalAmount = WimpysFoodExpressDeliveryReceipt::where('id', $id)->sum('total');
        
        //
        $countAmount = WimpysFoodExpressDeliveryReceipt::where('dr_id', $id)->sum('total');

        $sum2  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printDeliveryWimpys', compact('deliveryId', 'deliveryReceipts', 'sum', 'sum2'));

        return $pdf->download('wimpys-food-express-delivery-receipt.pdf');
    }

    public function viewDeliveryReceipt($id){
        $moduleName = "Delivery Receipt";
        $viewDeliveryReceipt = DB::table(
                            'wimpys_food_express_delivery_receipts')
                            ->select( 
                            'wimpys_food_express_delivery_receipts.id',
                            'wimpys_food_express_delivery_receipts.user_id',
                            'wimpys_food_express_delivery_receipts.dr_id',
                            'wimpys_food_express_delivery_receipts.sold_to',
                            'wimpys_food_express_delivery_receipts.delivered_to',
                            'wimpys_food_express_delivery_receipts.time',
                            'wimpys_food_express_delivery_receipts.date',
                            'wimpys_food_express_delivery_receipts.unit',
                            'wimpys_food_express_delivery_receipts.date_to_be_delivered',
                            'wimpys_food_express_delivery_receipts.product_id',
                            'wimpys_food_express_delivery_receipts.contact_person',
                            'wimpys_food_express_delivery_receipts.mobile_num',
                            'wimpys_food_express_delivery_receipts.qty',
                            'wimpys_food_express_delivery_receipts.description',
                            'wimpys_food_express_delivery_receipts.unit_price',
                            'wimpys_food_express_delivery_receipts.price',
                            'wimpys_food_express_delivery_receipts.total',
                            'wimpys_food_express_delivery_receipts.special_instruction',
                            'wimpys_food_express_delivery_receipts.consignee_name',
                            'wimpys_food_express_delivery_receipts.consignee_contact_num',
                            'wimpys_food_express_delivery_receipts.status',
                            'wimpys_food_express_delivery_receipts.prepared_by',
                            'wimpys_food_express_delivery_receipts.checked_by',
                            'wimpys_food_express_delivery_receipts.received_by',
                            'wimpys_food_express_delivery_receipts.created_by',
                            'wimpys_food_express_delivery_receipts.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_delivery_receipts.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_delivery_receipts.id', $id)
                            ->where('wimpys_food_express_codes.module_name', $moduleName)
                           
                            ->get()->toArray();

        $deliveryReceipts = WimpysFoodExpressDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        //count the total unit price
        $countTotalUnitPrice = WimpysFoodExpressDeliveryReceipt::where('id', $id)->sum('unit_price');
        
        //
        $countUnitPrice = WimpysFoodExpressDeliveryReceipt::where('dr_id', $id)->sum('unit_price');

        $sum  = $countTotalUnitPrice + $countUnitPrice;


            //count the total amount
        $countTotalAmount = WimpysFoodExpressDeliveryReceipt::where('id', $id)->sum('total');
        
        //
        $countAmount = WimpysFoodExpressDeliveryReceipt::where('dr_id', $id)->sum('total');

        $sum2  = $countTotalAmount + $countAmount;

         return view('view-wimpys-food-express-delivery-receipt', compact('viewDeliveryReceipt', 
         'deliveryReceipts', 'sum', 'sum2'));

    }

    public function deliveryReceiptLists(){
         //getAllDeliveryReceipt
         $moduleName = "Delivery Receipt";
         $getAllDeliveryReceipts = DB::table(
                                 'wimpys_food_express_delivery_receipts')
                                 ->select( 
                                 'wimpys_food_express_delivery_receipts.id',
                                 'wimpys_food_express_delivery_receipts.user_id',
                                 'wimpys_food_express_delivery_receipts.dr_id',
                                 'wimpys_food_express_delivery_receipts.sold_to',
                                 'wimpys_food_express_delivery_receipts.delivered_to',
                                 'wimpys_food_express_delivery_receipts.time',
                                 'wimpys_food_express_delivery_receipts.date',
                                 'wimpys_food_express_delivery_receipts.date_to_be_delivered',
                                 'wimpys_food_express_delivery_receipts.contact_person',
                                 'wimpys_food_express_delivery_receipts.mobile_num',
                                 'wimpys_food_express_delivery_receipts.product_id',
                                 'wimpys_food_express_delivery_receipts.qty',
                                 'wimpys_food_express_delivery_receipts.description',
                                 'wimpys_food_express_delivery_receipts.price',
                                 'wimpys_food_express_delivery_receipts.total',
                                 'wimpys_food_express_delivery_receipts.special_instruction',
                                 'wimpys_food_express_delivery_receipts.consignee_name',
                                 'wimpys_food_express_delivery_receipts.consignee_contact_num',
                                 'wimpys_food_express_delivery_receipts.status',
                                 'wimpys_food_express_delivery_receipts.prepared_by',
                                 'wimpys_food_express_delivery_receipts.checked_by',
                                 'wimpys_food_express_delivery_receipts.received_by',
                                 'wimpys_food_express_delivery_receipts.created_by',
                                 'wimpys_food_express_delivery_receipts.deleted_at',
                                 'wimpys_food_express_codes.wimpys_food_express_code',
                                 'wimpys_food_express_codes.module_id',
                                 'wimpys_food_express_codes.module_code',
                                 'wimpys_food_express_codes.module_name')
                                 ->join('wimpys_food_express_codes', 'wimpys_food_express_delivery_receipts.id', '=', 'wimpys_food_express_codes.module_id')
                                 ->where('wimpys_food_express_delivery_receipts.dr_id', NULL)
                                 ->where('wimpys_food_express_codes.module_name', $moduleName)
                                 ->where('wimpys_food_express_delivery_receipts.deleted_at', NULL)
                                 ->orderBy('wimpys_food_express_delivery_receipts.id', 'desc')
                                 ->get()->toArray();
 
        
     
         return view('wimpys-food-express-delivery-receipt-lists', compact('getAllDeliveryReceipts'));
    
    }

    public function updateDr(Request $request, $id){
        
        $delivery = WimpysFoodExpressDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;
        
        $delivery->product_id = $request->get('productId');
        $delivery->qty = $qty;
        $delivery->unit = $request->get('unit');
        $delivery->description = $request->get('itemDescription');
        $delivery->unit_price = $unitPrice;
        $delivery->amount = $sum;

        $delivery->save();


        Session::flash('SuccessEdit', 'Successfully updated');

       return redirect()->route('editDeliveryReceiptWimpys', ['id'=>$request->get('drId')]);
    }

    public function updateDeliveryReceipt(Request $request, $id){

        $updateDeliveryReceipt = WimpysFoodExpressDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $updateDeliveryReceipt->date = $request->get('date');
        $updateDeliveryReceipt->sold_to = $request->get('soldTo');
        $updateDeliveryReceipt->time = $request->get('time');
        $updateDeliveryReceipt->delivered_to = $request->get('deliveredTo');
        $updateDeliveryReceipt->delivered_for = $request->get('deliveredFor');
        $updateDeliveryReceipt->contact_person = $request->get('contactPerson');
        $updateDeliveryReceipt->mobile_num = $request->get('mobile');
        $updateDeliveryReceipt->special_instruction = $request->get('specialInstruction');
        $updateDeliveryReceipt->consignee_name = $request->get('consigneeName');
        $updateDeliveryReceipt->consignee_contact_num = $request->get('consigneeContact');
        $updateDeliveryReceipt->date_to_be_delivered = $request->get('dateDelivered');
        $updateDeliveryReceipt->product_id  = $request->get('productId');
        $updateDeliveryReceipt->qty = $request->get('qty');
        $updateDeliveryReceipt->unit_price = $unitPrice;
        $updateDeliveryReceipt->description = $request->get('itemDescription');
        $updateDeliveryReceipt->total = $sum; 

        $updateDeliveryReceipt->save();

        Session::flash('updateSuccessfull', 'Successfully updated');

        return redirect()->route('editDeliveryReceiptWimpys', ['id'=>$id]);
    }

    public function addNewDeliveryReceiptData(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName.$lastName;

        $deliveryReceipt = WimpysFoodExpressDeliveryReceipt::find($id);

        $qty = $request->get('qty');
        $unitPrice = $request->get('unitPrice');

        $compute = $qty * $unitPrice;
        $sum = $compute;

        $getAmount = $deliveryReceipt->total_amount + $sum;


        $avail = $request->get('productId'); 
        $availExp = explode("-", $avail);

        
        $rawMaterial = DB::table(
                    'wimpys_food_express_raw_materials')
                    ->select(
                        'wimpys_food_express_raw_materials.id',
                        'wimpys_food_express_raw_materials.user_id',
                        'wimpys_food_express_raw_materials.rm_id',
                        'wimpys_food_express_raw_materials.product_name',
                        'wimpys_food_express_raw_materials.unit_price',
                        'wimpys_food_express_raw_materials.unit',
                        'wimpys_food_express_raw_materials.in',
                        'wimpys_food_express_raw_materials.out',
                        'wimpys_food_express_raw_materials.stock_amount',
                        'wimpys_food_express_raw_materials.remaining_stock',
                        'wimpys_food_express_raw_materials.amount',
                        'wimpys_food_express_raw_materials.supplier',
                        'wimpys_food_express_raw_materials.date',
                        'wimpys_food_express_raw_materials.item',
                        'wimpys_food_express_raw_materials.description',
                        'wimpys_food_express_raw_materials.reference_no',
                        'wimpys_food_express_raw_materials.qty',
                        'wimpys_food_express_raw_materials.requesting_branch',
                        'wimpys_food_express_raw_materials.cheque_no_issued',
                        'wimpys_food_express_raw_materials.status',
                        'wimpys_food_express_raw_materials.created_by',
                        'wimpys_food_express_raw_material_products.raw_materials_id',
                        'wimpys_food_express_raw_material_products.branch',
                        'wimpys_food_express_raw_material_products.product_id_no')
                    ->join('wimpys_food_express_raw_material_products', 'wimpys_food_express_raw_materials.id', '=', 'wimpys_food_express_raw_material_products.raw_materials_id')
                    ->where('wimpys_food_express_raw_material_products.raw_materials_id', $availExp[0])
                    ->orderBy('wimpys_food_express_raw_materials.id', 'desc')
                    ->get();

          //minus available pcs from the qty
          $aPcs = $rawMaterial[0]->remaining_stock - $qty;
        
          //add qty to out 
          $out = $rawMaterial[0]->out + $qty;
              
          //compute the stock out amount in unit price
          $stockAmount = $rawMaterial[0]->unit_price * $qty;
              
          //update raw material table
          $updateRawMaterial = WimpysFoodExpressRawMaterial::find($availExp[0]);
          
          $updateRawMaterial->out = $out;
          $updateRawMaterial->remaining_stock = $aPcs;
          $updateRawMaterial->stock_amount = $stockAmount;
          $updateRawMaterial->save();
  
  
           //get date today
          $getDateToday =  date('Y-m-d');

        $addNewDeliveryReceipt = new WimpysFoodExpressDeliveryReceipt([
            'user_id'=>$user->id,
            'dr_id'=>$id,
            'dr_no'=>$deliveryReceipt['dr_no'],
            'product_id'=>$request->get('productId'),
            'qty'=>$qty,
            'unit'=>$request->get('unit'),
            'description'=>$request->get('itemDescription'),
            'unit_price'=>$unitPrice,
            'total'=>$sum,
            'prepared_by'=>$name,
            'created_by'=>$name,

        ]);

        $addNewDeliveryReceipt->save();

        //update 
        $deliveryReceipt->total  = $getAmount; 
        $deliveryReceipt->save();

        Session::flash('addDeliveryReceiptSuccess', 'Successfully added.');

        return redirect()->route('editDeliveryReceiptWimpys', ['id'=>$id]);
    }

    public function editDeliveryReceipt($id){
        $getDeliveryReceipt = WimpysFoodExpressDeliveryReceipt::find($id);

        $getRawMaterials = DB::table(
                        'wimpys_food_express_raw_materials')
                        ->select(
                            'wimpys_food_express_raw_materials.id',
                            'wimpys_food_express_raw_materials.user_id',
                            'wimpys_food_express_raw_materials.rm_id',
                            'wimpys_food_express_raw_materials.product_name',
                            'wimpys_food_express_raw_materials.unit_price',
                            'wimpys_food_express_raw_materials.unit',
                            'wimpys_food_express_raw_materials.in',
                            'wimpys_food_express_raw_materials.out',
                            'wimpys_food_express_raw_materials.stock_amount',
                            'wimpys_food_express_raw_materials.remaining_stock',
                            'wimpys_food_express_raw_materials.amount',
                            'wimpys_food_express_raw_materials.supplier',
                            'wimpys_food_express_raw_materials.date',
                            'wimpys_food_express_raw_materials.item',
                            'wimpys_food_express_raw_materials.description',
                            'wimpys_food_express_raw_materials.reference_no',
                            'wimpys_food_express_raw_materials.qty',
                            'wimpys_food_express_raw_materials.requesting_branch',
                            'wimpys_food_express_raw_materials.cheque_no_issued',
                            'wimpys_food_express_raw_materials.status',
                            'wimpys_food_express_raw_materials.created_by',
                            'wimpys_food_express_raw_material_products.raw_materials_id',
                            'wimpys_food_express_raw_material_products.branch',
                            'wimpys_food_express_raw_material_products.product_id_no')
                        ->join('wimpys_food_express_raw_material_products', 'wimpys_food_express_raw_materials.id', '=', 'wimpys_food_express_raw_material_products.raw_materials_id')
                        ->where('wimpys_food_express_raw_materials.rm_id', NULL)
                        ->orderBy('wimpys_food_express_raw_materials.id', 'desc')
                        ->get()->toArray();


         //dReceipts
         $dReceipts = WimpysFoodExpressDeliveryReceipt::where('dr_id', $id)->get()->toArray();

        return view('edit-wimpys-food-express-delivery-receipt', compact('id', 
            'getDeliveryReceipt', 'dReceipts', 'getRawMaterials'));
    }

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
        $dataDrNo = DB::select('SELECT id, wimpys_food_express_code FROM wimpys_food_express_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 dr_no
        if(isset($dataDrNo[0]->wimpys_food_express_code) != 0){
            //if code is not 0
            $newDr = $dataDrNo[0]->wimpys_food_express_code +1;
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
                        'wimpys_food_express_raw_materials')
                        ->select(
                            'wimpys_food_express_raw_materials.id',
                            'wimpys_food_express_raw_materials.user_id',
                            'wimpys_food_express_raw_materials.rm_id',
                            'wimpys_food_express_raw_materials.product_name',
                            'wimpys_food_express_raw_materials.unit_price',
                            'wimpys_food_express_raw_materials.unit',
                            'wimpys_food_express_raw_materials.in',
                            'wimpys_food_express_raw_materials.out',
                            'wimpys_food_express_raw_materials.stock_amount',
                            'wimpys_food_express_raw_materials.remaining_stock',
                            'wimpys_food_express_raw_materials.amount',
                            'wimpys_food_express_raw_materials.supplier',
                            'wimpys_food_express_raw_materials.date',
                            'wimpys_food_express_raw_materials.item',
                            'wimpys_food_express_raw_materials.description',
                            'wimpys_food_express_raw_materials.reference_no',
                            'wimpys_food_express_raw_materials.qty',
                            'wimpys_food_express_raw_materials.requesting_branch',
                            'wimpys_food_express_raw_materials.cheque_no_issued',
                            'wimpys_food_express_raw_materials.status',
                            'wimpys_food_express_raw_materials.created_by',
                            'wimpys_food_express_raw_material_products.raw_materials_id',
                            'wimpys_food_express_raw_material_products.branch',
                            'wimpys_food_express_raw_material_products.product_id_no')
                        ->join('wimpys_food_express_raw_material_products', 'wimpys_food_express_raw_materials.id', '=', 'wimpys_food_express_raw_material_products.raw_materials_id')
                        ->where('wimpys_food_express_raw_material_products.raw_materials_id', $availExp[0])
                        ->orderBy('wimpys_food_express_raw_materials.id', 'desc')
                        ->get();

        //minus available pcs from the qty
        $aPcs = $rawMaterial[0]->remaining_stock - $qty;
    
        //add qty to out 
        $out = $rawMaterial[0]->out + $qty;

        //compute the stock out amount in unit price
        $stockAmount = $rawMaterial[0]->unit_price * $qty;
       
        //update 
        $updateRawMaterial = WimpysFoodExpressRawMaterial::find($availExp[0]);
        
        $updateRawMaterial->out = $out;
        $updateRawMaterial->remaining_stock = $aPcs;
        $updateRawMaterial->stock_amount = $stockAmount;
        $updateRawMaterial->save();

        
        $storeDeliveryReceipt = new WimpysFoodExpressDeliveryReceipt([
            'user_id'=>$user->id,
            'sold_to'=>$request->get('soldTo'),
            'time'=>$request->get('time'),
            'date'=>$request->get('date'),
            'date_to_be_delivered'=>$request->get('dateDelivered'),
            'delivered_to'=>$request->get('deliveredFor'),
            'dr_no'=>$uDr,
            'delivered_to'=>$request->get('deliveredTo'),
            'contact_person'=>$request->get('contactPerson'),
            'mobile_num'=>$request->get('mobile'),
            'special_instruction'=>$request->get('specialInstruction'),
            'consignee_name'=>$request->get('consigneeName'),
            'consignee_contact_num'=>$request->get('consigneeContact'),
            'product_id'=>$request->get('productId'),
            'qty'=>$request->get('qty'),
            'unit'=>$request->get('unit'),
            'description'=>$request->get('itemDescription'),
            'unit_price'=>$request->get('unitPrice'),
            'price'=>$sum,
            'total'=>$sum,
            'prepared_by'=>$name,
            'created_by'=>$name,
        ]);

        $storeDeliveryReceipt->save();
        $insertedId  = $storeDeliveryReceipt->id;

        $moduleCode = "DR-";
        $moduleName = "Delivery Receipt";

        $wimpysCode = new WimpysFoodExpressCode([
            'user_id'=>$user->id,
            'wimpys_food_express_code'=>$uDr,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $wimpysCode->save();

        return redirect()->route('editDeliveryReceiptWimpys', ['id'=>$insertedId]);

        return response()->json($storeDeliveryReceipt);

    }

    public function deliveryReceiptForm(){
        $getRawMaterials = DB::table(
                        'wimpys_food_express_raw_materials')
                        ->select(
                            'wimpys_food_express_raw_materials.id',
                            'wimpys_food_express_raw_materials.user_id',
                            'wimpys_food_express_raw_materials.rm_id',
                            'wimpys_food_express_raw_materials.product_name',
                            'wimpys_food_express_raw_materials.unit_price',
                            'wimpys_food_express_raw_materials.unit',
                            'wimpys_food_express_raw_materials.in',
                            'wimpys_food_express_raw_materials.out',
                            'wimpys_food_express_raw_materials.stock_amount',
                            'wimpys_food_express_raw_materials.remaining_stock',
                            'wimpys_food_express_raw_materials.amount',
                            'wimpys_food_express_raw_materials.supplier',
                            'wimpys_food_express_raw_materials.date',
                            'wimpys_food_express_raw_materials.item',
                            'wimpys_food_express_raw_materials.description',
                            'wimpys_food_express_raw_materials.reference_no',
                            'wimpys_food_express_raw_materials.qty',
                            'wimpys_food_express_raw_materials.requesting_branch',
                            'wimpys_food_express_raw_materials.cheque_no_issued',
                            'wimpys_food_express_raw_materials.status',
                            'wimpys_food_express_raw_materials.created_by',
                            'wimpys_food_express_raw_material_products.raw_materials_id',
                            'wimpys_food_express_raw_material_products.branch',
                            'wimpys_food_express_raw_material_products.product_id_no')
                        ->join('wimpys_food_express_raw_material_products', 'wimpys_food_express_raw_materials.id', '=', 'wimpys_food_express_raw_material_products.raw_materials_id')
                        ->where('wimpys_food_express_raw_materials.rm_id', NULL)
                        ->orderBy('wimpys_food_express_raw_materials.id', 'desc')
                        ->get()->toArray();

    
        return view('wimpys-food-express-delivery-receipt-form', compact('getRawMaterials'));
    }

    public function updateMenu(Request $request){
        $updateMenu = WimpysFoodExpressMenuList::find($request->id);
        $updateMenu->name = $request->name;
        $updateMenu->category = $request->category;
        $updateMenu->save();

        return response()->json('Success: succefully updated.');
        
    }

    public function addMenuList(Request $request){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $target = DB::table(
            'wimpys_food_express_menu_lists')
            ->where('name', $request->name)
            ->get()->first(); 

        if($target === NULL){
            $addMenu = new WimpysFoodExpressMenuList([
                'user_id'=>$user->id,
                'name'=>$request->name,
                'category'=>$request->cat,
                'created_by'=>$name,
            ]);
    
            $addMenu->save();
    
            return response()->json('Success: successfully added a menu.');     
        }else{
            return response()->json('Failed: menu already exists'); 
        }
       

    }   

    public function menuLists(){
       

        $getAllMenus = WimpysFoodExpressMenuList::orderBy('id', 'desc')->get()->toArray();

    
        return view('wimpys-food-express-menu-lists', compact('getAllMenus'));
    }

    public function printClientBooking($id){
        $printCB =  WimpysFoodExpressClientBookingForm::with(['user', 'client_bookings'])
                                                                        ->where('id', $id)
                                                                        ->get();

        $getMenuItems = WimpysFoodExpressClientBookingForm::where('bf_id', $id)->get()->toArray();

        $pdf = PDF::loadView('printClientBookingWimpys', compact('printCB', 'getMenuItems'));
    
        return $pdf->download('wimpys-food-express-client-booking.pdf');
    }

    public function viewClientBooking($id){
        $viewClientBooking =  WimpysFoodExpressClientBookingForm::with(['user', 'client_bookings'])
                                                                ->where('id', $id)
                                                                ->get();
        $getMenuItems = WimpysFoodExpressClientBookingForm::where('bf_id', $id)->get()->toArray();



        return view('view-wimpys-food-express-client-booking', compact('id','viewClientBooking', 'getMenuItems'));
    }

    public function clientBookingLists(){
        $clientBookingLists =  WimpysFoodExpressClientBookingForm::with(['user', 'client_bookings'])
                                                            ->where('bf_id', NULL)
                                                            ->where('deleted_at', NULL)
                                                            ->orderBy('id', 'desc')
                                                            ->get(); 

        return view('wimpys-food-express-client-booking-list', compact('clientBookingLists'));
    }

    public function updateClientBooking(Request $request, $id){
        $updateBooking = WimpysFoodExpressClientBookingForm::find($id);
        $updateBooking->date_of_event = $request->get('dateOfEvent');
        $updateBooking->time_of_event = $request->get('timeOfEvent');
        $updateBooking->no_of_people = $request->get('noOfPeople');
        $updateBooking->motiff =  $request->get('motiff');
        $updateBooking->type_of_package = $request->get('package');
        $updateBooking->client = $request->get('client');
        $updateBooking->place_of_event = $request->get('placeOfEvent');
        $updateBooking->mobile_number = $request->get('mobileNumber');
        $updateBooking->email = $request->get('emailAddress');
        $updateBooking->special_requests = $request->get('specialRequests');

        $updateBooking->save();

        Session::flash('updateItem', 'Successfully updated');

        return redirect()->route('editClientBookingFormWimpys', ['id'=>$id]);
    }

    public function addItem(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        if($request->get('menuCat') == "Additional Order"){
            $qty = $request->get('qty');
            $amount = $request->get('amount');

            $getMenu = WimpysFoodExpressClientBookingForm::find($request->get('menuId'));
           
            $total = $getMenu->total; 
            $totAmount = $total + $amount;
           
            $getMenu->total = $totAmount; 
            $getMenu->save();

            
        }else{
            $qty = NULL;
            $amount = NULL;
        }


        $addItem = new WimpysFoodExpressClientBookingForm([
            'user_id'=>$user->id,
            'bf_id'=>$id,
            'menu_cat'=>$request->get('menuCat'),
            'menu'=>$request->get('entrees'),
            'qty'=>$qty,
            'amount'=>$amount,
            'created_by'=>$name,
        ]);

        $addItem->save();
        
        Session::flash('addItem', 'Successfully added');

        return redirect()->route('editClientBookingFormWimpys', ['id'=>$id]);

    }

    public function editClientBookingForm(Request $request, $id){
        $menuItem = WimpysFoodExpressClientBookingForm::find($id);

        $menuLists = WimpysFoodExpressMenuList::get()->toArray();

        $getMenuItems = WimpysFoodExpressClientBookingForm::where('bf_id', $id)->get()->toArray();


        return view('edit-wimpys-client-booking-form', compact('menuLists', 'menuItem', 'getMenuItems'));
        
    }

    
    CONST PACK_PRICEA = 300;
    CONST PACK_PRICEB = 350;
    CONST PACK_PRICEC = 400;
    CONST PACK_EXEC = 600;

    public function storeBookingForm(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the latest insert id query in table lechon de cebu
        $dataCode = DB::select('SELECT id, wimpys_food_express_code FROM wimpys_food_express_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataCode[0]->wimpys_food_express_code) != 0){
            //if code is not 0
            $newCode= $dataCode[0]->wimpys_food_express_code +1;
            $uCode = sprintf("%06d",$newCode);   

        }else{
            //if code is 0 
            $newCode = 1;
            $uCode = sprintf("%06d",$newCode);
        } 


        if($request->get('noOfPeople') && $request->get('package')){
            $pax = $request->get('noOfPeople');
            $package = $request->get('package');
            if($package == "SET A - 300"){
               $total = $pax * self::PACK_PRICEA;
                
            }else if($package == "SET B - 350"){
               $total = $pax * self::PACK_PRICEB;

            }else if($package == "SET C - 400"){
               $total  = $pax * self::PACK_PRICEC;

            }else if($package == "EXECUTIVE SET - 600"){
                $total = $pax * self::PACK_EXEC;
            } 
        }

        $addClientBooking = new WimpysFoodExpressClientBookingForm([
            'user_id'=>$user->id,
            'date_of_event'=>$request->get('dateOfEvent'),
            'time_of_event'=>$request->get('timeOfEvent'),
            'no_of_people'=>$request->get('noOfPeople'),
            'motiff'=>$request->get('motiff'),
            'type_of_package'=>$request->get('package'),
            'client'=>$request->get('client'),
            'place_of_event'=>$request->get('placeOfEvent'),
            'mobile_number'=>$request->get('mobileNumber'),
            'email'=>$request->get('emailAddress'),
            'special_requests'=>$request->get('specialRequests'),
            'total'=>$total,
            'created_by'=>$name,
        ]);

        $addClientBooking->save();
        $insertedId = $addClientBooking->id;

        $moduleCode = "CB-";
        $moduleName = "Client Booking";

        $wimpysCode = new WimpysFoodExpressCode([
            'user_id'=>$user->id,
            'wimpys_food_express_code'=>$uCode,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $wimpysCode->save();

        return redirect()->route('editClientBookingFormWimpys', ['id'=>$insertedId]);

    }

    public function clientBookingForm(){

        return view('wimpys-food-express-client-booking-form');
    }

    public function search(Request $request){
        $getSearchResults = WimpysFoodExpressCode::where('wimpys_food_express_code', $request->get('searchCode'))->get();
        if($getSearchResults[0]->module_name === "Payment Voucher"){
            $getSearchPaymentVouchers = DB::table('wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.id', $getSearchResults[0]->module_id)
                    ->where('wimpys_food_express_codes.module_name',  $getSearchResults[0]->module_name)
                    ->get()->toArray();


            $getAllCodes = WimpysFoodExpressCode::get()->toArray();  
            $module = $getSearchResults[0]->module_name;  
            
            return view('wimpys-food-express-search-results',  compact('module', 'getAllCodes', 'getSearchPaymentVouchers'));
           
        }
    }

    public function searchNumberCode(){
        $getAllCodes = WimpysFoodExpressCode::get()->toArray();
        return view('wimpys-food-express-search-number-code', compact('getAllCodes'));

    }

    public function printGetSummary($date){
        $uri0 = "";
        $uri1 = "";

        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";

        $getTransactionListCashes = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->sum('wimpys_food_express_payment_vouchers.amount_due');

        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $totalAmountCheck = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->sum('wimpys_food_express_payment_vouchers.amount_due');

    $totalPaidAmountCheck = DB::table(
                            'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.cheque_total_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($date))
                            ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                            ->where('wimpys_food_express_payment_vouchers.status', $status)
                            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                            ->sum('wimpys_food_express_payment_vouchers.amount_due');
        
        
        $getDateToday = "";     
        $pdf = PDF::loadView('printSummaryWimpysFoodExp',  compact('date', 'getDateToday', 'uri0', 'uri1', 
            'getTransactionListCashes', 'getTransactionListChecks', 
            'totalAmountCashes','totalAmountCheck', 'totalPaidAmountCheck'));
        
        return $pdf->download('wimpys-food-express-summary-report.pdf');
                

    }

    public function printSummary(){
        $getDateToday = date("Y-m-d");
        $moduleNamePV = "Payment Voucher";
        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $totalAmountCashes = DB::table(
                            'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.cheque_total_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                            ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                            ->sum('wimpys_food_express_payment_vouchers.amount_due');


        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->sum('wimpys_food_express_payment_vouchers.amount_due');
        
    $totalPaidAmountCheck = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->where('wimpys_food_express_payment_vouchers.status', $status)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->sum('wimpys_food_express_payment_vouchers.amount_due');

        $uri0 = "";
        $uri1 = "";
        $pdf = PDF::loadView('printSummaryWimpysFoodExp', compact('uri0', 'uri1', 'getDateToday', 
        'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck', 'totalPaidAmountCheck'));

        return $pdf->download('wimpys-food-express-inc-summary-report.pdf');

    }

    public function getSummaryReportMultiple(Request $request){
        $startDate = date("Y-m-d",strtotime($request->input('startDate')));
        $endDate = date("Y-m-d",strtotime($request->input('endDate')."+1 day"));
        $moduleNamePV = "Payment Voucher";

        $getTransactionLists = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $totalAmountCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->sum('wimpys_food_express_payment_vouchers.amount_due');


            $check = "CHECK";
            $getTransactionListChecks = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->get()->toArray();
    
            $status = "FULLY PAID AND RELEASED";
            $totalAmountCheck = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereBetween('wimpys_food_express_payment_vouchers.created_at', [$startDate, $endDate])
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->sum('wimpys_food_express_payment_vouchers.amount_due');
            
        return view('wimpys-food-express-multiple-summary-report', compact('getTransactionLists', 'startDate', 'endDate', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));


    }

    public function getSummaryReport(Request $request){
        $getDate = $request->get('selectDate');
        $moduleNamePV = "Payment Voucher";

        $getTransactionLists = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();

        $cash = "CASH";
        $getTransactionListCashes = DB::table(
                        'wimpys_food_express_payment_vouchers')
                        ->select( 
                        'wimpys_food_express_payment_vouchers.id',
                        'wimpys_food_express_payment_vouchers.user_id',
                        'wimpys_food_express_payment_vouchers.pv_id',
                        'wimpys_food_express_payment_vouchers.date',
                        'wimpys_food_express_payment_vouchers.paid_to',
                        'wimpys_food_express_payment_vouchers.account_no',
                        'wimpys_food_express_payment_vouchers.account_name',
                        'wimpys_food_express_payment_vouchers.particulars',
                        'wimpys_food_express_payment_vouchers.amount',
                        'wimpys_food_express_payment_vouchers.method_of_payment',
                        'wimpys_food_express_payment_vouchers.prepared_by',
                        'wimpys_food_express_payment_vouchers.approved_by',
                        'wimpys_food_express_payment_vouchers.date_approved',
                        'wimpys_food_express_payment_vouchers.received_by_date',
                        'wimpys_food_express_payment_vouchers.created_by',
                        'wimpys_food_express_payment_vouchers.created_at',
                        'wimpys_food_express_payment_vouchers.invoice_number',
                        'wimpys_food_express_payment_vouchers.issued_date',
                        'wimpys_food_express_payment_vouchers.category',
                        'wimpys_food_express_payment_vouchers.amount_due',
                        'wimpys_food_express_payment_vouchers.delivered_date',
                        'wimpys_food_express_payment_vouchers.status',
                        'wimpys_food_express_payment_vouchers.cheque_number',
                        'wimpys_food_express_payment_vouchers.cheque_amount',
                        'wimpys_food_express_payment_vouchers.cheque_total_amount',
                        'wimpys_food_express_payment_vouchers.sub_category',
                        'wimpys_food_express_payment_vouchers.sub_category_account_id',
                        'wimpys_food_express_payment_vouchers.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                        ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                        ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                        ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                        ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                        ->get()->toArray();

        $totalAmountCashes = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->sum('wimpys_food_express_payment_vouchers.amount_due');
                    
        $check = "CHECK";
        $getTransactionListChecks = DB::table(
                        'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.cheque_total_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                            ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                            ->get()->toArray();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDate))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->sum('wimpys_food_express_payment_vouchers.amount_due');
        
        return view('wimpys-food-express-get-summary-report', compact('getDate', 'getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));
    
                    
    }

    public function summaryReport(){    
        $getDateToday = date("Y-m-d");
        $moduleNamePV = "Payment Voucher";

        $getTransactionLists = DB::table(
            'wimpys_food_express_payment_vouchers')
            ->select( 
            'wimpys_food_express_payment_vouchers.id',
            'wimpys_food_express_payment_vouchers.user_id',
            'wimpys_food_express_payment_vouchers.pv_id',
            'wimpys_food_express_payment_vouchers.date',
            'wimpys_food_express_payment_vouchers.paid_to',
            'wimpys_food_express_payment_vouchers.account_no',
            'wimpys_food_express_payment_vouchers.account_name',
            'wimpys_food_express_payment_vouchers.particulars',
            'wimpys_food_express_payment_vouchers.amount',
            'wimpys_food_express_payment_vouchers.method_of_payment',
            'wimpys_food_express_payment_vouchers.prepared_by',
            'wimpys_food_express_payment_vouchers.approved_by',
            'wimpys_food_express_payment_vouchers.date_approved',
            'wimpys_food_express_payment_vouchers.received_by_date',
            'wimpys_food_express_payment_vouchers.created_by',
            'wimpys_food_express_payment_vouchers.created_at',
            'wimpys_food_express_payment_vouchers.invoice_number',
            'wimpys_food_express_payment_vouchers.issued_date',
            'wimpys_food_express_payment_vouchers.category',
            'wimpys_food_express_payment_vouchers.amount_due',
            'wimpys_food_express_payment_vouchers.delivered_date',
            'wimpys_food_express_payment_vouchers.status',
            'wimpys_food_express_payment_vouchers.cheque_number',
            'wimpys_food_express_payment_vouchers.cheque_amount',
            'wimpys_food_express_payment_vouchers.cheque_total_amount',
            'wimpys_food_express_payment_vouchers.sub_category',
            'wimpys_food_express_payment_vouchers.sub_category_account_id',
            'wimpys_food_express_payment_vouchers.deleted_at',
            'wimpys_food_express_codes.wimpys_food_express_code',
            'wimpys_food_express_codes.module_id',
            'wimpys_food_express_codes.module_code',
            'wimpys_food_express_codes.module_name')
            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
            ->get()->toArray();

    $cash = "CASH";
    $getTransactionListCashes = DB::table(
            'wimpys_food_express_payment_vouchers')
            ->select( 
            'wimpys_food_express_payment_vouchers.id',
            'wimpys_food_express_payment_vouchers.user_id',
            'wimpys_food_express_payment_vouchers.pv_id',
            'wimpys_food_express_payment_vouchers.date',
            'wimpys_food_express_payment_vouchers.paid_to',
            'wimpys_food_express_payment_vouchers.account_no',
            'wimpys_food_express_payment_vouchers.account_name',
            'wimpys_food_express_payment_vouchers.particulars',
            'wimpys_food_express_payment_vouchers.amount',
            'wimpys_food_express_payment_vouchers.method_of_payment',
            'wimpys_food_express_payment_vouchers.prepared_by',
            'wimpys_food_express_payment_vouchers.approved_by',
            'wimpys_food_express_payment_vouchers.date_approved',
            'wimpys_food_express_payment_vouchers.received_by_date',
            'wimpys_food_express_payment_vouchers.created_by',
            'wimpys_food_express_payment_vouchers.created_at',
            'wimpys_food_express_payment_vouchers.invoice_number',
            'wimpys_food_express_payment_vouchers.issued_date',
            'wimpys_food_express_payment_vouchers.category',
            'wimpys_food_express_payment_vouchers.amount_due',
            'wimpys_food_express_payment_vouchers.delivered_date',
            'wimpys_food_express_payment_vouchers.status',
            'wimpys_food_express_payment_vouchers.cheque_number',
            'wimpys_food_express_payment_vouchers.cheque_amount',
            'wimpys_food_express_payment_vouchers.cheque_total_amount',
            'wimpys_food_express_payment_vouchers.sub_category',
            'wimpys_food_express_payment_vouchers.sub_category_account_id',
            'wimpys_food_express_payment_vouchers.deleted_at',
            'wimpys_food_express_codes.wimpys_food_express_code',
            'wimpys_food_express_codes.module_id',
            'wimpys_food_express_codes.module_code',
            'wimpys_food_express_codes.module_name')
            ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
            ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
            ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
            ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
            ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
            ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
            ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
            ->get()->toArray();

    $totalAmountCashes = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->sum('wimpys_food_express_payment_vouchers.amount_due');

    $check = "CHECK";
    $getTransactionListChecks = DB::table(
                    'wimpys_food_express_payment_vouchers')
                    ->select( 
                    'wimpys_food_express_payment_vouchers.id',
                    'wimpys_food_express_payment_vouchers.user_id',
                    'wimpys_food_express_payment_vouchers.pv_id',
                    'wimpys_food_express_payment_vouchers.date',
                    'wimpys_food_express_payment_vouchers.paid_to',
                    'wimpys_food_express_payment_vouchers.account_no',
                    'wimpys_food_express_payment_vouchers.account_name',
                    'wimpys_food_express_payment_vouchers.particulars',
                    'wimpys_food_express_payment_vouchers.amount',
                    'wimpys_food_express_payment_vouchers.method_of_payment',
                    'wimpys_food_express_payment_vouchers.prepared_by',
                    'wimpys_food_express_payment_vouchers.approved_by',
                    'wimpys_food_express_payment_vouchers.date_approved',
                    'wimpys_food_express_payment_vouchers.received_by_date',
                    'wimpys_food_express_payment_vouchers.created_by',
                    'wimpys_food_express_payment_vouchers.created_at',
                    'wimpys_food_express_payment_vouchers.invoice_number',
                    'wimpys_food_express_payment_vouchers.issued_date',
                    'wimpys_food_express_payment_vouchers.category',
                    'wimpys_food_express_payment_vouchers.amount_due',
                    'wimpys_food_express_payment_vouchers.delivered_date',
                    'wimpys_food_express_payment_vouchers.status',
                    'wimpys_food_express_payment_vouchers.cheque_number',
                    'wimpys_food_express_payment_vouchers.cheque_amount',
                    'wimpys_food_express_payment_vouchers.cheque_total_amount',
                    'wimpys_food_express_payment_vouchers.sub_category',
                    'wimpys_food_express_payment_vouchers.sub_category_account_id',
                    'wimpys_food_express_payment_vouchers.deleted_at',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                    ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                    ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                    ->where('wimpys_food_express_payment_vouchers.method_of_payment', $check)
                    ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                    ->get()->toArray();
    
        $status = "FULLY PAID AND RELEASED";
        $totalAmountCheck = DB::table(
                'wimpys_food_express_payment_vouchers')
                ->select( 
                'wimpys_food_express_payment_vouchers.id',
                'wimpys_food_express_payment_vouchers.user_id',
                'wimpys_food_express_payment_vouchers.pv_id',
                'wimpys_food_express_payment_vouchers.date',
                'wimpys_food_express_payment_vouchers.paid_to',
                'wimpys_food_express_payment_vouchers.account_no',
                'wimpys_food_express_payment_vouchers.account_name',
                'wimpys_food_express_payment_vouchers.particulars',
                'wimpys_food_express_payment_vouchers.amount',
                'wimpys_food_express_payment_vouchers.method_of_payment',
                'wimpys_food_express_payment_vouchers.prepared_by',
                'wimpys_food_express_payment_vouchers.approved_by',
                'wimpys_food_express_payment_vouchers.date_approved',
                'wimpys_food_express_payment_vouchers.received_by_date',
                'wimpys_food_express_payment_vouchers.created_by',
                'wimpys_food_express_payment_vouchers.created_at',
                'wimpys_food_express_payment_vouchers.invoice_number',
                'wimpys_food_express_payment_vouchers.issued_date',
                'wimpys_food_express_payment_vouchers.category',
                'wimpys_food_express_payment_vouchers.amount_due',
                'wimpys_food_express_payment_vouchers.delivered_date',
                'wimpys_food_express_payment_vouchers.status',
                'wimpys_food_express_payment_vouchers.cheque_number',
                'wimpys_food_express_payment_vouchers.cheque_amount',
                'wimpys_food_express_payment_vouchers.cheque_total_amount',
                'wimpys_food_express_payment_vouchers.sub_category',
                'wimpys_food_express_payment_vouchers.sub_category_account_id',
                'wimpys_food_express_payment_vouchers.deleted_at',
                'wimpys_food_express_codes.wimpys_food_express_code',
                'wimpys_food_express_codes.module_id',
                'wimpys_food_express_codes.module_code',
                'wimpys_food_express_codes.module_name')
                ->join('wimpys_food_express_codes', 'wimpys_food_express_payment_vouchers.id', '=', 'wimpys_food_express_codes.module_id')
                ->where('wimpys_food_express_payment_vouchers.pv_id', NULL)
                ->where('wimpys_food_express_codes.module_name', $moduleNamePV)
                ->where('wimpys_food_express_payment_vouchers.deleted_at', NULL)
                ->whereDate('wimpys_food_express_payment_vouchers.created_at', '=', date($getDateToday))
                ->where('wimpys_food_express_payment_vouchers.method_of_payment', $cash)
                ->orderBy('wimpys_food_express_payment_vouchers.id', 'desc')
                ->sum('wimpys_food_express_payment_vouchers.amount_due');


        return view('wimpys-food-express-summary-report', compact('getTransactionLists', 'getTransactionListCashes', 
        'totalAmountCashes', 'getTransactionListChecks', 'totalAmountCheck'));

    }

    public function orderFormLists(){
        $moduleName = "Order Form";
        $orderForms =  DB::table(
                    'wimpys_food_express_order_forms')
                    ->select( 
                    'wimpys_food_express_order_forms.id',
                    'wimpys_food_express_order_forms.user_id',
                    'wimpys_food_express_order_forms.order_id',
                    'wimpys_food_express_order_forms.date',
                    'wimpys_food_express_order_forms.time',
                    'wimpys_food_express_order_forms.no_of_people',
                    'wimpys_food_express_order_forms.ordered_by',
                    'wimpys_food_express_order_forms.noted_by',
                    'wimpys_food_express_order_forms.items',
                    'wimpys_food_express_order_forms.qty',
                    'wimpys_food_express_order_forms.unit',
                    'wimpys_food_express_order_forms.price',
                    'wimpys_food_express_order_forms.total',
                    'wimpys_food_express_order_forms.created_by',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_order_forms.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_order_forms.order_id', NULL)
                    ->where('wimpys_food_express_codes.module_name', $moduleName)
                    ->where('wimpys_food_express_order_forms.deleted_at', NULL)
                    ->orderBy('wimpys_food_express_order_forms.id', 'desc')
                    ->get()->toArray();

        return view('wimpys-food-express-order-form-list', compact('orderForms'));
    }

    public function printOrderForm($id){
        $moduleName = "Order Form";

        $viewOrder =  DB::table(
            'wimpys_food_express_order_forms')
            ->select( 
            'wimpys_food_express_order_forms.id',
            'wimpys_food_express_order_forms.user_id',
            'wimpys_food_express_order_forms.order_id',
            'wimpys_food_express_order_forms.date',
            'wimpys_food_express_order_forms.time',
            'wimpys_food_express_order_forms.no_of_people',
            'wimpys_food_express_order_forms.ordered_by',
            'wimpys_food_express_order_forms.noted_by',
            'wimpys_food_express_order_forms.items',
            'wimpys_food_express_order_forms.qty',
            'wimpys_food_express_order_forms.unit',
            'wimpys_food_express_order_forms.price',
            'wimpys_food_express_order_forms.total',
            'wimpys_food_express_order_forms.created_by',
            'wimpys_food_express_codes.wimpys_food_express_code',
            'wimpys_food_express_codes.module_id',
            'wimpys_food_express_codes.module_code',
            'wimpys_food_express_codes.module_name')
            ->join('wimpys_food_express_codes', 'wimpys_food_express_order_forms.id', '=', 'wimpys_food_express_codes.module_id')
            ->where('wimpys_food_express_order_forms.id', $id)
            ->where('wimpys_food_express_codes.module_name', $moduleName)
            ->where('wimpys_food_express_order_forms.deleted_at', NULL)
            ->get()->toArray();

        $viewOtherOrders = WimpysFoodExpressOrderForm::where('order_id', $id)->get()->toArray();


        //count the total amount 
        $countTotalAmount = WimpysFoodExpressOrderForm::where('id', $id)->sum('total');

        //
        $countAmount = WimpysFoodExpressOrderForm::where('order_id', $id)->sum('total');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printOrderFormWimpys', compact('viewOrder', 'viewOtherOrders', 'sum'));

        return $pdf->download('wimpys-food-express-order-form.pdf'); 


        
    }

    public function viewOrderForm($id){
        $moduleName = "Order Form";
        $viewOrder =  DB::table(
                    'wimpys_food_express_order_forms')
                    ->select( 
                    'wimpys_food_express_order_forms.id',
                    'wimpys_food_express_order_forms.user_id',
                    'wimpys_food_express_order_forms.order_id',
                    'wimpys_food_express_order_forms.date',
                    'wimpys_food_express_order_forms.time',
                    'wimpys_food_express_order_forms.no_of_people',
                    'wimpys_food_express_order_forms.ordered_by',
                    'wimpys_food_express_order_forms.noted_by',
                    'wimpys_food_express_order_forms.items',
                    'wimpys_food_express_order_forms.qty',
                    'wimpys_food_express_order_forms.unit',
                    'wimpys_food_express_order_forms.price',
                    'wimpys_food_express_order_forms.total',
                    'wimpys_food_express_order_forms.created_by',
                    'wimpys_food_express_codes.wimpys_food_express_code',
                    'wimpys_food_express_codes.module_id',
                    'wimpys_food_express_codes.module_code',
                    'wimpys_food_express_codes.module_name')
                    ->join('wimpys_food_express_codes', 'wimpys_food_express_order_forms.id', '=', 'wimpys_food_express_codes.module_id')
                    ->where('wimpys_food_express_order_forms.id', $id)
                    ->where('wimpys_food_express_codes.module_name', $moduleName)
                    ->where('wimpys_food_express_order_forms.deleted_at', NULL)
                    ->get()->toArray();

        $viewOtherOrders = WimpysFoodExpressOrderForm::where('order_id', $id)->get()->toArray();


         //count the total amount 
         $countTotalAmount = WimpysFoodExpressOrderForm::where('id', $id)->sum('total');

         //
         $countAmount = WimpysFoodExpressOrderForm::where('order_id', $id)->sum('total');
 
         $sum  = $countTotalAmount + $countAmount;


        return view('view-order-form-wimpys-food-express', compact('viewOrder', 'viewOtherOrders', 'sum'));
    }

    public function storeOrder(Request $request, $id){
       
        $storeOrder = WimpysFoodExpressOrderForm::find($id);
        $storeOrder->date = $request->get('date');
        $storeOrder->time = $request->get('time');
        $storeOrder->no_of_people = $request->get('noOfPeople');
        $storeOrder->ordered_by = $request->get('orderedBy');
        $storeOrder->noted_by = $request->get('notedBy');
        $storeOrder->save();

        return redirect()->route('viewOrderFormWimpys', ['id'=>$id]);


    }

    public function transactionOrder($id){
        
        $categoryKitchen = "Kitchen";
        $categoryDessert = "Dessert";
        $categoryDecor = "Decor";
        $categoryEqup  = "Equipment and Supplies";

        $getMaterials = WimpysFoodExpressStockInventory::where('category',$categoryKitchen)->get()->toArray();

        $getMaterials2 = WimpysFoodExpressStockInventory::where('category', $categoryDessert)->get()->toArray();

        $getMaterials3 = WimpysFoodExpressStockInventory::where('category', $categoryDecor)->get()->toArray();
        
        $getMaterials4 = WimpysFoodExpressStockInventory::where('category', $categoryEqup)->get()->toArray();

        $transaction = DB::table(
                        'wimpys_food_express_order_forms')
                        ->select(
                        'wimpys_food_express_order_forms.id',    
                        'wimpys_food_express_order_forms.user_id',
                        'wimpys_food_express_order_forms.order_id',
                        'wimpys_food_express_order_forms.date',
                        'wimpys_food_express_order_forms.time',
                        'wimpys_food_express_order_forms.no_of_people',
                        'wimpys_food_express_order_forms.ordered_by',
                        'wimpys_food_express_order_forms.noted_by',
                        'wimpys_food_express_order_forms.items',
                        'wimpys_food_express_order_forms.qty',
                        'wimpys_food_express_order_forms.unit',
                        'wimpys_food_express_order_forms.price',
                        'wimpys_food_express_order_forms.total',
                        'wimpys_food_express_order_forms.deleted_at')
                        ->where('wimpys_food_express_order_forms.id', $id)
                        
                        ->get();

        $transactionOtherDetails = DB::table(
                            'wimpys_food_express_order_forms')
                            ->select(
                            'wimpys_food_express_order_forms.id',    
                            'wimpys_food_express_order_forms.user_id',
                            'wimpys_food_express_order_forms.order_id',
                            'wimpys_food_express_order_forms.date',
                            'wimpys_food_express_order_forms.time',
                            'wimpys_food_express_order_forms.no_of_people',
                            'wimpys_food_express_order_forms.ordered_by',
                            'wimpys_food_express_order_forms.noted_by',
                            'wimpys_food_express_order_forms.items',
                            'wimpys_food_express_order_forms.qty',
                            'wimpys_food_express_order_forms.unit',
                            'wimpys_food_express_order_forms.price',
                            'wimpys_food_express_order_forms.total',
                            'wimpys_food_express_order_forms.deleted_at')
                            ->where('wimpys_food_express_order_forms.order_id', $id)
                            ->where('wimpys_food_express_order_forms.deleted_at', NULL)
                            ->get()->toArray();
        
     
        return view('wimpys-food-express-order-form-transactions', compact('id','getMaterials', 
        'getMaterials2', 'getMaterials3', 'getMaterials4', 'transaction', 'transactionOtherDetails'));
    }

    public function additionalTransactionForm(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
         $getDate =  date("Y-m-d");
        

         
         $addItem = new WimpysFoodExpressOrderForm([
            'user_id'=>$user->id,
            'order_id'=>$request->ids,
            'date'=>$getDate,
            'items'=>$request->productName,
            'qty'=>$request->quantity,
            'unit'=>$request->unit,
            'price'=>$request->price,
            'total'=>$request->total,
            'created_by'=>$name,
        ]);


        $addItem->save();   
        $insertId = $addItem->id; 
            
        
        return response()->json($request->ids);


    }

    public function addForm(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
        $getDate =  date("Y-m-d");

        $dataReferenceNum = DB::select('SELECT id, wimpys_food_express_code FROM wimpys_food_express_codes ORDER BY id DESC LIMIT 1');

        //if code is not zero add plus 1 reference number
        if(isset($dataReferenceNum[0]->wimpys_food_express_code) != 0){
            //if code is not 0
            $newRefNum = $dataReferenceNum[0]->wimpys_food_express_code +1;
            $uRef = sprintf("%06d",$newRefNum);   
        }else{
            //if code is 0 
            $newRefNum = 1;
            $uRef = sprintf("%06d",$newRefNum);
        } 

        if($request->quantity == 1){
            $total = $request->price;
             
        }else{
            $total = $request->total;
           
        }


        $addItem = new WimpysFoodExpressOrderForm([
            'user_id'=>$user->id,
            'date'=>$getDate,
            'items'=>$request->productName,
            'qty'=>$request->quantity,
            'unit'=>$request->unit,
            'price'=>$request->price,
            'total'=>$total,
            'created_by'=>$name,
        ]);

        $addItem->save();   
        $insertedId = $addItem->id; 
            
        $moduleCode = "OF-";
        $moduleName = "Order Form";

        $wimpysFoodExp = new WimpysFoodExpressCode([
            'user_id'=>$user->id,
            'wimpys_food_express_code'=>$uRef,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);

        $wimpysFoodExp->save();


        return response()->json($insertedId);
       
        
    }

    public function orderForm(){
        $categoryKitchen = "Kitchen";
        $categoryDessert = "Dessert";
        $categoryDecor = "Decor";
        $categoryEqup  = "Equipment and Supplies";

        $getMaterials = WimpysFoodExpressStockInventory::where('category',$categoryKitchen)->get()->toArray();

        $getMaterials2 = WimpysFoodExpressStockInventory::where('category', $categoryDessert)->get()->toArray();

        $getMaterials3 = WimpysFoodExpressStockInventory::where('category', $categoryDecor)->get()->toArray();
        
        $getMaterials4 = WimpysFoodExpressStockInventory::where('category', $categoryEqup)->get()->toArray();
        
        return view('wimpys-food-express-order-form', compact('getMaterials', 'getMaterials2', 
        'getMaterials3', 'getMaterials4'));
    }

    public function updateRawMaterial(Request $request){
        $updateRawMaterial = WimpysFoodExpressStockInventory::find($request->id);

        $updateRawMaterial->product_name = $request->productName;
        $updateRawMaterial->price = $request->price;
        $updateRawMaterial->category = $request->category;
        $updateRawMaterial->save();
        
        return response()->json('Success: successfully updated.');  

    }

    public function addRawMaterial(Request $request){   
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

          //check if product name name exits
        $target = DB::table(
            'wimpys_food_express_stock_inventories')
            ->where('product_name', $request->productName)
            ->get()->first(); 

        if($target === NULL){
            $addNewMaterial = new WimpysFoodExpressStockInventory([
                'user_id'=>$user->id,
                'product_name'=>$request->productName,
                'unit'=>$request->unit,
                'price'=>$request->price,
                'category'=>$request->category,
                'created_by'=>$name,
            ]);

            $addNewMaterial->save();

            return response()->json('Success: successfully add material.'); 
        }else{
            return response()->json('Failed: Already exist.');
        }
    }

    public function menuOrder(){
        $getMaterials = WimpysFoodExpressStockInventory::get()->toArray();

        return view('wimpys-food-express-raw-materials', ['getMaterials'=>$getMaterials]);
    }

    public function printSOAList(){
        $printSOAStatements = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('billing_statement_id', NULL)
                                                                    ->where('deleted_at', NULL)
                                                                    ->orderBy('id', 'desc')
                                                                    ->get();
        $status = "PAID";
        $moduleName = "Statement Of Account";
        $totalAmount  =   DB::table(
                        'wimpys_food_express_statement_of_accounts')
                        ->select(
                        'wimpys_food_express_statement_of_accounts.id',
                        'wimpys_food_express_statement_of_accounts.user_id',
                        'wimpys_food_express_statement_of_accounts.billing_statement_id',
                        'wimpys_food_express_statement_of_accounts.bill_to',
                        'wimpys_food_express_statement_of_accounts.address',
                        'wimpys_food_express_statement_of_accounts.date',
                        'wimpys_food_express_statement_of_accounts.period_cover',
                        'wimpys_food_express_statement_of_accounts.terms',
                        'wimpys_food_express_statement_of_accounts.date_of_transaction',
                        'wimpys_food_express_statement_of_accounts.description',
                        'wimpys_food_express_statement_of_accounts.amount',
                        'wimpys_food_express_statement_of_accounts.total_amount',
                        'wimpys_food_express_statement_of_accounts.paid_amount',
                        'wimpys_food_express_statement_of_accounts.payment_method',
                        'wimpys_food_express_statement_of_accounts.collection_date',
                        'wimpys_food_express_statement_of_accounts.check_number',
                        'wimpys_food_express_statement_of_accounts.check_amount',
                        'wimpys_food_express_statement_of_accounts.or_number',
                        'wimpys_food_express_statement_of_accounts.status',
                        'wimpys_food_express_statement_of_accounts.created_by',
                        'wimpys_food_express_statement_of_accounts.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_statement_of_accounts.billing_statement_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleName)
                        ->where('wimpys_food_express_statement_of_accounts.status', '=', $status)
                        ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                        ->sum('wimpys_food_express_statement_of_accounts.total_amount');
                                            
        $totalRemainingBalance  =   DB::table(
                            'wimpys_food_express_statement_of_accounts')
                            ->select(
                            'wimpys_food_express_statement_of_accounts.id',
                            'wimpys_food_express_statement_of_accounts.user_id',
                            'wimpys_food_express_statement_of_accounts.billing_statement_id',
                            'wimpys_food_express_statement_of_accounts.bill_to',
                            'wimpys_food_express_statement_of_accounts.address',
                            'wimpys_food_express_statement_of_accounts.date',
                            'wimpys_food_express_statement_of_accounts.period_cover',
                            'wimpys_food_express_statement_of_accounts.terms',
                            'wimpys_food_express_statement_of_accounts.date_of_transaction',
                            'wimpys_food_express_statement_of_accounts.description',
                            'wimpys_food_express_statement_of_accounts.amount',
                            'wimpys_food_express_statement_of_accounts.total_amount',
                            'wimpys_food_express_statement_of_accounts.total_remaining_balance',
                            'wimpys_food_express_statement_of_accounts.paid_amount',
                            'wimpys_food_express_statement_of_accounts.payment_method',
                            'wimpys_food_express_statement_of_accounts.collection_date',
                            'wimpys_food_express_statement_of_accounts.check_number',
                            'wimpys_food_express_statement_of_accounts.check_amount',
                            'wimpys_food_express_statement_of_accounts.or_number',
                            'wimpys_food_express_statement_of_accounts.status',
                            'wimpys_food_express_statement_of_accounts.created_by',
                            'wimpys_food_express_statement_of_accounts.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_statement_of_accounts.billing_statement_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleName)
                            ->where('wimpys_food_express_statement_of_accounts.status', NULL)
                            ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                            ->sum('wimpys_food_express_statement_of_accounts.total_remaining_balance');

            $pdf = PDF::loadView('printSOAListsWimpysFoodexp', compact('printSOAStatements', 
            'totalAmount', 'totalRemainingBalance'));

            return $pdf->download('wimpys-food-express-statement-of-account-list-all.pdf');
                                                            
    }

    public function printSOA($id){
        $orFormCBF = self::ORDER_FORM_CB;
        $orFormDR = self::ORDER_FORM_DR;

        $soa = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                        ->where('billing_statement_id', NULL)
                                                        ->where('id', $id)
                                                        ->orderBy('id', 'desc')
                                                        ->get();                                                   
                                                        
        $statementAccounts = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->get()->toArray();

        $moduleName = "Statement Of Account";
        $countTotalAmount =  DB::table(
                            'wimpys_food_express_statement_of_accounts')
                            ->select(
                            'wimpys_food_express_statement_of_accounts.id',
                            'wimpys_food_express_statement_of_accounts.user_id',
                            'wimpys_food_express_statement_of_accounts.billing_statement_id',
                            'wimpys_food_express_statement_of_accounts.bill_to',
                            'wimpys_food_express_statement_of_accounts.address',
                            'wimpys_food_express_statement_of_accounts.date',
                            'wimpys_food_express_statement_of_accounts.period_cover',
                            'wimpys_food_express_statement_of_accounts.terms',
                            'wimpys_food_express_statement_of_accounts.date_of_transaction',
                            'wimpys_food_express_statement_of_accounts.description',
                            'wimpys_food_express_statement_of_accounts.amount',
                            'wimpys_food_express_statement_of_accounts.paid_amount',
                            'wimpys_food_express_statement_of_accounts.payment_method',
                            'wimpys_food_express_statement_of_accounts.collection_date',
                            'wimpys_food_express_statement_of_accounts.check_number',
                            'wimpys_food_express_statement_of_accounts.check_amount',
                            'wimpys_food_express_statement_of_accounts.or_number',
                            'wimpys_food_express_statement_of_accounts.status',
                            'wimpys_food_express_statement_of_accounts.created_by',
                            'wimpys_food_express_statement_of_accounts.deleted_at',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_statement_of_accounts.id', $id)
                            ->where('wimpys_food_express_codes.module_name', $moduleName)
                            ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                            ->sum('wimpys_food_express_statement_of_accounts.amount');

        $countAmount = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        //
        $countAmount = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');


        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printSOAWimpysFoodExp', compact('soa', 'statementAccounts', 'sum', 'orFormCBF', 'orFormDR'));

        return $pdf->download('wimpys-food-express-statement-of-account.pdf');

    }

    public function viewStatementAccount($id){
        $orFormCBF = self::ORDER_FORM_CB;
        $orFormDR = self::ORDER_FORM_DR;

        $viewStatementAccount = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('id', $id)
                                                                    ->get();

        $statementAccounts = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->get();

        //count the total amount 
        $countTotalAmount = WimpysFoodExpressStatementOfAccount::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        //count the total balance if there are paid amount
        $paidAmountCount = WimpysFoodExpressStatementOfAccount::where('id', $id)->sum('paid_amount');

        //
        $countAmountOthersPaid = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');

        $compute  = $paidAmountCount + $countAmountOthersPaid;


        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('view-wimpys-food-express-statement-account', compact('viewStatementAccount', 
        'statementAccounts', 'sum', 'computeAll', 'orFormCBF', 'orFormDR'));

    }

    public function sAccountUpdate(Request $request, $id){
          //get the main Id 
          $mainIdSoa = WimpysFoodExpressStatementOfAccount::find($request->mainId);

          $compute = $mainIdSoa->total_remaining_balance - $request->paidAmount;
          
          $mainIdSoa->total_remaining_balance = $compute; 
          $mainIdSoa->save();
  
          $statementAccountPaid = WimpysFoodExpressStatementOfAccount::find($request->id);
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


    public function editStatementAccount($id){  
        $orFormCBF = self::ORDER_FORM_CB;
        $orFormDR = self::ORDER_FORM_DR;
        $paid = self::PAID;

        $getStatementOfAccount = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                            ->where('id', $id)
                                                                            ->get();
        //AllAcounts not yet paid
        $allAccounts = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('status', NULL)->get()->toArray();

        $stat = "PAID";
        $allAccountsPaids = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('status', $stat)->get()->toArray();  

        //count the total amount 
        $countTotalAmount = WimpysFoodExpressStatementOfAccount::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        //count the total balance if there are paid amount
        $paidAmountCount = WimpysFoodExpressStatementOfAccount::where('id', $id)->sum('paid_amount');

        //
        $countAmountOthersPaid = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->where('bill_to', NULL)->sum('paid_amount');

        $compute  = $paidAmountCount + $countAmountOthersPaid;

        //minus the total balance to paid amounts
        $computeAll  = $sum - $compute;

        return view('edit-wimpys-food-express-statement-of-account', compact('id', 'getStatementOfAccount', 
        'computeAll', 'allAccounts', 'allAccountsPaids', 'sum', 'orFormCBF', 'orFormDR', 'paid'));

    }   

    public function statementOfAccountLists(){
        $statementOfAccounts = WimpysFoodExpressStatementOfAccount::with(['user', 'statement_of_accounts'])
                                                                    ->where('billing_statement_id', NULL)
                                                                    ->where('deleted_at', NULL)
                                                                    ->orderBy('id', 'desc')
                                                                    ->get();

        $status = "PAID";
        $moduleName = "Statement Of Account";
        $totalAmount  =   DB::table(
                        'wimpys_food_express_statement_of_accounts')
                        ->select(
                        'wimpys_food_express_statement_of_accounts.id',
                        'wimpys_food_express_statement_of_accounts.user_id',
                        'wimpys_food_express_statement_of_accounts.billing_statement_id',
                        'wimpys_food_express_statement_of_accounts.bill_to',
                        'wimpys_food_express_statement_of_accounts.order',
                        'wimpys_food_express_statement_of_accounts.address',
                        'wimpys_food_express_statement_of_accounts.date',
                        'wimpys_food_express_statement_of_accounts.period_cover',
                        'wimpys_food_express_statement_of_accounts.terms',
                        'wimpys_food_express_statement_of_accounts.date_of_transaction',
                        'wimpys_food_express_statement_of_accounts.description',
                        'wimpys_food_express_statement_of_accounts.amount',
                        'wimpys_food_express_statement_of_accounts.total_amount',
                        'wimpys_food_express_statement_of_accounts.paid_amount',
                        'wimpys_food_express_statement_of_accounts.payment_method',
                        'wimpys_food_express_statement_of_accounts.collection_date',
                        'wimpys_food_express_statement_of_accounts.check_number',
                        'wimpys_food_express_statement_of_accounts.check_amount',
                        'wimpys_food_express_statement_of_accounts.or_number',
                        'wimpys_food_express_statement_of_accounts.status',
                        'wimpys_food_express_statement_of_accounts.created_by',
                        'wimpys_food_express_statement_of_accounts.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_statement_of_accounts.billing_statement_id', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleName)
                        ->where('wimpys_food_express_statement_of_accounts.status', '=', $status)
                        ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                        ->sum('wimpys_food_express_statement_of_accounts.total_amount');
                                            
        $totalRemainingBalance  =   DB::table(
                            'wimpys_food_express_statement_of_accounts')
                            ->select(
                            'wimpys_food_express_statement_of_accounts.id',
                            'wimpys_food_express_statement_of_accounts.user_id',
                            'wimpys_food_express_statement_of_accounts.billing_statement_id',
                            'wimpys_food_express_statement_of_accounts.bill_to',
                            'wimpys_food_express_statement_of_accounts.order',
                            'wimpys_food_express_statement_of_accounts.address',
                            'wimpys_food_express_statement_of_accounts.date',
                            'wimpys_food_express_statement_of_accounts.period_cover',
                            'wimpys_food_express_statement_of_accounts.terms',
                            'wimpys_food_express_statement_of_accounts.date_of_transaction',
                            'wimpys_food_express_statement_of_accounts.description',
                            'wimpys_food_express_statement_of_accounts.amount',
                            'wimpys_food_express_statement_of_accounts.total_amount',
                            'wimpys_food_express_statement_of_accounts.total_remaining_balance',
                            'wimpys_food_express_statement_of_accounts.paid_amount',
                            'wimpys_food_express_statement_of_accounts.payment_method',
                            'wimpys_food_express_statement_of_accounts.collection_date',
                            'wimpys_food_express_statement_of_accounts.check_number',
                            'wimpys_food_express_statement_of_accounts.check_amount',
                            'wimpys_food_express_statement_of_accounts.or_number',
                            'wimpys_food_express_statement_of_accounts.status',
                            'wimpys_food_express_statement_of_accounts.created_by',
                            'wimpys_food_express_codes.wimpys_food_express_code',
                            'wimpys_food_express_codes.module_id',
                            'wimpys_food_express_codes.module_code',
                            'wimpys_food_express_codes.module_name')
                            ->join('wimpys_food_express_codes', 'wimpys_food_express_statement_of_accounts.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_statement_of_accounts.billing_statement_id', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleName)
                            ->where('wimpys_food_express_statement_of_accounts.status', NULL)
                            ->where('wimpys_food_express_statement_of_accounts.deleted_at', NULL)
                            ->sum('wimpys_food_express_statement_of_accounts.total_remaining_balance');

        return view('wimpys-food-express-statement-of-account-lists', compact('statementOfAccounts',
        'totalAmount', 'totalRemainingBalance'));
    }

    public function printBillingStatement($id){
        $orFormCBF = self::ORDER_FORM_CB;
        $orFormDR = self::ORDER_FORM_DR;

        $printBillingStatement = WimpysFoodExpressBillingStatement::with(['user', 'billing_statements'])
                                                                        ->where('id', $id)
                                                                        ->get();

        $billingStatements = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = WimpysFoodExpressBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        $pdf = PDF::loadView('printBillingStatementWimpysFoodExpress', compact('printBillingStatement', 
        'billingStatements', 'sum', 'orFormCBF', 'orFormDR'));

        return $pdf->download('wimpys-food-express-billing-statement.pdf'); 
    }

    public function viewBillingStatement($id){
        $orFormCBF = self::ORDER_FORM_CB;
        $orFormDR = self::ORDER_FORM_DR;

        $viewBillingStatement = WimpysFoodExpressBillingStatement::with(['user', 'billing_statements'])
                                                                ->where('id', $id)
                                                                ->get();


        $billingStatements = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        //count the total amount 
        $countTotalAmount = WimpysFoodExpressBillingStatement::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;

        return view('view-wimpys-food-express-billing-statement', compact('viewBillingStatement', 
        'billingStatements', 'sum', 'orFormCBF', 'orFormDR'));

    }

    public function billingStatementList(){
        $billingStatements = WimpysFoodExpressBillingStatement::with(['user', 'billing_statements'])
                                                                ->where('billing_statement_id', NULL)
                                                                ->where('deleted_at', NULL)
                                                                ->orderBy('id', 'desc')
                                                                ->get();

        return view('wimpys-food-express-billing-statement-lists', compact('billingStatements', ));
    }

    public function updateBillingInfo(Request $request, $id){   
        $updateBillingOrder = WimpysFoodExpressBillingStatement::find($id);

        $getOtherBilling = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->get();
       
        if(isset($getOtherBilling[0]->amount) == ""){
            $amount = $request->get('amount');
            $getOtherAmount = 0 + $amount; 

        }else{
            $amount = $request->get('amount');
            $getOtherAmount = $getOtherBilling[0]->amount + $amount; 
        
        }
     

        $updateBillingOrder->date = $request->get('date');
        $updateBillingOrder->bill_to = $request->get('billTo');
        $updateBillingOrder->address = $request->get('address');
        $updateBillingOrder->period_cover = $request->get('periodCovered');
      
        $updateBillingOrder->terms = $request->get('terms');
        $updateBillingOrder->date_of_transaction = $request->get('transactionDate');
        $updateBillingOrder->dr_no = $request->get('drNo');
        $updateBillingOrder->description = $request->get('description');
        $updateBillingOrder->unit_price = $request->get('unitPrice');
        $updateBillingOrder->amount = $request->get('amount');
        $updateBillingOrder->total_amount = $getOtherAmount;
        $updateBillingOrder->save();


             
        //statement of account
        $getMainStatement = WimpysFoodExpressStatementOfAccount::find($id);

        $getStatement = WimpysFoodExpressStatementOfAccount::where('billing_statement_id', $id)->get();
      
        if(isset($getStatement[0]->amount) == ""){
            $amount = $request->get('amount');
            $getOtherAmountSOA = 0 + $amount; 

        }else{
            $amount = $request->get('amount');
            $getOtherAmountSOA = $getStatement[0]->amount + $amount; 
        
        }

        $getMainStatement->bill_to = $request->get('billTo');
        $getMainStatement->period_cover = $request->get('periodCovered');
      
        $getMainStatement->terms = $request->get('terms');
        $getMainStatement->date_of_transaction = $request->get('transactionDate');
        $getMainStatement->dr_no = $request->get('drNo');
        $getMainStatement->description = $request->get('description');
        $getMainStatement->unit_price = $request->get('unitPrice');
        $getMainStatement->amount =  $request->get('amount');
        $getMainStatement->total_amount = $getOtherAmountSOA;
        $getMainStatement->total_remaining_balance = $getOtherAmountSOA;
        $getMainStatement->save();

        Session::flash('SuccessE', 'Successfully updated');

        return redirect()->route('editBillingStatementWimpysFoodExp', ['id'=>$id]);
    }

    public function addNewBilling(Request $request, $id){

        $ids = Auth::user()->id;
        $user = User::find($ids);

        $billingOrder = WimpysFoodExpressBillingStatement::find($id);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;


        if($request->get('choose') === self::ORDER_FORM_CB){
            $order = $request->get('choose');
            $cbfNo = $request->get('cbf');
            $dateOfEvent = $request->get('dateOfEvent');
            $timeOfEvent = $request->get('timeOfEvent');
            $noPax = $request->get('noOfPax');
            $motiff = $request->get('motiff');
            $typeOfPackage = $request->get('typeOfPackage');
            $client = $request->get('client');
            $placeOfEvent = $request->get('placeOfEvent');
    
            $amount = $request->get('totalAmount');
           
            $tot = $billingOrder->total_amount + $amount; 
            
            $drNo = NULL;
            $drListId = NULL;
            $qty = NULL;
            $unit = NULL;
            $description = NULL;
            $price = NULL;
            

        }else if($request->get('choose') === self::ORDER_FORM_DR){
            $order = $request->get('choose');
            $drNo = $request->get('drNo');
            $drListId = $request->get('drList');
            $qty = $request->get('qty');
            $unit = $request->get('unit');
            $description = $request->get('description');
            $price = $request->get('price');

            $amount = $request->get('price');
           
    
            $tot = $billingOrder->total_amount + $amount; 

            $cbfNo = NULL;
            $dateOfEvent = NULL;
            $timeOfEvent = NULL;
            $noPax = NULL;
            $motiff = NULL;
            $typeOfPackage = NULL;
            $client = NULL;
            $placeOfEvent = NULL;
            $totalAmount = NULL;      

        }  


        $addBillingStatement = new WimpysFoodExpressBillingStatement([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'bill_to'=>$request->get('billTo'),
            'address'=>$request->get('address'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'terms'=>$request->get('terms'),
            'dr_no'=>$request->get('drNo'),
            'dr_list_id'=>$drListId,
            'qty'=>$qty,
            'unit'=>$unit,
            'description'=>$description,
            'price'=>$price,
            'order'=>$order,
            'date_of_event'=>$dateOfEvent,
            'time_of_event'=>$timeOfEvent,
            'no_of_people'=>$noPax,
            'motiff'=>$motiff,
            'type_of_package'=>$typeOfPackage,
            'client'=>$client,
            'place_of_event'=>$placeOfEvent,
            'total_amount'=>$amount,
            'date_of_transaction'=>$request->get('transactionDate'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$amount,
            'created_by'=>$name,
            'prepared_by'=>$name,
        ]);

        $addBillingStatement->save();


        $addStatementAccount = new WimpysFoodExpressStatementOfAccount([
            'user_id'=>$user->id,
            'billing_statement_id'=>$id,
            'bill_to'=>$request->get('billTo'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'terms'=>$request->get('terms'),
            'dr_no'=>$request->get('drNo'),
            'dr_list_id'=>$drListId,
            'qty'=>$qty,
            'unit'=>$unit,
            'date_of_transaction'=>$request->get('transactionDate'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$amount,
            'total_remaining_balance'=>$request->get('amount'),
            'date_of_event'=>$dateOfEvent,
            'time_of_event'=>$timeOfEvent,
            'no_of_people'=>$noPax,
            'motiff'=>$motiff,
            'type_of_package'=>$typeOfPackage,
            'client'=>$client,
            'place_of_event'=>$placeOfEvent,
            'amount'=>$amount,
            'total_amount'=>$tot,
            'created_by'=>$name,
            'prepared_by'=>$name,
        ]);
        $addStatementAccount->save();
          
        $statementOrder = WimpysFoodExpressStatementOfAccount::find($id);
       

        //update
        $billingOrder->total_amount = $tot;
        $billingOrder->save();

        //update soa table
        $statementOrder->total_amount  = $tot;
        $statementOrder->total_remaining_balance = $tot;
        $statementOrder->save();

        Session::flash('SuccessAdd', 'Successfully added.');

        return redirect()->route('editBillingStatementWimpysFoodExp', ['id'=>$id]);

    }


    public function editBillingStatement($id){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $billingStatement = WimpysFoodExpressBillingStatement::find($id);

        $bStatements = WimpysFoodExpressBillingStatement::where('billing_statement_id', $id)->get()->toArray();

        $orFormCBF = self::ORDER_FORM_CB;
        $orFormDR = self::ORDER_FORM_DR;

        $moduleName = "Delivery Receipt";
        $drNos = DB::table(
                        'wimpys_food_express_delivery_receipts')
                        ->select( 
                        'wimpys_food_express_delivery_receipts.id',
                        'wimpys_food_express_delivery_receipts.user_id',
                        'wimpys_food_express_delivery_receipts.dr_id',
                        'wimpys_food_express_delivery_receipts.sold_to',
                        'wimpys_food_express_delivery_receipts.delivered_to',
                        'wimpys_food_express_delivery_receipts.time',
                        'wimpys_food_express_delivery_receipts.date',
                        'wimpys_food_express_delivery_receipts.unit',
                        'wimpys_food_express_delivery_receipts.date_to_be_delivered',
                        'wimpys_food_express_delivery_receipts.contact_person',
                        'wimpys_food_express_delivery_receipts.mobile_num',
                        'wimpys_food_express_delivery_receipts.qty',
                        'wimpys_food_express_delivery_receipts.description',
                        'wimpys_food_express_delivery_receipts.price',
                        'wimpys_food_express_delivery_receipts.total',
                        'wimpys_food_express_delivery_receipts.special_instruction',
                        'wimpys_food_express_delivery_receipts.consignee_name',
                        'wimpys_food_express_delivery_receipts.consignee_contact_num',
                        'wimpys_food_express_delivery_receipts.status',
                        'wimpys_food_express_delivery_receipts.prepared_by',
                        'wimpys_food_express_delivery_receipts.checked_by',
                        'wimpys_food_express_delivery_receipts.received_by',
                        'wimpys_food_express_delivery_receipts.created_by',
                        'wimpys_food_express_delivery_receipts.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_delivery_receipts.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_delivery_receipts.dr_id', NULL)
                        ->where('wimpys_food_express_delivery_receipts.status', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleName)
                    
                        ->get()->toArray(); 

         //getAllCbf
         $moduleNameCbf = "Client Booking";
         $getAllCbfs = DB::table(
                             'wimpys_food_express_client_booking_forms')
                             ->select(
                                 'wimpys_food_express_client_booking_forms.id',
                                 'wimpys_food_express_client_booking_forms.user_id',
                                 'wimpys_food_express_client_booking_forms.bf_id',
                                 'wimpys_food_express_client_booking_forms.date_of_event',
                                 'wimpys_food_express_client_booking_forms.time_of_event',
                                 'wimpys_food_express_client_booking_forms.no_of_people',
                                 'wimpys_food_express_client_booking_forms.motiff',
                                 'wimpys_food_express_client_booking_forms.qty',
                                 'wimpys_food_express_client_booking_forms.amount',
                                 'wimpys_food_express_client_booking_forms.type_of_package',
                                 'wimpys_food_express_client_booking_forms.total',
                                 'wimpys_food_express_client_booking_forms.client',
                                 'wimpys_food_express_client_booking_forms.place_of_event',
                                 'wimpys_food_express_client_booking_forms.mobile_number',
                                 'wimpys_food_express_client_booking_forms.email',
                                 'wimpys_food_express_client_booking_forms.special_requests',
                                 'wimpys_food_express_client_booking_forms.menu',
                                 'wimpys_food_express_client_booking_forms.menu_cat',
                                 'wimpys_food_express_client_booking_forms.deleted_at',
                                 'wimpys_food_express_codes.wimpys_food_express_code',
                                 'wimpys_food_express_codes.module_id',
                                 'wimpys_food_express_codes.module_code',
                                 'wimpys_food_express_codes.module_name')
                             ->leftJoin('wimpys_food_express_codes', 'wimpys_food_express_client_booking_forms.id', '=', 'wimpys_food_express_codes.module_id')
                             ->where('wimpys_food_express_client_booking_forms.bf_id', NULL)
                             ->orderBy('wimpys_food_express_client_booking_forms.id', 'desc')
                             ->where('wimpys_food_express_client_booking_forms.deleted_at', NULL)
                             ->where('wimpys_food_express_codes.module_name', $moduleNameCbf)
                             ->get()->toArray();
 

        return view('edit-wimpys-food-express-billing-statement-form', compact('billingStatement', 'bStatements', 
            'orFormCBF', 'orFormDR', 'getAllCbfs', 'drNos'));
    
    }

   
    public function storeBillingStatement(Request $request){
        $ids =  Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        //get user name
        $name  = $firstName." ".$lastName;

        $this->validate($request,[
            'billTo' =>'required',
            'address'=>'required',
            'periodCovered'=>'required',
            'date'=>'required',
            'terms'=>'required',
            'transactionDate'=>'required',
        ]);

         //get the latest insert id query in table billing statements ref number
         $dataReferenceNum = DB::select('SELECT id, wimpys_food_express_code FROM wimpys_food_express_codes ORDER BY id DESC LIMIT 1');

         //if code is not zero add plus 1 reference number
         if(isset($dataReferenceNum[0]->wimpys_food_express_code) != 0){
             //if code is not 0
             $newRefNum = $dataReferenceNum[0]->wimpys_food_express_code +1;
             $uRef = sprintf("%06d",$newRefNum);   
 
         }else{
             //if code is 0 
             $newRefNum = 1;
             $uRef = sprintf("%06d",$newRefNum);
         } 


        if($request->get('choose') === self::ORDER_FORM_CB){
            $order = $request->get('choose');
            $cbfNo = $request->get('cbf');
            $dateOfEvent = $request->get('dateOfEvent');
            $timeOfEvent = $request->get('timeOfEvent');
            $noPax = $request->get('noOfPax');
            $motiff = $request->get('motiff');
            $typeOfPackage = $request->get('typeOfPackage');
            $client = $request->get('client');
            $placeOfEvent = $request->get('placeOfEvent');
            $totalAmount = $request->get('totalAmount');
            

            $drNo = NULL;
            $drListId = NULL;
            $qty = NULL;
            $unit = NULL;
            $description = NULL;
            $price = NULL;
            

        }else if($request->get('choose') === self::ORDER_FORM_DR){
            $order = $request->get('choose');
            $drNo = $request->get('drNo');
            $drListId = $request->get('drList');
            $qty = $request->get('qty');
            $unit = $request->get('unit');
            $description = $request->get('description');
            $totalAmount = $request->get('price');

            $cbfNo = NULL;
            $dateOfEvent = NULL;
            $timeOfEvent = NULL;
            $noPax = NULL;
            $motiff = NULL;
            $typeOfPackage = NULL;
            $client = NULL;
            $placeOfEvent = NULL;
            $price = NULL;
            

        }  
    
        $billingStatement = new WimpysFoodExpressBillingStatement([
            'user_id'=>$user->id,
            'bill_to'=>$request->get('billTo'),
            'address'=>$request->get('address'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'terms'=>$request->get('terms'),
            'dr_no'=>$request->get('drNo'),
            'dr_list_id'=>$drListId,
            'qty'=>$qty,
            'unit'=>$unit,
            'description'=>$description,
            'price'=>$price,
            'order'=>$order,
            'date_of_event'=>$dateOfEvent,
            'time_of_event'=>$timeOfEvent,
            'no_of_people'=>$noPax,
            'motiff'=>$motiff,
            'type_of_package'=>$typeOfPackage,
            'client'=>$client,
            'place_of_event'=>$placeOfEvent,
            'total_amount'=>$totalAmount,
            'date_of_transaction'=>$request->get('transactionDate'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$totalAmount,
            'total_amount'=>$totalAmount,
            'created_by'=>$name,
            'prepared_by'=>$name,
        ]);

        $billingStatement->save();

        $insertedId = $billingStatement->id;

        $moduleCode = "BS-";
        $moduleName = "Billing Statement";

        $wimpysFoodExp = new WimpysFoodExpressCode([
            'user_id'=>$user->id,
            'wimpys_food_express_code'=>$uRef,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);

        $wimpysFoodExp->save();
        $bsNo = $wimpysFoodExp->id;

        $bsNoId = WimpysFoodExpressCode::find($bsNo);

        $statementAccount = new WimpysFoodExpressStatementOfAccount([
            'user_id'=>$user->id,
            'bs_no'=>$bsNoId->wimpys_food_express_code,
            'bill_to'=>$request->get('billTo'),
            'period_cover'=>$request->get('periodCovered'),
            'date'=>$request->get('date'),
            'terms'=>$request->get('terms'),
            'dr_no'=>$request->get('drNo'),
            'dr_list_id'=>$drListId,
            'qty'=>$qty,
            'unit'=>$unit,
            'order'=>$order,
            'date_of_transaction'=>$request->get('transactionDate'),
            'description'=>$request->get('description'),
            'unit_price'=>$request->get('unitPrice'),
            'amount'=>$totalAmount,
            'total_remaining_balance'=>$request->get('amount'),
            'date_of_event'=>$dateOfEvent,
            'time_of_event'=>$timeOfEvent,
            'no_of_people'=>$noPax,
            'motiff'=>$motiff,
            'type_of_package'=>$typeOfPackage,
            'client'=>$client,
            'place_of_event'=>$placeOfEvent,
            'amount'=>$totalAmount,
            'total_amount'=>$totalAmount,
            'total_remaining_balance'=>$totalAmount,
            'created_by'=>$name,
            'prepared_by'=>$name,
        ]);
        $statementAccount->save();
        $insertedIdStatement = $statementAccount->id;

        $moduleCodeSOA = "SOA-";
        $moduleNameSOA = "Statement Of Account";
        
        $uRefStatement = $uRef + 1; 
        $uRefState = sprintf("%06d",$uRefStatement);

        $statement = new WimpysFoodExpressCode([
            'user_id'=>$user->id,
            'wimpys_food_express_code'=>$uRefState,
            'module_id'=>$insertedIdStatement,
            'module_code'=>$moduleCodeSOA,
            'module_name'=>$moduleNameSOA,

        ]);
        $statement->save();

        return redirect()->route('editBillingStatementWimpysFoodExp', ['id'=>$insertedId]);

    }

    public function billingStatementForm(){
        $moduleName = "Delivery Receipt";
        $drNos = DB::table(
                        'wimpys_food_express_delivery_receipts')
                        ->select( 
                        'wimpys_food_express_delivery_receipts.id',
                        'wimpys_food_express_delivery_receipts.user_id',
                        'wimpys_food_express_delivery_receipts.dr_id',
                        'wimpys_food_express_delivery_receipts.sold_to',
                        'wimpys_food_express_delivery_receipts.delivered_to',
                        'wimpys_food_express_delivery_receipts.time',
                        'wimpys_food_express_delivery_receipts.date',
                        'wimpys_food_express_delivery_receipts.unit',
                        'wimpys_food_express_delivery_receipts.date_to_be_delivered',
                        'wimpys_food_express_delivery_receipts.contact_person',
                        'wimpys_food_express_delivery_receipts.mobile_num',
                        'wimpys_food_express_delivery_receipts.qty',
                        'wimpys_food_express_delivery_receipts.description',
                        'wimpys_food_express_delivery_receipts.price',
                        'wimpys_food_express_delivery_receipts.total',
                        'wimpys_food_express_delivery_receipts.special_instruction',
                        'wimpys_food_express_delivery_receipts.consignee_name',
                        'wimpys_food_express_delivery_receipts.consignee_contact_num',
                        'wimpys_food_express_delivery_receipts.status',
                        'wimpys_food_express_delivery_receipts.prepared_by',
                        'wimpys_food_express_delivery_receipts.checked_by',
                        'wimpys_food_express_delivery_receipts.received_by',
                        'wimpys_food_express_delivery_receipts.created_by',
                        'wimpys_food_express_delivery_receipts.deleted_at',
                        'wimpys_food_express_codes.wimpys_food_express_code',
                        'wimpys_food_express_codes.module_id',
                        'wimpys_food_express_codes.module_code',
                        'wimpys_food_express_codes.module_name')
                        ->join('wimpys_food_express_codes', 'wimpys_food_express_delivery_receipts.id', '=', 'wimpys_food_express_codes.module_id')
                        ->where('wimpys_food_express_delivery_receipts.dr_id', NULL)
                        ->where('wimpys_food_express_delivery_receipts.status', NULL)
                        ->where('wimpys_food_express_codes.module_name', $moduleName)
                    
                        ->get()->toArray(); 
      

        //getAllCbf
        $moduleNameCbf = "Client Booking";
        $getAllCbfs = DB::table(
                            'wimpys_food_express_client_booking_forms')
                            ->select(
                                'wimpys_food_express_client_booking_forms.id',
                                'wimpys_food_express_client_booking_forms.user_id',
                                'wimpys_food_express_client_booking_forms.bf_id',
                                'wimpys_food_express_client_booking_forms.date_of_event',
                                'wimpys_food_express_client_booking_forms.time_of_event',
                                'wimpys_food_express_client_booking_forms.no_of_people',
                                'wimpys_food_express_client_booking_forms.motiff',
                                'wimpys_food_express_client_booking_forms.qty',
                                'wimpys_food_express_client_booking_forms.amount',
                                'wimpys_food_express_client_booking_forms.type_of_package',
                                'wimpys_food_express_client_booking_forms.total',
                                'wimpys_food_express_client_booking_forms.client',
                                'wimpys_food_express_client_booking_forms.place_of_event',
                                'wimpys_food_express_client_booking_forms.mobile_number',
                                'wimpys_food_express_client_booking_forms.email',
                                'wimpys_food_express_client_booking_forms.special_requests',
                                'wimpys_food_express_client_booking_forms.menu',
                                'wimpys_food_express_client_booking_forms.menu_cat',
                                'wimpys_food_express_client_booking_forms.deleted_at',
                                'wimpys_food_express_codes.wimpys_food_express_code',
                                'wimpys_food_express_codes.module_id',
                                'wimpys_food_express_codes.module_code',
                                'wimpys_food_express_codes.module_name')
                            ->leftJoin('wimpys_food_express_codes', 'wimpys_food_express_client_booking_forms.id', '=', 'wimpys_food_express_codes.module_id')
                            ->where('wimpys_food_express_client_booking_forms.bf_id', NULL)
                            ->orderBy('wimpys_food_express_client_booking_forms.id', 'desc')
                            ->where('wimpys_food_express_client_booking_forms.deleted_at', NULL)
                            ->where('wimpys_food_express_codes.module_name', $moduleNameCbf)
                            ->get()->toArray();

        return view('wimpys-food-exoress-billing-statement-form', compact('getAllCbfs', 'drNos'));
    }

    public function printPO($id){
        $purchaseOrder =  WimpysFoodExpressPurchaseOrder::with(['user', 'purchase_orders'])
                                            ->where('id', $id)                     
                                            ->get(); 

           
        $pOrders = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->get()->toArray();

            //count the total amount 
        $countTotalAmount = WimpysFoodExpressPurchaseOrder::where('id', $id)->sum('amount');
    
            //
        $countAmount = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->sum('amount');
    
        $sum  = $countTotalAmount + $countAmount;
    
    
        $pdf = PDF::loadView('printPOWimpysFoodExpress', compact('purchaseOrder', 'pOrders', 'sum'));
    
        return $pdf->download('wimpys-food-express-purchase-order.pdf');
    }

    public function purchaseOrderList(){
        $purchaseOrders =  WimpysFoodExpressPurchaseOrder::with(['user', 'purchase_orders'])
                                                ->where('po_id', NULL)
                                                ->where('deleted_at', NULL)
                                                ->orderBy('id', 'desc')
                                                ->get(); 
       
        return view('wimpys-food-express-purchase-order-list', compact('purchaseOrders'));
    }

    public function updatePo(Request $request, $id){
        $order = WimpysFoodExpressPurchaseOrder::find($id);
        $order->quantity = $request->get('quant');
        $order->description = $request->get('desc');
        $order->unit_price = $request->get('unitP');
        $order->amount = $request->get('amt');

        $order->save();

        Session::flash('SuccessEdit', 'Successfully updated');
        return redirect()->route('editWimpysFoodExpress', ['id'=>$request->get('poId')]);
    }

    public function addNewPurchaseOrder(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);
        
        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $pO = WimpysFoodExpressPurchaseOrder::find($id);
    
        $tot = $pO->total_price + $request->get('amount');

        $addPurchaseOrder = new WimpysFoodExpressPurchaseOrder([
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

        return redirect()->route('editWimpysFoodExpress', ['id'=>$id]);
    }

    public function purchaseOrder(){
        return view('wimpys-food-express-purchase-order');
    }

    public function printSupplier($id){
        $printSuppliers =  WimpysFoodExpressSupplier::with(['user', 'suppliers'])
                                                ->where('id', $id)
                                                ->get(); 

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue  = DB::table(
                            'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.supplier_id',
                            'wimpys_food_express_payment_vouchers.supplier_name',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_suppliers.id',
                            'wimpys_food_express_suppliers.date',
                            'wimpys_food_express_suppliers.supplier_name')
                            ->leftJoin('wimpys_food_express_suppliers', 'wimpys_food_express_payment_vouchers.supplier_id', '=', 'wimpys_food_express_suppliers.id')
                            ->where('wimpys_food_express_suppliers.id', $id)
                            ->where('wimpys_food_express_payment_vouchers.status', '!=', $status)
                            ->sum('amount_due');
                                        
        
        $pdf = PDF::loadView('printSupplierWimpys', compact('printSuppliers', 'totalAmountDue'));

        return $pdf->download('wimpys-food-express-supplier.pdf');
    }

    public function viewSupplier($id){
        $viewSuppliers =  WimpysFoodExpressSupplier::with(['user', 'suppliers'])
                                                ->where('id', $id)
                                                ->get();

        $status = "FULLY PAID AND RELEASED";
        $totalAmountDue  = DB::table(
                            'wimpys_food_express_payment_vouchers')
                            ->select( 
                            'wimpys_food_express_payment_vouchers.id',
                            'wimpys_food_express_payment_vouchers.user_id',
                            'wimpys_food_express_payment_vouchers.pv_id',
                            'wimpys_food_express_payment_vouchers.date',
                            'wimpys_food_express_payment_vouchers.paid_to',
                            'wimpys_food_express_payment_vouchers.account_no',
                            'wimpys_food_express_payment_vouchers.account_name',
                            'wimpys_food_express_payment_vouchers.particulars',
                            'wimpys_food_express_payment_vouchers.amount',
                            'wimpys_food_express_payment_vouchers.method_of_payment',
                            'wimpys_food_express_payment_vouchers.prepared_by',
                            'wimpys_food_express_payment_vouchers.approved_by',
                            'wimpys_food_express_payment_vouchers.date_approved',
                            'wimpys_food_express_payment_vouchers.received_by_date',
                            'wimpys_food_express_payment_vouchers.created_by',
                            'wimpys_food_express_payment_vouchers.created_at',
                            'wimpys_food_express_payment_vouchers.invoice_number',
                            'wimpys_food_express_payment_vouchers.issued_date',
                            'wimpys_food_express_payment_vouchers.category',
                            'wimpys_food_express_payment_vouchers.amount_due',
                            'wimpys_food_express_payment_vouchers.delivered_date',
                            'wimpys_food_express_payment_vouchers.status',
                            'wimpys_food_express_payment_vouchers.cheque_number',
                            'wimpys_food_express_payment_vouchers.cheque_amount',
                            'wimpys_food_express_payment_vouchers.sub_category',
                            'wimpys_food_express_payment_vouchers.sub_category_account_id',
                            'wimpys_food_express_payment_vouchers.supplier_id',
                            'wimpys_food_express_payment_vouchers.supplier_name',
                            'wimpys_food_express_payment_vouchers.deleted_at',
                            'wimpys_food_express_suppliers.id',
                            'wimpys_food_express_suppliers.date',
                            'wimpys_food_express_suppliers.supplier_name')
                            ->leftJoin('wimpys_food_express_suppliers', 'wimpys_food_express_payment_vouchers.supplier_id', '=', 'wimpys_food_express_suppliers.id')
                            ->where('wimpys_food_express_suppliers.id', $id)
                            ->where('wimpys_food_express_payment_vouchers.status', '!=', $status)
                            ->sum('amount_due');
            
        return view('view-wimpys-food-express-supplier', compact('viewSuppliers', 'totalAmountDue'));
    }


    public function addSupplier(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

            //check if supplier name exits
        $target = DB::table(
                'wimpys_food_express_suppliers')
                ->where('supplier_name', $request->supplierName)
                ->get()->first();

        if($target === NULL){
            $supplier = new WimpysFoodExpressSupplier([
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
        $suppliers = WimpysFoodExpressSupplier::with(['user', 'suppliers'])
                                            ->orderBy('id', 'desc')
                                            ->get();
        return view('wimpys-food-express-supplier', compact('suppliers'));
    }

    public function printPayables($id){
        $payableId = WimpysFoodExpressPaymentVoucher::with(['user','payment_vouchers'])
                                ->where('id', $id)
                                ->get();   

        //getParticular details
        $getParticulars = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
    
        $getChequeNumbers = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        $getCashAmounts = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
        $amount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;
        

        $pdf = PDF::loadView('printPayablesWimpysFoodExpress', compact('payableId',  
        'getChequeNumbers', 'getCashAmounts', 'sum', 'getParticulars', 'sumCheque'));

        return $pdf->download('wimpys-food-express-payment-voucher.pdf');
    }

    public function viewPayableDetails($id){
        $viewPaymentDetail = WimpysFoodExpressPaymentVoucher::with(['user','payment_vouchers'])
                                                            ->where('id', $id)
                                                            ->withTrashed()
                                                            ->get(); 
                            
        $getChequeNumbers = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        $getCashAmounts = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        

        //getParticular details
        $getParticulars = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
    
        //amount
        $amount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('view-wimpys-food-express-payable-details', compact('viewPaymentDetail', 
        'getChequeNumbers', 'getCashAmounts', 'getParticulars', 'sum', 'sumCheque'));
    }

    public function transactionList(){
        $getTransactionLists = WimpysFoodExpressPaymentVoucher::with(['user','payment_vouchers'])
                                        ->where('pv_id', NULL)
                                        ->where('deleted_at', NULL)
                                        ->orderBy('id', 'desc')
                                        ->get();

        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = WimpysFoodExpressPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');
        

        return view('wimpys-food-transaction-transaction-list', compact('getTransactionLists', 'totalAmoutDue'));
        
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
  
                      $payables = WimpysFoodExpressPaymentVoucher::find($id);
                      $payables->status = $status;
                      $payables->delivered_date = $getDate;
                      $payables->created_by = $name; 
                      $payables->save();
  
                      Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');
  
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
  
          }else if($status == "FOR APPROVAL"){
              switch ($request->get('action')) {
                  case 'PAID & HOLD':
                      # code...
                      $payables = WimpysFoodExpressPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                       Session::flash('payablesSuccess', 'Status set for approval.');
  
                       return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
  
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
          }else{
  
              switch ($request->get('action')) {
                  case 'PAID & HOLD':
                      # code...
                      $payables = WimpysFoodExpressPaymentVoucher::find($id);
  
                      $payables->status = $status;
                      $payables->save();
  
                      Session::flash('payablesSuccess', 'Status set for confirmation.');
  
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
                      
                      break;
                  
                  default:
                      # code...
                      return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id])->with('errorPaid', 'STATUS IS INVALID.');
                      break;
              }
          }  
    
    }

    public function updateDetails(Request $request){
        $updateDetails = WimpysFoodExpressPaymentVoucher::find($request->id);

        $updateDetails->paid_to =  $request->paidTo;
        $updateDetails->invoice_number = $request->invoiceNo;
        $updateDetails->account_name = $request->accountName;
 
        $updateDetails->save();
 
        return response()->json('Success: successfully updated.');
    }

    public function updateParticulars(Request $request){
        $updateParticular =  WimpysFoodExpressPaymentVoucher::find($request->id);

        $amount = $request->amount; 
     
        $tot = WimpysFoodExpressPaymentVoucher::where('pv_id', $request->id)->sum('amount');
 
        $sum = $amount + $tot; 
 
        $updateParticular->date = $request->date;
        $updateParticular->particulars = $request->particulars;
        $updateParticular->amount = $amount;
        $updateParticular->amount_due = $sum;
        $updateParticular->save();
 
        return response()->json('Success: successfully updated.');
    }

    public function updateP(Request $request){
          //main id 
          $updateParticular = WimpysFoodExpressPaymentVoucher::find($request->transId);

          //particular id
          $uIdParticular = WimpysFoodExpressPaymentVoucher::find($request->id);
  
          $amount = $request->amount; 
  
          $updateAmount =  $updateParticular->amount; 
         
          $uParticular = WimpysFoodExpressPaymentVoucher::where('pv_id', $request->transId)->sum('amount');
          
          $tot = $updateAmount + $uParticular; 
         
        
          $uIdParticular->date  = $request->date;
          $uIdParticular->particulars = $request->particulars;
          $uIdParticular->amount = $amount; 
          $uIdParticular->save();
  
          $updateParticular->amount_due = $tot;
          $updateParticular->save();
          
          return response()->json('Success: successfully updated.');
    }

    public function updateCheck(Request $request){
        $updateCheck = WimpysFoodExpressPaymentVoucher::find($request->id);

        $updateCheck->account_name_no = $request->accountNameNo;
        $updateCheck->cheque_number = $request->checkNumber;
        $updateCheck->cheque_amount = $request->checkAmount;
        $updateCheck->save();

        return response()->json('Success: successfully updated.');
    }

    public function updateCash(Request $request){   
        $updateCash = WimpysFoodExpressPaymentVoucher::find($request->id);

        $updateCash->cheque_amount = $request->cashAmount;
        $updateCash->save();

        return response()->json('Success: successfully updated.');
    }

    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $paymentData = WimpysFoodExpressPaymentVoucher::find($id);

        $totalChequeAmount = $paymentData->cheque_total_amount + $request->get('chequeAmount');

        //save payment cheque num and cheque amount
        $addPayment = new WimpysFoodExpressPaymentVoucher([
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

        return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
 
    }

    public function addParticulars(Request $request, $id){  
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $particulars = WimpysFoodExpressPaymentVoucher::find($id);

        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

        $addParticulars = new WimpysFoodExpressPaymentVoucher([
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


        return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$id]);
    }

    public function editPayablesDetail(Request $request, $id){
        $transactionList = WimpysFoodExpressPaymentVoucher::with(['user','payment_vouchers'])
                                ->where('id', $id)
                                ->get();

        $getChequeNumbers = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        $getCashAmounts = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('cheque_amount', '!=', NULL)->get()->toArray();
        
        //getParticular details
        $getParticulars = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        //amount
        $amount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('amount');
            
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = WimpysFoodExpressPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = WimpysFoodExpressPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('wimpys-food-express-payables-detail', compact('transactionList', 'getChequeNumbers','sum'
        , 'getParticulars', 'sumCheque', 'getCashAmounts'));
    }

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
          $dataCode = DB::select('SELECT id, wimpys_food_express_code FROM wimpys_food_express_codes ORDER BY id DESC LIMIT 1');

          //if code is not zero add plus 1 reference number
          if(isset($dataCode[0]->wimpys_food_express_code) != 0){
              //if code is not 0
              $newCode= $dataCode[0]->wimpys_food_express_code +1;
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
                'wimpys_food_express_payment_vouchers')
                ->where('invoice_number', $request->get('invoiceNumber'))
                ->get()->first();

        if ($target === NULL) {
            # code...
                $addPaymentVoucher = new WimpysFoodExpressPaymentVoucher([
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
            $wimpysCode = new WimpysFoodExpressCode([
                'user_id'=>$user->id,
                'wimpys_food_express_code'=>$uCode,
                'module_id'=>$insertedId,
                'module_code'=>$moduleCode,
                'module_name'=>$moduleName,
    
            ]);
            $wimpysCode->save();

            return redirect()->route('editPayablesDetailWimpysFoodExpress', ['id'=>$insertedId]);

        }else{
            return redirect()->route('paymentVoucherFormWimpys')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }  
  
    }

    public function paymentVoucherForm(){   
        $suppliers =  WimpysFoodExpressSupplier::with(['user', 'suppliers'])
                                                 ->get();
        return view('payment-voucher-form-wimpys-food-express', compact('suppliers'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //return view('wimpys-food-express');
        return redirect()->route('orderFormLists');
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
            'address'=> 'required',
            'quantity'=>'required',
            'description'=>'required',
            'unitPrice'=>'required',
            'amount'=>'required',
        ]);

         //get the latest insert id query in table lechon_de_cebu_codes
         $data = DB::select('SELECT id, wimpys_food_express_code FROM wimpys_food_express_codes ORDER BY id DESC LIMIT 1');
        
         //if code is not zero add plus 1
        if(isset($data[0]->wimpys_food_express_code) != 0){
             //if code is not 0
             $newNum = $data[0]->wimpys_food_express_code +1;
             $uNum = sprintf("%06d",$newNum);    
         }else{
             //if code is 0 
             $newNum = 1;
             $uNum = sprintf("%06d",$newNum);
         }

         
         $purchaseOrder = new WimpysFoodExpressPurchaseOrder([
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
        $wimpysFoodExpress = new WimpysFoodExpressCode([
            'user_id'=>$user->id,
            'wimpys_food_express_code'=>$uNum,
            'module_id'=>$insertedId,
            'module_code'=>$moduleCode,
            'module_name'=>$moduleName,

        ]);
        $wimpysFoodExpress->save();

        return redirect()->route('editWimpysFoodExpress', ['id'=>$insertedId]);
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
        $purchaseOrder =  WimpysFoodExpressPurchaseOrder::with(['user', 'purchase_orders'])
                                                    ->where('id', $id)
                                                    ->get(); 

        $pOrders = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->get()->toArray();

            //count the total amount 
        $countTotalAmount = WimpysFoodExpressPurchaseOrder::where('id', $id)->sum('amount');

        //
        $countAmount = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->sum('amount');

        $sum  = $countTotalAmount + $countAmount;


        return view('view-wimpys-food-express-purchase-order', compact('purchaseOrder', 'pOrders', 'sum'));
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
        $purchaseOrder = WimpysFoodExpressPurchaseOrder::with(['user', 'purchase_orders'])
                                                ->where('id', $id)
                                                ->get();

        $pOrders = WimpysFoodExpressPurchaseOrder::where('po_id', $id)->get()->toArray();

        return view('edit-wimpys-food-express-purchase-order', compact('id', 'purchaseOrder', 'pOrders'));
    }

    /**
     * Update the specified resource in storage.
     *+
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

        $purchaseOrder = WimpysFoodExpressPurchaseOrder::find($id);
        
        $purchaseOrder->paid_to = $paidTo;
        $purchaseOrder->address = $address;
        $purchaseOrder->date = $date;
        $purchaseOrder->description = $description;
        $purchaseOrder->quantity = $quantity;
        $purchaseOrder->unit_price = $unitPrice;
        $purchaseOrder->amount = $amount;

        $purchaseOrder->save();

        
        Session::flash('SuccessE', 'Successfully updated');

        return redirect()->route('editWimpysFoodExpress', ['id'=>$id]);
    }

    public function destroyDeliveryReceipt(Request $request, $id){
        $drId = WimpysFoodExpressDeliveryReceipt::find($request->drId);
 
        $deliveryReceipt = WimpysFoodExpressDeliveryReceipt::find($id);
        $getAmount = $drId->total - $deliveryReceipt->price;

        $drId->total = $getAmount; 
        $drId->save();

        $deliveryReceipt->delete();
    }

    public function destroyClientBooking(Request $request, $id){
        $clientBooking = WimpysFoodExpressClientBookingForm::find($id);

        $menuId = WimpysFoodExpressClientBookingForm::find($request->menuId);


        if($clientBooking->amount){

            $amount = $menuId->total - $clientBooking->amount; 
            $menuId->total = $amount;
            $menuId->save();
        }

        $clientBooking->delete();
    }

    public function destroyMenu($id){
        $menu = WimpysFoodExpressMenuList::find($id);
        $menu->delete();
    }

    public function destroyMenuList($id){
        $stockMenu = WimpysFoodExpressStockInventory::find($id);
        $stockMenu->delete();
    }

    public function destroyOrderForm($id){
        $orderForm = WimpysFoodExpressOrderForm::find($id);

        $orderForm->delete();
    }

    public function destroyBillingStatement($id){
        $billingStatement = WimpysFoodExpressBillingStatement::find($id);
        $billingStatement->delete();
        

        //delete SOA 
        $soa = WimpysFoodExpressStatementOfAccount::find($id);
        $soa->delete();

    }

    public function destroyBillingDataStatement(Request $request, $id){
        $billStatement = WimpysFoodExpressBillingStatement::find($request->billingStatementId);

        $billingStatement = WimpysFoodExpressBillingStatement::find($id);
    
        $getAmount = $billStatement->total_amount - $billingStatement->amount;
        $billStatement->total_amount = $getAmount;
        $billStatement->save();

        $billingStatement->delete();

        //update statement of account table
        $statementAccount = WimpysFoodExpressStatementOfAccount::find($request->billingStatementId);

        $stateAccount = WimpysFoodExpressStatementOfAccount::find($id);

        $getStateAmount = $statementAccount->total_amount - $stateAccount->amount; 
        $statementAccount->total_amount = $getStateAmount;
        $statementAccount->total_remaining_balance = $getStateAmount;
        $statementAccount->save();

        $stateAccount->delete();

    }

    public function destroyTransactionList($id){
        $transactionList = WimpysFoodExpressPaymentVoucher::find($id);
        $transactionList->delete();
    }

    public function destroyPO($id){
        $purchaseOrder = WimpysFoodExpressPurchaseOrder::find($id);
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
        //
        $poId = WimpysFoodExpressPurchaseOrder::find($request->poId);

        $purchaseOrder = WimpysFoodExpressPurchaseOrder::find($id);
        $getAmount = $poId->total_price - $purchaseOrder->amount;

        $poId->total_price = $getAmount;
        $poId->save();

        $purchaseOrder->delete();

    }
}
