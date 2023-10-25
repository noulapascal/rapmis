<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Service\LocaleSubscriber;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

    /**
     * @Route("/",locale="fr", requirements={
     *         "_locale": "en|fr",
     *         "_format": "html|xml",
     *     })
     */

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function home()
    {
        return $this->redirectToRoute('homepage');
    }
      
}
