<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemsStatisticResource;
use App\Models\Item;
use League\CommonMark\CommonMarkConverter;

class ItemController extends Controller
{
    protected $converter;

    public function __construct()
    {

        $this->converter = new CommonMarkConverter(['html_input' => 'escape', 'allow_unsafe_links' => false]);

    }

    public function index()
    {

        return new ItemCollection(Item::all());

    }

    public function store(ItemRequest $request)
    {

        $item = Item::create([
            'name'          => $request->get('name'),
            'price'         => $request->get('price'),
            'url'           => $request->get('url'),
            'description'   => $this->converter->convert($request->get('description'))->getContent(),
        ]);

        return new ItemResource($item);

    }

    public function show(Item $item)
    {

        return new ItemResource($item);

    }

    public function update(ItemRequest $request, Item $item)
    {

        $item->update([
            'name'          => $request->get('name'),
            'url'           => $request->get('url'),
            'price'         => $request->get('price'),
            'description'   => $this->converter->convert($request->get('description'))->getContent()
        ]);

        return new ItemResource($item);

    }

    public function statistics()
    {

        return new ItemsStatisticResource('all');

    }
}
