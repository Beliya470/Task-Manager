<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f0f2f8;
            color: #333;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(135deg, #1a365d 0%, #2c7a7b 100%);
            padding: 20px 32px 22px;
            box-shadow: 0 2px 12px rgba(26, 54, 93, 0.35);
        }

        header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.01em;
        }

        header p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.7);
            margin-top: 3px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 28px 32px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.05);
        }

        .card-title {
            font-size: 0.875rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 16px;
        }

        .form-row {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-group label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        input, select {
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.9rem;
            outline: none;
            background: #fafafa;
            transition: border-color 0.15s, box-shadow 0.15s;
            color: #1f2937;
        }

        input:focus, select:focus {
            border-color: #2c7a7b;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(44, 122, 123, 0.12);
        }

        .form-group input[type="text"] { width: 280px; }

        button {
            padding: 9px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            transition: filter 0.15s, transform 0.1s;
        }

        button:hover { filter: brightness(1.07); }
        button:active { transform: scale(0.98); }
        button:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-primary {
            background: linear-gradient(135deg, #1a365d, #2c7a7b);
            color: #fff;
            box-shadow: 0 2px 8px rgba(26, 54, 93, 0.3);
        }

        .btn-sm { padding: 5px 12px; font-size: 0.78rem; border-radius: 6px; }
        .btn-advance {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
        }
        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
        }

        /* filters bar */
        .filters {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .filters label {
            font-size: 0.82rem;
            font-weight: 600;
            color: #6b7280;
        }

        .filter-divider {
            width: 1px;
            height: 24px;
            background: #e5e7eb;
            margin: 0 2px;
        }

        .btn-clear {
            background: none;
            border: 1.5px solid #e5e7eb;
            color: #6b7280;
            font-size: 0.78rem;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .btn-clear:hover {
            border-color: #d1d5db;
            background: #f9fafb;
            filter: none;
        }

        .result-count {
            font-size: 0.78rem;
            color: #9ca3af;
            background: #f3f4f6;
            padding: 3px 10px;
            border-radius: 20px;
        }

        /* table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        th {
            text-align: left;
            padding: 10px 14px;
            border-bottom: 2px solid #f3f4f6;
            color: #9ca3af;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        td {
            padding: 13px 14px;
            border-bottom: 1px solid #f9fafb;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }

        tbody tr {
            transition: background 0.1s;
        }

        tbody tr:hover td {
            background: #f0f7f7;
        }

        .task-title {
            font-weight: 500;
            color: #111827;
        }

        .due-date {
            color: #6b7280;
            font-size: 0.85rem;
            font-variant-numeric: tabular-nums;
        }

        /* badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.73rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            text-transform: capitalize;
        }

        .priority-high {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }
        .priority-high::before { content: '●'; font-size: 0.6rem; color: #ef4444; }

        .priority-medium {
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }
        .priority-medium::before { content: '●'; font-size: 0.6rem; color: #f97316; }

        .priority-low {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .priority-low::before { content: '●'; font-size: 0.6rem; color: #22c55e; }

        .status-pending {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }
        .status-in_progress {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }
        .status-done {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .actions { display: flex; gap: 6px; }

        /* alerts */
        .alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .alert-success::before { content: '✓'; font-weight: 700; }

        .alert-error {
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
        }
        .alert-error::before { content: '!'; font-weight: 700; }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #d1d5db;
            font-size: 0.9rem;
        }

        .empty-state::before {
            display: block;
            content: '📋';
            font-size: 2rem;
            margin-bottom: 10px;
        }

        /* pagination */
        .table-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 16px;
            margin-top: 4px;
            border-top: 1px solid #f3f4f6;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-btn {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 7px;
            border: 1.5px solid #e5e7eb;
            background: #fff;
            color: #374151;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.1s;
        }

        .page-btn:hover:not(:disabled) {
            border-color: #2c7a7b;
            color: #2c7a7b;
            filter: none;
        }

        .page-btn.active {
            background: linear-gradient(135deg, #1a365d, #2c7a7b);
            border-color: transparent;
            color: #fff;
            font-weight: 700;
        }

        .page-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .per-page {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.82rem;
            color: #6b7280;
        }

        .per-page select {
            padding: 5px 8px;
            font-size: 0.82rem;
            width: auto;
        }

        .page-info {
            font-size: 0.82rem;
            color: #9ca3af;
        }

        @media (max-width: 700px) {
            .container { padding: 16px; }
            .form-group input[type="text"] { width: 100%; }
            .form-row { flex-direction: column; }
            header { padding: 16px 20px; }
            .table-footer { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <header>
        <h1>Task Manager</h1>
        <p>Track your work, stay on top of priorities</p>
    </header>

    @verbatim
    <div id="app" class="container">

        <div v-if="alert.message" :class="['alert', alert.type === 'success' ? 'alert-success' : 'alert-error']">
            {{ alert.message }}
        </div>

        <div class="card">
            <div class="card-title">New Task</div>
            <div class="form-row">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" v-model="form.title" placeholder="What needs to be done?" />
                </div>
                <div class="form-group">
                    <label>Due Date</label>
                    <input type="date" v-model="form.due_date" />
                </div>
                <div class="form-group">
                    <label>Priority</label>
                    <select v-model="form.priority">
                        <option value="">Select...</option>
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
                <button class="btn-primary" @click="createTask" :disabled="submitting">
                    {{ submitting ? 'Creating...' : '+ Add Task' }}
                </button>
            </div>
        </div>

        <div class="card">
            <div class="filters">
                <input type="text" v-model="search" placeholder="🔍  Search tasks..." style="width:200px;" />

                <div class="filter-divider"></div>

                <label>Status:</label>
                <select v-model="filterStatus" @change="loadTasks">
                    <option value="">All</option>
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="done">Done</option>
                </select>

                <label>Priority:</label>
                <select v-model="filterPriority">
                    <option value="">All</option>
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>

                <div class="filter-divider"></div>

                <label>From:</label>
                <input type="date" v-model="dateFrom" style="width:145px;" />
                <label>To:</label>
                <input type="date" v-model="dateTo" style="width:145px;" />

                <button v-if="search || dateFrom || dateTo || filterPriority" class="btn-clear" @click="clearFilters">
                    ✕ Clear
                </button>

                <span v-if="hasActiveFilter" class="result-count">
                    {{ filteredTasks.length }} result{{ filteredTasks.length !== 1 ? 's' : '' }}
                </span>
            </div>

            <div v-if="loading" class="empty-state">Loading tasks...</div>

            <div v-else-if="filteredTasks.length === 0" class="empty-state">No tasks found.</div>

            <template v-else>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in pagedTasks" :key="task.id">
                            <td class="task-title">{{ task.title }}</td>
                            <td class="due-date">{{ task.due_date ? task.due_date.split('T')[0] : '—' }}</td>
                            <td>
                                <span :class="['badge', 'priority-' + task.priority]">{{ task.priority }}</span>
                            </td>
                            <td>
                                <span :class="['badge', 'status-' + task.status]">{{ task.status.replace('_', ' ') }}</span>
                            </td>
                            <td>
                                <div class="actions">
                                    <button
                                        v-if="task.status !== 'done'"
                                        class="btn-sm btn-advance"
                                        @click="advanceStatus(task)"
                                    >
                                        {{ task.status === 'pending' ? '▶ Start' : '✓ Complete' }}
                                    </button>
                                    <button
                                        v-if="task.status === 'done'"
                                        class="btn-sm btn-delete"
                                        @click="deleteTask(task)"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-footer">
                    <div class="per-page">
                        Show
                        <select v-model="perPage" @change="currentPage = 1">
                            <option :value="10">10</option>
                            <option :value="25">25</option>
                            <option :value="50">50</option>
                            <option :value="100">100</option>
                        </select>
                        per page
                    </div>

                    <div class="page-info">
                        {{ (currentPage - 1) * perPage + 1 }}–{{ Math.min(currentPage * perPage, filteredTasks.length) }}
                        of {{ filteredTasks.length }}
                    </div>

                    <div class="pagination">
                        <button class="page-btn" @click="currentPage = 1" :disabled="currentPage === 1">«</button>
                        <button class="page-btn" @click="currentPage--" :disabled="currentPage === 1">‹</button>

                        <button
                            v-for="p in visiblePages"
                            :key="p"
                            :class="['page-btn', { active: p === currentPage }]"
                            @click="currentPage = p"
                        >{{ p }}</button>

                        <button class="page-btn" @click="currentPage++" :disabled="currentPage === totalPages">›</button>
                        <button class="page-btn" @click="currentPage = totalPages" :disabled="currentPage === totalPages">»</button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    tasks: [],
                    loading: true,
                    submitting: false,
                    filterStatus: '',
                    filterPriority: '',
                    search: '',
                    dateFrom: '',
                    dateTo: '',
                    currentPage: 1,
                    perPage: 10,
                    alert: { message: '', type: '' },
                    form: {
                        title: '',
                        due_date: '',
                        priority: '',
                    },
                };
            },

            computed: {
                hasActiveFilter() {
                    return this.search.trim() || this.dateFrom || this.dateTo || this.filterPriority;
                },

                filteredTasks() {
                    return this.tasks.filter(t => {
                        const date = t.due_date ? t.due_date.split('T')[0] : '';

                        if (this.search.trim() && !t.title.toLowerCase().includes(this.search.toLowerCase()))
                            return false;
                        if (this.filterPriority && t.priority !== this.filterPriority)
                            return false;
                        if (this.dateFrom && date < this.dateFrom)
                            return false;
                        if (this.dateTo && date > this.dateTo)
                            return false;

                        return true;
                    });
                },

                totalPages() {
                    return Math.max(1, Math.ceil(this.filteredTasks.length / this.perPage));
                },

                pagedTasks() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.filteredTasks.slice(start, start + this.perPage);
                },

                visiblePages() {
                    const range = [];
                    const delta = 2;
                    const left = Math.max(1, this.currentPage - delta);
                    const right = Math.min(this.totalPages, this.currentPage + delta);
                    for (let i = left; i <= right; i++) range.push(i);
                    return range;
                },
            },

            mounted() {
                this.loadTasks();
            },

            methods: {
                async loadTasks() {
                    this.loading = true;
                    this.currentPage = 1;
                    try {
                        const params = this.filterStatus ? { status: this.filterStatus } : {};
                        const res = await axios.get('/api/tasks', { params });
                        this.tasks = res.data.tasks || [];
                    } catch (e) {
                        this.showAlert('Failed to load tasks', 'error');
                    } finally {
                        this.loading = false;
                    }
                },

                async createTask() {
                    if (!this.form.title || !this.form.due_date || !this.form.priority) {
                        this.showAlert('Please fill in all fields', 'error');
                        return;
                    }
                    this.submitting = true;
                    try {
                        await axios.post('/api/tasks', this.form);
                        this.form = { title: '', due_date: '', priority: '' };
                        this.showAlert('Task created', 'success');
                        this.loadTasks();
                    } catch (e) {
                        const msg = e.response?.data?.message || Object.values(e.response?.data?.errors || {})[0]?.[0] || 'Failed to create task';
                        this.showAlert(msg, 'error');
                    } finally {
                        this.submitting = false;
                    }
                },

                async advanceStatus(task) {
                    const next = task.status === 'pending' ? 'in_progress' : 'done';
                    try {
                        await axios.patch(`/api/tasks/${task.id}/status`, { status: next });
                        this.showAlert(`Task moved to ${next.replace('_', ' ')}`, 'success');
                        this.loadTasks();
                    } catch (e) {
                        this.showAlert(e.response?.data?.message || 'Update failed', 'error');
                    }
                },

                async deleteTask(task) {
                    if (!confirm('Delete this task?')) return;
                    try {
                        await axios.delete(`/api/tasks/${task.id}`);
                        this.showAlert('Task deleted', 'success');
                        this.loadTasks();
                    } catch (e) {
                        this.showAlert(e.response?.data?.message || 'Delete failed', 'error');
                    }
                },

                clearFilters() {
                    this.search = '';
                    this.filterPriority = '';
                    this.dateFrom = '';
                    this.dateTo = '';
                    this.currentPage = 1;
                },

                showAlert(message, type) {
                    this.alert = { message, type };
                    setTimeout(() => { this.alert = { message: '', type: '' }; }, 3500);
                },
            },
        }).mount('#app');
    </script>
    @endverbatim
</body>
</html>
