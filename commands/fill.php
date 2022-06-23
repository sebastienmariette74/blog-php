<?php

use App\Connection;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = Connection::getPdo();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE userblog');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

for ($i = 0; $i < 50 ; $i++){
    $pdo->exec("INSERT INTO `post`(`name`, `slug`, `content`, `created_at`) VALUES ('{$faker->sentence(3)}','{$faker->slug()}','{$faker->paragraphs(3, true)}','{$faker->date()} {$faker->time()}') ");
    $posts[] = $pdo->lastInsertId();

}

for ($i = 0; $i < 5 ; $i++){
    $pdo->exec("INSERT INTO `category`(`name`, `slug`) VALUES ('{$faker->sentence(3)}','{$faker->slug()}')");
    $categories[] = $pdo->lastInsertId();
}

foreach($posts as $post){
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach($randomCategories as $category){
        $pdo->exec("INSERT INTO `post_category`(`post_id`, `category_id`) VALUES ('$post','$category')"); // pas d'accolades, expression simple
    }
}

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO `userblog`(`username`, `password`) VALUES ('admin','$password')");