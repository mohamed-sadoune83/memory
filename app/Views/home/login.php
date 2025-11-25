<div class="login-container">
        <h2>Connexion</h2>
        <?php if (!empty($error)): ?>
                <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        <form method="post" action="/login">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" required>

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>

                <button type="submit" class="btn-login">Se connecter</button>
        </form>
</div>