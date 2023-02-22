<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Hash;
use Session;
use App\Models\User;
use DB;
use \stdClass;


class ProductController extends BaseController
{

    public function managecategory()
    {
        $managecategory = DB::table('sjr_productcategory')->get();
        return view('managecategory')->with("manageprolist",$managecategory);
    }

    public function createcategory(Request $request)
    {

        try {

              $data=$request->all();

              // to get all request params
               $input = [
			    'deptid' => isset($data['deptid']) ? $data['deptid'] : 0,
				'category_name' => isset($data['category_name']) ? $data['category_name'] : '',
                'category_desc' => isset($data['category_desc']) ? $data['category_desc'] : '',

				];

                $rules = array(
                    'category_name'    => 'required',

            );

				$deptid = $input['deptid'];

				$insertdata = [
						'category_name' => $input['category_name'],
						'category_desc' => $input['category_desc'],
					];

                    if($deptid !== "" && $deptid  == 0){
				      $arrdata = DB::table('sjr_productcategory')->insertGetId($insertdata);
                    }else{
                        $arrdata = DB::table('sjr_productcategory')->where('id',$deptid)->update($insertdata);
                   }
				      return redirect("managecategory");


    }
    catch(Exception $e){

        }

    }

    public function fndeleteproduct($id)
    {

        try {

            if(Auth::user()->user_role =='admin' || Auth::user()->user_role =='superadmin'){
				$delrecrod = DB::table('sjr_productcategory')->where('id', $id)->delete();
				return redirect("managecategory");
			}else{
				return redirect("/");
			}


        }catch(Exception $e){
				return redirect("/");
        }

    }



public function manageproduct(){


   $manageprodt = DB::table('sjr_productcategory')->get();
   $managecategory = DB::table('sjr_products')->get();


   foreach($managecategory as $procat){
        $gcatgory =  DB::table('sjr_productcategory')->where("id",$procat->category_id)->first();
        $procat->catname = ($gcatgory) ? $gcatgory->category_name : '';

		$proimages = DB::select("SELECT p.*,m.media_url FROM sjr_productimages p, web_media m WHERE p.media_id = m.id AND p.product_id = '".$procat->id."'");
		$primaryimage = '';
		if($proimages){
				foreach($proimages as $pimg){
						if($pimg->primary_flag == 1){
							$primaryimage = $pimg->media_url ;
						}else{
							$arrimages[] = $pimg;
						}
				}

				if($primaryimage == ""){
					$primaryimage = $arrimages[0]->media_url ;
				}
		}

		$procat->primaryimage = $primaryimage;

   }
	Session::put('patab', 'productinfo');
	return view('manageproduct')->with("manageprolist",$managecategory)->with("manageprodulist",$manageprodt);
    }


 public function addnewproducts($id){
        $managecategory = DB::table('sjr_productcategory')->get();
        return view('addnewproducts')->with("manageprolist",$managecategory);
}

public function categoryspecification($id){

    $getcategorydata =  DB::table('sjr_productcategory')->where("id",$id)->first();
    $managecategoryspecifi = DB::table('sjr_categoryspecifications')->where("category_id",$id)->get();
    return view("categoryspecification")->with("cid",$id)->with("managespecilist",$managecategoryspecifi)->with("catdata",$getcategorydata);

}

public function createcategoryspecific(Request $request)
{

    try {

          $data=$request->all();

          // to get all request params
           $input = [
            'deptid' => isset($data['deptid']) ? $data['deptid'] : 0,
            'spec_name' => isset($data['spec_name']) ? $data['spec_name'] : '',
            'spec_type' => isset($data['spec_type']) ? $data['spec_type'] : '',
            'spec_dvalue' => isset($data['spec_type']) ? $data['spec_dvalue'] : '',

            'category_id' => isset($data['category_id']) ? $data['category_id'] : '',
            ];
            $rules = array(
                'spec_name'    => 'required'
        );

            $deptid = $input['deptid'];
            $catid =  $input['category_id'];

            $insertdata = [
                    'spec_name' => $input['spec_name'],
                    'spec_type' => $input['spec_type'],
                    'spec_dvalue' => $input['spec_dvalue'],

                    'category_id' => $input['category_id'],
                ];

                if($deptid !== "" && $deptid  == 0){
                  $arrdata = DB::table('sjr_categoryspecifications')->insertGetId($insertdata);
                }else{
                    $arrdata = DB::table('sjr_categoryspecifications')->where('id',$deptid)->update($insertdata);
               }
                  return redirect("categoryspecification/". $catid );

}
catch(Exception $e){

    }

}

public function deletecategory($id)
{

    try {

        if(Auth::user()->user_role =='admin'){

            $getdeldata = DB::table('sjr_categoryspecifications')->where("id",$id)->first();
            $catid = $getdeldata->category_id;
            $delrecrod = DB::table('sjr_categoryspecifications')->where('id', $id)->delete();
            return redirect("categoryspecification/".$catid);
        }else{
            return redirect("/");
        }


    }catch(Exception $e){
            return redirect("/");
    }

}



public function addnewproduct(Request $request)
    {

        try {

              $data=$request->all();

              // to get all request params
               $input = [
			    'deptid' => isset($data['deptid']) ? $data['deptid'] : 0,
				'category_id' => isset($data['category_id']) ? $data['category_id'] :'' ,
                'product_skuid' => isset($data['product_skuid']) ? $data['product_skuid'] : '',
				'product_name' => isset($data['product_name']) ? $data['product_name'] : '',
				'product_desc' => isset($data['product_desc']) ? $data['product_desc'] : '',

				];

				$deptid = $input['deptid'];
				$cateid = $input['category_id'];
				$catspeupdateflag = 0;
				$productid = $deptid;

				$insertdata = [
						'category_id' => $cateid ,
						'product_skuid' => $input['product_skuid'],
						'product_name' => $input['product_name'],
						'product_desc' => $input['product_desc'],

					];

					if($deptid !== "" && $deptid  == 0){
							 $pid = DB::table('sjr_products')->insertGetId($insertdata);
							 $productid = $pid;
							 $catspeupdateflag = 1;
					}else{
							$productid = $deptid;

							$geprodata = DB::table('sjr_products')->where('id', $productid )->first();
							$oldcateid = $geprodata->category_id;
							$arrdata = DB::table('sjr_products')->where('id',$deptid)->update($insertdata);

							if($oldcateid != $cateid){
								$catspeupdateflag = 1;
							}
					}



						//insert product specifications


					    if($catspeupdateflag == 1){

							$insprospec = '';
							 $getspecications = DB::table('sjr_categoryspecifications')->where('category_id', $cateid )->get();
							 if($getspecications){

								 foreach($getspecications as $spec){
									 $spec->pdefaultvalue = "";
								 }

								 $insprospec = json_encode($getspecications);
							 }


							 $insertspemaping = [
								'product_id' => $productid ,
								'category_id' =>  $cateid,
								'product_specifications' => $insprospec,
							 ];

							$getprocspec = DB::table('sjr_productspecifications')->where('product_id', $productid )->first();

							if($getprocspec){
								$cid = DB::table('sjr_productspecifications')->where('id', $getprocspec->id)->update($insertspemaping);
							}else{
								$cid = DB::table('sjr_productspecifications')->insertGetId($insertspemaping);
							}

						}


				Session::put('patab', 'productinfo');
                return redirect("editproduct/".$productid)->with("patab","productinfo");

        }catch(Exception $e){

        }

    }
    public function deleteproductmanagaement($id)
    {
        try {

            if(Auth::check()){
                if(Auth::user()->user_role =='admin' || Auth::user()->user_role =='superadmin'){
				$delrecrod = DB::table('sjr_products')->where('id', $id)->delete();
                $delrecrod = DB::table('sjr_productspecifications')->where('product_id', $id)->delete();
				return redirect("manageproduct");
			}
            else{
				return redirect("/");
			}
            return redirect("login");
        }
        }catch(Exception $e){
				return redirect("/");
        }
    }


public function productspecification($id){


    $objsubdata = new stdClass();
    if($id == 0){

        $objsubdata->product_name = '';
        $objsubdata->id = '';
    }
    else{
        $subdivdata = DB::table('sjr_products')->where('id', $id)->first();
        $objsubdata->product_name = $subdivdata->product_name;
        $objsubdata->id =  $id;

    }


    $managedept = DB::table('sjr_departments')->get();
    $subdivmap = DB::table('sjr_products')->where('id', '<>',$id)->get();
    $managecategoryspecifi = DB::table('sjr_productspecifications')->where("product_id",$id)->first();

	if($managecategoryspecifi){
		$managecategoryspecifi->arrspec = json_decode($managecategoryspecifi->product_specifications);
	}

	return view("productspecification")->with("managelist",$managedept)->with("managesublist",$subdivmap)->with("subdivdata",$objsubdata)->with("managespecilist",$managecategoryspecifi);
}

public function addproductspecval(Request $request)
{

    try {

          $data=$request->all();

          // to get all request params
           $input = [
            'productid' => isset($data['productid']) ? $data['productid'] : 0,
            'spec_name' => isset($data['spec_name']) ? $data['spec_name'] : '',
            'spec_type' => isset($data['spec_type']) ? $data['spec_type'] : '',
            'spec_dvalue' => isset($data['spec_dvalue']) ? $data['spec_dvalue'] : '',
            ];


            $prid = $input['productid'];
            $managecategoryspecifi = DB::table('sjr_productspecifications')->where("product_id",$prid)->first();

            if($managecategoryspecifi){

                $specdata = json_decode($managecategoryspecifi->product_specifications);

                $apparary = new stdClass();
                $apparary->id = 0;
                $apparary->category_id =  $managecategoryspecifi->category_id;
                $apparary->spec_name =  $input['spec_name'];
                $apparary->spec_type = $input['spec_type'];
                $apparary->spec_dvalue = $input['spec_dvalue'];
                $apparary->spec_configvalues = '';
                $apparary->spec_defaultflag = '';
				$apparary->pdefaultvalue = '';
				array_push($specdata,$apparary);

                $insertspemaping = [
                    'product_specifications' => json_encode($specdata),
                 ];

                 $cid = DB::table('sjr_productspecifications')->where('id', $managecategoryspecifi->id)->update($insertspemaping);
                 //return redirect("productspecification/".$prid);
				 
				 Session::put('patab', 'produsspec');
				
				 return redirect("editproduct/".$prid);

            }else{

				$geprodata = DB::table('sjr_products')->where('id', $prid )->first();

				$apparary = new stdClass();
                $apparary->id = 0;
                $apparary->category_id =  $geprodata->category_id;
                $apparary->spec_name =  $input['spec_name'];
                $apparary->spec_type = $input['spec_type'];
                $apparary->spec_dvalue = $input['spec_dvalue'];
                $apparary->spec_configvalues = '';
                $apparary->spec_defaultflag = '';
				$apparary->pdefaultvalue = '';

				$arrmapping = [];
				$arrmapping[] = $apparary;

				$insertspemaping = [
								'product_id' => $prid ,
								'category_id' =>  $geprodata->category_id,
								'product_specifications' => json_encode($arrmapping),
							 ];

				$getprocspec = DB::table('sjr_productspecifications')->where('product_id', $prid )->first();
				$cid = DB::table('sjr_productspecifications')->insertGetId($insertspemaping);
				
				Session::put('patab', 'produsspec');
				
				return redirect("editproduct/".$prid);
			}
    }
    catch(Exception $e){

        }

}
// public function deleteproductspecval($id){





// }

public function fndelprodspecification(Request $request)
{
	$returnRes = [];
	$arrReturn = [];
    try
	{
		$data=$request->all();
			$input = [
				'productid' => isset($data['productid']) ? $data['productid'] : '',
				'spindex' => isset($data['spindex']) ? $data['spindex'] : '',
			];
			$rules = array(
				'productid' => 'required',
				'spindex' => 'required',
			);
				$checkValid = Validator::make($input,$rules);
			if ($checkValid->fails()){
				$arrErr = $checkValid->errors()->all();
				$arrReturn['status'] = 'failed';
				$arrReturn['message'] = $arrErr;
			}
			else{

				$procid = $input['productid'];
				$delindex = $input['spindex'];
				$procspecfi = DB::table('sjr_productspecifications')->where("product_id",$procid)->first();

                    //decoding array from the table

				if($procspecfi){
					$specdata  = json_decode($procspecfi->product_specifications);
					$delindex2 = $delindex -1;

					//remove items from array
					array_splice($specdata,$delindex2,1);

					//update dta
					$insertspemaping = [
                    'product_specifications' => json_encode($specdata),
                    ];

                    $cid = DB::table('sjr_productspecifications')->where('id', $procspecfi->id)->update($insertspemaping);

				}
				
				$arrReturn['status'] = "success";
				$arrReturn['orivakye'] = Session::get('patab');
        	}
		}
		catch(\Exception $e){
			    $msg= $e->getMessage();
				$arrReturn['status'] = 'failed';
				$arrReturn['message'] = $msg;
		}
			Session::put('patab', 'produsspec');
			
			$returnRes=json_encode($arrReturn);
			return $returnRes;
	}




    public function getspecificationvalue(Request $request)
    {
        $returnRes = [];
        $arrReturn = [];
        try
        {
            $data=$request->all();
                $input = [
                    'id' => isset($data['id']) ? $data['id'] : 0,
                    'productid' => isset($data['productid']) ? $data['productid'] : '',
                    'spindex' => isset($data['spindex']) ? $data['spindex'] : '',
                    'specvalue' => isset($data['specvalue']) ? $data['specvalue'] : '',

                ];
                $rules = array(
                    'id' => 'required',
                    'productid' => 'required',
                    'spindex' => 'required',
                );
                    $checkValid = Validator::make($input,$rules);
                if ($checkValid->fails()){
                    $arrErr = $checkValid->errors()->all();
                    $arrReturn['status'] = 'failed';
                    $arrReturn['message'] = $arrErr;
                }
                else{
                    $arrinsert = [
                    $procid = $input['productid'],
                    $selindex = $input['spindex'],
                    $specval = $input['specvalue'],
                    ];
      $procspecfi = DB::table('sjr_productspecifications')->where("product_id",$procid)->first();
				if($procspecfi){

                    $sdelindex = $selindex -1;
					$specdata  = json_decode($procspecfi->product_specifications);
                    $specdata[$sdelindex]->pdefaultvalue = $specval;

                    //update dta
					$insertspemaping = [
                        'product_specifications' => json_encode($specdata),
                        ];

                        $cid = DB::table('sjr_productspecifications')->where('id', $procspecfi->id)->update($insertspemaping);

                }

                $arrReturn['status'] = "success";

            }

        }
            catch(\Exception $e){
                    $msg= $e->getMessage();
                    $arrReturn['status'] = 'failed';
                    $arrReturn['message'] = $msg;
            }
                $returnRes=json_encode($arrReturn);
                return $returnRes;
        }



		public function fnviewproductimages($id){


			if(Auth::check()){

				$urole = Auth::user()->user_role;
				if($urole == "superadmin" || $urole == "admin"){

					$objsubdata = new stdClass();
					$proimages = [];
					if($id == 0){

						$objsubdata->product_name = '';
						$objsubdata->id = '';
					}
					else{
						$subdivdata = DB::table('sjr_products')->where('id', $id)->first();
						$objsubdata->product_name = $subdivdata->product_name;
						$objsubdata->id =  $id;
						$proimages = DB::select("SELECT p.*,m.media_url FROM sjr_productimages p, web_media m WHERE p.media_id = m.id AND p.product_id = '".$id."'");

					}

					return view("productimages")->with("subdivdata",$objsubdata)->with("proimglist",$proimages);

				}

			}

			return redirect("login");


		}


	public function fndelprocimage(Request $request)
	{
		$returnRes = [];
		$arrReturn = [];
		try
		{
			 $data=$request->all();
				$input = [
					'product_id' => isset($data['product_id']) ? $data['product_id'] : '',
					'media_id' => isset($data['media_id']) ? $data['media_id'] : '',
				];
				$rules = array(
					'product_id' => 'required',
					'media_id' => 'required',
				);
				$checkValid = Validator::make($input,$rules);
				if ($checkValid->fails()){

					$arrErr = $checkValid->errors()->all();
					$arrReturn['status'] = 'failed';
					$arrReturn['message'] = $arrErr;
				}
				else{

					$pid = $input['product_id'];
					$mid = $input['media_id'];
					$delrecrod = DB::table('sjr_productimages')->where('media_id', $mid)->where('product_id', $pid)->delete();
					$arrReturn['status'] = "success";
				}
			}
			catch(\Exception $e){
					$msg= $e->getMessage();
					$arrReturn['status'] = 'failed';
					$arrReturn['message'] = $msg;
			}
				Session::put('patab', 'prodimg');
				$returnRes=json_encode($arrReturn);
				return $returnRes;
	}


	public function fnupprocimagprimary(Request $request)
	{
		$returnRes = [];
		$arrReturn = [];
		try
		{
			 $data=$request->all();
				$input = [
					'recupid' => isset($data['recupid']) ? $data['recupid'] : '',
					'primary_flag' => isset($data['primary_flag']) ? $data['primary_flag'] : '',
				];
				$rules = array(
					'recupid' => 'required',
				);
				$checkValid = Validator::make($input,$rules);
				if ($checkValid->fails()){

					$arrErr = $checkValid->errors()->all();
					$arrReturn['status'] = 'failed';
					$arrReturn['message'] = $arrErr;
				}
				else{

					 $rid = $input['recupid'];
					  $updaterecdata = [
                        'primary_flag' => $input['primary_flag'],
                        ];
					  $cid = DB::table('sjr_productimages')->where('id', $rid)->update($updaterecdata);
					  $arrReturn['status'] = "success";
				}
			}
			catch(\Exception $e){
					$msg= $e->getMessage();
					$arrReturn['status'] = 'failed';
					$arrReturn['message'] = $msg;
			}
				$returnRes=json_encode($arrReturn);
				return $returnRes;
	}



	public function fngetproductid(Request $request)
	{
		$returnRes = [];
		$arrReturn = [];
		$arrSdata = [];
		try
		{
			$data=$request->all();
				$input = [
					'category_id' => isset($data['category_id']) ? $data['category_id'] :' ',
					'product_skuid' => isset($data['product_skuid']) ? $data['product_skuid'] :' ',
				];
				$rules = array(
					//'product_skuid' => 'required',
					'category_id'=>  'required',
				);
				$checkValid = Validator::make($input,$rules);
				if ($checkValid->fails()){
					$arrErr = $checkValid->errors()->all();
					$arrReturn['status'] = 'failed';
					$arrReturn['message'] = $arrErr;
				}
				else{
					$category_id =  $input['category_id'];
			    $productdata = DB::table('sjr_products')->where('category_id', $category_id)->first();
				$product_skuid =  $input['product_skuid'];
					if($category_id == 'all'){
						$arrSdata = DB::select("SELECT * FROM sjr_products");
					}
					else{
						$arrSdata = DB::select("SELECT * FROM sjr_products WHERE category_id = '".$category_id."'");
					}
				$arrReturn['status'] = "success";
				$arrReturn['sdata'] = $productdata;
				$arrReturn['sdata'] = $arrSdata;
				$arrReturn['message'] = "record get successfully";
					}
		}
			catch(\Exception $e){
				$msg= $e->getMessage();
				$arrReturn['status'] = 'failed';
				$arrReturn['message'] = $msg;
			}
			$returnRes=json_encode($arrReturn);
			return $returnRes;
	}
    public function editproduct($id){
		
		
		
		if(Auth::check()){

				$urole = Auth::user()->user_role;
				if($urole == "superadmin" || $urole == "admin"){				
					
					$acttab = Session::get('patab');
		
					$productdata = DB::table('sjr_products')->where('id', $id)->first();
					$proimages = DB::select("SELECT p.*,m.media_url FROM sjr_productimages p, web_media m WHERE p.media_id = m.id AND p.product_id = '".$id."'");
					
					$managecategory = DB::table('sjr_productcategory')->get();
					$subdivmap = DB::table('sjr_products')->where('id', '<>',$id)->get();
					$managecategoryspecifi = DB::table('sjr_productspecifications')->where("product_id",$id)->first();

					if($managecategoryspecifi){
						$managecategoryspecifi->arrspec = json_decode($managecategoryspecifi->product_specifications);
					}
					
					return view("editproduct")
								->with("proimglist",$proimages)
								->with("patab",$acttab)
								->with("manageprolist",$managecategory)
								->with("proddata",$productdata)
								->with("managespecilist",$managecategoryspecifi);

				}

			}
		
		return redirect("login");      
		
		
    }
}


