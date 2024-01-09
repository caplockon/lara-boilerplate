<?php
declare(strict_types=1);

namespace Modules\Common\Facades;

use Illuminate\Support\Facades\DB as Base;

class DB extends Base
{
    /**
     * Randomly generating uid in the database
     * @return \Illuminate\Contracts\Database\Query\Expression
     */
    public static function uid()
    {
        return Base::raw('(gen_random_uuid ())');
    }
}
