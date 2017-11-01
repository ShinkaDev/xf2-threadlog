<?php

namespace Shinka\ThreadLog;

use XF\AddOn\AbstractSetup;
use XF\Db\Schema\Alter;

class Setup extends AbstractSetup
{
    use \XF\AddOn\StepRunnerInstallTrait;
    use \XF\AddOn\StepRunnerUpgradeTrait;
    use \XF\AddOn\StepRunnerUninstallTrait;

    private $COLUMN_NAME = 'shinka_thread_log';

    /**
     * Adds column to forum table to include forum in thread log
     *
     * @param array $stepParams
     */
	public function install(array $stepParams = [])
	{
        $this->schemaManager()->alterTable('xf_forum', function(Alter $table)
        {
            $table->addColumn($this->COLUMN_NAME, 'tinyint')->setDefault(0);
        });
	}

    /**
     * Drops column on forum table
     *
     * @param array $stepParams
     */
	public function uninstall(array $stepParams = [])
	{
        $this->schemaManager()->alterTable('xf_forum', function(Alter $table)
        {
            $table->dropColumns($this->COLUMN_NAME);
        });
	}
}