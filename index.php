<?php
use Intervention\Image\ImageManagerStatic as Image;
use Symfony\Component\HttpFoundation\Request;

require_once("vendor/autoload.php");

$sizeList = include("sizes.php");

function render_ios_xml($path, $size) {
	return "<icon src=\"{$path}\" width=\"{$size['w']}\" height=\"{$size['h']}\"/>";
}

function render_android_xml($path, $size) {
	return "<icon density=\"{$size['density']}\" src=\"{$path}\"/>";
}

function render_xml($fileList) {
	$xml = "";

	foreach($fileList as $platform => $files) {
		$xml .= "<platform name=\"{$platform}\">\n";

		foreach($files as $file) {
			$xml .= "\t" . (($platform === 'ios') ?
				render_ios_xml($file['xml_path'], $file) :
				render_android_xml($file['xml_path'], $file)
			) . "\n";
		}

		$xml .= "</platform>\n\n";
	}

	return $xml;
}

$app = new Silex\Application();
//$app['debug'] = true;

$app->get('/', function() use($app) {
	return include("views/upload.php");
});

$app->post('/generate', function(Request $request) use ($app, $sizeList) {

	$masterID = uniqid();
	$masterFolder = "storage/{$masterID}";
	$zipPath = "{$masterFolder}/iconmaker_{$masterID}.zip";

	mkdir($masterFolder);

	$file = $request->files->get('file'); /* @var $file \Symfony\Component\HttpFoundation\File\UploadedFile */
	
	$file->move($masterFolder, 'master.png');

	$img = Image::make("{$masterFolder}/master.png");
	$img->backup();
	$generated = [];

	$zip = new ZipArchive;
	$zip->open($zipPath, ZipArchive::CREATE);


	foreach($sizeList as $platform => $sizes) {

		$generated[$platform] = [];

		foreach($sizes as $filename => $size) {

			$path = "{$masterFolder}/{$filename}.png";
			$xmlPath = "resources/{$platform}/icon/{$filename}";

			$img->reset();
			$img->resize($size['w'], $size['h']);
			$img->save($path);

			$xml = ($platform === 'ios') ?
				render_ios_xml($path, $size) :
				render_android_xml($path, $size);

			array_push($generated[$platform], [
				'master' => $masterID,
				'w' => $size['w'],
				'h' => $size['h'],
				'density' => $size['density'] ?? null,
				'name' => $filename,
				'generated_path' => $path,
				'xml_path' => $xmlPath,
				'xml' => $xml
			]);

			$zip->addFile($path, $xmlPath);
		}
	}

	$zip->close();
	$xml = render_xml($generated);

	unlink("{$masterFolder}/master.png");

	return include("views/upload.php");

});

$app->run();