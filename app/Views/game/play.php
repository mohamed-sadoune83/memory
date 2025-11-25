<?php
$pairs = (int) ($pairs ?? 6);
$themeId = (int) ($themeId ?? 7);
$playerId = $_SESSION['player_id'] ?? 0;
?>

<div class="mg-theme-selector">
        <label for="theme">Thème :</label>
        <select id="theme">
                <?php foreach ($themes as $themeOption): ?>
                        <option value="<?= $themeOption['id'] ?>" <?= $themeOption['id'] == $themeId ? "selected" : "" ?>>
                                <?= htmlspecialchars($themeOption['name'], ENT_QUOTES) ?>
                        </option>
                <?php endforeach; ?>
        </select>
        <button id="theme-apply">Valider</button>
</div>


<div class="mg-difficulty-selector">
        <label for="difficulty">Difficulté :</label>
        <select id="difficulty">
                <option value="3" <?= $pairs == 3 ? "selected" : "" ?>>Facile (3 paires)</option>
                <option value="6" <?= $pairs == 6 ? "selected" : "" ?>>Normal (6 paires)</option>
                <option value="12" <?= $pairs == 12 ? "selected" : "" ?>>Difficile (12 paires)</option>
        </select>
        <button id="difficulty-apply">Valider</button>
</div>


<section class="mg-container">

        <p>Thème : <strong><?= htmlspecialchars($selectedThemeName, ENT_QUOTES) ?></strong></p>

        <div class="mg-info">
                <span>Temps : <span id="mg-timer">0</span> s</span>
                <span>Coups : <span id="mg-moves">0</span></span>
        </div>

        <div class="mg-board" data-total-pairs="<?= $pairs ?>" data-player-id="<?= $_SESSION['user']['id'] ?>">
                <?php foreach ($cards as $card): ?>
                        <div class="mg-card" data-name="<?= htmlspecialchars($card['name'], ENT_QUOTES) ?>">
                                <img class="front" src="/assets/<?= htmlspecialchars($card['image_path'], ENT_QUOTES) ?>"
                                        alt="<?= htmlspecialchars($card['name'], ENT_QUOTES) ?>">
                                <img class="back" src="/assets/img/back-card.png" alt="Dos de carte">
                        </div>
                <?php endforeach; ?>
        </div>

</section>

<!-- Overlay Victoire -->
<div class="mg-victory-overlay" id="mg-victory">
        <div class="mg-victory-content">
                <h2>🎉 Congratulation !!!</h2>
                <p id="mg-victory-stats"></p>
                <button id="mg-victory-close">Fermer</button>
        </div>
</div>
<!-- Zone confettis -->
<canvas id="confetti-canvas"></canvas>