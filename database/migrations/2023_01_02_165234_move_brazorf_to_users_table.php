<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasColumn('users', 'points_received')){
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedBigInteger('points_received')->default(0);
                $table->unsignedBigInteger('points_given')->default(0);
            });
        }
        DB::transaction(function () {
            DB::table('users')->orderBy('id')->chunk(100, function ($users) {
                $user_ids = [];
                foreach ($users as $user) {
                    $user_ids[] = $user->id;
                }
                $preloaded_famous_points_received = DB::table('famous_points')
                    ->selectRaw('user_id, sum(ajeje) as ajeje_sum')
                    ->whereIn('user_id', $user_ids)
                    ->groupBy('user_id')
                    ->get();
                $preloaded_famous_points_given = DB::table('famous_points')
                    ->selectRaw('sender_id, sum(ajeje) as ajeje_sum')
                    ->whereIn('sender_id', $user_ids)
                    ->groupBy('sender_id')
                    ->get();
                $data = [];
                foreach ($user_ids as $user_id) {
                    $user_points_received = $preloaded_famous_points_received->firstWhere('user_id', $user_id)->ajeje_sum ?? 0;
                    $user_points_given = $preloaded_famous_points_given->firstWhere('sender_id', $user_id)->ajeje_sum ?? 0;
                    if ($user_points_received + $user_points_given > 0) {
                        $data[] = [
                            'id' => $user_id,
                            'points_received' => $user_points_received,
                            'points_given' => $user_points_given,
                            'name' => '-',
                            'email' => '-',
                            'password' => '-',
                            'slug' => '-',
                            'type' => 0
                        ];
                    }
                }
                if (!empty($data)) {
                    DB::table('users')->upsert(
                        $data,
                        ['id'],
                        ['points_received', 'points_given']
                    );
                }
            });
            if (Schema::hasColumn('famous_points', 'brazorf'))
            {
                Schema::table('famous_points', function (Blueprint $table) {
                    $table->dropColumn('brazorf');
                });
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('points_received');
            $table->dropColumn('points_given');
        });
    }
};
