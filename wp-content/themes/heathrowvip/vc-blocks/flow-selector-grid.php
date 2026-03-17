<?php
add_action('vc_before_init', 'your_name_flowselectorgrid');
function your_name_flowselectorgrid()
{
	vc_map(

		array(
			"name" => __("Flow Selector Grid", "my-text-domain"),
			"base" => "flowselectorgrid",
			"class" => "",
			"category" => __("Content", "my-text-domain"),
			"params" => array(
			)
		)
	);
}

add_shortcode('flowselectorgrid', 'flowselectorgrid_func');
function flowselectorgrid_func($atts, $content = null, $servicetitle)
{ 
    ob_start();
    ?>













<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>



<div class="flowchart-grid">
	
		<div class="col-12">
			<h1>I want to use it on a:</h1>
		</div>
	
    <div class="level level--1" data-level="1">
	
        <div class="" data-conditional-name="">

            <div class="form-check">
				<div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
					<div class='zoom-card'>
						<div class='zoom-block-background-outer' >
							<div class='zoom-block-background' style='background: url("/wp-content/uploads/2019/01/Alfa.png");'>
								<div class='zoom-block-text-outer' >	
									<div class='zoom-block-text' >
										<h2 class='zoom-title'>Car</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
                    
                    <input class="conditional-input" type="radio" name="choose_a_team" value="red"
                        data-conditional-child="choose_a_speciality_cars" />
                    <label for="choose_a_team"></label>
                </div>
				<div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
					<div class='zoom-card'>
						<div class='zoom-block-background-outer' >
							<div class='zoom-block-background' style='background: url("/wp-content/uploads/2019/01/bw-Bike.png");'>
								<div class='zoom-block-text-outer' >
									<div class='zoom-block-text' >
										<h2 class='zoom-title'>Bike</h2>
										
										<input class="conditional-input" type="radio" name="choose_a_team" value="blue"
											data-conditional-child="choose_a_speciality_bikes" />
										<label for="choose_a_team"></label>
									</div>
								</div>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>

    <div class="level level--2" data-level="2">
        <div class="conditional-wrapper" data-conditional-name="choose_a_speciality_cars">
			<div class="col-12">
				<h1>I want to use it for:</h1>
			</div>
            <div class="form-check">
                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
                    <input class="conditional-input" type="radio" name="choose_speciality" value="tomato"
						data-conditional-child="speciality_tomato" />
						<a href="/product-category/interior-products/">
							<div class='zoom-card'>
								<div class='zoom-block-background-outer' >
									<div class='zoom-block-background' style='background: url("/wp-content/uploads/2020/10/20200720_091414.jpg");'>
										<div class='zoom-block-text-outer' >
											<div class='zoom-block-text' >
												<h2 class='zoom-title'>Products for car windows</h2>
												
												<!--<label for="choose_speciality">tomatoes</label>-->
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</a>
						
						

				</div>
				
                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
					<input class="conditional-input" type="radio" name="choose_speciality" value="ketchup" data-conditional-child="speciality_ketchup" />
					<a href="/product-category/interior-products/">
						<div class='zoom-card'>
							<div class='zoom-block-background-outer' >
								<div class='zoom-block-background' style='background: url("/wp-content/uploads/2020/10/20200723_084858.jpg");'>
									<div class='zoom-block-text-outer' >
										<div class='zoom-block-text' >
											<h2 class='zoom-title'>Products for car doors</h2>
											
											<!--<label for="choose_speciality">ketchup</label>-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>

				<div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
					<input class="conditional-input" type="radio" name="choose_speciality" value="ketchup" data-conditional-child="speciality_ketchup" />
					<a href="/product-category/interior-products/">
						<div class='zoom-card'>
							<div class='zoom-block-background-outer' >
								<div class='zoom-block-background' style='background: url("/wp-content/uploads/2020/10/20200714_155743.jpg");'>
									<div class='zoom-block-text-outer' >
										<div class='zoom-block-text' >
											<h2 class='zoom-title'>Products for car doors</h2>
											
											<!--<label for="choose_speciality">ketchup</label>-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				
            </div>
        </div>

        <div class="conditional-wrapper" data-conditional-name="choose_a_speciality_bikes">
			<div class="col-12">
				<h1>I want to use it for:</h1>
			</div>
            <div class="form-check">
				



                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
                    <input class="conditional-input" type="radio" name="choose_speciality" value="blue_mms" data-conditional-child="speciality_bikes_mms" />
					<a href="/product-category/interior-products/">
						<div class='zoom-card'>
							<div class='zoom-block-background-outer' >
								<div class='zoom-block-background' style='background: url("/wp-content/uploads/2020/10/20200628_134949.jpg");'>
									<div class='zoom-block-text-outer' >
										<div class='zoom-block-text' >
											<h2 class='zoom-title'>Bike doors</h2>
											
											<!--<label for="choose_speciality">blue m&ms</label>-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				


                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
					<input class="conditional-input" type="radio" name="choose_speciality" value="blueberries"  data-conditional-child="speciality_bikesberries"/>
					<a href="/product-category/interior-products/">
						<div class='zoom-card'>
							<div class='zoom-block-background-outer' >
								<div class='zoom-block-background' style='background: url("/wp-content/uploads/2020/10/20200624_172103.jpg");'>
									<div class='zoom-block-text-outer' >
										<div class='zoom-block-text' >
											<h2 class='zoom-title'>Bike windows</h2>
											<!--<label for="choose_speciality">blueberries</label>-->
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</a>
				</div>

				<div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
					<input class="conditional-input" type="radio" name="choose_speciality" value="blueberries"  data-conditional-child="speciality_bikesberries"/>
					<a href="/product-category/interior-products/">
						<div class='zoom-card'>
							<div class='zoom-block-background-outer' >
								<div class='zoom-block-background' style='background: url("/wp-content/uploads/2020/10/20200602_201450.jpg");'>
									<div class='zoom-block-text-outer' >
										<div class='zoom-block-text' >
											<h2 class='zoom-title'>Bike wheels</h2>
											<!--<label for="choose_speciality">blueberries</label>-->
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</a>
				</div>

				<div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
					<input class="conditional-input" type="radio" name="choose_speciality" value="blueberries"  data-conditional-child="speciality_bikesberries"/>
					<a href="/product-category/interior-products/">
						<div class='zoom-card'>
							<div class='zoom-block-background-outer' >
								<div class='zoom-block-background' style='background: url("/wp-content/uploads/2020/10/20200624_171839.jpg");'>
									<div class='zoom-block-text-outer' >
										<div class='zoom-block-text' >
											<h2 class='zoom-title'>Bike paintwork</h2>
											<!--<label for="choose_speciality">blueberries</label>-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</a>
				</div>
				



            </div>
        </div>
    </div>

    <div class="level level--3" data-level="3">

        <div class="conditional-wrapper" data-conditional-name="speciality_tomato">
            <h3>Tomato things</h3>
            <a href="https://tomato.com">Visit tomato.com</a>
        </div>
        <div class="conditional-wrapper" data-conditional-name="speciality_ketchup">
            <h3>Ketchup things</h3>
            <a href="https://ketchup.com">Visit ketchup.com</a>
        </div>
        <div class="conditional-wrapper" data-conditional-name="speciality_bikes_mms">
            <h3>Blue M&M things</h3>
            <a href="https://mms.com">Visit mms.com</a>
        </div>
        <div class="conditional-wrapper" data-conditional-name="speciality_bikesberries">
            <h3>Blueberry things</h3>
            <a href="https://ketchup.com">Visit blueberry.com</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".conditional-input").each(function () {
            $(this).change(function () {
                if ($(this).is(":checked")) {
                    var conditional = $(this).attr("data-conditional-child");
                    var level = parseInt($(this).parents('.level').attr('data-level'));
                    var newlevel = level+1;
                    var maxlevel = 5;
                    for (i = newlevel; i < maxlevel; i++) {
                        $('.level[data-level="'+i+'"] [data-conditional-name]').each(function(){
                            $(this).removeClass('active');
                        });
                    }
                    $('.level[data-level="'+newlevel+'"] [data-conditional-name="'+conditional+'"]').addClass('active');
                }
            });
        });

        $('.input-wrapper').click(function(){
            
            $(this).siblings().each(function(){
                $(this).removeClass('selected');
            });

            $(this).addClass('selected');

        });
    });
</script>

<style>
/*
* Prefixed by https://autoprefixer.github.io
* PostCSS: v7.0.29,
* Autoprefixer: v9.7.6
* Browsers: last 4 version
*/
.conditional-wrapper {
    opacity: 0.2;
    pointer-events: none;
}
.conditional-wrapper.active {
    opacity: 1;
    pointer-events: all;
}
.level {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: start;
        -ms-flex-pack: start;
            justify-content: flex-start;
}
.form-check {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
}
.conditional-wrapper.active .input-wrapper.selected {
    border: 7px blue #D3D3D3;
}
.level--1 .input-wrapper.selected {
    border: 7px blue #D3D3D3;
}
.input-wrapper {
    padding: 0 15px;
    float: left;
    -ms-flex-preferred-size: 100%;
        flex-basis: 100%;
}
[data-conditional-name] {
    -ms-flex-preferred-size: 100%;
        flex-basis: 100%;
}
.level input {
    display: none;
}

.input-wrapper.selected {
}

.conditional-wrapper {
    display: none;
}

.conditional-wrapper.active {
    display: block;
}

.flowchart-grid .zoom-card {
    cursor: pointer;
}

.flowchart-grid .zoom-block-text {
    position: absolute;
    bottom: 0;
    background: white;
}

.flowchart-grid label {
    display: none!important;
}


.flowchart-grid .zoom-block-background {
    padding-top: 40%;
}

.conditional-wrapper .zoom-block-background {
    padding-top: 60%;
} 

@media screen and (max-width: 767px) { 
	.flowchart-grid .zoom-block-background {
    padding-top: 80%;
}

}

.flowchart-grid .zoom-block-text {
	position: absolute;
    bottom: calc( 50% - 45px );
    background: rgba(0,0,0,0);
    margin: 0 auto;
    width: 100%;
    text-align: center;
	z-index: 10;
	position: relative;
  top: 50%;
  transform: perspective(1px) translateY(-50%);
}

h2.zoom-title {
    color: white;
    font-size: 35px;
    font-weight: 600;
    text-transform: uppercase;
	letter-spacing: 1px;
    text-shadow: 1px 1px 5px black;
}

.zoom-block-background-outer {
    position: relative!important;
    overflow: hidden;
}

.zoom-block-background-outer:after {
    content: " ";
    background: red;
    background: rgba(0, 0, 0, 0.2);
    background: rgba(255, 255, 255, 0.2);
	background: linear-gradient(to right, rgba(0,0,0,1), rgba(0,0,0,0), rgba(0,0,0,0));
	background: rgba(0, 0, 0, 0.2);
    width: 100%;
    height: 100%;
    display: block!important;
    position: absolute;
    z-index: 3;
    left: 0;
    top: 0;
}

.zoom-block-background-outer * {
    z-index: 5;
    position: relative;
}

.zoom-block-text-outer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}



@media screen and (max-width: 767px) {
.form-check {
	display: grid;
	grid-gap: 15px;
}
}



</style>


























<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>

<h2>Information for teams in the example cooking challange.</h2>

<div class="flowchart-grid">
    <div class="level level--1" data-level="1">

        <div class="" data-conditional-name="">

            <div class="form-check">
                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
                    <h3>Info</h3>
                    <p>This is additional information</p>
                    <input class="conditional-input" type="radio" name="choose_a_team" value="red"
                        data-conditional-child="choose_a_speciality_red" />
                    <label for="choose_a_team">red</label><br />
                </div>
                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
                    <h3>Info</h3>
                    <p>This is additional information</p>
                    <input class="conditional-input" type="radio" name="choose_a_team" value="blue"
                        data-conditional-child="choose_a_speciality_blue" />
                    <label for="choose_a_team">blue</label><br />
                </div>
            </div>
        </div>
    </div>

    <div class="level level--2" data-level="2">
        <div class="conditional-wrapper" data-conditional-name="choose_a_speciality_red">
            <div class="form-check">
                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
                    <input class="conditional-input" type="radio" name="choose_speciality" value="tomato"
                        data-conditional-child="speciality_tomato" />
                    <label for="choose_speciality">tomatoes</label><br />
                </div>
                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
                    <input class="conditional-input" type="radio" name="choose_speciality" value="ketchup" data-conditional-child="speciality_ketchup" />
                    <label for="choose_speciality">ketchup</label><br />
                </div>
            </div>
        </div>

        <div class="conditional-wrapper" data-conditional-name="choose_a_speciality_blue">
            <div class="form-check">
                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
                    <h3>More info</h3>
                    <input class="conditional-input" type="radio" name="choose_speciality" value="blue_mms"
                        data-conditional-child="speciality_blue_mms" />
                    <label for="choose_speciality">blue m&ms</label><br />
                </div>
                <div class="input-wrapper" onclick="this.querySelector('input[type=radio]').click()">
                    <input class="conditional-input" type="radio" name="choose_speciality"
                        value="blueberries"  data-conditional-child="speciality_blueberries"/>
                    <label for="choose_speciality">blueberries</label><br />
                </div>
            </div>
        </div>
    </div>

    <div class="level level--3" data-level="3">

        <div class="conditional-wrapper" data-conditional-name="speciality_tomato">
            <h3>Tomato things</h3>
            <a href="https://tomato.com">Visit tomato.com</a>
        </div>
        <div class="conditional-wrapper" data-conditional-name="speciality_ketchup">
            <h3>Ketchup things</h3>
            <a href="https://ketchup.com">Visit ketchup.com</a>
        </div>
        <div class="conditional-wrapper" data-conditional-name="speciality_blue_mms">
            <h3>Blue M&M things</h3>
            <a href="https://mms.com">Visit mms.com</a>
        </div>
        <div class="conditional-wrapper" data-conditional-name="speciality_blueberries">
            <h3>Blueberry things</h3>
            <a href="https://ketchup.com">Visit blueberry.com</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".conditional-input").each(function () {
            $(this).change(function () {
                if ($(this).is(":checked")) {
                    var conditional = $(this).attr("data-conditional-child");
                    var level = parseInt($(this).parents('.level').attr('data-level'));
                    var newlevel = level+1;
                    var maxlevel = 5;
                    for (i = newlevel; i < maxlevel; i++) {
                        $('.level[data-level="'+i+'"] [data-conditional-name]').each(function(){
                            $(this).removeClass('active');
                        });
                    }
                    $('.level[data-level="'+newlevel+'"] [data-conditional-name="'+conditional+'"]').addClass('active');
                }
            });
        });

        $('.input-wrapper').click(function(){
            
            $(this).siblings().each(function(){
                $(this).removeClass('selected');
            });

            $(this).addClass('selected');

        });
    });
</script>











    <?php 
    
    return ob_get_clean();
}