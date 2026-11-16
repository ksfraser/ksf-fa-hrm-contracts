<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\HRM\Contracts\DTO;
final class ContractsDTO {
    public $contract_id;
    public $person_id;
    public $person_name;
    public $contract_type;
    public $title;
    public $reference_no;
    public $start_date;
    public $end_date;
    public $renewal_date;
    public $status;
    public $file_path;
    public $notes;
    public $created_at;
    public $updated_at;
    public function __construct(
        int $contract_id,
        int $person_id = 0,
        string $person_name = '',
        string $contract_type = '',
        string $title = '',
        string $reference_no = '',
        string $start_date = '',
        string $end_date = '',
        string $renewal_date = '',
        string $status = 'active',
        string $file_path = '',
        string $notes = '',
        string $created_at = '',
        string $updated_at = ''
    ) {
        $this->contract_id = $contract_id;
        $this->person_id = $person_id;
        $this->person_name = $person_name;
        $this->contract_type = $contract_type;
        $this->title = $title;
        $this->reference_no = $reference_no;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->renewal_date = $renewal_date;
        $this->status = $status;
        $this->file_path = $file_path;
        $this->notes = $notes;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function getDisplayLabel(): string {
        if ($this->title !== '') {
            return sprintf(_('%s — %s'), $this->title, $this->reference_no ?: $this->contract_type);
        }
        return _('Contract #') . (string) $this->contract_id;
    }
    public function toArray(): array {
        return array(
            'contract_id' => $this->contract_id,
            'person_id' => $this->person_id,
            'person_name' => $this->person_name,
            'contract_type' => $this->contract_type,
            'title' => $this->title,
            'reference_no' => $this->reference_no,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'renewal_date' => $this->renewal_date,
            'status' => $this->status,
            'file_path' => $this->file_path,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        );
    }
    public static function fromArray(array $data): self {
        return new self(
            (int) ($data['contract_id'] ?? 0),
            (int) ($data['person_id'] ?? 0),
            (string) ($data['person_name'] ?? ''),
            (string) ($data['contract_type'] ?? ''),
            (string) ($data['title'] ?? ''),
            (string) ($data['reference_no'] ?? ''),
            (string) ($data['start_date'] ?? ''),
            (string) ($data['end_date'] ?? ''),
            (string) ($data['renewal_date'] ?? ''),
            (string) ($data['status'] ?? 'active'),
            (string) ($data['file_path'] ?? ''),
            (string) ($data['notes'] ?? ''),
            (string) ($data['created_at'] ?? ''),
            (string) ($data['updated_at'] ?? '')
        );
    }
}
