
		<!-- Header --> 
		<header class="site-header header-s1 is-sticky">
			<!-- Topbar -->
			<div class="topbar">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<ul class="social">
								<li><a href="#"><em class="fa fa-facebook"></em></a></li>
								<li><a href="#"><em class="fa fa-twitter"></em></a></li>
								<li><a href="#"><em class="fa fa-linkedin"></em></a></li>
								<li><a href="#"><em class="fa fa-google-plus"></em></a></li>
							</ul>
						</div>
						<div class="col-sm-6 al-right">
							<ul class="top-nav">
								<li><a href="<?=base_url();?>faqs">Help</a></li>
								<li><a href="<?=base_url();?>support">Support</a></li>
								<li><a href="<?=base_url();?>login">Login</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- End Topbar -->
			<!-- Navbar -->
			<div class="navbar navbar-primary">
				<div class="container relative">
					<!-- Logo -->
					<a class="navbar-brand" href="<?=base_url();?>">
						<img class="logo logo-dark" alt="logo" src="<?=base_url().settings('logo');?>">
						<img class="logo logo-light" alt="logo" src="<?=base_url().settings('logo');?>">
					</a>
					<!-- #end Logo -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainnav" aria-expanded="false">
							<span class="sr-only">Menu</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<div class="quote-btn"><a class="btn" href="<?=base_url();?>investment"><span>get started</span></a></div>
					</div>
					<!-- MainNav -->
					<nav class="navbar-collapse collapse" id="mainnav">
						<ul class="nav navbar-nav">
							<li><a href="<?=base_url();?>">Home</a></li>
							<li><a href="<?=base_url();?>company">Company</a></li>
							
							<li><a href="<?=base_url();?>investment">investment Plan</a></li>
							<li><a href="<?=base_url();?>market">word Market</a></li>
							<li><a href="<?=base_url();?>faqs">faqs</a></li>
							<li><a href="<?=base_url();?>support">Support</a></li>
							<li><a href="<?=base_url();?>review">Reviews</a></li>
							<li class="quote-btn hidden-xs hidden-sm"><a class="btn" href="<?=base_url();?>investment">get started</a></li>
						</ul>
					</nav>
					<!-- #end MainNav -->
				</div>
			</div>
			<!-- End Navbar -->
		