<?php
require("C:\wamp64\www\wp-includes\mysql\credentials.php");

$sql = "SELECT nomeTime, escudo from time";
$result = $conn->prepare($sql);
$result->execute();

echo ' <section class="hestia-about section-image" id="about" data-sorder="hestia_about" style="color:black;">
						<div class="container" style = "background:mintcream;">
				<div class="row hestia-about-content">
							<div class="elementor elementor-35">
			<div class="elementor-inner">
				<div class="elementor-section-wrap">
				<section data-id="6f3313e8" class="elementor-element elementor-element-6f3313e8 elementor-section-stretched elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section" data-settings="{"background_background":"classic"}" data-element_type="section" style="width: 793px; left: -31.5px;">
						<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-row">
				<div data-id="7e1d3c40" class="elementor-element elementor-element-7e1d3c40 elementor-column elementor-col-100 elementor-top-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="6569554e" class="elementor-element elementor-element-6569554e elementor-widget elementor-widget-heading" data-element_type="heading.default">
				<div class="elementor-widget-container">
			<h2 class="elementor-heading-title elementor-size-large" style="color:black;">Equipes</h2>		</div>
				</div>';
while ( $row = $result->fetch()) {

$escudo = $row["escudo"];
$nomeTime = $row['nomeTime'];
utf8_encode($nomeTime);
$caminho = "http://futifmg.serveblog.net:8080/times?tmpString=";
$caminho .= $nomeTime;

			echo' <section data-id="c8da2e7" class="elementor-element elementor-element-c8da2e7 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-inner-section" data-element_type="section">
						<div class="elementor-container elementor-column-gap-wider">
				<div class="elementor-row">



				<div data-id="5a5dec9b" class="elementor-element elementor-element-5a5dec9b elementor-sm-50 elementor-column elementor-col-25 elementor-inner-column" data-element_type="column">
			<div class="elementor-column-wrap elementor-element-populated">
					<div class="elementor-widget-wrap">
				<div data-id="ddea3a3" class="elementor-element elementor-element-ddea3a3 elementor-widget elementor-widget-image" data-element_type="image.default">
				<div class="elementor-widget-container">
					<div class="elementor-image">
					<figure class="wp-caption">';
					echo"	<a href='$caminho'>";
			echo "<img width='300' height='300' src='$escudo' class='attachment-medium size-medium' />";
			echo	'			</a>
						<figcaption class="widget-image-caption wp-caption-text">'.$nomeTime.'</figcaption>
					</figure>
				</div>
				</div>
				</div>
						</div>
			</div>
		</div>';


}


					echo	'</div>
			</div>
		</section>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>
						</div>
			</div>
		</div>
						</div>
			</div>
		</section>';
?>