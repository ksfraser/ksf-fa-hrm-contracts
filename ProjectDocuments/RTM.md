# ksf_FA_HRM_Contracts — Requirements Traceability Matrix

| Req ID | Requirement | Source | Implemented In | Verified By |
|--------|-------------|--------|----------------|-------------|
| BR-HRM-09 | Contracts & statutory documents | HR-CRM_gaps.md H9 | ContractsService | unit tests |
| FR-CT-01 | Create contract | BR-HRM-09 | ContractsRepository::insertContract | ContractsDtoTest |
| FR-CT-02 | List contracts | BR-HRM-09 | ContractsService::listAll | (tab controller) |
| FR-CT-03 | Resolve contract by id | BR-HRM-09 | ContractsService::resolveById | (capability hook) |
| FR-CT-04 | Update contract | BR-HRM-09 | ContractsService::updateState | (state transitions) |
| FR-CT-05 | List for employee | BR-HRM-09 | ContractsRepository::listForPerson | (service) |
| FR-CT-06 | RELATED_TO_FIELDS | BR-HRM-09 | hooks.php RELATED_TO_FIELDS | (capability) |
| NF-CT-01 | Native db_* calls | AGENTS_ARCH | repository | code review |
| NF-CT-02 | PHP 7.3 compatible | AGENTS_ARCH | all src | code review |
| NF-CT-03 | Unit tests | AGENTS_ARCH | tests/Unit | phpunit |
