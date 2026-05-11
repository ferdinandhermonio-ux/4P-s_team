import './bootstrap';

import Alpine from 'alpinejs';

const applyTheme = (theme) => {
	const nextTheme = theme || 'light';
	document.documentElement.setAttribute('data-theme', nextTheme);
};

const getThemeLabel = (theme) => (theme === 'dark' ? 'Dark' : 'Light');

const getInitialTheme = () => {
	const stored = localStorage.getItem('slms_theme');
	if (stored === 'dark' || stored === 'light') {
		return stored;
	}

	return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const applyDensity = (density) => {
	const nextDensity = density || 'comfortable';
	document.documentElement.setAttribute('data-density', nextDensity);
};

const getDensityLabel = (density) => (density === 'compact' ? 'Compact' : 'Comfortable');

const getInitialDensity = () => {
	const stored = localStorage.getItem('slms_density');
	return stored === 'compact' ? 'compact' : 'comfortable';
};

window.toggleTheme = () => {
	const current = document.documentElement.getAttribute('data-theme') || 'light';
	const next = current === 'dark' ? 'light' : 'dark';

	document.documentElement.classList.add('theme-switching');
	applyTheme(next);
	localStorage.setItem('slms_theme', next);

	updatePreferenceLabels();

	window.dispatchEvent(new CustomEvent('slms:ui-updated', {
		detail: {
			theme: next,
			density: document.documentElement.getAttribute('data-density') || 'comfortable',
		},
	}));

	setTimeout(() => {
		document.documentElement.classList.remove('theme-switching');
	}, 260);
};

window.toggleDensity = () => {
	const current = document.documentElement.getAttribute('data-density') || 'comfortable';
	const next = current === 'compact' ? 'comfortable' : 'compact';
	applyDensity(next);
	localStorage.setItem('slms_density', next);

	updatePreferenceLabels();

	window.dispatchEvent(new CustomEvent('slms:ui-updated', {
		detail: {
			theme: document.documentElement.getAttribute('data-theme') || 'light',
			density: next,
		},
	}));
};

const updatePreferenceLabels = () => {
	const theme = document.documentElement.getAttribute('data-theme') || 'light';
	const density = document.documentElement.getAttribute('data-density') || 'comfortable';

	document.querySelectorAll('[data-theme-toggle-label]').forEach((el) => {
		el.textContent = getThemeLabel(theme);
	});

	document.querySelectorAll('[data-density-toggle-label]').forEach((el) => {
		el.textContent = getDensityLabel(density);
	});
};

applyTheme(getInitialTheme());
applyDensity(getInitialDensity());
updatePreferenceLabels();

window.Alpine = Alpine;

Alpine.start();
