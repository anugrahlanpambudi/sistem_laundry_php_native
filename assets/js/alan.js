// ========================================================
// Fungsi memilih customer
function selectCustomers() {
  const select = document.getElementById("customer_id");
  const phone = select.options[select.selectedIndex].getAttribute("data-phone");
  document.getElementById("phone").value = phone || "";
}

// ========================================================
// Fungsi membuka modal layanan
function openModal(service) {
  document.getElementById("modal_id").value = service.id;
  document.getElementById("modal_name").value = service.name;
  document.getElementById("modal_price").value = service.price;
  document.getElementById("modal_qty").value = service.qty || 1;

  new bootstrap.Modal("#exampleModal").show();
}

// ========================================================
// Cart global
let cart = [];

// ========================================================
// Tambah item ke cart
function addToCart() {
  const id = document.getElementById("modal_id").value;
  const name = document.getElementById("modal_name").value;
  const price = parseFloat(document.getElementById("modal_price").value);
  const qty = parseFloat(document.getElementById("modal_qty").value);

  if (!qty || qty <= 0) return alert("Masukkan quantity yang valid");

  const existing = cart.find((item) => item.id == id);

  if (existing) {
    existing.qty += qty;
  } else {
    cart.push({ id, name, price, qty });
  }

  renderCart();
}

// ========================================================
// Render cart
function renderCart() {
  const cartContainer = document.querySelector("#cartItems");
  cartContainer.innerHTML = "";

  if (cart.length === 0) {
    cartContainer.innerHTML = `
      <div class="text-center text-muted mt-5">
        <i class="bi bi-cart mb-3"></i>
        <p>Cart Empty</p>
      </div>`;
    updateTotal();
    calculateChange();
    return;
  }

  cart.forEach((item) => {
    const div = document.createElement("div");
    div.className = "cart-item d-flex justify-content-between align-items-center mb-2";
    div.innerHTML = `
      <div>
        <strong>${item.name}</strong>
        <small>Rp. ${item.price.toLocaleString()}</small>
      </div>
      <div class="d-flex align-items-center">
        <span>${item.qty} kg</span>
        <button class="btn btn-sm btn-danger ms-3" onclick="removeItem('${item.id}')">
          <i class="bi bi-trash"></i>
        </button>
      </div>`;
    cartContainer.appendChild(div);
  });

  updateTotal();
}

// ========================================================
// Hapus item dari cart
function removeItem(id) {
  cart = cart.filter((p) => p.id != id);
  renderCart();
}

// ========================================================
// Update subtotal, tax, total
function updateTotal() {
  const subtotal = cart.reduce((sum, item) => sum + item.price * item.qty, 0);
  const taxPercent = parseFloat(document.querySelector(".tax").value) || 0;
  const tax = subtotal * (taxPercent / 100);
  const total = subtotal + tax;

  document.getElementById("subtotal").textContent = `Rp. ${subtotal.toLocaleString()}`;
  document.getElementById("tax").textContent = `Rp. ${tax.toLocaleString()}`;
  document.getElementById("total").textContent = `Rp. ${total.toLocaleString()}`;

  document.getElementById("subtotal_value").value = subtotal;
  document.getElementById("tax_value").value = tax;
  document.getElementById("total_value").value = total;

  calculateChange();
}

// ========================================================
// Clear cart
document.getElementById("clearCart").addEventListener("click", function () {
  cart = [];
  renderCart();
});

// ========================================================
// Proses pembayaran
async function processPayment() {
  if (cart.length === 0) return alert("Cart masih kosong");

  const order_code = document.querySelector(".orderNumber").textContent.trim();
  const subtotal = document.querySelector("#subtotal_value").value.trim();
  const tax = document.querySelector("#tax_value").value.trim();
  const grandTotal = document.querySelector("#total_value").value.trim();
  const customer_id = parseInt(document.getElementById("customer_id").value);
  const end_date = document.getElementById("end_date").value;
  const pay = parseFloat(document.getElementById("pay").value) || 0;

  if (!customer_id) return alert("Pilih customer");
  if (!end_date) return alert("Isi tanggal selesai");
  if (pay < parseFloat(grandTotal)) return alert("Uang bayar kurang");

  try {
    const res = await fetch("add-order.php?payment", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        cart,
        order_code,
        subtotal,
        tax,
        grandTotal,
        customer_id,
        end_date,
        pay,
        change: parseFloat(document.getElementById("change").value) || 0
      }),
    });
    const data = await res.json();

    if (data.status === "success") {
      alert("Transaksi berhasil");
      window.location.href = "print.php?id=" + data.order_id;
    } else {
      alert("Transaksi gagal: " + data.message);
    }
  } catch (error) {
    console.log(error);
    alert("Ups, transaksi gagal");
  }
}

// ========================================================
// Hitung kembalian
function calculateChange() {
  const total = parseFloat(document.getElementById("total_value").value) || 0;
  const pay = parseFloat(document.getElementById("pay").value) || 0;

  let change = pay - total;
  if (change < 0) change = 0;

  document.getElementById("change").value = change;
}
