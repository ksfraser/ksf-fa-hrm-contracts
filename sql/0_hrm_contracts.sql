-- ksf_FA_HRM_Contracts: contracts and statutory documents tables

CREATE TABLE IF NOT EXISTS `0_hrm_contracts` (
  `contract_id`   INT(11) NOT NULL AUTO_INCREMENT,
  `person_id`     INT(11) NOT NULL COMMENT 'FK to crm_persons.id (employee)',
  `contract_type` VARCHAR(64) NOT NULL COMMENT 'e.g. employment, NDA, statutory',
  `title`         VARCHAR(255) NOT NULL,
  `reference_no`  VARCHAR(64) DEFAULT NULL,
  `start_date`    DATE NOT NULL,
  `end_date`      DATE DEFAULT NULL,
  `renewal_date`  DATE DEFAULT NULL,
  `status`        VARCHAR(24) NOT NULL DEFAULT 'active' COMMENT 'active|expired|terminated|draft',
  `file_path`     VARCHAR(500) DEFAULT NULL COMMENT 'path to stored document',
  `notes`         TEXT DEFAULT NULL,
  `created_at`    DATETIME NOT NULL,
  `updated_at`    DATETIME NOT NULL,
  PRIMARY KEY (`contract_id`),
  KEY `idx_person` (`person_id`),
  KEY `idx_type` (`contract_type`),
  KEY `idx_status` (`status`),
  KEY `idx_renewal` (`renewal_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
