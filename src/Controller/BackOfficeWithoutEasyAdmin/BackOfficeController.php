<?php

namespace App\Controller\BackOfficeWithoutEasyAdmin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/backoffice")
 */

class BackOfficeController extends AbstractController
{
    /**
     * @Route("/", name="backoffice_home" , methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('back_office_without_easy_admin/backoffice/index.html.twig', [
            'controller_name' => 'BackOfficeController',
        ]);
    }
}
