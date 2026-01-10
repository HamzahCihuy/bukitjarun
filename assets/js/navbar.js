let lastScrollTop = 0;
window.addEventListener("scroll", () => {
    const navbar = document.getElementById("navbar");
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    navbar.style.transform =
        (scrollTop > lastScrollTop && scrollTop > 100)
            ? "translateY(-100%)"
            : "translateY(0)";
    lastScrollTop = scrollTop;
});
