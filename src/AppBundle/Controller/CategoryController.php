<?php
/**
 * Created by PhpStorm.
 * User: ausenko
 * Date: 31.03.17
 * Time: 15:21
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\EventManager;
use Gedmo\Tree\TreeListener;
use JMS\SerializerBundle\JMSSerializerBundle;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $food = new Category();
        $food->setTitle('Food');

        $fruits = new Category();
        $fruits->setTitle('Fruits');
        $fruits->setParent($food);

        $vegetables = new Category();
        $vegetables->setTitle('Vegetables');
        $vegetables->setParent($food);

        $carrots = new Category();
        $carrots->setTitle('Carrots');
        $carrots->setParent($vegetables);

        $em = $this->getDoctrine()->getManager();

        $em->persist($food);
        $em->persist($fruits);
        $em->persist($vegetables);
        $em->persist($carrots);
        $em->flush();

        return new Response('Records has been saved');
    }

    public function getAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:Category');
          //Simple array
//        $arrayTree = $repo->getNodesHierarchy(null, false, [], true);
//        var_dump($arrayTree);
        //Tree in json
//        $tree = $repo->buildTreeArray($arrayTree);
//        var_dump($tree);

//        $serializer = SerializerBuilder::create()->build();
//        $jsonContent = $serializer->serialize($tree, 'json');
//
//        return new Response($jsonContent);
    }
}