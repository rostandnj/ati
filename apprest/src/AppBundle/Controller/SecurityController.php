<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Convert;
use AppBundle\Entity\Presence;
use AppBundle\Entity\StockProduit;


class SecurityController extends Controller

{
      
    public function loginAction(Request $request)
    {
         
        $code = new Convert();

        $ip = $request->getClientIp();


        $data = json_decode($request->getContent(), true);

        $username = $data["username"];
        $password = $data["password"];
        $ad = file_get_contents("https://api.ipify.org?format=json");
        
        $adip = substr($ad, 7,-2);

        $pass = $code->cryptoJsAesDecrypt($username, $password);

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('AppBundle:Utilisateur')->findOneByUsername($username);

        if(!is_object($user))
        {
            return new JsonResponse(array('status'=>2,'message'=>'User Not Found','data'=>array('entity'=>$username)));
        }
        $encoder = $this->container->get('security.password_encoder');
         $date = new \Datetime();

        if($encoder->isPasswordValid($user,$pass))
        {
            $pre = $em->getRepository('AppBundle:Presence')->findOneBy(array("utilisateur"=>$user),array("id"=>"DESC"));

            

           if(is_object($pre))
           {
                if ($pre->getDate()->format('Y-m-d') == $date->format('Y-m-d'))

                {
                    $r = 1;
                }
                else
                {
                    $r = 0;
                }

                if($r == 0)
                {
                    
                    if($pre->getDepart() =="")
                    {
                        $pre->setDepart($date->format('h:i:sa'));
                        $pre->setLogoutip($ip);
                        $pre->setCloseby("system");

                        

                       $pre->setLogoutplace($adip);
                        $em->persist($pre);
                        $em->flush();

                    }
                    $new = new Presence();
                    $new->setDate($date);
                    $new->setLoginip($ip);
                    $new->setUtilisateur($user);
                    $new->setArrivee($date->format('h:i:sa'));
                    $new->setLoginplace($adip);
                    $em->persist($new);
                    $em->flush();
                    
                }

           }
           else
           {
                $new = new Presence();
                    $new->setDate($date);
                    $new->setUtilisateur($user);
                    $new->setArrivee($date->format('h:i:sa'));
                    $new->setLoginip($ip);
                    $new->setLoginplace($adip);
                    $em->persist($new);
                    $em->flush();
           }
           $last =  $em->getRepository('AppBundle:Presence')->findOneBy(array("utilisateur"=>$user),array("id"=>"DESC"));

           

            
            return new JsonResponse(array('status'=>0,'success'=>true,'message'=>'successfull logged','data'=>array('entity'=>$user->toArray($this->container),"time"=>$last->toArray($this->container))));
        }

        return new JsonResponse(array('status'=>$pass,'error'=>'Invalid password','data'=>array('entity'=>null)));

        
    }

    public function logoutAction(Request $request)
    {
         
        
        
            return new JsonResponse(array('status'=>"success",'message'=>'log out ','data'=>array('entity'=>null)));
        
        
    }

    



     
}