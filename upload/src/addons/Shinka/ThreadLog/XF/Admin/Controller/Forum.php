<?php

namespace Shinka\ThreadLog\XF\Admin\Controller;

use XF\Entity\AbstractNode;
use XF\Entity\Node;
use XF\Mvc\FormAction;

/**
 * Extends Forum controller to persist `shinka_thread_log` on save
 *
 * @package Shinka\ThreadLog\XF\Admin\Controller
 */
class Forum extends XFCP_Forum
{
    protected function saveTypeData(FormAction $form, Node $node, AbstractNode $data)
    {
        parent::saveTypeData($form, $node, $data);

        $form->setup(function() use ($data)
        {
            $data->shinka_thread_log = $this->filter('shinka_thread_log', 'bool');
        });
    }
}