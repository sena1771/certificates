let image=document.getElementById('image');
let images=['s1s.jpg','s2s.jpg']
setInterval(function() {
    let random=Math.floor(Math.random() *2); /* because of the two pictures*/
 image.src=images[random];
}, 2000);
image.style.width='100%';
image.style.height='100%';