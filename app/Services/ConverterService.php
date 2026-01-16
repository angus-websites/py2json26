<?php

namespace App\Services;

use App\Exceptions\InvalidDictException;
use App\Exceptions\JsonConversionException;
use Exception;
use Symfony\Component\Process\Process;

class ConverterService
{
    /**
     * Convert Python-like data structure to JSON-compatible PHP array.
     *
     * @return string JSON string
     *
     * @throws InvalidDictException
     * @throws JsonConversionException
     */
    public function convertPythonToJson(string $pythonData, bool $pretty = true): string
    {
        // Run the python script and convert the data
        $process = new Process(['python3', base_path('scripts/convert.py'), $pythonData]);

        // Run the process
        $process->run();

        // Check if the process was successful
        if (! $process->isSuccessful()) {
            $error = trim($process->getErrorOutput());
            $exitCode = $process->getExitCode();
            throw match ($exitCode) {
                2 => new InvalidDictException('Invalid Python dictionary'),
                3 => new JsonConversionException('This object cannot be converted to JSON'),
                4 => new Exception('Unknown JSON error: '.$error),
                default => new Exception('Unexpected Python error: '.$error),
            };
        }
        $out = $process->getOutput();

        // Encode and Decode again to pretty print
        return json_encode(json_decode($process->getOutput(), false), $pretty ? JSON_PRETTY_PRINT : 0);
    }
}
