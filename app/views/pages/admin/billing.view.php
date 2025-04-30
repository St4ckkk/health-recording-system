<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/boxicons/css/boxicons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/globals.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/reception.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/dashboard.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/badges.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/output.css">
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/flatpickr/dist/l10n/fr.js"></script>
    <script src="<?= BASE_URL ?>/node_modules/chart.js/dist/chart.umd.js"></script>
    <style>
        .action-button i {
            margin-right: 0.25rem;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 1rem;
            height: 1rem;
            vertical-align: middle;
        }

        .action-buttons-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-width: 80px;
            padding: 0.15rem 0.5rem;
            border-radius: 0.375rem;
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px 8px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.7rem;
            white-space: nowrap;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .action-button.secondary {
            background-color: var(--neutral-light);
            color: var(--neutral-dark);
            border: 1px solid var(--neutral-light);
        }

        .action-button.secondary:hover {
            background-color: var(--neutral-lighter);
        }

        .action-button.danger {
            background-color: transparent;
            color: var(--danger-dark);
            border: 1px solid var(--danger);
        }

        .action-button.danger:hover {
            background-color: var(--danger-light);
        }

        .action-button.view {
            background-color: transparent;
            color: var(--info-dark);
            border: 1px solid var(--info);
        }

        .action-button.view:hover {
            background-color: var(--info-light);
        }

        .action-button.edit {
            background-color: transparent;
            color: var(--warning-dark);
            border: 1px solid var(--warning);
        }

        .action-button.edit:hover {
            background-color: var(--warning-light);
        }

        .action-button.delete {
            background-color: transparent;
            color: var(--danger-dark);
            border: 1px solid var(--danger-dark);
        }

        .action-button.delete:hover {
            background-color: var(--danger-lighter);
        }

        /* Admin theme colors */
        .admin-primary {
            background-color: #4f46e5;
            color: white;
        }

        .admin-primary:hover {
            background-color: #4338ca;
        }

        .admin-secondary {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .admin-secondary:hover {
            background-color: #e5e7eb;
        }
    </style>
</head>

<body class="font-body">
    <div class="flex">
        <?php include(VIEW_ROOT . '/pages/admin/components/sidebar.php') ?>
        <main class="flex-1 main-content">
            <?php include(VIEW_ROOT . '/pages/admin/components/header.php') ?>
            <div class="content-wrapper">
                <section class="p-6">
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Billing Records</h2>
                            <p class="text-sm text-gray-500">
                                View and manage all patient billing records.
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <button
                                class="px-4 py-2 admin-secondary rounded-md text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200">
                                <i class='bx bx-filter-alt mr-1'></i> Filter
                            </button>
                            <button
                                class="px-4 py-2 admin-secondary rounded-md text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200">
                                <i class='bx bx-export mr-1'></i> Export
                            </button>
                        </div>
                    </div>

                    <!-- Billing Records Table -->
                    <div class="card bg-white shadow-sm rounded-lg w-full fade-in">
                        <div class="p-4">
                            <table class="appointments-table">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Service</th>
                                        <th>Amount</th>
                                        <th>Billing Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($billingRecords)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center py-4">No billing records found</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($billingRecords as $billing): ?>
                                            <tr class="border-b border-gray-200">
                                                <td class="py-3 px-4">
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-md">
                                                            <?= htmlspecialchars($billing->patient_first_name . ' ' . $billing->patient_last_name) ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <div class="flex flex-col">
                                                        <span class="font-medium text-md">
                                                            <?= htmlspecialchars($billing->service_type) ?>
                                                        </span>
                                                        <span class="text-xs text-gray-500">
                                                            <?= htmlspecialchars($billing->description) ?>
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-4">₱<?= number_format($billing->amount, 2) ?></td>
                                                <td class="py-3 px-4"><?= date('M d, Y', strtotime($billing->billing_date)) ?>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <?= date('M d, Y', strtotime($billing->due_date)) ?>
                                                    <?php
                                                    $today = new DateTime();
                                                    $dueDate = new DateTime($billing->due_date);
                                                    $diff = $today->diff($dueDate);

                                                    if ($billing->status !== 'paid' && $today > $dueDate) {
                                                        echo '<span class="ml-2 text-xs px-2 py-1 bg-red-100 text-red-800 rounded-full">Overdue</span>';
                                                    } elseif ($billing->status !== 'paid' && $diff->days <= 3) {
                                                        echo '<span class="ml-2 text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Due soon</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <span class="status-badge <?php
                                                    switch (strtolower($billing->status)) {
                                                        case 'paid':
                                                            echo 'bg-green-100 text-green-800 border border-green-200';
                                                            break;
                                                        case 'pending':
                                                            echo 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                                                            break;
                                                        case 'cancelled':
                                                            echo 'bg-red-100 text-red-800 border border-red-200';
                                                            break;
                                                        case 'partial':
                                                            echo 'bg-blue-100 text-blue-800 border border-blue-200';
                                                            break;
                                                        case 'refunded':
                                                            echo 'bg-purple-100 text-purple-800 border border-purple-200';
                                                            break;
                                                        default:
                                                            echo 'bg-gray-100 text-gray-800 border border-gray-200';
                                                    }
                                                    ?>">
                                                        <?= ucfirst(htmlspecialchars($billing->status)) ?>
                                                    </span>
                                                </td>
                                                <td class="py-3 px-4">
                                                    <div class="action-buttons-container">
                                                        <div class="tooltip">
                                                            <button class="p-2 text-blue-600 hover:text-blue-800"
                                                                onclick="viewBilling(<?= $billing->id ?>)">
                                                                <i class="bx bx-show text-lg"></i>
                                                                <span class="tooltip-text">View Details</span>
                                                            </button>
                                                        </div>
                                                        <?php if (strtolower($billing->status) === 'pending'): ?>
                                                            <div class="tooltip">
                                                                <button class="p-2 text-yellow-600 hover:text-yellow-800"
                                                                    onclick="updateBillingStatus(<?= $billing->id ?>, 'paid')">
                                                                    <i class="bx bx-check text-lg"></i>
                                                                    <span class="tooltip-text">Mark Paid</span>
                                                                </button>
                                                            </div>
                                                            <div class="tooltip">
                                                                <button class="p-2 text-red-600 hover:text-red-800"
                                                                    onclick="updateBillingStatus(<?= $billing->id ?>, 'cancelled')">
                                                                    <i class="bx bx-x text-lg"></i>
                                                                    <span class="tooltip-text">Cancel</span>
                                                                </button>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Add this CSS to your existing styles section -->
                    <style>
                        .appointments-table {
                            width: 100%;
                        }

                        .appointments-table thead th {
                            background-color: rgb(37 99 235);
                            color: white;
                            font-weight: 500;
                            padding: 0.75rem 1rem;
                            text-align: left;
                            border-bottom: 1px solid #e5e7eb;
                        }

                        .appointments-table tbody td {
                            vertical-align: middle;
                        }

                        .card {
                            transition: all 0.3s ease;
                        }

                        .fade-in {
                            animation: fadeIn 0.5s ease-in;
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
                    </style>
                </section>
            </div>
        </main>
    </div>

    <!-- View Billing Modal (Hidden by default) -->
    <div id="viewBillingModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
        <div
            class="w-full max-w-2xl transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900">Billing Details</h3>
                    <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>
                <div id="billingDetails" class="space-y-4">
                    <!-- Billing details will be loaded here via JavaScript -->
                    <div class="flex justify-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-500"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const BASE_URL = '<?= BASE_URL ?>';

        // Function to view billing details
        function viewBilling(id) {
            const modal = document.getElementById('viewBillingModal');
            const detailsContainer = document.getElementById('billingDetails');

            // Show modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95', 'opacity-0');
                modal.querySelector('.transform').classList.add('scale-100', 'opacity-100');
            }, 10);

            // Show loading spinner
            detailsContainer.innerHTML = `
                <div class="flex justify-center">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-500"></div>
                </div>
            `;

            // Load billing details - Change this line to use query parameter
            fetch(`${BASE_URL}/admin/getBillingDetails?id=${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`Server returned ${response.status}: ${response.statusText}`);
                    }
                    return response.text().then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            console.error('Invalid JSON response:', text);
                            throw new Error('Server returned invalid JSON. See console for details.');
                        }
                    });
                })
                .then(data => {
                    if (data.success) {
                        const billing = data.billing;
                        detailsContainer.innerHTML = `
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Patient</p>
                                    <p class="font-medium">${billing.patient_first_name} ${billing.patient_last_name}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Staff</p>
                                    <p class="font-medium">${billing.staff_first_name} ${billing.staff_last_name}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Service Type</p>
                                    <p class="font-medium">${billing.service_type}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Description</p>
                                    <p class="font-medium">${billing.description}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Amount</p>
                                    <p class="font-medium">₱${parseFloat(billing.amount).toFixed(2)}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Status</p>
                                    <p class="font-medium">${billing.status}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Billing Date</p>
                                    <p class="font-medium">${new Date(billing.billing_date).toLocaleDateString()}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Due Date</p>
                                    <p class="font-medium">${new Date(billing.due_date).toLocaleDateString()}</p>
                                </div>
                                ${billing.appointment_date ? `
                                <div>
                                    <p class="text-sm text-gray-500">Appointment Date</p>
                                    <p class="font-medium">${new Date(billing.appointment_date).toLocaleDateString()}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Appointment Time</p>
                                    <p class="font-medium">${billing.appointment_time}</p>
                                </div>` : ''}
                                ${billing.notes ? `
                                <div class="col-span-2">
                                    <p class="text-sm text-gray-500">Notes</p>
                                    <p class="font-medium">${billing.notes}</p>
                                </div>` : ''}
                            </div>
                            
                            ${billing.status === 'pending' ? `
                            <div class="mt-6 flex justify-end space-x-3">
                                <button onclick="updateBillingStatus(${billing.id}, 'paid')" 
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                    <i class='bx bx-check mr-1'></i> Mark as Paid
                                </button>
                                <button onclick="updateBillingStatus(${billing.id}, 'cancelled')" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                    <i class='bx bx-x mr-1'></i> Cancel
                                </button>
                            </div>` : ''}
                        `;
                    } else {
                        detailsContainer.innerHTML = `<p class="text-center text-red-500">${data.message}</p>`;
                    }
                })
                .catch(error => {
                    detailsContainer.innerHTML = `
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg">
                            <div class="font-medium">Error loading billing details</div>
                            <div>${error.message}</div>
                            <div class="mt-2 text-xs">Please try again or contact the system administrator.</div>
                        </div>
                    `;
                    console.error('Error fetching billing details:', error);
                });
        }

        // Function to update billing status
        function updateBillingStatus(id, status) {
            if (!confirm(`Are you sure you want to mark this billing as ${status}?`)) {
                return;
            }

            fetch(`${BASE_URL}/admin/updateBillingStatus`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id, status })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('success', 'Success', data.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showToast('error', 'Error', data.message);
                    }
                })
                .catch(error => {
                    showToast('error', 'Error', `Failed to update status: ${error.message}`);
                });
        }

        // Close modal when clicking the close button or outside the modal
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.getElementById('viewBillingModal');
                modal.querySelector('.transform').classList.add('scale-95', 'opacity-0');
                modal.querySelector('.transform').classList.remove('scale-100', 'opacity-100');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300);
            });
        });

        // Toast notification function
        window.showToast = (type, title, message) => {
            const toast = document.createElement('div')
            toast.className = `fixed top-4 right-4 z-50 flex items-start p-4 mb-4 w-full max-w-xs rounded-lg shadow-lg ${type === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'} fade-in`

            toast.innerHTML = `
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg ${type === 'success' ? 'bg-green-100 text-green-500' : 'bg-red-100 text-red-800'}">
                    <i class="bx ${type === 'success' ? 'bx-check' : 'bx-x'} text-xl"></i>
                </div>
                <div class="ml-3 text-sm font-normal">
                    <span class="mb-1 text-sm font-semibold">${title}</span>
                    <div class="mb-2 text-sm">${message}</div>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 ${type === 'success' ? 'text-green-500 hover:bg-green-100' : 'text-red-500 hover:bg-red-100'}" aria-label="Close">
                    <i class="bx bx-x text-lg"></i>
                </button>
            `

            document.body.appendChild(toast)

            // Add click event to close button
            toast.querySelector('button').addEventListener('click', () => {
                toast.remove()
            })

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    toast.classList.add('fade-out')
                    setTimeout(() => {
                        if (document.body.contains(toast)) {
                            toast.remove()
                        }
                    }, 300)
                }
            }, 5000)
        }
    </script>
</body>

</html