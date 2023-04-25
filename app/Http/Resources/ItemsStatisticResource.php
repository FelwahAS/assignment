<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemsStatisticResource extends JsonResource
{
    /**
     * The statistic type.
     *
     * @var string
     */
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'total_items'                   => $this->when(in_array($this->type, ['total_items','all']),Item::getTotalCount()),
            'average_price'                 => $this->when(in_array($this->type, ['average_price','all']),Item::getAveragePrice()),
            'highest_website'               => $this->when(in_array($this->type, ['highest_website','all']),Item::getHighestPriceWebsite()),
            'total_price_current_month'     => $this->when(in_array($this->type, ['total_price_current_month','all']),Item::getTotalPriceCurrentMonth())
        ];

    }
}
