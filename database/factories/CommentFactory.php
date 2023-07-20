<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'post_id' => $this->faker->randomNumber(),
            'content' => $this->faker->word(),
            'abbervation' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    /*
     * I used this method to get all combinations for content words,
     * than formatted the content and added in config/data.php file as array
     * and later the uploading them from a job that is called form a command: `load:dataset`
     */
    public function makeCombination()
    {
        $randomWords = "Cool,Strange,Funny,Laughing,Nice,Awesome,Great,Horrible,Beautiful,PHP,Vegeta,Italy,Joost";
        $words = explode(',', strtolower($randomWords));

        function generateCombinations($words, $length, $start = 0, $combination = []) {
            $combinations = [];

            if ($length === 0) {
                return [$combination];
            }

            for ($i = $start; $i <= count($words) - $length; $i++) {
                $word = $words[$i];
                if (in_array($word, $combination)) {
                    continue; // Skip if the word is already in the combination
                }

                $newCombination = array_merge($combination, [$word]);
                $combinations = array_merge($combinations, generateCombinations($words, $length - 1, $i + 1, $newCombination));
            }

            return $combinations;
        }

        $combinations = [];
        $maxWordCount = count($words);

        for ($i = 1; $i <= $maxWordCount; $i++) {
            $combinations = array_merge($combinations, generateCombinations($words, $i));
        }

        foreach ($combinations as $combination) {
            sort($combination); // Sort the words to remove duplicate order combinations
            $uniqueCombination = implode(' ', $combination);

            if (!empty(trim($uniqueCombination))) {
                return $uniqueCombination . PHP_EOL;
            }
        }

    }
}
