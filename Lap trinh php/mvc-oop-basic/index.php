
const productInfo = [
  {
    id: 1,
    name: "Laptop Dell Inspiron 15",
    price: 18500000,
    category: "Laptop",
    stock: 12,
  },
  {
    id: 2,
    name: "iPhone 13",
    price: 15900000,
    category: "Điện thoại",
    stock: 8,
  },
  {
    id: 3,
    name: "Tai nghe Sony WH-1000XM4",
    price: 6500000,
    category: "Phụ kiện",
    stock: 15,
  },
  {
    id: 4,
    name: "Chuột Logitech G304",
    price: 850000,
    category: "Phụ kiện",
    stock: 25,
  },
  {
    id: 5,
    name: "Bàn phím Keychron K6",
    price: 2200000,
    category: "Phụ kiện",
    stock: 10,
  },

  {
    id: 6,
    name: "Laptop HP Pavilion 14",
    price: 17500000,
    category: "Laptop",
    stock: 9,
  },
  {
    id: 7,
    name: "MacBook Air M1",
    price: 21000000,
    category: "Laptop",
    stock: 6,
  },
  {
    id: 8,
    name: "Samsung Galaxy S21",
    price: 14000000,
    category: "Điện thoại",
    stock: 11,
  },
  {
    id: 9,
    name: "Xiaomi Redmi Note 12",
    price: 5500000,
    category: "Điện thoại",
    stock: 20,
  },
  {
    id: 10,
    name: "Oppo Reno8",
    price: 8900000,
    category: "Điện thoại",
    stock: 7,
  },

  {
    id: 11,
    name: "Tai nghe AirPods Pro",
    price: 5200000,
    category: "Phụ kiện",
    stock: 13,
  },
  {
    id: 12,
    name: "Loa JBL Flip 5",
    price: 2900000,
    category: "Phụ kiện",
    stock: 18,
  },
  {
    id: 13,
    name: "Chuột Razer DeathAdder",
    price: 1200000,
    category: "Phụ kiện",
    stock: 14,
  },
  {
    id: 14,
    name: "Bàn phím Logitech K380",
    price: 750000,
    category: "Phụ kiện",
    stock: 30,
  },
  {
    id: 15,
    name: "Màn hình Dell 24 inch",
    price: 4200000,
    category: "Phụ kiện",
    stock: 5,
  },

  {
    id: 16,
    name: "Laptop Asus TUF Gaming",
    price: 22500000,
    category: "Laptop",
    stock: 4,
  },
  {
    id: 17,
    name: "iPhone 14 Pro",
    price: 26000000,
    category: "Điện thoại",
    stock: 3,
  },
  {
    id: 18,
    name: "Samsung Galaxy Z Flip 5",
    price: 24000000,
    category: "Điện thoại",
    stock: 6,
  },
  {
    id: 19,
    name: "Tai nghe Bluetooth Anker",
    price: 900000,
    category: "Phụ kiện",
    stock: 22,
  },
  {
    id: 20,
    name: "Sạc dự phòng Xiaomi 20000mAh",
    price: 650000,
    category: "Phụ kiện",
    stock: 27,
  },
];
let id;
//In ra màn hình thông tin của những sản phẩm này
function renderProduct() {
  let renderString = "";
  productInfo.forEach((product, i) => {
    renderString =
      renderString +
      `<tr>
        <td>${i + 1}</td>
        <td>${product.name}</td>
        <td>${product.price}</td>
        <td>${product.category}</td>
        ${
          product.stock > 20
            ? `<td style="background-color: green;">${product.stock}</td>`
            : product.stock > 10
              ? `<td style="background-color: yellow;">${product.stock}</td>`
              : `<td style="background-color: red;">${product.stock}</td>`
        }
        <td>
          <button class="btn btn-sm btn-primary me-2"onclick="fillEditInfo(${i})">Sửa</button>
          <button class="btn btn-sm btn-danger" onclick="xoa(${i})">Xóa</button>
        </td>
      </tr>`;
  });
  document.getElementById("renderBody").innerHTML = renderString;
}
function xoa(id) {
  if (window.confirm("Bạn có chắc chắn muốn xóa sản phẩm này không?")) {
    console.log(id);
    productInfo.splice(id, 1);
  }
  renderProduct();
}
function addProduct(event) {
  event.preventDefault();

  let pName = document.getElementById("name").value;
  let pPrice = document.getElementById("price").value;
  let pCategory = document.getElementById("category").value;
  let pStock = document.getElementById("stock").value;
  productInfo.push({
    name: pName,
    price: pPrice,
    category: pCategory,
    stock: pStock,
  });
  renderProduct();
}
renderProduct();
function fillEditInfo(i) {
  id = i;
  document.getElementById("eName").value = productInfo[i].name;
  document.getElementById("ePrice").value = productInfo[i].price;
  document.getElementById("eCategory").value = productInfo[i].category;
  document.getElementById("eStock").value = productInfo[i].stock;
}
function editProduct(event) {
  event.preventDefault();
  let pName = document.getElementById("eName").value;
  let pPrice = document.getElementById("ePrice").value;
  let pCategory = document.getElementById("eCategory").value;
  let pStock = document.getElementById("eStock").value;
  productInfo[id] = {
    name: pName,
    price: pPrice,
    category: pCategory,
    stock: pStock,
  };
  renderProduct();
}
};