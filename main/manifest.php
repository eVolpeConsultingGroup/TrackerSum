<?php
$manifest = array(
    'built_in_version' => '7.7.0.0',
    'acceptable_sugar_flavors' => array(
        'ENT',
        'ULT',
        'PRO',
        'CE',
    ),
    'acceptable_sugar_versions' => array(
        '10.*',
        '9.*',
        '8.*',
        '7.*',
        '6.*',
    ),
    'key' => 'ev',
    'author' => 'eVolpe',
    'type' => 'module',
    'is_uninstallable' => false,
    'description' => 'Custom Logger',
    'name' => 'TrackerSum',
    'version' => '1.0.105',
    'published_date' => '2020-25-09 23:43:07',
    'type' => 'module',
    'remove_tables' => 'prompt',
);

$installdefs = array(
    'id' => 'TrackerSum',
    'language' => array(
        array(
            'from' => '<basepath>/ext/language/pl_PL.Schedulers.php',
            'to_module' => 'Schedulers',
            'language' => 'pl_PL',
        ),
        array(
            'from' => '<basepath>/ext/language/en_us.Schedulers.php',
            'to_module' => 'Schedulers',
            'language' => 'en_us',
        ),
    ),
    'copy' => array(
        array(
            'from' => '<basepath>/include/TrackerSum/TrackerSumJob.php',
            'to' => 'custom/include/TrackerSum/TrackerSumJob.php',
        ),

    ),
    'relationships' => array(
        array('meta_data' => '<basepath>/ext/relationships/TrackerSumMetaData.php'),
    ),
    'scheduledefs' => array(
        array(
            'from' => '<basepath>/ext/schedulers/TrackerSumCron.php',
        ),
    ),
);
