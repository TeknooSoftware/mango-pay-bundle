<?php

/**
 * MangoPayBundle.
 *
 * LICENSE
 *
 * This source file is subject to the MIT license and the version 3 of the GPL3
 * license that are bundled with this package in the folder licences
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@uni-alteri.com so we can send you a copy immediately.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
namespace Teknoo\MangoPayBundle\Event;

/**
 * Class MangoPayEvents.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
final class MangoPayEvents
{
    const CARD_REGISTRATION_ERROR = 'event.mangopay.card.registration.error';
    const CARD_REGISTRATION_VALIDATED = 'event.mangopay.card.registration.validate';
    const CARD_REGISTRATION_ERROR_IN_VALIDATING = 'event.mangopay.card.registration.validating.error';
    const SECURE_FLOW_SUCCESS = 'event.mangopay.secure.flow.success';
    const SECURE_FLOW_ERROR = 'event.mangopay.secure.flow.error';
}
