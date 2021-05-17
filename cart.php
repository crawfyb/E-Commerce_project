<?php

ini_set('display_errors', 1); error_reporting(-1);
    session_start();

    include './dbconfig/db.php';




?>


<link rel="stylesheet" href="CSS/style.css" type="text/css">


<?php
require './include/header.html';

?>

<div class="products-container">
              <div class="product-header">
                <h5 class="product-title">Product</h5>
                <h5 class="price">PRICE</h5>
                <h5 class="quantity">Quantity</h5>
                <h5 class="total">Total</h5>
              </div>
              <div class="products">

              </div>
              <div class="btn btn-primary" type="button">
                Buy Now
              </div>
            </div>



<script type="text/javascript">

let carts = document.querySelectorAll('.add-cart');




    let products = [

    <?php     $stmt = $pdo -> query('SELECT * from estock');
      while ($row = $stmt->fetch()) {
    ?>

      {
        id: "<?php  echo $row->stockNo ?>",
        name: "<?php echo $row->description ?>",
        price: <?php  echo $row->price ?>,
        inCart: 0
    },

    <?php
    } ?>
]
    console.log(products);

    //console.log(products);
for (let i = 0; i < carts.length; i++) {
carts[i].addEventListener('click', () => {
cartNumbers(products[i]);
totalCost(products[i]);
})
}

function onLoadCartNumbers() {
let productNumbers = localStorage.getItem('cartNumbers');

if (productNumbers) {
document.querySelector('.cart span').textContent = productNumbers;
}
};

function cartNumbers(product, action) {
// console.log("The product clicked is", product);
let productNumbers = localStorage.getItem('cartNumbers');

productNumbers=parseInt(productNumbers);

let cartItems = localStorage.getItem('productsInCart');
cartItems = JSON.parse(cartItems);

if (action == 'decrease') {
localStorage.setItem('cartNumbers', productNumbers - 1 );
document.querySelector('.cart span').textContent = productNumbers - 1;
}else if(productNumbers){
localStorage.setItem('cartNumbers', productNumbers + 1)
document.querySelector('.cart span').textContent = productNumbers + 1;
}else {
localStorage.setItem('cartNumbers', 1)
document.querySelector('.cart span').textContent = 1;

}

// if (productNumbers) {
//   localStorage.setItem('cartNumbers', productNumbers + 1);
//   document.querySelector('.cart span').textContent = productNumbers + 1;
// } else {
//   localStorage.setItem('cartNumbers', 1);
//   document.querySelector('.cart span').textContent = 1;
// }
setItems(product);
};

function setItems(product) {
let cartItems = localStorage.getItem('productsInCart');
cartItems = JSON.parse(cartItems);
//console.log("asfafasf", cartItems);
// console.log('Inside of the items function');
// console.log("my product is ", product);
if (cartItems != null) {

if (cartItems[product.name] == undefined) {
 cartItems = {
   ...cartItems,
   [product.name]: product
 }

}
cartItems[product.name].inCart += 1;
}else {
product.inCart = 1;

cartItems = {
 [product.name]:product
}
}

localStorage.setItem('productsInCart', JSON.stringify(cartItems))
}

function totalCost(product, action) {
let cartCost = localStorage.getItem('totalCost');

if (action == 'decrease') {
cartCost = parseInt(cartCost);
localStorage.setItem('totalCost',cartCost - product.price);
} else if (cartCost != null) {
cartCost = parseInt(cartCost);

localStorage.setItem('totalCost', cartCost + product.price)
}else {
localStorage.setItem('totalCost', product.price)

}


}

function displayCart() {
let cartItems = localStorage.getItem('productsInCart');
cartItems = JSON.parse(cartItems);

let productContainer = document.querySelector('.products');
let cartCost = localStorage.getItem('totalCost');


if (cartItems && productContainer) {
productContainer.innerHTML = '';
Object.values(cartItems).map(item => {
 productContainer.innerHTML += `
 <div class="product">
     <ion-icon name="close-circle-outline"></ion-icon>
      <img src="images/${item.id}.jpeg">
     <span>${item.name}</span>
     </div>
     <div class="price">£${item.price}.00</div>
     <div class="quantity">
     <ion-icon class="decrease" name="remove-circle-outline"></ion-icon>
     <span>${item.inCart}</span>
     <ion-icon class="increase" name="add-circle-outline"></ion-icon>
     </div>
     <div class="total">
     £${item.inCart * item.price}.00
     </div>
     </div>
     `
})
productContainer.innerHTML += `
 <div class="basketTotalContainer">
 <h4 class="basketTotalTitle">
 Basket Total
 </h4>
 <h4 class="basketTotal">
 <?php if ($user->catagory === 'Silver') { ?>
    £${cartCost}
    Member discount 10%
    £${cartCost/10 * 9}.00
 <?php
}
?>

 </h4>
`
}
deleteButtons();
manageQuantity();
}


function deleteButtons() {
let deleteButtons = document.querySelectorAll('.product ion-icon');
let productName;
let productNumbers = localStorage.getItem('cartNumbers');
let cartItems = localStorage.getItem('productsInCart');
cartItems = JSON.parse(cartItems);
let cartCost = localStorage.getItem('totalCost');


for (let i = 0; i < deleteButtons.length; i++) {
 deleteButtons[i].addEventListener('click', () => {
   productName = deleteButtons[i].parentElement.textContent.trim()//.toLowerCase().replace(/ /g, '');
 //  console.log(productName);

   localStorage.setItem('cartNumbers', productNumbers - cartItems[productName].inCart)
   //console.log(cartItems[productName].inCart);

   localStorage.setItem('totalCost', cartCost - (cartItems[productName].price * cartItems[productName].inCart))

   delete cartItems[productName];
   localStorage.setItem('productsInCart', JSON.stringify(cartItems));

   displayCart();
   onLoadCartNumbers();
 });
 }
}

function manageQuantity() {
let decreaseButtons = document.querySelectorAll('.decrease');
let increaseButtons = document.querySelectorAll('.increase');
let cartItems = localStorage.getItem('productsInCart');
cartItems = JSON.parse(cartItems);
let currentQuantity;
let currentProduct;

for (let i = 0; i < decreaseButtons.length; i++) {
 decreaseButtons[i].addEventListener('click', () => {
   currentQuantity =decreaseButtons[i].parentElement.querySelector('span').textContent;
   currentProduct = decreaseButtons[i].parentElement.previousElementSibling.previousElementSibling.querySelector('span').textContent.trim();

   if (cartItems[currentProduct].inCart > 1) {
       cartItems[currentProduct].inCart -= 1;
   cartNumbers(cartItems[currentProduct], "decrease");
   totalCost(cartItems[currentProduct], "decrease");

   localStorage.setItem('productsInCart', JSON.stringify(cartItems));
   displayCart();
   }
 })
 }
 for (let i = 0; i < increaseButtons.length; i++) {
   increaseButtons[i].addEventListener('click', () => {
     //console.log("increase Buttons");
     currentQuantity =increaseButtons[i].parentElement.querySelector('span').textContent;

     currentProduct = increaseButtons[i].parentElement.previousElementSibling.previousElementSibling.querySelector('span').textContent.trim();

     cartItems[currentProduct].inCart += 1;
     cartNumbers(cartItems[currentProduct]);
     totalCost(cartItems[currentProduct]);

     localStorage.setItem('productsInCart', JSON.stringify(cartItems));
     displayCart();

})
}
}

onLoadCartNumbers();
displayCart();
</script>






////////////////////////////////////////////





<?php

ini_set('display_errors', 1); error_reporting(-1);
    session_start();

    include './dbconfig/db.php';



        ?>
        <?php


 ?>


            <?php
            require './include/header.html';
            ?>
            <div class="">
              <br>
              <br>
              <br>
              <br>
            </div>
            <div class="col-12">

          <table  class="table table-striped">
            <t>
            <th>Stock number</th>
            <th>Description</th>
            <th>Price</th>
            <th>Stock</th>
            <th>image</th>
            <th>quantity</th>
            <th></th>
          </t>
            <?php     $stmt = $pdo -> query('SELECT * from estock');
              while ($row = $stmt->fetch()) {

              ?>
              <tr>
              <td><?php  echo $row->stockNo ?></td>
              <td><?php  echo $row->description ?></td>
              <td><?php  echo $row->price ?></td>
              <td><?php  echo $row->qtyInStock ?></td>
              <td><img src="./images/<?php echo $row->stockNo?>.jpeg" > </td>

              <td>
                <button class="add-cart" type="button" name="button">Add to cart</button>
              </td>
            </tr>
            <?php
            } ?>
            </table>




            <script type="text/javascript">


            let carts = document.querySelectorAll('.add-cart');




                let products = [

                <?php     $stmt = $pdo -> query('SELECT * from estock');
                  while ($row = $stmt->fetch()) {
                ?>

                  {
                    id: "<?php  echo $row->stockNo ?>",
                    name: "<?php echo $row->description ?>",
                    price: <?php  echo $row->price ?>,
                    inCart: 0
                },

                <?php
                } ?>
            ]
                console.log(products);

                //console.log(products);
            for (let i = 0; i < carts.length; i++) {
            carts[i].addEventListener('click', () => {
            cartNumbers(products[i]);
            totalCost(products[i]);
            })
            }

            function onLoadCartNumbers() {
            let productNumbers = localStorage.getItem('cartNumbers');

            if (productNumbers) {
            document.querySelector('.cart span').textContent = productNumbers;
            }
            };

            function cartNumbers(product, action) {
            // console.log("The product clicked is", product);
            let productNumbers = localStorage.getItem('cartNumbers');

            productNumbers=parseInt(productNumbers);

            let cartItems = localStorage.getItem('productsInCart');
            cartItems = JSON.parse(cartItems);

            if (action == 'decrease') {
            localStorage.setItem('cartNumbers', productNumbers - 1 );
            document.querySelector('.cart span').textContent = productNumbers - 1;
            }else if(productNumbers){
            localStorage.setItem('cartNumbers', productNumbers + 1)
            document.querySelector('.cart span').textContent = productNumbers + 1;
            }else {
            localStorage.setItem('cartNumbers', 1)
            document.querySelector('.cart span').textContent = 1;

            }

            // if (productNumbers) {
            //   localStorage.setItem('cartNumbers', productNumbers + 1);
            //   document.querySelector('.cart span').textContent = productNumbers + 1;
            // } else {
            //   localStorage.setItem('cartNumbers', 1);
            //   document.querySelector('.cart span').textContent = 1;
            // }
            setItems(product);
            };

            function setItems(product) {
            let cartItems = localStorage.getItem('productsInCart');
            cartItems = JSON.parse(cartItems);
            //console.log("asfafasf", cartItems);
            // console.log('Inside of the items function');
            // console.log("my product is ", product);
            if (cartItems != null) {

            if (cartItems[product.name] == undefined) {
             cartItems = {
               ...cartItems,
               [product.name]: product
             }

            }
            cartItems[product.name].inCart += 1;
            }else {
            product.inCart = 1;

            cartItems = {
             [product.name]:product
            }
            }

            localStorage.setItem('productsInCart', JSON.stringify(cartItems))
            }

            function totalCost(product, action) {
            let cartCost = localStorage.getItem('totalCost');

            if (action == 'decrease') {
            cartCost = parseInt(cartCost);
            localStorage.setItem('totalCost',cartCost - product.price);
            } else if (cartCost != null) {
            cartCost = parseInt(cartCost);

            localStorage.setItem('totalCost', cartCost + product.price)
            }else {
            localStorage.setItem('totalCost', product.price)

            }


            }

            function displayCart() {
            let cartItems = localStorage.getItem('productsInCart');
            cartItems = JSON.parse(cartItems);

            let productContainer = document.querySelector('.products');
            let cartCost = localStorage.getItem('totalCost');


            if (cartItems && productContainer) {
            productContainer.innerHTML = '';
            Object.values(cartItems).map(item => {
             productContainer.innerHTML += `
             <div class="product">
                 <ion-icon name="close-circle-outline"></ion-icon>
                  <img src="${item.id}.jpeg">
                 <span>${item.name}</span>
                 </div>
                 <div class="price">£${item.price}.00</div>
                 <div class="quantity">
                 <ion-icon class="decrease" name="remove-circle-outline"></ion-icon>
                 <span>${item.inCart}</span>
                 <ion-icon class="increase" name="add-circle-outline"></ion-icon>
                 </div>
                 <div class="total">
                 £${item.inCart * item.price}.00
                 </div>
                 </div>
                 `
            })
            productContainer.innerHTML += `
             <div class="basketTotalContainer">
             <h4 class="basketTotalTitle">
             Basket Total
             </h4>
             <h4 class="basketTotal">
               £${cartCost}.00
             </h4>
            `
            }
            deleteButtons();
            manageQuantity();
            }


            function deleteButtons() {
            let deleteButtons = document.querySelectorAll('.product ion-icon');
            let productName;
            let productNumbers = localStorage.getItem('cartNumbers');
            let cartItems = localStorage.getItem('productsInCart');
            cartItems = JSON.parse(cartItems);
            let cartCost = localStorage.getItem('totalCost');


            for (let i = 0; i < deleteButtons.length; i++) {
             deleteButtons[i].addEventListener('click', () => {
               productName = deleteButtons[i].parentElement.textContent.trim()//.toLowerCase().replace(/ /g, '');
             //  console.log(productName);

               localStorage.setItem('cartNumbers', productNumbers - cartItems[productName].inCart)
               //console.log(cartItems[productName].inCart);

               localStorage.setItem('totalCost', cartCost - (cartItems[productName].price * cartItems[productName].inCart))

               delete cartItems[productName];
               localStorage.setItem('productsInCart', JSON.stringify(cartItems));

               displayCart();
               onLoadCartNumbers();
             });
             }
            }

            function manageQuantity() {
            let decreaseButtons = document.querySelectorAll('.decrease');
            let increaseButtons = document.querySelectorAll('.increase');
            let cartItems = localStorage.getItem('productsInCart');
            cartItems = JSON.parse(cartItems);
            let currentQuantity;
            let currentProduct;

            for (let i = 0; i < decreaseButtons.length; i++) {
             decreaseButtons[i].addEventListener('click', () => {
               currentQuantity =decreaseButtons[i].parentElement.querySelector('span').textContent;
               currentProduct = decreaseButtons[i].parentElement.previousElementSibling.previousElementSibling.querySelector('span').textContent.trim();

               if (cartItems[currentProduct].inCart > 1) {
                   cartItems[currentProduct].inCart -= 1;
               cartNumbers(cartItems[currentProduct], "decrease");
               totalCost(cartItems[currentProduct], "decrease");

               localStorage.setItem('productsInCart', JSON.stringify(cartItems));
               displayCart();
               }
             })
             }
             for (let i = 0; i < increaseButtons.length; i++) {
               increaseButtons[i].addEventListener('click', () => {
                 //console.log("increase Buttons");
                 currentQuantity =increaseButtons[i].parentElement.querySelector('span').textContent;

                 currentProduct = increaseButtons[i].parentElement.previousElementSibling.previousElementSibling.querySelector('span').textContent.trim();

                 cartItems[currentProduct].inCart += 1;
                 cartNumbers(cartItems[currentProduct]);
                 totalCost(cartItems[currentProduct]);

                 localStorage.setItem('productsInCart', JSON.stringify(cartItems));
                 displayCart();

            })
            }
            }

            onLoadCartNumbers();
            displayCart();

            </script>


            <?php
             require './include/footer.html';
             ?>
