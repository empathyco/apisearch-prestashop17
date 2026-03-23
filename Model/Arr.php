<?php

namespace Apisearch\Model;

class Arr
{
    /**
     * @param array $array
     * @return array
     */
    public static function filterAssoc(array $array)
    {
        return array_filter($array, function($element) {
            if (is_array($element) && empty($element)) {
                return false;
            }

            return !empty($element);
        });
    }

    /**
     * @param array $array
     * @return array
     */
    public static function filterList($array)
    {
        if (!is_array($array)) {
            return null;
        }

        return array_values(array_filter(array_unique($array), function($element) {
            return !empty($element);
        }));
    }

    /**
     * @param array $items
     * @return array
     */
    public static function filterItems(array $items)
    {
        return array_filter($items, function($item) {
            return $item !== false;
        });
    }

    /**
     * @param array $array
     * @return array
     */
    public static function toArrayOfStrings(array $array) : array
    {
        return array_values(array_map('strval', array_unique(array_filter($array))));
    }

    /**
     * @param array<int, string|int> $ids
     * @return string[]
     */
    public static function toPartialIds(array $ids) : array
    {
        $partialIds = [];
        foreach ($ids as $id) {
            $id = strval($id);
            $length = strlen($id);
            if ($length < 2) {
                $partialIds[] = $id;
            } else {
                for ($i = 2; $i <= $length; $i++) {
                    $partialIds[] = substr($id, 0, $i);
                }
            }
        }

        return array_values(array_unique($partialIds));
    }
}