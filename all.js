const my=gsap.timeline({defaults: { ease: "power1.out"}}); /*gsap library for sliding process */
my.to( ".mytext",{y:"0%",duration:1}); /* 1 second */
my.to(".slide",{y:"-100%",duration:1,delay:0.5});
my.to(".start",{y:"-100%",duration:0.5});