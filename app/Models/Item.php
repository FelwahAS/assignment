<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Returns the TLD of an item.
     * note: I have elected to include the TLD as part of the unique identifier of a website
     * (eg. amazon.sa will be considered different from amazon.com)
     *
     * @return string
     */
    public function getWebsiteHostAttribute() {

        $url = parse_url($this->url);
        return $url["host"];

    }

    /**
     * Returns the total items count.
     *
     * @return int
     */
    public static function getTotalCount(){

        return Item::count();

    }

    /**
     * Returns the average price of an item.
     *
     * @return float
     */
    public static function getAveragePrice(){

        return number_format(Item::avg('price'),2);

    }

    /**
     * Returns the website with the highest total price of its items
     *
     * @return string
     */
    public static function getHighestPriceWebsite(){

        $websitesTotals = Item::all('url','price')->groupBy('website_host')->map(function($website_items, $website) {
            return [
                'website'   => $website,
                'total'     => $website_items->sum('price')
            ];
        });

        return $websitesTotals->firstWhere('total', $websitesTotals->max('total'))["website"];

    }

    /**
     * Returns the total price of items added in the current month
     *
     * @return float
     */
    public static function getTotalPriceCurrentMonth(){

        return number_format(Item::select('price')->whereMonth('created_at', Carbon::now()->month)->sum('price'),2);

    }
}
