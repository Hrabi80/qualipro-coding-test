<?php

namespace App\Controller;

use App\Service\ExcelImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Annotations as OA;
/**
 *
 * @OA\Tag(name="Excel Import")
 */
#[Route("/api/import")]
class ExcelImportController extends AbstractController
{
    private ExcelImportService $excel_import_service;

    public function __construct(ExcelImportService $excel_import_service)
    {
        $this->excel_import_service = $excel_import_service;
    }

    /**
     *
     * @OA\Post(
     *     summary="Import musical bands from an Excel file",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Excel file containing musical bands",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bands imported successfully."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="No file uploaded or error during import."
     *     )
     * )
     */

    #[Route("/bands", methods: ["POST"])]
    public function importBands(Request $request): JsonResponse
    {
        $file = $request->files->get("file");
        if (!$file) {
            return new JsonResponse(
                ["error" => "No file uploaded."],
                Response::HTTP_BAD_REQUEST
            );
        }

        $filePath = $file->getRealPath();

        try {
            $importedCount = $this->excel_import_service->importMusicalBands(
                $filePath
            );
            return new JsonResponse(
                ["message" => "{$importedCount} bands imported successfully."],
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                ["error" => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
