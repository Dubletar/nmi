<?php

namespace AppBundle\Controller;

use UtilityBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class AppController extends AbstractController
{
    /**
     * @Route("/", name="index", options={"expose":true})
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render("AppBundle::index.html.twig");
    }

    /**
     * @Route("/valencepm/test", name="valencepm_test", options={"expose":true})
     *
     * @return Response
     */
    public function valencePMTestAction()
    {
        return $this->render("AppBundle:ValencePM:test.html.twig");
    }

    /**
     * @Route("/valencepm/data", name="valencepm_data", options={"expose":true})
     *
     * @return Response
     */
    public function valencePMTestDataAction()
    {
        // Array to hold the data.
        $data = array();

        // Grab the file.
        $file = fopen(__DIR__ . "/../../../web/valencepm/input.txt", "r");
        while ($line = fgets($file)) {
            $lineData = explode(" ", $line);
            $data[] = array("unit" => $lineData[0], "tenant" => $lineData[2]);
        }

        $originalData = $data;
        usort($data, function($a, $b) {
            return strnatcmp($a['unit'], $b['unit']);
        });

        return $this->createJmsResponse(array(
            "data" => $data,
            "originalData" => $originalData
        ));
    }
}