<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'seller_id',
        'bidder_id',
        'description',
        'min_bid',
        'bid_step',
        'current_bid',
        'is_paid',
        'is_received',
        'location',
        'condition',
        'starting_datetime',
        'ending_datetime',
        'photo'
    ];

    protected $casts = [
        'starting_datetime' => 'datetime',
        'ending_datetime' => 'datetime',
    ];

    public function scopeFilter($query, array $filters) 
    {
        if ($filters['search'] ?? false) {
            $query->where(function ($query) use ($filters) {
                $query->where('title', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('location', 'like', '%' . $filters['search'] . '%');
            });
        }
        if ($filters['current_min_bid'] ?? false) {
            $query->where(function ($query) {
                $query->where('current_bid', '>=', request('current_min_bid'))
                ->orWhere(function ($query) {
                    $query->whereNull('current_bid')->where('min_bid', '>=', request('current_min_bid'));
                });
            });
        }
        if ($filters['current_max_bid'] ?? false) {
            $query->where(function ($query) {
                $query->where('current_bid', '<=', request('current_max_bid'))
                ->orWhere(function ($query) {
                    $query->whereNull('current_bid')->where('min_bid', '<=', request('current_max_bid'));
                });
            });
        }

        if ($filters['condition'] ?? false) {
            $query->where('condition', '=', request('condition'));
        }
        if ($filters['auction_status'] ?? false) {
            
            switch ($filters['auction_status']) {
                case 'on_auction':
                    $query->where('starting_datetime', '<=', now())->where('ending_datetime', '>', now());
                    break;
                case 'auction_ended':
                    $query->where('ending_datetime', '<=', now());
                    break;
                case 'future_auction':
                    $query->where('starting_datetime', '>=', now());
                    break;
            }
            
        }
        
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function getStatus()
    {
        $mytime = Carbon::now();

        if ($this->ending_datetime > $this->starting_datetime) {

            if (($mytime > $this->starting_datetime) && ($mytime < $this->ending_datetime))

                return "on_auction";

            elseif ($mytime < $this->starting_datetime)

                return "future_auction";

            elseif ($mytime > $this->ending_datetime)
                return "auction_ended";
            else {
                return "date_incorrect";
            }
        }
        else {
            return "date_incorrect";
        }
    }
}
