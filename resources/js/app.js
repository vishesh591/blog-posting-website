const theme = localStorage.getItem('theme') || 'dark';
document.body.classList.toggle('light', theme === 'light');

document.addEventListener('click', (event) => {
    if (event.target.closest('[data-theme-toggle]')) {
        const isLight = document.body.classList.toggle('light');
        localStorage.setItem('theme', isLight ? 'light' : 'dark');
    }
});

const showToast = (message, type = 'success') => {
    const root = document.querySelector('[data-toast-root]');
    if (!root) return;

    const toast = document.createElement('div');
    toast.className = `glass-panel mb-3 min-w-[260px] px-4 py-3 text-sm ${type === 'error' ? 'border-red-400/30' : 'border-emerald-400/30'}`;
    toast.textContent = message;
    root.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3500);
};

window.showToast = showToast;

document.querySelectorAll('[data-flash]').forEach((element) => {
    showToast(element.dataset.flash, element.dataset.type || 'success');
});

let searchTimer = null;
document.addEventListener('input', async (event) => {
    const input = event.target.closest('[data-search-input]');
    if (!input) return;

    const query = input.value;
    const target = document.querySelector(input.dataset.target);

    clearTimeout(searchTimer);
    searchTimer = setTimeout(async () => {
        if (!query) {
            target.innerHTML = '';
            target.classList.add('hidden');
            return;
        }

        const response = await fetch(`/search/suggestions?q=${encodeURIComponent(query)}`);
        const items = await response.json();

        target.innerHTML = '';
        if (!items.length) {
            target.classList.add('hidden');
            return;
        }

        items.forEach((item) => {
            target.insertAdjacentHTML('beforeend', `<a href="/search?q=${encodeURIComponent(item)}" class="block px-4 py-2 text-sm hover:bg-white/10">${item}</a>`);
        });
        target.classList.remove('hidden');
    }, 300);
});

document.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-like-button], [data-bookmark-button]');
    if (!button) return;

    event.preventDefault();

    try {
        const response = await fetch(button.dataset.endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({}),
        });
        const payload = await response.json();
        button.querySelector('[data-count]').textContent = payload.count;
        button.classList.toggle('bg-orange-500');
        button.classList.toggle('text-white');
    } catch {
        showToast('Something went wrong. Please try again.', 'error');
    }
});

document.addEventListener('change', async (event) => {
    const input = event.target.closest('[data-media-upload]');
    if (!input) return;

    const form = input.form;
    const data = new FormData(form);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: data,
        });

        if (!response.ok) throw new Error();

        showToast('Media uploaded successfully.');
        window.location.reload();
    } catch {
        showToast('Upload failed. Please retry.', 'error');
    }
});
