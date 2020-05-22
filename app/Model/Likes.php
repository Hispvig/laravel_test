<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Likes extends Model
{
    const TABLES_LIST = ['newsTable', 'photosTable'];

    protected $fillable = ['user_id', 'table', 'element_id'];

    public $timestamps = false;

    public static function getByTableElement($table, $elementId): array
    {
        if (in_array($table, self::TABLES_LIST)) {
            $redis = Redis::connection();
            $hashKey = 'likes_list_' . $table . $elementId;
            $result = $redis->hgetall($hashKey);

            if (!$result) {
                $result = [];
                $list = self::where([
                    ['table', '=', $table],
                    ['element_id', '=', $elementId]
                ])->get();

                foreach ($list as $key => $value) {
                    $result[(int)$value->user_id] = (int)$value->user_id;
                }

                $result['count'] = count($result);

                $redis->command('hmset', [$hashKey, $result]);
                $redis->command('expire', [$hashKey, 3200]);
            }

            return $result;
        }

        return [];
    }

    public static function editUserLikes(int $userId, string $table, int $elementId): array
    {
        $redis = Redis::connection();
        $hashKey = 'likes_list_' . $table . $elementId;
        $result = $redis->hgetall($hashKey);

        self::updateOrCreate([
            'user_id' => $userId,
            'table' => $table,
            'element_id' => $elementId,
        ]);

        $result[$userId] = $userId;

        unset($result['count']);
        $result['count'] = count($result);

        $redis->command('hmset', [$hashKey, $result]);

        return $result;
    }

    public static function deleteUserLikes(int $userId, string $table, int $elementId): array
    {
        $redis = Redis::connection();
        $hashKey = 'likes_list_' . $table . $elementId;
        $result = $redis->hgetall($hashKey);

        self::where([
                ['user_id', '=', $userId],
                ['table', '=', $table],
                ['element_id', '=', $elementId],
            ])->delete();

        unset($result[$userId], $result['count']);
        $result['count'] = count($result);

        $redis->command('hmset', [$hashKey, $result]);

        return $result;
    }
}
