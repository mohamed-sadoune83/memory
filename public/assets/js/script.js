document.addEventListener('DOMContentLoaded', () => {
	let timer = 0;
	let interval = null;
	let moves = 0;
	let firstCard = null;
	let lock = false;
	let matchedPairs = 0;

	// Récupérer le plateau et les cartes
	const board = document.querySelector('.mg-board');
	if (!board) return;
	const cards = document.querySelectorAll('.mg-card');

	const playerId = board.dataset.playerId;

	// Récupérer le nombre total de paires depuis l'attribut data
	const totalPairs = parseInt(board.dataset.totalPairs || cards.length / 2, 10);

	// Timer
	function startTimer() {
		interval = setInterval(() => {
			timer++;
			document.getElementById('mg-timer').textContent = timer;
		}, 1000);
	}

	// === Choix difficulté ===
	const diffBtn = document.getElementById('difficulty-apply');
	const diffSelect = document.getElementById('difficulty');

	if (diffBtn) {
		diffBtn.addEventListener('click', () => {
			const pairs = diffSelect.value;
			const theme = document.getElementById('theme')?.value;

			const url = new URL(window.location.href);
			url.searchParams.set('pairs', pairs);
			if (theme) url.searchParams.set('theme', theme);

			window.location.href = url.toString();
		});
	}

	function saveGame() {
		const playerId = board.dataset.playerId;
		const pairs = totalPairs;

		fetch('/game/save', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: `player_id=${playerId}&pairs=${pairs}&moves=${moves}&time_seconds=${timer}`,
		})
			.then((res) => res.json())
			.then((data) => console.log('DEBUG Response:', data))
			.catch((err) => console.error('DEBUG Error:', err));
	}

	// Flip des cartes
	cards.forEach((card) => {
		card.addEventListener('click', () => {
			if (!interval) startTimer();
			if (lock || card.classList.contains('mg-flipped') || card.classList.contains('matched')) return;

			card.classList.add('mg-flipped');

			if (!firstCard) {
				firstCard = card;
			} else {
				moves++;
				document.getElementById('mg-moves').textContent = moves;

				if (firstCard.dataset.name === card.dataset.name) {
					// Paire trouvée
					firstCard.classList.add('matched');
					card.classList.add('matched');
					matchedPairs++;

					firstCard = null;

					// Vérification victoire
					if (matchedPairs === totalPairs) {
						gameWon();
					}
				} else {
					lock = true;
					setTimeout(() => {
						firstCard.classList.remove('mg-flipped');
						card.classList.remove('mg-flipped');
						firstCard = null;
						lock = false;
					}, 900);
				}
			}
		});
	});

	// Fonction victoire
	function gameWon() {
		clearInterval(interval);

		const overlay = document.getElementById('mg-victory');
		const stats = document.getElementById('mg-victory-stats');

		stats.textContent = `Pairs : ${totalPairs} — Coups : ${moves} — Temps : ${timer}s`;

		overlay.classList.add('active');

		launchConfetti(); // 🎉

		document.getElementById('mg-victory-close').onclick = () => overlay.classList.remove('active');

		saveGame();
	}
});

// --- Confettis futuristes ---
function launchConfetti() {
	const duration = 2000; // 2 sec
	const end = Date.now() + duration;

	// Animation loop
	(function frame() {
		createConfettiParticle();
		if (Date.now() < end) {
			requestAnimationFrame(frame);
		}
	})();
}

function createConfettiParticle() {
	const confetti = document.createElement('div');
	confetti.className = 'mg-confetti';

	const colors = ['gold', 'gold', 'white', 'silver', 'goldenrod'];

	confetti.style.left = Math.random() * 100 + 'vw';
	confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
	confetti.style.animationDuration = 1 + Math.random() * 1 + 's';
	confetti.style.transform = `rotate(${Math.random() * 360}deg)`;

	document.body.appendChild(confetti);

	setTimeout(() => confetti.remove(), 2000);
}

// === Choix thème ===
const themeSelect = document.getElementById('theme');
const themeApply = document.getElementById('theme-apply');

if (themeApply) {
	themeApply.addEventListener('click', () => {
		const theme = themeSelect.value;
		const pairs = document.getElementById('difficulty')?.value;

		const url = new URL(window.location.href);
		url.searchParams.set('theme', theme);
		if (pairs) url.searchParams.set('pairs', pairs);

		window.location.href = url.toString();
	});
}
