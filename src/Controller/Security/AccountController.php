<?php

namespace App\Controller\Security;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Owner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    /**
     * @Route("/register", name="auth_register")
     */
    public function register(Request $request,UserPasswordEncoderInterface $encoder,ValidatorInterface $validator): Response
    {

        $data = \json_decode($request->getContent(), true);

        if(strlen($data['plainPassword'])<8){
            return new JsonResponse('password too short',500);
        }

        $owner = new Owner();
        $owner->setEmail($data['email']);
        $owner->setPassword($encoder->encodePassword($owner, $data['plainPassword']));
        $errors= $validator->validate($owner);
        if(is_array($errors)) {
            if (count($errors) > 0) {
                /*
                 * Uses a __toString method on the $errors variable which is a
                 * ConstraintViolationList object. This gives us a nice string
                 * for debugging.
                 */
                $errorsString = (string)$errors;

                return new JsonResponse($errorsString, 500);
            }
        }
        try {
            $this->em->persist($owner);
            $this->em->flush();
        }catch (\Exception $e){
            return new JsonResponse('error creating user: '.$e->getMessage(),500);
        }
        return new JsonResponse('working');

    }

}
