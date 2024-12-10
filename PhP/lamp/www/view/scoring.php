<?php
session_start(); // Start the session

// Initialize or update the timer value in the session
if (!isset($_SESSION['timer_start'])) {
    $_SESSION['timer_start'] = time(); // Store the current timestamp on first load
}

// Store the setid in the session if it's set in the URL
if (isset($_GET['setid'])) {
    if (!isset($_SESSION['setid']) || $_SESSION['setid'] != $_GET['setid']) {
        // If setid is different from the session's setid, reset the timer
        $_SESSION['setid'] = $_GET['setid'];
        $_SESSION['timer_start'] = time(); // Reset the timer
    }
}

$currentTime = time();
$elapsedTime = $currentTime - $_SESSION['timer_start']; // Calculate elapsed time in seconds

$title = 'Score du match ' . $game->number;
ob_start();
?>

<div class="row text-center">
    <h1>Set <?= $set->number ?></h1>
</div>
<div class="row text-center">
    <h2 id="timer">00:00</h2>
</div>

<div class="d-flex flex-row justify-content-around">
    <div class="d-flex flex-column order-<?= (($game->toss + $set->number) % 2 == 0) ? 1 : 2 ?>">
        <div class="teamname"><?= $game->receivingTeamName ?></div>
        <div class="setscore"><?= $game->scoreReceiving ?> sets</div>
        <div class="setscore"><?= count($game->receivingTimeouts) ?> timeouts</div>
        <div class="score"><?= $set->scoreReceiving ?></div>
        <div class="d-flex flex-column align-items-center">
            <?php foreach ($receivingPositions as $player) : ?>
                <div class="<?= ($player->id == $nextUp->id ? 'serving' : '') ?>">
                    <?= $player->number ?> <?= $player->last_name ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row actions d-flex flex-column">
            <form method="post" action="?action=scorePoint">
                <input type="hidden" name="setid" value="<?= $set->id ?>" />
                <input type="hidden" name="receiving" value="1" />
                <input class="col-12 btn btn-success" type="submit" value="Point" />
            </form>
            <div class="d-flex flex-row justify-content-between">
                <a class="btn btn-danger m-2" href="?action=selectBooking&teamid=<?= $game->receivingTeamId ?>&setid=<?= $set->id ?>">Sanctions</a>
                <?php if (count($game->receivingTimeouts) < 2) : ?>
                    <a class="btn btn-secondary m-2" href="?action=timeout&teamid=<?= $game->receivingTeamId ?>&setid=<?= $set->id ?>">Temps Mort</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column order-<?= (($game->toss + $set->number) % 2 == 0) ? 2 : 1 ?>">
        <div class="teamname"><?= $game->visitingTeamName ?></div>
        <div class="setscore"><?= $game->scoreVisiting ?></div>
        <div class="setscore"><?= count($game->visitingTimeouts) ?> timeouts</div>
        <div class="score"><?= $set->scoreVisiting ?></div>
        <div class="d-flex flex-column align-items-center">
            <?php foreach ($visitingPositions as $player) : ?>
                <div class="<?= ($player->id == $nextUp->id ? 'serving' : '') ?>">
                    <?= $player->number ?> <?= $player->last_name ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="row actions d-flex flex-column">
            <form method="post" action="?action=scorePoint">
                <input type="hidden" name="setid" value="<?= $set->id ?>" />
                <input type="hidden" name="receiving" value="0" />
                <input class="col-12 btn btn-success" type="submit" value="Point" />
            </form>
            <div class="d-flex flex-row justify-content-between">
                <a class="btn btn-danger m-2" href="?action=selectBooking&teamid=<?= $game->visitingTeamId ?>&setid=<?= $set->id ?>">Sanctions</a>
                <?php if (count($game->visitingTimeouts) < 2) : ?>
                    <a class="btn btn-secondary m-2" href="?action=timeout&teamid=<?= $game->visitingTeamId ?>&setid=<?= $set->id ?>">Temps Mort</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    let secondsElapsed = <?= $elapsedTime ?>; // Initialize with elapsed time

    function updateTimer() {
        const timerElement = document.getElementById('timer');
        const minutes = Math.floor(secondsElapsed / 60);
        const seconds = secondsElapsed % 60;

        // Format the time as MM:SS
        const formattedTime =
            String(minutes).padStart(2, '0') + ':' +
            String(seconds).padStart(2, '0');

        timerElement.textContent = formattedTime;
        secondsElapsed++; // Increment the time
    }

    // Update the timer every second
    setInterval(updateTimer, 1000);
    updateTimer(); // Initialize immediately
</script>

<?php
$content = ob_get_clean();
require_once 'gabarit.php';
?>
