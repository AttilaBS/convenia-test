<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class EmailPattern implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $acute = 'áéíóúÁÉÍÓÚ';
        $circumflex = 'âêîôûÂÊÎÔÛ';
        $grave = 'àèìòùÀÈÌÒÙ';
        $tilde = 'ãẽĩõũÃẼĨÕŨ';
        $pattern = '/[!\~\^\`\"\|\,\;\:\?\#\$\%\&\*\(\)\+\=\{\}\[\]'
            .$acute.$circumflex.$grave.$tilde
            .'çëïüÄËÏÖÜÆæÇŒœñý\s]/u';
        if (preg_match($pattern, $value)) {
            $fail('The email can not contain special characters or accents.');
        }
    }
}
