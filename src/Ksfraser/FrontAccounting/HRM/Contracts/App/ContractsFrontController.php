<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\HRM\Contracts\App;

use ksfraser\FrontAccounting\Common\App\AbstractFrontController;

class ContractsFrontController extends AbstractFrontController
{
    public function __construct(
        ContractsAppShell $appShell,
        string $fallbackSecurityArea,
        string $path_to_root
    ) {
        parent::__construct($appShell, $fallbackSecurityArea, $path_to_root);
    }
}
