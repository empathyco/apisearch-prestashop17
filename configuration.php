<?php

/**
 * Plugin Name: Apisearch
 * License: MIT
 * Copyright (c) 2020 - 2025 Apisearch SL
 *
 * This software is provided 'as-is', without any express or implied warranty.
 * In no event will the authors be held liable for any damages arising from the use
 * of this software, even if advised of the possibility of such damages.
 *
 * Permission is hereby granted, free of charge, to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons
 * to whom the Software is provided to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice must be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE, AND NON-INFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES, OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT,
 * OR OTHERWISE, ARISING FROM, OUT OF, OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 */

use Apisearch\Model\ApisearchDefaults;

/**
 * We suppress all possible incoming output data to avoid malformed feed
 */
ob_start();

require_once(dirname(__FILE__) . '../../../config/config.inc.php');
require_once(dirname(__FILE__) . '../../../init.php');
require_once __DIR__.'/vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
http_response_code(200);

echo json_encode([
    'VERSION' => ApisearchDefaults::PLUGIN_VERSION,
    'AS_DISPLAY_SEARCH_BAR' => Configuration::get('AS_DISPLAY_SEARCH_BAR'),
    'AS_CLUSTER_URL' => Configuration::get('AS_CLUSTER_URL'),
    'AS_ADMIN_URL' => Configuration::get('AS_ADMIN_URL'),
    'AS_APP' => Configuration::get('AS_APP'),
    'AS_INDEX_PRODUCTS_WITHOUT_IMAGE' => Configuration::get('AS_INDEX_PRODUCTS_WITHOUT_IMAGE'),
    'AS_INDEX_PRODUCT_PURCHASE_COUNT' => Configuration::get('AS_INDEX_PRODUCT_PURCHASE_COUNT'),
    'AS_INDEX_PRODUCT_NO_STOCK' => Configuration::get('AS_INDEX_PRODUCT_NO_STOCK'),
    'AS_FIELDS_SUPPLIER_REFERENCES' => Configuration::get('AS_FIELDS_SUPPLIER_REFERENCES'),
    'AS_INDEX_DESCRIPTIONS' => Configuration::get('AS_INDEX_DESCRIPTIONS'),
    'AS_INDEX_LONG_DESCRIPTIONS' => Configuration::get('AS_INDEX_LONG_DESCRIPTIONS'),
    'AS_B2B' => Configuration::get('AS_B2B'),
    'AS_INDEX_IMAGES_PER_COLOR' => Configuration::get('AS_INDEX_IMAGES_PER_COLOR'),
    'AS_SHOW_PRICES_WITHOUT_TAX' => Configuration::get('AS_SHOW_PRICES_WITHOUT_TAX'),
    'AS_GROUP_BY_COLOR' => Configuration::get('AS_GROUP_BY_COLOR'),
    'AS_IMAGE_FORMAT' => \Apisearch\Model\ApisearchImage::getCurrentImageType(),
    'AS_ORDER_BY' => \Apisearch\Model\ApisearchOrderBy::getCurrentOrderBy(),
    'AS_DEGRADE_NOT_AVAILABLE' => Configuration::get('AS_DEGRADE_NOT_AVAILABLE'),
    'AS_REAL_TIME_PRICES' => Configuration::get('AS_REAL_TIME_PRICES'),
    'AS_GROUPS_SHOW_NO_TAX[]' => explode(',', Configuration::get('AS_GROUPS_SHOW_NO_TAX')),
    'AS_AVOID_REFERENCES' => Configuration::get('AS_AVOID_REFERENCES'),
    'AS_DEFAULT_ROUND_DECIMALS' => Configuration::get('AS_DEFAULT_ROUND_DECIMALS', null, null, null, ApisearchDefaults::AS_DEFAULT_ROUND_DECIMALS),
    'AS_DYNAMIC_JS' => Configuration::get('AS_DYNAMIC_JS'),
    'AS_PARTIAL_IDS' => Configuration::get('AS_PARTIAL_IDS'),
    'AS_STOCK_0_AS_NOT_AVAILABLE' => Configuration::get('AS_STOCK_0_AS_NOT_AVAILABLE'),
]);