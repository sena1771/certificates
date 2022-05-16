let image=document.getElementById('image');
let images=['pp.jpg' , 'zachary.jpg']
setInterval(function() {
    let random=Math.floor(Math.random() *2); /* because of the two pictures*/
 image.src=images[random];
}, 1000);
image.style.width='100%';
image.style.height='150%';