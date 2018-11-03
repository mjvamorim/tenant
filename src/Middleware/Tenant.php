<?php

namespace Amorim\Tenant\Middleware;

use Amorim\Tenant\Models\Company;
use Amorim\Tenant\TenantConnector;

use Amorim\Tenant\TenantConfigDB;
use Illuminate\Http\Request;
use Closure;

class Tenant {

    use TenantConnector;

    /**
     * @var Company
     */
    protected $company;

    /**
     * Tenant constructor.
     * @param Company $company
     */
    public function __construct(Company $company) {
        //$this->company = Company::findOrFail(1);
        $this->company = $company;
    }

    public function selectTenant(Request $request, Company $company) {
        TenantConfigDB::createDatabase($company);
        $this->reconnect($this->company->findOrFail($company->id)); 
        $request->session()->put('tenant', $company);
        TenantConfigDB::createTenantTables();
    }
    public function createCompanyAuthUser() { 
        $user = auth()->user();
        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
        ];
        $company = TenantConfigDB::createCompany($data);
        $user->company_id = $company->id;
        $user->save();
    }

    public function handle(Request $request, Closure $next) {
        //Novo
        if (auth()->check()) {
            if (auth()->user()->company == null) {
                $this->createCompanyAuthUser();
            }
            $this->selectTenant($request, auth()->user()->company);
        }

        if (($request->session()->get('tenant')) === null)
            return redirect()->route('home')->withErrors(['error' => __('Please select a customer/tenant before making this request.')]);
        // Get the company object with the id stored in session
        $company = $this->company->find($request->session()->get('tenant')->id);
      

        // Connect and place the $company object in the view
        $this->reconnect($company);
        $request->session()->put('company', $company);
        $request->session()->put('tenant', $company);
          
        return $next($request);
    }
}
