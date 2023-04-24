<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /*
     * I have elected to include the TLD as part of the unique identifier of a website
     * (eg. amazon.sa will be considered different from amazon.com)
     * */
    public function getWebsiteHostAttribute(){

        $url = parse_url($this->url);
        return $url["host"];

    }

    public static function getStatistics(){
        //====== 1. total items count ======
        $statistics['total_items'] = Item::count();

        //====== 2. average price of an item ======
        $statistics['average_price'] = Item::avg('price');

        //====== 3. the website with the highest total price of its items ======
        $websitesTotals = Item::all('url','price')->groupBy('website_host')->map(function($website_items, $website) {
            return [
                'website'   => $website,
                'total'     => $website_items->sum('price')
            ];
        });
        $statistics['highest_website'] = $websitesTotals->firstWhere('total', $websitesTotals->max('total'))["website"];

        //====== 4. total price of items added this month ======
        $statistics['total_price_current_month'] = Item::select('price')->whereMonth('created_at', Carbon::now()->month)->sum('price');

        return $statistics;
    }
}
