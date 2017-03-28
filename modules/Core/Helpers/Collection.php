<?php
/**
 * Created by PhpStorm.
 * User: vdjkelly
 * Date: 3/15/2017
 * Time: 8:12 p.m.
 */

namespace Modules\Core\Helpers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection as BaseCollection;
use Modules\Core\Providers\AppServiceProvider;

/**
 * Class Collection
 * @package App\Helpers
 */
class Collection extends BaseCollection
{
    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($value) {
            if ($value instanceof AppServiceProvider) {
                return $value->json()->getAttributes();
            }

            return $value instanceof Arrayable ? $value->toArray() : $value;

        }, $this->items);
    }
}
