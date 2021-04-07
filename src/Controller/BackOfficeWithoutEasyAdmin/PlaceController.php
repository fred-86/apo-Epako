<?php

namespace App\Controller\BackOfficeWithoutEasyAdmin;

use App\Entity\Place;
use App\Form\PlaceType;
use App\Repository\PlaceRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/backoffice/place")
 */
class PlaceController extends AbstractController
{
    /**
     * @Route("/browse", name="back_office_place_browse", methods={"GET"})
     */
    public function browse(PlaceRepository $placeRepository,PaginatorInterface $paginator,Request $request): Response
    {

        $pagination = $paginator->paginate(
            $placeRepository->findAll(),

            $request->query->getInt('page', 1),
            15
        );
        return $this->render('back_office_without_easy_admin/place/browse.html.twig', [
            'places' => $pagination,
        ]);
    }

    /**
     * @Route("/add", name="back_office_place_add", methods={"GET","POST"})
     */
    public function add(Request $request): Response
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($place);
            $entityManager->flush();

            return $this->redirectToRoute('back_office_place_browse');
        }

        return $this->render('back_office_without_easy_admin/place/add.html.twig', [
            'place' => $place,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/read/{id}", name="back_office_place_read", methods={"GET"})
     */
    public function read(Place $place): Response
    {
        return $this->render('back_office_without_easy_admin/place/read.html.twig', [
            'place' => $place,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="back_office_place_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Place $place,PlaceRepository $placeRepository): Response
    {
        $placeObject =  $placeRepository->find($place);
        $placeImage = $placeObject->getImage();
        $form = $this->createForm(PlaceType::class, $place,['attr' => ['placeImage' => $placeImage]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('back_office_place_browse');
        }

        return $this->render('back_office_without_easy_admin/place/edit.html.twig', [
            'place' => $place,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="back_office_place_delete", methods={"POST"})
     */
    public function delete(Request $request, Place $place): Response
    {
        if ($this->isCsrfTokenValid('delete'.$place->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($place);
            $entityManager->flush();
        }

        return $this->redirectToRoute('back_office_place_browse');
    }
}
