<h1>UNFINISHED call in lightbox by ID</h1>
					<?php if(get_field('video')){ ?>
						<div class="single-item">
							<a href="#itemno<?php the_ID(); ?>">
								<div class="hidden-layer">
									<?php if(get_field('youtubeid')){ ?>
										<div class="item-background video" style="background-image:url('https://img.youtube.com/vi/<?php the_field("youtubeid"); ?>/maxresdefault.jpg');"></div>
									<?php } ?>
									<?php if(get_field('vimeoid')){ ?>
										<?php the_field("vimeoid"); ?>
										<img src="<?php $imgid = 355227695; $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php")); echo $hash[0]['thumbnail_large']; ?>">
										<?php $imgidxxx = the_field('vimeoid'); ?>
										<img src="<?php $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/'$imgidxxx'.php")); echo $hash[0]['thumbnail_large']; ?>">
									<?php } ?>
								</div>
							</a>
							<a href="#_" class="lightbox videolight" id="itemno<?php the_ID(); ?>">
								<?php the_field("video"); ?>
							</a>
						</div>
					<?php } ?>




                    <h1>Display item custom post type cat with link</h1>
					<h3>Categery Name: 
						<!--<?php 
						$terms = get_the_terms( $post->ID , 'locations_taxonomy' ); 
						foreach ( $terms as $term ) : ?>
							<a href="<?php echo get_term_link($term->term_id); ?>">
								<?php echo $term->name; ?>
							</a>
						<?php endforeach;?>-->
					</h3> 



                    