<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use PDF; 
use Session;
use Auth; 
use App\User;
use App\DnoPersonalPaymentVoucher;
use App\DnoPersonalCreditCard;
use App\DnoPersonalProperty;
use App\DnoPersonalUtility; 

class DnoPersonalController extends Controller
{

    //view service provider
    public function viewServiceProvider($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
         $viewBill = DnoPersonalPaymentVoucher::find($id);

        //getParticular details
        $getParticulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
     

        return view('dno-personal-view-bills', compact('user', 'viewBill', 'getParticulars'));
    }

    //
    public function vehicleUpdate(Request $request){
        
        $updateVehicle = DnoPersonalUtility::find($request->id);

        $updateVehicle->vehicle_unit = $request->editVehicleUnit;
        $updateVehicle->series = $request->editSeries;
        $updateVehicle->denomination = $request->editDenomination;
        $updateVehicle->body_type = $request->editBodyType;
        $updateVehicle->year_model = $request->editYearModel;
        $updateVehicle->mv_file_no = $request->editMVFile;
        $updateVehicle->plate_no = $request->editPlateNo;
        $updateVehicle->engine_no = $request->editEngineNo;
        $updateVehicle->cr_no = $request->editCrNo;
        $updateVehicle->location = $request->editLocation;

        $updateVehicle->save();

        return response()->json('Success: successfully updated.'); 

    }   


    //
    public function storePMSDocument(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $document = $request->file('document');

        if($document == ""){
            Session::flash('errorUp', 'Please upload a file.');
            return redirect('dno-personal/vehicles/view/'.$id);
        }else{
            $document = $request->file('document');
            
            $profileImageSaveAsName = time() . "." .$document->getClientOriginalExtension();
            
            if($document->getClientOriginalExtension() == "jpg"){
                //upload the file to uploads folder
                $upload_path = 'uploads/documents';
                $image = $upload_path . $profileImageSaveAsName;

                //move the image to uploads folder
                $success = $document->move($upload_path, $profileImageSaveAsName);

                $flag = "PMS List";

                $getDate = date("Y-m-d");
                $addDocument = new DnoPersonalUtility([
                    'user_id'=>$user->id,
                    'pu_id'=>$id,
                    'upload_document'=>$profileImageSaveAsName,
                    'document_name'=>$request->get('docName'),
                    'flag'=>$flag,
                    'date'=>$getDate,
                    'created_by'=>$name,
                ]);

                $addDocument->save();

                Session::flash('uploadPMSDocu', 'Document successfully uploaded');

                return redirect('dno-personal/vehicles/view/'.$id);

            }else if($document->getClientOriginalExtension() == "png"){
                 //upload the file to uploads folder
                 $upload_path = 'uploads/documents';
                 $image = $upload_path . $profileImageSaveAsName;
 
                 //move the image to uploads folder
                 $success = $document->move($upload_path, $profileImageSaveAsName);

                 $flag = "PMS List";

                $getDate = date("Y-m-d");
                $addDocument = new DnoPersonalUtility([
                    'user_id'=>$user->id,
                    'pu_id'=>$id,
                    'upload_document'=>$profileImageSaveAsName,
                    'document_name'=>$request->get('docName'),
                    'flag'=>$flag,
                    'date'=>$getDate,
                    'created_by'=>$name,
                ]);
                 $addDocument->save();
 
                 Session::flash('uploadPMSDocu', 'Document successfully uploaded');
 
                 return redirect('dno-personal/vehicles/view/'.$id);


            }else if($document->getClientOriginalExtension() == "jpeg"){
                  //upload the file to uploads folder
                  $upload_path = 'uploads/documents';
                  $image = $upload_path . $profileImageSaveAsName;
  
                  //move the image to uploads folder
                  $success = $document->move($upload_path, $profileImageSaveAsName);
                  
                  $flag = "PMS List";

                  $getDate = date("Y-m-d");
                  $addDocument = new DnoPersonalUtility([
                      'user_id'=>$user->id,
                      'pu_id'=>$id,
                      'upload_document'=>$profileImageSaveAsName,
                      'document_name'=>$request->get('docName'),
                      'flag'=>$flag,
                      'date'=>$getDate,
                      'created_by'=>$name,
                  ]);

                  $addDocument->save();
  
                  Session::flash('uploadPMSDocu', 'Document successfully uploaded');
  
                  return redirect('dno-personal/vehicles/view/'.$id);
            }else{

                Session::flash('errorUp', 'Invalid file type.');
                return redirect('dno-personal/vehicles/view/'.$id);
            }

        }
        
    }
    
    //
    public function viewDocumentList($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $getViewDocument = DnoPersonalUtility::find($id);
       
        //getDocumentParticulars
        $getDocumentParticulars = DnoPersonalPaymentVoucher::where('utility_sub_category', $id)->get()->toArray();
        
        return view('dno-personal-view-document-list', compact('user', 'getViewDocument', 'getDocumentParticulars'));
        
    }

    //
    public function storeDocument(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        $document = $request->file('document');
        
        if($document == ""){
            Session::flash('err', 'Please upload a file.');
            return redirect('dno-personal/vehicles/view/'.$id);
        }else{
            $document = $request->file('document');
            
            $profileImageSaveAsName = time() . "." .$document->getClientOriginalExtension();
            
            if($document->getClientOriginalExtension() == "jpg"){
                //upload the file to uploads folder
                $upload_path = 'uploads/documents';
                $image = $upload_path . $profileImageSaveAsName;

                //move the image to uploads folder
                $success = $document->move($upload_path, $profileImageSaveAsName);

                $flag = "OR List";

                $getDate = date("Y-m-d");
                $addDocument = new DnoPersonalUtility([
                    'user_id'=>$user->id,
                    'pu_id'=>$id,
                    'upload_document'=>$profileImageSaveAsName,
                    'document_name'=>$request->get('docName'),
                    'flag'=>$flag,
                    'date'=>$getDate,
                    'created_by'=>$name,
                ]);

                $addDocument->save();

                Session::flash('uploadDocu', 'Document successfully uploaded');

                return redirect('dno-personal/vehicles/view/'.$id);

            }else if($document->getClientOriginalExtension() == "png"){
                 //upload the file to uploads folder
                 $upload_path = 'uploads/documents';
                 $image = $upload_path . $profileImageSaveAsName;
 
                 //move the image to uploads folder
                 $success = $document->move($upload_path, $profileImageSaveAsName);

                 $flag = "OR List";

                $getDate = date("Y-m-d");
                $addDocument = new DnoPersonalUtility([
                    'user_id'=>$user->id,
                    'pu_id'=>$id,
                    'upload_document'=>$profileImageSaveAsName,
                    'document_name'=>$request->get('docName'),
                    'flag'=>$flag,
                    'date'=>$getDate,
                    'created_by'=>$name,
                ]);

                 $addDocument->save();
 
                 Session::flash('uploadDocu', 'Document successfully uploaded');
 
                 return redirect('dno-personal/vehicles/view/'.$id);


            }else if($document->getClientOriginalExtension() == "jpeg"){
                  //upload the file to uploads folder
                  $upload_path = 'uploads/documents';
                  $image = $upload_path . $profileImageSaveAsName;
  
                  //move the image to uploads folder
                  $success = $document->move($upload_path, $profileImageSaveAsName);
                  
                  $flag = "OR List";

                  $getDate = date("Y-m-d");
                  $addDocument = new DnoPersonalUtility([
                      'user_id'=>$user->id,
                      'pu_id'=>$id,
                      'upload_document'=>$profileImageSaveAsName,
                      'document_name'=>$request->get('docName'),
                      'flag'=>$flag,
                      'date'=>$getDate,
                      'created_by'=>$name,
                  ]);

                  $addDocument->save();
  
                  Session::flash('uploadDocu', 'Document successfully uploaded');
  
                  return redirect('dno-personal/vehicles/view/'.$id);
            }else{

                Session::flash('err', 'Invalid file type.');
                return redirect('dno-personal/vehicles/view/'.$id);
            }

        }

    }

    //
    public function viewVehicle($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $getVehicle = DnoPersonalUtility::find($id);

        $flagOR = "OR List";
        $flagPMS = "PMS List";

        //get OR documents
        $getORDocuments = DnoPersonalUtility::where('pu_id', $id)->where('flag', $flagOR)->get()->toArray();

        //get PMS documents
        $getPMSDocuments = DnoPersonalUtility::where('pu_id', $id)->where('flag', $flagPMS)->get()->toArray();

        return view('dno-personal-view-vehicles', compact('user', 'getVehicle', 'getORDocuments', 'getPMSDocuments'));
    }

    //
    public function storeVehicles(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //check if vehicle unit already exists
        $target = DB::table(
            'dno_personal_utilities')
            ->where('vehicle_unit', $request->vehicleUnit)
            ->get()->first();
        
        if($target === NULL){
            $addVehicle = new DnoPersonalUtility([
                'user_id'=>$user->id,
                'vehicle_unit'=>$request->vehicleUnit,
                'series'=>$request->series,
                'denomination'=>$request->denomination,
                'body_type'=>$request->bodyType,
                'year_model'=>$request->yearModel,
                'mv_file_no'=>$request->mVFile,
                'plate_no'=>$request->plateNo,
                'engine_no'=>$request->engineNo,
                'cr_no'=>$request->crNo,
                'location'=>$request->location,
                'created_by'=>$name,
            ]);
    
            $addVehicle->save();
    
            return response()->json('Success: Vehicle has been added'); 
        }else{

            return response()->json('Error: Vehicle already exists');
        }

    
    }

    //
    public function vehicles(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getVehicles
        $getVehicles = DnoPersonalUtility::where('pu_id', NULL)->get()->toArray();
        
        return view('dno-personal-vehicles', compact('user', 'getVehicles'));
    }

    //
    public function viewBills($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewBill = DnoPersonalProperty::find($id);

        //
        $viewParticulars = DnoPersonalPaymentVoucher::where('sub_category_account_id', $id)->get()->toArray();
       

        return view('dno-personal-view-bills', compact('user', 'viewBill', 'viewParticulars'));
    } 
    
    //save method for skycable
    public function addSky(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
        $getDate =  date("Y-m-d");

        //check if account no already exists
        $target = DB::table(
            'dno_personal_properties')
            ->where('account_no', $request->skyAccountNo)
            ->get()->first();

        if($target == NULL){
            $addSky = new DnoPersonalProperty([
                'user_id'=>$user->id,
                'pp_id'=>$request->propIdSky,
                'account_id'=>$request->skyAccountNo,
                'account_name'=>$request->skyAccountName,
                'flag'=>$request->flagSky,
                'date'=>$getDate,
                'created_by'=>$name,

            ]);
            $addSky->save();
            return response()->json('Success: successfully added an account.');
        }else{
            return response()->json('Error: account already exist.');
        }


    }

    //save method for pldt 
    public function addPLDT(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
         $getDate =  date("Y-m-d");

        //check if account no already exists
        $target = DB::table(
            'dno_personal_properties')
            ->where('account_no', $request->accountNoPLDT)
            ->get()->first();
        
        if($target == NULL){
            $addPLDT = new DnoPersonalProperty([
                'user_id'=>$user->id,
                'pp_id'=>$request->propIdPLDT,
                'account_id'=>$request->accountNoPLDT,
                'account_name'=>$request->accountNamePLDT,
                'telephone_no'=>$request->telephoneNO,
                'meter_no'=>$request->meterNo,
                'flag'=>$request->flagPLDT,
                'date'=>$getDate,
                'created_by'=>$name,

            ]);
            $addPLDT->save();
            return response()->json('Success: successfully added an account.');
        }else{
            return response()->json('Error: account already exist.');
        }


    }
    

    //save method for veco and mcwd
    public function addOtherBills(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         //get the date today
         $getDate =  date("Y-m-d");

        //check if veco account and mcwd already exists
        $target = DB::table(
                    'dno_personal_properties')
                    ->where('account_id', $request->accountId)
                    ->get()->first();
        if($target == NULL){
            $addOtherBills = new DnoPersonalProperty([
                'user_id'=>$user->id,
                'pp_id'=>$request->propId,
                'account_id'=>$request->accountId,
                'account_name'=>$request->accountName,
                'meter_no'=>$request->meterNo,
                'flag'=>$request->flag,
                'date'=>$getDate,
                'created_by'=>$name,

            ]);
            $addOtherBills->save();
            return response()->json('Success: successfully added an account.');

        }else{
            return response()->json('Error: Account ID already exist.'); 
        }

    }

    //
    public function updateProperty(Request $request){
        $property = DnoPersonalProperty::find($request->id);
        $property->property_name = $request->propNameUpdate;
        $property->property_account_code = $request->propAccountCodeUpdate;
        $property->property_account_name = $request->propAccountNameUpdate;
        $property->address = $request->addressUpdate;
        $property->unit = $request->unitUpdate;
        $property->status = $request->statusUpdate;
        $property->save();

        return response()->json('Success: successfully updated.');
    }

    //
    public function updateSky(Request $request){
        $updateSky = DnoPersonalProperty::find($request->id);
        $updateSky->account_no = $request->skyAccountNoUpdate;
        $updateSky->account_name =$request->skyAccountNameUpdate;
        $updateSky->save();

        return response()->json('Success: successfully updated.');
    }

    //
    public function updatePldt(Request $request){   
        $updatePLDT = DnoPersonalProperty::find($request->id);
        $updatePLDT->account_no = $request->accountNoPLDTUpdate;
        $updatePLDT->account_name = $request->accountNamePLDTUpdate;
        $updatePLDT->telephone_no = $request->telephoneNOUpdate;
        $updatePLDT->save();

        return response()->json('Success: successfully updated');
    }

    //
    public function updateProperties(Request $request){
        $updateProperty = DnoPersonalProperty::find($request->id);

        $updateProperty->account_id = $request->accountIdUpdate;
        $updateProperty->account_name = $request->accountNameUpdate;
        $updateProperty->meter_no = $request->meterNoUpdate;
        $updateProperty->save();
        return response()->json('Success: successfully updated.');

        
    }

    //
    public function viewProperties($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $viewProperty = DnoPersonalProperty::find($id);

        $flag = "Veco";
        $flagMc = "MCWD";
        $flagPLDT = "PLDT";
        $flagSky = "SkyCable";
        $subCat = "Service Provider";

        $vecoDocuments = DnoPersonalProperty::where('pp_id', $id)->where('flag', $flag)->get()->toArray();

        $mcwdDocuments = DnoPersonalProperty::where('pp_id', $id)->where('flag', $flagMc)->get()->toArray();

        $PLDTDocuments = DnoPersonalProperty::where('pp_id', $id)->where('flag', $flagPLDT)->get()->toArray();

        $skyDocuments = DnoPersonalProperty::where('pp_id', $id)->where('flag', $flagSky)->get()->toArray();

        //service provider
        $serviceProviders = DnoPersonalPaymentVoucher::where('sub_category', $id)->where('sub_category_bill_name', $subCat)->get()->toArray();

        //
        $viewParticulars = DnoPersonalPaymentVoucher::where('sub_category_account_id', $id)->get()->toArray();
      

        return view('dno-personal-view-property', compact('user', 'viewProperty', 'vecoDocuments', 
        'mcwdDocuments', 'PLDTDocuments', 'skyDocuments', 'serviceProviders', 'viewParticulars'));
    }

    //
    public function storeProperties(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //check if property unit already exists
        $target = DB::table(
                    'dno_personal_properties')
                    ->where('property_name', $request->propName)
                    ->get()->first();
    
        if($target  == NULL){
            $addProperties = new DnoPersonalProperty([
                'user_id'=>$user->id,
                'property_name'=>$request->propName,
                'property_account_code'=>$request->propAccountCode,
                'property_account_name'=>$request->propAccountName,
                'address'=>$request->address,
                'unit'=>$request->unit,
                'status'=>$request->status,
                'flag'=>$request->flag,
                'created_by'=>$name,
            ]);
    
            $addProperties->save();
            return response()->json('Success: successfully added a property.'); 
        }else{
            return response()->json('Error: property has been existed.'); 
        }
      

       
    }

    //
    public function properties(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $cebuFlag = "Cebu Properties";
        $manilaFlag = "Manila Properties";

        //getCebuProperties
        $getCebuProperties = DnoPersonalProperty::where('flag', $cebuFlag)->get()->toArray();

        //getManilaProperties
        $getManilaProperties = DnoPersonalProperty::where('flag', $manilaFlag)->get()->toArray();
         
        return view('dno-personal-properties', compact('user', 'getCebuProperties', 'getManilaProperties'));  
    }

    //
    public function printPersonalTransactions($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $personalExpenses = DnoPersonalPaymentVoucher::find($id);

        $particulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('amount', '!=', NULL)->get()->toArray();

        //
        $payments = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('amount', NULL)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount_due');
            //
        $countAmount = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;

        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        $pdf = PDF::loadView('printPersonalTransactions', compact('personalExpenses', 'user', 'particulars', 'sum', 
        'payments', 'sumCheque'));

        return $pdf->download('dno-personal-transaction.pdf');
   
    }

    //
    public function printCardTransactions($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $creditCard = DnoPersonalPaymentVoucher::find($id);

        $particulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('amount', '!=', NULL)->get()->toArray();

        //
        $payments = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('amount', NULL)->get()->toArray();

        //count the total amount 
        $countTotalAmount = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount_due');
            //
        $countAmount = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;

        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;


        $pdf = PDF::loadView('printCardTransactions', compact('creditCard', 'user', 'particulars', 'sum', 
        'payments', 'sumCheque'));

        return $pdf->download('dno-personal-card-transaction.pdf');
    }

    //
    public function personalTransaction($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

          //
        $viewTransaction = DnoPersonalPaymentVoucher::find($id);
    
        //getParticular details
        $getParticulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
          //
        $getChequeNumbers = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //amount
        $amount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;

        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        return view('dno-personal-personal-expenses-transaction', compact('user', 'viewTransaction', 
        'sum', 'getParticulars', 'getChequeNumbers', 'sumCheque'));
    }

    //
    public function viewTransaction($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewTransaction = DnoPersonalPaymentVoucher::find($id);

        //
        $getChequeNumbers = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();


        //getParticular details
        $getParticulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        
        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

        //amount
        $amount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount');
        
        $sum = $amount1 + $amount2;

        

        return view('dno-personal-credit-card-view', compact('user', 'viewTransaction', 'getParticulars', 
            'getChequeNumbers', 'sumCheque', 'sum'));
    }

    //
    public function cardTransaction($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        
        //creditCardDetail
        $creditCardDetail = DnoPersonalCreditCard::find($id);
        
        //getTransaction
        $getTransactions = DnoPersonalPaymentVoucher::where('account_no', $creditCardDetail['account_no'])->get()->toArray();
       
        //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmountDue = DnoPersonalPaymentVoucher::where('account_no', $creditCardDetail['account_no'])
        ->where('status' ,'!=', $status)->sum('amount_due');

            
        return view('dno-personal-credit-card-transaction', compact('user', 'getTransactions', 'creditCardDetail', 
        'totalAmountDue'));
    }

  
    //
    public function editCreditCardAccount(Request $request){
        $updateCard = DnoPersonalCreditCard::find($request->id);
        $updateCard->bank_name = $request->bankName;
        $updateCard->account_no = $request->accountNumber;
        $updateCard->account_name = $request->accoutName;
        $updateCard->type_of_card = $request->typeOfCard;
        $updateCard->save();
        
        return response()->json($updateCard); 
    
    }   

    //
    public function storeCreditCard(Request $request){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //validate
        $this->validate($request, [
        'bankName' =>'required',
        'accountNo'=>'required',
        'accountName'=>'required',
        
         ]);

        $addCreditCard = new DnoPersonalCreditCard([
            'user_id'=>$user->id,
            'bank_name'=>$request->get('bankName'),
            'account_no'=>$request->get('accountNo'),
            'account_name'=>$request->get('accountName'),
            'type_of_card'=>$request->get('typeOfCard'),
            'created_by'=>$name,
        ]);

        $addCreditCard->save();

        Session::flash('cardAdded', 'Successfully added a card.');

        if (\Request::is('dno-personal/credit-card/ald-accounts')) { 
            return redirect('dno-personal/credit-card/ald-accounts');
        }else{
            return redirect('dno-personal/credit-card/mod-accounts');
        }
        
    }

    //
    public function creditCardAccount(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $accountName = "Alan Dino";
        $accountName2 = "MARY MARGARET O. DINO";

        $getCreditCards1 = DnoPersonalCreditCard::where('account_name', $accountName)->get()->toArray();

        $getCreditCards2 = DnoPersonalCreditCard::where('account_name', $accountName2)->get()->toArray();

        return view('dno-personal-credit-card', compact('user', 'getCreditCards1', 'getCreditCards2'));
    }

    //
    public function printPayablesDnoPersonal($id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $payableId = DnoPersonalPaymentVoucher::find($id);

        $payablesVouchers = DnoPersonalPaymentVoucher::where('pv_id', $id)->get()->toArray();

          //count the total amount 
        $countTotalAmount = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount_due');


          //
        $countAmount = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount_due');

        $sum  = $countTotalAmount + $countAmount;
       

        $pdf = PDF::loadView('printPayablesDnoPersonal', compact('payableId', 'user', 'payablesVouchers', 'sum'));

        return $pdf->download('dno-personal-payment-voucher.pdf');
    }


    //
    public function viewPayableDetails($id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        //
        $viewPaymentDetail = DnoPersonalPaymentVoucher::find($id);

        //
        $getViewPaymentDetails = DnoPersonalPaymentVoucher::where('pv_id', $id)->get()->toArray();

        return view('view-dno-personal-payable-details', compact('user', 'viewPaymentDetail', 'getViewPaymentDetails'));
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

                    $payables = DnoPersonalPaymentVoucher::find($id);
                    $payables->status = $status;
                    $payables->delivered_date = $getDate;
                    $payables->created_by = $name; 
                    $payables->save();

                    Session::flash('payablesSuccess', 'FULLY PAID AND RELEASED.');

                    return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);
                    break;
                
                default:
                    # code...
                    return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }

        }else if($status == "FOR APPROVAL"){
            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoPersonalPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                     Session::flash('payablesSuccess', 'Status set for approval.');

                     return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);

                    break;
                
                default:
                    # code...
                    return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
                    break;
            }
        }else{

            switch ($request->get('action')) {
                case 'PAID & HOLD':
                    # code...
                    $payables = DnoPersonalPaymentVoucher::find($id);

                    $payables->status = $status;
                    $payables->save();

                    Session::flash('payablesSuccess', 'Status set for confirmation.');

                    return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);
                    
                    break;
                
                default:
                    # code...
                    return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id)->with('errorPaid', 'STATUS IS INVALID.');
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

        $particulars = DnoPersonalPaymentVoucher::find($id);
       
        if($particulars['category'] == "Cebu Properties"){
            $subCatId = $particulars['sub_category_account_id'];
            $util = "NULL";

        }else if($particulars['category'] == "Manila Properties"){
            $subCatId = $particulars['sub_category_account_id'];
            $util = "NULL";

        } else if($particulars['category'] == "Vehicles"){
            $subCatId = $particulars['utility_sub_category'];

        }else{
            $util = "NULL";
            $subCatId = "NULL";
        }
    
        
        //add current amount
        $add = $particulars['amount_due'] + $request->get('amount');

        $addParticulars = new DnoPersonalPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$particulars['voucher_ref_number'],
            'particulars'=>$request->get('particulars'),
            'sub_category_account_id'=>$subCatId,
            'utility_sub_category'=>$util,
            'amount'=>$request->get('amount'),
            'created_by'=>$name,

        ]);

        $addParticulars->save();
           
        //update 
        $particulars->amount_due = $add;
        $particulars->save();
        
        Session::flash('particularsAdded', 'Particulars added.');

        return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);
    }

    //
    public function addPayment(Request $request, $id){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

         $paymentData = DnoPersonalPaymentVoucher::find($id);

        //save payment cheque num and cheque amount
        $addPayment = new DnoPersonalPaymentVoucher([
            'user_id'=>$user->id,
            'pv_id'=>$id,
            'voucher_ref_number'=>$paymentData['voucher_ref_number'],
            'cheque_number'=>$request->get('chequeNumber'),
            'cheque_amount'=>$request->get('chequeAmount'),
            'created_by'=>$name,

        ]);

         $addPayment->save();

        Session::flash('paymentAdded', 'Payment added.');

         return redirect('dno-personal/edit-dno-personal-payables-detail/'.$id);
    }

    //
    public function editPayablesDetail(Request $request, $id){
          $ids = Auth::user()->id;
        $user = User::find($ids);

        $transactionList = DnoPersonalPaymentVoucher::find($id);

        //
        $getChequeNumbers = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('cheque_number', '!=', NUll)->get()->toArray();

        //getParticular details
        $getParticulars = DnoPersonalPaymentVoucher::where('pv_id', $id)->where('particulars', '!=', NULL)->get()->toArray();
        

        //amount
        $amount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('amount');
        $amount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('amount');
          
        $sum = $amount1 + $amount2;
        
        //
        $chequeAmount1 = DnoPersonalPaymentVoucher::where('id', $id)->sum('cheque_amount');
        $chequeAmount2 = DnoPersonalPaymentVoucher::where('pv_id', $id)->sum('cheque_amount');
        
        $sumCheque = $chequeAmount1 + $chequeAmount2;

         return view('dno-personal-payables-detail', compact('user', 'transactionList', 'getChequeNumbers','sum'
        , 'getParticulars', 'sumCheque'));
    }

    //
    public function transactionList(){
         $ids = Auth::user()->id;
        $user = User::find($ids);

         //
        $getTransactionLists = DnoPersonalPaymentVoucher::where('pv_id', NULL)->orderBy('id', 'desc')->get()->toArray();

           //get total amount due
        $status = "FULLY PAID AND RELEASED";

        $totalAmoutDue = DnoPersonalPaymentVoucher::where('pv_id', NULL)->where('status' ,'!=', $status)->sum('amount_due');
        

        return view('dno-personal-transaction-list', compact('user', 'getTransactionLists', 'totalAmoutDue'));
    }

    //
    public function paymentVoucherStore(Request $request){

        $ids = Auth::user()->id;
        $user = User::find($ids);

        $firstName = $user->first_name;
        $lastName = $user->last_name;

        $name  = $firstName." ".$lastName;

        //get the latest insert id query in table payment voucher ref number
        $dataVoucherRef = DB::select('SELECT id, voucher_ref_number FROM dno_personal_payment_vouchers ORDER BY id DESC LIMIT 1');

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


        //if user select cash or cheque
        if($request->get('paymentMethod') == "Cash"){
            $accountName = $request->get('accountNameCash');
            $paidTo = $request->get('paidToCash');


        }else if($request->get('paymentMethod') == "Cheque"){
            $accountName = $request->get('accountName');
            $paidTo = $request->get('paidToCash');

        }


        if($request->get('category') === "Cebu Properties"){
            
            $subCatExp = explode("-", $request->get('subCatCebu'));
            $subCat = $subCatExp[0];
            $subCatName = $subCatExp[1];

            //
            $bills = $request->get('otherBills');
            $selectAccountID = $request->get('selectAccountID');
          
           
        }elseif($request->get('category') === "Manila Properties"){
            $subCatExp = explode("-", $request->get('subCatManila'));
            $subCat = $subCatExp[0];
            $subCatName = $subCatExp[1];

            $bills = $request->get('otherBills');
            $selectAccountID = $request->get('selectAccountID');
           
        
        }elseif($request->get('category') === "Vehicles"){

            $subCatExp = explode("-",$request->get('subCatUtility'));
            $subCat = $subCatExp[0];
            $subCatName = $subCatExp[1];

            $selectAccountID = "NULL";
          
        }else{
            $subCat = "NULL";
            $subCatName = "NULL";
            $bills = "NULL";
        }

    
        //check if invoice number already exists
        $target = DB::table(
                        'dno_personal_payment_vouchers')
                        ->where('invoice_number', $request->get('invoiceNumber'))
                        ->get()->first();

        if ($target === NULL) {
            # code...
              $addPaymentVoucher = new DnoPersonalPaymentVoucher([
                    'user_id'=>$user->id,
                    'paid_to'=>$paidTo,
                    'bank_card'=>$request->get('bankName'),
                    'invoice_number'=>$request->get('invoiceNumber'),
                    'account_no'=>$request->get('accountNo'),
                    'account_name'=>$accountName,
                    'type_of_card'=>$request->get('typeOfCard'),
                    'voucher_ref_number'=>$uVoucher,
                    'issued_date'=>$request->get('issuedDate'),     
                    'amount'=>$request->get('amount'),
                    'amount_due'=>$request->get('amount'),
                    'particulars'=>$request->get('particulars'),
                    'method_of_payment'=>$request->get('paymentMethod'),
                    'category'=>$request->get('category'),
                    'sub_category'=>$subCat,
                    'sub_category_name'=>$subCatName,
                    'sub_category_bill_name'=>$bills,
                    'sub_category_account_id'=>$selectAccountID,
                    'utility_sub_category'=>$request->get('documentList'),
                    'prepared_by'=>$name,
                    'created_by'=>$name,
            ]);

            $addPaymentVoucher->save();
            $insertedId = $addPaymentVoucher->id;

            return redirect('dno-personal/edit-dno-personal-payables-detail/'.$insertedId);
        }else{
             return redirect('dno-personal/payment-voucher-form/')->with('error', 'Invoice Number Already Exists. Please See Transaction List For Your Reference');
        }

    }

    //do ajax call
    public function getCebuProp($id){ 
        $getProp = DnoPersonalProperty::where('pp_id', $id)->get()->toArray();

        return response()->json($getProp);
    }

    // do ajax call
    public function getData($id){
        $getDocuments = DnoPersonalUtility::where('pu_id', $id)->get()->toArray();

        return response()->json($getDocuments); 

    }
    
     //
    public function paymentVoucherForm(){
        $ids = Auth::user()->id;
        $user = User::find($ids);

        //getCreditCards
        $getCreditCards = DnoPersonalCreditCard::get()->toArray();

        //getproperties
        $flag = "Cebu Properties";
        $flagM = "Manila Properties";

        $getCebuProperties = DnoPersonalProperty::where('flag', $flag)->get()->toArray();

        $getManilaProperties = DnoPersonalProperty::where('flag', $flagM)->get()->toArray();

        //getUtilities
        $getUtilities = DnoPersonalUtility::where('pu_id', NULL)->get()->toArray();

        //get all flag expect cebu and manila properties
        $getAllFlags = DnoPersonalProperty::where('flag', '!=', $flag)->where('flag', '!=', $flagM)->get()->toArray();
       

        return view('payment-voucher-form-dno-personal', compact('user', 'getCreditCards', 
        'getCebuProperties', 'getManilaProperties', 'getUtilities', 'getAllFlags'));
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

        $catName = "ALD Accounts";

        $catNameMOD = "MOD Accounts";

        $payment ="Cash";

        //getTransaction
        $getTransactions = DnoPersonalPaymentVoucher::where('account_no', NULL)->where('category', $catName)
        ->where('method_of_payment', $payment)->get()->toArray();
        
        //getTransaction
        $getModTransactions = DnoPersonalPaymentVoucher::where('account_no', NULL)->where('category', $catNameMOD)
        ->where('method_of_payment', $payment)->get()->toArray();
       

         //get total amount due
         $status = "FULLY PAID AND RELEASED";

         $totalAmountDue = DnoPersonalPaymentVoucher::where('account_no',  NULl)->where('category', $catName)
         ->where('status' ,'!=', $status)->sum('amount_due');

         $totalAmountDueMod = DnoPersonalPaymentVoucher::where('account_no',  NULl)->where('category', $catNameMOD)
         ->where('status' ,'!=', $status)->sum('amount_due');

        return view('dno-personal', compact('user', 'getTransactions', 'totalAmountDue', 'getModTransactions', 'totalAmountDueMod'));
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

    //
    public function destroyProperty($id){
        $property = DnoPersonalProperty::find($id);
        $property->delete();
    }

    //  
    public function destroyVehicles($id){
        $vehicle = DnoPersonalUtility::find($id);
        $vehicle->delete();
    }

    //
    public function destroyCreditCard($id){
        $creditCard = DnoPersonalCreditCard::find($id);
        $creditCard->delete();
    }

    public function destroyTransactionList($id){
        $transactionList = DnoPersonalPaymentVoucher::find($id);
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
    }
}
