import './bootstrap';
import Alpine from 'alpinejs';
import {
    siDocker,
    siFramer,
    siGo,
    siKubernetes,
    siLangchain,
    siNextdotjs,
    siPostgresql,
    siPytorch,
    siRedis,
    siRust,
    siTailwindcss,
    siTypescript,
    siVercel,
} from 'simple-icons';
import {
    ArrowRight,
    ArrowUpRight,
    BadgeCheck,
    Bot,
    BriefcaseBusiness,
    Building2,
    CalendarDays,
    ChartColumnBig,
    ChevronDown,
    Circle,
    Clock3,
    Cloud,
    Code2,
    Cpu,
    Database,
    Facebook,
    Factory,
    FileText,
    FolderOpen,
    Globe,
    GraduationCap,
    HeartPulse,
    Home,
    Hotel,
    House,
    Instagram,
    Landmark,
    Layers3,
    LayoutDashboard,
    Linkedin,
    Mail,
    MapPin,
    Menu,
    MessagesSquare,
    Palette,
    Phone,
    Plane,
    Quote,
    ReceiptText,
    Rocket,
    ServerCog,
    Settings2,
    ShieldCheck,
    ShoppingCart,
    Smartphone,
    Sparkles,
    Target,
    Truck,
    Twitter,
    UserRound,
    Users,
    WalletCards,
    Workflow,
    X,
    Youtube,
    createIcons,
} from 'lucide';

window.Alpine = Alpine;

const lucideIcons = {
    ArrowRight,
    ArrowUpRight,
    BadgeCheck,
    Bot,
    BriefcaseBusiness,
    Building2,
    CalendarDays,
    ChartColumnBig,
    ChevronDown,
    Circle,
    Clock3,
    Cloud,
    Code2,
    Cpu,
    Database,
    Facebook,
    Factory,
    FileText,
    FolderOpen,
    Globe,
    GraduationCap,
    HeartPulse,
    Home,
    Hotel,
    House,
    Instagram,
    Landmark,
    Layers3,
    LayoutDashboard,
    Linkedin,
    Mail,
    MapPin,
    Menu,
    MessagesSquare,
    Palette,
    Phone,
    Plane,
    Quote,
    ReceiptText,
    Rocket,
    ServerCog,
    Settings2,
    ShieldCheck,
    ShoppingCart,
    Smartphone,
    Sparkles,
    Target,
    Truck,
    Twitter,
    UserRound,
    Users,
    WalletCards,
    Workflow,
    X,
    Youtube,
};

const simpleIconMap = {
    nextdotjs: siNextdotjs,
    typescript: siTypescript,
    tailwindcss: siTailwindcss,
    framer: siFramer,
    rust: siRust,
    go: siGo,
    postgresql: siPostgresql,
    redis: siRedis,
    docker: siDocker,
    kubernetes: siKubernetes,
    vercel: siVercel,
    pytorch: siPytorch,
    langchain: siLangchain,
};

window.websiteImageManager = (initialFields = {}, labels = {}) => ({
    fields: initialFields,
    activeImageKey: 'home.hero_dashboard',
    libraryOpen: false,
    targetLabels: labels,
    resolveAsset(path) {
        if (!path) return '';
        if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) return path;
        return `${window.location.origin}/${String(path).replace(/^\/+/, '')}`;
    },
    valueFor(key) {
        return String(key).split('.').reduce((carry, segment) => (carry?.[segment] ?? ''), this.fields);
    },
    focusLibrary(key) {
        this.activeImageKey = key;
        this.libraryOpen = true;
    },
    assignAsset(path) {
        const segments = String(this.activeImageKey).split('.');
        let target = this.fields;

        while (segments.length > 1) {
            target = target[segments.shift()];
        }

        target[segments[0]] = path;
        this.libraryOpen = false;
    },
});

const resolveManagedAsset = (path) => {
    if (!path) return '';
    if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) return path;
    return `${window.location.origin}/${String(path).replace(/^\/+/, '')}`;
};

window.singleMediaPicker = (initialValue = '') => ({
    selectedImage: initialValue,
    libraryOpen: false,
    resolveAsset(path) {
        return resolveManagedAsset(path);
    },
    focusLibrary() {
        this.libraryOpen = true;
    },
    assignAsset(path) {
        this.selectedImage = path;
        this.libraryOpen = false;
    },
});

window.targetedMediaPicker = (initialValues = {}, labels = {}, defaultTarget = 'default') => ({
    values: initialValues,
    targetLabels: labels,
    activeTarget: defaultTarget,
    libraryOpen: false,
    resolveAsset(path) {
        return resolveManagedAsset(path);
    },
    focusLibrary(target) {
        this.activeTarget = String(target);
        this.libraryOpen = true;
    },
    assignAsset(path) {
        this.values[String(this.activeTarget)] = path;
        this.libraryOpen = false;
    },
});

document.addEventListener('alpine:init', () => {
    Alpine.store('marketingPopup', {
        open: false,
        mode: 'lead',
        title: 'Start Your Project',
        description: 'Share a little about your goals and we will follow up with the right next step.',
        source: 'website_popup',
        context: 'General inquiry',
        submitLabel: 'Send Inquiry',
        openLead(options = {}) {
            this.mode = options.mode || 'lead';
            this.title = options.title || 'Start Your Project';
            this.description = options.description || 'Share a little about your goals and we will follow up with the right next step.';
            this.source = options.source || 'website_popup';
            this.context = options.context || this.title;
            this.submitLabel = options.submitLabel || 'Send Inquiry';
            this.open = true;
        },
        close() {
            this.open = false;
        },
    });
});

document.addEventListener('DOMContentLoaded', async () => {
    Alpine.start();

    document.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target.closest('[data-lead-popup]') : null;
        if (!target) return;

        const popup = window.Alpine?.store?.('marketingPopup');
        if (!popup?.openLead) return;

        event.preventDefault();

        popup.openLead({
            title: target.getAttribute('data-lead-title') || undefined,
            source: target.getAttribute('data-lead-source') || undefined,
            context: target.getAttribute('data-lead-context') || undefined,
            submitLabel: target.getAttribute('data-lead-submit') || undefined,
            description: target.getAttribute('data-lead-description') || undefined,
        });
    }, { capture: true });

    createIcons({ icons: lucideIcons });

    if (document.querySelector('iconify-icon')) {
        import('iconify-icon').catch(() => {});
    }

    if (document.querySelector('[data-chart]')) {
        import('chart.js/auto').then(({ default: Chart }) => {
            window.Chart = Chart;
        }).catch(() => {});
    }

    // Lightweight DataTables-like enhancement for admin tables.
    // Usage: add `data-datatable` to a <table> (or we will auto-enable on `.dashboard-table`).
    const enhanceDatatable = (table) => {
        if (!(table instanceof HTMLTableElement)) return;
        if (table.dataset.datatableInit === '1') return;
        const tbody = table.tBodies?.[0];
        if (!tbody) return;

        table.dataset.datatableInit = '1';

        const wrapper = document.createElement('div');
        wrapper.className = 'datatable-shell';

        const toolbar = document.createElement('div');
        toolbar.className = 'datatable-toolbar';
        toolbar.innerHTML = `
            <div class="datatable-title">Records</div>
            <div class="datatable-actions">
                <input class="datatable-search" type="search" placeholder="Search..." aria-label="Search table" />
                <div class="datatable-count" aria-live="polite"></div>
            </div>
        `;

        const parent = table.parentElement;
        if (!parent) return;

        parent.insertBefore(wrapper, table);
        wrapper.appendChild(toolbar);
        wrapper.appendChild(table);

        const searchInput = toolbar.querySelector('.datatable-search');
        const countEl = toolbar.querySelector('.datatable-count');
        const rows = Array.from(tbody.rows);

        const getText = (row) => row.textContent?.toLowerCase() ?? '';
        const setCount = (visible, total) => {
            if (!countEl) return;
            countEl.textContent = `${visible} / ${total}`;
        };

        const applyFilter = () => {
            const q = (searchInput?.value ?? '').trim().toLowerCase();
            let visible = 0;
            rows.forEach((row) => {
                const match = !q || getText(row).includes(q);
                row.style.display = match ? '' : 'none';
                if (match) visible += 1;
            });
            setCount(visible, rows.length);
        };

        if (searchInput) {
            searchInput.addEventListener('input', applyFilter, { passive: true });
        }
        setCount(rows.length, rows.length);

        // Sorting
        const thead = table.tHead;
        if (thead) {
            const headers = Array.from(thead.querySelectorAll('th'));
            headers.forEach((th, idx) => {
                th.classList.add('datatable-th');
                th.tabIndex = 0;
                th.setAttribute('role', 'button');
                th.setAttribute('aria-label', `${th.textContent || 'Column'} sort`);

                const sort = () => {
                    const current = th.dataset.sortDir || 'none';
                    const next = current === 'asc' ? 'desc' : 'asc';
                    headers.forEach((h) => {
                        if (h !== th) delete h.dataset.sortDir;
                    });
                    th.dataset.sortDir = next;

                    const visibleRows = rows.filter((r) => r.style.display !== 'none');
                    const parse = (value) => {
                        const v = (value ?? '').trim();
                        const n = Number(v.replace(/[^0-9.\-]/g, ''));
                        if (!Number.isNaN(n) && /[0-9]/.test(v)) return n;
                        return v.toLowerCase();
                    };
                    visibleRows.sort((a, b) => {
                        const av = parse(a.cells?.[idx]?.textContent ?? '');
                        const bv = parse(b.cells?.[idx]?.textContent ?? '');
                        if (typeof av === 'number' && typeof bv === 'number') return av - bv;
                        return String(av).localeCompare(String(bv));
                    });
                    if (next === 'desc') visibleRows.reverse();
                    visibleRows.forEach((r) => tbody.appendChild(r));
                };

                th.addEventListener('click', sort);
                th.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        sort();
                    }
                });
            });
        }
    };

    document.querySelectorAll('table[data-datatable], table.dashboard-table').forEach((table) => {
        enhanceDatatable(table);
    });

    const prefersReducedMotion = window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches ?? false;
    const isSmallScreen = window.matchMedia?.('(max-width: 767px)')?.matches ?? false;
    const lowPowerDevice = (navigator.hardwareConcurrency ?? 8) <= 4;

    document.querySelectorAll('[data-simple-icon]').forEach((element) => {
        const key = element.dataset.simpleIcon;
        const icon = key ? simpleIconMap[key] : null;

        if (icon) {
            element.innerHTML = `
                <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5" fill="currentColor">
                    <path d="${icon.path}" />
                </svg>
            `;
            return;
        }

        element.textContent = element.dataset.fallback || '•';
    });

    const revealElements = document.querySelectorAll('[data-reveal]');
    if (revealElements.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.15 });

        revealElements.forEach((element) => {
            element.classList.add('reveal');
            observer.observe(element);
        });
    }

    const counterElements = document.querySelectorAll('[data-counter-target]');
    if (counterElements.length) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                const element = entry.target;
                const target = Number(element.dataset.counterTarget || 0);
                const duration = 900;
                const start = performance.now();

                const step = (now) => {
                    const progress = Math.min((now - start) / duration, 1);
                    element.textContent = `${Math.floor(progress * target)}+`;
                    if (progress < 1) requestAnimationFrame(step);
                };

                requestAnimationFrame(step);
                counterObserver.unobserve(element);
            });
        }, { threshold: 0.6 });

        counterElements.forEach((element) => {
            counterObserver.observe(element);
        });
    }

    document.querySelectorAll('[data-typed-words]').forEach((element) => {
        if (prefersReducedMotion || isSmallScreen) return;

        let words = [];

        try {
            words = JSON.parse(element.dataset.typedWords || '[]');
        } catch (_error) {
            words = [];
        }

        if (!words.length) return;

        let wordIndex = 0;
        let charIndex = 0;
        let deleting = false;
        let timerId;

        const tick = () => {
            const currentWord = words[wordIndex] || '';

            if (!deleting) {
                charIndex += 1;
                element.textContent = currentWord.slice(0, charIndex);

                if (charIndex >= currentWord.length) {
                    deleting = true;
                    timerId = window.setTimeout(tick, 1200);
                    return;
                }

                timerId = window.setTimeout(tick, 70);
                return;
            }

            charIndex -= 1;
            element.textContent = currentWord.slice(0, Math.max(charIndex, 0));

            if (charIndex <= 0) {
                deleting = false;
                wordIndex = (wordIndex + 1) % words.length;
                timerId = window.setTimeout(tick, 220);
                return;
            }

            timerId = window.setTimeout(tick, 36);
        };

        tick();
        window.addEventListener('beforeunload', () => window.clearTimeout(timerId), { once: true });
    });

    const canvas = document.querySelector('[data-neural-canvas]');
    const allowCanvas = !prefersReducedMotion && !isSmallScreen && !lowPowerDevice;

    if (allowCanvas && canvas instanceof HTMLCanvasElement) {
        const ctx = canvas.getContext('2d', { alpha: true });
        if (ctx) {
            const pointer = { x: 0, y: 0 };
            let animationFrame;
            let running = false;

            const resize = () => {
                const parent = canvas.parentElement;
                if (!parent) return;
                canvas.width = parent.clientWidth;
                canvas.height = parent.clientHeight;
            };

            const nodes = Array.from({ length: 14 }, (_, index) => ({
                x: (index % 4 + 1) * 180,
                y: (Math.floor(index / 4) + 1) * 130,
                dx: (Math.random() - 0.5) * 0.16,
                dy: (Math.random() - 0.5) * 0.16,
            }));

            const draw = () => {
                if (!running) return;

                const now = performance.now();
                if (draw.last && now - draw.last < 50) {
                    animationFrame = requestAnimationFrame(draw);
                    return;
                }
                draw.last = now;

                ctx.clearRect(0, 0, canvas.width, canvas.height);

                nodes.forEach((node) => {
                    node.x += node.dx;
                    node.y += node.dy;

                    if (node.x < 40 || node.x > canvas.width - 40) node.dx *= -1;
                    if (node.y < 40 || node.y > canvas.height - 40) node.dy *= -1;
                });

                for (let i = 0; i < nodes.length; i += 1) {
                    for (let j = i + 1; j < nodes.length; j += 1) {
                        const a = nodes[i];
                        const b = nodes[j];
                        const distance = Math.hypot(a.x - b.x, a.y - b.y);
                        if (distance > 160) continue;

                        ctx.strokeStyle = `rgba(115, 182, 85, ${0.15 - distance / 1400})`;
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(a.x, a.y);
                        ctx.lineTo(b.x, b.y);
                        ctx.stroke();
                    }
                }

                nodes.forEach((node) => {
                    const pointerDistance = Math.hypot(node.x - pointer.x, node.y - pointer.y);
                    const radius = pointerDistance < 110 ? 4 : 2.5;
                    ctx.beginPath();
                    ctx.fillStyle = pointerDistance < 110 ? 'rgba(115, 182, 85, 0.9)' : 'rgba(197, 240, 183, 0.55)';
                    ctx.arc(node.x, node.y, radius, 0, Math.PI * 2);
                    ctx.fill();
                });

                animationFrame = requestAnimationFrame(draw);
            };

            resize();

            const io = new IntersectionObserver((entries) => {
                const entry = entries[0];
                const shouldRun = Boolean(entry?.isIntersecting) && !document.hidden;
                if (shouldRun && !running) {
                    running = true;
                    draw();
                } else if (!shouldRun && running) {
                    running = false;
                    cancelAnimationFrame(animationFrame);
                }
            }, { threshold: 0.12 });

            io.observe(canvas);

            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    running = false;
                    cancelAnimationFrame(animationFrame);
                }
            });

            canvas.parentElement?.addEventListener('mousemove', (event) => {
                const rect = canvas.getBoundingClientRect();
                pointer.x = event.clientX - rect.left;
                pointer.y = event.clientY - rect.top;
            }, { passive: true });

            window.addEventListener('resize', resize, { passive: true });
            window.addEventListener('beforeunload', () => cancelAnimationFrame(animationFrame), { once: true });
        }
    }
});
