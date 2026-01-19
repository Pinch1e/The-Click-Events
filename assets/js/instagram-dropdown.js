// Instagram-Style Dropdown Menu JavaScript

document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const dropdownMenu = document.getElementById('dropdownMenu');

    // Toggle dropdown menu
    hamburger.addEventListener('click', function() {
        hamburger.classList.toggle('active');
        dropdownMenu.classList.toggle('active');

        // Update aria-hidden attribute for accessibility
        const isExpanded = dropdownMenu.classList.contains('active');
        dropdownMenu.setAttribute('aria-hidden', !isExpanded);
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!hamburger.contains(event.target) && !dropdownMenu.contains(event.target)) {
            hamburger.classList.remove('active');
            dropdownMenu.classList.remove('active');
            dropdownMenu.setAttribute('aria-hidden', 'true');
        }
    });

    // Close dropdown on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            hamburger.classList.remove('active');
            dropdownMenu.classList.remove('active');
            dropdownMenu.setAttribute('aria-hidden', 'true');
        }
    });

    // Add subtle animations to menu items
    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach((item, index) => {
        item.style.animationDelay = `${index * 0.05}s`;
        item.classList.add('animate-in');
    });

    // Handle menu item clicks (for demonstration)
    const menuLinks = document.querySelectorAll('.menu-link');
    menuLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            // Prevent default for demo purposes
            event.preventDefault();

            // Add click animation
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);

            // Close menu after selection
            hamburger.classList.remove('active');
            dropdownMenu.classList.remove('active');
            dropdownMenu.setAttribute('aria-hidden', 'true');

            // Here you would typically navigate to the selected page
            console.log('Navigating to:', this.querySelector('.menu-text').textContent);
        });
    });

    // Add hover effects with micro-animations
    menuLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.menu-icon');
            icon.style.transform = 'scale(1.1) rotate(5deg)';
        });

        link.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.menu-icon');
            icon.style.transform = '';
        });
    });
});

// Add CSS for animation class
const style = document.createElement('style');
style.textContent = `
    .animate-in {
        opacity: 0;
        transform: translateX(-10px);
        animation: slideIn 0.3s ease-out forwards;
    }

    @keyframes slideIn {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
`;
document.head.appendChild(style);
