<?php

namespace Shinka\ThreadLog\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
    public function actionThreadLog(ParameterBag $params)
    {
        $user = $this->assertViewableUser($params->user_id);

        $page = $this->filterPage($params->page) ?: 1;
        $perPage = $this->options()->discussionsPerPage;
        $filters = $this->getThreadLogFilterInput($user['user_id']);

        /** @var \XF\Repository\Thread $repo */
		$repo = $this->repository('XF:Thread');
        /** @var \XF\Finder\Thread $finder */
        $finder = $repo->findThreadsWithPostsByUser($user['user_id']);

        $this->filterThreadLog($finder, $filters, $page, $perPage);
        $total = $finder->total();
        $finder->limitByPage($page, $perPage);

        $viewParams = [
            'user' => $user,
            'threads' => $finder->fetch(),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'filters' => $filters
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