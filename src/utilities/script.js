/**
 * script.js - JavaScript for Blood Donor System
 * Handles interactivity and form validation
 */

// Wait for page to load
document.addEventListener('DOMContentLoaded', function() {
    
    // ===== AUTO-HIDE SUCCESS/ERROR MESSAGES =====
    const messages = document.querySelectorAll('.message');
    if (messages.length > 0) {
        messages.forEach(message => {
            // Auto-hide after 5 seconds
            setTimeout(() => {
                message.style.opacity = '0';
                message.style.transition = 'opacity 0.5s';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 500);
            }, 5000);
        });
    }
    
    // ===== FORM VALIDATION =====
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Validate contact number (optional - can be customized)
            const contactInput = form.querySelector('input[name="contact"]');
            if (contactInput && contactInput.value) {
                const contact = contactInput.value;
                // Check if contact has at least 10 digits
                const digits = contact.replace(/\D/g, '');
                if (digits.length < 10) {
                    e.preventDefault();
                    alert('Please enter a valid contact number (at least 10 digits)');
                    contactInput.focus();
                    return false;
                }
            }
            
            // Validate email format (optional)
            const emailInput = form.querySelector('input[name="email"]');
            if (emailInput && emailInput.value) {
                const email = emailInput.value;
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    e.preventDefault();
                    alert('Please enter a valid email address');
                    emailInput.focus();
                    return false;
                }
            }
        });
    });
    
    // ===== CONFIRM DELETE ACTION =====
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const confirmDelete = confirm('Are you sure you want to delete this donor? This action cannot be undone!');
            if (!confirmDelete) {
                e.preventDefault();
                return false;
            }
        });
    });
    
    // ===== SMOOTH SCROLL FOR LINKS =====
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // ===== ADD LOADING SPINNER ON FORM SUBMIT =====
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '⏳ Processing...';
                submitBtn.style.opacity = '0.7';
            }
        });
    });
    
    // ===== HIGHLIGHT EMPTY REQUIRED FIELDS =====
    const requiredInputs = document.querySelectorAll('input[required], select[required], textarea[required]');
    requiredInputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '#e0e0e0';
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value) {
                this.style.borderColor = '#27ae60';
            }
        });
    });
    
    // ===== SEARCH FORM - PREVENT EMPTY SEARCH =====
    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            const blood = document.querySelector('select[name="blood"]').value;
            const city = document.querySelector('input[name="city"]').value;
            const name = document.querySelector('input[name="name"]').value;
            
            // If all fields are empty, show alert
            if (!blood && !city && !name) {
                e.preventDefault();
                alert('Please enter at least one search criteria');
                return false;
            }
        });
    }
    
    // ===== PRINT TABLE FUNCTIONALITY (optional) =====
    const printBtn = document.getElementById('printTable');
    if (printBtn) {
        printBtn.addEventListener('click', function() {
            window.print();
        });
    }
    
    // ===== CHARACTER COUNTER FOR TEXTAREA =====
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        const maxLength = 500;
        const counter = document.createElement('div');
        counter.style.textAlign = 'right';
        counter.style.fontSize = '0.9em';
        counter.style.color = '#666';
        counter.style.marginTop = '5px';
        
        textarea.parentNode.insertBefore(counter, textarea.nextSibling);
        
        function updateCounter() {
            const remaining = maxLength - textarea.value.length;
            counter.textContent = `${textarea.value.length} / ${maxLength} characters`;
            
            if (remaining < 50) {
                counter.style.color = '#e74c3c';
            } else {
                counter.style.color = '#666';
            }
        }
        
        textarea.setAttribute('maxlength', maxLength);
        textarea.addEventListener('input', updateCounter);
        updateCounter();
    });
    
    // ===== SHOW SUCCESS ANIMATION =====
    const successMessages = document.querySelectorAll('.success');
    successMessages.forEach(msg => {
        msg.style.animation = 'slideIn 0.5s ease';
    });
    
});

// ===== HELPER FUNCTION: Format Phone Number =====
function formatPhoneNumber(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length > 4 && value.length <= 7) {
        value = value.slice(0, 4) + '-' + value.slice(4);
    } else if (value.length > 7) {
        value = value.slice(0, 4) + '-' + value.slice(4, 7) + value.slice(7, 11);
    }
    input.value = value;
}

// ===== ADD CSS ANIMATIONS =====
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);