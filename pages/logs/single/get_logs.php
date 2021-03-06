<?php

    include('../../../config.php');
    session_start();

    if($_POST) {


        if(isset($_SESSION['id'])) {

            // get log id
            $log_id = $_POST['lesson_id'];

            // make db connection
            $db = new Sqlite3("../../../" . 'database.sqlite',  SQLITE3_OPEN_READWRITE);

            // get logged lessons
            $statement = $db->prepare('SELECT * FROM lessons WHERE user = :user AND id = :id');
            $statement->bindValue(':user', $_SESSION['id']);
            $statement->bindValue(':id', $log_id);
            $result = $statement->execute();

            $tz = date_default_timezone_get();
            date_default_timezone_set($_COOKIE['time_offset']);

            $lesson = $result->fetchArray(SQLITE3_ASSOC);
            $timeStamp = strtotime($lesson["started_at"].' GMT+03');
            $lesson["started_at"] = date("Y-m-d H:i:s", $timeStamp);
            $timeStamp = strtotime($lesson["ended_at"].' GMT+03');
            $lesson["ended_at"] = date("Y-m-d H:i:s", $timeStamp);

            date_default_timezone_set($tz);

            // free up memory
            $result->finalize();

            $statement = $db->prepare('SELECT a.*, l.started_at, l.ended_at FROM logs AS l
                LEFT JOIN activities AS a ON a.id = l.activity
                WHERE l.lesson = :lesson_id ORDER BY a.type DESC, a.slug ASC');
            $statement->bindValue(':user', $_SESSION['id']);
            $statement->bindValue(':lesson_id', $lesson['id']);
            $activities_raw = $statement->execute();

            $fp = fopen('file.csv', 'w');

            $tz = date_default_timezone_get();
            date_default_timezone_set($_COOKIE['time_offset']);

            $logs = [];
            while ( $row = $activities_raw->fetchArray() ) {
                $timeStamp = strtotime($row["started_at"].' GMT+03');
                $row["started_at"] = date("Y-m-d H:i:s", $timeStamp);
                $timeStamp = strtotime($row["ended_at"].' GMT+03');
                $row["ended_at"] = date("Y-m-d H:i:s", $timeStamp);
                array_push($logs, $row);
                fputcsv($fp, $row);
            }

            date_default_timezone_set($tz);

            fclose($fp);
            // free up memory
            $activities_raw->finalize();
            echo json_encode([$lesson, $logs]);


        }
    } else {

    }
?>
