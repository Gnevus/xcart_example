/* vim: set ts=2 sw=2 sts=2 et: */

/**
 * Edit recommendation button controller
 *
 * Copyright (c) 2011-present Qualiteam software Ltd. All rights reserved.
 * See https://www.x-cart.com/license-agreement.html for license details.
 */

function PopupButtonEditRecommendation()
{
  PopupButtonEditRecommendation.superclass.constructor.apply(this, arguments);
}

function PopupButtonEditRecommendationAutoload()
{
  core.autoload(PopupButtonEditRecommendation);
}

extend(PopupButtonEditRecommendation, PopupButton);

PopupButtonEditRecommendation.prototype.pattern = '.edit-recommendation';

PopupButtonEditRecommendationAutoload();
