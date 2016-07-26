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
 * to richarddeloge@gmail.com so we can send you a copy immediately.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
namespace Teknoo\MangoPayBundle\Service\Interfaces;

/**
 * Interface StorageServiceInterface.
 *
 *
 * @copyright   Copyright (c) 2009-2016 Richard Déloge (richarddeloge@gmail.com)
 *
 * @link        http://teknoo.software/mangopay-bundle Project website
 *
 * @license     http://teknoo.software/license/mit         MIT License
 * @author      Richard Déloge <richarddeloge@gmail.com>
 */
interface StorageServiceInterface
{
    /**
     * Gets the service container parameters.
     *
     * @return array An array of parameters
     *
     * @api
     */
    public function all();

    /**
     * Gets a service container parameter.
     *
     * @param string $name The parameter name
     *
     * @return mixed The parameter value
     *
     * @throws \LogicException if the parameter is not defined
     *
     * @api
     */
    public function get($name);

    /**
     * Sets a service container parameter.
     *
     * @param string $name  The parameter name
     * @param mixed  $value The parameter value
     *
     * @throws \LogicException if the parameter can not be set
     *
     * @api
     */
    public function set($name, $value);

    /**
     * Returns true if a parameter name is defined.
     *
     * @param string $name The parameter name
     *
     * @return bool true if the parameter name is defined, false otherwise
     *
     * @api
     */
    public function has($name);
}
