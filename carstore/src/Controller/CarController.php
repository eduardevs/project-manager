<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Form\SearchType;
use App\Model\SearchData;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\MeteoService;

class CarController extends AbstractController
{
    private MeteoService $meteoService;
    public $weather;

    public function __construct(MeteoService $meteoService) {
        $this->meteoService = $meteoService;
        $this->weather = $this->meteoService->fetchMeteo();
    }

    #[Route('/', name: 'app_admin', methods: ['GET'])]
    public function index(CarRepository $repository, Request $request): Response
    {
        // Filters
        $searchData = new SearchData();
        // Form
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $cars = $repository->findBySearch($searchData);

            return $this->render('cars/main.html.twig', [
                'form' => $form->createView(),
                'cars' => $cars,
                'weather' => $this->weather,
            ]);
        }

        return $this->render('cars/main.html.twig', [
            'controller_name' => 'CarController',
            'cars' => $repository->findAll(),
            'weather' => $this->weather,
            'form' => $form->createView()
        ]);
    }

    #[Route('/cars/new/', name: 'app_new_car', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $carInstance = $form->getData();
            $manager->persist($carInstance);
            $manager->flush();
        }
        return $this->redirectToRoute('app_admin');

        return $this->render('cars/new.html.twig', [
            'controller_name' => 'CarController',
            'form' => $form->createView(),
            'weather' => $this->weather
        ]);
    }

    #[Route('/cars/{id}', name: 'app_single_car', methods: ['GET'])]
    public function show(CarRepository $carRepository, $id): Response
    {
        $car = $carRepository->find($id);

        return $this->render('cars/car.html.twig', [
            'controller_name' => 'CarController',
            'car' => $car,
            'weather' => $this->weather
        ]);
    }

    #[Route('/cars/edit/{id}', name: 'app_edit_car', methods: ['GET','POST'])]
    public function edit(CarRepository $carRepository, $id, Request $request, EntityManagerInterface $manager): Response
    {
        $car = $carRepository->find($id);
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $carInstance = $form->getData();
            $manager->persist($carInstance);
            $manager->flush();

            $this->addFlash(
                'success',
                'The user has been updated succesfully !'
            );

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('cars/edit.html.twig', [
            'controller_name' => 'CarController',
            'form' => $form->createView(),
            'weather' => $this->weather
        ]);
    }

    #[Route('/cars/delete/{id}', 'car_delete', methods: ['POST'])]
    public function delete(EntityManagerInterface $manager, CarRepository $carRepository, $id) : Response {   
        $car = $carRepository->find($id); 
        if(!$car) {
            $this->addFlash(
                'fail',
                'Oops ! The car has not been found.'
            );

            return $this->redirectToRoute('app_admin');
        }
        //add validation javascript pour demander avant la suppresion
    $manager->remove($car);
    $manager->flush();

    $this->addFlash(
        'success',
        'The car was succesfully removed!'
    );

    return $this->redirectToRoute('app_admin');
    }
}
