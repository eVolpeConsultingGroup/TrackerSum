<?php

class TrackerSumJob
{

    protected $filelocation = 'custom/include/TrackerSum/TrackerSumConfig.php';

    protected function getLastDate()
    {
        $lastDateFile = $this->getDateFromFile();
        if (!empty($lastDate)) {
            return $lastDate;
        }
        $lastDateCT = $this->getDateFromCustomTable();
        if (!empty($lastDate)) {
            return $lastDate;
        }
        $lastDateTT = $this->getDateFromTreackersTable();
        if (!empty($lastDate)) {
            return $lastDate;
        }
        return null;

    }
    protected function getDateFromFile()
    {
        $lastdate = null;
        if (file_exists($this->filelocation)) {
            require $this->filelocation;
        }
        return $lastdate;
    }
    protected function getDateFromCustomTable($sub_one_day = true)
    {
        $db = \DBManagerFactory::getInstance();
        if ($sub_one_day) {
            return $db->getOne("SELECT DATE(MAX(DATE_SUB(event_date, INTERVAL 1 DAY))) FROM ev_trackers_sum");
        } else {
            return $db->getOne("SELECT MAX(event_date) FROM ev_trackers_sum");
        }
    }
    protected function getDateFromTreackersTable()
    {
        $db = \DBManagerFactory::getInstance();
        return $db->getOne("SELECT DATE(MIN(date_modified)) FROM tracker");
    }

    public function run()
    {
        $date = '';
        // $date = $this->getLastDate();
        // if (!$date) {
        //     return;
        // }
        $this->rewriteData($date);
        // $this->dumpDataToFile($date);
    }
    protected function rewriteData($data)
    {
        $data = strtotime($data);
        $query = "INSERT INTO
            ev_trackers_sum
                SELECT
                    user_id,
                    date_event AS event_date,
                    MIN(date_modified) AS first_event,
                    MAX(date_modified) AS last_event,
                    SUM(1) AS counter,
                    0 AS deleted
                FROM
                (
                    SELECT
                        user_id ,
                        date_modified,
                        SUBSTRING(date_modified,1, 10) AS date_event
                    FROM
                        tracker
                    WHERE
                        date_modified BETWEEN DATE_SUB(NOW(),INTERVAL 2 DAY) AND NOW()
                        AND user_id IS NOT NULL
                ) AS T
            GROUP BY
                user_id,
                date_event
            ON DUPLICATE KEY UPDATE
                first_event=VALUES(first_event),
                last_event=VALUES(last_event),
                counter=VALUES(counter)";
        // -- date_modified BETWEEN '" . date("Y-m-d H:i:s", $data) . "' AND '" . date("Y-m-d H:i:s", $data + 86400) . "'
        $db = \DBManagerFactory::getInstance();
        $db->query($query);
    }
    protected function dumpDataToFile($date)
    {
        $date = strtotime($date) + 86400;
        // $date = $this->getDateFromCustomTable(false);
        file_put_contents($this->filelocation, '<?php

        $lastdate=\'' . date("Y-m-d H:i:s", $date) . '\';
        ');
    }
}
