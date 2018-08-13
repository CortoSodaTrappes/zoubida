<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\LoginType; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {   
        $user = new Users();
        $form = $this->createForm(LoginType::class, $user);

        $form->handleRequest($request);
        $error = $authenticationUtils->getLastAuthenticationError();

        if ($form->isSubmitted() && $form->isValid()) {
            // return $this->render("home/index.html.twig");
        }
        dump($error);

        return $this->render("static/signin.html.twig", array(
            "formulaire" => $form->createView(),
            "error" => $error
        ));
    }
    
    public function postregister(Request $request, UserPasswordEncoderInterface $encoder)
    {
        if (!filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            echo "Cette (".$request->get('email').") adresse email est considérée comme valide.";
            return $this->returnJson(array("path" =>"/register", "Adresse email non conforme."), 401) ;
        }

        $er = $this->getDoctrine()->getRepository(users::class);
        $userOne = $er->findOneBy(["email" => $request->get('email')]);
        
        if(!$userOne){
            $em = $this->getDoctrine()->getManager();
    
            $user = new Users();
            $user->setName($request->get('firstname') . " " . $request->get('lastname'));
            $user->setEmail($request->get('email'));
            // Encryptage manuel
            // $user->setPassword($this->encryptPassword($request->get('password')));


            $user->setPassword($encoder->encodePassword($user, $request->get('password')));
            $user->setPhone($request->get('tel'));
            $user->setUpdated();
    
            try{
                $em->persist($user);
                $em->flush();
            }catch(\Doctrine\ORM\EntityNotFoundException $e){
                return $this->returnJson(array("path" =>"/register", "Error : invalid request."), 501) ;
            }
   
            if(true){
                return $this->returnJson(array("path" =>"/home", "User created", $request->get('password')), 201) ;
            }else{
                return $this->returnJson(array("path" =>"/register", "User not créated."), 401) ;
                
            }
        }else{
            return $this->returnJson(array("path" =>"/register", "User existed."), 401) ;
        }
    }

    private function returnJson($data, $statusCode){
        return new Response (json_encode($data), $statusCode, array("Content-Type"=> "application/json"));
    }

    public function logout(){
        return $this->redirectToRoute('login');
    }

}