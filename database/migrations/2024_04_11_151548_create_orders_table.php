<?php

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Phone;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Address::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Coupon::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignIdFor(Phone::class)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('payment');
            $table->string('status');
            $table->float('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
