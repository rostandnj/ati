<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use FOS\RestBundle\Controller\FOSRestController;

class UsersController extends Controller
{
    /**
     * Cette fonction retourne tous les utilisateurs
     * Possibilité de décrire la fonction plus en détails
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retourne les utilisateurs"
     * )
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Article')->findAll();
		
		$serializer = $this->container->get('jms_serializer');
		
		foreach ($users as $key => $user) 
		{
            $users[$key] =json_decode($serializer->serialize($user, 'json'));
			
        }
		return $this->render('AppBundle::index.html.twig');
		//return new JsonResponse(array('code' => 0, "message" => count($users)." Utilisateurs récupérés", "data" => array("users" => $users)));

    }

    public function getUsersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Article')->findAll();
        
        $serializer = $this->container->get('jms_serializer');
        
        foreach ($users as $key => $user) 
        {
            $users[$key] =json_decode($serializer->serialize($user, 'json'));
            
        }
        
        return new JsonResponse(array('code' => 0, "message" => count($users)." Utilisateurs récupérés", "data" => array("users" => $users)));

    }

    /**
     * Cette fonction retourne un utilisateur
     * Possibilité de décrire la fonction plus en détails
     *
     * @ApiDoc(
     *  description="Retourne un utilisateur",
     *  parameters={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="identifiant de l'utilisateur"}
     *  }
     * )
     *
     * @param User $user
     * @return array
     */
    public function getUserAction(User $user)
    {
        return array('user' => $user);
    }
}