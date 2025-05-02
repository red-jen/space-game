<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens/*Allows users to authenticate via API tokens (used for API authentication with Laravel Sanctum).*/
    , HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

//     will hide this attributes when i transfer the object to json format 
//     $user = User::find(1);
// return response()->json($user);

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // will that is obviouse it ensure the verified at to be treated as an time object 
    //and hash the password automaticlly when stored 

    /**
     * Tournaments created by this user.
     */
    public function createdTournaments()
    {
        return $this->hasMany(Tournament::class, 'created_by');
    }

    /**
     * Tournaments where this user is a player.
     */
    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'tournament_player', 'player_id', 'tournament_id')
                    ->withPivot('status', 'registered_at')
                    ->withTimestamps();
    }

    /**
     * Matches where this user is player1.
     */
    public function matchesAsPlayer1()
    {
        return $this->hasMany(Match::class, 'player1_id');
    }

    /**
     * Matches where this user is player2.
     */
    public function matchesAsPlayer2()
    {
        return $this->hasMany(Match::class, 'player2_id');
    }

    /**
     * Get all matches for this player.
     */
    public function matches()
    {
        return Match::where('player1_id', $this->id)
                   ->orWhere('player2_id', $this->id);
    }

    /**
     * Matches won by this user.
     */
    public function wonMatches()
    {
        return $this->hasMany(Match::class, 'winner_id');
    }

    /**
     * Scores recorded for this user.
     */
    public function scores()
    {
        return $this->hasMany(Score::class, 'player_id');
    }
}