<?php

require_once 'custom/include/TrackerSum/TrackerSumJob.php';

$job_strings[] = 'trackersumcron';

function trackersumcron()
{
    (new TrackerSumJob)->run();
    return true;
}
