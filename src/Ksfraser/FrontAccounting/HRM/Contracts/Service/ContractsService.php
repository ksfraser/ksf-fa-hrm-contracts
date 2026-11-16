<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\HRM\Contracts\Service;
use Ksfraser\FrontAccounting\HRM\Contracts\DTO\ContractsDTO;
use Ksfraser\FrontAccounting\HRM\Contracts\Repository\ContractsRepository;
use ksfraser\RelatedTo\DTO\RelatedRecordDto;
final class ContractsService {
    private $repo;
    public function __construct(?ContractsRepository $repo = null) { $this->repo = $repo ?? new ContractsRepository(); }
    public function resolveById(int $id, ?RelatedRecordDto $dto = null): array {
        $row = $this->repo->findById($id);
        if ($row === null) {
            return array('dto' => new RelatedRecordDto('hrm_contract', '0', 'hrm_contract', '0', null), 'fields' => $this->fieldMap(), 'labels' => $this->labelMap(), 'url' => '#', 'label' => _('Contract #') . (string) $id);
        }
        $r = ContractsDTO::fromArray($row);
        $dto = $dto ?? new RelatedRecordDto('hrm_contract', (string) $r->contract_id, 'hrm_contract', (string) $r->contract_id, null);
        return array(
            'dto' => $dto,
            'fields' => array(
                'contract_id' => (string) $r->contract_id,
                'person_id' => $r->person_name,
                'contract_type' => $r->contract_type,
                'reference_no' => $r->reference_no,
                'start_date' => $r->start_date,
                'end_date' => $r->end_date,
                'renewal_date' => $r->renewal_date,
                'status' => $r->status,
            ),
            'labels' => $this->labelMap(),
            'url' => '/modules/ksf_FA_HRM_Contracts/pages/contracts_form.php?action=edit&contract_id=' . $r->contract_id,
            'label' => $r->getDisplayLabel(),
        );
    }
    public function listForPerson(int $personId): array {
        $rows = $this->repo->listForPerson($personId);
        $results = array();
        foreach ($rows as $row) {
            $r = ContractsDTO::fromArray($row);
            $results[] = array(
                'id' => $r->contract_id,
                'dto' => new RelatedRecordDto('hrm_contract', (string) $r->contract_id, 'hrm_contract', (string) $r->contract_id, null),
                'fields' => array(
                    'contract_id' => (string) $r->contract_id,
                    'person_id' => $r->person_name,
                    'contract_type' => $r->contract_type,
                    'reference_no' => $r->reference_no,
                    'start_date' => $r->start_date,
                    'end_date' => $r->end_date,
                    'renewal_date' => $r->renewal_date,
                    'status' => $r->status,
                ),
                'labels' => $this->labelMap(),
                'url' => '/modules/ksf_FA_HRM_Contracts/pages/contracts_form.php?action=edit&contract_id=' . $r->contract_id,
                'label' => $r->getDisplayLabel(),
            );
        }
        return $results;
    }
    public function listAll(): array {
        $rows = $this->repo->findAll();
        $results = array();
        foreach ($rows as $row) {
            $r = ContractsDTO::fromArray($row);
            $results[] = array(
                'id' => $r->contract_id,
                'fields' => array(
                    'contract_id' => (string) $r->contract_id,
                    'person_name' => $r->person_name,
                    'contract_type' => $r->contract_type,
                    'reference_no' => $r->reference_no,
                    'start_date' => $r->start_date,
                    'end_date' => $r->end_date,
                    'status' => $r->status,
                    'url' => '/modules/ksf_FA_HRM_Contracts/pages/contracts_form.php?action=edit&contract_id=' . $r->contract_id,
                ),
            );
        }
        return $results;
    }
    public function insertContract(array $data): int {
        return $this->repo->insertContract($data);
    }
    public function updateState(int $contractId, string $status, string $renewalDate = null, string $notes = null): void {
        $this->repo->updateState($contractId, $status, $renewalDate, $notes);
        contract_state_changed((string) $contractId, '', $status, array('notes' => $notes));
    }
    public function fieldMap(): array { return $this->labelMap(); }
    public function labelMap(): array {
        return array(
            'contract_id' => _('Contract ID'),
            'person_id' => _('Employee'),
            'contract_type' => _('Contract Type'),
            'reference_no' => _('Reference No'),
            'start_date' => _('Start Date'),
            'end_date' => _('End Date'),
            'renewal_date' => _('Renewal Date'),
            'status' => _('Status'),
        );
    }
    public function getStateTransitions(string $currentState): array {
        $transitions = array(
            'draft' => array('active' => _('Activate')),
            'active' => array('expired' => _('Expire'), 'terminated' => _('Terminate')),
        );
        return isset($transitions[$currentState]) ? $transitions[$currentState] : array();
    }
    public function isAllowedTransition(string $fromState, string $toState): bool {
        $transitions = $this->getStateTransitions($fromState);
        return isset($transitions[$toState]);
    }
}
