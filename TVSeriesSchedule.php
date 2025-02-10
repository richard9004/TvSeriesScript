<?php

// Class for storing the next airing details
class NextAiringResponse {
    public function __construct(
        public int $id,
        public string $title,
        public string $channel,
        public string $weekDay,
        public string $showTime
    ) {}
}

// Class for storing the request parameters
class NextAiringRequest {
    public function __construct(
        public ?string $dateTime,
        public ?string $title = null
    ) {}
}

class TVSeriesSchedule {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Get the next airing time of a TV series based on the request parameters
    public function findNextAiring(NextAiringRequest $request): ?NextAiringResponse {
        $query = "SELECT ts.id, ts.title, ts.channel, tsi.week_day, tsi.show_time 
                  FROM tv_series ts
                  JOIN tv_series_intervals tsi ON ts.id = tsi.id_tv_series
                  WHERE (
                      (tsi.week_day = DAYOFWEEK(:timedate) AND tsi.show_time > TIME(:timedate)) 
                      OR (tsi.week_day > DAYOFWEEK(:timedate)) 
                      OR (tsi.week_day < DAYOFWEEK(:timedate))
                  )";

        if (!empty($request->title)) {
            $query .= " AND ts.title = :title";
        }

        $query .= " ORDER BY 
                    CASE 
                        WHEN tsi.week_day = DAYOFWEEK(:timedate) AND tsi.show_time > TIME(:timedate) THEN 0 
                        WHEN tsi.week_day > DAYOFWEEK(:timedate) THEN 1 
                        ELSE 2 
                    END,
                    tsi.week_day ASC,
                    tsi.show_time ASC
                    LIMIT 1;";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":timedate", $request->dateTime);

        if (!empty($request->title)) {
            $stmt->bindValue(":title", $request->title);
        }

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new NextAiringResponse(
            id: $row['id'],
            title: $row['title'],
            channel: $row['channel'],
            weekDay: $row['week_day'],
            showTime: $row['show_time']
        );
    }

    // Validate the request parameters 
    public static function validateRequest($request): array {
        $errors = [];
    
        if (!strtotime($request->dateTime)) {
            $errors[] = "Invalid datetime.";
        }
    
        if (!empty($request->title)) {
            if (strlen($request->title) > 255) {
                $errors[] = "The title must be less than 255 characters.";
            }
    
            if (!ctype_alnum(str_replace(' ', '', $request->title))) {
                $errors[] = "The title must be alphanumeric (letters and numbers only).";
            }
        }
    
        return $errors;
    }

    // Get the weekday name based on the day number
    public static function getWeekdayName(int $dayNumber): string {
        $weekdays = [
            1 => 'Sunday',
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
            7 => 'Saturday'
        ];

        return $weekdays[$dayNumber] ?? 'Unknown';
    }
}


$db = new PDO('mysql:host=localhost;dbname=tv_series_db', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schedule = new TVSeriesSchedule($db);

// Get the request parameters 
$dateTime = !empty($_GET['datetime']) ? trim($_GET['datetime']) : date('Y-m-d H:i:s');
$title = !empty($_GET['title']) ? trim($_GET['title']) : null;

$request = new NextAiringRequest($dateTime, $title);

// Validate the request parameters
$errors = TVSeriesSchedule::validateRequest($request);

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "Error: " . $error . PHP_EOL;
    }
    exit;
}

// Get the next airing time
$nextAiring = $schedule->findNextAiring($request);
