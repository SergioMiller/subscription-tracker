<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('currencies', static function (Blueprint $table) {
            $table->id();
            $table->string('name', 16);
            $table->string('code', 3);
            $table->string('symbol', 4);
            $table->timestamps();

            $table->unique(['name', 'code']);
        });

        Schema::create('exchange_rates', static function (Blueprint $table) {
            $table->foreignId('from_currency_id')->constrained('currencies', 'id')->cascadeOnDelete();
            $table->foreignId('to_currency_id')->constrained('currencies', 'id')->cascadeOnDelete();
            $table->float('rate');
            $table->timestamps();

            $table->unique(['from_currency_id', 'to_currency_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
