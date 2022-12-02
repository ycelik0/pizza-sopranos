<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Entity\ShoppingcartPizza;
use App\Form\AddPizzaFormType;
use App\Form\ChangeOrderStatusType;
use App\Form\DeletePizzaFormType;
use App\Repository\OrdersRepository;
use App\Repository\PizzaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminDashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(PizzaRepository $pizzaRepository): Response
    {
        $data = $pizzaRepository->findAll();

        return $this->render('admin_dashboard.html.twig', [
            'allData' => $data,
        ]);
    }

    #[Route('/admin/dashboard/add/pizza', name: 'app_add_pizza')]
    public function addPizza(SluggerInterface $slugger, Request $request, EntityManagerInterface $entityManager)
    {
        $pizza = new Pizza();
        $form = $this->createForm(AddPizzaFormType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('file_upload'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    error_log($e->getMessage());
                }

                $pizza->setImage($newFilename);

                $entityManager->persist($form->getData());
                $entityManager->flush();

                return $this->redirectToRoute('app_admin_dashboard');
            }
        }
        return $this->renderForm('add_pizza.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/edit/pizza/{id}', name: 'app_edit_pizza')]
    public function showEditPizza($id, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger, Filesystem $filesystem): Response
    {
        $pizza = $entityManager->getRepository(Pizza::class)->find($id);
        $form = $this->createForm(AddPizzaFormType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newImageFile = $form->get('image')->getData();
            if ($newImageFile) {
                $originalFilename = pathinfo($newImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $newImageFile->guessExtension();
                try {
                    $newImageFile->move(
                        $this->getParameter('file_upload'),
                        $newFilename
                    );
                    $projectDir = $this->getParameter('kernel.project_dir');
                    $filesystem->remove($projectDir . '/public/assets/images/' . $pizza->getImage());;
                    $pizza->setImage($newFilename);
                } catch (FileException $e) {
                    error_log($e->getMessage());
                }
            }

            $entityManager->persist($form->getData());
            $entityManager->flush();
        }

        return $this->renderForm('edit_pizza.html.twig', [
            'pizza' => $pizza,
            'form' => $form,
        ]);
    }

    #[Route('admin/dashboard/delete/pizza/{id}', name: 'app_delete_pizza')]
    public function deletePizza($id, EntityManagerInterface $entityManager, Request $request, Filesystem $filesystem): Response
    {
        $pizza = $entityManager->getRepository(Pizza::class)->find($id);

        $form = $this->createForm(DeletePizzaFormType::class, $pizza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projectDir = $this->getParameter('kernel.project_dir');
            $filesystem->remove($projectDir . '/public/assets/images/' . $pizza->getImage());

            $entityManager->remove($pizza);
            $entityManager->flush();
        }

        return $this->renderForm('delete_pizza.html.twig', [
            'pizza' => $pizza,
            'form' => $form,
        ]);
    }

    #[Route('/admin/dashboard/order/status', name: 'app_order_status', methods: 'GET')]
    public function orderStatus(OrdersRepository $ordersRepository, SerializerInterface $serializer): Response
    {
        $user = $this->getUser();
        $orders = $ordersRepository->findBy(['user' => $user]);

        foreach ($orders as $order) {
            $shoppingcarts = [];
            $explodedShoppingcart = explode('#', $order->getShoppingcart());
            for ($i = 0; $i < count($explodedShoppingcart); $i++) {
                $shoppingcarts[] = $serializer->deserialize($explodedShoppingcart[$i], ShoppingcartPizza::class, 'json');
            }
            $order->setShoppingcart($shoppingcarts);
        }

        return $this->render('order_status.html.twig', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    #[Route('/admin/dashboard/order/status/order/{id}', name: 'app_change_order_status', methods: 'GET')]
    public function orderStatusPrepared($id, OrdersRepository $ordersRepository, EntityManagerInterface $entityManager): Response
    {
        $order = $ordersRepository->find(['id' => $id]);

        if ($order->getOrderStatus() == 'prepared') {
            $order->setOrderStatus('delivery');
        } else if ($order->getOrderStatus() == 'delivery') {
            $order->setOrderStatus('done');
        } else if ($order->getOrderStatus() == 'done') {
            $order->setOrderStatus('prepared');
        }

        $entityManager->persist($order);
        $entityManager->flush();

        return $this->redirectToRoute('app_order_status');
    }
}
