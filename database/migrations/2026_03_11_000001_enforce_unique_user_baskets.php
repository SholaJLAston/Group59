<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $duplicateUserIds = DB::table('baskets')
                ->select('user_id')
                ->groupBy('user_id')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('user_id');

            foreach ($duplicateUserIds as $userId) {
                $basketIds = DB::table('baskets')
                    ->where('user_id', $userId)
                    ->orderBy('id')
                    ->pluck('id')
                    ->all();

                $primaryBasketId = array_shift($basketIds);

                foreach ($basketIds as $basketId) {
                    $items = DB::table('basket_items')
                        ->where('basket_id', $basketId)
                        ->get();

                    foreach ($items as $item) {
                        $existingItem = DB::table('basket_items')
                            ->where('basket_id', $primaryBasketId)
                            ->where('product_id', $item->product_id)
                            ->first();

                        if ($existingItem) {
                            DB::table('basket_items')
                                ->where('id', $existingItem->id)
                                ->update([
                                    'quantity' => $existingItem->quantity + $item->quantity,
                                    'updated_at' => now(),
                                ]);

                            DB::table('basket_items')
                                ->where('id', $item->id)
                                ->delete();

                            continue;
                        }

                        DB::table('basket_items')
                            ->where('id', $item->id)
                            ->update([
                                'basket_id' => $primaryBasketId,
                                'updated_at' => now(),
                            ]);
                    }

                    DB::table('baskets')
                        ->where('id', $basketId)
                        ->delete();
                }
            }
        });

        Schema::table('baskets', function (Blueprint $table) {
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('baskets', function (Blueprint $table) {
            $table->dropUnique('baskets_user_id_unique');
        });
    }
};