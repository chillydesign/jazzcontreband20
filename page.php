<?php get_header(); ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php if (is_front_page()  == false &&  $post->post_name != 'accueil') : ?>
			<?php $image = (has_post_thumbnail())  ?  get_the_post_thumbnail_url() : false ?>
			<?php get_template_part('partials/page-header'); ?>
		<?php endif; ?>


		<!-- article -->
		<article id="post-<?php the_ID(); ?>">
			<?php if (!post_password_required($post)) : ?>

				<div class="container" id="main_section">
					<div class="row">
						<div class="col-sm-4 sticky">

							<br>
							<br>
							<br>
							<br>
							<br>
							<div class="black_box ">
								<h3>Contact</h3>
								<hr>
								<p>+33 33 123 3234789</p>
								<hr>
								<p><a href="www.esplanadedulac.fr" target="_blank">www.esplanadedulac.fr</a></p>
								<hr>
								<p>181, Avenue de la Plage <br>
								01220 Divonne-les-Bains <br>
								France</p>
								<hr>
							</div>

						</div>
						<div class="col-sm-8">
							<div class="white_box">
								<?php the_content(); ?>

								<?php include('section-loop.php'); ?>
								<?php if (have_rows('galleries')) get_template_part('gallery_content'); ?>
								<?php if (have_rows('press')) get_template_part('press_content'); ?>
							<?php endif; ?>
							</div>
						</div>
					</div>
				</div>






		</article>
		<!-- /article -->

	<?php endwhile; ?>

<?php else : ?>

	<!-- article -->
	<article class="container">

		<h2><?php _e('Sorry, nothing to display.', 'webfactor'); ?></h2>

	</article>
	<!-- /article -->

<?php endif; ?>




<?php get_footer(); ?>
