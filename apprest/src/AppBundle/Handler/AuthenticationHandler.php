<?php
namespace AppBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    use \Symfony\Component\DependencyInjection\ContainerAwareTrait;
    function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $token->getUser()->setLastLogin(new \DateTime());
        $this->container->get('doctrine')->getManager()->flush();


        return new RedirectResponse($this->container->get('router')->generate('rest_user_all_index'));
    }
}