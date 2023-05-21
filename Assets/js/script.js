let hamburgermenu = document.querySelector('#menu-btn');
let userbtn=document.querySelector('#user-btn');
hamburgermenu=addEventListener('click',function() {
    let nav = this.document.querySelector('#navbar');
    nav.classList.toggle('active');
})

userbtn.addEventListener('click',function(){
    let userbox=document.querySelector('.user-box');
    userbox.classList.toggle('active');
})

function myfuc(){
    document.getElementById("name").value=null;
    document.getElementById("units").value=null;
    document.getElementById("price").value=null;
    document.getElementById("brand").value=null;
    document.getElementById("type").value=null;
    document.getElementById("detail").value=null;
}


let heading= document.querySelectorAll(".indicator li");
let contaner= document.querySelector(".box-container");
heading.forEach((li) => {
    li.addEventListener("click",removeactive);
});

function removeactive(){
    heading.forEach((li) => {
        li.classList.remove("active");
        this.classList.add("active");
    }
    );
}

const selectElement = document.querySelector('#select');

selectElement.addEventListener('change', (event) => {
    localStorage.setItem('selectedOption', event.target.value);
    event.target.form.submit();
});

if (localStorage.getItem('selectedOption')) {
    selectElement.value = localStorage.getItem('selectedOption');
}