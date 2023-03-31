<?php

namespace Imported\AppBundle\Controller;

use Imported\AppBundle\Services\Import\Preparation\ImportPreparationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/import/csv", name="imported_app_csv",methods={"POST"})
     */
    public function index(Request $request, ImportPreparationInterface $csvImportPreparation): JsonResponse
    {
        $response=[];
        $result=$csvImportPreparation->process($request->request->all());
        if($result)
        {
            $response['message'] = "Imported In Progress Please Wait";
            $response['type'] = "success";
        }
        else
        {
            $response['message'] = "Error in Import this CSV file";
            $response['type'] = "error";
        }
        return new JsonResponse($response);
    }


}
