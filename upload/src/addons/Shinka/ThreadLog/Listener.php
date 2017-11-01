<?php

namespace Shinka\ThreadLog;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Manager;
use XF\Mvc\Entity\Structure;

/**
 * Adds `shinka_thread_log` property to Forum entity
 *
 * @package Shinka\ThreadLog
 */
class Listener
{
    public static function forumEntityStructure(Manager $em, Structure &$structure)
    {
        $structure->columns['shinka_thread_log'] = ['type' => Entity::BOOL, 'default' => false];
    }
}