<?php

namespace Amorim\Tenant\Middleware;

use Amorim\Tenant\Models\Company;
use Amorim\Tenant\TenantConnector;
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
        $this->company = $company;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
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
