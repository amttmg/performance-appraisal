<?php

function csvToArray($filename = '', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data   = [];
    if (($handle = fopen($filename, 'r')) !== false) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {

            if (!$header) {
                $header = array_map(function ($array) {
                    return str_slug($array, '_');
                }, $row);
            } else {
                $data[] = array_combine($header, $row);
            }
        }
        fclose($handle);
    }

    return $data;
}

/**
 * Get csv header
 *
 * @param string $filename
 * @param string $delimiter
 * @return array|bool|null
 */
function getCsvHeader($filename='', $delimiter = ',')
{
    if (!file_exists($filename) || !is_readable($filename))
        return false;

    $header = null;
    $data   = [];
    if (($handle = fopen($filename, 'r')) !== false) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            $header = array_map(function ($array) {
                return str_slug($array, '_');
            }, $row);
            return $header ;
        }
        fclose($handle);
    }

    return $data;
}

/**
 * Get technology by id if not found create new
 *
 * @param $technologyName
 * @return mixed
 */
function getTechnologyId($technologyName)
{
    $technology = app(\App\Services\TechnologyService::class)->firstOrCreate($technologyName);

    return $technology->id;
}