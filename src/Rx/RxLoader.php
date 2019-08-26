<?php declare(strict_types=1);

namespace Rx;

use Symfony\Component\Yaml\Yaml;
use Rx\Exception\RxException;

final class RxLoader
{

    public static function load(string $filename): \stdClass
    {

        $fileContents = file_get_contents($filename);
        $fileExt = pathinfo($filename, PATHINFO_EXTENSION);
        $typeOfFile = 'Unknown';
        $contentsParsed = null;

        if (in_array($fileExt, ['yaml', 'yml']) || substr($fileContents, 0, 3) == '---') {
            $typeOfFile = 'YAML';
            $contentsParsed = Yaml::parse($fileContents, Yaml::PARSE_OBJECT_FOR_MAP);
        } else if (in_array($fileExt, ['json', 'js'])) {
            $typeOfFile = 'JSON';
            $contentsParsed = json_decode($fileContents);
        }

        if (is_null($contentsParsed)) {
            throw new RxException(sprintf('Unable to parse %s contents in \'%s\'.', $typeOfFile, $filename));
        }
        return $contentsParsed;
    }

}
