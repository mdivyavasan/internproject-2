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

class DepartmentController extends BaseController
{
    public function managedepartment()
    {
        $managedept = DB::table('sjr_departments')->get();
        return view('managedepartment')->with("managelist",$managedept);
    }

    public function managesubdivisiondepartment()
    {
        $managedept = DB::table('sjr_departsubdivisions')->get();
        return view('managesubdiviondepartment')->with("managelist",$managedept);
    }
    public function subdivisionmapping($id)
    {
        $objsubdata = new stdClass();
        if($id == 0){
            $objsubdata->id = '';
            $objsubdata->subdivision_name = '';
        }
        else{
            $subdivdata = DB::table('sjr_departsubdivisions')->where('id', $id)->first();
            $objsubdata->subdivision_name = $subdivdata->subdivision_name;
            $objsubdata->id = $subdivdata->id;

        }
        $managedept = DB::table('sjr_departments')->get();
        $subdivmap = DB::table('sjr_departsubdivisions')->where('id','<>',$id)->get();

        //edpatmentloogp

        foreach($managedept as $procat){
            $gcatgory =  DB::table('sju_dept_submappings')->where("dept_id",$procat->id)->where("sub_id",$id)->where("parent_subdivision",0)->first();
            $procat->assigned = ($gcatgory) ? $gcatgory->dept_id : '';
        }

        //subdivaloop
       /* foreach($subdivmap as $subdiv){
            $subdivmap =  DB::table('sju_dept_submappings')->where("dept_id",$subdiv->id)->where("sub_id",$id)->where("parent_subdivision",0)->first();
            $subdiv->subdivmapping = ($subdivmap) ? $subdivmap->sub_id : '';
        }
*/

        return view('subdivisionmapping')->with("managelist",$managedept)->with("managesublist",$subdivmap)->with("subdivdata",$objsubdata);
    }
    public function createdeaprtmentname(Request $request)
    {

        try {

              $data=$request->all();

              // to get all request params
               $input = [
			    'deptid' => isset($data['deptid']) ? $data['deptid'] : 0,
				'department_name' => isset($data['department_name']) ? $data['department_name'] : '',
                'depart_desc' => isset($data['depart_desc']) ? $data['depart_desc'] : '',

				];

				$deid = $input['deptid'];

				$insertdata = [
						'department_name' => $input['department_name'],
						'depart_desc' => $input['depart_desc'],
					];

				if($deid !== "" && $deid  == 0){
					  $arrdata = DB::table('sjr_departments')->insertGetId($insertdata);
				}else{
					 $arrdata = DB::table('sjr_departments')->where('id',$deid)->update($insertdata);
				}

                return redirect("managedepartment");

        }catch(Exception $e){

        }

    }
    public function createdeaprtmentsubdiv(Request $request)
    {

        try {

            $data=$request->all();
              // to get all request params
               $input = [
				'subdivision_name' => isset($data['subdivision_name']) ? $data['subdivision_name'] : '',
                'subdivision_desc' => isset($data['subdivision_desc']) ? $data['subdivision_desc'] : '',
                'subid' => isset($data['subid']) ? $data['subid'] : '0',
				];
                //prepare array to insert
                $insertdata = [
                    'subdivision_name' => $input['subdivision_name'],
                    'subdivision_desc' => $input['subdivision_desc'],

                ];

                $deid = $input['subid'];

                if($deid !== "" && $deid  == 0){
                //insert rrecord to db
                $arrdata = DB::table('sjr_departsubdivisions')->insertGetId($insertdata);
            }else{
                $arrdata = DB::table('sjr_departsubdivisions')->where('id',$deid)->update($insertdata);
           }
                return redirect("managesubdiviondepartment");

        }catch(Exception $e){

        }

    }

	public function fndeletedpartment($id)
    {

        try {
            if(Auth::check()){
            if(Auth::user()->user_role =='admin' || Auth::user()->user_role =='superadmin'){
				$delrecrod = DB::table('sjr_departments')->where('id', $id)->delete();
				return redirect("managedepartment");
			}else{
				return redirect("/");
			}
            return redirect("login");

        }
    }
    catch(Exception $e){
				return redirect("/");
        }

    }


	public function fndeletesubdiv($id)
    {

        try {

            if(Auth::check()){
            if(Auth::user()->user_role =='admin' || Auth::user()->user_role =='superadmin'){
				$delrecrod = DB::table('sjr_departsubdivisions')->where('id', $id)->delete();
				return redirect("managesubdiviondepartment");
			}else{
				return redirect("/");
			}
            return redirect("login");
        }

        }catch(Exception $e){
				return redirect("/");
        }

    }


public function assignsubdiv(Request $request)
{
	$returnRes = [];
	$arrReturn = [];
    try
	{
		$data=$request->all();
			$input = [
				'dept_id' => isset($data['dept_id']) ? $data['dept_id'] : 0,
				'sub_id' => isset($data['sub_id']) ? $data['sub_id'] : 0,
			    'assignstatus' => isset($data['assignstatus']) ? $data['assignstatus'] : '',
			    'parent_subdivision' => isset($data['parent_subdivision']) ? $data['parent_subdivision'] : 0,
			];
			$rules = array(
				'dept_id' => 'required',
			);
				$checkValid = Validator::make($input,$rules);
			if ($checkValid->fails()){
				$arrErr = $checkValid->errors()->all();
				$arrReturn['status'] = 'failed';
				$arrReturn['message'] = $arrErr;
			}
			else{
				$arrinsert = [
				"dept_id" =>  $input['dept_id'],
				"sub_id" =>  $input['sub_id'],
                "parent_subdivision" => $input['parent_subdivision'],
				];
    		$assignstatus = $input['assignstatus'];
			if($assignstatus != 0){
                $arrPdata = DB::table('sju_dept_submappings')->where('sub_id', $input['sub_id'])->where('dept_id', $input['dept_id'])->where('parent_subdivision', $input['parent_subdivision'])->first();
	    		if(!$arrPdata){
                    $cart_item_id = DB::table('sju_dept_submappings')->insertGetId($arrinsert);
                }
					$arrReturn['message'] = 'record inserted successfully';
                }
				else{
                    $arrPdata = DB::table('sju_dept_submappings')->where('sub_id', $input['sub_id'])->where('dept_id', $input['dept_id'])->where('parent_subdivision', $input['parent_subdivision'])->first();
					if($arrPdata){
		            $cart_item_id = DB::table('sju_dept_submappings')->where('sub_id', $input['sub_id'])->where('dept_id', $input['dept_id'])->where('parent_subdivision', $input['parent_subdivision'])->delete();
                    $arrReturn['message'] = 'record deleted successfully';
                    }else{
                        $arrReturn['message'] = '';
                    }
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



}




