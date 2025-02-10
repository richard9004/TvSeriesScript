<?php require_once 'TVSeriesSchedule.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search TV Series</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Find Next Airing Time</h2>
        
        <!-- Search Form -->
        <form method="GET">
            <div class="mb-3">
                <label for="datetime" class="form-label">Enter Date & Time:</label>
                <input type="datetime-local" id="datetime" name="datetime" class="form-control" 
                       value="<?= isset($_GET['datetime']) ? htmlspecialchars($_GET['datetime']) : '' ?>">
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">TV Series Title (Optional):</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Enter TV series title" 
                       value="<?= isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '' ?>">
            </div>

            <button type="submit" class="btn btn-primary w-100">Search</button>
        </form>
    </div>

    <!-- Display Next Airing Details -->
    <div class="card mt-4 shadow-lg">
        <div class="card-body">
            <?php if (isset($nextAiring) && $nextAiring): ?>
                <h3 class="card-title text-center">Next Airing</h3>
                <h4 class="card-title"><?= htmlspecialchars($nextAiring->title) ?></h4>
                <p class="card-text">
                    <strong>Channel:</strong> <?= htmlspecialchars($nextAiring->channel) ?><br>
                    <strong>Weekday:</strong> <?= TVSeriesSchedule::getWeekdayName($nextAiring->weekDay) ?><br>
                    <strong>Show Time:</strong> <?= date('h:i A', strtotime($nextAiring->showTime)) ?>
                </p>
            <?php else: ?>
                <p class="text-center">No TV series found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
