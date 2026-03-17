


<div class="testimonial-single">
    <div class="row">
        <div class="col-3 testimonial-left">
            <div class="testimonial-image-background" style="background-image: url('<?php the_field("testimonial_image"); ?>')">
                <div class="testimonial-image-inner">
                </div>
            </div>
        </div>
    <div class="col-9 testimonial-right">
            <h2 class="testimonial-title"><?php the_field("title"); ?></h2>
            
            <div class="testimonial-content">
            <span class="speach-mark middle"><?php the_field("testimonial"); ?></span>
            </div>

            <div class="testimonial-attribution">
                <p  class="attribution">
                    <span class="attribution-name">
                        <?php the_field("name"); ?>,
                    </span>
                    <span class="attribution-job-title">
                        <?php the_field("job_title"); ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

	

