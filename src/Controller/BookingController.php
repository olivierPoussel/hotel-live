<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking")
     */
    public function index(): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        return $this->render('booking/booking.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
