<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->string('vehicle_number')->nullable()->after('model_name');
            $table->string('chassis_number', 17)->nullable()->unique()->after('vehicle_number');
            $table->string('vehicle_variant')->nullable()->after('chassis_number');
            $table->string('rc_status')->nullable()->after('vehicle_variant');
            $table->string('rc_front_photo')->nullable()->after('rc_status');
            $table->string('rc_back_photo')->nullable()->after('rc_front_photo');
            $table->date('rc_valid_until')->nullable()->after('rc_back_photo');
            $table->string('insurance_type')->nullable()->after('rc_valid_until');
            $table->string('insurance_photo')->nullable()->after('insurance_type');
            $table->date('insurance_valid_until')->nullable()->after('insurance_photo');
            $table->string('approx_expense')->nullable()->after('insurance_valid_until');
            $table->string('market_value')->nullable()->after('approx_expense');
            $table->string('sale_price')->nullable()->after('market_value');
            $table->string('file_number')->nullable()->after('sale_price');
            $table->string('rto_location')->nullable()->after('file_number');
            $table->string('customer_name')->nullable()->after('rto_location');
            $table->text('remark')->nullable()->after('customer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropColumn([
                'vehicle_number',
                'chassis_number',
                'vehicle_variant',
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
            ]);
        });
    }
};
