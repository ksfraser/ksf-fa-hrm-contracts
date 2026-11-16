# ksf_FA_HRM_Contracts — Requirements

## Purpose
Manage contracts and statutory documents: contract repository, renewal tracking, document references and status per employee.

## Business Rules (BR-HRM-09)
- A contract belongs to one employee and one contract type.
- Each contract tracks start/end/renewal dates, status, reference number and an optional stored document path.
- Renewal dates are monitored for upcoming expirations.
- State transitions: draft → active → expired | terminated.

## Functional Requirements
- FR-CT-01: Create a contract for an employee.
- FR-CT-02: List all contracts (summary table).
- FR-CT-03: Resolve a single contract by id (related-record linking).
- FR-CT-04: Update contract status/renewal date/notes.
- FR-CT-05: List contracts for a given employee.
- FR-CT-06: Expose contract fields via RELATED_TO_FIELDS.

## Non-Functional Requirements
- NF-CT-01: All database access uses native FA db_* calls.
- NF-CT-02: PHP 7.3 compatible runtime.
- NF-CT-03: Unit tests cover DTO round-trip and label resolution.
