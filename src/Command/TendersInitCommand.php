<?php

namespace App\Command;

use App\Entity\Tender;
use App\Entity\TenderStatus;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\TryCatch;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(name: 'app:tenders:init')]
/**
 * Заполнение бд тестовыми данными
 */
class TendersInitCommand
{
    private $filePath = "";
    public function __construct(private SerializerInterface $serializer, private EntityManagerInterface $em, ContainerBagInterface $cbi)
    {
        $projectDir     = $cbi->get('project_dir');
        $this->filePath = $projectDir . '/test_task_data.csv';
    }
    public function __invoke(): int
    {
        try {
            $data = $this->serializer->decode(file_get_contents($this->filePath), 'csv');

            $this->createStatus($data);
            $this->importTenders($data);

        } catch (\Throwable $th) {
            return Command::FAILURE;
        }
        ;
        return Command::SUCCESS;
    }

    private function createStatus(array $decodeData, $statusKey = "Статус")
    {

        $allStatuses    = array_column($decodeData, 'Статус');
        $statuses       = array_filter($allStatuses);
        $uniqueStatuses = array_unique($statuses);
        if (!in_array('Отсутствует', $uniqueStatuses)) {
            $uniqueStatuses[] = 'Отсутствует';
        }
        $statusMap = $this->getStatusMap();
        foreach ($uniqueStatuses as $name) {

            if (array_key_exists($name, $statusMap)) {
                continue;
            }

            $status = new TenderStatus();
            $status->setName($name);
            $this->em->persist($status);
        }

        $this->em->flush();
    }

    private function importTenders(array $decodeData)
    {
        $statusMap = $this->getStatusMap();

        $batchSize = 200;
        $i         = 0;

        foreach ($decodeData as $row) {

            $Tender = new Tender();
            $Tender->setExternalCode($row['Внешний код']);
            $Tender->setNumber($row['Номер']);

            $statusName = $row['Статус'] ?: 'Отсутствует';
            $Tender->setStatus($statusMap[$statusName] ?? $statusMap['Отсутствует']);

            $Tender->setName($row['Название']);

            $Tender->setUpdatedAt(new DateTimeImmutable($row['Дата изм']['4']));

            $this->em->persist($Tender);

            if (($i % $batchSize) === 0) {
                $this->em->flush();
                $this->em->clear();
                $statusMap = $this->getStatusMap();
            }

            $i++;
        }

        $this->em->flush();
        $this->em->clear();
    }


    private function getStatusMap(): array
    {
        $tenderStatuses = $this->em->getRepository(TenderStatus::class)->findAll();
        $statusMap      = [];
        foreach ($tenderStatuses as $status) {
            $statusMap[$status->getName()] = $status;
        }
        return $statusMap;
    }
}