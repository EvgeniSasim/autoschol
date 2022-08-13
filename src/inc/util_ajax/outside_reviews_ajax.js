(async () => {
  let btnLoad = document.querySelectorAll(
    ".btn-list.outside-reviews-btn > .btn-list__item"
  );
  let pagiNavi = document.querySelector(".testimonials-pagination");
  btnLoad.forEach((btn) => {
    btn.addEventListener("click", () => {
      let catIndex = btn.getAttribute("data-value");
      let parentElem = document.querySelector(".outside-reviews");

      fetch(wp_get_reviews_ajax.ajax_url, {
        method: "POST",
        credentials: "same-origin",
        body: new URLSearchParams({
          action: "getreviews",
          nonce: wp_get_reviews_ajax.nonce,
          catIndex: catIndex,
        }),
      })
        .then((response) => {
          if (response.status !== 200) {
            console.log("Status Code: " + response.status);
            return;
          }
          response.text().then(function (data) {
            dataArr = data.split("***");
            if (dataArr[1]) {
              parentElem.innerHTML = dataArr[1];
              pagiNavi.innerHTML = dataArr[0];
            } else {
              parentElem.innerHTML = data;
              pagiNavi.innerHTML = "";
            }
            handleNavi();
            readMore();
          });
        })
        .catch((error) => {
          console.error(error);
        });
    });
  });
})();
