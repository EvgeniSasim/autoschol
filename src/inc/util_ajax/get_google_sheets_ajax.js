(async () => {
  let filterElem = document.querySelectorAll(".google-sheets__row__col");
  filterElem.forEach((item) => {
    let filterBtn = item.querySelector("button");
    filterBtn.addEventListener("click", () => {
      let selectCatrgory = item.querySelector("select").value;
      let selectDate = item.querySelector("input").value;
      let location = filterBtn.getAttribute("data-location");
      let table = item.querySelector(".schedule-list__item__table");
      let tableCol = item.querySelectorAll(".schedule-list__item__table__row");
      if (selectCatrgory && selectDate) {
        fetch(wp_get_sheet.ajax_url, {
          method: "POST",
          credentials: "same-origin",
          body: new URLSearchParams({
            action: "sheets",
            nonce: wp_get_sheet.nonce,
            selectCatrgory: selectCatrgory,
            selectDate: selectDate,
            location: location,
          }),
        })
          .then((response) => {
            if (response.status !== 200) {
              console.log("Status Code: " + response.status);
              return;
            }
            response.text().then(function (data) {
              let inTable;
              tableCol.forEach((item, index) => {
                if (index < 2) {
                  item.remove();
                } else {
                  inTable = item.innerHTML;
                }
              });
              table.innerHTML =
                data +
                '<div class="schedule-list__item__table__row">' +
                inTable +
                "</div>";
            });
          })
          .catch((error) => {
            console.error(error);
          });
      } else {
        alert("Не все параметры указаны...");
      }
    });
  });
})();
