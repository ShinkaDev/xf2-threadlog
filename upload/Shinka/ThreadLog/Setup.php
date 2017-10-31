<?php

namespace Shinka\ThreadLog;

use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
    use \XF\AddOn\StepRunnerInstallTrait;
    use \XF\AddOn\StepRunnerUninstallTrait;

	public function install(array $stepParams = [])
	{
        $this->schemaManager()->createTable('xf_shinka_thread_log', function(Create $table)
        {
            $table->addColumn('thread_id', 'int');
            $table->addColumn('user_id', 'int');
            $table->addColumn('position', 'int');
            $table->addPrimaryKey(['thread_id', 'user_id']);
        });
	}

	public function uninstall(array $stepParams = [])
	{
        $this->schemaManager()->dropTable('xf_shinka_thread_log`');
	}
}