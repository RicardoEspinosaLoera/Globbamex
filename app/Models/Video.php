<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Video
 *
 * @property string $video
 * @property string|null $title
 * @property string|null $description
 * @property string $type
 * @property bool $state
 *
 * @package App\Models
 */
class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video',
        'title',
        'description',
        'type',
        'state',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope('translate', function(Builder $builder) {
            $builder->with(['translations' => function($query) {
                if (strpos(url()->current(), '/api')) {
                    return $query->where('locale', App::getLocale());
                } else {
                    return $query->where('locale', getDefaultLanguage());
                }
            }]);
        });
    }

    public function translations(): MorphMany
    {
        return $this->morphMany('App\Models\Translation', 'translationable');
    }
}
