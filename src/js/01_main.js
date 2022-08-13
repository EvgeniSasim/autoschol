/**********Sticky header ************ */
document.addEventListener("DOMContentLoaded", onDOMReady);
function onDOMReady() {
  window.addEventListener("scroll", onWindowScroll);
  let menuHeader = document.querySelector("header");
  function onWindowScroll() {
    if (window.document.scrollingElement.scrollTop > 121) {
      menuHeader.classList.add("sticky");
    } else {
      menuHeader.classList.remove("sticky");
    }
  }
}
//////********** Simple Header Menu ********************///////////
const handlePopper = (itemMenu, simpleTooltip) => {
  let popper = Popper.createPopper(itemMenu, simpleTooltip, {
    placement: "bottom",
    modifiers: [
      {
        name: "offset",
        options: {
          offset: () => {
            if (window.document.scrollingElement.scrollTop < 150) {
              return [0, 12];
            } else {
              return [0, 12];
            }
          },
        },
      },
    ],
  });
  return popper;
};
const popoverMenu = () => {
  const showEvents = ["mouseenter", "focus"];
  const hideEvents = ["mouseleave", "blur"];
  let simpleLink = document.querySelectorAll(".menu-item-has-children");
  let indexArr = [];
  simpleLink.forEach((item, index) => {
    let simpleTooltip = item.querySelector(".sub-menu");
    // let linkDefoult = item.querySelector("a");
    // linkDefoult.addEventListener("click", (event) => event.preventDefault());
    let itemMenu = item;

    handlePopper(itemMenu, simpleTooltip);

    const hide = () => {
      if (index !== indexArr[0]) {
        let num = indexArr[0];
        simpleLink[num].querySelector(".sub-menu").classList.remove("visibil");
        indexArr = [index];
      } else {
        indexArr = [index];
      }
    };
    showEvents.forEach((event) => {
      item.addEventListener(event, () => {
        simpleTooltip.classList.add("visibil");
        indexArr.push(index);
        hide();
      });
    });
    hideEvents.forEach((event) => {
      item.addEventListener(event, () => {
        simpleTooltip.classList.remove("visibil");
      });
    });
  });
};

const menu = () => {
  if (window.screen.width > 980) {
    popoverMenu();
  }
  if (window.screen.width <= 980) {
    let simpleLink = document.querySelectorAll(".menu-item-has-children");
    simpleLink.forEach((item) => {
      let simpleTooltip = item.querySelector(".sub-menu");
      item.addEventListener("click", () => {
        simpleTooltip.classList.toggle("visibil");
        item.classList.toggle("active");
      });
    });
  }
};
menu();
/////////////* Burger Menu *////////////////////////////
const burgerMenu = () => {
  const pushmenu = document.querySelectorAll(".pushmenu");
  const hiddenOverley = document.querySelector(".hidden-overley");

  hiddenOverley.addEventListener("click", (e) => {
    e.currentTarget.classList.toggle("show");
    document.querySelector(".navbar-header").classList.toggle("show");
    for (i = 0; i < pushmenu.length; i++) {
      pushmenu[i].classList.toggle("open");
    }
  });

  const pushmenuFunction = () => {
    document.querySelector(".pushmenu").classList.toggle("open");
    document.querySelector(".navbar-header").classList.toggle("show");
    document.querySelector(".hidden-overley").classList.toggle("show");
  };

  for (i = 0; i < pushmenu.length; i++) {
    pushmenu[i].addEventListener("click", pushmenuFunction, false);
  }

  const navbarHeaderAccordeon = document.querySelectorAll(
    ".navbar-header .menu-parent-item a:first-child"
  );
  const accordeonFunction = () => {
    this.parentNode.querySelector("ul").classList.toggle("show");
    this.querySelector("i").classList.toggle("rotate");
  };

  for (i = 0; i < navbarHeaderAccordeon.length; i++) {
    navbarHeaderAccordeon[i].addEventListener(
      "click",
      accordeonFunction,
      false
    );
  }
};
burgerMenu();
//// Colorese text
const colorese = (selector) => {
  let subTitle = document.querySelectorAll(selector);
  subTitle.forEach((item) => {
    let arr = item.innerHTML.split(" ");
    arr[1] = "<span>" + arr[1] + "</span>";
    arr[3] = "<span>" + arr[3];
    arr[arr.length - 1] = arr[arr.length - 1] + "</span>";
    item.innerHTML = arr.join(" ");
  });
};
///// Modal (pop-up)
// class Modal {
//   static closeSelector = ".close-modal";
//   static containSelector = ".container";
//   constructor(id) {
//     this.id = id;
//     this.eventBtn = ".btn-" + this.id;
//     this.modalId = this.id + "-modal";
//     this.closeSelector = this.$getModal = document.getElementById(this.modalId);
//     this.$getModal = document.getElementById(this.modalId);
//     this.$getBtn = document.querySelectorAll(this.eventBtn);
//     this.$closeBtn = this.$getModal.querySelector(Modal.closeSelector);
//     this.$modalContain = this.$getModal.querySelector(Modal.containSelector);
//   }
//   openModal() {
//     this.$getModal.classList.add("show");
//     document.querySelector("body").classList.add("stop");
//   }
//   closeModal() {
//     this.$getModal.classList.remove("show");
//     document.querySelector("body").classList.remove("stop");
//   }
//   showNoti() {
//     this.$modalContain.classList.add("show");
//     setTimeout(this.hideNoti, 1500);
//   }
//   hideNoti() {
//     this.closeModal(this);
//     setTimeout(this.$modalContain.classList.remove("show"), 1000);
//   }
//   addEvents() {
//     this.$getBtn.forEach((item) =>
//       item.addEventListener("click", () => {
//         this.openModal(this);
//       })
//     );
//     this.$getModal.addEventListener("click", (e) => {
//       this.$modalContain.contains(e.target) ? "" : this.closeModal(this);
//     });
//     this.$closeBtn.addEventListener("click", () => this.closeModal(this));
//     document.addEventListener("keydown", (e) => {
//       e.key === "Escape" ? this.closeModal(this) : "";
//     });
//     document.addEventListener(
//       "wpcf7mailsent",
//       (event) => {
//         if (event.detail.contactFormId == this.id) {
//           this.showNoti(this);
//         }
//       },
//       false
//     );
//   }
// }
// const mdaltest = new Modal(109);
// mdaltest.addEvents();

const modal = (id) => {
  let eventBtn = ".btn-" + id;
  let modalId = id + "-modal";
  let getModal = document.getElementById(modalId);
  let getBtn = document.querySelectorAll(eventBtn);
  let closeBtn = getModal.querySelector(".close-modal");
  let modalContain = getModal.querySelector(".container");

  const openModal = () => {
    getModal.classList.add("show");
    document.querySelector("body").classList.add("stop");
  };
  const closeModal = () => {
    getModal.classList.remove("show");
    document.querySelector("body").classList.remove("stop");
  };
  const showNoti = () => {
    modalContain.classList.add("show");
    setTimeout(hideNoti, 1500);
  };
  const hideNoti = () => {
    closeModal();
    setTimeout(modalContain.classList.remove("show"), 1000);
  };

  getBtn.forEach((item) => item.addEventListener("click", openModal));
  getModal.addEventListener("click", (e) => {
    modalContain.contains(e.target) ? "" : closeModal();
  });

  closeBtn.addEventListener("click", closeModal);
  document.addEventListener("keydown", (e) => {
    e.key === "Escape" ? closeModal() : "";
  });

  document.addEventListener(
    "wpcf7mailsent",
    (event) => {
      if (event.detail.contactFormId == id) {
        showNoti();
      }
    },
    false
  );
};
/// Rank stars
function executeRating() {
  const ratingStars = [...document.getElementsByClassName("rank__list__star")];
  const starsLength = ratingStars.length;
  const starClassActive = "rank__list__star active";
  const starClassUnactive = "rank__list__star disable";
  let i;
  ratingStars.map((star) => {
    star.onclick = () => {
      i = ratingStars.indexOf(star);
      if (star.className.indexOf(starClassUnactive) !== -1) {
        printRatingResult(i + 1);
        for (i; i >= 0; --i) ratingStars[i].className = starClassActive;
      } else {
        printRatingResult(i);
        for (i; i < starsLength; ++i)
          ratingStars[i].className = starClassUnactive;
      }
    };
  });
  document.addEventListener("wpcf7submit", (event) => {
    let inputV = event.detail.inputs;
    let inputNum = document
      .querySelector('input[type="number"]')
      .getAttribute("name");
    inputV.forEach((item) => {
      if (item.value == 0 && item.name == inputNum) {
        document.querySelectorAll(".rank__list__star").forEach((item) => {
          item.classList.add("invalid");
        });
        setTimeout(() => {
          document.querySelectorAll(".rank__list__star").forEach((item) => {
            item.classList.remove("invalid");
          });
          document.querySelectorAll(".wpcf7-not-valid-tip").forEach((el) => {
            el.remove();
          });
        }, 2000);
      }
    });
  });
  document.querySelector("#instructors-name").value =
    document.querySelector("h1").innerHTML;
}
function printRatingResult(num = 0) {
  document.querySelector("input[type='number']").value = num;
}
///// Teacher filter
const filterTeachers = () => {
  let btnList = document.querySelectorAll(".btn-list__item");
  let selectRank = document.querySelector("#select-rank");
  let selectCat = document.querySelector("#select-cat");
  let sortRank;
  let sortCat;
  let person = "teach";
  btnList.forEach((item, index) => {
    const action = () => {
      let activeElem = item.getAttribute("class").indexOf("active");
      if (activeElem === -1) {
        person = item.getAttribute("data-value");
        dataRank = item.getAttribute("data-rank");
        filterPersons(person, sortCat, sortRank);
        item.classList.add("active");
        disableBtn(index);
      }
    };
    item.addEventListener("click", action);
  });
  if (selectRank || selectCat) {
    selectRank.addEventListener("change", () => {
      sortRank = selectRank.value;
      sortingRank(sortRank);
    });
    selectCat.addEventListener("change", () => {
      sortCat = selectCat.value;
      filterPersons(person, sortCat);
    });
  }
  const disableBtn = (index) => {
    btnList.forEach((item, key) => {
      if (index !== key) {
        item.classList.remove("active");
      }
    });
  };
  const filterPersons = (person, sortCat) => {
    let allPersons = document.querySelectorAll(
      ".instructors-and-teachers__list__item"
    );
    allPersons.forEach((item) => {
      let dataValue = item.getAttribute("data-value");
      if (dataValue.indexOf(person) !== -1) {
        item.classList.add("active");
      } else {
        item.classList.remove("active");
      }
    });
  };
  const sortingRank = (sortRank) => {
    if (sortRank === "ABC") {
      let arr = [].slice.call(
        document.querySelectorAll(".instructors-and-teachers__list__item")
      );
      arr.sort(function (a, b) {
        return a.getAttribute("data-rank") - b.getAttribute("data-rank");
      });
      document.querySelector(".instructors-and-teachers__list").innerHTML = "";
      arr.forEach((item) => {
        document
          .querySelector(".instructors-and-teachers__list")
          .insertAdjacentHTML("afterbegin", item.outerHTML);
      });
    }
    if (sortRank === "ZWX") {
      let arr = [].slice.call(
        document.querySelectorAll(".instructors-and-teachers__list__item")
      );
      arr.sort(function (a, b) {
        return b.getAttribute("data-rank") - a.getAttribute("data-rank");
      });
      document.querySelector(".instructors-and-teachers__list").innerHTML = "";
      arr.forEach((item) => {
        document
          .querySelector(".instructors-and-teachers__list")
          .insertAdjacentHTML("afterbegin", item.outerHTML);
      });
    }
  };
};
//////////////TAB MENU //////////////////////////
const tabMenu = (navTabsSelector, contentTabsSelector) => {
  let tabsNavi = document.querySelectorAll(navTabsSelector);
  let tabsContent = document.querySelectorAll(contentTabsSelector);
  tabsNavi.forEach((tab, index) => {
    tab.addEventListener("click", (event) => {
      let indexThis = index;
      event.preventDefault();
      tab.classList.add("active");
      tabsContent[index].classList.add("active");
      tabsContent.forEach((item) => {
        item.classList.add("active");
      });
      handleRemove(indexThis, tabsNavi, tabsContent);
    });
  });
  const handleRemove = (indexThis, tadsElem, tabsElemContent) => {
    tadsElem.forEach((tab, index) => {
      if (index != indexThis) {
        tab.classList.remove("active");
      }
    });
    tabsElemContent.forEach((tab, index) => {
      if (index != indexThis) {
        tab.classList.remove("active");
      }
    });
  };
};
//// Read More
const readMore = () => {
  let readMoreContainer = document.querySelectorAll(".outside-reviews__item");
  readMoreContainer.forEach((item) => {
    if (
      item.contains(item.querySelector("button.read-more")) &&
      item.querySelector("button.read-more")
    ) {
      let btn = item.querySelector("button.read-more");
      btn.addEventListener("click", () => {
        item.addEventListener(
          "click",
          (event) => {
            event.preventDefault();
          },
          { once: true }
        );
        item
          .querySelector(".outside-reviews__item__descr")
          .classList.add("active");
      });
    }
  });
};
//// Form services
const getInputHidden = () => {
  if (document.querySelector("#select-date-input")) {
    let hiddenInput = document.querySelector("#select-date-input");
    let selectDate = document.querySelector("#select__schedule");
    hiddenInput.value = selectDate.value;
    selectDate.addEventListener("change", () => {
      hiddenInput.value = selectDate.value;
    });
  }
};
getInputHidden();
