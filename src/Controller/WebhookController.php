<?php

declare(strict_types=1);

namespace App\Controller;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WebhookController extends AbstractController implements SecuredWebhookController
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/webhook", name="up_webhook")
     */
    public function receive(Request $request): Response
    {
        $this->logger->debug(dump($request->getContent()));

        return new Response();
    }
}