<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    use Filterable;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'details',
        'active',
        'sale',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array',
        'active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', new ActiveScope);

        static::saving(function ($product) {
            if (is_string($product->details)) {
                $product->details = json_decode($product->details);
            }
        });
    }

    /**
     * Relation with price model.
     *
     * @return HasMany
     */
    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'product_id', 'id')
            ->orderBy('prices.value');
    }

    /**
     * List of fields by which the user can sort the models.
     *
     * @returns array
     */
    public static function allowedSortingFields(): array
    {
        return [
            'id',
            'name',
        ];
    }

    /**
     * Applies scope that returns only currently active products.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('products.active', true);
    }

    /**
     * Applies scope to match given term.
     *
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $term): Builder
    {
        $term = "%{$term}%";
        return $query->where(function (Builder $query) use ($term) {
            $query->where('products.name', 'like', $term)
                ->orWhere('products.description', 'like', $term)
                ->orWhereJsonContains('details', $term);
        });
    }
}
