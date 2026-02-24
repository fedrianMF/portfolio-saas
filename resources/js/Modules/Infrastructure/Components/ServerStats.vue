<script setup>
import { computed } from 'vue'

const props = defineProps({
    data: {
        type: Object,
        required: true
    }
})

// ── Helpers ──────────────────────────────────────────────
const toGB = (bytes) => (Number(bytes) / 1073741824).toFixed(1)

// ── Server ───────────────────────────────────────────────
const server = computed(() => ({
    label: 'Server',
    icon: '🖥',
    main: props.data.model ?? '—',
    sub: props.data.os ?? '—',
    detail: [
        { label: 'Hostname', value: props.data.hostname },
        { label: 'Kernel', value: props.data.kernel },
        { label: 'Architecture', value: props.data.architecture },
        { label: 'IP Address', value: props.data.SERVER_ADDR },
        { label: 'Web Server', value: props.data.SERVER_SOFTWARE },
        {
            label: 'Boot time', value: props.data.uptime?.bootedTimestamp
                ? new Date(props.data.uptime.bootedTimestamp * 1000).toLocaleString()
                : '—'
        },
    ]
}))

// ── Uptime ───────────────────────────────────────────────
const uptime = computed(() => ({
    label: 'Uptime',
    icon: '⏱',
    main: props.data.uptime?.text ?? '—',
    sub: null,
    detail: null
}))

// ── CPU ──────────────────────────────────────────────────
const cpu = computed(() => {
    const cores = props.data.cpu ?? []
    return {
        label: 'CPU',
        icon: '🧠',
        main: cores[0]?.Model ?? '—',
        sub: `${cores.length} cores`,
        detail: cores.map((c, i) => ({ label: `Core ${i + 1}`, value: c.Model }))
    }
})

// ── Load ─────────────────────────────────────────────────
const load = computed(() => {
    const l = props.data.cpu_load
    return {
        label: 'Load',
        icon: '📊',
        main: l ? `${l.now} / ${l['5min']} / ${l['15min']}` : '—',
        sub: '1 min / 5 min / 15 min',
        detail: l ? [
            { label: '1 min', value: l.now },
            { label: '5 min', value: l['5min'] },
            { label: '15 min', value: l['15min'] },
        ] : null
    }
})

// ── RAM ──────────────────────────────────────────────────
const ram = computed(() => {
    const r = props.data.ram
    if (!r) return { label: 'RAM', icon: '💾', main: '—', sub: null, detail: null }
    const used = (Number(r.total) - Number(r.free))
    return {
        label: 'RAM',
        icon: '💾',
        main: `${toGB(r.total)} GB`,
        sub: `${toGB(used)} GB used`,
        usedPercent: Math.round((used / Number(r.total)) * 100),
        detail: [
            { label: 'Total', value: `${toGB(r.total)} GB` },
            { label: 'Used', value: `${toGB(used)} GB` },
            { label: 'Free', value: `${toGB(r.free)} GB` },
            { label: 'Swap Total', value: `${toGB(r.swapTotal)} GB` },
            { label: 'Swap Free', value: `${toGB(r.swapFree)} GB` },
            { label: 'Swap Used', value: `${toGB(r.swapTotal - r.swapFree)} GB` },
        ]
    }
})

// ── Disk ─────────────────────────────────────────────────
const disk = computed(() => {
    const mounts = props.data.mounts ?? []
    const root = mounts.find(m => m.mount === '/')
    if (!root) return { label: 'Disk', icon: '💿', main: '—', sub: null, detail: null }

    const relevantMounts = mounts.filter(m => !m.mount.startsWith('/System/Volumes'))

    return {
        label: 'Disk',
        icon: '💿',
        main: `${toGB(root.size)} GB`,
        sub: `${root.used_percent}% used · ${toGB(root.free)} GB free`,
        usedPercent: root.used_percent,
        detail: relevantMounts.map(m => ({
            label: m.mount,
            value: m.size > 0
                ? `${toGB(m.used)} / ${toGB(m.size)} GB (${m.used_percent}%)`
                : '—'
        }))
    }
})

// ── Network ──────────────────────────────────────────────
const network = computed(() => {
    const net = props.data.network ?? {}

    // Find active interface (state up with traffic)
    const activeEntry = Object.entries(net).find(([, iface]) =>
        iface.state === 'up' && parseInt(iface.recieved.bytes) > 0
    )

    const activeInterfaces = Object.entries(net).filter(([, iface]) =>
        iface.state === 'up' || parseInt(iface.recieved.bytes) > 0
    )

    if (!activeEntry) return { label: 'Network', icon: '🌐', main: '—', sub: null, detail: null }

    const [name, iface] = activeEntry
    return {
        label: 'Network',
        icon: '🌐',
        main: `↓ ${toGB(iface.recieved.bytes)} GB · ↑ ${toGB(iface.sent.bytes)} GB`,
        sub: `via ${name}`,
        detail: activeInterfaces.map(([key, i]) => ({
            label: key,
            value: `↓ ${toGB(i.recieved.bytes)} GB · ↑ ${toGB(i.sent.bytes)} GB`
        }))
    }
})

// ── PHP ──────────────────────────────────────────────────
const php = computed(() => ({
    label: 'PHP',
    icon: '⚙️',
    main: `PHP ${props.data.php_version ?? '—'}`,
    sub: null,
    detail: null
}))

const cards = computed(() => [
    server.value,
    uptime.value,
    cpu.value,
    load.value,
    ram.value,
    disk.value,
    network.value,
    php.value,
])

// ── Expanded state ────────────────────────────────────────
import { ref } from 'vue'
const expanded = ref(null)

const toggle = (label) => {
    expanded.value = expanded.value === label ? null : label
}
</script>

<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div v-for="card in cards" :key="card.label" class="stat-card" :class="{
            'is-expanded': expanded === card.label,
            'is-clickable': card.detail?.length
        }" @click="card.detail?.length ? toggle(card.label) : null">
            <!-- Header row -->
            <div class="card-header">
                <span class="card-icon">{{ card.icon }}</span>
                <span class="card-label">{{ card.label }}</span>
                <span v-if="card.detail?.length" class="card-chevron">
                    {{ expanded === card.label ? '▲' : '▼' }}
                </span>
            </div>

            <!-- Main value -->
            <div class="card-main">{{ card.main }}</div>

            <!-- Sub value -->
            <div v-if="card.sub" class="card-sub">{{ card.sub }}</div>

            <!-- Progress bar for RAM / Disk -->
            <div v-if="card.usedPercent !== undefined" class="card-bar">
                <div class="card-bar-fill" :class="{
                    'bar-warn': card.usedPercent >= 70 && card.usedPercent < 90,
                    'bar-danger': card.usedPercent >= 90
                }" :style="{ width: card.usedPercent + '%' }" />
            </div>

            <!-- Expanded detail -->
            <Transition name="expand">
                <div v-if="expanded === card.label && card.detail?.length" class="card-detail">
                    <div v-for="item in card.detail" :key="item.label" class="detail-row">
                        <span class="detail-label">{{ item.label }}</span>
                        <span class="detail-value">{{ item.value }}</span>
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>

<style scoped>
@keyframes pulse {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0.4;
    }
}

/* Card */
.stat-card {
    background: #0f172a;
    border: 1px solid #1e293b;
    border-radius: 8px;
    padding: 14px 16px;
    transition: border-color 0.2s, background 0.2s;
}

.stat-card.is-clickable {
    cursor: pointer;
}

.stat-card.is-clickable:hover {
    border-color: #fbbf24;
    background: #111827;
}

.stat-card.is-expanded {
    border-color: #fbbf24;
    grid-column: span 2;
}

/* Card inner */
.card-header {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 8px;
}

.card-icon {
    font-size: 13px;
}

.card-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #64748b;
    flex: 1;
}

.card-chevron {
    font-size: 9px;
    color: #fbbf24;
}

.card-main {
    font-size: 13px;
    font-weight: 600;
    color: #f1f5f9;
    line-height: 1.4;
    word-break: break-word;
}

.card-sub {
    font-size: 11px;
    color: #64748b;
    margin-top: 3px;
}

/* Progress bar */
.card-bar {
    margin-top: 8px;
    height: 3px;
    background: #1e293b;
    border-radius: 2px;
    overflow: hidden;
}

.card-bar-fill {
    height: 100%;
    background: #fbbf24;
    border-radius: 2px;
    transition: width 0.4s ease;
}

.card-bar-fill.bar-warn {
    background: #fb923c;
}

.card-bar-fill.bar-danger {
    background: #ef4444;
}

/* Detail rows */
.card-detail {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid #1e293b;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    gap: 8px;
}

.detail-label {
    font-size: 10px;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    white-space: nowrap;
}

.detail-value {
    font-size: 11px;
    color: #94a3b8;
    text-align: right;
    word-break: break-word;
}

/* Expand animation */
.expand-enter-active,
.expand-leave-active {
    transition: opacity 0.2s ease, transform 0.2s ease;
}

.expand-enter-from,
.expand-leave-to {
    opacity: 0;
    transform: translateY(-4px);
}
</style>
