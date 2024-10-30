<template>
    <header id="header" >
      <div class="container-xl container-fluid d-flex justify-content-between">
        <div class="logo">
          <a v-bind:href="'/'" class="mt-3 ml-4"><span
            :class="currRoute == 'home' ? 'text-green' : ''"> <img :src="`/images/home/header-logo.svg`" /></span> </a>
          
        </div>
        <nav class="navbar navbar-expand-lg">
          <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end w-auto" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
              <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 align-items-center">
                    <li class="nav-item">
                        <a href="/" class="nav-link" exact aria-current="page">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="/about" class="nav-link">About</a>
                    </li>
                    <li class="nav-item">
                        <a href="/services" class="nav-link">Services</a>
                    </li>
                    <li class="nav-item">
                        <a href="/blog" class="nav-link">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="/contact" class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a href="/signin" class="nav-link">Sign in</a>
                    </li>
                    <li class="nav-item">
                        <a href="/driver" class="nav-link driver-btn">Driver</a>
                    </li>
                </ul>

              </div>
            </div>
          </div>
        </nav>
        <div class="top-side-img">      
          <img :src="`/images/home/Ellipse.png`"  alt="">
        </div>
      </div>
    </header>
</template>
<style>
.nav-link.active {
  position: relative;
  padding-bottom: 10px;
}

.nav-link.active::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 3px;
  /* Change this to the desired thickness */
  background-color: #0D6EFD;
  border-radius: 0 0 5px 5px;
  /* Adjust the border-radius as needed */
}
.driver-btn{
  background: #0D6EFD;
  color: white;
  width: 150px;
  height: 58px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  box-shadow: 0px 20px 10px rgb(0 0 0 / 5%);
}
</style>