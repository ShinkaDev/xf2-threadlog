<?php

namespace Shinka\ThreadLog\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;

class ThreadLog extends Repository
{
    /**
     * @return Finder
     */
    public function findThreadLogsForMemberView()
    {
        $visitor = \XF::visitor();

        $finder = $this->finder('Shinka\ThreadLog:ThreadLog');
        $finder
            ->setDefaultOrder('position', 'ASC')
            ->with('Thread', true)
            ->with('Thread.User')
            ->with('Thread.Forum', true)
            ->with('Thread.Forum.Node.Permissions|' . $visitor->permission_combination_id)
            ->with('Thread.FirstPost', true)
            ->with('Thread.FirstPost.User')
            ->where('Thread.discussion_type', '<>', 'redirect')
            ->where('Thread.discussion_state', 'visible');

        return $finder;
    }
}