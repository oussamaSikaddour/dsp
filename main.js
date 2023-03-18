const loader = document.querySelector(".loader__container");
window.onload = () => {
  if (loader) {
    loader.classList.add("hide");
  }
};

const navHumb = document.querySelector(".nav__humb");
const navMobile = document.querySelector(".nav--mobile");
const navMobileLinks = document.querySelector(".nav--mobile .nav__links");

if (navHumb) {
  navHumb.addEventListener("click", () => {
    navHumb.classList.toggle("open");
    navMobile.style.transform = "scale(1)";
    navMobileLinks.style.transform = "translate(0,-50%)";
  });
}
const modal = document.getElementById("myModal");
const roleModal = document.getElementById("managesRolesModel");
// Get the button that opens the modal
const btns = document.querySelectorAll(".openModal");
const rolesBtns = document.querySelectorAll(".openMangeModel");
const next = document.querySelector(".next");
const formSteps = document.querySelector(".form__steps");
// Get the <span> element that closes the modal
const closeSpans = document.querySelectorAll(".modal__close");
const progress = document.querySelectorAll(".form__steps__progress span");
// When the user clicks the button, open the modal
if (btns.length > 0) {
  btns.forEach((btn) => {
    btn.addEventListener("click", function () {
      modal.style.display = "flex";
    });
  });
}

if (rolesBtns.length > 0) {
  rolesBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      roleModal.style.display = "flex";
    });
  });
}
if (next) {
  next.addEventListener("click", (e) => {
    if (progress) {
      progress[0].classList.add("active");
      progress[0].innerHTML = "&#10004;";
    }

    e.preventDefault();
    if (formSteps) {
      formSteps.style.transform = "translateX(-50%)";
    }
  });
}

if (closeSpans.length > 0) {
  closeSpans.forEach((span) => {
    span.addEventListener("click", function () {
      if (roleModal) {
        roleModal.style.display = "none";
      }
      modal.style.display = "none";
    });
  });
}

const tabLinks = document.querySelectorAll(".tab__link");

const tabs = document.querySelectorAll(".tab");
if (tabLinks.length > 0) {
  tabLinks[0].classList.add("active");
  tabs[0].classList.add("active");
  for (let [index, tabLink] of tabLinks.entries()) {
    tabLink.addEventListener("click", () => {
      // Remove the active class from all tab links and tabs
      for (let i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove("active");
        tabs[i].classList.remove("active");
      }
      // Add the active class to the clicked tab link and corresponding tab
      tabLink.classList.add("active");
      tabs[index].classList.add("active");
    });
  }
}

const rows = document.querySelectorAll("tr");
if (rows.length > 0 && rolesBtns.length === 0) {
  rows.forEach((row) => {
    row.addEventListener("click", () => {
      window.location.href = "dossier.html";
    });
  });
}

const messageButton = document.querySelector(".message__button");
const messageContainer = document.querySelector(".message__container");
const messageClose = document.querySelector(".message__close");
if (messageButton) {
  messageButton.addEventListener("click", () => {
    messageContainer.style.transform = "translateX(0)";
    messageButton.style.transform = "translateX(200%)";
  });
}

if (messageClose) {
  messageClose.addEventListener("click", () => {
    messageContainer.style.transform = "translateX(calc(100% + 1.5rem))";
    messageButton.style.transform = "translateX(0)";
  });
}
