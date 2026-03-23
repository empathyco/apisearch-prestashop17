<?php

namespace Apisearch\Model;

use Apisearch\Context;

class ApisearchCategories
{
    public static function getCategories(
        $categoriesId,
        Context $context
    ) {
        if (empty($categoriesId)) {
            return [];
        }

        $langId = $context->getLanguageId();
        $categoriesName = array();
        $categoriesDepth0 = array();
        $categoriesDepth1 = array();
        $categoriesDepth2 = array();

        foreach ($categoriesId as $categoryId) {
            if ($categoryId == \Configuration::get('PS_ROOT_CATEGORY') || $categoryId == \Configuration::get('PS_HOME_CATEGORY')) {
                continue;
            }

            $category = new \Category($categoryId, $langId);
            if (\Validate::isLoadedObject($category)) {
                $categories = $category->getParentsCategories($langId);
                foreach ($categories as $innerCategory) {
                    $innerCategory = new \Category($innerCategory['id_category'], $langId);
                    if (\Validate::isLoadedObject($innerCategory)) {

                        if ($innerCategory->active == "0") {
                            continue;
                        }

                        if ($innerCategory->id == \Configuration::get('PS_ROOT_CATEGORY') || $innerCategory->id == \Configuration::get('PS_HOME_CATEGORY')) {
                            continue;
                        }

                        $categoriesName[] = $innerCategory->name;
                        if (\strval($innerCategory->level_depth) == "2") $categoriesDepth0[] = $innerCategory->name;
                        elseif (\strval($innerCategory->level_depth) == "3") $categoriesDepth1[] = $innerCategory->name;
                        elseif (\strval($innerCategory->level_depth) == "4") $categoriesDepth2[] = $innerCategory->name;
                    }
                }
            }
        }

        return [
            'categories_name' => $categoriesName,
            'categories_id_depth_0' => $categoriesDepth0,
            'categories_id_depth_1' => $categoriesDepth1,
            'categories_id_depth_2' => $categoriesDepth2
        ];
    }
}