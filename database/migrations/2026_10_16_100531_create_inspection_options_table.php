<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspection_options', function (Blueprint $table) {
            $table->id();
            $table->string('category', 50)->index();
            $table->string('name', 150);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['category', 'name']);
        });

        $now = now();
        $defaults = [
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

        $records = [];
        foreach ($defaults as $category => $names) {
            foreach ($names as $order => $name) {
                $records[] = [
                    'category' => $category,
                    'name' => $name,
                    'sort_order' => $order,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('inspection_options')->insert($records);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_options');
    }
};
