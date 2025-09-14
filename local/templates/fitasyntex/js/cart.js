document.addEventListener('DOMContentLoaded', function() {
    // Функции уведомлений
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
                    // Обновляем счетчик в шапке сайта, если он есть
                    const cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.count;
                    }
                }
            })
            .catch(error => {
                console.error('Ошибка обновления счетчика корзины:', error);
            });
    }

    function updateCartItem(productId, quantity) {
        const cartItem = document.querySelector(`[data-product-id="${productId}"]`);
        if (!cartItem) return;

        if (quantity <= 0) {
            // Удаляем товар из корзины
            cartItem.remove();
            showNotification('Товар удален из корзины');
            
            // Проверяем, пуста ли корзина
            const remainingItems = document.querySelectorAll('.cart-item');
            if (remainingItems.length === 0) {
                location.reload(); // Перезагружаем страницу для показа пустой корзины
            }
        } else {
            // Обновляем количество
            const quantityInput = cartItem.querySelector('.quantity-input');
            if (quantityInput) {
                quantityInput.value = quantity;
            }
        }
    }

    function updateCartSummary() {
        fetch('/ajax/cart_summary.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('total-items').textContent = data.totalItems;
                    document.getElementById('total-price').textContent = data.totalPrice;
                }
            })
            .catch(error => {
                console.error('Ошибка обновления итогов:', error);
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
                updateCartItem(productId, data.quantity);
                updateCartSummary();
            } else {
                showNotification(data.message || 'Ошибка изменения количества', 'error');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            showNotification('Ошибка изменения количества', 'error');
        });
    }

    function removeFromCart(productId) {
        fetch('/ajax/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'remove',
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount();
                updateCartItem(productId, 0);
                updateCartSummary();
            } else {
                showNotification(data.message || 'Ошибка удаления товара', 'error');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            showNotification('Ошибка удаления товара', 'error');
        });
    }

    function clearCart() {
        if (!confirm('Вы уверены, что хотите очистить корзину?')) {
            return;
        }

        fetch('/ajax/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'clear'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Корзина очищена');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification(data.message || 'Ошибка очистки корзины', 'error');
            }
        })
        .catch(error => {
            console.error('Ошибка:', error);
            showNotification('Ошибка очистки корзины', 'error');
        });
    }

    // Обработчики событий
    document.addEventListener('click', function(e) {
        // Кнопки увеличения/уменьшения количества
        if (e.target.classList.contains('quantity-minus')) {
            const productId = parseInt(e.target.dataset.productId);
            changeCartQuantity(productId, -1);
        }
        
        if (e.target.classList.contains('quantity-plus')) {
            const productId = parseInt(e.target.dataset.productId);
            changeCartQuantity(productId, 1);
        }
        
        // Кнопка удаления товара
        if (e.target.classList.contains('remove-btn') || e.target.closest('.remove-btn')) {
            const productId = parseInt(e.target.dataset.productId || e.target.closest('.remove-btn').dataset.productId);
            removeFromCart(productId);
        }
        
        // Кнопка очистки корзины
        if (e.target.id === 'clear-cart') {
            clearCart();
        }
    });

    // Обработчик изменения количества через input
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('quantity-input')) {
            const productId = parseInt(e.target.dataset.productId);
            const newQuantity = parseInt(e.target.value);
            
            if (newQuantity < 1) {
                e.target.value = 1;
                return;
            }
            
            // Получаем текущее количество из корзины
            fetch('/ajax/cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'get_quantity',
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const currentQuantity = data.quantity;
                    const change = newQuantity - currentQuantity;
                    
                    if (change !== 0) {
                        changeCartQuantity(productId, change);
                    }
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                showNotification('Ошибка изменения количества', 'error');
            });
        }
    });
});
