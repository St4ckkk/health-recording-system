<div id="toast-container" class="fixed bottom-4 right-4 z-50 flex flex-col gap-2 max-w-xs"></div>

<style>
    /* Toast container */
    #toast-container {
        pointer-events: none;
    }

    /* Toast alert styles */
    .toast {
        pointer-events: auto;
        display: flex;
        align-items: center;
        padding: 0.8rem 0.75rem;
        border-radius: 0.375rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        margin-bottom: 0.5rem;
        transform: translateX(200%);
        opacity: 0;
        transition: all 0.3s ease;
        max-width: 100%;
        position: relative;
        overflow: hidden;
        margin-top: 10px;
    }

    .toast.show {
        transform: translateX(800px);
        opacity: 1;
    }

    /* Toast types */
    .toast-success {
        background-color: #ecfdf5;
        border-left: 4px solid #10b981;
        color: #065f46;
    }

    .toast-error {
        background-color: #fef2f2;
        border-left: 4px solid #ef4444;
        color: #991b1b;
    }

    .toast-info {
        background-color: #eff6ff;
        border-left: 4px solid #3b82f6;
        color: #1e40af;
    }

    .toast-warning {
        background-color: #fffbeb;
        border-left: 4px solid #f59e0b;
        color: #92400e;
    }

    /* Toast elements */
    .toast-icon {
        margin-right: 0.75rem;
        flex-shrink: 0;
    }

    .toast-content {
        flex-grow: 1;
    }

    .toast-message {
        font-size: 0.875rem;
        font-weight: 500;
    }

    .toast-close {
        margin-left: 0.75rem;
        cursor: pointer;
        color: currentColor;
        opacity: 0.7;
        transition: opacity 0.2s;
        flex-shrink: 0;
    }

    .toast-close:hover {
        opacity: 1;
    }

    /* Progress bar animation */
    @keyframes progress {
        0% {
            width: 100%;
        }

        100% {
            width: 0%;
        }
    }

    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background-color: rgba(0, 0, 0, 0.1);
        animation: progress 5s linear forwards;
    }
</style>

<script>
    // Toast system
    const toastSystem = {
        container: null,

        init: function () {
            this.container = document.getElementById('toast-container');
            if (!this.container) {
                console.error('Toast container not found');
                return;
            }
        },

        // Show a toast with options
        show: function (message, type = 'info', duration = 5000) {
            if (!this.container) this.init();

            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;

            // Set icon based on type
            let iconClass = '';
            switch (type) {
                case 'success':
                    iconClass = 'bx bx-check-circle';
                    break;
                case 'error':
                    iconClass = 'bx bx-x-circle';
                    break;
                case 'warning':
                    iconClass = 'bx bx-error';
                    break;
                case 'info':
                default:
                    iconClass = 'bx bx-info-circle';
                    break;
            }

            // Build toast content
            toast.innerHTML = `
                <div class="toast-icon">
                    <i class="${iconClass} text-lg"></i>
                </div>
                <div class="toast-content">
                    <div class="toast-message">${message}</div>
                </div>
                <div class="toast-close">
                    <i class="bx bx-x"></i>
                </div>
                <div class="toast-progress"></div>
            `;

            // Add to container
            this.container.appendChild(toast);

            // Show with animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);

            // Set up close button
            const closeBtn = toast.querySelector('.toast-close');
            closeBtn.addEventListener('click', () => {
                this.close(toast);
            });

            // Auto close after duration
            if (duration > 0) {
                setTimeout(() => {
                    this.close(toast);
                }, duration);
            }

            return toast;
        },

        // Close a toast
        close: function (toast) {
            toast.classList.remove('show');

            // Remove after animation completes
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        },

        // Shorthand methods for different toast types
        success: function (message, duration) {
            return this.show(message, 'success', duration);
        },

        error: function (message, duration) {
            return this.show(message, 'error', duration);
        },

        info: function (message, duration) {
            return this.show(message, 'info', duration);
        },

        warning: function (message, duration) {
            return this.show(message, 'warning', duration);
        }
    };

    // Initialize toast system
    document.addEventListener('DOMContentLoaded', function () {
        toastSystem.init();
    });
</script>