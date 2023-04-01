<div class="row">
    <?php foreach ($sanctions as $teamname => $team) : ?>
        <div class="col-6 d-flex flex-column">
            <div>
                <?= $teamname ?>
                <?php foreach ($team as $setnumber => $set) : ?>
                    <div>
                        <?php if (count($set) > 0) : ?>
                            <div>
                                Set <?= $setnumber ?>
                            </div>
                            <?php foreach ($set as $sanction) : ?>
                                <div>
                                    <?= $sanction['number'] ?>
                                    <?= $sanction['last_name'] ?>
                                    <?= $sanction['severity'] ?> (<?= $sanction['scoreReceiving'] ?>-<?= $sanction['scoreVisiting'] ?>)
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>