<?php

$dictionary["ev_trackers_sum"] = array(
    'table' => 'ev_trackers_sum',
    'fields' => array(
        'user_id' => array(
            'name' => 'user_id',
            'type' => 'varchar',
            'required' => true,
            'len' => 32,
            'isnull' => 'false',
        ),
        'event_date' => array(
            'name' => 'event_date',
            'type' => 'date',
            'isnull' => 'false',
            'required' => true,
        ),
        'first_event' => array(
            'name' => 'first_event',
            'type' => 'datetime',
        ),
        'last_event' => array(
            'name' => 'last_event',
            'type' => 'datetime',
        ),
        'counter' => array(
            'name' => 'counter',
            'type' => 'int',
            'default' => 0,
        ),
        'deleted' => array(
            'name' => 'deleted',
            'type' => 'int',
            'default' => 0,
        ),
    ),
    'indices' => array(
        array(
            'name' => 'ev_trackers_sum_primary',
            'type' => 'primary',
            'fields' => array(
                'user_id',
                'event_date',
            ),
        ),
    ),
);
