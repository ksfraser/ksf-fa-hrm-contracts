<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\HRM\Contracts\App;

use ksfraser\FrontAccounting\Common\App\AbstractAppShell;
use ksfraser\FrontAccounting\Common\App\TabRegistration;

class ContractsAppShell extends AbstractAppShell
{
    public function __construct()
    {
        parent::__construct('contracts', 'index.php', 'view', 'hrm_contracts');

        $this->registerTab(new TabRegistration(
            'hrm_contracts',
            'Contracts',
            'SA_CONTRACTS_VIEW',
            null,
            10,
            0,
            null,
            null,
            array()
        ));
    }
}
