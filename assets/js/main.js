
document.addEventListener('DOMContentLoaded', function() {
    console.log("Website Loaded Successfully");

    
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    });
});

function confirmOrder() {
    return confirm("Are you sure you want to place this order?");
}