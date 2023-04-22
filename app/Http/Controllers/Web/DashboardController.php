<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AppHelper;
use App\Http\Controllers\Controller;
use App\Repositories\DashboardRepository;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private DashboardRepository $dashboardRepo;

    public function __construct(DashboardRepository $dashboardRepo)
    {
        $this->dashboardRepo = $dashboardRepo;
    }

    public function index(Request $request)
    {
        try {
            $companyId = AppHelper::getAuthUserCompanyId();
            if (!$companyId) {
                throw new Exception('Company Detail Not Found');
            }
            $date = AppHelper::yearDetailToFilterData();
            $dashboardDetail = $this->dashboardRepo->getCompanyDashboardDetail($companyId, $date);
            return view('admin.dashboard', compact('dashboardDetail'));
        } catch (Exception $exception) {
            return redirect()
                ->back()
                ->with('danger', $exception->getMessage());
        }
    }


}
