<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
/**
 * @Route("/register", name="user_registration")
 */
public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
 {
 // 1) build the form
 $user = new User();
 $form = $this->createForm(UserType::class, $user);
 $form->handleRequest($request);
 if ($form->isSubmitted() && $form->isValid()) {
    $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
     $user->setPassword($password);
     $entityManager = $this->getDoctrine()->getManager();
     $entityManager->persist($user);
     $entityManager->flush();
     return $this->redirectToRoute('show',['id'=>$user->getId(),
     ]);
     }
     return $this->render('security/form.html.twig',
     array('form' => $form->createView())
     );
     }
     /**
* @Route("/show/{id}", name="show")
*/
public function show2(User $user)
{
return $this->render('security/show.html.twig',[
'user'=>$user,
]);
}
/**
 * @Route("/login", name="login")
 */
public function login(AuthenticationUtils $authenticationUtils)
{
 // get the login error if there is one
 $error = $authenticationUtils->getLastAuthenticationError();

 $lastUsername = $authenticationUtils->getLastUsername();
 return $this->render('security/login.html.twig', [
 'last_username' => $lastUsername,
 'error' => $error,
 ]);
}
#[Route('/logout', name: 'security_logout')]
public function logoutAction(){
    return $this->redirectToRoute('arriere');  
}
#[Route('/users', name: 'users')]
public function users()
{
return $this->render('security/users.html.twig', [
'controller_name' => 'AdminController',
]);
}
}
