<?php /* Template Name: Espace Membres */ get_header(); ?>


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
						<?php if(get_field('sidebar')):?>
						<div class="col-sm-4 sticky">

							<br>
							<br>
							<br>
							<br>
							<br>
							<div class="black_box ">
							<?php echo get_field('sidebar'); ?>
							</div>

						</div>
						<div class="col-sm-8">
						<?php else: ?>
							<div class="col-sm-12">
						<?php endif; ?>
							<div class="white_box">
								<?php the_content(); ?>

								<?php include('section-loop.php'); ?>
							<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				</div>

<?php include('sections/reperages.php'); ?>




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
