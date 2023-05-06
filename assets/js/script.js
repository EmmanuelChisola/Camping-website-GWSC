'use strict';

/**
 * navbar toggle
 */

const overlay = document.querySelector("[data-overlay]");
const navOpenBtn = document.querySelector("[data-nav-open-btn]");
const navbar = document.querySelector("[data-navbar]");
const navCloseBtn = document.querySelector("[data-nav-close-btn]");
const navLinks = document.querySelectorAll("[data-nav-link]");

const navElemArr = [navOpenBtn, navCloseBtn, overlay];

const navToggleEvent = function (elem) {
  for (let i = 0; i < elem.length; i++) {
    elem[i].addEventListener("click", function () {
      navbar.classList.toggle("active");
      overlay.classList.toggle("active");
    });
  }
}

navToggleEvent(navElemArr);
navToggleEvent(navLinks);

/**
 * header sticky & go to top
 */
const header = document.querySelector("[data-header]");
const goTopBtn = document.querySelector("[data-go-top]");

window.addEventListener("scroll", function () {

  if (window.scrollY >= 200) {
    header.classList.add("active");
    goTopBtn.classList.add("active");
  } else {
    header.classList.remove("active");
    goTopBtn.classList.remove("active");
  }
});
/*Login form content*/
document.querySelector('#loginbtn').onclick = () =>{
  document.querySelector('.login-form').classList.toggle('active');
}
document.querySelector('#closeloginform').onclick = () =>{
  document.querySelector('.login-form').classList.remove('active');
}

function updateCounter(){
fetch('https://countapi.xyz/update/gwsc/ekcgwsc/?amount=1')
.then(res=> res.json())
.then(data=> counterElement.innerHTML = data.value)
}

updateCounter()

class Reviews{
  constructor(options){
    let defaults = {
      page_id: 1,
      container: document.querySelector(".reviews"),
      php_file_url: "reviews.php"
    };
    this.options = Object.assign(defaults,options);
    this.fetchReviews();
  }
  fetchReviews(){
    let url = '${this.phpFileUrl}?page_id=${this.page_Id}';
    url += "current_pagination_page" in this.options ? '&current_pagination_page=${this.currentPaginationPage}': '';
    url += "reviews_per_pagination_page" in this.option ? '&reviews_per_pagination_page=${this.reviewsPerPagination}' : '';
    url += "sort_by" in this.option ? '&sort_by=${this.sortBy}' : '';
    fetch(url).then(response => response.text()).then(data =>{
      this.container.innerHTML = data;
      this.eventHandlers();

    });
  }
  get reviewsPerPaginationPage(){
    return this.oprions.reviews_per_pagimation_page;
  }
  set reviewsPerPaginationPage(value){
    this.options.reviews_per_pagimation_page = value;
  }
  get currentPageinationPage(){
      return this.options.current_pagimations_page;
  }
  set currentPageinationPage(value){
    this.options.current_pagimations_page = value;
  }
  get pageId(){
    return this.options.page_id;
  }
  set page_Id(value){
    this.options.page_id = value;
  }
  get phpFileUrl(){
    return this.options.php_file_url;
  }
  set phpFileUrl(value){
    this.options.php_file_url = value;
  }
  get container(){
    return this.options.container;
  }
  set container(value){
    this.options.container = value;
  }
  get sortBy(){
    return this.options.sort_by;
  }
  set sortBy(value){
    this.options.sort_by = value;
  }
  _eventHandlers(){
    this.container.querySelector(".write_review_btn").onclick = event =>{
      event.preventDefault();
      this.container.querySelector(".write_review").style.display = 'block';
      this.container.querySelector(".write_review input[name='name]").focus();
    };
    this.container.querySelector(".write_review form").onsubmit = event =>{
      event.preventDefault();
      fetch('${this.phpFileUrl}?page_id=${this.page_Id}',{
        method: 'POST',
        body: new FormData(this.container.querySelector(".write_review_form"))
      }).then(response => response.text()).then(data =>{
        this.container.querySelector(".write_review").innerHTML = data;
      });
    };
    this.container.querySelector(".sort_by").onchange = event =>{
      this.sortBy = event.target.value;
      this.fetchReviews();
    };
    if (this.reviewsPerPaginationPage && this.currentPageinationPage){
      this.container.querySelectorAll(".pagination a").forEach(a =>{
        a.onclick = event =>{
          event.preventDefault();
          this.currentPageinationPage= event.target.dataset.pagination_page;
          this.reviewsPerPaginationPage = event.target.dataset.records_per_page;
          this.fetchReviews();
        };
      });
    }

  }



}