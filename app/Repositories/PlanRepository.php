<?php

namespace App\Repositories;

use App\Contracts\Repositories\PlanRepositoryInterface;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanRepository implements PlanRepositoryInterface
{
    public function __construct(
        private readonly Plan       $plan,
    )
    {
    }

    public function add(array $data): string|object
    {
        return $this->plan->create($data);
    }

    public function getFirstWhere(array $params, array $relations = []): ?Model
    {
        return $this->plan->where($params)->with($relations)->withoutGlobalScopes()->first();
    }

    public function getList(array $orderBy = [], array $relations = [], int|string $dataLimit = DEFAULT_DATA_LIMIT, int $offset = null): Collection|LengthAwarePaginator
    {
        $query = $this->plan->with($relations)
                ->when(!empty($orderBy), function ($query) use ($orderBy) {
                    return $query->orderBy(array_key_first($orderBy),array_values($orderBy)[0]);
                });

        return $dataLimit == 'all' ? $query->get() : $query->paginate($dataLimit);
    }

    public function getListWhere(array $orderBy = [], string $searchValue = null, array $filters = [], array $relations = [], int|string $dataLimit = DEFAULT_DATA_LIMIT, int $offset = null): Collection|LengthAwarePaginator
    {
        $query = $this->plan->with($relations)
            ->where($filters)
            ->when(isset($searchValue), function ($query) use ($searchValue) {
                $query->where('name', 'like', "%$searchValue%");
            })
            ->when(!empty($orderBy), function ($query) use ($orderBy) {
                return $query->orderBy(array_key_first($orderBy), array_values($orderBy)[0]);
            });

        $filters += ['searchValue' =>$searchValue];
        return $dataLimit == 'all' ? $query->get() : $query->paginate($dataLimit)->appends($filters);
    }

    public function update(string $id, array $data): bool
    {
        return $this->plan->where('id', $id)->update($data);
    }

    public function delete(array $params): bool
    {
        return true;
    }
}
