<?php

namespace Koyaan\GlobeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Koyaan\GlobeBundle\Classes\Geobin;
use Koyaan\GlobeBundle\Entity\Globe;

class DefaultController extends Controller {

     /**
     * @Route("/squareglobe/s/{token}")
     * @Template()
     */
    public function savedAction($token) {
        $em = $this->getDoctrine()->getEntityManager();

        $userGlobe = $em->getRepository('KoyaanGlobeBundle:Globe')->findOneByToken($token);

        if (!$userGlobe) {
            throw $this->createNotFoundException('Unable to find Globe entity.');
        }
        
        if(!$userGlobe->getPublic()) {
            throw $this->createNotFoundException('Globe entity not public.');
        }
        
        return(array("token" => $userGlobe->getToken(), "name" => $userGlobe->getName()));
    }

    /**
     * @Route("/squareglobe/save")
     * @Method("post")
     */
    public function saveAction() {
        
        $token = $this->getRequest()->get("token");
        $picture = $this->getRequest()->get("snapshot");
        
        $em = $this->getDoctrine()->getEntityManager();

        $userGlobe = $em->getRepository('KoyaanGlobeBundle:Globe')->findOneByToken($token);

        if (!$userGlobe) {
            throw $this->createNotFoundException('Unable to find Globe entity.');
        }
        
        $userGlobe->setPublic(true);
        $userGlobe->setPicture($picture);
        $em->persist($userGlobe);
        $em->flush();
        
        return new Response("");
    }

    
    /**
     * @Route("/squareglobe")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

    /**
     * @Route("/squareglobe/dataulf")
     * @Template()
     */
    public function dataulfAction() {
        return array();
    }

    /**
     * @Route("/squareglobe/my")
     * @Template()
     */
    public function myAction() {
        $app_client_id = "UUXGV3BSLTGTJY0QDJWB1BHLAFLSKWH521MNHSL4T0YF5FUN";
        $app_client_secret = "CRMGOVHE2J4Q5AEVTJTJ4PYMC1X0DQRG1Y2CR54XXICXA5BJ";
        $app_redirect_uri = "http://koyaan.com/squareglobe/my";

        if (!$this->getRequest()->get("code")) {
            return $this->redirect("https://foursquare.com/oauth2/authenticate?client_id=" . $app_client_id . "&response_type=code&redirect_uri=" . $app_redirect_uri);
        } else {
            $code = $this->getRequest()->get("code");
            $JSONtoken = file_get_contents("https://foursquare.com/oauth2/access_token?client_id=" . $app_client_id . "&client_secret=" . $app_client_secret . "&grant_type=authorization_code&redirect_uri=" . $app_redirect_uri . "&code=" . $code);
            $accessToken = json_decode($JSONtoken)->access_token;
            $userName = $this->getUserName($accessToken);
            $globeToken = $this->createUserGlobe($accessToken,$userName);
            return(array("token" => $globeToken, "name" => $userName));
        }
    }

    /*
     * returns token of new globe
     */

    private function createUserGlobe($oauthToken,$userName) {

        $userGlobe = new Globe();
        $userGlobe->setName($userName);
        $userGlobe->setAccessToken($oauthToken);
        $userGlobe->setToken(substr(sha1($userName . time() . rand(0, 1000)),0,10)) ;
        $userGlobe->setPublic(false);
        $userGlobe->setData("B33F");
        $userGlobe->setPicture("B00BS");

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($userGlobe);
        $em->flush();

        return $userGlobe->getToken();
    }

    private function getUserName($oauthToken) {
        $data = file_get_contents("https://api.foursquare.com/v2/users/self?v=" . date("Ymd") . "&oauth_token=" . $oauthToken);
        $dataObject = json_decode($data);
        return $dataObject->response->user->firstName . " " . $dataObject->response->user->lastName;
    }

    /**
     * @Route("/squareglobe/getdata/{token}")
     */
    public function getdataAction($token) {
        
        $em = $this->getDoctrine()->getEntityManager();

        $userGlobe = $em->getRepository('KoyaanGlobeBundle:Globe')->findOneByToken($token);

        if (!$userGlobe) {
            throw $this->createNotFoundException('Unable to find Globe entity.');
        }
        
        return new Response($userGlobe->getData());
    }
    
     /**
     * @Route("/squareglobe/image/{token}.png")
     */
    public function imageAction($token) {
        $em = $this->getDoctrine()->getEntityManager();

        $userGlobe = $em->getRepository('KoyaanGlobeBundle:Globe')->findOneByToken($token);

        if (!$userGlobe) {
            throw $this->createNotFoundException('Unable to find Globe entity.');
        }
        
        $data = explode(";", $userGlobe->getPicture());
        $type = $data[0];
        $data = explode(",", $data[1]);
		$headers = array('Content-Type'     => 'image/png',
           'Content-Disposition' => 'inline; filename="'.$token.'.png"');
      //  $response = new Response();
     //   $response->setContent(base64_decode($data[1]));
     //   $response->setStatusCode(200);
   //     $response->headers->set('Content-Type', $type);
        
      return new Response(base64_decode($data[1]), 200, $headers);
  //      return $response;   
    }
    
     /**
     * @Route("/squareglobe/data/{token}")
     */
    public function dataAction($token) {
        $resolution = 100;

        $em = $this->getDoctrine()->getEntityManager();

        $userGlobe = $em->getRepository('KoyaanGlobeBundle:Globe')->findOneByToken($token);

        if (!$userGlobe) {
            throw $this->createNotFoundException('Unable to find Globe entity.');
        }

        $geobinsSelf = array();
        $geobinsSelf = $this->getData($geobinsSelf, $userGlobe->getAccessToken(), 0, "self");

        $data = "";
        $data .= '[';
        $data .= '["self",[';
        $flat = array();
        foreach ($geobinsSelf as $bin) {
            $flat[] = $bin->lat;
            $flat[] = $bin->lng;
            if ($bin->count > $resolution) {
                $flat[] = 1;
            } else {
                $flat[] = $bin->count / $resolution;
            }
        }
        $data .= implode(",", $flat);
        $data .= ']]]';

        $userGlobe->setData($data);
        $em->persist($userGlobe);
        $em->flush();
        
        return new Response($data);
    }
    
    


    private function getData($geobins, $oauthToken, $offset = 0, $subject = "self") {

        if ($subject == "self") {
            $data = file_get_contents("https://api.foursquare.com/v2/users/self/checkins?v=" . date("Ymd") . "&oauth_token=" . $oauthToken . "&limit=250&offset=" . $offset);
            $dataObject = json_decode($data);
            $checkins = $dataObject->response->checkins->items;
        } else if ($subject == "recent") {
            $data = file_get_contents("https://api.foursquare.com/v2/checkins/recent?v=" . date("Ymd") . "&oauth_token=" . $oauthToken);
            $dataObject = json_decode($data);
            $checkins = $dataObject->response->recent;
        }

        foreach ($checkins as $checkin) {

            if (isset($checkin->venue->location)) {
                $location = $checkin->venue->location;
            } else {
                $location = $checkin->location;
            }
            $latitude = round($location->lat, 1);
            $longitude = round($location->lng, 1);

            if (($latitude * 10) % 2 == 1) {
                $latitude -= 0.1;
            }

            if (($longitude * 10) % 2 == 1) {
                $longitude -= 0.1;
            }

            $binIndex = $latitude . "-" . $longitude;
            if (!array_key_exists($binIndex, $geobins)) {
                $geobins[$binIndex] = new Geobin();
                $geobins[$binIndex]->lat = $latitude;
                $geobins[$binIndex]->lng = $longitude;
            } else {
                $geobins[$binIndex]->count++;
            }
        }

        if ($subject == "self") {
            $totalCheckinCount = $dataObject->response->checkins->count;
            $dataCount = count($dataObject->response->checkins->items);

            if ($offset + $dataCount < $totalCheckinCount) {
                $geobins = $this->getData($geobins, $oauthToken, $offset + $dataCount);
            }
        }

        return $geobins;
    }

}
