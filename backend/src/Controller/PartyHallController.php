<?php

namespace App\Controller;

use App\DTO\PartyHallDTO;
use App\Service\PartyHallService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;

/**
 *
 * @OA\Tag(name="Party Halls")
 */
#[Route("/api/party-halls")]
class PartyHallController extends AbstractController
{
    private PartyHallService $party_hall_service;

    public function __construct(PartyHallService $party_hall_service)
    {
        $this->party_hall_service = $party_hall_service;
    }

    /**
     *
     * @OA\Get(
     *     summary="List all party halls",
     *     @OA\Response(
     *         response=200,
     *         description="Returns the list of party halls."
     *     )
     * )
     */
    #[Route("", methods: ["GET"])]
    public function index(): JsonResponse
    {
        $party_halls = $this->party_hall_service->getAllPartyHalls();
        $data = [];

        foreach ($party_halls as $hall) {
            $data[] = [
                "id" => $hall->getId(),
                "name" => $hall->getName(),
                "address" => $hall->getAddress(),
                "city" => $hall->getCity(),
            ];
        }
        return $this->json($data);
    }

    /**
     *
     * @OA\Get(
     *     summary="Get a party hall",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Party hall ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns a party hall."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Party hall not found."
     *     )
     * )
     *
     */
    #[Route("/{id}", methods: ["GET"])]
    public function show(int $id): JsonResponse
    {
        try {
            $hall = $this->party_hall_service->getPartyHallById($id);
            $data = [
                "id" => $hall->getId(),
                "name" => $hall->getName(),
                "address" => $hall->getAddress(),
                "city" => $hall->getCity(),
            ];
            return $this->json($data);
        } catch (\Exception $e) {
            return $this->json(
                ["error" => $e->getMessage()],
                Response::HTTP_NOT_FOUND
            );
        }
    }

    /**
     * @OA\Post(
     *     summary="Create a new party hall",
     *     @OA\RequestBody(
     *         required=true,
     *         description="PartyHall object that needs to be added",
     *         @OA\JsonContent(ref="#/components/schemas/PartyHallDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Party hall created"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    #[Route("", methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $hall_dto = new PartyHallDTO();
        $hall_dto->name = $data["name"] ?? null;
        $hall_dto->address = $data["address"] ?? null;
        $hall_dto->city = $data["city"] ?? null;

        try {
            $hall = $this->party_hall_service->createPartyHall($hall_dto);
            $response_data = [
                "id" => $hall->getId(),
                "name" => $hall->getName(),
                "address" => $hall->getAddress(),
                "city" => $hall->getCity(),
            ];
            return $this->json($response_data, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->json(
                ["error" => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Update an existing party hall.
     *
     * @OA\Put(
     *     summary="Update an existing party hall",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Party hall ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="PartyHall object that needs to be updated",
     *         @OA\JsonContent(ref="#/components/schemas/PartyHallDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Party hall updated"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     *
     *
     */
    #[Route("/{id}", methods: ["PUT"])]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $hall_dto = new PartyHallDTO();
        $hall_dto->name = $data["name"] ?? null;
        $hall_dto->address = $data["address"] ?? null;
        $hall_dto->city = $data["city"] ?? null;

        try {
            $hall = $this->party_hall_service->updatePartyHall($id, $hall_dto);
            $response_data = [
                "id" => $hall->getId(),
                "name" => $hall->getName(),
                "address" => $hall->getAddress(),
                "city" => $hall->getCity(),
            ];
            return $this->json($response_data);
        } catch (\Exception $e) {
            return $this->json(
                ["error" => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Delete a party hall.
     *
     * @OA\Delete(
     *     summary="Delete a party hall",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Party hall ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Party hall deleted"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error deleting party hall"
     *     )
     * )
     *
     *
     */
    #[Route("/{id}", methods: ["DELETE"])]
    public function delete(int $id): JsonResponse
    {
        try {
            $this->party_hall_service->deletePartyHall($id);
            return $this->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->json(
                ["error" => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
