<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repositories\VideoRepositoryInterface;
use App\Contracts\Repositories\TranslationRepositoryInterface;
use App\Enums\ViewPaths\Admin\Video;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Video\VideoStoreRequest;
use App\Http\Requests\Admin\Video\VideoUpdateRequest;
use App\Services\VideoService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VideoController extends BaseController
{
    public function __construct(
        private readonly VideoRepositoryInterface           $videoRepo,
        private readonly TranslationRepositoryInterface     $translationRepo,
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
        return view(Video::LIST[VIEW], compact('videos'));
    }

    public function getAddView(): View
    {
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        return view(Video::ADD[VIEW], compact('languages', 'defaultLanguage'));
    }

    public function add(VideoStoreRequest $request, VideoService $videoService): RedirectResponse
    {
        $dataArray = $videoService->getProcessedData(request: $request);
        $savedVideo = $this->videoRepo->add(data: $dataArray);
        $this->translationRepo->add(request: $request, model: 'App\Models\Video', id: $savedVideo->id);

        Toastr::success(translate('video_added_successfully'));
        return redirect()->route('admin.videos.list');
    }

    public function getUpdateView(string|int $id): View|RedirectResponse
    {
        $video = $this->videoRepo->getFirstWhere(params: ['id' => $id]);
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = $languages[0];
        return view(Video::UPDATE[VIEW], compact('video', 'languages', 'defaultLanguage'));
    }

    public function update(VideoUpdateRequest $request, string|int $id, VideoService $videoService): RedirectResponse
    {
        $video = $this->videoRepo->getFirstWhere(params: ['id' => $request['id']]);
        $dataArray = $videoService->getProcessedData(request: $request, video: $video->video, oldType: $video->type);
        $this->videoRepo->update(id: $request['id'], data: $dataArray);
        $this->translationRepo->update(request: $request, model: 'App\Models\Video', id: $request['id']);

        Toastr::success(translate('video_updated_successfully'));
        return redirect()->route('admin.videos.list');
    }

    public function delete(Request $request, VideoService $videoService): RedirectResponse
    {
        $video = $this->videoRepo->getFirstWhere(params:['id' => $request['id']]);
        if ($video->type=='2') {
            $videoService->deleteVideo(data: $video);
        }
        $this->translationRepo->delete(model: 'App\Models\Video', id: $request['id']);
        $this->videoRepo->delete(params: ['id' => $request['id']]);
        Toastr::success(translate('video_deleted_successfully'));
        return redirect()->back();
    }
}
