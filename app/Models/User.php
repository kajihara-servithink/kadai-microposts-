<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function microposts()
    {
        return $this->hasMany(Micropost::class);
    }
    // このユーザーに関係するモデルの件数をロードする。
    public function loadRelationshipCounts()
    {
        $this->loadCount('microposts');
    }
    // このユーザーがフォロー中のユーザー。（Userモデルとの関係を定義）
    public function followings()
    {
        return $this->belongsToMany(User::class, 'user_follow', 'user_id','follow_id' )->withTimestamps();
    }
    // このユーザーをフォロー中のユーザー。（Userモデルとの関係を定義）

     public function followers()
     {
        return $this->belongsToMany(User::class, 'user_follow', 'follow_id','user_id' )->withTimestamps();
     }
    //   $userIdで指定されたユーザーをフォローする。
     public function follow(int $userId)
     {
         $exist = $this->is_following($userId);
         $its_me = $this->id == $userId;
         
         if ($exist || $its_me){
             return false;
         }else{
             $this->followings()->attach($userId);
             return true;
         }
     }
    //  $userIdで指定されたユーザーをアンフォローする。
    public function unfollow(int $userId)
    {
        $exist = $this->is_following($userId);
        $its_me = $this->id == $userId;
        
        if ($exist && !$its_me){
            $this->followings()->detach($userId);
            return true;
        }else {
            return false;
        }
    }
    // 指定された$userIdのユーザーをこのユーザーがフォロー中であるか調べる。フォロー中ならtrueを返す。
    public function is_following(int $userId)
    {
        return $this->followings()->where('follow_id',$userId)->exists();
    }
}
