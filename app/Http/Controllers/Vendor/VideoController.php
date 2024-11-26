<?php

namespace App\Http\Controllers\Vendor;

use App\Contracts\Repositories\VideoRepositoryInterface;
use App\Enums\ViewPaths\Vendor\Video;
use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class VideoController extends BaseController
{
    public function __construct(
        private readonly VideoRepositoryInterface           $videoRepo,
    )
    {
    }

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View Index function is the starting point of a controller
     * Index function is the starting point of a controller
     */
    public function index(Request|null $request, string $type = null): View
    {
        return $this->getList($request);
    }

    public function getList(Request $request): Application|Factory|View
    {
        $videos = $this->videoRepo->getListWhere(orderBy: ['id' => 'desc'], searchValue: $request->get('searchValue'), dataLimit: getWebConfig(name: 'pagination_limit'));
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = session()->has('local') ? session('local') : 'en';
        return view(Video::INDEX[VIEW], compact('videos', 'languages', 'defaultLanguage'));
    }
}
