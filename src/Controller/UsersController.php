<?php

namespace App\Controller;

use App\Document\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager;

class UsersController extends AbstractController
{
    /**
     * @param DocumentManager $dm
     * @return Response
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     * @Route("/user", methods={"POST"})
     */
    public function createAction(DocumentManager $dm)
    {
        $user = new User();
        $user->setEmail('pame@gmail.com');
        $user->setPassword('31760660');

        $dm->persist($user);
        $dm->flush();

        return new Response('Created user id ' . $user->getId());
    }

    /**
     * @param DocumentManager $dm
     * @param $id
     * @return Response
     * @Route("/user/{id}", methods={"GET","HEAD"})
     */
    public function showAction(DocumentManager $dm, $id)
    {
        $user = $dm->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('No user found for id ' . $id);
        }

        return new Response($user->getEmail());
    }
}
