<?php
/**
 * PHP version 5.6
 * 
 * @category PHP
 * @package  Jcresus_Build
 * @author   Dean Sellars <dino@sellars.org>
 * @license  no license
 * @link     http://jcres.test
 */
namespace Gen;
/**
 * PHP version 5.6
 * 
 * @category PHP
 * @package  Jcresus_Build
 * @author   Dean Sellars <dino@sellars.org>
 * @license  no license
 * @link     http://jcres.test
 */
interface Routes
{
     /** 
      * This sets a standard interface for Routes
      *
      * @return Array
      */
    public function getRoutes();
    public function getAuthentication();
}