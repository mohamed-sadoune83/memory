<?php
$title = htmlspecialchars($title ?? 'Accueil', ENT_QUOTES, 'UTF-8');
?>

<section class="home-container">
  <h2><?= $title ?></h2>

  <p class="intro">Bienvenue dans le projet <strong>Memory Game</strong> !</p>

  <!-- Top 10 des joueurs -->
  <section class="players-section">
    <h3>Top 3 des meilleurs scores :</h3>
    <?php if (!empty($players)): ?>
      <div class="card-preview">
        <?php foreach ($players as $player): ?>
          <div class="card-item player-card card-style">
            <h4><?= htmlspecialchars($player['username'], ENT_QUOTES, 'UTF-8') ?></h4>
            <p>Score : <?= htmlspecialchars($player['score'], ENT_QUOTES, 'UTF-8') ?></p>
            <small><?= htmlspecialchars($player['created_at'], ENT_QUOTES, 'UTF-8') ?></small>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p>Aucun score disponible pour le moment.</p>
    <?php endif; ?>
  </section>


  <!-- Sélection du thème et aperçu des cartes -->
  <section class="cards-section">
    <div class="header-cards-section">
      <h3>Visualisez un thème :</h3>
      <form method="get" class="theme-form">
        <select name="theme" onchange="this.form.submit()" class="theme-select">
          <?php foreach ($themes as $theme): ?>
            <option value="<?= $theme['id'] ?>" <?= ($theme['id'] == $selectedTheme) ? 'selected' : '' ?>>
              <?= htmlspecialchars($theme['name'], ENT_QUOTES, 'UTF-8') ?>
            </option>
          <?php endforeach; ?>
        </select>
      </form>
    </div>

    <?php if (!empty($cards)): ?>
      <div class="card-preview">
        <?php foreach ($cards as $card): ?>
          <div class="card-item">
            <img class="card-img" src="assets/<?= htmlspecialchars($card['image_path'], ENT_QUOTES, 'UTF-8') ?>"
              alt="<?= htmlspecialchars($card['name'], ENT_QUOTES, 'UTF-8') ?>" width="80">
            <span><?= htmlspecialchars($card['name'], ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="no-cards">Aucune carte disponible pour ce thème.</p>
    <?php endif; ?>
  </section>

</section>