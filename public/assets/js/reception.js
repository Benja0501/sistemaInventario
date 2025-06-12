// reception.js
document.addEventListener("DOMContentLoaded", () => {
    const orderSel = document.getElementById("purchase_order_id"),
        tableBody = document.querySelector("#rec-items-table tbody"),
        tpl = tableBody.querySelector(".item-row.d-none");

    // recalcula faltante en una fila
    function recalc(row) {
        const ord = parseInt(row.querySelector(".ord-qty").value) || 0,
            rec = parseInt(row.querySelector(".rec-qty").value) || 0,
            dam = parseInt(row.querySelector(".dam-qty").value) || 0;
        row.querySelector(".miss-qty").value = ord - rec - dam;
    }

    // enlaza eventos en una fila
    function bindRow(r) {
        r.querySelector(".rec-qty").addEventListener("input", () => recalc(r));
        r.querySelector(".dam-qty").addEventListener("input", () => recalc(r));
        r.querySelector(".btn-remove-rec-item").addEventListener("click", () =>
            r.remove()
        );
    }

    // al cambiar orden, cargar ítems via AJAX
    orderSel?.addEventListener("change", () => {
        const pid = orderSel.value;
        if (!pid) return (tableBody.innerHTML = "");
        fetch(`/purchases/${pid}/items/json`)
            .then((r) => r.json())
            .then((items) => {
                tableBody.innerHTML = "";
                items.forEach((it, index) => {
                    const row = tpl.cloneNode(true);
                    row.classList.remove("d-none");
                    // asignar valores
                    row.querySelector(".prod-name").value = it.product;
                    row.querySelector(".ord-qty").value = it.ordered;
                    row.querySelector(
                        ".rec-qty"
                    ).name = `items[${index}][quantity_received]`;
                    row.querySelector(
                        ".dam-qty"
                    ).name = `items[${index}][quantity_damaged]`;
                    row.querySelector(
                        ".miss-qty"
                    ).name = `items[${index}][quantity_missing]`;
                    recalc(row);
                    bindRow(row);
                    tableBody.appendChild(row);
                });
            });
    });

    // si estamos en edit, enlaza las filas ya existentes
    tableBody.querySelectorAll(".item-row:not(.d-none)").forEach(bindRow);
});
