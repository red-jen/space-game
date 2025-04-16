
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tournament_id',
        'player1_id',
        'player2_id',
        'scheduled_at',
        'status',
        'winner_id',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    /**
     * The tournament this match belongs to.
     */
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * The first player in this match.
     */
    public function player1()
    {
        return $this->belongsTo(User::class, 'player1_id');
    }

    /**
     * The second player in this match.
     */
    public function player2()
    {
        return $this->belongsTo(User::class, 'player2_id');
    }

    /**
     * The winner of this match.
     */
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    /**
     * The user who created this match.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * The scores for this match.
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Get the score for a specific player.
     */
    public function getPlayerScore($playerId)
    {
        return $this->scores()->where('player_id', $playerId)->first();
    }
}

// app/Models/Score.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'match_id',
        'player_id',
        'score',
        'recorded_by',
    ];

    /**
     * The match this score belongs to.
     */
    public function match()
    {
        return $this->belongsTo(Match::class);
    }

    /**
     * The player this score belongs to.
     */
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }

    /**
     * The user who recorded this score.
     */
    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}