<?php

namespace App\Http\Controllers;

class DatasetController extends Controller
{
    /*
     * I used this method to get all combinations for content words,
     * and added in config/data.php file as array and later the uploaded
     * them from a job that is called form a command: `load:dataset`
     */
    public function __invoke()
    {
        $randomWords = 'Cool,Strange,Funny,Laughing,Nice,Awesome,Great,Horrible,Beautiful,PHP,Vegeta,Italy,Joost';
        $result = $this->getAllCombinations($randomWords);

        return $result;
    }

    private function generateCombinations($words, $length, $start = 0, $combination = [])
    {
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
            $combinations = array_merge($combinations, $this->generateCombinations($words, $length - 1, $i + 1, $newCombination));
        }

        return $combinations;
    }

    private function getAllCombinations($randomWords)
    {
        $words = explode(',', strtolower($randomWords));
        $combinations = [];

        $maxWordCount = count($words);

        for ($i = 1; $i <= $maxWordCount; $i++) {
            $combinations = array_merge($combinations, $this->generateCombinations($words, $i));
        }

        $uniqueCombinations = [];

        foreach ($combinations as $combination) {
            sort($combination); // Sort the words to remove duplicate order combinations
            $uniqueCombination = implode(' ', $combination);

            if (! empty(trim($uniqueCombination))) {
                $uniqueCombinations[] = $uniqueCombination;
            }
        }

        return $uniqueCombinations;
    }
}
