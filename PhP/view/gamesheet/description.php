<div id='gameteams'><div class="sectiontitle">Equipes</div><div class="text-center"><?= $game->receivingTeamName ?> - <?= $game->visitingTeamName ?></div></div>
<div id='gamelocation'><div class="sectiontitle">Lieu</div><div class="text-center"><?= $game->place ?></div></div>
<div id='gamevenue'><div class="sectiontitle">Salle</div><div class="text-center"><?= $game->venue ?></div></div>
<div id='gamedate'><div class="sectiontitle">Date</div><div class="text-center"><?= date_format(date_create($game->moment),'d M Y') ?></div></div>
<div id='gametime'><div class="sectiontitle">Heure</div><div class="text-center"><?= date_format(date_create($game->moment),'H:i') ?></div></div>
