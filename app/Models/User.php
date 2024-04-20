<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;


/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $username
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $role
 * @property string|null $path_image
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Anggota|null $anggota
 * @property-read string $full_url_path_image
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Petugas|null $petugas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePathImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'path_image',
        'role'
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
    ];

    /**
     *
     * @var array<string>
     */
    protected $appends = ['full_url_path_image'];

    /**
     * Mengambil full url path image
     * @return string
     */
    public function getFullUrlPathImageAttribute(): string
    {
        return $this->path_image ?
            '/' . $this->path_image :
            asset('modernize/package/dist/images/profile/user-1.jpg');
    }

    /**
     * Mengambil warna berdasarkan role
     *
     * @param string $role
     * @return string
     */
    public function getRoleColor($role)
    {
        $color = '';
        switch ($role) {
            case 'superadmin':
                $color = 'warning';
                break;
            case 'petugas':
                $color = 'primary';
                break;
            case 'anggota':
                $color = 'secondary';
                break;
            default:
                $color = '';
                break;
        }

        return $color;
    }

    /**
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->hasRole(['superadmin']);
    }

    /**
     * @return bool
     */
    public function canBeImpersonated()
    {
        return $this->hasRole([
            'anggota',
            'petugas',
        ]);
    }

    /**
     * Send a password reset notification to the user.
     *
     * @param  string  $token
     */
    public function sendPasswordResetNotification($token): void
    {
        $url = url('/') . '/reset-password/' . $token . '?email=' . $this->email;

        $this->notify(new CustomResetPasswordNotification($url, $this));
    }

    /**
     * Get the petugas associated with the User
     *
     * @return HasOne<Petugas>
     */
    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'user_id', 'id');
    }

    /**
     * Get the anggota associated with the User
     *
     * @return HasOne<Anggota>
     */
    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'user_id', 'id');
    }
}
