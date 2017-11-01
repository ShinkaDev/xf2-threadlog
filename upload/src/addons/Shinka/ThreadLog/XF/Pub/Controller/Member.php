<?php
namespace Shinka\ThreadLog\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

/**
 * Manages ThreadLog action, fetching inputs, and filtering the Thread finder
 *
 * @package Shinka\ThreadLog\XF\Pub\Controller
 */
class Member extends XFCP_Member
{
    /**
     * Fetches all threads with posts by user, limits by page, filters by `discussion_open` and/or the last
     * poster, and returns the corresponding view.
     *
     * @param ParameterBag $params Contains user ID and may contain page number
     * @return \XF\Mvc\Reply\View ThreadLog container view with view parameters
     */
    public function actionThreadLog(ParameterBag $params)
    {
        // Throws exception if user does not exist or visitor does not have permission to view user
        $user = $this->assertViewableUser($params->user_id);

        $page = $this->filterPage($params->page) ?: 1;
        $perPage = $this->options()->discussionsPerPage;
        $filters = $this->getThreadLogFilterInput($user['user_id']);

        /** @var \XF\Repository\Thread $repo */
		$repo = $this->repository('XF:Thread');
        /** @var \XF\Finder\Thread $finder */
        $finder = $repo->findThreadsWithPostsByUser($user['user_id'])
                       ->where('Forum.shinka_thread_log', true);

        $this->filterThreadLog($finder, $filters);
        $total = $finder->total();
        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'user' => $user,
            'threads' => $finder->fetch(),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
        ];

        return $this->view('Shinka\ThreadLog:View', 'shinka_threadlog_member_threadlog', $viewParams);
    }

    public function getThreadLogFilterInput($user_id)
    {
        $filters = [];
        $input = $this->filter('threadlog', 'str');

        switch($input) {
            case 'active':
                $filters[] = ['discussion_open', '=', 1];
                break;
            case 'locked':
                $filters[] = ['discussion_open', '=', 0];
                break;
            case 'need_replies':
                $filters[] = ['last_post_user_id', '!=', $user_id];
                break;
        }

        return $filters;
    }

    /**
     * @param \XF\Finder\Thread $finder
     */
    public function filterThreadLog($finder, $filters)
    {
        foreach ($filters as $filter)
        {
            $finder->where($filter);
        }

        return $finder;
    }
}