<?php
declare(strict_types=1);

namespace Modules\Lender\Models\Relations;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Lender\Models\Address;

/**
 * @property-read Address|null $address
 */
trait LenderRelations
{
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
