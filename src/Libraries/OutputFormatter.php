<?php

namespace Angelo8828\MakeModule\Libraries;

class OutputFormatter
{
    public function wrapSuccessMessage($string)
    {
        return "\033[32m" . $string . "\033[0m \n";
    }

    public function wrapErrorMessage($string)
    {
        return "\033[31m" . $string . "\033[0m \n";
    }
}
