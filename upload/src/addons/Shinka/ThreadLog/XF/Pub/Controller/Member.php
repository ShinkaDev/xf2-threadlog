<?php

namespace Shinka\ThreadLog\XF\Pub\Controller;

use XF\Entity\Thread;
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
        $user = $this->assertViewableUser($params->user_id);
        $page = $this->filterPage($params->page) ?: 1;
        $perPage = $this->options()->discussionsPerPage;

        /** @var \XF\Repository\Thread $repo */
		$repo = $this->repository('XF:Thread');
        /** @var \XF\Finder\Thread $finder */
        $finder = $repo->findThreadsWithPostsByUser($user['user_id']);
        $threads = $this->filterThreads($finder, $user['user_id'], $page, $perPage);

        $viewParams = [
            'user' => $user,
            'threads' => $threads,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
            'checked' => $this->filter('threadlog', 'str')
        ];

        return $this->view('Shinka\ThreadLog:View', 'shinka_threadlog_member_threadlog', $viewParams);
    }

    /**
     * From the initial `findThreadsWithPostsByUser` finder, filter out threads from forums that are not included
     * in the thread log, apply user filter, and limit by page.
     *
     * @param $finder \XF\Finder\Thread Threads that the given user has participated in
     * @param $filters []      Array of filters to apply. Each filter is an array of three args.
     * @param $page    integer
     * @param $perPage integer
     */
    private function filterThreads(\XF\Finder\Thread $finder, $user_id, $page, $perPage)
    {
        $filters = $this->getThreadLogFilterInput($user_id);

        $finder->where('Forum.shinka_thread_log', true);
        $this->applyFilters($finder, $filters);
        $finder->limitByPage($page, $perPage, $perPage * 2);
        $threads = $finder->fetch()
            ->filter(function(Thread $thread)
            {
                return $thread->canView();
            })
            ->slice(0, $perPage, true);

        return $threads;
    }

    /**
     * @param $user_id
     * @return array
     */
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
    public function applyFilters($finder, $filters)
    {
        foreach ($filters as $filter)
        {
            $finder->where($filter);
        }

        return $finder;
    }
}