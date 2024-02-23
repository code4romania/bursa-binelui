<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class County extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'coordinates',
    ];

    public $timestamps = false;

    protected array $geometry = ['coordinates'];

    protected bool $geometryAsText = true;

    public function newQuery($excludeDeleted = true)
    {
        if (! empty($this->geometry) && $this->geometryAsText === true) {
            $raw = '';
            foreach ($this->geometry as $column) {
                $raw .= 'ST_AsText(`' . $this->table . '`.`' . $column . '`) as `' . $column . '`, ';
            }
            $raw = substr($raw, 0, -2);

            return parent::newQuery($excludeDeleted)->addSelect('*', DB::raw($raw));
        }

        return parent::newQuery($excludeDeleted);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'model', 'model_has_counties', 'model_id');
    }

    public function getCoordinatesAttribute($value)
    {
        $value = Str::replaceFirst('POINT(', '', $value);
        $value = Str::replaceLast(')', '', $value);

        $value = explode(' ', $value);
        $value[0] = (float) $value[0];
        $value[1] = (float) $value[1];
        return $value;
    }
}
