<?php

namespace App\Controller\Device;

use App\Entity\Device;
use App\Entity\Owner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DeviceCollectionCreateController extends AbstractController
{

    public function __invoke(Device $data,UserInterface $user) :Device
    {
        if(!$user){
            return new JsonResponse('',403);
        }
        if ($user instanceof Owner) {
            $data->setOwner($user);
        }

        return $data;

    }
}
