<?php
$title = htmlspecialchars($title ?? 'Profil', ENT_QUOTES, 'UTF-8');
?>

<div class="profile-container">
        <h2><?= $title ?></h2>

        <?php if (!empty($player)): ?>
                <div class="profile-card">
                        <h3><?= htmlspecialchars($player['username'], ENT_QUOTES, 'UTF-8') ?></h3>
                        <p><strong>ID :</strong> <?= $player['id'] ?></p>
                        <p><strong>Inscrit le :</strong> <?= htmlspecialchars($player['created_at'], ENT_QUOTES, 'UTF-8') ?></p>

                        <?php if (!empty($topScores)): ?>
                                <h4>Top 3 Scores</h4>
                                <ol class="score-list">
                                        <?php foreach ($topScores as $score): ?>
                                                <li>
                                                        <?= htmlspecialchars($score['score'], ENT_QUOTES, 'UTF-8') ?> points
                                                        <span
                                                                class="score-date">(<?= htmlspecialchars($score['created_at'], ENT_QUOTES, 'UTF-8') ?>)</span>
                                                </li>
                                        <?php endforeach; ?>
                                </ol>
                        <?php else: ?>
                                <p class="no-scores">Aucun score enregistré.</p>
                        <?php endif; ?>
                </div>
        <?php else: ?>
                <p class="no-player">Profil introuvable.</p>
        <?php endif; ?>
</div>