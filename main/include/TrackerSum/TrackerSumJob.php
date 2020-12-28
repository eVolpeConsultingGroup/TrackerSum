<?php

class TrackerSumJob
{
    public function run()
    {
        $this->rewriteData();
    }
    /**
     *
     * 'OAuthTokens', -- autoryzacja (klucze w przeglądarce)
     * 'ev_PackageSubscriptions'  , -- nasze paczki pytanie o licencje
     * 'SchedulersJobs',  -- tworzenie jednorazowych zadań np przy zapisie spotkania
     * 'ActivityStream/Activities', -- aktywności sugara generowane na zapis
     * 'ActivityStream/Subscriptions', -- aktywności sugara generowane na zapis
     * 'ACLRoles', -- obsługa ról
     * 'Administration',  -- administracja ??
     * 'Dashboards', -- zmiana Dashboardów
     * 'Filters' ,-- zapisanie filtrów
     * 'Home' ,-- strona domowa (dashlety, i dashbordy na wejście do aplikacji )
     * 'Import',  -- import rekordów
     * 'Schedulers',  -- Harmonogramy w administracji
     * 'UserPreferences', -- preferencje użytkowników np sposób wyświetlania waluty
     * 'Users',  -- użytkownicy
     * 'Charts', -- wykresy w systemie
     * 'ReportMaker' , -- tworzenie reaportów
     * 'Reports', -- wywoływanie raporów
     * 'SugarFavorites',  -- dodanie rekordu do ulubionych (gwiwazdka przy rekordzie )
     * 'Tags', -- tagi
     * 'Teams', -- zespoły (administracja)
     * 'Trackers'  -- śledzenie
     */
    protected function rewriteData()
    {

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
                        date_modified BETWEEN DATE_SUB(NOW(),INTERVAL 4 DAY) AND NOW()
                        AND module_name NOT IN ('OAuthTokens','ev_PackageSubscriptions','SchedulersJobs',
                        'ActivityStream/Activities','ActivityStream/Subscriptions','ACLRoles',
                        'Administration','Dashboards','Filters',
                        'Home','Import','Schedulers',
                        'UserPreferences','Users','Charts',
                        'SugarFavorites','Tags','Teams',
                        'Trackers')
                        AND action IN ('index', 'save', 'view', 'buildreportmoduletree', 'confirm')
                        AND user_id IS NOT NULL
                ) AS T
            GROUP BY
                user_id,
                date_event
            ON DUPLICATE KEY UPDATE
                first_event=LEAST(VALUES(first_event),first_event),
                last_event=GREATEST(VALUES(last_event),last_event),
                counter=GREATEST(VALUES(counter),counter)
                ";
        // $data = strtotime($data);
        // -- date_modified BETWEEN '" . date("Y-m-d H:i:s", $data) . "' AND '" . date("Y-m-d H:i:s", $data + 86400) . "'
        $db = \DBManagerFactory::getInstance();
        $db->query($query);
    }
}
