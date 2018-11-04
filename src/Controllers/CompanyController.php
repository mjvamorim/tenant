<?php

namespace Amorim\Tenant\Controllers;

use Amorim\Tenant\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Validator;
use Response;
use DataTables;


class CompanyController extends Controller
{   

    function index()
    {
        $showables  = Company::getShowableFields();
        $model = 'company';
        return view('tenant::model',compact('showables','model'));
    }

    function getData()
    {
        $companies = Company::all();
        return DataTables::of($companies)
            ->addColumn('action', function($company){
                $btedit = '<button class="btn edit" id="'.$company->id.'" title="Alterar" data-toggle="tooltip" ><i class="glyphicon glyphicon-edit"></i> </button>';
                $btdelt = '<button class="btn delt" id="'.$company->id.'" title="Apagar" data-toggle="tooltip" ><i class="glyphicon glyphicon-trash"></i> </button>';
                $btslct = '<button class="btn slct" id="'.$company->id.'" title="Escolher" data-toggle="tooltip" ><i class="glyphicon glyphicon-folder-open"></i> </button>';
                return '<div align="center">'.$btedit.'<span> </span>'.$btdelt.'<span> </span>'.$btslct.'</div>';
            })
            ->make(true);
    }

    function fetchData(Request $request,Company $company )
    {
        $id = $request->input('id');
        $company = Company::find($id);
        echo json_encode($company);
    }


    function postData(Request $request)
    {
        if($request->get('button_action') == 'delete')
        {
            $id = $request->input('id');

            $deleted = Company::destroy($id);
            if ($deleted) {
                $error_array = [];
                $success_output = '<div class="alert alert-success">Data Deleted</div>';
            } else {
                $success_output = '<div class="alert alert-danger">Data Deleted</div>';
                $error_array = [];
            }

        }
        else {

            $rules = Company::getRules();
            $validation = Validator::make($request->all(), Company::getRules());      
            $error_array = array();
            $success_output = '';
            if ($validation->fails())
            {
                foreach ($validation->messages()->getMessages() as $field_name => $messages)
                {
                    $error_array[] = $messages; 
                }
            }
            else
            {
                if($request->get('button_action') == 'insert')
                {
                    $company = new Company;
                    $input =  $request->only($company->fillable);
                    $company->fill($input);
                    $company->save();
                    $success_output = '<div class="alert alert-success">Data Inserted</div>';
                }

                if($request->get('button_action') == 'update')
                {
                    $company = Company::find($request->get('id'));
                    $input =  $request->only($company->fillable);
                    $company->fill($input);
                    $company->save();
                    $success_output = '<div class="alert alert-success">Data Updated</div>';
                }
            }
        }
            
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output,
            'eu'        => 'Mauricio Amorim',
        );
        echo json_encode($output);
    }
}

