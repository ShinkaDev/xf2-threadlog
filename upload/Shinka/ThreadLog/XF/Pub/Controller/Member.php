<?php

namespace Shinka\ThreadLog\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
    public function actionThreadLog(ParameterBag $params)
    {
        $user = $this->assertViewableUser($params->user_id);

        $page = $this->filterPage($params->page);
        $perPage = $this->options()->threadsPerPage;
		$threadLogRepo = $this->repository('Shinka\ThreadLog:ThreadLog');

        $viewParams = [
            'user' => $user
        ];
        return $this->view('Shinka\ThreadLog:View', 'shinka_threadlog_member_threadlog', $viewParams);
    }
}