<template>
<div>
  <section class="hero">
    <div class="hero-section">
      <div class="image-container left">
        <img :src="`/images/home/section-1.png`" alt="#" />
        <!-- <img :src="`${$public}/hero.png`" alt="Left Image"> -->
      </div>
      <div class="hero-content">
        <div>
          <h1 class="hero-heading">Easy to move anythings<br> with <span style="color: blue;">Mooveto</span></h1>
        </div>
        <div>
          <p>Hire top notch driver, get the offer and select a best one<br class="remove-br"> according to your needs
          </p>
        </div>

        <div class="hero-content-btn d-flex align-items-center justify-content-center">
          <button class="btn">Find Job</button>
          <a href="" class="d-flex align-items-center" style="gap: 15px">Watch Video 
            <img :src="`/images/home/watch.png`" alt="#" />
          </a>
        </div>
        <!-- <div>
          <router-link :to="{ name: 'DriverLogin' }" class="driver-button">Hire Drivers</router-link>
         
        </div> -->
      </div>

      <div class="image-container right">
        <img :src="`/images/home/hero.png`" alt="Left Image">
      </div>


    </div>
  </section>

  <section class="company-section">
    <div class="d-flex justify-content-around align-items-center flex-wrap" style="gap: 30px; padding-top: 40px;">
      <div>
        <img :src="`/images/home/flutter.png`" alt="#" />
      </div>
      <div>
        <img :src="`/images/home/asana.png`" alt="#" />
      </div>
      <div>
        <img :src="`/images/home/money-africa.png`" alt="#" />
      </div>
      <div>
        <img :src="`/images/home/quidx.png`" alt="#" />
      </div>
      <div>
        <img :src="`/images/home/wallmart.png`" alt="#" />
      </div>
    </div>
    <div class="side-logo-company">
      <img :src="`/images/home/company-vector.png`" alt="#" />
    </div>
  </section>

  <section class="specialization">
    <h6>What we Do?</h6>
    <h2 class="pt-3">Our Specialization</h2>
    <div class="d-flex justify-content-center flex-wrap pt-5" style="gap: 30px;">
      <div class="card special-card" style="width: 18rem; height: 260px;">
        <div class="card-body text-start">
          <div class="d-flex align-items-center pb-4" style="gap: 10px;">
            <img width="20px" :src="`/images/home/user-services.png`" alt="#" />
            <h6 class="card-title">Users(Services Seekers)</h6>
          </div>
          <p class="card-text">Really boy law county she unable her sister. Feet you off its like like six. Among sex are leave law built now. In built table in an rapid blush. Merits behind on afraid or warmly.</p>
          <a href="#" style="color:black !important" class="card-link">Read more</a>
        </div>
      </div>
      <div class="card" style="width: 18rem; height: 260px;">
        <div class="card-body text-start">
          <div class="d-flex align-items-center pb-4" style="gap: 10px;">
            <img width="20px" :src="`/images/home/driver-services.png`" alt="#" />
            <h6 class="card-title">Driver(Services Provider)</h6>
          </div>
          <p class="card-text">Really boy law county she unable her sister. Feet you off its like like six. Among sex are leave law built now. In built table in an rapid blush. Merits behind on afraid or warmly.</p>
          <a href="#" style="color:black !important" class="card-link">Read more</a>
        </div>
      </div>
    </div>
    <button class="btn btn-primary mt-5">Learn More</button>

  </section>

  <section class="how-it-works">
    <h2>This is how you can hire a driver</h2>
    <div class="content pt-3 row justify-content-between">
      <div class="left-column col-md col-sm col-lg col-xl-4 text-start">
        <h2>How It Works</h2>
        <p>It is really as simple as the following steps:</p>
        <ul class="list-unstyled">
          <li>
            <span>1. Sign Up: Create your free Mooveto account in just a few clicks.</span>
          </li>
          <li>
            <span>2. Book a Service: Choose the delivery service you need, whether it’s same-day, scheduled, or
              something more specific.</span>
          </li>
          <li>
            <span>3. Get Matched: We’ll connect you with a nearby driver who is ready to assist with your
              delivery.</span>
          </li>
          <li>
            <span>4. Enjoy Peace of Mind: Experience seamless service as your items are carefully transported from point
              A to point B and multilocations too.</span>
          </li>
        </ul>
      </div>
      <div class="right-column col-md w-auto col-lg col-xl-8">
        <div class="step">
          <div class="icon">
            <img :src="`/images/home/job-5.png`" alt="#" />
          </div>
          <div class="details">
            <h3>Post a job as service seekers.</h3>
            <h4>Job Posting</h4>
            <p>Post by adding the relevant information in the form and add notes if there is anything extra required.
            </p>
          </div>
        </div>
        <div class="step">
          <div class="icon">
            <img :src="`/images/home/review.png`" alt="#" />
          </div>
          <div class="details">
            <h3>Integrated Approach</h3>
            <h4>Review</h4>
            <p>We will review your requirements and present you a list of shortlisted candidates based on your needs.
            </p>
          </div>
        </div>
        <div class="step">
          <div class="icon">
            <img :src="`/images/home/account.png`" alt="#" />
          </div>
          <div class="details">
            <h3>Choose the form the offers</h3>
            <h4>Select the best</h4>
            <p>See the Reviews on the profile and the availability of the driver.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="box-testimonial text-center">
    <p>Testimonails</p>
    <h2>What Customers Say</h2>
    <section class="testimonials mt-5">
      <div class="testimonial-slider">
        <div class="testimonial-card text-start">
          <h3>Superb Work!</h3>
          <p>"Blessing welcomed ladyship she met humoured sir breeding her. Six curiosity day assurance bed necessary."
          </p>
          <div class="rating">★★★★★</div>
          <div class="author">Sabo Masties</div>
        </div>
        <div class="testimonial-card text-start">
          <h3>Superb Work!</h3>
          <p>"Blessing welcomed ladyship she met humoured sir breeding her. Six curiosity day assurance bed necessary."
          </p>
          <div class="rating">★★★★★</div>
          <div class="author">Sabo Masties</div>
        </div>
        <div class="testimonial-card text-start">
          <h3>Superb Work!</h3>
          <p>"Blessing welcomed ladyship she met humoured sir breeding her. Six curiosity day assurance bed necessary."
          </p>
          <div class="rating">★★★★★</div>
          <div class="author">Sabo Masties</div>
        </div>
      </div>
      <div class="controls">
        <button :class="{ active: activeButton === 'prev', inactive: activeButton !== 'prev' }" class="prev"
          @click="toggleButton('prev')">
          <img :src="`/images/home/previous-icon.png`" alt="Previous" />
        </button>
        <button :class="{ active: activeButton === 'next', inactive: activeButton !== 'next' }" class="next"
          @click="toggleButton('next')">
          <img :src="`/images/home/next-icon.png`" alt="Next" />
        </button>
      </div>
      <!-- <div class="controls">
      <button class="prev">
        <img :src="`/images/home/previous-icon.png`" alt="#"/>
      </button>
      <button class="next">
        <img :src="`/images/home/next-icon.png`" alt="#"/>
      </button>
    </div> -->
    </section>
  </div>
</div>
</template>
<script>
import Footer from './../../components/Footer.vue';

export default {
  name: 'LandingPage',
  components: {
    Footer
  },
  data() {
    return {
      activeButton: 'next' // 'next' is active by default
    };
  },
  methods: {
    toggleButton(button) {
      this.activeButton = button;
    }
  }
}
</script>
<style scoped>
.controls .next,
.controls .prev {
  border: none;
  color: #fff;
  font-size: 1.5em;
  margin: 0 5px;
  padding: 10px 20px;
  border-radius: 50%;
  cursor: pointer;
}

.controls .next.active {
  background-color: #0AF886;
}

.controls .prev.active {
  background-color: #0AF886;
}

.controls .next.inactive,
.controls .prev.inactive {
  background: darkgrey;
  opacity: 0.5;
}

.hero-section {
  padding: 5em 2em;
  text-align: center;
  color: #000000;
  display: flex;
  /* align-items: center; */
  justify-content: space-between;
}

.hero-section h1 {
  margin: 0;
  font-size: 2.5em;
}

.hero-section p {
  margin: 0.5em 0 1.5em;
  font-size: 15px;


}

.button-group {
  display: flex;
  gap: 10px;
}

section {
  padding: 2em;
  text-align: center;
}

.feature-box {
  border: 1px solid #ccc;
  padding: 1em;
  margin: 1em;
  display: inline-block;
  width: 30%;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.hero-content {
  max-width: 50%;
}

.hero-content h1 {
  /* font-family: Inter; */
  font-size: 70px;
  font-weight: 600;
  line-height: 80px;
  letter-spacing: -0.05em;
  text-align: center;
}

.hero-content h1 span {
  color: #007bff;
}

.hero-content p {
  font-family: DM Sans;
  font-size: 18px;
  font-weight: 400;
  line-height: 26.62px;
  text-align: center;
  padding-top: 20px;
}

.hero-buttons {
  display: flex;
  gap: 20px;
}

.btn {
  text-decoration: none;
  padding: 10px 20px;
  border-radius: 5px;
  transition: background-color 0.3s;
}

.btn.primary {
  background-color: #007bff;
  color: white;
}

.btn.primary:hover {
  background-color: #0056b3;
}

.btn.secondary {
  background-color: transparent;
  color: #007bff;
  border: 2px solid #007bff;
}

.btn.secondary:hover {
  background-color: #007bff;
  color: white;
}



.hero-images {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.how-it-works {
  padding-top: 100px !important;
  padding: 20px;
  max-width: 1200px;
  margin: 0 auto;
  text-align: center;
}

.how-it-works h2 {
  font-size: 2em;
  margin-bottom: 20px;
}

.content ul {
  padding: inherit;
  font-size: 16px;
}


.left-column h2 {
  font-size: 1.5em;
}


.step {
  display: flex;
  align-items: flex-start;
  margin-bottom: 20px;
}

.icon {
  margin-right: 20px;
}

.icon img {
  width: 50px;
  height: 50px;
}

.details {
  text-align: left;
}

.details h3 {
  font-size: 1em;
  color: blue;
  margin-bottom: 5px;
}

.details h4 {
  font-size: 1.2em;
  margin-bottom: 10px;
}

.details p {
  font-size: 0.9em;
  color: #555;
}

.box-testimonial {
  padding-top: 100px;
}

.testimonials {
  text-align: center;
  padding-top: 60px;
  background-color: #F2F2F2;
  width: 50%;
  margin: auto;
}

/* .testimonials h2 {
  font-size: 2em;
  margin-bottom: 20px;
} */

.testimonial-slider {
  display: flex;
  justify-content: center;
  /* overflow: hidden; */
  position: relative;
}

.testimonial-card {
  background-color: #fff;
  border: 1px solid #eee;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  margin: 0 10px;
  padding: 20px;
  width: 300px;
  flex-shrink: 0;
  transition: transform 0.5s ease;
}

.testimonial-card h3 {
  font-size: 1.5em;
  margin-bottom: 10px;
}

.testimonial-card p {
  font-size: 1em;
  color: #666;
}

.rating {
  font-size: 1.2em;
  color: #f5a623;
  margin: 10px 0;
}

.author {
  font-size: 1em;
  font-weight: bold;
  color: #333;
}

.controls {
  /* margin-top: 20px; */
  background-color: #fff;
  width: 170px;
  margin: auto;
  margin-top: 60px;
  border-radius: 50px;
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
}

/* .controls .next {
  background-color: #00C853;
  border: none;
  color: #fff;
  font-size: 1.5em;
  margin: 0 5px;
  padding: 10px 20px;
  border-radius: 50%;
  cursor: pointer;
}
.controls .prev {
  background: none;
  border: none;
  color: #fff;
  font-size: 1.5em;
  margin: 0 5px;
  padding: 10px 20px;
  border-radius: 50%;
  cursor: pointer;
} */

/* .controls button:hover {
  background-color: #007b30;
} */

.driver-button {
  margin-top: 20px;
  padding: 20px;
  border: 1px sloid gray;
  background: #0D6EFD;
  color: #FFFFFF;
}

/* .hero-images img {
  width: 100px;
  height: auto;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
} */
.specialization {
  padding-top: 100px;
}

.specialization button {
  width: 200px;
  box-shadow: 0px 20px 0px rgb(56 54 54 / 2%);
}
.hero-content-btn{
  padding-top: 80px;
  gap: 50px;
}
.hero-content-btn button{
  background: #0D6EFD;
  color: #fff;
  padding: 10px 60px;
}
</style>
