<?php
declare(strict_types=1);

namespace Modules\Lender;

use App\Modular\ModuleServiceProvider as BaseProvider;

class ModuleServiceProvider extends BaseProvider
{
    protected function getRouteFiles(): array
    {
        return [
            __DIR__ . '/Http/Routes/api.php',
        ];
    }
}
