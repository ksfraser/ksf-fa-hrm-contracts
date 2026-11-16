<?php

declare(strict_types=1);

namespace Ksfraser\FrontAccounting\HRM\Contracts\App;

use ksfraser\FrontAccounting\Common\App\AbstractAppShell;
use ksfraser\FrontAccounting\Common\Menu\FAModuleMenu;
use Ksfraser\FrontAccounting\HRM\Contracts\Controller\ContractsTabController;

class ContractsAppShell extends AbstractAppShell
{
    public function __construct()
    {
        parent::__construct('contracts', 'index.php', 'view', 'hrm_contracts');

        $this->add_module(_("Contracts"));

        $menu = new FAModuleMenu(
            'modules/ksf_FA_HRM_Contracts/index.php',
            'view',
            ''
        );

        $menu->addItem('hrm_contracts', _("Contracts"), MENU_INQUIRY)
             ->registerWithApp($this, 'SA_CONTRACTS_VIEW');

        $this->add_extensions();
    }
}
