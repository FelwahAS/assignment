<?php

namespace App\Console\Commands;

use App\Http\Resources\ItemsStatisticResource;
use App\Models\Item;
use Illuminate\Console\Command;

class GetStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:statistics {--type=all : an option to display a specific statistic}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command displays four different types of statistics including:
        [total_items]               => Total items count 
        [average_price]             => Average price of an item
        [highest_website]           => The website with the highest total price of its items 
        [total_price_current_month] => Total price of items added this month
        
        To display a specific type you could pass the string between brackets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $statistics = (new ItemsStatisticResource($this->option('type')))->resolve();

        if(!$statistics){
            $this->error(trans('item.errors.invalid_type'));
            return;
        }

        foreach($statistics as $key => $value)
            $result[] = [trans('item.statistic_types.'.$key), $value];

        $this->table([trans('item.statistic'), trans('item.result')], $result);

    }
}
