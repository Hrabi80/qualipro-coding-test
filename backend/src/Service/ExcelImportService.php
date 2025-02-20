<?php

namespace App\Service;

use App\Entity\MusicalBand;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use DateTimeImmutable;
use DateTime;

/**
 * Handles importing MusicalBand entities from an Excel file.
 */
class ExcelImportService
{
    private EntityManagerInterface $entity_manager;
    private LoggerInterface $logger;

    /**
     * ExcelImportService constructor.
     *
     * @param EntityManagerInterface $entity_manager
     * @param LoggerInterface $logger
     */
    public function __construct(
        EntityManagerInterface $entity_manager,
        LoggerInterface $logger
    ) {
        $this->entity_manager = $entity_manager;
        $this->logger = $logger;
    }

    /**
     * Import musical bands from an Excel file.
     *
     * @param string $filePath Path to the Excel file.
     * @return int Number of bands imported.
     *
     * @throws BadRequestHttpException if the file cannot be read.
     */
    public function importMusicalBands(string $filePath): int
    {
        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestDataRow();
            $importedCount = 0;

            // Assuming row 1 is a header
            for ($row = 2; $row <= $highestRow; $row++) {
                $name = $worksheet->getCell("A{$row}")->getValue();
                $origin = $worksheet->getCell("B{$row}")->getValue();
                $city = $worksheet->getCell("C{$row}")->getValue();
                $founded_at = $worksheet->getCell("D{$row}")->getValue();
                $separation_date = $worksheet->getCell("E{$row}")->getValue();
                $founders = $worksheet->getCell("F{$row}")->getValue();
                $members = $worksheet->getCell("G{$row}")->getValue();
                $music_style = $worksheet->getCell("H{$row}")->getValue();
                $about = $worksheet->getCell("I{$row}")->getValue();

                // Validate required fields
                if (
                    !$name ||
                    !$origin ||
                    !$city ||
                    !$founded_at ||
                    !$founders ||
                    !$members ||
                    !$about
                ) {
                    $this->logger->warning(
                        "Row {$row} skipped due to missing required data."
                    );
                    continue;
                }

                $band = new MusicalBand();
                $band->setName($name);
                $band->setOrigin($origin);
                $band->setCity($city);
                $band->setFoundedAt(new DateTimeImmutable($founded_at));
                $band->setSeparationDate(
                    $separation_date ? new DateTime($separation_date) : null
                );
                $band->setFounders($founders);
                $band->setMembers((int) $members);
                $band->setMusicStyle($music_style);
                $band->setAbout($about);

                $this->entity_manager->persist($band);
                $importedCount++;
            }

            $this->entity_manager->flush();
            return $importedCount;
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            $this->logger->error(
                "Error reading Excel file: " . $e->getMessage()
            );
            throw new BadRequestHttpException("Error reading Excel file.");
        } catch (\Exception $e) {
            $this->logger->error(
                "Error importing musical bands: " . $e->getMessage()
            );
            throw $e;
        }
    }
}
