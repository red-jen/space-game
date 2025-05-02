<?php
// app/Models/Tournament.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

  
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'location',
        'max_players',
        'status',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * The user who created this tournament.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The players registered for this tournament.
     */
    public function players()
    {
        return $this->belongsToMany(User::class, 'tournament_player', 'tournament_id', 'player_id')
                    ->withPivot('status', 'registered_at')
                    ->withTimestamps();
    }

    /**
     * The matches in this tournament.
     */
    public function matches()
    {
        return $this->hasMany(Match::class);
    }

    /**
     * Check if tournament is full.
     */
    public function isFull()
    {
        if (!$this->max_players) {
            return false;
        }
        
        return $this->players()->count() >= $this->max_players;
    }
}