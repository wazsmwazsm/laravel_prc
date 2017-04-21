<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function gravatar($size = '100'){
      $hash = md5(strtolower(trim($this->attributes['email'])));
      return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    public static function boot(){
        parent::boot();

        static::creating(function ($user){
            $user->activation_token = str_random(30);
        });
    }

    public function statuses()
    {
       // 一对多自动使用类的名称加 id 的下划线命名作为关联字段
       // 这里自动使用 user_id 作为关联 Status Eloquent 对象的属性，和 user 对象的 id 相匹配
       // 第二个参数可选 Status 对象的关联值，第三个参数可选 user 对象的关联值(不使用 ID)
       return $this->hasMany(Status::class);
    }

    // 取出当前用户的所有微博
    public function feed()
    {
      return $this->statuses()
             ->orderBy('created_at', 'desc');
    }
}
