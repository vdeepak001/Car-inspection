<?php

namespace App\Models;

use Database\Factories\InspectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'brand', 'model_name', 'location', 'inspector', 'vin', 'engine_number', 'inspected_on', 'overall_rating', 'status', 'photos'])]
class Inspection extends Model
{
    /** @use HasFactory<InspectionFactory> */
    use HasFactory;

    /**
     * Checklist sections and the photo required for each item.
     *
     * @return array<string, array<string, string>>
     */
    public static function checklist(): array
    {
        return [
            'Exterior & Body' => [
                'exterior_paint' => 'Paint condition — all panels',
                'exterior_glass' => 'Windshield & window glass',
                'exterior_lights' => 'Headlights, tail lights & indicators',
                'exterior_doors' => 'Doors, boot & bonnet alignment',
                'exterior_bumpers' => 'Bumpers & body cladding',
                'exterior_mirrors' => 'Side mirrors & adjustment',
            ],
            'Tyres & Wheels' => [
                'tyres_tread' => 'Tread depth — all four tyres',
                'tyres_spare' => 'Spare wheel & jack kit',
                'tyres_alignment' => 'Wheel alignment & balancing',
                'tyres_rims' => 'Alloy wheels / Rims condition',
                'tyres_pressure' => 'Tyre pressure monitoring',
            ],
            'Engine Bay & Fluids' => [
                'engine_oil' => 'Engine oil level',
                'engine_coolant' => 'Coolant & brake fluid level',
                'engine_battery' => 'Battery health & terminals',
                'engine_belts' => 'Drive belts & hoses',
                'engine_radiator' => 'Radiator & cooling system',
            ],
            'Interior & Electronics' => [
                'interior_infotainment' => 'Infotainment & reverse camera',
                'interior_ac' => 'Air conditioning & heating',
                'interior_windows' => 'Power windows & central locking',
                'interior_seats' => 'Seats & upholstery condition',
                'interior_steering' => 'Steering wheel & controls',
            ],
            'Safety Features' => [
                'safety_airbags' => 'Airbags & SRS system',
                'safety_abs' => 'ABS & braking system',
                'safety_belts' => 'Seatbelts & pretensioners',
                'safety_lights' => 'All lights & indicators',
                'safety_horn' => 'Horn & wipers',
            ],
        ];
    }

    /**
     * Flat checklist keyed by the form field name.
     *
     * @return array<string, array{section: string, label: string}>
     */
    public static function checklistItems(): array
    {
        $items = [];

        foreach (self::checklist() as $section => $labels) {
            foreach ($labels as $key => $label) {
                $items[$key] = [
                    'section' => $section,
                    'label' => $label,
                ];
            }
        }

        return $items;
    }

    /**
     * Tailwind text color for a score out of 10.
     */
    public static function scoreClass(int|float $score): string
    {
        if ($score >= 8) {
            return 'text-emerald-600';
        }

        if ($score >= 5) {
            return 'text-amber-500';
        }

        return 'text-red-600';
    }

    /**
     * Website account that saved this inspection.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Saved checklist rows for this inspection.
     */
    public function items(): HasMany
    {
        return $this->hasMany(InspectionItem::class);
    }

    /**
     * Five-character code so the address does not show the database id.
     */
    public function getRouteKey(): string
    {
        return $this->encodeRouteKey((int) $this->getKey());
    }

    /**
     * Resolve an inspection from its short address code.
     */
    public function resolveRouteBinding($value, $field = null): ?static
    {
        if ($field !== null) {
            return parent::resolveRouteBinding($value, $field);
        }

        $id = $this->decodeRouteKey((string) $value);

        if ($id === null) {
            return null;
        }

        return $this->resolveRouteBindingQuery($this, $id, null)->first();
    }

    /**
     * Turn the database id into a 5-character code.
     */
    private function encodeRouteKey(int $id): string
    {
        $mixed = ($id * $this->routeKeyMultiplier() + $this->routeKeyOffset()) % $this->routeKeySpace();

        return str_pad(base_convert((string) $mixed, 10, 36), 5, '0', STR_PAD_LEFT);
    }

    /**
     * Turn a 5-character code back into the database id.
     */
    private function decodeRouteKey(string $value): ?int
    {
        $value = strtolower($value);

        if (preg_match('/^[0-9a-z]{5}$/', $value) !== 1) {
            return null;
        }

        $space = $this->routeKeySpace();
        $mixed = (int) base_convert($value, 36, 10);
        $shifted = ($mixed - $this->routeKeyOffset()) % $space;

        if ($shifted < 0) {
            $shifted += $space;
        }

        $id = ($shifted * $this->routeKeyInverse()) % $space;

        return $id > 0 ? $id : null;
    }

    /**
     * Number of distinct 5-character codes.
     */
    private function routeKeySpace(): int
    {
        return 36 ** 5;
    }

    /**
     * Secret multiplier that stays reversible for every code.
     */
    private function routeKeyMultiplier(): int
    {
        $multiplier = (hexdec(substr(hash('sha256', (string) config('app.key').'inspection'), 0, 5)) % 8000) | 1;

        if ($multiplier % 3 === 0) {
            $multiplier += 2;
        }

        return $multiplier;
    }

    /**
     * Secret shift mixed into the code.
     */
    private function routeKeyOffset(): int
    {
        return hexdec(substr(hash('sha256', (string) config('app.key').'inspection-offset'), 0, 6)) % $this->routeKeySpace();
    }

    /**
     * Number that undoes the secret multiplier.
     */
    private function routeKeyInverse(): int
    {
        $modulus = $this->routeKeySpace();
        $value = $this->routeKeyMultiplier();
        $inverse = 0;
        $current = 1;

        while ($value > 1) {
            $quotient = intdiv($value, $modulus);
            $remainder = $value % $modulus;
            $value = $modulus;
            $modulus = $remainder;
            $next = $current - ($quotient * $inverse);
            $current = $inverse;
            $inverse = $next;
        }

        return $current < 0 ? $current + $this->routeKeySpace() : $current;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'inspected_on' => 'date',
            'overall_rating' => 'decimal:1',
            'photos' => 'array',
        ];
    }
}
