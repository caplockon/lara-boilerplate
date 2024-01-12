<?php
declare(strict_types=1);

namespace Modules\Lender\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Common\Eloquent\Model;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'street_1',
        'street_2',
        'city',
        'state',
        'zipcode',
        'county',
        'country',
    ];

    protected $hidden = [
        'id',
        'deleted_at',
        'addressable_id',
        'addressable_type',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
