<?php get_header(); ?>


<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php if (is_front_page()  == false &&  $post->post_name != 'accueil') : ?>
			<?php $image = (has_post_thumbnail())  ?  get_the_post_thumbnail_url() : false ?>
			<?php get_template_part('partials/page-header'); ?>
		<?php endif; ?>


		<!-- article -->
		<article id="post-<?php the_ID(); ?>">
			<?php if (!post_password_required($post)) : ?>

				<?php $sidebar = get_field('sidebar'); ?>

				<div class="container" id="main_section">
					<div class="row">

						<?php $mainclass = ($sidebar) ? 'col-sm-8 col-sm-push-4' :  'col-sm-12'; ?>

						<div class="<?php echo $mainclass; ?>">


							<div class="white_box">
								<?php the_content(); ?>

								<?php include('section-loop.php'); ?>
								<?php if (have_rows('galleries')) get_template_part('gallery_content'); ?>
								<?php if (have_rows('press')) get_template_part('press_content'); ?>
							<?php endif; ?>
							</div>
						</div>

						<?php if ($sidebar) : ?>
							<div class="col-sm-4 col-sm-pull-8 sticky">

								<br>
								<br>
								<br>
								<br>
								<br>
								<div class="black_box ">
									<?php echo $sidebar; ?>
								</div>

							</div>

						<?php endif; ?>



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