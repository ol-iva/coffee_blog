<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactPageController extends AbstractController
{
    /**
     * @Route("/contact-us", name="contact")
     */
    public function contactUsPage()
    {
        $about = <<< EOT
The specialty coffee industry is an interesting one,
one that’s almost unrecognizable from its incarnation a decade ago;
back then, there were closed doors, blends made of secret components,
and only a few big name coffee companies.
These days, the floodgates have opened and there are many small roasters,
retailers, and coffee shops – all with passionate individuals behind them,
making great coffee using fresh, high quality, raw coffee.
One of these people is Jason Scheltus, director of coffee at Market Lane Coffee.
While he’s now an integral part of the specialty scene, it wasn’t always so.
After attempting to get involved in the coffee roasting industry in Ukraine in 2004
and finding only a myriad of closed doors, he decided to head overseas in search
of a new opportunity and ended up in London, roasting for Monmouth Coffee.
EOT;
        return $this->render('contact_us.html.twig', ['about' => $about]);
    }
}