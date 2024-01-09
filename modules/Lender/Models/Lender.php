<?php
declare(strict_types=1);

namespace Modules\Lender\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Common\Eloquent\Model;

/**
 * @property int|null $id
 * @property string|null $uid
 * @property string|null $name
 * @property string|null $logo
 * @property bool|null $is_active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 */
class Lender extends Model
{
    use SoftDeletes;

    /**
     * Define table name
     * @var string
     */
    protected $table = 'lenders';

    /**
     * Define hidden columns
     * @var string[]
     */
    protected $hidden = [
        'id',
        'deleted_at',
    ];

    /**
     * Define fillable columns
     * @var string[]
     */
    protected $fillable = [
        'name',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool'
    ];
}
