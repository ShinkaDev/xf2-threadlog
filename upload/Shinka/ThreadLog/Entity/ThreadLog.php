<?php

namespace Shinka\ThreadLog\Entity;

use XF\Mvc\Entity\Structure;

class ThreadLog extends \XF\Mvc\Entity\Entity
{
    public static function getStructure(Structure $structure)
    {
        $structure->table = 'xf_shinka_thread_log';
        $structure->shortName = 'XF:ThreadLog';
        $structure->primaryKey = ['thread_id', 'user_id'];
        $structure->columns = [
            'thread_id' => ['type' => self::UINT, 'required' => true],
            'user_id' => ['type' => self::UINT, 'required' => true],
            'position' => ['type' => self::UINT, 'default' => 0]
        ];
        $structure->getters = [];
        $structure->relations = [
            'Thread' => [
                'entity' => 'XF:Thread',
                'type' => self::TO_ONE,
                'conditions' => 'thread_id',
                'primary' => true
            ],
        ];

        return $structure;
    }
}