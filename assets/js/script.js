const rooms = document.querySelector('#rooms');
const about = document.querySelector('#about');
const home = document.querySelector('.home');
const ar = [rooms, about];
window.addEventListener('scroll',function (){
    var x = document.querySelectorAll('.carousel-item');
    for(let i=0;i<x.length;i++){
        x[i].style.backgroundPositionY = (window.scrollY*0.7)  + 'px';
    }
    let a = document.querySelector('nav');
    if(window.scrollY>=240){
        if(!a.classList.contains('nav-scrolled')){
            a.classList.add('nav-scrolled');
        }
    } else {
        if(a.classList.contains('nav-scrolled')){
            a.classList.remove('nav-scrolled');
        }
    }

    const scrollY = window.pageYOffset;
    let isInter = false;
    for(let i=0;i<2;i++){
        let current = ar[i];
        let sectionId = current.getAttribute('id');
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 50;
        let sec = document.querySelector('.nav-links li a[href*=' + sectionId + ']');
        if(scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
            if(!sec.classList.contains('active')){
                sec.classList.add('active');
            }
            isInter = true;
        } else {
            sec.classList.remove('active');
        }
    }
    if(!isInter && !home.classList.contains('active')){
        home.classList.add('active');
    } else if(isInter && home.classList.contains('active')) {
        home.classList.remove('active');
    }
});
document.addEventListener('DOMContentLoaded',function (){
    var x = document.querySelectorAll('.carousel-item');
    for(let i=0;i<x.length;i++){
        x[i].style.background = 'url(/assets/images/'+(i+1)+'.jpg)';
        x[i].style.backgroundSize = 'cover';
    }
    const days_c = document.querySelector('.days');
    const months_c = document.querySelector('.months');
    const hours_c = document.querySelector('.hours');
    const minutes_c = document.querySelector('.mins');
    const seconds_c = document.querySelector('.sec');
    var countDownDate = new Date().getTime() + (1000*60*60*2);
    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var months = Math.floor(distance / (1000 * 60 * 60 * 24 * 30));
        var days = Math.floor(distance % (1000 * 60 * 60 * 24 * 30) / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        if(months<10){
            months = '0' + months;
        }
        if(days<10){
            days = '0' + days;
        }
        if(hours<10){
            hours = '0' + hours;
        }
        if(minutes<10){
            minutes = '0' + minutes;
        }
        if(seconds<10){
            seconds = '0' + seconds;
        }
        months_c.innerHTML = months;
        days_c.innerHTML = days;
        hours_c.innerHTML = hours;
        minutes_c.innerHTML = minutes;
        seconds_c.innerHTML = seconds;
        if (distance <= 0) {
            clearInterval(x);
            months_c.innerHTML = '00';
            days_c.innerHTML = '00';
            hours_c.innerHTML = '00';
            minutes_c.innerHTML = '00';
            seconds_c.innerHTML = '00';
            document.querySelector(".countdown_title").innerHTML = "This offer has expired";
        }
    }, 1000);
});

const navSlide = () =>{
    const burger = document.querySelector('.burger');  
    const nav = document.querySelectorAll('.nav-links li');
    const bar = document.querySelector('.nav-links');
    burger.addEventListener('click',()=>{
        bar.classList.toggle('nav-active');
        nav.forEach((link,index) => {
            if(link.style.animation){
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index/7 + 0.5}s`;
            }
        });
        burger.classList.toggle('toggle');
    });
}
function enlarge(params){
    let src = params.getAttribute('src');
    window.open('/show-img?q='+src, '_blank');
}
function copyToClip(params){
    var copyText = 'SUMMER50';
    navigator.clipboard.writeText(copyText);
    alert("PROMO CODE : SUMMER50\nIt has been copied\nYou can apply it now");
}
navSlide();