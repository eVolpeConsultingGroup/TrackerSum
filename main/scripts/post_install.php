<?php

function post_install()
{
    $job = BeanFactory::getBean('Schedulers');
    if ($job->retrieve('trackersumcron') == null) {
        $job->new_with_id = true;
        $job->id = 'trackersumcron';
    }
    $job->name = 'Update Tracker Sum by Tracker';
    $job->job = 'function::trackersumcron';
    $job->date_time_start = '2005-01-01 00:00:00';
    $job->job_interval = '0::4::*::*::*';
    $job->status = 'Active';
    $job->catch_up = '1';
    $job->save();
    runTwelveQuickRepairAndRebuild();

}

function runTwelveQuickRepairAndRebuild()
{

    $autoexecute = true;
    $show_output = true;

    $sapi_type = php_sapi_name();
    if (substr($sapi_type, 0, 3) == 'cli') {
        $show_output = false;
    }

    require_once "modules/Administration/QuickRepairAndRebuild.php";
    $repair = new RepairAndClear();
    $repair->repairAndClearAll(array('clearAll'), array(translate('LBL_ALL_MODULES')), $autoexecute, $show_output);
}
