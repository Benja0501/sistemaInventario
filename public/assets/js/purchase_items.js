// public/assets/js/purchase_items.js

document.addEventListener("DOMContentLoaded", function () {
    const formItem = document.getElementById("formItem");
    const itemModal = new bootstrap.Modal(document.getElementById("itemModal"));

    // Al abrir para agregar
    document.querySelectorAll(".btn-edit-item").forEach((btn) => {
        btn.addEventListener("click", () => {
            const item = JSON.parse(btn.dataset.item);
            formItem.action = `/purchase_order_items/${item.id}`;
            formItem.insertAdjacentHTML(
                "afterbegin",
                '<input type="hidden" name="_method" value="PUT">'
            );
            document.getElementById("product_id").value = item.product_id;
            document.getElementById("quantity").value = item.quantity;
            document.getElementById("unit_price").value = item.unit_price;
            document.getElementById("itemModalLabel").textContent =
                "Editar Ítem";
            itemModal.show();
        });
    });

    // Al abrir para nuevo
    document
        .querySelector('[data-bs-target="#itemModal"]')
        .addEventListener("click", () => {
            formItem.action = `{{ route('purchase_orders.items.store', $purchaseOrder) }}`;
            formItem.querySelector('input[name="_method"]')?.remove();
            document.getElementById("formItem").reset();
            document.getElementById("itemModalLabel").textContent =
                "Agregar Ítem";
        });
});
