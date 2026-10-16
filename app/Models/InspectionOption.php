<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

#[Fillable(['category', 'name', 'sort_order'])]
class InspectionOption extends Model
{
    /** @use HasFactory */
    use HasFactory;

    /**
     * Default options for each category.
     *
     * @return array<string, array<int, string>>
     */
    public static function defaultOptions(): array
    {
        return [
            'inspector' => [
                'Dolly Pravin Kankariya',
                'Rahul Sharma',
                'Amit Verma',
                'Priya Patel',
            ],
            'brand' => [
                'Maruti',
                'Hyundai',
                'Tata',
                'Mahindra',
                'Honda',
                'Toyota',
                'Kia',
                'MG',
                'Suzuki',
                'BMW',
                'Mercedes',
                'DS Automobiles',
                'Volkswagen',
                'Skoda',
            ],
            'model' => [
                'Swift',
                'Baleno',
                'Brezza',
                'Dzire',
                'Creta',
                'Venue',
                'i20',
                'Nexon',
                'Punch',
                'Harrier',
                'Thar',
                'Scorpio',
                'XUV700',
                'City',
                'Fortuner',
                'Innova',
                'Seltos',
                'DS 7',
            ],
            'location' => [
                'Nagpur',
                'Mumbai',
                'Pune',
                'Delhi',
                'Bengaluru',
                'Hyderabad',
                'Chennai',
                'Kolkata',
                'Ahmedabad',
            ],
            'rc_status' => [
                'Available',
                'DRC Karwana Hai',
                'DRC - Before Done',
                'Plain RC',
                'Blacklisted but RC Available',
            ],
            'insurance_type' => [
                'Comprehensive',
                'Third Party (TP)',
                'Zero Depreciation (Zero Dep)',
                'Expired / None',
            ],
        ];
    }

    /**
     * Get all option names for a given category.
     *
     * @return Collection<int, string>
     */
    public static function forCategory(string $category): Collection
    {
        $options = static::query()
            ->where('category', $category)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name');

        if ($options->isNotEmpty()) {
            return $options;
        }

        return collect(static::defaultOptions()[$category] ?? []);
    }

    /**
     * Add a custom option to the database if it doesn't already exist.
     */
    public static function addOption(string $category, string $name): static
    {
        $name = trim($name);

        return static::query()->firstOrCreate(
            ['category' => $category, 'name' => $name],
            ['sort_order' => (int) (static::query()->where('category', $category)->max('sort_order') + 1)]
        );
    }
}
