// JAVASCRIPT FOR HAMBURGER ICON IN MEDIA QUERY
document.addEventListener('DOMContentLoaded', () => {
    // Get references to the hamburger menu and navigation links
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('nav-links');

    // Toggle the 'active' class on the navigation links and 'open' class on the hamburger when clicked
    hamburger.addEventListener('click', () => {
        // Toggle the 'active' class to show or hide the nav links
        const isActive = navLinks.classList.toggle('active');
        
        // Toggle the 'open' class on the hamburger icon to change its appearance
        hamburger.classList.toggle('open');
        
        // Update the 'aria-expanded' attribute for accessibility purposes
        hamburger.setAttribute('aria-expanded', isActive);
    });
});

// JAVASCRIPT FOR BACK TO TOP ICON OR BACK TO HEADER
window.onscroll = function() {
    // Get the back-to-top button element
    var backToTopButton = document.getElementById("back-to-top");

    // Check if the scroll position is greater than 50 pixels
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        // If yes, display the back-to-top button
        backToTopButton.style.display = "flex";
    } else {
        // If not, hide the back-to-top button
        backToTopButton.style.display = "none";
    }
};


// FOR CAROUSEL 
document.addEventListener("DOMContentLoaded", function () {
    const carouselItems = document.querySelectorAll(".carousel-item");
    const numericIndicatorContainer = document.getElementById("carousel-numeric-indicators");
    let currentIndex = 0;
    let interval;
    const maxVisible = 5; 
  
    const updateSlide = (index) => {
      clearActiveStates();
      currentIndex = index;
      carouselItems[currentIndex].classList.add("active");
      renderPagination();
    };
  
    const clearActiveStates = () => {
      carouselItems.forEach((item) => item.classList.remove("active"));
    };
  
    const renderPagination = () => {
      numericIndicatorContainer.innerHTML = "";
      const total = carouselItems.length;
  
      const createButton = (label, index, isActive = false) => {
        const btn = document.createElement("button");
        btn.textContent = label;
        btn.disabled = label === "...";
        if (isActive) btn.classList.add("active");
        if (!btn.disabled) {
          btn.addEventListener("click", () => {
            clearInterval(interval);
            updateSlide(index);
            restartInterval();
          });
        }
        numericIndicatorContainer.appendChild(btn);
      };
  
      if (currentIndex > 0) {
        createButton("«", currentIndex - 1);
      }
  
      const pageStart = Math.max(0, currentIndex - Math.floor(maxVisible / 2));
      const pageEnd = Math.min(total, pageStart + maxVisible);
  
      if (pageStart > 0) {
        createButton("1", 0);
        if (pageStart > 1) createButton("...");
      }
  
      for (let i = pageStart; i < pageEnd; i++) {
        createButton(i + 1, i, i === currentIndex);
      }
  
      if (pageEnd < total) {
        if (pageEnd < total - 1) createButton("...");
        createButton(total, total - 1);
      }
  
      if (currentIndex < total - 1) {
        createButton("»", currentIndex + 1);
      }
    };
  
    const restartInterval = () => {
      interval = setInterval(() => {
        const nextIndex = (currentIndex + 1) % carouselItems.length;
        updateSlide(nextIndex);
      }, 10000);
    };
  
    updateSlide(0);
    restartInterval();
  });
  

// JAVASCRIPT FOR SCROLL ANIMATION WITH ITS VARIATIONS
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        // Check if the element is in view
        if (entry.isIntersecting) {
            entry.target.classList.add('show'); // Add 'show' class to make the element visible
        } else {
            entry.target.classList.remove('show'); // Remove 'show' class to hide the element
        }
    });
});

// Observe elements with the 'hidden' class
const hiddenElements = document.querySelectorAll('.hidden');
hiddenElements.forEach((el) => observer.observe(el)); // Add each hidden element to the observer

// Observe elements with the 'hidden2' class
const hiddenElements2 = document.querySelectorAll('.hidden2');
hiddenElements2.forEach((el) => observer.observe(el)); // Add each hidden element to the observer

// Observe elements with the 'hidden3' class
const hiddenElements3 = document.querySelectorAll('.hidden3');
hiddenElements3.forEach((el) => observer.observe(el)); // Add each hidden element to the observer

