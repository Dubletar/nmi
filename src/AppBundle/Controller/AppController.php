<?php

namespace AppBundle\Controller;

use AppBundle\Service\PDFService;
use RobbieP\ZbarQrdecoder\ZbarDecoder;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
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
     * @Route("/problem-1", name="problem 1", options={"expose":true})
     *
     * @return Response
     */
    public function problem1Action()
    {
        // Save the contents of the product_costs.txt file to an array.
        $content = file_get_contents(
            $this->get('kernel')->getRootDir()
            .'/../web/assets/product_costs.txt'
        );
        $contentArray = array_map("trim", explode("\n", $content));

        $result = [];
        foreach ($contentArray as $key => $content) {
            $thisContent = explode(' ', $content);
            if (count($thisContent) > 1) {
                $cost = $thisContent[0];
                $fee = $thisContent[1];
                // Add ceil for those variants that had negatives while the others were zeroed out.
                $minPrice = ceil($cost / (1 - $fee));

                $thisArray = array(
                    'row' => $key,
                    'cost' => $cost,
                    'fee' => $fee,
                    'minPrice' => $minPrice,
                    'profit' => number_format($minPrice - ($minPrice * $fee) - $cost, 2)
                );

                array_push($result, $thisArray);
            }

        }

        return $this->render(
            'AppBundle:problems:problem1.html.twig',
            array('result' => $result)
        );
    }

    /**
     * @Route("/problem-2", name="problem 2", options={"expose":true})
     *
     * @return Response
     */
    public function problem2Action()
    {
        $query = 'select majors.title, COUNT(students.id) AS students_in from `students` join `majors` ON students.major_id=majors.id group by majors.id; ';
        return $this->render(
            'AppBundle:problems:problem2.html.twig',
            array('query' => $query)
        );
    }

    /**
     * @Route("/problem-3", name="problem 3", options={"expose":true})
     *
     * @return Response
     */
    public function problem3Action()
    {
        $query = 'select majors.title, COUNT(students.id) AS students_in from `students` join `majors` ON students.major_id=majors.id group by majors.id; ';
        return $this->render(
            'AppBundle:problems:problem3.html.twig'
        );
    }

    /**
     * @Route("/problem-4", name="problem 4", options={"expose":true})
     *
     * @return Response
     */
    public function problem4Action()
    {
        $arr = array(5,7,11);
        $results = array();

        foreach ($arr as $ar) {
            $group = [];

            for ($x = 1; $x < 1000; $x++) {
                if (($x % $ar) == 0) {
                    array_push($group, $x);
                }
            }
            $results[$ar] = $group;
        }

        return $this->render(
            'AppBundle:problems:problem4.html.twig',
            array('results' => $results)
        );
    }

    /**
     * @Route("/problem-5", name="problem 5", options={"expose":true})
     *
     * @return Response
     */
    public function problem5Action()
    {
        $pathToAssets = __DIR__ . '/../Resources/public/assets/';
        $content = file_get_contents($pathToAssets . 'excel_reader2.php');
        $contentArray = array_map("trim", explode("\n", $content));
        return $this->render(
            'AppBundle:problems:problem5.html.twig',
            array('file' => $contentArray)
        );
    }

    /**
     * @Route("/problem-6", name="problem 6", options={"expose":true})
     *
     * @return Response
     */
    public function problem6Action()
    {
        $assetPath = __DIR__ . '/../../../web/assets/sequences.txt';
        $content = file_get_contents($assetPath);
        $contentArray = array_map("trim", explode("\n", $content));
        $needle = 'join the nmi team';

        $lines = array();
        foreach($contentArray as $haystack) {
            $value = $this->posAll($haystack, $needle);
            array_push($lines, $value);
        }

        return $this->render(
            'AppBundle:problems:problem6.html.twig',
            array('lines' => $lines)
        );
    }

    /**
     * @param $haystack string
     * @param $needle string
     * @return int
     */
    protected function posAll($haystack, $needle)
    {
        $haystackLen = strlen($haystack);
        $needleLen = strlen($needle);
        $needlePos = 0;
        $count = 0;

        for($x = 0; $x < $haystackLen; $x++) {
            if(substr($haystack, $x, 1) == substr($needle, $needlePos, 1)) {
                $needlePos++;
            }

            if($needlePos == $needleLen) {
                $count++;
                $needlePos = 0;
            }
        }

        return $count;
    }
}