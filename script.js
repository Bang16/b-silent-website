// Wait for the DOM to fully load before executing
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');

    // Check if elements exist to avoid errors
    if (mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', function () {
            navLinks.classList.toggle('active');

            // Optional: Change hamburger icon to "X" when open
            this.classList.toggle('open');
        });
    } else {
        console.error('Mobile menu elements not found! Check your selectors.');
    }
    const checkoutBtn = document.querySelector('.checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function () {
            // Example: Redirect to checkout page
            window.location.href = 'checkout.html';
        });
    }
});
// Cart functionality
let cart = [];
const savedCart = localStorage.getItem('cart');
if (savedCart) {
    cart = JSON.parse(savedCart);
}

const cartToggle = document.getElementById('cartToggle');
const cartSidebar = document.getElementById('cartSidebar');
const closeCart = document.getElementById('closeCart');
const cartItems = document.getElementById('cartItems');
const cartTotal = document.getElementById('cartTotal');
const cartCount = document.querySelector('.cart-count');
const addToCartButtons = document.querySelectorAll('.add-to-cart');

updateCart();

// Toggle cart visibility
cartToggle.addEventListener('click', () => {
    cartSidebar.classList.toggle('active');
});

closeCart.addEventListener('click', () => {
    cartSidebar.classList.remove('active');
});

// Add to cart function
addToCartButtons.forEach(button => {
    button.addEventListener('click', () => {
        const name = button.getAttribute('data-name');
        const price = parseFloat(button.getAttribute('data-price'));

        // Add item to cart
        cart.push({ name, price });
        updateCart();

        // Show cart sidebar
        cartSidebar.classList.add('active');
    });
});

// Update cart display
function updateCart() {
    // Update cart count
    cartCount.textContent = cart.length;

    // Update cart items
    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="empty-cart-message">Your cart is empty</p>';
    } else {
        cartItems.innerHTML = '';
        cart.forEach((item, index) => {
            const cartItem = document.createElement('div');
            cartItem.className = 'cart-item';
            cartItem.innerHTML = `
                            <div class="cart-item-details">
                                <span class="cart-item-name">${item.name}</span>
                                <span class="cart-item-price">R${item.price.toFixed(2)}</span>
                            </div>
                            <button class="remove-item" data-index="${index}">&times;</button>
                        `;
            cartItems.appendChild(cartItem);
        });

        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', (e) => {
                const index = e.target.getAttribute('data-index');
                cart.splice(index, 1);
                updateCart();
            });
        });
    }

    // Update total
    const total = cart.reduce((sum, item) => sum + item.price, 0);
    cartTotal.textContent = `R${total.toFixed(2)}`;
    localStorage.setItem('cart', JSON.stringify(cart));
}