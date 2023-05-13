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

const closeBtn= document.querySelector('#close-edit');
closeBtn.addEventListener('click',()=>{
    document.querySelector('.update-container').style.display='none';
})