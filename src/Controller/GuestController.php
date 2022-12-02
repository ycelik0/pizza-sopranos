<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\Pizza;
use App\Entity\ShoppingcartPizza;
use App\Form\OrderPayFormType;
use App\Form\ShoppingcartFormType;
use App\Repository\CategoryRepository;
use App\Repository\OrdersRepository;
use App\Repository\PizzaRepository;
use App\Repository\ShoppingcartPizzaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GuestController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function showHomepage(PizzaRepository $pizzaRepository, CategoryRepository $categoryRepository): Response
    {
        $dataPizzas = $pizzaRepository->findAll();
        $dataCategory = $categoryRepository->findAll();

        $dataPizzasSliced = array_slice($dataPizzas, 0, 3);

        return $this->render('homepage.html.twig', [
            'dataPizzas' => $dataPizzas,
            'dataCategory' => $dataCategory,
            'dataPizzasSliced' => $dataPizzasSliced,
        ]);
    }

    #[Route('/menu', name: 'app_menu')]
    public function showMenu(PizzaRepository $pizzaRepository, CategoryRepository $categoryRepository): Response
    {
        $dataPizzas = $pizzaRepository->findAll();
        $dataCategory = $categoryRepository->findAll();

        return $this->render('menu.html.twig', [
            'dataPizzas' => $dataPizzas,
            'dataCategory' => $dataCategory,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function showAbout(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route('/contact', name: 'app_contact')]
    public function showContact(): Response
    {
        return $this->render('contact.html.twig');
    }

    #[Route('/order/category/{id}', name: 'app_order')]
    public function showOrder($id, PizzaRepository $pizzaRepository, CategoryRepository $categoryRepository, ShoppingcartPizzaRepository $shoppingcartPizzaRepository): Response
    {
        $user = $this->getUser();
        $dataPizzas = $pizzaRepository->findBy(['category' => $id]);
        $dataCategory = $categoryRepository->findAll();
        $dataShoppingcarts = $shoppingcartPizzaRepository->findBy(['user' => $user]);

        if ($dataShoppingcarts !== []) {
            $totalPrice = 0;
            foreach ($dataShoppingcarts as $data) {
                $totalPrice += $data->getPizza()->getPrice() * $data->getAmount();
            }
        } else {
            $totalPrice = '';
        }
//        dd($totalPrice);
        return $this->renderForm('order.html.twig', [
            'dataPizzas' => $dataPizzas,
            'dataCategory' => $dataCategory,
            'dataShoppingcart' => $dataShoppingcarts,
            'user' => $user,
            'totalPrice' => $totalPrice,
        ]);
    }

    #[Route('/order/delete/{id}', name: 'app_order_delete')]
    public function shoppingcartDelete($id, EntityManagerInterface $entityManager, ShoppingcartPizzaRepository $shoppingcartPizzaRepository): Response
    {
        $dataShoppingcarts = $shoppingcartPizzaRepository->find(['id' => $id]);
        $entityManager->remove($dataShoppingcarts);
        $entityManager->flush();

        return $this->redirectToRoute('app_order', ['id' => 1]);
    }

    #[Route('/order/pizza/{id}', name: 'app_pizza_order')]
    public function showCustomizePizza($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $pizza = $entityManager->getRepository(Pizza::class)->find($id);

        $shoppingcart = new ShoppingcartPizza();

        $shoppingcart->setPizza($pizza);
        $shoppingcart->setUser($user);

        $form = $this->createForm(ShoppingcartFormType::class, $shoppingcart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($form->getData());
            $entityManager->flush();
            return $this->redirectToRoute('app_order', ['id' => 1]);
        }
        return $this->renderForm('pizza_order.html.twig', [
            'form' => $form,
            'dataPizza' => $pizza,
        ]);
    }

    #[Route('/order/checkout', name: 'app_order_pay')]
    public function showOrderPay(ShoppingcartPizzaRepository $shoppingcartPizzaRepository, EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer): Response
    {
        $user = $this->getUser();
        $dataShoppingcart = $shoppingcartPizzaRepository->findBy(['user' => $user]);

        if (!$dataShoppingcart == []) {
            $order = new Orders();
            $order->setUser($user);
            $order->setOrderStatus('prepared');

            for ($i = 0; $i < count($dataShoppingcart); $i++) {
                $serializingShoppingcart[$i] = $serializer->serialize($dataShoppingcart[$i], 'json');
            }
            $serializedShoppingcart = implode('#', $serializingShoppingcart);
            $order->setShoppingcart($serializedShoppingcart);

            $totalPrice = 0;
            foreach ($dataShoppingcart as $data) {
                $totalPrice += $data->getPizza()->getPrice() * $data->getAmount();
            }

            $form = $this->createForm(OrderPayFormType::class, $order);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($form->getData());
                foreach ($dataShoppingcart as $shoppingcart) {
                    $entityManager->remove($shoppingcart);
                }
                $entityManager->flush();
                $this->addFlash('orderMessage', 'Bedankt voor je bestelling. Je bestelling komt er zo aan');
                return $this->redirectToRoute('app_profile');
            }
        } else {
            $form = null;
            $totalPrice = '';
        }

        return $this->renderForm('checkout.html.twig', [
            'form' => $form,
            'dataShoppingcart' => $dataShoppingcart,
            'totalPrice' => $totalPrice,
        ]);
    }

    #[Route('/profile', name: 'app_profile', methods: 'GET')]
    public function showProfile(OrdersRepository $ordersRepository, SerializerInterface $serializer): Response
    {
        $user = $this->getUser();
        $orders = $ordersRepository->findBy(['user' => $user]);

        if ($orders == []) {
            $shoppingcarts = [];
        } else {
            foreach ($orders as $order) {
                $shoppingcarts = [];
                $explodedShoppingcart = explode('#', $order->getShoppingcart());
                for ($i = 0; $i < count($explodedShoppingcart); $i++) {
                    $shoppingcarts[] = $serializer->deserialize($explodedShoppingcart[$i], ShoppingcartPizza::class, 'json');
                }
                $order->setShoppingcart($shoppingcarts);
            }
        }

        return $this->render('profile.html.twig', [
            'user' => $user,
            'shoppingcarts' => $shoppingcarts,
            'orders' => $orders,
        ]);
    }
}