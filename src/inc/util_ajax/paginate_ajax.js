async function fetchData(currentPage, catIndex, parentElem, pagiNavi) {
  fetch(wp_get_paginate_ajax.ajax_url, {
    method: "POST",
    credentials: "same-origin",
    body: new URLSearchParams({
      action: "getpaginate",
      nonce: wp_get_paginate_ajax.nonce,
      currentPage: currentPage,
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
        parentElem.innerHTML = dataArr[1];
        pagiNavi.innerHTML = dataArr[0];
        readMore();
        handleNavi();
      });
    })
    .catch((error) => {
      console.error(error);
    });
}
const handleNavi = () => {
  document.querySelectorAll("button.page-numbers").forEach((item) => {
    item.addEventListener("click", () => {
      let currentPage = item.getAttribute("data-href");
      let parentElem = document.querySelector(".outside-reviews");
      let catIndex = document
        .querySelector(".btn-list__item.active")
        .getAttribute("data-value");
      let pagiNavi = document.querySelector(".testimonials-pagination");
      fetchData(currentPage, catIndex, parentElem, pagiNavi);
    });
  });
};
handleNavi();
