console.log("Hello js");

let cartItems = [];

document.addEventListener('click', function(event) {
    if (event.target.classList.contains('kosarbarak')) {
        addToCart(event);
    }
});

function addToCart(event) {
    const productId = event.target.classList[1];
    const termekmegnevezes = event.target.parentElement.querySelector('.nev').innerText;
    //const termekkep = event.target.parentElement.querySelector('.kep').innerText;
    const termekcikkszam = event.target.parentElement.querySelector('.cikkszam').innerText;
    const termekar = event.target.parentElement.querySelector('.ar').innerText;
    console.log("kosarbarak event");

    const cartItem = {
        id: productId,
        megnevezes: termekmegnevezes,
        //kep: termekkep,
        cikkszam: termekcikkszam,
        ar: termekar
    };
    console.log(cartItem);

    if (!localStorage.getItem('cartItems')) {
        localStorage.setItem('cartItems', JSON.stringify([cartItem]));
    } else {
        let cartItems = JSON.parse(localStorage.getItem('cartItems'));
        cartItems.push(cartItem);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
    }
}
console.log(cartItems);