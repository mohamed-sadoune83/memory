<?php
$title = htmlspecialchars($title ?? 'Classement', ENT_QUOTES, 'UTF-8');
?>

<section class="leaderboard-container">
        <h2><?= $title ?></h2>

        <?php if (!empty($players)): ?>
                <table class="leaderboard-table">
                        <thead>
                                <tr>
                                        <th>Rang</th>
                                        <th>Joueur</th>
                                        <th>Score</th>
                                        <th>Paires (Niveau)</th>
                                        <th>Date</th>
                                </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($players as $index => $player): ?>
                                        <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= htmlspecialchars($player['username'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($player['score'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($player['pairs'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($player['created_at'], ENT_QUOTES, 'UTF-8') ?></td>
                                        </tr>
                                <?php endforeach; ?>
                        </tbody>
                </table>
        <?php else: ?>
                <p class="no-scores">Aucun score disponible pour le moment.</p>
        <?php endif; ?>
</section>