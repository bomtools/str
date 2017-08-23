<?php
/**
 * Tools for string handling
 *
 * @version 0.0.1
 * @released 2017-08-22
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2017 Bakay Omuraliev
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace BomTools;

abstract class Str
{
    /**
     * @param string
     * @return string
     */
    public static function getExtension(string $filename): string
    {
        $position = mb_strripos($filename, '.');

        if ($position === false) {
            return '';
        }
        return mb_substr($filename, $position+1);
    }

    /**
     * @param string
     * @return string
     */
    public static function clearSpaces(string $string): string
    {
        return preg_replace('/[\s]{2,}/', ' ', $string);
    }

    /**
     * @param string
     * @return string
     */
    public static function addHttp(string $link): string
    {
        if (substr($link, 0, 7) != "http://" AND substr($link, 0, 8) != "https://") $link = "http://".$link;
        return $link;
    }

    /**
     * @param string
     * @param int
     * @param string
     * @return string
     */
    public static function completeLeft(string $string, int $length, string $symbol = '0'): string
    {
        if (mb_strlen($symbol)!=1 || !is_int($length)) return $string;
        $string = (string)$string;
        $stringLength = mb_strlen($string);
        if ($stringLength < $length) {
            $additional = $length - $stringLength;
            for ($i = 0; $i < $additional; $i++) $string = $symbol.$string;
        }
        return $string;
    }

    /**
     * @param string
     * @param int
     * @param string
     * @return string
     */
    public static function completeRight(string $string, int $length, string $symbol = '0'): string
    {
        if (mb_strlen($symbol)!=1 || !is_int($length)) return $string;
        $string = (string)$string;
        $stringLength = mb_strlen($string);
        if ($stringLength < $length) {
            $additional = $length - $stringLength;
            for ($i = 0; $i<$additional; $i++) $string = $string.$symbol;
        }
        return $string;
    }

    /**
     * Invert slashes
     * @param string
     * @return string
     */
    public static function invertSlashes(string $string): string
    {
        return str_replace("\\", '/', $string);
    }

    /**
     * Get left symbols of the string
     * @param string
     * @param int
     * @return string
     */
    public static function getLeft(string $string, int $length): string
    {
        return mb_substr($string, 0, $length, 'UTF-8');
    }

    /**
     * Get right symbols of the string
     * @param string
     * @param int
     * @return string
     */
    public static function getRight(string $string, int $length): string
    {
        return mb_substr($string, -$length, $length, 'UTF-8');
    }

    /**
     * Remove left side of the string
     * @param string
     * @param int
     * @return string
     */
    public static function removeLeft(string $string, int $length): string
    {
        return mb_substr($string, $length, strlen($string), 'UTF-8');
    }

    /**
     * Rmove right side of the string
     * @param string
     * @param int
     * @return string
     */
    public static function removeRight(string $string, int $length): string
    {
        return mb_substr($string, 0, -$length, 'UTF-8');
    }

    /**
     * Check if string is starting with substring
     * @param string
     * @param string
     * @return bool
     */
    public static function compareLeft(string $string, string $substring): bool
    {
        $length = mb_strlen($substring, 'UTF-8');
        if (mb_strlen($string) < $length) return false;
        return mb_substr($string, 0, $length) == $substring;
    }

    /**
     * Check if string is ending with substring
     * @param string
     * @param string
     * @return bool
     */
    public static function compareRight(string $string, string $substring): bool
    {
        $length = mb_strlen($substring, 'UTF-8');
        if (mb_strlen($string) < $length) return false;
        return mb_substr($string, -$length) == $substring;
    }

    /**
     * Get position in string
     * @param string
     * @param int
     * @return string
     */
    public static function getPosition(string $string, int $position): string
    {
        return mb_substr($string, $position, 1, 'UTF-8');
    }

    /**
     * Remove position from string
     * @param string
     * @param int
     * @return string
     */
    public static function removePosition(string $string, int $position): string
    {
        $length = mb_strlen($string, 'UTF-8');

        if ($position < $length && $position > 0) {
            $stringLeft = self::getLeft($string, $position);
            $stringRight = self::getRight($string, $length-$position-1);

            return $stringLeft.$stringRight;
        } elseif ($position < 0) {
            $stringRight = mb_substr($string, $position+1, $length, 'UTF-8');
            $stringLeft = mb_substr($string, 0, $length+$position, 'UTF-8');

            return $stringLeft.$stringRight;
        }
        return $string;
    }

    /**
     * @param string
     * @param string
     * @return bool
     */
    public static function existSubstring(string $string, string $substring): bool
    {
        if ($string == $substring) return true;
        return mb_strpos($string, $substring) !== false;
    }

    /**
     * Get host address of the url
     * @param string
     * @return string
     */
    public static function getSiteAddress(string $url): string
    {
        return parse_url($url, PHP_URL_HOST);
    }

    /**
     * Get url parameters
     * @param string
     * @return array
     */
    public static function getUrlParams(string $url): array
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if (!empty($query)) {
            parse_str($query, $parameters);
            return $parameters;
        }
        return [];
    }

    /**
     * Remove everything besides numbers in string
     * @param string
     * @return string
     */
    public static function keepOnlyNumbers(string $string): string
    {
        return preg_replace('/[^0-9]/i', '', $string);
    }

    /**
     * Remove everything besides letters in string
     * @param string
     * @return string
     */
    public static function keepOnlyLetters(string $string): string
    {
        return preg_replace("/[^a-zA-Zа-яА-Я]+/u", "", $string);
    }

    /**
     * Remove everything besides letters and spaces in string
     * @param $string
     * @return mixed
     */
    public static function keepOnlyLettersAndSpaces(string $string): string
    {
        return preg_replace("/[^a-zA-Zа-яА-Я\s]+/u", "", $string);
    }

    /**
     * Remove everything besides letters and numbers from string
     * @param $string
     * @return mixed
     */
    public static function keepOnlyNumbersAndLetters(string $string): string
    {
        return preg_replace("/[^a-zA-Zа-яА-Я0-9]+/u", "", $string);
    }

    /**
     * Remove everything besides letters and numbers from string
     * @param $string
     * @return string
     */
    public static function keepOnlyNumbersLettersAndSpaces(string $string): string
    {
        return preg_replace("/[^a-zA-Zа-яА-Я0-9\s]+/u", "", $string);
    }

    /**
     * @param string $string
     * @return bool
     */
    public static function hasOnlyNumbers(string $string): bool
    {
        $string = (string)$string;
        return ctype_digit($string);
    }

    /**
     * @param string $string
     * @return bool
     */
    public static function hasInt(string $string): bool
    {
        $string = (string)$string;
        return $string == (string)(int)$string;
    }

    /**
     * Explode array with delimiter
     * @param string
     * @param string
     * @return array
     */
    public static function toArray(string $string, string $delimiter = ' '): array
    {
        if ($delimiter == ' ') {
            $string = self::clearSpaces($string);
            $string = trim($string);
        }
        return explode($delimiter, $string);
    }

    /**
     * Remove all bbcode from string
     * @param string
     * @return string
     */
    public static function removeBbcode(string $string): string
    {
        return preg_replace("/[[\/\!]*?[^\[\]]*?]/si", "", $string);
    }

    /**
     * Convert string to url index
     * @param string
     * @return string
     */
    public static function toIndex(string $string): string
    {
        $string = str_replace("\t", " ", $string);
        $string = Str::toLine($string);
        $string = Str::clearSpaces($string);
        $string = str_replace(" ", "_", $string);
        $string = strtolower($string);
        $string = preg_replace('/[^0-9A-Za-z_]/i','',$string);
        return $string;
    }

    /**
     * Get only first line from string
     * @param string
     * @return string
     */
    public static function getFirstLine(string $string): string
    {
        $string = str_replace("\r", "", $string);
        $lines = explode("\n", $string);
        return $lines[0];
    }

    /**
     * Remove all new line transition symbols
     * @param string
     * @return string
     */
    public static function removeLines(string $string): string
    {
        $string = str_replace("\r", "", $string);
        $string = str_replace("\n", "", $string);
        return $string;
    }

    /**
     * Replace all new line transition symbols to spaces
     * @param string
     * @param string
     * @return string
     */
    public static function toLine(string $string, string $separator = ' '): string
    {
        $string = str_replace("\r", "", $string);
        $string = str_replace("\n", $separator, $string);
        return $string;
    }

    /**
     * Get lines from string
     * @param string
     * @param int
     * @return string
     */
    public static function getLines(string $string, int $count = 1): string
    {
        $string = str_replace("\r", "", $string);
        $lines = explode("\n", $string);

        if (count($lines) <= $count) {
            return $string;
        }
        else {
            $return = $lines[0];
            if (count($lines) > 1 && $count > 1)
                for ($i = 1; $i < $count; $i++)
                    $return .= "\n".$lines[$i];
        }
        return $return;
    }

    /**
     * Check if string is aliquot to divider
     * @param string $string
     * @param int $divider
     * @return bool
     */
    public static function isAliquot(string $string, int $divider): bool
    {
        return mb_strlen($string) % $divider == 0;
    }

    /**
     * Url safe base64 encoding
     * @param string $string
     * @return string
     */
    public static function base64SafeEncode(string $string): string
    {
        $string = base64_encode($string);
        $string = str_replace('=', '', $string);
        $string = str_replace('+', '-', $string);
        $string = str_replace('/', '_', $string);
        return $string;
    }

    /**
     * Url save base64 decoding
     * @param string $string
     * @return string
     */
    public static function base64SafeDecode(string $string): string
    {
        if (!Str::isAliquot($string, 4))
            $string .= str_repeat('=', mb_strlen($string) % 4);
        $string = str_replace('-', '+', $string);
        $string = str_replace('_', '/', $string);
        return base64_decode($string);
    }

    /**
     * Generate string with random printable characters
     * @param int $length
     * @return string
     */
    public static function getRandomChars(int $length = 1): string
    {
        if ($length < 1) $length = 1;
        $chars = '';
        for ($i=0; $i<$length; $i++)
            $chars .= chr(random_int(32,126));
        return $chars;
    }

    /**
     * @param string $string
     * @param string $wrapLeft
     * @param string|null $wrapRight
     * @return string
     */
    public static function wrap(string $string, string $wrapLeft, string $wrapRight = null): string
    {
        if (null === $wrapRight) return $wrapLeft . $string . $wrapLeft;
        return $wrapLeft . $string . $wrapRight;
    }

    /**
     * @param string $string
     * @return string
     */
    public static function translitToRus(string $string): string
    {
        $from = array ("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
            "a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
        $to = array ("А","Б","С","Д","Е","Ф","Г","Х","И","Дж","К","Л","М","Н","О","П","К","Р","С","Т","У","В","В","Кс","Ю","З",
            "а","б","с","д","е","ф","г","х","и","дж","к","л","м","н","о","п","к","р","с","т","у","в","в","кс","ю","з");

        for ($i=0; $i<count($from); $i++) {
            $string = preg_replace('/['.$from[$i].']/u', $to[$i], $string);
        }

        return $string;
    }

    /**
     * @param string $string
     * @return string
     */
    public static function translitToEng(string $string): string
    {
        $from = array ("А","Б","В","Г","Д","Е","Ё","Ж","З","И","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Ъ","Ы","Ь","Э","Ю","Я",
            "а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ч","ш","щ","ъ","ы","ь","э","ю","я");
        $to = array ("A","B","V","G","D","E","Yo","Zh","Z","I","I","K","L","M","N","O","P","R","S","T","U","F","H","C","Ch","Sh","Sch","'","Y","'","E","Yu","Ya",
            "a","b","v","g","d","e","yo","zh","z","i","i","k","l","m","n","o","p","r","s","t","u","f","h","c","ch","sh","sch","'","y","'","e","yu","ya");
        for ($i=0; $i<count($from); $i++) {
            $string = preg_replace('/['.$from[$i].']/u', $to[$i], $string);
        }

        return $string;
    }

    /**
     * @param string $link
     * @return string
     */
    public static function extractYoutubeId($link)
    {
        if (self::existSubstring($link, 'youtube.com')) {
            $parameters = [];
            $query = parse_url($link, PHP_URL_QUERY);
            parse_str($query, $parameters);
            if (isset($parameters['v']))
                return $parameters['v'];
            return '';
        } elseif (self::existSubstring($link, 'youtu.be')) {
            $link = str_replace('http://', '', $link);
            $link = str_replace('https://', '', $link);
            $link = str_replace('youtu.be', '', $link);
            $link = str_replace('/', '', $link);
            return $link;
        } else return '';
    }
}
