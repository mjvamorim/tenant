<?php

namespace Amorim\Tenant\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Amorim\Tenant\Models\Company;
use Amorim\Tenant\TenantConfigDB;
use Amorim\Tenant\TenantConnector;


class TenantController extends Controller
{
    use TenantConnector;
    protected  $company;
    public function __construct()
    {
        $this->company = Company::findOrFail(1);
        // $this->company = new Company;
        // $this->company->id=1;
        // $this->company->db_host = 'localhost';
        // $this->company->db_database = 'clinic1';
        // $this->company->db_user = 'root';
        // $this->company->db_password = 'root';

    }
    /**
     * @GET
     * @param Request $request
     * @param $company
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function select(Request $request,  Company $company) {

        TenantConfigDB::createDatabase($company);
        $this->reconnect($this->company->findOrFail($company->id)); 
        $request->session()->put('tenant', $company);
        TenantConfigDB::createTenantTables();
        $output = array(
            'tenant'     =>  $company,
        );
        echo json_encode($output);
    }
    public function selectTenant(Request $request, Company $company) {
        TenantConfigDB::createDatabase($company);
        $this->reconnect($this->company->findOrFail($company->id)); 
        $request->session()->put('tenant', $company);
        TenantConfigDB::createTenantTables();
    }
}