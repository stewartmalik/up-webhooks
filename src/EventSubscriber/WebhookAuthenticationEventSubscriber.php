<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Controller\SecuredWebhookController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class WebhookAuthenticationEventSubscriber implements EventSubscriberInterface
{
    private string $secretKey;

    public function __construct(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();

        if ($controller instanceof SecuredWebhookController) {
            $receivedSignature = $event->getRequest()->headers->get('X-Up-Authenticity-Signature');

            $body = $event->getRequest()->getContent();
            $signature = hash_hmac('sha256', $body, $this->secretKey);

            if(!hash_equals($receivedSignature, $signature)) {
                throw new \Exception("Unable to authenticate webhook event");
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }
}