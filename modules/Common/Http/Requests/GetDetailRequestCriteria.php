<?php
declare(strict_types=1);

namespace Modules\Common\Http\Requests;

class GetDetailRequestCriteria
{
    /**
     * @template T
     * @param T $model
     * @return T
     */
    public function apply($model)
    {
        return $model;
    }
}
