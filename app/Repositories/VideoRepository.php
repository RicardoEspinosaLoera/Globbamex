<?php

namespace App\Repositories;

use App\Contracts\Repositories\VideoRepositoryInterface;
use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class VideoRepository implements VideoRepositoryInterface
{
    public function __construct(
        private readonly Video         $video,
    )
    {
    }

    public function add(array $data): string|object
    {
        return $this->video->create($data);
    }

    public function getFirstWhere(array $params, array $relations = []): ?Model
    {
        return $this->video->withoutGlobalScope('translate')->with($relations)->where($params)->first();
    }

    public function getList(array $orderBy = [], array $relations = [], int|string $dataLimit = DEFAULT_DATA_LIMIT, int $offset = null): Collection|LengthAwarePaginator
    {
        $query = $this->video->with($relations)
                ->when(!empty($orderBy), function ($query) use ($orderBy) {
                    return $query->orderBy(array_key_first($orderBy),array_values($orderBy)[0]);
                });

        return $dataLimit == 'all' ? $query->get() : $query->paginate($dataLimit);
    }

    public function getListWhere(array $orderBy=[], string $searchValue = null, array $filters = [], array $relations = [], int|string $dataLimit = DEFAULT_DATA_LIMIT, int $offset = null): Collection|LengthAwarePaginator
    {
        $query = $this->video
            ->when($searchValue, function ($query) use($searchValue){
                $query->Where('title', 'like', "%$searchValue%")->orWhere('id', $searchValue);
            })
            ->when(isset($filters['title']), function ($query) use($filters) {
                return $query->where(['title' => $filters['title']]);
            })
            ->when(isset($filters['state']), function ($query) use($filters) {
                return $query->where(['state' => $filters['state']]);
            })
            ->when(!empty($orderBy), function ($query) use ($orderBy) {
                $query->orderBy(array_key_first($orderBy),array_values($orderBy)[0]);
            });

        $filters += ['searchValue' =>$searchValue];
        return $dataLimit == 'all' ? $query->get() : $query->paginate($dataLimit)->appends($filters);

    }

    public function update(string $id, array $data): bool
    {
        return $this->video->where('id', $id)->update($data);
    }

    public function delete(array $params): bool
    {
        $this->video->where($params)->delete();
        return true;
    }

}
