// purchase_form.js
document.addEventListener("DOMContentLoaded", () => {
    const table = document.getElementById("items-table"),
        addBtn = document.getElementById("add-item"),
        totalInput = document.getElementById("total-amount"),
        form = document.getElementById("purchase-form");

    // recalcula subtotal de una fila
    function recalcRow(row) {
        const select = row.querySelector(".product-select"),
            qty = parseFloat(row.querySelector(".qty-input").value) || 0,
            price = parseFloat(select.selectedOptions[0]?.dataset.price || 0),
            subI = row.querySelector(".subtotal-input");
        const sub = qty * price;
        subI.value = sub.toFixed(2);
    }

    // recalcula total
    function recalcTotal() {
        let sum = 0;
        table.querySelectorAll(".item-row:not(.d-none)").forEach((r) => {
            sum += parseFloat(r.querySelector(".subtotal-input").value) || 0;
        });
        totalInput.value = sum.toFixed(2);
    }

    // añade listeners a una fila dada
    function bindRow(row) {
        const select = row.querySelector(".product-select"),
            qty = row.querySelector(".qty-input"),
            remove = row.querySelector(".btn-remove-item");

        select.addEventListener("change", () => {
            recalcRow(row);
            recalcTotal();
        });
        qty.addEventListener("input", () => {
            recalcRow(row);
            recalcTotal();
        });
        remove.addEventListener("click", () => {
            row.remove();
            recalcTotal();
        });
    }

    // inicial bind para filas existentes
    table.querySelectorAll(".item-row:not(.d-none)").forEach((r) => bindRow(r));
    recalcTotal();

    // clon plantilla
    addBtn.addEventListener("click", () => {
        const template = table.querySelector(".item-row.d-none"),
            clone = template.cloneNode(true);
        clone.classList.remove("d-none");
        // reasigna índices en name[]
        const index =
            table.querySelectorAll(".item-row:not(.d-none)").length - 1;
        clone.querySelectorAll("select, input").forEach((el) => {
            if (el.name) {
                el.name = el.name.replace(/\d+/, index);
                el.value =
                    el.type === "number"
                        ? el.classList.contains("qty-input")
                            ? "1"
                            : ""
                        : "";
            }
        });
        template.parentNode.appendChild(clone);
        bindRow(clone);
    });

    // antes de submit: asegúrate de que total_amount coincide
    form.addEventListener("submit", () => recalcTotal());
});
