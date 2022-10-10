<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['campaign_id', 'prize_id', 'account', 'revealed_at'];

    protected $dates = [
        'revealed_at',
    ];

    public static function filter()
    {
        $query = self::query();
        $campaign = Campaign::find(session('activeCampaign'));

        self::filterDates($query, $campaign);

        $query->with('prize')
            ->when(request()->search and request()->criteria == 'account', function($query){
                $query->where('account', 'like', request()->search.'%');
            })
            ->when(request()->search and request()->criteria == 'prize', function($query) {
                $query->where('prize_id', request()->search);
            })
            ->when(request()->search and request()->criteria == 'hour_greater', function($query) {
                $query->whereRaw('HOUR(revealed_at) >= '.request()->search);
            })
            ->when(request()->search and request()->criteria == 'hour_less', function($query) {
                $query->whereRaw('HOUR(revealed_at) <= '.request()->search);
            })
            ->where('campaign_id', $campaign->id);

        return $query;
    }

    private static function filterDates($query, $campaign): void
    {
        // $query->when(($data = request('date_start')) || ($data = Carbon::now()->subDays(6)), function($query) use ($data, $campaign) {
        //     $data = Carbon::parse($data)->setTimezone($campaign->timezone)->toDateTimeString();
        //     $query->where('revealed_at', '>=', $data);
        // })
        // ->when(($data = request('date_end')) || ($data = Carbon::now()), function($query) use ($data) {
        //     $query->where('revealed_at', '<=', $data);
        // });
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}
