<?php

namespace App\Service;

use App\DTO\ConcertDTO;
use App\DTO\ConcertResponseDto;
use App\Entity\Concert;
use App\Entity\MusicalBand;
use App\Entity\PartyHall;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DateTime;

class ConcertService
{
    private EntityManagerInterface $entity_manager;
    private LoggerInterface $logger;
    public function __construct(
        EntityManagerInterface $entity_manager,
        LoggerInterface $logger
    ) {
        $this->entity_manager = $entity_manager;
        $this->logger = $logger;
    }

     /**
     * Retrieve all concerts with party hall info and band names.
     *
     * @return ConcertResponseDto[]
     */
    public function getAllConcerts(): array
    {
        $concerts = $this->entity_manager->getRepository(Concert::class)->findAll();
        $concertDtos = [];

        foreach ($concerts as $concert) {
            $partyHall = $concert->getPartyHall();
            $bands = $concert->getBands()->toArray();

            $bandList = array_map(fn($band) => [
                "id" => $band->getId(),
                "name" => $band->getName(),
            ], $bands);

            $concertDtos[] = new ConcertResponseDto(
                $concert->getId(),
                $concert->getDate()->format("Y-m-d"),
                $partyHall ? $partyHall->getId() : null,
                $partyHall ? $partyHall->getName() : null,
                $bandList
            );
        }

        return $concertDtos;
    }

    /**
     * Retrieve a concert by its ID.
     *
     * @param int $id
     * @return Concert
     *
     * @throws NotFoundHttpException if concert is not found.
     */
    public function getConcertById(int $id): Concert
    {
        $concert = $this->entity_manager
            ->getRepository(Concert::class)
            ->find($id);
        if (!$concert) {
            $this->logger->error("Concert with ID {$id} not found.");
            throw new NotFoundHttpException("Concert not found.");
        }
        return $concert;
    }

    /**
     * Create a new concert.
     *
     * @param ConcertDTO $concert_dto
     * @return Concert
     */
    public function createConcert(ConcertDTO $concert_dto): Concert
    {
        try {
            // Check if the party hall is already booked for the given date
            $existingConcert = $this->entity_manager->getRepository(Concert::class)->findOneBy([
            'date' => new DateTime($concert_dto->date),
            'partyHall' => $concert_dto->party_hall_id
            ]);

            if ($existingConcert) {
            throw new \Exception("This party hall is already reserved for the selected date. Please choose another date.");
            }

            // Check if any of the bands already have a concert on the given date if any of the bands have a separation date
            foreach ($concert_dto->band_ids as $band_id) {
                $qb = $this->entity_manager->createQueryBuilder();
                $existingBandConcert = $qb->select('c')
                    ->from(Concert::class, 'c')
                    ->join('c.bands', 'b')
                    ->where('c.date = :date')
                    ->andWhere('b.id = :band_id')
                    ->setParameter('date', new DateTime($concert_dto->date))
                    ->setParameter('band_id', $band_id)
                    ->getQuery()
                    ->getOneOrNullResult();
                    
                if ($existingBandConcert) {
                    $band = $this->entity_manager->getRepository(MusicalBand::class)->find($band_id);
                    throw new \Exception("The band '{$band->getName()}' already has a concert on the selected date.");
                }
            }
            // Check if any of the bands have a separation date
            foreach ($concert_dto->band_ids as $band_id) {
            $band = $this->entity_manager->getRepository(MusicalBand::class)->find($band_id);
            if ($band && $band->getSeparationDate() !== null) {
                throw new \Exception("The band '{$band->getName()}' is no longer active.");
            }
            }

            $concert = new Concert();
            $concert->setDate(new DateTime($concert_dto->date));

            if ($concert_dto->party_hall_id) {
            $party_hall = $this->entity_manager
                ->getRepository(PartyHall::class)
                ->find($concert_dto->party_hall_id);
            if (!$party_hall) {
                throw new NotFoundHttpException("PartyHall not found.");
            }
            $concert->setPartyHall($party_hall);
            }

            // Add bands to the concert
            foreach ($concert_dto->band_ids as $band_id) {
            $band = $this->entity_manager
                ->getRepository(MusicalBand::class)
                ->find($band_id);
            if (!$band) {
                throw new NotFoundHttpException(
                "MusicalBand with ID {$band_id} not found."
                );
            }
            $concert->addBand($band);
            }

            $this->entity_manager->persist($concert);
            $this->entity_manager->flush();

            return $concert;
        } catch (\Exception $e) {
            $this->logger->error("Error creating concert: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update an existing concert.
     *
     * @param int $id
     * @param ConcertDTO $concert_dto
     * @return Concert
     *
     * @throws NotFoundHttpException if concert is not found.
     */
    public function updateConcert(int $id, ConcertDTO $concert_dto): Concert
    {
        $concert = $this->getConcertById($id);

        try {
            if ($concert_dto->date) {
                $concert->setDate(new DateTime($concert_dto->date));
            }

            if ($concert_dto->party_hall_id !== null) {
                $party_hall = $this->entity_manager
                    ->getRepository(PartyHall::class)
                    ->find($concert_dto->party_hall_id);
                if (!$party_hall) {
                    throw new NotFoundHttpException("PartyHall not found.");
                }
                $concert->setPartyHall($party_hall);
            }

            // Reset bands and add new ones
            foreach ($concert->getBands() as $band) {
                $concert->removeBand($band);
            }
            foreach ($concert_dto->band_ids as $band_id) {
                $band = $this->entity_manager
                    ->getRepository(MusicalBand::class)
                    ->find($band_id);
                if (!$band) {
                    throw new NotFoundHttpException(
                        "MusicalBand with ID {$band_id} not found."
                    );
                }
                $concert->addBand($band);
            }

            $this->entity_manager->flush();

            return $concert;
        } catch (\Exception $e) {
            $this->logger->error("Error updating concert: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete a concert.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if concert is not found.
     */
    public function deleteConcert(int $id): void
    {
        $concert = $this->getConcertById($id);
        try {
            $this->entity_manager->remove($concert);
            $this->entity_manager->flush();
        } catch (\Exception $e) {
            $this->logger->error("Error deleting concert: " . $e->getMessage());
            throw $e;
        }
    }
}
