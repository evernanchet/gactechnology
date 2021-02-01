<?php

namespace App\Controller;

use App\Repository\AppelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/call", name="call")
 */
class CallController extends AbstractController
{
    /** @var AppelRepository */
    private $appelRepository;
    public function __construct(AppelRepository $appelRepository)
    {
        $this->appelRepository = $appelRepository;
    }

    /**
     * Recuperer la durée des appels
     *
     * @Route("/duration", name="duration")
     */
    public function getCallDuration()
    {
        $title = "Durée des appels";
        $value = $this->appelRepository->findDurationCalls();
        return $this->render('calls.html.twig', [
            'value' => $value,
            'title' => $title,
        ]);
    }

    /**
     * Recuperer le Top 10 des datas
     *
     * @Route("/top", name="top")
     */
    public function getTopData()
    {
        $title = "Top 10 des datas";
        $value = $this->appelRepository->findTopData();
        return $this->render('calls.html.twig', [
            'value' => $value,
            'title' => $title,
        ]);
    }

    /**
     * Recuperer la quantité de sms
     *
     * @Route("/sms", name="sms")
     */
    public function getSmsSent()
    {
        $title = "Quantité de sms";
        $value = $this->appelRepository->findSmsSent();
        return $this->render('calls.html.twig', [
            'value' => $value,
            'title' => $title,
        ]);
    }




}
