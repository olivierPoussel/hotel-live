<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\Customer;
use App\Entity\Option;
use App\Entity\Room;
use DateTime;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //use faker
        $faker = Factory::create('fr_FR');
        $faker->seed(0);
        //Option
        // 2 option petit dej / lit supp
        $optionPdej = new Option();
        $optionPdej
            ->setName('Petit déjeuner')
            ->setPrice(6.5)
        ;
        $manager->persist($optionPdej);
        $optionJ = new Option();
        $optionJ
            ->setName('Jacuzzi')
            ->setPrice(47.99)
        ;
        $manager->persist($optionJ);

        $optionTele = new Option();
        $optionTele
            ->setName('télé')
            ->setPrice(8.00)
        ;
        $manager->persist($optionTele);

        $manager->flush();
        //room créer 10 rooms
        $rooms = [];
        for ($i=0; $i < 10; $i++) { 
            $room = new Room();
            $room
            ->setName($faker->word)
            ->setNumber($i+1)
            ->setPrice($faker->randomFloat(2,50,150))
            ->addOption($optionPdej)
            ->addOption($optionTele)
            ;
            if($i % 3 == 0) {
                $room->addOption($optionJ);
            }
            $manager->persist($room);
            $rooms[] = $room;
        }
        $manager->flush();

        //customer créer 50 customer
        $customers = [];
        for ($j=0; $j < 50; $j++) { 
            $customer = new Customer();
            $gender = ($j % 2 == 0) ? 'male' : 'female';
            $customer
                ->setEmail($faker->safeEmail)
                ->setLastname($faker->lastName)
                ->setFirstname($faker->firstName($gender))
            ;
            $manager->persist($customer);
            $customers[] = $customer;
        }
        $manager->flush();

        //booking 10/30 par room
        $nbCustomer = count($customers) - 1;
        foreach ($rooms as $room) {
            $nbBooking = $faker->numberBetween(10, 30);

            for ($k=0; $k < $nbBooking; $k++) { 

                $startDate = $faker->dateTimeBetween('-6 month', '+6 month', 'Europe/Paris');
                $startDate->setTime(0,0,0,0);
                $nbNight = $faker->numberBetween(1, 10);
                //double quote interprete les variables a l'interreur du string
                $endDate = (clone $startDate)->modify("+$nbNight days");

                $createDate = (clone $startDate)->modify("-$nbNight days");

                $booking = new Booking();
                $booking
                    ->setCreatedAt($createDate)
                    ->setRoom($room)
                    ->setCustomer($customers[$faker->numberBetween(0, $nbCustomer)])
                    ->setComment($faker->sentence)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                ;
                $manager->persist($booking);
            }

            $manager->flush();
        }

        // $user = $this->getReference('admin');

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
