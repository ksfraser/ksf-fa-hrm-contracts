<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\HRM\Contracts\Repository;
final class ContractsRepository {
    private string $table = 'hrm_contracts';
    public function findAll(): array {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return array(); }
        $sql = "SELECT c.*, p.name AS person_name FROM " . TB_PREF . $this->table . " c"
            . " LEFT JOIN " . TB_PREF . "crm_persons p ON c.person_id = p.id"
            . " ORDER BY c.created_at DESC, c.contract_id DESC";
        $result = db_query($sql, 'Could not load contracts');
        if ($result === false) { return array(); }
        $rows = array();
        while (($row = db_fetch_assoc($result)) !== false && $row !== null) { $rows[] = $row; }
        return $rows;
    }
    public function findById(int $id): ?array {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return null; }
        $sql = "SELECT c.*, p.name AS person_name FROM " . TB_PREF . $this->table . " c"
            . " LEFT JOIN " . TB_PREF . "crm_persons p ON c.person_id = p.id"
            . " WHERE c.contract_id = " . (int) $id;
        $result = db_query($sql, 'Could not load contract');
        if ($result === false) { return null; }
        $row = db_fetch_assoc($result);
        return $row === false ? null : $row;
    }
    public function listForPerson(int $personId): array {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return array(); }
        $sql = "SELECT c.*, p.name AS person_name FROM " . TB_PREF . $this->table . " c"
            . " LEFT JOIN " . TB_PREF . "crm_persons p ON c.person_id = p.id"
            . " WHERE c.person_id = " . (int) $personId
            . " ORDER BY c.start_date DESC";
        $result = db_query($sql, 'Could not load contracts by person');
        if ($result === false) { return array(); }
        $rows = array();
        while (($row = db_fetch_assoc($result)) !== false && $row !== null) { $rows[] = $row; }
        return $rows;
    }
    public function insertContract(array $data): int {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return 0; }
        $sql = "INSERT INTO " . TB_PREF . $this->table . " (
                person_id, contract_type, title, reference_no, start_date, end_date, renewal_date, status, file_path, notes, created_at, updated_at)
            VALUES ("
            . $this->intVal($data['person_id'] ?? 0) . ", "
            . $this->escape($data['contract_type'] ?? '') . ", "
            . $this->escape($data['title'] ?? '') . ", "
            . $this->escape($data['reference_no'] ?? '') . ", "
            . $this->escape($data['start_date'] ?? '') . ", "
            . $this->escape($data['end_date'] ?? null) . ", "
            . $this->escape($data['renewal_date'] ?? null) . ", "
            . $this->escape($data['status'] ?? 'active') . ", "
            . $this->escape($data['file_path'] ?? '') . ", "
            . $this->escape($data['notes'] ?? '') . ", "
            . $this->escape(date('Y-m-d H:i:s')) . ", "
            . $this->escape(date('Y-m-d H:i:s')) . ")";
        $this->dbQuery($sql);
        return $this->dbInsertId();
    }
    public function updateState(int $contractId, string $status, string $renewalDate = null, string $notes = null): void {
        if (!function_exists('db_query') || !defined('TB_PREF')) { return; }
        $sets = ["status = " . $this->escape($status)];
        $sets[] = "renewal_date = " . $this->escape($renewalDate);
        $sets[] = "notes = " . $this->escape($notes ?? '');
        $sets[] = "updated_at = " . $this->escape(date('Y-m-d H:i:s'));
        $sql = "UPDATE " . TB_PREF . $this->table . " SET " . implode(', ', $sets)
            . " WHERE contract_id = " . $this->intVal($contractId);
        $this->dbQuery($sql);
    }
    private function dbQuery($sql, $errorMsg = null) {
        return db_query($sql, $errorMsg);
    }
    private function dbInsertId() {
        return db_insert_id();
    }
    private function escape($value): string {
        if ($value === null) { return 'NULL'; }
        return function_exists('db_escape') ? db_escape($value) : addslashes((string) $value);
    }
    private function intVal($value): int {
        return (int) $value;
    }
}
