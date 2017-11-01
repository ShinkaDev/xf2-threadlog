<?php
/**
 * Extends the XF\Entity\Thread structure to manage relationship with ThreadLog.
 */
namespace Shinka\ThreadLog;

use XF\Mvc\Entity\Entity;

class Listener
{
    public static function threadEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
    {
        $structure->relations['ThreadLog'] = [
            'entity' => 'Shinka\ThreadLog:ThreadLog',
            'type' => Entity::TO_ONE,
            'conditions' => ['thread_id', 'user_id'],
            'primary' => true
        ];
    }
}