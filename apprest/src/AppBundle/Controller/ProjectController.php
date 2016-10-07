<?php

namespace AppBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\FOSRestController;



use AppBundle\Entity\Utilisateur;
use AppBundle\Entity\Projet;
use AppBundle\Entity\Antenne;
use AppBundle\Entity\Poste;
use AppBundle\Entity\Image;
use AppBundle\Entity\Evolution;
use AppBundle\Entity\Depense;
use AppBundle\Entity\Blocage;
use AppBundle\Entity\File;


/**
 * Project controller.
 *
 */
class ProjectController extends Controller
{

	private function auth(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $apikey = $request->headers->get('Authorization');

        $apikey = substr($apikey,6);
        $apikey= base64_decode($apikey);
        $apikey = substr($apikey, strpos($apikey, ":") + 1); 

        $user = $em->getRepository('AppBundle:Utilisateur')->findOneByApiKey($apikey);
        return $user;
    }

	public function indexAction(Request $request)
    {
        
    	$u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();
        

        $projets = $em->getRepository('AppBundle:Projet')->findBy(array('statut'=>false));



        foreach ($projets as $key => $projet) 
        {
            $projets[$key] =  $projet->toArray($this->container);
            
        }

         return new JsonResponse(array('code' => 0, "message" => count($projets)."Projet(s) récupéré(s)", "data" => array("entities" => $projets)));

        
    
    }

    public function newAction(Request $request)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }

        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        

   		$data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        if(!is_null($data))
        {
        	$user = $this->auth($request);
        	
        	$projet = new Projet();
        	$projet->setUtilisateur($user);
        	$projet->setLibelle($data["libelle"]);
        	$projet->setDateDebut(new \Datetime($data["datedebut"]));
        	$projet->setDateFin(new \Datetime($data["datefin"]));
        	$projet->setClosedate(new \Datetime($data["datefin"]));
        	$projet->setdelais(0);
        	$projet->setMoa($data["moa"]);

        	$start = strtotime($data["datedebut"]);
		    $end = strtotime($data["datefin"]);
		    $days = $end - $start;
		    $days = ceil($days/86400);
		    $projet->setDelais($days);


        	if(array_key_exists("image", $data))
	        {

	            $image = substr($data["image"], strpos( $data["image"],';')+1);
	            list($type, $image) = explode(';', $image);
	            list(, $image)      = explode(',', $image);
	            list(, $type)      = explode(':', $type);
	            $image = base64_decode($image);
	            $types = array('image/jpg','image/jpeg','image/png','image/gif');
	            $filepath = __DIR__.'/../../../web/uploads/';
	            $base = $filepath;
	            $baseok = " C:\\xampp\htdocs\apprest\\web\\uploads\\";
	            $filename = uniqid();
	            
	            $r = false;
	            if($key = array_search($type, $types))
	            {
	                switch ($key) 
	                {
	                    case 0:
	                        $filename .= '.jpg';
	                        $ext='.jpg';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    case 1:
	                        $filename .= '.jpeg';
	                        $ext='.jpeg';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                       
	                        break;
	                    case 2:
	                        $filename .= '.png';
	                        $ext='.png';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    case 3:
	                        $filename .= '.gif';
	                        $ext='.gif';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    
	                    default:
	                        # code...
	                        break;
	                }
	            }
	            if($r)
	            {
	                $img = new Image();
	                $img->setNom($filename);
	                $img->setSize($r);
	                $img->setPath($filename);
	                $img->setExtension($ext);
	                $img->setType("projet");

	                $projet->setImage($img);
	                

	            }
	        }
	        if(array_key_exists("file", $data))
            {

                $file= substr($data["file"], strpos( $data["file"],';')+1);
                list($type, $file) = explode(';', $file);
                list(, $file)      = explode(',', $file);
                list(, $type)      = explode(':', $type);
                $file = base64_decode($file);
                $filepath = __DIR__.'/../../../web/uploads/';
                $base = $filepath;
                $baseok = " C:\\xampp\htdocs\apprest\\web\\uploads\\";
                $filename = uniqid();
                
                
                $filename .= '.pdf';
                $ext='.pdf';
                $filepath = $base.$filename;
                $re = file_put_contents($filepath, $file);

                $f = new File();
                $f->setNom($filename);
                $f->setSize($re);
                $f->setPath($filename);
                $f->setExtension($ext);
                $f->setType("projet");
                $projet->setFile($f);
                            
            }
	       
	        try
	        {   
	                
	                $em->persist($projet);
	                $em->flush();
	        }
	        catch(\Exception $e)
	        {
	            return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
	        }

        	return new JsonResponse(array('code' => 0, "message" =>" project successful create ", "data" => array("entity"=>$projet->toArray($this->container))));
    	}
		return new JsonResponse(array('code' => 0, "message" =>"formulaire d un projet ", "data" => array("entity"=>null)));
	}

	public function showAction(Request $request, Projet $projet)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();
        if(!is_null($projet))
        {
        	$daten = new \Datetime();
        	$nb = $daten->diff($projet->getDateFin());
        	$nb = $nb->format('%R%a ');
                   

        	return new JsonResponse(array('code' => 0, "message" => "Projet) récupéré", "data" => array("entity" => $projet->toArray($this->container),'remain'=>$nb)));
        }
        
        return new JsonResponse(array('code' => 0, "message" => "Projet inexistant", "data" => array("entity" => null)));

        
    
    }

    public function evolutionAction(Request $request, Projet $projet)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        

   		$data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        
        if(!is_null($projet))
        {


        if(!is_null($data))
        {
        	
        	$evolution = new Evolution();
        	$evolution->setLibelle($data["libelle"]);
        	$evolution->setProjet($projet);
        	$evolution->setPourcentage($data["pourcentage"]);


        	if(array_key_exists("image", $data))
	        {

	            $image = substr($data["image"], strpos( $data["image"],';')+1);
	            list($type, $image) = explode(';', $image);
	            list(, $image)      = explode(',', $image);
	            list(, $type)      = explode(':', $type);
	            $image = base64_decode($image);
	            $types = array('image/jpg','image/jpeg','image/png','image/gif');
	            $filepath = __DIR__.'/../../../web/uploads/';
	            $base = $filepath;
	            $baseok = " C:\\xampp\htdocs\apprest\\web\\uploads\\";
	            $filename = uniqid();
	            
	            $r = false;
	            if($key = array_search($type, $types))
	            {
	                switch ($key) 
	                {
	                    case 0:
	                        $filename .= '.jpg';
	                        $ext='.jpg';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    case 1:
	                        $filename .= '.jpeg';
	                        $ext='.jpeg';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                       
	                        break;
	                    case 2:
	                        $filename .= '.png';
	                        $ext='.png';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    case 3:
	                        $filename .= '.gif';
	                        $ext='.gif';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    
	                    default:
	                        # code...
	                        break;
	                }
	            }
	            if($r)
	            {
	                $img = new Image();
	                $img->setNom($filename);
	                $img->setSize($r);
	                $img->setPath($filename);
	                $img->setExtension($ext);
	                $img->setType("projet");


	                $evolution->setImage($img);
	               

	            }
	        }
	       
	        try
	        {   
	                
	                $em->persist($evolution);
	                $em->flush();
	        }
	        catch(\Exception $e)
	        {
	            return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
	        }

        	return new JsonResponse(array('code' => 0, "message" =>" evolution successful added ", "data" => array("entity"=>$projet->toArray($this->container))));
    	}
    }
		return new JsonResponse(array('code' => 0, "message" =>"formulaire d un projet ", "data" => array("entity"=>null)));
	}

	public function expenditureAction(Request $request, Projet $projet)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
   		$data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        
        if(!is_null($projet))
        {

        if(!is_null($data))
        {
        	
        	$depense = new Depense();
        	$depense->setLibelle($data["libelle"]);
        	$depense->setProjet($projet);
        	$depense->setMontant($data["montant"]);
        	


        	if(array_key_exists("image", $data))
	        {

	            $image = substr($data["image"], strpos( $data["image"],';')+1);
	            list($type, $image) = explode(';', $image);
	            list(, $image)      = explode(',', $image);
	            list(, $type)      = explode(':', $type);
	            $image = base64_decode($image);
	            $types = array('image/jpg','image/jpeg','image/png','image/gif');
	            $filepath = __DIR__.'/../../../web/uploads/';
	            $base = $filepath;
	            $baseok = " C:\\xampp\htdocs\apprest\\web\\uploads\\";
	            $filename = uniqid();
	            
	            $r = false;
	            if($key = array_search($type, $types))
	            {
	                switch ($key) 
	                {
	                    case 0:
	                        $filename .= '.jpg';
	                        $ext='.jpg';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    case 1:
	                        $filename .= '.jpeg';
	                        $ext='.jpeg';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                       
	                        break;
	                    case 2:
	                        $filename .= '.png';
	                        $ext='.png';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    case 3:
	                        $filename .= '.gif';
	                        $ext='.gif';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    
	                    default:
	                        # code...
	                        break;
	                }
	            }
	            if($r)
	            {
	                $img = new Image();
	                $img->setNom($filename);
	                $img->setSize($r);
	                $img->setPath($filename);
	                $img->setExtension($ext);
	                $img->setType("projet");


	                $depense->setImage($img);
	                
	            }
	        }
	       
	        try
	        {   
	                
	                $em->persist($depense);
	                $em->flush();
	        }
	        catch(\Exception $e)
	        {
	            return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
	        }

        	return new JsonResponse(array('code' => 0, "message" =>" expenditure successful added ", "data" => array("entity"=>$projet->toArray($this->container))));
    	}
    }
		return new JsonResponse(array('code' => 0, "message" =>"formulaire d une depense ", "data" => array("entity"=>null)));
	}


	public function blocageAction(Request $request, Projet $projet)
    {
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
   		$data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

        
        if(!is_null($projet))
        {

        if(!is_null($data))
        {
        	
        	$blocage = new Blocage();
        	$blocage->setLibelle($data["libelle"]);
        	$blocage->setDescription($data["description"]);
        	$blocage->setProjet($projet);


        	if(array_key_exists("image", $data))
	        {

	            $image = substr($data["image"], strpos( $data["image"],';')+1);
	            list($type, $image) = explode(';', $image);
	            list(, $image)      = explode(',', $image);
	            list(, $type)      = explode(':', $type);
	            $image = base64_decode($image);
	            $types = array('image/jpg','image/jpeg','image/png','image/gif');
	            $filepath = __DIR__.'/../../../web/uploads/';
	            $base = $filepath;
	            $baseok = " C:\\xampp\htdocs\apprest\\web\\uploads\\";
	            $filename = uniqid();
	            
	            $r = false;
	            if($key = array_search($type, $types))
	            {
	                switch ($key) 
	                {
	                    case 0:
	                        $filename .= '.jpg';
	                        $ext='.jpg';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    case 1:
	                        $filename .= '.jpeg';
	                        $ext='.jpeg';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                       
	                        break;
	                    case 2:
	                        $filename .= '.png';
	                        $ext='.png';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    case 3:
	                        $filename .= '.gif';
	                        $ext='.gif';
	                        $filepath = $base.$filename;
	                        $r = file_put_contents($filepath, $image);
	                        break;
	                    
	                    default:
	                        # code...
	                        break;
	                }
	            }
	            if($r)
	            {
	                $img = new Image();
	                $img->setNom($filename);
	                $img->setSize($r);
	                $img->setPath($baseok.$filename);
	                $img->setExtension($ext);
	                $img->setType("projet");


	                $blocage->setImage($img);
	                

	            }
	        }
	       
	        try
	        {   
	                
	                $em->persist($blocage);
	                $em->flush();
	        }
	        catch(\Exception $e)
	        {
	            return new JsonResponse(array('code' => 2, "message" => $e->getMessage()." à la ligne ".$e->getLine()." du fichier ".$e->getFile() , "data" => array("entity"=>null)));
	        }

        	return new JsonResponse(array('code' => 0, "message" =>" evolution successful added ", "data" => array("entity"=>$projet->toArray($this->container))));
    	}
    }
		return new JsonResponse(array('code' => 0, "message" =>"formulaire d un projet ", "data" => array("entity"=>null)));
	}

	public function endAction(Request $request, Projet $project)
	{
		$u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        if( is_object($u) && ($u->getRoles()[0] != 'ROLE_MANAGER'))
        {
             return new JsonResponse(array('code'=>4,"message"=>"unauthorized"));
            
        }
        
		$data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

		if(!is_null($project))
		{
			if(!is_null($data))
			{
				
					$project->setStatut(true);
					$project->setClosedate(new \Datetime());
					$em->persist($project);
					$em->flush();
				
				
				

				return new JsonResponse(array('code' => 0, "message" =>"project cloture ", "data" => array("entity"=>$project->toArray($this->container))));

			}
			return new JsonResponse(array('code' => 0, "message" =>"form ", "data" => array("entity"=>$project->toArray($this->container))));

		}
		return new JsonResponse(array('code' => 2, "message" =>"projet inexistant ", "data" => array("entity"=>null)));

	}

	public function statAction(Request $request)
	{
		$u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
		$data = json_decode($request->getContent(), true);
        $em = $this->getDoctrine()->getManager();

		$projects = $em->getRepository('AppBundle:Projet')->findByStatut(true);

		$order = [];
		$month =[];
		$date = new \Datetime();
			$year = $date->format('y');

		

		foreach ($projects as $key => $project) 
		{
			
			
			if(($project->getDateDebut()->format('y') == $date->format('y'))&&($project->getDateDebut()->format('m') <= $date->format('m')))
			{
				if(!in_array(date_format($project->getDateDebut(),'F'), $month))
				{
					$month[] = date_format($project->getDateDebut(),'F');
				}
				$order[] = $project->toArray($this->container);
			}
			

			
		}
		return new JsonResponse(array('code' => 0, "message" =>"Archive", "data" => array("entities"=>$order,'month'=>$month,'year'=>$year)));

	}

	public function apilistAction(Request $request)
    {
    	$u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();
        

        $projets = $em->getRepository('AppBundle:Projet')->findAll();



        foreach ($projets as $key => $projet) 
        {
            $projets[$key] =  $projet->toArray($this->container);
            
        }

         return new JsonResponse($projets);

        
    
    }

    function printdepAction(Request $request,Projet $projet)
    {


        
        $u = $this->auth($request);
        if(!is_object($u))
        {
            return new JsonResponse(array('code'=>3,"message"=>"access denied!!!"));
        }
        $em = $this->getDoctrine()->getManager();

        $all=[];
        $date = new \Datetime();

        foreach ($projet->getDepenses() as $key => $depense) 
        {
        	$all[]=$depense;
        }


        

        $html = $this->renderView('AppBundle:ati:doc_pro.html.twig', array('date'=>$date,"stat"=>$all,"projet"=>$projet));

        $html2pdf = $this->get('html2pdf_factory')->create('P','A4','fr', false, 'ISO-8859-15', array(10, 10, 10, 5));

        $html2pdf->pdf->SetDisplayMode('fullpage');

        $html2pdf->writeHTML($html,isset($_GET['vuehtml']));



        $nom = 'project_'.uniqid().'.pdf';

        //$file = base64_encode($html2pdf->Output($nom));

        //$filepath = __DIR__.'/../../../web/uploads/'.$nom;

        $html2pdf->Output('../../user/'.$nom, 'F');

       

       
        //$re = file_put_contents($filepath, $html2pdf);

        return new JsonResponse(array("code"=>0,"data"=>$nom));

    }


}