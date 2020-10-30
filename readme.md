A package that allows you to generate sql reports about logged in users, date of the first and last action on a given day based on the trackers table.

The user with the id "1" should be excluded from the reports

The data is updated in cron once a day (can be changed, although the query is time-consuming)

Package which

* creates the table ev_tracker_sum
* cron that cyclically rewrites grouped tracker data to the ev_tracker_sum table

The table contains information such as
user's ID (user_id - varchar(32))
date of the event (event_date - date )
date of the first user event (first_event - datetime)
date of the last user event (last_event - datetime)
number of events (counter - int(11))
whether the record is deleted (deleted - int(11) not used)


The system does not generate zero records for users with no entries in the trackers table