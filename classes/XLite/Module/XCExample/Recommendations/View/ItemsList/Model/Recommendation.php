<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

namespace XLite\Module\XCExample\Recommendations\View\ItemsList\Model;

/**
 * Recommendations items list (common recommendations page)
 *
 * @ListChild (list="admin.center", zone="admin")
 */
class Recommendation extends \XLite\View\ItemsList\Model\Table
{
    /**
     * Allowed sort criteria
     */
    const SORT_BY_MODE_TEXT         = 'r.text';
    const SORT_BY_MODE_URL           = 'r.url';

    /**
     * Widget param names
     */
    const PARAM_SEARCH_DATE_RANGE   = 'dateRange';
    const PARAM_SEARCH_KEYWORDS     = 'keywords';
    const PARAM_SEARCH_RATING       = 'rating';
    const PARAM_SEARCH_TYPE         = 'type';
    const PARAM_SEARCH_STATUS       = 'status';

    /**
     * The product selector cache
     *
     * @var mixed
     */
    protected $productSelectorWidget = null;

    /**
     * The profile selector cache
     *
     * @var mixed
     */
    protected $profileSelectorWidget = null;

    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        return array_merge(parent::getAllowedTargets(), ['recommendations']);
    }

    /**
     * Get search panel widget class
     *
     * @return string
     */
    protected function getSearchPanelClass()
    {
        return 'XLite\Module\XCExample\Recommendations\View\SearchPanel\Recommendation\Main';
    }

    /**
     * Description for blank items list
     *
     * @return string
     */
    protected function getBlankItemsListDescription()
    {
        return static::t('itemslist.admin.review.blank');
    }

    /**
     * Should itemsList be wrapped with form
     *
     * @return boolean
     */
    protected function wrapWithFormByDefault()
    {
        return true;
    }

    /**
     * Get wrapper form target
     *
     * @return string
     */
    protected function getFormTarget()
    {
        return 'recommendations';
    }

    /**
     * Get wrapper form params
     *
     * @return array
     */
    protected function getFormParams()
    {
        $params = [];

        $productId = \XLite\Core\Request::getInstance()->product_id;
        if ($productId) {
            $params['product_id'] = $productId;
        }

        return array_merge(
            parent::getFormParams(),
            $params
        );
    }

    /**
     * Return search parameters.
     *
     * @return array
     */
    static public function getSearchParams()
    {
        return [
            \XLite\Module\XCExample\Recommendations\Model\Repo\Recommendation::SEARCH_DATE_RANGE => static::PARAM_SEARCH_DATE_RANGE,
            \XLite\Module\XCExample\Recommendations\Model\Repo\Recommendation::SEARCH_KEYWORDS   => static::PARAM_SEARCH_KEYWORDS,
            \XLite\Module\XCExample\Recommendations\Model\Repo\Recommendation::SEARCH_RATING     => static::PARAM_SEARCH_RATING,
            \XLite\Module\XCExample\Recommendations\Model\Repo\Recommendation::SEARCH_TYPE       => static::PARAM_SEARCH_TYPE,
            \XLite\Module\XCExample\Recommendations\Model\Repo\Recommendation::SEARCH_STATUS     => static::PARAM_SEARCH_STATUS,
        ];
    }

    /**
     * Get a list of CSS files required to display the widget properly
     *
     * @return array
     */
    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();

        $list[] = 'modules/XCExample/Recommendations/recommendations/style.css';
        $list[] = 'modules/XCExample/Recommendations/recommendation/style.css';

        $list = array_merge($list, $this->getProductSelectorWidget()->getCSSFiles());
        $list = array_merge($list, $this->getProfileSelectorWidget()->getCSSFiles());

        return $list;
    }

    /**
     * Get a list of JS files required to display the widget properly
     *
     * @return array
     */
    public function getJSFiles()
    {
        $list = parent::getJSFiles();

        $list = array_merge($list, $this->getProductSelectorWidget()->getJSFiles());
        $list = array_merge($list, $this->getProfileSelectorWidget()->getJSFiles());

        return $list;
    }

    /**
     * Getter of the product selector widget
     *
     * @return \XLite\View\FormField\Select\Model\ProductSelector
     */
    protected function getProductSelectorWidget()
    {
        if (is_null($this->productSelectorWidget)) {
            $this->productSelectorWidget = new \XLite\View\FormField\Select\Model\ProductSelector();
        }

        return $this->productSelectorWidget;
    }

    /**
     * Getter of the product selector widget
     *
     * @return \XLite\View\FormField\Select\Model\ProductSelector
     */
    protected function getProfileSelectorWidget()
    {
        if (is_null($this->profileSelectorWidget)) {
            $this->profileSelectorWidget = new \XLite\View\FormField\Select\Model\ProfileSelector();
        }

        return $this->profileSelectorWidget;
    }

    /**
     * Return profile id
     *
     * @param \XLite\Module\XCExample\Recommendations\Model\Recommendation $entity
     *
     * @return int
     */
    public function getProfileId(\XLite\Module\XCExample\Recommendations\Model\Recommendation $entity)
    {
        return $entity->getProfile()
            ? $entity->getProfile()->getProfileId()
            : 0;
    }

    /**
     * Define and set widget attributes; initialize widget
     *
     * @param array $params Widget params OPTIONAL
     *
     * @return void
     */
    public function __construct(array $params = [])
    {
        $this->sortByModes += [
            static::SORT_BY_MODE_TEXT       => 'Text',
            static::SORT_BY_MODE_URL         => 'Url',
        ];

        parent::__construct($params);
    }

    // {{{ Search

    /**
     * Define so called "request" parameters
     *
     * @return void
     */
    protected function defineRequestParams()
    {
        parent::defineRequestParams();

        $this->requestParams = array_merge($this->requestParams, static::getSearchParams());
    }

    /**
     * Get right actions templates name
     *
     * @return array
     */
    protected function getRightActions()
    {
        $list = parent::getRightActions();

        array_unshift(
            $list,
            'modules/XCExample/Recommendations/' . $this->getDir() . '/' . $this->getPageBodyDir() . '/recommendation/action.link.twig'
        );

        return $list;
    }

    /**
     * Define widget parameters
     *
     * @return void
     */
    protected function defineWidgetParams()
    {
        parent::defineWidgetParams();

        $this->widgetParams += [
            static::PARAM_SEARCH_DATE_RANGE => new \XLite\Model\WidgetParam\TypeString('Date range', ''),
            static::PARAM_SEARCH_KEYWORDS => new \XLite\Model\WidgetParam\TypeString('Product, SKU or customer info', ''),
        ];

    }

    /**
     * Define columns structure
     *
     * @return array
     */
    protected function defineColumns()
    {
        return [
            'text' => [
                static::COLUMN_CLASS    => 'XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_NAME     => static::t('recommendation_text'),
                static::COLUMN_ORDERBY  => 100,
            ],
            'url' => [
                static::COLUMN_CLASS    => 'XLite\View\FormField\Inline\Input\Text',
                static::COLUMN_NAME     => static::t('recommendation_url'),
                static::COLUMN_ORDERBY  => 101,
            ],
        ];
    }

    /**
     * isFooterVisible
     *
     * @return boolean
     */
    protected function isFooterVisible()
    {
        return true;
    }

    /**
     * Mark list as removable
     *
     * @return boolean
     */
    protected function isRemoved()
    {
        return true;
    }

    /**
     * Mark list as selectable
     *
     * @return boolean
     */
    protected function isSelectable()
    {
        return true;
    }

    /**
     * Get container class
     *
     * @return string
     */
    protected function getContainerClass()
    {
        return parent::getContainerClass() . ' recommendations';
    }

    /**
     * Get panel class
     *
     * @return string|\XLite\View\Base\FormStickyPanel
     */
    protected function getPanelClass()
    {
        return 'XLite\Module\XCExample\Recommendations\View\StickyPanel\ItemsList\Recommendation';
    }

    /**
     * Return class name for the list pager
     *
     * @return string
     */
    protected function getPagerClass()
    {
        return 'XLite\View\Pager\Admin\Model\Table';
    }

    /**
     * Define repository name
     *
     * @return string
     */
    protected function defineRepositoryName()
    {
        return 'XLite\Module\XCExample\Recommendations\Model\Recommendation';
    }

    /**
     * Get create entity URL
     *
     * @return string
     */
    protected function getCreateURL()
    {
        return \XLite\Core\Converter::buildURL('recommendation');
    }

    protected function isLink(array $column, \XLite\Model\AEntity $entity)
    {
        return parent::isLink($column, $entity) && (
                'product' !== $column[static::COLUMN_CODE]
                || \XLite\Core\Auth::getInstance()->isPermissionAllowed('manage catalog')
            );
    }

    protected function buildEntityURL(\XLite\Model\AEntity $entity, array $column)
    {
        if ('product' == $column[static::COLUMN_CODE]) {
            return \XLite\Core\Converter::buildURL(
                'product',
                '',
                ['product_id' => $entity->getProduct()->getProductId()]
            );
        }

        return parent::buildEntityURL($entity, $column);
    }

    /**
     * getSortByModeDefault
     *
     * @return string
     */
    protected function getSortByModeDefault()
    {
        return static::SORT_BY_MODE_TEXT;
    }

    /**
     * getSortOrderDefault
     *
     * @return string
     */
    protected function getSortOrderModeDefault()
    {
        return \XLite\View\ItemsList\AItemsList::SORT_ORDER_DESC;
    }

    /**
     * Check - table header is visible or not
     *
     * @return boolean
     */
    protected function isHeaderVisible()
    {
        return true;
    }

    /**
     * Mark list as switchable (enable / disable)
     *
     * @return boolean
     */
    protected function isSwitchable()
    {
        return true;
    }
}
