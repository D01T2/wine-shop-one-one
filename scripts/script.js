//the menu changes button from 3 vertical lines into an X
function toggleNav(x) {

  const naviMenu = document.querySelector('.navi-menu');

  x.classList.toggle("change");
  naviMenu.classList.toggle("show-nav");
};

//in the events section are 3 tabs which now are in desktop mode inline and mobile column.
$( function() {
  $("#tabs").tabs();
});

