<?php

namespace App\Controller;

use App\DTO\ConcertDTO;
use App\Service\ConcertService;
use App\DTO\ConcertResponseDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
/**
 *
 * @OA\Tag(name="Concerts")
 */
#[Route("/api/concerts")]
class ConcertController extends AbstractController
{
    private ConcertService $concert_service;

    public function __construct(ConcertService $concert_service)
    {
        $this->concert_service = $concert_service;
    }

    /**
     *   @OA\Get(
     *     summary="List all concerts",
     *     @OA\Response(
     *         response=200,
     *         description="Returns the list of concerts."
     *     )
     * )
     *
     * @return JsonResponse
     */
    #[Route("", methods: ["GET"])]
    public function index(): JsonResponse
    {
        $concerts = $this->concert_service->getAllConcerts();
        return $this->json($concerts);
    }

    /**
     * Get details of a single concert.
     *
     * @OA\Get(
     *     summary="Get a concert",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Concert ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns a concert."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Concert not found."
     *     )
     * )
     */
    #[Route("/{id}", methods: ["GET"])]
    public function show(int $id): JsonResponse
    {
        try {
            $concert = $this->concert_service->getConcertById($id);
            $data = [
                "id" => $concert->getId(),
                "date" => $concert->getDate()->format("Y-m-d"),
                "party_hall_id" => $concert->getPartyHall()
                    ? $concert->getPartyHall()->getId()
                    : null,
                "band_ids" => array_map(
                    fn($band) => $band->getId(),
                    $concert->getBands()->toArray()
                ),
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
     *
     * @OA\Post(
     *     summary="Create a new concert",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Concert object that needs to be added",
     *         @OA\JsonContent(ref="#/components/schemas/ConcertDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Concert created"
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
        $concert_dto = new ConcertDTO();
        $concert_dto->date = $data["date"] ?? null;
        $concert_dto->party_hall_id = $data["party_hall_id"] ?? null;
        $concert_dto->band_ids = $data["band_ids"] ?? [];

        try {
            $concert = $this->concert_service->createConcert($concert_dto);
            $response_data = [
                "id" => $concert->getId(),
                "date" => $concert->getDate()->format("Y-m-d"),
                "party_hall_id" => $concert->getPartyHall()
                    ? $concert->getPartyHall()->getId()
                    : null,
                "band_ids" => array_map(
                    fn($band) => $band->getId(),
                    $concert->getBands()->toArray()
                ),
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
     * @OA\Put(
     *     summary="Update an existing concert",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Concert ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Concert object that needs to be updated",
     *         @OA\JsonContent(ref="#/components/schemas/ConcertDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Concert updated"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     *
     */
    #[Route("/{id}", methods: ["PUT"])]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $concert_dto = new ConcertDTO();
        $concert_dto->date = $data["date"] ?? null;
        $concert_dto->party_hall_id = $data["party_hall_id"] ?? null;
        $concert_dto->band_ids = $data["band_ids"] ?? [];

        try {
            $concert = $this->concert_service->updateConcert($id, $concert_dto);
            $response_data = [
                "id" => $concert->getId(),
                "date" => $concert->getDate()->format("Y-m-d"),
                "party_hall_id" => $concert->getPartyHall()
                    ? $concert->getPartyHall()->getId()
                    : null,
                "band_ids" => array_map(
                    fn($band) => $band->getId(),
                    $concert->getBands()->toArray()
                ),
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
     * Delete a concert.
     *
     * @OA\Delete(
     *     summary="Delete a concert",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Concert ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Concert deleted"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error deleting concert"
     *     )
     * )
     */
    #[Route("/{id}", methods: ["DEMLETE"])]
    public function delete(int $id): JsonResponse
    {
        try {
            $this->concert_service->deleteConcert($id);
            return $this->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->json(
                ["error" => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
