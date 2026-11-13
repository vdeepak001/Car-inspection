<?php

namespace App\Models;

use Database\Factories\InspectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'brand',
    'model_name',
    'vehicle_number',
    'chassis_number',
    'vehicle_variant',
    'location',
    'inspector',
    'vin',
    'engine_number',
    'inspected_on',
    'rc_status',
    'rc_front_photo',
    'rc_back_photo',
    'rc_valid_until',
    'insurance_type',
    'insurance_photo',
    'insurance_valid_until',
    'approx_expense',
    'market_value',
    'sale_price',
    'file_number',
    'rto_location',
    'customer_name',
    'remark',
    'overall_rating',
    'status',
    'photos',
])]
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
                'exterior_front_photo_full' => 'FRONT PHOTO FULL',
                'exterior_right_side_photo_full' => 'RIGHT SIDE PHOTO FULL',
                'exterior_back_side_photo_full' => 'BACK SIDE PHOTO FULL',
                'exterior_left_side_photo_full' => 'LEFT SIDE PHOTO FULL',
                'exterior_front_left_corner' => 'FRONT LEFT CORNER',
                'exterior_front_right_corner' => 'FRONT RIGHT CORNER',
                'exterior_back_right_corner' => 'BACK RIGHT CORNER',
                'exterior_back_left_corner' => 'BACK LEFT CORNER',
                'exterior_lower_silencer_side' => 'PHOTO OF LOWER SIDE FROM SILENCER SIDE',
                'exterior_lower_front_side' => 'PHOTO OF LOWER SIDE FROM FRONT SIDE',
                'exterior_roof_full' => 'PHOTO OF TOP ROOF FULL',
                'exterior_roof_front_side' => 'PHOTO OF TOP ROOF FRONT SIDE',
                'exterior_roof_back_side' => 'PHOTO OF TOP ROOF BACK SIDE',
                'exterior_full_circle_360_video' => 'FULL CIRCLE 360 VIDEO',
                'exterior_bonat_photo' => 'BONAT PHOTO',
                'exterior_buffer_photo' => 'BUFFER PHOTO front + rear',
                'exterior_head_light_1' => 'HEAD LIGHT 1',
                'exterior_head_light_2' => 'HEAD LIGHT 2',
                'exterior_tail_light_1' => 'TAIL LIGHT 1',
                'exterior_tail_light_2' => 'TAIL LIGHT 2',
                'exterior_fog_lamp_1' => 'FOG LAMP 1',
                'exterior_fog_lamp_2' => 'FOG LAMP 2',
            ],
            'Tyres & Wheels' => [
                'tyres_right_front' => 'RIGHT FRONT TYRE',
                'tyres_left_front' => 'LEFT FRONT TYRE',
                'tyres_left_back' => 'LEFT BACK TYRE',
                'tyres_right_back' => 'RIGHT BACK TYRE',
                'tyres_stephney' => 'STEPHNEY PHOTO',
                'tyres_wheel_cap_right_front' => 'WHEEL CAP & ALLOY WHEEL PHOTO RIGHT FRONT',
                'tyres_wheel_cap_left_front' => 'WHEEL CAP & ALLOY WHEEL PHOTO LEFT FRONT',
                'tyres_wheel_cap_right_back' => 'WHEEL CAP & ALLOY WHEEL PHOTO RIGHT BACK',
                'tyres_wheel_cap_left_back' => 'WHEEL CAP & ALLOY WHEEL PHOTO LEFT BACK',
                'tyres_wheel_cap_stephney' => 'WHEEL CAP & ALLOY WHEEL PHOTO STEPHNEY',
            ],
            'Engine Bay & Fluids' => [
                'engine_oil_gage_video' => 'Engine oil GAGE SHORT VIDEO',
                'engine_sound_video' => 'ENGINE SOUND FULL VIDEO',
                'engine_battery' => 'Battery PHOTO',
                'engine_photo' => 'ENGINE PHOTO',
                'engine_extra_left_apron' => 'EXTRA PHOTO OF ENGINES 1LEFT APRON',
                'engine_extra_right_apron' => 'EXTRA PHOTO OF ENGINES 2 RIGHT APRON',
            ],
            'Interior & Electronics' => [
                'interior_full_photo_1' => 'FULL INTERIOR PHOTO 1',
                'interior_full_photo_2' => 'FULL INTERIOR PHOTO 2',
                'interior_door_frame_1' => 'DOOR FRAME 1',
                'interior_door_frame_2' => 'DOOR FRAME 2',
                'interior_door_frame_3' => 'DOOR FRAME 3',
                'interior_door_frame_4' => 'DOOR FRAME 4',
                'interior_door_deeki' => 'DOOR DEEKI PHOTO',
                'interior_meter' => 'METER PHOTO',
                'interior_steering' => 'STERRING PHOTO',
                'interior_tool_kit' => 'TOOL KIT',
                'interior_ac_video' => 'AC SHORT VIDEO',
                'interior_ac_photo' => 'AC PHOTO',
                'interior_music_system' => 'MUSIC SYSTEM PHOTO',
                'interior_dash_board' => 'DASH BOARD PHOTO',
                'interior_seat_rear' => 'SEAT PHOTO REAR',
                'interior_seat_front' => 'SEAT PHOTO FRONT',
                'interior_extra_1' => 'EXTRA PHOTO 1',
                'interior_extra_2' => 'EXTRA PHOTO 2',
                'interior_remark' => 'REMARK',
            ],
            'Safety Features' => [
                'safety_airbags' => 'Airbags',
                'safety_extra_1' => 'EXTRA 1',
                'safety_extra_2' => 'EXTRA 2',
                'safety_lights_indicators_video' => 'All lights & indicators SHORT VIDEO',
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
     * Get the public URL of the cover photo stored in the database.
     */
    public function coverPhotoUrl(): string
    {
        $firstItem = $this->relationLoaded('items')
            ? $this->items->first(fn ($item) => filled($item->photo))
            : $this->items()->whereNotNull('photo')->first();

        $path = $firstItem?->photo;

        if (! filled($path) && is_array($this->photos) && count($this->photos) > 0) {
            $path = $this->photos[0];
        }

        if (! filled($path) && filled($this->rc_front_photo)) {
            $path = $this->rc_front_photo;
        }

        if (filled($path)) {
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }

            if (file_exists(public_path('storage/'.$path)) || file_exists(storage_path('app/public/'.$path))) {
                return asset('storage/'.$path);
            }

            if (file_exists(public_path('images/cars/'.basename($path)))) {
                return asset('images/cars/'.basename($path));
            }

            return asset('storage/'.$path);
        }

        $slug = strtolower($this->brand.'-'.$this->model_name);
        if (str_contains($slug, 'hector')) {
            return asset('images/cars/hector.jpg');
        } elseif (str_contains($slug, 'creta')) {
            return asset('images/cars/creta.jpg');
        } elseif (str_contains($slug, 'brezza')) {
            return asset('images/cars/brezza.jpg');
        } elseif (str_contains($slug, 'i20')) {
            return asset('images/cars/i20.jpg');
        } elseif (str_contains($slug, 'captiva')) {
            return asset('images/cars/captiva.jpg');
        } elseif (str_contains($slug, 'octavia')) {
            return asset('images/cars/octavia.jpg');
        }

        return asset('images/cars/hero.jpg');
    }

    /**
     * Formatted sale price or market value.
     */
    public function displayPrice(): string
    {
        $raw = $this->sale_price ?: $this->market_value;

        if (! filled($raw)) {
            return '₹ Price on Request';
        }

        if (str_starts_with($raw, '₹')) {
            return $raw;
        }

        $numeric = str_replace([',', ' '], '', $raw);

        if (is_numeric($numeric)) {
            return '₹ '.number_format((float) $numeric);
        }

        return '₹ '.$raw;
    }

    /**
     * Formatted variant or year and mileage.
     */
    public function displayVariant(): string
    {
        return $this->vehicle_variant ?: 'Verified PDI';
    }

    /**
     * Human readable date text matching marketplace style (e.g. "Jul 09", "2 days ago").
     */
    public function displayDate(): string
    {
        $date = $this->inspected_on ?? $this->created_at;

        if (! $date) {
            return 'Verified';
        }

        $diffDays = (int) round(abs(now()->diffInDays($date)));

        if ($diffDays === 0) {
            return 'Today';
        }

        if ($diffDays === 1) {
            return '1 day ago';
        }

        if ($diffDays <= 4) {
            return "{$diffDays} days ago";
        }

        return $date->format('M d');
    }

    /**
     * Check if vehicle qualifies for ELITE badge.
     */
    public function isElite(): bool
    {
        return (float) $this->overall_rating >= 9.0;
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
            'rc_valid_until' => 'date',
            'insurance_valid_until' => 'date',
            'overall_rating' => 'decimal:1',
            'photos' => 'array',
        ];
    }
}
