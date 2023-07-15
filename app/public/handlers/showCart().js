function showCart() {
    fetch('/getCart.php') // Путь к файлу, который будет возвращать данные о корзине
        .then(response => response.text())
        .then(data => {
            // Отобразить данные о корзине в сплывающем окне
            var popup = window.open('', 'cartPopup', 'width=400,height=300');
            popup.document.write(data);
        });