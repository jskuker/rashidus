document.addEventListener('DOMContentLoaded', function() {
    // Переключение вида
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            const url = new URL(window.location.href);
            url.searchParams.set('view', view);
            document.querySelector('.catalog-items').classList.add('fade');
            setTimeout(() => { window.location = url.toString(); }, 200);
        });
    });

    // Переключение сортировки
    document.querySelectorAll('.sort-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const sort = this.dataset.sort;
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sort);
            document.querySelector('.catalog-items').classList.add('fade');
            setTimeout(() => { window.location = url.toString(); }, 200);
        });
    });

    // Функции корзины
    function showNotification(message, type = 'success') {
        const notifications = document.getElementById('cart-notifications');
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        notifications.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    function updateCartCount() {
        fetch('/ajax/cart_count.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cart-count').textContent = data.count;
                }
            })
            .catch(error => {
                console.error('Ошибка обновления счетчика корзины:', error);
            });
    }

    function updateProductControls(productId, quantity) {
        const productElement = document.querySelector(`[data-product-id="${productId}"]`);
        const cartControls = productElement.querySelector('.catalog-item__cart-controls');
        
        if (quantity > 0) {
            // Показываем контролы количества
            cartControls.innerHTML = `
                <div class="cart-quantity-controls">
                    <button class="cart-btn cart-btn-minus" data-action="decrease" data-product-id="${productId}">-</button>
                    <span class="cart-quantity" data-product-id="${productId}">${quantity}</span>
                    <button class="cart-btn cart-btn-plus" data-action="increase" data-product-id="${productId}">+</button>
                </div>
            `;
            
            // Добавляем обработчики для новых кнопок
            addCartEventListeners(cartControls);
        } else {
            // Показываем кнопку "В корзину"
            const price = productElement.querySelector('.catalog-item__btn').dataset.price || '0';
            cartControls.innerHTML = `
                <button class="catalog-item__btn cart-btn-add" data-product-id="${productId}" data-price="${price}">В корзину</button>
            `;
            
            // Добавляем обработчик для новой кнопки
            addCartEventListeners(cartControls);
        }
    }

    function addCartEventListeners(container) {
        // Кнопка "В корзину"
        const addBtn = container.querySelector('.cart-btn-add');
        if (addBtn) {
            addBtn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                addToCart(productId, 1);
            });
        }

        // Кнопки увеличения/уменьшения
        const minusBtn = container.querySelector('.cart-btn-minus');
        const plusBtn = container.querySelector('.cart-btn-plus');
        
        if (minusBtn) {
            minusBtn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                changeCartQuantity(productId, -1);
            });
        }
        
        if (plusBtn) {
            plusBtn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                changeCartQuantity(productId, 1);
            });
        }
    }

    function addToCart(productId, quantity = 1) {
        fetch('/ajax/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'add',
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Товар добавлен в корзину');
                updateCartCount();
                updateProductControls(productId, data.quantity);
            } else {
                showNotification(data.message || 'Ошибка добавления товара', 'error');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            showNotification('Ошибка добавления товара', 'error');
        });
    }

    function changeCartQuantity(productId, change) {
        fetch('/ajax/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'change',
                product_id: productId,
                change: change
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount();
                updateProductControls(productId, data.quantity);
                
                if (data.quantity === 0) {
                    showNotification('Товар удален из корзины');
                }
            } else {
                showNotification(data.message || 'Ошибка изменения количества', 'error');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            showNotification('Ошибка изменения количества', 'error');
        });
    }

    // Инициализация обработчиков корзины
    document.querySelectorAll('.catalog-item__cart-controls').forEach(container => {
        addCartEventListeners(container);
    });
});
