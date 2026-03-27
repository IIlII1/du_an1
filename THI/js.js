const products = [
{
    id: 1, 
    name: "Iphone 13",
    price: 200000000,
    category: "phone",
    stock: 10,
},

{
    id: 2, 
    name: "Samsung S21",
    price: 180000000,
    category: "phone",
    stock: 0,
},

{
    id: 3, 
    name: "Macbook Air",
    price: 250000000,
    category: "Laptop",
    stock: 3,
},

];
let editIndex = -1;
function renderProduct(){
    let renderString = "";
    productInfo.forEach((product, index) => {
        renderString += `tr`
    })
    html = "";
    for(let i = 0; i < data.length; i++){
        html += `<tr>
        <td>${i+ 1}</td>
        td>${data[i].name}</td>
        td>${data[i].price}</td>
        td>${data[i].category}</td>
        td>${data[i].stock}</td>

        </tr>`
    }
    document.getElementById("target").innerHTML = html;

}
render(products);
event.preventDefault();
function addProduct(){
    const name = document.getElementById("name").value;
    const price = document.getElementById("price").value;
    const category = document.getElementById("category").value;
    const stock = document.getElementById("stock").value;
    const newProduct = {
        id: products.length + 1,
        name : name,
        price : price,
        category : category,
        stock : stock,
    };
    products.push(newProduct);
    render(products);
        
    
}
function xoa(i){
    if(window.confirm("ban co muon xoa ?")){
        console.log(id);
        productInfo.spile(i,1);
    }
    render(products);

}
