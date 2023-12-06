<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class TokenListener{

    /**
     * @param RequestEvent $event
     * @return RequestEvent|void
     */
    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }


        if($event->getRequest()->get('_route') === 'api_entrypoint'){
            return;
        }

        if(!$event->getRequest()->headers->get('token')){
            $response = new JsonResponse(['error' => 'No token provided.'], Response::HTTP_UNAUTHORIZED);
            $event->setResponse($response);
            return $event;
        }

        if($event->getRequest()->headers->get('token') !== $_ENV['API_TOKEN']){
            $response = new JsonResponse(['error' => 'Invalid token'], Response::HTTP_FORBIDDEN);
            $event->setResponse($response);
            return $event;
        }

    }
}