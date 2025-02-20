<?php

namespace App\Controller;

use App\DTO\MusicalBandDTO;
use App\Service\MusicalBandService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
//use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @OA\Tag(name="Musical Bands")
 */
#[Route("/api/bands")]
class MusicalBandController extends AbstractController
{
    private MusicalBandService $band_service;

   // private ValidatorInterface $validator;

    public function __construct(MusicalBandService $band_service, /*ValidatorInterface $validator*/)
    {
        $this->band_service = $band_service;
       // $this->validator = $validator;
    }

    /**
     *
     * @OA\Get(
     *     summary="List all musical bands",
     *     @OA\Response(
     *         response=200,
     *         description="Returns the list of musical bands."
     *     )
     * )
     *
     * @return JsonResponse
     */
    #[Route("", methods: ["GET"])]
    public function index(): JsonResponse
    {
        $bands = $this->band_service->getAllBands();
        $data = [];

        foreach ($bands as $band) {
            $data[] = [
                "id" => $band->getId(),
                "name" => $band->getName(),
                "origin" => $band->getOrigin(),
                "city" => $band->getCity(),
                "founded_at" => $band->getFoundedAt()->format("Y-m-d"),
                "separation_date" => $band->getSeparationDate()
                    ? $band->getSeparationDate()->format("Y-m-d")
                    : null,
                "founders" => $band->getFounders(),
                "members" => $band->getMembers(),
                "music_style" => $band->getMusicStyle(),
                "about" => $band->getAbout(),
            ];
        }
        return $this->json($data);
    }

    /**
     * Get details of a single musical band.
     *
     * @OA\Get(
     *     summary="Get a musical band",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Musical Band ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns a musical band."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Musical band not found."
     *     )
     * )
     *
     */
    #[Route("/{id}", methods: ["GET"])]
    public function show(int $id): JsonResponse
    {
        try {
            $band = $this->band_service->getBandById($id);
            $data = [
                "id" => $band->getId(),
                "name" => $band->getName(),
                "origin" => $band->getOrigin(),
                "city" => $band->getCity(),
                "founded_at" => $band->getFoundedAt()->format("Y-m-d"),
                "separation_date" => $band->getSeparationDate()
                    ? $band->getSeparationDate()->format("Y-m-d")
                    : null,
                "founders" => $band->getFounders(),
                "members" => $band->getMembers(),
                "music_style" => $band->getMusicStyle(),
                "about" => $band->getAbout(),
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
     *     summary="Create a new musical band",
     *     @OA\RequestBody(
     *         required=true,
     *         description="MusicalBand object that needs to be added",
     *         @OA\JsonContent(ref="#/components/schemas/MusicalBandDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Musical band created"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     *
     *
     */
    #[Route("", methods: ["POST"])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $band_dto = new MusicalBandDTO();
        $band_dto->name = $data["name"] ?? null;
        $band_dto->origin = $data["origin"] ?? null;
        $band_dto->city = $data["city"] ?? null;
        $band_dto->founded_at = $data["founded_at"] ?? null;
        $band_dto->separation_date = $data["separation_date"] ?? null;
        $band_dto->founders = $data["founders"] ?? null;
        $band_dto->members = $data["members"] ?? null;
        $band_dto->about = $data["about"] ?? null;

        try {
            $band = $this->band_service->createBand($band_dto);
            $response_data = [
                "id" => $band->getId(),
                "name" => $band->getName(),
                "origin" => $band->getOrigin(),
                "city" => $band->getCity(),
                "founded_at" => $band->getFoundedAt()->format("Y-m-d"),
                "separation_date" => $band->getSeparationDate()
                    ? $band->getSeparationDate()->format("Y-m-d")
                    : null,
                "founders" => $band->getFounders(),
                "members" => $band->getMembers(),
                "music_style" => $band->getMusicStyle(),
                "about" => $band->getAbout(),
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
     * Update an existing musical band.
     *
     * @OA\Put(
     *     summary="Update an existing musical band",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Musical Band ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="MusicalBand object that needs to be updated",
     *         @OA\JsonContent(ref="#/components/schemas/MusicalBandDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Musical band updated"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    #[Route("/{id}", methods: ["PUT"])]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $band_dto = new MusicalBandDTO();
        $band_dto->name = $data["name"] ?? null;
        $band_dto->origin = $data["origin"] ?? null;
        $band_dto->city = $data["city"] ?? null;
        $band_dto->founded_at = $data["founded_at"] ?? null;
        $band_dto->separation_date = $data["separation_date"] ?? null;
        $band_dto->founders = $data["founders"] ?? null;
        $band_dto->members = $data["members"] ?? null;
        $band_dto->music_style = $data["music_style"] ?? null;
        $band_dto->about = $data["about"] ?? null;

        try {
            $band = $this->band_service->updateBand($id, $band_dto);
            $response_data = [
                "id" => $band->getId(),
                "name" => $band->getName(),
                "origin" => $band->getOrigin(),
                "city" => $band->getCity(),
                "founded_at" => $band->getFoundedAt()->format("Y-m-d"),
                "separation_date" => $band->getSeparationDate()
                    ? $band->getSeparationDate()->format("Y-m-d")
                    : null,
                "founders" => $band->getFounders(),
                "members" => $band->getMembers(),
                "music_style" => $band->getMusicStyle(),
                "about" => $band->getAbout(),
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
     * Delete a musical band.
     *
     * @OA\Delete(
     *     summary="Delete a musical band",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Musical Band ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Musical band deleted"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error deleting musical band"
     *     )
     * )
     */

    #[Route("/{id}", methods: ["DELETE"])]
    public function delete(int $id): JsonResponse
    {
        try {
            $this->band_service->deleteBand($id);
            return $this->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->json(
                ["error" => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
