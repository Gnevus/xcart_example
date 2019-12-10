/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Add recommendation button controller
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

function PopupButtonAddRecommendation()
{
  PopupButtonAddRecommendation.superclass.constructor.apply(this, arguments);
}

function PopupButtonAddRecommendationAutoload()
{
  core.autoload(PopupButtonAddRecommendation);
}

extend(PopupButtonAddRecommendation, PopupButton);

PopupButtonAddRecommendation.prototype.pattern = '.add-recommendation';

PopupButtonAddRecommendationAutoload();
