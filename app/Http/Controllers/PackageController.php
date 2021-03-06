<?php

namespace App\Http\Controllers;

use App\Portal\Services\PackageService;
use App\Portal\Services\ShipmentService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    //

    /**
     * @var PackageService
     */
    private $packageService;
    /**
     * @var ShipmentService
     */
    private $shipmentService;

    public function __construct(PackageService $packageService,ShipmentService $shipmentService)
    {

        $this->packageService = $packageService;
        $this->shipmentService = $shipmentService;
    }

    public function create()
    {
        $package= $this->packageService->getpackage();

        return view('front.packagecomplain',compact('package'));
    }
    public function report(Request $request)
    {
        if ($this->packageService->addPackagereport($request)) {
            return redirect()->route('/home')->withSuccess("package lost report added!");
        }
        return back()->withErrors("Check Your Tracking Id once more");
    }

    public function track()
    {
        return view('front.trackform');
    }

    public function gettrack(Request $request)
    {
        if ($result=$this->shipmentService->getpackagebytrack($request))
        {
            return view('front.tracked',compact('result'))->withSuccess("package tracked!");
        }
        return back()->withErrors("Check Tracking Id once more");
    }

public function pickup()
{
    return view('front.pickup');
}

}
