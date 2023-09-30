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
        'location',
        'status'
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

    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function friends()
    {
        return Friend::select('friends.id', 'friends.user_id1', 'friends.user_id2', 'friends.accepted', 'user1.name as user1_name', 'user2.name as user2_name')
            ->where(function ($query) {
                $query->where('user_id1', $this->id)
                      ->orWhere('user_id2', $this->id);
            })
            ->where('accepted', true)
            ->join('users as user1', 'friends.user_id1', '=', 'user1.id')
            ->join('users as user2', 'friends.user_id2', '=', 'user2.id');
    }

    public function request_friends()
    {
        $user_id = $this->id;

        return Friend::select('friends.id', 'friends.user_id1', 'friends.user_id2', 'friends.accepted', 'user1.name as user_name')
            ->Where('user_id2', $user_id)
            ->where('accepted', 0)
            ->join('users as user1', 'friends.user_id1', '=', 'user1.id')
            ->get();
    }
    public function sentFriendRequests()
    {
        return $this->hasMany(Friend::class, 'user_id1', 'id')->where('accepted', 0);
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(Friend::class, 'user_id2', 'id')->where('accepted', 0);
    }
}
