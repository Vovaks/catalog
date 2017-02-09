<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ajaxController extends Controller
{
    /**
     * @Route("/ajax")
     */
    public function indexAction(Request $request)
    {

        $request->query->get('id');//toze samoe 4to $_GET['name'];
        $id = $request->query->get('id');

        $array = $this->filedDirectoryAll($this->findParent($id));

        return new JsonResponse($array);
        //return $this->render('', array('name' => $name));
    }

    /**
     * @param $id
     * @return array
     */
    public function findParent($id)
    {
        $repository = $this->getDoctrine()->getRepository('DemoBundle:Category');
        $query = $repository->createQueryBuilder('c')
            ->select('c.name')
            ->where('c.id = :id')
            ->getQuery();
        $query->setParameter('id', $id);
        $findParent = $query->getResult();

        return $findParent;
    }

    /**
     * @param $nameParent
     * @return array
     */
    public function filedDirectoryAll($nameParent)
    {//Find files in catalog
        $repository = $this->getDoctrine()->getRepository('DemoBundle:Category');
        $query = $repository->createQueryBuilder('c')
            ->select('c.name', 'c.size', 'c.parent_name')
            ->where('c.size != :num')
            ->andWhere('c.parent_name = :id')
            ->getQuery();
        $query->setParameters(array('num' => '0', 'id' => $nameParent));
        $filesDirectory = $query->getResult();

        return $filesDirectory;
    }
}
