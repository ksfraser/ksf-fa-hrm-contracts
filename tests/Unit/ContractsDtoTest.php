<?php
declare(strict_types=1);
namespace Ksfraser\FrontAccounting\HRM\Contracts\Tests\Unit;
use PHPUnit\Framework\TestCase;
use Ksfraser\FrontAccounting\HRM\Contracts\DTO\ContractsDTO;
class ContractsDtoTest extends TestCase
{
    public function testDtoRoundTripsThroughArray(): void {
        $dto = new ContractsDTO(5, 10, 'Sue Jones', 'employment', 'Senior Developer', 'REF-2026-001', '2026-01-01', '2026-12-31', '2026-11-01', 'active', '/docs/contract.pdf', 'Probation 6 months');
        $arr = $dto->toArray();
        $this->assertSame(5, $arr['contract_id']);
        $this->assertSame(10, $arr['person_id']);
        $this->assertSame('Sue Jones', $arr['person_name']);
        $this->assertSame('employment', $arr['contract_type']);
        $this->assertSame('Senior Developer', $arr['title']);
        $this->assertSame('REF-2026-001', $arr['reference_no']);
        $this->assertSame('active', $arr['status']);
        $dto2 = ContractsDTO::fromArray($arr);
        $this->assertSame($dto->contract_id, $dto2->contract_id);
        $this->assertSame($dto->title, $dto2->title);
        $this->assertSame($dto->status, $dto2->status);
    }
    public function testDisplayLabelUsesTitleWhenSet(): void {
        $dto = new ContractsDTO(1, 2, 'Sue Jones', 'employment', 'Senior Developer', 'REF-1');
        $this->assertStringContainsString('Senior Developer', $dto->getDisplayLabel());
    }
    public function testDisplayLabelFallsBackToId(): void {
        $dto = new ContractsDTO(9, 2, '', '', '', '', '', '', '', 'active');
        $this->assertStringContainsString('Contract #9', $dto->getDisplayLabel());
    }
}
