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
            return [
                'categories_name' => [],
                'categories_id_depth_0' => [],
                'categories_id_depth_1' => [],
                'categories_id_depth_2' => [],
            ];
        }

        $langId = (int) $context->getLanguageId();
        $prefix = _DB_PREFIX_;
        $categoryIdsAsString = implode(',', array_map('intval', $categoriesId));
        $rootCategoryId = (int) \Configuration::get('PS_ROOT_CATEGORY');
        $homeCategoryId = (int) \Configuration::get('PS_HOME_CATEGORY');

        $sql = "
            SELECT DISTINCT parent.id_category, parent.level_depth, cl.name
            FROM {$prefix}category child
            INNER JOIN {$prefix}category parent
                ON parent.nleft <= child.nleft AND parent.nright >= child.nright
            LEFT JOIN {$prefix}category_lang cl
                ON cl.id_category = parent.id_category AND cl.id_lang = $langId
            WHERE child.id_category IN ($categoryIdsAsString)
            AND parent.active = 1
            AND parent.id_category NOT IN ($rootCategoryId, $homeCategoryId)
        ";

        $results = \Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql, true, false);

        $categoriesName = [];
        $categoriesDepth0 = [];
        $categoriesDepth1 = [];
        $categoriesDepth2 = [];

        foreach ($results as $row) {
            $name = $row['name'];
            if (empty($name)) {
                continue;
            }

            $categoriesName[] = $name;
            $levelDepth = (int) $row['level_depth'];
            if ($levelDepth === 2) $categoriesDepth0[] = $name;
            elseif ($levelDepth === 3) $categoriesDepth1[] = $name;
            elseif ($levelDepth === 4) $categoriesDepth2[] = $name;
        }

        return [
            'categories_name' => $categoriesName,
            'categories_id_depth_0' => $categoriesDepth0,
            'categories_id_depth_1' => $categoriesDepth1,
            'categories_id_depth_2' => $categoriesDepth2,
        ];
    }
}