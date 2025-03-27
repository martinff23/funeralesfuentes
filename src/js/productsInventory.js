// (function(){
//     const productSelect = document.querySelector('#product_select');
//     if(productSelect){
//         let product = {
//             product_id : ''
//         };

//         productSelect.addEventListener('change', searchParameters);

//         function searchParameters(event){
//             product[event.target.name] = event.target.value;

//             if(Object.values(product).includes('')){
//                 return;
//             }

//             searchInventory();
//         }

//         async function searchInventory() {
//             const { product_id } = product;
//             const url = `/api/product-inventory?product_id=${product_id}`;
//             const result = await fetch(url);
//             const inventory = await result.json();
//             fetchInventory();
//         }

//         function fetchInventory(){
//             const availableProducts = document.querySelectorAll('#product_select option');
//             console.log(availableProducts);
//             // availableProducts.forEach(availableProduct => availableProduct.addEventListener('change', selectProduct));
//             availableProducts.forEach(availableProduct => {console.log(availableProduct)});
//         }

//         function selectProduct(event){
//             console.log(event.target.value);
//         }

//     }
// })();