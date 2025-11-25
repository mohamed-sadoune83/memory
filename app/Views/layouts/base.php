<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($title ?? 'Memory', ENT_QUOTES) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

  <?php
  $user = $_SESSION['user'] ?? null;
  ?>

  <header>
    <div class="header-container">
      <h1>Memory Game</h1>
      <nav>
        <a href="/">Accueil</a>
        <a href="/game/play?player=1&pairs=6">Jouer</a>
        <a href="/leaderboard">Classement</a>

        <?php if (!empty($_SESSION['user'])): ?>
          <a href="/player/profile?player=<?= $_SESSION['user']['id'] ?>">Profil</a>
          <a href="/logout">Déconnexion</a>
        <?php else: ?>
          <a href="/login">Connexion</a>
        <?php endif; ?>
      </nav>

    </div>
  </header>

  <main>
    <?= $content ?>
  </main>

  <script src="/assets/js/script.js"></script>
  <footer>
    <p>&copy; <?= date('Y') ?> Memory Game. Tous droits réservés.</p>
  </footer>
</body>

</html>