@extends('voyager::master')
<title>Dashboard</title>
@section('css')
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
            z-index: 200000;
        }

        .panel.is-fullscreen .mce-tinymce {
            height:100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 99%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }
    </style>
@stop

@section('content')
	<div class="page-content container-fluid">
		<div class="col-md-7">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h2 class="panel-title">
						<i class="voyager-bar-chart"></i>
						Report
						<span class="panel-desc"> Procurement Accomplishment </span>
					</h2>
					<div class="panel-actions">
						<a class="panel-action voyager-angle-down" data-toggle="panel-collapse" aria-hidden="true"></a>
					</div>
				</div>
				<div class="panel-body">
					<canvas id="procurement_accomplishment_chart" width="100%" height="70px"></canvas>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
	<script>
		$(document).ready(function(){
			var ctx = document.getElementById("procurement_accomplishment_chart");
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: ["Processed", "Awarded", "Posted to KC-NCDDP Website"],
					datasets: [{
						label: 'Goods',
						data: [104, 100, 79],
						backgroundColor: [
							'rgba(0, 255, 255, 0.2)',
							'rgba(0, 255, 255, 0.2)',
							'rgba(0, 255, 255, 0.2)'
						],
						borderColor: [
							'rgba(0, 255, 255, 1)',
							'rgba(0, 255, 255, 1)',
							'rgba(0, 255, 255, 1)'
						],
						borderWidth: 1
					},{
						label: 'Non-consulting Services',
						data: [333, 273, 180],
						backgroundColor: [
							'rgba(0, 255, 22, 0.2)',
							'rgba(0, 255, 22, 0.2)',
							'rgba(0, 255, 22, 0.2)'
						],
						borderColor: [
							'rgba(0, 255, 22, 1)',
							'rgba(0, 255, 22, 1)',
							'rgba(0, 255, 22, 1)'
						],
						borderWidth: 1
					},{
						label: 'Consulting Services (TAF)',
						data: [24, 24, 7],
						backgroundColor: [
							'rgba(255, 0, 0, 0.2)',
							'rgba(255, 0, 0, 0.2)',
							'rgba(255, 0, 0, 0.2)'
						],
						borderColor: [
							'rgba(255, 0, 0, 1)',
							'rgba(255, 0, 0, 1)',
							'rgba(255, 0, 0, 1)'
						],
						borderWidth: 1
					}
					]
				},
				options: {
					scales: {
						xAxes: [{
							stacked: true
						}],
						yAxes: [{
							stacked: true,
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		});
	</script>
@endsection