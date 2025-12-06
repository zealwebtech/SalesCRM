/*
 Copyright (c) 2025 Zeal Web Technologies (https://zealwebtech.com)
 All Rights Reserved.

 This file is part of SalesCRM. No one is permitted to copy, modify,
 distribute, or create derivative works of this file without prior written
 permission from Zeal Web Technologies.
 For permissions contact: legal@zealwebtech.com
*/

// Navigation function to switch between pages
function navigate(page) {
    // Hide all page sections
    const sections = document.querySelectorAll('.page-section');
    sections.forEach(section => {
        section.classList.remove('active');
    });

    // Remove active class from all menu items
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(item => {
        item.classList.remove('active');
    });

    // Show selected page section
    const activeSection = document.getElementById(page);
    if (activeSection) {
        activeSection.classList.add('active');
    }

    // Add active class to clicked menu item
    event.target.closest('.menu-item')?.classList.add('active');

    // Update page title
    const pageTitle = document.getElementById('page-title');
    const pageTitles = {
        'dashboard': 'Dashboard',
        'manage-user': 'Manage User',
        'manager-invoice': 'Manager Invoice',
        'inventory': 'Inventory Management',
        'product': 'Product Management',
        'purchase': 'Purchase Orders',
        'expenses': 'Expense Management',
        'accounting': 'Accounting & Finance',
        'hrm': 'Human Resource Management',
        'quotation': 'Quotation Management'
    };
    
    if (pageTitles[page]) {
        pageTitle.textContent = pageTitles[page];
    }
}

// Modal functions
function openAddUserModal() {
    const modal = document.getElementById('addUserModal');
    modal.classList.add('active');
}

function closeAddUserModal() {
    const modal = document.getElementById('addUserModal');
    modal.classList.remove('active');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('addUserModal');
    if (event.target === modal) {
        modal.classList.remove('active');
    }
}

// Handle form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.modal-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const userName = document.getElementById('userName').value;
            const userEmail = document.getElementById('userEmail').value;
            const userRole = document.getElementById('userRole').value;

            // Validate form
            if (!userName || !userEmail || !userRole) {
                alert('Please fill in all fields');
                return;
            }

            // Add new user to table
            addUserToTable(userName, userEmail, userRole);

            // Reset form and close modal
            form.reset();
            closeAddUserModal();
        });
    }
});

// Add user to table function
function addUserToTable(name, email, role) {
    const tableBody = document.querySelector('.users-table tbody');
    
    // Generate new user ID
    const lastRow = tableBody.lastElementChild;
    const lastId = lastRow ? parseInt(lastRow.cells[0].textContent.replace('#', '')) : 0;
    const newId = lastId + 1;

    // Create new row
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>#${String(newId).padStart(3, '0')}</td>
        <td>${name}</td>
        <td>${email}</td>
        <td>${role}</td>
        <td><span class="badge badge-success">Active</span></td>
        <td>
            <button class="btn-icon" title="Edit">✏️</button>
            <button class="btn-icon" title="Delete" onclick="deleteUser(this)">🗑️</button>
        </td>
    `;

    // Add animation
    newRow.style.opacity = '0';
    newRow.style.transform = 'translateY(-10px)';
    tableBody.insertBefore(newRow, tableBody.firstChild);

    // Trigger animation
    setTimeout(() => {
        newRow.style.transition = 'all 0.3s ease';
        newRow.style.opacity = '1';
        newRow.style.transform = 'translateY(0)';
    }, 10);

    // Show success message
    showNotification('User added successfully!', 'success');
}

// Delete user function
function deleteUser(button) {
    const row = button.closest('tr');
    const userName = row.cells[1].textContent;

    if (confirm(`Are you sure you want to delete ${userName}?`)) {
        row.style.transition = 'all 0.3s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateX(-100%)';

        setTimeout(() => {
            row.remove();
            showNotification('User deleted successfully!', 'success');
        }, 300);
    }
}

// Show notification function
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        padding: 15px 20px;
        border-radius: 6px;
        z-index: 2000;
        animation: slideInRight 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Logout function
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to logout?')) {
                alert('You have been logged out successfully!');
                // Here you would typically redirect to login page
                // window.location.href = '/login';
            }
        });
    }
});

// Invoice Counter for auto-generating invoice numbers
let invoiceCounter = 4;

// Open Create Invoice Modal
function openCreateInvoiceModal() {
    const modal = document.getElementById('createInvoiceModal');
    modal.classList.add('active');
    
    // Auto-generate invoice number
    invoiceCounter++;
    const invoiceNum = '#INV-' + String(invoiceCounter).padStart(3, '0');
    document.getElementById('invoiceNumber').value = invoiceNum;
    
    // Set today's date
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('invoiceDate').value = today;
}

// Close Create Invoice Modal
function closeCreateInvoiceModal() {
    const modal = document.getElementById('createInvoiceModal');
    modal.classList.remove('active');
}

// Close modals when clicking outside
window.onclick = function(event) {
    const userModal = document.getElementById('addUserModal');
    const invoiceModal = document.getElementById('createInvoiceModal');
    
    if (event.target === userModal) {
        userModal.classList.remove('active');
    }
    if (event.target === invoiceModal) {
        invoiceModal.classList.remove('active');
    }
}

// Handle Invoice Form Submission
document.addEventListener('DOMContentLoaded', function() {
    const invoiceForm = document.querySelector('#createInvoiceModal .modal-form');
    if (invoiceForm) {
        invoiceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const invoiceNumber = document.getElementById('invoiceNumber').value;
            const customerName = document.getElementById('customerName').value;
            const invoiceAmount = document.getElementById('invoiceAmount').value;
            const issueDate = document.getElementById('invoiceDate').value;
            const dueDate = document.getElementById('dueDate').value;
            const status = document.getElementById('invoiceStatus').value;

            // Validate form
            if (!customerName || !invoiceAmount || !issueDate || !dueDate || !status) {
                alert('Please fill in all required fields');
                return;
            }

            // Format dates
            const issueDateFormatted = new Date(issueDate).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            const dueDateFormatted = new Date(dueDate).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });

            // Add invoice to table
            addInvoiceToTable(invoiceNumber, customerName, invoiceAmount, issueDateFormatted, dueDateFormatted, status);

            // Reset form and close modal
            invoiceForm.reset();
            closeCreateInvoiceModal();
        });
    }
});

// Add Invoice to Table
function addInvoiceToTable(invoiceNumber, customerName, amount, issueDate, dueDate, status) {
    const tableBody = document.querySelector('.invoices-table tbody');
    
    // Create new row
    const newRow = document.createElement('tr');
    const amountFormatted = '$' + parseFloat(amount).toFixed(2);
    
    // Get badge class based on status
    let badgeClass = 'badge-draft';
    if (status === 'Pending') badgeClass = 'badge-pending';
    else if (status === 'Paid') badgeClass = 'badge-paid';
    else if (status === 'Overdue') badgeClass = 'badge-overdue';
    
    newRow.innerHTML = `
        <td>${invoiceNumber}</td>
        <td>${customerName}</td>
        <td>${amountFormatted}</td>
        <td>${issueDate}</td>
        <td>${dueDate}</td>
        <td><span class="badge ${badgeClass}">${status}</span></td>
        <td>
            <button class="btn-icon" title="View" onclick="viewInvoice(this)">👁️</button>
            <button class="btn-icon" title="Edit" onclick="editInvoice(this)">✏️</button>
            <button class="btn-icon" title="Delete" onclick="deleteInvoice(this)">🗑️</button>
        </td>
    `;

    // Add animation
    newRow.style.opacity = '0';
    newRow.style.transform = 'translateY(-10px)';
    tableBody.insertBefore(newRow, tableBody.firstChild);

    // Trigger animation
    setTimeout(() => {
        newRow.style.transition = 'all 0.3s ease';
        newRow.style.opacity = '1';
        newRow.style.transform = 'translateY(0)';
    }, 10);

    // Show success message
    showNotification('Invoice created successfully!', 'success');
}

// View Invoice
function viewInvoice(button) {
    const row = button.closest('tr');
    const invoiceNumber = row.cells[0].textContent;
    const customerName = row.cells[1].textContent;
    const amount = row.cells[2].textContent;
    
    alert(`Invoice Details:\n\nInvoice #: ${invoiceNumber}\nCustomer: ${customerName}\nAmount: ${amount}`);
}

// Edit Invoice
function editInvoice(button) {
    const row = button.closest('tr');
    const invoiceNumber = row.cells[0].textContent;
    alert(`Edit functionality for ${invoiceNumber} - Coming soon!`);
}

// Delete Invoice
function deleteInvoice(button) {
    const row = button.closest('tr');
    const invoiceNumber = row.cells[0].textContent;

    if (confirm(`Are you sure you want to delete ${invoiceNumber}?`)) {
        row.style.transition = 'all 0.3s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateX(-100%)';

        setTimeout(() => {
            row.remove();
            showNotification('Invoice deleted successfully!', 'success');
        }, 300);
    }
}

// Search and Filter Invoices
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInvoice');
    const statusFilter = document.getElementById('filterStatus');
    
    if (searchInput && statusFilter) {
        searchInput.addEventListener('input', filterInvoices);
        statusFilter.addEventListener('change', filterInvoices);
    }
});

function filterInvoices() {
    const searchTerm = document.getElementById('searchInvoice')?.value.toLowerCase() || '';
    const statusFilter = document.getElementById('filterStatus')?.value || '';
    const tableRows = document.querySelectorAll('.invoices-table tbody tr');

    tableRows.forEach(row => {
        const invoiceNumber = row.cells[0].textContent.toLowerCase();
        const customerName = row.cells[1].textContent.toLowerCase();
        const status = row.cells[5].textContent.trim();

        const matchesSearch = invoiceNumber.includes(searchTerm) || customerName.includes(searchTerm);
        const matchesStatus = statusFilter === '' || status === statusFilter;

        row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
    });
}

// =============== INTERCONNECTIVITY FUNCTIONS ===============

// Navigation with parameters for interconnectivity
function navigateToProduct(productId) {
    navigate('product');
    showNotification(`Loading product ${productId}...`, 'success');
}

function navigateToPurchase(productId) {
    navigate('purchase');
    showNotification(`Creating purchase for ${productId}...`, 'success');
}

function navigateToQuotation(productId) {
    navigate('quotation');
    showNotification(`Creating quotation for ${productId}...`, 'success');
}

function navigateToAccounting(referenceId) {
    navigate('accounting');
    showNotification(`Loading accounting details for ${referenceId}...`, 'success');
}

function convertToInvoice(quotationId) {
    navigate('manager-invoice');
    showNotification(`Converting ${quotationId} to invoice...`, 'success');
}

// =============== INVENTORY FUNCTIONS ===============

function openAddInventoryModal() {
    showNotification('Add Inventory Modal - Coming Soon', 'success');
}

// =============== PRODUCT FUNCTIONS ===============

function openAddProductModal() {
    showNotification('Add Product Modal - Coming Soon', 'success');
}

// =============== PURCHASE FUNCTIONS ===============

function openAddPurchaseModal() {
    showNotification('Add Purchase Order Modal - Coming Soon', 'success');
}

// =============== EXPENSES FUNCTIONS ===============

function openAddExpenseModal() {
    showNotification('Add Expense Modal - Coming Soon', 'success');
}

// =============== ACCOUNTING FUNCTIONS ===============

function openFinancialReportModal() {
    showNotification('Financial Report Modal - Coming Soon', 'success');
}

// =============== HRM FUNCTIONS ===============

function openAddEmployeeModal() {
    showNotification('Add Employee Modal - Coming Soon', 'success');
}

// =============== QUOTATION FUNCTIONS ===============

function openAddQuotationModal() {
    showNotification('Add Quotation Modal - Coming Soon', 'success');
}
