<?php
/**
 * Created by PhpStorm.
 * User: ausenko
 * Date: 24.03.17
 * Time: 16:01
 */

namespace Example\ExampleBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ExampleController extends Controller
{
    /**
     * Example:
     *
     * Return list of users. For example:
     *
     * [
     *  {
    "user_id": 1,
     *      "first_name": "TestUser",
     *      "user_role": "TestRole"
     * }
     * ]
     *
     * @ApiDoc(
     *     output="json",
     *     statusCodes={
    200="Returned when successful",
     *          404="There are no users exist",
     *     }
     * )
     */
    public function newAction()
    {
        //your code
    }
}