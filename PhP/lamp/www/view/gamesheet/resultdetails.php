<div id="gameresultdetails">
    <?php foreach ($sets as $set) : ?>
        <div class="setresult">
            <div class="sectiontitle">
                <span class="setnumber">
                    Set <?= $set->number ?>, 
                </span>
                <span class="setduration">
                    <?= date("H\hi",strtotime($set->start)) ?>-<?= date("H\hi",strtotime($set->end)) ?>, <?= minutesBetween($set->start,$set->end) ?> minutes
                </span>
            </div>
            <div class="w-100 d-flex flex-row">
                <div class="teamsetresult">
                    <div>
                        <?= $game->receivingTeamName ?>
                    </div>
                    <div class="setpositions">
                        <?php foreach (VolscoreDB::getStartingPositions($set->id, $game->receivingTeamId) as $player) : ?>                            
                            <div class="playernumber"><?= $player->playerInfo['number'] ?></div>
                        <?php endforeach; ?>
                        <?php foreach (VolscoreDB::getSubPositions($set->id, $game->receivingTeamId) as $player) : ?>                            
                            <div class="playernumber"><?= $player->playerInfo['number'] ?></div>
                        <?php endforeach; ?>
                        <?php foreach (VolscoreDB::getSubInpoints($set->id, $game->receivingTeamId) as $point) : ?>                            
                            <div class="playernumber"><?= $point ?></div>
                        <?php endforeach; ?>
                        <?php foreach (VolscoreDB::getSubOutPoints($set->id, $game->receivingTeamId) as $point) : ?>                            
                            <div class="playernumber"><?= $point ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="scoringsequence">
                        <div class="playerpoints">
                            <?= implode('</div><div class="playerpoints">',VolscoreDB::getSetScoringSequence($set)[$game->receivingTeamId]) ?>
                        </div>
                    </div>
                    <div>
                        Temps morts: <?= count($game->receivingTimeouts[$set->number]) ?>
                    </div>
                    <?php if (count($game->receivingTimeouts[$set->number]) > 0) : ?>
                        <?php foreach ($game->receivingTimeouts[$set->number] as $timeout) : ?>
                            <div>
                                <?= $timeout['scoreReceiving'] ?>-<?= $timeout['scoreVisiting'] ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="teamsetresult">
                    <div>
                        <?= $game->visitingTeamName ?>
                    </div>
                    <div class="setpositions">
                        <div class="setpositions">
                        <?php foreach (VolscoreDB::getStartingPositions($set->id, $game->visitingTeamId) as $player) : ?>                            
                            <div class="playernumber"><?= $player->playerInfo['number'] ?></div>
                        <?php endforeach; ?>
                        <?php foreach (VolscoreDB::getSubPositions($set->id, $game->visitingTeamId) as $player) : ?>                            
                            <div class="playernumber"><?= $player->playerInfo['number'] ?></div>
                        <?php endforeach; ?>
                        <?php foreach (VolscoreDB::getSubInpoints($set->id, $game->visitingTeamId) as $point) : ?>                            
                            <div class="playernumber"><?= $point ?></div>
                        <?php endforeach; ?>
                        <?php foreach (VolscoreDB::getSubOutPoints($set->id, $game->visitingTeamId) as $point) : ?>                            
                            <div class="playernumber"><?= $point ?></div>
                        <?php endforeach; ?>
                    </div>
                    </div>
                    <div class="scoringsequence">
                        <div class="playerpoints">
                        <?php
                            $scoringSequence = VolscoreDB::getSetScoringSequence($set)[$game->visitingTeamId];

                            if (is_array($scoringSequence)) {
                                echo implode('</div><div class="playerpoints">', $scoringSequence);
                            } else {
                                // Gestion des cas où $scoringSequence n'est pas un tableau
                                echo '<div class="playerpoints">Pas de données disponibles</div>';
                            }
                            ?>

                        </div>
                    </div>
                    <div>
                        Temps morts: <?= count($game->visitingTimeouts[$set->number]) ?>
                    </div>
                    <?php if (count($game->visitingTimeouts[$set->number]) > 0) : ?>
                        <?php foreach ($game->visitingTimeouts[$set->number] as $timeout) : ?>
                            <div>
                                <?= $timeout['scoreReceiving'] ?>-<?= $timeout['scoreVisiting'] ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            </div>
    <?php endforeach; ?>
</div>