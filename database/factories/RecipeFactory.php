<?php

use Faker\Generator as Faker;

$food_list = array("bagel","batter","beans","beer","biscuit","bread","broth","burger","butter","cake","candy","caramel","caviar","cheese","chili","chocolate","cider","cobbler","cocoa","coffee","cookie","cream","croissant","crumble","curd","dessert","dish","drink","eggs","entree","filet","fish","flour","food","glaze","grill","hamburger","ice","juice","ketchup","lard","liquor","margarine","marinade","mayo","mayonnaise","meat","milk","mousse","muffin","mushroom","noodle","nut","oil","olive","omelette","pasta","paste","pastry","pie","pizza","plate","poutine","pudding","raclette","rice","salad","salsa","sandwich","sauce","seasoning","soda","soup","soy","steak","stew","syrup","tartar","tea","toast","vinegar","waffle","water","wheat","wine","yeast","yogurt");
$amounts = array("cups","tablespoons","teaspoons");

$factory->define(App\Recipe::class, function (Faker $faker) use ($food_list, $amounts) {
    return [
        'name' => ucfirst($faker->randomElement($food_list)),
        'description' => $faker->sentence . ' ' .  $faker->sentence,
        'cook_time' => $faker->randomDigitNotNull . ' ' . $faker->randomElement(['mins', 'hours']),
        'prep_time' => $faker->randomDigitNotNull . ' ' . $faker->randomElement(['mins', 'hours']),
        'ingredients' => json_encode(
            [   [
                    'amount' => $faker->randomDigitNotNull . ' ' . $faker->randomElement($amounts),
                    'food' => $faker->randomElement($food_list)
                ],
                [
                    'amount' => $faker->randomDigitNotNull . ' ' . $faker->randomElement($amounts),
                    'food' => $faker->randomElement($food_list)
                ],
                [
                    'amount' => $faker->randomDigitNotNull . ' ' . $faker->randomElement($amounts),
                    'food' => $faker->randomElement($food_list)
                ],
                [
                    'amount' => $faker->randomDigitNotNull . ' ' . $faker->randomElement($amounts),
                    'food' => $faker->randomElement($food_list)
                ],
                [
                    'amount' => $faker->randomDigitNotNull . ' ' . $faker->randomElement($amounts),
                    'food' => $faker->randomElement($food_list)
                ],
                [
                    'amount' => $faker->randomDigitNotNull . ' ' . $faker->randomElement($amounts),
                    'food' => $faker->randomElement($food_list)
                ]
            ]
        ),
        'instructions' => json_encode(
            [   [
                    'sort' => 1,
                    'do' => $faker->sentence . ' ' .  $faker->sentence,
                ],
                [
                    'sort' => 2,
                    'do' => $faker->sentence . ' ' .  $faker->sentence . ' ' . $faker->sentence . ' ' .  $faker->sentence,
                ],
                [
                    'sort' => 3,
                    'do' => $faker->sentence . ' ' .  $faker->sentence . ' ' . $faker->sentence . ' ' .  $faker->sentence,
                ],
                [
                    'sort' => 4,
                    'do' => $faker->sentence . ' ' .  $faker->sentence . ' ' . $faker->sentence . ' ' .  $faker->sentence,
                ],
                [
                    'sort' => 5,
                    'do' => $faker->sentence . ' ' .  $faker->sentence . ' ' . $faker->sentence . ' ' .  $faker->sentence,
                ],
                [
                    'sort' => 6,
                    'do' => $faker->sentence,
                ]
            ]
        ),
        'image' => $faker->image('public/storage/cover_images',640,480, 'food', false),
    ];
});
