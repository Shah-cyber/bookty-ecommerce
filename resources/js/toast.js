/**
 * Flowbite Toast Notification System
 * Replaces Notyf and custom toast implementations
 */

class ToastManager {
    constructor() {
        this.container = null;
        this.toastCount = 0;
        this.defaultDuration = 4000; // 4 seconds
        this.forceTheme = null; // Can be 'light', 'dark', or null for auto-detection
        this.init();
    }

    init() {
        // Detect layout type and set appropriate theme
        this.detectAndSetLayoutTheme();
        // Create toast container if it doesn't exist
        this.createContainer();
        // Set up event listeners for dismiss buttons
        this.setupEventListeners();
        // Set up theme change listeners
        this.setupThemeListeners();
    }

    createContainer() {
        if (this.container) return;
        
        this.container = document.createElement('div');
        this.container.id = 'toast-container';
        
        // Use inline styles to ensure visibility regardless of CSS loading order
        Object.assign(this.container.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            zIndex: '10001',
            maxWidth: '320px',
            display: 'flex',
            flexDirection: 'column',
            gap: '16px',
            pointerEvents: 'none'
        });
        
        // Also add Tailwind classes as fallback
        this.container.className = 'fixed top-5 right-5 z-[10001] space-y-4';
        
        document.body.appendChild(this.container);
        
        // Debug: Log container creation
        console.log('Toast container created:', this.container);
    }

    setupEventListeners() {
        // Use event delegation for dismiss buttons
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-dismiss-toast]') || e.target.closest('[data-dismiss-toast]')) {
                const button = e.target.matches('[data-dismiss-toast]') ? e.target : e.target.closest('[data-dismiss-toast]');
                const toastId = button.getAttribute('data-dismiss-toast');
                this.dismiss(toastId);
            }
        });
    }

    /**
     * Show a toast notification
     * @param {string} message - The message to display
     * @param {string} type - The type of toast (success, error, warning, info)
     * @param {number} duration - How long to show the toast (0 = don't auto-hide)
     * @param {boolean} dismissible - Whether to show close button
     */
    show(message, type = 'success', duration = null, dismissible = true) {
        if (!message) return;

        // Generate unique ID for this toast
        const toastId = `toast-${Date.now()}-${++this.toastCount}`;
        
        // Create toast element
        const toast = this.createToastElement(toastId, type, message, dismissible);
        
        // Add to container
        this.container.appendChild(toast);
        
        // Debug: Log toast creation and container state
        console.log('Toast created and added to container:', {
            toastId: toastId,
            message: message,
            type: type,
            containerChildren: this.container.children.length,
            containerVisible: this.container.offsetParent !== null,
            containerPosition: {
                top: this.container.style.top,
                right: this.container.style.right,
                zIndex: this.container.style.zIndex
            }
        });
        
        // Animate in
        requestAnimationFrame(() => {
            toast.style.transform = 'translateX(0)';
            toast.style.opacity = '1';
            console.log('Toast animated in:', toastId);
        });

        // Auto-dismiss if duration is set
        const finalDuration = duration !== null ? duration : this.defaultDuration;
        if (finalDuration > 0) {
            setTimeout(() => {
                this.dismiss(toastId);
            }, finalDuration);
        }

        return toastId;
    }

    createToastElement(id, type, message, dismissible) {
        // Check if dark mode is active
        const isDarkMode = this.isDarkModeActive();
        
        const typeConfig = {
            success: {
                containerClass: 'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>',
                srText: 'Check icon',
                lightColors: { bg: '#f0fdf4', text: '#065f46', iconBg: '#dcfce7', iconText: '#16a34a' },
                darkColors: { bg: '#1f2937', text: '#d1fae5', iconBg: '#065f46', iconText: '#34d399' }
            },
            error: {
                containerClass: 'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>',
                srText: 'Error icon',
                lightColors: { bg: '#fef2f2', text: '#7f1d1d', iconBg: '#fecaca', iconText: '#dc2626' },
                darkColors: { bg: '#1f2937', text: '#fecaca', iconBg: '#7f1d1d', iconText: '#f87171' }
            },
            warning: {
                containerClass: 'text-orange-500 bg-orange-100 dark:bg-orange-700 dark:text-orange-200',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>',
                srText: 'Warning icon',
                lightColors: { bg: '#fffbeb', text: '#92400e', iconBg: '#fed7aa', iconText: '#ea580c' },
                darkColors: { bg: '#1f2937', text: '#fed7aa', iconBg: '#92400e', iconText: '#fb923c' }
            },
            info: {
                containerClass: 'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200',
                icon: '<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>',
                srText: 'Info icon',
                lightColors: { bg: '#eff6ff', text: '#1e40af', iconBg: '#dbeafe', iconText: '#2563eb' },
                darkColors: { bg: '#1f2937', text: '#dbeafe', iconBg: '#1e40af', iconText: '#60a5fa' }
            }
        };

        const config = typeConfig[type] || typeConfig.success;
        const colors = isDarkMode ? config.darkColors : config.lightColors;

        const toast = document.createElement('div');
        toast.id = id;
        toast.className = 'toast-notification flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800 transform transition-all duration-300 ease-out';
        
        // Add dynamic inline styles that support dark mode
        Object.assign(toast.style, {
            transform: 'translateX(100%)',
            opacity: '0',
            pointerEvents: 'auto',
            boxShadow: isDarkMode 
                ? '0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2)'
                : '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
            backgroundColor: colors.bg,
            color: colors.text,
            borderRadius: '8px',
            padding: '16px',
            display: 'flex',
            alignItems: 'center',
            width: '100%',
            maxWidth: '320px',
            marginBottom: '16px',
            transition: 'all 0.3s ease-out',
            border: isDarkMode ? '1px solid #374151' : '1px solid #e5e7eb'
        });
        
        toast.setAttribute('role', 'alert');

        // Create icon wrapper with dynamic styling
        const iconWrapper = document.createElement('div');
        iconWrapper.className = `inline-flex items-center justify-center shrink-0 w-8 h-8 ${config.containerClass} rounded-lg`;
        Object.assign(iconWrapper.style, {
            backgroundColor: colors.iconBg,
            color: colors.iconText,
            borderRadius: '8px',
            width: '32px',
            height: '32px',
            display: 'inline-flex',
            alignItems: 'center',
            justifyContent: 'center',
            flexShrink: '0'
        });

        iconWrapper.innerHTML = `
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                ${config.icon}
            </svg>
            <span class="sr-only">${config.srText}</span>
        `;

        // Create message container
        const messageContainer = document.createElement('div');
        messageContainer.className = 'ms-3 text-sm font-normal';
        messageContainer.style.marginLeft = '12px';
        messageContainer.style.fontSize = '14px';
        messageContainer.style.fontWeight = 'normal';
        messageContainer.innerHTML = this.escapeHtml(message);

        // Append elements to toast
        toast.appendChild(iconWrapper);
        toast.appendChild(messageContainer);

        // Add dismiss button if dismissible
        if (dismissible) {
            const dismissBtn = document.createElement('button');
            dismissBtn.type = 'button';
            dismissBtn.className = 'ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700';
            dismissBtn.setAttribute('data-dismiss-toast', id);
            dismissBtn.setAttribute('aria-label', 'Close');
            
            // Apply dynamic styling to dismiss button
            Object.assign(dismissBtn.style, {
                marginLeft: 'auto',
                marginRight: '-6px',
                marginTop: '-6px',
                marginBottom: '-6px',
                backgroundColor: isDarkMode ? '#374151' : '#f9fafb',
                color: isDarkMode ? '#9ca3af' : '#6b7280',
                borderRadius: '8px',
                padding: '6px',
                display: 'inline-flex',
                alignItems: 'center',
                justifyContent: 'center',
                width: '32px',
                height: '32px',
                border: 'none',
                cursor: 'pointer',
                transition: 'all 0.2s ease'
            });

            dismissBtn.innerHTML = `
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            `;

            toast.appendChild(dismissBtn);
        }

        return toast;
    }

    /**
     * Dismiss a toast notification
     * @param {string} toastId - The ID of the toast to dismiss
     */
    dismiss(toastId) {
        const toast = document.getElementById(toastId);
        if (!toast) return;

        // Animate out
        toast.style.transform = 'translateX(100%)';
        toast.style.opacity = '0';

        // Remove from DOM after animation
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }

    /**
     * Clear all toast notifications
     */
    clearAll() {
        const toasts = this.container.querySelectorAll('.toast-notification');
        toasts.forEach(toast => {
            this.dismiss(toast.id);
        });
    }

    /**
     * Escape HTML to prevent XSS
     * @param {string} text
     * @returns {string}
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    /**
     * Detect layout type and set appropriate theme
     */
    detectAndSetLayoutTheme() {
        const bodyElement = document.body;
        const layoutType = bodyElement?.getAttribute('data-layout');
        
        console.log('Toast: Detected layout type:', layoutType);
        
        if (layoutType === 'customer') {
            // Customer side - always use light theme
            this.forceTheme = 'light';
            console.log('Toast: Forcing light theme for customer layout');
        } else if (layoutType === 'admin') {
            // Admin side - allow auto-detection (dark mode available)
            this.forceTheme = null;
            console.log('Toast: Auto-detection enabled for admin layout');
        } else {
            // Fallback - try to detect from URL or other indicators
            const currentPath = window.location.pathname;
            if (currentPath.startsWith('/admin')) {
                this.forceTheme = null; // Admin - auto-detect
                console.log('Toast: Auto-detection enabled (detected admin from URL)');
            } else {
                this.forceTheme = 'light'; // Customer - force light
                console.log('Toast: Forcing light theme (detected customer from URL)');
            }
        }
    }

    /**
     * Check if dark mode is currently active
     * @returns {boolean}
     */
    isDarkModeActive() {
        // Check if theme is forced (for customer side - always light mode)
        if (this.forceTheme === 'light') {
            return false;
        }
        if (this.forceTheme === 'dark') {
            return true;
        }
        
        // Auto-detection for admin side or when no theme is forced
        
        // 1. Check if document has dark class (common Tailwind approach)
        if (document.documentElement.classList.contains('dark')) {
            return true;
        }
        
        // 2. Check localStorage for theme preference
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme === 'dark') {
            return true;
        }
        
        // 3. Check if data-theme attribute is set to dark
        const dataTheme = document.documentElement.getAttribute('data-theme');
        if (dataTheme === 'dark') {
            return true;
        }
        
        // 4. Check system preference if no explicit theme is set
        if ((!storedTheme || storedTheme === 'system') && 
            window.matchMedia && 
            window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return true;
        }
        
        // 5. Check for other common dark mode indicators
        if (document.body.classList.contains('dark-mode') || 
            document.body.classList.contains('dark-theme')) {
            return true;
        }
        
        return false;
    }

    /**
     * Set up theme change listeners to update existing toasts
     */
    setupThemeListeners() {
        // Don't set up listeners if theme is forced
        if (this.forceTheme) {
            return;
        }
        
        // Listen for system theme changes
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', () => {
                this.updateExistingToastsTheme();
            });
        }
        
        // Listen for localStorage theme changes (for multi-tab sync)
        window.addEventListener('storage', (e) => {
            if (e.key === 'theme') {
                this.updateExistingToastsTheme();
            }
        });
        
        // Listen for class changes on document element (MutationObserver)
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.type === 'attributes' && 
                    (mutation.attributeName === 'class' || mutation.attributeName === 'data-theme')) {
                    this.updateExistingToastsTheme();
                }
            });
        });
        
        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['class', 'data-theme']
        });
        
        // Also observe body for some implementations
        observer.observe(document.body, {
            attributes: true,
            attributeFilter: ['class']
        });
    }

    /**
     * Update theme for all existing toasts
     */
    updateExistingToastsTheme() {
        const toasts = this.container.querySelectorAll('.toast-notification');
        const isDarkMode = this.isDarkModeActive();
        
        toasts.forEach(toast => {
            // Update container colors based on current theme
            const boxShadow = isDarkMode 
                ? '0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2)'
                : '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
                
            const border = isDarkMode ? '1px solid #374151' : '1px solid #e5e7eb';
            
            Object.assign(toast.style, {
                boxShadow: boxShadow,
                border: border
            });
            
            // Note: We would need to determine the toast type to update colors properly
            // For now, we just update the basic theme-aware properties
        });
    }

    // Convenience methods for different toast types
    success(message, duration, dismissible) {
        return this.show(message, 'success', duration, dismissible);
    }

    error(message, duration, dismissible) {
        return this.show(message, 'error', duration, dismissible);
    }

    warning(message, duration, dismissible) {
        return this.show(message, 'warning', duration, dismissible);
    }

    info(message, duration, dismissible) {
        return this.show(message, 'info', duration, dismissible);
    }
}

// Initialize the toast manager
const toastManager = new ToastManager();

// Global functions for backwards compatibility and ease of use
window.showToast = function(message, type = 'success', duration = null, dismissible = true) {
    return toastManager.show(message, type, duration, dismissible);
};

window.toastSuccess = function(message, duration, dismissible) {
    return toastManager.success(message, duration, dismissible);
};

window.toastError = function(message, duration, dismissible) {
    return toastManager.error(message, duration, dismissible);
};

window.toastWarning = function(message, duration, dismissible) {
    return toastManager.warning(message, duration, dismissible);
};

window.toastInfo = function(message, duration, dismissible) {
    return toastManager.info(message, duration, dismissible);
};

window.clearAllToasts = function() {
    toastManager.clearAll();
};

// Export for module usage
export default toastManager;
