<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\Controller\Admin;

/**
 * Recommendations controller
 *
 */
class Recommendations extends \XLite\Controller\Admin\AAdmin
{
    public function checkACL()
    {
        return parent::checkACL();
    }

    /**
     * Preprocessor for no-action run
     *
     * @return void
     */
    protected function doNoAction()
    {
        if (
            \XLite\Core\Request::getInstance()->isGet()
            && !\XLite\Core\Request::getInstance()->isAJAX()
        ) {
            // Reset 'isNew' status of recommendations on page open
            // (ignore this on POST and AJAX requests)
            $this->resetIsNewStatus();
        }

        parent::doNoAction();
    }

    /**
     * Get itemsList class
     *
     * @return string
     */
    public function getItemsListClass()
    {
        return parent::getItemsListClass()
            ?: 'XLite\Module\XCExample\Recommendations\View\ItemsList\Model\Recommendation';
    }

    /**
     * Return the current page title (for the content area)
     *
     * @return string
     */
    public function getTitle()
    {
        return static::t('Products recommendations');
    }

    /**
     * Return null since it's common recommendations list
     *
     * @return integer
     */
    public function getProductId()
    {
        return 0;
    }

    /**
     * Do action 'delete'
     *
     * @return void
     */
    protected function doActionDelete()
    {
        $select = \XLite\Core\Request::getInstance()->select;

        if ($select && is_array($select)) {
            \XLite\Core\Database::getRepo('\XLite\Module\XCExample\Recommendations\Model\Recommendation')->deleteInBatchById($select);
            \XLite\Core\TopMessage::addInfo(
                'Selected recommendations have been deleted'
            );
        } else {
            \XLite\Core\TopMessage::addWarning('Please select the recommendations first');
        }
    }
}
