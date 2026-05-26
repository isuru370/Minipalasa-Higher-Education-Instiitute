<aside class="sidebar" id="sidebar">

    <!-- SIDEBAR HEADER -->
    <div class="sidebar-header">

        <a href="{{ route('admin.dashboard') }}" class="brand text-decoration-none">

            <div class="brand-icon">
                N
            </div>

            <div class="brand-text">

                <h4>Nexora</h4>

                <small>
                    Education System
                </small>

            </div>

        </a>

    </div>

    <!-- SIDEBAR BODY -->
    <div class="sidebar-body">

        <!-- MAIN SECTION -->
        <div class="sidebar-section">

            <div class="sidebar-section-title">
                MAIN MENU
            </div>

            @if(hasPermission('dashboard'))

                <div class="nav-item">

                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

                        <i class="bi bi-speedometer2"></i>

                        <span>Dashboard</span>

                    </a>

                </div>

            @endif

        </div>

        <!-- MANAGEMENT -->
        <div class="sidebar-section">

            <div class="sidebar-section-title">
                MANAGEMENT
            </div>

            @if(hasPermission('system-users.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.system-users.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.system-users*') ? 'active' : '' }}">

                        <i class="bi bi-people-fill"></i>

                        <span>System User</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('students.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.students.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">

                        <i class="bi bi-people-fill"></i>

                        <span>Students</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('teachers.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.teachers.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">

                        <i class="bi bi-person-badge-fill"></i>

                        <span>Teachers</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('organizers.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.organizers.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.organizers.*') ? 'active' : '' }}">

                        <i class="bi bi-calendar-check-fill"></i>

                        <span>Organizers</span>

                    </a>

                </div>

            @endif

        </div>

        <!-- ACADEMIC -->
        <div class="sidebar-section">

            <div class="sidebar-section-title">
                ACADEMIC
            </div>

            @if(hasPermission('student-classes.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.student-classes.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.student-classes.*') ? 'active' : '' }}">

                        <i class="bi bi-book-fill"></i>

                        <span>Classes</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('class-schedules.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.class-schedules.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.class-schedules.*') ? 'active' : '' }}">

                        <i class="bi bi-book-fill"></i>

                        <span>Class Schedule</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('student-class-enrollments.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.student-class-enrollments.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.student-class-enrollments.*') ? 'active' : '' }}">

                        <i class="bi bi-pencil-square"></i>

                        <span>Enrollments</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('attendance.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.class-schedules.todayClasses') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.class-schedules.todayClasses') ? 'active' : '' }}">

                        <i class="bi bi-calendar2-check-fill"></i>

                        <span>Attendance</span>

                    </a>

                </div>

            @endif

        </div>

        <!-- FINANCE -->
        <div class="sidebar-section">

            <div class="sidebar-section-title">
                FINANCE
            </div>

            @if(hasPermission('payments.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.admissions.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.admissions.*') ? 'active' : '' }}">

                        <i class="bi bi-credit-card-fill"></i>

                        <span>Admissions</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('payments.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.admission-payments.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.admission-payments.*') ? 'active' : '' }}">

                        <i class="bi bi-credit-card-fill"></i>

                        <span>Admissions Payments</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('payments.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.payments.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">

                        <i class="bi bi-credit-card-fill"></i>

                        <span>Payments</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('teacher-salaries.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.teacher-salaries.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.teacher-salaries.*') ? 'active' : '' }}">

                        <i class="bi bi-cash-stack"></i>

                        <span>Teacher Salaries</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('organizer-payments.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.organizer-payments.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.organizer-payments.index') ? 'active' : '' }}">

                        <i class="bi bi-wallet2"></i>

                        <span>Organizer Payments</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('extra-incomes.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.extra-incomes.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.extra-incomes.*') ? 'active' : '' }}">

                        <i class="bi bi-cash-coin"></i>

                        <span>Extra Incomes</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('institute-expenses.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.institute-expenses.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.institute-expenses.*') ? 'active' : '' }}">

                        <i class="bi bi-cash-coin"></i>

                        <span>Institute Expenses</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('institute-income.monthly-report'))

                <div class="nav-item">

                    <a href="{{ route('admin.institute-income.monthly-report') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.institute-income.monthly-report') ? 'active' : '' }}">

                        <i class="bi bi-bar-chart-line-fill"></i>

                        <span>Income Reports</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('admin.temporary-id-cards.index'))

                <div class="nav-item">
                    <a href="{{ route('admin.temporary-id-cards.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.temporary-id-cards.*') ? 'active' : '' }}">
                        <i class="bi bi-book-fill"></i>
                        <span>Temporary ID</span>
                    </a>
                </div>

            @endif

        </div>

        <!-- Report SECTION -->
        <div class="sidebar-section">

            <div class="sidebar-section-title">
                REPORTS
            </div>

            @if(hasPermission('daily-report.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.daily-report.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.daily-report.*') ? 'active' : '' }}">

                        <i class="bi bi-file-earmark-bar-graph"></i>

                        <span>Daily Report</span>

                    </a>

                </div>

            @endif
            @if(hasPermission('monthly-report.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.monthly-report.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.monthly-report.*') ? 'active' : '' }}">

                        <i class="bi bi-file-earmark-bar-graph"></i>

                        <span>Monthly Report</span>

                    </a>

                </div>

            @endif

            @if(hasPermission('teacher-report.index'))

                <div class="nav-item">

                    <a href="{{ route('admin.teacher-report.index') }}"
                        class="nav-link-custom {{ request()->routeIs('admin.teacher-report.*') ? 'active' : '' }}">

                        <i class="bi bi-file-earmark-bar-graph"></i>

                        <span>Teacher Report</span>

                    </a>

                </div>

            @endif

        </div>

    </div>

</aside>

<style>
    /* SIDEBAR */

    .sidebar {

        width: 280px;

        background:
            linear-gradient(180deg,
                #0f172a 0%,
                #111827 50%,
                #1e293b 100%);

        position: fixed;

        top: 0;
        left: 0;
        bottom: 0;

        z-index: 1030;

        display: flex;
        flex-direction: column;

        border-right:
            1px solid rgba(255, 255, 255, 0.05);

        box-shadow:
            6px 0 25px rgba(0, 0, 0, 0.25);
    }

    /* HEADER */

    .sidebar-header {

        padding: 1.5rem 1.25rem;

        border-bottom:
            1px solid rgba(255, 255, 255, 0.08);

        flex-shrink: 0;
    }

    /* BODY */

    .sidebar-body {

        flex: 1;

        overflow-y: auto;

        padding: 1rem;

        scrollbar-width: thin;
    }

    /* SCROLLBAR */

    .sidebar-body::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-body::-webkit-scrollbar-thumb {

        background:
            rgba(255, 255, 255, 0.15);

        border-radius: 20px;
    }

    /* BRAND */

    .brand {

        display: flex;
        align-items: center;
        gap: 14px;
    }

    .brand-icon {

        width: 48px;
        height: 48px;

        border-radius: 14px;

        background:
            linear-gradient(135deg,
                #3b82f6,
                #2563eb);

        display: flex;
        align-items: center;
        justify-content: center;

        color: white;

        font-size: 1.4rem;
        font-weight: 800;

        box-shadow:
            0 10px 20px rgba(37, 99, 235, 0.35);
    }

    .brand-text h4 {

        margin: 0;

        color: white;

        font-size: 1.2rem;
        font-weight: 700;
    }

    .brand-text small {

        color: #94a3b8;

        font-size: 0.75rem;
    }

    /* SECTIONS */

    .sidebar-section {
        margin-bottom: 1.8rem;
    }

    .sidebar-section-title {

        color: #64748b;

        font-size: 0.72rem;

        font-weight: 700;

        letter-spacing: 1px;

        margin-bottom: 0.8rem;

        padding-left: 0.8rem;
    }

    /* NAV ITEMS */

    .nav-item {
        margin-bottom: 0.35rem;
    }

    .nav-link-custom {

        display: flex;
        align-items: center;
        gap: 14px;

        padding: 0.9rem 1rem;

        border-radius: 14px;

        color: #cbd5e1;

        text-decoration: none;

        font-size: 0.95rem;
        font-weight: 500;

        transition: all 0.25s ease;
    }

    .nav-link-custom i {

        font-size: 1.15rem;

        width: 22px;
    }

    .nav-link-custom:hover {

        background:
            rgba(255, 255, 255, 0.08);

        color: white;

        transform: translateX(5px);
    }

    .nav-link-custom.active {

        background:
            linear-gradient(135deg,
                #2563eb,
                #1d4ed8);

        color: white;

        box-shadow:
            0 10px 18px rgba(37, 99, 235, 0.30);
    }

    /* MOBILE */

    @media(max-width: 991px) {

        .sidebar {
            transform: translateX(-100%);
            transition: 0.3s ease;
        }

        .sidebar.show {
            transform: translateX(0);
        }
    }
</style>