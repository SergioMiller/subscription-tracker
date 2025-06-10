<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_subscriptions', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('subscription_id')->constrained('subscriptions', 'id')->onDelete('cascade');
            $table->foreignId('currency_id')->constrained('currencies', 'id');
            $table->integer('price');
            $table->integer('base_price');
            $table->string('status', 12);
            $table->timestamp('start_at');
            $table->timestamp('finish_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
