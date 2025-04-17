<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TB Care Connect | Your Health Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #3b82f6;
            --primary-light: #dbeafe;
            --primary-dark: #2563eb;
            --success: #22c55e;
            --success-light: #dcfce7;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --radius-sm: 0.25rem;
            --radius-md: 0.375rem;
            --radius-lg: 0.5rem;
            --radius-xl: 0.75rem;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --font-size-base: 16px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            font-size: var(--font-size-base);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--gray-800);
            background-color: var(--gray-50);
            line-height: 1.5;
        }
        
        .container-fluid {
            width: 100%;
            padding-left: 1rem;
            padding-right: 1rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        @media (min-width: 768px) {
            .container-fluid {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
        
        .card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-100);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: var(--gray-50);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-footer {
            padding: 1rem 1.5rem;
            background-color: var(--gray-50);
            border-top: 1px solid var(--gray-100);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: var(--radius-md);
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-outline {
            background-color: white;
            color: var(--gray-700);
            border: 2px solid var(--gray-200);
        }
        
        .btn-outline:hover {
            background-color: var(--gray-50);
            border-color: var(--gray-300);
        }
        
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background-color: #16a34a;
        }
        
        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
        
        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1.125rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            line-height: 1.5;
            color: var(--gray-700);
            background-color: white;
            border: 2px solid var(--gray-300);
            border-radius: var(--radius-md);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            color: var(--gray-700);
        }
        
        .form-check {
            display: flex;
            align-items: center;
            padding: 0.875rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            transition: all 0.15s ease;
            cursor: pointer;
            margin-bottom: 0.75rem;
        }
        
        .form-check:hover {
            background-color: var(--gray-50);
            border-color: var(--gray-300);
        }
        
        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.75rem;
            border: 2px solid var(--gray-400);
            border-radius: 0.25rem;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .form-radio-card {
            position: relative;
        }
        
        .form-radio-card input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .form-radio-card label {
            display: flex;
            align-items: center;
            padding: 1.25rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: all 0.15s ease;
        }
        
        .form-radio-card input[type="radio"]:checked + label {
            border-color: var(--primary);
            background-color: var(--primary-light);
        }
        
        .form-radio-card input[type="radio"]:focus + label {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }
        
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.875rem;
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1;
            border-radius: 9999px;
        }
        
        .badge-success {
            background-color: var(--success-light);
            color: var(--success);
        }
        
        .badge-warning {
            background-color: var(--warning-light);
            color: var(--warning);
        }
        
        .badge-danger {
            background-color: var(--danger-light);
            color: var(--danger);
        }
        
        .badge-primary {
            background-color: var(--primary-light);
            color: var(--primary);
        }
        
        .badge-gray {
            background-color: var(--gray-100);
            color: var(--gray-600);
        }
        
        .alert {
            padding: 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            font-size: 1rem;
            border-left: 4px solid transparent;
        }
        
        .alert-success {
            background-color: var(--success-light);
            border-left-color: var(--success);
            color: #166534;
        }
        
        .alert-warning {
            background-color: var(--warning-light);
            border-left-color: var(--warning);
            color: #854d0e;
        }
        
        .alert-danger {
            background-color: var(--danger-light);
            border-left-color: var(--danger);
            color: #b91c1c;
        }
        
        .alert-primary {
            background-color: var(--primary-light);
            border-left-color: var(--primary);
            color: #1e40af;
        }
        
        .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 9999px;
            flex-shrink: 0;
        }
        
        .icon-circle-sm {
            width: 2.5rem;
            height: 2.5rem;
        }
        
        .icon-circle-lg {
            width: 3.5rem;
            height: 3.5rem;
        }
        
        .progress-bar {
            height: 0.75rem;
            border-radius: 9999px;
            background-color: var(--gray-100);
            overflow: hidden;
        }
        
        .progress-bar-fill {
            height: 100%;
            border-radius: 9999px;
        }
        
        .progress-bar-fill-primary {
            background-color: var(--primary);
        }
        
        .progress-bar-fill-success {
            background-color: var(--success);
        }
        
        /* Calendar Styles */
        .calendar {
            width: 100%;
        }
        
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }
        
        .calendar-weekday {
            text-align: center;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-500);
            padding: 0.5rem 0;
        }
        
        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-md);
            font-size: 1rem;
            position: relative;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid var(--gray-200);
        }
        
        .calendar-day:hover {
            background-color: var(--gray-100);
            transform: scale(1.05);
        }
        
        .calendar-day-number {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .calendar-day-indicator {
            width: 0.75rem;
            height: 0.75rem;
            border-radius: 50%;
        }
        
        .calendar-day-indicator.success {
            background-color: var(--success);
        }
        
        .calendar-day-indicator.warning {
            background-color: var(--warning);
        }
        
        .calendar-day-indicator.danger {
            background-color: var(--danger);
        }
        
        .calendar-day-indicator.primary {
            background-color: var(--primary);
        }
        
        .calendar-day.today {
            border: 3px solid var(--primary);
            background-color: var(--primary-light);
            font-weight: 700;
        }
        
        .calendar-day.other-month {
            color: var(--gray-400);
            background-color: var(--gray-50);
        }
        
        .calendar-legend {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        
        .calendar-legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--gray-700);
        }
        
        .calendar-legend-indicator {
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
        }
        
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }
        
        /* Pill selector */
        .pill-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        
        .pill-selector label {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            background-color: var(--gray-100);
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.15s ease;
        }
        
        .pill-selector label:hover {
            background-color: var(--gray-200);
        }
        
        .pill-selector label.active {
            background-color: var(--primary);
            color: white;
        }
        
        /* Header and navigation */
        .header {
            background-color: white;
            border-bottom: 1px solid var(--gray-100);
            position: sticky;
            top: 0;
            z-index: 30;
            box-shadow: var(--shadow-sm);
        }
        
        .nav-link {
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-weight: 500;
            color: var(--gray-600);
            text-decoration: none;
            transition: all 0.15s ease;
        }
        
        .nav-link:hover {
            color: var(--gray-900);
            background-color: var(--gray-50);
        }
        
        .nav-link.active {
            color: var(--primary);
            background-color: var(--primary-light);
            font-weight: 600;
        }
        
        /* Chart styles */
        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }
        
        .chart-tabs {
            display: flex;
            border-bottom: 1px solid var(--gray-200);
            margin-bottom: 1.5rem;
            overflow-x: auto;
        }
        
        .chart-tab {
            padding: 0.75rem 1.25rem;
            font-size: 1rem;
            font-weight: 500;
            color: var(--gray-600);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.15s ease;
            white-space: nowrap;
        }
        
        .chart-tab:hover {
            color: var(--gray-900);
        }
        
        .chart-tab.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
            font-weight: 600;
        }
        
        /* Help tooltip */
        .help-tooltip {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            background-color: var(--gray-200);
            color: var(--gray-600);
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
            cursor: help;
        }
        
        .help-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 0.5rem 0.75rem;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 400;
            white-space: nowrap;
            z-index: 10;
            margin-bottom: 0.5rem;
            width: max-content;
            max-width: 300px;
        }
        
        .help-tooltip:hover::before {
            content: '';
            position: absolute;
            bottom: calc(100% - 0.25rem);
            left: 50%;
            transform: translateX(-50%);
            border-width: 0.25rem;
            border-style: solid;
            border-color: rgba(0, 0, 0, 0.8) transparent transparent transparent;
            z-index: 10;
        }
        
        /* Utility classes */
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .space-x-2 > * + * { margin-left: 0.5rem; }
        .space-x-3 > * + * { margin-left: 0.75rem; }
        .space-x-4 > * + * { margin-left: 1rem; }
        .space-y-2 > * + * { margin-top: 0.5rem; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .space-y-8 > * + * { margin-top: 2rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        .grid-cols-7 { grid-template-columns: repeat(7, minmax(0, 1fr)); }
        .col-span-2 { grid-column: span 2 / span 2; }
        .col-span-3 { grid-column: span 3 / span 3; }
        .w-full { width: 100%; }
        .h-full { height: 100%; }
        .min-h-screen { min-height: 100vh; }
        .p-2 { padding: 0.5rem; }
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .m-2 { margin: 0.5rem; }
        .m-3 { margin: 0.75rem; }
        .m-4 { margin: 1rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 0.75rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mt-8 { margin-top: 2rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .ml-1 { margin-left: 0.25rem; }
        .ml-2 { margin-left: 0.5rem; }
        .ml-3 { margin-left: 0.75rem; }
        .ml-4 { margin-left: 1rem; }
        .mr-1 { margin-right: 0.25rem; }
        .mr-2 { margin-right: 0.5rem; }
        .mr-3 { margin-right: 0.75rem; }
        .mr-4 { margin-right: 1rem; }
        .text-xs { font-size: 0.75rem; }
        .text-sm { font-size: 0.875rem; }
        .text-base { font-size: 1rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-primary { color: var(--primary); }
        .text-success { color: var(--success); }
        .text-warning { color: var(--warning); }
        .text-danger { color: var(--danger); }
        .text-gray-400 { color: var(--gray-400); }
        .text-gray-500 { color: var(--gray-500); }
        .text-gray-600 { color: var(--gray-600); }
        .text-gray-700 { color: var(--gray-700); }
        .text-gray-800 { color: var(--gray-800); }
        .text-gray-900 { color: var(--gray-900); }
        .bg-white { background-color: white; }
        .bg-gray-50 { background-color: var(--gray-50); }
        .bg-gray-100 { background-color: var(--gray-100); }
        .bg-primary-light { background-color: var(--primary-light); }
        .bg-success-light { background-color: var(--success-light); }
        .bg-warning-light { background-color: var(--warning-light); }
        .bg-danger-light { background-color: var(--danger-light); }
        .rounded-full { border-radius: 9999px; }
        .rounded { border-radius: var(--radius-md); }
        .rounded-lg { border-radius: var(--radius-lg); }
        .border { border: 1px solid var(--gray-200); }
        .border-t { border-top: 1px solid var(--gray-200); }
        .border-b { border-bottom: 1px solid var(--gray-200); }
        .border-l { border-left: 1px solid var(--gray-200); }
        .border-r { border-right: 1px solid var(--gray-200); }
        .shadow-sm { box-shadow: var(--shadow-sm); }
        .shadow { box-shadow: var(--shadow-md); }
        .hidden { display: none; }
        .block { display: block; }
        .inline-block { display: inline-block; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .sticky { position: sticky; }
        .top-0 { top: 0; }
        .right-0 { right: 0; }
        .bottom-0 { bottom: 0; }
        .left-0 { left: 0; }
        .z-10 { z-index: 10; }
        .z-20 { z-index: 20; }
        .z-30 { z-index: 30; }
        .overflow-hidden { overflow: hidden; }
        .overflow-auto { overflow: auto; }
        .overflow-x-auto { overflow-x: auto; }
        .overflow-y-auto { overflow: auto; }
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .whitespace-nowrap { white-space: nowrap; }
        .cursor-pointer { cursor: pointer; }
        
        /* Responsive utilities */
        @media (min-width: 640px) {
            .sm\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .sm\:flex-row { flex-direction: row; }
            .sm\:items-center { align-items: center; }
            .sm\:justify-between { justify-content: space-between; }
            .sm\:space-x-4 > * + * { margin-left: 1rem; }
            .sm\:space-y-0 > * + * { margin-top: 0; }
            .sm\:block { display: block; }
            .sm\:hidden { display: none; }
        }
        
        @media (min-width: 768px) {
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .md\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .md\:flex-row { flex-direction: row; }
            .md\:items-center { align-items: center; }
            .md\:justify-between { justify-content: space-between; }
            .md\:space-x-4 > * + * { margin-left: 1rem; }
            .md\:space-y-0 > * + * { margin-top: 0; }
            .md\:block { display: block; }
            .md\:hidden { display: none; }
            .md\:mb-0 { margin-bottom: 0; }
        }
        
        @media (min-width: 1024px) {
            .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .lg\:grid-cols-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }
            .lg\:col-span-2 { grid-column: span 2 / span 2; }
            .lg\:block { display: block; }
            .lg\:hidden { display: none; }
        }
        
        /* Accessibility improvements */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }
        
        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                background-color: white;
            }
            
            .card {
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
</head>

<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="header">
            <div class="container-fluid">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white mr-3">
                                <i class="bx bx-plus-medical text-xl"></i>
                            </div>
                            <h1 class="text-xl font-bold text-gray-900">TB Care Connect</h1>
                        </div>
                        <div class="hidden md:flex ml-10 space-x-2">
                            <a href="#" class="nav-link active">
                                <i class="bx bx-home-alt mr-2"></i>
                                Home
                            </a>
                            <a href="#" class="nav-link">
                                <i class="bx bx-book-open mr-2"></i>
                                Resources
                            </a>
                            <a href="#" class="nav-link">
                                <i class="bx bx-calendar mr-2"></i>
                                History
                            </a>
                            <a href="#" class="nav-link">
                                <i class="bx bx-help-circle mr-2"></i>
                                Help
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="text-gray-500 hover:text-gray-700 focus:outline-none text-xl">
                                <i class="bx bx-bell"></i>
                                <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-danger"></span>
                            </button>
                        </div>
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-primary-light flex items-center justify-center text-primary font-bold text-lg">
                                <?= substr($patient_name ?? 'JD', 0, 1) ?>
                            </div>
                            <span class="ml-2 text-base font-medium text-gray-700 hidden md:block"><?= $patient_name ?? 'John Doe' ?></span>
                        </div>
                        <div class="badge badge-primary hidden md:flex items-center">
                            <i class="bx bx-calendar text-primary mr-1"></i> <?= date('M d, Y') ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Welcome Banner -->
        <div class="bg-primary-light py-4 mb-6">
            <div class="container-fluid">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-2xl font-bold text-gray-900">Welcome back, <?= $patient_name ?? 'John' ?>!</h2>
                        <p class="text-gray-700 mt-1">Here's your health progress for today, <?= date('F d, Y') ?></p>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" class="btn btn-outline">
                            <i class="bx bx-printer mr-2 text-lg"></i> Print Summary
                        </button>
                        <button type="button" class="btn btn-primary">
                            <i class="bx bx-phone-call mr-2 text-lg"></i> Call Clinic
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-grow">
            <div class="container-fluid">
                <!-- Treatment Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="card p-6">
                        <div class="flex items-center">
                            <div class="icon-circle bg-primary-light text-primary mr-4">
                                <i class="bx bx-calendar-check text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-700">Days in Treatment</h3>
                                <div class="mt-1 flex items-baseline">
                                    <p class="text-3xl font-bold text-gray-900"><?= $treatment_day ?? '45' ?></p>
                                    <p class="ml-2 text-base text-gray-500">of <?= $treatment_duration ?? '180' ?> days</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card p-6">
                        <div class="flex items-center">
                            <div class="icon-circle bg-success-light text-success mr-4">
                                <i class="bx bx-trending-up text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-700">Medicine Taken</h3>
                                <div class="mt-1 flex items-baseline">
                                    <p class="text-3xl font-bold text-gray-900"><?= $adherence_rate ?? '92' ?>%</p>
                                    <p class="ml-2 text-base text-success">
                                        <i class="bx bx-up-arrow-alt"></i> Better than last week
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card p-6">
                        <div class="flex items-center">
                            <div class="icon-circle bg-primary-light text-primary mr-4">
                                <i class="bx bx-vial text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-700">Treatment Phase</h3>
                                <div class="mt-1">
                                    <p class="text-xl font-bold text-gray-900"><?= $treatment_phase ?? 'Intensive' ?></p>
                                    <p class="text-base text-gray-500">Month 2 of 3</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card p-6">
                        <div class="flex items-center">
                            <div class="icon-circle bg-warning-light text-warning mr-4">
                                <i class="bx bx-calendar text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-700">Next Doctor Visit</h3>
                                <div class="mt-1">
                                    <p class="text-xl font-bold text-gray-900"><?= $next_checkup_date ?? 'Jun 15' ?></p>
                                    <p class="text-base text-gray-500">In <?= $days_to_checkup ?? '12' ?> days</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Alerts -->
                <div class="card mb-8">
                    <div class="card-header bg-primary-light">
                        <h3 class="text-xl font-bold text-gray-900">
                            <i class="bx bx-bell mr-2"></i> Important Reminders
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div class="alert alert-success">
                                <div class="flex items-start">
                                    <div class="icon-circle bg-success-light text-success mr-3 flex-shrink-0">
                                        <i class="bx bx-check-circle text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold">Great job taking your medicine!</h4>
                                        <p class="text-base mt-1">
                                            You've taken your medicine for 6 days in a row. Keep up the good work!
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-warning">
                                <div class="flex items-start">
                                    <div class="icon-circle bg-warning-light text-warning mr-3 flex-shrink-0">
                                        <i class="bx bx-calendar-event text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold">Doctor Visit Coming Up</h4>
                                        <p class="text-base mt-1">
                                            Your next visit with Dr. Sarah Johnson is in 12 days (June 15, 2023).
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-primary">
                                <div class="flex items-start">
                                    <div class="icon-circle bg-primary-light text-primary mr-3 flex-shrink-0">
                                        <i class="bx bx-trending-up text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold">Your Symptoms Are Improving</h4>
                                        <p class="text-base mt-1">
                                            Your symptoms have decreased by 30% over the past two weeks. This is a good sign that your treatment is working!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Symptom Trends Chart -->
                <div class="card mb-8">
                    <div class="card-header bg-primary-light">
                        <h3 class="text-xl font-bold text-gray-900">
                            <i class="bx bx-line-chart mr-2"></i> How Your Symptoms Are Changing
                            <span class="help-tooltip" data-tooltip="This chart shows how your symptoms have changed over time. Lower numbers mean you're feeling better!">?</span>
                        </h3>
                        <div class="flex space-x-2">
                            <select id="chart-period" class="form-control py-2 px-3 text-base w-auto">
                                <option value="week">Last Week</option>
                                <option value="month" selected>Last Month</option>
                                <option value="3months">Last 3 Months</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-tabs">
                            <div class="chart-tab active" data-chart="symptoms">
                                <i class="bx bx-pulse mr-2"></i> Symptoms
                            </div>
                            <div class="chart-tab" data-chart="adherence">
                                <i class="bx bx-calendar-check mr-2"></i> Medicine Taken
                            </div>
                            <div class="chart-tab" data-chart="side-effects">
                                <i class="bx bx-dizzy mr-2"></i> Side Effects
                            </div>
                        </div>
                        <div class="chart-container">
                            <canvas id="symptomsChart"></canvas>
                        </div>
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg border text-base">
                            <h4 class="font-bold mb-2">What This Means:</h4>
                            <p id="chart-analysis">Your symptoms are getting better! Your fever has improved by 85% and your cough has improved by 62% over the past 6 weeks. You're still feeling tired sometimes, but that's also slowly getting better.</p>
                        </div>
                    </div>
                </div>

                <!-- Medication Calendar -->
                <div class="card mb-8">
                    <div class="card-header bg-primary-light">
                        <h3 class="text-xl font-bold text-gray-900">
                            <i class="bx bx-calendar mr-2"></i> Your Medicine Calendar
                            <span class="help-tooltip" data-tooltip="This calendar shows when you've taken your medicine. Green means taken on time, yellow means taken late, and red means missed.">?</span>
                        </h3>
                        <div class="flex space-x-2">
                            <select id="calendar-month" class="form-control py-2 px-3 text-base w-auto">
                                <option value="5">May 2023</option>
                                <option value="6" selected>June 2023</option>
                                <option value="7">July 2023</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="calendar">
                            <div class="calendar-grid">
                                <div class="calendar-weekday">Sunday</div>
                                <div class="calendar-weekday">Monday</div>
                                <div class="calendar-weekday">Tuesday</div>
                                <div class="calendar-weekday">Wednesday</div>
                                <div class="calendar-weekday">Thursday</div>
                                <div class="calendar-weekday">Friday</div>
                                <div class="calendar-weekday">Saturday</div>
                                
                                <!-- Calendar days will be generated by JavaScript -->
                                <div id="calendar-days"></div>
                            </div>
                            
                            <div class="calendar-legend">
                                <div class="calendar-legend-item">
                                    <div class="calendar-legend-indicator bg-success"></div>
                                    <span>Medicine Taken On Time</span>
                                </div>
                                <div class="calendar-legend-item">
                                    <div class="calendar-legend-indicator bg-warning"></div>
                                    <span>Medicine Taken Late</span>
                                </div>
                                <div class="calendar-legend-item">
                                    <div class="calendar-legend-indicator bg-danger"></div>
                                    <span>Medicine Missed</span>
                                </div>
                                <div class="calendar-legend-item">
                                    <div class="calendar-legend-indicator bg-gray-300"></div>
                                    <span>No Record</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Dashboard Content -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Progress & Stats -->
                    <div class="space-y-8">
                        <!-- Treatment Progress -->
                        <div class="card">
                            <div class="card-header bg-primary-light">
                                <h3 class="text-xl font-bold text-gray-900">
                                    <i class="bx bx-trending-up mr-2"></i> Your Treatment Progress
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-6">
                                    <div class="flex justify-between text-base mb-2">
                                        <span class="font-bold text-gray-700">Overall Progress</span>
                                        <span class="font-bold text-primary"><?= round(($treatment_day ?? 45) / ($treatment_duration ?? 180) * 100) ?>% Complete</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill progress-bar-fill-primary" style="width: <?= ($treatment_day ?? 45) / ($treatment_duration ?? 180) * 100 ?>%"></div>
                                    </div>
                                    <div class="flex justify-between text-base text-gray-500 mt-2">
                                        <span>Start</span>
                                        <span>Day <?= $treatment_day ?? '45' ?> (Today)</span>
                                        <span>End</span>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-success-light rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full bg-success mr-3"></div>
                                            <span class="text-base font-medium">First Phase</span>
                                        </div>
                                        <span class="text-base font-medium text-success">Completed!</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-primary-light rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full bg-primary mr-3"></div>
                                            <span class="text-base font-medium">Second Phase</span>
                                        </div>
                                        <span class="text-base font-medium text-primary">In Progress</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-100 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full bg-gray-300 mr-3"></div>
                                            <span class="text-base font-medium">Follow-up Phase</span>
                                        </div>
                                        <span class="text-base font-medium text-gray-500">Coming Soon</span>
                                    </div>
                                </div>
                                
                                <div class="mt-6 pt-6 border-t">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-base font-medium text-gray-700">Expected finish date:</p>
                                            <p class="text-xl font-bold text-gray-900"><?= $completion_date ?? 'November 12, 2023' ?></p>
                                        </div>
                                        <div class="badge badge-success p-3">
                                            <i class="bx bx-check-circle mr-2 text-lg"></i> On Track
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Doctor's Weekly Review -->
                        <div class="card">
                            <div class="card-header bg-primary-light">
                                <h3 class="text-xl font-bold text-gray-900">
                                    <i class="bx bx-user-voice mr-2"></i> Doctor's Notes
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="flex items-center mb-4">
                                    <div class="icon-circle bg-primary-light text-primary mr-3">
                                        <i class="bx bx-user-circle text-2xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">Dr. Sarah Johnson</h4>
                                        <p class="text-base text-gray-500">Last visit: June 10, 2023</p>
                                    </div>
                                </div>
                                
                                <div class="p-4 bg-primary-light rounded-lg mb-4">
                                    <p class="text-base italic">
                                        "John is doing well with his TB treatment. He's taking his medicine regularly (94% of the time), which is excellent. His cough is much better, and he's not having night sweats as often. His liver tests are normal. He should continue his current medicine and watch the mild skin rash that started last week."
                                    </p>
                                </div>
                                
                                <div class="space-y-3">
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="w-4 h-4 rounded-full bg-success mr-3"></div>
                                        <span class="text-base text-gray-700">Continue taking your current medicine</span>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="w-4 h-4 rounded-full bg-warning mr-3"></div>
                                        <span class="text-base text-gray-700">Watch for any changes in your skin rash</span>
                                    </div>
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="w-4 h-4 rounded-full bg-primary mr-3"></div>
                                        <span class="text-base text-gray-700">Next visit: June 15, 2023</span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t">
                                    <button class="btn btn-outline w-full">
                                        <i class="bx bx-history mr-2"></i> See Previous Notes
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Risk Level Indicator -->
                        <div class="card">
                            <div class="card-header bg-primary-light">
                                <h3 class="text-xl font-bold text-gray-900">
                                    <i class="bx bx-shield-quarter mr-2"></i> Health Risk Level
                                    <span class="help-tooltip" data-tooltip="This shows your current health risk level based on your symptoms, medicine-taking, and side effects.">?</span>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-lg font-bold text-gray-700">Current Risk Level</h4>
                                    <div class="badge badge-success p-3">
                                        <i class="bx bx-shield-quarter mr-2 text-lg"></i> Low Risk
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full bg-success mr-3"></div>
                                            <span class="text-base">Taking Medicine</span>
                                        </div>
                                        <span class="text-base font-bold text-success">Good</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full bg-success mr-3"></div>
                                            <span class="text-base">Symptoms</span>
                                        </div>
                                        <span class="text-base font-bold text-success">Mild</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full bg-warning mr-3"></div>
                                            <span class="text-base">Side Effects</span>
                                        </div>
                                        <span class="text-base font-bold text-warning">Moderate</span>
                                    </div>
                                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full bg-success mr-3"></div>
                                            <span class="text-base">Daily Check-ins</span>
                                        </div>
                                        <span class="text-base font-bold text-success">Regular</span>
                                    </div>
                                </div>
                                
                                <div class="mt-6 pt-4 border-t">
                                    <p class="text-base font-medium text-gray-600 mb-2">Your risk level over time:</p>
                                    <div class="flex items-center space-x-1">
                                        <div class="h-8 w-full bg-warning-light rounded-l-full"></div>
                                        <div class="h-8 w-full bg-warning-light"></div>
                                        <div class="h-8 w-full bg-warning-light"></div>
                                        <div class="h-8 w-full bg-success-light"></div>
                                        <div class="h-8 w-full bg-success-light"></div>
                                        <div class="h-8 w-full bg-success-light rounded-r-full"></div>
                                    </div>
                                    <div class="flex justify-between text-base text-gray-500 mt-2">
                                        <span>May 1</span>
                                        <span>May 15</span>
                                        <span>Jun 1</span>
                                        <span>Today</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Today's Log Form -->
                    <div class="lg:col-span-2">
                        <div class="card">
                            <!-- Form Header -->
                            <div class="card-header bg-primary-light">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">
                                        <i class="bx bx-calendar-check mr-2"></i> Today's Health Check-in
                                    </h3>
                                    <p class="text-base text-gray-600">Sunday, <?= date('F d, Y') ?></p>
                                </div>
                                <div class="badge badge-warning p-3">
                                    <i class="bx bx-time mr-2"></i> Needs Completion
                                </div>
                            </div>

                            <!-- Form -->
                            <div class="card-body">
                                <form action="process_log.php" method="post">
                                    <input type="hidden" name="token" value="<?= $token ?? '' ?>">
                                    
                                    <!-- Medication Intake -->
                                    <div class="mb-8">
                                        <label class="form-label text-lg mb-3">Did you take your TB medicine today?</label>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="form-radio-card">
                                                <input type="radio" id="med-yes" name="medication_taken" value="yes" required>
                                                <label for="med-yes">
                                                    <div class="icon-circle bg-success-light text-success mr-3">
                                                        <i class="bx bx-check text-2xl"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-lg font-bold text-gray-900">Yes</h4>
                                                        <p class="text-base text-gray-500">I took my medicine today</p>
                                                    </div>
                                                </label>
                                            </div>
                                            
                                            <div class="form-radio-card">
                                                <input type="radio" id="med-no" name="medication_taken" value="no" required>
                                                <label for="med-no">
                                                    <div class="icon-circle bg-danger-light text-danger mr-3">
                                                        <i class="bx bx-x text-2xl"></i>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-lg font-bold text-gray-900">No</h4>
                                                        <p class="text-base text-gray-500">I missed my medicine today</p>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- If No, Why Not? (conditionally shown) -->
                                    <div class="mb-6 hidden" id="reasonSection">
                                        <label for="reason" class="form-label text-lg">Why were you unable to take your medicine today?</label>
                                        <div class="relative">
                                            <select id="reason" name="reason" class="form-control text-base">
                                                <option value="">Please select a reason...</option>
                                                <option value="forgot">I forgot</option>
                                                <option value="side_effects">Side effects were too strong</option>
                                                <option value="ran_out">I ran out of medicine</option>
                                                <option value="feeling_better">I'm feeling better</option>
                                                <option value="other">Other reason</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Daily Checklist Section -->
                                    <div class="mb-8">
                                        <label class="form-label text-lg mb-3">Daily Health Checklist
                                            <span class="help-tooltip" data-tooltip="Check all the healthy activities you did today">?</span>
                                        </label>
                                        <div class="space-y-3">
                                            <label class="form-check">
                                                <input type="checkbox" name="checklist[]" value="drank_water" class="form-check-input">
                                                <span class="text-base text-gray-700">I drank 8+ glasses of water today</span>
                                            </label>
                                            <label class="form-check">
                                                <input type="checkbox" name="checklist[]" value="ate_nutritious" class="form-check-input">
                                                <span class="text-base text-gray-700">I ate healthy meals today</span>
                                            </label>
                                            <label class="form-check">
                                                <input type="checkbox" name="checklist[]" value="no_symptoms" class="form-check-input">
                                                <span class="text-base text-gray-700">I had no symptoms today</span>
                                            </label>
                                            <label class="form-check">
                                                <input type="checkbox" name="checklist[]" value="got_rest" class="form-check-input">
                                                <span class="text-base text-gray-700">I got enough sleep (7-8 hours)</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Symptoms Section -->
                                    <div class="mb-8">
                                        <label class="form-label text-lg mb-3">How are you feeling today?</label>
                                        
                                        <!-- Symptom Severity Slider -->
                                        <div class="mb-6">
                                            <div class="flex justify-between text-base text-gray-600 mb-2">
                                                <span>No symptoms</span>
                                                <span>Severe symptoms</span>
                                            </div>
                                            <div class="relative">
                                                <input type="range" name="symptom_severity" min="0" max="10" value="3" 
                                                    class="w-full h-3 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                            </div>
                                            <div class="flex justify-between text-sm text-gray-500 mt-1">
                                                <span>0</span>
                                                <span>1</span>
                                                <span>2</span>
                                                <span>3</span>
                                                <span>4</span>
                                                <span>5</span>
                                                <span>6</span>
                                                <span>7</span>
                                                <span>8</span>
                                                <span>9</span>
                                                <span>10</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Symptoms Checkboxes -->
                                        <label class="form-label text-lg mb-3">Check any symptoms you have today:</label>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mb-4">
                                            <label class="form-check">
                                                <input type="checkbox" name="symptoms[]" value="cough" class="form-check-input">
                                                <span class="text-base text-gray-700">Cough</span>
                                            </label>
                                            <label class="form-check">
                                                <input type="checkbox" name="symptoms[]" value="fever" class="form-check-input">
                                                <span class="text-base text-gray-700">Fever</span>
                                            </label>
                                            <label class="form-check">
                                                <input type="checkbox" name="symptoms[]" value="nausea" class="form-check-input">
                                                <span class="text-base text-gray-700">Nausea</span>
                                            </label>
                                            <label class="form-check">
                                                <input type="checkbox" name="symptoms[]" value="chest_pain" class="form-check-input">
                                                <span class="text-base text-gray-700">Chest pain</span>
                                            </label>
                                            <label class="form-check">
                                                <input type="checkbox" name="symptoms[]" value="fatigue" class="form-check-input">
                                                <span class="text-base text-gray-700">Feeling tired</span>
                                            </label>
                                            <label class="form-check">
                                                <input type="checkbox" name="symptoms[]" value="night_sweats" class="form-check-input">
                                                <span class="text-base text-gray-700">Night sweats</span>
                                            </label>
                                        </div>
                                        
                                        <button type="button" class="text-base text-primary hover:text-primary-dark font-medium flex items-center">
                                            <i class="bx bx-plus-circle mr-2 text-lg"></i> Show more symptoms
                                        </button>
                                    </div>

                                    <!-- Side Effects -->
                                    <div class="mb-6">
                                        <label for="side_effects" class="form-label text-lg">Any side effects from your medicine?
                                            <span class="help-tooltip" data-tooltip="Click on any side effects you're experiencing from your TB medicine">?</span>
                                        </label>
                                        <div class="pill-selector flex flex-wrap gap-3 mb-3">
                                            <label class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-base cursor-pointer hover:bg-gray-200">
                                                <input type="checkbox" name="side_effects[]" value="dizziness" class="sr-only">
                                                Dizziness
                                            </label>
                                            <label class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-base cursor-pointer hover:bg-gray-200">
                                                <input type="checkbox" name="side_effects[]" value="skin_rash" class="sr-only">
                                                Skin rash
                                            </label>
                                            <label class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-base cursor-pointer hover:bg-gray-200">
                                                <input type="checkbox" name="side_effects[]" value="joint_pain" class="sr-only">
                                                Joint pain
                                            </label>
                                            <label class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-base cursor-pointer hover:bg-gray-200">
                                                <input type="checkbox" name="side_effects[]" value="headache" class="sr-only">
                                                Headache
                                            </label>
                                        </div>
                                        <input type="text" id="other_side_effects" name="other_side_effects" class="form-control text-base" placeholder="Other side effects? Type them here...">
                                    </div>

                                    <!-- Notes -->
                                    <div class="mb-8">
                                        <label for="notes" class="form-label text-lg">Anything else you want to tell your doctor?</label>
                                        <textarea id="notes" name="notes" rows="3" class="form-control text-base" placeholder="Type any other information you'd like to share with your doctor..."></textarea>
                                    </div>

                                    <!-- Daily Health Tip -->
                                    <div class="alert alert-primary mb-8">
                                        <div class="flex items-start">
                                            <div class="icon-circle bg-primary-light text-primary mr-3 flex-shrink-0">
                                                <i class="bx bx-bulb text-2xl"></i>
                                            </div>
                                            <div>
                                                <h4 class="text-lg font-bold">Today's Health Tip</h4>
                                                <p class="text-base mt-1">
                                                    Did you know? TB treatment works best when you sleep 8 hours each night. Good sleep helps your body fight the infection better.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="flex justify-center">
                                        <button type="submit" class="btn btn-lg btn-success">
                                            <i class="bx bx-check-circle mr-2 text-xl"></i>
                                            Submit Today's Check-in
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Quick Contact -->
                            <div class="card-footer flex flex-col sm:flex-row justify-between items-center gap-3">
                                <p class="text-base text-gray-600">Need help? Contact your healthcare team</p>
                                <div>
                                    <a href="tel:+1234567890" class="btn btn-primary">
                                        <i class="bx bx-phone mr-2 text-lg"></i>
                                        Call Clinic (Toll Free)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white py-6 border-t mt-auto">
            <div class="container-fluid">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white mr-3">
                            <i class="bx bx-plus-medical text-xl"></i>
                        </div>
                        <span class="text-lg font-bold text-gray-800">TB Care Connect</span>
                    </div>
                    
                    <div class="flex space-x-6 mb-4 md:mb-0">
                        <a href="#" class="text-base text-gray-600 hover:text-gray-900">
                            <i class="bx bx-help-circle mr-2"></i> Help Center
                        </a>
                        <a href="#" class="text-base text-gray-600 hover:text-gray-900">
                            <i class="bx bx-lock-alt mr-2"></i> Privacy
                        </a>
                        <a href="#" class="text-base text-gray-600 hover:text-gray-900">
                            <i class="bx bx-cog mr-2"></i> Settings
                        </a>
                    </div>
                    
                    <div class="text-base text-gray-500">
                        &copy; <?= date('Y') ?> TB Care Connect. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- JavaScript for the form interaction, charts and calendar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Medication radio buttons
            const medicationRadios = document.querySelectorAll('input[name="medication_taken"]');
            const reasonSection = document.getElementById('reasonSection');
            
            medicationRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'no') {
                        reasonSection.classList.remove('hidden');
                    } else {
                        reasonSection.classList.add('hidden');
                    }
                });
            });
            
            // Pill selector
            const pillLabels = document.querySelectorAll('.pill-selector label');
            
            pillLabels.forEach(label => {
                label.addEventListener('click', function() {
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    if (checkbox.checked) {
                        this.classList.remove('active');
                        checkbox.checked = false;
                    } else {
                        this.classList.add('active');
                        checkbox.checked = true;
                    }
                });
            });
            
            // Chart tabs
            const chartTabs = document.querySelectorAll('.chart-tab');
            chartTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    chartTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    updateChart(this.dataset.chart);
                });
            });
            
            // Initialize charts
            initializeCharts();
            
            // Initialize calendar
            generateCalendar();
        });
        
        function initializeCharts() {
            // Sample data for symptoms chart
            const ctx = document.getElementById('symptomsChart').getContext('2d');
            
            const dates = ['May 1', 'May 8', 'May 15', 'May 22', 'May 29', 'Jun 5', 'Jun 12'];
            
            const symptomsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [
                        {
                            label: 'Cough',
                            data: [8, 7, 6, 5, 4, 3, 3],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.3,
                            pointRadius: 6,
                            pointBackgroundColor: '#3b82f6'
                        },
                        {
                            label: 'Fever',
                            data: [9, 8, 7, 6, 5, 4, 3],
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.3,
                            pointRadius: 6,
                            pointBackgroundColor: '#ef4444'
                        },
                        {
                            label: 'Fatigue',
                            data: [7, 6, 5, 4, 3, 2, 1],
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            tension: 0.3,
                            pointRadius: 6,
                            pointBackgroundColor: '#f59e0b'
                        },
                        {
                            label: 'Night Sweats',
                            data: [6, 5, 4, 3, 3, 2, 1],
                            borderColor: '#8b5cf6',
                            backgroundColor: 'rgba(139, 92, 246, 0.1)',
                            tension: 0.3,
                            pointRadius: 6,
                            pointBackgroundColor: '#8b5cf6'
                        },
                        {
                            label: 'Weight Loss',
                            data: [3, 3, 2, 2, 1, 1, 0],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.3,
                            pointRadius: 6,
                            pointBackgroundColor: '#10b981'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 10,
                            title: {
                                display: true,
                                text: 'Severity (0-10)',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 12
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 15,
                                padding: 20,
                                font: {
                                    size: 14
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 16
                            },
                            bodyFont: {
                                size: 14
                            },
                            displayColors: true,
                            boxWidth: 10,
                            boxHeight: 10
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false
                    }
                }
            });
            
            // Store chart instance for later updates
            window.symptomsChart = symptomsChart;
        }
        
        function updateChart(chartType) {
            const chart = window.symptomsChart;
            
            if (chartType === 'symptoms') {
                chart.data.datasets = [
                    {
                        label: 'Cough',
                        data: [8, 7, 6, 5, 4, 3, 3],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#3b82f6'
                    },
                    {
                        label: 'Fever',
                        data: [9, 8, 7, 6, 5, 4, 3],
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#ef4444'
                    },
                    {
                        label: 'Fatigue',
                        data: [7, 6, 5, 4, 3, 2, 1],
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#f59e0b'
                    },
                    {
                        label: 'Night Sweats',
                        data: [6, 5, 4, 3, 3, 2, 1],
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#8b5cf6'
                    },
                    {
                        label: 'Weight Loss',
                        data: [3, 3, 2, 2, 1, 1, 0],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#10b981'
                    }
                ];
                document.getElementById('chart-analysis').textContent = 'Your symptoms are getting better! Your fever has improved by 85% and your cough has improved by 62% over the past 6 weeks. You\'re still feeling tired sometimes, but that\'s also slowly getting better.';
            } else if (chartType === 'adherence') {
                chart.data.datasets = [
                    {
                        label: 'Medicine Taken',
                        data: [80, 85, 90, 88, 92, 94, 95],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#3b82f6'
                    },
                    {
                        label: 'Taken On Time',
                        data: [75, 80, 85, 82, 90, 92, 94],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#10b981'
                    }
                ];
                document.getElementById('chart-analysis').textContent = 'You\'re doing great at taking your medicine! You\'ve improved from taking it 80% of the time to 95% of the time over the past 6 weeks. You\'re also getting better at taking it on time.';
            } else if (chartType === 'side-effects') {
                chart.data.datasets = [
                    {
                        label: 'Nausea',
                        data: [7, 6, 5, 4, 3, 2, 1],
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#f59e0b'
                    },
                    {
                        label: 'Skin Rash',
                        data: [0, 0, 2, 4, 3, 2, 1],
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#ef4444'
                    },
                    {
                        label: 'Dizziness',
                        data: [5, 4, 3, 2, 1, 1, 0],
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.3,
                        pointRadius: 6,
                        pointBackgroundColor: '#8b5cf6'
                    }
                ];
                document.getElementById('chart-analysis').textContent = 'The side effects from your medicine are getting better! Your nausea has decreased from severe to mild. You developed a skin rash in week 3, but it\'s now improving. Your dizziness is almost completely gone.';
            }
            
            chart.update();
        }
        
        function generateCalendar() {
            const calendarDays = document.getElementById('calendar-days');
            if (!calendarDays) return;
            
            // Clear existing content
            calendarDays.innerHTML = '';
            
            // Get current date
            const today = new Date();
            const currentMonth = today.getMonth();
            const currentYear = today.getFullYear();
            
            // Create a date for the first day of the month
            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            
            // Get the day of the week for the first day (0 = Sunday, 1 = Monday, etc.)
            const firstDayOfWeek = firstDay.getDay();
            
            // Get the number of days in the month
            const daysInMonth = lastDay.getDate();
            
            // Create calendar grid
            const calendarGrid = document.createElement('div');
            calendarGrid.className = 'calendar-grid';
            
            // Add empty cells for days before the first day of the month
            for (let i = 0; i < firstDayOfWeek; i++) {
                const emptyDay = document.createElement('div');
                emptyDay.className = 'calendar-day other-month';
                calendarGrid.appendChild(emptyDay);
            }
            
            // Generate random adherence data for demonstration
            // In a real app, this would come from the database
            const adherenceData = {};
            for (let i = 1; i <= daysInMonth; i++) {
                // 0: No data, 1: Missed, 2: Taken late, 3: Taken on time
                let status;
                
                // Make more recent days have better adherence for demonstration
                if (i > daysInMonth - 7) {
                    // Last week: mostly good adherence
                    status = Math.random() < 0.9 ? 3 : (Math.random() < 0.5 ? 2 : 1);
                } else if (i > daysInMonth - 14) {
                    // 2 weeks ago: mixed adherence
                    status = Math.random() < 0.8 ? 3 : (Math.random() < 0.5 ? 2 : 1);
                } else {
                    // Earlier in month: lower adherence
                    status = Math.random() < 0.7 ? 3 : (Math.random() < 0.5 ? 2 : 1);
                }
                
                adherenceData[i] = status;
            }
            
            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                
                // Check if this day is today
                if (day === today.getDate()) {
                    dayElement.classList.add('today');
                }
                
                // Add day number
                const dayNumber = document.createElement('div');
                dayNumber.className = 'calendar-day-number';
                dayNumber.textContent = day;
                dayElement.appendChild(dayNumber);
                
                // Add adherence indicator
                const indicator = document.createElement('div');
                indicator.className = 'calendar-day-indicator';
                
                // Set indicator color based on adherence status
                const status = adherenceData[day] || 0;
                if (status === 3) {
                    indicator.classList.add('success');
                } else if (status === 2) {
                    indicator.classList.add('warning');
                } else if (status === 1) {
                    indicator.classList.add('danger');
                } else {
                    indicator.classList.add('gray-300');
                }
                
                dayElement.appendChild(indicator);
                calendarGrid.appendChild(dayElement);
            }
            
            // Add empty cells for days after the last day of the month
            const totalCells = firstDayOfWeek + daysInMonth;
            const remainingCells = 7 - (totalCells % 7);
            if (remainingCells < 7) {
                for (let i = 0; i < remainingCells; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'calendar-day other-month';
                    calendarGrid.appendChild(emptyDay);
                }
            }
            
            calendarDays.appendChild(calendarGrid);
        }
    </script>
</body>

</html>
