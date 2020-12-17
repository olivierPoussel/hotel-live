<?php

namespace App\Controller\Api;

use App\Entity\Room;
use App\Repository\RoomRepository;
use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class RoomApiController extends AbstractController
{
    /**
     * @Route("/rooms", name="api_room")
     * 
     * @param RoomRepository $roomRepository
     * @return JsonResponse
     */
    public function allRoom(RoomRepository $roomRepository): JsonResponse
    {
        return $this->json($roomRepository->getAllRoom(), 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * @Route("/room/{id}", name="room_details")
     *
     * @param int $id
     * @param RoomRepository $roomRepository
     * @param BookingService $bookingService
     * 
     * @return JsonResponse
     */
    public function roomDetails(Room $room, BookingService $bookingService, SerializerInterface $serializer) : JsonResponse
    {
        if(!$room) {           
            return (new JsonResponse('room not found'))->setStatusCode(404);
        }

        $dates = $bookingService->getBookingsRangeDates($room->getBookings());      

        $result = $serializer->serialize(['room' => $room,'UnavailableDate' => $dates], 'json', ['groups' => 'room_details']);

        return $this->json($result, 200, ['Access-Control-Allow-Origin' => '*']);
    }
}
