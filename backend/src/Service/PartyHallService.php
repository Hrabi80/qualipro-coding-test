<?php

namespace App\Service;

use App\DTO\PartyHallDTO;
use App\Entity\PartyHall;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PartyHallService
{
    private EntityManagerInterface $entity_manager;
    private LoggerInterface $logger;

    /**
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
     * @return PartyHall[]
     */
    public function getAllPartyHalls(): array
    {
        return $this->entity_manager
            ->getRepository(PartyHall::class)
            ->findAll();
    }

    public function getPartyHallById(int $id): PartyHall
    {
        $party_hall = $this->entity_manager
            ->getRepository(PartyHall::class)
            ->find($id);
        if (!$party_hall) {
            $this->logger->error("PartyHall with ID {$id} not found.");
            throw new NotFoundHttpException("PartyHall not found.");
        }
        return $party_hall;
    }

    public function createPartyHall(PartyHallDTO $party_hall_dto): PartyHall
    {
        try {
            $existing_party_hall = $this->entity_manager
            ->getRepository(PartyHall::class)
            ->findOneBy([
                'name' => $party_hall_dto->name,
                'city' => $party_hall_dto->city,
            ]);

            if ($existing_party_hall) {
            $this->logger->error(
                "PartyHall with name {$party_hall_dto->name} in city {$party_hall_dto->city} already exists."
            );
            throw new \Exception("PartyHall already exists.");
            }

            $party_hall = new PartyHall();
            $party_hall->setName($party_hall_dto->name);
            $party_hall->setAddress($party_hall_dto->address);
            $party_hall->setCity($party_hall_dto->city);

            $this->entity_manager->persist($party_hall);
            $this->entity_manager->flush();

            return $party_hall;
        } catch (\Exception $e) {
            $this->logger->error(
            "Error creating party hall: " . $e->getMessage()
            );
            throw $e;
        }
    }

    /**
     * Update an existing party hall.
     *
     * @param int $id
     * @param PartyHallDTO $party_hall_dto
     * @return PartyHall
     *
     * @throws NotFoundHttpException if party hall is not found.
     */
    public function updatePartyHall(
        int $id,
        PartyHallDTO $party_hall_dto
    ): PartyHall {
        $party_hall = $this->getPartyHallById($id);
        try {
            if ($party_hall_dto->name) {
                $party_hall->setName($party_hall_dto->name);
            }
            if ($party_hall_dto->address) {
                $party_hall->setAddress($party_hall_dto->address);
            }
            if ($party_hall_dto->city) {
                $party_hall->setCity($party_hall_dto->city);
            }

            $this->entity_manager->flush();

            return $party_hall;
        } catch (\Exception $e) {
            $this->logger->error(
                "Error updating party hall: " . $e->getMessage()
            );
            throw $e;
        }
    }

    /**
     * Delete a party hall.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if party hall is not found.
     */
    public function deletePartyHall(int $id): void
    {
        $party_hall = $this->getPartyHallById($id);
        try {
            $this->entity_manager->remove($party_hall);
            $this->entity_manager->flush();
        } catch (\Exception $e) {
            $this->logger->error(
                "Error deleting party hall: " . $e->getMessage()
            );
            throw $e;
        }
    }
}
