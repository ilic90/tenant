<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use App\User;
use App\Provider;
use App\Providers\TenantProvider;

class HomeController extends Controller
{
    //use ServiceProvider;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $tenantProvider;
    public function __construct(TenantProvider $tenantProvider)
    {
        $this->middleware('auth');
        $this->tenantProvider = $tenantProvider;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $provider = $user->provider;
        $website = Website::where('uuid',$provider->name)->first();
        $this->tenantProvider->boot($website);
        //$environment->tenant($website);
        return view('home');
    }
}
