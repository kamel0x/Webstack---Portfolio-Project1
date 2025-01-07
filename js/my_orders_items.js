document.addEventListener("DOMContentLoaded", function () {
    const orderRows = document.querySelectorAll(".order-row");
    let currentPage = 1;
    const itemsPerPage = 3;
    let fetchedItems = [];
  
    orderRows.forEach((row) => {
      row.addEventListener("click", function () {
        const orderId = this.getAttribute("data-order-id");
        fetch("get_order_items.php?order_id=" + orderId)
          .then((response) => response.json())
          .then((data) => {
            fetchedItems = data;
            currentPage = 1;
            showPage(currentPage);
          })
          .catch((error) => {
            console.error("Error fetching order items:", error);
          });
      });
    });
  
    function showPage(page) {
      const container = document.getElementById("order-items-container");
      container.innerHTML = "";
  
      const start = (page - 1) * itemsPerPage;
      const end = page * itemsPerPage;
      const paginatedItems = fetchedItems.slice(start, end);
  
      if (paginatedItems.length === 0) {
        container.innerHTML = "<p>No items found for this order.</p>";
        return;
      }
  
      paginatedItems.forEach((item) => {
        const itemDiv = document.createElement("div");
        itemDiv.classList.add("item");
        itemDiv.innerHTML = `
                  <div class="item-image">
                      <img src="${item.image}" alt="${item.name}">
                      <div class="item-price">${item.price} EGP</div>
                  </div>
                  <div class="item-info">
                      <span>${item.name}</span> x 
                      <span>${item.quantity}</span>
                  </div>
              `;
  
        container.appendChild(itemDiv);
      });
  
      document.querySelector(".page-number").textContent = page;
    }
  
    document.querySelector(".prev-page").addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
      }
    });
  
    document.querySelector(".next-page").addEventListener("click", () => {
      const totalPages = Math.ceil(fetchedItems.length / itemsPerPage);
      if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
      }
    });
  
    ////////
  
    //////////////////////////////////////////////////////////////
    function attachEventListeners() {
      // Attach event listeners to cancel buttons and order rows
      document.querySelectorAll(".cancel-btn").forEach((button) => {
        button.addEventListener("click", function (e) {
          e.preventDefault();
  
          const orderId = this.getAttribute("data-order-id");
          const row = this.closest(".order-row");
  
          if (confirm("Are you sure you want to cancel this order?")) {
            fetch("cancel_order.php", {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded",
              },
              body: new URLSearchParams({
                order_id: orderId,
              }),
            })
              .then((response) => response.text())
              .then((result) => {
                console.log("Server response:", result);
                if (result === "success") {
                  row.remove();
                } else {
                  alert("Failed to cancel the order. Please try again.");
                }
              })
              .catch((error) => {
                console.error("Fetch error:", error);
                alert("Failed to cancel the order. Please try again.");
              });
          }
        });
      });
  
      document.querySelectorAll(".order-row").forEach((row) => {
        row.addEventListener("click", function () {
          var totalPrice = this.getAttribute("data-total");
          document.getElementById("total-price").innerText = "EGP " + totalPrice;
        });
      });
    }
  
    //////////////////////////////////////////////////////
  
    // Attach event listeners to existing elements
    attachEventListeners();
  
    document.getElementById("date-from").addEventListener("change", filterOrders);
    document.getElementById("date-to").addEventListener("change", filterOrders);
  
    function filterOrders() {
      var dateFrom = document.getElementById("date-from").value;
      var dateTo = document.getElementById("date-to").value;
  
      if (dateFrom && dateTo) {
        var xhr = new XMLHttpRequest();
        xhr.open(
          "GET",
          "my_orders.php?date_from=" +
            encodeURIComponent(dateFrom) +
            "&date_to=" +
            encodeURIComponent(dateTo),
          true
        );
        xhr.onload = function () {
          if (this.status == 200) {
            var response = this.responseText;
  
            // Replace only the order table body with the new filtered data
            var orderList = document.getElementById("order-list");
            orderList.innerHTML = response;
  
            // Re-attach event listeners to the new rows
            attachEventListeners();
          }
        };
        xhr.send();
      }
    }
  });
  