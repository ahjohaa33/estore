<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class Collections extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $wantedMap = Category::query()
            ->get(['name', 'category_image']) // change 'name' if your column is different
            ->mapWithKeys(function ($c) {
                $key = strtolower(trim($c->name));
                return [$key => [
                    'label' => $c->name,                  // keep original casing for display
                    'image' => $c->category_image,        // store path or full URL
                ]];
            });

        // 2) Make the list of normalized names we want to count
        $wantedKeys = $wantedMap->keys()->values()->all();

        // 3) Get product counts for those categories (case-insensitive), plus 'uncategorized'
        $raw = Products::selectRaw("LOWER(TRIM(COALESCE(category, 'uncategorized'))) as k, COUNT(*) as total")
            ->whereIn(DB::raw("LOWER(TRIM(COALESCE(category, 'uncategorized')))"),
                array_merge($wantedKeys, ['uncategorized'])
            )
            ->groupBy('k')
            ->pluck('total', 'k'); // e.g. ['men'=>42, 'caps'=>5, 'uncategorized'=>3]

        // 4) Build final response: each category gets its image + count (zero-filled)
        $result = $wantedMap->map(function ($meta, $k) use ($raw) {
                return [
                    'category'       => $meta['label'],
                    'count'          => (int) ($raw[$k] ?? 0),
                    'category_image' => $meta['image'],
                ];
            })
            // 5) Optionally append an 'Uncategorized' row at the end
          
            ->values();
        return view('components.collections')->with('result', $result);
    }
}
