<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends Controller
{
    public function index()
    {

        $er = $this->getDoctrine()->getRepository(users::class);
        $users = $er->findByName("Juan Alex");
        dump($users);

        $user = $this->getUser();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            "users" => $users,
            "user" => [
                "nom" => $user->getName(),
                "prenom" => "",
                "avatar" => "https://i1.wp.com/geekirc.me/wp-content/uploads/2017/06/SpongeBob-Miguel-Vasquez-5.jpg",
                // "image" => "assets/static/images/500.png",
            ]
        ]);
        // return $this->redirecttoroute("login");
    }
}
