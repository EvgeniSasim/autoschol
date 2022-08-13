(async () => {
  let btnLoad = document.querySelectorAll(".date-filter__list__item");
  let setState;
  const handleRemove = (indexThis) => {
    btnLoad.forEach((btn, index) => {
      if (index != indexThis) {
        btn.classList.remove("active");
      }
    });
  };
  btnLoad.forEach((btn, index) => {
    btn.addEventListener("click", () => {
      let indexThis = index;
      btn.classList.add("active");
      handleRemove(indexThis);
      let postDate = btn.getAttribute("data-date");
      let parentElem = document.querySelector(".slider-results__slides");
      if (setState != postDate) {
        setState = postDate;
        fetch(wp_util_ajax.ajax_url, {
          method: "POST",
          credentials: "same-origin",
          body: new URLSearchParams({
            action: "getposts",
            nonce: wp_util_ajax.nonce,
            postDate: postDate,
          }),
        })
          .then((response) => {
            if (response.status !== 200) {
              console.log("Status Code: " + response.status);
              return;
            }
            response.text().then(function (data) {
              parentElem.innerHTML = data;
              swiper.update();
            });
          })
          .catch((error) => {
            console.error(error);
          });
      }
    });
  });
})();
