<?php

namespace Shinka\ThreadLog;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Manager;
use XF\Mvc\Entity\Structure;

class Listener
{
    public static function forumEntityStructure(Manager $em, Structure &$structure)
    {
        $COLUMN_NAME = 'shinka_thread_log';
        $structure->columns[$$COLUMN_NAME] = ['type' => Entity::BOOL, 'default' => false];
    }
}