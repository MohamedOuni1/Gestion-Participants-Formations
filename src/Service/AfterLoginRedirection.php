<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use
Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use App\Entity\User;
/**
* Class AfterLoginRedirection
*
* @package App\Service
*/
class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
private $router;
/**
* AfterLoginRedirection constructor.
*
* @param RouterInterface $router
*/
public function __construct(RouterInterface $router)
{
$this->router = $router;
}
/**
* @param Request $request
*
* @param TokenInterface $token
*
* @return RedirectResponse
*/
public function onAuthenticationSuccess(Request $request, TokenInterface 
$token)
{
$roles = $token->getRoleNames();
$rolesTab = array_map(function ($role) {
return $role;
}, $roles);
if (in_array('ROLE_ADMIN', $rolesTab, true)) {
// c'est un aministrateur : on le rediriger vers l'espace admin
$redirection = new RedirectResponse($this->router->generate('admin'));
} else {
// c'est un utilisaeur lambda : on le rediriger vers l'accueil
$redirection = new RedirectResponse($this->router->generate('users'));
}
return $redirection;
}
}