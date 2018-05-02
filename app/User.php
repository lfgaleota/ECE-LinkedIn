<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * App\User
 *
 * @property int $user_id
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $email
 * @property string|null $password
 * @property string $role
 * @property string $birth_date
 * @property string|null $title
 * @property string|null $cv_url
 * @property int|null $photo_id
 * @property int|null $cover_id
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCoverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCvUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhotoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    public $timestamps = true;

    protected $primaryKey = 'user_id';
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password',
        'role',
        'birth_date',
        'title',
        'cv_url',
        'photo_id',
        'cover_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be validated and their respective format
     */
    const validation = [
        'username' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'password' => 'required|string|min:6|confirmed',
        'birth_date' => 'required|date',
    ];

    public function getPhoto()
    {
        return $this->hasOne('Post', 'photo_id');
    }

    public function getCover()
    {
        return $this->hasOne('Post', 'cover_id');
    }

    public function getConversations()
    {
        return $this->belongsToMany('Conversation', 'conversation_member', 'user_id', 'conversation_id');
    }

    public function getFriendRequests()
    {
        return $this->hasMany('FriendRequest', 'invited_id');
    }

    public function getNotifications()
    {
        return $this->hasMany('Notification');
    }

    public function getName() {
        return $this->name . " " . $this->surname;
    }

    public function selectorNetworkMembers()
    {
        /*return DB::table( 'users AS user1' )
            ->join( 'networks', 'user1.user_id', '=', 'networks.user1_id' )
            ->join( 'users AS user2', 'user2.user_id', '=', 'networks.user2_id' )
            ->where( 'user1.user_id', '=', $this->user_id )
            ->orWhere( 'user2.user_id', '=', $this->user_id );*/
        return User::join( 'networks', 'users.user_id', '=', 'networks.user1_id' )
            ->join( 'users AS user2', 'user2.user_id', '=', 'networks.user2_id' )
            ->where( 'users.user_id', '=', $this->user_id )
            ->leftJoin( 'friendships', function ( $join ) {
                $join->on('friend2_id', '=', 'user2.user_id')
                ->on('friend1_id', '=', 'users.user_id');
            })
            ->addSelect( '*' )
            ->addSelect( 'friend2_id AS isFriendOf' );
    }

    public function selectorFriends()
    {
        return User::join( 'friendships', 'users.user_id', '=', 'friendships.friend1_id' )
            ->join( 'users AS user2', 'user2.user_id', '=', 'friendships.friend2_id' )
            ->where( 'users.user_id', '=', $this->user_id );
    }

    public function selectorNetworkMember( User $user ) {
        return DB::table( 'networks' )
            ->where(function ($query) use ($user) {
                $query->where('user1_id', '=', $this->user_id)->where('user2_id', '=', $user->user_id);
            });
    }

    public function selectorFriendship( User $user ) {
        return DB::table( 'friendships' )
            ->where(function ($query) use ($user) {
                $query->where('friend1_id', '=', $this->user_id)->where('friend2_id', '=', $user->user_id);
            });
    }

    public function selectorTimeline()
    {
        return Post::join( 'networks', function ( $join ) {
            $join->on( 'networks.user1_id', '=', 'posts.author_id' )->orOn( 'networks.user2_id', '=', 'posts.author_id' );
        })->where(function ($query) {
            $query->where( 'networks.user1_id', '=', $this->user_id )
                ->orWhere( 'networks.user2_id', '=', $this->user_id );
        })->where( function( $query ) {
            $query->where('visibility', '=',  'PUBLIC' )
                ->orWhere(function ($query) {
                    $query->where('visibility', '=', 'NETWORKMEMBERS')->where(function ($query) {
                        $query->where( 'user1_id', '=', $this->user_id )
                            ->orWhere( 'user2_id', '=', $this->user_id );
                    });
                })->orWhere(function ($query) {
                    $query->where('visibility', '=', 'FRIENDS')
                        ->whereExists(function ($query) {
                            $query->select( DB::raw( '*' ) )
                                ->from( 'friendships' )
                                ->where(function ($query) {
                                    $query->where('friendships.friend1_id', '=', $this->user_id)->where('friendships.friend2_id', '=', 'posts.author_id');
                                })->orWhere(function ($query) {
                                    $query->where('friendships.friend2_id', '=', $this->user_id)->where('friendships.friend1_id', '=', 'posts.author_id');
                                });
                        });
                })->orWhere(function ($query) {
                    $query->where('visibility', '=', 'RESTRICTED')
                        ->whereExists(function ($query) {
                            $query->select( DB::raw( '*' ) )
                                ->from( 'post_visibilities' )
                                ->where( 'post_visibilities.post_id', '=', 'posts.post_id' )
                                ->where( 'post_visibilities.user_id', '=', $this->user_id );
                        });
                });
        });
    }

    public function getNetworkMembers()
    {
        return $this->selectorNetworkMembers()->get();
        //return DB::select('SELECT * FROM users AS user1 JOIN networks ON user1.user_id = networks.user1_id JOIN users AS user2 ON user2.user_id = networks.user2_id WHERE user1.user_id = :id OR user2.user_id = :id;', ['id' => $this->user_id]);
    }

    public function getFriends()
    {
        return $this->selectorFriends()->get();
    }

    public function getTimeline()
    {
        return $this->selectorTimeline()->get();
    }

    public function isSame( User $user ) {
        return $this->user_id === $user->user_id;
    }

    public function isInNetwork( User $user ) {
        return $this->selectorNetworkMember( $user )->first() !== null;
    }

    public function isFriend( User $user ) {
        return $this->selectorFriendship( $user )->first() !== null;
    }

    public function hasFriendOf() {
        return array_key_exists('isFriendOf',$this->toArray());
    }

    public function askedFriend(User $user ) {
        $status = DB::table( 'friend_requests' )
            ->where('invited_id', '=', $user->user_id)
            ->where('requester_id', '=', $this->user_id)
            ->first();
        return $status !== null;
    }

   public function wasAskedFriend(User $user ) {
        $status = DB::table( 'friend_requests' )
            ->where('invited_id', '=', $this->user_id)
            ->where('requester_id', '=', $user->user_id)
            ->first();
        return $status !== null;
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function addToNetwork(User $user ) {
        if( $this->isSame( $user ) ) {
            throw new \Exception( "Cannot add yourself to your network." );
        }
        $status = DB::table( 'networks' )->insert([
            'user1_id' => $this->user_id,
            'user2_id' => $user->user_id
        ]);
        $status &= DB::table( 'networks' )->insert([
            'user2_id' => $this->user_id,
            'user1_id' => $user->user_id
        ]);
        return $status;
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function addFriend(User $user ) {
        if( $this->isSame( $user ) ) {
            throw new \Exception( "Cannot add yourself as friend." );
        }
        if( !$this->isInNetwork( $user ) ) {
            $this->addToNetwork( $user );
        }

        $status = DB::table( 'friendships' )->insert([
            'friend1_id' => $this->user_id,
            'friend2_id' => $user->user_id
        ]);
        $status &= DB::table( 'friendships' )->insert([
            'friend2_id' => $this->user_id,
            'friend1_id' => $user->user_id
        ]);


        return $status;
    }

       public function sendFriendRequest(User $user ) {
        //send friend request
        //check if selected user is not the same user
         if( $this->isSame( $user ) ) {
            throw new \Exception( "Cannot add yourself as friend." );
        }
        //create request
     $status = DB::table( 'friend_requests' )->insert([
            'requester_id' => $this->user_id,
            'invited_id' => $user->user_id
        ]);
        return $status;
    }

        public function delFriendRequest(User $user ) {
        //delete friend request

        //create request
     $status = DB::table( 'friend_requests' )
      ->where(function ($query) use ($user) {
         $query->where('requester_id', '=', $this->user_id)->where('invited_id', '=', $user->user_id);
    })->orWhere(function ($query) use ($user) {
                $query->where('invited_id', '=', $this->user_id)->where('requester_id', '=', $user->user_id);
            })->delete();
        return $status;
    }
    /**
     * @param User $user
     * @return int
     * @throws \Exception
     */
    public function removeFromNetwork(User $user ) {
        if( $this->isSame( $user ) ) {
            throw new \Exception( "Illegal removing oneself from his network." );
        }
        if( $this->isFriend( $user ) ) {
            $this->removeFriend( $user, true );
        }

        return DB::table( 'networks' )
            ->where(function ($query) use ($user) {
                $query->where('user1_id', '=', $this->user_id)->where('user2_id', '=', $user->user_id);
            })->orWhere(function ($query) use ($user) {
                $query->where('user2_id', '=', $this->user_id)->where('user1_id', '=', $user->user_id);
            })->delete();
    }

    /**
     * @param User $user
     * @param bool $skipNetwork
     * @return int
     * @throws \Exception
     */
    public function removeFriend(User $user, $skipNetwork = true ) {
        if( $this->isSame( $user ) ) {
            throw new \Exception( "Illegal removing oneself as friend." );
        }
        if( !$skipNetwork && !$this->isInNetwork( $user ) ) {
            $this->removeFromNetwork( $user );
        }

        return DB::table( 'friendships' )
            ->where(function ($query) use ($user) {
                $query->where('friend1_id', '=', $this->user_id)->where('friend2_id', '=', $user->user_id);
            })->orWhere(function ($query) use ($user) {
                $query->where('friend2_id', '=', $this->user_id)->where('friend1_id', '=', $user->user_id);
            })->delete();
    }
}