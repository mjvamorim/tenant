<?php

namespace Amorim\Tenant;


use Amorim\Tenant\Models\Company;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


trait TenantConnector {
   
   /**
    * Switch the Tenant connection to a different company.
    * @param Company $company
    * @return void
    * @throws
    */
    public function reconnect(Company $company) {     
        // Erase the tenant connection, thus making Laravel get the default values all over again.
        DB::purge('tenant');
        
        // Make sure to use the database name we want to establish a connection.
        Config::set('tenant.connections.tenant.host', $company->db_host);
        Config::set('tenant.connections.tenant.database', $company->db_database);
        Config::set('tenant.connections.tenant.username', $company->db_username);
        Config::set('tenant.connections.tenant.password', $company->db_password);
        
        // Rearrange the connection data
        DB::reconnect('tenant');
        // Ping the database. This will throw an exception in case the database does not exists or the connection fails
        Schema::connection('tenant')->getConnection()->reconnect();
     }
     
  }