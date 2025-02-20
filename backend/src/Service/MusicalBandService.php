<?php

namespace App\Service;

use App\DTO\MusicalBandDTO;
use App\Entity\MusicalBand;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DateTimeImmutable;
use DateTime;

class MusicalBandService
{
    private EntityManagerInterface $entity_manager;
    private LoggerInterface $logger;

    /**
     * MusicalBandService constructor.
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
     * Retrieve all musical bands.
     *
     * @return MusicalBand[]
     */
    public function getAllBands(): array
    {
        return $this->entity_manager
            ->getRepository(MusicalBand::class)
            ->findAll();
    }

    /**
     * Retrieve a musical band by its ID.
     *
     * @param int $id
     * @return MusicalBand
     *
     * @throws NotFoundHttpException if band is not found.
     */
    public function getBandById(int $id): MusicalBand
    {
        $band = $this->entity_manager
            ->getRepository(MusicalBand::class)
            ->find($id);
        if (!$band) {
            $this->logger->error("MusicalBand with ID {$id} not found.");
            throw new NotFoundHttpException("MusicalBand not found.");
        }
        return $band;
    }

    /**
     * Create a new musical band.
     *
     * @param MusicalBandDTO $band_dto
     * @return MusicalBand
     */
    public function createBand(MusicalBandDTO $band_dto): MusicalBand
    {
        try {
            $existingBand = $this->entity_manager
            ->getRepository(MusicalBand::class)
            ->findOneBy(['name' => $band_dto->name, 'origin' => $band_dto->origin]);

            if ($existingBand) {
            throw new \Exception("A band with the name '{$band_dto->name}' and origin '{$band_dto->origin}' already exists.");
            }

            $band = new MusicalBand();
            $band->setName($band_dto->name);
            $band->setOrigin($band_dto->origin);
            $band->setCity($band_dto->city);
            $band->setFoundedAt(new DateTimeImmutable($band_dto->founded_at));
            $band->setSeparationDate(
            $band_dto->separation_date
                ? new DateTime($band_dto->separation_date)
                : null
            );
            $band->setFounders($band_dto->founders);
            $band->setMembers($band_dto->members);
            $band->setMusicStyle($band_dto->music_style);
            $band->setAbout($band_dto->about);

            $this->entity_manager->persist($band);
            $this->entity_manager->flush();

            return $band;
        } catch (\Exception $e) {
            $this->logger->error(
                "Error creating musical band: " . $e->getMessage()
            );
            throw $e;
        }
    }

    /**
     * Update an existing musical band.
     *
     * @param int $id
     * @param MusicalBandDTO $band_dto
     * @return MusicalBand
     *
     * @throws NotFoundHttpException if band is not found.
     */
    public function updateBand(int $id, MusicalBandDTO $band_dto): MusicalBand
    {
        $band = $this->getBandById($id);
        try {
            if ($band_dto->name) {
                $band->setName($band_dto->name);
            }
            if ($band_dto->origin) {
                $band->setOrigin($band_dto->origin);
            }
            if ($band_dto->city) {
                $band->setCity($band_dto->city);
            }
            if ($band_dto->founded_at) {
                $band->setFoundedAt(
                    new DateTimeImmutable($band_dto->founded_at)
                );
            }
            if ($band_dto->separation_date !== null) {
                $band->setSeparationDate(
                    $band_dto->separation_date
                        ? new DateTime($band_dto->separation_date)
                        : null
                );
            }
            if ($band_dto->founders) {
                $band->setFounders($band_dto->founders);
            }
            if ($band_dto->members !== null) {
                $band->setMembers($band_dto->members);
            }
            if ($band_dto->music_style !== null) {
                $band->setMusicStyle($band_dto->music_style);
            }
            if ($band_dto->about) {
                $band->setAbout($band_dto->about);
            }

            $this->entity_manager->flush();

            return $band;
        } catch (\Exception $e) {
            $this->logger->error(
                "Error updating musical band: " . $e->getMessage()
            );
            throw $e;
        }
    }

    /**
     * Delete a musical band.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if band is not found.
     */
    public function deleteBand(int $id): void
    {
        $band = $this->getBandById($id);
        try {
            $this->entity_manager->remove($band);
            $this->entity_manager->flush();
        } catch (\Exception $e) {
            $this->logger->error(
                "Error deleting musical band: " . $e->getMessage()
            );
            throw $e;
        }
    }
}
