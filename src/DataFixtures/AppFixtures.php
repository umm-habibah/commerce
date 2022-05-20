<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Detail;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use DateTime;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('email@fixture.com')
             ->setLastname($faker->lastName())
             ->setFirstname($faker->firstName(null));
        
        $password = $this->hasher->hashPassword($user, 'azerty');
        $user->setPassword($password);
        $manager->persist($user);


        for ($i = 0; $i < 4; $i++) {
            $address = new Address();
            $address->setLastname($user->getLastname())
                    ->setFirstname($user->getFirstname())
                    ->setName($faker->words(2, true))
                    ->setAddress($faker->streetAddress())
                    ->setCity($faker->city())
                    ->setCountry($faker->countryCode())
                    ->setZipcode($faker->postcode())
                    ->setPhone($faker->phoneNumber())
                    ->setUser($user);
            $manager->persist($address);
        }

        for ($i = 0; $i < 6; $i++) {
            $category = new Category();
            $category->setName($faker->words(1, true));
            $manager->persist($category);

            for ($j = 0; $j < 15; $j++) {
                $product = new Product();
                $product->setName($faker->words(2, true))
                        ->setBrand($faker->company())
                        ->setDescription($faker->realText(500, 2))
                        ->setImage('/img/fixture_chair.jpg')
                        ->setPrice($faker->numberBetween(100, 1000))
                        ->setCategory($category)
                        ->setSlug($faker->slug(2, false));
                $manager->persist($product);
            }
        }

        for ($i = 0; $i < 4; $i++) {
            $carrier = new Carrier();
            $carrier->setName($faker->company())
                    ->setDescription($faker->text())
                    ->setPrice($faker->numberBetween(5, 30));
            $manager->persist($carrier);
        }

        for ($i = 0; $i < 3; $i++) {
            $order = new Order();
            $date = new DateTime();
            $order->setReference($date->format('d-m-Y').uniqid())
                  ->setCarrierName($carrier->getName())
                  ->setCarrierPrice($carrier->getPrice())
                  ->setState($faker->randomElement([0, 1, 2]))
                  ->setStripe($faker->randomElement([null, $faker->words(1, true)]))
                  ->setCreatedAt($faker->dateTimeBetween('-6 months', 'now'))
                  ->setAddress($faker->address())
                  ->setUser($user);
            $manager->persist($order);

            for ($j = 0; $j < 4; $j++) {
                $detail = new Detail();
                $detail->setProduct($product->getName())
                       ->setPrice($product->getPrice())
                       ->setQuantity($faker->randomDigitNotNull())
                       ->setTotal($faker->randomDigitNotNull() * $product->getPrice())
                       ->setTheOrder($order);
                $manager->persist($detail);
            }
        }

        $manager->flush();
    }
}
