<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use App\User;
use App\Role;
use App\Permission;
use Carbon\Carbon;
use App\Provider;

class TenantController extends Controller
{
    public function createWebsite($uuid)
    {
        $website = new Website;
        $website->managed_by_database_connection = 'system';
        $website->uuid = $uuid;
        //dd($website);
        app(WebsiteRepository::class)->create($website);
        //dd($website->uuid);
        $hostname = new Hostname;
        $hostname->fqdn = $uuid.'.tenant.boo';
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        return $website;
    }

    public function addHostname()
    {
        $website   = app(\Hyn\Tenancy\Environment::class)->tenant();
        //dd($website);
        $hostname = new Hostname;
        $hostname->fqdn = 'sub.tenant.boo';
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
        dd($website->hostnames);
    }

    public function getTenant()
    {
        //$website   = \Hyn\Tenancy\Facades\TenancyFacade::website();
        $website   = Website::where('uuid','provider1')->first();
        // $website   = app(\Hyn\Tenancy\Environment::class)->tenant();
        // $website   = app(\Hyn\Tenancy\Environment::class)->tenant();
        dd($website);
        
    }

    public function createUser()
    {
        $environment = app(\Hyn\Tenancy\Environment::class);
        $hostname = Hostname::find(1);
        $environment->hostname($hostname);
        $role = Role::create(['name' => 'writer']);
        $permission = Permission::create(['name' => 'edit articles']);
        $user = User::find(1);
        $user->getRoleNames();  
        $user->assignRole('writer');
        $user->save();
        $user = User::find(1);
        return $user->getRoleNames();  
    }

public function fullTenantCreate()
{
    $name = 'Dusan';
    $email = 'dusan@example.com';
    $password = bcrypt('dusanpass');
    $user = User::create([
        'name' => $name,
        'email' => $email,
        'password' => $password,
    ]);
    $provider = Provider::create([
        'name' =>'provider'.$user->id,
        'user_id' => $user->id,
    ]);
    $uuid = $provider->name;
    $this->createWebsite($uuid);
    return "Success!";
}

}
