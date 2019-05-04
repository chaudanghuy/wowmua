<div class="container">
		<div class="row">
		    <div class="col-md-12">
			    <div class="breadcrumbs">
				    <ul class="breadcrumb">
                        <li><a href="/">Trang chủ</a> <span class="divider"></span></li>
                        <li class="active">Liên hệ</li>
                    </ul>
				</div>
			</div>
		</div>
		
		<div class="row">
		    <div class="col-md-12">
				<h2>Liên hệ với chúng tôi</h2>
			</div>
		</div>
        <!-- <div class="row">
		    <div class="col-md-12">
			    <div id="map">
                    <p></p>
                </div>
			</div>
		</div> -->
		
		<div class="row">
				<div class="col-md-6">
					<div class="contact_form">
						<form action="https://formspree.io/wowmua.info@gmail.com" method="POST">
							<fieldset class="form-group">
								<label>Tên<span class="required">*</span></label>
								<input type="text" placeholder="Tên của bạn" class="form-control">
								<label>Email<span class="required">*</span></label>
								<input type="text" placeholder="Email" class="form-control">
							</fieldset>
						</form>
						<div class="form-group">
							<label>Nội dung<span class="required">*</span></label>
							<textarea rows="3" class="form-control"></textarea>
						</div>
						<p class="form-group">
							<button class="btn btn-primary" type="button">GỬI</button>
						</p>
					</div>
				</div>				
				<div class="col-md-6">
					<div class="location">
						<address>
						  <strong>WowMua</strong><br>
						  <br>
						  <abbr title="Phone">P:</abbr> 0934.007.012
						</address>

						<address>
						  <strong>Liên hệ</strong><br>
						  <a href="mailto:#">wowmua.info@gmail.com</a>
						</address>
					</div>
				</div>	
			</div>			
	

	</div>		
	
<?= $this->Html->script('https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=true') ?>
<?= $this->Html->script('jquery.ui.map.full.min.js') ?>

<script>
jQuery(window).load(function() 
{
	$('#map').gmap().bind('init', function(ev, map) 
	{
		$('#map').gmap('addMarker', {'position': '-37.8102539,144.9602197', 'bounds': true}).click(function() 
		{
			$('#map').gmap('openInfoWindow', 
			{
				'content': 
				'<p>30 South Park Avenue</p><p>San Francisco, CA 94108</p>'
			}, this);
		});
		$('#map').gmap('option', 'zoom', 15);
	});
});
</script>