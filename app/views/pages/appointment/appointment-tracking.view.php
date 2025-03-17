<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/index.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <style>
        .logo-container {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: white;
            color: var(--primary);
            border: 1px solid var(--primary);
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
        }

        .btn-secondary:hover {
            background-color: var(--primary-light);
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: #FEF2F2;
            color: #B91C1C;
            border: 1px solid #FEE2E2;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
        }

        .btn-danger:hover {
            background-color: #FEE2E2;
            transform: translateY(-1px);
        }

        .btn-disabled {
            background-color: var(--gray-200);
            color: var(--gray-500);
            cursor: not-allowed;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
        }

        .search-input {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-300);
            transition: all 0.2s ease;
            width: 100%;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
            outline: none;
        }

        .avatar {
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            color: var(--primary-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
            border: 3px solid white;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-scheduled {
            background-color: #EFF6FF;
            color: #1E40AF;
        }

        .status-confirmed {
            background-color: #ECFDF5;
            color: #065F46;
        }

        .status-completed {
            background-color: #F3F4F6;
            color: #1F2937;
        }

        .status-cancelled {
            background-color: #FEF2F2;
            color: #B91C1C;
        }

        .status-rescheduled {
            background-color: #FFF7ED;
            color: #9A3412;
        }

        /* Timeline styles */
        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0.75rem;
            width: 2px;
            background-color: var(--gray-200);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 1.5rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            top: 0;
            left: -2rem;
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            background-color: white;
            border: 2px solid var(--primary);
            z-index: 1;
        }

        .timeline-marker.completed {
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .timeline-marker.current {
            background-color: white;
            border: 2px solid var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.2);
        }

        .timeline-marker.pending {
            background-color: white;
            border: 2px solid var(--gray-300);
        }

        .timeline-content {
            padding: 0.5rem 0;
        }

        /* Split layout */
        .split-layout {
            display: flex;
            flex-direction: column;
            min-height: calc(100vh - 150px);
        }

        @media (min-width: 1024px) {
            .split-layout {
                flex-direction: row;
            }
        }

        /* Hero section */
        .hero-section {
            position: relative;
            background-color: var(--primary);
            color: white;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (min-width: 1024px) {
            .hero-section {
                width: 40%;
                min-height: calc(100vh - 150px);
                position: sticky;
                top: 0;
            }
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.2;
        }

        .hero-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.2;
            mix-blend-mode: multiply;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            max-width: 500px;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        .hero-icon {
            font-size: 8rem;
            position: absolute;
            bottom: 2rem;
            right: 2rem;
            opacity: 0.15;
        }

        /* Content section */
        .content-section {
            padding: 3rem;
            flex: 1;
            background-color: #f9fafb;
        }

        @media (min-width: 1024px) {
            .content-section {
                width: 60%;
                overflow-y: auto;
            }
        }

        /* Tracking form */
        .tracking-form {
            background-color: white;
            border: 1px solid var(--gray-200);
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .tracking-form-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--gray-800);
        }

        .tracking-input-container {
            position: relative;
        }

        .tracking-input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
        }

        .tracking-input {
            padding-left: 3rem;
            font-size: 1.125rem;
            height: 3.5rem;
            border-radius: 0.75rem;
        }

        /* Results section */
        .results-section {
            display: none;
        }

        .results-section.visible {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }

        /* Print button */
        .print-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s ease;
            background-color: white;
            color: var(--primary);
            border: 1px solid var(--primary-lighter);
        }

        .print-btn:hover {
            background-color: var(--primary-light);
        }

        .print-btn i {
            margin-right: 0.5rem;
        }

        /* Error message */
        .error-message {
            display: none;
            color: #B91C1C;
            background-color: #FEF2F2;
            border: 1px solid #FEE2E2;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-top: 1rem;
            text-align: center;
        }

        .error-message.visible {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Loading indicator */
        .loading-indicator {
            display: none;
            text-align: center;
            padding: 2rem 0;
        }

        .loading-indicator.visible {
            display: block;
        }

        .spinner {
            display: inline-block;
            width: 2.5rem;
            height: 2.5rem;
            border: 3px solid rgba(var(--primary-rgb), 0.2);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Appointment details card */
        .appointment-card {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .appointment-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .appointment-card-body {
            padding: 1.5rem;
        }

        .appointment-card-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--gray-100);
            background-color: var(--gray-50);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
        }

        @media (min-width: 640px) {
            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Info card */
        .info-card {
            background-color: var(--gray-50);
            border-radius: 0.75rem;
            padding: 1.25rem;
            transition: all 0.2s ease;
        }

        .info-card:hover {
            background-color: var(--gray-100);
        }

        .info-card-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .info-card-label {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-bottom: 0.25rem;
        }

        .info-card-value {
            font-size: 1rem;
            font-weight: 500;
            color: var(--gray-800);
        }

        /* Doctor card */
        .doctor-card {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 0.75rem;
            padding: 1.25rem;
            border: 1px solid var(--gray-100);
            margin-bottom: 1.5rem;
        }

        .doctor-avatar {
            width: 4rem;
            height: 4rem;
            margin-right: 1rem;
        }

        /* Preparation list */
        .preparation-list {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .preparation-list-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--gray-800);
        }

        .preparation-item {
            display: flex;
            align-items: flex-start;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .preparation-item:last-child {
            border-bottom: none;
        }

        .preparation-item-icon {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            background-color: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .preparation-item-text {
            font-size: 0.875rem;
            color: var(--gray-700);
        }

        /* Modal styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-overlay.visible {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .modal-overlay.visible .modal {
            transform: translateY(0);
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--gray-500);
            cursor: pointer;
            font-size: 1.5rem;
            line-height: 1;
            padding: 0.25rem;
        }

        .modal-close:hover {
            color: var(--gray-700);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--gray-100);
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        /* Calendar styles - Updated to match reference */
        .calendar-container {
            margin-bottom: 1.5rem;
        }

        .calendar-date-picker {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        @media (min-width: 768px) {
            .calendar-date-picker {
                flex-direction: row;
            }
        }

        .calendar-section {
            flex: 1;
        }

        .time-section {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .calendar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .calendar-month-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .calendar-nav-btn {
            background: none;
            border: none;
            color: var(--gray-600);
            cursor: pointer;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .calendar-nav-btn:hover {
            background-color: var(--gray-100);
            color: var(--gray-800);
        }

        .calendar-month {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }

        .calendar-day-header {
            text-align: center;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-500);
            padding: 0.5rem 0;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .calendar-day:hover:not(.disabled):not(.empty) {
            background-color: var(--gray-100);
        }

        .calendar-day.today {
            font-weight: 600;
            border: 1px solid var(--primary);
        }

        .calendar-day.selected {
            background-color: var(--primary-dark);
            color: white;
        }

        .calendar-day.disabled {
            color: var(--gray-300);
            cursor: not-allowed;
        }

        .calendar-day.empty {
            cursor: default;
        }

        .calendar-day.has-slots {
            background-color: #E0F2FE;
            color: var(--gray-800);
        }

        .calendar-day.has-slots.selected {
            background-color: var(--primary-dark);
            color: white;
        }

        /* Time slots */
        .time-slots-container {
            flex: 1;
        }

        .time-slots-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
        }

        .time-slots-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .time-slot {
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid var(--gray-200);
            text-align: center;
            font-size: 1rem;
            font-weight: 500;
            color: var(--gray-700);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .time-slot:hover:not(.disabled) {
            border-color: var(--primary);
            background-color: #E0F2FE;
        }

        .time-slot.selected {
            border-color: var(--primary-dark);
            background-color: var(--primary-dark);
            color: white;
        }

        .time-slot.disabled {
            color: var(--gray-300);
            background-color: var(--gray-50);
            cursor: not-allowed;
        }

        /* Confirmation modal */
        .confirmation-modal .modal-body {
            text-align: center;
            padding: 2rem 1.5rem;
        }

        .confirmation-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .confirmation-icon.warning {
            color: #F59E0B;
        }

        .confirmation-icon.danger {
            color: #B91C1C;
        }

        .confirmation-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .confirmation-message {
            color: var(--gray-600);
            margin-bottom: 1.5rem;
        }

        /* Tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 0.25rem;
            padding: 0.5rem;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.75rem;
        }

        .tooltip .tooltip-text::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Success message */
        .success-message {
            display: none;
            color: #065F46;
            background-color: #ECFDF5;
            border: 1px solid #D1FAE5;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-top: 1rem;
            text-align: center;
        }

        .success-message.visible {
            display: block;
            animation: fadeIn 0.3s ease-in-out;
        }

        /* Next button */
        .btn-next {
            background-color: var(--primary-dark);
            color: white;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            width: 100%;
            text-align: center;
            margin-top: 1rem;
        }

        .btn-next:hover {
            background-color: var(--primary);
        }

        .btn-next:disabled {
            background-color: var(--gray-300);
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="p-5">
        <div class="w-64 h-16 mb-8">
            <div class="logo-container text-white p-4 inline-flex items-center">
                <div class="mr-2">
                    <div class="logo">
                        <div class="w-12 h-12 flex justify-center items-center font-bold text-white">TC</div>
                    </div>
                </div>
                <span class="text-2xl font-bold">Test Clinic</span>
            </div>
        </div>

        <div class="split-layout">
            <!-- Hero Section (Left Side) -->
            <div class="hero-section">
                <div class="hero-pattern"></div>
                <img src="<?= BASE_URL ?>/images/image-header.jpg" class="hero-image" alt="Medical Appointment">
                <div class="hero-content">
                    <h1 class="hero-title">Track Your Appointment</h1>
                    <p class="hero-subtitle">Enter your appointment tracking number to view your appointment details and
                        status</p>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-3">
                            <i class="bx bx-info-circle text-white text-xl"></i>
                        </div>
                        <p class="text-sm opacity-80">Your tracking number can be found in your confirmation email or
                            SMS</p>
                    </div>
                </div>
                <i class="bx bx-calendar-check hero-icon"></i>
            </div>

            <!-- Content Section (Right Side) -->
            <div class="content-section">
                <!-- Tracking Form -->
                <div class="tracking-form">
                    <h2 class="tracking-form-title">Enter Your Appointment Tracking Number</h2>
                    <form id="appointmentTrackingForm">
                        <div class="tracking-input-container mb-4">
                            <i class="bx bx-search tracking-input-icon text-xl"></i>
                            <input type="text" id="trackingNumber" class="search-input tracking-input"
                                placeholder="Enter your appointment tracking number (e.g., APP-12345)" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn-primary">
                                <i class="bx bx-calendar-search mr-2"></i> Track Appointment
                            </button>
                        </div>
                    </form>
                    <div id="errorMessage" class="error-message">
                        <i class="bx bx-error-circle mr-2"></i> We couldn't find an appointment with that tracking
                        number. Please check and try again.
                    </div>
                    <div id="successMessage" class="success-message">
                        <i class="bx bx-check-circle mr-2"></i> <span id="successMessageText"></span>
                    </div>
                </div>

                <!-- Loading Indicator -->
                <div id="loadingIndicator" class="loading-indicator">
                    <div class="spinner"></div>
                    <p class="mt-4 text-gray-600">Looking up your appointment...</p>
                </div>

                <!-- Results Section (initially hidden) -->
                <div id="resultsSection" class="results-section">
                    <!-- Appointment Status Card -->
                    <div class="appointment-card">
                        <div class="appointment-card-header">
                            <div>
                                <h2 class="text-xl font-bold text-gray-900">Appointment Details</h2>
                                <p class="text-sm text-gray-500">Appointment ID: <span
                                        id="appointmentId">APP-12345</span></p>
                            </div>
                            <span class="status-badge status-confirmed" id="statusBadge">
                                <i class="bx bx-check-circle mr-1"></i> Confirmed
                            </span>
                        </div>

                        <!-- Doctor Information -->
                        <div class="appointment-card-body">
                            <div class="doctor-card">
                                <div class="doctor-avatar avatar">
                                    <i class="bx bx-user text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800" id="doctorName">Dr. Sarah Johnson</h3>
                                    <p class="text-gray-600 text-sm" id="specialty">Cardiologist</p>
                                </div>
                            </div>

                            <!-- Appointment Information -->
                            <div class="info-grid">
                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <i class="bx bx-calendar"></i>
                                    </div>
                                    <div class="info-card-label">Date & Time</div>
                                    <div class="info-card-value" id="dateTime">May 15, 2023 at 10:00 AM</div>
                                </div>

                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <i class="bx bx-map"></i>
                                    </div>
                                    <div class="info-card-label">Location</div>
                                    <div class="info-card-value" id="location">Main Clinic, Room 101</div>
                                </div>

                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <i class="bx bx-clipboard"></i>
                                    </div>
                                    <div class="info-card-label">Reason for Visit</div>
                                    <div class="info-card-value" id="reason">Annual checkup</div>
                                </div>

                                <div class="info-card">
                                    <div class="info-card-icon">
                                        <i class="bx bx-time"></i>
                                    </div>
                                    <div class="info-card-label">Scheduled On</div>
                                    <div class="info-card-value" id="scheduledDate">May 10, 2023</div>
                                </div>
                            </div>

                            <!-- Timeline -->
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Appointment Status</h3>
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker completed">
                                            <i class="bx bx-check text-xs"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h4 class="text-sm font-medium text-gray-800">Appointment Scheduled</h4>
                                            <p class="text-xs text-gray-500" id="scheduledDateTimeline">May 10, 2023</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-marker completed" id="confirmedMarker">
                                            <i class="bx bx-check text-xs"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <h4 class="text-sm font-medium text-gray-800">Appointment Confirmed</h4>
                                            <p class="text-xs text-gray-500" id="confirmedDate">May 12, 2023</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-marker current" id="checkInMarker"></div>
                                        <div class="timeline-content">
                                            <h4 class="text-sm font-medium text-gray-800">Check-in</h4>
                                            <p class="text-xs text-gray-500" id="checkInDate">Pending</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-marker pending" id="completedMarker"></div>
                                        <div class="timeline-content">
                                            <h4 class="text-sm font-medium text-gray-800">Appointment Completed</h4>
                                            <p class="text-xs text-gray-500" id="completedDate">Pending</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="appointment-card-footer">
                            <div class="flex gap-2">
                                <button class="btn-secondary" id="rescheduleButton">
                                    <i class="bx bx-calendar-edit mr-2"></i> Reschedule
                                </button>
                                <div class="tooltip">
                                    <button class="btn-danger" id="cancelButton">
                                        <i class="bx bx-x-circle mr-2"></i> Cancel
                                    </button>
                                    <span class="tooltip-text" id="cancelTooltip">You can only cancel within 30 minutes
                                        of scheduling</span>
                                </div>
                            </div>
                            <button class="print-btn" id="printButton">
                                <i class="bx bx-printer"></i> Print Details
                            </button>
                        </div>
                    </div>

                    <!-- Preparation Instructions -->
                    <div class="preparation-list">
                        <h3 class="preparation-list-title">Preparation Instructions</h3>
                        <div class="preparation-item">
                            <div class="preparation-item-icon">
                                <i class="bx bx-id-card text-xs"></i>
                            </div>
                            <div class="preparation-item-text">Bring your insurance card and photo ID</div>
                        </div>
                        <div class="preparation-item">
                            <div class="preparation-item-icon">
                                <i class="bx bx-time text-xs"></i>
                            </div>
                            <div class="preparation-item-text">Arrive 15 minutes before your appointment time</div>
                        </div>
                        <div class="preparation-item">
                            <div class="preparation-item-icon">
                                <i class="bx bx-capsule text-xs"></i>
                            </div>
                            <div class="preparation-item-text">Bring a list of all current medications</div>
                        </div>
                        <div class="preparation-item">
                            <div class="preparation-item-icon">
                                <i class="bx bx-food-menu text-xs"></i>
                            </div>
                            <div class="preparation-item-text" id="specialInstructions">Fast for 8 hours before your
                                appointment (water is allowed)</div>
                        </div>
                        <div class="preparation-item">
                            <div class="preparation-item-icon">
                                <i class="bx bx-closet text-xs"></i>
                            </div>
                            <div class="preparation-item-text">Wear comfortable clothing</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reschedule Modal -->
    <div class="modal-overlay" id="rescheduleModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Select a Date & Time</h3>
                <button class="modal-close" id="closeRescheduleModal">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="calendar-date-picker">
                    <!-- Calendar Section -->
                    <div class="calendar-section">
                        <div class="calendar-month-nav">
                            <button class="calendar-nav-btn" id="prevMonth">
                                <i class="bx bx-chevron-left"></i>
                            </button>
                            <span class="calendar-month" id="currentMonth">March 2023</span>
                            <button class="calendar-nav-btn" id="nextMonth">
                                <i class="bx bx-chevron-right"></i>
                            </button>
                        </div>
                        <div class="calendar-grid" id="calendarDays">
                            <div class="calendar-day-header">SUN</div>
                            <div class="calendar-day-header">MON</div>
                            <div class="calendar-day-header">TUE</div>
                            <div class="calendar-day-header">WED</div>
                            <div class="calendar-day-header">THU</div>
                            <div class="calendar-day-header">FRI</div>
                            <div class="calendar-day-header">SAT</div>
                            <!-- Calendar days will be generated by JavaScript -->
                        </div>
                    </div>

                    <!-- Time Slots Section -->
                    <div class="time-section">
                        <div class="time-slots-container" id="timeSlotsContainer">
                            <h4 class="time-slots-title" id="selectedDateDisplay">Select a date</h4>
                            <div class="time-slots-list" id="timeSlots">
                                <!-- Time slots will be generated by JavaScript -->
                                <p class="text-center text-gray-500 py-4">Please select a date to view available time
                                    slots</p>
                            </div>
                        </div>
                        <button class="btn-next" id="confirmReschedule" disabled>Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Confirmation Modal -->
    <div class="modal-overlay confirmation-modal" id="cancelConfirmModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Cancel Appointment</h3>
                <button class="modal-close" id="closeCancelModal">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="confirmation-icon danger">
                    <i class="bx bx-error-circle"></i>
                </div>
                <h4 class="confirmation-title">Are you sure you want to cancel?</h4>
                <p class="confirmation-message">This action cannot be undone. Your appointment slot will be released and
                    made available to other patients.</p>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" id="cancelCancellation">No, Keep Appointment</button>
                <button class="btn-danger" id="confirmCancellation">Yes, Cancel Appointment</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const trackingForm = document.getElementById('appointmentTrackingForm');
            const trackingInput = document.getElementById('trackingNumber');
            const resultsSection = document.getElementById('resultsSection');
            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');
            const successMessageText = document.getElementById('successMessageText');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const printButton = document.getElementById('printButton');
            const rescheduleButton = document.getElementById('rescheduleButton');
            const cancelButton = document.getElementById('cancelButton');
            const cancelTooltip = document.getElementById('cancelTooltip');

            // Modal elements
            const rescheduleModal = document.getElementById('rescheduleModal');
            const closeRescheduleModal = document.getElementById('closeRescheduleModal');
            const confirmReschedule = document.getElementById('confirmReschedule');
            const cancelConfirmModal = document.getElementById('cancelConfirmModal');
            const closeCancelModal = document.getElementById('closeCancelModal');
            const cancelCancellation = document.getElementById('cancelCancellation');
            const confirmCancellation = document.getElementById('confirmCancellation');

            // Calendar elements
            const prevMonth = document.getElementById('prevMonth');
            const nextMonth = document.getElementById('nextMonth');
            const currentMonth = document.getElementById('currentMonth');
            const calendarDays = document.getElementById('calendarDays');
            const timeSlotsContainer = document.getElementById('timeSlotsContainer');
            const selectedDateDisplay = document.getElementById('selectedDateDisplay');
            const timeSlots = document.getElementById('timeSlots');

            // Sample appointment data (in a real application, this would come from the server)
            const sampleAppointments = {
                'APP-12345': {
                    id: 'APP-12345',
                    status: 'confirmed',
                    doctor: 'Dr. Sarah Johnson',
                    specialty: 'Cardiologist',
                    dateTime: 'May 15, 2023 at 10:00 AM',
                    location: 'Main Clinic, Room 101',
                    reason: 'Annual checkup',
                    scheduledDate: 'May 10, 2023',
                    scheduledTime: '2023-05-10T14:30:00', // ISO format for time calculations
                    confirmedDate: 'May 12, 2023',
                    checkInDate: 'Pending',
                    completedDate: 'Pending',
                    specialInstructions: 'Fast for 8 hours before your appointment (water is allowed)'
                },
                'APP-67890': {
                    id: 'APP-67890',
                    status: 'scheduled',
                    doctor: 'Dr. Michael Chen',
                    specialty: 'Neurologist',
                    dateTime: 'May 22, 2023 at 2:30 PM',
                    location: 'Neurology Center, Room 305',
                    reason: 'Follow-up consultation',
                    scheduledDate: 'May 5, 2023',
                    scheduledTime: '2023-05-05T09:15:00', // ISO format for time calculations
                    confirmedDate: 'Pending',
                    checkInDate: 'Pending',
                    completedDate: 'Pending',
                    specialInstructions: 'No special preparation required'
                },
                'APP-24680': {
                    id: 'APP-24680',
                    status: 'completed',
                    doctor: 'Dr. James Wilson',
                    specialty: 'Orthopedic Surgeon',
                    dateTime: 'April 30, 2023 at 11:00 AM',
                    location: 'Orthopedic Center, Room 405',
                    reason: 'Post-surgery follow-up',
                    scheduledDate: 'April 15, 2023',
                    scheduledTime: '2023-04-15T11:45:00', // ISO format for time calculations
                    confirmedDate: 'April 18, 2023',
                    checkInDate: 'April 30, 2023',
                    completedDate: 'April 30, 2023',
                    specialInstructions: 'Bring your previous X-rays and medical reports'
                }
            };

            // Current appointment being viewed
            let currentAppointment = null;

            // Calendar variables
            let currentDate = new Date();
            let selectedCalendarDate = null;
            let selectedTimeSlot = null;

            // Sample available time slots (in a real application, this would come from the server)
            const availableTimeSlots = {
                '2023-03-18': ['2:00pm', '2:30pm', '3:00pm', '3:30pm', '4:00pm'],
                '2023-03-20': ['9:00am', '9:30am', '10:00am', '10:30am', '11:00am'],
                '2023-03-22': ['2:00pm', '2:30pm', '3:00pm', '3:30pm', '4:00pm'],
                '2023-03-24': ['1:00pm', '1:30pm', '2:00pm', '2:30pm'],
                '2023-03-26': ['10:00am', '10:30am', '11:00am', '11:30am'],
                '2023-03-28': ['9:00am', '9:30am', '3:00pm', '3:30pm', '4:00pm'],
                '2023-04-01': ['9:00am', '9:30am', '10:00am', '10:30am', '11:00am', '2:00pm', '2:30pm'],
                '2023-04-03': ['9:00am', '9:30am', '10:00am', '2:00pm', '2:30pm'],
                '2023-04-05': ['10:00am', '10:30am', '11:00am', '3:00pm', '3:30pm'],
                '2023-04-07': ['9:00am', '9:30am', '2:00pm', '2:30pm', '3:00pm'],
                '2023-04-10': ['11:00am', '11:30am', '1:00pm', '1:30pm', '2:00pm', '2:30pm'],
                '2023-04-12': ['9:00am', '9:30am', '10:00am', '10:30am', '11:00am', '11:30am'],
                '2023-04-14': ['10:00am', '10:30am', '11:00am', '1:00pm', '1:30pm', '2:00pm']
            };

            // Handle form submission
            trackingForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const trackingNumber = trackingInput.value.trim();

                // Hide error and success messages if they were previously shown
                errorMessage.classList.remove('visible');
                successMessage.classList.remove('visible');

                // Show loading indicator
                loadingIndicator.classList.add('visible');

                // Hide results if they were previously shown
                resultsSection.classList.remove('visible');

                // Simulate server request delay
                setTimeout(function () {
                    // Hide loading indicator
                    loadingIndicator.classList.remove('visible');

                    // Check if appointment exists
                    if (sampleAppointments[trackingNumber]) {
                        // Store current appointment
                        currentAppointment = sampleAppointments[trackingNumber];

                        // Populate appointment details
                        populateAppointmentDetails(currentAppointment);

                        // Show results
                        resultsSection.classList.add('visible');

                        // Scroll to results
                        resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    } else {
                        // Show error message
                        errorMessage.classList.add('visible');
                    }
                }, 1500); // Simulate 1.5 second delay
            });

            // Function to populate appointment details
            function populateAppointmentDetails(appointment) {
                // Basic details
                document.getElementById('appointmentId').textContent = appointment.id;
                document.getElementById('doctorName').textContent = appointment.doctor;
                document.getElementById('specialty').textContent = appointment.specialty;
                document.getElementById('dateTime').textContent = appointment.dateTime;
                document.getElementById('location').textContent = appointment.location;
                document.getElementById('reason').textContent = appointment.reason;
                document.getElementById('specialInstructions').textContent = appointment.specialInstructions;

                // Timeline dates
                document.getElementById('scheduledDate').textContent = appointment.scheduledDate;
                document.getElementById('scheduledDateTimeline').textContent = appointment.scheduledDate;
                document.getElementById('confirmedDate').textContent = appointment.confirmedDate;
                document.getElementById('checkInDate').textContent = appointment.checkInDate;
                document.getElementById('completedDate').textContent = appointment.completedDate;

                // Status badge
                const statusBadge = document.getElementById('statusBadge');
                statusBadge.className = 'status-badge';

                // Set status badge based on appointment status
                if (appointment.status === 'scheduled') {
                    statusBadge.classList.add('status-scheduled');
                    statusBadge.innerHTML = '<i class="bx bx-time mr-1"></i> Scheduled';

                    // Update timeline markers
                    document.getElementById('confirmedMarker').className = 'timeline-marker pending';
                    document.getElementById('checkInMarker').className = 'timeline-marker pending';
                    document.getElementById('completedMarker').className = 'timeline-marker pending';
                } else if (appointment.status === 'confirmed') {
                    statusBadge.classList.add('status-confirmed');
                    statusBadge.innerHTML = '<i class="bx bx-check-circle mr-1"></i> Confirmed';

                    // Update timeline markers
                    document.getElementById('confirmedMarker').className = 'timeline-marker completed';
                    document.getElementById('confirmedMarker').innerHTML = '<i class="bx bx-check text-xs"></i>';
                    document.getElementById('checkInMarker').className = 'timeline-marker current';
                    document.getElementById('completedMarker').className = 'timeline-marker pending';
                } else if (appointment.status === 'completed') {
                    statusBadge.classList.add('status-completed');
                    statusBadge.innerHTML = '<i class="bx bx-check-double mr-1"></i> Completed';

                    // Update timeline markers
                    document.getElementById('confirmedMarker').className = 'timeline-marker completed';
                    document.getElementById('confirmedMarker').innerHTML = '<i class="bx bx-check text-xs"></i>';
                    document.getElementById('checkInMarker').className = 'timeline-marker completed';
                    document.getElementById('checkInMarker').innerHTML = '<i class="bx bx-check text-xs"></i>';
                    document.getElementById('completedMarker').className = 'timeline-marker completed';
                    document.getElementById('completedMarker').innerHTML = '<i class="bx bx-check text-xs"></i>';
                }

                // Check if cancellation is allowed (within 30 minutes of scheduling)
                const scheduledTime = new Date(appointment.scheduledTime);
                const currentTime = new Date();
                const timeDifference = (currentTime - scheduledTime) / (1000 * 60); // difference in minutes

                if (timeDifference <= 30 && appointment.status !== 'completed') {
                    cancelButton.classList.remove('btn-disabled');
                    cancelButton.classList.add('btn-danger');
                    cancelButton.disabled = false;
                    cancelTooltip.textContent = "You can cancel your appointment";
                } else {
                    cancelButton.classList.remove('btn-danger');
                    cancelButton.classList.add('btn-disabled');
                    cancelButton.disabled = true;
                    cancelTooltip.textContent = "You can only cancel within 30 minutes of scheduling";
                }

                // Check if reschedule is allowed (not for completed appointments)
                if (appointment.status === 'completed') {
                    rescheduleButton.classList.remove('btn-secondary');
                    rescheduleButton.classList.add('btn-disabled');
                    rescheduleButton.disabled = true;
                } else {
                    rescheduleButton.classList.remove('btn-disabled');
                    rescheduleButton.classList.add('btn-secondary');
                    rescheduleButton.disabled = false;
                }
            }

            // Handle print button click
            printButton.addEventListener('click', function () {
                window.print();
            });

            // Handle reschedule button click
            rescheduleButton.addEventListener('click', function () {
                // Reset calendar selection
                selectedCalendarDate = null;
                selectedTimeSlot = null;
                confirmReschedule.disabled = true;

                // Reset time slots display
                selectedDateDisplay.textContent = "Select a date";
                timeSlots.innerHTML = '<p class="text-center text-gray-500 py-4">Please select a date to view available time slots</p>';

                // Set current date to March 2023 for demo purposes
                currentDate = new Date(2023, 2, 1); // March 2023

                // Update calendar
                updateCalendar();

                // Show reschedule modal
                rescheduleModal.classList.add('visible');
            });

            // Handle cancel button click
            cancelButton.addEventListener('click', function () {
                if (!cancelButton.disabled) {
                    cancelConfirmModal.classList.add('visible');
                }
            });

            // Close reschedule modal
            closeRescheduleModal.addEventListener('click', function () {
                rescheduleModal.classList.remove('visible');
            });

            // Close cancel confirmation modal
            closeCancelModal.addEventListener('click', function () {
                cancelConfirmModal.classList.remove('visible');
            });

            cancelCancellation.addEventListener('click', function () {
                cancelConfirmModal.classList.remove('visible');
            });

            // Confirm reschedule
            confirmReschedule.addEventListener('click', function () {
                if (selectedCalendarDate && selectedTimeSlot) {
                    // Format the selected date
                    const formattedDate = formatDate(selectedCalendarDate);

                    // In a real application, you would send this data to the server
                    // For now, we'll just show a success message
                    successMessageText.textContent = `Your appointment has been submitted for rescheduling to ${formattedDate} at ${selectedTimeSlot}. You will receive a confirmation soon.`;

                    // Hide modals
                    rescheduleModal.classList.remove('visible');

                    // Show success message
                    successMessage.classList.add('visible');

                    // Scroll to top
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            // Confirm cancellation
            confirmCancellation.addEventListener('click', function () {
                // In a real application, you would send this data to the server
                // For now, we'll just show a success message
                successMessageText.textContent = 'Your appointment has been cancelled successfully.';

                // Hide modals
                cancelConfirmModal.classList.remove('visible');

                // Show success message
                successMessage.classList.add('visible');

                // Hide results
                resultsSection.classList.remove('visible');

                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Calendar navigation
            prevMonth.addEventListener('click', function () {
                currentDate.setMonth(currentDate.getMonth() - 1);
                updateCalendar();
            });

            nextMonth.addEventListener('click', function () {
                currentDate.setMonth(currentDate.getMonth() + 1);
                updateCalendar();
            });

            // Function to update calendar
            function updateCalendar() {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                // Update month display
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                currentMonth.textContent = `${monthNames[month]} ${year}`;

                // Clear calendar days
                while (calendarDays.children.length > 7) { // Keep the header row
                    calendarDays.removeChild(calendarDays.lastChild);
                }

                // Get first day of month and total days
                const firstDay = new Date(year, month, 1).getDay();
                const totalDays = new Date(year, month + 1, 0).getDate();

                // Add empty cells for days before first day of month
                for (let i = 0; i < firstDay; i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.classList.add('calendar-day', 'empty');
                    calendarDays.appendChild(emptyDay);
                }

                // Add days of month
                const today = new Date();
                for (let day = 1; day <= totalDays; day++) {
                    const dayElement = document.createElement('div');
                    dayElement.classList.add('calendar-day');
                    dayElement.textContent = day;

                    const currentDateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                    // Check if this date has available slots
                    if (availableTimeSlots[currentDateString]) {
                        dayElement.classList.add('has-slots');
                    }

                    // Check if this is today
                    if (today.getFullYear() === year && today.getMonth() === month && today.getDate() === day) {
                        dayElement.classList.add('today');
                    }

                    // Check if this date is in the past
                    const checkDate = new Date(year, month, day);
                    if (checkDate < new Date(today.getFullYear(), today.getMonth(), today.getDate())) {
                        dayElement.classList.add('disabled');
                    } else {
                        // Add click event for future dates
                        dayElement.addEventListener('click', function () {
                            if (dayElement.classList.contains('has-slots')) {
                                // Remove selected class from all days
                                document.querySelectorAll('.calendar-day.selected').forEach(el => {
                                    el.classList.remove('selected');
                                });

                                // Add selected class to clicked day
                                dayElement.classList.add('selected');

                                // Store selected date
                                selectedCalendarDate = new Date(year, month, day);

                                // Update selected date display
                                const dayOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][selectedCalendarDate.getDay()];
                                selectedDateDisplay.textContent = `${dayOfWeek}, ${monthNames[month]} ${day}`;

                                // Show time slots for selected date
                                showTimeSlots(currentDateString);
                            }
                        });
                    }

                    // Check if this is the selected date
                    if (selectedCalendarDate &&
                        selectedCalendarDate.getFullYear() === year &&
                        selectedCalendarDate.getMonth() === month &&
                        selectedCalendarDate.getDate() === day) {
                        dayElement.classList.add('selected');
                    }

                    calendarDays.appendChild(dayElement);
                }
            }

            // Function to show time slots for selected date
            function showTimeSlots(dateString) {
                // Clear time slots
                timeSlots.innerHTML = '';

                // Get available slots for selected date
                const slots = availableTimeSlots[dateString] || [];

                if (slots.length > 0) {
                    // Create time slot elements
                    slots.forEach(slot => {
                        const slotElement = document.createElement('div');
                        slotElement.classList.add('time-slot');
                        slotElement.textContent = slot;

                        slotElement.addEventListener('click', function () {
                            // Remove selected class from all time slots
                            document.querySelectorAll('.time-slot.selected').forEach(el => {
                                el.classList.remove('selected');
                            });

                            // Add selected class to clicked time slot
                            slotElement.classList.add('selected');

                            // Store selected time slot
                            selectedTimeSlot = slot;

                            // Enable confirm button
                            confirmReschedule.disabled = false;
                        });

                        // Check if this is the selected time slot
                        if (selectedTimeSlot === slot) {
                            slotElement.classList.add('selected');
                        }

                        timeSlots.appendChild(slotElement);
                    });
                } else {
                    // No available slots for this date
                    timeSlots.innerHTML = '<p class="text-center text-gray-500 py-4">No available time slots for this date.</p>';
                }
            }

            // Helper function to format date
            function formatDate(date) {
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                const dayOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][date.getDay()];
                return `${dayOfWeek}, ${monthNames[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
            }
        });
    </script>
</body>

</html>