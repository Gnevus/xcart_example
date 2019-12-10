<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\View\StickyPanel\ItemsList;

/**
 * Recommendations items list's sticky panel
 */
class Recommendation extends \XLite\View\StickyPanel\ItemsListForm
{
    /**
     * Define additional buttons
     *
     * @return array
     */
    protected function defineAdditionalButtons()
    {
        return [
            'delete' => [
                'class'    => 'XLite\View\Button\DeleteSelected',
                'params'   => [
                    'label'      => '',
                    'style'      => 'more-action icon-only hide-on-disable hidden',
                    'icon-style' => 'fa fa-trash-o',
                ],
                'position' => 200,
            ],
        ];
    }

}
