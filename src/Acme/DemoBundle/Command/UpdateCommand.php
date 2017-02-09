<?php

namespace Acme\DemoBundle\Command;

use Acme\DemoBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class UpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('catalog:update')
            ->setDescription('Update you Catalog');

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = $this->updateCatalog();
    }

    /**Update you Catalog and create Tree
     * @return array
     */
    function updateCatalog()
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $query = $em->createQuery('DELETE DemoBundle:Category c WHERE c.id != 0');//Clear catalog in db
        $query->execute();
        $basePath = 'src\load_files';
        $text = array();
        echo $this->treeCreate($basePath);

        return $text;
    }

    /**Search in base directory
     * @param $dir
     * @param array $results
     * @return array
     */
    function getPath($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = $dir . DIRECTORY_SEPARATOR . $value;

            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $this->getPath($path, $results);
                $results[] = $path;
            }
        }
        return $results;

    }

    /**
     * @param $basePath
     */
    function treeCreate($basePath)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $basePathName = (basename($basePath));

        $directory = $basePathName;//create general category
        $$directory = new Category();
        $$directory->setTitle($basePathName);
        $$directory->setName($basePathName);
        $$directory->setExtension('');
        $$directory->setSize('');
        $$directory->setType('dir');
        $em->persist($$directory);

        $results = $this->getPath($basePath);
        $results = array_reverse($results);//reverse

        foreach ($results as $result) {
            if (filetype($result) == 'dir') {

                echo $result . "\n";

                $path_parts = pathinfo($result);
                $type = (filetype($result) . "\n");//type dir/file
                $name = $path_parts['basename'];//name
                $parent = pathinfo($path_parts['dirname']);
                $parent = $parent['basename'];//name catalog Parent

                $$name = new Category();//create directory
                $$name->setTitle($name);
                $$name->setName($name);
                $$name->setExtension('');
                $$name->setSize('');
                $$name->setType($type);
                $$name->setParent_name($parent);
                $$name->setParent($$parent);
                $em->persist($$name);
            }
        }

        foreach ($results as $result) {
            if (filetype($result) != 'dir') {

                echo $result . "\n";

                $path_parts = pathinfo($result);
                $size = (filesize($result) . "\n");//size
                $type = (filetype($result) . "\n");//type dir/file
                $name = $path_parts['basename'];//name
                $title = $path_parts['filename'];//title
                $extension = $path_parts['extension'];//ext
                $parent = pathinfo($path_parts['dirname']);
                $parent = $parent['basename'];

                $$name = new Category();
                $$name->setTitle($title);
                $$name->setName($name);
                $$name->setExtension($extension);
                $$name->setSize($size);
                $$name->setType($type);
                $$name->setParent_name($parent);
                $$name->setParent($$parent);
                $em->persist($$name);
            }
        }
        $em->flush();
    }
}