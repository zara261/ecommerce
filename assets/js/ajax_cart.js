document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.dataset.id;

        fetch('core/cart_logic.php', {
            method: 'POST',
            body: JSON.stringify({id: productId}),
            headers: {'Content-Type': 'application/json'}
        })
        .then(res => res.json())
        .then(data => {
            alert('Added to cart!');
            document.getElementById('cart-count').innerText = `Cart (${data.count})`;
        });
    });
});