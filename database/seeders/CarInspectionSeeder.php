<?php

namespace Database\Seeders;

use App\Models\Inspection;
use App\Models\InspectionItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class CarInspectionSeeder extends Seeder
{
    /**
     * Seed verified car inspections for public viewing without login.
     */
    public function run(): void
    {
        $admin = User::query()->first();

        $cars = [
            [
                'brand' => 'MG',
                'model_name' => 'Hector Plus',
                'vehicle_variant' => '2022 - 61,000 km',
                'vehicle_number' => 'MH49CL0027',
                'chassis_number' => '1HGCR2F83HA100001',
                'location' => 'Jafar Nagar',
                'sale_price' => '₹ 14,75,000',
                'market_value' => '₹ 15,20,000',
                'inspected_on' => '2026-07-09',
                'photo' => 'pdi/hector.jpg',
                'rating' => 8.8,
            ],
            [
                'brand' => 'Hyundai',
                'model_name' => 'Creta',
                'vehicle_variant' => '2021 - 85,000 km',
                'vehicle_number' => 'MH49BQ5201',
                'chassis_number' => '1HGCR2F83HA100002',
                'location' => 'Civil Lines',
                'sale_price' => '₹ 10,49,000',
                'market_value' => '₹ 11,00,000',
                'inspected_on' => '2026-10-06',
                'photo' => 'pdi/creta.jpg',
                'rating' => 9.2,
            ],
            [
                'brand' => 'Maruti Suzuki',
                'model_name' => 'Vitara Brezza',
                'vehicle_variant' => '2017 - 89,000 km',
                'vehicle_number' => 'MH49AS2948',
                'chassis_number' => '1HGCR2F83HA100003',
                'location' => 'Bagadganj',
                'sale_price' => '₹ 6,51,000',
                'market_value' => '₹ 7,00,000',
                'inspected_on' => '2026-10-14',
                'photo' => 'pdi/brezza.jpg',
                'rating' => 8.1,
            ],
            [
                'brand' => 'Hyundai',
                'model_name' => 'Elite i20',
                'vehicle_variant' => '2019 - 48,000 km',
                'vehicle_number' => 'MH49AS0203',
                'chassis_number' => '1HGCR2F83HA100004',
                'location' => 'Ramdaspeth',
                'sale_price' => '₹ 5,80,000',
                'market_value' => '₹ 6,20,000',
                'inspected_on' => '2026-10-11',
                'photo' => 'pdi/i20.jpg',
                'rating' => 8.4,
            ],
            [
                'brand' => 'Chevrolet',
                'model_name' => 'Captiva',
                'vehicle_variant' => '2015 - 92,000 km',
                'vehicle_number' => 'MH15BX7565',
                'chassis_number' => '1HGCR2F83HA100005',
                'location' => 'Dharampeth',
                'sale_price' => '₹ 4,25,000',
                'market_value' => '₹ 4,80,000',
                'inspected_on' => '2026-10-09',
                'photo' => 'pdi/captiva.jpg',
                'rating' => 7.6,
            ],
            [
                'brand' => 'Skoda',
                'model_name' => 'Octavia',
                'vehicle_variant' => '2018 - 55,000 km',
                'vehicle_number' => 'MH49CD8821',
                'chassis_number' => '1HGCR2F83HA100006',
                'location' => 'Sadar',
                'sale_price' => '₹ 8,90,000',
                'market_value' => '₹ 9,50,000',
                'inspected_on' => '2026-10-02',
                'photo' => 'pdi/octavia.jpg',
                'rating' => 8.7,
            ],
        ];

        foreach ($cars as $car) {
            $inspection = Inspection::query()->updateOrCreate(
                ['vehicle_number' => $car['vehicle_number']],
                [
                    'user_id' => $admin?->id,
                    'brand' => $car['brand'],
                    'model_name' => $car['model_name'],
                    'vehicle_variant' => $car['vehicle_variant'],
                    'chassis_number' => $car['chassis_number'],
                    'vin' => $car['chassis_number'],
                    'location' => $car['location'],
                    'sale_price' => $car['sale_price'],
                    'market_value' => $car['market_value'],
                    'inspected_on' => $car['inspected_on'],
                    'overall_rating' => $car['rating'],
                    'status' => 'completed',
                    'inspector' => 'Dolly Pravin Kankariya',
                    'rc_status' => 'Available',
                    'insurance_type' => 'Comprehensive',
                    'photos' => [$car['photo']],
                ]
            );

            // Ensure key checklist items exist with photo
            InspectionItem::query()->updateOrCreate(
                [
                    'inspection_id' => $inspection->id,
                    'item_key' => 'exterior_paint',
                ],
                [
                    'section' => 'Exterior & Body',
                    'label' => 'Paint condition — all panels',
                    'score' => (int) round($car['rating']),
                    'photo' => $car['photo'],
                ]
            );

            InspectionItem::query()->updateOrCreate(
                [
                    'inspection_id' => $inspection->id,
                    'item_key' => 'exterior_glass',
                ],
                [
                    'section' => 'Exterior & Body',
                    'label' => 'Windshield & window glass',
                    'score' => 9,
                    'photo' => $car['photo'],
                ]
            );
        }
    }
}
