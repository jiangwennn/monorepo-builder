<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MonorepoBuilder20210721\Symfony\Component\HttpFoundation\Session\Storage;

use MonorepoBuilder20210721\Symfony\Component\HttpFoundation\Request;
// Help opcache.preload discover always-needed symbols
\class_exists(\MonorepoBuilder20210721\Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage::class);
/**
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
class PhpBridgeSessionStorageFactory implements \MonorepoBuilder20210721\Symfony\Component\HttpFoundation\Session\Storage\SessionStorageFactoryInterface
{
    private $handler;
    private $metaBag;
    private $secure;
    /**
     * @see PhpBridgeSessionStorage constructor.
     */
    public function __construct($handler = null, \MonorepoBuilder20210721\Symfony\Component\HttpFoundation\Session\Storage\MetadataBag $metaBag = null, bool $secure = \false)
    {
        $this->handler = $handler;
        $this->metaBag = $metaBag;
        $this->secure = $secure;
    }
    /**
     * @param \Symfony\Component\HttpFoundation\Request|null $request
     */
    public function createStorage($request) : \MonorepoBuilder20210721\Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface
    {
        $storage = new \MonorepoBuilder20210721\Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage($this->handler, $this->metaBag);
        if ($this->secure && $request && $request->isSecure()) {
            $storage->setOptions(['cookie_secure' => \true]);
        }
        return $storage;
    }
}
