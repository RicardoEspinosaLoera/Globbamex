<?php

namespace App\Services;

use App\Traits\FileManagerTrait;

class VideoService
{
    use FileManagerTrait;

    public function getProcessedData(object $request, string $video = null, string $oldType = '1'): array
    {
        if ($request['type']=='2') {
            $file=$request->file('video');

            if ($oldType=='2' && !is_null($video)) {
                $videoName=$request->hasFile('video') ? $this->update(dir: 'videos/', oldImage: $video, format: $file->getClientOriginalExtension(), image: $file, fileType: 'file') : $video;
            } else {
                $videoName=$this->fileUpload(dir: 'videos/', format: $file->getClientOriginalExtension(), file: $file);
            }
        } else {
            if ($oldType=='2' && !is_null($video)) {
                $this->delete(filePath: 'videos/'.$video);
            }
            $videoName=$request['url'];
        }

        return [
            'title' => $request['title'][array_search('en', $request['lang'])],
            'description' => $request['description'][array_search('en', $request['lang'])],
            'type' => $request['type'],
            'video' => $videoName
        ];
    }

    public function deleteVideo(object $data): bool
    {
        if ($data['video']) {
            $this->delete(filePath: 'videos/'.$data['video']);
        }
        return true;
    }
}
