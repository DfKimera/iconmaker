<!doctype html>
<html>
	<head>

		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

		<title>LQDI Iconmaker</title>
	</head>
	<body>

		<div class="container">
			<h1>LQDI Iconmaker <iframe src="https://ghbtns.com/github-btn.html?user=dfkimera&repo=iconmaker&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px"></iframe></h1>
			<p>Generates icons and XML config for iOS and Android apps, based on Cordova / Ionic standards. </p>
			<hr />

			<div class="row">
				<form name="uploadMaster" class="col-md-6" method="POST" enctype="multipart/form-data" action="/generate">
					<div class="panel panel-default">
						<div class="panel-heading">Upload master icon (512x512)</div>
						<div class="panel-body">
								<div class="form-group">
									<label for="fld-file">Master icon (PNG):</label>
									<input class="form-control" id="fld-file" type="file" name="file" />
								</div>
						</div>
						<div class="panel-footer">
							<button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload and generate</button>
						</div>
					</div>
				</form>
			</div>


			<?php if(isset($generated)) { ?>
				<h2>Generated</h2>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading"><i class="fa fa-file-zip-o"></i> ZIP file</div>
							<div class="panel-body">
								<a href="<?= $zipPath ?>" target="_blank" class="btn btn-success"><i class="fa fa-download"></i> Download ZIP file</a>

								<hr />

								<div class="well clearfix" style="height: 500px; overflow-y: scroll;">

									<?php foreach($generated as $platform => $files) { ?>
										<?php foreach($files as $file) { ?>
											<div class="text-center" style="float: left; width: 200px; height: 200px; margin: 5px;">
												<img style="max-width: 180px; max-height: 180px; " src="/<?= $file['generated_path'] ?>" /><br />
												<small><?= $file['name'] ?> (<?= $file['w'] ?>x<?= $file['h'] ?>)</small>
											</div>
										<?php } ?>
									<?php } ?>

								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading"><i class="fa fa-code"></i> XML strings</div>
							<div class="panel-body">
								<textarea class="form-control" style="font-family: monospace; white-space: pre; height: 600px;"><?= $xml ?></textarea>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>


			<hr />
			<div class="text-center">
				<small>Copyleft &copy; LQDI Digital - <a href="http://lqdi.net?utm_source=iconmaker&utm_campaign=opensource">www.lqdi.net</a> - 2017</small>
			</div>
		</div>

	</body>
</html>