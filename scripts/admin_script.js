// Get references to the navigation menu and profile elements
let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');

// Toggle the navigation menu when the menu button is clicked
document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active'); // Remove the 'active' class from the profile if present
}

// Toggle the profile when the user button is clicked
document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active'); // Remove the 'active' class from the navigation menu if present
}

// Close both the navigation menu and profile when scrolling occurs
window.onscroll = () =>{
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

// Get references to the main product image and sub-images
let mainImage = document.querySelector('.update-product .image-container .main-image img');
let subImages = document.querySelectorAll('.update-product .image-container .sub-image img');

// Add click event listeners to the sub-images for image switching
subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src'); // Get the source attribute of the clicked sub-image
      mainImage.src = src; // Set the main product image source to the clicked sub-image source
   }
});
