<div id="gameresultdetails">
    <?php foreach ($sets as $set) : ?>
        <div class="setresult">
            <div class="sectiontitle">Set<?= $set->number ?></div>
            <div class="w-100 d-flex flex-row">
                <div class="scoringsequence">
                    <div class="playerpoints">
                        <?= implode('</div><div class="playerpoints">',VolscoreDB::getSetScoringSequence($set)[$game->receivingTeamId]) ?>
                    </div>
                </div>
                <div class="scoringsequence">
                    <div class="playerpoints">
                        <?= implode('</div><div class="playerpoints">',VolscoreDB::getSetScoringSequence($set)[$game->visitingTeamId]) ?>
                    </div>
                </div>
            </div>
            </div>
    <?php endforeach; ?>
</div>