<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NewsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $faker->seed(0);
        for ($i=0; $i < 20; $i++) { 
            $news = new News();
            $news
                ->setTitre($faker->sentence($faker->numberBetween(2,5)))
                ->setDescription($faker->text(50))
                ->setContenu($faker->paragraph)
                ->setDateNews($faker->dateTimeBetween('-6 month'))
                ;
            
            $manager->persist($news);
        }

        $manager->flush();
    }
}
