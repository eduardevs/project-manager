<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    #[Route('/admin/cars', name: 'app_car', methods: ['GET'])]
    public function index(CarRepository $carRepository): Response
    {
        $carsList = $carRepository->findAll();

        return $this->render('admin/cars/index.html.twig', [
            'controller_name' => 'CarController',
            'cars' => $carsList
        ]);
    }

    #[Route('/admin/cars/new/', name: 'app_new_car', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {

        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        // dd($form);
        
        if($form->isSubmitted() && $form->isValid()) {
            
            $carInstance = $form->getData();
            $manager->persist($carInstance);
            $manager->flush();
        }

        return $this->render('admin/cars/new.html.twig', [
            'controller_name' => 'CarController',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/cars/{id}', name: 'app_single_car', methods: ['GET','POST'])]
    public function edit(CarRepository $carRepository, $id): Response
    {
        $car = $carRepository->find($id);

        // dd($car);

        return $this->render('admin/cars/car.html.twig', [
            'controller_name' => 'CarController',
            'car' => $car,
        ]);
    }


}
