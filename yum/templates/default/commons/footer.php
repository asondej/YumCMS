
<!--============================
=            Footer            =
=============================-->

<footer class="footer-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="block text-center">
            <div class="footer-logo">
              <!-- <img src="images/footer-logo.png" alt="logo" class="img-fluid"> -->
            </div>
          </div>
          
        </div>
      </div>
    </div>
</footer>
<!-- Subfooter -->
<footer class="subfooter">
  <div class="container">
    <div class="row">
      <div class="col-md-6 align-self-center">
        <div class="copyright-text">
          <p><a href="#">Yum</a> 2021 </p>
		  <p><a href="https://www.flaticon.com/packs/cooking-176">cooking icon pack</a>, <a href="https://www.flaticon.com/packs/food-45">food icon pack</a> and <a href="https://www.flaticon.com/packs/breakfast-42">breakfast icon pack</a>
			<a href="https://github.com/thephpleague/commonmark">league/commonmark markdown parser</a> and it's based on <a href="https://themefisher.com/products/eventre-event-conference-website-template/">Evetre</a> template
		</p>
        </div>
      </div>
      <div class="col-md-6">
          <a href="#" class="to-top"><i class="fa fa-angle-up"></i></a>
      </div>
    </div>
  </div>
</footer>

  <script src="js/all.js"></script>
 
	<script>
			class BS4breakpoints {
				constructor(delay = 350, prefix = "current breakpoint", ) {
					this.prefix = prefix;
					this.delay = delay;
					this.build();
					this.xl = document.querySelector("#BS4breakpoints .xl");
					this.lg = document.querySelector("#BS4breakpoints .lg");
					this.md = document.querySelector("#BS4breakpoints .md");
					this.sm = document.querySelector("#BS4breakpoints .sm");
					this.xs = document.querySelector("#BS4breakpoints .xs");
				}

			build() {

				let breakpoints = {
					xl: "d-none d-xl-block xl",
					lg: "d-none d-lg-block d-xl-none lg",
					md: "d-none d-md-block d-lg-none md",
					sm: "d-none d-sm-block d-md-none sm",
					xs: "d-block d-sm-none xs",
				}
				var parent = document.createElement("div");
				parent.id = "BS4breakpoints";
					for (const breakpoint in breakpoints) {

						let child = document.createElement("div");
						child.className = breakpoints[breakpoint]; 
						parent.appendChild(child);
					}
				document.body.appendChild(parent);
			}	
			detect() {
				if(window.getComputedStyle(this.xl).getPropertyValue("display") == "block") {
					console.log('%c Bootstrap 4 breakpoint ', 'background: #222; color: #bada55');
					console.log(this.prefix+": xl");
				} else if(window.getComputedStyle(this.lg).getPropertyValue("display") == "block") {
					console.log('%c Bootstrap 4 breakpoint ', 'background: #222; color: #bada55');
					console.log(this.prefix+": lg");
				} else if(window.getComputedStyle(this.md).getPropertyValue("display") == "block") {
					console.log('%c Bootstrap 4 breakpoint ', 'background: #222; color: #bada55');
					console.log(this.prefix+": md");
				} else if(window.getComputedStyle(this.sm).getPropertyValue("display") == "block") {
					console.log('%c Bootstrap 4 breakpoint ', 'background: #222; color: #bada55');
					console.log(this.prefix+": sm");
				} else if(window.getComputedStyle(this.xs).getPropertyValue("display") == "block") {
					console.log('%c Bootstrap 4 breakpoint ', 'background: #222; color: #bada55');
					console.log(this.prefix+": xs");
				}
			}

			log() {
				const func = (e) => this.detect();
				function throttled(delay, fn) {
						let lastCall = 0;
							return function wrapper(...args) {
								const now = (new Date).getTime();
								if (now - lastCall < delay) {
								return;
								}
								lastCall = now;
								return fn(...args);
							}
						}
				window.addEventListener("resize", throttled(this.delay, (e) => func(this.detect)));
				this.detect();
			}
	}

	document.addEventListener("DOMContentLoaded", function() {
		let breakpoint = new BS4breakpoints();
		breakpoint.log();
	});

	</script>
</body>




</html>