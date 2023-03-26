<div id="gameresultdetails">
    <?php foreach ($sets as $set) : ?>
        <div class="setresult"><div class="sectiontitle">Set<?= $set->number ?></div><?= $set->scoreReceiving ?> - <?= $set->scoreVisiting ?></div>
    <?php endforeach; ?>
</div>