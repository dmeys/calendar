<?php

namespace App\Http\Traits;

use App\Users\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Tymon\JWTAuth\Facades\JWTAuth;

trait HasUserId {
    static $_user_id_field = 'user_id';

    /**
     * Add user id to field
     */
    public static function bootHasUserId() {
        static::saving(function (Model $model) {
            if(empty($model['user_id'])) {
                $model->{self::$_user_id_field} = JWTAuth::parseToken()->toUser()->id;
            }
        });

        static::creating(function (Model $model) {
            if(empty($model['user_id'])) {
                $model->{self::$_user_id_field} = JWTAuth::parseToken()->toUser()->id;
            }
        });

//		static::addGlobalScope('user', function (Builder $builder) {
//			return $builder->whereUserId(JWTAuth::parseToken()->toUser()->id);
//		});
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}