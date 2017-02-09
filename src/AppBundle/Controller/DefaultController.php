<?php

namespace AppBundle\Controller;

use Acme\DemoBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('DemoBundle:Category');

        $options = array(
            'decorate' => true,
            'rootOpen' => '<ul class="ul-treefree">',
            'rootClose' => '</ul>',
            'childOpen' => '<li>',
            'childClose' => '</li>',
            'nodeDecorator' => function ($node) {
                if ($node['size'] == '0') {
                    return '<span style="color:blue;" onclick="openDir(this)" class="' . $node['name'] . '"  id = ' . $node['id'] . '>' . $node['name'] . '</span>';
                }
                return $node['name'];
            }
        );
        $htmlTree = $repo->childrenHierarchy(
            null, /* starting from root nodes */
            false, /* true: load all children, false: only direct */
            $options
        );


        return $this->render('default/index.html.twig', array(
            'arrayTree' => $htmlTree,
            'directory' => $this->filedDirectoryList(),
            'sizeDirectory' => $this->sizeDirectory(),
            'catalogSize' => $this->catalogSize(),
            'countFilesCatalog' => $this->countFilesCatalog(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @return string*
     */
    public function filedDirectoryList()
    {
        $filesdirectory = $this->filesDirectoryAll();
        $htmlText="";
        for ($i = 0; $i <= $count = (count($filesdirectory)) - 1; $i++) {

            $htmlText[$i] = $filesdirectory[$i]['name'];
        }
        if(!empty( $htmlText)){
            $filesDirectoryList = $comma_separated = implode("<br>", $htmlText);
        }else
        {
            $filesDirectoryList=$htmlText;
        }
        return $filesDirectoryList;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findParent($id)
    {//Find parent

        $repository = $this->getDoctrine()->getRepository('DemoBundle:Category');
        $query = $repository->createQueryBuilder('c')
            ->select('c.parent_id')
            ->where('c.id != :id')
            ->getQuery();
        $query->setParameter('id', $id);
        $findParent = $query->getResult()[0][1];

        return $findParent;
    }

    /**
     * @return float
     */
    public function sizeDirectory()
    {//size in  parent dir

        $repository = $this->getDoctrine()->getRepository('DemoBundle:Category');
        $query = $repository->createQueryBuilder('c')
            ->select('SUM (c.size)')
            ->where('c.size != :num')
            ->getQuery();
        $query->setParameter('num', '0');
        $sizeDirectory = round(($query->getResult()[0][1]) / 1024 / 1024, 2);

        return $sizeDirectory;
    }

    /**
     * @return array
     */
    public function filesDirectoryAll()
    {//Find files in catalog
        $repository = $this->getDoctrine()->getRepository('DemoBundle:Category');
        $query = $repository->createQueryBuilder('c')
            ->select('c.name', 'c.size', 'c.parent_name')
            ->where('c.size != :num')
            ->getQuery();
        $query->setParameter('num', '0');
        $filesDirectory = $query->getResult();

        return $filesDirectory;
    }

    /**
     * @return mixed
     */
    public function countFilesCatalog()
    {//Find how many files in catalog

        $repository = $this->getDoctrine()->getRepository('DemoBundle:Category');
        $query = $repository->createQueryBuilder('c')
            ->select('COUNT(c.type)')
            ->where('c.size != :num')
            ->getQuery();
        $query->setParameter('num', '0');
        $countFilesCatalog = $query->getResult()[0][1];

        return $countFilesCatalog;
    }

    /**
     * @return float
     */
    public function catalogSize()
    {
        $repository = $this->getDoctrine()->getRepository('DemoBundle:Category');
        $query = $repository->createQueryBuilder('p')
            ->select('SUM(p.size)')
            ->getQuery();
        $catalogSize = round(($query->getResult()[0][1]) / 1024 / 1024, 2);

        return $catalogSize;
    }


}
