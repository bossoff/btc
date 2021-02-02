<!-- JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		
		<script src="<?=base_url();?>web/front/js/jquery.bundle.js"></script>
		<script src="<?=base_url();?>web/front/js/script.js"></script>
		<script>
		  (function(b,i,t,C,O,I,N) {
			window.addEventListener('load',function() {
			  if(b.getElementById(C))return;
			  I=b.createElement(i),N=b.getElementsByTagName(i)[0];
			  I.src=t;I.id=C;N.parentNode.insertBefore(I, N);
			},false)
		  })(document,'script','https://widgets.bitcoin.com/widget.js','btcwdgt');
		</script>