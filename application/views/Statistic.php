<div class="app-main__inner">
	<div class="app-page-title">
		<div class="page-title-wrapper">
			<div class="page-title-heading">
				<div class="page-title-icon">
					<i class="far fa-chart-bar icon-gradient bg-ripe-malin">
					</i>
				</div>
				<div><n i18n="totalStatistics">Total Statistics</n>
					<div class="page-title-subheading">
						<n i18n="statisticalDescription">This page is cached for 12 hours.Statistics Time:</n>
						<n class="statisticsTime">0000-00-00 00:00:00</n>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="tabs-animation">
		<div class="row">
			<div class="col-lg-12 col-xl-12">
				<div class="main-card mb-3 card">
					<div class="grid-menu grid-menu-2col">
						<div class="no-gutters row">
							<div class="col-sm-6">
								<div class="widget-chart">
									<div class="icon-wrapper rounded-circle">
										<div class="icon-wrapper-bg bg-primary"></div>
										<i class="far fa-comment text-primary"></i>
									</div>
									<div class="widget-numbers totalContent">...</div>
									<div class="widget-subheading" i18n="totalContent">Total Content</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="widget-chart">
									<div class="icon-wrapper rounded-circle">
										<div class="icon-wrapper-bg bg-info"></div>
										<i class="far fa-comment-dots text-info"></i>
									</div>
									<div class="widget-numbers totalComment">...</div>
									<div class="widget-subheading" i18n="totalComment">Total Comment</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="widget-chart">
									<div class="icon-wrapper rounded-circle">
										<div class="icon-wrapper-bg bg-success"></div>
										<i class="fas fa-user-check text-success"></i>
									</div>
									<div class="widget-numbers activeUser">...</div>
									<div class="widget-subheading" i18n="activeUser">Active User</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="widget-chart">
									<div class="icon-wrapper rounded-circle">
										<div class="icon-wrapper-bg bg-success"></div>
										<i class="fas fa-users"></i>
									</div>
									<div class="widget-numbers totalUser">...</div>
									<div class="widget-subheading" i18n="totalUser">Total User</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="widget-chart">
									<div class="icon-wrapper rounded-circle">
										<div class="icon-wrapper-bg bg-danger"></div>
										<i class="far fa-heart text-danger"></i>
										</div>
									<div class="widget-numbers totalLike">...</div>
									<div class="widget-subheading" i18n="totalLike">Total Like</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="widget-chart">
									<div class="icon-wrapper rounded-circle">
										<div class="icon-wrapper-bg bg-danger"></div>
										<i class="fab fa-yelp"></i>
										</div>
									<div class="widget-numbers totalActivity">...</div>
									<div class="widget-subheading" i18n="totalActivity">Total Activity</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('footer');?>
        </div>
    </div>
<script>

getData()
	function getData(){
		$.get("/Statistic/Total/",function(data){
			item = $.parseJSON(data);
			$(".totalContent").html(item['totalContent']);
			$(".totalComment").html(item['totalComment']);
			$(".activeUser").html(item['activeUser']);
			$(".totalUser").html(item['totalUser']);
			$(".totalLike").html(item['totalLike']);
			$(".totalActivity").html(item['totalActivity']); 
			$(".statisticsTime").html(stampToTime(item['statisticsTime']));
		});
	}

</script>