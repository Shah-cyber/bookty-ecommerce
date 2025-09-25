// Initialize Notyf
const notyf = new Notyf({
    duration: 4000,
    position: {
        x: 'right',
        y: 'top',
    },
    types: [
        {
            type: 'success',
            background: '#10b981',
            icon: {
                className: 'notyf__icon--success',
                tagName: 'i',
            }
        },
        {
            type: 'error',
            background: '#ef4444',
            icon: {
                className: 'notyf__icon--error',
                tagName: 'i',
            }
        },
        {
            type: 'warning',
            background: '#f59e0b',
            icon: {
                className: 'notyf__icon--warning',
                tagName: 'i',
            }
        },
        {
            type: 'info',
            background: '#3b82f6',
            icon: {
                className: 'notyf__icon--info',
                tagName: 'i',
            }
        }
    ]
});

// Create a simplified global function for easier usage
function showToast(message, type = 'success') {
    notyf.open({
        type: type,
        message: message
    });
}
