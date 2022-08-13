const handleSortPosts = async (getCatId, sortAttr) => {
  let setPostElem = document.querySelector(".promotions-list");
  fetch(wp_get_blogPostSortData_ajax.ajax_url, {
    method: "POST",
    credentials: "same-origin",
    body: new URLSearchParams({
      action: "getblogPostSortData",
      nonce: wp_get_blogPostSortData_ajax.nonce,
      catId: getCatId,
      sortAttr: sortAttr,
    }),
  })
    .then((response) => {
      if (response.status !== 200) {
        console.log("Status Code: " + response.status);
        return;
      }
      response.text().then(function (data) {
        setPostElem.innerHTML = data;
      });
    })
    .catch((error) => {
      console.error(error);
    });
};
//// Blog filter
let catIdArr = [];
let sortAttr = [];
let getCatId = "";
(() => {
  if (document.querySelector(".blog-filters__dropdown > button")) {
    let openBtn = document.querySelector(".blog-filters__dropdown > button");
    let filtersList = document.querySelector(".dropdown-filter");
    openBtn.addEventListener("click", () => {
      filtersList.classList.toggle("active");
      openBtn.classList.toggle("active");
    });
  }
})();
const handlePostFiltered = () => {
  if (document.querySelectorAll(".dropdown-filter__list > button")) {
    let tags = document.querySelectorAll(".dropdown-filter__list > button");
    tags.forEach((tag) => {
      let getTagColor = tag.getAttribute("data-tag-color");
      const addBgColor = () => {
        tag.style.background = getTagColor;
        tag.style.color = "#fff";
      };
      const removeBgColor = () => {
        tag.style.background = "";
        tag.style.color = "";
      };
      if (!tag.classList.contains("active")) {
        tag.addEventListener("mouseover", addBgColor);
        tag.addEventListener("mouseout", removeBgColor);
      }
      tag.addEventListener("click", () => {
        getCatId = tag.getAttribute("data-tag-id");
        if (!catIdArr.includes(getCatId, 0)) {
          catIdArr.push(getCatId);
        } else {
          let removeIndex = catIdArr.indexOf(getCatId);
          if (catIdArr.length === 1) {
            catIdArr = [];
          } else {
            catIdArr.splice(removeIndex, 1);
          }
        }
        getCatId = catIdArr.join(",");
        handleSortPosts(getCatId, sortAttr);
        tag.classList.toggle("active");
        if (!tag.classList.contains("active")) {
          removeBgColor();
          tag.addEventListener("mouseout", removeBgColor);
        } else {
          tag.removeEventListener("mouseout", removeBgColor);
          addBgColor();
        }
      });
    });
  } else {
    return;
  }
};
handlePostFiltered();
/// Sort blog
(() => {
  if (document.querySelectorAll(".blog-filters__sort-list > button")) {
    let sortBtns = document.querySelectorAll(
      ".blog-filters__sort-list > button"
    );
    sortBtns.forEach((item) => {
      item.addEventListener("click", () => {
        item.classList.toggle("active");
        let dataAttr = item.getAttribute("data-sort");
        let removeIndex = sortAttr.indexOf(dataAttr);
        if (item.classList.contains("active")) {
          sortAttr.push(dataAttr);
        } else {
          sortAttr.splice(removeIndex, 1);
        }
        handleSortPosts(getCatId, sortAttr.join(","));
      });
    });
  }
})();
